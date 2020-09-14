<?php
require("conexion.inc");
include("funciones.php");

$cod_cliente=$_POST['cod_cliente'];
$nombre_cliente=$_POST['nombre_cliente'];
$nit_cliente=$_POST['nit_cliente'];
$cod_categoria=$_POST['cod_categoria'];
$cod_ciudad=$_POST['cod_ciudad'];
$direccion_cliente=$_POST['direccion_cliente'];
$telefono_cliente=$_POST['telefono_cliente'];
$celular_cliente=$_POST['celular_cliente'];
$fax_cliente=$_POST['fax_cliente'];
$email_cliente=$_POST['email_cliente'];
$obs_cliente=$_POST['obs_cliente'];
$cod_usuario_registro=$_POST['cod_usuario_registro'];
$fecha_registro=$_POST['fecha_registro'];
$cod_usuario_modifica=$_POST['cod_usuario_modifica'];
$fecha_modifica=$_POST['fecha_modifica'];
$cod_estado_registro=$_POST['cod_estado_registro'];




$sql="update  clientes set ";
$sql.=" nombre_cliente='".$nombre_cliente."',"; 
$sql.=" nit_cliente='".$nit_cliente."',";
$sql.=" cod_categoria='".$cod_categoria."',";
$sql.=" cod_ciudad='".$cod_ciudad."',";
$sql.=" direccion_cliente='".$direccion_cliente."',";
$sql.=" telefono_cliente='".$telefono_cliente."',";
$sql.=" celular_cliente='".$celular_cliente."',";
$sql.=" fax_cliente='".$fax_cliente."',";
$sql.=" email_cliente='".$email_cliente."',";
$sql.=" obs_cliente='".$obs_cliente."',";
$sql.=" cod_usuario_modifica='".$_COOKIE['usuario_global']."',"; 
$sql.=" fecha_modifica='".date('Y-m-d', time())."',"; 
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
$sql.=" where cod_cliente='".$cod_cliente."'"; 
$resp=mysql_query($sql);
require("cerrar_conexion.inc");

?>
<script language="JavaScript">
			url="ajax_listaClientes.php?cod_cliente=<?php echo $cod_cliente;?>";
			window.close();
			window.opener.cargar_cliente_ajax(url);
</script> 