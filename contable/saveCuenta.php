<?php
require("conexion.inc");
include("funciones.php");


$sql=" select max(cod_cuenta) from cuentas ";
$cod_cuenta=obtenerCodigo($sql);

$sql="insert into cuentas set ";
$sql.=" cod_cuenta='".$cod_cuenta."',"; 
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
$sql.=" cod_usuario_registro='".$_COOKIE['usuario_global']."',";
$sql.=" fecha_registro='".date('Y-m-d H:i:s', time())."'";
//echo $sql;
mysql_query($sql);

if($_POST['cod_cliente']!=NULL){

	$sql=" update clientes set ";
	$sql.=" cod_cuenta=".$cod_cuenta;
	$sql.=" where cod_cliente=".$_POST['cod_cliente'];
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
	location.href="listCuentas.php?cod_cuenta=<?php echo $cod_cuenta;?>";
</script>