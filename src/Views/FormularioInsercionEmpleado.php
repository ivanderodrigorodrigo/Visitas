<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Inserción de Empleado</title>
    <link rel="stylesheet" href="./public/css/style.css">
</head>
<body>
    <h1>Formulario de Inserción de Empleado</h1>
    <form action="index.php?ruta=insertar-empleado" method="POST">
        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" required><br>
        
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>
        
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        
        <label for="contrasenya">Contraseña:</label>
        <input type="password" id="contrasenya" name="contrasenya" required><br>
        
        <label for="rol_id">ID de Rol:</label>
        <input type="number" id="rol_id" name="rol_id" required><br>
        
        <label for="activo_emp">Activo:</label>
        <select id="activo_emp" name="activo_emp" required>
            <option value="S">Sí</option>
            <option value="N">No</option>
        </select><br>

        <button type="submit">Insertar Empleado</button>
    </form>
</body>
</html>

