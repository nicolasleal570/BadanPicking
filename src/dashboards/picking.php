<?php

session_start();

include ('../config/conexion.php');

if (!isset($_GET['subject1'])) {

  header("Location: facturas-list.php");
  
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="../css/fontawesome-all.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/estilos.css">
  <title>Picking Online</title>
</head>
<body>

  <?php

    // SQL PARA OBTENER TODOS LOS PEDIDOS NO ENTREGADOS. 'E' = Entregado.
    $sql = "SELECT * FROM likp INNER JOIN lips ON likp.vbeln = lips.idEntrega
            JOIN knal ON knal.idCliente = likp.kunnr
            JOIN mchb ON mchb.idProduc = lips.idProduc
            WHERE vbeln = '".$_GET['subject1']."' AND status_entrega != 'E'";

    $query_entrega = odbc_exec($conexion, $sql);
    $num = odbc_num_rows($query_entrega);

  ?>

  <header class="banner">
    <!-- LOGO -->
    <div class="img">
      <img src="../img/logo.png" alt="">
    </div>

    <div class="user">
      <h2> Repartidor: <span>
        <?php
        if (!$_SESSION['nombre_usuario']) {
          session_destroy();
          header("Location: ../index.php");
        }else{
          echo $_SESSION['nombre_usuario']; 
        }
        ?>
      </span> </h2>
    </div>
  </header>

  <section class="seccionToggle" id="seccionToggle">
      <div class="toggle-wrap">
        <h1>Sucursal <span>S301 </span></h1>
        <h3>
          <span class="fas fa-chevron-right"></span> Nombre del Usuario:
          <span>
            <?php echo $_SESSION['nombre'] .' '. $_SESSION['apellido']; ?>
          </span>
        </h3>
        <h3>
          <span class="fas fa-chevron-right"></span> Fecha de Picking:
          <span>
            <?php echo date("d / m / Y"); ?>
          </span>
        </h3>
      </div>
  </section>

  <a href="#" id="btn-toggle" class="btn-toggle">Información Importante. Click Aquí</a>

  <div class="main-picking">
    <div class="content">
      <h1> Información Sobre Facturación <span class="fa fa-medkit" aria-hidden="true"></span></h1>
      <table class="farm">
        <thead>
          <th>Entrega</th>
          <th>Facturador</th>
          <th>Puesto de Expedición</th>
          <th>Código del Cliente</th>
          <th>Nombre del Cliente</th>
        </thead>

        <tr>
          <?php $nro_entrega = $_GET['subject1']; ?>

          <td> <?php echo $nro_entrega; ?> </td>
          <td> <?php echo $_GET['subject2']; ?> </td>
          <td> <?php echo $_GET['subject3']; ?> </td>
          <td> <?php echo $_GET['subject4']; ?> </td>
          <td lang="es"> <?php echo $_GET['subject5']; ?> </td>
        </tr>

      </table>

      <h1> Medicamentos A Entregar <span class="fa fa-heartbeat" aria-hidden="true"></span></h1>
      <table class="producto">
        <thead>
            <th>Código del Producto</th>
            <th>Nombre del Producto</th>
            <th>Tipo de Unidad</th>
            <th>Cantidad</th>
            <th>Lote</th>
            <th>Inventario Restante</th>
        </thead>

        <?php

          if ($num == 0) {
            echo "La factura fue anulada y no existe";
            header("facturas-list.php");
          }else {
            /* Imprime todos las facturas entrantes */
            while ($row = odbc_fetch_array($query_entrega)) {

              $inventario_rest = $row['clabs'] - $row['lfimg'];

              ?>
                <tr>
                  <td>
                    <?php echo $row['matnr']; ?>
                  </td>
                  <td lang="es">
                    <?php echo $row['produc_nombre']; ?>
                  </td>
                  <td>
                    <?php echo $row['meins']; ?>
                  </td>
                  <td>
                    <?php echo $row['lfimg']; ?>
                  </td>
                  <td>
                    <?php echo $row['charg']; ?>
                  </td>
                  <td>
                    <?php
                      if ($row['lfimg'] > $row['clabs']) {

                        $inventario_rest *= (-1);

                        echo "<p class='error'>Al cliente le falta/n ".$inventario_rest." medicamentos.<br>Solo hay disponible ".$row['clabs']." medicamentos en el inventario</p>";

                      }else {
                        echo $inventario_rest;
                      }
                    ?>
                  </td>
                </tr>
              <?php
            }
          }
        ?>

      </table>

      <a href="entrega-val.php?item1=<?php print $nro_entrega; ?>
        &item2=<?php print $inventario_rest; ?>" class="btn-entregar" id="btn-entregar">
        <span class="fas fa-arrow-circle-right"></span>
      </a>

      <!-- BTN CANCELAR PICKING -->
      <a href="facturas-list.php" class="btn-cancelar" id="btn-cancelar">
        <span class="fas fa-times-circle"></span>
      </a>
    </div>
  </div>




  <script src="../js/jquery.js"></script>
  <script src="../js/picking.js"></script>
</body>
</html>
