<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>EDITAR HOJA DE RUTA</title>
<script language="Javascript"> 
function guardar(f)
{
	var i;
	var j=0;
	var sw=0;
	vectorCotizacionDetalle=new Array();
	vectorUsuariosDiseno=new Array();
	vectorDiseno=new Array();
	vectorDisenoAprobadoPor=new Array();
	vectorPlacas=new Array();
	vectorCantidad=new Array();
	vectorMaquinaria=new Array();
	vectorAuxiliar=new Array();
	var codigo=0;
	var auxiliar="";
	vectorObservaciones=new Array();
	for(i=0;i<=f.length-1;i++)
	{
			if(f.elements[i].name=="cod_usuario_diseno")
			{		
				if(f.elements[i-1].type=='checkbox'){					
					
					if(f.elements[i-1].name="cod_cotizaciondetalle"){
					
						if(f.elements[i-1].checked==true){	
							vectorCotizacionDetalle[j]=f.elements[i-1].value;
							codigo=f.elements[i-1].value;
							vectorUsuariosDiseno[j]=f.elements[i].value;			
							sw=1;							
						}
					}
				}										
			}	
			//alert("diseno"+codigo);
			if(sw==1){
				if(f.elements[i].name=="diseno"+codigo)
				{	
					if(f.elements[i].checked==true){
						vectorDiseno[j]=f.elements[i].value;
					}
				}
				if(f.elements[i].name=="aprobado_por"+codigo)
				{	if(f.elements[i].checked==true){			
						vectorDisenoAprobadoPor[j]=f.elements[i].value;
					}
				}
				if(f.elements[i].name=="placas"+codigo)
				{			
					if(f.elements[i].checked==true){		
						vectorPlacas[j]=f.elements[i].value;
					}
				}		
				if(f.elements[i].name=="cantidad"+codigo)
				{	
					vectorCantidad[j]=f.elements[i].value;			
				}										
			
				////////////////////////////////////////////
				if(f.elements[i].type=="checkbox")
				{	
					if(f.elements[i].checked==true){
							auxiliar=auxiliar+f.elements[i].value+"|";
					}
				}
			
				if(f.elements[i].name=="obs_trabajo")
				{				
						vectorMaquinaria[j]=auxiliar;
						vectorObservaciones[j]=f.elements[i].value;
						auxiliar="";
						sw=0;
						j=j+1;
				}	
				///////////////////////////////////////////////////
			}
		
	}
	
	f.vectorCotizacionDetalle.value=vectorCotizacionDetalle;
	f.vectorUsuariosDiseno.value=vectorUsuariosDiseno;
	f.vectorDiseno.value=vectorDiseno;
	f.vectorDisenoAprobadoPor.value=vectorDisenoAprobadoPor;
	f.vectorPlacas.value=vectorPlacas;
	f.vectorCantidad.value=vectorCantidad;	
	f.vectorMaquinaria.value=vectorMaquinaria;
	f.vectorObservaciones.value=vectorObservaciones;
	
	f.submit();		

}

function repetir(f){
var valor=0;
var sw=0;
	for(i=0;i<=f.length-1;i++)
	{	
		if(f.elements[i].name=="cod_usuario_diseno"){
			
			if(sw==0){
				valor=f.elements[i].value;
				sw=1;
			}
			f.elements[i].value=valor;
		}
		
	
	}
}
function atras(f){
			window.location="listHojasRutas.php";
}
</script>
</head>
<body  bgcolor="#FFFFFF">
<form method="post"  name="form1" action="guardaEditarHojaRuta.php">

<?php 	
	require("conexion.inc");
	include("funciones.php");	
	$cod_hoja_ruta=$_GET['cod_hoja_ruta'];
	
?>

<input type="hidden" name="cod_hoja_ruta" value="<?php echo $cod_hoja_ruta; ?>">
<input type="hidden" name="vectorCotizacionDetalle">
<input type="hidden" name="vectorUsuariosDiseno">
<input type="hidden" name="vectorDiseno">
<input type="hidden" name="vectorDisenoAprobadoPor">
<input type="hidden" name="vectorPlacas">
<input type="hidden" name="vectorCantidad">
<input type="hidden" name="vectorMaquinaria">
<input type="hidden" name="vectorObservaciones">

