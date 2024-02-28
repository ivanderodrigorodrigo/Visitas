
<?php
    use app\controllers\empleadoController;
    $emp = new empleadoController();
?>
<div class="col-md-10">

<div class="rounded-box d-flex flex-column justify-content-center">
    <!-- Título -->
    <div class="formulario-seccion">
        <h2 class="tituloEmpleados">Lista de Empleados</h2>
    </div>
    <table>
        <tr><th>DNI</th><th>Nombre</th><th>Apellidos</th><th>Email</th><th>Rol</th><th>Estado Civil</th><th>Activo</th></tr>
        <?php 
        foreach($emp->mostrarEmpleados() as $empleado): ?>
            <tr onclick="window.location='<?php echo APP_URL;?>empleadosCRUD?id_emp=<?php echo $empleado['id_emp'] ?>'">
                <td><?= $empleado['dni_emp'] ?></td>
                <td><?= $empleado['nombre_emp'] ?></td>
                <td><?= $empleado['apellido_emp'] ?></td>
                <td><?= $empleado['email_emp'] ?></td>
                <td><?= $empleado['nombre_rol'] ?></td>
                <td><?= $empleado['nombre_estado'] ?></td>
                <td><?= $empleado['activo_emp'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="<?php echo APP_URL;?>empleadosCRUD/">Agregar Nuevo Usuario</a>

</div>
          


</div>

