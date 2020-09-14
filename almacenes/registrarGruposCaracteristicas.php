<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Registro de Caracteristicas de Grupo</title>
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
<form  name="form1" method="post" action="guardaRegistrarGruposCaracteristicas.php" accept-charset="UTF-8">
<?php 
	require("conexion.inc");
	
	$cod_grupo=$_POST['cod_grupo'];
	
	$sql="select nombre_grupo from grupos where cod_grupo=".$cod_grupo;
	$resp = mysql_query($sql);
	$nombre_grupo="";
	if($dat=mysql_fetch_array($resp)){
		$nombre_grupo=$dat[0];
	}	
	
	$cod_estado_registro=1;
	
	$sql2=" select nombre_estado_registro from estados_referenciales where cod_estado_registro='".$cod_estado_registro."'";
    $resp2 = mysql_query($sql2);	
	$nombre_estado_registro="";
	$dat2=mysql_fetch_array($resp2);
	$nombre_estado_registro=$dat2[0];

?>
<input type="hidden" name="cod_grupo" value="<?php echo $cod_grupo ;?>">
<h3 align="center" style="background:white;font-size: 14px;color: #E78611;font-weight:bold;">Registro de Caracteristica de Grupo </h3>

<div align="center"><b>Grupo&nbsp;::&nbsp;</b><?php echo $nombre_grupo;?></div><br>
	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">

		 <tr class="titulo_tabla">
		   <td  colSpan="3" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td width="19%">Caracteristica</td>
      		<td colspan="2"><input type="text"  class="textoform" size="40" name="nombre_grupo_carac" ></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td width="19%">Orden</td>
      		<td colspan="2"><input type="text"  class="textoform" size="40" name="orden" ></td>
    	</tr>		
		<tr bgcolor="#FFFFFF">
     		<td>Estado de Registro</td>
      		<td colspan="2"><?php echo $nombre_estado_registro;?></td>
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

