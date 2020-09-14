<?php

header("Cache-Control: no-store, no-cache, must-revalidate");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
</head>

<body>

<script language='Javascript'>
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


	num=0;

	function mas(f,obj) {
		if(f.cod_tipo_salida.value!=0)
		{
  			num++;
			fi = document.getElementById('fiel');
			contenedor = document.createElement('div');
			contenedor.id = 'div'+num;  
			fi.type="style";
			fi.appendChild(contenedor);
			var div_material;
			div_material=document.getElementById("div"+num);			
			ajax=nuevoAjax();
			ajax.open("GET","ajaxMaterialSalida.php?codigo="+num+"&cod_tipo_salida="+f.cod_tipo_salida.value,true);
			ajax.onreadystatechange=function(){
				if (ajax.readyState==4) {
					div_material.innerHTML=ajax.responseText;
			    	}
	    	}		
			ajax.send(null)

		}else{
			alert("Seleccione el Tipo de Salida.");
		}
	}	
	function menos(numero) {
  		fi = document.getElementById('fiel');
  		fi.removeChild(document.getElementById('div'+numero));
  		calcularTotal();
	}
	

function importe(fila){
if(document.getElementById('cod_tipo_salida').value==1){
		var cantidad=document.getElementById('cantidad'+fila).value;

		var precioVenta=document.getElementById('precioVenta'+fila).value;
	  	var importe=document.getElementById('importe'+fila);
		importe.value=(parseFloat(cantidad)*parseFloat(precioVenta));
	
	if(importe.value=="NaN"){
		importe.value=0;
	}

		calcularTotal();
}
}


