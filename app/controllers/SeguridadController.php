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


}


?>