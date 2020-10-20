<?
header("Cache-Control: no-store, no-cache, must-revalidate");

//coneccion a la Base de Datos
require("conexion.inc");
include("funciones.php");
	$nrocotizacionB=$_GET['nrocotizacionB'];
	$codEstadoCotizacionB=$_GET['codEstadoCotizacionB'];
	$codTipoCotizacionB=$_GET['codTipoCotizacionB'];
	$nombreClienteB=$_GET['nombreClienteB'];
	$descItemB=$_GET['descItemB'];
	$codActivoFecha=$_GET['codActivoFecha'];
	$fechaInicioB=$_GET['fechaInicioB'];
	$fechaFinalB=$_GET['fechaFinalB'];
//para sacar los datos de la busqueda
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php 


	//Paginador
	
	
	$nro_filas_show=100;	
	$pagina=$_GET['pagina'];
	//echo $pagina;
	if ($pagina==""){
		$pagina = 1;
		$fila_inicio=0;
		$fila_final=$nro_filas_show;
	}else{
		$fila_inicio=(($pagina*$nro_filas_show)-$nro_filas_show);
		$fila_final=($fila_inicio+$nro_filas_show);
	}	
	

	
	$sql=" select count(*) ";
	$sql.=" from cotizaciones c, gestiones g, estados_cotizacion ec, tipos_cotizacion tc, tipos_pago tp, clientes cli ";
	$sql.=" where c.cod_gestion=g.cod_gestion ";
	$sql.=" and c.cod_estado_cotizacion=ec.cod_estado_cotizacion ";
	$sql.=" and c.cod_tipo_cotizacion=tc.cod_tipo_cotizacion ";
	$sql.=" and c.cod_tipo_pago=tp.cod_tipo_pago ";
	$sql.=" and c.cod_cliente=cli.cod_cliente ";
////Busqueda//////////////////
	if($nrocotizacionB<>""){
		$sql.=" and CONCAT(c.nro_cotizacion,'/',g.gestion) LIKE '%".$nrocotizacionB."%' ";
	}
	if($codEstadoCotizacionB<>0){
		$sql.=" and c.cod_estado_cotizacion =".$codEstadoCotizacionB;
	}	
	if($codTipoCotizacionB<>0){
		$sql.=" and c.cod_tipo_cotizacion =".$codTipoCotizacionB;
	}	

	if($nombreClienteB<>""){
		$sql.=" and cli.nombre_cliente like '%".$nombreClienteB."%' ";	
	}
	if($descItemB<>""){
		$sql.=" and c.cod_cotizacion in ( select cod_cotizacion from cotizaciones_detalle where cod_item in(select cod_item from items where desc_item like '%".$descItemB."%')) ";	
	}	

	if($codActivoFecha=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);
				
				$sql.=" and c.fecha_cotizacion>='".$aI."-".$mI."-".$dI."' and c.fecha_cotizacion<='".$aF."-".$mF."-".$dF."' ";

		}
	}

	//Fin Busqueda/////////////////	
	//echo $sql;
	$resp_aux = mysql_query($sql);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}

		//Calculo de Nro de Paginas
			$nropaginas=1;
			if($nro_filas_sql<$nro_filas_show){
				$nropaginas=1;
			}else{
				$nropag_aux=round($nro_filas_sql/$nro_filas_show);

				if($nro_filas_sql>($nropag_aux*$nro_filas_show)){
					$nropaginas=$nropag_aux+1;
				}else{
					$nropaginas=$nropag_aux;
				}
			}					
		//Fin de calculo de paginas
		$sql=" select c.cod_cotizacion, c.cod_tipo_cotizacion, tc.nombre_tipo_cotizacion, c.cod_estado_cotizacion, ";
		$sql.=" ec.nombre_estado_cotizacion, c.nro_cotizacion,c.cod_cliente, cli.nombre_cliente,  c.fecha_cotizacion,"; 
		$sql.=" c.obs_cotizacion, c.cod_tipo_pago, tp.nombre_tipo_pago,  c.cod_gestion, g.gestion, c.cod_sumar,";
		$sql.=" c.considerar_precio_unitario, c.fecha_registro, c.cod_usuario_registro, c.fecha_modifica, c.cod_usuario_modifica, ";
		$sql.=" c.cod_usuario_aprobacion, c.fecha_aprobacion, c.obs_cotizacion_impresion, c.cod_usuario_firma,";
		$sql.=" c.descuento_cotizacion,  c.descuento_fecha, c.descuento_obs, c.cod_usuario_descuento, c.obs_pago, ";
		$sql.=" c.incremento_cotizacion, c.incremento_fecha, c.incremento_obs ";
		$sql.=" from cotizaciones c, gestiones g, estados_cotizacion ec, tipos_cotizacion tc, tipos_pago tp, clientes cli ";
		$sql.=" where c.cod_gestion=g.cod_gestion ";
		$sql.=" and c.cod_estado_cotizacion=ec.cod_estado_cotizacion ";
		$sql.=" and c.cod_tipo_cotizacion=tc.cod_tipo_cotizacion ";
		$sql.=" and c.cod_tipo_pago=tp.cod_tipo_pago ";
		$sql.=" and c.cod_cliente=cli.cod_cliente ";

