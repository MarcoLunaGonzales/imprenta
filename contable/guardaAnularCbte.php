<?php
require("conexion.inc");
include("funciones.php");


$sql=" update comprobante set ";
$sql.=" obs_anulacion='".$_POST['obs_anulacion']."', ";
$sql.=" fecha_anulacion='".date('Y-m-d h:i:s', time())."',";
$sql.=" cod_usuario_anulacion='".$_COOKIE['usuario_global']."',";
$sql.=" cod_estado_cbte=2 ";
$sql.=" where cod_cbte='".$_POST['cod_cbte']."'";
//echo $sql;
mysql_query($sql);



require("cerrar_conexion.inc");
?>
<script language="JavaScript">
	opener.location.reload();
	window.close();
</script>