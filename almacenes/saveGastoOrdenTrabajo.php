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

	$sql="select max(cod_gasto_ordentrabajo) from gastos_ordentrabajo";
	$cod_gasto_ordentrabajo=obtenerCodigo($sql);
			
		$sql2=" insert into gastos_ordentrabajo set ";
		$sql2.=" cod_gasto_ordentrabajo=".$cod_gasto_ordentrabajo.",";
		$sql2.=" cod_gasto=".$cod_gasto.",";
		$sql2.=" cod_orden_trabajo=".$_POST['cod_orden_trabajo'].",";
		$sql2.=" fecha_gasto='".$aI."-".$mI."-".$dI."',";
		if($cant_gasto<>""){
		$sql2.=" cant_gasto='".$cant_gasto."',";
		}
		$sql2.=" monto_gasto=".$monto_gasto.",";
		$sql2.=" descripcion_gasto='".$descripcion_gasto."',";
		$sql2.=" cod_proveedor=".$cod_proveedor.","; 
		if($cod_contacto_proveedor<>"" and $cod_contacto_proveedor<>0){
		$sql2.=" cod_contacto_proveedor=".$cod_contacto_proveedor.","; 
		}
		$sql2.=" recibo_gasto='".$recibo_gasto."',";
		$sql2.=" cod_usuario_registro=".$_COOKIE['usuario_global'].",";
		$sql2.=" fecha_registro='".date('Y-m-d', time())."'";

		mysql_query($sql2);



require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listGastoOrdenTrabajo.php?cod_orden_trabajo=<?php echo $_POST['cod_orden_trabajo']; ?>";
</script>