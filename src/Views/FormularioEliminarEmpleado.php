<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Empleado</title>
    <link rel="stylesheet" href="./public/css/style.css"> <!-- Enlaza tu archivo de estilos CSS -->
</head>
<body>
    <h1>Eliminar Empleado</h1>
    <form action="index.php" method="GET">
        <input type="hidden" name="ruta" value="eliminar-empleado">
        <label for="id_emp">ID del Empleado:</label>
        <input type="number" id="id_emp" name="id" required><br><br>
        <button type="submit">Eliminar Empleado</button>
    </form>
</body>
</html>






