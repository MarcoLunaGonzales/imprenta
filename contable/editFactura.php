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
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script language='Javascript'>

	function cancelar(f){
			window.location="viewFactura.php?cod_factura="+f.cod_factura.value;
	}
		function nuevoAjax()
{	var xmlhttp=false;
 		try {
 			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	 	} catch (e) {
 			try {
 				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
 			} catch (E) {
 				xmlhttp = false;
 			}
	  	}
		if (!xmlhttp && typeof XMLHttpRequest!="undefined") {
 			xmlhttp = new XMLHttpRequest();
		}
		return xmlhttp;
}
function cargar_cliente_ajax(url)
{	var div_cliente;
		div_cliente=document.getElementById("div_cliente");
		ajax=nuevoAjax();
		ajax.open("GET", url,true);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4) {
			div_cliente.innerHTML=ajax.responseText;
			}
		}
		ajax.send(null)
}	
function cargar_cliente()
{			
		izquierda = (screen.width) ? (screen.width-600)/2 : 100 
	    arriba = (screen.height) ? (screen.height-400)/2 : 100 
		url="registrarClienteAjax.php";
		opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=500,height=400,left='+izquierda+',top=' + arriba + '' 
	   	window.open(url, 'popUp', opciones);
}	
function datosCliente(f)
{	 

		var cod_cliente=document.getElementById("cod_cliente").value;
		cod_cliente=cod_cliente*1;
		if(cod_cliente!=0){
		
			izquierda = (screen.width) ? (screen.width-600)/2 : 100 
		    arriba = (screen.height) ? (screen.height-400)/2 : 100 
			url="datosClienteAjax.php?cod_cliente="+cod_cliente;
			opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=500,height=400,left='+izquierda+',top=' + arriba + '' 
		   	window.open(url, 'popUp', opciones)
			
		}else{
			alert("Seleccione un Cliente");
			
		}
}	

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
</head>
<body onload="document.form1.nro_factura.focus()">
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="saveEditFactura.php" name="form1">

<?php 

$cod_factura=$_POST['cod_factura']; 
	
	$sql=" select nro_factura, cod_cliente,nombre_factura,nit_factura, fecha_factura, detalle_factura, ";
	$sql.=" obs_factura, cod_est_fac, monto_factura, cod_usuario_registro, fecha_registro, cod_usuario_modifica, fecha_modifica ";
	$sql.=" from facturas";
	$sql.=" where cod_factura=".$cod_factura;
    $resp= mysql_query($sql);	
	while($dat=mysql_fetch_array($resp)){
		
		$nro_factura=$dat['nro_factura'];
		$codcliente=$dat['cod_cliente'];
		$nombre_factura=$dat['nombre_factura'];
		$nit_factura=$dat['nit_factura'];
		$fecha_factura=$dat['fecha_factura'];
		$detalle_factura=$dat['detalle_factura'];
		$obs_factura=$dat['obs_factura'];
		$codestfac=$dat['cod_est_fac'];
		$monto_factura=$dat['monto_factura'];
		$cod_usuario_registro=$dat['cod_usuario_registro'];
		$fecha_registro=$dat['fecha_registro'];
		$cod_usuario_modifica=$dat['cod_usuario_modifica'];
		$fecha_modifica=$dat['fecha_modifica'];
		
	}

///Datos Hoja Ruta////
	$queryFacHojaRuta="select cod_hoja_ruta from factura_hojaruta where cod_factura=".$cod_factura;
	$resp3 = mysql_query($queryFacHojaRuta);
	$cod_hoja_ruta=0;
	while($dat3=mysql_fetch_array($resp3)){
		$cod_hoja_ruta=$dat3['cod_hoja_ruta'];
	}
	
	if($cod_hoja_ruta<>0){
		$sql3=" select  hr.cod_gestion, hr.nro_hoja_ruta, g.gestion , hr.fecha_hoja_ruta, hr.cod_cotizacion, ";
		$sql3.=" c.cod_cliente, cli.nombre_cliente, cli.nit_cliente,  hr.cod_estado_hoja_ruta, ";
		$sql3.=" ehr.nombre_estado_hoja_ruta";
		$sql3.=" from hojas_rutas hr, gestiones g, estados_hojas_rutas ehr, cotizaciones c, clientes cli ";
		$sql3.=" where hr.cod_gestion=g.cod_gestion ";
		$sql3.=" and hr.cod_estado_hoja_ruta=ehr.cod_estado_hoja_ruta ";
		$sql3.=" and hr.cod_cotizacion=c.cod_cotizacion ";
		$sql3.=" and c.cod_cliente=cli.cod_cliente ";
		$sql3.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
		$resp3 = mysql_query($sql3);
		while($dat3=mysql_fetch_array($resp3)){
				$cod_gestion=$dat3['cod_gestion'];
				$nro_hoja_ruta=$dat3['nro_hoja_ruta'];
				$gestion=$dat3['gestion'];
				$fecha_hoja_ruta=$dat3['fecha_hoja_ruta'];
				$cod_cotizacion=$dat3['cod_cotizacion'];
				$cod_cliente=$dat3['cod_cliente'];
				$nombre_cliente=$dat3['nombre_cliente'];
				$nit_cliente=$dat3['nit_cliente'];
				$cod_estado_hoja_ruta=$dat3['cod_estado_hoja_ruta'];
				$nombre_estado_hoja_ruta=$dat3['nombre_estado_hoja_ruta'];
		}
					 	$sqlCotizacion=" select c.nro_cotizacion, g.gestion ";
				$sqlCotizacion.=" from cotizaciones c, gestiones g";
				$sqlCotizacion.=" where c.cod_gestion=g.cod_gestion";
				$sqlCotizacion.=" and c.cod_cotizacion=".$cod_cotizacion;
				$resp2 = mysql_query($sqlCotizacion);
				while($dat2=mysql_fetch_array($resp2)){
					$nro_cotizacion=$dat2['nro_cotizacion'];
					$gestion_cotizacion=$dat2['gestion'];
				}	
		 
	}
                				
				///Fin Datos Hoja Ruta//	
	


