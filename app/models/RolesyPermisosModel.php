<?php

namespace app\models;

require_once __DIR__ . "/../../config/app.php";

class RolesyPermisosModel {
    private $db;

    public function __construct() {
        include './app/includes/database.php';
        $this->db = $conn;
    }

    // Obtener todos los roles
    public function getRoles() {
        $roles = array();
        $consulta = "SELECT * FROM roles;";
        if ($resultado = $this->db->query($consulta)) {
            while ($fila = $resultado->fetch_assoc()) {
                $roles[] = $fila;
            }
            $resultado->free();
            return $roles;
        } else {
            // Manejo del error
            error_log("Error al obtener roles: " . $this->db->error);
            return false;
        }
    }

    // Obtener permisos de un rol específico
    public function getPermisosPorRol($id_rol) {
        $permisos = array();
        $consulta = "SELECT p.* FROM permisos p INNER JOIN roles_permisos rp ON p.id_permiso = rp.id_permiso WHERE rp.id_rol = ?";
        if ($stmt = $this->db->prepare($consulta)) {
            $stmt->bind_param("i", $id_rol);
            if ($stmt->execute()) {
                $resultado = $stmt->get_result();
                while ($fila = $resultado->fetch_assoc()) {
                    $permisos[] = $fila;
                }
                $stmt->close();
                return $permisos;
            } else {
                // Manejo del error
                $stmt->close();
                error_log("Error al obtener permisos: " . $this->db->error);
                return false;
            }
        } else {
            // Manejo del error
            error_log("Error al preparar consulta: " . $this->db->error);
            return false;
        }
    }

    // Insertar un nuevo rol
    public function insertarRol($nombre_rol) {
        $consulta = "INSERT INTO roles (nombre_rol) VALUES (?);";
        if ($stmt = $this->db->prepare($consulta)) {
            $stmt->bind_param("s", $nombre_rol);
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            } else {
                // Manejo del error
                $stmt->close();
                error_log("Error al insertar rol: " . $this->db->error);
                return false;
            }
        } else {
            // Manejo del error
            error_log("Error al preparar consulta para insertar rol: " . $this->db->error);
            return false;
        }
    }

    // Asignar un permiso a un rol
    public function asignarPermisoARol($id_rol, $id_permiso) {
        $consulta = "INSERT INTO roles_permisos (id_rol, id_permiso) VALUES (?, ?);";
        if ($stmt = $this->db->prepare($consulta)) {
            $stmt->bind_param("ii", $id_rol, $id_permiso);
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            } else {
                // Manejo del error
                $stmt->close();
                error_log("Error al asignar permiso a rol: " . $this->db->error);
                return false;
            }
        } else {
            // Manejo del error
            error_log("Error al preparar consulta para asignar permiso: " . $this->db->error);
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
    
    // Método para obtener todos los permisos
public function mostrarPermisos() {
    $permisos = array();
    $consulta = "SELECT * FROM permisos;";
    if ($resultado = $this->db->query($consulta)) {
        while ($fila = $resultado->fetch_assoc()) {
            $permisos[] = $fila;
        }
        $resultado->free();
        return $permisos;
    } else {
        // Manejo del error
        error_log("Error al obtener permisos: " . $this->db->error);
        return false;
    }
}

}
