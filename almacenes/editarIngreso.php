<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Edicion de Ingreso </title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
<?php

	require("conexion.inc");
	include("funciones.php");
	$cod_ingreso=$_GET['cod_ingreso'];
	
				$sql=" select count(*) from ingresos_detalle  where cod_ingreso=".$cod_ingreso;	
				$num_materiales=0;
				$resp= mysql_query($sql);				
				while($dat=mysql_fetch_array($resp)){	
					$num_materiales=$dat[0];
				}
?>
	num=<?php echo $num_materiales;?>;
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
	
	function menos(numero) {

		 fi = document.getElementById('fiel');
  		 fi.removeChild(document.getElementById('div'+numero));
 		 calcularTotal();
	}
	
function calcularTotal(){
//	alert('holaaaa calcular');
	var importeTotal=document.getElementById('importeTotal');
//	alert('holaaaa calcular2');
	var sumImporteParcial=0;
//	alert('holaaaa calcular3');
	var i=1;
	for(i=1;i<=num;i++){
	//	alert('for'+i);
		if(document.getElementById('importe'+i)){
			var importeParcial=document.getElementById('importe'+i).value;
			sumImporteParcial=parseFloat(sumImporteParcial)+parseFloat(importeParcial);
		}
	}	
//	alert('holaaaa calcularultimo'+sumImporteParcial);
	importeTotal.innerHTML=Math.round(sumImporteParcial*100)/100;
}
function importe(fila){
	//	alert('holaaaa');
		var cantidad=document.getElementById('cantidad'+fila).value;

var precioCompra=document.getElementById('precioCompra'+fila).value;
		var importe=document.getElementById('importe'+fila);
	//	alert('holaaaa5');
		importe.value=(parseFloat(cantidad)*parseFloat(precioCompra));
	//	alert('holaaaa6');
		importe.value=Math.round(importe.value*100)/100;
	//	alert('holaaaa7');

	if(importe.value=="NaN"){
		importe.value=0;
	}

		calcularTotal();

}


	
	function guardar(f)
	{	
		if(f.cod_tipo_ingreso.value==1){
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
			
function cancelar(f)
{	
	window.location="listIngresos.php?cod_almacen="+f.cod_almacen.value;
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
<body onLoad="calcularTotal();">
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="guardaEditarIngreso.php" name="form1" id="form1" >
<input type="hidden" name="num" >
<input name="cod_ingreso" type="hidden" value="<?php echo $cod_ingreso;?>">
<?php 	


	
	
	$sql=" select cod_ingreso, cod_gestion,cod_almacen,nro_ingreso,cod_tipo_ingreso,fecha_ingreso,cod_usuario_ingreso, ";
	$sql.=" cod_proveedor, cod_contacto_proveedor, cod_salida, nro_factura, fecha_factura, obs_ingreso, cod_estado_ingreso, total_bs,";
	$sql.=" cod_tipo_pago, cod_estado_pago_doc,dias_plazo_pago,fecha_modifica, cod_usuario_modifica, obs_anular ";
	$sql.=" from ingresos ";
	$sql.=" where  cod_ingreso=".$_GET['cod_ingreso'];
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
	
		$cod_ingreso=$dat['cod_ingreso'];
		$cod_gestion=$dat['cod_gestion'];
		$cod_almacen=$dat['cod_almacen'];
		$nro_ingreso=$dat['nro_ingreso'];
		$cod_tipo_ingreso=$dat['cod_tipo_ingreso'];
		$fecha_ingreso=$dat['fecha_ingreso'];
		$cod_usuario_ingreso=$dat['cod_usuario_ingreso'];
		$codproveedor=$dat['cod_proveedor'];
		$codcontactoproveedor=$dat['cod_contacto_proveedor'];
		$cod_salida=$dat['cod_salida'];
		$nro_factura=$dat['nro_factura'];
		$fecha_factura=$dat['fecha_factura'];
		$obs_ingreso=$dat['obs_ingreso'];
		$cod_estado_ingreso=$dat['cod_estado_ingreso'];
		$total_bs=$dat['total_bs'];
		$codtipopago=$dat['cod_tipo_pago'];
		$cod_estado_pago_doc=$dat['cod_estado_pago_doc'];
		$dias_plazo_pago=$dat['dias_plazo_pago'];
		$fecha_modifica=$dat['fecha_modifica'];
		$cod_usuario_modifica=$dat['cod_usuario_modifica'];
		$obs_anular=$dat['obs_anular'];

		//echo "holaaaaaaaaaaaa".$codproveedor;
	
				////////////////GESTION////////////////////
					$sql2="select gestion_nombre from gestiones where cod_gestion='".$cod_gestion."'";
					$resp2= mysql_query($sql2);
					$gestion="";
					while($dat2=mysql_fetch_array($resp2)){
						$gestion_nombre=$dat2[0];
					}
					
					$nombre_proveedor="";
					if($codproveedor<>"" and $codproveedor<>0){
						$sql2="select nombre_proveedor from proveedores where cod_proveedor='".$codproveedor."'";
						$resp2= mysql_query($sql2);			
						while($dat2=mysql_fetch_array($resp2)){
							$nombre_proveedor=$dat2[0];
						}
					}
					
				//******************************AlMACEN ********************************
				if($cod_tipo_ingreso==2){
					$nombre_almacen="";
					$sql2="select nombre_almacen from almacenes where cod_almacen_ingreso='".$cod_almacen."'";
					$resp2= mysql_query($sql2);			
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_almacen=$dat2[0];
					}
				}
				

				
				$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios ";
				$sql2.=" where cod_usuario='".$cod_usuario_ingreso."'";
				$resp2= mysql_query($sql2);
				$nombres_usuario="";
				$ap_paterno_usuario="";
				$ap_materno_usuario="";		
				while($dat2=mysql_fetch_array($resp2)){	
					$nombres_usuario=$dat2[0];
					$ap_paterno_usuario=$dat2[1];
					$ap_materno_usuario=$dat2[2];		
				}					
			//******************************TIPO DE INGRESO********************************
				$nombre_tipo_ingreso="";
				$sql2="select nombre_tipo_ingreso from tipos_ingreso where cod_tipo_ingreso='".$cod_tipo_ingreso."'";
				$resp2= mysql_query($sql2);			
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_tipo_ingreso=$dat2[0];
				}

				
				//******************************ESTADO********************************
				$desc_estado_ingreso="";
				$sql2=" select desc_estado_ingreso from estados_ingresos_almacen ";
				$sql2.=" where cod_estado_ingreso='".$cod_estado_ingreso."'";
				$resp2= mysql_query($sql2);			
				while($dat2=mysql_fetch_array($resp2)){
					$desc_estado_ingreso=$dat2[0];
				}		
	}		

