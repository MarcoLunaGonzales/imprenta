<?php

/*
select cod_cbte, cod_empresa, cod_gestion, cod_tipo_cbte, nro_cbte, cod_moneda,
cod_estado_cbte, fecha_cbte, nro_cheque, nro_factura, glosa, cod_usuario_registro,
fecha_registro, cod_usuario_modifica, fecha_modifica
from comprobante
*/
require("conexion.inc");
include("funciones.php");



$fecha_cbte=$_POST['fecha_cbte'];
$fecha_formato_cbte=llevarAFormatoFechaSqlMarco($_POST['fecha_cbte']);
$cod_moneda=$_POST['cod_moneda'];
$glosa=$_POST['glosa'];
$cantidad_material=$_POST['cantidad_material'];
$banco=$_POST['banco'];
$nro_cheque=$_POST['nro_cheque'];
$nro_factura=$_POST['nro_factura'];


$sql=" update comprobante set  ";
//$sql.=" cod_empresa="..",";
//$sql.=" cod_gestion="..",";
//$sql.=" cod_tipo_cbte="..",";
$sql.=" nro_cbte=".$_POST['nro_cbte'].",";
$sql.=" cod_moneda=".$_POST['cod_moneda'].",";
//$sql.=" cod_estado_cbte="..",";
$sql.=" fecha_cbte='".llevarAFormatoFechaSqlMarco($_POST['fecha_cbte'])."',";
$sql.=" nro_cheque='".$_POST['nro_cheque']."',";
$sql.=" nro_factura='".$_POST['nro_factura']."',";
$sql.=" banco='".$_POST['banco']."',";
$sql.=" glosa='".$_POST['glosa']."',";
$sql.=" nombre='".$_POST['nombre']."',";
//$sql.=" cod_usuario_registro="..",";
//$sql.=" fecha_registro="..",";
$sql.=" cod_usuario_modifica=".$_COOKIE['usuario_global'].",";
$sql.=" fecha_modifica='".date('Y-m-d H:i:s', time())."'";
$sql.=" where cod_cbte=".$_POST['cod_cbte']."";
mysql_query($sql);

//sacamos el tipo de cambio ya sean dolares o bolivianos
$sql3="select cambio_bs from tipo_cambio";
$sql3.=" where fecha_tipo_cambio='".llevarAFormatoFechaSqlMarco($_POST['fecha_cbte'])."' and cod_moneda=2";
$resp3 = mysql_query($sql3);
$cambio_bs=0;
while($dat3=mysql_fetch_array($resp3)){
	$cambio_bs=$dat3['cambio_bs'];
}

$sql=" delete from comprobante_detalle   where cod_cbte=".$_POST['cod_cbte']."";
//echo $sql;
mysql_query($sql);
//echo $sql3." ".$cambio_bs."CAMBIO BS.";

for($i=1;$i<=$_POST['cantidad_material'];$i++){ 
	
	if($_POST["cod_cuenta".$i]){
	//echo"entroooooooooo";
	$cod_cuenta=$_POST["cod_cuenta$i"];
	$nro_factura=$_POST["nro_factura$i"];
	$fecha_factura=$_POST["fecha_factura$i"];
	$fecha_factura_formato=llevarAFormatoFechaSqlMarco($fecha_factura);
	$debe=$_POST["debe$i"];
	$haber=$_POST["haber$i"];
	$glosaDetalle=$_POST["glosa$i"];
	$dias_venc_factura=$_POST["dias_venc_factura$i"];
	
	if($cod_moneda==1){
		$debeBs=$debe;
		$haberBs=$haber;
		$debeDol=$debe/$cambio_bs;
		$haberDol=$haber/$cambio_bs;
	}
	if($cod_moneda==2){
		$debeBs=$debe*$cambio_bs;
		$haberBs=$haber*$cambio_bs;
		$debeDol=$debe;
		$haberDol=$haber;
	}
	$sql=" select max(cod_cbte_detalle) from comprobante_detalle  where cod_cbte=".$_POST['cod_cbte']."";
	$cod_cbte_detalle=obtenerCodigo($sql);
	$sqlInsertDetalle="INSERT INTO `comprobante_detalle` (`cod_cbte`, `cod_cbte_detalle`, `cod_cuenta`, `nro_factura`, `fecha_factura`,  
		`dias_venc_factura`, `glosa`, `debe`, `haber`, `debe_sus`, `haber_sus`)  VALUES 
		('".$_POST['cod_cbte']."','$cod_cbte_detalle','$cod_cuenta','$nro_factura','$fecha_factura_formato','$dias_venc_factura','$glosaDetalle',
		'$debeBs','$haberBs','$debeDol','$haberDol')";
		
	//echo $sqlInsertDetalle."<br/>";
	
	$respInsertDetalle=mysql_query($sqlInsertDetalle);
	}
}

require("cerrar_conexion.inc");
?>


<script language="JavaScript">
location.href="listComprobantes.php";
</script>