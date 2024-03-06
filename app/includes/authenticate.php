<?php

namespace app\includes;
use app\models\EmpleadoModel;
use app\controllers\viewsController;

class authenticate extends EmpleadoModel {

    private $emp;
    private $views;

    public function __construct(){
        $this->emp = new EmpleadoModel();
        $this->views = new viewsController();
    }

    public function verificarUser(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($this->emp->getEmpleadoLogin($email,$password)){
                header("Location: ".APP_URL);
            } else {
                echo '<script>';
                echo 'alert("Acceso denegado ';
                echo ' ';
                echo '");';
                echo '</script>';
            }

        }
    }
}

?>
