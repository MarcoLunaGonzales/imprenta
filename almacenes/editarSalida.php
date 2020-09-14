<?php header("Cache-Control: no-store, no-cache, must-revalidate");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SISTEMA DE GESTION</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
</head>
<script language='Javascript'>
<?php


	require("conexion.inc");
	include("funciones.php");
	$cod_salida=$_GET['cod_salida'];
	$sql=" select count(*) from salidas_detalle  where cod_salida=".$cod_salida;	
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

		//alert("ajax_tipoSalidaAlmacen.php?cod_tipo_salida="+document.getElementById("cod_tipo_salida").value+"&cod_almacen="+cod_almacen);
		ajax.open("GET","ajax_tipoSalidaAlmacen.php?cod_tipo_salida="+document.getElementById("cod_tipo_salida").value+"&cod_almacen="+cod_almacen,true);	
	//	alert("pasoo");
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
	//	alert("ajax_tituloImporteSalida.php?cod_tipo_salida="+document.getElementById("cod_tipo_salida").value);
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
		//alert("aquii="+f.cod_tipo_salida.value);
		if(f.cod_tipo_salida.value==0){
			alert("Seleccione el tipo de Salida ");
			//f.cod_tipo_salida.focus();
			return false;
		
		}else{
				//alert("aquii="+f.cod_tipo_salida.value);
			if(f.cod_tipo_salida.value==1){					
					if(f.nombre_cliente_venta.value==""){
						alert("El Campo Cliente se encuentra vacio. ");
						f.nombre_cliente_venta.focus();
						return false;
					}
			}
			//alert("hola");
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
						if((cantSalida*1)<=0){
							sw=0;
							alert("Debe sacar cantidades positivas. ");							
							return false;
						}
						if((cantSalida*1)>(stock*1)){
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
		window.location="listSalidas.php?cod_almacen="+f.cod_almacen.value;
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
function listaSubGrupos(f)
{	
		var div_subgrupo,cod_grupo;
		div_subgrupo=document.getElementById("div_subgrupo");			
		cod_grupo=f.cod_grupo.value;	
		ajax=nuevoAjax();

	
		ajax.open("GET","ajax_listaSubGrupos.php?cod_grupo="+cod_grupo,true);				
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
			div_subgrupo.innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null)
		

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
/************************************************/
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
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form    method="post" action="guardaEditarSalida.php" name="form1" id="form1">
<input type="hidden" name="num" id="num">
<input type="hidden" name="cod_salida" id="cod_salida" value="<?php echo $cod_salida;?>">
<?php 	


	$sql=" select cod_tipo_salida, nro_salida, cod_gestion, cod_almacen,fecha_salida, cod_usuario_salida, ";
	$sql.=" obs_salida, cod_almacen_traspaso, cod_hoja_ruta, cliente_venta, cod_estado_salida, fecha_modifica, ";
	$sql.=" cod_usuario_modifica, fecha_anulacion, cod_usuario_anulacion, obs_anulacion, cod_orden_trabajo, ";
	$sql.=" cod_cliente_venta, cod_contacto, cod_tipo_pago ,cod_area, cod_usuario";
	$sql.=" from salidas ";
	$sql.=" where cod_salida=".$cod_salida;
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		
		$codtiposalida=$dat['cod_tipo_salida'];
		$nro_salida=$dat['nro_salida'];
		$cod_gestion=$dat['cod_gestion'];
		//////////Datos de Gestion///////
			$sqlGestion="select gestion from gestiones where cod_gestion=".$cod_gestion;
			$resp2= mysql_query($sqlGestion);
			while($dat2=mysql_fetch_array($resp2)){
					$gestion=$dat2['gestion'];
			}
		////////////////////////////////
		$cod_almacen=$dat['cod_almacen'];
		//////////Datos de Almacen///////
			$sqlAlmacen="select nombre_almacen from almacenes where cod_almacen=".$cod_almacen;
			$resp2= mysql_query($sqlAlmacen);
			while($dat2=mysql_fetch_array($resp2)){
					$nombre_almacen=$dat2['nombre_almacen'];
			}
		////////////////////////////////
		$fecha_salida=$dat['fecha_salida'];
		$cod_usuario_salida=$dat['cod_usuario_salida'];
		$obs_salida=$dat['obs_salida'];
		$codalmacentraspaso=$dat['cod_almacen_traspaso']; 
		$codhojaruta=$dat['cod_hoja_ruta'];
		$cliente_venta=$dat['cliente_venta'];
		$cod_estado_salida=$dat['cod_estado_salida'];
		$fecha_modifica=$dat['fecha_modifica'];
		$cod_usuario_modifica=$dat['cod_usuario_modifica'];
		$fecha_anulacion=$dat['fecha_anulacion'];
		$cod_usuario_anulacion=$dat['cod_usuario_anulacion'];
		$obs_anulacion=$dat['obs_anulacion'];
		$codordentrabajo=$dat['cod_orden_trabajo'];
		$codclienteventa=$dat['cod_cliente_venta'];
		$nombreClienteVenta="";
		if($codclienteventa<>""){
			$sqlCliente="select nombre_cliente from clientes where cod_cliente=".$codclienteventa;
			$resp2= mysql_query($sqlCliente);
			while($dat2=mysql_fetch_array($resp2)){
					$nombreClienteVenta=$dat2['nombre_cliente'];
			}		
		}
		$codcontacto=$dat['cod_contacto'];
		$codtipopago=$dat['cod_tipo_pago'];
		$codarea=$dat['cod_area'];
		$codusuario=$dat['cod_usuario'];
	}	

	

			

?>

<input type="hidden" name="cod_salida" id="cod_salida" value="<?php echo $cod_salida;?>">
<input type="hidden" name="cod_almacen" id="cod_almacen" value="<?php echo $cod_almacen;?>">
<input type="hidden" name="cod_tipo_salida"  id="cod_tipo_salida" value="<?php echo $codtiposalida;?>">

<h3 align="center" style="background:white;font-size: 12px;color:#E78611;font-weight:bold;">Edicion de Salida de Material &nbsp;<?php echo $nombre_almacen; ?> <br>
   No. <?php echo $nro_salida;?>/<?php echo $gestion;?><br><?php echo "Fecha: ".$fecha_salida;?></h3>


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
      		<td colspan="3">
              <?php
					$sql2=" select cod_tipo_salida, nombre_tipo_salida from tipos_salida where cod_tipo_salida=".$codtiposalida;
					$sql2.=" order by  nombre_tipo_salida asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_tipo_salida=$dat2[0];	
			  		 		$nombre_tipo_salida=$dat2[1];
							echo 	$nombre_tipo_salida;
		
					}
				?>
            </td>
    	</tr>
		<tr bgcolor="#FFFFFF">
			<td>
			<strong>
			<div id="div_etiquetaTipoSalidaAlmacen">
            	<?php if($codtiposalida==1){
				//	echo "Cliente:";
				 } 
				 if($codtiposalida==2 or $codtiposalida==4){
					 echo "Hoja de Ruta:";
				  } 
  
				 if($codtiposalida==3){
				   echo "Almacen Traspaso:";
				}
				 if($codtiposalida==5){
				   echo "Orden de Trabajo:";
				}
 ?>
			</div>
			</strong>
			
			</td>
			
			<td colspan="2">
			<div id="div_tipoSalidaAlmacen">
            
