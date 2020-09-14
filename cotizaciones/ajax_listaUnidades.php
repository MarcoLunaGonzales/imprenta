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
$codcliente=$_GET['cod_cliente'];
$codunidad=$_GET['cod_unidad'];
?>

			
			<select name="cod_unidad" id="cod_unidad" class="textoform" >
				<option value="0">Seleccione un Contacto</option>
				<?php
					$sql2=" select cod_unidad, nombre_unidad";
					$sql2.=" from clientes_unidades";
					$sql2.=" where cod_cliente=".$codcliente;
					$sql2.=" order by  nombre_unidad asc ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_unidad=$dat2['cod_unidad'];
							$nombre_unidad=$dat2['nombre_unidad'];

				 ?>
				 <?php if($cod_unidad==$codunidad){?>
					 <option value="<?php echo $cod_unidad;?>" selected="selected"><?php echo $nombre_unidad;?></option>		
				 <?php }else{?>
 					 <option value="<?php echo $cod_unidad;?>"><?php echo $nombre_unidad;?></option>		
				 <?php }?>		
				<?php		
					}
				?>						
			</select>
			<a  href="javascript:cargar_unidad();">[ Nueva Unidad]</a>
			&nbsp;<a  href="javascript:datosUnidad(this.form)"> [Datos Unidad]</a>
</body>
</html>
