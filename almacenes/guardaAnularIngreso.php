<?php
require("conexion.inc");
include("funciones.php");

$cod_ingreso=$_POST['cod_ingreso'];
$obs_anular=$_POST['obs_anular'];
$cod_estado_ingreso=2;



$sql=" update ingresos set ";
$sql.=" obs_anular='".$obs_anular."', ";
$sql.=" cod_estado_ingreso='".$cod_estado_ingreso."' ";
$sql.=" where cod_ingreso='".$cod_ingreso."'";
mysql_query($sql);



require("cerrar_conexion.inc");
?>
<script language="JavaScript">
	opener.location.reload();
	window.close();
</script>