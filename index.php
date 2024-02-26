<?php
include "./src/includes/database.php";
session_start();
?>

<?php

// Cargar el controlador de empleados
require_once './src/controllers/EmpleadoController.php';

// Obtener la ruta solicitada
$ruta = isset($_GET['ruta']) ? $_GET['ruta'] : '';

// Instanciar el controlador de empleados
$empleadoController = new EmpleadoController();

// Manejar las solicitudes según la ruta
switch ($ruta) {
    case 'mostrar-empleados':
        $empleadoController->mostrarEmpleados();
        break;
    case 'mostrar-empleado':
      
        $id_emp = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id_emp !== null) {
            $empleadoController->mostrarEmpleados($id_emp);
        } else {
           
            echo "ID de empleado no válido";
        }
        break;
    case 'insertar-empleado':
        $dni_emp = $_POST['dni'] ?? '';
        $nombre_emp = $_POST['nombre'] ?? '';
        $apellido_emp = $_POST['apellido'] ?? '';
        $email_emp = $_POST['email'] ?? '';
        $contrasenya_emp = $_POST['contrasenya'] ?? '';
        $rol_id = $_POST['rol_id'] ?? '';
        $activo_emp = $_POST['activo'] ?? '';
        $empleadoController->insertarEmpleado($dni_emp, $nombre_emp, $apellido_emp, $email_emp, $contrasenya_emp, $rol_id, $activo_emp);
        break;
    case 'modificar-empleado':
        $id_emp = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id_emp !== null) {
            $dni_emp = $_POST['dni'] ?? '';
            $nombre_emp = $_POST['nombre'] ?? '';
            $apellido_emp = $_POST['apellido'] ?? '';
            $email_emp = $_POST['email'] ?? '';
            $contrasenya_emp = $_POST['contrasenya'] ?? '';
            $rol_id = $_POST['rol_id'] ?? '';
            $activo_emp = $_POST['activo'] ?? '';
            $empleadoController->modificarEmpleado($id_emp, $dni_emp, $nombre_emp, $apellido_emp, $email_emp, $contrasenya_emp, $rol_id, $activo_emp);
        } else {
            echo "ID de empleado no válido";
        }
        break;
    case 'eliminar-empleado':
        $id_emp = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id_emp !== null) {
            $empleadoController->eliminarEmpleado($id_emp);
        } else {
            echo "ID de empleado no válido";
        }
        break;
    case 'formulario-insercion':
        $empleadoController->mostrarFormularioInsercion();
        break;
    case 'formulario-edicion':
        $id_emp = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id_emp !== null) {
            $empleadoController->mostrarFormularioEdicion($id_emp);
        } else {
            echo "ID de empleado no válido";
        }
        break;
    default:
        // Mostrar una página de error 404 si la ruta no coincide con ninguna de las opciones anteriores
        echo "Error 404: Página no encontrada";
        break;
}

/*
index.php?ruta=mostrar-empleados: Muestra todos los empleados.
index.php?ruta=mostrar-empleado&id=1: Muestra los detalles del empleado con ID 1.
index.php?ruta=insertar-empleado: Muestra el formulario para insertar un nuevo empleado.
index.php?ruta=modificar-empleado&id=1: Muestra el formulario para modificar los detalles del empleado con ID 1.
index.php?ruta=eliminar-empleado&id=1: Elimina el empleado con ID 1.
index.php?ruta=formulario-insercion: Muestra el formulario para insertar un nuevo empleado.
index.php?ruta=formulario-edicion&id=1: Muestra el formulario para editar los detalles del empleado con ID 1.
 */

?>