<?php	

	$sql=" select  cod_gestion, nro_hoja_ruta, fecha_hoja_ruta, cod_usuario_hoja_ruta, ";
	$sql.=" obs_hoja_ruta, cod_cotizacion, cod_estado_hoja_ruta, factura_si_no, cod_usuario_comision, cod_tipo_pago ";
	$sql.=" from hojas_rutas ";
	$sql.=" where cod_hoja_ruta='".$cod_hoja_ruta."'";
	//echo $sql."<br>";
	$resp= mysql_query($sql);
	$dat=mysql_fetch_array($resp);

	$cod_gestion=$dat[0];
	/****************************GESTION*************************************/
	$sql2="select gestion, gestion_nombre from gestiones where cod_gestion='".$cod_gestion."'";
	$resp2= mysql_query($sql2);
	$gestion="";
	while($dat2=mysql_fetch_array($resp2)){
		$gestion=$dat2['gestion'];
		$gestion_nombre=$dat2['gestion_nombre'];
	}	
	/******************************FIN GESTION***********************************/
	$nro_hoja_ruta=$dat[1];
	$fecha_hoja_ruta=$dat[2];
	$cod_usuario_hoja_ruta=$dat[3];
	$obs_hoja_ruta=$dat[4]; 
	$cod_cotizacion=$dat[5]; 
	$cod_estado_hoja_ruta=$dat[6]; 
	$factura_si_no=$dat[7];
	$codusuariocomision=$dat[8];
	$codtipopago=$dat[9];	
	
	/************************USUARIO DE REGISTRO*****************/	
		$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
		$sql2.=" from usuarios where cod_usuario='".$cod_usuario_hoja_ruta."'";
	//	echo $sql2."<br>";
		$resp2= mysql_query($sql2);
		$dat2=mysql_fetch_array($resp2);
		$nombres_usuario=$dat2[0];
		$ap_paterno_usuario=$dat2[1];
		$ap_materno_usuario=$dat2[2];
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

		
	?>
	<h3 align="center" style="background:white;font-size: 14px;color: #E78611;font-weight:bold;">EDITAR HOJA DE RUTA</h3>
	<h3 align="center" style="background:white;font-size: 14px;color: #E78611;font-weight:bold;">No. <?php echo $nro_hoja_ruta."/".$gestion_nombre;?></h3>	
    <table  cellSpacing="1" cellPadding="2" width="90%" bgColor="#cccccc" border="0" id="tabla" align="center">
		<tr class="titulo_tabla">
			<td  colSpan="6" align="center">COTIZACI&Oacute;N </td>
		</tr>
		<tr bgcolor="#FFFFFF">
     		<td>Cotizacion</td>
     		<td  colspan="2" >No. <?php echo $nro_cotizacion;?>/<?php echo $gestion;?></td>
			<td>Fecha de Cotizacion</td>
     		<td colspan="2"><?php echo $fecha_cotizacion; ?></td>
		</tr>		
		<tr bgcolor="#FFFFFF">
     		<td>Cliente</td>
			<td colspan="2"><?php echo $nombre_cliente;?>
			<td colspan="3">Telefono:<?php echo $telefono_cliente;?> &nbsp; Celular:
			<?php echo $celular_cliente;?> &nbsp;Fax:<?php echo $fax_cliente;?></td>
		</tr>	
		<tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
     		<td colspan="5"><textarea name="obs_hoja_ruta" cols="80" rows="3"><?php echo $obs_hoja_ruta;?></textarea></td>
		</tr>	
		<tr bgcolor="#FFFFFF">
     		<td>Factura</td>
     		<td colspan="5">C1
     		  <input name="factura_si_no" type="radio" value="1"<?php if($factura_si_no==1){ echo "checked='checked'";}?> >
				  &nbsp;&nbsp;C2
			      <input type="radio" name="factura_si_no" value="2" <?php if($factura_si_no==2){ echo "checked='checked'";}?> >
			</td>
		</tr>	
		<tr bgcolor="#FFFFFF">
     		<td>Comisión</td>
     		<td colspan="5"><select name="cod_usuario_comision" class="textoform" >
				<?php
					$sql3="select cod_usuario, nombres_usuario, ap_paterno_usuario from usuarios where cod_usuario<>0";
					$resp3=mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3))
						{
							$cod_usuario=$dat3[0];
							$nombres_usuario=$dat3[1];	
			  		 		$ap_paterno_usuario=$dat3[2];	
				 ?>
				 
				 	<option value="<?php echo $cod_usuario;?>" <?php if($codusuariocomision==$cod_usuario){echo "selected='selected'"; }?>>
				 		<?php echo $nombres_usuario." ".$ap_paterno_usuario;?>
				 	</option>				 				 						 
				<?php		
						}
				?>						
			</select> &nbsp; Tipo de Pago:<select name="cod_tipo_pago" id="cod_tipo_pago" class="textoform" >
				<?php
					$sql4="select cod_tipo_pago,nombre_tipo_pago from tipos_pago";
					$resp4=mysql_query($sql4);
						while($dat4=mysql_fetch_array($resp4))
						{
							$cod_tipo_pago=$dat4[0];	
			  		 		$nombre_tipo_pago=$dat4[1];	
				 ?>
				 			<?php if($cod_tipo_Pago==$codtipopago){?>
				 			<option value="<?php echo $cod_tipo_pago;?>"selected="selected">
							<?php echo $nombre_tipo_pago;?>
							</option>				
						<?php }else{?>	
							<option value="<?php echo $cod_tipo_pago;?>" <?php if($codtipopago==$cod_tipo_pago){?> selected="true"<?php }?>><?php echo $nombre_tipo_pago;?></option>				
						<?php }?>
										
				<?php		
					}
				?>						
			</select>
			</td>
		</tr>					
		<tr class="titulo_tabla">
			<td  colSpan="6" align="center">DETALLE DE COTIZACION</td>
		</tr>	
		<tr bgcolor="#FFFFFF">
			<td  colSpan="6" align="center"><strong>Click para Repetir Usuario de Diseno &nbsp;<input type="button" name="rep" value="@"  alt="Repetir Usuario Diseno" class="boton" onclick="javascript:repetir(this.form);"></strong></td>
		</tr>			

		
	<?php
		
		$sql=" select cod_cotizaciondetalle,cod_item, descripcion_item, cantidad_unitariacotizacion,";
		$sql.=" precio_venta, descuento, importe_total, orden, cod_estado_detallecotizacionitem ";
		$sql.=" from cotizaciones_detalle ";
		$sql.=" where cod_cotizacion=".$cod_cotizacion;
		$sql.=" order by  orden asc";
		$resp= mysql_query($sql);
		$sumaTotal=0;
		$cont=0;
		while($dat=mysql_fetch_array($resp)){
	
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
				$cod_estado_detallecotizacionitem=$dat[8];	
							
				if($considerar_precio_unitario==1){ 
					$sumaTotal=$sumaTotal+($cantidad_unitariacotizacion *$precio_venta);				
				}else{
	         		$sumaTotal=$sumaTotal+($importe_total);
				}
				
			$sql6=" select  count(*) as sw_hoja_ruta";
			$sql6.=" from hojas_rutas_detalle ";
			$sql6.=" where cod_hoja_ruta='".$cod_hoja_ruta."'";
			$sql6.=" and cod_cotizacion='".$cod_cotizacion."'";
			$sql6.=" and cod_cotizaciondetalle='".$cod_cotizaciondetalle."'";
			$resp6=mysql_query($sql6);
			while($dat6=mysql_fetch_array($resp6)){
				$sw_hoja_ruta=$dat6[0];
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

		<td colspan="3" valign="top">
		<table border="0" width="100%" >
		<tr valign="top" class="titulo_tabla">
			<td colspan="4"  align="center">ITEM <?php echo $cont;?></td>
		</tr>			
		<tr bgcolor="#FFFFFF">		     		
		   <td align="right">
		   <input type="checkbox" name="cod_cotizaciondetalle"  value="<?php echo $cod_cotizaciondetalle;?>" <?php if($sw_hoja_ruta==1){ echo "checked='checked'";}?>>
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
		<td colspan="3" valign="top">
		
		<table width="100%">
		<tr class="titulo_tabla">
				<td  colspan="4" align="center">TRABAJO</td>
		</tr>

		<tr bgcolor="#FFFFFF">		
				<td align="right">Asinado a :</td>
				<td colspan="2"><select name="cod_usuario_diseno" class="textoform" >
				<?php
					$sql3="select cod_usuario, nombres_usuario, ap_paterno_usuario from usuarios where cod_usuario<>0 and cod_cargo=2 and cod_estado_registro=1";
					$resp3=mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3))
						{
							$cod_usuario=$dat3[0];
							$nombres_usuario=$dat3[1];	
			  		 		$ap_paterno_usuario=$dat3[2];	
				 ?>
				 	<option value="<?php echo $cod_usuario;?>" <?php if($codusuariodiseno==$cod_usuario){echo "selected='selected'"; }?> >
				 		<?php echo $nombres_usuario." ".$ap_paterno_usuario;?>
				 	</option>				 		 		
				<?php		
					}
				?>						
			</select>
			</td>
		  </tr>
		<tr bgcolor="#FFFFFF">		
				<td align="right">Diseno:</td>
				<td colspan="2">Imprenta
				  <input name="diseno<?php echo $cod_cotizaciondetalle;?>" type="radio" value="1" <?php if($diseno==1){ echo "checked='checked'";}?>>
				  &nbsp;&nbsp;Cliente<input type="radio" name="diseno<?php echo $cod_cotizaciondetalle;?>" value="2" <?php if($diseno==2){ echo "checked='checked'";}?>>
		<tr bgcolor="#FFFFFF">		
				<td align="right">Aprobado por:</td>
				<td colspan="2">Imprenta 
				  <input name="aprobado_por<?php echo $cod_cotizaciondetalle;?>" type="radio" value="1" <?php if($diseno_aprobacion==1){ echo "checked='checked'";}?>>
			&nbsp;&nbsp;Cliente<input type="radio" name="aprobado_por<?php echo $cod_cotizaciondetalle;?>" value="2" <?php if($diseno_aprobacion==2){ echo "checked='checked'";}?>></td>
		  </tr>	
		<tr bgcolor="#FFFFFF">		
				<td align="right">Placas:</td>
				<td colspan="2">&nbsp;CTP<input name="placas<?php echo $cod_cotizaciondetalle;?>" type="radio" value="1" <?php if($placas==1){ echo "checked='checked'";}?>>
				&nbsp;&nbsp;CONVENC<input type="radio" name="placas<?php echo $cod_cotizaciondetalle;?>" value="2" <?php if($placas==2){ echo "checked='checked'";}?>> 
				&nbsp;Cantidad:
				<input type="text" name="cantidad<?php echo $cod_cotizaciondetalle;?>" value="<?php echo $cantidad_cpt; ?>" size="10" class="textoform"></td>
		  </tr>		  
			<tr bgcolor="#FFFFFF">		
				<td align="right">Prensa:</td>
				<td colspan="2">
			<?php
				$sql3=" select cod_maquina, desc_maquina from maquinaria where cod_estado_registro=1 ";
				$resp3=mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3))
				{
					$cod_maquina=$dat3[0];	
			  		$desc_maquina=$dat3[1];	
					
					$sql7="select count(*) as sw_maquina ";
					$sql7.=" from hojas_rutas_detalle_maquinaria ";
					$sql7.=" where cod_hoja_ruta='".$cod_hoja_ruta."'";
					$sql7.=" and cod_cotizacion='".$cod_cotizacion."'";
					$sql7.=" and cod_cotizaciondetalle='".$cod_cotizaciondetalle."'";
					$sql7.=" and cod_maquina='".$cod_maquina."'";
					$resp7=mysql_query($sql7);
					$sw_maquina=0;
					while($dat7=mysql_fetch_array($resp7)){
						$sw_maquina=$dat7[0];
					}
									 
			?>				
				<input name="cod_maquina" type="checkbox" value="<?php echo $cod_maquina;?>"<?php if($sw_maquina==1){ echo "checked='checked'";}?>  > 
				<?php echo $desc_maquina;?><br>

			<?php	
				}
			
			?>
				</td>
			</tr>	
			<tr bgcolor="#FFFFFF" >		
				<td align="right">Obs:</td>
				<td colspan="3"><textarea name="obs_trabajo" cols="40"><?php echo $obs_trabajo;?></textarea></td>
			</tr>								

		</table>
		</td></tr>
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
