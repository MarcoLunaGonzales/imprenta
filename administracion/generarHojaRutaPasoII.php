<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>GENERAR HOJA DE RUTA</title>
<script language="Javascript"> 
function guardar(f)
{
	var i;
	var j=0;
	var sw=0;
	vectorCotizacionDetalle=new Array();
	vectorUsuariosDiseno=new Array();
	vectorMaquinaria=new Array();
	vectorAuxiliar=new Array();
	var auxiliar="";
	vectorObservaciones=new Array();
	for(i=0;i<=f.length-1;i++)
	{
		if(f.elements[i].name=="cod_usuario_diseno")
		{		vectorAuxiliar=(f.elements[i].value).split("|");
				vectorCotizacionDetalle[j]=vectorAuxiliar[0];
				vectorUsuariosDiseno[j]=vectorAuxiliar[1];				
				sw=1;
		}
		
		if(f.elements[i].type=="checkbox")
		{	
			if(f.elements[i].checked==true){
				if(sw==1){
					auxiliar=auxiliar+f.elements[i].value+"|";
				}
			}
		}
		
		if(f.elements[i].name=="obs_trabajo")
		{	
			
			if(sw==1){
				vectorMaquinaria[j]=auxiliar;
				vectorObservaciones[j]=f.elements[i].value;
				auxiliar="";
				sw=0;
			}
			j=j+1;
		}	
			
		
	}

	/*alert("vectorCotizacionDetalle="+vectorCotizacionDetalle);
	alert("vectorUsuariosDiseno="+vectorUsuariosDiseno);
	alert("vectorMaquinaria="+vectorMaquinaria);
	alert("vectorObservaciones="+vectorObservaciones);	*/
	f.vectorCotizacionDetalle.value=vectorCotizacionDetalle;
	f.vectorUsuariosDiseno.value=vectorUsuariosDiseno;
	f.vectorMaquinaria.value=vectorMaquinaria;
	f.vectorObservaciones.value=vectorObservaciones;
	
	f.submit();		

}
</script>
</head>
<body >
<form method="post"  name="form1" action="guardaHojaRutaPasoII.php">

<?php 	
	require("conexion.inc");
	include("funciones.php");	
	$cod_hoja_ruta=$_GET['cod_hoja_ruta'];
?>

<input type="hidden" name="cod_hoja_ruta" value="<?php echo $cod_hoja_ruta; ?>">
<input type="hidden" name="vectorCotizacionDetalle">
<input type="hidden" name="vectorUsuariosDiseno">
<input type="hidden" name="vectorMaquinaria">
<input type="hidden" name="vectorObservaciones">

