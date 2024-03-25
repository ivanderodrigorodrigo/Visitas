<?php
	
	namespace app\models;
	use app\controllers\SeguridadController;
use app\controllers\viewsController;

	class viewsModel{

		private $navs;
		private $subnavs;
		private $vista;
		private $home;
		private $db;
		private $segController;

		public function __construct(){
			include './app/includes/database.php';
			$this->navs = array();
			$this->vista = array();
			$this->home = array();
			$this->db = $conn;
			$this->segController = new SeguridadController();

		}

		/*---------- Modelo obtener vista ----------*/
		protected function obtenerVistasModelo($vista){
			$consulta = $this->db->query("SELECT url_modulo FROM modulos WHERE url_modulo <> '';");
        
			while($fila = $consulta->fetch_assoc()){
				
				$this->vistas[] = $fila['url_modulo'];
			}
			mysqli_free_result($consulta);

			$consulta = $this->db->query("SELECT * FROM modulos WHERE url_modulo = '{$vista}';");
        
			$this->vista = $consulta->fetch_assoc();

			mysqli_free_result($consulta);

			if(isset($this->vista)){

				if ($this->segController->VerificarPermisosModuloRol($this->vista['id_modulo'])){

					if(is_file("./app/views/content/".$vista."-view.php")){
					$contenido="./app/views/content/".$vista."-view.php";
					$_SESSION['view_current'] = $vista;
					}else{
						//vista no encontrada poner vista para error 404
						$_SESSION['view_current']='403';
						$contenido="./app/views/content/403-view.php";
					}
				} else {
					$_SESSION['view_current']='403';
					$contenido="./app/views/content/403-view.php";
				}


			}elseif($vista=="logout"){
				$_SESSION['view_current']='logout';
				$contenido="./app/includes/session_close.php";
			}else{
				$_SESSION['view_current']='403';
				$contenido="./app/views/content/403-view.php";
			}
			return $contenido;
		}

		/*---------- Modelo obtener navs ----------*/
		protected function obtenerNavs($rol) {
			$consulta = $this->db->query("CALL get_navs({$rol})");
			if (!$consulta) {
				echo "Error al ejecutar la consulta: " . $this->db->error;
				return false; // O maneja el error de acuerdo a tus necesidades
			}
			while ($fila = $consulta->fetch_assoc()) {
				$this->navs[] = $fila;
			}

			mysqli_free_result($consulta);

			return $this->navs;
		}

		/*---------- Modelo obtener subnavs ----------*/
		protected function obtenerSubNavs($subnavs) {
			$consulta = $this->db->query("SELECT * FROM modulos WHERE id_modulo in ({$subnavs});");

			if (!$consulta) {
				echo "Error al ejecutar la consulta: " . $this->db->error;
				return false; // O maneja el error de acuerdo a tus necesidades
			}
			
			while($fila = $consulta->fetch_assoc()){
				$this->subnavs[] = $fila;

			}
			mysqli_free_result($consulta);
			return $this->subnavs;
		}


		/*---------- Modelo obtener subnavs ----------*/
		protected function obtenerVistaHome($rol) {
			$consulta = $this->db->query("SELECT * FROM modulos INNER JOIN modulos_roles mr ON modulos.id_modulo = mr.id_modulo AND mr.id_rol = {$rol} AND mr.modulo_default = 'S';");


			while($fila = $consulta->fetch_assoc()){
				$this->home[] = $fila['url_modulo'];
			}

			mysqli_free_result($consulta);

			if(is_file("./app/views/content/".$this->home[0]."-view.php")){
				$contenido="./app/views/content/".$this->home[0]."-view.php";
				$_SESSION['view_current'] = $this->home[0];

			}else{
				$contenido="404";
			}
	
			return $contenido;
		}

		/*---------- Modelo obtener navs ----------*/
		protected function obtenerNavs($rol) {
			$consulta = $this->db->query("CALL get_navs({$rol})");
			if (!$consulta) {
				echo "Error al ejecutar la consulta: " . $this->db->error;
				return false; // O maneja el error de acuerdo a tus necesidades
			}
			while ($fila = $consulta->fetch_assoc()) {
				$this->navs[] = $fila;
			}

			mysqli_free_result($consulta);

			return $this->navs;
		}

		/*---------- Modelo obtener subnavs ----------*/
		protected function obtenerSubNavs($subnavs) {
			$consulta = $this->db->query("SELECT * FROM modulos WHERE id_modulo in ({$subnavs});");


			while($fila = $consulta->fetch_assoc()){
				$this->subnavs[] = $fila;

			}
			mysqli_free_result($consulta);
	
			return $this->subnavs;
		}


		/*---------- Modelo obtener subnavs ----------*/
		protected function obtenerVistaHome($rol) {
			$consulta = $this->db->query("SELECT * FROM modulos INNER JOIN modulos_roles mr ON modulos.id_modulo = mr.id_modulo AND mr.id_rol = {$rol} AND mr.modulo_default = 'S';");


			while($fila = $consulta->fetch_assoc()){
				$this->home[] = $fila['url_modulo'];
			}

			mysqli_free_result($consulta);

			if(is_file("./app/views/content/".$this->home[0]."-view.php")){
				$contenido="./app/views/content/".$this->home[0]."-view.php";
				$_SESSION['view_current'] = $this->home[0];
			}else{
				$contenido="404";
			}
	
			return $contenido;
		}

	}