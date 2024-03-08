<?php

use app\controllers\empleadoController;
use app\controllers\globalController;

$emp = new empleadoController();
$global = new globalController();

//Obtener el número total de empleados de la BBDD
$total_empleados = $emp->getTotalEmpleados();

//Obtener la cantida de páginas necesarias para mostrar todos los datos
$total_paginas = ceil($total_empleados / FILAS_TABLA);


//Obtener la página que vamos a mostrar en la tabla
$page = $global->getid("pagina");
$_SESSION['page'] = isset($page) ? $page : 1;

?>
<div class="col-md-10">
    <div class="rounded-box d-flex flex-column justify-content-center">
        <!-- Primera Fila: Título -->
        <div class="formulario-seccion">
            <h2 class="tituloEmpleados">Lista de Empleados</h2>
        </div>
        <!-- Segunda fila: Input de búsqueda -->
        <!-- <div class="form-row formulario-seccion">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text form-control" id="basic-addon1"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" id="searchInput" class="form-control" placeholder="Busca por nombre" aria-label="Buscar" aria-describedby="basic-addon1">
            </div>
        </div> -->
        <div class="form-row formulario-seccion">
            <div class="input-group">                
                <input type="text" id="searchInput" class="form-search" placeholder="Busca por Nombre/Apellido" aria-label="Buscar" aria-describedby="basic-addon1">
                <button class="btn btn-search" type="button">Buscar</button>  
                <div class="newUser">
            <button id="anyadirEmpleado" class="btn btn-newUser" type="submit">Agregar Usuario</button>
        </div>
            </div>
        </div>
        <!-- Tercera fila: Tabla -->
        <div class="form-row formulario-seccion">
            <div class="col mr-0">
                <div class="table-responsive">
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
                            <?php foreach ($emp->mostrarEmpleados($_SESSION['page']) as $empleado) : ?>
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
                </div>

                <!-- Sección de paginación -->
                <div class="pagination-section">
                    <button id="prevPage" class="btn btn-left"
                    onclick="window.location='<?php echo APP_URL; ?>empleados?pagina=<?php echo  $_SESSION['page'] == 1 ? 1 : $_SESSION['page'] - 1; ?>'">
                    <i class="fas fa-arrow-left"></i></button>
                    <?php 
                    for ($i = 1; $i<=$total_paginas;$i++){ ?>
                        <button class="btn <?php if ($i == $_SESSION['page'] ) echo 'page-selected'; else echo 'page-number' ?> " onclick="window.location='<?php echo APP_URL; ?>empleados?pagina=<?php echo  $i; ?>'">
                        <?php echo $i; ?></button>
                    <?php } ?>
                    <button id="nextPage" class="btn btn-right" 
                        onclick="window.location='<?php echo APP_URL; ?>empleados?pagina=<?php echo  $_SESSION['page'] + 1; ?>'">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Recuadro informativo y Logo -->
        <!-- <div class="form-row formulario-seccion recuadroInfo">
            <div class="col-9">
                <div class="alert alert-info" role="alert">
                    <p>En esta página puedes: registrar, modificar los datos o dar de baja a un empleado.</p>
                    <p class="ayuda-info">Ayuda</p>
                </div>
            </div>
            <div class="col-3">
                <img src="<?php echo APP_URL; ?>app/views/img/Logo CheckInSight.png" class="img-logo" alt="Logo" />
            </div>
        </div> -->

        
    </div>
</div>

<script>
    // Script para activar la funcionalidad de ordenamiento en las columnas de la tabla
    document.addEventListener("DOMContentLoaded", function() {
        const table = document.getElementById("employeesTable");
        const headers = table.querySelectorAll("thead th.sortable");
        headers.forEach(header => {
            header.addEventListener("click", () => {
                const column = parseInt(header.dataset.column);
                const type = header.dataset.type;
                const order = header.dataset.order;

                const rows = Array.from(table.querySelectorAll("tbody tr"));
                const sortedRows = rows.sort((a, b) => {
                    const aValue = type === "string" ? a.cells[column].textContent.trim().toLowerCase() : parseFloat(a.cells[column].textContent.trim());
                    const bValue = type === "string" ? b.cells[column].textContent.trim().toLowerCase() : parseFloat(b.cells[column].textContent.trim());

                    if (order === "asc") {
                        return aValue > bValue ? 1 : -1;
                    } else {
                        return aValue < bValue ? 1 : -1;
                    }
                });

                table.querySelector("tbody").innerHTML = "";
                sortedRows.forEach(row => {
                    table.querySelector("tbody").appendChild(row);
                });

                headers.forEach(header => {
                    header.dataset.order = "";
                    header.innerHTML = header.innerHTML.replace(" ▼", "").replace(" ▲", "");
                });

                header.dataset.order = order === "asc" ? "desc" : "asc";
                header.innerHTML += order === "asc" ? " ▼" : " ▲";

                // Oculta los iconos de filtro en todas las columnas
                table.querySelectorAll("thead th i.bi-funnel").forEach(icon => {
                    icon.style.visibility = "visible";
                });

                // Muestra el icono de filtro solo en la columna actual
                header.querySelector("i.bi-funnel").style.visibility = "hidden";
            });
        });
    });
</script>

