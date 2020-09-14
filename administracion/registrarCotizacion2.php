
<html >
<head>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<title>Registro de Cotizaci&oacute;n</title>
<script language="Javascript"> 
function datosCliente(f)
{	 

		var cod_cliente=f.cod_cliente.value;
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
	importe.value=parseFloat(montoVentaSinDescuento)-(parseFloat(montoVentaSinDescuento)*(parseFloat(descuento)/100));
	calcularTotal();
}
function importetotal(fila){
	var cantiddUnitaria=document.getElementById('cantidadUnitaria'+fila).value;
	var precioVenta=document.getElementById('precioVenta'+fila);
	var descuento=document.getElementById('descuento'+fila);
	var importe=document.getElementById('importe'+fila).value;
	var montoVentaSinDescuento=parseFloat(cantiddUnitaria)*parseFloat(precioVenta);
	descuento=0;
	if(cantiddUnitaria>0){
		precioVenta.value=parseFloat(importe)/parseFloat(cantiddUnitaria);
	}	
	calcularTotal();
}
function calcularTotal(){
	var importeTotal=document.getElementById('importeTotal');
	var sumImporteParcial=0;
	for(i=1;i<=num;i++){
		var importeParcial=document.getElementById('importe'+i).value;
		sumImporteParcial=parseFloat(sumImporteParcial)+parseFloat(importeParcial);
	}
	importeTotal.innerHTML=sumImporteParcial;
}
function enviar(f){
	fi = document.getElementById('fiel'); // 1
	alert("fi="+fi);

	if(f.cod_cliente.value==0){
		alert("Seleccione un Cliente.")
		f.cod_cliente.focus();
		return false;
	}

	if(num==0){
		alert("No existe ningun item seleccionado en detalle de cotizacion.")
		return false;
	}
	
	f.codClienteF.value=f.cod_cliente.value;
	f.fechaCotizacionF.value=document.getElementById('fechaCotizacion').value;
	f.codTipoCotizacionF.value=document.getElementById('codTipoCotizacion').value;	
	f.obsF.value=document.getElementById('obs').value;
	f.codTipoPagoF.value=document.getElementById('codTipoPago').value;		
	var codItemArray=new Array();
	var cantiddUnitariaArray=new Array();
	var precioVentaArray=new Array();
	var descuentoArray=new Array();
	var codCaracArray=new Array();
	var descCaracArray=new Array();
	var descItemArray=new Array();
	var k=0;
	for(i=1;i<=num;i++){
		if(document.getElementById('chk'+i).checked){		
		codItemArray[i-1]=document.getElementById('cod_item'+i).value;
		cantiddUnitariaArray[i-1]=document.getElementById('cantidadUnitaria'+i).value;
		precioVentaArray[i-1]=document.getElementById('precioVenta'+i).value;
		descuentoArray[i-1]=document.getElementById('descuento'+i).value;
		descItemArray[i-1]=document.getElementById('obs'+i).value;
		elements=document.getElementById('dataCarac'+i);
			var rowsElement=elements.rows; 		
	        for(var j=0;j<rowsElement.length;j++){
				var cellsElement=rowsElement[j].cells;
	            var cel_0=cellsElement[0];
				var cel_2=cellsElement[2];
				var celda_0=cel_0.getElementsByTagName('input')[0];
				var checked=0;
				if(celda_0!=null){
					var celda_2=cel_2.getElementsByTagName('input')[0];				
					if(celda_0.type='checkbox'){
						if(celda_0.checked){
							checked=1;
						}
					}
					codCaracArray[k]=checked;
					descCaracArray[k]=celda_2.value;
					k++;
				}
			}
		}
	}
	f.codItemF.value=codItemArray;
	f.cantidadUnitariaF.value=cantiddUnitariaArray;
	f.precioVentaF.value=precioVentaArray;
	f.descuentoF.value=descuentoArray;
	f.codCaracF.value=codCaracArray;
	f.descCaracF.value=descCaracArray;
	f.descItemF.value=descItemArray;
	var msj=confirm("Esta seguro de grabar los datos.")
	if(msj){
		f.action="saveRegistrarCotizacion.php";
	    f.submit();	
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<form    method="post" action="saveRegistrarCotizacion.php" id="form" >
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
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">REGISTRAR COTIZACION</h3>
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">No. <?php echo $nro_cotizacion;?>/<?php echo $gestion;?></h3>
<table align="center" class="text"  cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0" id="tabla">
		<tr class="titulo_tabla">
			<td  colSpan="6" align="center">DATOS CLIENTE </td>
		</tr>
		<tr bgcolor="#FFFFFF">
     		<td>&nbsp;<b>Cliente </b></td>
      		<td> <div id="div_cliente">
			<select name="cod_cliente"  class="textoform" >
				<option value="0">Seleccione un Cliente</option>
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
			<a  href="javascript:cargar_cliente();">[ Nuevo Cliente]</a>
			&nbsp;<a  href="javascript:datosCliente(form);">[Datos Cliente]</a>
			</div>
			</td>
     		<td>&nbsp;<b>Fecha Cotizaci&oacute;n</b></td>			
     		<td>
                            <input type="text" class="textoform" size="12"  value="<?php echo date('d/m/Y');?>" name="fechaCotizacion" id="fechaCotizacion" >
			</td>
    	</tr>
		<tr bgcolor="#FFFFFF">
     		<td>&nbsp;<b>Tipo de Cotizacion</b></td>			
     		<td>
			<select name="codTipoCotizacion" id="codTipoCotizacion" class="textoform" >
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
			<td>&nbsp;<b>Estado de Cotizacion </b></td>			
     		<td>NORMAL</td>			
		</tr>
		<tr bgcolor="#FFFFFF">
		    <td>&nbsp;<b>Observacion </b></td>					
			<td><textarea cols="40" rows="2" name="obs" id="obs"  class="textoform" ></textarea></td>
     		<td>&nbsp;<b>Tipo de Pago</b></td>							
     		<td>
			<select name="codTipoPago" id="codTipoPago" class="textoform" >
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
  </table>
	<center>
		<fieldset id="fiel" style="width:80%;border:0;" >
			<table align="center"class="text" cellSpacing="1" cellPadding="2" width="100%" border="0" id="data0">
				<tr>
					<td align="center" colspan="6">
						<input class="boton" type="button" value="Nuevo Item (+)" onClick="mas(this)" />
						<input class="boton" type="button" value="Memos Item (-)" onClick="menos(this)" />						
					</td>
				</tr>
				<tr>
					<td align="center" colspan="6">
					<div style="width:100%;" align="center"><b>DETALLE DE COTIZACION</b></div>
					</td>				
				</tr>				
				<tr class="titulo_tabla" align="center">
					<td width="55%">ITEM</td>
					<td width="11%">CANT. UNIT.</td>
					<td width="12%">PRECIO VENTA</td>
					<td width="11%">DESC. %</td>
					<td width="8%">IMPORTE</td>
					<td width="5%">&nbsp;</td>
				</tr>
			</table>
		</fieldset>
		<table align="center"class="text" cellSpacing="1" cellPadding="2" width="80%" border="0" id="dataTotal">
				<tr class="titulo_tabla">
					<td width="89%" colspan="4">&nbsp;<b>Total</b></td>
					<td width="11%" align="right"><SPAN id="importeTotal">0</SPAN></td>
				</tr>		
		</table>
	</center>
	<br>
	<center>
		<input type="button" class="boton" value="Guardar" onClick="enviar(form)" />
	</center>
	<input type="hidden" name="codCliente" id="codClienteF">
	<input type="hidden" name="fechaCotizacionF" id="fechaCotizacionF">
	<input type="hidden" name="codTipoCotizacionF" id="codTipoCotizacionF">
	<input type="hidden" name="obsF" id="obsF">
	<input type="hidden" name="codTipoPagoF" id="codTipoPagoF">
	
	<input type="hidden" name="codItemF" id="codItemF">	
	<input type="hidden" name="cantidadUnitariaF" id="cantidadUnitariaF">	
	<input type="hidden" name="precioVentaF" id="precioVentaF">	
	<input type="hidden" name="descuentoF" id="descuentoF">				
	
	<input type="hidden" name="codCaracF" id="codCaracF">				
	<input type="hidden" name="descCaracF" id="descCaracF">
	
	<input type="hidden" name="descItemF" id="descItemF">
</form>
<script type="text/javascript" language="JavaScript"  src=".../css/dlcalendar.js"></script>
</body>
</html>
