<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Registro de Usuario</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
			if(f.nombres_usuario.value==""){
			 	alert('El campo Nombre se encuentra vacio.'); 
			 	f.nombres_usuario.focus();
		 	 	return(false);
			}
			if(f.ap_paterno_usuario.value==""){
			 	alert('El campo Apellido Paterno se encuentra vacio.'); 
			 	f.ap_paterno_usuario.focus();
		 	 	return(false);
			}
			if(f.ap_materno_usuario.value==""){
			 	alert('El campo Apellido Materno se encuentra vacio.'); 
			 	f.ap_materno_usuario.focus();
		 	 	return(false);
			}			
			if(f.fecha_nac_usuario.value==""){
			 	alert('Por favor llenar la Fecha de Nacimiento.'); 
			 	f.fecha_nac_usuario.focus();
		 	 	return(false);
			}
			
				
		
		f.submit();
	}	
</script>

</head>
<body bgcolor="#FFFFFF" >
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="guardaRegistrarUsuario.php">
<?php 	require("conexion.inc");

	$sql2="select nombre_estado_registro from estados_referenciales where cod_estado_registro=1";
	$resp2= mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2)){
		$nombre_estado_registro=$dat2[0];
	}	
?>
<h3 align="center" style="background:white;font-size: 14px;color:#E78611;font-weight:bold;">Registro de Usuario </h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Nombre</td>
      		<td><input type="text"  class="textoform" size="55" name="nombres_usuario"  id="nombres_usuario"></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Nombre 2</td>
      		<td><input type="text"  class="textoform" size="55" name="nombres_usuario2" id="nombres_usuario2" ></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Nombre de Pila</td>
      		<td><input type="text"  class="textoform" size="55" name="nombres_pila" id="nombres_pila" ></td>
    	</tr>                
		<tr bgcolor="#FFFFFF">
   			<td>Apellido Paterno</td>
      		<td><input type="text"  class="textoform" size="55" name="ap_paterno_usuario" id="ap_paterno_usuario" ></td>
    	</tr>	
		<tr bgcolor="#FFFFFF">
   			<td>Apellido Materno</td>
      		<td><input type="text"  class="textoform" size="55" name="ap_materno_usuario" id="ap_materno_usuario" ></td>
    	</tr>
		<tr bgcolor="#FFFFFF">
   			<td>Fecha de Nacimiento</td>
      		<td><input type="text"  class="textoform" size="10" maxlength="10" name="fecha_nac_usuario" id="fecha_nac_usuario" >(dd/mm/aaaa)</td>
    	</tr>        
		<tr bgcolor="#FFFFFF">
   			<td>Carnet de Identidad</td>
      		<td><input type="text"  class="textoform" size="55" name="ci_usuario" id="ci_usuario" ></td>
    	</tr>        
		 <tr bgcolor="#FFFFFF">
   			<td>Departamento</td>
      		<td>
			<select name="cod_ciudad" id="cod_ciudad"  class="textoform">				
				<?php
					$sql2="select cod_ciudad, desc_ciudad from ciudades  where cod_pais=1 order by desc_ciudad";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_ciudad=$dat2['cod_ciudad'];	
			  		 		$desc_ciudad=$dat2['desc_ciudad'];	
				 ?>
                 <option value="<?php echo $cod_ciudad;?>" <?php if($cod_ciudad==1){ ?> selected <?php } ?>><?php echo $desc_ciudad;?></option>				
				<?php		
					}
				?>						
			</select>
			</td>
    	</tr>
		<tr bgcolor="#FFFFFF">
   			<td>Telefono </td>
      		<td><input type="text"  class="textoform" size="55" name="telf_usuario" id="telf_usuario" ></td>
    	</tr>          
		 <tr bgcolor="#FFFFFF">
   			<td>Area</td>
      		<td>
			<select name="cod_area" id="cod_area" class="textoform">				
				<?php
					$sql2="select cod_area, nombre_area from areas  order by nombre_area";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_area=$dat2['cod_area'];	
			  		 		$nombre_area=$dat2['nombre_area'];	
				 ?><option value="<?php echo $cod_area;?>"><?php echo $nombre_area;?></option>				
				<?php		
					}
				?>						
			</select>
			</td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
   			<td>Cargo</td>
      		<td>
			<select name="cod_cargo" id="cod_cargo" class="textoform">				
				<?php
					$sql2="select cod_cargo, desc_cargo from cargos order by desc_cargo ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_cargo=$dat2[0];	
			  		 		$desc_cargo=$dat2[1];	
				 ?><option value="<?php echo $cod_cargo;?>"><?php echo $desc_cargo;?></option>				
				<?php		
					}
				?>						
			</select>
			</td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
   			<td>Grado Academico</td>
      		<td>
			<select name="cod_grado" id="cod_grado" class="textoform">				
				<?php
					$sql2="select cod_grado, desc_grado from grado_academico ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_grado=$dat2[0];	
			  		 		$desc_grado=$dat2[1];	
				 ?>
				 			<option value="<?php echo $cod_grado;?>"><?php echo $desc_grado;?></option>				
				<?php		
						}
				?>						
			</select>
			</td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
   			<td>Perfil</td>
      		<td>
			<select name="cod_perfil" id="cod_perfil" class="textoform">
				<option value="">Seleccione una Opci&oacute;n</option>					
				<?php
					$sql2="select cod_perfil, nombre_perfil from perfiles ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_perfil=$dat2[0];	
			  		 		$nombre_perfil=$dat2[1];	
				 ?>
				 			<option value="<?php echo $cod_perfil;?>"><?php echo $nombre_perfil;?></option>				
				<?php		
						}
				?>						
			</select>
			</td>
    	</tr>													
		 <tr bgcolor="#FFFFFF">
   			<td>Usuario Interno </td>
      		<td>SI
      		    <input type="radio" name="usuario_interno" value="1" checked="true">
      		    NO
      		    <input type="radio" name="usuario_interno" value="2"></td>
    	</tr>	
		<tr bgcolor="#FFFFFF">
   			<td>User</td>
      		<td><input type="text"  class="textoform" size="55" name="usuario" id="usuario" ></td>
    	</tr>
		<tr bgcolor="#FFFFFF">
   			<td>Password</td>
      		<td><input type="text"  class="textoform" size="55" name="contrasenia" id="contrasenia" ></td>
    	</tr>
		<tr bgcolor="#FFFFFF">
   			<td>Autorizado Firma Cotizaci&oacute;n </td>
      		<td>SI
      		    <input type="radio" name="autorizado_firma_cotizacion" value="1" >
      		    NO
      		    <input type="radio" name="autorizado_firma_cotizacion" value="2" checked="true"></td>
    	</tr>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">M&Oacute;DULOS</td>
		 </tr> 
		   	<?php
					$sql="select cod_modulo, nombre_modulo";
					$sql.=" from modulos  ";
					$sql.=" order by nombre_modulo asc ";
					$resp = mysql_query($sql);
					while($dat=mysql_fetch_array($resp)){						
						$cod_modulo=$dat['cod_modulo'];
						$nombre_modulo=$dat['nombre_modulo'];
			?> 
				<tr bgcolor="#FFFFFF">	
					<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp; 
                    <input type="checkbox"name="cod_modulo<?php echo $cod_modulo;?>" value="<?php echo $cod_modulo;?>" id="cod_modulo<?php echo $cod_modulo;?>">&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $nombre_modulo;?></td>				
		    	 </tr>
<?php
		 		} 
?>	      				
	</table>	

<br>
<div align="center">
	<input type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
	<input type="reset"  class="boton"  name="btn_limpiar" value="Limpiar" >
	<input type="button"  class="boton"  name="btn_cancelar" value="Atras" onClick="javascript:history.back(-1);"  >
</div>
</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>
