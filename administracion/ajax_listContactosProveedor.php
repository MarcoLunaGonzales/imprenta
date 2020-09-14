<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<link rel="STYLESHEET" type="text/css" href="pagina.css" />

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Octubre de 2008
-->

<?php require("conexion.inc");
$cod_proveedor=$_GET['cod_proveedor'];

?>
<select name="cod_contacto_proveedor" id="cod_contacto_proveedor" class="textoform" >
				<option value="0">------------</option>
				<?php
					$sql2="select cod_contacto_proveedor, nombre_contacto, ap_paterno_contacto, ap_materno_contacto";
					$sql2.=" from proveedores_contactos";
					$sql2.=" where cod_proveedor=".$_GET['cod_proveedor'];
					$sql2.=" order by  ap_paterno_contacto asc,nombre_contacto asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_contacto_proveedor=$dat2['cod_contacto_proveedor'];	
							$nombre_contacto=$dat2['nombre_contacto'];	
							$ap_paterno_contacto=$dat2['ap_paterno_contacto'];	
							$ap_materno_contacto=$dat2['ap_materno_contacto'];	

				 ?>

 					 <option value="<?php echo $cod_contacto_proveedor;?>"><?php echo $ap_paterno_contacto." ".$ap_materno_contacto." ".$nombre_contacto;?></option>		
	
				<?php		
					}
				?>						
			</select>
			<a  href="javascript:cargar_contactoProveedor();">[ Nuevo Contacto]</a>
			&nbsp;<a  href="javascript:datosContactoProveedor(this.form)"> [Datos Contacto]</a>
</body>
</html>
