<?php

use app\controllers\empleadoController;

$emp = new empleadoController();
?>
<div class="col-md-10">
    <div class="rounded-box d-flex flex-column justify-content-center">
        <!-- Primera Fila: Título -->
        <div class="formulario-seccion">
            <h2 class="tituloEmpleados">Lista de Empleados</h2>
        </div>
        <!-- Segunda fila: Input de búsqueda -->
        <div class="form-row formulario-seccion">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text form-control" id="basic-addon1"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" id="searchInput" class="form-control" placeholder="Busca por nombre" aria-label="Buscar" aria-describedby="basic-addon1">
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
                            <?php foreach ($emp->mostrarEmpleados() as $empleado) : ?>
                                <tr onclick="window.location='<?php echo APP_URL; ?>empleadosCRUD?id_emp=<?php echo $empleado['id_emp'] ?>'">
                                    <td><?= $empleado['nombre_emp'] ?></td>
                                    <td><?= $empleado['apellido_emp'] ?></td>
                                    <td><?= $empleado['dni_emp'] ?></td>
                                    <td><?= $empleado['nombre_rol'] ?></td>
                                    <td><?= $empleado['nombre_estado'] ?></td>
                                    <td><label class="fas fa-edit" onclick=""></label></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Recuadro informativo y Logo -->
        <div class="form-row formulario-seccion recuadroInfo">
            <div class="col-9">
                <div class="alert alert-info" role="alert">
                    <p>En esta página puedes: registrar, modificar los datos o dar de baja a un empleado.</p>
                    <p class="ayuda-info">Ayuda</p>
                </div>
            </div>
            <div class="col-3">
                <img src="<?php echo APP_URL; ?>app/views/img/Logo CheckInSight.png" class="img-logo" alt="Logo" />
            </div>
        </div>
        <a href="<?php echo APP_URL; ?>empleadosCRUD/">Agregar Nuevo Usuario</a>
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