<?php if($codtiposalida==1){?>

<table border="0" cellpadding="1" cellspacing="1">
<tr>
	<td align="left"><strong>Tipo de Pago</strong></td>
<td><select name="cod_tipo_pago" id="cod_tipo_pago" class="textoform">
				<?php
					$sql2=" select cod_tipo_pago, nombre_tipo_pago ";
					$sql2.=" from tipos_pago ";
					$sql2.=" where cod_tipo_pago=1 or cod_tipo_pago=2";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_tipo_pago=$dat2['cod_tipo_pago'];	
			  		 		$nombre_tipo_pago=$dat2['nombre_tipo_pago'];	
				 ?>
 
					 <option value="<?php echo $cod_tipo_pago;?>" <?php if($cod_tipo_pago==$codtipopago){?> selected <?php }?>><?php echo $nombre_tipo_pago;?></option>							 
				<?php		
					}
				?>						
			</select>
</td>
</tr>
<tr>
<td><strong>Cliente</strong></td>
<td>
<input type="hidden" name="cod_cliente_venta" id="cod_cliente_venta" value="<?php echo $codclienteventa; ?>" >
<input type="text" class="textoform" id="nombre_cliente_venta" name="nombre_cliente_venta" value="<?php echo $nombreClienteVenta; ?>" size="40" readonly>
<a href="javascript:buscarCliente()" accesskey="B">[Buscar Cliente]</strong></a>
<a  href="javascript:cargar_cliente();">[Nuevo Cliente]</a>
<a  href="javascript:datosCliente(this.form);">[Datos Cliente]</a>
</td>
</tr>
<tr><td align="left"><strong>Contacto</strong></td><td><div id="div_contactoCliente">
<select name="cod_contacto" id="cod_contacto" class="textoform" >
				<option value="0">------------</option>
				<?php
					$sql2="select cod_contacto, nombre_contacto, ap_paterno_contacto, ap_materno_contacto";
					$sql2.=" from clientes_contactos";
					$sql2.=" where cod_cliente=".$codclienteventa;
					$sql2.=" order by  ap_paterno_contacto asc,nombre_contacto asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_contacto=$dat2['cod_contacto'];	
							$nombre_contacto=$dat2['nombre_contacto'];	
							$ap_paterno_contacto=$dat2['ap_paterno_contacto'];	
							$ap_materno_contacto=$dat2['ap_materno_contacto'];	

				 ?>

 					 <option value="<?php echo $cod_contacto;?>" <?php if($cod_contacto==$codcontacto){?> selected<?php }?>><?php echo $ap_paterno_contacto." ".$ap_materno_contacto." ".$nombre_contacto;?></option>		
	
				<?php		
					}
				?>						
			</select>
			<a  href="javascript:cargar_contacto();">[ Nuevo Contacto]</a>
			&nbsp;<a  href="javascript:datosContacto(this.form)"> [Datos Contacto]</a>
