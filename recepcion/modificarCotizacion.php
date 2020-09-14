<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edici&oacute;n</title>
<?php 	
	require("conexion.inc");
	include("funciones.php");
	$codCotizacion=$_GET['codCotizacion'];
	$sql=" select count(*) as num from cotizaciones_detalle where cod_cotizacion=".$codCotizacion;
	$resp= mysql_query($sql);
	$dat=mysql_fetch_array($resp);
	$num=$dat[0];
	
?>
<script language="Javascript"> 
num=<?php echo $num;?>;

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
function ajaxItemReplicar(cont,contAmterior)
{	
		var div_item;
		div_item=document.getElementById("div"+cont);			
		var contReplicar=contAmterior;
		var codItemAnterior=document.getElementById('cod_item'+contReplicar).value;
		ajax=nuevoAjax();
		ajax.open("GET","ajaxItemReplicar.php?codigo="+cont+"&codItemAnterio="+codItemAnterior,true);
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
				div_item.innerHTML=ajax.responseText;
				document.getElementById('cantidadUnitaria'+cont).value=document.getElementById('cantidadUnitaria'+contReplicar).value;
				document.getElementById('precioVenta'+cont).value=document.getElementById('precioVenta'+contReplicar).value;
				document.getElementById('descuento'+cont).value=document.getElementById('descuento'+contReplicar).value;
				document.getElementById('obs'+cont).value=document.getElementById('obs'+contReplicar).value;
				document.getElementById('importe'+cont).value=document.getElementById('importe'+contReplicar).value;
				
				elementsReplicar=document.getElementById('dataCarac'+cont);
				elements=document.getElementById('dataCarac'+contReplicar);
				var rowsElement=elements.rows; 		
				var rowsElementReplicar=elementsReplicar.rows; 		
		        for(var j=0;j<rowsElement.length;j++){
					var cellsElement=rowsElement[j].cells;
					var cellsElementReplicar=rowsElementReplicar[j].cells;					
					var cel_0=cellsElement[0];
					var cel_0Replicar=cellsElementReplicar[0];
					var cel_2=cellsElement[2];
					var celda_0=cel_0.getElementsByTagName('input')[0];
					var celda_0Replicar=cel_0Replicar.getElementsByTagName('input')[0];

					var cel_2Replicar=cellsElementReplicar[2];
					if(celda_0!=null){
						var celda_2=cel_2.getElementsByTagName('input')[0];
						var celda_2Replicar=cel_2Replicar.getElementsByTagName('input')[0];
						celda_2Replicar.value=celda_2.value;
						celda_0Replicar.checked=celda_0.checked;
					}										
				}
				if(document.getElementById('chkSumar').checked){
					calcularTotal();
				}else{
					document.getElementById('importeTotal').innerHTML="";
				}
		    }
	    }		
		ajax.send(null)
}

function mas(obj) {
  num++;
  fi = document.getElementById('fiel');
  contenedor = document.createElement('div');
  contenedor.id = 'div'+num;  
  fi.type="style";
  fi.appendChild(contenedor);
		var div_item;
		div_item=document.getElementById("div"+num);			
		ajax=nuevoAjax();
		ajax.open("GET","ajaxItem.php?codigo="+num,true);
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
				div_item.innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null)
}

