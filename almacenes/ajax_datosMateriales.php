<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Nuevo Material</title>
<?php 

require("conexion.inc");
include("funciones.php");
		$cod_material=$_GET['cod_material'];
		$nombre_unidad_medida="";
		$sql=" select  abrev_unidad_medida from unidades_medidas  ";
		$sql.=" where cod_unidad_medida in(select cod_unidad_medida from materiales where cod_material=".$cod_material.")";	
		$resp= mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){
				$abrev_unidad_medida=$dat[0]; 
									
		}
	
		echo $abrev_unidad_medida;
?>



</head>
</html>