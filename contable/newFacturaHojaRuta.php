<?php
	require("conexion.inc");
	$cod_hoja_ruta=$_GET['cod_hoja_ruta'];

		$sql=" select  hr.cod_gestion, hr.nro_hoja_ruta, g.gestion , hr.fecha_hoja_ruta, hr.cod_cotizacion, ";
		$sql.=" c.cod_cliente, cli.nombre_cliente, cli.nit_cliente,  hr.cod_estado_hoja_ruta, ehr.nombre_estado_hoja_ruta";
		$sql.=" from hojas_rutas hr, gestiones g, estados_hojas_rutas ehr, cotizaciones c, clientes cli ";
		$sql.=" where hr.cod_gestion=g.cod_gestion ";
		$sql.=" and hr.cod_estado_hoja_ruta=ehr.cod_estado_hoja_ruta ";
		$sql.=" and hr.cod_cotizacion=c.cod_cotizacion ";
		$sql.=" and c.cod_cliente=cli.cod_cliente ";
		$sql.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
		$resp = mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){
			$cod_gestion=$dat['cod_gestion'];
			$nro_hoja_ruta=$dat['nro_hoja_ruta'];
			$gestion=$dat['gestion'];
			$fecha_hoja_ruta=$dat['fecha_hoja_ruta'];
			$cod_cotizacion=$dat['cod_cotizacion'];
			$codcliente=$dat['cod_cliente'];
			$nombre_cliente=$dat['nombre_cliente'];
			$nit_cliente=$dat['nit_cliente'];
			$cod_estado_hoja_ruta=$dat['cod_estado_hoja_ruta'];
			$nombre_estado_hoja_ruta=$dat['nombre_estado_hoja_ruta'];
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
		$descuento_cotizacion=0;
		$sql=" select c.descuento_cotizacion, c.descuento_fecha, c.descuento_obs, c.cod_usuario_descuento, c.obs_pago ";
		$sql.=" from cotizaciones c";
		$sql.=" where c.cod_cotizacion=".$cod_cotizacion;
		$resp = mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){
			$descuento_cotizacion=$dat['descuento_cotizacion'];
			$descuento_fecha=$dat['descuento_fecha'];
			$descuento_obs=$dat['descuento_obs'];
			$cod_usuario_descuento=$dat['cod_usuario_descuento'];
			$obs_pago=$dat['obs_pago'];
		}
		$incremento_cotizacion=0;
		$sql=" select c.incremento_cotizacion, c.incremento_fecha, c.incremento_obs, c.cod_usuario_incremento, c.obs_pago ";
		$sql.=" from cotizaciones c";
		$sql.=" where c.cod_cotizacion=".$cod_cotizacion;
		$resp = mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){
			$incremento_cotizacion=$dat['incremento_cotizacion'];
			$incremento_fecha=$dat['incremento_fecha'];
			$incremento_obs=$dat['incremento_obs'];
			$cod_usuario_incremento=$dat['cod_usuario_incremento'];
			$obs_pago=$dat['obs_pago'];
		}
				
		
		
		$sql=" select sum(cd.IMPORTE_TOTAL) ";
		$sql.=" from hojas_rutas_detalle hrd, cotizaciones_detalle cd ";
		$sql.=" where hrd.cod_hoja_ruta=".$cod_hoja_ruta;
		$sql.=" and hrd.cod_cotizacion=cd.cod_cotizacion ";
		$sql.=" and hrd.cod_cotizaciondetalle=cd.cod_cotizaciondetalle ";
		$resp = mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){
			$monto_factura=$dat[0];
		}


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
</head>
<body onload="document.form1.nro_factura.focus()">
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="saveFacturaHojaRuta.php" name="form1">
<input type="hidden" name="cod_hoja_ruta" id="cod_hoja_ruta" value="<?php echo $cod_hoja_ruta;?>">
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
<h3 align="center" style="background:#FFF;font-size: 12px;color: #E78611;font-weight:bold;">Nro Hoja Ruta:<?php echo $nro_hoja_ruta."/".$gestion;?> - Cliente: <?php echo $nombre_cliente;?></h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0">
    
		<tbody>
