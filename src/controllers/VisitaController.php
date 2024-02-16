<?php
class VisitaController {
    // Método para registrar una nueva visita
    public function registrarVisita($visitanteId, $fechaEntrada, $fechaSalida, $motivo) {
        // Aquí iría la lógica para agregar la nueva visita a la base de datos
        echo "Visita registrada para el visitante ID: $visitanteId con motivo: $motivo\n";
    }

    // Método para listar todas las visitas
    public function listarVisitas() {
        // Aquí iría la lógica para obtener todas las visitas de la base de datos
        // Simulación de datos obtenidos
        return [
            ['visitanteId' => 1, 'fechaEntrada' => '2024-02-15 09:00', 'fechaSalida' => '2024-02-15 10:00', 'motivo' => 'Reunión de trabajo'],
            ['visitanteId' => 2, 'fechaEntrada' => '2024-02-16 11:00', 'fechaSalida' => '2024-02-16 12:00', 'motivo' => 'Entrevista']
        ];
    }
}

// Ejemplo de uso
$visitaController = new VisitaController();

// Registrar una nueva visita
$visitaController->registrarVisita(1, '2024-02-15 09:00', '2024-02-15 10:00', 'Reunión de trabajo');

// Listar todas las visitas
$visitas = $visitaController->listarVisitas();
echo "Listado de todas las visitas:\n";
print_r($visitas);
