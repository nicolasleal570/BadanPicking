<?php

  require_once '../config/conexion.php';

  $nro_entrega = $_GET['item1'];

  /* Comprueb que esté establecida la variable que envía el archivo 'picking.php' para hacer entrega final del picking */
  if (!$nro_entrega) {
    header("Location: facturas-list.php");
  }

  /*----------------------------------------*/
  /* VALIDACION DE LAS ENTREGAS DE FACTURAS */
  /*----------------------------------------*/

    // DATOS CON EL NRO DE LA ENTREGA LISTA
    $sql_entreg = "SELECT * FROM likp INNER JOIN lips ON likp.vbeln = lips.idEntrega
    JOIN knal ON knal.idCliente = likp.kunnr
    JOIN mchb ON mchb.idProduc = lips.idProduc
    WHERE vbeln ='".$_GET['item1']."'";
    $query_entreg = odbc_exec($conexion, $sql_entreg);

    $row_entreg = odbc_fetch_array($query_entreg);


  if (isset($row_entreg['vbeln'])) {
    $sql_update = "UPDATE likp SET status_entrega = 'E' WHERE vbeln ='".$_GET['item1']."'";
    $query_update = odbc_exec($conexion, $sql_update);

    
    header('Location: facturas-list.php');
  }

?>