?>
<input type="hidden" name="cod_tipo_ingreso" value="<?php echo $cod_tipo_ingreso;?>">
<input type="hidden" name="cod_almacen" value="<?php echo $cod_almacen;?>">
<h3 align="center" style="background:white;font-size: 12px;color:#E78611;font-weight:bold;">Edici&oacute;n de Ingreso <br>
   No. <?php echo $nro_ingreso;?>/<?php echo $gestion_nombre;?><br><?php echo "Fecha: ".$fecha_ingreso;?></h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0">
	<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="4" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td><strong>Tipo de Ingreso</strong></td>
      		<td colspan="3"><?php echo $nombre_tipo_ingreso; ?></td>
    	</tr>
<?php
	if($cod_tipo_ingreso==1){
?>
 <tr bgcolor="#FFFFFF">
     		<td><strong>Proveedor</strong></td>
      		<td colspan="3">
            <input type="hidden" name="cod_proveedor" id="cod_proveedor" value="<?php echo $codproveedor;?>" >
<input type="text" class="textoform" id="nombre_proveedor" name="nombre_proveedor" value="<?php echo $nombre_proveedor;?>" size="40" disabled="disabled">
<a href="javascript:buscarProveedor()" accesskey="B">[Buscar Proveedor]</strong></a>
<a  href="javascript:cargar_proveedor();">[Nuevo Proveedor]</a>
<a  href="javascript:datosProveedor(this.form);">[Datos Proveedor]</a>

            </td>
    	</tr>	
        <tr bgcolor="#FFFFFF">
                <th align="left">Contacto</th><td colspan="3"><div id="div_contactoProveedor"><select name="cod_contacto_proveedor" id="cod_contacto_proveedor" class="textoform" >
				<option value="0">Seleccione un Registro</option>
				<?php
					$sql2=" select cod_contacto_proveedor,nombre_contacto, ap_paterno_contacto, ap_materno_contacto  ";
					$sql2.=" from proveedores_contactos";
					$sql2.=" where cod_proveedor=".$codproveedor;
					$sql2.=" order by  ap_paterno_contacto asc, ap_materno_contacto asc , nombre_contacto asc ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_contacto_proveedor=$dat2['cod_contacto_proveedor'];
							$nombre_contacto=$dat2['nombre_contacto'];
							$ap_paterno_contacto=$dat2['ap_paterno_contacto'];
							$ap_materno_contacto=$dat2['ap_materno_contacto'];

				 ?>
				 <?php if($cod_contacto_proveedor==$codcontactoproveedor){?>
					 <option value="<?php echo $cod_contacto_proveedor;?>" selected="selected"><?php echo $ap_paterno_contacto." ".$nombre_contacto;?></option>		
				 <?php }else{?>
 					 <option value="<?php echo $cod_contacto_proveedor;?>"><?php echo $ap_paterno_contacto." ".$nombre_contacto;?></option>		
				 <?php }?>		
				<?php		
					}
				?>						
			</select>
			<a  href="javascript:cargar_contactoProveedor();">[ Nuevo Contacto]</a>
			&nbsp;<a  href="javascript:datosContactoProveedor(this.form)"> [Datos Contacto]</a>
