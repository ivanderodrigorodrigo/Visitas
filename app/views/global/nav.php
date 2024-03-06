
<?php
use app\controllers\viewsController;
$viewsController2 = new viewsController();
?>

<nav class="col-md-2 menu-lateral d-flex flex-column">  
    <!-- Primer listado -->
    <ul class="menu-seccion primerMenu">
    <?php foreach($viewsController->obtenerNavsControlador($_SESSION['user_rol']) as $nav): ?>
        <li>
            <i class="fas <?= $nav['iconos'] ?>"></i>
            <?php
            if ($nav['url_principal'] == $_SESSION['view_current']): ?>
                <a class="" style=" color:black; font-weight: bold; text-decoration: none;"  <?php if (!isset($nav['nav_secundaria'])) : ?> href=" <?php echo APP_URL . $nav['url_principal'] ?>" <?php endif; ?>  onclick="activarSubMenu('submenu<?= $nav['id'] ?>')"> <?= $nav['nav_principal'] ?></a>
            <?php else: ?>
                <a class="" style="text-decoration: none; color:black; cursor:pointer;"  <?php if (!isset($nav['nav_secundaria'])) : ?> href=" <?php echo APP_URL . $nav['url_principal'] ?>" <?php endif; ?>  onclick="activarSubMenu('submenu<?= $nav['id'] ?>')"> <?= $nav['nav_principal'] ?></a>
            <?php endif; ?>
            <?php if (isset($nav['nav_secundaria'])): ?>
                <i id="m-dropdown" class="fas fa-angle-down"></i>
                <ul id="submenu<?= $nav['id'] ?>" class="submenu-seccion" style="display: none;">
                    <?php foreach($viewsController2->obtenerSubNavsControlador($nav['nav_secundaria']) as $subnav): ?>
                        <li>
                            <a class="" style="text-decoration: none; color:black" href="<?php echo APP_URL . $subnav['url_modulo']?>"><?= $subnav['nombre_modulo'] ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
    </ul>

    <!-- Segundo listado -->
    <ul class="menu-seccion mt-auto">
        <li><i class="fas fa-question-circle"></i>Ayuda</li>
        <li><i class="fas fa-sign-out-alt"> 
            <a class="" style="text-decoration: none; color:black; cursor:pointer;" onclick=" logout() ">Log-out</a>
         </i></li>  
        <li>Presential SL</li>
        <li>CheckinSign</li>
    </ul>
</nav>

<script>
    function logout() {
        window.location.href = 'logout';
    }
</script>

