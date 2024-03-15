<?php
namespace app\includes;
use app\models\EmpleadoModel;
use app\controllers\viewsController;

class authenticate extends EmpleadoModel {

    private $emp;

    public function __construct(){
        $this->emp = new EmpleadoModel();
    }

    public function verificarUser(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($this->emp->getEmpleadoLogin($email,$password)){
                header("Location: ".APP_URL);
            } else {
                $_SESSION['valid_user'] = 0;
                header("Location: ".APP_URL.'login');
            }

        }
    }
}

?>
