<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Datos de Proveedor</title>
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
			var i;
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
			f.datos_grupos.value=datos;
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
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="guardadatosProveedorAjax.php">
<input type="hidden" name="datos_grupos">
<?php 
	require("conexion.inc");

	$cod_proveedor=$_GET['cod_proveedor'];

		$sql="select  nombre_proveedor,telefono_proveedor,mail_proveedor,direccion_proveedor, cod_ciudad,";
		$sql.=" contacto1_proveedor, cel_contacto1_proveedor,contacto2_proveedor, cel_contacto2_proveedor, cod_estado_registro";
		$sql.=" from proveedores ";
		$sql.=" where cod_proveedor='".$cod_proveedor."'";
		$resp = mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){	
		
				$nombre_proveedor=$dat[0];
				$telefono_proveedor=$dat[1];
				$mail_proveedor=$dat[2];
				$direccion_proveedor=$dat[3];
				$codciudad=$dat[4];
				$contacto1_proveedor=$dat[5]; 
				$cel_contacto1_proveedor=$dat[6];
				$contacto2_proveedor=$dat[7];
				$cel_contacto2_proveedor=$dat[8];
				$codestadoregistro=$dat[9];
		
		}
?>
<input type="hidden" name="cod_proveedor" value="<?php echo $cod_proveedor;?>">
<h3 align="center" style="background:white;font-size: 14px;color:#E78611;font-weight:bold;">Edici&oacute;n de Proveedor </h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
	<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Proveedor</td>
      		<td>
			<input type="text"  class="textoform" size="55" name="nombre_proveedor" value="<?php echo $nombre_proveedor;?>">
			</td>
    	</tr>		

		 <tr bgcolor="#FFFFFF">
     		<td>Ciudad</td>
      		<td>
			<select name="cod_ciudad" class="textoform">				
				<?php
					$sql2="select cod_ciudad, desc_ciudad from ciudades  order by  desc_ciudad asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_ciudad=$dat2[0];	
			  		 		$desc_ciudad=$dat2[1];	
				 ?>
				 <option value="<?php echo $cod_ciudad;?>" <?php if($cod_ciudad==$codciudad){echo "selected='selected'";}?>><?php echo $desc_ciudad;?></option>				
				<?php		
					}
				?>						
			</select>			
			</td>
    	</tr>	
		 <tr bgcolor="#FFFFFF">
     		<td>Direccion</td>
      		<td><input type="text"  class="textoform" size="55" name="direccion_proveedor"  value="<?php echo $direccion_proveedor;?>"></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Mail</td>
      		<td><input type="text"  class="textoform" size="55" name="mail_proveedor" value="<?php echo $mail_proveedor;?>"></td>
    	</tr>	
		 <tr bgcolor="#FFFFFF">
     		<td>Telefono</td>
      		<td><input type="text"  class="textoform" size="55" name="telefono_proveedor" value="<?php echo $telefono_proveedor;?>"></td>
    	</tr>						
		 <tr bgcolor="#FFFFFF">
     		<td>Contacto 1</td>
      		<td><input type="text"  class="textoform" size="55" name="contacto1_proveedor" value="<?php echo $contacto1_proveedor;?>" ></td>
    	</tr>			
		 <tr bgcolor="#FFFFFF">
     		<td>Celular Contacto 1</td>
      		<td><input type="text"  class="textoform" size="55" name="cel_contacto1_proveedor" value="<?php echo $cel_contacto1_proveedor;?>" ></td>
    	</tr>	
		 <tr bgcolor="#FFFFFF">
     		<td>Contacto 2</td>
      		<td><input type="text"  class="textoform" size="55" name="contacto2_proveedor" value="<?php echo $contacto2_proveedor;?>" ></td>
    	</tr>			
		 <tr bgcolor="#FFFFFF">
     		<td>Celular Contacto 2</td>
      		<td><input type="text"  class="textoform" size="55" name="cel_contacto2_proveedor"  value="<?php echo $cel_contacto2_proveedor;?>"></td>
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
		<tr class="titulo_tabla">
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
						
						$sql2=" select count(*) from proveedores_grupos";
						$sql2.=" where cod_proveedor='".$cod_proveedor."'";
						$sql2.=" and cod_grupo='".$cod_grupo."'";
						
						$resp2 = mysql_query($sql2);
						$dat2=mysql_fetch_array($resp2);
						$sw=$dat2[0];
			?> 
				<tr bgcolor="#FFFFFF">	
					<td align="right"><input type="checkbox"name="cod_grupo"<?php if($sw==1){echo "checked='checked'";}?> value="<?php echo $cod_grupo;?>"></td>	
								
    				<td align="left"><?php echo $nombre_grupo;?></td>				
		    	 </tr>
<?php
		 		} 
?>	
		   </table>
		   </td>
		 </tr>	
		 	
		</tbody>
	</table>	

<br><div align="center">
	<input type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
	<input type="reset"  class="boton"  name="btn_cancelar" value="Cancelar" onClick="cancelar(this.form)"  >
</div>
</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>

