<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Vincular Cuenta</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
							
		
		f.submit();
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
function buscarCuenta(cuenta){
		izquierda = (screen.width) ? (screen.width-600)/2 : 100 
	    arriba = (screen.height) ? (screen.height-400)/2 : 100 
		url="ajax_listCuentas.php?cuenta="+cuenta;
opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=650,left='+izquierda+',top=' + arriba + '' 
	   	window.open(url, 'popUp', opciones);
}
function setCuentas(cod_cuenta, cuenta, nro_nuevo){
	document.getElementById('desc_cuenta').value=cuenta;
	document.getElementById('cod_cuenta').value=cod_cuenta;
	}

function eliminarCuenta(){
	document.getElementById('cod_cuenta').value=null;
	document.getElementById('desc_cuenta').value="";	
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="saveVincularProveedorCuenta.php">
<?php 	
	require("conexion.inc");

?>
<input type="hidden"  class="textoform" size="55" name="cod_proveedor" value="<?php echo $_GET['cod_proveedor'];?>" >

<?php	

	$sql=" select nombre_proveedor, nit_proveedor,  ";
	$sql.=" cod_ciudad, direccion_proveedor, telefono_proveedor, celular_proveedor,";
	$sql.=" fax_proveedor, mail_proveedor, obs_proveedor, cod_usuario_registro,";
	$sql.=" fecha_registro, cod_usuario_modifica, fecha_modifica, cod_estado_registro,cod_cuenta ";
	$sql.=" from proveedores ";
	$sql.=" where cod_proveedor=".$_GET['cod_proveedor'];
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		
		$nombre_proveedor=$dat['nombre_proveedor'];
		$nit_proveedor=$dat['nit_proveedor'];
		$codciudad=$dat['cod_ciudad'];
		$direccion_proveedor=$dat['direccion_proveedor']; 
		$telefono_proveedor=$dat['telefono_proveedor'];
		$celular_proveedor=$dat['celular_proveedor'];
		$fax_proveedor=$dat['fax_proveedor'];
		$mail_proveedor=$dat['mail_proveedor'];
		$obs_proveedor=$dat['obs_proveedor'];
		$cod_usuario_registro=$dat['cod_usuario_registro'];
		$fecha_registro=$dat['fecha_registro'];
		$cod_usuario_modifica=$dat['cod_usuario_modifica'];
		$fecha_modifica=$dat['fecha_modifica'];
		$codestadoregistro=$dat['codestadoregistro'];
		$cod_cuenta=$dat['cod_cuenta'];
		if($cod_cuenta!= NULL){
		$sql2=" select  nro_cuenta, desc_cuenta ";
		$sql2.=" from cuentas ";
		$sql2.=" where cod_cuenta=".$cod_cuenta." ";
		$resp2 = mysql_query($sql2);	
		while($dat2=mysql_fetch_array($resp2)){			
			$nro_cuenta=$dat2['nro_cuenta'];
			$desc_cuenta=$dat2['desc_cuenta'];
			
		}
}
	}	
	

?>
<h3 align="center" style="background:white;font-size: 14px;color:#E78611;font-weight:bold;">VINCULAR CUENTA</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
	<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Proveedor</td>
      		<td><input type="text"  class="textoform" size="55" name="nombre_proveedor" readonly="true" value="<?php echo $nombre_proveedor;?>" ></td>
    	</tr>		
		 <tr bgcolor="#FFFFFF">
     		<td>Nit</td>
      		<td><input type="text"  class="textoform" size="55" id="nit_proveedor" name="nit_proveedor"  value="<?php echo $nit_proveedor;?>" ></td>
    	</tr>	
				 <tr bgcolor="#FFFFFF">
     		<td>Cuenta</td>
      		<td><input type="hidden" name="cod_cuenta" id="cod_cuenta"  value="<?php if($cod_cuenta!=NULL){  echo $cod_cuenta; }else { echo NULL; }?>"  >
<input type="text" class="textoform" id="desc_cuenta" name="desc_cuenta"  <?php if($cod_cuenta!= NULL){ ?> value="<?php echo $nro_cuenta." ".$desc_cuenta;?>" <?php }?>size="40" disabled="disabled">
<a href="javascript:buscarCuenta(0)" accesskey="B">[Vincular Cuenta]</strong></a>
<a  href="javascript:eliminarCuenta();">[Desvincular Cuenta]</a></td>
    	</tr>
	 
					
		</tbody>
	</table>	

<br>
<div align="center">
	<input type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
	<input type="reset"  class="boton"  name="btn_limpiar" value="Reestablecer Valores" >
	<input type="reset"  class="boton"  name="btn_cancelar" value="Cancelar" onClick="javascript:history.back(-1);"  >
</div>
</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>
