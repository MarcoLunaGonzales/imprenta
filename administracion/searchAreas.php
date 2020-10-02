<?php
header('Content-Type: text/html; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';

//coneccion a la Base de Datos
require("conexion.inc");
include("funciones.php");
$elemento=$_GET['elemento'];
$cod_estado_registro=$_GET['cod_estado_registro'];
//para sacar los datos de la busqueda
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgcolor="#FFFFFF">
<?php

	$sql_aux=" select count(*) from areas a , estados_referenciales e ";
	$sql_aux.=" where a.cod_estado_registro=e.cod_estado_registro";		
	if($cod_estado_registro<>0){
		$sql_aux.=" and  a.cod_estado_registro='".$cod_estado_registro."' ";
	}
	$sql_aux.=" and a.nombre_area like '%".$elemento."%' ";	
	$resp_aux = mysql_query($sql_aux);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}

?>
        
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc" class="tablaReporte" style="width:100% !important;">
		<thead>
	    <tr height="20px" align="center"  class="bg-success text-white">
    		<th>&nbsp;</th>
            <th>Area</th>
			<th>Observaciones</th>				
    		<th>Estado</th>
			<th>Fecha de Registro</th>	
			<th>Ultima Edicion</th>		                           
          </tr>
          </thead>
          <tbody>
        <?php
			$sql=" select a.cod_area, a.nombre_area, a.obs_area, a.cod_estado_registro, e.nombre_estado_registro, a.fecha_registro, ";
			$sql.=" a.cod_usuario_registro, a.fecha_modifica, a.cod_usuario_modifica ";
			$sql.=" from areas a , estados_referenciales e ";
			$sql.=" where a.cod_estado_registro=e.cod_estado_registro ";
			if($cod_estado_registro<>0){
				$sql.=" and  a.cod_estado_registro='".$cod_estado_registro."' ";
			}
			$sql.=" and a.nombre_area like '%".$elemento."%' ";		
		
			$sql.=" order by a.nombre_area asc ";
			
			$resp = mysql_query($sql);
				
			$flag=0; 
			while($dat=mysql_fetch_array($resp)){
				
				$cod_area=$dat['cod_area'];
				$nombre_area=$dat['nombre_area'];
				$obs_area=$dat['obs_area'];
				$cod_estado_registro=$dat['cod_estado_registro'];
				$nombre_estado_registro=$dat['nombre_estado_registro'];
				$fecha_registro=$dat['fecha_registro'];
				$cod_usuario_registro=$dat['cod_usuario_registro'];
				$fecha_modifica=$dat['fecha_modifica'];
				$cod_usuario_modifica=$dat['cod_usuario_modifica'];
			?>
            <tr bgcolor="#FFFFFF">	
			<td><input type="checkbox"name="cod_area"value="<?php echo $cod_area;?>"></td>	
    		<td><?php echo $nombre_area;?></td>
    		<td><?php echo $obs_area;?></td>
    		<td><?php echo $nombre_estado_registro; ?></td>
			<td>&nbsp;</td>
   			<td>&nbsp;</td>    
            </tr>
            <?php
			}					
	  ?>
   </tbody>
</table>
        
</body>
</html>