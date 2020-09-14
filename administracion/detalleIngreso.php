<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Detalle Ingreso</title>
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
	$cod_ingreso=$_GET['cod_ingreso'];
	
	$sql=" select  i.cod_gestion, i.cod_almacen, i.nro_ingreso,";
	$sql.=" i.cod_tipo_ingreso, i.fecha_ingreso, i.cod_usuario_ingreso, i.cod_proveedor, i.cod_contacto_proveedor, ";
	$sql.=" i.cod_salida, i.nro_factura, i.obs_ingreso, i.fecha_modifica, i.cod_usuario_modifica, ";
	$sql.=" i.cod_estado_ingreso, i.obs_anular, i.total_bs, i.dias_plazo_pago, i.cod_tipo_pago, i.cod_estado_pago_doc, tp.nombre_tipo_pago,epd.desc_estado_pago_doc ";
	$sql.=" from ingresos i";
	$sql.=" left join tipos_pago tp on(i.cod_tipo_pago=tp.cod_tipo_pago)";
	$sql.=" left join estado_pago_documento epd on (i.cod_estado_pago_doc=epd.cod_estado_pago_doc)";
	$sql.=" where i.cod_ingreso='".$cod_ingreso."'";
	//echo $sql;
		
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
				
				$cod_gestion=$dat['cod_gestion']; 
				$cod_almacen=$dat['cod_almacen']; 
				$nro_ingreso=$dat['nro_ingreso']; 
				$cod_tipo_ingreso=$dat['cod_tipo_ingreso']; 
				$fecha_ingreso=$dat['fecha_ingreso']; 
				$cod_usuario_ingreso=$dat['cod_usuario_ingreso']; 
				$cod_proveedor=$dat['cod_proveedor']; 
				$cod_contacto_proveedor=$dat['cod_contacto_proveedor']; 
				$cod_salida=$dat['cod_salida']; 
				$nro_factura=$dat['nro_factura'];  
				$obs_ingreso=$dat['obs_ingreso'];  
				$fecha_modifica=$dat['fecha_modifica']; 
				$cod_usuario_modifica=$dat['cod_usuario_modifica']; 
				$cod_estado_ingreso=$dat['cod_estado_ingreso']; 
				$obs_anular=$dat['obs_anular']; 
				$total_bs=$dat['total_bs']; 
				$dias_plazo_pago=$dat['dias_plazo_pago']; 
				$cod_tipo_pago=$dat['cod_tipo_pago'];  
				$nombre_tipo_pago=$dat['nombre_tipo_pago'];
				$desc_estado_pago_doc=$dat['desc_estado_pago_doc'];
				//**************************************************************
				$gestionIngreso="";
				$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion."'";
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$gestionIngreso=$dat2[0];
				}
				$nombre_almacen_ingreso="";
				$sql2="select nombre_almacen from almacenes where cod_almacen='".$cod_almacen."'";
				$resp2= mysql_query($sql2);			
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_almacen_ingreso=$dat2[0];
				}
				
				$nombre_tipo_ingreso="";
				$sql2="select nombre_tipo_ingreso from tipos_ingreso where cod_tipo_ingreso='".$cod_tipo_ingreso."'";
				$resp2= mysql_query($sql2);			
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_tipo_ingreso=$dat2[0];
				}
				
				if($cod_tipo_ingreso==1){
						$nombre_proveedor="";
						$sql2="select nombre_proveedor from proveedores where cod_proveedor='".$cod_proveedor."'";
						$resp2= mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2)){
							$nombre_proveedor=$dat2[0];
						}	
				}
						
				if($cod_tipo_ingreso==2){
					$sql2="  select s.nro_salida, s.cod_gestion, g.gestion,  s.cod_almacen, a.nombre_almacen ";
					$sql2.="  from salidas s, gestiones g, almacenes a ";
					$sql2.="  where s.cod_gestion=g.cod_gestion ";
					$sql2.="  and s.cod_almacen=a.cod_almacen ";
					$sql2.="  and s.cod_salida=".$cod_salida;
					$resp2= mysql_query($sql2);
						$nro_salida="";
						$cod_gestion_salida="";
						$gestion_salida="";
						$cod_almacen_salida="";
						$nombre_almacen_salida="";		
						while($dat2=mysql_fetch_array($resp2)){	
							$nro_salida=$dat2[0];
							$cod_gestion_salida=$dat2[1];
							$gestion_salida=$dat2[2];		
							$cod_almacen_salida=$dat2[3];		
							$nombre_almacen_salida=$dat2[4];		
						}									
				}			
								
				$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios ";
				$sql2.=" where cod_usuario='".$cod_usuario_ingreso."'";
				$resp2= mysql_query($sql2);
				$nombres_usuario="";
				$ap_paterno_usuario="";
				$ap_materno_usuario="";		
				while($dat2=mysql_fetch_array($resp2)){	
					$nombres_usuario=$dat2[0];
					$ap_paterno_usuario=$dat2[1];
					$ap_materno_usuario=$dat2[2];		
				}
				
			$sql2="select desc_estado_ingreso from estados_ingresos_almacen where cod_estado_ingreso='".$cod_estado_ingreso."'";
			$resp2= mysql_query($sql2);
			while($dat2=mysql_fetch_array($resp2)){
					$desc_estado_ingreso=$dat2[0];
			}	
			
				
				
 }
		

