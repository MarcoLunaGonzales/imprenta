<?php
require("conexion.inc");
include("funciones.php");



$sql="update ordentrabajo set ";
$sql.=" cod_est_ot=2,";
$sql.=" obs_anulacion='".$_POST['obs_anulacion']."',";
$sql.=" cod_usuario_anulacion='".$_COOKIE['usuario_global']."',";
$sql.=" fecha_anulacion='".date('Y-m-d', time())."'";
$sql.=" where cod_orden_trabajo='".$_POST['cod_orden_trabajo']."'"; 

$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="viewOrdenTrabajo.php?cod_orden_trabajo=<?php echo $_POST['cod_orden_trabajo'];?>";
</script>