<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>



<?php 
require("conexion.inc");
include("funciones.php");
$cod_grupo=$_GET['cod_grupo'];
?>
			<select name="cod_tipo_grupo" class="textoform">	
			<option value="0">Seleccione una opcion</option>			
				<?php
					$sql2=" select cod_tipo_grupo, nombre_tipo_grupo from tipos_grupo ";
					$sql2.=" where cod_estado_registro=1  and cod_grupo=".$cod_grupo;
					$sql2.= "  order by  nombre_tipo_grupo asc";

					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_tipo_grupo=$dat2[0];	
			  		 		$nombre_tipo_grupo=$dat2[1];	
				 ?><option value="<?php echo $cod_tipo_grupo;?>"><?php echo $nombre_tipo_grupo;?></option>				
				<?php		
					}
				?>						
			</select>	


</body>
</html>
