<?php
require("conexion.inc");
include("funciones.php");

$codCotizacion=$_POST['codCotizacionF'];

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
$fechaModificacion =date('Y/m/d h:i:s', time());

$sql_00="delete from cotizacion_detalle_caracteristica where COD_COTIZACION=".$codCotizacion;
mysql_query($sql_00);
$sql_00="delete from cotizaciones_detalle where COD_COTIZACION=".$codCotizacion;
mysql_query($sql_00);


$sql = "update cotizaciones set ";
$sql .= " COD_TIPO_COTIZACION=" . $codTipoCotizacionF . ",";
$sql .= " COD_CLIENTE=" . $codCliente . ",";
$sql .= " FECHA_COTIZACION='" . $fechaCotizacionF . "',";
$sql .= " OBS_COTIZACION='" . $obsF . "',";
$sql .= " COD_TIPO_PAGO='" . $codTipoPagoF . "',";
$sql .= " COD_SUMAR=" .$chkSumarF. ",";
$sql .= " considerar_precio_unitario=" .$chkConsiderarPrecioUnitarioF. ",";
$sql .= " cod_usuario_modifica=" .$_COOKIE['usuario_global'] . ",";
$sql .="  fecha_modifica='".$fechaModificacion."',";
$sql .="  cod_usuario_firma='".$codUsuarioFirmaF."' ";
$sql .= " where COD_COTIZACION=" . $codCotizacion . "";

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
</script>
