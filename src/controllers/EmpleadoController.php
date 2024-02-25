<?php

require_once './src/models/EmpleadoModel.php';

class EmpleadoController {
    
    private $emp;

    public function __construct(){
        $this->emp = new EmpleadoModel();
    }

    public function mostrarEmpleados(){
        $empleados = $this->emp->get_empleados();
        require_once("./src/views/EmpleadosView.php");
    }

    public function mostrarEmpleado($id_emp){
        $empleado = $this->emp->get_empleado($id_emp);
        require_once("./src/views/EmpleadosView.php");
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
}


?>