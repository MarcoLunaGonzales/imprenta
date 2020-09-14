<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>GENERAR HOJA DE RUTA</title>
<script language="Javascript"> 
function generaHojaRuta(f)
{
	var i;
	var j=0;
	datos=new Array();
	for(i=0;i<=f.length-1;i++)
	{
		if(f.elements[i].type=='checkbox')
		{	if(f.elements[i].checked==true)
			{	datos[j]=f.elements[i].value;
				j=j+1;
			}
		}
	}
	if(j==0)
	{	alert('Debe seleccionar al menos un Item, para generar la Hoja de Ruta.');
		return(false);
	}
	else
	{	
		
			f.datos.value=datos;
			f.submit();		
	}
}
</script>
</head>
<body >
<form method="post"  name="form1" action="guardarHojaRutaGenerada.php">
<?php 	
	require("conexion.inc");
	include("funciones.php");
	$codCotizacion=$_GET['codigo'];
?>
<input type="hidden" name="cod_cotizacion" value="<?php echo $codCotizacion;?>">
<input type="hidden" name="datos" >
<?php
	
	$sql=" select cod_cotizacion, cod_tipo_cotizacion, cod_estado_cotizacion, ";
	$sql.=" nro_cotizacion, cod_cliente, fecha_cotizacion, obs_cotizacion, cod_tipo_pago, "; 
	$sql.=" cod_gestion, cod_sumar, considerar_precio_unitario, cod_usuario_registro, fecha_registro, ";
	$sql.=" cod_usuario_modifica, fecha_modifica, cod_usuario_aprobacion, fecha_aprobacion, ";
	$sql.=" obs_cotizacion_impresion ";
	$sql.=" from cotizaciones ";
	$sql.=" where cod_cotizacion=".$codCotizacion;
	$resp= mysql_query($sql);
	$dat=mysql_fetch_array($resp);
	
		$cod_cotizacion=$dat[0];
		$cod_tipo_cotizacion=$dat[1];
		/****************TIPO DE COTIZACION*************************/	
			$sql2="select nombre_tipo_cotizacion  from tipos_cotizacion where cod_tipo_cotizacion='".$cod_tipo_cotizacion."'";
			$resp2= mysql_query($sql2);
			$nombre_tipo_cotizacion="";
			while($dat2=mysql_fetch_array($resp2)){
				$nombre_tipo_cotizacion=$dat2[0];
			}
		/************************************/			
		$cod_estado_cotizacion=$dat[2];
		/*******************ESTADO DE COTIZACION**********************/	
		$sql2="select nombre_estado_cotizacion  from estados_cotizacion where cod_estado_cotizacion='".$cod_estado_cotizacion."'";
			$resp2= mysql_query($sql2);
			$nombre_estado_cotizacion="";
			while($dat2=mysql_fetch_array($resp2)){
				$nombre_estado_cotizacion=$dat2[0];
			}
		/************************************/			
		$nro_cotizacion=$dat[3];
		$cod_cliente=$dat[4]; 
		/********************CLIENTE*********************/	
		$sql2=" select nombre_cliente, direccion_cliente, telefono_cliente, celular_cliente, fax_cliente";
		$sql2.=" from clientes where cod_cliente='".$cod_cliente."'";
			$resp2= mysql_query($sql2);
			$nombre_cliente="";
			$direccion_cliente=""; 
			$telefono_cliente="";
			$celular_cliente="";
			$fax_cliente="";
			
			while($dat2=mysql_fetch_array($resp2)){
				$nombre_cliente=$dat2[0];
				$direccion_cliente=$dat2[1];
				$telefono_cliente=$dat2[2];
				$celular_cliente=$dat2[3];
				$fax_cliente=$dat2[4];				
			}
		/************************************/		
		$fecha_cotizacion=$dat[5]; 	
		$obs_cotizacion=$dat[6];
		$cod_tipo_pago=$dat[7];
		/********************TIPO DE PAGO *********************/	
		$sql2="select nombre_tipo_pago  from tipos_pago where cod_tipo_pago='".$cod_tipo_pago."'";
			$resp2= mysql_query($sql2);
			$nombre_tipo_pago="";
			while($dat2=mysql_fetch_array($resp2)){
				$nombre_tipo_pago=$dat2[0];
			}
		/************************************/			
		$cod_gestion=$dat[8];
		/************************GESTION*****************/	
		$sql2="select gestion  from gestiones where cod_gestion='".$cod_gestion."'";
			$resp2= mysql_query($sql2);
			$gestion="";
			while($dat2=mysql_fetch_array($resp2)){
				$gestion=$dat2[0];
			}
		/************************************/	
				
		$cod_sumar=$dat[9];
		if($cod_sumar==1){
			$desc_cod_sumar="Si";
		}else{
			$desc_cod_sumar="No";
		}
		$considerar_precio_unitario=$dat[10];
		if($considerar_precio_unitario==1){
			$desc_considerar_precio_unitario="Si";
		}else{
			$desc_considerar_precio_unitario="No";
		}		
		$cod_usuario_registro=$dat[11];
		/************************USUARIO DE REGISTRO*****************/	
		$sql2="select nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
		$sql2.=" from usuarios where cod_usuario='".$cod_usuario_registro."'";
			$resp2= mysql_query($sql2);
			$nombres_usuario_reg="";
			$ap_paterno_usuario_reg="";
			$ap_materno_usuario_reg="";			
			while($dat2=mysql_fetch_array($resp2)){
				$nombres_usuario_reg=$dat2[0];
				$ap_paterno_usuario_reg=$dat2[1];
				$ap_materno_usuario_reg=$dat2[2];
			}
		/************************************/			
		$fecha_registro=$dat[12];
	
		$cod_usuario_modifica=$dat[13];
		/************************USUARIO MODIFICA*****************/	
		$sql2="select nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
		$sql2.=" from usuarios where cod_usuario='".$cod_usuario_modifica."'";
			$resp2= mysql_query($sql2);
			$nombres_usuario_mod="";
			$ap_paterno_usuario_mod="";
			$ap_materno_usuario_mod="";			
			while($dat2=mysql_fetch_array($resp2)){
				$nombres_usuario_mod=$dat2[0];
				$ap_paterno_usuario_mod=$dat2[1];
				$ap_materno_usuario_mod=$dat2[2];
			}
		/************************************/			
		$fecha_modifica=$dat[14];
		$cod_usuario_aprobacion=$dat[15];
		$fecha_aprobacion=$dat[16];
		$obs_cotizacion_impresion=$dat[17]; 
	
