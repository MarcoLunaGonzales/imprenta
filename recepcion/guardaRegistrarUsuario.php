<?php
require("conexion.inc");
include("funciones.php");


$cod_estado_registro=1;



$sql=" select max(cod_usuario) from usuarios ";
$cod_usuario=obtenerCodigo($sql);


$sql=" insert into usuarios  set";
$sql.=" cod_usuario='".$cod_usuario."',";
$sql.=" cod_area='".$_POST['cod_area']."',";
$sql.=" cod_cargo='".$_POST['cod_cargo']."',";
$sql.=" cod_grado='".$_POST['cod_grado']."',";
$sql.=" usuario='".$_POST['usuario']."',";
$sql.=" contrasenia='".$_POST['contrasenia']."',";
$sql.=" nombres_usuario='".$_POST['nombres_usuario']."',";
$sql.=" nombres_usuario2='".$_POST['nombres_usuario2']."',";
$sql.=" nombres_pila='".$_POST['nombres_pila']."',";
$sql.=" ap_paterno_usuario='".$_POST['ap_paterno_usuario']."',";
$sql.=" ap_materno_usuario='".$_POST['ap_materno_usuario']."',";
$sql.=" ci_usuario='".$_POST['ci_usuario']."',";
$sql.=" cod_ciudad='".$_POST['cod_ciudad']."',";
if($_POST['fecha_nac_usuario']<>""){
list($d,$m,$a)=explode("/",$_POST['fecha_nac_usuario']);
	$sql.=" fecha_nac_usuario='".$a."-".$m."-".$d."',";
}

$sql.=" telf_usuario='".$_POST['telf_usuario']."',";
$sql.=" email_usuario='".$_POST['email_usuario']."',";
$sql.=" cod_estado_registro='".$cod_estado_registro."',";
$sql.=" usuario_interno='".$_POST['usuario_interno']."',";
$sql.=" cod_perfil='".$_POST['cod_perfil']."'";
mysql_query($sql);

if($_POST['autorizado_firma_cotizacion']==1){
$sql="insert into autorizados_firma_cotizacion set ";
$sql.=" cod_usuario=".$cod_usuario.""; 
mysql_query($sql);
}

$sql="select count(*) from usuarios where cod_usuario=".$cod_usuario;
	$resp = mysql_query($sql);
	$nroReg=0;
	while($dat=mysql_fetch_array($resp)){	
		$nroReg=$dat[0];
	}

if($nroReg>0){
	$sql="delete from usuarios_modulos where cod_usuario='".$cod_usuario."'"; 
	mysql_query($sql);	
	
	
	$sql="select cod_modulo from modulos";
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){	
		$cod_modulo=$dat['cod_modulo'];
		if($_POST["cod_modulo".$cod_modulo]){
			$sql2="insert into usuarios_modulos set ";
			$sql2.=" cod_modulo='".$cod_modulo."',"; 
			$sql2.=" cod_usuario='".$cod_usuario."'"; 
			mysql_query($sql2);	

		}
	
	}
}

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listUsuarios.php";
</script>