<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>REGISTRO NOTA REMISION</title>
<script language="Javascript"> 
function guardar(f)
{
	var i;
	var j=0;
	var sw=0;
	vectorCotizacionDetalle=new Array();
	vectorCantidadesAEntregar=new Array();
	for(i=0;i<=f.length-1;i++)
	{
			if(f.elements[i].name=="cod_cotizaciondetalle")
			{		
				if(f.elements[i].type=='checkbox'){					
									
						if(f.elements[i].checked==true){
							//alert("cod_cotizaciondetalle="+f.elements[i].value);	
							//alert("cantidad="+f.elements[i+1].value);	
							vectorCotizacionDetalle[j]=f.elements[i].value;
							vectorCantidadesAEntregar[j]=f.elements[i+1].value;
							j=j+1;
						}

				}										
			}	
				
	}


	f.vectorCotizacionDetalle.value=vectorCotizacionDetalle;
	f.vectorCantidadesAEntregar.value=vectorCantidadesAEntregar;
	
	f.submit();		

}
function atras(f){
			window.location="listHojasRutas.php";
}

</script>
</head>
<body bgcolor="#FFFFFF" >
<form method="post"  name="form1" action="guardaRegistroNotaRemision.php">

<?php 	
	require("conexion.inc");
	include("funciones.php");	
	$cod_hoja_ruta=$_GET['cod_hoja_ruta'];
	
	$sql = "select max(cod_nota_remision) from notas_remision";
	$cod_nota_remision = obtenerCodigo($sql);
	
	$cod_gestion_nota_remision=gestionActiva();
	
	$sql2="select gestion_nombre from gestiones where cod_gestion='".$cod_gestion_nota_remision."'";
	$resp2= mysql_query($sql2);
	$gestionNotaRemision="";
	while($dat2=mysql_fetch_array($resp2)){
		$gestionNotaRemision=$dat2[0];
	}
		
	$sql="select max(nro_nota_remision) from notas_remision where cod_gestion='".$cod_gestion_nota_remision."'";
	$nro_nota_remision=obtenerCodigo($sql);
	

	$fecha_nota_remision=date('d/m/Y', time());
	
	$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
	$sql2.=" from usuarios where cod_usuario='".$_COOKIE['usuario_global']."'";
	$resp2= mysql_query($sql2);
	$dat2=mysql_fetch_array($resp2);
	$entregadoPor=$dat2[0]." ".$dat2[1];
?>

<input type="hidden" name="cod_hoja_ruta" value="<?php echo $cod_hoja_ruta; ?>">
<input type="hidden" name="vectorCotizacionDetalle">
<input type="hidden" name="vectorCantidadesAEntregar">

