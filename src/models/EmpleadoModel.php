<?php
class EmpleadoModel {
    private $empleados;
    private $db;

    public function __construct(){
        include './src/includes/database.php';

        $this->empleados = array();
        $this->db = $conn;
    }

    public function get_empleados(){
        $consulta = $this->db->query("SELECT * FROM empleados;");
        while($fila = $consulta->fetch_assoc()){
            $this->empleados[] = $fila;
        }
        return $this->empleados;
    }

    public function get_empleado($id_emp){
        $consulta = $this->db->query("SELECT * FROM empleados WHERE id_emp = {$id_emp};");
        $resultado = $consulta->fetch_assoc();
        return $resultado;
    }

    public function insertar($dni_emp, $nombre_emp, $apellido_emp, $email_emp, $contrasenya_emp, $rol_id, $activo_emp){
        $resultado = $this->db->query("INSERT INTO empleados (dni_emp, nombre_emp, apellido_emp, email_emp, contrasenya_emp, rol_id, activo_emp) VALUES ('{$dni_emp}', '{$nombre_emp}', '{$apellido_emp}', '{$email_emp}', '{$contrasenya_emp}', {$rol_id}, '{$activo_emp}');");
        return $resultado;
    }

    public function modificar($id_emp, $dni_emp, $nombre_emp, $apellido_emp, $email_emp, $contrasenya_emp, $rol_id, $activo_emp){
        $resultado = $this->db->query("UPDATE empleados SET dni_emp='{$dni_emp}', nombre_emp='{$nombre_emp}', apellido_emp='{$apellido_emp}', email_emp='{$email_emp}', contrasenya_emp='{$contrasenya_emp}', rol_id={$rol_id}, activo_emp='{$activo_emp}' WHERE id_emp={$id_emp};");
        return $resultado;
    }

    public function eliminar($id_emp){
        $resultado = $this->db->query("DELETE FROM empleados WHERE id_emp={$id_emp};");
        return $resultado;
    }
}
?>