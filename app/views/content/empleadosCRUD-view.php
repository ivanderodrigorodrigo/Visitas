<?php 
    use app\controllers\empleadoController;
    use app\controllers\SeguridadController;
    use app\controllers\globalController;

    $emp = new empleadoController();
    $seg = new SeguridadController();
    $global = new globalController();

    $details = false;
    $empleado = null;

    $id_emp = $global->getid("id_emp");
    if (isset($id_emp)){
        $empleado = $emp->mostrarEmpleado($id_emp);
        $details = true;
    }

?>

<form class="col-md-10" method="post" action="<?php echo  $details ? $emp->modificarEmpleado() : $emp->insertarEmpleado(); ?> ">
    <div class="rounded-box d-flex flex-column justify-content-center">
    <!-- Título -->
    <div class="formulario-seccion">
        <h2 class="tituloEmpleados"><?php echo $details ? 'Editar Empleado' : 'Registrar Nuevo Empleado'; ?></h2>
    </div>
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
    <input type="hidden" id="activo_emp" name="activo_emp" value="S" style="display: none;">
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
            <label for="estado_emp">Estado</label>
            <select id="estado_emp" name="estado_emp" class="form-control" <?php echo $details ? 'disabled' : ''; ?>>
                <option value=""></option>
                <?php foreach ($emp->getEstados() as $estado) : ?>
                    <option value="<?php echo $estado['id_estado']; ?>" <?php echo ($details && $estado['id_estado'] == $empleado['estado_id']) ? 'selected' : ''; ?>>
                        <?php echo $estado['nombre_estado']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <!-- Botones -->
    <div class="form-row botones formulario-seccion">
    <div class="col">
    <div style="display: flex; justify-content: space-between;">
        <div>
            <?php if (!$details) : ?>
                <button type="submit" class="btn btn-accept" <?php echo $details ? 'disabled' : ''; ?>>Registrar</button>
            <?php endif; ?>
            <?php if (($details)) : ?>
                <button type="button" id="btn_edicion" class="btn btn-modify" onclick="activarEdicion();">Editar</button>
                <button type="submit" id="btn_save" class="btn btn-accept" style="display: none;" disabled>Guardar</button>
            <?php endif; ?>
        </div>
        
        <div>
            <button type="button" class="btn btn-cancel" onclick="goBack()">Cancelar</button>
            <button type="submit" onclick="eliminar()" class="btn btn-delete" >Eliminar</button>
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
    function activarEdicion() { 
        
        var inputDNI = document.getElementById('dni_emp');
        var inputNombre = document.getElementById('nombre_emp');
        var inputApellidos = document.getElementById('apellido_emp');
        var inputEmail = document.getElementById('email_emp');
        var inputRol = document.getElementById('rol_emp');
        var inputEstado = document.getElementById('estado_emp');
        var btn_edicion = document.getElementById('btn_edicion');
        var btn_save = document.getElementById('btn_save');

        inputDNI.removeAttribute("readonly");
        inputNombre.removeAttribute("readonly");
        inputApellidos.removeAttribute("readonly");
        inputEmail.removeAttribute("readonly");
        inputRol.removeAttribute("disabled");
        inputEstado.removeAttribute("disabled");
        btn_save.removeAttribute("disabled");
        btn_save.style.display = 'inline-block';
        btn_edicion.setAttribute('disabled','');
        btn_edicion.style.display = 'none';
        
    }

    function eliminar(){
        var action = document.getElementById('activo_emp');
        action.value = 'N';
        activarEdicion();
    }



</script>