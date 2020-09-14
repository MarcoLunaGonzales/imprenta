<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Edici&oacute;n de Usuario</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
			if(f.nombres_usuario.value==""){
			 	alert('El campo Nombre se encuentra vacio.'); 
			 	f.nombres_usuario.focus();
		 	 	return(false);
			}
			
				
		
		f.submit();
	}	
</script>

</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="guardaEditarUsuario.php">
<?php 	require("conexion.inc");

 $cod_usuario=$_GET['cod_usuario'];
 
 		$sql=" select cod_cargo, cod_grado, usuario, contrasenia, nombres_usuario, ";
		$sql.=" ap_paterno_usuario,ap_materno_usuario, cod_estado_registro, usuario_interno, cod_perfil ";
		$sql.="from usuarios ";	
		$sql.=" where  cod_usuario=".$cod_usuario;
		$resp = mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){
		
				$codcargo=$dat[0];
				$codgrado=$dat[1];
				$usuario=$dat[2];
				$contrasenia=$dat[3];
				$nombres_usuario=$dat[4];
				$ap_paterno_usuario=$dat[5];
				$ap_materno_usuario=$dat[6];
				$codestadoregistro=$dat[7];
				$usuario_interno=$dat[8];
				$codperfil=$dat[9];
		}
		$autorizado_firma_cotizacion="";				
		$sql2="select count(*) from autorizados_firma_cotizacion";
		$sql2.=" where cod_usuario='".$cod_usuario."'";	
		$resp2= mysql_query($sql2);
		while($dat2=mysql_fetch_array($resp2)){
				$var=$dat2[0];
		}	
		if($var>0){
				$autorizado_firma_cotizacion=1;
		}

?>

<h3 align="center" style="background:white;font-size: 14px;color:#d20000;font-weight:bold;">Edici&oacute;n de Usuario </h3>

<input type="hidden" name="cod_usuario" value="<?php echo $cod_usuario;?>">
	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Nombres</td>
      		<td>
			<input type="text"  class="textoform" size="55" name="nombres_usuario" value="<?php echo $nombres_usuario;?>" ></td>
    	</tr>
		<tr bgcolor="#FFFFFF">
   			<td>Apellido Paterno</td>
      		<td>
			<input type="text"  class="textoform" size="55"name="ap_paterno_usuario" value="<?php echo $ap_paterno_usuario;?>">
			</td>
    	</tr>	
		<tr bgcolor="#FFFFFF">
   			<td>Apellido Materno</td>
      		<td>
			<input type="text"  class="textoform" size="55" name="ap_materno_usuario" value="<?php echo $ap_materno_usuario;?>" >
			</td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
   			<td>Cargo</td>
      		<td>
			<select name="cod_cargo" class="textoform">				
				<?php
					$sql2="select cod_cargo, desc_cargo from cargos ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_cargo=$dat2[0];	
			  		 		$desc_cargo=$dat2[1];	
				 ?><option value="<?php echo $cod_cargo;?>" <?php if($cod_cargo==$codcargo){echo "selected='selected'";}?>><?php echo $desc_cargo;?></option>				
				<?php		
					}
				?>						
			</select>
			</td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
   			<td>Grado Academico</td>
      		<td>
			<select name="cod_grado" class="textoform">				
				<?php
					$sql2="select cod_grado, desc_grado from grado_academico ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_grado=$dat2[0];	
			  		 		$desc_grado=$dat2[1];	
				 ?>
				 			<option value="<?php echo $cod_grado;?>"<?php if($cod_grado==$codgrado){echo "selected='selected'";}?>><?php echo $desc_grado;?></option>				
				<?php		
						}
				?>						
			</select>
			</td>
    	</tr>	
		 <tr bgcolor="#FFFFFF">
   			<td>Perfil</td>
      		<td>
			<select name="cod_perfil" class="textoform">
			<option value="">Seleccione una Opci&oacute;n</option>				
				<?php
					$sql2="select cod_perfil, nombre_perfil from perfiles ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_perfil=$dat2[0];	
			  		 		$nombre_perfil=$dat2[1];	
				 ?>
				 			<option value="<?php echo $cod_perfil;?>"<?php if($cod_perfil==$codperfil){echo "selected='selected'";}?>><?php echo $nombre_perfil;?></option>				
				<?php		
						}
				?>						
			</select>
			</td>
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
		 <tr bgcolor="#FFFFFF">
   			<td>Usuario Interno </td>
      		<td>SI
      		    <input type="radio" name="usuario_interno" value="1" <?php if($usuario_interno==1){echo "checked='true'";}?>>
      		    NO
      		    <input type="radio" name="usuario_interno" value="2" <?php if($usuario_interno==2){echo "checked='true'";}?>></td>
    	</tr>	
		<tr bgcolor="#FFFFFF">
   			<td>User</td>
      		<td><input type="text"  class="textoform" size="55" name="usuario" value="<?php echo $usuario;?>" ></td>
    	</tr>
		<tr bgcolor="#FFFFFF">
   			<td>Password</td>
      		<td><input type="text"  class="textoform" size="55" name="contrasenia" value="<?php echo $contrasenia;?>" ></td>
    	</tr>	
		<tr bgcolor="#FFFFFF">
   			<td>Autorizado Firma Cotizaci&oacute;n </td>
      		<td>SI
      		    <input type="radio" name="autorizado_firma_cotizacion" value="1" <?php if($autorizado_firma_cotizacion==1){echo "checked='true'";}?>>
      		    NO
      		    <input type="radio" name="autorizado_firma_cotizacion" value="2" <?php if($autorizado_firma_cotizacion==""){echo "checked='true'";}?>>
		</td>
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
