<?php
// Incluir archivo de configuración de la base de datos o código de conexión aquí
// Asumiendo que ya tienes un archivo de configuración o conexión PDO
// Por ejemplo, incluyendo un archivo con una variable $pdo para la conexión PDO
// include 'configuracionBaseDatos.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar y validar los datos de entrada
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $fechaEntrada = filter_input(INPUT_POST, 'fechaEntrada', FILTER_SANITIZE_STRING);
    $fechaSalida = filter_input(INPUT_POST, 'fechaSalida', FILTER_SANITIZE_STRING);
    $motivo = filter_input(INPUT_POST, 'motivo', FILTER_SANITIZE_STRING);

    // Llamar a la función para guardar los datos en la base de datos
    if (guardarVisita($nombre, $fechaEntrada, $fechaSalida, $motivo)) {
        echo "Visita registrada con éxito.";
    } else {
        echo "Error al registrar la visita.";
    }
}

/**
 * Guarda los detalles de la visita en la base de datos.
 *
 * @param string $nombre Nombre del visitante.
 * @param string $fechaEntrada Fecha y hora de entrada.
 * @param string $fechaSalida Fecha y hora de salida.
 * @param string $motivo Motivo de la visita.
 * @return bool Retorna true si la operación fue exitosa, de lo contrario false.
 */
function guardarVisita($nombre, $fechaEntrada, $fechaSalida, $motivo) {
    global $pdo; // Asegúrate de que esta variable contiene tu conexión PDO

    $sql = "INSERT INTO visitas (nombre, fecha_entrada, fecha_salida, motivo) VALUES (:nombre, :fechaEntrada, :fechaSalida, :motivo)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':fechaEntrada', $fechaEntrada);
    $stmt->bindParam(':fechaSalida', $fechaSalida);
    $stmt->bindParam(':motivo', $motivo);

    return $stmt->execute();
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
