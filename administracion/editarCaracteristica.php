<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Edici&oacute;n de Caracteristica</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
			if(f.desc_carac.value==""){
			 	alert('El campo Caracteristica se encuentra vacio.'); 
			 	f.desc_carac.focus();
		 	 	return(false);
			}
		
		f.submit();
	}	
</script>

</head>
<body bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="guardaEditarCaracteristica.php">
<?php 	require("conexion.inc");

	$cod_carac=$_GET['cod_carac'];
	
	$sql=" select desc_carac,  cod_estado_registro,  cod_usuario_registro, fecha_registro,";
	$sql.=" cod_usuario_modifica, fecha_modifica ";
	$sql.=" from caracteristicas ";
	$sql.=" where cod_carac='".$cod_carac."'";
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){	

		$desc_carac=$dat[0];
		$codestadoregistro=$dat[1]; 
		$cod_usuario_registro=$dat[2];
		$fecha_registro=$dat[3];
		$cod_usuario_modifica=$dat[4];
		$fecha_modifica=$dat[5]; 
	}

	
?>
<input type="hidden" name="cod_carac" value="<?php echo $cod_carac;?>">
<h3 align="center" style="background:white;font-size: 14px;color:#E78611;font-weight:bold;">Edici&oacute;n de Caracteristica</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Caracteristica</td>
      		<td><input type="text"  class="textoform" size="55" name="desc_carac" value="<?php echo $desc_carac; ?>" ></td>
    	</tr>					
		 <tr bgcolor="#FFFFFF">
   			<td>Estado</td>
      		<td>			<select name="cod_estado_registro" class="textoform">				
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
			</select>	</td>
    	</tr>		
	</table>	

<br>
<div align="center">
	<input type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
	<input type="reset"  class="boton"  name="btn_limpiar" value="Restaurar" >
	<input type="button"  class="boton"  name="btn_cancelar" value="Cancelar" onClick="javascript:history.back(-1);"  >
</div>
</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>
