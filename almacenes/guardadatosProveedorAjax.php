<?php
require("conexion.inc");
include("funciones.php");


$sql="update  proveedores set ";
$sql.=" nombre_proveedor='".$_POST['nombre_proveedor']."',"; 
$sql.=" nit_proveedor='".$_POST['nit_proveedor']."',";
$sql.=" cod_ciudad='".$_POST['cod_ciudad']."',";
$sql.=" direccion_proveedor='".$_POST['direccion_proveedor']."',";
$sql.=" telefono_proveedor='".$_POST['telefono_proveedor']."',";
$sql.=" celular_proveedor='".$_POST['celular_proveedor']."',";
$sql.=" fax_proveedor='".$_POST['fax_proveedor']."',";
$sql.=" mail_proveedor='".$_POST['mail_proveedor']."',";
$sql.=" obs_proveedor='".$_POST['obs_proveedor']."',";
$sql.=" cod_usuario_modifica='".$_COOKIE['usuario_global']."',"; 
$sql.=" fecha_modifica='".date('Y/m/d', time())."',"; 
$sql.=" cod_estado_registro='".$_POST['cod_estado_registro']."'";
$sql.=" where cod_proveedor='".$_POST['cod_proveedor']."'"; 
$resp=mysql_query($sql);
require("cerrar_conexion.inc");

?>
<script language="JavaScript">

			window.opener.setProveedores('<?php echo $cod_proveedor;?>','<?php echo $_POST['nombre_proveedor'];?>');
	location.href="datosProveedorAjax.php?cod_proveedor=<?php echo $_POST['cod_proveedor'];?>";
</script> 