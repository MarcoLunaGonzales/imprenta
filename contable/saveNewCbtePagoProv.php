<?php

/*
select cod_cbte, cod_empresa, cod_gestion, cod_tipo_cbte, nro_cbte, cod_moneda,
cod_estado_cbte, fecha_cbte, nro_cheque, nro_factura, glosa, cod_usuario_registro,
fecha_registro, cod_usuario_modifica, fecha_modifica
from comprobante
*/
require("conexion.inc");
include("funciones.php");

$sql=" select max(cod_cbte) from comprobante ";
$cod_cbte=obtenerCodigo($sql);

$fecha_cbte=$_POST['fecha_cbte'];
$fecha_formato_cbte=llevarAFormatoFechaSqlMarco($fecha_cbte);
$cod_tipo_cbte=$_POST['cod_tipo_cbte'];
$cod_moneda=$_POST['cod_moneda'];
$glosa=$_POST['glosa'];
$nombre=$_POST['nombre'];
$banco=$_POST['banco'];
$nro_cheque=$_POST['nro_cheque'];
$nro_factura=$_POST['nro_factura'];
$cod_gestion=gestionActiva();
$cod_usuario=$_COOKIE['usuario_global'];
$cantidad_material=$_POST['cantidad_material'];


/*$sqlNroComp="select max(c.`nro_cbte`)+1 from `comprobante` c where 
		c.`cod_gestion`='$cod_gestion' and c.`cod_tipo_cbte`='$cod_tipo_cbte'";
$respNroComp=mysql_query($sqlNroComp);
$nro_cbte=mysql_result($respNroComp,0,0);*/

	$sql="select max(nro_cbte) from comprobante where cod_gestion='".$cod_gestion."' and cod_tipo_cbte='".$_POST['cod_tipo_cbte']."'";
	$nro_cbte=obtenerCodigo($sql);

$sql="INSERT INTO  `comprobante` (`cod_cbte`, `cod_empresa`, `cod_gestion`, `cod_tipo_cbte`, `nro_cbte`, `cod_moneda`, 
 `cod_estado_cbte`, `fecha_cbte`, `nro_cheque`, `nro_factura`,`banco`, `glosa`,`nombre`, `cod_usuario_registro`, `fecha_registro`) VALUES 
  ('$cod_cbte','1','$cod_gestion','$cod_tipo_cbte','$nro_cbte','$cod_moneda','1','$fecha_formato_cbte','$nro_cheque','$nro_factura','$banco','$glosa','$nombre',
  '$cod_usuario','".date('Y-m-d H:i:s', time())."')";

//echo $sql;

mysql_query($sql);

//sacamos el tipo de cambio ya sean dolares o bolivianos
$sql3="select cambio_bs from tipo_cambio";
$sql3.=" where fecha_tipo_cambio='$fecha_formato_cbte' and cod_moneda=2";
$resp3 = mysql_query($sql3);
$cambio_bs=0;
while($dat3=mysql_fetch_array($resp3)){
	$cambio_bs=$dat3['cambio_bs'];
}

//echo $sql3." ".$cambio_bs."CAMBIO BS.";

for($i=1;$i<=$cantidad_material;$i++){   
if($_POST["cod_cuenta".$i]){	
	$cod_cuenta=$_POST["cod_cuenta$i"];
	$nro_factura=$_POST["nro_factura$i"];
	$fecha_factura=$_POST["fecha_factura$i"];
	$fecha_factura_formato=llevarAFormatoFechaSqlMarco($fecha_factura);
	$debe=$_POST["debe$i"];
	$haber=$_POST["haber$i"];
	$glosaDetalle=$_POST["glosa$i"];
	$dias_venc_factura=$_POST["dias_venc_factura$i"];
	$id_pago=$_POST["cod_pago_prov"];
	$id_pago_detalle=$_POST["id_pago_detalle$i"];
	
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
		$sql=" select max(cod_cbte_detalle) from comprobante_detalle  where cod_cbte=".$cod_cbte."";
	$cod_cbte_detalle=obtenerCodigo($sql);
	
	$sqlInsertDetalle="INSERT INTO `comprobante_detalle` (`cod_cbte`, `cod_cbte_detalle`, `cod_cuenta`, `nro_factura`, `fecha_factura`,  
		`dias_venc_factura`, `glosa`, `debe`, `haber`, `debe_sus`, `haber_sus`, `id_pago`, `id_pago_detalle`)  VALUES 
		('$cod_cbte','$cod_cbte_detalle','$cod_cuenta','$nro_factura','$fecha_factura_formato','$dias_venc_factura','$glosaDetalle',
		'$debeBs','$haberBs','$debeDol','$haberDol','$id_pago','$id_pago_detalle')";
		
	//	echo "aqui =".$sqlInsertDetalle;
	
	//echo "<br>.$sqlInsertDetalle";
	
	$respInsertDetalle=mysql_query($sqlInsertDetalle);
	}
}
$sql=" update pago_proveedor set cod_cbte=".$cod_cbte." where cod_pago_prov=".$_POST['cod_pago_prov'];
mysql_query($sql);

require("cerrar_conexion.inc");
?>


<script language="JavaScript">
location.href="listComprobantes.php";
</script>