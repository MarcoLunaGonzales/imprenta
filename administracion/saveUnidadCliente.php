<?php
require("conexion.inc");
include("funciones.php");

$cod_cliente=$_POST['cod_cliente'];
$nombre_unidad=$_POST['nombre_unidad'];



$sql=" select max(cod_unidad) from clientes_unidades ";
$cod_unidad=obtenerCodigo($sql);
$sql="insert into clientes_unidades set ";
$sql.=" cod_unidad=".$cod_unidad.",";
$sql.=" cod_cliente=".$_POST['cod_cliente'].",";
$sql.=" nombre_unidad='".$_POST['nombre_unidad']."',";
$sql.=" direccion_unidad='".$_POST['direccion_unidad']."',";
$sql.=" telf_unidad='".$_POST['telf_unidad']."',";
$sql.=" cod_usuario_registro=".$_COOKIE['usuario_global'].",";
$sql.=" fecha_registro='".date('Y-m-d H:i:s', time())."'";


mysql_query($sql);
require("cerrar_conexion.inc");

?>
<script language="JavaScript">
location.href="listUnidadesClientes.php?cod_cliente=<?php echo $_POST['cod_cliente'];?>&clienteContactoB=<?php echo $_POST['nombre_cliente'];?>";

</script> 