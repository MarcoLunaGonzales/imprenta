<?php
require("conexion.inc");
include("funciones.php");

$desc_categoria=$_POST['desc_categoria'];
$obs_categoria=$_POST['obs_categoria'];

$cod_estado_registro=$_POST['cod_estado_registro'];

$cod_estado_registro=1;



$sql=" select max(cod_categoria) from clientes_categorias ";
$cod_categoria=obtenerCodigo($sql);


$sql="insert into clientes_categorias set ";
$sql.=" cod_categoria=".$cod_categoria.","; 
$sql.=" desc_categoria='".$desc_categoria."',"; 
$sql.=" obs_categoria='".$obs_categoria."',"; 
$sql.=" cod_estado_registro=".$cod_estado_registro.",";
$sql.=" cod_usuario_registro=".$_COOKIE['usuario_global'].",";
$sql.=" fecha_registro='".date('Y-m-d', time())."'";
//$sql.=" cod_usuario_modifica='".$obs_cargo."',";
//$sql.=" fecha_modifica='".$obs_cargo."'";
mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorClientesCategorias.php";
</script>