function verHojaRuta(f)
{	
			
		ajax=nuevoAjax();

		ajax.open("GET","ajax_verHojaRuta.php?cod_hoja_ruta="+document.getElementById("cod_hoja_ruta").value,true);	
					
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
			document.getElementById("div_detalleHojaRuta").innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null);
}
function tipoSalidaAlmacen(f,cod_almacen)
{	
		var  i=0;
		for(i=1;i<=num;i++){
			if(document.getElementById('cod_material'+i)){
		  		fi = document.getElementById('fiel');
  				fi.removeChild(document.getElementById('div'+i));
  				calcularTotal();
			}
		}
		
		ajax=nuevoAjax();
		ajax.open("GET","ajax_tipoSalidaAlmacen.php?cod_tipo_salida="+document.getElementById("cod_tipo_salida").value+"&cod_almacen="+cod_almacen,true);	

		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
			document.getElementById("div_tipoSalidaAlmacen").innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null);
		
		ajax2=nuevoAjax();
		ajax2.open("GET","ajax_etiquetaTipoSalidaAlmacen.php?cod_tipo_salida="+document.getElementById("cod_tipo_salida").value,true);	
					
		ajax2.onreadystatechange=function(){
			if (ajax2.readyState==4) {
			document.getElementById("div_etiquetaTipoSalidaAlmacen").innerHTML=ajax2.responseText;
		    }
	    }		
		ajax2.send(null);
		
		ajax3=nuevoAjax();
		ajax3.open("GET","ajax_tituloPrecioVenta.php?cod_tipo_salida="+document.getElementById("cod_tipo_salida").value,true);	
					
		ajax3.onreadystatechange=function(){
			if (ajax3.readyState==4) {
			document.getElementById("div_tituloPrecioVenta").innerHTML=ajax3.responseText;
		    }
	    }		
		ajax3.send(null);
		
		ajax4=nuevoAjax();
		ajax4.open("GET","ajax_tituloImporteSalida.php?cod_tipo_salida="+document.getElementById("cod_tipo_salida").value,true);	
					
		ajax4.onreadystatechange=function(){
			if (ajax4.readyState==4) {
			document.getElementById("div_tituloImporteSalida").innerHTML=ajax4.responseText;
		    }
	    }		
		ajax4.send(null);			
		
		ajax5=nuevoAjax();
		ajax5.open("GET","ajax_TotalVentaSalida.php?cod_tipo_salida="+document.getElementById("cod_tipo_salida").value,true);	
					
		ajax5.onreadystatechange=function(){
			if (ajax5.readyState==4) {
			document.getElementById("div_TotalVentaSalida").innerHTML=ajax5.responseText;
		    }
	    }		
		ajax5.send(null);
}	
function calcularTotal(){
  if(document.getElementById('importeTotal')){
		var importeTotal=document.getElementById('importeTotal');
		var sumImporteParcial=0;
		for(i=1;i<=num;i++){
			if(document.getElementById('importe'+i)){
				var importeParcial=document.getElementById('importe'+i).value;
				sumImporteParcial=parseFloat(sumImporteParcial)+parseFloat(importeParcial);
			}	
		}	
		importeTotal.innerHTML=Math.round(sumImporteParcial*100)/100;
	}
}
function guardar(f){	
		
		if(f.cod_tipo_salida.value==0){
			alert("Seleccione el tipo de Salida ");
			f.cod_tipo_salida.focus();
			return false;
		
		}else{
		
			if(f.cod_tipo_salida.value==1){					
					if(f.cod_cliente_venta.value==0){
						alert("El Campo Cliente se encuentra vacio. ");
						f.cod_cliente_venta.focus();
						return false;
					}
			}
			
			if(f.cod_tipo_salida.value==2){
					if(f.cod_hoja_ruta.value==0){
						alert("Seleccione la Hoja de Ruta para Salida.");
						f.cod_hoja_ruta.focus();
						return false;
					} 
			}
			
			if(f.cod_tipo_salida.value==3){
			
					if(f.cod_almacen_traspaso.value==0){
						alert("Seleccione el Almacen de Traspaso.");
						f.cod_almacen_traspaso.focus();
						return false;
					} 
					
			}
			
			/////////////////////////
			f.num.value=num;		
			numReg=0;
			for(i=1;i<=num;i++){
				if(document.getElementById("cod_material"+i)){
					 numReg++;
				}			
			}
			
			//alert('numReg'+numReg);
			if(numReg==0){
			 	alert('Para realizar una Salida de Almacen debe tener materiales en el detalle.'); 			 	
		 	 	return(false);
			}else{
				//////////////////////
				var sw=1;
				for(ii=1; ii<=f.num.value; ii++){
					if(document.getElementById('div_cantActual'+ii)){
						var stock=document.getElementById("div_cantActual"+ii).innerHTML;			
						var cantSalida=document.getElementById("cantidad"+ii).value;				
						if(cantSalida<0){
							sw=0;
							alert("Debe sacar cantidades positivas. ");							
							return false;
						}
						if((cantSalida*1)>(stock*1)){
						//alert("cantSalida="+cantSalida);
						//alert("stock="+stock);
								sw=0;
								alert("No puede sacar una cantidad mayor al Stock.");
								return false;
						}						
					}	
			
				}
				/////////////////////////
				if(sw==1){
					f.submit();
				}				
			}
			
			
			/////////////////////////////////////////
		}
		
		
	}	
	
	function cancelar(f)
	{	
		window.location="seleccionarAlmacenSalida.php";
	}

function buscarMaterial(numMaterial){
		izquierda = (screen.width) ? (screen.width-600)/2 : 100 
	    arriba = (screen.height) ? (screen.height-400)/2 : 100 
		url="ajax_listMaterial.php?numMaterial="+numMaterial;
		opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=650,left='+izquierda+',top=' + arriba + '' 
	   	window.open(url, 'popUp', opciones);
	

}

