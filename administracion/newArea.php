<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>INVENTA</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script language='Javascript'>

	function cancelar(){
			window.location="listAreas.php";
	}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="saveArea.php">
<?php 
	require("conexion.inc");
	$cod_estado_registro=1;
	$sql2=" select nombre_estado_registro from estados_referenciales where cod_estado_registro='".$cod_estado_registro."'";
    $resp2 = mysql_query($sql2);	
	$nombre_estado_registro="";
	$dat2=mysql_fetch_array($resp2);
	$nombre_estado_registro=$dat2[0];

?>
<h3 align="center" style="background:#F7F5F3;font-size: 14px;color: #E78611;font-weight:bold;">REGISTRO DE AREA</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Introduzca Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Area</td>
      		<td><span id="sprytextfield1">
      		  <label for="nombre_area"></label>
      		  <input type="text" name="nombre_area" id="nombre_area" class="textoform">
   		    <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
      		<td><span id="sprytextarea1">
      		  <label for="obs_area"></label>
      		  <textarea name="obs_area" id="obs_area" cols="45" rows="3" class="textoform"></textarea>
</span></td>
    	</tr>
		<tr bgcolor="#FFFFFF">
     		<td>Estado de Registro</td>
      		<td><?php echo $nombre_estado_registro;?></td>
    	</tr>		
										
		</tbody>
	</table>	
	<br>
<div align="center">
<INPUT type="submit" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
<INPUT type="button"  class="boton"  name="btn_limpiar" value="Cancelar" onClick="cancelar();"  >
</div>
</form>
<?php require("cerrar_conexion.inc");?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false});
</script>
</body>
</html>
