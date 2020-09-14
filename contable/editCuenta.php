<?php
	require("conexion.inc");
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
 function Solo_Numerico(variable){
        Numer=parseInt(variable);
        if (isNaN(Numer)){
            return "";
        }
        return Numer;
    }
function validaEntero(Control){
        Control.value=Solo_Numerico(Control.value);
		
		var div_cuenta_existente;
		div_cuenta_existente=document.getElementById("div_cuenta_existente");

		ajax=nuevoAjax();
		ajax.open("GET","ajax_revisiondeNroCtaExistente.php?nro_cuenta="+document.getElementById("nro_cuenta").value,true);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4) {
			div_cuenta_existente.innerHTML=ajax.responseText;
			}
		}
		ajax.send(null);

}
function verificarCuentaDesc(){
		
		var div_cuenta_existente_desc;
		div_cuenta_existente_desc=document.getElementById("div_cuenta_existente_desc");

		ajax=nuevoAjax();
		ajax.open("GET","ajax_revisiondeNroCtaExistenteDesc.php?desc_cuenta="+document.getElementById("desc_cuenta").value,true);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4) {
				div_cuenta_existente_desc.innerHTML=ajax.responseText;
			}
		}
		ajax.send(null);
		
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
function buscarCuentaPadre(cod_cuenta){
		izquierda = (screen.width) ? (screen.width-600)/2 : 100 
	    arriba = (screen.height) ? (screen.height-400)/2 : 100 
		url="ajax_listCuentas.php?cuenta="+cod_cuenta;
opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=650,left='+izquierda+',top=' + arriba + '' 
	   	window.open(url, 'popUp', opciones);
}
function setCuentas(cod_cuenta, cuenta, nro_nuevo){
	document.getElementById('desc_cuenta_padre').value=cuenta;
	document.getElementById('cod_cuenta_padre').value=cod_cuenta;
	document.getElementById('nro_cuenta').value=nro_nuevo;
	}

function eliminarCuentaPadre(){
	//alert("hola");
	document.getElementById('cod_cuenta_padre').value=null;
	document.getElementById('desc_cuenta_padre').value="";	
}
function buscarCliente(){
		izquierda = (screen.width) ? (screen.width-600)/2 : 100 
	    arriba = (screen.height) ? (screen.height-400)/2 : 100 
		url="ajax_listClientes.php";
opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=650,left='+izquierda+',top=' + arriba + '' 
	   	window.open(url, 'popUp', opciones);
}
function setCliente(cod_cliente, cliente){
	document.getElementById('nombre_cliente').value=cliente;
	document.getElementById('desc_cuenta').value=cliente;
	document.getElementById('cod_cliente').value=cod_cliente;
	
		
	}
function eliminarCliente(){
	document.getElementById('cod_cliente').value=null;
	document.getElementById('nombre_cliente').value="";	
}	
function buscarProveedor(){
		izquierda = (screen.width) ? (screen.width-600)/2 : 100 
	    arriba = (screen.height) ? (screen.height-400)/2 : 100 
		url="ajax_listProveedores.php";
opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=650,left='+izquierda+',top=' + arriba + '' 
	   	window.open(url, 'popUp', opciones);
}
function setProveedor(cod_proveedor, proveedor){
	document.getElementById('nombre_proveedor').value=proveedor;
	document.getElementById('desc_cuenta').value=proveedor;
	document.getElementById('cod_proveedor').value=cod_proveedor;			
}

function eliminarProveedor(){
	document.getElementById('cod_proveedor').value=null;
	document.getElementById('nombre_proveedor').value="";	
}	

