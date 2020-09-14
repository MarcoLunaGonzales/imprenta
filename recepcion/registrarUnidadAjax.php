<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Registro Unidad</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
</head>


<script language='Javascript'>
	function guardar(f)
	{	
			if(f.nombre_unidad.value==""){
			 	alert('El campo Unidad se encuentra vacio.'); 
			 	f.nombre_unidad.focus();
		 	 	return(false);
			}

		
		f.submit();
	}	
	
	function cancelar(f)
	{	
			window.close();
	}
</script>

<body bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Si?ani
	02 de Julio de 2008
-->
<form   method="post" action="guardaRegistrarUnidadAjax.php">
<input type="hidden" name="cod_cliente" id="cod_cliente" value="<?php echo $_GET['cod_cliente'];?>">

<?php 	require("conexion.inc");

	$sql2="select nombre_cliente from clientes where cod_cliente=".$_GET['cod_cliente'];
	$resp2= mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2)){
		$nombre_cliente=$dat2[0];
	}	

?>
<h3 align="center" style="background:white;font-size: 14px;color:#E78611;font-weight:bold;">REGISTRO DE UNIDAD DE <?PHP echo $nombre_cliente;?></h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Unidad</td>
      		<td><input type="text"  class="textoform" size="55" name="nombre_unidad" id="nombre_unidad" ></td>
    	</tr>		
		<tr bgcolor="#FFFFFF">
     		<td>Telefono</td>
      		<td><input type="text"  class="textoform" size="55" name="telf_unidad" id="telf_unidad" ></td>
    	</tr>	
		 

	</table>	

<br>
<div align="center">
	<input type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
	<input type="reset"  class="boton"  name="btn_limpiar" value="Limpiar" >
	<input type="reset"  class="boton"  name="btn_cancelar" value="Cancelar" onClick="cancelar(this.form)"  >
</div>
</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>
