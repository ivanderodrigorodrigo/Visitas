<?php 
    use app\controllers\empleadoController;
    use app\controllers\SeguridadController;
    use app\controllers\globalController;
    use app\controllers\RolesyPermisosController;

    $emp = new empleadoController();
    $seg = new SeguridadController();
    $global = new globalController();
    $perm_rol = new RolesyPermisosController();

    //Mostrar los permisos que tiene el usuario
    $permisos = $perm_rol->mostrarPermisosPorRol($_SESSION['user_rol']);
    $nombrePermisosActuales = array_column($permisos, 'nombre_permiso');
    $editar = array_search('Edicion Empleados',$nombrePermisosActuales);
    $eliminar = array_search('Eliminar empleados',$nombrePermisosActuales);

    $details = false;
    $empleado = null;

    $id_emp = $global->getid("id_emp");
    if (isset($id_emp)){
        $empleado = $emp->mostrarEmpleado($id_emp);
        $details = true;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['action']) && $_POST['action'] == 'Baja_empleado'){
            echo $_POST['action'];
            $emp->eliminarEmpleado($_POST['id_emp']);
        }elseif (isset($_POST['action']) && $_POST['action'] == 'Actualizar_empleado'){
            $emp->modificarEmpleado();
        }elseif (isset($_POST['action']) && $_POST['action'] == 'Registrar_empleado'){
            $emp->insertarEmpleado();
        }
    }



?>

<form class="col-md-10" id="formulario" method="post" action="">
    <div class="rounded-box d-flex flex-column justify-content-center">
    <!-- Título -->
    <h2><?php echo $details ? 'Editar Empleado' : 'Registrar Nuevo Empleado'; ?></h2>
    <!-- Número de empleado por si se debe modificar. -->
    <div class="formulario-seccion">
        <input
        type="text"
        id="id_emp"
        name="id_emp"
        class="form-control"
        type="hidden"
        placeholder="Número de empleado"
        value="<?php echo $details ? $empleado['id_emp'] : ''; ?>"
        style="display: none;"
        <?php echo $details ? 'readonly' : ''; ?>
        />
    </div>
    <input type="hidden" id="action" name="action" value="" style="display: none;">
    <!-- Nombre y DNI -->
    <div class="form-row formulario-seccion">
        <div class="col">
        <label for="nombre_emp">Nombre</label>
        <input
            type="text"
            id="nombre_emp"
            name="nombre_emp"
            class="form-control"
            placeholder="Nombre"
            value="<?php echo $details ? $empleado['nombre_emp'] : ''; ?>"
            <?php echo $details ? 'readonly' : ''; ?>
            required
        />
        </div>
        <div class="col mr-0">
        <label for="dni_emp">DNI</label>
        <input
            type="text"
            id="dni_emp"
            name="dni_emp"
            class="form-control"
            placeholder="DNI"
            value="<?php echo $details ? $empleado['dni_emp'] : ''; ?>"
            <?php echo $details ? 'readonly' : ''; ?>
            required
        />
        </div>
    </div>
    <!-- Apellidos -->
    <div class="formulario-seccion">
        <label for="apellido_emp">Apellidos</label>
        <input
        type="text"
        id="apellido_emp"
        name="apellido_emp"
        class="form-control"
        placeholder="Apellidos"
        value="<?php echo $details ? $empleado['apellido_emp'] : ''; ?>"
        <?php echo $details ? 'readonly' : ''; ?>
        />
    </div>
    <!-- Correo -->
    <div class="formulario-seccion">
        <label for="email_emp">Correo electrónico</label>
        <input
        type="email"
        id="email_emp"
        name="email_emp"
        class="form-control"
        placeholder="Correo electrónico"
        value="<?php echo $details ? $empleado['email_emp'] : ''; ?>"
        <?php echo $details ? 'readonly' : ''; ?>
        required
        />
    </div>
    <!-- Desplegables -->
    <div class="form-row formulario-seccion">
        <div class="col">
            <label for="rol_emp">Rol</label>
            <select id="rol_emp" name="rol_emp" class="form-control" <?php echo $details ? 'disabled' : ''; ?>>
                <option value=""></option>
                <?php foreach ($seg->mostrarRoles() as $tipo) : ?>
                    <option value="<?php echo $tipo['id_rol']; ?>" <?php echo ($details && $tipo['id_rol'] == $empleado['rol_id']) ? 'selected' : ''; ?>>
                        <?php echo $tipo['nombre_rol']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col mr-0">
            <label for="activo_emp">Estado</label>
            <input
            type="text"
            id="activo_emp"
            name="activo_emp"
            class="form-control"
            value="<?php echo $details ? ($empleado['activo_emp'] == 'S' ? 'Usuario activo' : 'Usuario dado de baja') : ''; ?>"
            readonly
            />
        </div>
    </div>

    <!-- Botones -->
    <div class="form-row botones formulario-seccion">
    <div class="col">
    <div style="display: flex; justify-content: space-between;">
        <div>
            <?php if (!$details) : ?>
                <button type="submit" id="btn_registrar" class="btn btn-accept" <?php echo $details ? 'disabled' : ''; ?>>Registrar</button>
            <?php endif; ?>
            <?php if (($details)) : ?>
                <button type="button" id="btn_edicion" class="btn btn-modify" <?php echo !$editar ? 'style="display: none;"' : ''; ?>
                 onclick="activarEdicion();">Editar</button>
                <button type="submit" id="btn_save" class="btn btn-accept" style="display: none;" disabled>Guardar</button>
            <?php endif; ?>
        </div>
        
        <div>
            <button type="button" class="btn btn-cancel" onclick="goBack('Empleados')">Volver</button>
            <?php if (($details)) : ?>
                <button type="submit" id="btn_baja" class="btn btn-delete"
                <?php echo !$eliminar ? 'style="display: none;"' : ''; ?>
                >Dar de baja</button>
            <?php endif; ?>
            
        </div>
    </div>
