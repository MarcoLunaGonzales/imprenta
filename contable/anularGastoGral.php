<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Anulacion de  Ingreso </title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>


function guardar(f)
{	
	if(f.obs_anulacion.value==""){
		 		alert('Debe llenar la razon de la anulacion.'); 			 	
		 		return(false);
	}	
			f.submit();
}	
	function cancelar(f)
	{	
		window.close();
	}			
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="guardaAnularGastoGral.php">
<?php 	


	require("conexion.inc");
	include("funciones.php");
?>

<input type="hidden" name="cod_gasto_gral" value="<?php echo $_GET['cod_gasto_gral']?>" >
<h3 align="center" style="background:white;font-size: 12px;color:#E78611;font-weight:bold;">Anulacion de Gasto <br>
  No. <?php echo $nro_gasto_gral;?></h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="50%" bgColor="#cccccc" border="0">
	<tbody>

		<tr height="20px" align="center"  class="titulo_tabla">
			<td>Motivo de Anulacion</td>
		</tr>		
		<tr bgcolor="#FFFFFF">
			<td >
			<textarea cols="70" rows="4" name="obs_anulacion" id="obs_anulacion"  class="textoform" ></textarea>
			</td>
		</tr>							
	  </tbody>
	</table>	

		
<br>
<div align="center">
	<input type="button" class="boton" name="btn_guardar" value="Aceptar" onClick="guardar(this.form);"  >
	<input type="reset"  class="boton"  name="btn_limpiar" value="Cancelar" onClick="cancelar(this.form);" >
</div>
</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>
