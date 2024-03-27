<?php

namespace app\models;
require_once __DIR__ . "/../../config/app.php";


class VisitanteModel {

    private $db;

    public function __construct() {
        include './app/includes/database.php';
        $this->db = $conn;
    }


    public function listarVisitantes() {
        return $this->db->query("SELECT * FROM visitantes WHERE activo_visitante = 'S'")->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerVisitante($id) {
        $stmt = $this->db->prepare("SELECT * FROM visitantes WHERE id_visitante = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

  

    public function crearVisitante($datos) {
        $stmt = $this->db->prepare("INSERT INTO visitantes (dni_visitante, nombre_visitante, apellido_visitante, email_visitante, empresa_visitante, fecha_visita, id_emp_visita, id_motivo_visita) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssii", $datos['dni_visitante'], $datos['nombre_visitante'], $datos['apellido_visitante'], $datos['email_visitante'], $datos['empresa_visitante'], $datos['fecha_visita'], $datos['id_emp_visita'], $datos['id_motivo_visita']);
        return $stmt->execute();
    }
    
    public function actualizarVisitante($id, $datos) {
        $stmt = $this->db->prepare("UPDATE visitantes SET dni_visitante = ?, nombre_visitante = ?, apellido_visitante = ?, email_visitante = ?, empresa_visitante = ?, fecha_visita = ?, id_emp_visita = ?, id_motivo_visita = ? WHERE id_visitante = ?");
        $stmt->bind_param("ssssssi", $datos['dni_visitante'], $datos['nombre_visitante'], $datos['apellido_visitante'], $datos['email_visitante'], $datos['empresa_visitante'], $datos['fecha_visita'], $datos['id_emp_visita'], $datos['id_motivo_visita'], $id);
        return $stmt->execute();
    }
    

    public function eliminarVisitante($id) {
        $stmt = $this->db->prepare("UPDATE visitantes SET activo_visitante = 'N' WHERE id_visitante = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function buscarVisitantes($busqueda) {
        
        $query = "SELECT * FROM visitantes WHERE activo_visitante = 'S' AND (
            dni_visitante LIKE ? OR 
            nombre_visitante LIKE ? OR 
            apellido_visitante LIKE ? OR 
            email_visitante LIKE ? OR 
            empresa_visitante LIKE ?
        )";
    
        // Añade los comodines alrededor de la búsqueda para coincidencias parciales
        $parametroDeBusqueda = "%" . $busqueda . "%";
    
        // Prepara la consulta SQL
        $stmt = $this->db->prepare($query);
    
        // Vincula los parámetros a la consulta
        // Cada '?' en la consulta será reemplazado por $parametroDeBusqueda
        $stmt->bind_param("sssss", $parametroDeBusqueda, $parametroDeBusqueda, $parametroDeBusqueda, $parametroDeBusqueda, $parametroDeBusqueda);
    
        // Ejecuta la consulta
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        // Devuelve los resultados
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
    
   
    
    public function contarVisitantes($busqueda = '') {
       
        $sql = "SELECT COUNT(*) as total FROM visitantes WHERE activo_visitante = 'S' AND fecha_visita >=CURRENT_DATE";
    
        if (!empty($busqueda)) {
            $sql .= " AND (dni_visitante LIKE ? OR nombre_visitante LIKE ? OR apellido_visitante LIKE ? OR email_visitante LIKE ? OR empresa_visitante LIKE ?)";
            $stmt = $this->db->prepare($sql);
            $likeBusqueda = '%' . $busqueda . '%';
            $stmt->bind_param("sssss", $likeBusqueda, $likeBusqueda, $likeBusqueda, $likeBusqueda, $likeBusqueda);
        } else {
            $stmt = $this->db->prepare($sql);
        }
        
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
                
        return $resultado['total'];
    }
    
    public function listarVisitantesConLimite($inicio, $tamanioPagina, $ordenarPor = 'fecha_visita', $direccion = 'ASC', $busqueda = '') {
        $this->actualizarEstadoVisitantes();
      
        // Validar que la columna de ordenamiento sea una de las permitidas, agregando nombre_emp y apellido_emp
        $columnasValidas = ['dni_visitante', 'nombre_visitante', 'apellido_visitante', 'email_visitante', 'empresa_visitante', 'fecha_visita', 'nombre_emp', 'apellido_emp'];
        if (!in_array($ordenarPor, $columnasValidas)) {
            $ordenarPor = 'fecha_visita';
        }
        $direccion = strtoupper($direccion) === 'DESC' ? 'DESC' : 'ASC';
    
        // Modificar la consulta SQL para incluir un JOIN con la tabla empleados y filtrar por fecha_visita futura
        $sql = "SELECT v.*, e.nombre_emp, e.apellido_emp FROM visitantes AS v
                LEFT JOIN empleados AS e ON v.id_emp_visita = e.id_emp 
                WHERE v.activo_visitante = 'S' AND v.fecha_visita >=CURRENT_DATE";
    
        // Añadir búsqueda SQL si se proporcionó un término de búsqueda
        if ($busqueda) {
            $sql .= " AND (v.dni_visitante LIKE ? OR v.nombre_visitante LIKE ? OR v.apellido_visitante LIKE ? OR v.email_visitante LIKE ? OR v.empresa_visitante LIKE ?)";
        }
    
        // Completar la consulta SQL con ordenamiento, dirección y paginación
        $sql .= " ORDER BY $ordenarPor $direccion LIMIT ?, ?";
    
        // Preparar la consulta SQL
        $stmt = $this->db->prepare($sql);
    
        if ($busqueda) {
            $likeBusqueda = '%' . $busqueda . '%';
            // Vincular parámetros de búsqueda y paginación
            $stmt->bind_param("sssssii", $likeBusqueda, $likeBusqueda, $likeBusqueda, $likeBusqueda, $likeBusqueda, $inicio, $tamanioPagina);
        } else {
            // Vincular solo parámetros de paginación cuando no hay búsqueda
            $stmt->bind_param("ii", $inicio, $tamanioPagina);
        }
    
        // Ejecutar la consulta
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        // Devolver los resultados
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
    
    
    
    
    public function listarEmpleados() {
        $resultado = $this->db->query("SELECT id_emp, nombre_emp, apellido_emp FROM empleados WHERE activo_emp = 'S'");
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
    

    
    public function actualizarEstadoVisitantes() {
       
        $sql = "UPDATE visitantes SET activo_visitante = 'N' WHERE fecha_visita < CURRENT_DATE AND activo_visitante = 'S'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }
    
   
    public function dniYaExiste($dni) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM visitantes WHERE dni_visitante = ?");
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        return $resultado['total'] > 0;
    }
    
    
}
