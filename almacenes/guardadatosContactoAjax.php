<?php
require("conexion.inc");
include("funciones.php");






$sql="update  clientes_contactos set ";
$sql.=" nombre_contacto='".$_POST['nombre_contacto']."',";
$sql.=" ap_paterno_contacto='".$_POST['ap_paterno_contacto']."',";
$sql.=" ap_materno_contacto='".$_POST['ap_materno_contacto']."',";

$sql.=" telefono_contacto='".$_POST['telefono_contacto']."',";
$sql.=" celular_contacto='".$_POST['celular_contacto']."',";

$sql.=" email_contacto='".$_POST['email_contacto']."',";
$sql.=" cargo_contacto='".$_POST['cargo_contacto']."',";
$sql.=" cod_usuario_modifica=".$_COOKIE['usuario_global'].",";
$sql.=" fecha_modifica='".date('Y-m-d', time())."',";
$sql.=" cod_estado_registro='".$_POST['cod_estado_registro']."'";
$sql.=" where cod_contacto='".$_POST['cod_contacto']."'"; 
$resp=mysql_query($sql);
require("cerrar_conexion.inc");

?>
<script language="JavaScript">
	location.href="datosContactoAjax.php?cod_contacto=<?php echo $_POST['cod_contacto'];?>";
</script> 