<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Edicion de Proveedor</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
			if(f.nombre_proveedor.value==""){
			 	alert('El campo Cliente se encuentra vacio.'); 
			 	f.nombre_proveedor.focus();
		 	 	return(false);
			}
			if(f.cod_ciudad.value==0){
			 	alert('Seleccione la Ciudad.'); 
			 	f.cod_ciudad.focus();
		 	 	return(false);
			}
			if(f.direccion_proveedor.value==""){
			 	alert('El campo Direccion se encuentra vacio.'); 
			 	f.direccion_proveedor.focus();
		 	 	return(false);
			}						
		
		f.submit();
	}	
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="guardaEditarProveedor.php">
<?php 	
	require("conexion.inc");

?>
<input type="hidden"  class="textoform" size="55" name="cod_proveedor" value="<?php echo $_GET['cod_proveedor'];?>" >

<?php	


	
	$sql=" select nombre_proveedor, nit_proveedor,  ";
	$sql.=" cod_ciudad, direccion_proveedor, telefono_proveedor, celular_proveedor,";
	$sql.=" fax_proveedor, mail_proveedor, obs_proveedor, cod_usuario_registro,";
	$sql.=" fecha_registro, cod_usuario_modifica, fecha_modifica, cod_estado_registro ";
	$sql.=" from proveedores ";
	$sql.=" where cod_proveedor=".$_GET['cod_proveedor'];
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		
		$nombre_proveedor=$dat['nombre_proveedor'];
		$nit_proveedor=$dat['nit_proveedor'];
		$codciudad=$dat['cod_ciudad'];
		$direccion_proveedor=$dat['direccion_proveedor']; 
		$telefono_proveedor=$dat['telefono_proveedor'];
		$celular_proveedor=$dat['celular_proveedor'];
		$fax_proveedor=$dat['fax_proveedor'];
		$mail_proveedor=$dat['mail_proveedor'];
		$obs_proveedor=$dat['obs_proveedor'];
		$cod_usuario_registro=$dat['cod_usuario_registro'];
		$fecha_registro=$dat['fecha_registro'];
		$cod_usuario_modifica=$dat['cod_usuario_modifica'];
		$fecha_modifica=$dat['fecha_modifica'];
		$codestadoregistro=$dat['codestadoregistro'];
	}		

?>
<h3 align="center" style="background:white;font-size: 14px;color:#E78611;font-weight:bold;">EDICION DE PROVEEDOR</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
	<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">DATOS</td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Proveedor</td>
      		<td><input type="text"  class="textoform" size="55" name="nombre_proveedor" value="<?php echo $nombre_proveedor;?>" ></td>
    	</tr>		
		 <tr bgcolor="#FFFFFF">
     		<td>Nit</td>
      		<td><input type="text"  class="textoform" size="55" name="nit_proveedor"  value="<?php echo $nit_proveedor;?>" ></td>
    	</tr>	
		 
		 <tr bgcolor="#FFFFFF">
     		<td>Ciudad</td>
      		<td>
			<select name="cod_ciudad" class="textoform">				
				<?php
					$sql2="select cod_ciudad, desc_ciudad from ciudades where cod_pais=1 order by  desc_ciudad asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_ciudad=$dat2[0];	
			  		 		$desc_ciudad=$dat2[1];	
				 ?><option value="<?php echo $cod_ciudad;?>" <?php if($cod_ciudad==$codciudad){echo "selected='selected'";}?>><?php echo $desc_ciudad;?></option>				
				<?php		
					}
				?>						
			</select>			</td>
    	</tr>	
		 <tr bgcolor="#FFFFFF">
     		<td>Direcci&oacute;n</td>
      		<td><input type="text"  class="textoform" size="55" name="direccion_proveedor" value="<?php echo $direccion_proveedor;?>" ></td>
    	</tr>						
		 <tr bgcolor="#FFFFFF">
     		<td>Telefono</td>
      		<td ><input type="text"  class="textoform" size="55" name="telefono_proveedor" value="<?php echo $telefono_proveedor;?>"></td>
    	</tr>			
		 <tr bgcolor="#FFFFFF">
     		<td>Fax</td>
      		<td ><input type="text"  class="textoform" size="55" name="fax_proveedor" value="<?php echo $fax_proveedor;?>" ></td>
    	</tr>			
		 <tr bgcolor="#FFFFFF">
     		<td>Celular</td>
      		<td ><input type="text"  class="textoform" size="55" name="celular_proveedor" value="<?php echo $celular_proveedor;?>" ></td>
    	</tr>			
		 <tr bgcolor="#FFFFFF">
	   		<td>Email</td>
      		<td ><input type="text"  class="textoform" size="55" name="mail_proveedor" value="<?php echo $mail_proveedor;?>"></td>
    	</tr>							
		 <tr bgcolor="#FFFFFF">
   			<td>Estado</td>
      		<td><select name="cod_estado_registro" class="textoform">				
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
		 <tr bgcolor="#FFFFFF">
   			<td>Observaciones</td>
      		<td ><textarea cols="55" name="obs_proveedor" rows="3" class="textoform"><?php echo $obs_proveedor;?> </textarea></td>
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
