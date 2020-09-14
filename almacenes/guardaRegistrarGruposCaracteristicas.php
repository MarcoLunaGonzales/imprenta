<?php
require("conexion.inc");
include("funciones.php");

$cod_grupo=$_POST['cod_grupo'];
$nombre_grupo_carac=$_POST['nombre_grupo_carac'];
$orden=$_POST['orden'];
$cod_estado_registro=1;

$sql="select max(cod_grupo_carac) from grupos_caracteristicas";
$cod_grupo_carac=obtenerCodigo($sql);

$sql="insert into grupos_caracteristicas set ";
$sql.=" cod_grupo_carac='".$cod_grupo_carac."', ";
$sql.=" cod_grupo='".$cod_grupo."',";
$sql.=" nombre_grupo_carac='".$nombre_grupo_carac."',";
$sql.=" orden='".$orden."',";
$sql.=" cod_usuario_registro='".$_COOKIE['usuario_global']."',"; 
$sql.=" fecha_registro='".date('Y/m/d', time())."',"; 
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
mysql_query($sql);


require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorGruposCaracteristicas.php?cod_grupo=<?php echo $cod_grupo;?>";
</script>