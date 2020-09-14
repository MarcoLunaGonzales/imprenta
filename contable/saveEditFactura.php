<?php
require("conexion.inc");
include("funciones.php");




list($d,$m,$a)=explode("/",$_POST['fecha_factura']);

$sql="update facturas set ";
$sql.=" nro_factura='".$_POST['nro_factura']."',"; 
//$sql.=" cod_cliente='".$_POST['cod_cliente']."',"; 
$sql.=" nombre_factura='".$_POST['nombre_factura']."',";
$sql.=" nit_factura='".$_POST['nit_factura']."',";
$sql.=" fecha_factura='".$a."-".$m."-".$d."',";
$sql.=" detalle_factura='".$_POST['detalle_factura']."',";
$sql.=" obs_factura='".$_POST['obs_factura']."',";
$sql.=" cod_est_fac='".$_POST['cod_est_fac']."',";
$sql.=" monto_factura='".$_POST['monto_factura']."',";
$sql.=" cod_usuario_modifica='".$_COOKIE['usuario_global']."',";
$sql.=" fecha_modifica='".date('Y-m-d', time())."'";
$sql.=" where cod_factura='".$_POST['cod_factura']."'"; 
$resp=mysql_query($sql);


require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="viewFactura.php?cod_factura=<?php echo $_POST['cod_factura'];?>";
</script>