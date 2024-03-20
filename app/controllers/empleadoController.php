<?php

namespace app\models;

class EmpleadoModel {
    private $db; // Instancia de la conexión a la base de datos

    public function __construct() {
        include './app/includes/database.php';
        $this->db = $conn;
    }

    // Obtener todos los empleados activos con roles y estados
    public function get_empleados() {
        $empleados = [];
        $sql = "SELECT * FROM empleados AS e INNER JOIN roles r ON e.rol_id = r.id_rol LEFT JOIN estados_emp est ON est.id_estado = e.estado_id WHERE e.activo_emp = 'S';";
        if ($resultado = $this->db->query($sql)) {
            while ($fila = $resultado->fetch_assoc()) {
                $empleados[] = $fila;
            }
            $resultado->close();
        }
        return $empleados;
    }

    // Obtener un empleado por ID
    public function get_empleado($id_emp) {
        $sql = "SELECT * FROM empleados WHERE id_emp = ?;";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param("i", $id_emp);
            $stmt->execute();
            $resultado = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $resultado;
        }
        return null;
    }

    // Insertar un nuevo empleado con validación
    public function insertar($dni_emp, $nombre_emp, $apellido_emp, $email_emp, $contrasenya_emp, $rol_id, $activo_emp, $estado_emp) {
        // Validaciones
        if (!filter_var($email_emp, FILTER_VALIDATE_EMAIL)) return "Formato de email inválido.";
        if (strlen($nombre_emp) > 50 || strlen($apellido_emp) > 50) return "Nombre o apellido demasiado largo.";
        if (empty($dni_emp) || empty($nombre_emp) || empty($apellido_emp) || empty($email_emp) || empty($contrasenya_emp) || empty($rol_id) || empty($activo_emp) || empty($estado_emp)) return "Todos los campos son obligatorios.";

        $sql = "INSERT INTO empleados (dni_emp, nombre_emp, apellido_emp, email_emp, contrasenya_emp, rol_id, activo_emp, estado_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
        if ($stmt = $this->db->prepare($sql)) {
            $contrasenya_hash = password_hash($contrasenya_emp, PASSWORD_DEFAULT);
            $stmt->bind_param("sssssiis", $dni_emp, $nombre_emp, $apellido_emp, $email_emp, $contrasenya_hash, $rol_id, $activo_emp, $estado_emp);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado ? "Empleado insertado con éxito." : "Error al insertar empleado.";
        }
        return "Error al preparar la consulta.";
    }

    // Modificar un empleado existente con validación
    public function modificar($id_emp, $dni_emp, $nombre_emp, $apellido_emp, $email_emp, $rol_id, $estado_emp, $activo_emp) {
        // Validaciones
        if (!filter_var($email_emp, FILTER_VALIDATE_EMAIL)) return "Formato de email inválido.";
        if (strlen($nombre_emp) > 50 || strlen($apellido_emp) > 50) return "Nombre o apellido demasiado largo.";
        if (empty($dni_emp) || empty($nombre_emp) || empty($apellido_emp) || empty($email_emp) || empty($rol_id) || empty($activo_emp) || empty($estado_emp)) return "Todos los campos son obligatorios.";

        $sql = "UPDATE empleados SET dni_emp=?, nombre_emp=?, apellido_emp=?, email_emp=?, rol_id=?, estado_id=?, activo_emp=? WHERE id_emp=?;";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param("ssssiisi", $dni_emp, $nombre_emp, $apellido_emp, $email_emp, $rol_id, $estado_emp, $activo_emp, $id_emp);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado ? "Empleado modificado con éxito." : "Error al modificar empleado.";
        }
        return "Error al preparar la consulta.";
    }

    // Marcar un empleado como inactivo
    public function eliminar($id_emp) {
        $sql = "UPDATE empleados SET activo_emp='N' WHERE id_emp=?;";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param("i", $id_emp);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado ? "Empleado eliminado con éxito." : "Error al eliminar empleado.";
        }
        return "Error al preparar la consulta.";
    }

    // Obtener todos los estados posibles de un empleado
    public function getEstados() {
        $estados = [];
        $sql = "SELECT * FROM estados_emp;";
        if ($resultado = $this->db->query($sql)) {
            while ($fila = $resultado->fetch_assoc()) {
                $estados[] = $fila;
            }
            $resultado->close();
        }
        return $estados;
    }
}
?>
