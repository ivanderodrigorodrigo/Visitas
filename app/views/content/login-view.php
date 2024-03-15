
<?php
use app\includes\authenticate;
$auth = new authenticate();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="body_login">
    
    <div class="login-container">
        <img class="img-logo-login" src="<?php echo APP_URL; ?>app/views/img/Logo CheckInSight.png" alt="Logo" /> <!-- Reemplaza con la ruta a tu logo -->
        <p>Accede a tu aplicación <strong>CheckInSight</strong></p>
     
        <form class="login-form" action="<?php echo  $auth->verificarUser(); ?>" method="post">
            <div class="login-form-seccion">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" placeholder="" required>
            </div>
            <div class="login-form-seccion">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="" required>
            </div>
            
        <!-- Espacio reservado para mensaje de error -->
            <?php if (isset($_SESSION['valid_user']) && $_SESSION['valid_user'] == 0) { ?>
                <div class="error-message d-flex justify-content-center align-items-center">
                    <i class="material-icons mx-2">error</i>
                    <p style="color: red;"> Email de usuario o contraseña incorrectos. </p>            
                </div>
            <?php
            }?>
        <button type="submit">Iniciar Sesión</button>
        </form>
        <a href="#">¿Has olvidado tu contraseña?</a>
    </div>
        
    <a href="http://www.presentialsl.com" class="presential-link" target="_blank">PresentiaL SL</a>
        
    <div class="footer-links">
        <a href="#">Ayuda</a>
        <a href="#">Contacto</a>
        <a href="#">About Us</a>
    </div>
</body>
</html>


