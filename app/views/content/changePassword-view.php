
<?php
use app\includes\authenticate;
$auth = new authenticate();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="body_login">
    
    <div class="login-container">
        <img class="img-logo-login" src="<?php echo APP_URL; ?>app/views/img/Logo CheckInSight.png" alt="Logo" /> <!-- Reemplaza con la ruta a tu logo -->
        <p>Recuperar o cambiar contraseña</p>
     
        <form class="login-form" action="" method="post">
            <div class="login-form-seccion">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" placeholder="" value="<?php echo isset($_POST['email'])? $_POST['email']:''; ?>" required>
            </div>
            <div class="login-form-seccion">
                <label for="psw1">Contraseña</label>
                <input type="password" id="psw1" name="psw1" placeholder="" required>
            </div>
            <div class="login-form-seccion">
                <label for="psw2">Contraseña</label>
                <input type="password" id="psw2" name="psw2" placeholder="" required>
            </div>

            <?php
                if(isset($_POST['email']) && isset($_POST['psw1']) && isset($_POST['psw2'])){
                    $auth->changePassword();
                }
		    ?>
        <button type="submit">Cambiar contraseña</button>
        </form>
    </div>
        
    <a href="http://www.presentialsl.com" class="presential-link" target="_blank">PresentiaL SL</a>
        
    <div class="footer-links">
        <a href="#">Ayuda</a>
        <a href="#">Contacto</a>
        <a href="#">About Us</a>
    </div>
</body>
</html>