function replicar(obj) {
	if(num==0){
		alert("Error al replicar Item.");
		return false;
	}
  num++;
  fi = document.getElementById('fiel');
  contenedor = document.createElement('div');
  contenedor.id = 'div'+num;  
  fi.type="style";
  fi.appendChild(contenedor);
  ajaxItemReplicar(num,obj);
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
function items_caracteristicasReplicar(f,num)
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

	if(document.getElementById('chkConsiderarPrecioUnitario').checked==true){
	
		var cantiddUnitaria=document.getElementById('cantidadUnitaria'+fila).value;
		var precioVenta=document.getElementById('precioVenta'+fila).value;
		var descuento=document.getElementById('descuento'+fila).value;
		var importe=document.getElementById('importe'+fila);
		var montoVentaSinDescuento=parseFloat(cantiddUnitaria)*parseFloat(precioVenta);
		importe.value=parseFloat(montoVentaSinDescuento)-(parseFloat(montoVentaSinDescuento)*(parseFloat(descuento)/100));
		importe.value=Math.round(importe.value*100)/100;
	}
	if(importe.value=="NaN"){
		importe.value=0;
	}
	if(document.getElementById('chkSumar').checked){
		calcularTotal();
	}else{
		document.getElementById('importeTotal').innerHTML="";
	}
}
function importetotal(fila){
if(document.getElementById('chkConsiderarPrecioUnitario').checked==true){
	var cantiddUnitaria=document.getElementById('cantidadUnitaria'+fila).value;
	var precioVenta=document.getElementById('precioVenta'+fila);
	var descuento=document.getElementById('descuento'+fila);
	var importe=document.getElementById('importe'+fila).value;
	var montoVentaSinDescuento=parseFloat(cantiddUnitaria)*parseFloat(precioVenta);
	descuento=0;
	if(cantiddUnitaria>0){		
		precioVenta.value=parseFloat(importe)/parseFloat(cantiddUnitaria);
		precioVenta.value=Math.round(precioVenta.value*100)/100;
		if(precioVenta.value=="NaN"){
			precioVenta.value=0;
		}
	}	
}
	calcularTotal();
}
function calcularTotal(){
	var importeTotal=document.getElementById('importeTotal');
	var sumImporteParcial=0;
	if(document.getElementById('chkSumar').checked){
		for(i=1;i<=num;i++){
			var importeParcial=document.getElementById('importe'+i).value;
			sumImporteParcial=parseFloat(sumImporteParcial)+parseFloat(importeParcial);
		}	
		importeTotal.innerHTML=Math.round(sumImporteParcial*100)/100;
		}
}
function enviar(f){

	fi = document.getElementById('fiel'); // 1
	if(document.getElementById('cod_cliente').value==0){
		alert("Seleccione un Cliente.")
		document.getElementById('cod_cliente').focus();
		return false;
	}
	if(num==0){
		alert("No existe ningun item seleccionado en detalle de cotizacion.")
		return false;
	}
	f.codClienteF.value=document.getElementById('cod_cliente').value;
	f.fechaCotizacionF.value=document.getElementById('fechaCotizacion').value;
	f.codTipoCotizacionF.value=document.getElementById('codTipoCotizacion').value;	
	f.obsF.value=document.getElementById('obs').value;
	f.codTipoPagoF.value=document.getElementById('codTipoPago').value;	
	if(document.getElementById('chkSumar').checked){
		f.chkSumarF.value=1;		
	}else{
		f.chkSumarF.value=0;		
	}
	if(document.getElementById('chkConsiderarPrecioUnitario').checked){
		f.chkConsiderarPrecioUnitarioF.value=1;		
	}else{
		f.chkConsiderarPrecioUnitarioF.value=0;		
	}
	f.codUsuarioFirmaF.value=document.getElementById('cod_usuario_firma').value;		
	
	var codItemArray=new Array();
	var cantiddUnitariaArray=new Array();
	var precioVentaArray=new Array();
	var descuentoArray=new Array();
	var importeArray=new Array();
	var codCaracArray=new Array();
	var descCaracArray=new Array();
	var descItemArray=new Array();
	var descItemAux="";
	var descCarcAux="";	
	var k=0;
	//alert("num="+num);
	for(i=1;i<=num;i++){
		if(document.getElementById('chk'+i).checked){		
		codItemArray[i-1]=document.getElementById('cod_item'+i).value;
		cantiddUnitariaArray[i-1]=document.getElementById('cantidadUnitaria'+i).value;
		precioVentaArray[i-1]=document.getElementById('precioVenta'+i).value;
		descuentoArray[i-1]=document.getElementById('descuento'+i).value;
		importeArray[i-1]=document.getElementById('importe'+i).value;
		descItemAux=document.getElementById('obs'+i).value;
		descItemAux=descItemAux.replace(/[,]/gi,"|");		
		descItemArray[i-1]=descItemAux;				

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
					if(celda_0.type=='checkbox'){
						if(celda_0.checked){
							checked=1;
						}
					}
					codCaracArray[k]=checked;
					descCarcAux=celda_2.value;
					descCarcAux=descCarcAux.replace(/[,]/gi,"|");
					descCaracArray[k]=descCarcAux;										
					//descCaracArray[k]=celda_2.value;
					k++;
				}
			}
		}
	}
	f.codItemF.value=codItemArray;
	f.cantidadUnitariaF.value=cantiddUnitariaArray;
	f.precioVentaF.value=precioVentaArray;
	f.descuentoF.value=descuentoArray;
	f.importeF.value=importeArray
	f.codCaracF.value=codCaracArray;
	f.descCaracF.value=descCaracArray;
	f.descItemF.value=descItemArray;
	var msj=confirm("Esta seguro de grabar los datos.")
	if(msj){
		f.action="updateRegistrarCotizacion.php";
	    f.submit();	
	}
}
function sumar(obj){
	if(obj.checked==true){
		calcularTotal();
	}else{
		document.getElementById('importeTotal').innerHTML="";
	}
}
function cancelar(){
			window.location="navegadorCotizaciones.php";
}
function ConsiderarPrecioUnitario(obj){
	var i=0;

	if(obj.checked==true){

		for(i=1;i<=num;i++){			
			var precioUnitario=(document.getElementById('importe'+i).value)/(document.getElementById('cantidadUnitaria'+i).value);	
			document.getElementById('precioVenta'+i).value=Math.round(precioUnitario*100)/100;

			if(document.getElementById('chkSumar').checked){
				calcularTotal();
			}else{
				document.getElementById('importeTotal').innerHTML="";
			}
			
		}
		
	}else{
		for(i=1;i<=num;i++){
		
			document.getElementById('precioVenta'+i).value=0;
		}
	}
}
function calcularTotalEditar(){
	//var cont=0;
	for(j=1;j<=num;j++){
		//num=j-1;
		if(document.getElementById('chkSumar').checked){
			calcularTotal();
		}else{
			document.getElementById('importeTotal').innerHTML="";
		}
		fila=document.getElementById('cantidadUnitaria'+j).value;		
	}			
}

