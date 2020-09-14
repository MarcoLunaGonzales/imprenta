<?php
function suma_fechas($fecha,$ndias)
{
             
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
            
              list($año,$mes,$dia)=split("-", $fecha);
            
 
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            
 
              list($año,$mes,$dia)=split("-",$fecha);
        $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
        $nuevafecha=date("Y-m-d",$nueva);
             
      return ($nuevafecha);  
          
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>MODULO DE ALMACENES</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript" src="ajax/searchAjax.js"></script>
<script type="text/javascript">


</script>

</head>
<body bgcolor="#FFFFFF">
<form name="form1" method="post"  id="form1">
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">INGRESOS</h3>
<table align="center" cellSpacing="1" cellPadding="1" width="20%" bgColor="#FFFFFF" border="0">
		<tbody>
    
			<?php
	
	require("conexion.inc");
	include("funciones.php");			
			$sql=" select cod_sucursal, nombre_sucursal";
			$sql.=" from sucursales ";
			$sql.=" where cod_estado_registro=1 ";
			$sql.=" order by  cod_sucursal asc";
			$resp = mysql_query($sql);

			while($dat=mysql_fetch_array($resp)){	
															 		
				$cod_sucursal=$dat['cod_sucursal'];	
				$nombre_sucursal=$dat['nombre_sucursal'];
			?>
					 <tr >
						   <td   align="center"><h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;"><?php echo "Sucursal ".$nombre_sucursal;?></h3></span></td>
			    </tr>
			<?php
				$sql2=" select cod_almacen, nombre_almacen ";
					$sql2.=" from almacenes";
					$sql2.=" where cod_sucursal=".$cod_sucursal;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){	
						
						$cod_almacen=$dat2['cod_almacen'];
						$nombre_almacen=$dat2['nombre_almacen'];	
			?>
            			 <tr bgcolor="#FFFFFF">
   						
			      		<td align="center"><a href="direccionar.php?cod_almacen_global=<?php echo $cod_almacen; ?>"  ><h3 align="center" style="background:#FFF;font-size: 12px;color: #666600;font-weight:bold;"><?php echo $nombre_almacen;?></h3></a></td>
			    	</tr>	
            <?php				
					}

			}
		
		?>	
	        
		</tbody>
	</table>

</form>

</body>
</html>

