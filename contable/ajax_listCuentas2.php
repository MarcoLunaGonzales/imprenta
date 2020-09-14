<?php header("Cache-Control: no-store, no-cache, must-revalidate");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Busqueda de Cuentas</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
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

	
		ajax.open("GET","ajax_buscarCuentas2.php?numero_cuentaB="+document.getElementById("numero_cuentaB").value+"&numDetalleCbte="+document.getElementById("numDetalleCbte").value,true);		

		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
			div_resultado.innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null)
}	
function enviarDatos(numDetalleCbte,cod_cuenta,nro_cuenta,desc_cuenta){			
			window.close();
			window.opener.setCuentas(numDetalleCbte,cod_cuenta,nro_cuenta,desc_cuenta);
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body onLoad="buscar(this.form)">
<!---Autor:Gabriela Quelali Si�ani
	02 de Julio de 2008
-->
<form   method="post" name="form1" id="form1" >
<input type="hidden" name="numDetalleCbte" id="numDetalleCbte"  value="<?php echo $_GET['numDetalleCbte'];  ?>">
        <h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">BUSQUEDA DE CUENTAS</h3>
  <table align='center'>
<?php
require("conexion.inc");
?>
            <th>CUENTA:</th>        
			<td>
				<input type='text' name='numero_cuentaB' id="numero_cuentaB" onKeyUp="buscar(this.form)" >
			</td>


			</tr>
			
		</table>

   <br/>
<div id="div_resultado">

	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			  <td>Nro de Cuenta</td>
              <td>Cuenta</td>
              <td>Detalle</td>
              <td>Moneda</td> 
              <td>Estado</td> 								
		</tr>
		<tr><th colspan="5" class="fila_par" align="center">No existen resultados</th></tr>
	</table>

</div>

</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>
