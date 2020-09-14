<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Registro de Unidad Medida</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
			if(f.nombre_unidad_medida.value==""){
			 	alert('El campo Unidad Medida se encuentra vacio.'); 
			 	f.nombre_unidad_medida.focus();
		 	 	return(false);
			}
		
		f.submit();
	}	
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="guardaRegistrarUnidadMedida.php">
<?php 	require("conexion.inc");

	$sql2="select nombre_estado_registro from estados_referenciales where cod_estado_registro=1";
	$resp2= mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2)){
		$nombre_estado_registro=$dat2[0];
	}	
?>
<h3 align="center" style="background:white;font-size: 14px;color:#E78611;font-weight:bold;">Registro de Unidad Medida </h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
	<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Unidad Medida</td>
      		<td><input type="text"  class="textoform" size="55" name="nombre_unidad_medida" ></td>
    	</tr>		
		 <tr bgcolor="#FFFFFF">
     		<td>Abreviatura</td>
      		<td><input type="text"  class="textoform" size="55" name="abrev_unidad_medida" ></td>
    	</tr>	
	
		 				
		 <tr bgcolor="#FFFFFF">
   			<td>Estado</td>
      		<td><?php echo $nombre_estado_registro;?></td>
    	</tr>				
		</tbody>
	</table>	

<br>
<div align="center">
	<input type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
	<input type="reset"  class="boton"  name="btn_limpiar" value="Limpiar" >
	<input type="reset"  class="boton"  name="btn_cancelar" value="Cancelar" onClick="javascript:history.back(-1);"  >
</div>
</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>
