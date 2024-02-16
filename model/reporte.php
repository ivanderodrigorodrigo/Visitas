<?php
class Reporte {
    public $id;
    public $tipo;
    public $descripcion;
    public $fechaGeneracion;

    public function __construct($id, $tipo, $descripcion, $fechaGeneracion) {
        $this->id = $id;
        $this->tipo = $tipo;
        $this->descripcion = $descripcion;
        $this->fechaGeneracion = $fechaGeneracion;
    }
}
