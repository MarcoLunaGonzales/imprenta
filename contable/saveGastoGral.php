<?php
require("conexion.inc");
include("funciones.php");


	list($dI,$mI,$aI)=explode("/",$_POST['fecha_gasto_gral']);
	
		
	$cod_gestion=gestionActiva();
	$sql="select max(cod_gasto_gral) from gastos_gral ";
	$cod_gasto_gral=obtenerCodigo($sql);
	$sql=" select max(nro_gasto_gral) from gastos_gral where cod_gestion='".$cod_gestion."'";
	$nro_gasto_gral=obtenerCodigo($sql);
	
	
	$sql=" insert into gastos_gral set ";
	$sql.=" cod_gasto_gral='".$cod_gasto_gral."',";
	$sql.=" cod_gestion='".$cod_gestion."',";
	$sql.=" nro_gasto_gral='".$nro_gasto_gral."',";
	if($_POST['cod_tipo_doc']<>null && $_POST['cod_tipo_doc']<>"" ){
		$sql.=" cod_tipo_doc='".$_POST['cod_tipo_doc']."',";
		$sql.=" codigo_doc='".$_POST['codigo_doc']."',";
	}
	if($_POST['cod_proveedor']<>null && $_POST['cod_proveedor']<>"" ){
		$sql.=" cod_proveedor='".$_POST['cod_proveedor']."',";
	}
	$sql.=" fecha_gasto_gral='".$aI."-".$mI."-".$dI."',";
	$sql.=" nro_recibo='".$_POST['nro_recibo']."',";
	$sql.=" monto_gasto_gral=".$_POST['monto_gasto_gral'].",";
	$sql.=" cant_gasto_gral='".$_POST['cant_gasto_gral']."',";
	$sql.=" desc_gasto_gral='".$_POST['desc_gasto_gral']."',";
	$sql.=" cod_gasto='".$_POST['cod_gasto']."',";
	$sql.=" cod_tipo_pago='".$_POST['cod_tipo_pago']."',";
	$sql.=" cod_estado_pago_doc=1,";
	$sql.=" fecha_registro='".date('Y-m-d h:i:s', time())."',";
	$sql.=" cod_usuario_registro='".$_COOKIE['usuario_global']."',";
	$sql.=" cod_estado=1";
	/*$sql.=" fecha_modifica='".."'";
	$sql.=" cod_usuario_modifica='".."'";*/

	mysql_query($sql);
	//echo $sql;


require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listGastosGral.php?cod_gasto_gral=<?php echo $_POST['cod_gasto_gral']; ?>";
</script>