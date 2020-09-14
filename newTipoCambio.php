<html><head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<title>INVENTA</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo1 {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-weight: bold;
	color: #363020;
}
.Estilo3 {color: #363020}
.Estilo5 {color: #000000}
.Estilo8 {color: #363020; font-size: 12px; }
-->
</style>
</head>
<body style="margin: 0pt; padding: 0pt; background: rgb(199, 200, 200) url(images/tall.jpg) repeat-x scroll left bottom; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;">
<div align="center">
<?php
require("conexion_inicio.inc");
	$sql=" select  nombres_usuario, ap_paterno_usuario, ap_materno_usuario,cod_perfil  from usuarios ";
	$sql.=" where cod_usuario='".$_COOKIE['usuario_global']."'";
	$resp=mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
	
		$nombres_usuario=$dat[0]; 
		$ap_paterno_usuario=$dat[1];
		$ap_materno_usuario=$dat[2];
		$cod_perfil=$dat[3];

		
	}
?>	
<table width="980" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff" id="Table_01" >
	<tbody>
	<tr>
		<td colspan="3">
			<img src="images/headerinventa.jpg" alt="" ></td>
	</tr>
	<tr>
		<td colspan="3"><img src="images/barraheader.jpg" alt="" >
		<div style="position: absolute; top:90px; left: 400px; margin: 10px; width: 1024px;">
  <span class="cabecera"><?php echo "Bienvenido: ".$nombres_usuario." ".$ap_paterno_usuario; ?></span></div>

</td>
	</tr>
	<tr valign="top"  height="200" align="center">
		<td width="400">&nbsp;</td>	
		<td width="280"   align="center">
		<div id="member">
		  <form method="post">
			<table align="center">
	            <tr><td colspan="2">TIPO CAMBIO</td></tr>
            </table>	
		<a href="salirSistema.php">Salir del Sistema</a>	  
 		</span>
		    </form>
	</div>
	</td>
	<td width="300">&nbsp;</td>	
	</tr>	
	<tr>
	<td colspan="3"><img src="images/index_05.jpg" alt="" ></td>
	<td colspan="3"></td>
	</tr>
		<tr>
	<td colspan="3"><img src="images/pieinventa.jpg" alt="" ></td>
	</tr>
</tbody>
</table>
</div>
</body>
</html>