?>
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">GENERAR HOJA DE RUTA</h3>
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">PASO I</h3>
<h3 align="center" style="background:white;font-size: 10px;color: #d20000;font-weight:bold;">
Seleccione los Items Aprobados por el Cliente</h3>

	<table  cellSpacing="1" cellPadding="2" width="80%" bgColor="#cccccc" border="0" id="tabla" align="center">
		<tr class="titulo_tabla">
			<td  colSpan="6" align="center">COTIZACI&Oacute;N </td>
		</tr>
		<tr bgcolor="#FFFFFF">
     		<td>Cotizacion</td>
     		<td colspan="2">No. <?php echo $nro_cotizacion;?>/<?php echo $gestion;?></td>
			<td>Fecha de Cotizacion</td>
     		<td colspan="2"><?php echo $fecha_cotizacion; ?></td>
		</tr>		
		<tr bgcolor="#FFFFFF">
     		<td>Cliente</td><td colspan="5"><?php echo $nombre_cliente; ?></td>
		</tr>	
		<tr class="titulo_tabla">
			<td  colSpan="6" align="center">DETALLE DE COTIZACION</td>
		</tr>	
		<tr class="titulo_tabla">
			<td  align="center">CANTIDAD</td>
			<td  colspan="2" align="center">DESCRIPCION</td>
			<td  align="center">PRECIO UNITARIO</td>
			<td  align="center">IMPORTE</td>
			<td  align="center">&nbsp;</td>
		</tr>				
		<?php
		$sql=" select cod_cotizaciondetalle,cod_item, descripcion_item, cantidad_unitariacotizacion,";
		$sql.=" precio_venta, descuento, importe_total, orden ";
		$sql.=" from cotizaciones_detalle ";
		$sql.=" where cod_cotizacion=".$codCotizacion;
		$sql.=" order by orden asc";
		$resp= mysql_query($sql);
		$sumaTotal=0;
		while($dat=mysql_fetch_array($resp)){
				$cod_cotizaciondetalle=$dat[0];
				$cod_item=$dat[1];
				/************************GESTION*****************/	
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
				if($considerar_precio_unitario==1){ 
					$sumaTotal=$sumaTotal+($cantidad_unitariacotizacion *$precio_venta);
				
				}else{
	         		$sumaTotal=$sumaTotal+($importe_total);
				}
			
		?>
		
		<tr bgcolor="#FFFFFF">		
     		
			<td align="right"><?php echo $cantidad_unitariacotizacion; ?></td>
			<td colspan="2"><?php echo $desc_item." ".$descripcion_item; ?></td>
			<?php if($considerar_precio_unitario==1){ ?>
				<td align="right"><?php echo $precio_venta; ?></td>
			<?php }else{ ?>
				<td>&nbsp;</td>
			<?php }?>
			<td align="right"><?php echo $importe_total; ?></td>
			<td>
			<input type="checkbox" name="itemCotizacion" value="<?php echo $cod_cotizaciondetalle; ?>" checked="checked">
			</td>
		</tr>

		<?php
			$sql3=" select count(distinct(cod_compitem)) as nro_compitem";
			$sql3.=" from cotizacion_detalle_caracteristica ";
			$sql3.=" where cod_cotizacion=".$codCotizacion;
			$sql3.=" and cod_cotizaciondetalle=".$cod_cotizaciondetalle;
			$resp3= mysql_query($sql3);
			$nro_compitem=0;
			while($dat3=mysql_fetch_array($resp3)){
				$nro_compitem=$dat3[0];
			}
		  	/////////////////////////////////////////////////////
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
				<td align="right">&nbsp;</td><td colspan="2"><?php echo $nombre_componenteitem; ?></td>
				<td>&nbsp;</td>
				<td align="right">&nbsp;</td>
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
				<td align="right">&nbsp;</td>
				<td colspan="2"><?php echo $desc_caracT.":".$desc_carac; ?></td>
				<td>&nbsp;</td>
				<td align="right">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<?php
				}
	
			}
		
		}
		?>				
  </table>
  
  <br>
	<div align="center">
		<INPUT type="button" class="boton" name="btn_siguiente"  value="Siguiente" onClick="generaHojaRuta(form1);">
	</div>

</form>

</body>
</html>
