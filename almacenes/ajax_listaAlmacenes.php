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
$cod_sucursal=$_GET['cod_sucursal'];
?>
<table width="100%" border="0">
<?php
					$sw=0;
					$sql2=" select cod_almacen, nombre_almacen from almacenes ";
					$sql2.=" where cod_estado_registro=1  ";
					$sql2.=" and cod_sucursal='".$cod_sucursal."'";
					$resp2=mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2))
					{				
							$cod_almacen=$dat2[0];	
			  		 		$nombre_almacen=$dat2[1];	
				?>
					
					<tr bgcolor="#FFFFFF">
						<td ><input type="checkbox"name="cod_almacen"value="<?php echo $cod_almacen;?>">&nbsp;&nbsp;&nbsp;<?php echo $nombre_almacen;?></td>
			    	</tr>
				<?php
		
					  }
				?>	

</table>
</body>
</html>
