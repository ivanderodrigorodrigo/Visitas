<?php

    require_once "./config/app.php";
    require_once "./autoload.php";

    /*---------- Iniciando sesion ----------*/
    require_once "./app/includes/session_start.php";

    if (!isset($_SESSION['id'])){
        $url=["login"];
    } elseif (isset($_GET['views'])){
        $url=explode("/", $_GET['views']);
    }else {
        $url = [""];
    }


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once "./app/views/global/head.php"; ?>
</head>
<body>
    <?php
        use app\controllers\viewsController;
        $viewsController= new viewsController();
        $vista=$viewsController->obtenerVistasControlador($url[0]);
        if($url[0]=="login" || $vista=="404"){
            require_once $vista;
        } elseif ($vista == "logout"){
            require_once "./app/includes/session_close.php";
        }else{
    ?>    
    <main class="container-fluid d-flex flex-column">
        <header>
        <?php 
            require_once "./app/views/global/header.php";
        ?>
        </header>
        <div class="row flex-grow-1">
        <?php 

            require_once "./app/views/global/nav.php";
            require_once $vista;
        }
        ?>

        </div>
    </main>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>
</html>