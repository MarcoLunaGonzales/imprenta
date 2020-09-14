<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Registro de Usuario</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
		if(f.nombre_usuario.value==""){
			alert("El campo Nombres se encuentra vacio.")
			f.nombre_usuario.focus();
		 	return(false);			
		}
		if(f.ap_paterno_usuario.value=="" && f.ap_materno_usuario.value==""){
			alert("Al menos debe llenar un Apellido.")
			f.ap_paterno_usuario.focus();
		 	return(false);			
		}		
		if(f.usuario.value==""){
			alert("El campo Usuario se encuentra vacio.")
			f.usuario.focus();
		 	return(false);			
		}
		if(f.password.value==""){
			alert("El campo Password se encuentra vacio.")
			f.password.focus();
		 	return(false);			
		}		
		
		f.submit();
	}	
	function cancelar(){
			window.location="navegador_usuarios.php";
	}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="guarda_registrar_usuario.php">
<?php 
	require("conexion.inc");
	$cod_estado_registro=1;
	$sql2=" select nombre_estado_registro from estados_referenciales where cod_estado_registro='".$cod_estado_registro."'";
    $resp2 = mysql_query($sql2);	
	$nombre_estado_registro="";
	$dat2=mysql_fetch_array($resp2);
	$nombre_estado_registro=$dat2[0];

?>
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">Registro de Usuario </h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Introduzca Datos</td>
		 </tr>	
		 <tr bgcolor="#FFFFFF">
     		<td>Nombres</td>
      		<td><input type="text"  class="textoform" size="50" name="nombre_usuario" ></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Apellido Paterno</td>
      		<td><input type="text"  class="textoform" size="50" name="ap_paterno_usuario" ></td>
    	</tr>

		 <tr bgcolor="#FFFFFF">
     		<td>Apellido Materno</td>
      		<td><input type="text"  class="textoform" size="50" name="ap_materno_usuario" ></td>
    	</tr>

		 <tr bgcolor="#FFFFFF">
     		<td>Grado Academico</td>
      		<td>
			<select name="cod_grado" class="textoform">
				<?php
					$sql_2="select cod_grado,nombre_grado from grados order by nombre_grado asc  ";
					$resp_2= mysql_query($sql_2);
					while($dat_2=mysql_fetch_array($resp_2)){	
			  		 	$cod_grado= $dat_2[0];
    					$nombre_grado=$dat_2[1];
				 ?>
						<option value="<?php echo $cod_grado;?>"><?php echo $nombre_grado;?></option>				

				<?php		
					}
				?>						
			</select>
			</td>
    	</tr>	
				
		 <tr bgcolor="#FFFFFF">
     		<td>Cargo</td>
      		<td>
			<select name="cod_cargo" class="textoform">
				<?php
					$sql_2="select cod_cargo,nombre_cargo from cargos order by nombre_cargo asc  ";
					$resp_2= mysql_query($sql_2);
					while($dat_2=mysql_fetch_array($resp_2)){	
			  		 	$cod_cargo= $dat_2[0];
    					$nombre_cargo=$dat_2[1];
				 ?>
						<option value="<?php echo $cod_cargo;?>"><?php echo $nombre_cargo;?></option>				

				<?php		
					}
				?>						
			</select>
			</td>
    	</tr>	
						
		 <tr bgcolor="#FFFFFF">
     		<td>Usuario</td>
      		<td><input type="text"  class="textoform" size="50" name="usuario" ></td>
    	</tr>

		 <tr bgcolor="#FFFFFF">
     		<td>Contraseña</td>
      		<td><input type="text"  class="textoform" size="50" name="password" ></td>
    	</tr>
		
		<tr bgcolor="#FFFFFF">
     		<td>Estado de Registro</td>
      		<td><?php echo $nombre_estado_registro;?></td>
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
