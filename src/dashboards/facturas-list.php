<?php

session_start();
include '../config/conexion.php';

/* if (!$_SESSION['id']) {
header("Location: ../index.php");
} */

?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../css/fontawesome-all.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos.css">
    <script src="../js/jquery.js"></script>
    <title>Lista de Facturas</title>
  </head>
  <body>
    <?php

/* Sentencia SQL */
$entregas = "SELECT kunnr, vbeln, name_1, ernam, vstel FROM likp INNER JOIN lips ON likp.vbeln = lips.idEntrega
                  JOIN knal ON knal.idCliente = likp.kunnr
                  JOIN mchb ON mchb.idProduc = lips.idProduc WHERE status_entrega = 'NE'
                  GROUP BY kunnr, vbeln, name_1, ernam, vstel
                  ORDER BY kunnr asc";

/* $query = odbc_exec($conexion, $entregas);
$num = odbc_num_rows($query); */

?>

    <header class="banner">
      <!-- LOGO -->
      <div class="img">
        <img src="../img/logo.png" alt="Logo"/>
      </div>

      <div class="user">
        <h2> Repartidor: <span> <?php echo $_SESSION['nombre_usuario']; ?> </span> </h2>
        <a href="../function/cerrar.php">Cerrar Sesión</a>
      </div>
    </header>

      <!------------------------------------------------------>
      <!-- Cambiar el link cuando ya la pagina este online --->
      <!------------------------------------------------------>
      <a href="http://mail.fundacionbadan.org:1067/BadanPicking/src/dashboards/facturas-list.php
" class="btn-actualizar fas fa-sync" id="btn-actualizar-fac">
      </a>

    <div class="main">
      <div class="content">
        <h1> Facturas Entrantes <span class="fas fa-newspaper" aria-hidden="true"></span></h1>

        <!-- IMPRESION DE LA LISTA DE FACTURAS -->
        <?php
if ($num == 0) {?>
          <h2>
            <br/>No hay facturas en este momento
          </h2>
          <?php
} else {

    while ($row = odbc_fetch_array($query)) {
        ?>

            <table class="farm" id="farm" data-farmtab="<?php echo $row['vbeln']; ?>">
              <thead>
                <th>Entrega</th>
                <th>Código del Destinatario</th>
                <th>Nombre del Destinatario</th>
                <th>Estatus de la Factura</th>
              </thead>
                <tr>
                <!-- IMPRIMIENDO LA INFORMACIÓN EN LOS CAMPOS SEGÚN SEA EL CASO -->
                  <td> <?php echo $row['vbeln']; ?> </td>
                  <td> <?php echo $row['kunnr']; ?> </td>
                  <td lang="es"> <?php echo $row['name_1']; ?></td>
                  <td class="status">
                    <a href="picking.php?subject1=<?php print_r($row['vbeln']);?>
                      &subject2=<?php print_r($row['ernam']);?>
                      &subject3=<?php print_r($row['vstel']);?>
                      &subject4=<?php print_r($row['kunnr']);?>
                      &subject5=<?php print_r($row['name_1']);?>"
                      class="btn_abrir fas fa-external-link-alt" id="btn_abrir"
                    </a>
                  </td>
                </tr>
            </table>
            <?php
}
}?>
      </div>
    </div>

    <script src="../js/facturas-list.js"></script>
  </body>
</html>
