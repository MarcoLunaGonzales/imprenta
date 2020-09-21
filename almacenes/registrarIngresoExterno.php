<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Registro de Ingreso </title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script type="text/javascript" src="lib/externos/jquery/jquery-1.4.4.min.js"></script>
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
	
	function mas(obj) {

  		num++;
		fi = document.getElementById('fiel');
		contenedor = document.createElement('div');
		contenedor.id = 'div'+num;  
		fi.type="style";
		fi.appendChild(contenedor);
		var div_material;
		div_material=document.getElementById("div"+num);			
		ajax=nuevoAjax();
		ajax.open("GET","ajaxMaterial.php?codigo="+num,true);
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
				div_material.innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null);
	}	
		
	function menos(numero) {


		 fi = document.getElementById('fiel');
  		 fi.removeChild(document.getElementById('div'+numero));
 		// num=parseInt(num)-1;
 		 calcularTotal();
	}


function importe(fila){

		var cantidad=document.getElementById('cantidad'+fila).value;
		//document.getElementById('precioCompra'+fila).value=Math.round(document.getElementById('precioCompra'+fila).value*100)/100;
		var precioCompra=document.getElementById('precioCompra'+fila).value;
		
		var importe=document.getElementById('importe'+fila);
		importe.value=(parseFloat(cantidad)*parseFloat(precioCompra));
		importe.value=Math.round(importe.value*100)/100;

	if(importe.value=="NaN"){
		importe.value=0;
	}

		calcularTotal();

}

function calcularTotal(){
	var importeTotal=document.getElementById('importeTotal');
	var sumImporteParcial=0;
	for(i=1;i<=num;i++){
		
		if(document.getElementById('importe'+i)){
			var importeParcial=document.getElementById('importe'+i).value;
			sumImporteParcial=parseFloat(sumImporteParcial)+parseFloat(importeParcial);
		}
	}	
	importeTotal.innerHTML=Math.round(sumImporteParcial*100)/100;
	///Total///
	document.getElementById('total_bs').value=Math.round(sumImporteParcial*100)/100;
}

function cancelar(f)
{	
	window.location="seleccionarAlmacenIngreso.php";
}	

	function guardar(f)
	{	
			if(f.cod_proveedor.value==0){
			 	alert('Seleccione Proveedor.'); 
			 	f.cod_proveedor.focus();
		 	 	return(false);
			}
			if(f.nro_factura.value!=""){
				if(f.fecha_factura.value==""){
				 	alert('Debe llenar la Fecha de Factura.'); 
				 	f.fecha_factura.focus();
			 	 	return(false);
				}
			}			
					
			f.num.value=num;

			numReg=0;
			for(i=1;i<=num;i++){
				if(document.getElementById("cod_material"+i)){
					 numReg++;
				}			
			}
			
			if(numReg==0){
			 	alert('Para guardar el Ingreso debe tener materiales en el detalle.'); 			 	
		 	 	return(false);
			}else{
				if( confirm("El Total de Bs del Ingreso es: "+document.getElementById('total_bs').value+", desea continuar?")){
					f.submit();
				}else{
					return(false);
				}
				
			}					
			
		}	

