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

$sql = "select max(cod_cotizacion) from cotizaciones";
$codCotizacion = obtenerCodigo($sql);
$codGestionActiva = gestionActiva();

$sql= "select max(nro_cotizacion) from cotizaciones where cod_gestion='".$codGestionActiva."'";
$nroCotizacion = obtenerCodigo($sql);
$fechaRegistro=date('Y/m/d h:i:s', time());

	
$sql = "insert into cotizaciones set ";
$sql .= " cod_cotizacion=" . $codCotizacion . ",";
$sql .= " cod_tipo_cotizacion=". $codTipoCotizacionF . ",";
$sql .= " cod_estado_cotizacion=1,";
$sql .= " cod_gestion=" . $codGestionActiva . ",";
$sql .= " nro_cotizacion=" . $nroCotizacion . ",";
$sql .= " cod_cliente=" . $codCliente . ",";
if($_POST['cod_unidad']<>0){
	$sql .= " cod_unidad=" .$_POST['cod_unidad']. ",";
}
if($_POST['cod_contacto']<>0){
	$sql .= " cod_contacto=" .$_POST['cod_contacto']. ",";
}
/*if($_POST['dias_validez']>0){
	$sql .= " dias_validez=".$_POST['dias_validez']. ",";
}else{
	$sql .= " dias_validez=15,";
}
if($_POST['tiempo_entrega']==""){
	$sql .= " tiempo_entrega=0,";
}else{
	$sql .= " tiempo_entrega=".$_POST['tiempo_entrega']. ",";
}*/
//$sql .= " forma_pago='" . $_POST['forma_pago']. "',";
$sql .= " fecha_cotizacion='" . $fechaCotizacionF . "',";
$sql .= " obs_cotizacion='" . $obsF . "',";
$sql .= " cod_tipo_pago='" . $codTipoPagoF . "',";
$sql .= " cod_usuario_registro=" .$_COOKIE['usuario_global'] . ",";
$sql .= " cod_sumar=" .$chkSumarF. ",";
$sql .= " considerar_precio_unitario=" .$chkConsiderarPrecioUnitarioF. ",";
$sql .= " descuento_cotizacion=0,";
$sql .= " incremento_cotizacion=0,";
$sql .= " cod_usuario_modifica=0, ";
$sql .= " cod_usuario_aprobacion=0, ";
$sql .= " cod_usuario_comision='".$_POST['cod_usuario_comision']."',";
$sql .= " fecha_registro='".$fechaRegistro."',";
$sql .= " cod_usuario_firma='".$codUsuarioFirmaF."'";




mysql_query($sql);

$cont=0;

for($i = 0;$i <= count($codItemVector)-1;$i++) {



    $sql_01 = "insert into cotizaciones_detalle set";
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
		$sql_03="SELECT cod_carac from componentes_caracteristica where  COD_COMPITEM='".$codCompItem."' order by orden asc";
		$resp_03= mysql_query($sql_03);
		$orden=1;
		while($dat_03=mysql_fetch_array($resp_03)){
			$codCarac=$dat_03[0];
			$sql_04="insert into cotizacion_detalle_caracteristica set";
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

					$sql4="select cod_ppc,desc_ppc, valor_ppc,orden_ppc from parametros_pie_cotizacion order by orden_ppc ";
					$resp4=mysql_query($sql4);
						while($dat4=mysql_fetch_array($resp4))
						{
							$cod_ppc=$dat4['cod_ppc'];
							
							
							
							if($_POST['cod_ppc'.$cod_ppc]<>Null || $_POST['cod_ppc'.$cod_ppc]<>""){
								
								$sqlInsert="insert into cotizaciones_ppc set";
								$sqlInsert.=" cod_cotizacion=".$codCotizacion."";				
								$sqlInsert.=" ,cod_ppc=".$_POST['cod_ppc'.$cod_ppc];
								$sqlInsert.=" ,desc_cotizacion_ppc='".$_POST['desc_cotizacion_ppc'.$cod_ppc]."'";
									
								mysql_query($sqlInsert);
								
							}
							
							
						}	

?>
<script language="JavaScript">				
	location.href="listCotizaciones.php";
</script>
