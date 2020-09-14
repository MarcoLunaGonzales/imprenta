<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Editar de Cliente</title>
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
<form   method="post" action="saveVincularClienteCuenta.php">
<?php 	
	require("conexion.inc");
	$cod_cliente=$_GET['cod_cliente'];
?>
<input type="hidden"  class="textoform" size="55" name="cod_cliente" value="<?php echo $cod_cliente;?>" >

<?php	

	$sql2="select nombre_estado_registro from estados_referenciales where cod_estado_registro=1";
	$resp2= mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2)){
		$nombre_estado_registro=$dat2[0];
	}	
	
	$sql=" select nombre_cliente, nit_cliente, cod_categoria, ";
	$sql.=" cod_ciudad, direccion_cliente, telefono_cliente, celular_cliente,";
	$sql.=" fax_cliente, email_cliente, obs_cliente,  cod_usuario_registro,";
	$sql.=" fecha_registro, cod_usuario_modifica, fecha_modifica, cod_estado_registro, cod_usuario_comision,cod_cuenta";
	$sql.=" from clientes ";
	$sql.=" where cod_cliente=".$cod_cliente;
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$nombre_cliente=$dat[0];
		$nit_cliente=$dat[1];
		$codcategoria=$dat[2];
		$codciudad=$dat[3];
		$direccion_cliente=$dat[4]; 
		$telefono_cliente=$dat[5];
		$celular_cliente=$dat[6];
		$fax_cliente=$dat[7];
		$email_cliente=$dat[8];
		$obs_cliente=$dat[9];
		$cod_usuario_registro=$dat[10];
		$fecha_registro=$dat[11];
		$cod_usuario_modifica=$dat[12];
		$fecha_modifica=$dat[13];
		$codestadoregistro=$dat[14];
		$codusuariocomision=$dat[15];
		$cod_cuenta=$dat[16];
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
     		<td>Cliente</td>
      		<td><input type="text"  class="textoform" size="55" name="nombre_cliente" readonly="true" value="<?php echo $nombre_cliente;?>" ></td>
    	</tr>		
		 <tr bgcolor="#FFFFFF">
     		<td>Nit</td>
      		<td><input type="text"  class="textoform" size="55" name="nit_cliente"  value="<?php echo $nit_cliente;?>" ></td>
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
