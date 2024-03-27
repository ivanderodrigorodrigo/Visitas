<?php

use app\controllers\VisitanteController;

$controller = new app\controllers\VisitanteController();

$accion = $_POST['accion'] ?? ''; // Uso del operador de fusión null para evitar undefined index
$idVisitante = $_POST['id_visitante'] ?? ''; // Obtener id de visitante si está definido
$fechaVisitaPost = $_POST['fecha_visita'] ?? null; // Asignar null por defecto si no está definido
// Obtiene la lista de empleados para el formulario
$empleados = $controller->obtenerEmpleados();


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
            'id_emp_visita' => $_POST['id_emp_visita'], // Asegúrate de recoger este valor
            'id_motivo_visita' => $_POST['id_motivo_visita'], // y este también
        ];
        $controller->guardar($datosVisitante);
        header("Location: {$_SERVER['REQUEST_URI']}");
        exit();
    
    } elseif ($accion === 'eliminar' && $idVisitante) {
        $controller->eliminar($idVisitante);
        header("Location: {$_SERVER['REQUEST_URI']}");
        exit();
    }
}



// Recuperación y saneamiento de parámetros de búsqueda, ordenamiento y paginación
$busqueda = $_GET['busqueda'] ?? '';
$ordenarPor = $_GET['ordenarPor'] ?? 'fecha_visita';
$direccion = $_GET['direccion'] ?? 'ASC';
$paginaActual = $_GET['pagina'] ?? 1;

// Unificar la obtención de datos para soportar búsqueda, paginación y ordenamiento
$datosPaginados = $controller->listarConPaginacion($paginaActual, 5, $ordenarPor, $direccion, $busqueda);
$visitantes = $datosPaginados['visitantes'];
$totalPaginas = $datosPaginados['totalPaginas'];


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
        .form-inline input[type="datetime-local"],
        .form-inline select,
        .form-inline button {
            flex-grow: 1; /* Esto permite que los elementos se expandan */
            margin: 10px; /* Ajusta el margen para controlar el espaciado */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            /* Ajuste el ancho mínimo para garantizar que los elementos no se vuelvan demasiado pequeños */
            min-width: 120px;
        }

        /* Opcional: ajuste para asegurar que el botón no crezca desproporcionadamente en comparación con los inputs */
        .form-inline button {
            background-color: #0b5394;
            color: white;
            flex-grow: 0; /* Esto previene que el botón se expanda */
            flex-shrink: 0; /* Esto previene que el botón se encoja */
            flex-basis: auto; /* Ajusta la base de flexión según el contenido del botón */
        }

       
       
        
        .form-inline button:hover {
            color: #083c61;
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
        
        .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        justify-content: center; /* Asegura que la paginación esté centrada */
    }
        .page-link {
        background-color: #0b5394;
        color: white;
        border: none;
        padding: 12px 20px; /* Hacerlos un poco más grandes */
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none; /* Para los enlaces de paginación */
        margin: 0 5px; /* Espaciado entre botones de paginación */
        }

        .page-link:hover {
        background-color: white;
        color: #0b5394;
        border: 1px solid #0b5394;
        }

    </style>
</head>
<body>
<?php if (isset($_SESSION['error'])): ?>
<script>
    window.onload = function() {
        // Crea una ventana modal/alerta con el mensaje de error
        alert("<?php echo $_SESSION['error']; ?>");
        <?php unset($_SESSION['error']); ?>
    };
</script>
<?php endif; ?>

