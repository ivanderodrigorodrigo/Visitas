<?php

require_once './src/models/EmpleadoModel.php';

class EmpleadoController {
    
    private $emp;

    public function __construct(){
        $this->emp = new EmpleadoModel();
    }

    public function mostrarEmpleados($id_emp = null) {
        if ($id_emp !== null) {
            // Mostrar los detalles de un solo empleado
            $empleado = $this->emp->get_empleado($id_emp);
            require_once("./src/views/FormularioMostrarEmpleado.php");
        } else {
            // Mostrar todos los empleados
            $empleados = $this->emp->get_empleados();
            require_once("./src/views/FormularioMostrarEmpleado.php");
        }
    }
    
    

    public function insertarEmpleado($dni_emp, $nombre_emp, $apellido_emp, $email_emp, $contrasenya_emp, $rol_id, $activo_emp){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->emp->insertar($dni_emp, $nombre_emp, $apellido_emp, $email_emp, $contrasenya_emp, $rol_id, $activo_emp);
            $this->mostrarEmpleados();
        }
    }

    public function modificarEmpleado($id_emp, $dni_emp, $nombre_emp, $apellido_emp, $email_emp, $contrasenya_emp, $rol_id, $activo_emp){
        $this->emp->modificar($id_emp, $dni_emp, $nombre_emp, $apellido_emp, $email_emp, $contrasenya_emp, $rol_id, $activo_emp);
        $this->mostrarEmpleados();
    }

    public function eliminarEmpleado($id_emp){
        $this->emp->eliminar($id_emp);
        $this->mostrarEmpleados();
    }

    public function mostrarFormularioInsercion() {
        require_once("./src/Views/FormularioInsercionEmpleado.php");
    }

    public function mostrarFormularioEdicion($id_emp) {
        // Obtener los datos del empleado con el ID dado y pasarlos a la vista de edición
        $empleado = $this->emp->get_empleado($id_emp);
        require_once("./src/views/FormularioEdicionEmpleado.php");
    }
}

