<?php

session_start();

include '../config/conexion.php';

session_destroy();

$update = "UPDATE usuarios SET disponible = 0 WHERE disponible = 1";

$result = odbc_exec($conexion, $update);

$row = odbc_fetch_array($result);

if($row['disponible'] == 0){
    header("Location: ../index.php");
}
    
