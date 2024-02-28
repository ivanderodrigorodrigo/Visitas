<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Asumiendo que tienes una función para conectar y guardar en la base de datos.
    // Aquí deberías sanear y validar los datos de entrada antes de guardarlos.
    $nombre = $_POST['nombre'];
    $fechaEntrada = $_POST['fechaEntrada'];
    $fechaSalida = $_POST['fechaSalida'];
    $motivo = $_POST['motivo'];

    // Aquí iría la lógica para guardar los datos en la base de datos.
    // Por ejemplo: guardarVisita($nombre, $fechaEntrada, $fechaSalida, $motivo);

    echo "Visita registrada con éxito."; // Mensaje simple por ahora
    // En una aplicación real, podrías redirigir al usuario o mostrar un mensaje de éxito más elaborado.
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Visita</title>
</head>
<body>
    <h2>Registrar Nueva Visita</h2>
    <form method="post" action="registro_visita.php">
        <label for="nombre">Nombre del Visitante:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="fechaEntrada">Fecha y Hora de Entrada:</label>
        <input type="datetime-local" id="fechaEntrada" name="fechaEntrada" required><br><br>

        <label for="fechaSalida">Fecha y Hora de Salida:</label>
        <input type="datetime-local" id="fechaSalida" name="fechaSalida"><br><br>

        <label for="motivo">Motivo de la Visita:</label>
        <textarea id="motivo" name="motivo" required></textarea><br><br>

        <button type="submit">Registrar Visita</button>
    </form>
</body>
</html>
