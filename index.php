<?php

    require_once "./config/app.php";
    require_once "./autoload.php";

    /*---------- Iniciando sesion ----------*/
    require_once "./app/includes/session_start.php";

    if (isset($_GET['views'])){

        $url=explode("/", $_GET['views']);

        if ($url[0] <> 'changePassword' && !isset($_SESSION['id'])){
            $url=["login"];
        }

    }elseif (!isset($_SESSION['id'])){
        $url=["login"];
    } else {
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
        switch($_SESSION['view_current'])
        {
            //PAGINAS QUE NO UTILIZAN EL HEADER Y NAV
            case "logout":
            case "login":
            case "changePassword":
            case "empleadosSearch":
            case "403":
                require_once $vista;
                break;
            //RESTO DE PAGINAS UTILIZAN EL HEADER Y NAV
            default:

            ?>    
            <main class=" d-flex flex-column">
                <header>
                <?php 
                    require_once "./app/views/global/header.php";
                ?>
                </header>
                <div class="row flex-grow-1">
                <?php 

                    require_once "./app/views/global/nav.php";
                    require_once $vista;
                    break;
                }
                ?>
        </div>
    </main>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>
</html>