<?php
class UsuarioController {
    // Método para registrar un nuevo usuario
    public function registrar($nombre, $email, $password) {
        // Aquí iría la lógica para agregar el nuevo usuario a la base de datos
        // Por simplicidad, este ejemplo solo imprimirá los datos
        echo "Registrando nuevo usuario: $nombre, $email, $password\n";
        // Recuerda: ¡Nunca almacenes contraseñas en texto plano! Usa password_hash() en una implementación real.
    }

    // Método para iniciar sesión
    public function iniciarSesion($email, $password) {
        // Aquí iría la lógica para verificar el email y la contraseña con la base de datos
        // Este ejemplo solo es ilustrativo
        echo "Inicio de sesión para: $email con contraseña $password\n";
        // En la práctica, deberías usar password_verify() para comparar la contraseña con el hash almacenado
    }

    // Método para recuperar contraseña
    public function recuperarContrasena($email) {
        // Aquí iría la lógica para iniciar el proceso de recuperación de contraseña
        // Por ejemplo, generar un token de restablecimiento y enviarlo por correo electrónico
        echo "Recuperación de contraseña para: $email\n";
    }
}

// Ejemplo de uso
$usuarioController = new UsuarioController();
$usuarioController->registrar('Juan Perez', 'juan@example.com', 'password123');
$usuarioController->iniciarSesion('juan@example.com', 'password123');
$usuarioController->recuperarContrasena('juan@example.com');
