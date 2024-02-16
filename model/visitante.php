<?php
class Visitante {
    public $id;
    public $nombre;
    public $tipoIdentificacion;
    public $numeroIdentificacion;
    public $empresa;

    public function __construct($id, $nombre, $tipoIdentificacion, $numeroIdentificacion, $empresa) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->tipoIdentificacion = $tipoIdentificacion;
        $this->numeroIdentificacion = $numeroIdentificacion;
        $this->empresa = $empresa;
    }

    // Métodos para la gestión de visitantes podrían ser añadidos aquí
}
