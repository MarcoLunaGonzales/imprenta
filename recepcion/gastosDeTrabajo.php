
<html >

<body >
<form method="post"  name="form1" >

<?php 	
header("Content-type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=archivo.xls"); 	


	require("conexion.inc");
	include("funciones.php");	
	$cod_cotizacion=$_GET['cod_cotizacion'];
	
	//////////////////////////////////DATOS DE CABECERA DE LA COTIZACION///////////////////////////
	
	$sql=" select cod_tipo_cotizacion, cod_estado_cotizacion, nro_cotizacion, cod_gestion,cod_cliente, ";
	$sql.="  fecha_cotizacion, obs_cotizacion, cod_tipo_pago, cod_sumar, considerar_precio_unitario, cod_usuario_firma ";
	$sql.=" from cotizaciones ";
	$sql.=" where cod_cotizacion='".$cod_cotizacion."'";
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$cod_tipo_cotizacion=$dat[0];
		$cod_estado_cotizacion=$dat[1];
		$nro_cotizacion=$dat[2];
		$cod_gestion_cot=$dat[3];		
		$cod_cliente=$dat[4];
		$fecha_cotizacion=$dat[5];
		$obs_cotizacion=$dat[6];
		$cod_tipo_pago=$dat[7];
		$cod_sumar=$dat[8];
		$considerar_precio_unitario=$dat[9]; 
		$cod_usuario_firma=$dat[10];
		/////////////////CLIENTE////////////////////////////
		$nombre_cliente="";
		$sql2="select nombre_cliente from clientes where cod_cliente='".$cod_cliente."'";
		$resp2= mysql_query($sql2);
		$nombre_cliente="";
		$dat2=mysql_fetch_array($resp2);
		$nombre_cliente=$dat2[0];
		/////////////////FIN CLIENTE////////////////////////////
				
		/////////////////GESTION COTIZACION////////////////////////////
		$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion_cot."'";
		$resp2= mysql_query($sql2);
		$gestionCotizacion="";
		$dat2=mysql_fetch_array($resp2);
		$gestionCotizacion=$dat2[0];
		/////////////////FIN GESTION COTIZACION////////////////////////////
	}	
	//////////////////////////////////FIN DATOS DE CABECERA DE LA COTIZACION///////////////////////////
	
	//////////////////////////////////DATOS DE CABECERA DE HOJA DE RUTA///////////////////////////
	$sql=" select cod_hoja_ruta, cod_gestion, nro_hoja_ruta, fecha_hoja_ruta, cod_usuario_hoja_ruta,";
	$sql.=" obs_hoja_ruta, cod_cotizacion,factura_si_no, cod_usuario_comision ";
	$sql.=" from hojas_rutas ";
	$sql.=" where cod_cotizacion='".$cod_cotizacion."' and cod_estado_hoja_ruta=1";
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$cod_hoja_ruta=$dat[0];
		$cod_gestion_hoja_ruta=$dat[1];	
		$nro_hoja_ruta=$dat[2];
		$fecha_hoja_ruta=$dat[3];
		$cod_usuario_hoja_ruta=$dat[4];
		$obs_hoja_ruta=$dat[5];
		$cod_cotizacion=$dat[6];
		$factura_si_no=$dat[7];
		$cod_usuario_comision=$dat[8];
		/////////////////GESTION HOJA RUTA////////////////////////////
		$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion_hoja_ruta."'";
		$resp2= mysql_query($sql2);
		$gestionHojaRuta="";
		$dat2=mysql_fetch_array($resp2);
		$gestionHojaRuta=$dat2[0];
		/////////////////FIN GESTION HOJA RUTA////////////////////////////			
	}		
	//////////////////////////////////FIN DATOS DE CABECERA DE HOJA DE RUTA///////////////////////////

	

	
	?>
		<table  border="1" align="center" width="100%" >
	<tr>
		<td colspan="6" align="center"><strong>DETALLE DE GASTOS</strong></td>
				
	</tr>
	<tr>
		<td colspan="6" align="center"><strong><?php echo $nombre_cliente;?></strong></td>
				
	</tr>
	<tr>
		<td align="right"><strong>FACT:</strong></td>
		<td colspan="5"><?php echo "C-".$factura_si_no;?></td>		
	</tr>
	<tr>
		<td align="right"><strong>HR:</strong></td>
		<td colspan="5"><?php echo $nro_hoja_ruta."/".$gestionHojaRuta?></td>		
	</tr>
	<tr>
		<td align="right"><strong>COT:</strong></td>
		<td colspan="5"><?php echo $nro_cotizacion."/".$gestionCotizacion?></td>		
	</tr>
	<tr >
		<td align="right"><strong>NR:</strong></td>
		<td colspan="5">
		<?php 
			$sql=" select cod_nota_remision, cod_gestion,nro_nota_remision, fecha_nota_remision ";
			$sql.=" from notas_remision ";
			$sql.=" where cod_hoja_ruta='".$cod_hoja_ruta."'";
			$resp= mysql_query($sql);
			while($dat=mysql_fetch_array($resp)){
				$cod_nota_remision=$dat[0];
				$cod_gestion_nota_remision=$dat[1];	
				$nro_nota_remision=$dat[2];
				$fecha_nota_remision=$dat[3];
				/////////////////GESTION HOJA RUTA////////////////////////////
				$sql2="select gestion from gestiones where cod_gestion=".$cod_gestion_nota_remision."";
				$resp2= mysql_query($sql2);
				$gestionNotaRemision="";
				$dat2=mysql_fetch_array($resp2);
				$gestionNotaRemision=$dat2[0];
				/////////////////FIN GESTION HOJA RUTA////////////////////////////	
				
				echo $nro_nota_remision."/".$gestionNotaRemision."; ";		
	
			}	
		?>
		</td>		
	</tr>
  </table>
