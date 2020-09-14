<?php
require("conexion.inc");
include("funciones.php");

$sql="update clientes set ";
$sql.=" nit_cliente='".$_POST['nit_cliente']."',";
if($_POST['cod_cuenta']!='' and $_POST['cod_cuenta']!= null){
$sql.=" cod_cuenta='".$_POST['cod_cuenta']."',";
}else{
$sql.=" cod_cuenta=null,";
}
$sql.=" cod_usuario_modifica='".$_COOKIE['usuario_global']."',"; 
$sql.=" fecha_modifica='".date('Y/m/d', time())."'"; 
$sql.=" where cod_cliente='".$_POST['cod_cliente']."'";
//echo $sql;
mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listClientesCuentas.php";
</script>