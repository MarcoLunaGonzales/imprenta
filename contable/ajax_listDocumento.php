<?php header("Cache-Control: no-store, no-cache, must-revalidate");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BUSQUEDA DE DOCUMENTOS</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
</head>
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
function cancelar(f)
{	
			window.close();
}
function buscar(f){
	var div_resultado;
	div_resultado=document.getElementById("div_resultado");			
	ajax=nuevoAjax();
	ajax.open("GET","ajax_buscarDocumentos.php?nroDocB="+document.getElementById("nroDocB").value+"&nombreClienteB="+document.getElementById("nombreClienteB").value+"&cod_tipo_docB="+document.getElementById("cod_tipo_docB").value,true);		

		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
			div_resultado.innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null)
}	
function enviarDatos(cod_tipod_doc,codigo_doc,descripcion){			
			window.close();
			window.opener.setDocumento(cod_tipod_doc,codigo_doc,descripcion);
}
</script>

<body onload="buscar(this.form)">
<!---Autor:Gabriela Quelali Si?ani
	02 de Julio de 2008
-->
<form   method="post" name="form1" >

        <h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">BUSQUEDA DE DOCUMENTO </h3>
        <h3 align="center" style="background:#FFF;font-size: 11px;color: #000;font-weight:bold;">Seleccione o llene los campos de busqueda.</h3>

<?php
require("conexion.inc");
?>
			<table align='center'>
			<tr>  
            <th>Tipo Documento:</th>        
			<td>
				<select name="cod_tipo_docB" id="cod_tipo_docB" onchange="buscar();" class="textoform">
				<option value="0">Elija un Opci&oacute;n</option>
				<?php
					$sql2=" select cod_tipo_doc, desc_tipo_doc";
					$sql2.=" from   tipo_documento ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_tipo_doc=$dat2['cod_tipo_doc'];	
			  		 		$desc_tipo_doc=$dat2['desc_tipo_doc'];	
				 ?>
                 <option value="<?php echo $cod_tipo_doc;?>" <?php if($cod_tipo_docB==$cod_tipo_doc){?> selected="selected" <?php } ?>><?php echo utf8_decode($desc_tipo_doc);?></option>				
				<?php		
					}
				?>						
			</select>
			</td>
 			<td><strong>Nro de Doc:</strong></td>
		 <td ><input type="text" name="nroDocB" id="nroDocB" size="10" value="<?php echo $nroDocB;?>" class="textoform" onkeyup="buscar()" ></td>

			</tr>
<tr><td><strong>Cliente:</strong></td>
<td colspan="3">
 <input name="nombreClienteB" id="nombreClienteB" size="50" class="textoform" value="<?php echo $nombreClienteB; ?>" onkeyup="buscar()">
	</td>
</tr>			
            </table>

   <br/>
<div id="div_resultado">


	<table width="98%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
            <td>Tipo Doc</td>
			<td>Nro Doc</td>
    		<td>Fecha</td>
    		<td>Cliente </td>																		
		</tr>
		<tr bgcolor="#FFFFFF" align="center" ><th colspan="4">No Existen registros</th></tr>
        </table>        
       

</div>

</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>
