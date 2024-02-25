<?php
class ConfiguracionSeguridad {
    public $id;
    public $nombre;
    public $valor;

    public function __construct($id, $nombre, $valor) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->valor = $valor;
    }
}