</script>
</head>
<body onload="calcularTotalEditar();">
<form method="post"  id="form">
<?php 	
	//require("conexion.inc");
	//include("funciones.php");
	//$codCotizacion=$_GET['codCotizacion'];
	$sql=" select cod_tipo_cotizacion, cod_estado_cotizacion, nro_cotizacion, ";
	$sql.=" cod_cliente, fecha_cotizacion, obs_cotizacion, cod_usuario_registro, cod_tipo_pago,";
	$sql.=" fecha_modifica, cod_gestion, cod_usuario_modifica, cod_sumar, considerar_precio_unitario, cod_usuario_firma ";
	$sql.=" from cotizaciones";
	$sql.=" where cod_cotizacion=".$codCotizacion;
	$resp_00 = mysql_query($sql);
	$dat_00=mysql_fetch_array($resp_00);
		$codtipocotizacion=$dat_00[0];
		$codestadocotizacion=$dat_00[1];
		$nro_cotizacion=$dat_00[2];
		$codcliente=$dat_00[3];
		$fecha_cotizacion=$dat_00[4];
		$fecha_cotizacionVector=explode("-",$fecha_cotizacion);

		$obs_cotizacion=$dat_00[5];
		$cod_usuario_registro=$dat_00[6];
		$codtipopago=$dat_00[7];
		$fecha_modifica=$dat_00[8];
		$cod_gestion=$dat_00[9];
		$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion."'";
		$resp2= mysql_query($sql2);
		$gestion="";
		while($dat2=mysql_fetch_array($resp2)){
			$gestion=$dat2[0];
		}		
		
		$cod_usuario_modifica=$dat_00[10];
		$cod_sumar=$dat_00[11];
		$considerar_precio_unitario=$dat_00[12];
		$codusuariofirma=$dat_00[13];
	
