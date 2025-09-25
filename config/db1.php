<?php
class Database {
    private static $conn = null;

    public static function getConnection() {
        if (self::$conn === null) {
            $host = 'localhost';
            $user = 'root';
            $pass = '';
            $dbname = 'smartaid';
            self::$conn = new mysqli($host, $user, $pass, $dbname);
            if (self::$conn->connect_error) {
                die('DB Connection failed: ' . self::$conn->connect_error);
            }
            // set charset
            self::$conn->set_charset('utf8mb4');
        }
        return self::$conn;
    }
}
?>
