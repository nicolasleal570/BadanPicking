<?php

session_start();
include ('../config/conexion.php');

$usuario = "SELECT * FROM usuarios";
$userQuery = odbc_exec($conexion, $usuario);
$row = odbc_fetch_array($userQuery);

if ($row['disponible'] = 1) {
  ?> <script> alert("Su sesion ya fue iniciada") </script> <?php
}

$usuario = $_POST['usuariolg'];
$password = $_POST['passlg'];

if(isset($usuario) && $usuario!='' && isset($password) && $password!=''){

  #llegaron los datos
  $sql = "SELECT * FROM usuarios WHERE usuario='$_POST[usuariolg]'";
  $query = odbc_exec($conexion,$sql);
  $num = odbc_num_rows($query);

  if ($num==0){?>
    <meta http-equiv="refresh" content="0;URL=../index.php"/>
    <script> alert("No existe el usuario. "); </script><?PHP
  }else {
    # se encontro registro
    $row = odbc_fetch_array($query); # descargo en el arreglo $row la primera fila
    if ($row['password'] != ($password)){
      # No coincide contraseña?>
      <script>
        alert("Contraseña Incorrecta. ");
      </script>
      <meta http-equiv="refresh" content="0;URL=../index.php"/>
      <?php
     }else {

      /*-----------------------------*/
      /* CREANDO VARIABLES DE SESION */
      /*-----------------------------*/
      $_SESSION['id'] = $row['id'];
      $_SESSION['nombre'] = $row['nombre'];
      $_SESSION['apellido'] = $row['apellido'];
      $_SESSION['nombre_usuario'] = $row['usuario'];
      $_SESSION['status'] = $row['disponible'];

      $update = "UPDATE usuarios SET disponible = 1 WHERE usuario = ".$row['usuario']."";

      odbc_exec($conexion, $update);

      header('Location: ../dashboards/facturas-list.php');
    }
  }
}else { ?>
    <script> alert("Debe rellenar todos los datos. "); </script>
    <meta http-equiv="refresh" content="0;URL=../index.php"/><?php
 }


?>
