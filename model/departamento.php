<?php
class Departamento {
    public $id;
    public $nombre;
    public $descripcion;

    public function __construct($id, $nombre, $descripcion) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
    }

    // Métodos para la gestión de departamentos podrían ser añadidos aquí
}
