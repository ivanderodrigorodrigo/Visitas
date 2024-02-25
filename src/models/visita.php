<?php
class Visita {
    public $id;
    public $visitanteId;
    public $fechaEntrada;
    public $fechaSalida;
    public $motivo;

    public function __construct($id, $visitanteId, $fechaEntrada, $fechaSalida, $motivo) {
        $this->id = $id;
        $this->visitanteId = $visitanteId;
        $this->fechaEntrada = $fechaEntrada;
        $this->fechaSalida = $fechaSalida;
        $this->motivo = $motivo;
    }

    // Métodos para la gestión de visitas podrían ser añadidos aquí
}
