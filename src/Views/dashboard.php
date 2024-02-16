<?php
// Aquí podrías incluir archivos necesarios o iniciar la sesión
// include 'VisitaController.php';
// $controlador = new VisitaController();
// $visitas = $controlador->listarVisitas();

// Simulación de datos obtenidos, reemplazar por llamadas reales a la base de datos
$visitas = [
    ['visitanteId' => 1, 'fechaEntrada' => '2024-02-15 09:00', 'fechaSalida' => '2024-02-15 10:00', 'motivo' => 'Reunión de trabajo'],
    ['visitanteId' => 2, 'fechaEntrada' => '2024-02-16 11:00', 'fechaSalida' => '2024-02-16 12:00', 'motivo' => 'Entrevista']
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Gestión de Visitas</title>
    <link rel="stylesheet" href="path/to/your/css"> <!-- Asegúrate de incluir tu archivo CSS aquí -->
</head>
<body>
    <h1>Dashboard de Gestión de Visitas</h1>
    <div class="visitas-lista">
        <h2>Visitas Recientes</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Visitante</th>
                    <th>Fecha Entrada</th>
                    <th>Fecha Salida</th>
                    <th>Motivo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($visitas as $visita): ?>
                <tr>
                    <td><?php echo htmlspecialchars($visita['visitanteId']); ?></td>
                    <td><?php echo htmlspecialchars($visita['fechaEntrada']); ?></td>
                    <td><?php echo htmlspecialchars($visita['fechaSalida']); ?></td>
                    <td><?php echo htmlspecialchars($visita['motivo']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- Aquí puedes agregar más secciones o funcionalidades según sea necesario -->
</body>
</html>
