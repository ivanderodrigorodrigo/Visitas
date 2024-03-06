<?php

	namespace app\controllers;
	use app\models\viewsModel;

	class viewsController extends viewsModel{

		/*---------- Controlador obtener vistas ----------*/
		public function obtenerVistasControlador($vista){
			if($vista!=""){
				$respuesta=$this->obtenerVistasModelo($vista);
			}else{
				$respuesta=$this->obtenerVistaHome($_SESSION['user_rol']);
			}
			return $respuesta;
		}


		/*---------- Controlador obtener opciones nav ----------*/
		public function obtenerNavsControlador($rol){
			return $this->obtenerNavs($rol);
		}

		/*---------- Controlador obtener subnav ----------*/
		public function obtenerSubNavsControlador($subnavs){	
			return $this->obtenerSubNavs($subnavs);
		}

		public function obtenerVistaController($rol){
			return $this->obtenerVistaHome($rol);
		}
	}