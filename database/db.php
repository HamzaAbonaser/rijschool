<?php
class Database {
    private $pdo;

    public function __construct($db = 'HotelTerDuin', $host = 'localhost', $user = 'root', $pass = '') {
        try {
            $dsn = "mysql:host=$host;port=3306;dbname=$db;charset=utf8mb4";
            $this->pdo = new PDO($dsn, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Fout bij verbinden: " . $e->getMessage());
        }
    }

    public function getPdo() {
        return $this->pdo;
    }
}
?>
