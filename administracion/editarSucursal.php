<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Edici&oacute;n de Sucursal</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
			if(f.nombre_sucursal.value==""){
			 	alert('El campo Sucursal se encuentra vacio.'); 
			 	f.nombre_sucursal.focus();
		 	 	return(false);
			}
			if(f.cod_ciudad.value==0){
			 	alert('Seleccione la Ciudad.'); 
			 	f.cod_ciudad.focus();
		 	 	return(false);
			}
			if(f.direccion_sucursal.value==""){
			 	alert('El campo Direccion se encuentra vacio.'); 
			 	f.direccion_sucursal.focus();
		 	 	return(false);
			}					
		
		f.submit();
	}	
		function cancelar(f){
		window.location="navegadorSucursales.php";
	}	
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="guardaEditarSucursal.php">
<?php 	
	require("conexion.inc");
	$cod_sucursal=$_GET['cod_sucursal'];
?>
<input type="hidden"  class="textoform" size="55" name="cod_sucursal" value="<?php echo $cod_sucursal;?>" >

<?php	

	$sql=" select nombre_sucursal, cod_ciudad,direccion_sucursal,";
	$sql.=" telf_sucursal, cod_estado_registro ";
	$sql.=" from sucursales ";
	$sql.=" where cod_sucursal=".$cod_sucursal;
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$nombre_sucursal =$dat[0];
		$codciudad=$dat[1];
		$direccion_sucursal=$dat[2];
		$telf_sucursal=$dat[3];
		$codestadoregistro=$dat[4];
					
	}		

?>
<h3 align="center" style="background:white;font-size: 14px;color:#E78611;font-weight:bold;">Edici&oacute;n de Sucursal</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
	<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Sucursal</td>
      		<td>
				<input type="text"  class="textoform" size="55" name="nombre_sucursal" value="<?php echo $nombre_sucursal;?>">
			</td>
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
			</select>			
			</td>
    	</tr>	
		 <tr bgcolor="#FFFFFF">
     		<td>Direcci&oacute;n</td>
      		<td>
			<input type="text"  class="textoform" size="55" name="direccion_sucursal" value="<?php echo $direccion_sucursal;?>">
			</td>
    	</tr>						
		 <tr bgcolor="#FFFFFF">
     		<td>Telefono</td>
      		<td>
			<input type="text"  class="textoform" size="55" name="telf_sucursal" value="<?php echo $telf_sucursal;?>">
			</td>
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
	<input type="reset"  class="boton"  name="btn_cancelar" value="Atras" onClick="cancelar(this.form);"  >
</div>
</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>
