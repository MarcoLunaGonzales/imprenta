<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Datos de Cliente</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
			if(f.nombre_contacto.value==""){
			 	alert('El campo Nombre se encuentra vacio.'); 
			 	f.nombre_contacto.focus();
		 	 	return(false);
			}
			if(f.ap_paterno_contacto.value==""){
			 	alert('El campo Apellido Paterno se encuentra vacio.'); 
			 	f.ap_paterno_contacto.focus();
		 	 	return(false);
			}	
				
					
		
			if(confirm("¿Esta seguro de guardar los datos?")){
					f.submit();
			}

	}	
	
	function cancelar(f)
	{	
			window.location="listContactosClientes.php?cod_cliente="+f.cod_cliente.value;
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="saveEditContactoCliente.php">
<input type="hidden" name="cod_contacto" id="cod_contacto" value="<?php echo $_GET['cod_contacto'];?>">
<?php 	require("conexion.inc");



	$sql=" select  cod_cliente, nombre_contacto, ap_paterno_contacto, ap_materno_contacto,";
	$sql.=" telefono_contacto, celular_contacto, email_contacto, cargo_contacto,";
	$sql.=" cod_estado_registro, cod_usuario_registro, fecha_registro ";
	$sql.=" from clientes_contactos ";
	$sql.=" where  cod_contacto=".$_GET['cod_contacto'];
	$resp= mysql_query($sql);
	
	while($dat=mysql_fetch_array($resp)){	
		
		$cod_cliente=$dat['cod_cliente'];
		$nombre_contacto=$dat['nombre_contacto'];
		$ap_paterno_contacto=$dat['ap_paterno_contacto'];
		$ap_materno_contacto=$dat['ap_materno_contacto'];
		$telefono_contacto=$dat['telefono_contacto'];
		$celular_contacto=$dat['celular_contacto'];
		$email_contacto=$dat['email_contacto'];
		$cargo_contacto=$dat['cargo_contacto'];
		$codestadoregistro=$dat['cod_estado_registro'];
		$cod_usuario_registro=$dat['cod_usuario_registro'];
		$fecha_registro=$dat['fecha_registro'];
					
	}
	
	$sql2="select nombre_cliente from clientes where cod_cliente=".$cod_cliente;
	$resp2= mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2)){
		$nombre_cliente=$dat2[0];
	}	


?>
<input type="hidden" name="cod_cliente" id="cod_cliente" value="<?php echo $cod_cliente;?>">
<h3 align="center" style="background:white;font-size: 14px;color:#E78611;font-weight:bold;">EDICION DE DATOS DE CONTACTO <br/> CLIENTE:<?PHP echo $nombre_cliente;?></h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Nombre</td>
      		<td><input type="text"  class="textoform" size="55" name="nombre_contacto" id="nombre_contacto" value="<?php echo $nombre_contacto; ?>" ></td>
    	</tr>		
		 <tr bgcolor="#FFFFFF">
     		<td>Apellido Paterno</td>
      		<td><input type="text"  class="textoform" size="55" name="ap_paterno_contacto" id="ap_paterno_contacto" value="<?php echo $ap_paterno_contacto;?>" ></td>
    	</tr>	
		 <tr bgcolor="#FFFFFF">
     		<td>Apellido Materno</td>
      		<td><input type="text"  class="textoform" size="55" name="ap_materno_contacto" id="ap_materno_contacto" value="<?php echo $ap_materno_contacto;?>" ></td>
    	</tr>	
		 <tr bgcolor="#FFFFFF">
     		<td>Cargo</td>
      		<td><input type="text"  class="textoform" size="55" name="cargo_contacto" id="cargo_contacto" value="<?php echo $cargo_contacto; ?>" ></td>
    	</tr>	                
							
		 <tr bgcolor="#FFFFFF">
     		<td>Telefono</td>
      		<td ><input type="text"  class="textoform" size="55" name="telefono_contacto" value="<?php echo $telefono_contacto;?>" ></td>
    	</tr>			
		
		 <tr bgcolor="#FFFFFF">
     		<td>Celular</td>
      		<td ><input type="text"  class="textoform" size="55" name="celular_contacto" value="<?php echo $celular_contacto;?>" ></td>
    	</tr>			
		 <tr bgcolor="#FFFFFF">
	   		<td>Email</td>
      		<td ><input type="text"  class="textoform" size="55" name="email_contacto" value="<?php echo $email_contacto; ?>" ></td>
    	</tr>										
		 <tr bgcolor="#FFFFFF">
   			<td>Estado</td>
      		<td><select name="cod_estado_registro" class="textoform">
				<?php
					$sql2="select cod_estado_registro,nombre_estado_registro from estados_referenciales order by cod_estado_registro desc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_estado_registro=$dat2[0];	
			  		 		$nombre_estado_registro=$dat2[1];	
				 ?>
				 <?php if($cod_estado_registro==$codestadoregistro){?> 
					 <option value="<?php echo $cod_estado_registro;?>" selected="selected"><?php echo $nombre_estado_registro;?></option>				
 				 <?php }else{?> 
					 <option value="<?php echo $cod_estado_registro;?>"><?php echo $nombre_estado_registro;?></option>				
				 <?php }?> 				 
				<?php		
					}
				?>						
			</select>
			</td>
    	</tr>	
		

	</table>	

<br>
<div align="center">
	<input type="button" class="boton" name="btn_guardar" value="GUARDAR CAMBIOS" onClick="guardar(this.form);"  >
	<input type="reset"  class="boton"  name="btn_cancelar" value="IR A LISTADO DE CONTACTOS" onClick="cancelar(this.form)"  >
</div>
</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>

