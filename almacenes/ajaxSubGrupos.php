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

<?php if($cod_grupo<>0){?>
<table align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc" width="100%">
<?php					$sql2=" select cod_subgrupo, nombre_subgrupo from subgrupos ";
					$sql2.=" where cod_estado_registro=1  and cod_grupo=".$cod_grupo;
					$sql2.= "  order by  nombre_subgrupo asc";

					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_subgrupo=$dat2[0];	
			  		 		$nombre_subgrupo=$dat2[1];	
				 ?>
                 	<tr>
					<td class="fila_par" align="right">                       
                      <input type="checkbox" name="cod_subgrupo<?php echo $cod_subgrupo?>" id="cod_subgrupo<?php echo $cod_subgrupo?>" checked="true">
                    </td>
                     <td class="fila_par" align="left"><?php echo $nombre_subgrupo; ?></td>
                    </tr>
                        
	
				<?php		
					}
				?>						

</table>
<?php }else{?>
					<h3 align="center" style="background:#F7F5F3;font-size: 11px;color: #663300;font-weight:bold;">
                    Todos los Subgrupos</h3>
<?php }?>
</body>
</html>
