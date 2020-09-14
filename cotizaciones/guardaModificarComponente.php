<?php
require("conexion.inc");
include("funciones.php");
$codItem=$_POST['codItem'];
$codCompItem=$_POST['codCompItem'];
$nombre_componenteitem=$_POST['nombre_componenteitem'];
$datos=$_POST['datos'];
/*echo $codItem."<br>";
echo $codCompItem."<br>";
echo $nombre_componenteitem."<br>";
echo $datos."<br>";*/

$sql="update componente_items set ";
$sql.=" nombre_componenteitem='".$nombre_componenteitem."'";
$sql.=" where cod_item='".$codItem."' ";
$sql.=" and cod_compitem='".$codCompItem."' ";
//echo $sql."<br>";
mysql_query($sql);

$sql=" delete from componentes_caracteristica where cod_compitem='".$codCompItem."' ";
//echo $sql."<br>";
mysql_query($sql);



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
	//echo $sql."<br>";

	mysql_query($sql);				
}	


require("cerrar_conexion.inc");
?>
<script language="JavaScript">
	location.href="navegadorComponente.php?codigo=<?php echo $codItem;?>";
</script>