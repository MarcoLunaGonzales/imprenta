<?php
require("conexion.inc");
include("funciones.php");

$cod_grupo=$_POST['cod_grupo'];
$nombre_subgrupo=$_POST['nombre_subgrupo'];
$abrev_subgrupo=$_POST['abrev_subgrupo'];
$cod_estado_registro=1;

$sql="select max(cod_subgrupo) from subgrupos";
$cod_subgrupo=obtenerCodigo($sql);

$sql="insert into subgrupos set ";
$sql.=" cod_subgrupo='".$cod_subgrupo."', ";
$sql.=" cod_grupo='".$cod_grupo."',";
$sql.=" nombre_subgrupo='".$nombre_subgrupo."',";
$sql.=" abrev_subgrupo='".$abrev_subgrupo."',";
$sql.=" cod_usuario_registro='".$_COOKIE['usuario_global']."',"; 
$sql.=" fecha_registro='".date('Y/m/d', time())."',"; 
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
mysql_query($sql);


require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorSubGrupos.php?cod_grupo=<?php echo $cod_grupo;?>";
</script>