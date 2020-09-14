<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Editar de Cliente</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
			if(f.nombre_cliente.value==""){
			 	alert('El campo Cliente se encuentra vacio.'); 
			 	f.nombre_cliente.focus();
		 	 	return(false);
			}
			if(f.cod_ciudad.value==0){
			 	alert('Seleccione la Ciudad.'); 
			 	f.cod_ciudad.focus();
		 	 	return(false);
			}
			if(f.direccion_cliente.value==""){
			 	alert('El campo Direccion se encuentra vacio.'); 
			 	f.direccion_cliente.focus();
		 	 	return(false);
			}	
			if(f.telefono_cliente.value==""){
			 	alert('El campo Telefono se encuentra vacio.'); 
			 	f.telefono_cliente.focus();
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
<form   method="post" action="guardaEditarCliente.php">
<?php 	
	require("conexion.inc");
	$cod_cliente=$_GET['cod_cliente'];
?>
<input type="hidden"  class="textoform" size="55" name="cod_cliente" value="<?php echo $cod_cliente;?>" >

<?php	

	$sql2="select nombre_estado_registro from estados_referenciales where cod_estado_registro=1";
	$resp2= mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2)){
		$nombre_estado_registro=$dat2[0];
	}	
	
	$sql=" select nombre_cliente, nit_cliente, cod_categoria, ";
	$sql.=" cod_ciudad, direccion_cliente, telefono_cliente, celular_cliente,";
	$sql.=" fax_cliente, email_cliente, obs_cliente,  cod_usuario_registro,";
	$sql.=" fecha_registro, cod_usuario_modifica, fecha_modifica, cod_estado_registro, cod_usuario_comision";
	$sql.=" from clientes ";
	$sql.=" where cod_cliente=".$cod_cliente;
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$nombre_cliente=$dat[0];
		$nit_cliente=$dat[1];
		$codcategoria=$dat[2];
		$codciudad=$dat[3];
		$direccion_cliente=$dat[4]; 
		$telefono_cliente=$dat[5];
		$celular_cliente=$dat[6];
		$fax_cliente=$dat[7];
		$email_cliente=$dat[8];
		$obs_cliente=$dat[9];
		$cod_usuario_registro=$dat[10];
		$fecha_registro=$dat[11];
		$cod_usuario_modifica=$dat[12];
		$fecha_modifica=$dat[13];
		$codestadoregistro=$dat[14];
		$codusuariocomision=$dat[15];
	}		

?>
<h3 align="center" style="background:white;font-size: 14px;color:#d20000;font-weight:bold;">Edici&oacute;n de Cliente</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
	<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Cliente</td>
      		<td><input type="text"  class="textoform" size="55" name="nombre_cliente" value="<?php echo $nombre_cliente;?>" ></td>
    	</tr>		
		 <tr bgcolor="#FFFFFF">
     		<td>Nit</td>
      		<td><input type="text"  class="textoform" size="55" name="nit_cliente"  value="<?php echo $nit_cliente;?>" ></td>
    	</tr>	
		 <tr bgcolor="#FFFFFF">
     		<td>Categoria</td>
      		<td>
			<select name="cod_categoria" class="textoform">
				<?php
					$sql2="select cod_categoria, desc_categoria from clientes_categorias  order by  desc_categoria asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_categoria=$dat2[0];	
			  		 		$desc_categoria=$dat2[1];	
				 ?>
				 <option value="<?php echo $cod_categoria;?>"<?php if($cod_categoria==$codcategoria){echo "selected='selected'";}?> >
				 <?php echo $desc_categoria;?>
				 </option>				
				<?php		
					}
				?>						
			</select>			</td>
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
      		<td><input type="text"  class="textoform" size="55" name="direccion_cliente" value="<?php echo $direccion_cliente;?>" ></td>
    	</tr>						
		 <tr bgcolor="#FFFFFF">
     		<td>Telefono</td>
      		<td ><input type="text"  class="textoform" size="55" name="telefono_cliente" value="<?php echo $telefono_cliente;?>"></td>
    	</tr>			
		 <tr bgcolor="#FFFFFF">
     		<td>Fax</td>
      		<td ><input type="text"  class="textoform" size="55" name="fax_cliente" value="<?php echo $fax_cliente;?>" ></td>
    	</tr>			
		 <tr bgcolor="#FFFFFF">
     		<td>Celular</td>
      		<td ><input type="text"  class="textoform" size="55" name="celular_cliente" value="<?php echo $celular_cliente;?>" ></td>
    	</tr>			
		 <tr bgcolor="#FFFFFF">
	   		<td>Email</td>
      		<td ><input type="text"  class="textoform" size="55" name="email_cliente" value="<?php echo $email_cliente;?>"></td>
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
      		<td ><textarea cols="55" name="obs_cliente" rows="3" class="textoform"><?php echo $obs_cliente;?> </textarea></td>
    	</tr>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">COMISION</td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
   			<td>Comision</td>
      		<td>		 <select name="cod_usuario_comision" class="textoform" >
				<?php
					$sql3="select cod_usuario, nombres_usuario, ap_paterno_usuario from usuarios where cod_usuario<>0";
					$resp3=mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3))
						{
							$cod_usuario=$dat3[0];
							$nombres_usuario=$dat3[1];	
			  		 		$ap_paterno_usuario=$dat3[2];	
				 ?>
				 	<option value="<?php echo $cod_usuario;?>" <?php if($cod_usuario==$codusuariocomision){?> selected="selected"<?php }?> >
				 		<?php echo $nombres_usuario." ".$ap_paterno_usuario;?>
				 	</option>				 				 		
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
