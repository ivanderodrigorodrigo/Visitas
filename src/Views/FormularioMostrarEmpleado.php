<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Empleados</title>
    <link rel="stylesheet" href="./public/css/style.css"> <!-- Enlaza tu archivo de estilos CSS -->
</head>
<body>
    <h1>Lista de Empleados</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Rol</th> <!-- Cambiamos "Rol ID" por "Rol" -->
                <th>Activo</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($empleado)): ?>
                <!-- Mostrar detalles de un solo empleado -->
                <tr>
                    <td><?= $empleado['id_emp'] ?></td>
                    <td><?= $empleado['dni_emp'] ?></td>
                    <td><?= $empleado['nombre_emp'] ?></td>
                    <td><?= $empleado['apellido_emp'] ?></td>
                    <td><?= $empleado['email_emp'] ?></td>
                    <td>
                        <?php 
                        $rol = '';
                        switch ($empleado['rol_id']) {
                            case 1:
                                $rol = 'Administrador';
                                break;
                            case 2:
                                $rol = 'Recepcionista';
                                break;
                            case 3:
                                $rol = 'Empleado';
                                break;
                            default:
                                $rol = 'Desconocido';
                                break;
                        }
                        echo $rol;
                        ?>
                    </td>
                    <td><?= $empleado['activo_emp'] ?></td>
                </tr>
            <?php else: ?>
                <!-- Mostrar todos los empleados -->
                <?php foreach($empleados as $empleado): ?>
                    <tr>
                        <td><?= $empleado['id_emp'] ?></td>
                        <td><?= $empleado['dni_emp'] ?></td>
                        <td><?= $empleado['nombre_emp'] ?></td>
                        <td><?= $empleado['apellido_emp'] ?></td>
                        <td><?= $empleado['email_emp'] ?></td>
                        <td>
                            <?php 
                            $rol = '';
                            switch ($empleado['rol_id']) {
                                case 1:
                                    $rol = 'Administrador';
                                    break;
                                case 2:
                                    $rol = 'Recepcionista';
                                    break;
                                case 3:
                                    $rol = 'Empleado';
                                    break;
                                default:
                                    $rol = 'Desconocido';
                                    break;
                            }
                            echo $rol;
                            ?>
                        </td>
                        <td><?= $empleado['activo_emp'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
