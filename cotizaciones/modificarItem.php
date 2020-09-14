<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>Edición de Item</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
		if(f.desc_item.value==""){
			alert("El campo Caracteristica se encuentra vacio.")
			f.desc_item.focus();
		 	return(false);
			
		}
		if(confirm("Esta seguro de modificar.")){
			f.submit();
		}else{
			return(false);
		}
	}	
	function cancelar(){
			window.location="navegadorItems.php";
	}

</script>

</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="guardaModificarItem.php" accept-charset="UTF-8">
<?php 
	require("conexion.inc");
	
	$cod_item=$_GET['cod_item'];
	
	$sql=" select desc_item, cod_estado_registro ";
	$sql.=" from items where cod_item='".$cod_item."'";
    $resp= mysql_query($sql);	
	$dat=mysql_fetch_array($resp);
	$desc_item=$dat[0];
	$codestadoregistro=$dat[1];		

?>
<input type="hidden" name="cod_item" value="<?php echo $cod_item;?>">
<input type="hidden" name="datos" >
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">EDICI&Oacute;N DE ITEM </h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">

		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Item</td>
      		<td><input type="text"  class="textoform" size="50" name="desc_item"  value="<?php echo $desc_item;?>"></td>
    	</tr>
		<tr bgcolor="#FFFFFF">
     		<td>Estado de Registro</td>
      		<td>
			<select name="cod_estado_registro" class="textoform">
				<?php
					$sql_2="select cod_estado_registro,nombre_estado_registro from estados_referenciales  ";
					$resp_2= mysql_query($sql_2);
					while($dat_2=mysql_fetch_array($resp_2)){	
			  		 	$cod_estado_registro= $dat_2[0];
    					$nombre_estado_registro=$dat_2[1];
				 ?>
				 	<?php if($cod_estado_registro==$codestadoregistro){?>
					
				 		<option value="<?php echo $cod_estado_registro;?>" selected><?php echo $nombre_estado_registro;?></option>				
					<?php }else{?>
						<option value="<?php echo $cod_estado_registro;?>"><?php echo $nombre_estado_registro;?></option>				
					<?php } ?>
				<?php		
					}
				?>						
			</select>			</td>
    	</tr>				
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
