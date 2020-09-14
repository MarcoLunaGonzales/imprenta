<?php
require("conexion.inc");
include("funciones.php");


$cod_estado_registro=1;

$sql=" select max(cod_proveedor) from proveedores ";
$cod_proveedor=obtenerCodigo($sql);

$sql="insert into proveedores set ";
$sql.=" cod_proveedor='".$cod_proveedor."',"; 
$sql.=" nombre_proveedor='".$_POST['nombre_proveedor']."',"; 
$sql.=" nit_proveedor='".$_POST['nit_proveedor']."',";
$sql.=" cod_ciudad='".$_POST['cod_ciudad']."',";
$sql.=" direccion_proveedor='".$_POST['direccion_proveedor']."',";
$sql.=" telefono_proveedor='".$_POST['telefono_proveedor']."',";
$sql.=" celular_proveedor='".$_POST['celular_proveedor']."',";
$sql.=" fax_proveedor='".$_POST['fax_proveedor']."',";
$sql.=" mail_proveedor='".$_POST['mail_proveedor']."',";
$sql.=" obs_proveedor='".$_POST['obs_proveedor']."',";
$sql.=" cod_usuario_registro='".$_COOKIE['usuario_global']."',"; 
$sql.=" fecha_registro='".date('Y/m/d', time())."',"; 
/*$sql.=" cod_usuario_modifica='".."',";
$sql.=" fecha_modifica='".."',";*/
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
$resp=mysql_query($sql);
//echo $sql;

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
	location.href="listProveedores.php";
</script>