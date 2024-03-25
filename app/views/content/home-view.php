<?php
use app\controllers\viewsController;
$viewsController2 = new viewsController();
$viewsController3 = new viewsController();
?>
<div class="col-md-10">
    <div class="rounded-box d-flex flex-column justify-content-center aling-items-center w-100 p-0">
        <div class="d-flex justify-content-around aling-items-center">
        <?php foreach($viewsController2->obtenerNavsControlador($_SESSION['user_rol']) as $nav): ?>
            <div id="" class="nav_home d-flex justify-content-center aling-items-center w-100">
                <a class="d-flex justify-content-center aling-items-center w-100" style="font-weight: bold; text-decoration: none;"  
                    <?php if (!isset($nav['nav_secundaria'])) { ?> href=" <?php echo APP_URL . $nav['url_principal'] ?>" 
                        <?php } else { foreach($viewsController3->obtenerSubNavsControlador($nav['nav_secundaria']) as $subnav):?>
                            href=" <?php echo APP_URL . $subnav['url_modulo'] ?>" 
                        <?php break; endforeach;  } ?>> 
                        <i class="d-flex justify-content-center aling-items-center fas <?= $nav['iconos'] ?>"></i> <?= $nav['nav_principal'] ?> 
                </a>
            </div>
        <?php endforeach; ?>
                      
        </div>

        <div class="imagen_home"  style="background-image: url('<?php echo APP_URL; ?>app/views/img/fondo_home.png');"></div>
        </div>
    </div>
</div>