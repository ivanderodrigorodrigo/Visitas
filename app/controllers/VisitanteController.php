<?php

namespace app\controllers;
use app\models\VisitanteModel;

class VisitanteController {
    protected $model;

    public function __construct() {
        $this->model = new VisitanteModel();
    }

    public function listar() {
        return $this->model->listarVisitantes();
    }

    public function ver($id) {
        return $this->model->obtenerVisitante($id);
    }

    public function guardar($datos) {
        if (isset($datos['id_visitante'])) {
            return $this->model->actualizarVisitante($datos['id_visitante'], $datos);
        } else {
            return $this->model->crearVisitante($datos);
        }
    }


    public function eliminar($id) {
        return $this->model->eliminarVisitante($id);
    }


    public function buscar($busqueda) {
       
   
        $terminoDeBusqueda = is_array($busqueda) ? '' : trim((string)$busqueda);
        
        // Si el término de búsqueda está vacío después de trim, retorna un array vacío.
        if (empty($terminoDeBusqueda)) {
            return [];
        }
        
        // Llama al modelo para realizar la búsqueda.
        return $this->model->buscarVisitantes($terminoDeBusqueda);
    }
    
    
    
    

    public function listarConPaginacion($pagina = 1, $tamanioPagina = 5, $ordenarPor = 'fecha_visita', $direccion = 'ASC', $busqueda = '') {
        
        $pagina = max(1, intval($pagina));
        $inicio = ($pagina - 1) * $tamanioPagina;
    
        // Integrar la búsqueda en el conteo total y en la obtención de los visitantes
        $totalVisitantes = $this->model->contarVisitantes($busqueda); // Asume que adaptas este método para aceptar búsqueda
        $totalPaginas = ceil($totalVisitantes / $tamanioPagina);
        $visitantes = $this->model->listarVisitantesConLimite($inicio, $tamanioPagina, $ordenarPor, $direccion, $busqueda); // Asume que adaptas este método para aceptar búsqueda
    
        return [
            'visitantes' => $visitantes,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
            'totalVisitantes' => $totalVisitantes
        ];
    }
    
    public function obtenerEmpleados() {
        return $this->model->listarEmpleados();
    }
    
    
    
    
    
    
    
    
    
    
    
}
