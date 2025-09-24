<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/config/db.php';

class RequestModel {
    private mysqli $db;
    public function __construct(){ $this->db = db(); }

    public function insert(string $type, string $name, ?string $bg, string $details): bool {
        $sql = "INSERT INTO requests (type, name, blood_group, details, created_at)
                VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        if(!$stmt) return false;
        $stmt->bind_param('ssss', $type, $name, $bg, $details);
        $ok = $stmt->execute();
        if ($ok) {
            if(!isset($_SESSION['my_req_ids'])) $_SESSION['my_req_ids'] = [];
            $_SESSION['my_req_ids'][] = (int)$stmt->insert_id;
        }
        $stmt->close();
        return $ok;
    }

    /** Results for my posts (by IDs kept in session) */
    public function my(array $ids) {
        if (empty($ids)) return false;
        $ids = array_values(array_filter(array_map('intval', $ids)));
        if (empty($ids)) return false;
        $in = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));
        $sql = "SELECT id, type, name, blood_group, details, created_at
                FROM requests
                WHERE id IN ($in)
                ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        if(!$stmt) return false;
        $stmt->bind_param($types, ...$ids);
        $stmt->execute();
        return $stmt->get_result();
    }

    /** All other posts (excluding my IDs if present) */
    public function others(array $ids) {
        $sql = "SELECT id, type, name, blood_group, details, created_at
                FROM requests";
        if (!empty($ids)) {
            $ids = array_values(array_filter(array_map('intval', $ids)));
            if (!empty($ids)) {
                $in = implode(',', array_fill(0, count($ids), '?'));
                $sql .= " WHERE id NOT IN ($in)";
                $sql .= " ORDER BY created_at DESC";
                $stmt = $this->db->prepare($sql);
                if(!$stmt) return false;
                $types = str_repeat('i', count($ids));
                $stmt->bind_param($types, ...$ids);
                $stmt->execute();
                return $stmt->get_result();
            }
        }
        $sql .= " ORDER BY created_at DESC";
        return $this->db->query($sql);
    }
}
