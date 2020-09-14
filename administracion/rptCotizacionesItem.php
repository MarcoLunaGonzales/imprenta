<?
header('Content-Type: text/html; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';

//coneccion a la Base de Datos
require("conexion.inc");
include("funciones.php");
	$nrocotizacionB=$_POST['nrocotizacionB'];
	$codEstadoCotizacionB=$_POST['codEstadoCotizacionB'];
	$codTipoCotizacionB=$_POST['codTipoCotizacionB'];
	$nombreClienteB=$_POST['nombreClienteB'];
	$descItemB=$_POST['descItemB'];
	$fechaInicioB=$_POST['fechaInicioB'];
	$fechaFinalB=$_POST['fechaFinalB'];
//para sacar los datos de la busqueda
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="ajax/searchAjax.js"></script>
<script type="text/javascript">
function imprimirPagina() {
  if (window.print)
    window.print();
  else
    alert("Lo sentimos existe un error, consultar con el administrador.");
}

</script>
</head>

<body>
<h3 align="center" style="background:white;font-size: 14px;color:#E78611;font-weight:bold;">REPORTE DE COTIZACIONES POR ITEMS</h3>
<table align="center" >
<?php if($nrocotizacionB<>""){ ?>
<tr><td><strong>Nro de Cotizacion</strong></td><td><?php echo $nrocotizacionB;?></td></tr>
<?php } ?>
<?php if($codEstadoCotizacionB<>0){ 
	$$nombre_estado_cotizacion="";
	$sql="select nombre_estado_cotizacion from estados_cotizacion where cod_estado_cotizacion=".$codEstadoCotizacionB;
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$nombre_estado_cotizacion=$dat['nombre_estado_cotizacion'];
	}
?>
<tr><td><strong>Estado de Cotizacion:</strong></td><td><?php echo $nombre_estado_cotizacion;?></td></tr>
<?php } ?>
<?php if($codTipoCotizacionB<>0){ 
	$sql="select nombre_tipo_cotizacion from tipos_cotizacion where cod_tipo_cotizacion=".$codTipoCotizacionB;
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$nombre_tipo_cotizacion=$dat['nombre_tipo_cotizacion'];
	}
?>
<tr><td><strong>Tipo de Cotizacion: </strong></td><td><?php echo $nombre_tipo_cotizacion;?></td></tr>
<?php } ?>
<?php if($nombreClienteB<>""){ ?>
<tr><td><strong>Cliente: </strong></td><td><?php echo $nombreClienteB;?></td></tr>
<?php } ?>
<?php if($descItemB<>""){ ?>
<tr><td><strong>Item: </strong></td><td><?php echo $descItemB;?></td></tr>
<?php } ?>
<?php if($fechaInicioB<>"" and $fechaFinalB<>""){ ?>
<tr><td><strong>Nro de Cotizacion<strong></td><td><?php echo $nrocotizacionB;?></td></tr>
<?php } ?>
</table>
<?php 



	
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
		$sql.=" and c.cod_cotizacion in (select cod_cotizacion from cotizaciones_detalle where cod_item in(select cod_item from items where CONCAT(desc_item,' ',descripcion_item) like '%".$_POST['descItemB']."%') ) ";	
	}	

		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);
				
				$sql.=" and c.fecha_cotizacion>='".$aI."-".$mI."-".$dI."' and c.fecha_cotizacion<='".$aF."-".$mF."-".$dF."' ";

		}

	//Fin Busqueda/////////////////	
	//echo $sql;
	$resp_aux = mysql_query($sql);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}
?>
<h3 align="center" style="background:white;font-size: 10px;color:#E78611;font-weight:bold;">Nro de Registros <?php echo $nro_filas_sql;?></h3>
<?php		
	if($nro_filas_sql==0){
?>
	<table width="90%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>Nro de Cotizacion</td>
    		<td>Fecha</td>	
            <td>Usuario</td>	
			<td>Cliente</td>														
    		<td>Tipo de Pago</td>
			<td>Tipo de Cotizacion</td>	            
			<td>Observaciones</td>
            <td>Estado</td>
            <td>&nbsp;</td> 
            <td>&nbsp;</td>            
		</tr>
		<tr><th colspan="10" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
	</table>
	
<?php	
	}else{

		$sql=" select c.cod_cotizacion, c.cod_tipo_cotizacion, tc.nombre_tipo_cotizacion, c.cod_estado_cotizacion, ";
		$sql.=" ec.nombre_estado_cotizacion, c.nro_cotizacion,c.cod_cliente, cli.nombre_cliente,  c.fecha_cotizacion,"; 
		$sql.=" c.obs_cotizacion, c.cod_tipo_pago, tp.nombre_tipo_pago,  c.cod_gestion, g.gestion, c.cod_sumar,";
		$sql.=" c.considerar_precio_unitario, c.fecha_registro, c.cod_usuario_registro, c.fecha_modifica, c.cod_usuario_modifica,  ";
		$sql.=" c.cod_usuario_aprobacion, c.fecha_aprobacion, c.obs_cotizacion_impresion, c.cod_usuario_firma ";
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
		$sql.=" and c.cod_cotizacion in (select cod_cotizacion from cotizaciones_detalle where cod_item in(select cod_item from items where CONCAT(desc_item,' ',descripcion_item) like '%".$_POST['descItemB']."%') ) ";	

	}	

		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);
				
				$sql.=" and c.fecha_cotizacion>='".$aI."-".$mI."-".$dI."' and c.fecha_cotizacion<='".$aF."-".$mF."-".$dF."' ";

		}

	//Fin Busqueda/////////////////	
			$sql.=" order by g.gestion desc, c.nro_cotizacion desc ";
		//	echo $sql;
		$resp = mysql_query($sql);
		$cont=0;
