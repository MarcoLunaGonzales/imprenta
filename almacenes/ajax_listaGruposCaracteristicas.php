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
				<table align="center" border="0">
				<?php
					$sql2=" select cod_grupo_carac, nombre_grupo_carac from grupos_caracteristicas ";
					$sql2.=" where cod_estado_registro=1  and cod_grupo=".$cod_grupo." order by orden asc";
					$resp2=mysql_query($sql2);
					$sw=0;
					while($dat2=mysql_fetch_array($resp2))
					{				
							$cod_grupo_carac=$dat2[0];	
			  		 		$nombre_grupo_carac=$dat2[1];	
							$nombre_grupo_carac=trim($nombre_grupo_carac)
				?>
					
					<tr bgcolor="#FFFFFF" align="right">
			     		<td><?php echo $nombre_grupo_carac;?></td>
      					<td align="right">
						<input type="text"  class="textoform" id="<?php echo $cod_grupo_carac;?>" size="35" 
						name="<?php echo $cod_grupo_carac;?>">
						</td>
			    	</tr>
				<?php
		
					  }
				?>						
				

			</table>
</body>
</html>