</div></td></tr>
</table>




<?php } ?>

<?php if($codtiposalida==2){?>

						<select name="cod_hoja_ruta" id="cod_hoja_ruta" class="textoform" onChange="verHojaRuta(this.form)" >
				<option value="0">Seleccione una opcion</option>	
              <?php
					$sql2=" select hr.cod_hoja_ruta,hr.nro_hoja_ruta,hr.cod_gestion,g.gestion,hr.cod_cotizacion,c.cod_cliente, ";
					$sql2.=" cli.nombre_cliente ";
					$sql2.=" from hojas_rutas hr, cotizaciones c, clientes cli, gestiones g ";
					$sql2.=" where hr.cod_gestion=g.cod_gestion ";
					$sql2.=" and hr.cod_cotizacion=c.cod_cotizacion ";
					$sql2.=" and c.cod_cliente=cli.cod_cliente ";
					$sql2.=" and cod_estado_hoja_ruta=1 ";
					$sql2.=" order by g.gestion desc, hr.nro_hoja_ruta desc ";

					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_hoja_ruta=$dat2[0];
							$nro_hoja_ruta=$dat2[1];	
			  		 		$cod_gestion=$dat2[2];	
							$gestion=$dat2[3];	
							$cod_cotizacion=$dat2[4];	
							$cod_cliente=$dat2[5];
							$nombre_cliente=$dat2[6];	
				 ?>
      		  <option value="<?php echo $cod_hoja_ruta;?>" <?php if($cod_hoja_ruta==$codhojaruta){?> selected="true"<?php }?>><?php echo $nro_hoja_ruta."/".$gestion." (".$nombre_cliente.")";?></option>
              <?php		
					}
				?>
            </select>
	
