<?php
use app\includes\authenticate;
$auth = new authenticate();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>
<body class="body_login">
    <img src="ruta-a-tu-imagen.jpg" alt="Descripción de la imagen" class="top-right-image" />  
    
    <div class="login-container">
        <img src="path-to-your-logo.png" alt="Logo" /> <!-- Reemplaza con la ruta a tu logo -->
        <h2>Accede a tu aplicación <strong>CheckInSight</strong></h2>
        <div class="error-message">
        <!-- Espacio reservado para mensaje de error -->
        </div>
        <form class="login-form" action="<?php echo  $auth->verificarUser(); ?>" method="post">
        <input type="email" id="email" name="email" placeholder="Email" required>
        <input type="password" id="password" name="password" placeholder="Contraseña" required>
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



