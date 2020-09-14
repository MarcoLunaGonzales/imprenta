<?php
require("conexion.inc");
include("funciones.php");


list($d,$m,$a)=explode("/",$_POST['fecha_orden_trabajo']);

$sql="update ordentrabajo set ";
$sql.=" cod_est_ot='".$_POST['cod_est_ot']."',";
$sql.=" numero_orden_trabajo='".$_POST['numero_orden_trabajo']."',";
$sql.=" fecha_orden_trabajo='".$a."-".$m."-".$d."',";
$sql.=" cod_cliente='".$_POST['cod_cliente']."',";
$sql.=" detalle_orden_trabajo='".$_POST['detalle_orden_trabajo']."',";
$sql.=" obs_orden_trabajo='".$_POST['obs_orden_trabajo']."',";
$sql.=" monto_orden_trabajo='".$_POST['monto_orden_trabajo']."',";
$sql.=" cod_usuario_modifica='".$_COOKIE['usuario_global']."',";
$sql.=" fecha_modifica='".date('Y-m-d', time())."'";
$sql.=" where cod_orden_trabajo='".$_POST['cod_orden_trabajo']."'"; 

$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="viewOrdenTrabajo.php?cod_orden_trabajo=<?php echo $_POST['cod_orden_trabajo'];?>";
</script>