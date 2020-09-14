<?php
require("conexion.inc");
include("funciones.php");

$cod_categoria=$_POST['cod_categoria'];
$desc_categoria=$_POST['desc_categoria'];
$obs_categoria=$_POST['obs_categoria'];

$cod_estado_registro=$_POST['cod_estado_registro'];







$sql="update clientes_categorias set ";
$sql.=" desc_categoria='".$desc_categoria."',"; 
$sql.=" obs_categoria='".$obs_categoria."',"; 
$sql.=" cod_estado_registro=".$cod_estado_registro.",";
$sql.=" cod_usuario_modifica=".$_COOKIE['usuario_global'].",";
$sql.=" fecha_modifica='".date('Y-m-d', time())."'";
$sql.=" where cod_categoria=".$cod_categoria.""; 
//$sql.=" cod_usuario_modifica='".$obs_cargo."',";
//$sql.=" fecha_modifica='".$obs_cargo."'";
mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorClientesCategorias.php";
</script>