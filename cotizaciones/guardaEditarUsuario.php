<?php
require("conexion.inc");
include("funciones.php");

$nombres_usuario=$_POST['nombres_usuario'];
$ap_paterno_usuario=$_POST['ap_paterno_usuario'];
$ap_materno_usuario=$_POST['ap_materno_usuario'];
$cod_cargo=$_POST['cod_cargo'];
$cod_grado=$_POST['cod_grado'];
$cod_perfil=$_POST['cod_perfil'];
$usuario_interno=$_POST['usuario_interno'];
$usuario=$_POST['usuario'];
$contrasenia=$_POST['contrasenia'];

$cod_estado_registro=$_POST['cod_estado_registro'];
$autorizado_firma_cotizacion=$_POST['autorizado_firma_cotizacion'];


$sql="update usuarios set ";
$sql.=" cod_cargo=".$cod_cargo.","; 
$sql.=" cod_grado=".$cod_grado.","; 
if($cod_perfil<>""){
	$sql.=" cod_perfil=".$cod_perfil.","; 
}
$sql.=" usuario='".$usuario."',";
$sql.=" contrasenia='".$contrasenia."',";
$sql.=" nombres_usuario='".$nombres_usuario."',";
$sql.=" ap_paterno_usuario='".$ap_paterno_usuario."',";
$sql.=" ap_materno_usuario='".$ap_materno_usuario."',";
$sql.=" cod_estado_registro=".$cod_estado_registro.",";
$sql.=" usuario_interno=".$usuario_interno."";
$sql.=" where cod_usuario=".$cod_usuario.""; 
mysql_query($sql);

	$sql="delete from autorizados_firma_cotizacion where cod_usuario=".$cod_usuario.""; 
	mysql_query($sql);
if($autorizado_firma_cotizacion==1){
	$sql="insert into autorizados_firma_cotizacion set ";
	$sql.=" cod_usuario=".$cod_usuario.""; 
	mysql_query($sql);
}


require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorUsuarios.php";
</script>