<br>
	<table   width="100%" border="1" >
	<tr height="20px" align="center" >
			<td>Item</td>
    		<td>Cantidad</td>	
			<td colspan="3">Descripcion</td>															
    		<td>Costo</td>
	</tr>
	
			
	<?php
		
		$sql=" select cod_cotizacion, cod_cotizaciondetalle ";
		$sql.=" from hojas_rutas_detalle ";
		$sql.=" where cod_hoja_ruta=".$cod_hoja_ruta." order by  cod_cotizaciondetalle asc";
		//echo $sql;
		$resp= mysql_query($sql);
		$sumaTotal=0;
		$cont=0;
		while($dat=mysql_fetch_array($resp)){
		$cont++;
			$cod_cotizacion=$dat[0];
			$cod_cotizaciondetalle=$dat[1];			
			
			$sql2=" select cod_item, descripcion_item, cantidad_unitariacotizacion,";
			$sql2.=" precio_venta, descuento, importe_total, orden, cod_estado_detallecotizacionitem ";
			$sql2.=" from cotizaciones_detalle ";
			$sql2.=" where cod_cotizacion=".$cod_cotizacion." and cod_cotizaciondetalle=".$cod_cotizaciondetalle;	
			$resp2= mysql_query($sql2);
			while($dat2=mysql_fetch_array($resp2)){	
							
				$cod_item=$dat2[0];
				$descripcion_item=$dat2[1]; 
				$cantidad_unitariacotizacion=$dat2[2];
		 		$precio_venta=$dat2[3]; 
				$descuento=$dat2[4];
				$importe_total=$dat2[5];
				$orden=$dat2[6];
				$cod_estado_detallecotizacionitem=$dat2[7];	
							
				if($considerar_precio_unitario==1){ 
					$sumaTotal=$sumaTotal+($cantidad_unitariacotizacion *$precio_venta);	
					$importe_total=$cantidad_unitariacotizacion *$precio_venta;		
				}else{
	         		$sumaTotal=$sumaTotal+($importe_total);
				}
				
				$desc_item="";
				$sql3="select desc_item  from items where cod_item=".$cod_item."";
				$resp3=mysql_query($sql3);
				$desc_item="";
				while($dat3=mysql_fetch_array($resp3)){
					$desc_item=$dat3[0];
				}		
				
				
			
		?>
					
		<tr bgcolor="#FFFFFF">		     		
		   <td align="center"><?php echo $cont;?></td>
		   <td align="center"><?php echo $cantidad_unitariacotizacion; ?></td>
		   <td colspan="3">
		   <?php 
		   		echo $desc_item." ".$descripcion_item."<br>";
				
				////////////////////////////////////////////////////////////////
				$sql3=" select count(distinct(cod_compitem)) as nro_compitem";
				$sql3.=" from cotizacion_detalle_caracteristica ";
				$sql3.=" where cod_cotizacion=".$cod_cotizacion;
				$sql3.=" and cod_cotizaciondetalle=".$cod_cotizaciondetalle;
				$resp3= mysql_query($sql3);
				$nro_compitem=0;
				while($dat3=mysql_fetch_array($resp3)){
					$nro_compitem=$dat3[0];
				}
				$detalle_item="";
				
				$sql4=" select  distinct(cod_compitem) as cod_compitem  from cotizacion_detalle_caracteristica ";
				$sql4.=" where cod_cotizaciondetalle='".$cod_cotizaciondetalle."' and cod_cotizacion='".$cod_cotizacion."'";
				$resp4=mysql_query($sql4);
				while ($dat4=mysql_fetch_array($resp4)){
		
					$cod_compitem=$dat4[0];
					$sql4=" select  count(*) from cotizacion_detalle_caracteristica ";
					$sql4.=" where cod_cotizaciondetalle='".$cod_cotizaciondetalle."' and cod_cotizacion='".$cod_cotizacion."'";
					$sql4.=" and cod_compitem='".$cod_compitem."' and cod_estado_registro=1";
					$resp4=mysql_query($sql4);
					$nro_carac=0;
					while($dat4=mysql_fetch_array($resp4)){
						$nro_carac=$dat4[0];
					}
				
					if($nro_carac>0){														
						$nombre_componenteitem="";
						$sql5=" select nombre_componenteitem from componente_items where cod_compitem='".$cod_compitem."'";
						$resp5=mysql_query($sql5);
						$dat5=mysql_fetch_array($resp5);
							$nombre_componenteitem=$dat5[0];					
						if($nro_compitem>1){
							echo $nombre_componenteitem."<br>";
						}
						
						/**********************************/
						$sql3=" select  cod_carac, desc_carac, cod_estado_registro ";
						$sql3.=" from cotizacion_detalle_caracteristica ";
						$sql3.=" where cod_cotizaciondetalle='".$cod_cotizaciondetalle."'";
						$sql3.=" and cod_cotizacion='".$cod_cotizacion."'";
						$sql3.=" and cod_compitem='".$cod_compitem."'";
						$sql3.=" and cod_estado_registro=1";
						$resp3=mysql_query($sql3);
						while ($dat3=mysql_fetch_array($resp3)){						
							$cod_carac=$dat3[0];	
							$desc_carac=$dat3[1];
							$desc_carac=str_replace("|",",",$desc_carac);
							$cod_estado_registro=$dat3[2];											
							/*************************/
							$desc_caracT="";
							$sql5=" select desc_carac from caracteristicas where cod_carac='".$cod_carac."'";
							$resp5=mysql_query($sql5);
							$dat5=mysql_fetch_array($resp5);
								$desc_caracT=$dat5[0];	
							/*************************/		
							echo $desc_caracT.":".$desc_carac."<br>";
						}		
					}	
				}
				/////////////////////////////////////////////////////////////////

		   
		   
		    ?></td>
		   <td align="right"><?php echo $importe_total;?></td>
								
		</tr>
		<?php			
			 	}
		}	
	?>
		<tr bgcolor="#FFFFFF">		     		
		   <td  align="center"><strong>A/C Bs.</strong></td>
		   <td>&nbsp;</td>
		   <td align="center"><strong>SALDO</strong></td>
		   <td>&nbsp;</td>
		   <td align="center"><strong>TOTAL</strong></td>
		   <td align="right"><?php echo $sumaTotal;?></td>
								
		</tr>		
  </table>	
	<br>
	<table  width="100%"  align="center" border="1">
	<tr height="20px" align="center" >
			<td>Fecha</td>
    		<td  colspan="2">Descripcion</td>	
			<td>Cant.</td>															
    		<td>Rec. Fact.</td>
			<td>Bs.</td>
	</tr>
	<tr bgcolor="#FFFFFF">		     		
		   <td>&nbsp;</td>
		   <td  colspan="2">&nbsp;</td>
		   <td>&nbsp;</td>
		   <td>&nbsp;</td>
		   <td>&nbsp;</td>						
	</tr>	
	</table>
</form>

</body>
</html>
