<?php
require("conexion.inc");
include("funciones.php");

$cod_hoja_ruta = $_POST['cod_hoja_ruta'];
$obs_anular= $_POST['obs_anular'];


$fecha_anular=date('Y/m/d h:i:s', time());



$sql=" update hojas_rutas set  ";
$sql.=" fecha_anular='".$fecha_anular."',";
$sql.=" cod_usuario_anular='".$_COOKIE['usuario_global']."',";
$sql.=" cod_estado_hoja_ruta=2, ";
$sql.=" obs_anular='".$obs_anular."' ";
$sql.=" where  cod_hoja_ruta='".$cod_hoja_ruta."'";
//echo $sql;
mysql_query($sql);

?>
<script language="JavaScript">				
	location.href="listHojasRutas.php";
</script>
