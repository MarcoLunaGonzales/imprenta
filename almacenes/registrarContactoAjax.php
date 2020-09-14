<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Registro Contacto - Cliente</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
</head>


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
					
			
		
		f.submit();
	}	
	
	function cancelar(f)
	{	
			window.close();
	}
</script>

<body>
<!---Autor:Gabriela Quelali Si?ani
	02 de Julio de 2008
-->
<form   method="post" action="guardaRegistrarContactoAjax.php">
<input type="hidden" name="cod_cliente" id="cod_cliente" value="<?php echo $_GET['cod_cliente'];?>">

<?php 	require("conexion.inc");

	$sql2="select nombre_cliente from clientes where cod_cliente=".$_GET['cod_cliente'];
	$resp2= mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2)){
		$nombre_cliente=$dat2[0];
	}	

	$sql2="select nombre_estado_registro from estados_referenciales where cod_estado_registro=1";
	$resp2= mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2)){
		$nombre_estado_registro=$dat2[0];
	}	
?>
<h3 align="center" style="background:white;font-size: 14px;color:#E78611;font-weight:bold;">REGISTRO DE CONTACTO DE <?PHP echo $nombre_cliente;?></h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Nombre</td>
      		<td><input type="text"  class="textoform" size="55" name="nombre_contacto" id="nombre_contacto" ></td>
    	</tr>		
		 <tr bgcolor="#FFFFFF">
     		<td>Apellido Paterno</td>
      		<td><input type="text"  class="textoform" size="55" name="ap_paterno_contacto" id="ap_paterno_contacto" ></td>
    	</tr>	
		 <tr bgcolor="#FFFFFF">
     		<td>Apellido Materno</td>
      		<td><input type="text"  class="textoform" size="55" name="ap_materno_contacto" id="ap_materno_contacto" ></td>
    	</tr>	
		 <tr bgcolor="#FFFFFF">
     		<td>Cargo</td>
      		<td><input type="text"  class="textoform" size="55" name="cargo_contacto" id="cargo_contacto" ></td>
    	</tr>	                
							
		 <tr bgcolor="#FFFFFF">
     		<td>Telefono</td>
      		<td ><input type="text"  class="textoform" size="55" name="telefono_contacto" ></td>
    	</tr>			
		
		 <tr bgcolor="#FFFFFF">
     		<td>Celular</td>
      		<td ><input type="text"  class="textoform" size="55" name="celular_contacto" ></td>
    	</tr>			
		 <tr bgcolor="#FFFFFF">
	   		<td>Email</td>
      		<td ><input type="text"  class="textoform" size="55" name="email_contacto" ></td>
    	</tr>							
		 <tr bgcolor="#FFFFFF">
   			<td>Estado</td>
      		<td><select name="cod_estado_registro" class="textoform">
				<?php
					$sql2="select cod_estado_registro,nombre_estado_registro from estados_referenciales order by cod_estado_registro asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_estado_registro=$dat2[0];	
			  		 		$nombre_estado_registro=$dat2[1];	
				 ?><option value="<?php echo $cod_estado_registro;?>"><?php echo $nombre_estado_registro;?></option>				
				<?php		
					}
				?>						
			</select>			</td>
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
