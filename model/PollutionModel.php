<?php
require_once __DIR__ . '/../config/db.php';

class PollutionModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conn;
    }

    // Subscribers (users who want notifications)
    public function insertSubscriber($name, $email, $location, $lat=null, $lon=null) {
        $stmt = $this->conn->prepare("INSERT INTO pollution_alerts (name, email, location, lat, lon) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssdd', $name, $email, $location, $lat, $lon);
        return $stmt->execute();
    }

    // Save air quality reading
    public function insertAirQuality($lat, $lon, $aqi, $raw_json) {
        $stmt = $this->conn->prepare("INSERT INTO air_quality (lat, lon, aqi, raw_json) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ddis', $lat, $lon, $aqi, $raw_json);
        return $stmt->execute();
    }

    public function getLatestAQForLocation($lat, $lon) {
        $stmt = $this->conn->prepare("SELECT * FROM air_quality WHERE lat=? AND lon=? ORDER BY created_at DESC LIMIT 1");
        $stmt->bind_param('dd', $lat, $lon);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_assoc();
    }

    public function getAllSubscribers() {
        $res = $this->conn->query("SELECT * FROM pollution_alerts ORDER BY id DESC");
        return $res->fetch_all(MYSQLI_ASSOC);
    }
}
?>