<?php } ?>
<?php if($codtiposalida==3){?>

			<select name="cod_almacen_traspaso" id="cod_almacen_traspaso" class="textoform" >
				<option value="0">Seleccione una opcion</option>	
              <?php
					$sql2=" select cod_almacen, nombre_almacen ";
					$sql2.=" from almacenes where cod_almacen<>".$cod_almacen;
					$sql2.=" and cod_estado_registro=1";
					$sql2.=" order by  nombre_almacen asc";
					echo $sql2;
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_almacen=$dat2[0];	
			  		 		$nombre_almacen=$dat2[1];	
				 ?>
      		  <option value="<?php echo $cod_almacen;?>" <?php if($cod_almacen==$codalmacentraspaso){?> selected="true"<?php }?>><?php echo $nombre_almacen;?></option>
              <?php		
					}
				?>
            </select>

<?php } ?>
<?php if($codtiposalida==4){?>

				<select name="cod_hoja_ruta" id="cod_hoja_ruta" class="textoform" onChange="verHojaRuta(this.form)" >
				<option value="0">Seleccione una opcion</option>	
              <?php
					$sql2=" select hr.cod_hoja_ruta,hr.nro_hoja_ruta,hr.cod_gestion,g.gestion,hr.cod_cotizacion,c.cod_cliente, ";
					$sql2.=" cli.nombre_cliente ";
					$sql2.=" from hojas_rutas hr, cotizaciones c, clientes cli, gestiones g ";
					$sql2.=" where hr.cod_gestion=g.cod_gestion ";
					$sql2.=" and hr.cod_cotizacion=c.cod_cotizacion ";
					$sql2.=" and c.cod_cliente=cli.cod_cliente ";
					$sql2.=" and cod_estado_hoja_ruta=3 ";
					$sql2.=" order by g.gestion desc, hr.nro_hoja_ruta desc ";

					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_hoja_ruta=$dat2[0];
							$nro_hoja_ruta=$dat2[1];	
			  		 		$cod_gestion=$dat2[2];	
							$gestion=$dat2[3];	
							$cod_cotizacion=$dat2[4];	
							$cod_cliente=$dat2[5];
							$nombre_cliente=$dat2[6];	
				 ?>
      		  <option value="<?php echo $cod_hoja_ruta;?>"  <?php if($cod_hoja_ruta==$codhojaruta){?> selected="true"<?php }?> ><?php echo $nro_hoja_ruta."/".$gestion." (".$nombre_cliente.")";?></option>
              <?php		
					}
				?>
            </select>
	
<?php } ?>

<?php if($codtiposalida==5){?>

				
				<select name="cod_orden_trabajo" id="cod_orden_trabajo" class="textoform"  >
				<option value="0">Seleccione una opcion</option>	
              <?php
					$sql2=" select ot.cod_orden_trabajo, ot.numero_orden_trabajo, ot.fecha_orden_trabajo, ";
					$sql2.=" ot.cod_cliente,c.nombre_cliente, ot.obs_orden_trabajo, ot.monto_orden_trabajo, ";
					$sql2.=" ot.nro_orden_trabajo, ot.cod_gestion  ";
					$sql2.=" from ordentrabajo	ot, clientes c ";
					$sql2.=" where ot.cod_cliente=c.cod_cliente ";
					$sql2.=" order by ot.fecha_orden_trabajo desc, ot.nro_orden_trabajo desc ";

					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_orden_trabajo=$dat2['cod_orden_trabajo'];
							$numero_orden_trabajo=$dat2['numero_orden_trabajo'];	
			  		 		$fecha_orden_trabajo=$dat2['fecha_orden_trabajo'];	
							$cod_cliente=$dat2['cod_cliente'];	
							$nombre_cliente=$dat2['nombre_cliente'];	
							$cod_cliente=$dat2['cod_cliente'];
							$obs_orden_trabajo=$dat2['obs_orden_trabajo'];
							$monto_orden_trabajo=$dat2['monto_orden_trabajo'];	
							$nro_orden_trabajo=$dat2['nro_orden_trabajo'];
							$cod_gestion_ot=$dat2['cod_gestion'];
							$gestion_ot="";
							$sql3=" select gestion from gestiones where  cod_gestion=".$cod_gestion_ot;
							$resp3=mysql_query($sql3);
							while($dat3=mysql_fetch_array($resp3))
							{
								$gestion_ot=$dat3['gestion'];	
			  		 		}							
				 ?>
      		  <option value="<?php echo $cod_orden_trabajo;?>"  <?php if($cod_orden_trabajo==$codordentrabajo){?> selected="true"<?php }?>><?php echo $nro_orden_trabajo."/".$gestion_ot." ( Nro Int.".$numero_orden_trabajo." ".$nombre_cliente.")";?></option>
              <?php		
					}
				?>
            </select>
	