?>

<input type="hidden" name="cod_factura" id="cod_factura" value="<?php echo $cod_factura?>">
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">EDICION DE FACTURA</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0">
    <?php if($cod_hoja_ruta<>0){?>
<tr bgcolor="#FFFFFF">
<td colspan="2" align="right"><a href="../reportes/impresionCotizacion.php?cod_cotizacion=<?php echo $cod_cotizacion; ?>" target="_blank">Ver Cotizacion Nro. <?php echo $nro_cotizacion."/".$gestion_cotizacion;?></a></td></tr>
   
    <?php } ?>
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Introduzca Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Nro Factura</td>
      		<td><span id="sprytextfield1">
            <label for="nro_factura"></label>
            <input type="text" name="nro_factura" id="nro_factura" class="textoform" size="40" value="<?php echo $nro_factura;?>">
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha Factura</td>
      		<td><span id="sprytextfield2">
            <label for="fecha_factura"></label>
            <input type="text"name="fecha_factura" id="fecha_factura" class="textoform" size="40" value="<?php echo strftime("%d/%m/%Y",strtotime($fecha_factura));?>">
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    	</tr>        
<tr bgcolor="#FFFFFF">
     		<td>Cliente Factura</td>
      		<td>
      		  <input type="text" name="nombre_factura" id="nombre_factura" value="<?php echo $nombre_factura?>" class="textoform" size="40" ></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>NIT</td>
      		<td><input type="text" name="nit_factura" id="nit_factura" class="textoform" size="40" value="<?php echo $nit_factura;?>"></td>
    	</tr>  
		 <tr bgcolor="#FFFFFF">
     		<td>Detalle</td>
      		<td><span id="sprytextarea1">
      		  <label for="detalle_factura"></label>
      		  <textarea name="detalle_factura" id="detalle_factura" cols="40" class="textoform"  rows="2"><?php echo $detalle_factura; ?></textarea>
</span></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Monto</td>
      		<td><span id="sprytextfield5">
            <label for="monto_factura"></label>
            <input type="text"name="monto_factura"id="monto_factura" class="textoform" size="40" value="<?php echo $monto_factura;?>">
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
      		<td><span id="sprytextarea2">
      		  <label for="obs_factura"></label>
      		  <textarea name="obs_factura" id="obs_factura" cols="40" rows="2" class="textoform"><?php echo $obs_factura; ?></textarea>
</span></td>
    	</tr>                              
		<tr bgcolor="#FFFFFF">
     		<td>Estado de Factura</td>
      		<td><span id="spryselect1">
      		  <label for="cod_est_fac"></label>
      		  <select name="cod_est_fac" id="cod_est_fac" class="textoform">
		<?php
        
			$sql2=" select cod_est_fac, desc_est_fac from estado_factura ";
		    $resp2 = mysql_query($sql2);	
			while($dat2=mysql_fetch_array($resp2)){
				$cod_est_fac=$dat2['cod_est_fac'];
				$desc_est_fac=$dat2['desc_est_fac'];
		?>
        	<option value="<?php echo $cod_est_fac;?>" <?php if($cod_est_fac==$codestfac){?> selected <?php }?> ><?php echo $desc_est_fac;?></optgroup>
        <?php
			}
		?>              
   		    </select>
   		    <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
    	</tr>		
  <?php if($cod_hoja_ruta<>0){?>	
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Datos de Hoja Ruta</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td width="25%">Nro Hoja Ruta</td>
      		<td width="75%"><?php echo $nro_hoja_ruta."/".$gestion;?></td>
    	</tr>        
		 <tr bgcolor="#FFFFFF">
     		<td width="25%">Cliente</td>
      		<td width="75%"><?php echo $nombre_cliente;?></td>
    	</tr>          
         <?php 
		 }?>											
	  </tbody>
	</table>	
	<br>
<div align="center">
<INPUT type="button" class="boton" name="btn_guardar" value="IR ATRAS" onClick="cancelar(this.form);"  >
<INPUT type="submit" class="boton" name="btn_guardar" value="GUARDAR CAMBIOS"   >
</div>
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"dd/mm/yyyy"});

var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "real");
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {isRequired:false});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
</script>
</body>
</html>
