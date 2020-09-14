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
$cod_cliente=$_GET['cod_cliente'];

?>
<select name="cod_unidad" id="cod_unidad" class="textoform" >
				<option value="0">Seleccione una Unidad</option>
				<?php
					$sql2="select cod_unidad, nombre_unidad ";
					$sql2.=" from clientes_unidades";
					$sql2.=" where cod_cliente=".$_GET['cod_cliente'];
					$sql2.=" order by  nombre_unidad asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_unidad=$dat2['cod_unidad'];	
							$nombre_unidad=$dat2['nombre_unidad'];	

				 ?>

 					 <option value="<?php echo $cod_unidad;?>"><?php echo $nombre_unidad;?></option>		
	
				<?php		
					}
				?>						
			</select>
			<a  href="javascript:cargar_unidad();">[ Nueva Unidad]</a>
			&nbsp;<a  href="javascript:datosUnidad(this.form)"> [Datos Unidad]</a>
</body>
</html>