<?php } ?>  
<?php if($codtiposalida==6){?>
<table border="0" cellpadding="1" cellspacing="1">
<tr>
	<td align="left"><strong>Area</strong></td>
	<td><select name="cod_area" id="area" class="textoform">
				<?php
					$sql2=" select cod_area, nombre_area ";
					$sql2.=" from areas ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_area=$dat2['cod_area'];	
			  		 		$nombre_area=$dat2['nombre_area'];	
				 ?>
			 <option value="<?php echo $cod_area;?>" <?php if($cod_area==$codarea){?> selected="true" <?php }?>><?php echo $nombre_area;?></option>							 
				<?php		
					}
				?>						
			</select>
	</td>
</tr>
<tr>
<td><strong>Usuario</strong></td>
<td>
<select name="cod_usuario" id="cod_usuario" class="textoform">
				<?php
					$sql2=" select cod_usuario, nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
					$sql2.=" from usuarios ";
					$sql2.=" order by ap_paterno_usuario asc, ap_materno_usuario asc, nombres_usuario asc ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_usuario=$dat2['cod_usuario'];	
							$nombres_usuario=$dat2['nombres_usuario'];	
			  		 		$ap_paterno_usuario=$dat2['ap_paterno_usuario'];
							$ap_materno_usuario=$dat2['ap_materno_usuario'];	
				 ?>

					 <option value="<?php echo $cod_usuario;?>" <?php if($cod_usuario==$codusuario){?> selected="true" <?php }?>><?php echo $ap_paterno_usuario." ".$ap_materno_usuario." ".$nombres_usuario;?></option>							 
				<?php		
					}
				?>						
			</select>
</td>
</tr>

