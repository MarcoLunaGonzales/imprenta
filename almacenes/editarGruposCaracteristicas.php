<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Edicion de Caracteristicas de Grupo</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
		if(f.nombre_grupo_carac.value==""){
			alert("El campo Caracteristica se encuentra vacio.")
			f.nombre_grupo_carac.focus();
		 	return(false);
			
		}
		if(f.orden.value==""){
			alert("El campo Orden se encuentra vacio.")
			f.orden..focus();
		 	return(false);
			
		}
		f.submit();
	}	
	function cancelar(f){
		window.location="navegadorGruposCaracteristicas.php?cod_grupo="+f.cod_grupo.value;
	}

</script>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form  name="form1" method="post" action="guardaEditarGruposCaracteristicas.php" accept-charset="UTF-8">
<?php 
	require("conexion.inc");
	
	$cod_grupo_carac=$_GET['cod_grupo_carac'];
	
	$sql=" select cod_grupo, nombre_grupo_carac,orden, cod_estado_registro, ";
	$sql.=" cod_usuario_registro, fecha_registro, cod_usuario_modifica, fecha_modifica ";
	$sql.=" from grupos_caracteristicas ";
	$sql.=" where cod_grupo_carac='".$cod_grupo_carac."'";
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){	
		
				$cod_grupo=$dat[0];
				$nombre_grupo_carac=$dat[1]; 
				$orden=$dat[2]; 
				$codestadoregistro=$dat[3];
				$cod_usuario_registro=$dat[4];
				$fecha_registro=$dat[5];
				$cod_usuario_modifica=$dat[6];
				$fecha_modifica=$dat[7];	
	}	
	
	$sql="select nombre_grupo from grupos where cod_grupo=".$cod_grupo;
	$resp = mysql_query($sql);
	$nombre_grupo="";
	if($dat=mysql_fetch_array($resp)){
		$nombre_grupo=$dat[0];
	}	
	


?>
<input type="hidden" name="cod_grupo" value="<?php echo $cod_grupo ;?>">
<input type="hidden" name="cod_grupo_carac" value="<?php echo $cod_grupo_carac ;?>">
<h3 align="center" style="background:white;font-size: 14px;color: #E78611;font-weight:bold;">Edici&oacute;n de Caracteristica</h3>

<div align="center"><b>Grupo&nbsp;::&nbsp;</b><?php echo $nombre_grupo;?></div><br>
	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">

		 <tr class="titulo_tabla">
		   <td  colSpan="3" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td width="19%">Caracteristica</td>
      		<td colspan="2"><input type="text"  class="textoform" size="50" name="nombre_grupo_carac" value="<?php echo $nombre_grupo_carac; ?>" ></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td width="19%">Orden</td>
      		<td colspan="2"><input type="text"  class="textoform" size="40" name="orden" value="<?php echo $orden; ?>" ></td>
    	</tr>			
		<tr bgcolor="#FFFFFF">
     		<td>Estado de Registro</td>
      		<td colspan="2">			
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
	</table>
	<br>
<div align="center">
	<INPUT type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
	<INPUT type="button"  class="boton"  name="btn_limpiar" value="Atras" onClick="cancelar(this.form);"  >
</div>

</form>
<?php require("cerrar_conexion.inc");?>
</body>
</html>

