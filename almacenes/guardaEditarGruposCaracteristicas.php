<?php
require("conexion.inc");
include("funciones.php");

$cod_grupo=$_POST['cod_grupo'];
$cod_grupo_carac=$_POST['cod_grupo_carac'];
$nombre_grupo_carac=$_POST['nombre_grupo_carac'];
$orden=$_POST['orden'];
$cod_estado_registro=$_POST['cod_estado_registro'];


$sql="update grupos_caracteristicas set ";
$sql.=" cod_grupo='".$cod_grupo."',";
$sql.=" nombre_grupo_carac='".$nombre_grupo_carac."',";
$sql.=" orden='".$orden."',";
$sql.=" cod_usuario_modifica='".$_COOKIE['usuario_global']."',"; 
$sql.=" fecha_modifica='".date('Y/m/d', time())."',"; 
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
$sql.=" where cod_grupo_carac='".$cod_grupo_carac."' ";
mysql_query($sql);


require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorGruposCaracteristicas.php?cod_grupo=<?php echo $cod_grupo;?>";
</script>