<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Edición de Cargo</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
		if(f.desc_carac.value==""){
			alert("El campo Caracteristica se encuentra vacio.")
			f.desc_carac.focus();
		 	return(false);
			
		}
		f.submit();
	}	
	function cancelar(){
			window.location="navegadorCaracteristicas.php";
	}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="guardaModificarCaracteristica.php">
<?php 
	require("conexion.inc");
	
	$cod_carac=$_GET['cod_carac'];
	
	$sql=" select desc_carac, cod_estado_registro ";
	$sql.=" from caracteristicas where cod_carac='".$cod_carac."'";
    $resp= mysql_query($sql);	
	$dat=mysql_fetch_array($resp);
	$desc_carac=$dat[0];
	$codestadoregistro=$dat[1];		

?>
<input type="hidden" name="cod_carac" value="<?php echo $cod_carac;?>">
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">EDICI&Oacute;N DE CARACTERISTICA </h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Caracteristica</td>
      		<td><input type="text"  class="textoform" size="50" name="desc_carac"  value="<?php echo $desc_carac;?>"></td>
    	</tr>
		<tr bgcolor="#FFFFFF">
     		<td>Estado de Registro</td>
      		<td>
			<select name="cod_estado_registro" class="textoform">
				<?php
					$sql_2="select cod_estado_registro,nombre_estado_registro from estados_referenciales  ";
					$resp_2= mysql_query($sql_2);
					while($dat_2=mysql_fetch_array($resp_2)){	
			  		 	$cod_estado_registro= $dat_2[0];
    					$nombre_estado_registro=$dat_2[1];
				 ?>
				 	<?php if($cod_estado_registro==$codestadoregistro){?>
					
				 		<option value="<?php echo $cod_estado_registro;?>" selected><?php echo $nombre_estado_registro;?></option>				
					<?php }else{?>
						<option value="<?php echo $cod_estado_registro;?>"><?php echo $nombre_estado_registro;?></option>				
					<?php } ?>
				<?php		
					}
				?>						
			</select>			</td>
    	</tr>		
		</tbody>
	</table>	
	<br>
<div align="center">
<INPUT type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
<INPUT type="button"  class="boton"  name="btn_limpiar" value="Cancelar" onClick="cancelar();"  >
</div>
</form>
<?php require("cerrar_conexion.inc");?>

</body>
</html>
