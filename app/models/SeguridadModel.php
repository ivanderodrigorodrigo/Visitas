<?php
namespace app\models;

class SeguridadModel {
    private $roles;
    private $db;

    public function __construct(){
        include './app/includes/database.php';
        $this->roles = array();
        $this->db = $conn;
    }

    public function get_Roles(){
        $consulta = $this->db->query("SELECT * FROM roles ;");
        
        while($fila = $consulta->fetch_assoc()){
            $this->roles[] = $fila;
        }

        return $this->roles;
    }

}
