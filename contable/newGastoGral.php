<?php 
	require("conexion.inc");
	include("funciones.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>INVENTA</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function cancelar(f){
			window.location="listGastosGral.php";
	}
	function guardar(f){
			if(f.monto_gasto_gral.value==""){
			alert("El campo Monto se encuentra vacio.")
			f.monto_gasto_gral.focus();
		 	return(false);
			
		}
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
function buscarDocumento(){
		izquierda = (screen.width) ? (screen.width-600)/2 : 100 
	    arriba = (screen.height) ? (screen.height-400)/2 : 100 
		url="ajax_listDocumento.php";
opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=650,left='+izquierda+',top=' + arriba + '' 
	   	window.open(url, 'popUp', opciones);
}
function setDocumento(cod_tipod_doc,codigo_doc,descripcion){
	document.getElementById('cod_tipo_doc').value=cod_tipod_doc;
	document.getElementById('codigo_doc').value=codigo_doc;
	document.getElementById('desc_documento').value=descripcion;	
	
}

function eliminarDocumento(){
	document.getElementById('cod_tipo_doc').value=null;
	document.getElementById('codigo_doc').value=null;
	document.getElementById('desc_documento').value="";	
}	

function buscarProveedor(){
		izquierda = (screen.width) ? (screen.width-600)/2 : 100 
	    arriba = (screen.height) ? (screen.height-400)/2 : 100 
		url="ajax_listProveedoresGral.php";
opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=650,left='+izquierda+',top=' + arriba + '' 
	   	window.open(url, 'popUp', opciones);
}
function setProveedor(cod_proveedor, proveedor){
	document.getElementById('nombre_proveedor').value=proveedor;
	document.getElementById('cod_proveedor').value=cod_proveedor;		
}

function eliminarProveedor(){
	document.getElementById('cod_proveedor').value=null;
	document.getElementById('nombre_proveedor').value="";	
}	


</script></head>
<body bgcolor="#FFFFFF" onload="document.form1.nro_recibo.focus()">


<form name="form1" id="form1" method="post" action="saveGastoGral.php">
<?php
	$cod_gestion=gestionActiva();
	
	$sql2="select gestion_nombre from gestiones where cod_gestion='".$cod_gestion."'";
	$resp2= mysql_query($sql2);
	$gestion="";
	while($dat2=mysql_fetch_array($resp2)){
		$gestion_nombre=$dat2['gestion_nombre'];
	}
	$sql="select max(nro_gasto_gral) from gastos_gral where cod_gestion='".$cod_gestion."'";
	$nro_gasto_gral=obtenerCodigo($sql);
	$cod_tipo_pago_defecto=2;

 ?>


<h3 align="center" style="background:#FFFFFF;font-size: 14px;color: #E78611;font-weight:bold;">REGISTRO DE GASTO <br/>
   Nro. <?php echo $nro_gasto_gral." / ".$gestion_nombre;?></h3>

 <div id="resultados" align="center">   

    <table align="center"class="text" cellSpacing="1" cellPadding="4" width="75%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Introduzca Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td align="left">Nro Recibo</td>
      		<td align="left"><input type="text"  class="textoform" size="50" name="nro_recibo" id="nro_recibo"  ></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha de Gasto</td>
      		<td align="left"><input type="text"  class="textoform" size="50" name="fecha_gasto_gral" id="fecha_gasto_gral" value="<?php echo date('d/m/Y', time());?>" /></td>
    	</tr>  
 		 <tr bgcolor="#FFFFFF">
     		<td>Documento</td>
   		   <td><input type="hidden" name="cod_tipo_doc" id="cod_tipo_doc" >
		   <input type="hidden" name="codigo_doc" id="codigo_doc" >
   		     <input type="text" class="textoform" id="desc_documento" name="desc_documento" size="60" disabled="disabled" />
   		     <a href="javascript:buscarDocumento(0)" accesskey="B">[Vincular con Documento]</strong></a>
<a  href="javascript:eliminarDocumento();">[Desvincular  Documento]</a></td>
    	</tr>
		     
		 <tr bgcolor="#FFFFFF">
     		<td>Proveedor</td>
      		<td><input type="hidden" name="cod_proveedor" id="cod_proveedor" >
<input type="text" class="textoform" id="nombre_proveedor" name="nombre_proveedor" size="60" disabled="disabled">
<a href="javascript:buscarProveedor(0)" accesskey="B">[Vincular con Proveedor]</strong></a>
<a  href="javascript:eliminarProveedor();">[Desvincular de Proveedor]</a>		</td>
    	</tr>  
		<tr bgcolor="#FFFFFF">
		<td >Tipo de Pago </td>
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
     		<td>Gasto</td>
      		<td align="left"><select class="textoform" name="cod_gasto" id="cod_gasto">
            <?php
            	$sql2="select cod_gasto, desc_gasto";
            	$sql2.=" from gastos ";
            	$sql2.=" order by desc_gasto asc ";
				$resp2 = mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$cod_gasto=$dat2['cod_gasto'];
					$desc_gasto=$dat2['desc_gasto'];
			?>
            	<option value="<?php echo $cod_gasto;?>"><?php echo $desc_gasto; ?></option>
            <?php
				}				

			?>
            </select></td>
    	</tr>		
		 <tr bgcolor="#FFFFFF">
     		<td>Descripcion</td>
      		<td align="left"><textarea name="desc_gasto_gral" id="desc_gasto_gral" cols="60" rows="2" class="textoform"></textarea></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Cantidad</td>
      		<td align="left"><input type="text"  class="textoform" size="50" name="cant_gasto_gral"  id="cant_gasto_gral"/></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Monto</td>
      		<td align="left"><input type="text"  class="textoform" value="0" size="50" name="monto_gasto_gral" id="monto_gasto_gral" /></td>
    	</tr>                 										
		</tbody>
	</table>
 </div>			

</div>	
	<br>
<div align="center">
<INPUT type="button"  class="boton"  name="btn_atras" value="IR  ATRAS" onClick="cancelar(this.form);"  >
<INPUT type="button" class="boton" name="btn_guardar" onclick="guardar(this.form)" value="GUARDAR"  >

</div>
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
