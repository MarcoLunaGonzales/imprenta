<?php
require("conexion.inc");
include("funciones.php");

$sql="update cuentas set ";
$sql.=" nro_cuenta='".$_POST['nro_cuenta']."',"; 
$sql.=" desc_cuenta='".$_POST['desc_cuenta']."',"; 
$sql.=" detalle_cuenta='".$_POST['detalle_cuenta']."',"; 
$sql.=" cod_moneda='".$_POST['cod_moneda']."',"; 
if($_POST['cod_cuenta_padre']!=NULL){
	$sql.=" cod_cuenta_padre=".$_POST['cod_cuenta_padre'].","; 
}else{
	$sql.=" cod_cuenta_padre=NULL,"; 
}
$sql.=" cod_estado_registro=1,"; 
$sql.=" cod_usuario_modifica='".$_COOKIE['usuario_global']."',";
$sql.=" fecha_modifica='".date('Y-m-d H:i:s', time())."'";
$sql.=" where cod_cuenta='".$_POST['cod_cuenta']."' "; 
mysql_query($sql);


if($_POST['codcliente']!=NULL){	
	$sql=" update clientes set ";
	$sql.=" cod_cuenta=NULL";
	$sql.=" where cod_cliente=".$_POST['codcliente'];
	//echo $sql."<br/>";
	mysql_query($sql);
}
if($_POST['cod_cliente']!=NULL){

	$sql=" update clientes set ";
	$sql.=" cod_cuenta=".$cod_cuenta;
	$sql.=" where cod_cliente=".$_POST['cod_cliente'];
	mysql_query($sql);
}

if($_POST['codproveedor']!=NULL){	
	$sql=" update proveedores set ";
	$sql.=" cod_cuenta=NULL";
	$sql.=" where cod_proveedor=".$_POST['codproveedor'];
	//echo $sql."<br/>";
	mysql_query($sql);
}
if($_POST['cod_proveedor']!=NULL){

	$sql=" update proveedores set ";
	$sql.=" cod_cuenta=".$cod_cuenta;
	$sql.=" where cod_proveedor=".$_POST['cod_proveedor'];
	mysql_query($sql);
}


require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listCuentas.php?cod_cuenta=<?php echo $_POST['cod_cuenta'];?>";
</script>