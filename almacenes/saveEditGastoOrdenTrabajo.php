<?php
require("conexion.inc");
include("funciones.php");

	$recibo_gasto=$_POST['recibo_gasto'];
	$fecha_gasto=$_POST['fecha_gasto'];
	list($dI,$mI,$aI)=explode("/",$fecha_gasto);
	$cod_proveedor=$_POST['cod_proveedor'];
	$cod_contacto_proveedor=$_POST['cod_contacto_proveedor'];
	$cod_gasto=$_POST['cod_gasto'];
	$descripcion_gasto=$_POST['descripcion_gasto'];
	$cant_gasto=$_POST['cant_gasto'];
	$monto_gasto=$_POST['monto_gasto'];

		$sql2=" update  gastos_ordentrabajo set ";
		$sql2.=" cod_gasto=".$cod_gasto.",";
		$sql2.=" fecha_gasto='".$aI."-".$mI."-".$dI."',";
		$sql2.=" cant_gasto='".$cant_gasto."',";
		$sql2.=" monto_gasto=".$monto_gasto.",";
		$sql2.=" descripcion_gasto='".$descripcion_gasto."',";
		$sql2.=" cod_proveedor=".$cod_proveedor.","; 
		$sql2.=" cod_contacto_proveedor=".$cod_contacto_proveedor.","; 
		$sql2.=" recibo_gasto='".$recibo_gasto."',";
		$sql2.=" cod_usuario_modifica=".$_COOKIE['usuario_global'].",";
		$sql2.=" fecha_modifica='".date('Y-m-d', time())."'";
		$sql2.=" where cod_gasto_ordentrabajo=".$_POST['cod_gasto_ordentrabajo']."";

		mysql_query($sql2);



require("cerrar_conexion.inc");
?>
<script language="JavaScript">
		location.href="listGastoOrdenTrabajo.php?cod_orden_trabajo=<?php echo $_POST['cod_orden_trabajo']; ?>";
</script>