</div>
    </div>
    <!-- Recuadro informativo y Logo -->
    <div class="form-row formulario-seccion recuadroInfo">
        <div class="col-9">
        <div class="alert alert-info" role="alert">
            <p>
            En esta página puedes: registrar, modificar los datos o dar
            de baja a un empleado.
            </p>
            <p class="ayuda-info">Ayuda</p>
        </div>
        </div>
        <div class="col-3">
        <img
            src="<?php echo APP_URL; ?>app/views/img/Logo CheckInSight.png"
            class="img-logo"
            alt="Logo"
        />
        </div>
    </div>
    </div>
</form>

<script>

    const btnbaja = document.getElementById('btn_baja');
    const btn_save = document.getElementById('btn_save');
    const btn_registrar = document.getElementById('btn_registrar');
    if (btnbaja) {
        btnbaja.addEventListener('click', (e) => {
            e.preventDefault()

            var action = document.getElementById('action');
            action.value = 'Baja_empleado';

            document.getElementById('formulario').submit()

        })
    }

    if (btn_save) {
        btn_save.addEventListener('click', (e) => {
        e.preventDefault()

        var action = document.getElementById('action');
        action.value = 'Actualizar_empleado';

        document.getElementById('formulario').submit()

    })
    }

    if (btn_registrar) {
        btn_registrar.addEventListener('click', (e) => {
        e.preventDefault()

        var action = document.getElementById('action');
        action.value = 'Registrar_empleado';

        document.getElementById('formulario').submit()

    })
    }

    function activarEdicion() { 
        
        var inputDNI = document.getElementById('dni_emp');
        var inputNombre = document.getElementById('nombre_emp');
        var inputApellidos = document.getElementById('apellido_emp');
        var inputEmail = document.getElementById('email_emp');
        var inputRol = document.getElementById('rol_emp');
        var btn_edicion = document.getElementById('btn_edicion');
        var btn_save = document.getElementById('btn_save');

        inputDNI.removeAttribute("readonly");
        inputNombre.removeAttribute("readonly");
        inputApellidos.removeAttribute("readonly");
        inputEmail.removeAttribute("readonly");
        inputRol.removeAttribute("disabled");
        btn_save.removeAttribute("disabled");
        btn_save.style.display = 'inline-block';
        btn_edicion.setAttribute('disabled','');
        btn_edicion.style.display = 'none';
        
    }


</script>