function setMateriales(numRegistro, cod, nombreMat){
	
	document.getElementById('desc_material'+numRegistro).value=nombreMat;
	document.getElementById('cod_material'+numRegistro).value=cod;
	
	
		ajax=nuevoAjax();
		ajax.open("GET","ajax_unidadMedidaMaterial.php?cod_material="+document.getElementById("cod_material"+numRegistro).value,true);						
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
			document.getElementById("div_unidad"+numRegistro).innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null);	
					
		ajax2=nuevoAjax();
		ajax2.open("GET","ajax_cantActualMaterial.php?cod_material="+document.getElementById("cod_material"+numRegistro).value+"&cod_almacen="+document.getElementById("cod_almacen").value,true);	
					
		ajax2.onreadystatechange=function(){
			if (ajax2.readyState==4) {
			document.getElementById("div_cantActual"+numRegistro).innerHTML=ajax2.responseText;
		    }
	    }		
		ajax2.send(null)
		
		ajax3=nuevoAjax();

		ajax3.open("GET","ajax_precioVentaMaterialSalida.php?numero="+numRegistro+"&cod_tipo_salida="+document.getElementById("cod_tipo_salida").value+"&cod_material="+document.getElementById("cod_material"+numRegistro).value,true);	
					
		ajax3.onreadystatechange=function(){
			if (ajax3.readyState==4) {
			document.getElementById("div_precioVenta"+numRegistro).innerHTML=ajax3.responseText;
		    }
	    }		
		ajax3.send(null)
		
		ajax4=nuevoAjax();

		ajax4.open("GET","ajax_importeMaterialSalida.php?numero="+numRegistro+"&cod_tipo_salida="+document.getElementById("cod_tipo_salida").value+"&cod_material="+document.getElementById("cod_material"+numRegistro).value,true);	
					
		ajax4.onreadystatechange=function(){
			if (ajax4.readyState==4) {
			document.getElementById("div_importe"+numRegistro).innerHTML=ajax4.responseText;
		    }
	    }		
		ajax4.send(null)
		
		
	
}



function buscarCliente(){
		izquierda = (screen.width) ? (screen.width-600)/2 : 100 
	    arriba = (screen.height) ? (screen.height-400)/2 : 100 
		url="ajax_listClientes.php";
opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=650,left='+izquierda+',top=' + arriba + '' 
	   	window.open(url, 'popUp', opciones);
}
function setClientes(cod_cli, nombreCliente){
	document.getElementById('nombre_cliente_venta').value=nombreCliente;
	document.getElementById('cod_cliente_venta').value=cod_cli;
	
	ajax=nuevoAjax();
	ajax.open("GET","ajaxListaContactos.php?cod_cliente="+document.getElementById('cod_cliente_venta').value,true);	
					
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4) {
			document.getElementById("div_contactoCliente").innerHTML=ajax.responseText;
		    }
	    }		
	ajax.send(null);	
	

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

		var cod_cliente=document.getElementById("cod_cliente_venta").value;
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
function cargar_contacto()
{			
		izquierda = (screen.width) ? (screen.width-600)/2 : 100 
	    arriba = (screen.height) ? (screen.height-400)/2 : 100 
		url="registrarContactoAjax.php?cod_cliente="+document.getElementById("cod_cliente_venta").value;
		opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=500,height=400,left='+izquierda+',top=' + arriba + '' 
	   	window.open(url, 'popUp', opciones);
}	
function datosContacto(f)
{	 

		var cod_contacto=document.getElementById("cod_contacto").value;
		cod_contacto=cod_contacto*1;
		if(cod_contacto!=0){
		
			izquierda = (screen.width) ? (screen.width-600)/2 : 100 
		    arriba = (screen.height) ? (screen.height-400)/2 : 100 
			url="datosContactoAjax.php?cod_contacto="+cod_contacto;
			opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=500,height=400,left='+izquierda+',top=' + arriba + '' 
		   	window.open(url, 'popUp', opciones)
			
		}else{
			alert("Seleccione un contacto");
			
		}
}	
function cargar_contacto_ajax(url)
{	var div_contactoCliente;
		div_contactoCliente=document.getElementById("div_contactoCliente");
		ajax=nuevoAjax();
		ajax.open("GET", url,true);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4) {
			div_contactoCliente.innerHTML=ajax.responseText;
			}
		}
		ajax.send(null)
}	
</script>
</head>
<body>

