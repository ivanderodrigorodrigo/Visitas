<?php
use app\controllers\VisitanteController;

$controller = new app\controllers\VisitanteController();

$accion = $_POST['accion'] ?? ''; // Uso del operador de fusión null para evitar undefined index
$idVisitante = $_POST['id_visitante'] ?? ''; // Obtener id de visitante si está definido
$fechaVisitaPost = $_POST['fecha_visita'] ?? null; // Asignar null por defecto si no está definido

if ($_SERVER["REQUEST_METHOD"] == "POST" && $accion) {
    if ($accion === 'crear' && $fechaVisitaPost) {
        $fechaHoraVisita = date('Y-m-d H:i:s', strtotime($fechaVisitaPost));
        $datosVisitante = [
            'dni_visitante' => $_POST['dni_visitante'],
            'nombre_visitante' => $_POST['nombre_visitante'],
            'apellido_visitante' => $_POST['apellido_visitante'],
            'email_visitante' => $_POST['email_visitante'],
            'empresa_visitante' => $_POST['empresa_visitante'],
            'fecha_visita' => $fechaHoraVisita,
        ];
        $controller->guardar($datosVisitante);
        // Redireccionar inmediatamente después de procesar el POST para evitar el output antes de header()
        header("Location: {$_SERVER['REQUEST_URI']}");
        exit();
    } elseif ($accion === 'eliminar' && $idVisitante) {
        $controller->eliminar($idVisitante);
        header("Location: {$_SERVER['REQUEST_URI']}");
        exit();
    }
}

// La lógica que genera el output HTML empieza aquí
$visitantes = [];
$busqueda = $_GET['busqueda'] ?? '';
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$totalPaginas = 1; // Define un valor predeterminado para totalPaginas

if (!empty($busqueda)) {
    $visitantes = $controller->buscar($busqueda);
    // Opcional: Aquí podrías calcular el total de páginas basado en el conteo de resultados de búsqueda, si fuera aplicable.
} else {
    $datosPaginados = $controller->listarConPaginacion($paginaActual, 5);
    $visitantes = $datosPaginados['visitantes'];
    $totalPaginas = $datosPaginados['totalPaginas']; // Este valor ya se define en el caso de listar todos los visitantes.
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Visitantes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .rounded-box {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            margin: 20px auto;
            width: 80%;
        }
        .form-inline {
            display: flex;
            flex-flow: row wrap;
            align-items: center;
            justify-content: space-between;
        }
        .form-inline input[type="text"],
        .form-inline input[type="email"],
        .form-inline input[type="datetime-local"] {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-inline button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-inline button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
<div class="rounded-box">
    <h2>Registrar Nuevo Visitante</h2>
    <form method="post" action="" class="form-inline">
        <input type="text" name="dni_visitante" placeholder="DNI" required>
        <input type="text" name="nombre_visitante" placeholder="Nombre" required>
        <input type="text" name="apellido_visitante" placeholder="Apellido" required>
        <input type="email" name="email_visitante" placeholder="Email" required>
        <input type="text" name="empresa_visitante" placeholder="Empresa">
        <input type="datetime-local" name="fecha_visita" placeholder="Fecha de Visita" required>
        <input type="hidden" name="accion" value="crear">
        <button type="submit">Guardar Visitante</button>
    </form>

    <h2>Buscar Visitantes</h2>
    <form method="get" action="" class="form-inline">
        <input type="text" name="busqueda" placeholder="Buscar..." value="<?= htmlspecialchars($busqueda ?? '') ?>">
        <button type="submit">Buscar</button>
    </form>

    
   

    <h2>Listado de Visitantes</h2>
    <table>
        <thead>
            <tr>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Empresa</th>
                <th>Fecha de Visita</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($visitantes as $visitante): ?>
            <tr>
                <td><?= htmlspecialchars($visitante['dni_visitante']) ?></td>
                <td><?= htmlspecialchars($visitante['nombre_visitante']) ?></td>
                <td><?= htmlspecialchars($visitante['apellido_visitante']) ?></td>
                <td><?= htmlspecialchars($visitante['email_visitante']) ?></td>
                <td><?= htmlspecialchars($visitante['empresa_visitante']) ?></td>
                <td><?= htmlspecialchars($visitante['fecha_visita']) ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="accion" value="eliminar">
                        <input type="hidden" name="id_visitante" value="<?= $visitante['id_visitante'] ?>">
                        <button type="submit" class="btn-delete">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- Paginación -->
    <nav aria-label="Paginación de visitantes">
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?= $i == $paginaActual ? 'active' : '' ?>">
                    <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    
   
</div>

</body>
</html>
