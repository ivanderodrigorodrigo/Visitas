<?php

namespace app\models;

class EmpleadoModel {
    private $empleados;
    private $estados;
    private $db;

    public function __construct() {
        include './app/includes/database.php';
        $this->empleados = array();
        $this->estados = array();
        $this->db = $conn;
    }

    public function get_empleados() {
        $consulta = $this->db->query("SELECT * FROM empleados AS e INNER JOIN roles r ON e.rol_id = r.id_rol LEFT JOIN estados_emp est ON est.id_estado = e.estado_id WHERE e.activo_emp = 'S';");
        while ($fila = $consulta->fetch_assoc()) {
            $this->empleados[] = $fila;
        }
        return $this->empleados;
    }

    public function get_empleado($id_emp) {
        $consulta = $this->db->query("SELECT * FROM empleados WHERE id_emp = {$id_emp};");
        $resultado = $consulta->fetch_assoc();
        return $resultado;
    }

    public function insertar($dni_emp, $nombre_emp, $apellido_emp, $email_emp, $contrasenya_emp, $rol_id, $activo_emp, $estado_emp) {
        // Validaciones básicas
        if (!filter_var($email_emp, FILTER_VALIDATE_EMAIL)) {
            return false; // Formato de email inválido
        }
        if (empty($dni_emp) || empty($nombre_emp) || empty($apellido_emp) || empty($email_emp) || empty($contrasenya_emp) || empty($rol_id) || empty($activo_emp) || empty($estado_emp)) {
            return false; // Campos obligatorios faltantes
        }
        // Insertar después de validar
        $sql = "INSERT INTO empleados (dni_emp, nombre_emp, apellido_emp, email_emp, contrasenya_emp, rol_id, activo_emp, estado_id) VALUES ('{$dni_emp}', '{$nombre_emp}', '{$apellido_emp}', '{$email_emp}', '{$contrasenya_emp}', {$rol_id}, '{$activo_emp}', '{$estado_emp}');";
        return $this->db->query($sql);
    }

    public function modificar($id_emp, $dni_emp, $nombre_emp, $apellido_emp, $email_emp, $rol_id, $estado_emp, $activo_emp) {
        // Validaciones básicas
        if (!filter_var($email_emp, FILTER_VALIDATE_EMAIL)) {
            return false; // Formato de email inválido
        }
        if (empty($dni_emp) || empty($nombre_emp) || empty($apellido_emp) || empty($email_emp) || empty($rol_id) || empty($estado_emp) || empty($activo_emp)) {
            return false; // Campos obligatorios faltantes
        }
        // Modificar después de validar
        $sql = "UPDATE empleados SET dni_emp='{$dni_emp}', nombre_emp='{$nombre_emp}', apellido_emp='{$apellido_emp}', email_emp='{$email_emp}', rol_id={$rol_id}, estado_id='{$estado_emp}', activo_emp='{$activo_emp}' WHERE id_emp={$id_emp};";
        return $this->db->query($sql);
    }

    public function eliminar($id_emp) {
        $sql = "UPDATE empleados SET activo_emp='N' WHERE id_emp={$id_emp};";
        return $this->db->query($sql);
    }

    public function getEstados() {
        $consulta = $this->db->query("SELECT * FROM estados_emp;");
        while ($fila = $consulta->fetch_assoc()) {
            $this->estados[] = $fila;
        }
        return $this->estados;
    }
}

?>
