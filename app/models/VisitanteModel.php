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
        $stmt = $this->db->prepare("INSERT INTO visitantes (dni_visitante, nombre_visitante, apellido_visitante, email_visitante, empresa_visitante, fecha_visita) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $datos['dni_visitante'], $datos['nombre_visitante'], $datos['apellido_visitante'], $datos['email_visitante'], $datos['empresa_visitante'], $datos['fecha_visita']);
        return $stmt->execute();
    }

    public function actualizarVisitante($id, $datos) {
        $stmt = $this->db->prepare("UPDATE visitantes SET dni_visitante = ?, nombre_visitante = ?, apellido_visitante = ?, email_visitante = ?, empresa_visitante = ?, fecha_visita = ? WHERE id_visitante = ?");
        $stmt->bind_param("ssssssi", $datos['dni_visitante'], $datos['nombre_visitante'], $datos['apellido_visitante'], $datos['email_visitante'], $datos['empresa_visitante'], $datos['fecha_visita'], $id);
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
        // Inicializa la consulta base
        $sql = "SELECT COUNT(*) as total FROM visitantes WHERE activo_visitante = 'S'";
        
        // Preparar los parámetros de búsqueda si es necesario
        if (!empty($busqueda)) {
            // Añade condiciones de búsqueda a la consulta
            $sql .= " AND (dni_visitante LIKE ? OR nombre_visitante LIKE ? OR apellido_visitante LIKE ? OR email_visitante LIKE ? OR empresa_visitante LIKE ?)";
            
            // Preparar la consulta con parámetros de búsqueda
            $stmt = $this->db->prepare($sql);
            
            // Concatena los comodines para la búsqueda LIKE
            $likeBusqueda = '%' . $busqueda . '%';
            
            // Vincula los parámetros al statement preparado
            $stmt->bind_param("sssss", $likeBusqueda, $likeBusqueda, $likeBusqueda, $likeBusqueda, $likeBusqueda);
        } else {
            // Prepara la consulta sin parámetros de búsqueda
            $stmt = $this->db->prepare($sql);
        }
        
        // Ejecuta la consulta
        $stmt->execute();
        
        // Obtiene y devuelve el resultado
        $resultado = $stmt->get_result()->fetch_assoc();
        
        return $resultado['total'];
    }
    

    public function listarVisitantesConLimite($inicio, $tamanioPagina, $ordenarPor = 'fecha_visita', $direccion = 'ASC', $busqueda = '') {
        $columnasValidas = ['dni_visitante', 'nombre_visitante', 'apellido_visitante', 'email_visitante', 'empresa_visitante', 'fecha_visita'];
        if (!in_array($ordenarPor, $columnasValidas)) {
            $ordenarPor = 'fecha_visita';
        }
        $direccion = strtoupper($direccion) === 'DESC' ? 'DESC' : 'ASC';
        
        $busquedaSql = $busqueda ? " AND (dni_visitante LIKE ? OR nombre_visitante LIKE ? OR apellido_visitante LIKE ? OR email_visitante LIKE ? OR empresa_visitante LIKE ?)" : '';
        $sql = "SELECT * FROM visitantes WHERE activo_visitante = 'S'" . $busquedaSql . " ORDER BY $ordenarPor $direccion LIMIT ?, ?";
        $stmt = $this->db->prepare($sql);
        
        if ($busqueda) {
            $likeBusqueda = '%' . $busqueda . '%';
            // Aquí, se usan 5 's' para los parámetros de búsqueda y 2 'i' para los de paginación.
            $stmt->bind_param("sssssii", $likeBusqueda, $likeBusqueda, $likeBusqueda, $likeBusqueda, $likeBusqueda, $inicio, $tamanioPagina);
        } else {
            // Cuando no hay búsqueda, solo se vinculan los parámetros de paginación.
            $stmt->bind_param("ii", $inicio, $tamanioPagina);
        }
        
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    
    
    
    

    
    
   
    
    
}
