<?php
require("conexion.inc");
include("funciones.php");

$sql="update proveedores set ";
$sql.=" nit_proveedor='".$_POST['nit_proveedor']."',";
if($_POST['cod_cuenta']!='' and $_POST['cod_cuenta']!= null){
$sql.=" cod_cuenta='".$_POST['cod_cuenta']."',";
}else{
$sql.=" cod_cuenta=null,";
}
$sql.=" cod_usuario_modifica='".$_COOKIE['usuario_global']."',"; 
$sql.=" fecha_modifica='".date('Y/m/d', time())."'"; 
$sql.=" where cod_proveedor='".$_POST['cod_proveedor']."'";
//echo $sql;
mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listProveedoresCuentas.php";
</script>