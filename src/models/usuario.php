<?php
class Usuario {
    public $id;
    public $nombre;
    public $email;
    public $password; // Considera almacenar solo hashes de contraseñas en aplicaciones reales

    public function __construct($id, $nombre, $email, $password) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->password = $password;
    }

    // Aquí podrías incluir métodos para interactuar con la base de datos, como guardar, actualizar o eliminar usuarios
}
