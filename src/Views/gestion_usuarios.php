<?php
// Incluir archivos necesarios
// include 'UsuarioController.php';
// $usuarioController = new UsuarioController();

// Asumiendo que hay lógica aquí para conectar con la base de datos y obtener la lista de usuarios

// Simulación de usuarios obtenidos de la base de datos
$usuarios = [
    ['id' => 1, 'nombre' => 'Juan Perez', 'email' => 'juan@example.com'],
    ['id' => 2, 'nombre' => 'Ana López', 'email' => 'ana@example.com']
];

// Añadir, editar o eliminar usuarios podría también gestionarse aquí,
// dependiendo de las acciones del usuario en el formulario (no mostrado)
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
</head>
<body>
    <h1>Gestión de Usuarios</h1>
    <a href="agregarUsuario.php">Agregar Nuevo Usuario</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?php echo $usuario['id']; ?></td>
                <td><?php echo $usuario['nombre']; ?></td>
                <td><?php echo $usuario['email']; ?></td>
                <td>
                    <a href="editarUsuario.php?id=<?php echo $usuario['id']; ?>">Editar</a> |
                    <a href="eliminarUsuario.php?id=<?php echo $usuario['id']; ?>" onclick="return confirm('¿Estás seguro de querer eliminar este usuario?');">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
