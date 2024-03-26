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
    
    public function contarVisitantes() {
        $resultado = $this->db->query("SELECT COUNT(*) as total FROM visitantes WHERE activo_visitante = 'S'");
        $fila = $resultado->fetch_assoc();
        return $fila['total'];
    }

    public function listarVisitantesConLimite($inicio, $tamanioPagina) {
        $inicioEntero = intval($inicio); // Almacenar el valor en una variable
        $tamanioPaginaEntero = intval($tamanioPagina); // Almacenar el valor en una variable
        
        $stmt = $this->db->prepare("SELECT * FROM visitantes WHERE activo_visitante = 'S' LIMIT ?, ?");
        $stmt->bind_param("ii", $inicioEntero, $tamanioPaginaEntero); // Pasar las variables a bind_param()
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
    
    

    
    
   
    
    
}
