<?php
require("conexion.inc");
include("funciones.php");


$cod_est_ot=1;


$sql=" select max(cod_orden_trabajo) from ordentrabajo ";
$cod_orden_trabajo=obtenerCodigo($sql);

$cod_gestion=gestionActiva();

$sql="select max(nro_orden_trabajo) from ordentrabajo where cod_gestion='".$cod_gestion."'";
$nro_orden_trabajo=obtenerCodigo($sql);

/*
SELECT cod_orden_trabajo, nro_orden_trabajo, cod_gestion, cod_est_ot, numero_orden_trabajo,
fecha_orden_trabajo, cod_cliente, detalle_orden_trabajo, obs_orden_trabajo, monto_orden_trabajo,
cod_usuario_registro,fecha_registro, cod_usuario_modifica, fecha_modifica
from ordentrabajo
*/

list($d,$m,$a)=explode("/",$_POST['fecha_orden_trabajo']);

$sql="insert into ordentrabajo set ";
$sql.=" cod_orden_trabajo='".$cod_orden_trabajo."',"; 
$sql.=" nro_orden_trabajo='".$nro_orden_trabajo."',"; 
$sql.=" cod_gestion='".$cod_gestion."',";
$sql.=" cod_est_ot='".$cod_est_ot."',";
$sql.=" numero_orden_trabajo='".$_POST['numero_orden_trabajo']."',";
$sql.=" fecha_orden_trabajo='".$a."-".$m."-".$d."',";
$sql.=" cod_cliente='".$_POST['cod_cliente']."',";
$sql.=" cod_contacto='".$_POST['cod_contacto']."',";
$sql.=" detalle_orden_trabajo='".$_POST['detalle_orden_trabajo']."',";
$sql.=" obs_orden_trabajo='".$_POST['obs_orden_trabajo']."',";
$sql.=" monto_orden_trabajo='".$_POST['monto_orden_trabajo']."',";
$sql.=" cod_usuario_registro='".$_COOKIE['usuario_global']."',";
$sql.=" fecha_registro='".date('Y-m-d', time())."',";
$sql.=" cod_tipo_pago=".$_POST['cod_tipo_pago'].",";
$sql.=" incremento_orden_trabajo=0,";
$sql.=" descuento_orden_trabajo=0,";
if($cod_tipo_pago==3){
	$sql.=" cod_estado_pago_doc=3";
}else{
	$sql.=" cod_estado_pago_doc=1";
}

$resp=mysql_query($sql);


require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="listOrdenTrabajo.php";
		window.close();
        window.opener.location.reload();
</script>