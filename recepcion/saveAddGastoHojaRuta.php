<?php
require("conexion.inc");
include("funciones.php");

$sql2=" delete from gastos_hojasrutas where cod_hoja_ruta=".$_POST['cod_hoja_ruta'];
mysql_query($sql2);


$sql=" select cod_gasto,desc_gasto from gastos where cod_estado_registro=1 ";
$resp = mysql_query($sql);
while($dat=mysql_fetch_array($resp)){
	
	$cod_gasto=$dat['cod_gasto'];
	$desc_gasto=$dat['desc_gasto'];
	echo $desc_gasto."=".$_POST['cod_gasto'.$cod_gasto]."<br>";
	if($_POST['cod_gasto'.$cod_gasto]=='on'){
		
		$sql2=" insert into gastos_hojasrutas set";
		$sql2.=" cod_gasto=".$cod_gasto.",";
		$sql2.=" cod_hoja_ruta=".$_POST['cod_hoja_ruta'].",";
		$sql2.=" monto_gasto=".$_POST['monto_gasto'.$cod_gasto];
		mysql_query($sql2);
	}

}


require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listGastoHojaRuta.php?cod_hoja_ruta=<?php echo $_POST['cod_hoja_ruta']; ?>";
</script>