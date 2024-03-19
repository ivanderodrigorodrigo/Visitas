<?php

use app\controllers\RolesyPermisosController;

$controller = new RolesyPermisosController();

// Verificar si se envió el formulario para agregar un nuevo rol o modificar permisos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['accion']) && $_POST['accion'] == 'agregar_rol') {
        // Acción para agregar un nuevo rol
        $nombre_rol = $_POST['nombre_rol'] ?? '';
        $resultado = $controller->insertarRol($nombre_rol);
        header("Location: {$_SERVER['REQUEST_URI']}");
        exit();
    } elseif (isset($_POST['accion']) && $_POST['accion'] == 'modificar_permisos') {
        // Acción para modificar permisos de un rol seleccionado
        $id_rol = $_POST['id_rol'] ?? '';
        $permisos_modificados = $_POST['permisos'] ?? [];
        $resultado = $controller->modificarPermisos($id_rol, $permisos_modificados);
        header("Location: {$_SERVER['REQUEST_URI']}");
        exit();
    }
}

$id_rol_seleccionado = $_POST['id_rol'] ?? '';
$roles = $controller->mostrarRoles();
$permisos = $controller->mostrarPermisos();
$permisosActuales = $id_rol_seleccionado ? $controller->mostrarPermisosPorRol($id_rol_seleccionado) : [];

// Simplificación: Convertir los permisos actuales en un array de IDs para fácil marcado
$idsPermisosActuales = array_column($permisosActuales, 'id_permiso');

?>
<div class="col-md-10">
    <div class="rounded-box d-flex flex-column justify-content-center">
        <h2>Gestión de Roles y Permisos</h2>
        <!-- Sección para añadir un nuevo rol -->
        <div class="mb-4">
            <form method="post" action="">
                <div class="form-group">
                    <label for="nombre_rol">Nombre del Rol:</label>
                    <input type="text" class="form-control" id="nombre_rol" name="nombre_rol" placeholder="Introduce el nombre del nuevo rol" required>
                </div>
                <input type="hidden" name="accion" value="agregar_rol">
                <button type="submit" class="btn btn-primary">Agregar Rol</button>
            </form>
        </div>

        <div class="row">
            <!-- Sección para mostrar y seleccionar roles -->
            <div class="col-md-6">
                <h5>Roles</h5>
                <form method="post" action="">
                    <select name="id_rol" class="form-control" onchange="this.form.submit()">
                        <option value="">Seleccione un Rol</option>
                        <?php foreach ($roles as $rol): ?>
                            <option value="<?= $rol['id_rol'] ?>" <?= $id_rol_seleccionado == $rol['id_rol'] ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($rol['nombre_rol']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="accion" value="cargar_permisos">
                </form>
            </div>

            <!-- Sección para mostrar y modificar permisos del rol seleccionado -->
            <div class="col-md-6">
                <h5>Permisos</h5>
                <?php if (!empty($id_rol_seleccionado)): ?>
                    <form method="post" action="">
                        <?php foreach ($permisos as $permiso): ?>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="permisos[]" value="<?= $permiso['id_permiso'] ?>" <?= in_array($permiso['id_permiso'], $idsPermisosActuales) ? 'checked' : ''; ?> id="permiso_<?= $permiso['id_permiso'] ?>">
                                <label class="form-check-label" for="permiso_<?= $permiso['id_permiso'] ?>"><?= htmlspecialchars($permiso['nombre_permiso']) ?></label>
                            </div>
                        <?php endforeach; ?>
                        <input type="hidden" name="id_rol" value="<?= $id_rol_seleccionado; ?>">
                        <input type="hidden" name="accion" value="modificar_permisos">
                        <button type="submit" class="btn btn-success">Aplicar Cambios</button>
                    </form>
                <?php else: ?>
                    <p>Seleccione un rol para ver o modificar sus permisos.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>