?>
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">MODIFICAR COTIZACI&Oacute;N</h3>
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">No. <?php echo $nro_cotizacion;?>/<?php echo $gestion;?></h3>
	<table align="center" class="text" cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0" id="tabla">
		<tr class="titulo_tabla">
			<td  colSpan="6" align="center">COTIZACIÓN </td>
		</tr>
		<tr bgcolor="#FFFFFF">
     		<td>&nbsp;<b>Cliente</b>&nbsp;</td>
      		<td>
			<div id="div_cliente">
			<select name="cod_cliente" id="cod_cliente" class="textoform" >
				<option value="0">Seleccione un Opci&oacute;n</option>
				<?php
					$sql2="select cod_cliente,nombre_cliente from clientes order by  nombre_cliente asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_cliente=$dat2[0];	
			  		 		$nombre_cliente=$dat2[1];	
				 ?>
				 		<?php if($codcliente==$cod_cliente){?>
				 			<option value="<?php echo $cod_cliente;?>" selected="selected"><?php echo $nombre_cliente;?></option>
						<?php }else{?>	
							<option value="<?php echo $cod_cliente;?>"><?php echo $nombre_cliente;?></option>
						<?php }?>				
				<?php		
					}
				?>						
			</select>
			<a  href="javascript:cargar_cliente();">[ Nuevo Cliente]</a>
			&nbsp;<a  href="javascript:datosCliente(this.form);">[Datos Cliente]</a>			</div>			</td>
     		<td>&nbsp;<b>Fecha Cotización</b>&nbsp;</td>			
     		<td>
                <input type="text" class="textoform" size="12"  value="<?php echo $fecha_cotizacionVector[2]."/".$fecha_cotizacionVector[1]."/".$fecha_cotizacionVector[0] ;?>" name="fechaCotizacion" id="fechaCotizacion" >			</td>
    	</tr>
		<tr bgcolor="#FFFFFF">
     		<td>&nbsp;<b>Tipo de Cotizaci&oacute;n</b>&nbsp;</td>			
     		<td>
			<select name="codTipoCotizacion" id="codTipoCotizacion" class="textoform" >
				<?php
					$sql3="select cod_tipo_cotizacion,nombre_tipo_cotizacion from tipos_cotizacion";
					$resp3=mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3))
						{
							$cod_tipo_cotizacion=$dat3[0];	
			  		 		$nombre_tipo_cotizacion=$dat3[1];	
				 ?>
				 		<?php if($codtipocotizacion==$cod_tipo_cotizacion){?>
				 			<option value="<?php echo $cod_tipo_cotizacion;?>"selected="selected">
							<?php echo $nombre_tipo_cotizacion;?>
							</option>				
						<?php }else{?>	
							<option value="<?php echo $cod_tipo_cotizacion;?>"><?php echo $nombre_tipo_cotizacion;?></option>				
						<?php }?>
				 
				 
				<?php		
					}
				?>						
			</select>			</td>

     		<td>&nbsp;<b>Tipo de Pago</b>&nbsp;</td>							
     		<td>
			<select name="codTipoPago" id="codTipoPago" class="textoform" >
				<?php
					$sql4="select cod_tipo_pago,nombre_tipo_pago from tipos_pago";
					$resp4=mysql_query($sql4);
						while($dat4=mysql_fetch_array($resp4))
						{
							$cod_tipo_pago=$dat4[0];	
			  		 		$nombre_tipo_pago=$dat4[1];	
				 ?>
				 			<?php if($cod_Tipo_Pago==$codtipopago){?>
				 			<option value="<?php echo $cod_tipo_pago;?>"selected="selected">
							<?php echo $nombre_tipo_pago;?>
							</option>				
						<?php }else{?>	
							<option value="<?php echo $cod_tipo_pago;?>"><?php echo $nombre_tipo_pago;?></option>				
						<?php }?>
										
				<?php		
					}
				?>						
			</select>
			</td>	
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>&nbsp;<b>Observaci&oacute;n</b>&nbsp;</td>
			<td colspan="3"><textarea cols="100" rows="1" name="obs" id="obs"  class="textoform" ><?php echo $obs_cotizacion;?></textarea></td>
		</tr>	
		<tr bgcolor="#FFFFFF">
			<td>&nbsp;<b>Suma total?</b>&nbsp;</td>			
     		<td>
			<?php if($cod_sumar==1){?>
				<INPUT type="checkbox" id="chkSumar" onchange="sumar(this);"  checked  />
			<?php }else{?>
				<INPUT type="checkbox" id="chkSumar" onchange="sumar(this);"  />
			<?php }?>
			
			</td>	
			<td>&nbsp;<b>Considerar Precio Unitario?</b>&nbsp;</td>			
     		<td>
			<?php if($considerar_precio_unitario==1){?>
				<input type="checkbox" id="chkConsiderarPrecioUnitario" name="chkConsiderarPrecioUnitario" onchange="ConsiderarPrecioUnitario(this)" checked />
			<?php }else{?>
				<input type="checkbox" id="chkConsiderarPrecioUnitario" name="chkConsiderarPrecioUnitario" onchange="ConsiderarPrecioUnitario(this)"/>
			<?php }?>
			
			</td>
		</tr>	
		<tr bgcolor="#FFFFFF">
			<td>&nbsp;<b>Firma:</b>&nbsp;</td>
			<td colspan="3">
			<select name="cod_usuario_firma" id="cod_usuario_firma" class="textoform" >
				<?php
					$sql4="select cod_usuario, nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios ";
					$sql4.=" where cod_usuario in(select cod_usuario from autorizados_firma_cotizacion) ";
					$resp4=mysql_query($sql4);
						while($dat4=mysql_fetch_array($resp4))
						{
							$cod_usuario=$dat4[0];
							$nombres_usuario=$dat4[1];
							$ap_paterno_usuario=$dat4[2];
							$ap_materno_usuario=$dat4[3];
								
				 ?>
				 	<?php if($cod_usuario==$codusuariofirma){ ?>
					 	<option value="<?php echo $cod_usuario;?>" selected="selected">
							<?php echo $nombres_usuario." ".$ap_paterno_usuario." ".$ap_materno_usuario;?>
						</option>	
					<?php }else{ ?>
						<option value="<?php echo $cod_usuario;?>">
							<?php echo $nombres_usuario." ".$ap_paterno_usuario." ".$ap_materno_usuario;?>
						</option>
					
					<?php }?>
								
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
						<input class="boton" type="button" value="Nuevo Item (+)" onclick="mas(this)" />
						<input class="boton" type="button" value="Memos Item (-)" onclick="menos(this)" />						
					</td>
				</tr>
				<tr>
					<td align="center" colspan="6">
					<div style="width:100%;" align="center"><b>DETALLE DE COTIZACI&Oacute;N</b></div>
					</td>				
				</tr>				
				<tr class="titulo_tabla" align="center">
					<td width="45%">Item</td>
					<td width="11%">Cantidad</td>
					<td width="12%">Precio Unitario </td>
					<td width="11%">Desc. %</td>
					<td width="8%">Importe</td>
					<td width="5%">&nbsp;</td>
					<td width="5%">&nbsp;</td>
				</tr>
			</table>
			<?php
			$cont=0;
			$sql_01=" select cod_item, cantidad_unitariacotizacion, ";
			$sql_01.=" precio_venta, descuento, importe_total,descripcion_item, cod_cotizaciondetalle ";
			$sql_01.=" from cotizaciones_detalle ";
			$sql_01.=" where cod_cotizacion='".$codCotizacion."'";
			$sql_01.=" order by cod_cotizaciondetalle asc";
			$resp_01= mysql_query($sql_01);
			while($dat_01=mysql_fetch_array($resp_01)){			
				$cont++;
				$codItemF=$dat_01[0];
				$cantidadUnitariaCotizacionF=$dat_01[1];
				$precioVentaF=$dat_01[2];
				$descuentoF=$dat_01[3];
				$importeTotalF=$dat_01[4];
				$descItem=$dat_01[5];
				
				$descItem=str_replace("|",",",$descItem);
				$cod_cotizaciondetalle=$dat_01[6];
				$nombreItem="";
				$sql3="select desc_item from items  where cod_item='".$codItemF."'";	
				$resp3= mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3)){
					$nombreItem=$dat3[0];
				}	
			?>
			<div id="div<?php echo $cont;?>">
			<table border="0" align="center" cellSpacing="1" cellPadding="1" width="100%"  style="border:#ccc 1px solid;" id="data<?php echo $cont?>" >
				<tr bgcolor="#FFFFFF">
					<td width="55%" align="left">					
					<br>
		&nbsp;&nbsp;<select class="textoform" id="cod_item<?php echo $cont;?>" onChange="javascript:items_caracteristicas(this.form,'<?php echo $cont?>');">
					<option value="<?php echo $codItemF;?>"><?php echo $nombreItem;?></option>
					<?php
					$sql="select cod_item,desc_item from items";
					$resp= mysql_query($sql);
					while($dat=mysql_fetch_array($resp)){
						$cod_item=$dat[0];
						$desc_item=$dat[1];
					?>
						<option value="<?php echo $cod_item;?>"><?php echo $desc_item;?></option>
					<?php										
					}
					?>
					</select>
					<br>
					&nbsp;&nbsp;<textarea cols="50" rows="1" name="obs" id="obs<?php echo $cont?>"  class="textoform" ><?php echo $descItem;?></textarea>
					<div id="div_items_caracteristicas<?php echo $cont?>" align="center">
					<table border="0" width="100%" id="dataCarac<?php echo $cont?>">
					<?php
					$sql2="select count(*) from componente_items where cod_item='".$codItemF."' order by cod_compitem asc";
					$resp2= mysql_query($sql2);	
					$countF=0;
					while($dat2=mysql_fetch_array($resp2)){
						$countF=$dat2[0];
					}					
					$sql2="select cod_compitem,nombre_componenteitem from componente_items ";
					$sql2.=" where cod_item='".$codItemF."' order by cod_compitem asc";
					$resp2= mysql_query($sql2);
					$filaComp=0;
					?>
					<?php
					while($dat2=mysql_fetch_array($resp2)){
						$codCompItem=$dat2[0];
						$nombreComponente=$dat2[1];
						$filaComp++;
						if($countF<=1){
							$nombreComponente="";
						}						
					?>
						<tr bgcolor="#FFFFFF">
							<td style="font-weight:bold;">&nbsp;</td>
							<td colspan="2">&nbsp;<b><?php echo $nombreComponente;?></b></td>
						</tr>
					<?php
						$sql3=" select cod_carac from componentes_caracteristica " ;
						$sql3.=" where cod_compitem='".$codCompItem."' order  by orden ";
						$resp3= mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3)){
							$codCarac=$dat3[0];
							$sql4="select desc_carac from caracteristicas where  cod_carac='".$codCarac."'";
								$resp4= mysql_query($sql4);
								while($dat4=mysql_fetch_array($resp4)){
									$descCarac=$dat4[0];
								}
									
						$sql5=" select desc_carac, cod_estado_registro from cotizacion_detalle_caracteristica ";
						$sql5.=" where cod_cotizaciondetalle='".$cod_cotizaciondetalle."'";
						$sql5.=" and cod_cotizacion='".$codCotizacion."'";
						$sql5.=" and cod_compitem='".$codCompItem."'";
						$sql5.=" and cod_carac='".$codCarac."' order by orden asc";
						$resp5= mysql_query($sql5);
						$descripcion_carac="";
						$cod_estado_registro=0;
						while($dat5=mysql_fetch_array($resp5)){
								$descripcion_carac=$dat5[0];
								$descripcion_carac=str_replace("|",",",$descripcion_carac);
								$cod_estado_registro=$dat5[1];
						}
					?>
					<tr bgcolor="#FFFFFF">
					<?php
							if($cod_estado_registro==1){
					?>
							<td>
							<input type="checkbox" checked="checked" id="codCarac<?php echo $filaComp;?><?php echo $codCarac;?>" value="<?php echo $codCarac;?>">
							</td>
							<?php
							}else{
							?>
							<td>
							<input type="checkbox" id="codCarac<?php echo $filaComp;?><?php echo $codCarac;?>" value="<?php echo $codCarac;?>"></td>
							<?php
							}
							?>
							<td>&nbsp;<?php echo $descCarac;?>&nbsp;</td>
						<td>
						<input class="textoform" type="text" id="descCarac<?php echo $filaComp;?><?php echo $codCarac;?>" value="<?php echo $descripcion_carac;?>"  size="35"  >
						</td>
						</tr>
						<?php
						}
						}
						?>
					</table>
					</div>
					</td>
					<td align="center" width="11%"><input type="text" class="textoform" value="<?php echo $cantidadUnitariaCotizacionF;?>"  id="cantidadUnitaria<?php echo $cont?>"  size="8" onKeyUp="importe('<?php echo $cont?>')" ></td>
					<td align="center" width="12%"><input type="text" class="textoform" value="<?php echo $precioVentaF;?>" id="precioVenta<?php echo $cont?>" onKeyUp="importe('<?php echo $cont?>')" size="8"></td>
					<td align="center" width="11%"><input type="text" class="textoform" value="<?php echo $descuentoF;?>" id="descuento<?php echo $cont?>" onKeyUp="importe('<?php echo $cont?>')" size="8"></td>
					<td align="right" width="8%" style="font-weight:bold;"><input type="text" class="textoform" value="<?php echo $importeTotalF;?>" id="importe<?php echo $cont?>" onKeyUp="importetotal('<?php echo $cont?>')" size="8"></td>
					<td align="right" width="5%" style="font-weight:bold;"><INPUT type="checkbox" id="chk<?php echo $cont?>"  value="" checked   /></td>
					<td><input class="boton" type="button" value="R" title="Replicar Item"  onclick="replicar(<?php echo $cont?>)" /></td>
				</tr>
			</table>
			</div>
			<?php 
			}
			?>
		</fieldset>
		<table align="center"class="text" cellSpacing="1" cellPadding="2" width="80%" border="0" id="dataTotal">
				<tr class="titulo_tabla">
					<td width="79%" colspan="4">&nbsp;<b>Total</b></td>
					<td width="11%" align="right"><SPAN id="importeTotal">0</SPAN></td>
					<td colspan="2" width="10%">&nbsp;</td>
				</tr>		
		</table>
	</center>
	<br>
	<center>
		<input type="button" class="boton" value="Guardar" onclick="enviar(form)" />
		<input type="button" class="boton" value="Cancelar" onClick="cancelar();" />
	</center>

	<input type="hidden" name="codCliente" id="codClienteF">
	<input type="hidden" name="fechaCotizacionF" id="fechaCotizacionF">
	<input type="hidden" name="codTipoCotizacionF" id="codTipoCotizacionF">
	<input type="hidden" name="obsF" id="obsF">
	<input type="hidden" name="codTipoPagoF" id="codTipoPagoF">
	<input type="hidden" name="codUsuarioFirmaF" id="codUsuarioFirmaF">	
	
	<input type="hidden" name="codItemF" id="codItemF">	
	<input type="hidden" name="cantidadUnitariaF" id="cantidadUnitariaF">	
	<input type="hidden" name="precioVentaF" id="precioVentaF">	
	<input type="hidden" name="descuentoF" id="descuentoF">	
	<input type="hidden" name="importeF" id="importeF">				
	
	<input type="hidden" name="codCaracF" id="codCaracF">				
	<input type="hidden" name="descCaracF" id="descCaracF">
	<input type="hidden" name="codCotizacionF" id="codCotizacionF" value="<?php echo $codCotizacion;?>" >	
	
	<input type="hidden" name="descItemF" id="descItemF">
	<input type="hidden" name="chkSumarF" id="chkSumarF">
	<input type="hidden" name="chkConsiderarPrecioUnitarioF" id="chkConsiderarPrecioUnitarioF">	

</form>

</body>
</html>
