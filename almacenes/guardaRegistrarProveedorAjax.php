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


	/*$sql="delete from proveedores_grupos where cod_proveedor='".$cod_proveedor."'"; 
	mysql_query($sql);
		
	$vector_datos=explode(",",$datos_grupos);	
	$n=sizeof($vector_datos);
	for($i=0;$i<$n;$i++){			
		$cod_grupo=$vector_datos[$i];
		$sql="insert into proveedores_grupos set ";
		$sql.=" cod_proveedor='".$cod_proveedor."',"; 
		$sql.=" cod_grupo='".$cod_grupo."'"; 
		mysql_query($sql);				
	}
	require("cerrar_conexion.inc");*/

?>
<script language="JavaScript">
			window.close();
			window.opener.setProveedores('<?php echo $cod_proveedor;?>','<?php echo $_POST['nombre_proveedor'];?>');
</script> 