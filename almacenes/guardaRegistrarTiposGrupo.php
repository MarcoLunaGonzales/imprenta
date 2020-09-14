<?php
require("conexion.inc");
include("funciones.php");

$cod_grupo=$_POST['cod_grupo'];
$nombre_tipo_grupo=$_POST['nombre_tipo_grupo'];

$sql="select max(cod_tipo_grupo) from tipos_grupo";


$sql="insert into tipos_grupo set ";
$sql.=" cod_tipo_grupo='".$codItemF."', ";
$sql.=" cod_compitem='".$codCompItem."',";
$sql.=" nombre_componenteitem='".$nombre_componenteitem."'";
$resp=mysql_query($sql);

$datos=$_POST['datos'];
$vector_datos=explode(",",$datos);	
$n=sizeof($vector_datos);
for($i=0;$i<$n;$i++){
			
	$vector_extra=explode("|",$vector_datos[$i]);
	$cod_carac=$vector_extra[0];
	$orden=$vector_extra[1];
	
	$sql=" insert into componentes_caracteristica set";
	$sql.="  cod_compitem='".$codCompItem."',";
	$sql.="  cod_carac='".$cod_carac."',";
	$sql.="  orden='".$orden."'";

	mysql_query($sql);				
}	
	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorTiposGrupo.php?cod_grupo=<?php echo $codItemF;?>";
</script>