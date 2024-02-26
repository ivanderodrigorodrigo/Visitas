<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Edición de Empleado</title>
    <link rel="stylesheet" href="./public/css/style.css">
</head>
<body>
    <h1>Formulario de Edición de Empleado</h1>
    <form action="index.php?ruta=modificar-empleado&id=<?= $id_emp ?>" method="POST"> <!-- Modificado el atributo action -->
        <input type="hidden" name="id_emp" value="<?= $id_emp ?>">
        
        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" value="<?= $empleado['dni_emp'] ?>" required><br>
        
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?= $empleado['nombre_emp'] ?>" required><br>
        
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" value="<?= $empleado['apellido_emp'] ?>" required><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= $empleado['email_emp'] ?>" required><br>
        
        <label for="contrasenya">Contraseña:</label>
        <input type="password" id="contrasenya" name="contrasenya" required><br>
        
        <label for="rol_id">ID de Rol:</label>
        <input type="number" id="rol_id" name="rol_id" value="<?= $empleado['rol_id'] ?>" required><br>
        
        <label for="activo_emp">Activo:</label>
        <select id="activo_emp" name="activo_emp" required>
            <option value="S" <?php if ($empleado['activo_emp'] == 'S') echo 'selected'; ?>>Sí</option>
            <option value="N" <?php if ($empleado['activo_emp'] == 'N') echo 'selected'; ?>>No</option>
        </select><br>

        <button type="submit">Actualizar Empleado</button>
    </form>
</body>
</html>

