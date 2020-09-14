<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>Cotizaciones</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script language='Javascript'>








</script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF">
<form name="form1" method="post"  id="form1" target="_blank" action="rptCotizacionesItem.php">
<?php
	require("conexion.inc");
	include("funciones.php");
	

?>
<h3 align="center" style="background:#F7F5F3;font-size: 14px;color: #E78611;font-weight:bold;">REPORTE DE COTIZACIONES POR ITEM</h3>

<table border="0" align="center">
<tr>
<td><strong>Nro de Cotizacion</strong></td>
<td colspan="3"><input type="text" name="nrocotizacionB" id="nrocotizacionB" size="10" class="textoform" onkeyup="buscar()" value="<?php echo $nrocotizacionB;?>" ></td>
</tr>
<tr>
  <td><strong>Estado de Cotizacion</strong></td>
<td colspan="3">
<select name="codEstadoCotizacionB" id="codEstadoCotizacionB" class="textoform" >
				<option value="0">Seleccione una Opcion</option>
				<?php
					$sql2="select cod_estado_cotizacion, nombre_estado_cotizacion from estados_cotizacion";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_estado_cotizacion=$dat2['cod_estado_cotizacion'];	
			  		 		$nombre_estado_cotizacion=$dat2['nombre_estado_cotizacion'];	
				 ?>
				  <option value="<?php echo $cod_estado_cotizacion;?>" <?php if($cod_estado_cotizacion==$codEstadoCotizacionB){?> selected="selected" <?php }?>><?php echo $nombre_estado_cotizacion;?></option>				
				<?php		
					}
				?>						
</select></td>
</tr>
<tr>
  <td><strong>Tipo de Cotizacion</strong></td>
<td colspan="3">
<select name="codTipoCotizacionB" id="codTipoCotizacionB" class="textoform" >
				<option value="0">Seleccione una Opcion</option>
				<?php
					$sql2="select cod_tipo_cotizacion, nombre_tipo_cotizacion from tipos_cotizacion";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_tipo_cotizacion=$dat2['cod_tipo_cotizacion'];	
			  		 		$nombre_tipo_cotizacion=$dat2['nombre_tipo_cotizacion'];	
				 ?>
				  <option value="<?php echo $cod_tipo_cotizacion;?>" <?php if($cod_tipo_cotizacion==$codTipoCotizacionB){?> selected="selected" <?php }?>><?php echo $nombre_tipo_cotizacion;?></option>				
				<?php		
					}
				?>						
</select></td>
</tr>
<tr>
<td><strong>Clientes</strong></td>
<td colspan="3">
 <input name="nombreClienteB" id="nombreClienteB" size="40" class="textoform" value="<?php echo $nombreClienteB; ?>" >
	</td>

</tr>

<tr>
<td><strong>Item</strong></td>
<td colspan="3"><input type="text" name="descItemB" id="descItemB" size="40" value="<?php echo $descItemB;?>" class="textoform" ></td>
</tr>
<tr >
     		<td>&nbsp;<b>Rango de Fecha</b>&nbsp;</td>			
     		<td>De&nbsp;<span id="sprytextfield1">
                <label for="fechaInicioB"></label>
                <input type="text" name="fechaInicioB" id="fechaInicioB" class="textoform" value="<?php echo $fechaInicioB; ?>">
<span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
        &nbsp;Hasta&nbsp;<span id="sprytextfield2">
        <label for="fechaFinalB"></label>
        <input type="text" name="fechaFinalB" id="fechaFinalB" class="textoform" value="<?php echo $fechaFinalB; ?>" >
<span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>

			</td>
    	</tr>

</table>
<br/>
<div align="center"><input type="submit" name="aceptar" class="boton" value="VER REPORTE"> </div>
<?php require("cerrar_conexion.inc");
?>
<br>

</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"dd/mm/yyyy", isRequired:false, validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"dd/mm/yyyy", isRequired:false, validateOn:["change"]});
</script>
</body>
</html>
