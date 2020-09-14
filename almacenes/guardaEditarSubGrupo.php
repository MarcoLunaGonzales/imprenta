<?php
require("conexion.inc");
include("funciones.php");

$cod_grupo=$_POST['cod_grupo'];
$cod_subgrupo=$_POST['cod_subgrupo'];
$nombre_subgrupo=$_POST['nombre_subgrupo'];
$abrev_subgrupo=$_POST['abrev_subgrupo'];
$cod_estado_registro=$_POST['cod_estado_registro'];


$sql="update subgrupos set ";
$sql.=" cod_grupo='".$cod_grupo."',";
$sql.=" nombre_subgrupo='".$nombre_subgrupo."',";
$sql.=" abrev_subgrupo='".$abrev_subgrupo."',";
$sql.=" cod_usuario_modifica='".$_COOKIE['usuario_global']."',"; 
$sql.=" fecha_modifica='".date('Y/m/d', time())."',"; 
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
$sql.=" where cod_subgrupo='".$cod_subgrupo."' ";
mysql_query($sql);


require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorSubGrupos.php?cod_grupo=<?php echo $cod_grupo;?>";
</script>