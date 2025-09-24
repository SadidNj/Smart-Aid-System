<?php
declare(strict_types=1);

/**
 * Central DB connection to your SmartAidSystem database.
 * Tables used: hospitals, reminders, requests
 */
function db(): mysqli {
    static $conn = null;
    if ($conn instanceof mysqli) return $conn;

    $host = 'localhost';
    $user = 'root';          // <-- change if needed
    $pass = '';              // <-- change if needed
    $dbname = 'SmartAidSystem';

    mysqli_report(MYSQLI_REPORT_OFF);
    $conn = @new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) {
        die('DB connection failed: ' . htmlspecialchars($conn->connect_error, ENT_QUOTES, 'UTF-8'));
    }
    $conn->set_charset('utf8mb4');
    return $conn;
}
