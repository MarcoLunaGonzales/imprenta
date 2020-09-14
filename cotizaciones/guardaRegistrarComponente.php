<?php
require("conexion.inc");
include("funciones.php");
$nombre_componenteitem=$_POST['nombre_componenteitem'];
$codItemF=$_POST['codItemF'];
$sql="select max(cod_compitem) from componente_items";
$codCompItem=obtenerCodigo($sql);

$sql="insert into componente_items set ";
$sql.=" cod_item='".$codItemF."', ";
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
location.href="navegadorComponente.php?codigo=<?php echo $codItemF;?>";
</script>