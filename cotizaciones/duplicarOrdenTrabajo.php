<?php
	require("conexion.inc");
	include("funciones.php");
		$cod_gestion=gestionActiva();
	
	$sql2="select gestion_nombre from gestiones where cod_gestion='".$cod_gestion."'";
	$resp2= mysql_query($sql2);
	$gestion="";
	while($dat2=mysql_fetch_array($resp2)){
		$gestion=$dat2[0];
	}
		
	$sql="select max(nro_orden_trabajo) from ordentrabajo where cod_gestion='".$cod_gestion."'";
	$nro_orden_trabajo=obtenerCodigo($sql);
	

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SISTEMA DE GESTION - DUPLICAR OT</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script language='Javascript'>
	function cancelar(){
			//window.location="listOrdenTrabajo.php";
			window.close();
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
function buscarCliente(){
		izquierda = (screen.width) ? (screen.width-600)/2 : 100 
	    arriba = (screen.height) ? (screen.height-400)/2 : 100 
		url="ajax_listClientes.php";
opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=650,left='+izquierda+',top=' + arriba + '' 
	   	window.open(url, 'popUp', opciones);
}
function setClientes(cod_cli, nombreCliente){
	document.getElementById('nombre_cliente').value=nombreCliente;
	document.getElementById('cod_cliente').value=cod_cli;
	
	ajax=nuevoAjax();
	ajax.open("GET","ajaxListaContactos.php?cod_cliente="+document.getElementById('cod_cliente').value,true);	
					
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
function cargar_contacto()
{			
		izquierda = (screen.width) ? (screen.width-600)/2 : 100 
	    arriba = (screen.height) ? (screen.height-400)/2 : 100 
		url="registrarContactoAjax.php?cod_cliente="+document.getElementById("cod_cliente").value;
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
function validaFloat(numero)
{
  if (!/^([0-9])*[.]?[0-9]*$/.test(numero))
   alert("El valor " + numero + " no es un número");
}		

function guardar(f){
	var sw=1;
	if(document.getElementById('fecha_orden_trabajo').value==""){
		alert("Debe Ingresar la Fecha de la Orden de Trabajo");
		return false;
		sw=0;
	}	
	if(document.getElementById('cod_cliente').value==0){
		alert("Seleecion un Cliente");
		return false;
	sw=0;
	}

	if(document.getElementById('monto_orden_trabajo').value==""){
		alert("Ingrese el monto de pago por favor.");
		return false;
		sw=0;
	}else{
		
		if (!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById('monto_orden_trabajo').value)){
	   alert("El Monto de Pago " + numero + " no es un número valido");
	   return false;
	   sw=0;
	}
	}
	if(document.getElementById('detalle_orden_trabajo').value==""){
		alert("Debe describir el trabajo que se esta realizando.");
		return false;
		sw=0;
	}	

   if(sw==1){
	f.submit();
   }
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>
<body bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post"  name="form1" id="form1" action="saveDuplicarOrdenTrabajo.php">

<?php 
	$sql=" select cod_est_ot, ";
	$sql.=" numero_orden_trabajo, fecha_orden_trabajo, cod_cliente, cod_contacto, ";
	$sql.=" detalle_orden_trabajo, obs_orden_trabajo, monto_orden_trabajo, cod_usuario_registro, ";
	$sql.=" fecha_registro, cod_usuario_modifica, fecha_modifica, cod_tipo_pago, cod_estado_pago_doc, ";
	$sql.=" fecha_anulacion, obs_anulacion, cod_usuario_anulacion, incremento_orden_trabajo, ";
	$sql.=" incremento_fecha, incremento_obs, cod_usuario_incremento,  descuento_orden_trabajo, "; 
	$sql.=" descuento_fecha, descuento_obs, cod_usuario_descuento ";
	$sql.=" from ordentrabajo ";
	$sql.=" where cod_orden_trabajo=".$_GET['cod_orden_trabajo'];
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$cod_est_ot=$dat['cod_est_ot']; 
		$numero_orden_trabajo=$dat['numero_orden_trabajo']; 
		$fecha_orden_trabajo=$dat['fecha_orden_trabajo'];
		$codcliente=$dat['cod_cliente'];
		$codcontacto=$dat['cod_contacto'];
		$detalle_orden_trabajo=$dat['detalle_orden_trabajo'];
		$obs_orden_trabajo=$dat['obs_orden_trabajo'];
		$monto_orden_trabajo=$dat['monto_orden_trabajo'];
		$cod_usuario_registro=$dat['cod_usuario_registro'];
		$fecha_registro=$dat['fecha_registro'];
		$cod_usuario_modifica=$dat['cod_usuario_modifica'];
		$fecha_modifica=$dat['fecha_modifica'];
		$cod_tipo_pago=$dat['cod_tipo_pago'];
		$cod_estado_pago_doc=$dat['cod_estado_pago_doc'];
		$fecha_anulacion=$dat['fecha_anulacion'];
		$obs_anulacion=$dat['obs_anulacion'];
		$cod_usuario_anulacion=$dat['cod_usuario_anulacion'];
		$incremento_orden_trabajo=$dat['incremento_orden_trabajo'];
		$incremento_fecha=$dat['incremento_fecha'];
		$incremento_obs=$dat['incremento_obs']; 
		$cod_usuario_incremento=$dat['cod_usuario_incremento'];
		$descuento_orden_trabajo=$dat['descuento_orden_trabajo']; 
		$descuento_fecha=$dat['descuento_fecha'];
		$descuento_obs=$dat['descuento_obs'];
		$cod_usuario_descuento=$dat['cod_usuario_descuento'];
	}	
	$sql2="select nombre_cliente from clientes where cod_cliente='".$codcliente."'";
	$resp2= mysql_query($sql2);
	$nombre_cliente="";
	while($dat2=mysql_fetch_array($resp2)){
		$nombre_cliente=$dat2['nombre_cliente'];
	}	

	
?>
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">REGISTRO DE ORDEN DE TRABAJO</h3>
<p align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">Nro.<?php echo $nro_orden_trabajo."/".$gestion; ?></p>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Introduzca Datos</td>
		 </tr>

		 <tr bgcolor="#FFFFFF">
     		<td>Fecha Orden de Trabajo</td>
      		<td class="textoform">
            <?php
            			list($aOT,$mOT,$dOT)=explode("-",$fecha_orden_trabajo);
			 
			?>
            <input type="text" name="fecha_orden_trabajo" id="fecha_orden_trabajo" class="textoform" value="<?php echo date('d/m/Y');?>">
(dd/mm/aaaa) </td>
    	</tr>        
		 <tr bgcolor="#FFFFFF">
     		<td>Cliente</td>
      		<td>
            <input type="hidden" name="cod_cliente" id="cod_cliente" value="<?php echo $codcliente;?>" >
<input type="text" class="textoform" id="nombre_cliente" name="nombre_cliente" value="<?php echo $nombre_cliente;?>" size="40" readonly>
<a href="javascript:buscarCliente()" accesskey="B">[Buscar Cliente]</strong></a>
<a  href="javascript:cargar_cliente();">[Nuevo Cliente]</a>
<a  href="javascript:datosCliente(this.form);">[Datos Cliente]</a>
            </td>
    	</tr>
<tr bgcolor="#FFFFFF"><td align="left">Contacto</td><td><div id="div_contactoCliente">
	<select name="cod_contacto" id="cod_contacto" class="textoform" >
				<option value="0">------------</option>
				<?php
					$sql2=" select cod_contacto,nombre_contacto, ap_paterno_contacto, ap_materno_contacto  ";
					$sql2.=" from clientes_contactos";
					$sql2.=" where cod_cliente=".$codcliente;
					$sql2.=" order by  ap_paterno_contacto asc, ap_materno_contacto asc , nombre_contacto asc ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_contacto=$dat2['cod_contacto'];
							$nombre_contacto=$dat2['nombre_contacto'];
							$ap_paterno_contacto=$dat2['ap_paterno_contacto'];
							$ap_materno_contacto=$dat2['ap_materno_contacto'];

				 ?>
				 <?php if($cod_contacto==$codcontacto){?>
					 <option value="<?php echo $cod_contacto;?>" selected="selected"><?php echo $ap_paterno_contacto." ".$nombre_contacto;?></option>		
				 <?php }else{?>
 					 <option value="<?php echo $cod_contacto;?>"><?php echo $ap_paterno_contacto." ".$nombre_contacto;?></option>		
				 <?php }?>		
				<?php		
					}
				?>						
			</select>
			<a  href="javascript:cargar_contacto();">[ Nuevo Contacto]</a>
			&nbsp;<a  href="javascript:datosContacto(this.form)"> [Datos Contacto]</a>
</div></td></tr>        
        <tr bgcolor="#FFFFFF">
        <td>Tipo Pago</td>
        <td><select name="cod_tipo_pago" id="cod_tipo_pago" class="textoform" >
				<?php
					$sql4="select cod_tipo_pago,nombre_tipo_pago from tipos_pago order by cod_tipo_pago asc";
					$resp4=mysql_query($sql4);
						while($dat4=mysql_fetch_array($resp4))
						{
							$cod_tipo_pago=$dat4[0];	
			  		 		$nombre_tipo_pago=$dat4[1];	
				 ?>
				 			<option value="<?php echo $cod_tipo_pago;?>" <?php if($cod_tipo_pago==2){?> selected="true" <?php }?>>
							<?php echo $nombre_tipo_pago;?>
							</option>				

										
				<?php		
					}
				?>						
			</select>
            </td>
        </tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Monto</td>
      		<td>
            <input type="text" name="monto_orden_trabajo" id="monto_orden_trabajo" value="<?php echo $monto_orden_trabajo;?>" class="textoform" onKeyUp="validaFloat(this.value)" onChange="validaFloat(this.value)">
</td>
    	</tr>   
		 <tr bgcolor="#FFFFFF">
     		<td>Detalle de Trabajo</td>
      		<td>
      		  <textarea name="detalle_orden_trabajo" id="detalle_orden_trabajo" cols="70" rows="2" class="textoform"><?php echo $detalle_orden_trabajo; ?></textarea>
</td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
      		<td>
      		  <textarea name="obs_orden_trabajo" id="obs_orden_trabajo" cols="70" rows="2" class="textoform"><?php echo $obs_orden_trabajo; ?></textarea></td>
    	</tr>                              
	
										
		</tbody>
	</table>	
	<br>
<div align="center">
<INPUT type="button"  class="boton"  name="btn_atras" value="CANCELAR" onClick="cancelar();"  >
<INPUT type="button" class="boton" name="btn_guardar" value="GUARDAR ORDEN DE TRABAJO" onClick="guardar(this.form);"  >
</div>
</form>

</body>
</html>
