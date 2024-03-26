<?php

use app\controllers\empleadoController;
use app\controllers\globalController;
use app\controllers\RolesyPermisosController;

$emp = new empleadoController();
$global = new globalController();
$perm_rol = new RolesyPermisosController();

//Mostrar los permisos que tiene el usuario
$permisos = $perm_rol->mostrarPermisosPorRol($_SESSION['user_rol']);
$nombrePermisosActuales = array_column($permisos, 'nombre_permiso');
$registrar = array_search('Registrar empleados',$nombrePermisosActuales);

// Obtener el número total de empleados de la BBDD
$total_empleados = $emp->getTotalEmpleados();

// Obtener la cantidad de páginas necesarias para mostrar todos los datos
$total_paginas = ceil($total_empleados / FILAS_TABLA);

// Obtener la página que vamos a mostrar en la tabla
$page = $global->getid("pagina");
$filtro = $global->getid("filtro");
$_SESSION['page'] = isset($page) ? $page : 1;
$_SESSION['filtro'] = isset($filtro) ? $filtro : '';

?>
<div class="col-md-10">
    <div class="rounded-box d-flex flex-column justify-content-center">
        <!-- Primera Fila: Título -->
        <h2>Lista de empleados</h2>
        <!-- Segunda fila: Input de búsqueda -->
        <div class="form-row formulario-seccion">
            <div class="input-group d-flex justify-content-between align-items-center mx-2">                
                <input type="text" name="searchInput" id="searchInput" class="form-search" placeholder="Busca por Nombre/Apellido" aria-label="Buscar" aria-describedby="basic-addon1"
                value="<?php echo $_SESSION['filtro'] ?>" 
                >
                <div class="newUser">
                    <button id="anyadirEmpleado" class="btn btn-newUser" onclick="window.location='<?php echo APP_URL; ?>empleadosCRUD'"
                    <?php echo !$registrar ? 'style="display: none;" disabled' : ''; ?>
                    >Agregar Usuario</button>
                </div>
            </div>
        </div>
        <!-- Tercera fila: Tabla -->
        <div class="form-row formulario-seccion">
            <div class="col mr-0">
                <div class="table-responsive">
                    <div id="employeesGrid"> <!-- Aquí se mostrará la tabla de empleados -->
                        <?php include('./app/views/content/empleadosSearch-view.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    (function($) {
    $(document).ready(function(){
        $('input[name="searchInput"]').on('keyup', function(){
            var nombre = $(this).val().trim();
            if (nombre != ''){

                $.ajax({
                type: "POST",
                url: 'empleadosSearch', // Cambia esto al archivo PHP que maneja la búsqueda
                data: { nombre: nombre },
                success: function(response) {
                    // Actualiza la tabla con los resultados de la búsqueda
                    $('#employeesGrid').html(response);
                }
                });
            } else {
                location.href="empleados";
            }
            
        });
        });
    })(jQuery);
</script>
