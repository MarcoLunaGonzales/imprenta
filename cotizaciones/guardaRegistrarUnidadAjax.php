<?php
require("conexion.inc");
include("funciones.php");




$sql=" select max(cod_unidad) from clientes_unidades ";
$cod_unidad=obtenerCodigo($sql);
$sql="insert into clientes_unidades set ";
$sql.=" cod_unidad=".$cod_unidad.",";
$sql.=" nombre_unidad='".$_POST['nombre_unidad']."',";
$sql.=" direccion_unidad='".$_POST['direccion_unidad']."',";
$sql.=" telf_unidad='".$_POST['telf_unidad']."',";
$sql.=" cod_cliente=".$_POST['cod_cliente'].",";
$sql.=" cod_usuario_registro=".$_COOKIE['usuario_global'].",";
$sql.=" fecha_registro='".date('Y-m-d', time())."'";
echo $sql;

mysql_query($sql);
require("cerrar_conexion.inc");

?>
<script language="JavaScript">
			url="ajax_listaUnidades.php?cod_cliente=<?php echo $_POST['cod_cliente'];?>&cod_unidad=<?php echo $cod_unidad;?>";
			window.close();
		window.opener.cargar_unidad_ajax(url);
</script> 