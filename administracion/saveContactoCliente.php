<?php
require("conexion.inc");
include("funciones.php");

$cod_cliente=$_POST['cod_cliente'];
$nombre_contacto=$_POST['nombre_contacto'];
$ap_paterno_contacto=$_POST['ap_paterno_contacto'];
$ap_materno_contacto=$_POST['ap_materno_contacto'];
$cargo_contacto=$_POST['cargo_contacto'];
$direccion_cliente=$_POST['direccion_contacto'];
$telefono_cliente=$_POST['telefono_contacto'];
$celular_cliente=$_POST['celular_contacto'];
$fax_cliente=$_POST['fax_contacto'];
$email_cliente=$_POST['email_contacto'];


$sql=" select max(cod_contacto) from clientes_contactos ";
$cod_contacto=obtenerCodigo($sql);
$sql="insert into clientes_contactos set ";
$sql.=" cod_contacto=".$cod_contacto.",";
$sql.=" cod_cliente=".$_POST['cod_cliente'].",";
$sql.=" nombre_contacto='".$_POST['nombre_contacto']."',";
$sql.=" ap_paterno_contacto='".$_POST['ap_paterno_contacto']."',";
$sql.=" ap_materno_contacto='".$_POST['ap_materno_contacto']."',";
$sql.=" telefono_contacto='".$_POST['telefono_contacto']."',";
$sql.=" celular_contacto='".$_POST['celular_contacto']."',";
$sql.=" email_contacto='".$_POST['email_contacto']."',";
$sql.=" cargo_contacto='".$_POST['cargo_contacto']."',";
$sql.=" cod_estado_registro='".$cod_estado_registro."',";
$sql.=" cod_usuario_registro=".$_COOKIE['usuario_global'].",";
$sql.=" fecha_registro='".date('Y-m-d H:i:s', time())."'";


mysql_query($sql);
require("cerrar_conexion.inc");

?>
<script language="JavaScript">
location.href="listContactosClientes.php?cod_cliente=<?php echo $_POST['cod_cliente'];?>&clienteContactoB=<?php echo $_POST['nombre_cliente'];?>";

</script> 