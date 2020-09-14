<?php header("Cache-Control: no-store, no-cache, must-revalidate");?>
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
$codproveedor=$_GET['cod_proveedor'];
?>

			
			<select name="cod_proveedor" id="cod_proveedor" class="textoform" >
				<option value="0">Seleccione un Proveedor</option>
				<?php
					$sql2="select cod_proveedor, nombre_proveedor";
	            	$sql2.=" from proveedores ";
    	        	$sql2.=" order by nombre_proveedor asc ";
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$cod_proveedor=$dat2['cod_proveedor'];
						$nombre_proveedor=$dat2['nombre_proveedor'];
				 ?>
				 <?php if($codproveedor==$cod_proveedor){?>
					 <option value="<?php echo $cod_proveedor;?>" selected="selected"><?php echo $nombre_proveedor;?></option>		
				 <?php }else{?>
 					 <option value="<?php echo $cod_proveedor;?>"><?php echo $nombre_proveedor;?></option>		
				 <?php }?>		
				<?php		
					}
				?>						
			</select>
			<a  href="javascript:cargar_proveedor();">[ Nuevo Proveedor]</a>
			&nbsp;<a  href="javascript:datosProveedor(this.form)"> [Editar Datos Proveedor]</a>
</body>
</html>