////Busqueda//////////////////
	if($nrocotizacionB<>""){
		$sql.=" and CONCAT(c.nro_cotizacion,'/',g.gestion) LIKE '%".$nrocotizacionB."%' ";
	}
	if($codEstadoCotizacionB<>0){
		$sql.=" and c.cod_estado_cotizacion =".$codEstadoCotizacionB;
	}	
	if($codTipoCotizacionB<>0){
		$sql.=" and c.cod_tipo_cotizacion =".$codTipoCotizacionB;
	}	

	if($nombreClienteB<>""){
		$sql.=" and cli.nombre_cliente like '%".$nombreClienteB."%' ";	
	}
	if($descItemB<>""){
		$sql.=" and c.cod_cotizacion in ( select cod_cotizacion from cotizaciones_detalle where cod_item in(select cod_item from items where desc_item like '%".$descItemB."%')) ";	
	}	

	if($codActivoFecha=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);
				
				$sql.=" and c.fecha_cotizacion>='".$aI."-".$mI."-".$dI."' and c.fecha_cotizacion<='".$aF."-".$mF."-".$dF."' ";

		}
	}

	//Fin Busqueda/////////////////	
			$sql.=" order by g.gestion desc, c.nro_cotizacion desc ";
		//$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		//	echo $sql;
		$resp = mysql_query($sql);
		$cont=0;
?>	
	<table width="95%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc" class="tablaReporte" style="width:100% !important;">
<thead>
	    <tr height="20px" align="center"  class="bg-success text-white">
            <th>&nbsp;</th> 
			<th>Nro de Cotizacion</th>
    		<th>Fecha</th>	
            <th>Usuario</th>	
			<th>Cliente</th>
			<!--th>Monto</th>
			<th>Desc</th>
            <th>Inc</th>
			<th>Total Monto</th-->														
    		<th>Tipo de Pago</th>
			<th>Tipo de Cotizacion</th>	            
			<th>Observaciones</th>
            <th>Estado</th>
			<!--th>&nbsp;</th>
            <th-->&nbsp;</th>
		</tr>
		</thead>    
		<tbody>
