
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

