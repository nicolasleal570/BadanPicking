<?php

session_start();

if ($_POST) {

    /* VARIABLES DE INPUTS */
    $usuario = $_POST['usuariolg'];
    $password = $_POST['passlg'];

    if (empty($usuario) || empty($password)) {
        echo '<p class="error-index"> Debe rellenar Todos los campos </p>';
    } else {
        $sql = "SELECT * FROM usuarios WHERE usuario='$_POST[usuariolg]'";
        $query = odbc_exec($conexion, $sql);
        $num = odbc_num_rows($query);

        if ($num==0) {
            echo '<p class="error-index"> El usuario no existe </p>';
        } else {
            $row = odbc_fetch_array($query);

            if ($row['password'] != $password) {
                echo '<p class="error-index"> Contraseña Incorrecta </p>';
            } else {
                /* VARIABLES DE SESION */
                $_SESSION['id'] = $row['id'];
                $_SESSION['nombre'] = $row['nombre'];
                $_SESSION['apellido'] = $row['apellido'];
                $_SESSION['nombre_usuario'] = $row['usuario'];
                $_SESSION['status'] = $row['status'];

                /* ACTUALIZANDO EL STATUS DEL USUARIO */
                $update = "UPDATE usuarios SET disponible = 1 WHERE id = ".$row['id']."";
                odbc_exec($conexion, $update);

                header('Location:dashboards/facturas-list.php');

            }
        }
    }
}