?>	
<div align="center"><a href="javascript:imprimirPagina()">Imprimir</a></div>
	<table width="75%" align="center" cellpadding="1" id="cotizacion" cellspacing="1" bgColor="#cccccc">

	    <tr height="20px" align="center"  class="titulo_tabla">
            <td>&nbsp;</td> 
            <td>&nbsp;</td> 
			<td>Nro de Cotizacion</td>
    		<td>Fecha</td>	
            <td>Usuario</td>	
			<td>Cliente</td>														
    		<td>Tipo de Pago</td>
			<td>Tipo de Cotizacion</td>	            
			<td>Observaciones</td>
            <td>Estado</td>

		</tr>
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

            	$sql2="  select count(*) swHojasRuta from hojas_rutas ";
				$sql2.=" where cod_cotizacion='".$cod_cotizacion."' and (cod_estado_hoja_ruta=1 or cod_estado_hoja_ruta=3)";
				$resp2= mysql_query($sql2);
				$swHojasRuta=0;
				while($dat2=mysql_fetch_array($resp2)){
					$swHojasRuta=$dat2[0];
				}
	 
				
		?> 
		<tr bgcolor="#FFCCFF" valign="middle" >	
            <td height="25"><a href="../reportes/impresionCotizacion.php?cod_cotizacion=<?php echo $cod_cotizacion;?>" target="_blank">CF</a></td>
            <td><a href="../reportes/impresionCotizacionImprimir4.php?cod_cotizacion=<?php echo $cod_cotizacion; ?>"target="_blank">SF</a></td>
    		<td align="right"><strong><?php echo $nro_cotizacion."/".$gestion; ?></strong></td>	
			<td><?php echo strftime("%d/%m/%Y",strtotime($fecha_cotizacion));?></td>	
			<td>&nbsp;</td>											    		
	        <td><strong><?php echo $nombre_cliente;?></strong></td>
		    <td><?php echo $nombre_tipo_pago;?></td>
            <td><?php echo $nombre_tipo_cotizacion;?></td>
            <td><?php echo $obs_cotizacion;?></td>
            <td><?php echo $nombre_estado_cotizacion;?></td>		                                       	            
   	  </tr>
     
      <?php      
	  	$cont=0;
		$sqlAux=" select cod_cotizaciondetalle,  cod_item, descripcion_item, ";
		$sqlAux.=" cantidad_unitariacotizacion, cantidad_unitariacotizacionefectuada, ";
		$sqlAux.=" cod_estado_detallecotizacionitem,precio_venta, descuento, importe_total, orden ";
		$sqlAux.=" from cotizaciones_detalle ";
		$sqlAux.=" where  cod_cotizacion='".$cod_cotizacion."'";
	$sqlAux.=" and (cod_item in(select cod_item from items where CONCAT(desc_item,' ',descripcion_item) like '%".$descItemB."%'))";
		$sqlAux.=" order by cod_cotizaciondetalle asc";
		$respAux=mysql_query($sqlAux);
		$suma=0;
	
		while ($datAux=mysql_fetch_array($respAux)){

			
			$cod_cotizaciondetalle=$datAux[0];
			$cod_item=$datAux[1];
			
			$sql4= " select desc_item  from items  where cod_item='".$cod_item."'";
			$desc_item="";
			$resp4=mysql_query($sql4);
			while ($dat4=mysql_fetch_array($resp4)){
		
				$desc_item=$dat4[0];
			}
			
			$descripcion_item=$datAux[2];
			$descripcion_item=str_replace("|",",",$descripcion_item);
			$cantidad_unitariacotizacion=$datAux[3];
			$cantidad_unitariacotizacionefectuada=$datAux[4];
			$cod_estado_detallecotizacionitem=$datAux[5];
			$precio_venta=$datAux[6];
			$descuento=$datAux[7];
			$importe_total=$datAux[8];
			$orden=$datAux[9];
			

			
			?>
            <tr bgcolor="#FFFFFF" valign="middle" >	
            <td><?php echo $cantidad_unitariacotizacion; ?></td>

			
			<td colspan="7"><?php echo "<strong>".$desc_item." ".$descripcion_item."</strong><br/>"; ?>

			
			<?php
			
			$sql7=" select count(DISTINCT(cod_compitem))as cant_comp ";
			$sql7.=" from cotizacion_detalle_caracteristica";
			$sql7.=" where cod_cotizaciondetalle='".$cod_cotizaciondetalle."' and cod_cotizacion='".$cod_cotizacion."'";
			$resp7=mysql_query($sql7);
			$cant_comp=0;
			while ($dat7=mysql_fetch_array($resp7)){
				$cant_comp=$dat7[0];	
			}
			
			$detalle_item="";
			$sql2=" select  distinct(cod_compitem) as cod_compitem  from cotizacion_detalle_caracteristica ";
			$sql2.=" where cod_cotizaciondetalle='".$cod_cotizaciondetalle."' and cod_cotizacion='".$cod_cotizacion."'";
			
			$resp2=mysql_query($sql2);
			while ($dat2=mysql_fetch_array($resp2)){		
				$cod_compitem=$dat2[0];
				$sql4=" select  count(*) from cotizacion_detalle_caracteristica ";
				$sql4.=" where cod_cotizaciondetalle='".$cod_cotizaciondetalle."' and cod_cotizacion='".$cod_cotizacion."'";
				$sql4.=" and cod_compitem='".$cod_compitem."' and cod_estado_registro=1";
				$resp4=mysql_query($sql4);
				$nro_carac=0;
				while($dat4=mysql_fetch_array($resp4)){
					$nro_carac=$dat4[0];
				}
				
				if($nro_carac>0){
				/***************************************************************/
								
				$nombre_componenteitem="";
				$sql5=" select nombre_componenteitem from componente_items where cod_compitem='".$cod_compitem."'";
				$resp5=mysql_query($sql5);
				while ($dat5=mysql_fetch_array($resp5)){
					$nombre_componenteitem=$dat5[0];	
				}
				if($cant_comp>1){
					echo "<strong>".$nombre_componenteitem."</strong><br/>";

                }
						
				/**********************************/
				$sql3=" select  cod_carac, desc_carac, cod_estado_registro ";
				$sql3.=" from cotizacion_detalle_caracteristica ";
				$sql3.=" where cod_cotizaciondetalle='".$cod_cotizaciondetalle."'";
				$sql3.=" and cod_cotizacion='".$cod_cotizacion."'";
				$sql3.=" and cod_compitem='".$cod_compitem."'";
				$sql3.=" and cod_estado_registro=1 order by orden asc";
				$resp3=mysql_query($sql3);
				while ($dat3=mysql_fetch_array($resp3)){
						
						$cod_carac=$dat3[0];
						
						/*************************/
						$desc_caracT="";
						$sql5=" select desc_carac from caracteristicas where cod_carac='".$cod_carac."'";
						$resp5=mysql_query($sql5);
						while ($dat5=mysql_fetch_array($resp5)){
							$desc_caracT=$dat5[0];	
						}
						/*************************/

						$desc_carac=$dat3[1];
						$desc_carac=str_replace("|",",",$desc_carac);
						$cod_estado_registro=$dat3[2];
						
						echo $desc_caracT.": ".$desc_carac."<br/>";


					
				}
				/***************************************************************/
				}				
			}
			?>
                        <?php
			if($considerar_precio_unitario==1){
				$precio_venta_formato=number_format($precio_venta,2);
				$precio_unitario_formato=number_format($cantidad_unitariacotizacion*$precio_venta,2);
				$suma=$suma+($cantidad_unitariacotizacion*$precio_venta);
			?>
			<td align="right"><?php echo $precio_venta_formato; ?></td>
            <td align="right"><?php echo $precio_unitario_formato; ?></td>

			<?php	
			}else{
				$importe_total_formato=number_format($importe_total,2);
				$suma=$suma+($importe_total);
			?>
            <td align="right" >&nbsp;</td>
            <td align="right" ><?php echo $importe_total_formato; ?></td>
		<?php	}			

		?>						

                  </tr>
            <?php
	
}
$sw=1;
	  ?>

      
<?php
		}
?>			

		</table>
		
<?php
	}
?>
</body>
</html>