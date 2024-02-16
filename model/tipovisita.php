<?php
class TipoVisita {
    public $id;
    public $nombre;
    public $descripcion;

    public function __construct($id, $nombre, $descripcion) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
    }

    // Aquí podrías incluir métodos específicos relacionados con los tipos de visita
}