<?php	

	$sql=" select  fecha_hoja_ruta, cod_usuario_hoja_ruta,obs_hoja_ruta, cod_cotizacion,  ";
	$sql.=" cod_estado_hoja_ruta, factura_si_no, cod_usuario_comision, cod_gestion, nro_hoja_ruta";
	$sql.=" from hojas_rutas ";
	$sql.=" where cod_hoja_ruta='".$cod_hoja_ruta."'";
	//echo $sql."<br>";
	$resp= mysql_query($sql);
	$dat=mysql_fetch_array($resp);

	$fecha_hoja_ruta=$dat[0];
	$cod_usuario_hoja_ruta=$dat[1];
	$obs_hoja_ruta=$dat[2]; 
	$cod_cotizacion=$dat[3]; 
	$cod_estado_hoja_ruta=$dat[4]; 
	$factura_si_no=$dat[5];
	$codusuariocomision=$dat[6];	
	$cod_gestion_hoja_ruta=$dat[7];
	$nro_hoja_ruta=$dat[8];
				/***********GESTION********/
					$gestionHojaRuta="";
					$sql3="select gestion_nombre  from gestiones where cod_gestion='".$cod_gestion_hoja_ruta."'";
					$resp3= mysql_query($sql3);
					$dat3=mysql_fetch_array($resp3);
						$gestionHojaRuta=$dat3[0];
				/************************************/		
	
	
	/************************USUARIO DE REGISTRO*****************/	
		$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
		$sql2.=" from usuarios where cod_usuario='".$cod_usuario_hoja_ruta."'";
		$resp2= mysql_query($sql2);
		$dat2=mysql_fetch_array($resp2);
		$UsuarioHojaRuta=$dat2[0]." ".$dat2[1];
	/************************************/	
		
		/********************DATOS COTIZACION********************/
			$sql2=" select nro_cotizacion, cod_gestion, cod_cliente, fecha_cotizacion ";
			$sql2.=" from cotizaciones ";
			$sql2.=" where cod_cotizacion=".$cod_cotizacion;
			$resp2= mysql_query($sql2);
			$dat2=mysql_fetch_array($resp2);
				$nro_cotizacion=$dat2[0];
				$cod_gestion=$dat2[1];
				$cod_cliente=$dat2[2];		
				$fecha_cotizacion=$dat2[3];	
				/***********GESTION********/
					$gestionCotizacion="";
					$sql3="select gestion_nombre  from gestiones where cod_gestion='".$cod_gestion."'";
					$resp3= mysql_query($sql3);
					$dat3=mysql_fetch_array($resp3);
						$gestionCotizacion=$dat3[0];
				/************************************/	
				/*******************CLIENTE*********************/	
					$sql3=" select nombre_cliente, direccion_cliente, telefono_cliente, celular_cliente, fax_cliente";
					$sql3.=" from clientes where cod_cliente='".$cod_cliente."'";
					$resp3= mysql_query($sql3);			
					$dat3=mysql_fetch_array($resp3);
						$nombre_cliente=$dat3[0];
						$direccion_cliente=$dat3[1];
						$telefono_cliente=$dat3[2];
						$celular_cliente=$dat3[3];
						$fax_cliente=$dat3[4];				
				/************************************/
		/******************FIN DATOS COTIZACION*********************/		

		
	?>
	<h3 align="center" style="background:white;font-size: 14px;color: #E78611;font-weight:bold;">REGISTRO DE NOTA DE REMISION </h3>
	<h3 align="center" style="background:white;font-size: 10px;color: #E78611;font-weight:bold;">No. <?php echo $nro_nota_remision."/".$gestionNotaRemision;?><?php echo "<br> Fecha:".$fecha_nota_remision;?></h3>
	<h3 align="center" style="background:white;font-size: 10px;color: #000033;font-weight:bold;">
	<?php echo "HR: ".$nro_hoja_ruta."/".$gestionHojaRuta;?><br>
	<?php echo "CLIENTE: ".$nombre_cliente;?><br>
	<?php echo "COT:".$nro_cotizacion."/".$gestionCotizacion; ?></h3>			
    <table  cellSpacing="1" cellPadding="2" width="90%" bgColor="#cccccc" border="0" id="tabla" align="center">
		<!--tr class="titulo_tabla">
			<td  colSpan="6" align="center">DATOS DE HOJA DE RUTA </td>
		</tr>
		<tr bgcolor="#FFFFFF">
     		<td>Hoja Ruta</td>
			<td>No. <?php echo $cod_hoja_ruta;?></td>
     		<td>Fecha</td>
			<td><?php echo $fecha_hoja_ruta;?></td>			
			<td  class="titulo_tabla" align="center">REF</td>
			<td  class="titulo_tabla" align="center">C</td>	
		</tr>		
		<tr bgcolor="#FFFFFF">
     		<td>Cliente</td>
			<td><?php echo $nombre_cliente;?></td>
			<td colspan="2">Telefono:<?php echo $telefono_cliente;?> &nbsp; Celular:
			<?php echo $celular_cliente;?> &nbsp;Fax:<?php echo $fax_cliente;?>
			</td>
			
			<td rowspan="2" align="center"><?php echo $nro_cotizacion;?>/<?php echo $gestion;?></td>
			<td rowspan="2" align="center"><?php echo $factura_si_no;?></td>			
		</tr>	
		<tr bgcolor="#FFFFFF">
     		<td>Autorizado por:</td>
     		<td colspan="3"><?php echo $UsuarioHojaRuta;?></td>
		</tr-->		
				
		<tr class="titulo_tabla">
			<td  colSpan="6" align="center"> NOTA DE REMISION</td>
		</tr>	
		<tr bgcolor="#FFFFFF">
     		<td>Entregado por </td>
     		<td colspan="5">
			<select name="cod_usuario_entregado_por"  class="textoform" >
				<option value="null">Seleccione un Usuario</option>				
				<?php
					$sql4="select cod_usuario, nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios ";
					$sql4.=" where cod_usuario<>2 ";
					$resp4=mysql_query($sql4);
						while($dat4=mysql_fetch_array($resp4))
						{
							$cod_usuario=$dat4[0];
							$nombres_usuario=$dat4[1];
							$ap_paterno_usuario=$dat4[2];
							$ap_materno_usuario=$dat4[3];
								
				 ?>
					 	<option value="<?php echo $cod_usuario;?>">
							<?php echo $nombres_usuario." ".$ap_paterno_usuario." ".$ap_materno_usuario;?>
						</option>				
				<?php		
						}
				?>						
			</select>	
			</td>
		</tr>
		<tr bgcolor="#FFFFFF">
     		<td>Recibido por </td>
     		<td colspan="5"><input type="text" name="recibido_por" class="textoform" size="40"></td>
		</tr>		
		<tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
     		<td colspan="5"><textarea name="obs_nota_remision" cols="60" ></textarea></td>
		</tr>		
		<tr class="titulo_tabla">
			<td  colSpan="6" align="center">DETALLE</td>
		</tr>	
		
	<?php
		
		$sql=" select cod_cotizaciondetalle,cod_item, descripcion_item, cantidad_unitariacotizacion,";
		$sql.=" precio_venta, descuento, importe_total, orden, cod_estado_detallecotizacionitem ";
		$sql.=" from cotizaciones_detalle ";
		$sql.=" where cod_cotizacion=".$cod_cotizacion;
		$sql.=" and cod_cotizaciondetalle in(select cod_cotizaciondetalle from hojas_rutas_detalle where cod_hoja_ruta='".$cod_hoja_ruta."')";
		$sql.=" order by  orden asc";
		$resp= mysql_query($sql);
		$sumaTotal=0;
		$cont=0;
		while($dat=mysql_fetch_array($resp)){
	
				$cont++;
				$cod_cotizaciondetalle=$dat[0];
				$cod_item=$dat[1];
				/************************items*****************/	
					$sql2="select desc_item  from items where cod_item='".$cod_item."'";
					$resp2= mysql_query($sql2);
					$desc_item="";
					while($dat2=mysql_fetch_array($resp2)){
						$desc_item=$dat2[0];
					}
				/************************************/					 
				$descripcion_item=$dat[2]; 
				$cantidad_unitariacotizacion=$dat[3];
		 		$precio_venta=$dat[4]; 
				$descuento=$dat[5];
				$importe_total=$dat[6];
				$orden=$dat[7];
				$cod_estado_detallecotizacionitem=$dat[8];	
							
				if($considerar_precio_unitario==1){ 
					$sumaTotal=$sumaTotal+($cantidad_unitariacotizacion *$precio_venta);				
				}else{
	         		$sumaTotal=$sumaTotal+($importe_total);
				}
				
		

			$sql6=" select  cod_usuario_diseno ,obs_trabajo, diseno, diseno_aprobacion, placas, cantidad_cpt ";
			$sql6.=" from hojas_rutas_detalle ";
			$sql6.=" where cod_hoja_ruta='".$cod_hoja_ruta."'";
			$sql6.=" and cod_cotizacion='".$cod_cotizacion."'";
			$sql6.=" and cod_cotizaciondetalle='".$cod_cotizaciondetalle."'";
			$resp6=mysql_query($sql6);
			$codusuariodiseno=0;
			$obs_trabajo="";
			$diseno=1;
			$diseno_aprobacion=1;
			$placas=1;
			$cantidad_cpt="";
			while($dat6=mysql_fetch_array($resp6)){
				$codusuariodiseno=$dat6[0];
				$obs_trabajo=$dat6[1];
				$diseno=$dat6[2];
				$diseno_aprobacion=$dat6[3];
				$placas=$dat6[4];
				$cantidad_cpt=$dat6[5];
			}	

			
		?>
		<tr bgcolor="#FFFFFF">						

		<td colspan="2" valign="top">
		<table border="0" width="100%" >
		<tr valign="top" class="titulo_tabla">
			<td colspan="4"  align="center">ITEM <?php echo $cont;?></td>
		</tr>			
		<tr bgcolor="#FFFFFF">		     		
		   <td align="right">
		   <input type="checkbox" name="cod_cotizaciondetalle"  value="<?php echo $cod_cotizaciondetalle;?>" checked="checked">
		   </td>
		   <td>
		   <strong><?php echo $cantidad_unitariacotizacion; ?></strong>&nbsp;<?php echo $desc_item." ".$descripcion_item; ?>
		   </td>
		   	
		<?php	if($considerar_precio_unitario==1){ ?>
			 <td align="right"><strong><?php echo $precio_venta;?></strong></td>		
			 <td align="right"><strong><?php echo $importe_total;?></strong></td>				
		<?php }else{ ?>
			 <td>&nbsp;</td>		
			 <td align="right"><strong><?php echo $importe_total;?></strong></td>
	         		
		<?php } ?>
									
		</tr>
		<?php
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
				$nombre_componenteitem="";
				$sql5=" select nombre_componenteitem from componente_items where cod_compitem='".$cod_compitem."'";
				$resp5=mysql_query($sql5);
				while ($dat5=mysql_fetch_array($resp5)){
					$nombre_componenteitem=$dat5[0];	
				}
				
				if($nro_compitem>1){

		?>
			<tr bgcolor="#FFFFFF">		
				<td align="right" valign="top">&nbsp;</td>
				<td><?php echo $nombre_componenteitem; ?></td>
				<td>&nbsp;</td>		
				<td>&nbsp;</td>
			</tr>
		
		<?php
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
				
			?>
			<tr bgcolor="#FFFFFF">		
				<td align="right" valign="top">&nbsp;</td>
				<td><?php echo $desc_caracT.":".$desc_carac; ?></td>
				<td>&nbsp;</td>		
	 			 <td>&nbsp;</td>
			</tr>
			<?php
				}	
			}
			
			?>
		</table>
		</td>
		<td colspan="2" valign="top">
		
		<table width="100%">
		<tr class="titulo_tabla">
				<td  colspan="4" align="center">TRABAJO</td>
		</tr>

		<tr bgcolor="#FFFFFF">		
				<td align="right">Asinado a :</td>
				<td colspan="2">
				<?php
					$sql3="select  nombres_usuario, ap_paterno_usuario from usuarios where cod_usuario='".$codusuariodiseno."'";
					$resp3=mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3))
						{
							$nombres_usuario=$dat3[0];	
			  		 		$ap_paterno_usuario=$dat3[1];	
						}
						echo $nombres_usuario." ".$ap_paterno_usuario;
				?>						
			</td>
		  </tr>
		<tr bgcolor="#FFFFFF">		
				<td align="right">Diseno:</td>
				<td colspan="2">
				  <?php if($diseno==1){
				  		echo "Imprenta";
				   }else{
					   	echo "Cliente";
				   }
				  ?>
			</td>
		</tr>
		<tr bgcolor="#FFFFFF">		
				<td align="right">Aprobado por:</td>
				<td colspan="2">
				<?php if($diseno_aprobacion==1){
				  		echo "Imprenta";
				   }else{
					   	echo "Cliente";
				   }
				  ?>
				</td>
		  </tr>	
		<tr bgcolor="#FFFFFF">		
				<td align="right">Placas:</td>
				<td colspan="2">
				<?php if($placas==1){
				  		echo "CPT";
				   }else{
					   	echo "CONVEC Cantidad:".$cantidad_cpt;
				   }
				  ?>
			</td>
		  </tr>		  
			<tr bgcolor="#FFFFFF">		
				<td align="right">Prensa:</td>
				<td colspan="2">
			<?php
				$sql3=" select cod_maquina, desc_maquina from maquinaria where cod_maquina in ( select cod_maquina   ";
				$sql3.=" from hojas_rutas_detalle_maquinaria ";
				$sql3.=" where cod_hoja_ruta='".$cod_hoja_ruta."' and cod_cotizacion='".$cod_cotizacion."'";
				$sql3.=" and cod_cotizaciondetalle='".$cod_cotizaciondetalle."' and cod_maquina='".$cod_maquina."')";									
				$resp3=mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3))
				{
					$cod_maquina=$dat3[0];	
			  		$desc_maquina=$dat3[1];	
					 echo $desc_maquina."<br>";	
				}
			
			?>
				</td>
			</tr>	
			<tr bgcolor="#FFFFFF" >		
				<td align="right">Obs:</td>
				<td colspan="3"><?php echo $obs_trabajo;?></td>
			</tr>								

		</table>
		</td>
		<td colspan="2" valign="top">
			<table width="100%">
			<tr class="titulo_tabla">
				<td  align="center">Cantidad Entregada</td>
				<td  align="center">Cantidad a Entregar</td>
			</tr>
			<tr  bgcolor="#FFFFFF">
				<td align="right">
			<?php
				$sql7=" select sum(cantidad) from notas_remision_detalle where cod_cotizacion='".$cod_cotizacion."'";
				$sql7.=" and cod_cotizaciondetalle='".$cod_cotizaciondetalle."'";
				$sql7.=" and cod_nota_remision in(select cod_nota_remision from notas_remision ";
				$sql7.=" where cod_estado_nota_remision=1 and cod_hoja_ruta='".$cod_hoja_ruta."')";
				$sumaCantidadEntregada=0;
				$resp7=mysql_query($sql7);
				while($dat7=mysql_fetch_array($resp7))
				{
					$sumaCantidadEntregada=$dat7[0];				  							
				}
				if($sumaCantidadEntregada == NULL){
					$sumaCantidadEntregada=0;
					echo $sumaCantidadEntregada;
				}else{
					echo $sumaCantidadEntregada;
				}
				
				
			?>
				</td>
				<td  align="center"><input type="text" name="cantidad" value="<?php echo ($cantidad_unitariacotizacion-$sumaCantidadEntregada); ?>" size="8" class="textoform"></td>
			</tr>
			</table>
		</td>
		
		</tr>
		<?php		
		}
		?>	
  </table>
  <br>
<div align="center">
	<input type="button"  class="boton" name="editar" value="Guardar" onclick="guardar(this.form)">
	<input type="button"  class="boton" name="cancelar" value="Cancelar" onclick="atras(this.form)">
</div>

</form>

</body>
</html>
