<?php
require("conexion.inc");
include("funciones.php");


$codCliente = $_POST['codCliente'];

$fechaCotizacionF = $_POST['fechaCotizacionF'];

$codTipoCotizacionF = $_POST['codTipoCotizacionF'];

$codTipoPagoF = $_POST['codTipoPagoF'];

$obsF = $_POST['obsF'];


$codItemF = $_POST['codItemF'];

$cantidadUnitariaF = $_POST['cantidadUnitariaF'];

$precioVentaF = $_POST['precioVentaF'];

$descuentoF = $_POST['descuentoF'];


$codCaracF = $_POST['codCaracF'];

$descCaracF = $_POST['descCaracF'];

$descItemF = $_POST['descItemF'];

$chkSumarF = $_POST['chkSumarF'];

$chkConsiderarPrecioUnitarioF = $_POST['chkConsiderarPrecioUnitarioF'];

$codUsuarioFirmaF= $_POST['codUsuarioFirmaF'];


$codItemVector = explode(",", $codItemF);
$cantidadUnitariaVector = explode(",", $cantidadUnitariaF);
$precioVentaVector = explode(",", $precioVentaF);
$descuentoVector = explode(",", $descuentoF); 
$importeVector = explode(",", $importeF);

$codCaracVector=explode(",", $codCaracF);
$descCaracVector=explode(",", $descCaracF);
$descItemVector=explode(",", $descItemF);



$vectorFecha = explode("/", $fechaCotizacionF);
$fechaCotizacionF = $vectorFecha[2] . "-" . $vectorFecha[1] . "-" . $vectorFecha[0];

$sql = "select max(COD_COTIZACION) from cotizaciones";
$codCotizacion = obtenerCodigo($sql);
$codGestionActiva = gestionActiva();

$sql= "select max(NRO_COTIZACION) from cotizaciones where cod_gestion='".$codGestionActiva."'";
$nroCotizacion = obtenerCodigo($sql);

$fechaRegistro=date('Y/m/d h:i:s', time());

$sql = "insert into cotizaciones set ";
$sql .= " COD_COTIZACION=" . $codCotizacion . ",";
$sql .= " COD_TIPO_COTIZACION=" . $codTipoCotizacionF . ",";
$sql .= " COD_ESTADO_COTIZACION=1,";
$sql .= " cod_gestion=" . $codGestionActiva . ",";
$sql .= " NRO_COTIZACION=" . $nroCotizacion . ",";
$sql .= " COD_CLIENTE=" . $codCliente . ",";
$sql .= " FECHA_COTIZACION='" . $fechaCotizacionF . "',";
$sql .= " OBS_COTIZACION='" . $obsF . "',";
$sql .= " COD_TIPO_PAGO='" . $codTipoPagoF . "',";
$sql .= " cod_usuario_registro=" .$_COOKIE['usuario_global'] . ",";
$sql .= " COD_SUMAR=" .$chkSumarF. ",";
$sql .= " considerar_precio_unitario=" .$chkConsiderarPrecioUnitarioF. ",";
$sql .= " cod_usuario_modifica=0, ";
$sql .= " cod_usuario_aprobacion=0, ";
$sql .= " fecha_registro='".$fechaRegistro."',";
$sql .= " cod_usuario_firma='".$codUsuarioFirmaF."'";

mysql_query($sql);
$cont=0;

for($i = 0;$i <= count($codItemVector)-1;$i++) {



    $sql_01 = "insert into COTIZACIONES_DETALLE SET";
	$sql_01 .= " COD_COTIZACIONDETALLE=" . ($i+1) . ",";
    $sql_01 .= " COD_COTIZACION=" . $codCotizacion . ",";
    $sql_01 .= " COD_ITEM=" . $codItemVector[$i] . ",";
	$sql_01 .= " DESCRIPCION_ITEM='" . $descItemVector[$i] . "',";	
    $sql_01 .= " CANTIDAD_UNITARIACOTIZACION=" . $cantidadUnitariaVector[$i] . ",";
    $sql_01 .= " CANTIDAD_UNITARIACOTIZACIONEFECTUADA=0,";
    $sql_01 .= " COD_ESTADO_DETALLECOTIZACIONITEM=1,";
	
	if($chkConsiderarPrecioUnitarioF==1){
    	$sql_01 .= " PRECIO_VENTA=" . $precioVentaVector[$i] . ",";
	    $sql_01 .= " DESCUENTO=" . $descuentoVector[$i] . ",";
    	$montoVentaSinDescuento = floatval($cantidadUnitariaVector[$i]) * floatval($precioVentaVector[$i]);
	    $importeTotal=floatval($montoVentaSinDescuento)-floatval(floatval($montoVentaSinDescuento)*floatval($descuentoVector[$i])/ 100);
   		 $sql_01 .= " IMPORTE_TOTAL=" . $importeTotal."";
	}else{
	    	$sql_01 .= " PRECIO_VENTA=0,";
   	        $sql_01 .= " DESCUENTO=0,";
			$sql_01 .= " IMPORTE_TOTAL=" .$importeVector[$i]."";
	}
 	// echo("$sql_01".$sql_01."<br>");
	 mysql_query($sql_01);
	
	$sql_02="select cod_compitem from componente_items where cod_item='".$codItemVector[$i]."' order by cod_compitem asc";
	$resp_02= mysql_query($sql_02);	
	while($dat_02=mysql_fetch_array($resp_02)){
		$codCompItem=$dat_02[0];
		$sql_03="SELECT COD_CARAC FROM componentes_caracteristica WHERE  COD_COMPITEM='".$codCompItem."' ORDER BY orden ASC";
		$resp_03= mysql_query($sql_03);
		$orden=1;
		while($dat_03=mysql_fetch_array($resp_03)){
			$codCarac=$dat_03[0];
			$sql_04="insert into COTIZACION_DETALLE_CARACTERISTICA SET";
			$sql_04.=" COD_COTIZACIONDETALLE=".($i+1)."";				
			$sql_04.=" ,COD_COTIZACION=".$codCotizacion;
			$sql_04.=" ,COD_COMPITEM=".$codCompItem;
			$sql_04.=" ,COD_CARAC=".$codCarac;
			$sql_04.=" ,DESC_CARAC='".$descCaracVector[$cont]."'";
			$sql_04.=" ,COD_ESTADO_REGISTRO=".$codCaracVector[$cont]."";		
			$sql_04.=" ,orden=".$orden."";	
		
			mysql_query($sql_04);

			$cont++;
			$orden++;
		}
	}
}

?>
<script language="JavaScript">				
		location.href="navegadorCotizaciones.php";
		window.close();
        window.opener.location.reload();
</script>