?>

<h3 align="center" style="background:white;font-size: 12px;color:#E78611;font-weight:bold;">INGRESO No. <?php echo $nro_ingreso;?>/<?php echo $gestionIngreso;?></h3>
 
  <?php if($cod_estado_ingreso==2){?>
  	<h3 align="center" style="background:white;font-size: 14px;color:#FF0000;font-weight:bold;">
	  <?php echo $desc_estado_ingreso;?>
	  </h3>
  <?php }?>

<div align="center"><a onClick="window.print();"><img src="img/imprimir.jpg" border="0"></a>
</div>
	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="70%" bgColor="#cccccc" border="0">
		 <tr class="titulo_tabla">
		   <td  colSpan="7" align="center">DATOS</td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td><strong>Almacen de Ingreso</strong></td>
      		<td  colSpan="6"><?php echo $nombre_almacen_ingreso;?></td>
		 </tr>	
		 <tr bgcolor="#FFFFFF">
     		<td><strong>Fecha de Ingreso</strong></td>
      		<td  colSpan="6"><?php echo $fecha_ingreso;?></td>
		 </tr>			 				 
		 <tr bgcolor="#FFFFFF">
     		<td><strong>Responsable de Ingreso</strong></td>
      		<td  colSpan="6"><?php echo $nombres_usuario." ".$ap_paterno_usuario;?></td>
		 </tr>	
		<?php if($cod_tipo_ingreso==1){ ?>	
		<tr bgcolor="#FFFFFF">
			<td><strong>Proveedor </strong></td>
			<td  colSpan="6"><?php echo $nombre_proveedor;
							if($cod_contacto_proveedor<>"" and $cod_contacto_proveedor<>0  ){				
					$sql2="select nombre_contacto, ap_paterno_contacto from proveedores_contactos where cod_contacto_proveedor=".$cod_contacto_proveedor;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){				
						$nombre_contacto=$dat2['nombre_contacto'];
						$ap_paterno_contacto=$dat2['ap_paterno_contacto'];
					}	
					echo "<br/>(".$nombre_contacto." ".$ap_paterno_contacto.")";		
				} 
			
			 ?></td>
		</tr>	
		<tr bgcolor="#FFFFFF">
			<td><strong>Nro. Factura </strong></td>
			<td><?php echo $nro_factura; ?></td>
			<td><strong>Tipo Pago</strong></td>
			<td colspan="5"><?php echo $nombre_tipo_pago; ?></td>
		</tr>	
		<tr bgcolor="#FFFFFF">
			<td><strong>Total Factura </strong></td>
			<td><?php echo $total_bs; ?></td>
			<td><strong>Plazo Pago</strong></td>
			<td colspan="5"><?php echo $dias_plazo_pago." dias."; ?></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>Estado de Pago</strong> </td>
			<td  colSpan="6"><?php echo $desc_estado_pago_doc; ?></td>
		</tr>			
			        
		<?php } ?>	
		
		<?php if($cod_tipo_ingreso==2){ ?>	
		<tr bgcolor="#FFFFFF">
			<td><strong>Almacen Traspaso</strong> </td>
			<td  colSpan="6"><?php echo $nombre_almacen_salida." ( Salida No.".$nro_salida."/".$gestion_salida.")"; ?></td>
		</tr>	
		<?php } ?>
		<tr bgcolor="#FFFFFF">
			<td><strong>Observaciones </strong></td>
			<td  colSpan="6"><?php echo $obs_ingreso; ?></td>
		</tr>		
				

		 <tr class="titulo_tabla">
		   	<td colspan="5" align="center">DETALLE</td>		
			<td colspan="2" align="center">DATOS ADICIONALES</td>
		 </tr>		 						
		 <tr class="titulo_tabla">
		   	<td >Material</td>
			<td >Unidad</td>
			<td align="center">Cantidad</td>		
			<td  align="center">Precio Unitario</td>			
			<td >Importe</td>			
			<td >Cantidad Actual</td>
			<td >Precio Venta</td>
		 </tr>
		 <?php
		 
		 	$sql="select count(*) from ingresos_detalle where cod_ingreso=".$cod_ingreso;
			$cant_registros=0;
			$resp = mysql_query($sql);
			while($dat=mysql_fetch_array($resp)){
				$cant_registros=$dat[0];
			}
		?>
		<?php if($cant_registros>0){?>
		<?php
		 	$sumaTotal=0;
		 	$sql=" select id.cod_ingreso_detalle, id.cod_material,m.desc_completa_material, ";
			$sql.=" m.cod_unidad_medida, um.abrev_unidad_medida, id.precio_compra_uni, ";
			$sql.=" id.cantidad, id.cant_actual ";
			$sql.=" from ingresos_detalle id, materiales m, unidades_medidas um ";
			$sql.=" where id.cod_material=m.cod_material ";
			$sql.=" and m.cod_unidad_medida=um.cod_unidad_medida ";
			$sql.=" and id.cod_ingreso=".$cod_ingreso;
			$sql.=" order by id.cod_ingreso_detalle asc ";
			
			$resp = mysql_query($sql);
			while($dat=mysql_fetch_array($resp)){
			
				$cod_ingreso_detalle=$dat[0];
				$cod_material=$dat[1];
				$desc_completa_material=$dat[2];
				$cod_unidad_medida=$dat[3];
				$abrev_unidad_medida=$dat[4];
				$precio_compra_uni=$dat[5];
				$cantidad=$dat[6];
				$cant_actual=$dat[7];
				$sumaTotal=$sumaTotal+($precio_compra_uni*$cantidad);
				
				$sql2="select precio_venta from materiales where cod_material='".$cod_material."'";
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$precio_venta=$dat2[0];
				}
				
				
		?>
			<tr bgcolor="#FFFFFF">					
					<td><?php echo $desc_completa_material; ?></td>    			
					<td><?php echo $abrev_unidad_medida; ?></td>		
					<td align="right"><?php echo $cantidad; ?></td>																					
					<td align="right"><?php echo $precio_compra_uni; ?></td>
					<td align="right"><?php echo ($precio_compra_uni*$cantidad); ?></td>
					<td><?php echo $cant_actual; ?></td>
					<td><?php echo $precio_venta; ?></td>
		   	  </tr>
			<?php
			}

		 ?>
			<tr bgcolor="#FFFFFF">					
					<td colspan="4" align="right"><strong>Total Importe:</strong></td>    			 
					<td align="right"><strong><?php echo $sumaTotal; ?></strong></td> 
					<td colspan="2">&nbsp;</td>     																							

		   	  </tr>	
		<?php }else{?>	
			<tr bgcolor="#FFFFFF">					
					<td colspan="7" align="center"><strong>No existen Materiales!</strong></td>     																							

   	  </tr>	 
		<?php }?>	 		
		
	  <?php if($cod_estado_ingreso==2){?>
	  
	  <tr bgcolor="#FFFFFF">
	  <td><strong>MOTIVO DE ANULACION:</strong></td>
	  <td colspan="6">
  	
	<h3 align="left" style="background:white;font-size: 12px;color:#FF0000;font-weight:bold;">
	  <?php echo $obs_anular;?>
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
