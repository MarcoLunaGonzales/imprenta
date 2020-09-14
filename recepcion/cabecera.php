<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="javascript">
function salir_sistema(){

		window.close();

}
</script>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-weight: bold;
	color: #363020;
}
.Estilo2 {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 13px;
	color: #6e5d53;
}
.Estilo3 {color: #363020}
.Estilo4 {
	color: #D4D19C;
	font-weight: bold;
}
.Estilo5 {color: #000000}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>IMVENTA</title>
</head>
<body  style="margin: 0pt; padding: 0pt; background:url(images/cabecera.jpg);">


  <?php
	require("conexion.inc");
	
	$sql=" select  nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios ";
	$sql.=" where cod_usuario='".$_COOKIE['usuario_global']."'";
	$resp=mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
	$nombres_usuario=$dat[0]; 
	$ap_paterno_usuario=$dat[1];
	$ap_materno_usuario=$dat[2];
}

require("cerrar_conexion.inc");
?>

<br>
<br>
<br>
<br>

<table border="0"  width="100%">
<tr align="right"><td class="Estilo4"><?php echo "Bienvenido: ".$nombres_usuario." ".$ap_paterno_usuario;?></td><td>&nbsp;</td></tr>
</table>

</body>
</html>
