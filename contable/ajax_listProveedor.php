<?php header("Cache-Control: no-store, no-cache, must-revalidate");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BUSQUEDA DE PROVEEDORES</title>
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

	ajax.open("GET","ajax_buscarProveedores.php?nombre_proveedorB="+document.getElementById("nombre_proveedorB").value,true);		

		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
			div_resultado.innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null)
}	
function enviarDatos(cod_proveedor,proveedor){			
			window.close();
			window.opener.setProveedor(cod_proveedor,proveedor);
}
</script>

<body onload="buscar(this.form)">
<!---Autor:Gabriela Quelali Si?ani
	02 de Julio de 2008
-->
<form   method="post" name="form1" >

        <h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">BUSQUEDA DE PROVEEDORES</h3>
  <h3 align="center" style="background:#FFF;font-size: 11px;color: #000;font-weight:bold;">Seleccione o llene los campos de busqueda.</h3>

<?php
require("conexion.inc");
?>
			<table align='center'>
			<tr>  
            <th>PROEVEEDOR:</th>        
			<td>
				<input type='text' name='nombre_proveedorB' id="nombre_proveedorB" onKeyUp="buscar(this.form)" >
			</td>

			</tr>
            </table>

   <br/>
<div id="div_resultado">


	<table width="98%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			  <td>Proveedor</td>
              <td>NIT</td>
              <td>Contactos</td>
              <td>Direcci&oacute;n</td> 
              <td>Telf.</td>   																		
		</tr>
		<tr bgcolor="#FFFFFF" align="center" ><th colspan="5">No Existen registros</th></tr>
        </table>        
       

</div>

</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>