</table>
<?php } ?>          
			</div>
			</td>
			<td >
			<div id="div_detalleHojaRuta">
            <?php if($codtiposalida==4 or $codtiposalida==2){?>
            <a href="../reportes/impresionHojaRuta.php?cod_hoja_ruta=<?php echo $codhojaruta; ?>" target="_blank">
            Ver Hoja de Ruta</a> 
            <?php }?>
            <?php if($codtiposalida==5){?>
            <a href="../reportes/impresionHojaRuta.php?cod_hoja_ruta=<?php echo $codhojaruta; ?>" target="_blank">
             Ver Orden de Trabajo</a> 
            <?php }?>            
			</div>
			</td>
		</tr>		
				<tr bgcolor="#FFFFFF">
			<td><strong>Observaci&oacute;n</strong></td>
			<td colspan="3"><textarea cols="70" rows="1" name="obs_salida" id="obs_salida"  class="textoform"><?php echo $obs_salida; ?></textarea></td>
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
					<td width="11%"><div id="div_tituloPrecioVenta">
                    <?php  if($codtiposalida==1){
							echo "Precio de Venta";
						  }
					?>
                    </div></td>
					<td width="9%"><div id="div_tituloImporteSalida">
                    <?php  if($codtiposalida==1){
							echo "Importe";
						  }
					?>                    
                    </div></td>
					<td width="7%">&nbsp;</td>
				</tr>
			</table>
				<?php
					$sql=" select cod_material, cant_salida, precio_venta ";
					$sql.=" from salidas_detalle ";
					$sql.=" where cod_salida=".$cod_salida;
					
					$resp= mysql_query($sql);
					$cont=0;
					$sumaTotal=0;
					while($dat=mysql_fetch_array($resp)){	
					
						$cont=$cont+1;
						$codmaterial=$dat['cod_material'];
						$cant_salida=$dat['cant_salida'];
						$precioventa=$dat['precio_venta'];

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
				<table border="0" align="center" cellSpacing="1" cellPadding="1" width="100%"  style="border:#ccc 1px solid;" id="data<?php echo $cont?>" >
<tr bgcolor="#FFFFFF">
<td width="57%" align="left">
                <a href="javascript:buscarMaterial(<?php echo $cont;?>)" accesskey="B">Buscar</a>
<input type="hidden" name="cod_material<?php echo $cont;?>" id="cod_material<?php echo $cont;?>" value="<?php echo $codmaterial; ?>">
<input type="text" class="textoform" id="desc_material<?php echo $cont;?>" name="desc_material<?php echo $cont;?>" size="70" value="<?php echo $desc_completa_material;?>" readonly>
</td>
<td align="center" width="3%">
<div id="div_unidad<?php echo $cont;?>"><?php echo $abrev_unidad_medida; ?></div>
</td>
<td align="center" width="5%">
<div id="div_cantActual<?php echo $cont;?>">
<?php
	
		$cantActualMaterial_1=0;		
		$cantActualMaterial_2=0;		
		$swError=0;

		$sql2=" select count(*)  from ingresos_detalle where cod_material=".$codmaterial."";
		$sql2.=" and cod_ingreso in(select cod_ingreso from ingresos where cod_almacen=".$cod_almacen." and cod_estado_ingreso=1)";
		$resp2= mysql_query($sql2);
		$num_reg_ing_material=0;
		while($dat2=mysql_fetch_array($resp2)){
				$num_reg_ing_material=$dat2[0]; 									
		}		
		
		$sql2=" select count(*) from salidas_detalle where cod_material=".$codmaterial."";
		$sql2.=" and cod_salida in(select cod_salida from salidas where cod_almacen=".$cod_almacen." and cod_estado_salida=1)";
		$resp2= mysql_query($sql2);
		$num_reg_sal_material=0;
		while($dat2=mysql_fetch_array($resp2)){
				$num_reg_sal_material=$dat2[0]; 									
		}	
		
		if($num_reg_ing_material==0){			
				if($num_reg_sal_material==0){
					$cantActualMaterial_1=0;
					$cantActualMaterial_2=0;
					
				}else{
					$cantActualMaterial_1=0;
					$cantActualMaterial_2=0;
					$swError=1; // No existe Ingreso pero si salidas
				}		
		}else{

				
				$sql2="  select sum(cant_actual) from ingresos_detalle where cod_material=".$codmaterial."";
				$sql2.=" and cod_ingreso in(select cod_ingreso from ingresos ";
				$sql2.=" where cod_almacen=".$cod_almacen." and cod_estado_ingreso=1)";
				$resp2= mysql_query($sql2);
				$cantActualMaterial_1=0;
				while($dat2=mysql_fetch_array($resp2)){
						$cantActualMaterial_1=$dat2[0]; 									
				}

				$sql2=" select sum(cantidad) from ingresos_detalle where cod_material=".$codmaterial."";
				$sql2.=" and cod_ingreso in(select cod_ingreso from ingresos ";
				$sql2.=" where cod_almacen=".$cod_almacen." and cod_estado_ingreso=1)";
				$resp2= mysql_query($sql2);
				$sum_cant_ing_mat=0;
				while($dat2=mysql_fetch_array($resp2)){
						$sum_cant_ing_mat=$dat2[0]; 									
				}
				
				
				if($num_reg_sal_material>0){
					////////////////
						$sql2=" select sum(cant_salida) from salidas_detalle where cod_material=".$codmaterial."";
						$sql2.=" and cod_salida in(select cod_salida from salidas ";
						$sql2.=" where cod_almacen=".$cod_almacen." and cod_estado_salida=1)";
						$resp2= mysql_query($sql2);
						$sum_reg_sal_material=0;
						while($dat2=mysql_fetch_array($resp2)){
							$sum_reg_sal_material=$dat2[0]; 									
						}
					///////////////
					
						$cantActualMaterial_2=$sum_cant_ing_mat-$sum_reg_sal_material;
					
				}else{
					$cantActualMaterial_2=$sum_cant_ing_mat;
				}					
		}
		
		if($cantActualMaterial_1==$cantActualMaterial_2){
			$swError=0;//no existe error

		}else{
			$swError=2;//no existe error
		}
		echo ($cantActualMaterial_2+$cant_salida);

?>

</div>
</td>
<td align="center" width="8%">
<input type="text" class="textoform"  name="cantidad<?php echo $cont;?>" id="cantidad<?php echo $cont;?>" 
value="<?php echo $cant_salida;?>" onKeyUp="importe('<?php echo $cont;?>')" size="6">
</td>

<td align="center"  width="11%" >
<div id="div_precioVenta<?php echo $cont;?>" align="right">
<?php 

		$sql2=" select precio_venta  from materiales where cod_material=".$codmaterial."";
		$resp2= mysql_query($sql2);
		$precio_venta=0;
		while($dat2=mysql_fetch_array($resp2)){
				$precio_venta=$dat2[0]; 									
		}	
?>
<?php  if($codtiposalida==1){?>

<input type="hidden" class="textoform"name="precioVentaDef<?php echo $cont;?>" id="precioVentaDef<?php echo $cont;?>" value="<?php echo $precio_venta;?>" >
<?php echo $precio_venta;?>&nbsp;
<input type="text" class="textoform"name="precioVenta<?php echo $cont;?>" id="precioVenta<?php echo $cont;?>" value="<?php echo $precioventa;?>"  size="6" onKeyUp="importe('<?php echo $cont;?>')">

<?php  }?>

</div>
</td>
<td align="right"  width="9%" >
<div id="div_importe<?php echo $cont;?>" align="right">
<?php  if($codtiposalida==1){
	$sumaTotal=$sumaTotal+($cant_salida*$precioventa);

?>
<input type="text" class="textoform"name="importe<?php echo $cont;?>" id="importe<?php echo $cont;?>" value="<?php echo ($cant_salida*$precioventa);?>"  size="8"  align="right">

<?php  }?>
</div>
</td>
<td align="right"  width="7%" ><input class="boton" type="button" value="Delete" onclick="menos(<?php echo $cont;?>)" /></td>
</tr>
</table>				
			</div>
				<?php		
					}				
					
				?>			

            
		</fieldset>


		<div id="div_TotalVentaSalida">

<?php  if($codtiposalida==1){?>
<table align="center"class="text" cellSpacing="1" cellPadding="2" width="98%" border="0" id="dataTotal">
	<tr class="titulo_tabla">
	<td width="90%" colspan="5">&nbsp;<b>Total</b></td>
	<td width="10%" align="right"><SPAN id="importeTotal"><?php echo $sumaTotal;?></SPAN></td>
	<td width="10%" align="right">&nbsp;</td>		
	</tr>
</table>	
<?php  }?>
		</div>
	</center>	

<br>
<div align="center">
	<input type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
	<input type="reset"  class="boton"  name="btn_limpiar" value="Cancelar" onClick="cancelar(this.form);" >
</div>
<input type='hidden' name='materialActivo' value="0">
</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>