function buscarMaterial( numMaterial){

		izquierda = (screen.width) ? (screen.width-600)/2 : 100;

	    arriba = (screen.height) ? (screen.height-400)/2 : 100;

		
		url="ajax_listMaterial.php?numMaterial="+numMaterial;

		opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=650,left='+izquierda+',top=' + arriba + '';

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

		ajax2.open("GET","ajax_precioVentaMaterial.php?num="+numRegistro+"&cod_material="+document.getElementById("cod_material"+numRegistro).value,true);	
					
		ajax2.onreadystatechange=function(){
			if (ajax2.readyState==4) {
			document.getElementById("div_precioVenta"+numRegistro).innerHTML=ajax2.responseText;
		    }
	    }		
		ajax2.send(null)
		
	
}
function buscarProveedor(){
		izquierda = (screen.width) ? (screen.width-600)/2 : 100 
	    arriba = (screen.height) ? (screen.height-400)/2 : 100 
		url="ajax_listProveedores.php";
opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=650,left='+izquierda+',top=' + arriba + '' 
	   	window.open(url, 'popUp', opciones);
}
function setProveedores(cod_pro, nombreProveedor){
	document.getElementById('nombre_proveedor').value=nombreProveedor;
	document.getElementById('cod_proveedor').value=cod_pro;
	
	ajax=nuevoAjax();
	ajax.open("GET","ajaxListaContactosProveedores.php?cod_proveedor="+document.getElementById('cod_proveedor').value,true);	
					
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4) {
			document.getElementById("div_contactoProveedor").innerHTML=ajax.responseText;
		    }
	    }		
	ajax.send(null);
	

}
/************************************************/
function cargar_proveedor()
{			
		izquierda = (screen.width) ? (screen.width-600)/2 : 100 
	    arriba = (screen.height) ? (screen.height-400)/2 : 100 
		url="registrarProveedorAjax.php";
		opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=500,height=400,left='+izquierda+',top=' + arriba + '' 
	   	window.open(url, 'popUp', opciones);
}	
function datosProveedor(f)
{	 

		var cod_proveedor=document.getElementById("cod_proveedor").value;
		cod_proveedor=cod_proveedor*1;
		if(cod_proveedor!=0){
		
			izquierda = (screen.width) ? (screen.width-600)/2 : 100 
		    arriba = (screen.height) ? (screen.height-400)/2 : 100 
			url="datosProveedorAjax.php?cod_proveedor="+cod_proveedor;
			opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=500,height=400,left='+izquierda+',top=' + arriba + '' 
		   	window.open(url, 'popUp', opciones)
			
		}else{
			alert("Seleccione un Proveedor");
			
		}
}

function cargar_contactoProveedor()
{			
		izquierda = (screen.width) ? (screen.width-600)/2 : 100 
	    arriba = (screen.height) ? (screen.height-400)/2 : 100 
		url="registrarContactoProveedorAjax.php?cod_proveedor="+document.getElementById("cod_proveedor").value;
		opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=500,height=400,left='+izquierda+',top=' + arriba + '' 
	   	window.open(url, 'popUp', opciones);
}	
function datosContactoProveedor(f)
{	 

		var cod_contacto_proveedor=document.getElementById("cod_contacto_proveedor").value;
		var cod_proveedor=document.getElementById("cod_proveedor").value;
		cod_contacto_proveedor=cod_contacto_proveedor*1;
		if(cod_contacto_proveedor!=0){
		
			izquierda = (screen.width) ? (screen.width-600)/2 : 100 
		    arriba = (screen.height) ? (screen.height-400)/2 : 100 
			url="datosContactoProveedorAjax.php?cod_contacto_proveedor="+cod_contacto_proveedor+"&cod_proveedor="+cod_proveedor;
			opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=500,height=400,left='+izquierda+',top=' + arriba + '' 
		   	window.open(url, 'popUp', opciones)
			
		}else{
			alert("Seleccione un contacto");
			
		}
}	
function cargar_contactoProveedor_ajax(url)
{	var div_contactoProveedor;
		div_contactoProveedor=document.getElementById("div_contactoProveedor");
		ajax=nuevoAjax();
		ajax.open("GET", url,true);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4) {
			div_contactoProveedor.innerHTML=ajax.responseText;
			}
		}
		ajax.send(null)
}	
</script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="guardaRegistrarIngresoExterno.php" name="form1" id="form1">
<input type="hidden" name="num">
<?php 	


	require("conexion.inc");
	include("funciones.php");
	$cod_tipo_pago_defecto=2;
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
	
	$sql2="select gestion_nombre from gestiones where cod_gestion='".$cod_gestion."'";
	$resp2= mysql_query($sql2);
	$gestion="";
	while($dat2=mysql_fetch_array($resp2)){
		$gestion_nombre=$dat2[0];
	}
	$sql="select max(nro_ingreso) from ingresos where cod_gestion='".$cod_gestion."' and cod_almacen='".$cod_almacen."'";
	$nro_ingreso=obtenerCodigo($sql);
?>
<input type="hidden" name="cod_almacen" value="<?php echo $cod_almacen;?>">

<h3 align="center" style="background:white;font-size: 12px;color:#E78611;font-weight:bold;">Ingreso de Material a  <?php echo $nombre_almacen; ?> <br> No. <?php echo $nro_ingreso;?>/<?php echo $gestion_nombre;?><br><?php echo "Fecha: ".date('d/m/Y', time());?></h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0">
	<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="4" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
			 
		 <tr bgcolor="#FFFFFF">
     		<td><strong>Proveedor</strong></td>
      		<td colspan="3">
            <input type="hidden" name="cod_proveedor" id="cod_proveedor" value="0" >
