<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Registro de Ingreso </title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
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
function ajaxMaterial(cont)
{	
		var div_material;
		div_material=document.getElementById("div"+cont);			
		ajax=nuevoAjax();
		ajax.open("GET","ajaxMaterial.php?codigo="+cont,true);
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
				div_material.innerHTML=ajax.responseText;
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
		var div_material;
		div_material=document.getElementById("div"+num);			
		ajax=nuevoAjax();
		ajax.open("GET","ajaxMaterial.php?codigo="+num,true);
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
				div_material.innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null)
	}	
	function menos() {
  		fi = document.getElementById('fiel');
  		fi.removeChild(document.getElementById('div'+num));
  		num=parseInt(num)-1;
  		calcularTotal();
	}
	function sumar(obj){
	if(obj.checked==true){
		calcularTotal();
	}else{
		document.getElementById('importeTotal').innerHTML="";
	}
}
function importe(fila){

		var cantidad=document.getElementById('cantidad'+fila).value;
		document.getElementById('precioCompra'+fila).value=Math.round(document.getElementById('precioCompra'+fila).value*100)/100;
		var precioCompra=document.getElementById('precioCompra'+fila).value;
		
		var importe=document.getElementById('importe'+fila);
		importe.value=(parseFloat(cantidad)*parseFloat(precioCompra));
		importe.value=Math.round(importe.value*100)/100;

	if(importe.value=="NaN"){
		importe.value=0;
	}

		calcularTotal();

}
function importetotal(fila){

	var cantidad=document.getElementById('cantidad'+fila).value;
	var precioCompra=document.getElementById('precioCompra'+fila);
	var precioMercado=document.getElementById('precioMercado'+fila);
	var importe=document.getElementById('importe'+fila).value;

	if(cantidad>0){		
		importe.value=(parseFloat(cantidad)*(parseFloat(precioCompra)));
		importe.value=Math.round(importe.value*100)/100;
		
		if(importe.value=="NaN"){
			importe.value=0;
		}
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
	importeTotal.innerHTML=Math.round(sumImporteParcial*100)/100;
}
	
	function guardar(f)
	{	
			if(f.cod_proveedor.value==0){
			 	alert('Seleccione Proveedor.'); 
			 	f.cod_proveedor.focus();
		 	 	return(false);
			}
			if(f.nro_factura.value==""){
			 	alert('El campo Nro de Factura se encuentra vacio.'); 
			 	f.nro_factura.focus();
		 	 	return(false);
			}			
					
			f.num.value=num;

			if(f.num.value==0){
			 	alert('Ingrese Materiales.'); 			 	
		 	 	return(false);
			}	
			//alert(f.num.value);
			f.submit();
		}	
function listaDatosMateriales(f)
{	
		
		ajax=nuevoAjax();
		ajax.open("GET","ajax_unidadMedidaMaterial.php?cod_material="+document.getElementById("cod_material"+num).value,true);	
					
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
			document.getElementById("div_unidad"+num).innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null);
		
		ajax2=nuevoAjax();
		ajax2.open("GET","ajax_precioVentaMaterial.php?num="+num+"&cod_material="+document.getElementById("cod_material"+num).value,true);	
					
		ajax2.onreadystatechange=function(){
			if (ajax2.readyState==4) {
			document.getElementById("div_precioVenta"+num).innerHTML=ajax2.responseText;
		    }
	    }		
		ajax2.send(null)
		
		
}			
	function cancelar(f)
	{	
		window.location="seleccionarAlmacenIngreso.php";
	}			
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="guardaRegistrarIngresoExterno.php">
<input type="hidden" name="num">
<?php 	


	require("conexion.inc");
	include("funciones.php");
//	$cod_almacen=$_GET['cod_almacen'];
	$cod_ingreso=$_GET['cod_ingreso'];
	
	
	
	
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
	$sql="select max(nro_ingreso) from ingresos where cod_gestion='".$cod_gestion."' and cod_almacen='".$cod_almacen."'";
	$nro_ingreso=obtenerCodigo($sql);
?>
<input type="hidden" name="cod_almacen" value="<?php echo $cod_almacen;?>">
<h3 align="center" style="background:white;font-size: 12px;color:#E78611;font-weight:bold;">Edici&oacute;n de Ingreso Externo <br>
   No. <?php echo $nro_ingreso;?>/<?php echo $gestion;?><br><?php echo "Fecha: ".date('d/m/Y', time());?></h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
	<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
		 <!--tr bgcolor="#FFFFFF">
     		<td>Responsable de Ingreso</td>
      		<td><?php echo $nombres_usuario." ".$ap_paterno_usuario." ".$ap_materno_usuario; ?></td>
    	</tr-->
			 
		 <tr bgcolor="#FFFFFF">
     		<td>Proveedor</td>
      		<td><select name="cod_proveedor" class="textoform" 	>
				<option value="0">Seleccione una opcion</option>	
              <?php
					$sql2=" select cod_proveedor, nombre_proveedor from proveedores";
					$sql2.=" where cod_estado_registro=1 order by  nombre_proveedor asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_proveedor=$dat2[0];	
			  		 		$nombre_proveedor=$dat2[1];	
				 ?>
      		  <option value="<?php echo $cod_proveedor;?>"><?php echo $nombre_proveedor;?></option>
              <?php		
					}
				?>
            </select></td>
    	</tr>	
		 <tr bgcolor="#FFFFFF">
     		<td>Nro Factura</td>
      		<td><input type="text"  class="textoform" size="40" name="nro_factura" ></td>
    	</tr>	
		<tr bgcolor="#FFFFFF">
			<td>Observaci&oacute;n</td>
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
						<input class="boton" type="button" value="Memos Item (-)" onclick="menos(this)" />						
					</td>
				</tr>
				<tr>
					<td align="center" colspan="6">
					<div style="width:100%;" align="center"><b>DETALLE DE COTIZACI&Oacute;N</b></div>
					</td>				
				</tr>				
				<tr class="titulo_tabla" align="center">
					<td width="60%">Material</td>
					<td width="8%">Unidad</td>
					<td width="8%">Cantidad</td>
					<td width="8%">Precio Compra </td>
					<td width="8%">Precio Venta </td>
					<td width="8%">Total</td>

				</tr>
			</table>
		</fieldset>
		
		<table align="center"class="text" cellSpacing="1" cellPadding="2" width="98%" border="0" id="dataTotal">
				<tr class="titulo_tabla">
					<td width="92%" colspan="5">&nbsp;<b>Total</b></td>
					<td width="8%" align="right"><SPAN id="importeTotal">0</SPAN></td>
					
				</tr>		
		</table>
	</center>	

<br>
<div align="center">
	<input type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
	<input type="reset"  class="boton"  name="btn_limpiar" value="Cancelar Ingreso" onClick="cancelar(this.form);" >
</div>
</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>
