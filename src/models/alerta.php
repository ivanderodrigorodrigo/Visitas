<?php
class Alerta {
    public $id;
    public $tipo;
    public $descripcion;
    public $fecha;

    public function __construct($id, $tipo, $descripcion, $fecha) {
        $this->id = $id;
        $this->tipo = $tipo;
        $this->descripcion = $descripcion;
        $this->fecha = $fecha;
    }
}
