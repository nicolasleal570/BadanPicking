<?php

/* CONEXION CON SAP */
include './config/conexion.php';

if ($sap->GetStatus() == SAPRFC_OK) {
    $sap->Open();
}

if ($sap->GetStatus() != SAPRFC_OK) {
    $sap->PrintStatus();
    exit;
}

$fce = $sap->NewFunction("Z_RFC_PRECIOS_STOCK");
if ($fce == false) {
    $sap->PrintStatus();
    exit;
}

$fce->S_MATX = $_POST['nm_prd']; //NOMBRE DEL PRODUCTO

$fce->Call();

if ($fce->GetStatus() == SAPRFC_OK) {

    echo "
    <div class='result'>
        <table>
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
    $fce->ZPRECIO_STOCK->Reset();

    $i = 0;

    while ($fce->ZPRECIO_STOCK->Next()) {

        $i++;
        if ($fce->ZPRECIO_STOCK->row["RAUBE"] == 'CR') {$temp = "(REFRIGERADO)";} else { $temp = "";}

        list($num, $null) = split('[/-]', $fce->ZPRECIO_STOCK->row["P_M_V_P"]);
        $pmvp = number_format($num / 100000, "2", ",", "."); //linea modificada

        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["UNI_MEDIDA"]);
        $uniMed = $num;

        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["CD01"]);
        $almc = $num;

        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["LCTJ"]);
        $crtj = $num;

        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["VLNC"]);
        $vlcn = $num;

        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["PTLC"]);
        $ptlc = $num;

        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["BQTO"]);
        $bqto = $num;

        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["MRCY"]);
        $mrcy = $num;

        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["MCBO"]);
        $mcbo = $num;

        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["SCTB"]);
        $sctb = $num;

        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["GLRA"]);
        $glra = $num;

        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["PTDZ"]);
        $ptdz = $num;

        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["PTFJ"]);
        $ptfj = $num;

        list($num, $null) = split('[/.-]', $fce->ZPRECIO_STOCK->row["CRCA"]);
        $crca = $num;

        $j = 1;

        echo "<tr><td align='left'><div class='littleTitle'><span style='font-size: 10px;'><b>Cod." . $fce->ZPRECIO_STOCK->row["CODIGO"] . "</b></span></div></br> " . $fce->ZPRECIO_STOCK->row["MEDICAMENTO"] . "    </br><span style='color: red;'>" . $temp . "</span> </br></br><span style='color: #3F02C4; font-size: 10px;'>" . $fce->ZPRECIO_STOCK->row["S_NAME1"] . "</span></br><span style='color: #3F02C4; font-size: 10px;'><b>" . $fce->ZPRECIO_STOCK->row["RECIPE"] . "</b></br> <input type='hidden' id=" . $i . " value=" . $fce->ZPRECIO_STOCK->row["CODIGO"] . " /> </span></td>
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

//      <th>Almacen</th> <td><div class='boxhead'>".number_format($almc, "", ",", ".")." /Und.</br><a href='JavaScript:newPopUp(".$i.$j++.")'>+ Info</a></div></td>
//    <
//

$sap->Close();
?>
</body>
</html>
