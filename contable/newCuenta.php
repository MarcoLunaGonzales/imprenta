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
		ajax.open("GET","ajax_revisiondeNroCtaExistenteDesc.php?desc_cuenta="+document.getElementById("desc_cuenta").value,true);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4) {
				div_cuenta_existente_desc.innerHTML=ajax.responseText;
			}
		}
		ajax.send(null);	
	
		
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
			ajax.open("GET","ajax_revisiondeNroCtaExistenteDesc.php?desc_cuenta="+document.getElementById("desc_cuenta").value,true);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4) {
				div_cuenta_existente_desc.innerHTML=ajax.responseText;
			}
		}
		ajax.send(null);		
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
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="saveCuenta.php" name="form1">

<?php 

	$cod_est_fac=1;
	$sql2=" select desc_est_fac from estado_factura where cod_est_fac='".$cod_est_fac."'";
    $resp2 = mysql_query($sql2);	
	$desc_est_fac="";
	while($dat2=mysql_fetch_array($resp2)){
		$desc_est_fac=$dat2[0];
	}

?>
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">REGISTRO DE CUENTA</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="70%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Introduzca Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Cuenta Padre</td>
      		<td><input type="hidden" name="cod_cuenta_padre" id="cod_cuenta_padre" >
<input type="text" class="textoform" id="desc_cuenta_padre" name="desc_cuenta_padre" size="40" disabled="disabled">
<a href="javascript:buscarCuentaPadre(0)" accesskey="B">[Vincular Cuenta]</strong></a>
<!--a  href="javascript:datosCuentaPadre(this.form);">[Datos Cuenta]</a-->
<a  href="javascript:eliminarCuentaPadre();">[Desvincular Cuenta]</a>		</td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Cliente</td>
   		   <td><input type="hidden" name="cod_cliente" id="cod_cliente" >
   		     <input type="text" class="textoform" id="nombre_cliente" name="nombre_cliente" size="40" disabled="disabled">
   		     <a href="javascript:buscarCliente(0)" accesskey="B">[Vincular con Cliente]</strong></a>
<a  href="javascript:eliminarCliente();">[Desvincular de Cliente]</a>		</td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Proveedor</td>
      		<td><input type="hidden" name="cod_proveedor" id="cod_proveedor" >
<input type="text" class="textoform" id="nombre_proveedor" name="nombre_proveedor" size="40" disabled="disabled">
<a href="javascript:buscarProveedor(0)" accesskey="B">[Vincular con Proveedor]</strong></a>
<a  href="javascript:eliminarProveedor();">[Desvincular de Proveedor]</a>		</td>
    	</tr>				
		 <tr bgcolor="#FFFFFF">
     		<td>Nro Cuenta</td>
      		<td><input type="text"name="nro_cuenta" id="nro_cuenta" class="textoform" size="40" onKeyUp="validaEntero(this)" onChange="validaEntero(this)"><div id="div_cuenta_existente"></div></td>
    	</tr>        
		 
		 <tr bgcolor="#FFFFFF">
     		<td>Cuenta</td>
      		<td><input type="text" name="desc_cuenta" id="desc_cuenta" class="textoform" size="40" onKeyUp="verificarCuentaDesc()" onChange="verificarCuentaDesc()"><div id="div_cuenta_existente_desc"></div></td>
    	</tr>          

		 <tr bgcolor="#FFFFFF">
     		<td>Detalle</td>
      		<td><textarea name="detalle_cuenta" id="detalle_cuenta" cols="40" class="textoform"  rows="2"></textarea></td>
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
				 ?><option value="<?php echo $cod_moneda;?>"><?php echo $desc_moneda;?></option>				
				<?php		
					}
				?>						
			</select></td>
		</tr>			
         <tr bgcolor="#FFFFFF">
	         <td>Estado</td>
			<td>ACTIVO</td>
		</tr>	        					
		</tbody>
	</table>	
	<br>
<div align="center">
<INPUT type="button" class="boton" name="btn_guardar" value="Guardar Registro" onClick="guardar(this.form);">
<INPUT type="button" class="boton" name="atras" value="Cancelar Registro" onClick="javascript:history.back(1)">
</div>
</form>

</body>
</html>
