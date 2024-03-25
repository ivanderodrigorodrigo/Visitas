<?php
namespace app\includes;
use app\models\EmpleadoModel;
use app\controllers\globalController;

class authenticate extends EmpleadoModel {

    private $emp;
    private $global;

    public function __construct(){
        $this->emp = new EmpleadoModel();
        $this->global = new globalController();

    }

    public function verificarUser(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $email = $this->global->limpiarCadena($_POST['email']);
            $password = $this->global->limpiarCadena($_POST['password']);

            $empleado = $this->emp->getEmpledoByEmail($email);

            if (isset($empleado)){

                if (!isset($empleado['contrasenya_emp'])){
                    echo '<div class="error-message d-flex justify-content-center align-items-center">
                            <p style="color: red;"> No tienes contraseña establecida. Haz click en "Recuperar contraseña" </p>            
                        </div>';
                } else {

                    if ($email == $empleado['email_emp'] && password_verify($password,$empleado['contrasenya_emp'])){

                        $_SESSION['id']=$empleado["id_emp"];
                        $_SESSION['user_name']=$empleado["nombre_emp"];
                        $_SESSION['user_surname']=$empleado["apellido_emp"];
                        $_SESSION['user_rol']=$empleado["rol_id"];

                        if (headers_sent()){
                            echo "<script> window.location.href='".APP_URL."'; </script>";
                        }else {
                            header("Location: ".APP_URL);
                        }
                    
                    } else {
                        echo '<div class="error-message d-flex justify-content-center align-items-center">
                                <i class="material-icons mx-2">error</i>
                                <p style="color: red;"> Email de usuario o contraseña incorrectos. </p>            
                            </div>';
                    }
                }
            }else{
                echo '<div class="error-message d-flex justify-content-center align-items-center">
                        <i class="material-icons mx-2">error</i>
                        <p style="color: red;"> Usuario no dado de alta. </p>            
                    </div>';
            }

        }
    }

    public function changePassword(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $email = $this->global->limpiarCadena($_POST['email']);
            $password1 = $this->global->limpiarCadena($_POST['psw1']);
            $password2 = $this->global->limpiarCadena($_POST['psw2']);

            if ($password1 == $password2){

                $empleado = $this->emp->getEmpledoByEmail($email);

                if (isset($empleado)){

                    $psw_hash = password_hash($password1, PASSWORD_DEFAULT);
                    if ($this->emp->updatePassword($empleado['id_emp'],$psw_hash)){
                        echo '<script> alert("Contraseña actualizada con éxito");';
                        echo "window.location.href='".APP_URL."login/'; </script>";

                    } else {
                        echo '<div class="error-message d-flex justify-content-center align-items-center">
                        <i class="material-icons mx-2">error</i>
                        <p style="color: red;"> Error. No se ha podido actualizar la contraseña. </p>            
                        </div>';
                    }

                }else{
                    echo '<div class="error-message d-flex justify-content-center align-items-center">
                        <i class="material-icons mx-2">error</i>
                        <p style="color: red;"> Usuario no dado de alta. </p>            
                    </div>';
                }

            }else {
                echo '<div class="error-message d-flex justify-content-center align-items-center">
                        <i class="material-icons mx-2">error</i>
                        <p style="color: red;"> Las contraseñas no son idénticas. </p>            
                    </div>';
            }
        }


    }
}

?>
