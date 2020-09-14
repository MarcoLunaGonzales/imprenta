<?php
	require("conexion.inc");
	


?>

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
			window.location="listHojasRutas.php";
	}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
</head>
<body onload="document.form1.nro_factura.focus()">
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="saveFactura.php" name="form1">

<?php 

	$cod_est_fac=1;
	$sql2=" select desc_est_fac from estado_factura where cod_est_fac='".$cod_est_fac."'";
    $resp2 = mysql_query($sql2);	
	$desc_est_fac="";
	while($dat2=mysql_fetch_array($resp2)){
		$desc_est_fac=$dat2[0];
	}

?>
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">REGISTRO DE FACTURA</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Introduzca Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Nro Factura</td>
      		<td><span id="sprytextfield1">
            <label for="nro_factura"></label>
            <input type="text" name="nro_factura" id="nro_factura" class="textoform" size="40">
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha Factura</td>
      		<td><span id="sprytextfield2">
            <label for="fecha_factura"></label>
            <input type="text"name="fecha_factura" id="fecha_factura" class="textoform" size="40" value="<?php echo date("d/m/Y");?>">
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    	</tr>        
		 <tr bgcolor="#FFFFFF">
     		<td>Cliente</td>
      		<td><span id="sprytextfield3">
      		  <label for="nombre_factura"></label>
      		  <input type="text" name="nombre_factura" id="nombre_factura" class="textoform" size="40" value="<?php echo $nombre_cliente;?>">
   		    <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>NIT</td>
      		<td><span id="sprytextfield4">
            <label for="nit_factura"></label>
            <input type="text" name="nit_factura" id="nit_factura" class="textoform" size="40">
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    	</tr>   
		 <tr bgcolor="#FFFFFF">
     		<td>Detalle</td>
      		<td><span id="sprytextarea1">
      		  <label for="detalle_factura"></label>
      		  <textarea name="detalle_factura" id="detalle_factura" cols="40" class="textoform"  rows="2"></textarea>
</span></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Monto</td>
      		<td><span id="sprytextfield5">
            <label for="monto_factura"></label>
            <input type="text"name="monto_factura"id="monto_factura" class="textoform" size="40">
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
      		<td><span id="sprytextarea2">
      		  <label for="obs_factura"></label>
      		  <textarea name="obs_factura" id="obs_factura" cols="40" rows="2" class="textoform"></textarea>
</span></td>
    	</tr>                              
		<tr bgcolor="#FFFFFF">
     		<td>Estado de Registro</td>
      		<td><?php echo $desc_est_fac;?></td>
    	</tr>		
										
		</tbody>
	</table>	
	<br>
<div align="center">
<INPUT type="submit" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
</div>
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"dd/mm/yyyy"});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "integer");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "real");
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {isRequired:false});
</script>
</body>
</html>
