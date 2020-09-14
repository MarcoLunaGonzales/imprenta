<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SISTEMA DE GESTION</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
			if(f.nombre_proveedor.value==""){
			 	alert('El campo Proveedor se encuentra vacio.'); 
			 	f.nombre_proveedor.focus();
		 	 	return(false);
			}
			if(f.cod_ciudad.value==0){
			 	alert('Seleccione Ciudad.'); 
			 	f.cod_ciudad.focus();
		 	 	return(false);
			}
			/*var i;
			var j=0;
			datos=new Array();
			for(i=0;i<=f.length-1;i++)
			{
				if(f.elements[i].type=='checkbox')
				{	if(f.elements[i].checked==true)
					{	datos[j]=f.elements[i].value;
						j=j+1;
					}
				}
			}	
			f.datos_grupos.value=datos;*/
		f.submit();
	}		
	
	function cancelar(f)
	{	
			window.close();
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<!---Autor:Gabriela Quelali Si�ani
	02 de Julio de 2008
-->
<form   method="post" action="guardaRegistrarProveedorAjax.php">
<input type="hidden" name="datos_grupos">
<?php 	
	require("conexion.inc");

	$sql2="select nombre_estado_registro from estados_referenciales where cod_estado_registro=1";
	$resp2= mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2)){
		$nombre_estado_registro=$dat2[0];
	}	
?>
<h3 align="center" style="background:white;font-size: 14px;color:#E78611;font-weight:bold;">REGISTRO PROVEEDOR</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
	<tbody>

		  <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Proveedor</td>
      		<td><input type="text"  class="textoform" size="55" name="nombre_proveedor" ></td>
    	</tr>		
		 <tr bgcolor="#FFFFFF">
     		<td>Nit</td>
      		<td><input type="text"  class="textoform" size="55" name="nit_proveedor" ></td>
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
				 ?><option value="<?php echo $cod_ciudad;?>"><?php echo $desc_ciudad;?></option>				
				<?php		
					}
				?>						
			</select>			</td>
    	</tr>	
		 <tr bgcolor="#FFFFFF">
     		<td>Direcci&oacute;n</td>
      		<td><input type="text"  class="textoform" size="55" name="direccion_proveedor" ></td>
    	</tr>						
		 <tr bgcolor="#FFFFFF">
     		<td>Telefono</td>
      		<td ><input type="text"  class="textoform" size="55" name="telefono_proveedor" ></td>
    	</tr>			
		 <tr bgcolor="#FFFFFF">
     		<td>Fax</td>
      		<td ><input type="text"  class="textoform" size="55" name="fax_proveedor" ></td>
    	</tr>			
		 <tr bgcolor="#FFFFFF">
     		<td>Celular</td>
      		<td ><input type="text"  class="textoform" size="55" name="celular_proveedor" ></td>
    	</tr>			
		 <tr bgcolor="#FFFFFF">
	   		<td>Email</td>
      		<td ><input type="text"  class="textoform" size="55" name="mail_proveedor" ></td>
    	</tr>							
		 <tr bgcolor="#FFFFFF">
   			<td>Estado</td>
      		<td><?php echo $nombre_estado_registro;?></td>
    	</tr>		
		 <tr bgcolor="#FFFFFF">
   			<td>Observaciones</td>
      		<td ><textarea cols="55" name="obs_proveedor" rows="3" class="textoform"> </textarea></td>
    	</tr>			
		<!--tr class="titulo_tabla">
		   <td  colSpan="2" align="center">MATERIAL QUE PROVEE</td>
		 </tr>		
		 <tr class="titulo_tabla">
		   <td  colSpan="2" >
		   <table  width="100%">
		   	<?php
					$sql="select cod_grupo, nombre_grupo";
					$sql.=" from grupos  where cod_estado_registro=1";
					$sql.=" order by nombre_grupo asc ";
					$resp = mysql_query($sql);
					while($dat=mysql_fetch_array($resp)){						
						$cod_grupo=$dat[0];
						$nombre_grupo=$dat[1];
			?> 
				<tr bgcolor="#FFFFFF">	
					<td align="right"><input type="checkbox"name="cod_grupo"value="<?php echo $cod_grupo;?>"></td>	
								
    				<td colspan="left"><?php echo $nombre_grupo;?></td>				
		    	 </tr>
<?php
		 		} 
?>	
		   </table>
		   </td>
		 </tr-->	
		 	
		</tbody>
	</table>	

<br>
<div align="center">
	<input type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
	<input type="reset"  class="boton"  name="btn_limpiar" value="Limpiar" >
	<input type="reset"  class="boton"  name="btn_cancelar" value="Cancelar" onClick="cancelar(this.form)"  >
</div>
</form>
</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>
