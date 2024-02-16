<?php
class Empleado {
    public $id;
    public $nombre;
    public $email;
    public $departamentoId; // ID del departamento al que pertenece el empleado

    public function __construct($id, $nombre, $email, $departamentoId) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->departamentoId = $departamentoId;
    }

    // Métodos para la gestión de empleados podrían ser añadidos aquí
}
