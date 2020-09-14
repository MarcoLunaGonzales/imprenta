<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Editar Banco</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
			if(f.desc_banco.value==""){
			 	alert('El campo Banco se encuentra vacio.'); 
			 	f.desc_banco.focus();
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
<form   method="post" action="guardaEditarBanco.php">
<?php 	require("conexion.inc");
	$cod_banco=$_GET['cod_banco'];
		
		$sql=" select desc_banco,  cod_estado_registro, ";
		$sql.=" cod_usuario_registro, fecha_registro, cod_usuario_modifica, fecha_modifica ";
		$sql.=" from bancos ";
		$sql.=" where cod_banco=".$_GET['cod_banco'];	
		//echo $sql;
		$resp = mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){	
		
				$desc_banco=$dat[0];
				$codestadoregistro=$dat[1];
				$cod_usuario_registro=$dat[2];
				$fecha_registro=$dat[3];				
				$cod_usuario_modifica=$dat[4];
				$fecha_modifica=$dat[5];
		}		
	
?>
<input type="hidden" name="cod_banco" value="<?php echo $cod_banco;?>">
<h3 align="center" style="background:white;font-size: 14px;color:#E78611;font-weight:bold;">EDICION DE BANCO</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Banco</td>
      		<td><input type="text"  class="textoform" size="55" name="desc_banco" value="<?php echo $desc_banco;?>" ></td>
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
	</table>	

<br>
<div align="center">
	<input type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
	<input type="reset"  class="boton"  name="btn_limpiar" value="Limpiar" >
	<input type="button"  class="boton"  name="btn_cancelar" value="Cancelar" onClick="javascript:history.back(-1);"  >
</div>
</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>
