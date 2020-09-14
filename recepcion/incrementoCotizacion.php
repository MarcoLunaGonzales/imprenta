<?php
	require("conexion.inc");
	


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>INVENTA</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />

<script language='Javascript'>

	function cerrarVentana(){
			window.close();
	}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>
<body >
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="editIncrementoCotizacion.php" name="form1">

<?php 

	$cod_cotizacion=$_GET['cod_cotizacion'];
?>
<input type="hidden" name="cod_cotizacion" id="cod_cotizacion" value="<?php echo $cod_cotizacion; ?>">
<?php
	
		$sql=" select  c.cod_tipo_cotizacion, tc.nombre_tipo_cotizacion, c.cod_estado_cotizacion, ";
		$sql.=" ec.nombre_estado_cotizacion, c.nro_cotizacion,c.cod_cliente, cli.nombre_cliente,  c.fecha_cotizacion,"; 
		$sql.=" c.obs_cotizacion, c.cod_tipo_pago, tp.nombre_tipo_pago,  c.cod_gestion, g.gestion, c.cod_sumar,";
		$sql.=" c.considerar_precio_unitario, c.fecha_registro, c.cod_usuario_registro, c.fecha_modifica,";
		$sql.=" c.cod_usuario_modifica, c.cod_usuario_aprobacion, c.fecha_aprobacion, c.obs_cotizacion_impresion, ";		
		$sql.=" c.cod_usuario_firma, c.descuento_cotizacion,";
		$sql.=" c.descuento_fecha, c.descuento_obs, c.cod_usuario_descuento, c.obs_pago, ";
		$sql.=" c.incremento_cotizacion, c.incremento_fecha, c.incremento_obs ";
		$sql.=" from cotizaciones c, gestiones g, estados_cotizacion ec, tipos_cotizacion tc, tipos_pago tp, clientes cli ";
		$sql.=" where c.cod_gestion=g.cod_gestion ";
		$sql.=" and c.cod_estado_cotizacion=ec.cod_estado_cotizacion ";
		$sql.=" and c.cod_tipo_cotizacion=tc.cod_tipo_cotizacion ";
		$sql.=" and c.cod_tipo_pago=tp.cod_tipo_pago ";
		$sql.=" and c.cod_cliente=cli.cod_cliente ";
		$sql.=" and c.cod_cotizacion=".$cod_cotizacion;
		$resp = mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){

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

			 if($descuento_cotizacion==""){
			 	$descuento_cotizacion=0;
			 }

			    $sql2="  select count(*) swHojasRuta from hojas_rutas ";
				$sql2.=" where cod_cotizacion='".$cod_cotizacion."' and (cod_estado_hoja_ruta=1 or cod_estado_hoja_ruta=3)";
				$resp2= mysql_query($sql2);
				$swHojasRuta=0;
				while($dat2=mysql_fetch_array($resp2)){
					$swHojasRuta=$dat2[0];
				}
	 	}
	
	

?>
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">INCREMENTO</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0">

		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">DETALLE DE DESCUENTO </td>
		 </tr>
		<tr bgcolor="#FFFFFF">
     		<td>Nro Cotizacion</td>
      		<td> <?php echo $nro_cotizacion."/".$gestion; ?> </td>
    	</tr>
		<tr bgcolor="#FFFFFF">
     		<td>Fecha Cotizacion</td>
      		<td> <?php echo strftime("%d/%m/%Y",strtotime($fecha_cotizacion));?> </td>
    	</tr>
		<tr bgcolor="#FFFFFF">
     		<td>Cliente</td>
      		<td><?php echo $nombre_cliente;?></td>
    	</tr>			
		
		 <tr bgcolor="#FFFFFF">
     		<td>Monto </td>
      		<td>
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
							echo($monto_factura-$descuento_cotizacion)." Bs.";
					}
					
				 ?>
				 </td>
    	</tr>

		 <tr bgcolor="#FFFFFF">
     		<td>Monto de Incremento</td>
      		<td><?php 
				if($incremento_cotizacion<>''){
					echo $incremento_cotizacion." Bs.";
				}else{
					echo "0 Bs.";
				}
			?>
			</td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha de Incremento</td>
      		<td><?php echo $incremento_fecha;?></td>
    	</tr>        
		 <!--tr bgcolor="#FFFFFF">
     		<td>Obs. Incremento</td>
      		<td><?php echo $incremento_obs;?></td>
    	</tr-->
		 <tr bgcolor="#FFFFFF">
     		<td>Obs. Pago</td>
      		<td><?php echo $obs_pago;?></td>
    	</tr>									

	</table>	
	<br>
<div align="center">
<INPUT type="button" class="boton"  value="Cancelar" onClick="cerrarVentana(this.form);"  >
<INPUT type="submit" class="boton" value="Modificar Datos"   >
</div>
</form>

</body>
</html>
