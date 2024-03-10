<?php

namespace app\models;
if(file_exists(__DIR__."/../../config/app.php")){
    require_once __DIR__."/../../config/app.php";
}


class EmpleadoModel {
    private $empleados;
    private $estados;
    private $db;
    private $filas;

    public function __construct(){
        include './app/includes/database.php';
        $this->empleados = array();
        $this->estados = array();
        $this->db = $conn;
        $this->filas = FILAS_TABLA;
    }


    public function get_empleados($pagina){
        $pagina = ($pagina - 1) * $this->filas;
        $consulta = $this->db->query("SELECT * FROM empleados AS e INNER JOIN roles r ON e.rol_id = r.id_rol LIMIT {$pagina}, {$this->filas};");
      
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

    public function insertar($dni_emp, $nombre_emp, $apellido_emp, $email_emp, $contrasenya_emp, $rol_id, $activo_emp, $estado_emp){
        $resultado = $this->db->query("INSERT INTO empleados (dni_emp, nombre_emp, apellido_emp, email_emp, contrasenya_emp, rol_id, activo_emp, estado_id) VALUES ('{$dni_emp}', '{$nombre_emp}', '{$apellido_emp}', '{$email_emp}', '{$contrasenya_emp}', {$rol_id}, '{$activo_emp}', '{$estado_emp}');");
        return $resultado;
    }

    public function modificar($id_emp, $dni_emp, $nombre_emp, $apellido_emp, $email_emp, $rol_id, $estado_emp,$activo_emp){
        $resultado = $this->db->query("UPDATE empleados SET dni_emp='{$dni_emp}', nombre_emp='{$nombre_emp}', apellido_emp='{$apellido_emp}', email_emp='{$email_emp}',  rol_id={$rol_id}, estado_id='{$estado_emp}', activo_emp = '{$activo_emp}' WHERE id_emp={$id_emp};");
        return $resultado;
    }

    public function eliminar($id_emp){
        $resultado = $this->db->query("UPDATE empleados SET activo_emp='N' WHERE id_emp={$id_emp};");
        return $resultado;
    }

    public function getEstados(){
        $consulta = $this->db->query("SELECT * FROM estados_emp;");
        while($fila = $consulta->fetch_assoc()){
            $this->estados[] = $fila;
        }
        return $this->estados;
    }

    public function getEmpleadoLogin($email, $pass){


        $consulta = $this->db->query("SELECT * FROM empleados WHERE email_emp = '{$email}' AND contrasenya_emp = '{$pass}';");
        
        if($consulta->num_rows > 0){
            $emp = mysqli_fetch_array($consulta);
            $_SESSION['id']=$emp["id_emp"];
			      $_SESSION['user_name']=$emp["nombre_emp"];
			      $_SESSION['user_surname']=$emp["apellido_emp"];
            $_SESSION['user_rol']=$emp["rol_id"];

            return true;
        }

        return false;
    }

    public function getTotalEmpleados(){
        
        $consulta = $this->db->query("SELECT COUNT(id_emp) as TOTAL FROM EMPLEADOS;");
        
        if($consulta->num_rows > 0){
            $emp = mysqli_fetch_array($consulta);
            return $emp["TOTAL"];
            return true;
        }

        return 0;
    }


}
?>