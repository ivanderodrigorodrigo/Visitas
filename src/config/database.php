<?php
class Database {
    private $host = "tu_host";
    private $db_name = "nombre_de_tu_base_de_datos";
    private $username = "tu_usuario";
    private $password = "tu_contraseña";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

