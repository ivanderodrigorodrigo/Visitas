<?php

namespace app\controllers;

use app\models\RolesyPermisosModel;

class RolesyPermisosController {

    private $model;

    public function __construct() {
        $this->model = new RolesyPermisosModel();
    }

    public function mostrarRoles() {
        return $this->model->getRoles();
    }

    public function mostrarPermisosPorRol($id_rol) {
        return $this->model->getPermisosPorRol($id_rol);
    }

    public function insertarRol($nombre_rol) {
        // Revisar si hay un nombre de rol disponible y no es vacío.
        if (!empty($nombre_rol)) {
            $resultado = $this->model->insertarRol($nombre_rol);
            return $resultado;
        } else {
            return false; // Puede que quieras manejar esto con una excepción o mensaje de error.
        }
    }
    
    
    // Método para mostrar todos los permisos
    public function mostrarPermisos() {
        $permisos = $this->model->mostrarPermisos();
        return $permisos;
    }

    
    public function modificarPermisos($id_rol, $permisos_modificados) {
        // Primero, eliminamos todos los permisos existentes para el rol
        $this->model->eliminarPermisosPorRol($id_rol);
        
        // Luego, asignamos los nuevos permisos
        foreach ($permisos_modificados as $id_permiso) {
            $this->model->asignarPermisoARol($id_rol, $id_permiso);
        }
    
        // Devolvemos true si la operación fue exitosa
        return true;
    }
    
   
    
}
