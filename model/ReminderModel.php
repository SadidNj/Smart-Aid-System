<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/config/db.php';

class ReminderModel {
    private mysqli $db;
    public function __construct(){ $this->db = db(); }

    public function insert(string $medicine, string $time, ?string $notes): bool {
        $sql = "INSERT INTO reminders (medicine, time, notes) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        if(!$stmt) return false;
        $stmt->bind_param('sss', $medicine, $time, $notes);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function all(): array {
        $rows = [];
        $sql = "SELECT id, medicine, time, notes 
                FROM reminders 
                ORDER BY id DESC";
        if ($res = $this->db->query($sql)) {
            while ($r = $res->fetch_assoc()) $rows[] = $r;
            $res->free();
        }
        return $rows;
    }

    public function deleteAll(): bool {
        return (bool)$this->db->query("DELETE FROM reminders");
    }
}
