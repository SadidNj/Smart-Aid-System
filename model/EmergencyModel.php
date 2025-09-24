<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/config/db.php';

class EmergencyModel {
    private mysqli $db;
    public function __construct(){ $this->db = db(); }

    /** Get hospitals by division ordered by nearest first */
    public function findByDivision(string $division): array {
        $rows = [];
        $sql = "SELECT name, address, distance_km 
                FROM hospitals 
                WHERE division = ?
                ORDER BY distance_km ASC, name ASC";
        $stmt = $this->db->prepare($sql);
        if(!$stmt) return $rows;
        $stmt->bind_param('s', $division);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($r = $res->fetch_assoc()) { $rows[] = $r; }
        $stmt->close();
        return $rows;
    }
}
