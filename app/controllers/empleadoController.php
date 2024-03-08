<?php

namespace app\controllers;
use app\models\EmpleadoModel;


class empleadoController extends EmpleadoModel {

    private $emp;

    public function __construct(){
        $this->emp = new EmpleadoModel();
    }

    public function mostrarEmpleados($pagina){
        return $this->emp->get_empleados($pagina);

    }

    public function mostrarEmpleado($id_emp){
       return $this->emp->get_empleado($id_emp);
    }

    public function insertarEmpleado(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $dni_emp = $_POST['dni_emp'];
            $nombre_emp = $_POST['nombre_emp'];
            $apellido_emp = $_POST['apellido_emp'];
            $email_emp = $_POST['email_emp'];  
            $rol_id = $_POST['rol_emp'];
            $rol_id = $_POST['rol_emp'];
            $estado_id = $_POST['estado_emp'];
            $activo_emp = 'S';

            $this->emp->insertar($dni_emp, $nombre_emp, $apellido_emp, $email_emp, null, $rol_id, $activo_emp, $estado_id);
            $this->mostrarEmpleadoView();
        }
    }

    public function modificarEmpleado(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id_emp = $_POST['id_emp'];
            $dni_emp = $_POST['dni_emp'];
            $nombre_emp = $_POST['nombre_emp'];
            $apellido_emp = $_POST['apellido_emp'];
            $email_emp = $_POST['email_emp'];    
            $rol_id = $_POST['rol_emp'];
            $estado_id = $_POST['estado_emp'];
            $activo_emp = $_POST['activo_emp'];

            $this->emp->modificar($id_emp, $dni_emp, $nombre_emp, $apellido_emp, $email_emp, $rol_id, $estado_id, $activo_emp);
            $this->mostrarEmpleadoView();

        }
    }

    public function eliminarEmpleado($id_emp){
        $this->emp->eliminar($id_emp);
        $this->mostrarEmpleadoView();
    }


    public function getEstados(){
        return $this->emp->getEstados();
     }

    public function mostrarEmpleadoView(){
        header("Location: ".APP_URL."empleados/");
    }

    public function getTotalEmpleados(){
        return $this->emp->getTotalEmpleados();
    }

}


?>