<tr bgcolor="#FFFFFF">
<td colspan="2" align="right"><a href="../reportes/impresionCotizacion.php?cod_cotizacion=<?php echo $cod_cotizacion; ?>" target="_blank">Ver Cotizacion Nro. <?php echo $nro_cotizacion."/".$gestion_cotizacion;?></a></td></tr>
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
     		<td>Cliente Factura</td>
      		<td>		
            <span id="sprytextfield3">
      		  <label for="nombre_factura"></label>
      		  <input type="text" name="nombre_factura" id="nombre_factura" class="textoform" size="40" value="<?php echo $nombre_cliente;?>">
   		    <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>NIT</td>
      		<td><span id="sprytextfield4">
            <label for="nit_factura"></label>
            <input type="text" name="nit_factura" id="nit_factura" class="textoform" size="40" value="<?php echo $nit_cliente;?>">
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    	</tr>   
		 <tr bgcolor="#FFFFFF">
     		<td>Detalle</td>
      		<td><span id="sprytextarea1">
      		  <label for="detalle_factura"></label>

      		  <textarea name="detalle_factura" id="detalle_factura" cols="80" class="textoform"  rows="15"><?php
              /*********************************CUERPO DE COTIZACION****************************************/
	
				$sql=" select cod_cotizaciondetalle,  cod_item, descripcion_item, ";
				$sql.=" cantidad_unitariacotizacion, cantidad_unitariacotizacionefectuada, ";
				$sql.=" cod_estado_detallecotizacionitem,precio_venta, descuento, importe_total, orden ";
				$sql.=" from cotizaciones_detalle ";
				$sql.=" where  cod_cotizacion='".$cod_cotizacion."'";
				$sql.=" and cod_cotizaciondetalle in (select cod_cotizaciondetalle from hojas_rutas_detalle ";
				$sql.=" where cod_hoja_ruta='".$cod_hoja_ruta."')";
				$sql.=" order by cod_cotizaciondetalle asc";
				$resp=mysql_query($sql);
				$suma=0;
				$numeroItem=0;
				while ($dat=mysql_fetch_array($resp)){
					$numeroItem=$numeroItem+1;			
					$cod_cotizaciondetalle=$dat[0];
					$cod_item=$dat[1];			
					$sql4= " select desc_item  from items  where cod_item='".$cod_item."'";
					$desc_item="";
					$resp4=mysql_query($sql4);
					while ($dat4=mysql_fetch_array($resp4)){		
						$desc_item=$dat4[0];
					}			
					$descripcion_item=$dat[2];
					$descripcion_item=str_replace("|",",",$descripcion_item);
					$cantidad_unitariacotizacion=$dat[3];
					$cantidad_unitariacotizacionefectuada=$dat[4];
					$cod_estado_detallecotizacionitem=$dat[5];
					$precio_venta=$dat[6];
					$descuento=$dat[7];
					$importe_total=$dat[8];
					$orden=$dat[9];
				echo "ITEM:".$numeroItem." (".$importe_total." Bs.)\n";
			echo $cantidad_unitariacotizacion." ".$desc_item.$descripcion_item."\n";	

			$sql7=" select count(DISTINCT(cod_compitem))as cant_comp ";
			$sql7.=" from cotizacion_detalle_caracteristica";
			$sql7.=" where cod_cotizaciondetalle='".$cod_cotizaciondetalle."' and cod_cotizacion='".$cod_cotizacion."'";
			$resp7=mysql_query($sql7);
			$cant_comp=0;
			while ($dat7=mysql_fetch_array($resp7)){
				$cant_comp=$dat7[0];	
			}
			
			$detalle_item="";
			$sql2=" select  distinct(cod_compitem) as cod_compitem  from cotizacion_detalle_caracteristica ";
			$sql2.=" where cod_cotizaciondetalle='".$cod_cotizaciondetalle."' and cod_cotizacion='".$cod_cotizacion."'";
			
			$resp2=mysql_query($sql2);
			while ($dat2=mysql_fetch_array($resp2)){
		
				$cod_compitem=$dat2[0];
				$sql4=" select  count(*) from cotizacion_detalle_caracteristica ";
				$sql4.=" where cod_cotizaciondetalle='".$cod_cotizaciondetalle."' and cod_cotizacion='".$cod_cotizacion."'";
				$sql4.=" and cod_compitem='".$cod_compitem."' and cod_estado_registro=1";
				$resp4=mysql_query($sql4);
				$nro_carac=0;
				while($dat4=mysql_fetch_array($resp4)){
					$nro_carac=$dat4[0];
				}
				
				if($nro_carac>0){
				/***************************************************************/				
				
				$nombre_componenteitem="";
				$sql5=" select nombre_componenteitem from componente_items where cod_compitem='".$cod_compitem."'";
				$resp5=mysql_query($sql5);
				while ($dat5=mysql_fetch_array($resp5)){
					$nombre_componenteitem=$dat5[0];	
				}
				if($cant_comp>1){

					echo $nombre_componenteitem.":";
				}
						
				/**********************************/
				$sql3=" select  cod_carac, desc_carac, cod_estado_registro ";
				$sql3.=" from cotizacion_detalle_caracteristica ";
				$sql3.=" where cod_cotizaciondetalle='".$cod_cotizaciondetalle."'";
				$sql3.=" and cod_cotizacion='".$cod_cotizacion."'";
				$sql3.=" and cod_compitem='".$cod_compitem."'";
				$sql3.=" and cod_estado_registro=1 order by orden asc";
				$resp3=mysql_query($sql3);
				while ($dat3=mysql_fetch_array($resp3)){
						
						$cod_carac=$dat3[0];
						
						/*************************/
						$desc_caracT="";
						$sql5=" select desc_carac from caracteristicas where cod_carac='".$cod_carac."'";
						$resp5=mysql_query($sql5);
						while ($dat5=mysql_fetch_array($resp5)){
							$desc_caracT=$dat5[0];	
						}
						/*************************/

						$desc_carac=$dat3[1];
						$desc_carac=str_replace("|",",",$desc_carac);
						$cod_estado_registro=$dat3[2];
						
						echo $desc_caracT.": ".$desc_carac."\n";
				}
				/***************************************************************/
				}

			}
				}
			  
			  ?></textarea>