</div></th>
        </tr> 
		 
		<tr bgcolor="#FFFFFF">
     		<td><strong>Nro Factura</strong></td>
      		<td><input type="text"  class="textoform" size="15" name="nro_factura"  value="<?php echo $nro_factura;?>"><strong>Fecha Factura</strong><input type="text"  class="textoform" size="15" name="fecha_factura"  value="<?php if($fecha_factura!=NULL && $fecha_factura!="" ){echo strftime("%d/%m/%Y",strtotime($fecha_factura));}?>"></td>
			<td ><strong>Tipo de Pago </strong></td>
			<td ><select name="cod_tipo_pago" id="cod_tipo_pago" class="textoform" >
			
				<?php
					$sql4="select cod_tipo_pago,nombre_tipo_pago from tipos_pago";
					$resp4=mysql_query($sql4);
						while($dat4=mysql_fetch_array($resp4))
						{
							$cod_tipo_pago=$dat4[0];	
			  		 		$nombre_tipo_pago=$dat4[1];	
				 ?><option value="<?php echo $cod_tipo_pago;?>" <?php if($codtipopago==$cod_tipo_pago){?>selected<?php }?>><?php echo $nombre_tipo_pago;?></option>				
				<?php		
					}
				?>						
			</select></td>		
    	</tr>
 		<tr bgcolor="#FFFFFF">
     		<td><strong>Dias Plazo</strong></td>
      		<td><input type="text"  class="textoform" size="10" name="dias_plazo_pago" id="dias_plazo_pago"  value="<?php echo $dias_plazo_pago;?>"></td>
			<td><strong>Total Bs.</strong></td>
      		<td><input type="text"  class="textoform" size="10" name="total_bs" id="total_bs" value="<?php echo $total_bs;?>" ></td>
    	</tr>			
<?php	
	}
?>				
<?php
	if($cod_tipo_ingreso==2){
		$sql=" select nro_salida, cod_gestion, cod_almacen, fecha_salida, ";
		$sql.=" cod_usuario_salida, obs_salida ";
		$sql.=" from salidas ";
		$sql.=" where cod_salida=".$cod_salida;
		//echo $sql;
		$resp= mysql_query($sql);			
		while($dat=mysql_fetch_array($resp)){
			$nro_salida=$dat[0];
			$cod_gestion_salida=$dat[1];
			$sql2="select gestion_nombre from gestiones where cod_gestion='".$cod_gestion_salida."'";
			$resp2= mysql_query($sql2);
			$gestion_salida="";
			while($dat2=mysql_fetch_array($resp2)){
				$gestion_salida=$dat2[0];
			}
			$cod_almacen_salida=$dat[2];
			$nombre_almacen_salida="";
			$sql2="select nombre_almacen from almacenes where cod_almacen='".$cod_almacen_salida."'";
			$resp2= mysql_query($sql2);			
			while($dat2=mysql_fetch_array($resp2)){
				$nombre_almacen_salida=$dat2[0];
			}						
							
			$fecha_salida=$dat[3];
			$cod_usuario_salida=$dat[4];
			
			$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios ";
			$sql2.=" where cod_usuario='".$cod_usuario_salida."'";
			$resp2= mysql_query($sql2);
			$nombres_usuario_salida="";
			$ap_paterno_usuario_salida="";
			$ap_materno_usuario_salida="";		
			while($dat2=mysql_fetch_array($resp2)){	
				$nombres_usuario_salida=$dat2[0];
				$ap_paterno_usuario_salida=$dat2[1];
				$ap_materno_usuario_salida=$dat2[2];		
			}
			$obs_salida=$dat[5];
			
		}			
	
?>
		 <tr bgcolor="#FFFFFF">
     		<td><strong>Almacen de Salida</strong></td>
      		<td><?php echo $nombre_almacen_salida;?></td>
     		<td><strong>Nro Salida</strong></td>
      		<td><?php echo $nro_salida."/".$gestion_salida;?></td>			
    	</tr>
		<tr bgcolor="#FFFFFF">
     		<td><strong>Fecha Salida</strong></td>
      		<td><?php echo "Fecha: ".$fecha_salida;?></td>
			 <td><strong>Responsable de  Salida</strong></td>
      		<td><?php echo $nombres_usuario_salida." ".$ap_paterno_usuario_salida;?></td>
    	</tr>
		<tr bgcolor="#FFFFFF">
     		<td><strong>Obs Salida</strong></td>
      		<td  colspan="3"><?php echo $obs_salida;?></td>
    	</tr>				
<?php	
	}