<?php	

	$sql=" select cod_cotizacion, fecha_hoja_ruta, cod_usuario_hoja_ruta, obs_hoja_ruta "; 
	$sql.=" from hojas_rutas where cod_hoja_ruta=".$cod_hoja_ruta;
	$resp= mysql_query($sql);
	$dat=mysql_fetch_array($resp);	
		$cod_cotizacion=$dat[0];
		$fecha_hoja_ruta=$dat[1]; 
		$cod_usuario_hoja_ruta=$dat[2]; 
		$obs_hoja_ruta=$dat[3];				
		
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
					$sql3="select gestion  from gestiones where cod_gestion='".$cod_gestion."'";
					$resp3= mysql_query($sql3);
					$dat3=mysql_fetch_array($resp3);
						$gestion=$dat3[0];
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

		/************************USUARIO DE REGISTRO*****************/	
		$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
		$sql2.=" from usuarios where cod_usuario='".$cod_usuario_hoja_ruta."'";
		$resp2= mysql_query($sql2);
		$dat2=mysql_fetch_array($resp2);
		$nombres_usuario=$dat2[0];
		$ap_paterno_usuario=$dat2[1];
		$ap_materno_usuario=$dat2[2];
		/************************************/			
		
	
	?>
	<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">HOJA DE RUTA</h3>
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">PASO II</h3>
<h3 align="center" style="background:white;font-size: 10px;color: #d20000;font-weight:bold;">
Complete los Datos</h3>

	<table  cellSpacing="1" cellPadding="2" width="80%" bgColor="#cccccc" border="0" id="tabla" align="center">
		<tr class="titulo_tabla">
			<td  colSpan="4" align="center">COTIZACI&Oacute;N </td>
		</tr>
		<tr bgcolor="#FFFFFF">
     		<td>Cotizacion</td>
     		<td >No. <?php echo $nro_cotizacion;?>/<?php echo $gestion;?></td>
			<td>Fecha de Cotizacion</td>
     		<td><?php echo $fecha_cotizacion; ?></td>
		</tr>		
		<tr bgcolor="#FFFFFF">
     		<td>Cliente</td><td colspan="3"><?php echo $nombre_cliente; ?></td>
		</tr>	
		<tr class="titulo_tabla">
			<td  colSpan="4" align="center">DETALLE DE COTIZACION</td>
		</tr>	

			
		<?php
		
		$sql=" select cod_cotizaciondetalle,cod_item, descripcion_item, cantidad_unitariacotizacion,";
		$sql.=" precio_venta, descuento, importe_total, orden ";
		$sql.=" from cotizaciones_detalle ";
		$sql.=" where cod_cotizacion=".$cod_cotizacion;
		$sql.=" and cod_estado_detallecotizacionitem=2 ";
		$sql.=" order by orden asc";
		$resp= mysql_query($sql);
		$sumaTotal=0;
		$cont=0;
		while($dat=mysql_fetch_array($resp)){
	?>
		<tr bgcolor="#FFFFFF">
		<td colspan="2" valign="top">
		<table border="0" width="100%" >
		
	<?php		
				$cont++;
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
		<tr valign="top" class="titulo_tabla">
			<td colspan="4"  align="center">ITEM <?php echo $cont;?></td>
		</tr>			
		<tr bgcolor="#FFFFFF">		
     		
			<td align="right" valign="top"><?php echo $cantidad_unitariacotizacion; ?></td>
			<td colspan="3"><?php echo $desc_item." ".$descripcion_item; ?></td>
			
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
				<td colspan="3"><?php echo $nombre_componenteitem; ?></td>
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
				<td colspan="3"><?php echo $desc_caracT.":".$desc_carac; ?></td>
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
				<td align="right">Diseno</td>
				<td colspan="2"><select name="cod_usuario_diseno" class="textoform" >
				<?php
					$sql3="select cod_usuario, nombres_usuario, ap_paterno_usuario from usuarios where cod_usuario<>0 and cod_cargo=2";
					$resp3=mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3))
						{
							$cod_usuario=$dat3[0];
							$nombres_usuario=$dat3[1];	
			  		 		$ap_paterno_usuario=$dat3[2];	
				 ?>
				 	<option value="<?php echo $cod_cotizaciondetalle."|".$cod_usuario;?>">
				 		<?php echo $nombres_usuario." ".$ap_paterno_usuario;?>
				 	</option>					 			
				<?php		
					}
				?>						
			</select>
			</td>
		  </tr>
			<tr bgcolor="#FFFFFF">		
				<td align="right">Prensa</td>
				<td colspan="2">
			<?php
				$sql3=" select cod_maquina, desc_maquina from maquinaria where cod_estado_registro=1 ";
				$resp3=mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3))
				{
					$cod_maquina=$dat3[0];	
			  		$desc_maquina=$dat3[1];	
			?>
				<input type="checkbox" name="cod_maquina" value="<?php echo $cod_maquina;?>"><?php echo $desc_maquina;?><br>
			<?php	
				}
			
			?>
				</td>
			</tr>	
			<tr bgcolor="#FFFFFF" >		
				<td align="right">Obs</td>
				<td colspan="3"><textarea name="obs_trabajo" cols="40"></textarea></td>
			</tr>								

		</table>
		</td></tr>
		<?php		
		}
		?>	

			
  </table>
  <br>
<div align="center">
	<input type="button"  class="boton" name="Guardar" value="Seguir" onclick="guardar(this.form)">
</div>

</form>

</body>
</html>
