<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Edici&oacute;n de Unidad de Medida</title>
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
<form   method="post" action="guardaEditarUnidadMedida.php">
<?php 	
	require("conexion.inc");
	$cod_unidad_medida=$_GET['cod_unidad_medida'];
?>
<input type="hidden"  class="textoform" size="55" name="cod_unidad_medida" value="<?php echo $cod_unidad_medida;?>" >

<?php	

		$sql="select nombre_unidad_medida, abrev_unidad_medida, cod_estado_registro";
		$sql.=" from unidades_medidas ";
		$sql.=" where cod_unidad_medida=".$cod_unidad_medida;
		$resp= mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){
			$nombre_unidad_medida =$dat[0];
			$abrev_unidad_medida=$dat[1];
			$codestadoregistro=$dat[2];
					
	}		

?>
<h3 align="center" style="background:white;font-size: 14px;color:#E78611;font-weight:bold;">Edici&oacute;n de Unidad de Medida </h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
	<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
		 		 <tr bgcolor="#FFFFFF">
     		<td>Unidad Medida</td>
      		<td>
			<input type="text"class="textoform" size="55" name="nombre_unidad_medida" value="<?php echo $nombre_unidad_medida;?>">		
			</td>
    	</tr>		
		 <tr bgcolor="#FFFFFF">
     		<td>Abreviatura</td>
      		<td><input type="text"  class="textoform" size="55" name="abrev_unidad_medida" value="<?php echo $abrev_unidad_medida;?>" ></td>
    	</tr>	
								
		 <tr bgcolor="#FFFFFF">
   			<td>Estado</td>
      		<td>
			<select name="cod_estado_registro" class="textoform">				
				<?php
					$sql2="select cod_estado_registro, nombre_estado_registro from estados_referenciales ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_estado_registro=$dat2[0];	
			  		 		$nombre_estado_registro=$dat2[1];	
				 ?><option value="<?php echo $cod_estado_registro;?>" <?php if($cod_estado_registro==$codestadoregistro){echo "selected='selected'";}?>><?php echo $nombre_estado_registro;?></option>				
				<?php		
					}
				?>						
			</select>	
			</td>
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