?>			 

		
	
		<tr bgcolor="#FFFFFF">
			<td><strong>Observaci&oacute;n</strong></td>
			<td colspan="3">
			<textarea cols="70" rows="1" name="obs_ingreso" id="obs_ingreso"  class="textoform" ><?php echo $obs_ingreso;?></textarea>
			</td>
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
				<?php
					$sql=" select cod_ingreso_detalle, cod_material, precio_compra_uni, cantidad ";
					$sql.=" from ingresos_detalle ";
					$sql.=" where cod_ingreso=".$cod_ingreso;	
					$sql.=" order by cod_ingreso_detalle asc";	
					
					$resp= mysql_query($sql);
					$cont=0;
					while($dat=mysql_fetch_array($resp)){	
					
						$cont=$cont+1;
						$cod_ingreso_detalle=$dat[0];
						$codmaterial=$dat[1];
						$precio_compra_uni=$dat[2];
						$cantidad=$dat[3];	
						
						$sql2=" select m.desc_completa_material, m.precio_venta,  um.abrev_unidad_medida ";
						$sql2.=" from materiales m, unidades_medidas um ";
						$sql2.=" where m.cod_unidad_medida=um.cod_unidad_medida ";
						$sql2.=" and m.cod_material=".$codmaterial;
						$resp2= mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2)){
							$desc_completa_material=$dat2['desc_completa_material'];
							$precio_venta=$dat2['precio_venta'];
							$abrev_unidad_medida=$dat2['abrev_unidad_medida'];
						
						}
												
						
				?>	
				<div id="div<?php echo $cont;?>">	
                
				<table border="0"  cellSpacing="1" cellPadding="1" width="100%"  style="border:#ccc 1px solid;" id="data<?php echo $cont?>" >
				<tr bgcolor="#FFFFFF" align="left">
				<td width="55%" align="left">
                <a href="javascript:buscarMaterial(<?php echo $cont;?>)" accesskey="B">Buscar</a>
                <input type="hidden" name="cod_material<?php echo $cont;?>" id="cod_material<?php echo $cont;?>" value="<?php echo $codmaterial; ?>">
<input type="text" class="textoform" id="desc_material<?php echo $cont;?>" name="desc_material<?php echo $cont;?>" size="70" value="<?php echo $desc_completa_material;?>" readonly>

              
              </td>
			<td align="left" width="5%">
				<div id="div_unidad<?php echo $cont;?>" align="left"><?php echo $abrev_unidad_medida; ?></div></td>
			<td align="left" width="8%">
			<input type="text" class="textoform" value="<?php echo $cantidad;?>"  id="cantidad<?php echo $cont;?>" name="cantidad<?php echo $cont;?>" size="5" onKeyUp="importe('<?php echo $cont;?>')" >			</td>
			<td align="left" width="8%"><input type="text" class="textoform" value="<?php echo $precio_compra_uni;?>" id="precioCompra<?php echo $cont;?>" name="precioCompra<?php echo $cont;?>" onKeyUp="importe('<?php echo $cont;?>')" size="5" ></td>
			<td align="left" width="8%">
			<div id="div_precioVenta<?php echo $cont;?>" align="left">
			<input type="text" class="textoform"  name="precioVenta<?php echo $cont;?>" id="precioVenta<?php echo $cont;?>" value="<?php echo $precio_venta; ?>" size="5">
			</div>			
			</td>
			<td align="left"  width="8%" >
			<input type="text" class="textoform" value="<?php echo $precio_compra_uni*$cantidad; ?>" name="importe<?php echo $cont;?>" id="importe<?php echo $cont;?>"   size="8" readonly="true">			</td>
			<td align="left"  width="8%" >
			<input class="boton" type="button" value="Remover" onclick="menos(<?php echo $cont;?>)" />			</td>
		</tr>
		</table>
</div>
				<?php		
					}				
					
				?>			


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
	<input type="reset"  class="boton"  name="btn_limpiar" value="Cancelar Edicion" onClick="cancelar(this.form);" >
	<input type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >	
</div>
<input type='hidden' name='materialActivo' value="0">
</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>
