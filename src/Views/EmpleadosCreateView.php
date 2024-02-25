<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de empleados</title>
</head>
<body>
    <h2>Registrar Nuevo Empleado</h2>
    <form method="post" action="Empleadocontroller.php">

        <label for="dni">DNI del empleado:</label>
        <input type="text" id="dni" name="dni" required><br><br>

        <label for="nombre">Nombre del empleado:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="apellido">Apellidos del empleado:</label>
        <input type="text" id="apellido" name="apellido" required><br><br>

        <label for="email">Email del empleado:</label>
        <input type="email" id="email" name="email" required><br><br>

        <button type="submit">Registrar empleado</button>
    </form>
</body>
</html>
