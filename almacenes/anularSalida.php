<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Anulacion de  Salida </title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>


function guardar(f)
{	
	if(f.obs_anular.value==""){
		 		alert('El campo observaciones se encuentra vacio. '); 			 	
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
<form   method="post" action="guardaAnularSalida.php">
<?php 	


	require("conexion.inc");
	include("funciones.php");
	$cod_salida=$_GET['cod_salida'];


	$sql=" select s.nro_salida, s.cod_gestion, g.gestion,  s.fecha_salida ";
	$sql.=" from salidas s, gestiones g ";
	$sql.=" where s.cod_salida=".$cod_salida;
	$sql.=" and s.cod_gestion=g.cod_gestion ";
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$nro_salida=$dat[0];
		$cod_gestion=$dat[1];
		$gestion=$dat[2];
		$fecha_salida=$dat[3];
	}
	
	
?>
<input type="hidden" name="cod_salida" value="<?php echo $cod_salida;?>">
<h3 align="center" style="background:white;font-size: 12px;color:#E78611;font-weight:bold;">Anulacion de Salida <br>
  No. <?php echo $nro_salida;?>/<?php echo $gestion;?><br><?php echo "Fecha: ".$fecha_salida;?></h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="50%" bgColor="#cccccc" border="0">
	<tbody>

		<tr height="20px" align="center"  class="titulo_tabla">
			<td>Motivo de Anulacion</td>
		</tr>		
		<tr bgcolor="#FFFFFF">
			<td >
			<textarea cols="70" rows="4" name="obs_anular" id="obs_anular"  class="textoform" ></textarea>
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
