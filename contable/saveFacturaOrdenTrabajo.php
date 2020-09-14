<?php
require("conexion.inc");
include("funciones.php");


$cod_est_fac=1;
$cod_orden_trabajo=$_POST['cod_orden_trabajo'];

$sql=" select max(cod_factura) from facturas ";
$cod_factura=obtenerCodigo($sql);



list($d,$m,$a)=explode("/",$_POST['fecha_factura']);

$sql="insert into facturas set ";
$sql.=" cod_factura='".$cod_factura."',"; 
$sql.=" nro_factura='".$_POST['nro_factura']."',"; 
//$sql.=" cod_cliente='".$_POST['cod_cliente']."',"; 
$sql.=" nombre_factura='".$_POST['nombre_factura']."',";
$sql.=" nit_factura='".$_POST['nit_factura']."',";
$sql.=" fecha_factura='".$a."-".$m."-".$d."',";
$sql.=" detalle_factura='".$_POST['detalle_factura']."',";
$sql.=" obs_factura='".$_POST['obs_factura']."',";
$sql.=" cod_est_fac='".$cod_est_fac."',";
$sql.=" monto_factura='".$_POST['monto_factura']."',";
$sql.=" cod_usuario_registro='".$_COOKIE['usuario_global']."',";
$sql.=" fecha_registro='".date('Y-m-d', time())."'";
$resp=mysql_query($sql);

$sql="insert into factura_ordentrabajo set ";
$sql.=" cod_factura='".$cod_factura."',"; 
$sql.=" cod_orden_trabajo='".$cod_orden_trabajo."'"; 
$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listOrdenTrabajo.php";
</script>