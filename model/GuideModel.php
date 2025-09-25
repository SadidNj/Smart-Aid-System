<?php
require_once __DIR__ . '/../config/db1.php';


class GuideModel {
    private $conn;
    private $jsonFile;

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->jsonFile = __DIR__ . '/../data/guides.json';
    }

    // Get all guides from DB and JSON and merge
    public function getAllGuides() {
        $guides = [];

        // DB
        $res = $this->conn->query("SELECT id, title, short_description, steps, training, image_url FROM first_aid_guides ORDER BY created_at DESC");
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                // assume steps stored as JSON in DB
                $steps = json_decode($row['steps'], true);
                if (!is_array($steps)) $steps = [];
                $guides[] = [
                    'id' => (int)$row['id'],
                    'title' => $row['title'],
                    'short_description' => $row['short_description'],
                    'steps' => $steps,
                    'training' => $row['training'],
                    'image_url' => $row['image_url']
                ];
            }
        }

        // JSON file
        if (file_exists($this->jsonFile)) {
            $json = json_decode(file_get_contents($this->jsonFile), true);
            if (is_array($json)) {
                // ensure ids do not collide: if JSON id exists also in DB, skip or adjust
                $existingIds = array_column($guides, 'id');
                foreach ($json as $item) {
                    if (!in_array($item['id'], $existingIds)) {
                        $guides[] = $item;
                    }
                }
            }
        }

        return $guides;
    }

    public function getGuideById($id) {
        // try DB first
        $stmt = $this->conn->prepare("SELECT id, title, short_description, steps, training, image_url FROM first_aid_guides WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($row = $res->fetch_assoc()) {
                $steps = json_decode($row['steps'], true);
                if (!is_array($steps)) $steps = [];
                return [
                    'id' => (int)$row['id'],
                    'title' => $row['title'],
                    'short_description' => $row['short_description'],
                    'steps' => $steps,
                    'training' => $row['training'],
                    'image_url' => $row['image_url']
                ];
            }
        }

        // fallback JSON
        if (file_exists($this->jsonFile)) {
            $json = json_decode(file_get_contents($this->jsonFile), true);
            foreach ($json as $item) {
                if ((int)$item['id'] === (int)$id) return $item;
            }
        }

        return null;
    }

   public function searchGuides($query) {
    $query = trim($query);
    $results = [];

    if ($query === '') {
        return $this->getAllGuides();
    }

    $like = "%" . $this->conn->real_escape_string($query) . "%";

    // DB search
    $sql = "SELECT id, title, short_description, steps, training, image_url 
            FROM first_aid_guides 
            WHERE title LIKE ? OR short_description LIKE ? OR training LIKE ? 
            ORDER BY created_at DESC";
    $stmt = $this->conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('sss', $like, $like, $like);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $steps = json_decode($row['steps'], true) ?: [];
            $results[] = [
                'id' => (int)$row['id'],
                'title' => $row['title'],
                'short_description' => $row['short_description'],
                'steps' => $steps,
                'training' => $row['training'],
                'image_url' => $row['image_url']
            ];
        }
    }

    // JSON search
    if (file_exists($this->jsonFile)) {
        $json = json_decode(file_get_contents($this->jsonFile), true);
        foreach ($json as $item) {
            if (
                stripos($item['title'], $query) !== false ||
                stripos($item['short_description'] ?? '', $query) !== false ||
                stripos($item['training'] ?? '', $query) !== false ||
                stripos(implode(' ', $item['steps'] ?? []), $query) !== false
            ) {
                $results[] = $item;
            }
        }
    }

    return $results;
}


}
?>
