<?php

header("Cache-Control: no-store, no-cache, must-revalidate");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BUSQUEDA DE PROVEEDORES</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
</head>

<body>


<?php


require("conexion.inc");

		$sql=" select count(*) ";
		$sql.=" from (select 1 as cod_tipo_doc, 'HR' as abrev_tipo_doc, hr.cod_hoja_ruta as codigo_doc, hr.cod_gestion as cod_gestion,";
		$sql.=" g.gestion_nombre as gestion_nombre,g.anio_menor as anio_menor,g.anio_mayor as anio_mayor ,";
 		$sql.=" hr.nro_hoja_ruta as nro_documento, hr.fecha_hoja_ruta as fecha_documento,";
		$sql.="  c.cod_cliente as cod_cliente ,cli.nombre_cliente as nombre_cliente";
		$sql.=" from hojas_rutas hr";
		$sql.=" inner join cotizaciones c on (hr.cod_cotizacion=c.cod_cotizacion)";
		$sql.=" left join clientes cli on (c.cod_cliente=cli.cod_cliente)";
		$sql.=" left join gestiones g on (hr.cod_gestion=g.cod_gestion)";
		$sql.=" where hr.cod_estado_hoja_ruta<>2 ";
		$sql.=" union";
		$sql.=" select 2 ascod_tipo_doc , 'OT' as abrev_tipo_doc, ot.cod_orden_trabajo as codigo_doc, ot.cod_gestion as cod_gestion,";
		$sql.=" g.gestion_nombre as gestion_nombre,g.anio_menor as anio_menor,g.anio_mayor as anio_mayor ,";
		$sql.="  ot.nro_orden_trabajo as nro_documento, ot.fecha_orden_trabajo as fecha_documento,";
		$sql.="  ot.cod_cliente as cod_cliente,cli.nombre_cliente as nombre_cliente";
		$sql.=" from ordentrabajo ot";
		$sql.=" left join clientes cli on (ot.cod_cliente=cli.cod_cliente)";
		$sql.=" left join gestiones g on (ot.cod_gestion=g.cod_gestion)";
		$sql.=" where ot.cod_est_ot<>2 ";
		$sql.=" ) as documentos";
		$sql.=" where cod_tipo_doc<>0 ";
		if($_GET['cod_tipo_docB']<>0){		
			$sql.=" and cod_tipo_doc='".$_GET['cod_tipo_docB']."'";
		}
		if($_GET['nombreClienteB']<>""){		
			$sql.=" and nombre_cliente like'%".$_GET['nombreClienteB']."%'";
		}
		if($_GET['nroDocB']<>""){
			$sql.=" and CONCAT(nro_documento) LIKE '%".$_GET['nroDocB']."%' ";
		}

		$sql.=" order by cod_tipo_doc asc, fecha_documento desc, nro_documento desc";
		$resp = mysql_query($sql);
		$numRows=0;
		while($dat=mysql_fetch_array($resp)){
			$numRows=$dat[0];			
		}

		if($numRows==0){

			
		?>
	<table width="98%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
            <td>Tipo Doc</td>
			<td>Nro Doc</td>
    		<td>Fecha</td>
    		<td>Cliente </td>																		
		</tr>
		<tr bgcolor="#FFFFFF" align="center" ><th colspan="4">No Existen registros</th></tr>
        </table>        
        <?php
		}else{
		?>

<h3 align="center" style="background:#F7F5F3;font-size: 10px;color: #E78611;font-weight:bold;"><?php echo "Nro de Registros :".$numRows;?></h3>
<?php

		$sql=" select cod_tipo_doc,abrev_tipo_doc, codigo_doc,cod_gestion, gestion_nombre, anio_menor, anio_mayor, nro_documento,";
		$sql.=" fecha_documento, cod_cliente, nombre_cliente";
		$sql.=" from (select 1 as cod_tipo_doc, 'HR' as abrev_tipo_doc, hr.cod_hoja_ruta as codigo_doc, hr.cod_gestion as cod_gestion,";
		$sql.=" g.gestion_nombre as gestion_nombre,g.anio_menor as anio_menor,g.anio_mayor as anio_mayor ,";
 		$sql.=" hr.nro_hoja_ruta as nro_documento, hr.fecha_hoja_ruta as fecha_documento,";
		$sql.="  c.cod_cliente as cod_cliente ,cli.nombre_cliente as nombre_cliente";
		$sql.=" from hojas_rutas hr";
		$sql.=" inner join cotizaciones c on (hr.cod_cotizacion=c.cod_cotizacion)";
		$sql.=" left join clientes cli on (c.cod_cliente=cli.cod_cliente)";
		$sql.=" left join gestiones g on (hr.cod_gestion=g.cod_gestion)";
		$sql.=" where hr.cod_estado_hoja_ruta<>2 and hr.informe='NO'";
		$sql.=" union";
		$sql.=" select 2 ascod_tipo_doc , 'OT' as abrev_tipo_doc, ot.cod_orden_trabajo as codigo_doc, ot.cod_gestion as cod_gestion,";
		$sql.=" g.gestion_nombre as gestion_nombre,g.anio_menor as anio_menor,g.anio_mayor as anio_mayor ,";
		$sql.="  ot.nro_orden_trabajo as nro_documento, ot.fecha_orden_trabajo as fecha_documento,";
		$sql.="  ot.cod_cliente as cod_cliente,cli.nombre_cliente as nombre_cliente";
		$sql.=" from ordentrabajo ot";
		$sql.=" left join clientes cli on (ot.cod_cliente=cli.cod_cliente)";
		$sql.=" left join gestiones g on (ot.cod_gestion=g.cod_gestion)";
		$sql.=" where ot.cod_est_ot<>2 ";
		$sql.=" ) as documentos";
		$sql.=" where cod_tipo_doc<>0 ";
		if($_GET['cod_tipo_docB']<>0){		
			$sql.=" and cod_tipo_doc='".$_GET['cod_tipo_docB']."'";
		}
		if($_GET['nombreClienteB']<>""){		
			$sql.=" and nombre_cliente like'%".$_GET['nombreClienteB']."%'";
		}
		if($_GET['nroDocB']<>""){
			$sql.=" and CONCAT(nro_documento) LIKE '%".$_GET['nroDocB']."%' ";
		}

		$sql.=" order by cod_tipo_doc asc, fecha_documento desc, nro_documento desc";
		//echo $sql."<br/>";
		$resp = mysql_query($sql);

?>	
	<table width="98%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
            <td>Tipo Doc</td>
			<td>Nro Doc</td>
    		<td>Fecha</td>
    		<td>Cliente </td>																				
		</tr>

<?php   
		while($dat=mysql_fetch_array($resp)){	
		
			$cod_tipo_doc=$dat['cod_tipo_doc'];
			$abrev_tipo_doc=$dat['abrev_tipo_doc'];
			$codigo_doc=$dat['codigo_doc'];
			$cod_gestion=$dat['cod_gestion'];
			$gestion_nombre=$dat['gestion_nombre'];
			$anio_menor=$dat['anio_menor'];
			$anio_mayor=$dat['anio_mayor'];
			$nro_documento=$dat['nro_documento'];
			$fecha_documento=$dat['fecha_documento'];
			$cod_cliente=$dat['cod_cliente'];
			$nombre_cliente=$dat['nombre_cliente'];	
			$aux=$abrev_tipo_doc.":".$nro_documento."/".$gestion_nombre." ".$nombre_cliente." (".strftime("%d/%m/%Y",strtotime($fecha_documento)).")";					
?> 
		<tr bgcolor="#FFFFFF" class="text">	
            <td>
			<?php if($cod_tipo_doc==1){?>
			<a href="../reportes/impresionHojaRuta.php?cod_hoja_ruta=<?php echo $codigo_doc;?>" target="_blank"><?php echo $abrev_tipo_doc; ?></a></td>
			<?php }
			if($cod_tipo_doc==2){?>
				<a href="../reportes/impresionOrdenTrabajo.php?cod_orden_trabajo=<?php echo $codigo_doc;?>" target="_blank"><?php echo $abrev_tipo_doc; ?></a></td>
			<?php }?>
			<td><a href="javascript:enviarDatos('<?php echo $cod_tipo_doc;?>','<?php echo $codigo_doc;?>','<?php echo $aux;?>')"><?php echo $nro_documento."/".$gestion_nombre; ?></a></td>
    		<td><?php echo strftime("%d/%m/%Y",strtotime($fecha_documento)); ?></td>
    		<td><?php echo $nombre_cliente; ?> </td>	
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


