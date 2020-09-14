<?php

header("Cache-Control: no-store, no-cache, must-revalidate");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
</head>

<body>


<?php


require("conexion.inc");




		$sql=" select count(*) ";
		$sql.=" from proveedores ";
		if($_GET['nombreProveedorB']<>""){
			$sql.=" where nombre_proveedor LIKE '%".$_GET['nombreProveedorB']."%'";
		}
		$sql.=" order by nombre_proveedor asc ";

		$resp = mysql_query($sql);
		$numRows=0;
		while($dat=mysql_fetch_array($resp)){
			$numRows=$dat[0];			
		}
		if($numRows==0){
			
		?>
	<table width="98%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			  <td>Proveedor</td>
              <td>Direccion</td>
              <td>Telf.</td>
              <td>Fax</td>
              <td>Celular</td>	   																		
		</tr>
		<tr bgcolor="#FFFFFF" align="center" ><th colspan="5">No Existen registros</th></tr>
        </table>        
        <?php
		}else{
		?>

<h3 align="center" style="background:#FFF;font-size: 10px;color: #E78611;font-weight:bold;"><?php echo "Nro de Registros :".$numRows;?></h3>
<?php

			$sql=" select  cod_proveedor, nombre_proveedor,direccion_proveedor, ";
			$sql.=" telefono_proveedor, celular_proveedor, fax_proveedor  ";
			$sql.=" from proveedores ";
			if($_GET['nombreProveedorB']<>""){
				$sql.=" where nombre_proveedor LIKE '%".$_GET['nombreProveedorB']."%'";
			}
			$sql.=" order by nombre_proveedor asc ";
			$resp = mysql_query($sql);

?>	
	<table width="98%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			  <td>Proveedor</td>
              <td>Direccion</td>
              <td>Telf.</td>
              <td>Fax</td>
              <td>Celular</td>	
              <td>Contactos</td>																			
		</tr>

<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){	

				$cod_proveedor=$dat['cod_proveedor']; 
				$nombre_proveedor=$dat['nombre_proveedor']; 
				$direccion_proveedor=$dat['direccion_proveedor'];
				$telefono_proveedor=$dat['telefono_proveedor'];
				$celular_proveedor=$dat['celular_proveedor'];
				$fax_proveedor=$dat['fax_proveedor'];
											

?> 
		<tr bgcolor="#FFFFFF">	
			<td align="left"><a href="javascript:enviarDatos('<?php echo $cod_proveedor;?>','<?php echo $nombre_proveedor;?>')"><?php echo $nombre_proveedor;?></a></td>
			<td align="left"><?php echo $direccion_proveedor;?></td>					
    		<td align="left"><?php echo $telefono_proveedor;?></td>
			<td align="left"><?php echo $fax_proveedor;?></td>
			<td align="left"><?php echo $celular_proveedor;?></td>	
<td>
            	<table border="0"c cellpadding="0" cellspacing="1">
				<?php
	          	$sqlAux=" select cod_contacto_proveedor, nombre_contacto, ap_paterno_contacto, ap_materno_contacto,";
				$sqlAux.=" cargo_contacto, telefono_contacto, celular_contacto";
				$sqlAux.=" from proveedores_contactos ";
				$sqlAux.=" where cod_proveedor=".$cod_proveedor;
				$sqlAux.=" order by ap_paterno_contacto, ap_materno_contacto, nombre_contacto asc ";
				$respAux= mysql_query($sqlAux);
				while($datAux=mysql_fetch_array($respAux)){
					$cod_contacto_proveedor=$datAux['cod_contacto_proveedor'];
					$nombre_contacto=$datAux['nombre_contacto'];
					$ap_paterno_contacto=$datAux['ap_paterno_contacto'];
					$ap_materno_contacto=$datAux['ap_materno_contacto'];
					$cargo_contacto=$datAux['cargo_contacto'];
					$telefono_contacto=$datAux['telefono_contacto'];
					$celular_contacto=$datAux['celular_contacto'];
				?>
                <tr class="text">
                <td><?php echo $ap_paterno_contacto." ".$nombre_contacto;?></td>
                <td><?php echo $cargo_contacto;?></td>
                <td><?php echo $telefono_contacto." ".$celular_contacto;?></td>
                </tr>
                <?php
				}	
				
			?>
            </table>
            </td>            		

    	 </tr>
<?php
		 } 
?>			


</table>
<?php
		 } 
?>

</body>
</html>


