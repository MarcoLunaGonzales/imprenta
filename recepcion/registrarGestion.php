<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Registro de Cargo</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
			if(f.gestion.value==""){
			 	alert('El campo Gestion se encuentra vacio.'); 
			 	f.gestion.focus();
		 	 	return(false);
			}
		f.submit();
	}	
	function cancelar(){
			window.location="navegadorGestiones.php";
	}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="guardaRegistrarGestion.php">
<?php 
	require("conexion.inc");

?>
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">REGISTRO DE GESTI&Oacute;N </h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="50%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Gesti&oacute;n</td>
      		<td><input type="text"  class="textoform" size="20" name="gestion" ></td>
    	</tr>		
		</tbody>
	</table>	
	<br>
<div align="center">
<INPUT type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
<INPUT type="button"  class="boton"  name="btn_cancelar" value="Cancelar" onClick="cancelar();"  >
</div>
</form>
<?php require("cerrar_conexion.inc");?>

</body>
</html>
