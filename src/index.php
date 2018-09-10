<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/estilos.css">
  <script src="js/jquery.js"></script>
  <title>Iniciar Sesión</title>
</head>
<body>

  <header class="banner">
    <!-- LOGO -->
    <div class="img">
      <img src="img/logo.png" alt="Logo Badan">
    </div>
  </header>

  <div id="error">
    <?php
/* Imprimiendo los errores */
require_once './config/conexion.php';
require_once './function/login-val.php';
?>
  </div>

  <!-- INICIO DE SESION -->
  <div class="wrap">
    <div class="formulario">
      <!-- ESTE LOGIN ES VALIDADO POR 'function/login-val.php' -->
      <form action="" method="post" class="login" id="formlg" autocomplete="off">
        <h1> Inicia tu Sesión </h1>
        <!-- USER -->
        <label for="user" class="user">Usuario:</label>
        <input type="text" id="user" name="usuariolg">

        <!-- PASSWORD -->
        <label for="password" class="password">Password:</label>
        <input type="password" id="password" name="passlg">

        <input type="submit" name="botonlg" onClick="Login();" class="botonlg" value="Iniciar Sesión" id="loginlg">
      </form>
    </div>

  </div>

  <script src="js/index.js"></script>
</body>
</html>