</span></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Monto</td>
      		<td><span id="sprytextfield5">
            <label for="monto_factura"></label>
            <input type="text"name="monto_factura"id="monto_factura" class="textoform" size="20" value="<?php echo (($monto_factura+$incremento_cotizacion)-$descuento_cotizacion);?>">Bs.<p style="background:#FFF;font-size: 10px;color: #660099;font-weight:bold;">
			<?php if($descuento_cotizacion>0){ ?>
				<?php echo "MONTO SIN DESCUENTO: ".$monto_factura." Bs. </br>DESCUENTO AUTORIZADO: ".$descuento_cotizacion." Bs."; ?>
			<?php }?>
				<?php if($descuento_obs<>''){ ?>
				<?php echo "</br>IMPORTANTE: ".$descuento_obs; ?>
			<?php }?>
            
			<?php if($incremento_cotizacion>0){ ?>
				<?php echo "MONTO SIN INCREMENTO: ".$monto_factura." Bs. </br>INCREMENTO AUTORIZADO: ".$incremento_cotizacion." Bs."; ?>
			<?php }?>
            <?php if($incremento_obs<>''){ ?>
				<?php echo "</br>IMPORTANTE: ".$incremento_obs; ?>
			<?php }?>

                        
			</p>
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
<INPUT type="button"  class="boton"  name="btn_limpiar" value="Cancelar" onClick="cancelar();"  >
<INPUT type="submit" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >

</div>
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"dd/mm/yyyy"});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "real");
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {isRequired:false});
</script>
</body>
</html>
