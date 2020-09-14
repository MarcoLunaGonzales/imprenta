<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Detalle Salida</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->

<?php 	


	require("conexion.inc");
	include("funciones.php");
	$cod_salida=$_GET['cod_salida'];
	
	$sql=" select s.cod_salida, s.cod_tipo_salida, s.nro_salida,  ";
	$sql.=" s.cod_gestion, g.gestion, s.cod_almacen, s.fecha_salida,  ";
 	$sql.=" s.cod_usuario_salida, s.obs_salida, s.cod_almacen_traspaso, s.cod_hoja_ruta, s.cliente_venta, ";
 	$sql.=" s.cod_estado_salida, s.fecha_modifica, s.cod_usuario_modifica, "; 
 	$sql.=" s.fecha_anulacion, s.cod_usuario_anulacion, s.obs_anulacion,s.cod_orden_trabajo, ";
	$sql.=" s.cod_cliente_venta, s.cod_contacto, s.cod_tipo_pago, s.cod_area, s.cod_usuario ";
	$sql.=" from salidas s, gestiones g  ";
	$sql.=" where s.cod_gestion=g.cod_gestion  ";
	$sql.=" and s.cod_salida='".$cod_salida."'";
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
				
				$cod_salida=$dat[0];
				$cod_tipo_salida=$dat[1];
				$nro_salida=$dat[2];
				$cod_gestion=$dat[3];
				$gestion=$dat[4];
				$cod_almacen=$dat[5];
				$fecha_salida=$dat[6];
 				$cod_usuario_salida=$dat[7];
				$obs_salida=$dat[8];
				$cod_almacen_traspaso=$dat[9];
				$cod_hoja_ruta=$dat[10];
				$cliente_venta=$dat[11];
			 	$cod_estado_salida=$dat[12];
				$fecha_modifica=$dat[13];
				$cod_usuario_modifica=$dat[14];
			 	$fecha_anulacion=$dat[15];
				$cod_usuario_anulacion=$dat[16];
				$obs_anulacion=$dat[17];
				$cod_orden_trabajo=$dat[18];
				$cod_cliente_venta=$dat['cod_cliente_venta'];
				$cod_contacto=$dat['cod_contacto'];
				$cod_tipo_pago=$dat['cod_tipo_pago'];
				$cod_area=$dat['cod_area'];
				$cod_usuario=$dat['cod_usuario'];
					
				
				//////////datos almacen////////
				$sql2="select nombre_almacen from almacenes where cod_almacen='".$cod_almacen."'";
				$resp2= mysql_query($sql2);
				$nombre_almacen="";
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_almacen=$dat2[0];
				}	
				////fin datos almacen///////////
				$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios ";
				$sql2.=" where cod_usuario='".$cod_usuario_salida."'";
				$resp2= mysql_query($sql2);
				$nombres_usuario="";
				$ap_paterno_usuario="";
				$ap_materno_usuario="";		
				while($dat2=mysql_fetch_array($resp2)){	
					$nombres_usuario=$dat2[0];
					$ap_paterno_usuario=$dat2[1];
					$ap_materno_usuario=$dat2[2];		
				}	
				
				//******************************TIPO DE salida********************************
				$nombre_tipo_salida="";
				$sql2="select nombre_tipo_salida from tipos_salida where cod_tipo_salida='".$cod_tipo_salida."'";
				$resp2= mysql_query($sql2);			
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_tipo_salida=$dat2[0];
				}
				if($cod_tipo_salida==2 or $cod_tipo_salida==4){
					$sql2=" select  hr.nro_hoja_ruta, hr.cod_gestion,g.gestion, hr.cod_cotizacion, hr.factura_si_no,";
					$sql2.=" c.cod_cliente, cli.nombre_cliente ";
					$sql2.=" from hojas_rutas hr, gestiones g, cotizaciones c, clientes cli ";
					$sql2.=" where hr.cod_hoja_ruta=".$cod_hoja_ruta;
					$sql2.=" and hr.cod_gestion=g.cod_gestion ";
					$sql2.=" and hr.cod_cotizacion=c.cod_cotizacion ";
					$sql2.=" and c.cod_cliente=cli.cod_cliente ";
					$resp2= mysql_query($sql2);
					$nro_hoja_ruta_salida="";
					$cod_gestion_salida="";
					$gestion_salida="";
					$cod_cotizacion_salida="";
					$cod_cliente_salida="";
					$nombre_cliente_salida="";
					while($dat2=mysql_fetch_array($resp2)){
					
						$nro_hoja_ruta_salida=$dat2[0];
						$cod_gestion_salida=$dat2[1];
						$gestion_hoja_ruta_salida=$dat2[2];
						$cod_cotizacion_salida=$dat2[3];
						$factura_si_no=$dat2[4];
						$cod_cliente_salida=$dat2[5];
						$nombre_cliente_salida=$dat2[6];
					
					}
				}				
				if($cod_tipo_salida==3){
						$sql2="select nombre_almacen from almacenes where cod_almacen='".$cod_almacen_traspaso."'";
						$resp2= mysql_query($sql2);
						$nombre_almacen_traspaso="";
						while($dat2=mysql_fetch_array($resp2)){
							$nombre_almacen_traspaso=$dat2[0];
						}	
				}
				if($cod_tipo_salida==5){
						$sql2="select  numero_orden_trabajo, fecha_orden_trabajo, ";
						$sql2.=" cod_cliente, obs_orden_trabajo, monto_orden_trabajo,nro_orden_trabajo, cod_gestion ";
						$sql2.=" from ordentrabajo ";
						$sql2.=" where cod_orden_trabajo=".$cod_orden_trabajo;		
						$resp2= mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2)){
						//////////////////////////////////

							$numero_orden_trabajo=$dat2['numero_orden_trabajo']; 
							$fecha_orden_trabajo=$dat2['fecha_orden_trabajo']; 
							$cod_cliente=$dat2['cod_cliente']; 
							$obs_orden_trabajo=$dat2['obs_orden_trabajo']; 
							$monto_orden_trabajo=$dat2['monto_orden_trabajo']; 
							$nro_orden_trabajo=$dat2['nro_orden_trabajo'];
							$cod_gestion_ot=$dat2['cod_gestion'];
						}
							//**************************************************************
							$nombre_cliente_orden_trabajo="";
							$sql2="select nombre_cliente from clientes where cod_cliente='".$cod_cliente."'";
							$resp2= mysql_query($sql2);
							while($dat2=mysql_fetch_array($resp2)){
								$nombre_cliente_orden_trabajo=$dat2['nombre_cliente'];
							}	
							$gestion_ot="";
							$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion_ot."'";
							$resp2= mysql_query($sql2);
							while($dat2=mysql_fetch_array($resp2)){
								$gestion_ot=$dat2['gestion'];
							}											
				//**************************************************************						
						//////////////////////////////////
						
				}		
				
				if($cod_tipo_salida==6){
					$nombre_area="";
					$usuario_uso_interno="";
					if($cod_area<>""){
						$sql2="select  nombre_area";
						$sql2.=" from areas ";
						$sql2.=" where cod_area=".$cod_area;		
						$resp2= mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2)){
							$nombre_area=$dat2['nombre_area']; 
						}
					}
					if($cod_usuario<>""){
						$sql2="select nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
						$sql2.=" from usuarios ";
						$sql2.=" where cod_usuario=".$cod_usuario;		
						$resp2= mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2)){
							$usuario_uso_interno=$dat2['ap_paterno_usuario']." ".$dat2['ap_materno_usuario']." ".$dat2['nombres_usuario']; 

						}
					}					

						
				}							
				
				$sql2=" select desc_estado_salida from estados_salidas_almacen ";
				$sql2.=" where cod_estado_salida='".$cod_estado_salida."'";
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
						$desc_estado_salida=$dat2[0];
				}
 }
		

