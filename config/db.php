<?php
class Database {
    private $host = "127.0.0.1";
    private $user = "root";
    private $pass = "";
    private $dbname = "smartaid";

    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($this->conn->connect_error) {
            die("❌ Connection failed: " . $this->conn->connect_error);
        }
    }
}
?>