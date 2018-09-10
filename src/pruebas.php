<?php

/* CONEXION CON SAP */
include './config/conexion.php';

/* INICIA UNA INSTANCIA CON SAP */
if ($sap->GetStatus() == SAPRFC_OK) {
    $sap->Open();
}

/* COMPRUEBA SI HAY ERRORES */
if ($sap->GetStatus() != SAPRFC_OK) {
    echo '<h1>Hay un Error</h1>';
    $sap->PrintStatus();
    exit;
}

/* EJECUTA LA FUNCION QUE RELLENA LA TABLA ZPRECIO_STOCK */
$fce = $sap->NewFunction("Z_RFC_PRECIOS_STOCK");
if ($fce == false) {
    echo '<h1> No existe esa función </h1>';
    $sap->PrintStatus();
    exit;
}

$fce->S_MATX = 'broxol'; //NOMBRE DEL PRODUCTO

$fce->Call(); //LLAMA LOS RESULTADOS

if ($fce->GetStatus() == SAPRFC_OK) {

    echo "
    <div class='result'>
        <table border='1px'>
            <tr>
                <th>Producto</th>
                <th>Precios</th>
                <th>Via de Administracion</th>

                <th>Los Cortijos</th>
                <th>Valencia</th>
                <th>Pto. La Cruz</th>
                <th>Barquisimeto</th>
                <th>Maracay</th>
                <th>Maracaibo</th>
                <th>San Cristobal</th>
                <th>Gal. Avila</th>
                <th>Pto. Ordaz</th>

                <th>Credicard</th>
            </tr>";

    $fce->ZPRECIO_STOCK->Reset(); // Hace un reset a los resultados y luego los imprime

    $i = 0; // Contador

    while ($fce->ZPRECIO_STOCK->Next()) {

        $i++; // Incrementa el contador con cada resultado

        /* COMPRUEBA SI EL MEDICAMENTO ES REFRIGERADO O NO */
        if ($fce->ZPRECIO_STOCK->row["RAUBE"] == 'CR') {
            $temp = "(REFRIGERADO)";
        } else {
            $temp = "";
        }

        //IMPRIME EL PRECIO DEL PRODUCTO
        list($num, $null) = split('[/-]', $fce->ZPRECIO_STOCK->row["P_M_V_P"]);
        $pmvp = number_format($num, "2", ",", ".");

        //IMPRIME LA VIA DE ADMINISTRACION
        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["UNI_MEDIDA"]);
        $uniMed = $num;

        //IMPRIME LAS UNIDADES EN ALMACEN
        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["CD01"]);
        $almc = $num;

        //imprime las unidades en los cortijos
        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["LCTJ"]);
        $crtj = $num;

        //imprime las unidades en valencia
        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["VLNC"]);
        $vlcn = $num;

        //imprime las unidades en puerto la cruz
        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["PTLC"]);
        $ptlc = $num;

        //imprime las unidades en barquisimeto
        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["BQTO"]);
        $bqto = $num;

        //imprime las unidades en maracay
        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["MRCY"]);
        $mrcy = $num;

        //imprime las unidades en maracaibo
        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["MCBO"]);
        $mcbo = $num;

        //imprime las unidades en san cristobal
        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["SCTB"]);
        $sctb = $num;

        //imprime las unidades en galerias avila
        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["GLRA"]);
        $glra = $num;

        //imprime las unidades en puerto ordaz
        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["PTDZ"]);
        $ptdz = $num;

        //imprime las unidades en punto fijo
        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["PTFJ"]);
        $ptfj = $num;

        //imprime las unidades en credicard
        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["CRCA"]);
        $crca = $num;

        $j = 1;

        echo "
        <tr>
            <td>
                <div class='littleTitle'>
                    <span><b>Cod." . $fce->ZPRECIO_STOCK->row["CODIGO"] . "</b></span>
                </div></br> " . $fce->ZPRECIO_STOCK->row["MEDICAMENTO"] . "  </br>

                    <span style='color: red;'>" . $temp . "</span> </br></br>
                    <span style='color: #3F02C4; font-size: 10px;'>" . $fce->ZPRECIO_STOCK->row["S_NAME1"] . "</span></br>
                    <span style='color: #3F02C4; font-size: 10px;'><b>" . $fce->ZPRECIO_STOCK->row["RECIPE"] . "</b></br>
                    <input type='hidden' id=" . $i . " value=" . $fce->ZPRECIO_STOCK->row["CODIGO"] . " /> </span>
            </td>
            <td>BsS." . $pmvp . "</td>
            <td>" . $uniMed . "</td>
            <td><div class='boxhead'>" . number_format($crtj, "", ",", ".") . " /Und.</div></td>
            <td><div class='boxhead'>" . number_format($vlcn, "", ",", ".") . "/Und.</div></td>
            <td><div class='boxhead'>" . number_format($ptlc, "", ",", ".") . "/Und.</div></td>
            <td><div class='boxhead'>" . number_format($bqto, "", ",", ".") . "/Und.</div></td>
            <td><div class='boxhead'>" . number_format($mrcy, "", ",", ".") . "/Und.</div></td>
            <td><div class='boxhead'>" . number_format($mcbo, "", ",", ".") . "/Und.</div></td>
            <td><div class='boxhead'>" . number_format($sctb, "", ",", ".") . "/Und.</div></td>
            <td><div class='boxhead'>" . number_format($glra, "", ",", ".") . "/Und.</div></td>
            <td><div class='boxhead'>" . number_format($ptdz, "", ",", ".") . "/Und.</div></td>
            <td><div class='boxhead'>" . number_format($crca, "", ",", ".") . "/Und.</div></td>
    </tr>";
    }
    echo "</table></div>";
} else {
    echo "<center>Disculpe su producto no puede ser encontrado intentelo con otro nombre!.</center>";
}

echo "<th>Almacen</th> <td><div class='boxhead'>" . number_format($almc, "", ",", ".") . " /Und.</div></td>";

$sap->Close();
?>
</body>
</html>
