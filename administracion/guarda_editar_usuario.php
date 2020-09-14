<?php
require("conexion.inc");
include("funciones.php");
$cod_usuario=$_POST['cod_usuario'];
$nombre_usuario=$_POST['nombre_usuario'];
$ap_paterno_usuario=$_POST['ap_paterno_usuario'];
$ap_materno_usuario=$_POST['ap_materno_usuario'];
$usuario=$_POST['usuario'];
$password=$_POST['password'];
$cod_cargo=$_POST['cod_cargo'];
$cod_grado=$_POST['cod_grado'];
$cod_estado_registro=$_POST['cod_estado_registro'];



$sql="update usuarios set ";
$sql.=" nombre_usuario='".$nombre_usuario."',";
$sql.=" ap_paterno_usuario='".$ap_paterno_usuario."',";
$sql.=" ap_materno_usuario='".$ap_materno_usuario."',";
$sql.=" usuario='".$usuario."',";
$sql.=" password='".$password."',";
$sql.=" cod_cargo='".$cod_cargo."',";
$sql.=" cod_grado='".$cod_grado."',";
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
$sql.=" where cod_usuario='".$cod_usuario."' ";

$resp=mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
	location.href="navegador_usuarios.php";
</script>