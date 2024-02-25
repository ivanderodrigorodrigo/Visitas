
<!DOCTYPE html>
<html>
<head>
    <title>Lista de Empleados</title>
</head>
<body>
    <h1>Lista de Empleados</h1>
    <table>
        <tr><th>ID</th><th>DNI</th><th>Nombre</th><th>Apellido</th><th>Email</th><th>Rol ID</th><th>Activo</th></tr>
        <?php 
        foreach($empleados as $empleado): ?>
            <tr>
                <td><?= $empleado['id_emp'] ?></td>
                <td><?= $empleado['dni_emp'] ?></td>
                <td><?= $empleado['nombre_emp'] ?></td>
                <td><?= $empleado['apellido_emp'] ?></td>
                <td><?= $empleado['email_emp'] ?></td>
                <td><?= $empleado['rol_id'] ?></td>
                <td><?= $empleado['activo_emp'] ?></td>
                <td>
                    <a href="">Editar</a> |
                    <a href="" onclick="return confirm('¿Estás seguro de querer eliminar este usuario?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="../src/Views/EmpleadosCreateView.php">Agregar Nuevo Usuario</a>

</body>
</html>