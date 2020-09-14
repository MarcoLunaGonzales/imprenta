<?php
require("conexion.inc");
include("funciones.php");



$sql=" select max(cod_contacto_proveedor) from proveedores_contactos ";
$cod_contacto_proveedor=obtenerCodigo($sql);
$sql="insert into proveedores_contactos set ";
$sql.=" cod_contacto_proveedor=".$cod_contacto_proveedor.",";
$sql.=" cod_proveedor=".$_POST['cod_proveedor'].",";
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
location.href="listContactosProveedor.php?cod_proveedor=<?php echo $_POST['cod_proveedor'];?>&proveedorContactoB=<?php echo $_POST['nombre_proveedor'];?>";

</script> 