<?php   
		while($dat=mysql_fetch_array($resp)){
				
			 $cod_cotizacion=$dat['cod_cotizacion'];
			 $cod_tipo_cotizacion=$dat['cod_tipo_cotizacion'];
			 $nombre_tipo_cotizacion=$dat['nombre_tipo_cotizacion'];
			 $cod_estado_cotizacion=$dat['cod_estado_cotizacion'];
			 $nombre_estado_cotizacion=$dat['nombre_estado_cotizacion'];
			 $nro_cotizacion=$dat['nro_cotizacion'];
			 $cod_cliente=$dat['cod_cliente'];
			 $nombre_cliente=$dat['nombre_cliente'];
			 $fecha_cotizacion=$dat['fecha_cotizacion'];
			 $obs_cotizacion=$dat['obs_cotizacion'];
			 $cod_tipo_pago=$dat['cod_tipo_pago'];
			 $nombre_tipo_pago=$dat['nombre_tipo_pago'];
			 $cod_gestion=$dat['cod_gestion'];
			 $gestion=$dat['gestion'];
			 $cod_sumar=$dat['cod_sumar'];
			 $considerar_precio_unitario=$dat['considerar_precio_unitario'];
			 $fecha_registro=$dat['fecha_registro'];
			 $cod_usuario_registro=$dat['cod_usuario_registro'];
			 $fecha_modifica=$dat['fecha_modifica'];
			 $cod_usuario_modifica=$dat['cod_usuario_modifica'];
			 $cod_usuario_aprobacion=$dat['cod_usuario_aprobacion'];
			 $fecha_aprobacion=$dat['fecha_aprobacion'];
			 $obs_cotizacion_impresion=$dat['obs_cotizacion_impresion'];
			 $cod_usuario_firma=$dat['cod_usuario_firma'];
			 $descuento_cotizacion=$dat['descuento_cotizacion'];
			 $descuento_fecha=$dat['descuento_fecha'];
			 $descuento_obs=$dat['descuento_obs'];
			 $cod_usuario_descuento=$dat['cod_usuario_descuento'];
			 $obs_pago=$dat['obs_pago'];
			 $incremento_cotizacion=$dat['incremento_cotizacion'];
			 $incremento_fecha=$dat['incremento_fecha'];
			 $incremento_obs=$dat['incremento_obs'];
			 

			    $sql2="  select count(*) swHojasRuta from hojas_rutas ";
				$sql2.=" where cod_cotizacion='".$cod_cotizacion."' and (cod_estado_hoja_ruta=1 or cod_estado_hoja_ruta=3)";
				$resp2= mysql_query($sql2);
				$swHojasRuta=0;
				while($dat2=mysql_fetch_array($resp2)){
					$swHojasRuta=$dat2[0];
				}
	 
				
		?> 
		<tr <?php if($swHojasRuta>0){?>bgcolor="#CCFFCC"<?php }else{?> bgcolor="#FFFFFF" <?php }?> valign="middle">	
            <td><a href="../reportes/impresionCotizacionFormato.php?cod_cotizacion=<?php echo $cod_cotizacion;?>" target="_blank">CF</a></td>

    		<td align="right"><?php echo $nro_cotizacion."/".$gestion; ?></td>	
			<td><?php echo strftime("%d/%m/%Y",strtotime($fecha_cotizacion));?></td>	
			<td>&nbsp;</td>											    		
	        <td><?php echo $nombre_cliente;?></td>
			<!--td bgcolor="#FFFFCC">
			<?php
					    $sql2="  select cod_hoja_ruta from hojas_rutas ";
						$sql2.=" where cod_cotizacion='".$cod_cotizacion."' and (cod_estado_hoja_ruta=1 or cod_estado_hoja_ruta=3)";
						$resp2= mysql_query($sql2);
						$cod_hoja_ruta=0;
						while($dat2=mysql_fetch_array($resp2)){
							$cod_hoja_ruta=$dat2[0];
						}
				
					$monto_factura=0;	
						if($cod_hoja_ruta<>0){			
							$sqlAux=" select sum(cd.IMPORTE_TOTAL) ";
							$sqlAux.=" from hojas_rutas_detalle hrd, cotizaciones_detalle cd ";
							$sqlAux.=" where hrd.cod_hoja_ruta=".$cod_hoja_ruta;
							$sqlAux.=" and hrd.cod_cotizacion=cd.cod_cotizacion ";
							$sqlAux.=" and hrd.cod_cotizaciondetalle=cd.cod_cotizaciondetalle ";
							$respAux = mysql_query($sqlAux);
							while($datAux=mysql_fetch_array($respAux)){
								$monto_factura=$datAux[0];
							}
							echo $monto_factura." Bs.";
					 }else{
						 	$sqlAux=" select sum(cd.IMPORTE_TOTAL) ";
							$sqlAux.=" from cotizaciones_detalle cd ";
							$sqlAux.=" where  cd.cod_cotizacion=".$cod_cotizacion;
							$respAux = mysql_query($sqlAux);
							while($datAux=mysql_fetch_array($respAux)){
								$monto_factura=$datAux[0];
							}
							echo $monto_factura." Bs.";
					
					 }
					
				 ?>
				</td-->
			<!--td bgcolor="#FFFFCC"><?php
				if($descuento_cotizacion<>''){ 
					echo $descuento_cotizacion." Bs.";
				}
			?>
			</td-->
			<!--td bgcolor="#FFFFCC"><?php
				if($incremento_cotizacion<>''){ 
					echo $incremento_cotizacion." Bs.";
				}
			?>
			</td-->            
			<!--td bgcolor="#FFFFCC"><?php
				if($swHojasRuta>0){ 
					echo (($monto_factura+$incremento_cotizacion)-$descuento_cotizacion)." Bs.";
				}
			?>
			</td-->
			
		    <td><?php echo $nombre_tipo_pago;?></td>
            <td><?php echo $nombre_tipo_cotizacion;?></td>
            <td><?php echo $obs_cotizacion;?></td>
            <td><?php echo $nombre_estado_cotizacion;?></td>
			<!--td><?php if($swHojasRuta>0){?>
			<a onclick="openPopup('descuentoCotizacion.php?cod_cotizacion=<?php echo $cod_cotizacion;?>');" title="Click Ver Descuento"> Desc.</a>
			<?php }?>
			</td>	
			<td><?php if($swHojasRuta>0){?>
			<a onclick="openPopup('incrementoCotizacion.php?cod_cotizacion=<?php echo $cod_cotizacion;?>');" title="Click Ver Descuento"> Inc.</a>
			<?php }?>
			</td-->	            	
				            
   	  </tr>
<?php
		 } 
?>			
  			</tbody>
		</table>

</body>
</html>