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
    
    
    
    

    public function listarConPaginacion($pagina = 1, $tamanioPagina = 5) {
        // Asegurar que la página no sea menor que 1
        $pagina = max(1, intval($pagina));
        
        // Calcular el valor de inicio basado en la página actual y el tamaño de la página
        $inicio = ($pagina - 1) * $tamanioPagina;
        
        // Obtener el total de visitantes y calcular el total de páginas
        $totalVisitantes = $this->model->contarVisitantes();
        $totalPaginas = ceil($totalVisitantes / $tamanioPagina);
        
        // Obtener los visitantes con el límite correcto
        $visitantes = $this->model->listarVisitantesConLimite($inicio, $tamanioPagina);
        
        // Devolver los resultados junto con la información de paginación
        return [
            'visitantes' => $visitantes,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
            'totalVisitantes' => $totalVisitantes
        ];
    }
    
    
    
    
    
    
    
    
    
    
}
