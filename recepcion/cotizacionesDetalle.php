<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Usuarios</title>
<link rel="STYLESHEET" type="text/css" href="ventas.css" />
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
</head>
<body>
<!---Autor:Rene Ergueta Illanes
02 de Julio de 2008
-->
<h3 align="center" style="background:white;font-size: 16px;color: #d20000;font-weight:bold;">DETALLE COTIZACIONES</h3>
<?php 
	require("conexion.inc");
	include("funciones.php");
?>
<?php	
	//Paginador
	$codCotizacion = $_GET['codigo'];
	$sumImporteTotal=0;
?>

<?php	
	$cod_gestion=gestionActiva();
	
	$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion."'";
	$resp2= mysql_query($sql2);
	$gestion="";
	while($dat2=mysql_fetch_array($resp2)){
		$gestion=$dat2[0];
	}
		$sql=" SELECT NRO_COTIZACION,FECHA_COTIZACION,COD_CLIENTE,COD_TIPO_COTIZACION";
		$sql.=" ,COD_ESTADO_COTIZACION,OBS_COTIZACION,COD_TIPO_PAGO,COD_USUARIO_REGISTRO FROM COTIZACIONES";
		$sql.=" WHERE COD_COTIZACION=".$codCotizacion;
		$resp = mysql_query($sql);		
		while($dat=mysql_fetch_array($resp)){
			$nroCotizacion=$dat[0];
			$fechaCotizacion=$dat[1];
			$codCliente=$dat[2];
			$codTipoCotizacion=$dat[3];
			$codEstadoCotizacion=$dat[4];
			$obsCotizacion=$dat[5];
			$codTipoPago=$dat[6];
			$codUsuarioRegistro=$dat[7];
			$fechaCotizacionVecto=explode(" ",$fechaCotizacion);
			$fechaCotizacionVectoAux=explode("-",$fechaCotizacionVecto[0]);			
			//**************************************************************
			$nombreCliente="";				
			$sql2="select nombre_cliente from clientes";
			$sql2.=" where cod_cliente='".$codCliente."'";	
			$resp2= mysql_query($sql2);
			while($dat2=mysql_fetch_array($resp2)){
				$nombreCliente=$dat2[0];
			}	
			//**************************************************************								
			//**************************************************************
			$nombreTipoCotizacion="";				
			$sql2="select nombre_tipo_cotizacion from tipos_cotizacion";
			$sql2.=" where cod_tipo_cotizacion='".$codTipoCotizacion."'";	
			$resp2= mysql_query($sql2);
			while($dat2=mysql_fetch_array($resp2)){
				$nombreTipoCotizacion=$dat2[0];
			}
			//**************************************************************
			//**************************************************************
			$nombreEstadoCotizacion="";				
			$sql2="select nombre_estado_cotizacion from estados_cotizacion";
			$sql2.=" where cod_estado_cotizacion='".$codEstadoCotizacion."'";	
			$resp2= mysql_query($sql2);
			while($dat2=mysql_fetch_array($resp2)){
				$nombreEstadoCotizacion=$dat2[0];
			}
			//**************************************************************
			//**************************************************************
			$nombreTipoPago="";				
			$sql2="select nombre_tipo_pago from tipos_pago";
			$sql2.=" where cod_tipo_pago='".$codTipoPago."'";	
			$resp2= mysql_query($sql2);
			while($dat2=mysql_fetch_array($resp2)){
				$nombreTipoPago=$dat2[0];
			}
			
?>	
<h3 align="center" style="background:white;font-size: 16px;color: #d20000;font-weight:bold;">Nro./Gesti&oacute;n : <?php echo $nroCotizacion;?>/<?php echo $gestion;?></h3>
	<table  border="0" align="center" class="outputText2" width="80%">        
	    <tr>    		
			<td class="tituloCampo"><b>Cliente</b></td><td><b>::</b></td><td><?php echo $nombreCliente;?></td>
			<td class="tituloCampo"><b>Fecha</b></td><td><b>::</b></td><td><?php echo $fechaCotizacionVectoAux[2]."/".$fechaCotizacionVectoAux[1]."/".$fechaCotizacionVectoAux[0];?></td>
		</tr>
		<tr>
    		<td class="tituloCampo"><b>Tipo de Cotizacion</b></td><td><b>::</b></td><td><?php echo $nombreTipoCotizacion;?></td>			
			<td class="tituloCampo"><b>Tipo de Pago</b></td><td><b>::</b></td><td><?php echo $nombreTipoPago;?></td>
		</tr>			
		<tr>
    		<td class="tituloCampo"><b>Estado</b></td><td><b>::</b></td><td><?php echo $nombreEstadoCotizacion;?></td>
			<td class="tituloCampo"><b>Observacion</b></td><td><b>::</b></td><td colspan="4"><?php echo $obsCotizacion;?></td>			
		</tr>
	</TABLE>
	<br>
	<table  align="center" class="tablaFiltroReporte" width="90%">
	    <tr class="tituloCampo">
			
			<td><b>Cantidad</b></td>
			<td><b>Descripci&oacute;n</b></td>    		
    		<td><b>Precio Venta</b></td>
    		<td><b>Descuento</b></td>			
    		<td><b>Importe</b></td>
		</tr>
<?php 
			$sql2="select cod_item,cantidad_unitariacotizacion,precio_venta,descuento,importe_total,DESCRIPCION_ITEM";
			$sql2.=" from cotizaciones_detalle where cod_cotizacion=".$codCotizacion;
			$sql2.=" order by orden asc";
			$resp2= mysql_query($sql2);
			$c=0;
			while($dat2=mysql_fetch_array($resp2)){
				$c++;
				$codItem=$dat2[0];
				$cantUnitaria=$dat2[1];
				$precioVenta=$dat2[2];
				$descuento=$dat2[3];
				$importeTotal=$dat2[4];
				$descItem=$dat2[5];
				$sumImporteTotal=$sumImporteTotal+$importeTotal;
				//**************************************************************
				//**************************************************************
				$nombreItem="";
				$sql3="select desc_item from items";
				$sql3.=" where cod_item='".$codItem."'";	
				$resp3= mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3)){
					$nombreItem=$dat3[0];
				}				
			?>
		    <tr>
				<td class="bordeNegroTd" align="right"><?php echo $cantUnitaria;?></td>				
				<td class="bordeNegroTd"><b><?php echo $nombreItem;?>:&nbsp;</b><?php echo $descItem;?><br>
				<?php

				$sql4="select cd.cod_compitem from cotizacion_detalle_caracteristica cd,componente_items c";
				$sql4.=" where cd.cod_compitem=c.cod_compitem and cd.cod_cotizacion=".$codCotizacion." and c.cod_item=".$codItem;				
				$sql4.=" group by cd.cod_compitem";
				$resp4= mysql_query($sql4);
				$cont=0;				
				while($dat4=mysql_fetch_array($resp4)){
					$cont=$cont+1;
				}				
				$sql4="select cd.cod_compitem,c.nombre_componenteitem from cotizacion_detalle_caracteristica cd,componente_items c";
				$sql4.=" where cd.cod_compitem=c.cod_compitem and cd.cod_cotizacion=".$codCotizacion." and c.cod_item=".$codItem;				
				$sql4.=" group by cd.cod_compitem order by cd.cod_compitem asc";
				$resp4= mysql_query($sql4);
				while($dat4=mysql_fetch_array($resp4)){
					$codCompItem=$dat4[0];
					$nombreItem=$dat4[1];				
				?>
				<ul>
					<?php 
					if($cont>=2){
					?>
					<li><b><?php echo $nombreItem;?></b></li>
					<?php 
					}
					$sql5="select c.desc_carac,cd.desc_carac,cd.cod_estado_registro from cotizacion_detalle_caracteristica cd,caracteristicas c";
					$sql5.=" where cd.cod_carac=c.cod_carac and cd.cod_cotizacion=".$codCotizacion." and cd.cod_compitem=".$codCompItem;
					$sql5.=" and cd.COD_COTIZACIONDETALLE=".$c;
					$sql5.=" order by cd.cod_carac asc";		
					$resp5= mysql_query($sql5);
					while($dat5=mysql_fetch_array($resp5)){					
						$descCarac=$dat5[0];
						$descripcion=$dat5[1];
						$descriptcionEstadoDetalle="";
						$codEstadoDetalle=$dat5[2];						
						if($codEstadoDetalle==1){
							$descriptcionEstadoDetalle="";
						}else{
							$descriptcionEstadoDetalle="";
						}
					?>
					<ul><li><?php echo $descCarac;?>&nbsp;:&nbsp;<?php echo $descripcion;?>&nbsp;&nbsp;<b><?php echo $descriptcionEstadoDetalle;?></b></li></li></ul>
					<?php
					}
					?>
				</ul>
				<?php
				}
				?>
				</td>
				<td class="bordeNegroTd" align="right"><?php echo $precioVenta;?></td>
				<td class="bordeNegroTd" align="right"><?php echo $descuento;?></td>
				<td class="bordeNegroTd" align="right"><?php echo $importeTotal;?></td>				
			</tr>
			<?php
			}
?>			
<tr>
	<td class="bordeNegroTd" colspan="4"><b>Total</b></td>
	<td class="bordeNegroTd" align="right"><b><?php echo $sumImporteTotal;?></b></td>
</tr>
	</TABLE>	
<?php
}
?>		
<?php require("cerrar_conexion.inc");
?>
</body>
</html>