function guardar(f){
	if(document.getElementById('nro_cuenta').value==""){
		alert("Introducir en Nro de Cuenta.");
		document.getElementById('nro_cuenta').focus();
		return(0);
	}
	if(document.getElementById('desc_cuenta').value==""){
		alert("Introducir la Cuenta.");
		document.getElementById('desc_cuenta').focus();
		return(0);
	}	

	f.submit();	
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>
<body >
<?php
	$sql=" select  nro_cuenta, desc_cuenta, detalle_cuenta, cod_moneda, ";
	$sql.=" cod_cuenta_padre, cod_estado_registro, cod_usuario_registro, fecha_registro, ";
	$sql.=" cod_usuario_modifica, fecha_modifica ";
	$sql.=" from cuentas ";
	$sql.=" where cod_cuenta=".$_GET['cod_cuenta']." ";
$resp = mysql_query($sql);	
while($dat=mysql_fetch_array($resp)){

		$nro_cuenta=$dat['nro_cuenta'];
		$desc_cuenta=$dat['desc_cuenta'];
		$detalle_cuenta=$dat['detalle_cuenta'];
		$codmoneda=$dat['cod_moneda'];
		$cod_cuenta_padre=$dat['cod_cuenta_padre'];
		$codestadoregistro=$dat['cod_estado_registro'];
		$cod_usuario_registro=$dat['cod_usuario_registro'];
		$fecha_registro=$dat['fecha_registro'];
		$cod_usuario_modifica=$dat['cod_usuario_modifica'];
		$fecha_modifica=$dat['fecha_modifica'];
}

if($cod_cuenta_padre!= NULL){
		$sql=" select  nro_cuenta, desc_cuenta ";
		$sql.=" from cuentas ";
		$sql.=" where cod_cuenta=".$cod_cuenta_padre." ";
		$resp = mysql_query($sql);	
		while($dat=mysql_fetch_array($resp)){
			
			$nro_cuenta_padre=$dat['nro_cuenta'];
			$desc_cuenta_padre=$dat['desc_cuenta'];
			
		}
}
				$sql2=" select cod_proveedor,nombre_proveedor";
				$sql2.=" from proveedores";
				$sql2.=" where cod_cuenta=".$_GET['cod_cuenta'];

				$codproveedor=NULL;
				$nombreproveedor="";
				$resp2 = mysql_query($sql2);	
				while($dat2=mysql_fetch_array($resp2)){	
						$codproveedor=$dat2['cod_proveedor'];		
						$nombreproveedor=$dat2['nombre_proveedor'];			
				}
				$sql2=" select cod_cliente, nombre_cliente";
				$sql2.=" from clientes";
				$sql2.=" where cod_cuenta=".$_GET['cod_cuenta'];

				$codcliente=NULL;
				$nombrecliente="";
				$resp2 = mysql_query($sql2);	
				while($dat2=mysql_fetch_array($resp2)){			
						$codcliente=$dat2['cod_cliente'];
						$nombrecliente=$dat2['nombre_cliente'];			
				}
				
?>
<form   method="post" action="saveEditCuenta.php" name="form1">
<input type="hidden" name="cod_cuenta" id="cod_cuenta" value="<?php echo $_GET['cod_cuenta']?>">
<input type="hidden" name="codcliente" id="codcliente" value="<?php echo $codcliente;?>">
<input type="hidden" name="codproveedor" id="codproveedor" value="<?php echo $codproveedor;?>">


<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">EDICI&Oacute;N DE CUENTA</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="70%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Introduzca Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Cuenta Padre</td>
      		<td><input type="hidden" name="cod_cuenta_padre" id="cod_cuenta_padre"  value="<?php if($cod_cuenta_padre!=NULL){  echo $cod_cuenta_padre; }else { echo NULL; }?>"  >
<input type="text" class="textoform" id="desc_cuenta_padre" name="desc_cuenta_padre"  <?php if($cod_cuenta_padre!= NULL){ ?> value="<?php echo $nro_cuenta_padre." ".$desc_cuenta_padre;?>" <?php }?>size="40" disabled="disabled">
<a href="javascript:buscarCuentaPadre(<?php echo $_GET['cod_cuenta'];?>)" accesskey="B">[Vincular Cuenta]</strong></a>
<!--a  href="javascript:datosCuentaPadre(this.form);">[Datos Cuenta]</a--> 
<a  href="javascript:eliminarCuentaPadre();">[Desvincular Cuenta]</a>
		</td>
    	</tr>
	 <tr bgcolor="#FFFFFF">
     		<td>Cliente</td>
      		<td><input type="hidden" name="cod_cliente" id="cod_cliente" value="<?php echo $codcliente;?>">
<input type="text" class="textoform" id="nombre_cliente" name="nombre_cliente" size="40" value="<?php echo $nombrecliente;?>" disabled="disabled">
<a href="javascript:buscarCliente(0)" accesskey="B">[Vincular con Cliente]</strong></a>
<a  href="javascript:eliminarCliente();">[Desvincular de Cliente]</a>
		</td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Proveedor</td>
      		<td><input type="hidden" name="cod_proveedor" id="cod_proveedor"  value="<?php echo $codproveedor;?>" >
<input type="text" class="textoform" id="nombre_proveedor" name="nombre_proveedor" size="40" disabled="disabled" value="<?php echo $nombreproveedor;?>">
<a href="javascript:buscarProveedor(0)" accesskey="B">[Vincular con Proveedor]</strong></a>
<a  href="javascript:eliminarProveedor();">[Desvincular de Proveedor]</a>
		</td>
    	</tr>			
		 <tr bgcolor="#FFFFFF">
     		<td>Nro Cuenta</td>
      		<td><input type="text"name="nro_cuenta" id="nro_cuenta" class="textoform" size="40" value="<?php echo $nro_cuenta;?>" onKeyUp="validaEntero(this)" onChange="validaEntero(this)"><div id="div_cuenta_existente"></div></td>
    	</tr>        
		 
		 <tr bgcolor="#FFFFFF">
     		<td>Cuenta</td>
      		<td><input type="text" name="desc_cuenta" id="desc_cuenta" value="<?php echo $desc_cuenta;?>" class="textoform" size="40" onKeyUp="verificarCuentaDesc()" onChange="verificarCuentaDesc()"><div id="div_cuenta_existente_desc"></div></td>
    	</tr>          

		 <tr bgcolor="#FFFFFF">
     		<td>Detalle</td>
      		<td><textarea name="detalle_cuenta" id="detalle_cuenta" cols="40" class="textoform"  rows="2"><?php echo $detalle_cuenta; ?></textarea></td>
    	</tr> 
         <tr bgcolor="#FFFFFF">
	         <td>Moneda</td>
			<td><select name="cod_moneda" id="cod_moneda" class="textoform">				
				<?php
					$sql2="select cod_moneda, desc_moneda from monedas ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_moneda=$dat2['cod_moneda'];		
			  		 		$desc_moneda=$dat2['desc_moneda'];	
				 ?><option value="<?php echo $cod_moneda;?>" <?php if($cod_moneda==$codmoneda){echo "selected";}?>><?php echo $desc_moneda;?></option>				
				<?php		
					}
				?>						
			</select></td>
		</tr>			
         <tr bgcolor="#FFFFFF">
	         <td>Estado</td>
			<td><select name="cod_estado_registro" id="cod_estado_registro" class="textoform">				
				<?php
					$sql2="select cod_estado_registro, nombre_estado_registro from estados_referenciales ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_estado_registro=$dat2['cod_estado_registro'];		
			  		 		$nombre_estado_registro=$dat2['nombre_estado_registro'];	
				 ?><option value="<?php echo $cod_estado_registro;?>" <?php if($cod_estado_registro==$codestadoregistro){echo "selected";}?>><?php echo $nombre_estado_registro;?></option>				
				<?php		
					}
				?>						
			</select></td>
		</tr>	        					
		</tbody>
	</table>	
	<br>
<div align="center">
<INPUT type="submit" class="boton" name="btn_guardar" value="Guardar Edicion" onClick="guardar(this.form);">
<INPUT type="button" class="boton" name="atras" value="Cancelar Edicion" onClick="javascript:history.back(1)">
</div>
</form>

</body>
</html>
