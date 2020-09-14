<?php
require("conexion.inc");
include("funciones.php");
	$cod_gasto_hojaruta=$_POST['cod_gasto_hojaruta'];
	$recibo_gasto=$_POST['recibo_gasto'];
	$fecha_gasto=$_POST['fecha_gasto'];
	list($dI,$mI,$aI)=explode("/",$fecha_gasto);
	$cod_proveedor=$_POST['cod_proveedor'];
	$cod_gasto=$_POST['cod_gasto'];
	$descripcion_gasto=$_POST['descripcion_gasto'];
	$cant_gasto=$_POST['cant_gasto'];
	$monto_gasto=$_POST['monto_gasto'];

			
		$sql2=" update gastos_hojasrutas set ";
		$sql2.=" cod_gasto=".$cod_gasto.",";
		$sql2.=" fecha_gasto='".$aI."-".$mI."-".$dI."',";
		if($cant_gasto<>""){
		$sql2.=" cant_gasto=".$cant_gasto.",";
		}
		$sql2.=" monto_gasto=".$monto_gasto.",";
		$sql2.=" descripcion_gasto='".$descripcion_gasto."',";
		$sql2.=" cod_proveedor=".$cod_proveedor.","; 
		$sql2.=" recibo_gasto='".$recibo_gasto."',";
		$sql2.=" cod_usuario_modifica=".$_COOKIE['usuario_global'].",";
		$sql2.=" fecha_modifica='".date('Y-m-d', time())."'";
		$sql2.=" where  cod_gasto_hojaruta=".$cod_gasto_hojaruta."";

	
		mysql_query($sql2);
		//echo $sql2;


require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listGastoHojaRuta.php?cod_hoja_ruta=<?php echo $_POST['cod_hoja_ruta']; ?>";
</script>