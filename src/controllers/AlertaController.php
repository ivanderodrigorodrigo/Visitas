<?php
class AlertaController {
    // Método para registrar una nueva alerta
    public function crearAlerta($tipo, $descripcion, $fecha) {
        // Aquí iría la lógica para agregar la nueva alerta a la base de datos
        echo "Alerta de tipo '$tipo' creada: $descripcion\n";
    }

    // Método para listar todas las alertas
    public function listarAlertas() {
        // Aquí iría la lógica para obtener todas las alertas de la base de datos
        // Simulación de datos obtenidos
        return [
            ['tipo' => 'Acceso no autorizado', 'descripcion' => 'Intento de acceso sin permiso en puerta trasera.', 'fecha' => '2024-02-15 09:00'],
            ['tipo' => 'Fuego', 'descripcion' => 'Sensor de humo activado en el almacén.', 'fecha' => '2024-02-16 11:00']
        ];
    }

    // Método para actualizar el estado de una alerta (ejemplo: marcar como atendida)
    public function actualizarAlerta($idAlerta, $nuevoEstado) {
        // Aquí iría la lógica para actualizar el estado de la alerta en la base de datos
        echo "Alerta con ID $idAlerta actualizada al estado: $nuevoEstado\n";
    }
}

// Ejemplo de uso
$alertaController = new AlertaController();

// Crear una nueva alerta
$alertaController->crearAlerta('Intrusión', 'Se detectó movimiento no autorizado en el área restringida', '2024-02-18 22:30');

// Listar todas las alertas
$alertas = $alertaController->listarAlertas();
echo "Listado de todas las alertas:\n";
print_r($alertas);

// Actualizar el estado de una alerta
$alertaController->actualizarAlerta(1, 'Atendida');
