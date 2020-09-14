<?php
require("conexion.inc");
include("funciones.php");

$nombre_proveedor=$_POST['nombre_proveedor'];
$cod_ciudad=$_POST['cod_ciudad'];
$telefono_proveedor=$_POST['telefono_proveedor'];
$mail_proveedor=$_POST['mail_proveedor'];
$direccion_proveedor=$_POST['direccion_proveedor'];
$contacto1_proveedor=$_POST['contacto1_proveedor'];
$cel_contacto1_proveedor=$_POST['cel_contacto1_proveedor'];
$contacto2_proveedor=$_POST['contacto2_proveedor'];
$cel_contacto2_proveedor=$_POST['cel_contacto2_proveedor'];
$datos_grupos=$_POST['datos_grupos'];

$cod_estado_registro=1;

$sql=" select max(cod_proveedor) from proveedores ";
$cod_proveedor=obtenerCodigo($sql);

$sql="insert into proveedores set ";
$sql.=" cod_proveedor='".$cod_proveedor."',"; 
$sql.=" nombre_proveedor='".$nombre_proveedor."',"; 
$sql.=" cod_ciudad='".$cod_ciudad."',";
$sql.=" telefono_proveedor='".$telefono_proveedor."',";
$sql.=" mail_proveedor='".$mail_proveedor."',";
$sql.=" direccion_proveedor='".$direccion_proveedor."',";
$sql.=" contacto1_proveedor='".$contacto1_proveedor."',";
$sql.=" cel_contacto1_proveedor='".$cel_contacto1_proveedor."',";
$sql.=" contacto2_proveedor='".$contacto2_proveedor."',";
$sql.=" cel_contacto2_proveedor='".$cel_contacto2_proveedor."',";
$sql.=" cod_usuario_registro='".$_COOKIE['usuario_global']."',"; 
$sql.=" fecha_registro='".date('Y/m/d', time())."',"; 
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
$resp=mysql_query($sql);


	$sql="delete from proveedores_grupos where cod_proveedor='".$cod_proveedor."'"; 
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
	require("cerrar_conexion.inc");

?>
<script language="JavaScript">
			url="ajax_listaProveedor.php?cod_proveedor=<?php echo $cod_proveedor;?>";
			window.close();
			window.opener.cargar_proveedor_ajax(url);
</script> 