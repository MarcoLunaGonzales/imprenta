<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Edición de Cargo</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
		if(f.nombre_cargo.value==""){
			alert("El campo Cargo se encuentra vacio.")
			f.nombre_cargo.focus();
		 	return(false);
			
		}
		f.submit();
	}	
	function cancelar(){
			window.location="navegador_cargos.php";
	}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="guarda_editar_cargo.php">
<?php 
	require("conexion.inc");
	
	$cod_cargo=$_GET['cod_cargo'];
	
	$sql=" select nombre_cargo, obs_cargo, cod_estado_registro ";
	$sql.=" from cargos where cod_cargo='".$cod_cargo."'";
    $resp= mysql_query($sql);	
	$dat=mysql_fetch_array($resp);
	$nombre_cargo=$dat[0];
	$obs_cargo=$dat[1];
	$codestadoregistro=$dat[2];		

?>
<input type="hidden" name="cod_cargo" value="<?php echo $cod_cargo;?>">
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">Edición de Cargo </h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Introduzca Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Cargo</td>
      		<td><input type="text"  class="textoform" size="50" name="nombre_cargo"  value="<?php echo $nombre_cargo;?>"></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
      		<td><textarea name="obs_cargo" class="textoform" rows="3" cols="50"><?php echo $obs_cargo; ?></textarea></td>
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
			</select>
			</td>
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
