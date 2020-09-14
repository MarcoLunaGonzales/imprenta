<?php
require("conexion.inc");
include("funciones.php");
	$cod_gasto_hojaruta=$_GET['cod_gasto_hojaruta'];
	
$sql2="select cod_hoja_ruta from gastos_hojasrutas where cod_gasto_hojaruta=".$cod_gasto_hojaruta;
  $resp = mysql_query($sql2);
 while($dat=mysql_fetch_array($resp)){
	 $cod_hoja_ruta=$dat['cod_hoja_ruta'];
 }
			
		$sql2=" delete from gastos_hojasrutas ";
		$sql2.=" where  cod_gasto_hojaruta=".$cod_gasto_hojaruta."";	
		mysql_query($sql2);
		//echo $sql2;


require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listGastoHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta; ?>";
</script>