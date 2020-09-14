<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<script language="Javascript"> 
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
function ajaxItem(cont)
{	
		var div_item;
		div_item=document.getElementById("div"+cont);			
		ajax=nuevoAjax();
		ajax.open("GET","ajaxItem.php?codigo="+cont,true);
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
				div_item.innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null)
}
num=0;
function mas(obj) {
  num++;
  fi = document.getElementById('fiel');
  contenedor = document.createElement('div');
  contenedor.id = 'div'+num;  
  fi.type="style";
  fi.appendChild(contenedor);
  ajaxItem(num);
}
function menos() {
  fi = document.getElementById('fiel');
  fi.removeChild(document.getElementById('div'+num));
  num=parseInt(num)-1;
  calcularTotal();
}
function items_caracteristicas(f,num)
{	
		var div_items_caracteristicas,cod_item;
		div_items_caracteristicas=document.getElementById("div_items_caracteristicas"+num);			
		cod_item=document.getElementById("cod_item"+num).value;
		ajax=nuevoAjax();
		ajax.open("GET","ajax_itemsCaracteristicas.php?cod_item="+cod_item+"&fila="+num,true);						
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
				div_items_caracteristicas.innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null)
}
function importe(fila){
	var cantiddUnitaria=document.getElementById('cantidadUnitaria'+fila).value;
	var precioVenta=document.getElementById('precioVenta'+fila).value;
	var descuento=document.getElementById('descuento'+fila).value;
	var importe=document.getElementById('importe'+fila);
	var montoVentaSinDescuento=parseFloat(cantiddUnitaria)*parseFloat(precioVenta);
	importe.innerHTML=parseFloat(montoVentaSinDescuento)-(parseFloat(montoVentaSinDescuento)*(parseFloat(descuento)/100));
	calcularTotal();
}
function calcularTotal(){
	var importeTotal=document.getElementById('importeTotal');
	var sumImporteParcial=0;
	for(i=1;i<=num;i++){
		var importeParcial=document.getElementById('importe'+i).innerHTML;
		sumImporteParcial=parseFloat(sumImporteParcial)+parseFloat(importeParcial);
	}
	importeTotal.innerHTML=sumImporteParcial;
}
function enviar(f){
	/*if(document.getElementById('cod_cliente').value==0){
		alert("Seleccione un Cliente.")
		document.getElementById('cod_cliente').focus();
		return false;
	}	*/
	var array1=new Array();
	var array2=new Array();
	var array3=new Array();	
	var array4=new Array();		
	var j=0;
	for(var i=0;i<=f.codTipoCotizacion.length-1;i++){
		if(f.codTipoCotizacion.options[i].selected){
			array1[j]=f.codTipoCotizacion.options[i].value;
			j++;
		}
	}
	/*if(j==0){
		alert("Seleccione tipo de cotizacion.");
		return false;
	}*/
	j=0;
	for(var i=0;i<=f.codEstadoCotizacion.length-1;i++){
		if(f.codEstadoCotizacion.options[i].selected){
			array2[j]=f.codEstadoCotizacion.options[i].value;
			j++;
		}
	}
	/*if(j==0){
		alert("Seleccione estado de cotizacion.");
		return false;
	}*/	
	j=0;
	for(var i=0;i<=f.codTipoPago.length-1;i++){
		if(f.codTipoPago.options[i].selected){
			array3[j]=f.codTipoPago.options[i].value;
			j++;
		}
	}	
	/*if(j==0){
		alert("Seleccione tipo de pago.");
		return false;
	}*/	
	j=0;
	for(var i=0;i<=f.codItem.length-1;i++){
		if(f.codItem.options[i].selected){
			array4[j]=f.codItem.options[i].value;
			j++;
		}
	}		
	/*if(j==0){
		alert("Seleccione Item.");
		return false;
	}*/
	//f.codActivoFechaf.value=codActivoFecha
	if(document.getElementById('codActivoFecha').checked){
		f.codActivoFechaF.value=1;
	}else{
		f.codActivoFechaF.value=0;
	}
	f.codClienteF.value=document.getElementById('cod_cliente').value;
	f.codTipoCotizacionF.value=array1;
	f.codEstadoCotizacionF.value=array2;
	f.codTipoPagoF.value=array3;
	f.fechaInicioF.value=document.getElementById('fechaInicio').value;
	f.fechaFinalF.value=document.getElementById('fechaFinal').value;
	f.codItemF.value=document.getElementById('codItem').value;		
    f.submit();	
}
</script>
</head>
<body>
<form method="post" action="rptCotizaciones.php" name="form1">
<?php 	
	require("conexion.inc");
	include("funciones.php");
	
	$cod_gestion=gestionActiva();
	
	$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion."'";
	$resp2= mysql_query($sql2);
	$gestion="";
	while($dat2=mysql_fetch_array($resp2)){
		$gestion=$dat2[0];
	}
		
	$sql="select max(nro_cotizacion) from cotizaciones where cod_gestion='".$cod_gestion."'";
	$nro_cotizacion=obtenerCodigo($sql);