?>

<h3 align="center" style="background:white;font-size: 12px;color:#E78611;font-weight:bold;">SALIDA <BR>  No. <?php echo $nro_salida;?>/<?php echo $gestion;?></h3>
   <?php if($cod_estado_salida==2){?>
  	<h3 align="center" style="background:white;font-size: 14px;color:#FF0000;font-weight:bold;">
	  <?php echo $desc_estado_salida;?>
</h3>
  <?php }?>
  <div align="center"><a onClick="window.print();"><img src="img/imprimir.jpg" border="0"></a>
</div>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0">
		 <tr class="titulo_tabla">
		   <td  colSpan="12" align="center">DATOS</td>
		 </tr>
		<tr bgcolor="#FFFFFF">
			<td>Almacen </td>
			<td  colSpan="10"><?php echo $nombre_almacen; ?></td>
		</tr>	
		<tr bgcolor="#FFFFFF">
			<td>Fecha</td>
			<td  colSpan="10"><?php echo $fecha_salida; ?></td>
		</tr>							 
		 <tr bgcolor="#FFFFFF">
     		<td>Responsable de Salida</td>
      		<td  colSpan="10"><?php echo $nombres_usuario." ".$ap_paterno_usuario;?></td>
		 </tr>	
		 	
		<tr bgcolor="#FFFFFF">
			<td>Tipo de Salida </td>
			<td  colSpan="10"><?php echo $nombre_tipo_salida; ?></td>
		</tr>	
		<?php if($cod_tipo_salida==1){
			
						if($cod_cliente_venta<>""){
							$sqlAux="select nombre_cliente from clientes where cod_cliente=".$cod_cliente_venta;
							$respAux = mysql_query($sqlAux);
							while($datAux=mysql_fetch_array($respAux)){	
								$nombre_cliente_venta=$datAux['nombre_cliente'];
							}	
							if($cod_contacto<>""){
								$sqlAux=" select nombre_contacto, ap_paterno_contacto from clientes_contactos ";
								$sqlAux.=" where cod_contacto=".$cod_contacto;
								$respAux = mysql_query($sqlAux);
								while($datAux=mysql_fetch_array($respAux)){	
									$nombre_contacto=$datAux['nombre_contacto'];
									$ap_paterno_contacto=$datAux['ap_paterno_contacto'];
								}
							}
						}
		
						if($cod_tipo_pago<>""){
							$sqlAux="select nombre_tipo_pago from tipos_pago where cod_tipo_pago=".$cod_tipo_pago;
							$respAux = mysql_query($sqlAux);
							while($datAux=mysql_fetch_array($respAux)){	
								$nombre_tipo_pago=$datAux['nombre_tipo_pago'];
							}
						}
			?>
		<tr bgcolor="#FFFFFF">
			<td>Cliente</td>
			<td  colSpan="10"><?php echo $cliente_venta.$nombre_cliente_venta."( ".$nombre_contacto." ".$ap_paterno_contacto.")"; ?></td>
		</tr>

		<tr bgcolor="#FFFFFF">
			<td>Tipo de Pago</td>
			<td  colSpan="10"><?php echo $nombre_tipo_pago; ?></td>
		</tr>                			
		<?php }?>		
		<?php if($cod_tipo_salida==2 or $cod_tipo_salida==4){?>
		<tr bgcolor="#FFFFFF">
			<td>Hoja de Ruta</td>
			<td  colSpan="10">
			<?php  echo "No. ".$nro_hoja_ruta_salida."/".$gestion_hoja_ruta_salida."(".$nombre_cliente_salida.")";?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  REF.:<?php echo "C".$factura_si_no;?>
            </td>
		</tr>	        		
		
		<?php }?>	
		<?php if($cod_tipo_salida==3){?>
			<tr bgcolor="#FFFFFF">
				<td>Almacen Traspaso</td>
				<td  colSpan="10"><?php echo $nombre_almacen_traspaso; ?></td>
			</tr>
		<?php }?>	
		<?php if($cod_tipo_salida==5){?>
			<tr bgcolor="#FFFFFF">
				<td>Nro Orden Trabajo</td>
				<td  colSpan="10"><?php echo "Nro.".$nro_orden_trabajo."/".$gestion_ot." (".$nombre_cliente_orden_trabajo.")";?>
            </td>
			</tr>
		<?php }?>
		<?php if($cod_tipo_salida==6){?>
			<tr bgcolor="#FFFFFF">
				<td>Area</td>
				<td  colSpan="10"><?php echo $nombre_area;?>
            </td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td>Usuario Solicitante</td>
				<td  colSpan="10"><?php echo $usuario_uso_interno;?>
            </td>
			</tr>            
		<?php }?>        	        				
			<tr bgcolor="#FFFFFF">
				<td>Observaciones</td>
				<td  colSpan="10"><?php echo $obs_salida; ?></td>
			</tr>		
		<tr class="titulo_tabla">
		   <td  colSpan="12" align="center">DETALLE DE MATERIALES</td>
		 </tr>						
		 <tr class="titulo_tabla" align="center">
		   	<td colspan="2" rowspan="2" >Material</td>			
			<td rowspan="2">Cantidad Salida</td>
			<td colspan="4" align="center">Detalle</td>	
			<td rowspan="2"> Costo Total</td>
			<?php if($cod_tipo_salida==1){?>		
					<td rowspan="2">Precio Venta</td>
					<td rowspan="2">Importe Venta</td>
			<?php }?>		
		 </tr>
		 <tr class="titulo_tabla">
			<td><div align="center">Cantidad</div></td>	
			<td><div align="center">Costo Unitario </div></td>
			<td><div align="center">Costo Subtotal</div></td>
			<td><div align="center">Nro Ingreso</div></td>
		 </tr>
		 
		 <?php

		 	$costoTotalSalida=0;
			$precioVentaTotalSalida=0;
		 	$sql=" select sd.cod_material, m.desc_completa_material, m.cod_unidad_medida, ";
			$sql.=" um.abrev_unidad_medida, sd.cant_salida, sd.precio_venta ";
			$sql.=" from salidas_detalle sd, materiales m, unidades_medidas um ";
			$sql.=" where sd.cod_salida=".$cod_salida;
			$sql.=" and sd.cod_material=m.cod_material ";
			$sql.=" and m.cod_unidad_medida=um.cod_unidad_medida ";
			$resp = mysql_query($sql);
			
			while($dat=mysql_fetch_array($resp)){
			$sw=0;
				$cod_material=$dat[0];
				$desc_completa_material=$dat[1];
				$cod_unidad_medida=$dat[2];
				$abrev_unidad_medida=$dat[3];
				$cant_salida=$dat[4];
				$precio_venta=$dat[5];	
				$precioVentaTotalSalida=$precioVentaTotalSalida+($cant_salida*$precio_venta);		
				$sql2=" select count(*) from salidas_detalle_ingresos ";
				$sql2.=" WHERE cod_salida=".$cod_salida." and cod_material=".$cod_material;	
				$resp2 = mysql_query($sql2);
				$numDetalle=0;
				while($dat2=mysql_fetch_array($resp2)){
					$numDetalle=$dat2[0];
				}
				//////////////////////////////////////////
					$costoTotal=0;
					$sql2=" select cant_salida_ingreso, cod_ingreso_detalle from salidas_detalle_ingresos ";
					$sql2.=" WHERE cod_salida=".$cod_salida." and cod_material=".$cod_material;
					$resp2 = mysql_query($sql2);					
					while($dat2=mysql_fetch_array($resp2)){
						$cant_salida_ingreso=$dat2[0];
						$cod_ingreso_detalle=$dat2[1];						
						
						$sql3=" select ig.cod_ingreso, i.nro_ingreso, i.cod_gestion, g.gestion, ig.precio_compra_uni";
						$sql3.=" from ingresos_detalle ig, ingresos i, gestiones g ";
						$sql3.=" where ig.cod_ingreso=i.cod_ingreso  and  g.cod_gestion=i.cod_gestion ";
						$sql3.=" and ig.cod_ingreso_detalle=".$cod_ingreso_detalle." and ig.cod_material=".$cod_material;
						$resp3 = mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3)){
							$cod_ingreso=$dat3[0];
							$nro_ingreso=$dat3[1];
							$cod_gestion_ingreso=$dat3[2];													
							$gestion_ingreso=$dat3[3];													
							$precio_compra_uni=$dat3[4];														
							$costoTotal=$costoTotal+($precio_compra_uni*$cant_salida_ingreso);	
					 }
					}				
				/////////////////////////////////////////
				
		?>
			<tr bgcolor="#FFFFFF">					
					<td rowspan="<?php echo $numDetalle;?>"><strong><?php echo $desc_completa_material; ?></strong></td>    			
					<td rowspan="<?php echo $numDetalle;?>" align="center"><strong><?php echo $abrev_unidad_medida; ?></strong></td>
					<td rowspan="<?php echo $numDetalle;?>" align="right" ><strong><?php echo $cant_salida; ?></strong></td>							
		<?php				
				
				////////////////////////////////////////////////////////	
					$sql2=" select cant_salida_ingreso, cod_ingreso_detalle ";
					$sql2.=" from salidas_detalle_ingresos ";
					$sql2.=" WHERE cod_salida=".$cod_salida;
					$sql2.=" and cod_material=".$cod_material;
					$sql2.=" order by cod_ingreso_detalle asc";
					$resp2 = mysql_query($sql2);					
					while($dat2=mysql_fetch_array($resp2)){
						$cant_salida_ingreso=$dat2[0];
						$cod_ingreso_detalle=$dat2[1];						
						
						$sql3=" select ig.cod_ingreso, i.nro_ingreso, i.cod_gestion, g.gestion,  ";
						$sql3.=" ig.precio_compra_uni";
						$sql3.=" from ingresos_detalle ig, ingresos i, gestiones g ";
						$sql3.=" where ig.cod_ingreso=i.cod_ingreso ";
						$sql3.=" and  g.cod_gestion=i.cod_gestion ";
						$sql3.=" and ig.cod_ingreso_detalle=".$cod_ingreso_detalle;
						$sql3.=" and ig.cod_material=".$cod_material;
						$resp3 = mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3)){
							$cod_ingreso=$dat3[0];
							$nro_ingreso=$dat3[1];
							$cod_gestion_ingreso=$dat3[2];													
							$gestion_ingreso=$dat3[3];													
							$precio_compra_uni=$dat3[4];																																	
						?>
						<?php if($sw==1){?>
							<tr bgcolor="#FFFFFF">
						<? }?>
		
							<td align="right"><?php echo $cant_salida_ingreso; ?></td>
							<td align="right"><?php echo $precio_compra_uni; ?></td>
							<td align="right"><?php echo $cant_salida_ingreso*$precio_compra_uni; ?></td>
							<td align="right"><?php echo $nro_ingreso."/".$gestion_ingreso; ?></td>
							
						<?php if($sw==1){?>
							</tr>
						<? }?>

						<?php
							}
						?>
						<?php
							if($sw==0){
						?>
						<td rowspan="<?php  echo $numDetalle;?>" align="right"><strong><?php echo $costoTotal;?></strong></td>
			<?php if($cod_tipo_salida==1){?>		
					<td  rowspan="<?php  echo $numDetalle;?>" align="right"><strong><?php echo $precio_venta; ?></strong></td>
					<td rowspan="<?php  echo $numDetalle;?>" align="right"><strong><?php echo $precio_venta*$cant_salida; ?></strong></td>			
					</tr>		
			<?php }?>							
						<?php
																																	
						}
						$sw=1;	
					?>
					

								
					<?php				
					}
					$costoTotalSalida=$costoTotalSalida+$costoTotal;
				///////////////////////////////////////////
			?>

		<?php
			}

		 ?>
		 <tr bgcolor="#FFFFFF">					
					<td colspan="7" align="right" ><strong>Costo Total</strong></td>    			 													
					<td align="right"><strong><?php echo $costoTotalSalida;?></strong></td>   
					<?php if($cod_tipo_salida==1){?>					
					<td align="right"><strong>Total Venta</strong></td>    			 													
					<td align="right"><strong><?php echo $precioVentaTotalSalida;?></strong></td> 	
					<?php }?>	
	 <?php if($cod_estado_salida==2){?>
	  
	  <tr bgcolor="#FFFFFF">
	  <td><strong>MOTIVO DE ANULACION:</strong></td>
	  <td colspan="9">
  	
	<h3 align="left" style="background:white;font-size: 12px;color:#FF0000;font-weight:bold;">
	  <?php echo $obs_anulacion;?>
	  </h3>
	  </td>
	  </tr>
	  
  <?php }?>
  					   			
		</table>	



</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>
