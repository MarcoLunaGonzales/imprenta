<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Registro de Almacen</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
			if(f.nombre_almacen.value==""){
			 	alert('El campo Almacen se encuentra vacio.'); 
			 	f.nombre_almacen.focus();
		 	 	return(false);
			}
			if(f.cod_sucursal.value==0){
			 	alert('Seleccione una Sucursal.'); 
			 	f.cod_sucursal.focus();
		 	 	return(false);
			}
				
		
		f.submit();
	}	
	function cancelar(f){
		window.location="navegadorAlmacenes.php";
	}		
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Si�ani
	02 de Julio de 2008
-->
<form   method="post" action="guardaRegistrarAlmacen.php">
<?php 	require("conexion.inc");

	$sql2="select nombre_estado_registro from estados_referenciales where cod_estado_registro=1";
	$resp2= mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2)){
		$nombre_estado_registro=$dat2[0];
	}	
?>
<h3 align="center" style="background:white;font-size: 14px;color:#E78611;font-weight:bold;">Registro de Almacen </h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
	<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Almacen</td>
      		<td><input type="text"  class="textoform" size="55" name="nombre_almacen" ></td>
    	</tr>		


		 <tr bgcolor="#FFFFFF">
     		<td>Sucursal</td>
      		<td>
			<select name="cod_sucursal" class="textoform">				
				<?php
					$sql2="select cod_sucursal, nombre_sucursal from sucursales ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_sucursal=$dat2[0];	
			  		 		$nombre_sucursal=$dat2[1];	
				 ?><option value="<?php echo $cod_sucursal;?>"><?php echo $nombre_sucursal;?></option>				
				<?php		
					}
				?>						
			</select>			</td>
    	</tr>	
	
		 				
		 <tr bgcolor="#FFFFFF">
   			<td>Estado</td>
      		<td><?php echo $nombre_estado_registro;?></td>
    	</tr>				
		</tbody>
	</table>	

<br>
<div align="center">
	<input type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
	<input type="reset"  class="boton"  name="btn_limpiar" value="Limpiar" >
	<input type="reset"  class="boton"  name="btn_cancelar" value="Atras" onClick="cancelar(this.form);"  >
</div>
</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>
