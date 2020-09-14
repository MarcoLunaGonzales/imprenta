<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>INVENTA</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="guardaGenerarBingo.php">
<?php 
	require("conexion.inc");
	$cod_estado_registro=1;
	$sql2=" select nombre_estado_registro from estados_referenciales where cod_estado_registro='".$cod_estado_registro."'";
    $resp2 = mysql_query($sql2);	
	$nombre_estado_registro="";
	$dat2=mysql_fetch_array($resp2);
	$nombre_estado_registro=$dat2[0];

?>
<h3 align="center" style="background:#F7F5F3;font-size: 14px;color: #E78611;font-weight:bold;">GENERACION DE CARTONES BINGO </h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Introduzca Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Nro de Cartones</td>
      		<td>
      		  <input type="text" name="nro_cartones" id="nro_cartones" value="0" class="textoform">
   		   </td>
    	</tr>
	
										
		</tbody>
	</table>	
	<br/>
<div align="center">
<INPUT type="submit" class="boton" name="btn_guardar" value="Aceptar"  >

</div>
</form>
<?php require("cerrar_conexion.inc");?>

</body>
</html>