<div class="rounded-box">
    <h2>Registrar Nuevo Visitante</h2>
    <form method="post" action="" class="form-inline">
        <div class="form-row">
            <input type="text" name="dni_visitante" placeholder="DNI" required>
            <input type="text" name="nombre_visitante" placeholder="Nombre" required>
            <input type="text" name="apellido_visitante" placeholder="Apellido" required>
            <input type="email" name="email_visitante" placeholder="Email" required>
            <input type="text" name="empresa_visitante" placeholder="Empresa">
        </div>
        <div class="">
            <select name="id_emp_visita" required>
                <option value="">Selecciona un empleado</option>
                <?php foreach ($empleados as $empleado): ?>
                    <option value="<?= $empleado['id_emp'] ?>"><?= htmlspecialchars($empleado['nombre_emp']) . ' ' . htmlspecialchars($empleado['apellido_emp']) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="id_motivo_visita" required>
                <option value="">Selecciona un motivo</option>
                <option value="1">Proveedor</option>
                <option value="2">Cliente</option>
                <option value="3">Formación</option>
                <option value="4">Otros</option>
            </select>
            <input type="datetime-local" name="fecha_visita" placeholder="Fecha de Visita" required>
            <button type="submit" class="btn-acc">Guardar Visitante</button>
        </div>
    </form>

   

    
   <!-- Formularios para registrar y buscar visitantes -->

   <h2>Buscar Visitantes</h2>
    <form method="get" action="" class="form-inline">
        <div class="search-wrapper">
            <input type="text" name="busqueda" placeholder="Buscar..." value="<?= htmlspecialchars($busqueda) ?>">
            
            <input type="hidden" name="ordenarPor" value="<?= htmlspecialchars($ordenarPor) ?>">
            <input type="hidden" name="direccion" value="<?= htmlspecialchars($direccion) ?>">
            <button type="submit" class="btn-acc">Buscar</button>
        </div>
        
    </form>

    <h2>Listado de Visitantes</h2>
    <table class="table">
        <thead>
            <tr>
                <th><a href="?ordenarPor=dni_visitante&direccion=<?= $ordenarPor === 'dni_visitante' && $direccion !== 'DESC' ? 'DESC' : 'ASC' ?>&busqueda=<?= htmlspecialchars($busqueda) ?>">DNI</a></th>
                <th><a href="?ordenarPor=nombre_visitante&direccion=<?= $ordenarPor === 'nombre_visitante' && $direccion !== 'DESC' ? 'DESC' : 'ASC' ?>&busqueda=<?= htmlspecialchars($busqueda) ?>">Nombre</a></th>
                <th><a href="?ordenarPor=apellido_visitante&direccion=<?= $ordenarPor === 'apellido_visitante' && $direccion !== 'DESC' ? 'DESC' : 'ASC' ?>&busqueda=<?= htmlspecialchars($busqueda) ?>">Apellido</a></th>
                <th><a href="?ordenarPor=email_visitante&direccion=<?= $ordenarPor === 'email_visitante' && $direccion !== 'DESC' ? 'DESC' : 'ASC' ?>&busqueda=<?= htmlspecialchars($busqueda) ?>">Email</a></th>
                <th><a href="?ordenarPor=empresa_visitante&direccion=<?= $ordenarPor === 'empresa_visitante' && $direccion !== 'DESC' ? 'DESC' : 'ASC' ?>&busqueda=<?= htmlspecialchars($busqueda) ?>">Empresa</a></th>
                <th><a href="?ordenarPor=fecha_visita&direccion=<?= $ordenarPor === 'fecha_visita' && $direccion !== 'DESC' ? 'DESC' : 'ASC' ?>&busqueda=<?= htmlspecialchars($busqueda) ?>">Fecha de Visita</a></th>
                <th><a href="?ordenarPor=nombre_emp&direccion=<?= $ordenarPor === 'nombre_emp' && $direccion !== 'DESC' ? 'DESC' : 'ASC' ?>&busqueda=<?= htmlspecialchars($busqueda) ?>">Empleado Visitado</a></th> <!-- Nueva columna -->
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
                <td><?= htmlspecialchars($visitante['nombre_emp'] . ' ' . $visitante['apellido_emp']) ?></td> <!-- Muestra el nombre del empleado -->
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
                <a class="page-link" href="?pagina=<?= $i ?>&ordenarPor=<?= htmlspecialchars($ordenarPor) ?>&direccion=<?= htmlspecialchars($direccion) ?>&busqueda=<?=                htmlspecialchars($busqueda) ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
</body>
</html>



    
 
