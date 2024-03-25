<?php

namespace app\models;
if(file_exists(__DIR__."/../../config/app.php")){
    require_once __DIR__."/../../config/app.php";
}


use Exception;

if(file_exists(__DIR__."/../../config/app.php")){
    require_once __DIR__."/../../config/app.php";
}


class EmpleadoModel {
    private $empleados;
    private $db;
    private $filas;

    public function __construct(){
        include './app/includes/database.php';
        $this->empleados = array();
        $this->db = $conn;
        $this->filas = FILAS_TABLA;
    }

    public function campoOrdenado ($sort){
        $campo = '';
        switch ($sort){
            CASE 1:
                $campo = 'nombre_emp';
                break;
            CASE 2:
                $campo = 'apellido_emp';
                break;
            CASE 3:
                $campo = 'dni_emp';
                break;
            CASE 4:
                $campo = 'nombre_rol';
                break;
            CASE 5:
                $campo = 'activo_emp';
                break;
            default:
                $campo = 'id_emp';
                break;  
        }

        return $campo;
    }


    public function get_empleados($pagina,$sort,$order){
        $pagina = ($pagina - 1) * $this->filas;
        $sort = $this->campoOrdenado($sort);
        $consulta = $this->db->query("SELECT * FROM empleados AS e INNER JOIN roles r ON e.rol_id = r.id_rol ORDER BY {$sort} {$order} LIMIT {$pagina}, {$this->filas};");

      
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

    public function insertar($dni_emp, $nombre_emp, $apellido_emp, $email_emp, $contrasenya_emp, $rol_id, $activo_emp) {
        try {
            $query = "INSERT INTO empleados (dni_emp, nombre_emp, apellido_emp, email_emp, contrasenya_emp, rol_id, activo_emp) VALUES ('{$dni_emp}', '{$nombre_emp}', '{$apellido_emp}', '{$email_emp}', '{$contrasenya_emp}', {$rol_id}, '{$activo_emp}')";
            if (!$this->db->query($query)) {
                throw new Exception("Error al ejecutar la consulta de inserción: " . $this->db->error);
            }
            return $this->db->insert_id;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . $this->db->error;
            return false; 
        }
    }

    public function modificar($id_emp, $dni_emp, $nombre_emp, $apellido_emp, $email_emp, $rol_id,$activo_emp){
        $resultado = $this->db->query("UPDATE empleados SET dni_emp='{$dni_emp}', nombre_emp='{$nombre_emp}', apellido_emp='{$apellido_emp}', email_emp='{$email_emp}',  rol_id={$rol_id}, activo_emp = '{$activo_emp}' WHERE id_emp={$id_emp};");
        return $resultado;
    }

    public function eliminar($id_emp){
        $resultado = $this->db->query("UPDATE empleados SET activo_emp='N' WHERE id_emp={$id_emp};");
        return $resultado;
    }

    public function getEmpledoByEmail($email){
        $consulta = $this->db->query("SELECT * FROM empleados WHERE email_emp = '{$email}' and activo_emp = 'S';");
        $resultado = $consulta->fetch_assoc();
        return $resultado;
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

    public function buscarEmpleados($nombre, $pagina) {
        $pagina = ($pagina - 1) * $this->filas;

        $consulta = $this->db->query("SELECT * FROM empleados AS e INNER JOIN roles r ON e.rol_id = r.id_rol WHERE nombre_emp LIKE '%{$nombre}%' or apellido_emp LIKE '%{$nombre}%' LIMIT {$pagina}, {$this->filas};");
        while($fila = $consulta->fetch_assoc()){
            $this->empleados[] = $fila;
        }
        return $this->empleados;
    }

    public function getTotalEmpleadosSearch($nombre){
        
        $consulta = $this->db->query("SELECT COUNT(id_emp) as TOTAL FROM EMPLEADOS WHERE nombre_emp LIKE '%{$nombre}%' or apellido_emp LIKE '%{$nombre}%';");
        
        if($consulta->num_rows > 0){
            $emp = mysqli_fetch_array($consulta);
            return $emp["TOTAL"];
            return true;
        }

        return 0;
    }

    public function updatePassword($id_emp, $password){
        $this->db->query("UPDATE empleados SET contrasenya_emp = '{$password}' WHERE id_emp={$id_emp};");
        if ($this->db->affected_rows == 1){
            return true;  
        }
        return false;
    }

    public function insertarRol($nombre_rol) {
        $consulta = "INSERT INTO roles (nombre_rol) VALUES (?);";
        if ($stmt = $this->db->prepare($consulta)) {
            $stmt->bind_param("s", $nombre_rol);
            if ($stmt->execute()) {
                $stmt->close();
                return $this->db->insert_id; // Retorna el ID del nuevo rol insertado.
            } else {
                $stmt->close();
                error_log("Error al insertar rol: " . $this->db->error);
                return false;
            }
        } else {
            error_log("Error al preparar consulta para insertar rol: " . $this->db->error);
            return false;
        }
    }

    public function eliminarPermisosPorRol($id_rol) {
        $consulta = "DELETE FROM roles_permisos WHERE id_rol = ?;";
        if ($stmt = $this->db->prepare($consulta)) {
            $stmt->bind_param("i", $id_rol);
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            } else {
                $stmt->close();
                error_log("Error al eliminar permisos por rol: " . $this->db->error);
                return false;
            }
        } else {
            error_log("Error al preparar consulta para eliminar permisos por rol: " . $this->db->error);
            return false;
        }
    }

    public function asignarPermisoARol($id_rol, $id_permiso) {
        $consulta = "INSERT INTO roles_permisos (id_rol, id_permiso) VALUES (?, ?);";
        if ($stmt = $this->db->prepare($consulta)) {
            $stmt->bind_param("ii", $id_rol, $id_permiso);
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            } else {
                $stmt->close();
                error_log("Error al asignar permiso a rol: " . $this->db->error);
                return false;
            }
        } else {
            error_log("Error al preparar consulta para asignar permiso: " . $this->db->error);
            return false;
        }
    }
    


}
?>