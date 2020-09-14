<?php
require("conexion.inc");
include("funciones.php");


$sql=" update gastos_gral set ";
$sql.=" obs_anulacion='".$_POST['obs_anulacion']."', ";
$sql.=" fecha_anulacion='".date('Y-m-d h:i:s', time())."',";
$sql.=" cod_usuario_anulacion='".$_COOKIE['usuario_global']."',";
$sql.=" cod_estado=2 ";
$sql.=" where cod_gasto_gral='".$_POST['cod_gasto_gral']."'";
mysql_query($sql);



require("cerrar_conexion.inc");
?>
<script language="JavaScript">
	opener.location.reload();
	window.close();
</script>