?>
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">BUSQUEDA DE COTIZACION</h3>
	<table align="center" class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0" id="tabla">
		<tr class="titulo_tabla">
			<td  colSpan="6" align="center">PARAMETROS DE BUSQUEDA</td>
		</tr>
		<tr bgcolor="#FFFFFF">
     		<td>&nbsp;<b>Cliente</b>&nbsp;</td>
      		<td>
			<select name="cod_cliente" id="cod_cliente" class="textoform" >
				<option value="0">Todos los Cliente</option>
				<?php
					$sql2="select cod_cliente,nombre_cliente from clientes order by  nombre_cliente asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_cliente=$dat2[0];	
			  		 		$nombre_cliente=$dat2[1];	
				 ?><option value="<?php echo $cod_cliente;?>"><?php echo $nombre_cliente;?></option>				
				<?php		
					}
				?>						
			</select>
			</td>
		</tr>	
		<tr bgcolor="#FFFFFF">
     		<td>&nbsp;<b>Tipo de Cotizaci&oacute;n</b>&nbsp;</td>			
     		<td>
			<select name="codTipoCotizacion" class="textoform">
				<option value="0">Todos</option>
				<?php
					$sql3="select cod_tipo_cotizacion,nombre_tipo_cotizacion from tipos_cotizacion";
					$resp3=mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3))
						{
							$cod_tipo_cotizacion=$dat3[0];	
			  		 		$nombre_tipo_cotizacion=$dat3[1];	
				 ?><option value="<?php echo $cod_tipo_cotizacion;?>"><?php echo $nombre_tipo_cotizacion;?></option>				
				<?php		
					}
				?>						
			</select>
			</td>
		</tr>
		<tr bgcolor="#FFFFFF">	
			<td>&nbsp;<b>Estado de Cotizaci&oacute;n</b>&nbsp;</td>			
			<td>
			<select name="codEstadoCotizacion"  class="textoform" >
				<option value="0">Todos</option>
				<?php
					$sql3="select cod_estado_cotizacion,nombre_estado_cotizacion from estados_cotizacion where cod_estado_registro=1";
					$resp3=mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3))
						{
							$codEstadoCotizacion=$dat3[0];	
			  		 		$nombreEstadiCotizacion=$dat3[1];	
				 ?><option value="<?php echo $codEstadoCotizacion;?>"><?php echo $nombreEstadiCotizacion;?></option>				
				<?php		
					}
				?>						
			</select>
			</td>	
		</tr>
		<tr bgcolor="#FFFFFF">
     		<td>&nbsp;<b>Tipo de Pago</b>&nbsp;</td>							
     		<td>
			<select name="codTipoPago" class="textoform" >
				<option value="0">Todos</option>
				<?php
					$sql4="select cod_tipo_pago,nombre_tipo_pago from tipos_pago";
					$resp4=mysql_query($sql4);
						while($dat4=mysql_fetch_array($resp4))
						{
							$codTipoPago=$dat4[0];	
			  		 		$nombreTipoPago=$dat4[1];	
				 ?><option value="<?php echo $codTipoPago;?>"><?php echo $nombreTipoPago;?></option>				
				<?php		
					}
				?>						
			</select>
			</td>			
		</tr>
		<tr bgcolor="#FFFFFF">
     		<td>&nbsp;<b>Item</b>&nbsp;</td>							
     		<td>
			<select name="codItem" id="codItem" class="textoform" multiple >
				<?php
					$sql4="select cod_item,desc_item from items order by desc_item asc";
					$resp4=mysql_query($sql4);
						while($dat4=mysql_fetch_array($resp4))
						{
							$codItem=$dat4[0];	
			  		 		$nombreItem=$dat4[1];	
				 ?><option value="<?php echo $codItem;?>"><?php echo $nombreItem;?></option>				
				<?php		
					}
				?>						
			</select>
			</td>			
		</tr>		
		<tr bgcolor="#FFFFFF">
     		<td>&nbsp;<b>Rango de Fecha</b>&nbsp;</td>			
     		<td>
				de&nbsp;<input type="text" class="textoform" size="12"  value="<?php echo date('d/m/Y');?>" name="fechaInicio" id="fechaInicio" >
				&nbsp;hasta&nbsp;<input type="text" class="textoform" size="12"  value="<?php echo date('d/m/Y');?>" name="fechaFinal" id="fechaFinal" >
				<input type="checkbox" name="codActivoFecha" id="codActivoFecha" checked >
			</td>
    	</tr>
	</table>
	<br>
	<center>
		<input type="button" class="boton" value="Ver" onclick="enviar(form1)" />
		<input type="reset" class="boton" value="Limpiar" />
	</center>
	<input type="hidden" name="codClienteF" >
	<input type="hidden" name="codTipoCotizacionF" >
	<input type="hidden" name="codEstadoCotizacionF" >
	<input type="hidden" name="codTipoPagoF" >
	<input type="hidden" name="fechaInicioF" >
	<input type="hidden" name="fechaFinalF" >
	<input type="hidden" name="codItemF" >
	<input type="hidden" name="codActivoFechaF" >
</form>
<script type="text/javascript" language="JavaScript"  src=".../css/dlcalendar.js"></script>
</body>
</html>