<form    method="post" action="guardaRegistrarSalida.php" name="form1" id="form1">
<input type="hidden" name="cod_almacen" id="cod_almacen" value="<?php echo $_COOKIE['cod_almacen_global'];?>">
<input type="hidden" name="num" id="num">
<?php 	


	require("conexion.inc");
	include("funciones.php");
	$cod_almacen=$_COOKIE['cod_almacen_global'];
	
	$sql2="select nombre_almacen from almacenes where cod_almacen='".$cod_almacen."'";
	$resp2= mysql_query($sql2);
	$nombre_almacen="";
	while($dat2=mysql_fetch_array($resp2)){
		$nombre_almacen=$dat2[0];
	}	

	
				
	$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios ";
	$sql2.=" where cod_usuario='".$_COOKIE['usuario_global']."'";
	$resp2= mysql_query($sql2);
	$nombres_usuario="";
	$ap_paterno_usuario="";
	$ap_materno_usuario="";		
	while($dat2=mysql_fetch_array($resp2)){	
		$nombres_usuario=$dat2[0];
		$ap_paterno_usuario=$dat2[1];
		$ap_materno_usuario=$dat2[2];		
	}	
	
			
	
	$cod_gestion=gestionActiva();
	
	$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion."'";
	$resp2= mysql_query($sql2);
	$gestion="";
	while($dat2=mysql_fetch_array($resp2)){
		$gestion=$dat2[0];
	}
	$sql="select max(nro_salida) from salidas where cod_gestion='".$cod_gestion."' and cod_almacen='".$cod_almacen."'";
	$nro_salida=obtenerCodigo($sql);
?>

<h3 align="center" style="background:white;font-size: 12px;color:#E78611;font-weight:bold;">Salida de Material   <?php echo $nombre_almacen; ?> <br>
   No. <?php echo $nro_salida;?>/<?php echo $gestion;?><br><?php echo "Fecha: ".date('d/m/Y', time());?></h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="85%" bgColor="#cccccc" border="0">
	<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="4" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
		 <!--tr bgcolor="#FFFFFF">
     		<td>Responsable de Ingreso</td>
      		<td><?php echo $nombres_usuario." ".$ap_paterno_usuario." ".$ap_materno_usuario; ?></td>
    	</tr-->
				 
		 <tr bgcolor="#FFFFFF">
     		<td><strong>Tipo Salida:</strong></td>
      		<td colspan="3"><select name="cod_tipo_salida" id="cod_tipo_salida" class="textoform" onChange="tipoSalidaAlmacen(this.form,<?php echo $cod_almacen;?>)">
				<option value="0">Seleccione una opcion</option>	
              <?php
					$sql2=" select cod_tipo_salida, nombre_tipo_salida from tipos_salida";
					$sql2.=" order by  nombre_tipo_salida asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_tipo_salida=$dat2[0];	
			  		 		$nombre_tipo_salida=$dat2[1];	
				 ?>
      		  <option value="<?php echo $cod_tipo_salida;?>"><?php echo $nombre_tipo_salida;?></option>
              <?php		
					}
				?>
            </select></td>
    	</tr>
		<tr bgcolor="#FFFFFF">
			<td>
			<strong>
			<div id="div_etiquetaTipoSalidaAlmacen">
			</div>
			</strong>
			
			</td>
			
			<td colspan="2">
			<div id="div_tipoSalidaAlmacen">
			</div>
			</td>
			<td >
			<div id="div_detalleHojaRuta">
			</div>
			</td>
		</tr>		
				<tr bgcolor="#FFFFFF">
			<td><strong>Observaci&oacute;n</strong></td>
			<td colspan="3"><textarea cols="70" rows="1" name="obs_salida" id="obs_salida"  class="textoform" ></textarea></td>
		</tr>							
	  </tbody>
	</table>	
	<center>
		<fieldset id="fiel" style="width:98%;border:0;" >
			<table align="center"class="text" cellSpacing="1" cellPadding="2" width="100%" border="0" id="data0">
				<tr>
					<td align="center" colspan="6">
						<input class="boton" type="button" value="Nuevo Item (+)" onclick="mas(this.form,this)" />					
					</td>
				</tr>
				<tr>
					<td align="center" colspan="6">
					<div style="width:100%;" align="center"><b>DETALLE DE SALIDA</b></div>
					</td>				
				</tr>				
				<tr class="titulo_tabla" align="center">
					<td width="57%">Material</td>
					<td width="3%">Unid</td>
					<td width="5%">Stock Actual</td>
					<td width="8%">Cantidad Salida</td>
					<td width="11%"><div id="div_tituloPrecioVenta"></div></td>
					<td width="9%"><div id="div_tituloImporteSalida"></div></td>
					<td width="7%">&nbsp;</td>
				</tr>
			</table>
		</fieldset>

		<div id="div_TotalVentaSalida">

		</div>
	</center>	

<br>
<div align="center">
	<input type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
	
</div>
<input type='hidden' name='materialActivo' value="0">
</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>