<input type="text" class="textoform" id="nombre_proveedor" name="nombre_proveedor" size="40" disabled="disabled">
<a href="javascript:buscarProveedor()" accesskey="B">[Buscar Proveedor]</a>
<a  href="javascript:cargar_proveedor();">[Nuevo Proveedor]</a>
<a  href="javascript:datosProveedor(this.form);">[Datos Proveedor]</a>

            </td>
    	</tr>	
        <tr bgcolor="#FFFFFF">
                <th align="left">Contacto</td><td colspan="3"><div id="div_contactoProveedor">
			<select name="cod_contacto_proveedor" id="cod_contacto_proveedor" class="textoform" disabled>
<option value="0">Seleccione un Contacto</option>
</select>
</div></th>
        </tr> 
		 <tr bgcolor="#FFFFFF">
     		<td ><strong>Nro Factura:</strong></td>
      		<td ><input type="text"  class="textoform" size="12" name="nro_factura" >
			<strong>Fecha Factura(dd/mm/aaaa):</strong> <input type="text"  class="textoform" size="10" name="fecha_factura" >
			</td>
			<td ><strong>Tipo de Pago </strong></td>
			<td ><select name="cod_tipo_pago" id="cod_tipo_pago" class="textoform" >
				<?php
					$sql4="select cod_tipo_pago,nombre_tipo_pago from tipos_pago";
					$resp4=mysql_query($sql4);
						while($dat4=mysql_fetch_array($resp4))
						{
							$cod_tipo_pago=$dat4[0];	
			  		 		$nombre_tipo_pago=$dat4[1];	
				 ?><option value="<?php echo $cod_tipo_pago;?>" <?php if($cod_tipo_pago_defecto==$cod_tipo_pago){?>selected<?php }?>><?php echo $nombre_tipo_pago;?></option>				
				<?php		
					}
				?>						
			</select></td>			
    	</tr>	
		 <tr bgcolor="#FFFFFF">
     		<td><strong>Dias Plazo</strong></td>
      		<td><input type="text"  class="textoform" size="10" name="dias_plazo_pago" id="dias_plazo_pago"  value="0"></td>
			<td><strong>Total Bs.</strong></td>
      		<td><input type="text"  class="textoform" size="10" name="total_bs" id="total_bs" value="0" ></td>
    	</tr>			
		<tr bgcolor="#FFFFFF">
			<td><strong>Observaci&oacute;n</strong></td>
			<td colspan="3"><textarea cols="70" rows="1" name="obs_ingreso" id="obs_ingreso"  class="textoform" ></textarea></td>
		</tr>							
	  </tbody>
	</table>	
	<center>
		<fieldset id="fiel" style="width:98%;border:0;" >
			<table align="center"class="text" cellSpacing="1" cellPadding="2" width="100%" border="0" id="data0">
				<tr>
					<td align="center" colspan="6">
						<input class="boton" type="button" value="Nuevo Item (+)" onclick="mas(this)" />
						<!--input class="boton" type="button" value="Memos Item (-)" onclick="menos(this)" /-->						
					</td>
				</tr>
				<tr>
					<td align="center" colspan="6">
					<div style="width:100%;" align="center"><b>DETALLE DE COTIZACI&Oacute;N</b></div>
					</td>				
				</tr>				
				<tr class="titulo_tabla" align="center">
					<td width="55%">Material</td>
					<td width="5%">Unidad</td>
					<td width="8%">Cantidad</td>
					<td width="8%">Precio Compra </td>
					<td width="8%">Precio Venta </td>
					<td width="8%">Total</td>
					<td width="8%">&nbsp;</td>

				</tr>
			</table>
		</fieldset>
           

		
		<table align="center"class="text" cellSpacing="1" cellPadding="2" width="98%" border="0" id="dataTotal">
				<tr class="titulo_tabla">
					<td width="84%" colspan="5">&nbsp;<b>Total</b></td>
					<td width="8%" align="right"><SPAN id="importeTotal">0</SPAN></td>
					<td width="8%" align="right">&nbsp;</td>
					
				</tr>		
		</table>
	</center>	

<br>

<div align="center">
	<input type="reset"  class="boton"  name="btn_limpiar" value="Cancelar Ingreso" onClick="cancelar(this.form);" >
	<input type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >

</div>
<?php require("cerrar_conexion.inc");
?>

<input type='hidden' name='materialActivo' value="0">

</form>


</body>
</html>
