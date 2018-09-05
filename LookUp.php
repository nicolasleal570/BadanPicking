<html>
<head>
   	<link href="CCSSelba/SelbaWeb.css" rel="stylesheet">
	<link href="jquery-ui-1.10.3/css/redmond/jquery-ui-1.10.3.custom.css" rel="stylesheet">
	<script src="jquery-ui-1.10.3/js/jquery-1.9.1.js"></script>
	<script src="jquery-ui-1.10.3/js/jquery-ui-1.10.3.custom.js"></script>
	<script src="jquery-ui-1.10.3/dist/jquery.maskedinput.min.js" type="text/javascript"></script>
	<script src="jquery-ui-1.10.3/dist/jquery.maskMoney.js" type="text/javascript"></script>
</head>
<body>

<?
include_once "sap.php";

$sap = new SAPConnection();
$sap->Connect("logon_data.conf");
if ($sap->GetStatus() == SAPRFC_OK) {
    $sap->Open();
}

if ($sap->GetStatus() != SAPRFC_OK) {
    $sap->PrintStatus();
    exit;
}

$fce = &$sap->NewFunction("Z_RFC_LOTES");
if ($fce == false) {
    $sap->PrintStatus();
    exit;
}

$fce->S_WERKS = $_POST['id_cen'];
$fce->N_MATNR = $_POST['cod_mat'];

$fce->Call();

if ($fce->GetStatus() == SAPRFC_OK) {

    echo "<div class='CSSTableGenerator' >
    	<table>
    	<tr align='center'>
    		<th>Codigo del Producto</th>
			<th>Centro</th>
    		<th>Almacen</th>
    		<th>Lote</th>
			<th>Fecha de Caducidad</th>
			<th>Cantidad</th>
		</tr>";

    $fce->ZLOTES_STOCK->Reset();

    while ($fce->ZLOTES_STOCK->Next()) {

        list($num, $null) = split('[/-]', $fce->ZLOTES_STOCK->row["MATNR"]);
        $matn = $num;

        list($num, $null) = split('[/.-]', $fce->ZLOTES_STOCK->row["WERKS"]);
        $center = $num;

        list($num, $null) = split('[/.-]', $fce->ZLOTES_STOCK->row["LGORT"]);
        $alm = $num;

        list($num, $null) = split('[/.-]', $fce->ZLOTES_STOCK->row["CHARG"]);
        $lot = $num;

        list($num, $null) = split('[/.-]', $fce->ZLOTES_STOCK->row["LAEDA"]);
        $fecv = $num;

        list($num, $null) = split('[/.-]', $fce->ZLOTES_STOCK->row["CLABS"]);
        $quant = $num;

        echo "<tr>
			<td><div class='boxhead'>Cod." . $matn . "</div></td>
			<td><div class='boxhead'>" . $center . "</div></td>
			<td><div class='boxhead'>" . $alm . "</div></td>
			<td><div class='boxhead'>" . $lot . "</div></td>
			<td><div class='boxhead'>" . $fecv[6] . $fecv[7] . "/" . $fecv[4] . $fecv[5] . "/" . $fecv[0] . $fecv[1] . $fecv[2] . $fecv[3] . "</div></td>
			<td><div class='boxhead'>" . number_format($quant, "", ",", ".") . " /Und.</div></td>


			</tr>";
    }
    echo "</table></div>";
} else {
    echo "<center>Disculpe no hay disponibilidad de este producto!.</center>";
}

$sap->Close();
?>
</body>
</html>