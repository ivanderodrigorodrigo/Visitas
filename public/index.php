<?php
// Iniciar sesión para utilizar variables de sesión
include "database.php";
session_start();

// Comprobar si el usuario ya ha iniciado sesión
if (isset($_SESSION['user'])) {
    // Usuario ha iniciado sesión, redirigir al dashboard
    header('Location: /views/dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Nuestra Aplicación</title>
    <link rel="stylesheet" href="path/to/your/css/style.css"> <!-- Asegúrate de incluir el camino correcto a tu archivo CSS -->
</head>
<body>
    <h1>Bienvenido a Nuestra Aplicación de Gestión de Visitas</h1>
    <p>Por favor, elige una opción:</p>
    <div>
        <a href="/public/login.php">Iniciar Sesión</a> | <a href="/public/registro.php">Registrarse</a>
    </div>
</body>
</html>

