<?php

namespace app\controllers;
use app\models\SeguridadModel;

class SeguridadController extends SeguridadModel {

    private $seg;

    public function __construct(){
        $this->seg = new SeguridadModel();
    }

    public function mostrarRoles(){
        return $this->seg->get_Roles();
    }

    
    public function VerificarPermisosModuloRol($modulo){

        if(isset($_SESSION['user_rol'])){

            $permiso = $this->seg->PermisosModuloRol($modulo,$_SESSION['user_rol']);
            if (isset($permiso)){
                return true;
            }
            return false;
        } else {
            //No se ha iniciado sesión, solo tiene acceso a LOGIN o CHANGEPASSWORD
            return true;
        }

        
    }


}


?>