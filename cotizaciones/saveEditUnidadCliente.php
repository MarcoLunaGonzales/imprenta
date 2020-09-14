<?php
require("conexion.inc");
include("funciones.php");






$sql="update  clientes_unidades set ";
$sql.=" nombre_unidad='".$_POST['nombre_unidad']."',";
$sql.=" telf_unidad='".$_POST['telf_unidad']."',";
$sql.=" cod_usuario_modifica=".$_COOKIE['usuario_global'].",";
$sql.=" fecha_modifica='".date('Y-m-d', time())."'";
$sql.=" where cod_unidad='".$_POST['cod_unidad']."'"; 
$resp=mysql_query($sql);
require("cerrar_conexion.inc");

?>
<script language="JavaScript">
	location.href="listUnidadesClientes.php?cod_cliente=<?php echo $_POST['cod_cliente'];?>";
</script> 