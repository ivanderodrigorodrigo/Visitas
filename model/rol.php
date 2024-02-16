<?php
class Rol {
    public $id;
    public $nombre;
    public $permisos; // Esto podría ser un array de objetos Permiso o simplemente identificadores de permisos

    public function __construct($id, $nombre, $permisos = []) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->permisos = $permisos;
    }

    // Métodos para gestionar los roles, como agregar o quitar permisos, podrían ser añadidos aquí
}
