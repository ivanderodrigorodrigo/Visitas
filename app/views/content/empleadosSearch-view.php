<?php

use app\controllers\empleadoController;
use app\controllers\globalController;

$emp = new empleadoController();
$global = new globalController();

if (isset($_POST['nombre']) or $_SESSION['filtro'] <> ''){

    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : $_SESSION['filtro'];
    $empleados = $emp->buscarEmpleados($nombre,$_SESSION['page']);
    //Obtener el número total de empleados de la BBDD
    $total_empleados = $emp->getTotalEmpleadosSearch($nombre);

    //Obtener la cantida de páginas necesarias para mostrar todos los datos
    $total_paginas = ceil($total_empleados / FILAS_TABLA);
} else {
    $empleados = $emp->mostrarEmpleados($_SESSION['page']);
}

// Obtener la página que vamos a mostrar en la tabla
$page = $global->getid("pagina");
$_SESSION['page'] = isset($page) ? $page : 1;
?>

    <table id="employeesTable" class="table">
        <thead>
            <tr>
                <th class="sortable" data-column="1" data-type="string">Nombre <i class="bi bi-funnel"></i></th>
                <th class="sortable" data-column="2" data-type="string">Apellido <i class="bi bi-funnel"></i></th>
                <th class="sortable" data-column="3" data-type="string">DNI <i class="bi bi-funnel"></i></th>
                <th class="sortable" data-column="4" data-type="string">Tipo <i class="bi bi-funnel"></i></th>
                <th class="sortable" data-column="5" data-type="string">Estado <i class="bi bi-funnel"></i></th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($empleados as $empleado) : ?>
                <tr onclick="window.location='<?php echo APP_URL; ?>empleadosCRUD?id_emp=<?php echo $empleado['id_emp'] ?>'">
                    <td><?= $empleado['nombre_emp'] ?></td>
                    <td><?= $empleado['apellido_emp'] ?></td>
                    <td><?= $empleado['dni_emp'] ?></td>
                    <td><?= $empleado['nombre_rol'] ?></td>
                    <td><?= $empleado['activo_emp'] = 'S' ? 'Alta' : 'Baja' ?></td>
                    <td class="apartadoAccion"><label class="fas fa-edit" onclick=""></label></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<!-- Sección de paginación -->
<div class="pagination-section">
    <button id="prevPage" class="btn btn-left"
    onclick="window.location='<?php echo APP_URL; ?>empleados?pagina=<?php echo  $_SESSION['page'] == 1 ? 1 : $_SESSION['page'] - 1; if (isset($nombre)){?>&filtro=<?php echo  $nombre;} ?>'"  <?php if ( $_SESSION['page'] == 1) { echo 'disabled';} else echo 'enabled'; ?>>
    <i class="fas fa-arrow-left"></i></button>
    <?php 
    for ($i = 1; $i<=$total_paginas;$i++){ ?>
        <button class="btn <?php if ($i == $_SESSION['page'] ) echo 'page-selected'; else echo 'page-number' ?> " onclick="window.location='<?php echo APP_URL; ?>empleados?pagina=<?php echo  $i; if (isset($nombre)){?>&filtro=<?php echo  $nombre;} ?>'">
        <?php echo $i; ?></button>
    <?php } ?>
    <button id="nextPage" class="btn btn-right" 
        onclick="window.location='<?php echo APP_URL; ?>empleados?pagina=<?php echo  $_SESSION['page'] + 1; if (isset($nombre)){?>&filtro=<?php echo  $nombre;} ?>'" <?php if (  $_SESSION['page'] == $total_paginas) { echo 'disabled';} else echo 'enabled'; ?>>
        <i class="fas fa-arrow-right"></i>
    </button>
</div>   
