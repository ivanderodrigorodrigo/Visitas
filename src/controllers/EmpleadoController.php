<?php
class EmpleadoController {

    public function agregarEmpleado($nombre, $email, $departamentoId) {
        // Aquí iría la lógica para agregar un nuevo empleado a la base de datos
        echo "Empleado agregado: " . $nombre . " en el departamento ID: " . $departamentoId . "\n";
    }

    public function listarEmpleados() {
        // Aquí iría la lógica para obtener una lista de todos los empleados de la base de datos
        // Esta es una simulación de datos
        return [
            ['id' => 1, 'nombre' => 'Juan Perez', 'email' => 'juan.perez@example.com', 'departamentoId' => 1],
            ['id' => 2, 'nombre' => 'Ana Lopez', 'email' => 'ana.lopez@example.com', 'departamentoId' => 2]
        ];
    }

    public function actualizarEmpleado($id, $nombre, $email, $departamentoId) {
        // Aquí iría la lógica para actualizar la información de un empleado en la base de datos
        echo "Empleado actualizado: " . $nombre . " con ID: " . $id . "\n";
    }

    public function eliminarEmpleado($id) {
        // Aquí iría la lógica para eliminar un empleado de la base de datos
        echo "Empleado eliminado con ID: " . $id . "\n";
    }
}

$empleadoController = new EmpleadoController();

// Agregar un nuevo empleado
$empleadoController->agregarEmpleado('Laura García', 'laura.garcia@example.com', 3);

// Listar todos los empleados
$empleados = $empleadoController->listarEmpleados();
print_r($empleados);

// Actualizar la información de un empleado
$empleadoController->actualizarEmpleado(1, 'Juan Pérez', 'juan.perez@example.com', 1);

// Eliminar un empleado
$empleadoController->eliminarEmpleado(2);
