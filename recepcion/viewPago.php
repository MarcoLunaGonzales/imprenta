
<?php 

	require("conexion.inc");
	include("funciones.php");
	
	$cod_pago=$_GET['cod_pago'];
	$sql=" select  p.nro_pago, p.cod_gestion, g.gestion, ";
	$sql.=" p.cod_cliente, cli.nombre_cliente,  p.fecha_pago, p.cod_usuario_pago, p.obs_pago, p.monto_pago, ";
	$sql.=" p.cod_estado_pago, ep.desc_estado_pago, p.fecha_anulacion, p.obs_anulacion, p.cod_usuario_anulacion ";
	$sql.=" from pagos p, gestiones g,  clientes cli, estados_pago ep ";
	$sql.=" where  p.cod_gestion=g.cod_gestion ";
	$sql.=" and p.cod_cliente=cli.cod_cliente ";
	$sql.=" and p.cod_estado_pago=ep.cod_estado_pago ";
	$sql.=" and p.cod_pago=".$cod_pago;
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		
				$nro_pago=$dat['nro_pago'];				
				$cod_gestion=$dat['cod_pago'];
				$gestion=$dat['gestion'];
				$cod_cliente=$dat['cod_cliente'];
				$nombre_cliente=$dat['nombre_cliente'];								
				$fecha_pago=$dat['fecha_pago'];
				$cod_usuario_pago=$dat['cod_usuario_pago'];
				$obs_pago=$dat['obs_pago'];
				$monto_pago=$dat['monto_pago'];
				$cod_estado_pago=$dat['cod_estado_pago'];
				$desc_estado_pago=$dat['desc_estado_pago'];
				$fecha_anulacion=$dat['fecha_anulacion'];
				$obs_anulacion=$dat['obs_anulacion'];
				$cod_usuario_anulacion=$dat['cod_usuario_anulacion'];
				///Usuario de Registro//////////
				if($cod_usuario_pago<>""){
					$sqlAux=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
					$sqlAux.=" from usuarios ";
					$sqlAux.=" where cod_usuario=".$cod_usuario_pago;
					$respAux = mysql_query($sqlAux);
					$nombres_usuario_pago="";
					$ap_paterno_usuario_pago="";
					$ap_materno_usuario_pago="";						
					while($datAux=mysql_fetch_array($respAux)){
						
						$nombres_usuario_pago=$datAux['nombres_usuario'];
						$ap_paterno_usuario_pago=$datAux['ap_paterno_usuario'];
						$ap_materno_usuario_pago=$datAux['ap_materno_usuario'];						
					}
				}
				////////////////////////////////
				if($cod_usuario_anulacion<>""){
					$sqlAux=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
					$sqlAux.=" from usuarios ";
					$sqlAux.=" where cod_usuario=".$cod_usuario_pago;
					$respAux = mysql_query($sqlAux);
					$nombres_usuario_anula="";
					$ap_paterno_usuario_anula="";
					$ap_materno_usuario_anula="";						
					while($datAux=mysql_fetch_array($respAux)){
						
						$nombres_usuario_anula=$datAux['nombres_usuario'];
						$ap_paterno_usuario_anula=$datAux['ap_paterno_usuario'];
						$ap_materno_usuario_anula=$datAux['ap_materno_usuario'];						
					}
				}
				////////////////////////////////				
	}



	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>INVENTA</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />

<script language='Javascript'>
function retornar()
	{
	location.href='listPagos.php';
	}

function modificar()
	{
	location.href='editPago.php?cod_pago=<? echo $_GET['cod_pago']?>'
	}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post"  name="form1" id="form1">

<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">PAGO</br> No. <?php echo $nro_pago;?>/<?php echo $gestion;?></h3>

</br>
<table align="center" border="0">
<tr><td bgcolor="#FFCC00">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td style="background:#FFF;font-size: 10px;color: #E78611;font-weight:bold;">Hojas Rutas con Descuento</td></tr>
</table>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Introduzca Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Cliente</td>
      		<td><?php echo $nombre_cliente;?></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha Pago</td>
      		<td><?php echo strftime("%d/%m/%Y",strtotime($fecha_pago))." ". $nombres_usuario_pago[0].$ap_paterno_usuario_pago[0].$ap_materno_usuario_pago[0];?></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
      		<td><?php echo $obs_pago;?></td>
    	</tr>  
		 <tr bgcolor="#FFFFFF">
     		<td>Estado de Pago</td>
      		<td><?php echo $desc_estado_pago;?></td>
    	</tr>  
        <?php if($cod_estado_pago==2){?>  
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Datos de Anulaci&oacute;n</td>
		 </tr>        
        <tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
      		<td><?php echo $obs_anulacion;?></td>
    	</tr>
       <tr bgcolor="#FFFFFF">
     		<td>Fecha Anulaci&oacute;n</td>
      		<td><?php echo strftime("%d/%m/%Y",strtotime($fecha_anulacion))." ". $nombres_usuario_anula[0].$ap_paterno_usuario_anula[0].$ap_materno_usuario_anula[0];?></td>
    	</tr>
                         
       <?php }?>                   
		</table>
         <div id="divDetallePago">
        <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1">
          <tr class="titulo_tabla">
            <td align="center" height="20">Tipo Doc</td>
            <td align="center" height="20">DOC</td>
            <td align="center" height="20">Fecha DOC</td>              
            <td align="center" height="20">Monto DOC</td> 
			<td align="center" height="20">Estado Actual DOC</td>            
            <td align="center" height="20">Forma de Pago</td>
            <td align="center" height="20">Banco</td>                           
            <td align="center" height="20">Nro Cuenta</td>
			<td align="center" height="20">Nro Cheque</td>                       
            <td align="center" height="20">Monto Pago</td>
			<td align="center" height="20">Moneda</td>
            <td align="center" height="20">Tipo Cambio</td>             
            <td align="center" height="20">Monto Pago(Bs)</td>
            <td align="center" height="20">Nro Comprobante</td>             
            <td align="center" height="20">Fecha Comprobante</td>            
           </tr>
			<?php  
				$total_pago=0;          
				$sql2=" select pd.cod_pago_detalle, pd.codigo_doc, hr.nro_hoja_ruta, g.gestion,hr.fecha_hoja_ruta,";
				$sql2.="  hr.cod_estado_pago_doc, pd.monto_pago_detalle, pd.cod_forma_pago, pd.cod_banco,";
				$sql2.=" pd.cod_moneda, pd.nro_cheque, pd.nro_cuenta, pd.nro_comprobante, pd.fecha_comprobante";
				$sql2.=" from pagos_detalle pd, hojas_rutas hr, gestiones g ";
				$sql2.=" where pd.cod_pago=".$cod_pago;
				$sql2.=" and pd.codigo_doc=hr.cod_hoja_ruta ";
				$sql2.=" and pd.cod_tipo_doc=1 ";
				$sql2.=" and hr.cod_gestion=g.cod_gestion ";
				$sql2.=" order by hr.fecha_hoja_ruta asc ,hr.nro_hoja_ruta asc, g.gestion asc";
				$resp2 = mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$cod_pago_detalle=$dat2['cod_pago_detalle'];
					$cod_hoja_ruta=$dat2['codigo_doc'];
					$nro_hoja_ruta=$dat2['nro_hoja_ruta'];
					$gestion=$dat2['gestion'];
					$fecha_hoja_ruta=$dat2['fecha_hoja_ruta'];
					$cod_estado_pago_doc=$dat2['cod_estado_pago_doc'];
					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					$cod_forma_pago=$dat2['cod_forma_pago'];
					$cod_banco=$dat2['cod_banco'];
					$cod_moneda=$dat2['cod_moneda'];
					$nro_cheque=$dat2['nro_cheque'];
					$nro_cuenta=$dat2['nro_cuenta'];	
					$nro_comprobante=$dat2['nro_comprobante'];
					$fecha_comprobante=$dat2['fecha_comprobante'];		


			?>   
<?php 
			 		$monto_hojaruta=0;
			 		$sql3=" select sum(cd.IMPORTE_TOTAL) ";
					$sql3.=" from hojas_rutas_detalle hrd, cotizaciones_detalle cd ";
					$sql3.=" where hrd.cod_hoja_ruta=".$cod_hoja_ruta;
					$sql3.=" and hrd.cod_cotizacion=cd.cod_cotizacion ";
					$sql3.=" and hrd.cod_cotizaciondetalle=cd.cod_cotizaciondetalle ";
					$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$monto_hojaruta=$dat3[0];
					}
					
					//////////////////////////
					$descuento_cotizacion=0;
					$sql3=" select c.descuento_cotizacion ";
					$sql3.=" from hojas_rutas hr, cotizaciones c ";
					$sql3.=" where hr.cod_cotizacion=c.cod_cotizacion ";
					$sql3.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
					$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$descuento_cotizacion=$dat3['descuento_cotizacion'];
					}
					///////////////////////////
					//////////////////////////
					$incremento_cotizacion=0;
					$sql3=" select c.incremento_cotizacion ";
					$sql3.=" from hojas_rutas hr, cotizaciones c ";
					$sql3.=" where hr.cod_cotizacion=c.cod_cotizacion ";
					$sql3.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
					$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$incremento_cotizacion=$dat3['incremento_cotizacion'];
					}
					///////////////////////////					
					$monto_hojaruta=($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion;												
			 ?>                   
          <tr  <?php if($descuento_cotizacion>0){ ?> bgcolor="#FFCC00" <?php }else{?>bgcolor="#FFFFFF"<?php } ?>>
            <td align="left">HR</td> 
            <td align="left"><?php echo $nro_hoja_ruta."/".$gestion; ?></td> 
            <td align="left"><?php echo strftime("%d/%m/%Y",strtotime($fecha_hoja_ruta)); ?></td> 
            <td align="right">&nbsp;<?php echo $monto_hojaruta; ?></td> 
            <td align="center"><?php 
			
			$sql3=" select desc_estado_pago_doc ";
			$sql3.=" from estado_pago_documento ";
			$sql3.=" where cod_estado_pago_doc=".$cod_estado_pago_doc;
			$resp3 = mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3)){
							$desc_estado_pago_doc=$dat3['desc_estado_pago_doc'];
				}
				echo $desc_estado_pago_doc;
			
			 ?></td>              
            <td align="left"><?php 
				$sql3="select desc_forma_pago from forma_pago where cod_forma_pago=".$cod_forma_pago;
				$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$desc_forma_pago=$dat3['desc_forma_pago'];
					}
					echo $desc_forma_pago;
			?>
            </td> 
            <td align="left">
            <?php
            	if($cod_forma_pago<>1){
				$sql3="select desc_banco from bancos where cod_banco=".$cod_banco;
				$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$desc_banco=$dat3['desc_banco'];
					}
					echo $desc_banco;					
				
				}
			?>
            </td> 
            <td align="left"><?php echo $nro_cuenta;?></td> 
            <td align="left"><?php echo $nro_cheque;?></td>
            <td align="right"><?php echo $monto_pago_detalle;?></td> 
            <td align="left">
			<?php
            	
				$sql3="select desc_moneda, abrev_moneda from monedas where cod_moneda=".$cod_moneda;
				$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$desc_moneda=$dat3['desc_moneda'];
						$abrev_moneda=$dat3['abrev_moneda'];
					}
					echo $abrev_moneda;					
			?></td> 
             
            <td align="right">
			<?php
            	if($cod_moneda<>1){
					$sql3="select cambio_bs from tipo_cambio";
					$sql3.=" where fecha_tipo_cambio='".$fecha_pago."' and cod_moneda='".$cod_moneda."'";
					$resp3=mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
								$cambio_bs=$dat3['cambio_bs'];
					}	
					echo $cambio_bs;							
				}
			?>
            </td> 
            <td align="right"><?php
            	if($cod_moneda<>1){
					$total_pago=$total_pago+($monto_pago_detalle*$cambio_bs);
					echo $monto_pago_detalle*$cambio_bs;		
				}else{
					$total_pago=$total_pago+$monto_pago_detalle;
					echo $monto_pago_detalle;
				}
				
			?></td> 
            <td align="right"><?php echo $nro_comprobante;?></td>     
            <td align="right"><?php echo strftime("%d/%m/%Y",strtotime($fecha_comprobante)); ?></td>                    
          </tr> 
          
         <?php }?>   

         <?php  
        
				$sql2=" select pd.cod_pago_detalle, pd.codigo_doc, ot.nro_orden_trabajo, ot.numero_orden_trabajo, g.gestion, ";
				$sql2.=" ot.fecha_orden_trabajo, ot.cod_estado_pago_doc, pd.monto_pago_detalle, pd.cod_forma_pago, pd.cod_banco,";
				$sql2.=" pd.cod_moneda, pd.nro_cheque, pd.nro_cuenta, pd.nro_comprobante, pd.fecha_comprobante";

				$sql2.=" from pagos_detalle pd, ordentrabajo ot, gestiones g ";
				$sql2.=" where pd.cod_pago=".$cod_pago;
				$sql2.=" and pd.codigo_doc=ot.cod_orden_trabajo ";
				$sql2.=" and pd.cod_tipo_doc=2 ";
				$sql2.=" and ot.cod_gestion=g.cod_gestion ";
				$sql2.=" order by ot.nro_orden_trabajo asc, g.gestion asc";
				$resp2 = mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$cod_pago_detalle=$dat2['cod_pago_detalle'];
					$cod_orden_trabajo=$dat2['codigo_doc'];
					$nro_orden_trabajo=$dat2['nro_orden_trabajo'];
					$numero_orden_trabajo=$dat2['numero_orden_trabajo'];
					$gestion=$dat2['gestion'];
					$fecha_orden_trabajo=$dat2['fecha_orden_trabajo'];
					$cod_estado_pago_doc=$dat2['cod_estado_pago_doc'];
					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					$cod_forma_pago=$dat2['cod_forma_pago'];
					$cod_banco=$dat2['cod_banco'];
					$cod_moneda=$dat2['cod_moneda'];
					$nro_cheque=$dat2['nro_cheque'];
					$nro_cuenta=$dat2['nro_cuenta'];	
					$nro_comprobante=$dat2['nro_comprobante'];
					$fecha_comprobante=$dat2['fecha_comprobante'];	

					
					

	 				$monto_ordetrabajo=0;
					$descuento_orden_trabajo=0;
					$incremento_orden_trabajo=0;
			 		$sql3=" select monto_orden_trabajo, descuento_orden_trabajo, incremento_orden_trabajo";
					$sql3.=" from ordentrabajo";
					$sql3.=" where cod_orden_trabajo=".$cod_orden_trabajo;
					$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$monto_ordetrabajo=$dat3['monto_ordetrabajo'];
						$descuento_orden_trabajo=$dat3['descuento_orden_trabajo'];
						$incremento_orden_trabajo=$dat3['incremento_orden_trabajo'];
					}
					///////////////////////////	
				
					$monto_ordetrabajo=($monto_ordetrabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo;																					
			 ?>                   
          <tr  bgcolor="#FFFFFF">
            <td align="left">OT</td> 
            <td align="left"><?php echo $nro_orden_trabajo."/".$gestion."(".$numero_orden_trabajo.")"; ?></td> 
            <td align="left"><?php echo strftime("%d/%m/%Y",strtotime($fecha_orden_trabajo)); ?></td> 
            <td align="right">&nbsp;<?php echo $monto_ordetrabajo; ?></td> 
            <td align="center"><?php 
			
			$sql3=" select desc_estado_pago_doc ";
			$sql3.=" from estado_pago_documento ";
			$sql3.=" where cod_estado_pago_doc=".$cod_estado_pago_doc;
			$resp3 = mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3)){
							$desc_estado_pago_doc=$dat3['desc_estado_pago_doc'];
				}
				echo $desc_estado_pago_doc;
			
			 ?></td>              
            <td align="left"><?php 
				$sql3="select desc_forma_pago from forma_pago where cod_forma_pago=".$cod_forma_pago;
				$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$desc_forma_pago=$dat3['desc_forma_pago'];
					}
					echo $desc_forma_pago;
			?>
            </td> 
            <td align="left">
            <?php
            	if($cod_forma_pago<>1){
				$sql3="select desc_banco from bancos where cod_banco=".$cod_banco;
				$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$desc_banco=$dat3['desc_banco'];
					}
					echo $desc_banco;					
				
				}
			?>
            </td> 
            <td align="left"><?php echo $nro_cuenta;?></td> 
            <td align="left"><?php echo $nro_cheque;?></td>
            <td align="right"><?php echo $monto_pago_detalle;?></td> 
            <td align="left">
			<?php
            	
				$sql3="select desc_moneda, abrev_moneda from monedas where cod_moneda=".$cod_moneda;
				$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$desc_moneda=$dat3['desc_moneda'];
						$abrev_moneda=$dat3['abrev_moneda'];
					}
					echo $abrev_moneda;					
			?></td> 
             
            <td align="right">
			<?php
            	if($cod_moneda<>1){
					$sql3="select cambio_bs from tipo_cambio";
					$sql3.=" where fecha_tipo_cambio='".$fecha_pago."' and cod_moneda='".$cod_moneda."'";
					$resp3=mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
								$cambio_bs=$dat3['cambio_bs'];
					}	
					echo $cambio_bs;							
				}
			?>
            </td> 
            <td align="right"><?php
            	if($cod_moneda<>1){
					$total_pago=$total_pago+($monto_pago_detalle*$cambio_bs);
					echo $monto_pago_detalle*$cambio_bs;		
				}else{
					$total_pago=$total_pago+$monto_pago_detalle;
					echo $monto_pago_detalle;
				}
				
			?></td> 
            <td align="right"><?php echo $nro_comprobante;?></td>     
            <td align="right"><?php echo strftime("%d/%m/%Y",strtotime($fecha_comprobante)); ?></td>                    
          </tr> 
          
         <?php }?>   
         
<?php  
        
				$sql2=" select pd.cod_pago_detalle, pd.codigo_doc, s.nro_salida, g.gestion,s.fecha_salida,";
				$sql2.=" s.cod_estado_pago_doc, pd.monto_pago_detalle, pd.cod_forma_pago, pd.cod_banco,";
				$sql2.=" pd.cod_moneda, pd.nro_cheque, pd.nro_cuenta, pd.nro_comprobante, pd.fecha_comprobante";
				$sql2.=" from pagos_detalle pd, salidas s, gestiones g ";
				$sql2.=" where pd.cod_pago=".$cod_pago;
				$sql2.=" and pd.codigo_doc=s.cod_salida ";
				$sql2.=" and pd.cod_tipo_doc=3";
				$sql2.=" and s.cod_gestion=g.cod_gestion ";
				$sql2.=" order by s.fecha_salida asc, s.nro_salida asc, g.gestion asc";
				
				$resp2 = mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$cod_pago_detalle=$dat2['cod_pago_detalle'];
					$cod_salida=$dat2['codigo_doc'];
					$nro_salida=$dat2['nro_salida'];
					$gestion=$dat2['gestion'];
					$fecha_salida=$dat2['fecha_salida'];
					$cod_estado_pago_doc=$dat2['cod_estado_pago_doc'];
					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					$cod_forma_pago=$dat2['cod_forma_pago'];
					$cod_banco=$dat2['cod_banco'];
					$cod_moneda=$dat2['cod_moneda'];
					$nro_cheque=$dat2['nro_cheque'];
					$nro_cuenta=$dat2['nro_cuenta'];	
					$nro_comprobante=$dat2['nro_comprobante'];
					$fecha_comprobante=$dat2['fecha_comprobante'];		


			?>   
<?php 
	 				$monto_venta=0;
			 		$sql5=" select sum(sd.precio_venta) ";
					$sql5.=" from salidas_detalle sd ";
					$sql5.=" where sd.cod_salida=".$cod_salida;
					$resp5 = mysql_query($sql5);
					while($dat5=mysql_fetch_array($resp5)){
						$monto_venta=$dat5[0];
					}
																
			 ?>                   
          <tr  <?php if($descuento_cotizacion>0){ ?> bgcolor="#FFCC00" <?php }else{?>bgcolor="#FFFFFF"<?php } ?>>
            <td align="left">VENTA</td> 
            <td align="left"><?php echo $nro_salida."/".$gestion; ?></td> 
            <td align="left"><?php echo strftime("%d/%m/%Y",strtotime($fecha_salida)); ?></td> 
            <td align="right">&nbsp;<?php echo $monto_venta; ?></td> 
            <td align="center"><?php 
			
			$sql3=" select desc_estado_pago_doc ";
			$sql3.=" from estado_pago_documento ";
			$sql3.=" where cod_estado_pago_doc=".$cod_estado_pago_doc;
			$resp3 = mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3)){
							$desc_estado_pago_doc=$dat3['desc_estado_pago_doc'];
				}
				echo $desc_estado_pago_doc;
			
			 ?></td>              
            <td align="left"><?php 
				$sql3="select desc_forma_pago from forma_pago where cod_forma_pago=".$cod_forma_pago;
				$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$desc_forma_pago=$dat3['desc_forma_pago'];
					}
					echo $desc_forma_pago;
			?>
            </td> 
            <td align="left">
            <?php
            	if($cod_forma_pago<>1){
				$sql3="select desc_banco from bancos where cod_banco=".$cod_banco;
				$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$desc_banco=$dat3['desc_banco'];
					}
					echo $desc_banco;					
				
				}
			?>
            </td> 
            <td align="left"><?php echo $nro_cuenta;?></td> 
            <td align="left"><?php echo $nro_cheque;?></td>
            <td align="right"><?php echo $monto_pago_detalle;?></td> 
            <td align="left">
			<?php
            	
				$sql3="select desc_moneda, abrev_moneda from monedas where cod_moneda=".$cod_moneda;
				$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$desc_moneda=$dat3['desc_moneda'];
						$abrev_moneda=$dat3['abrev_moneda'];
					}
					echo $abrev_moneda;					
			?></td> 
             
            <td align="right">
			<?php
            	if($cod_moneda<>1){
					$sql3="select cambio_bs from tipo_cambio";
					$sql3.=" where fecha_tipo_cambio='".$fecha_pago."' and cod_moneda='".$cod_moneda."'";
					$resp3=mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
								$cambio_bs=$dat3['cambio_bs'];
					}	
					echo $cambio_bs;							
				}
			?>
            </td> 
            <td align="right"><?php
            	if($cod_moneda<>1){
					$total_pago=$total_pago+($monto_pago_detalle*$cambio_bs);
					echo $monto_pago_detalle*$cambio_bs;		
				}else{
					$total_pago=$total_pago+$monto_pago_detalle;
					echo $monto_pago_detalle;
				}
				
			?></td> 
            <td align="right"><?php echo $nro_comprobante;?></td>     
            <td align="right"><?php echo strftime("%d/%m/%Y",strtotime($fecha_comprobante)); ?></td>                    
          </tr> 
          
         <?php }?>            

         
             <tr class="titulo_tabla">
             <td align="right" colspan="12">Monto Total Bs.</td> 
            <td align="right"><?php echo $total_pago." Bs."; ?></td> 
            <td align="right" colspan="2">&nbsp;</td> 
            <tr>      
        </table>            
      </div>    
      <br/>
      <div align="center">
      <input type="button" name="atras" id="atras" onClick="retornar()" value="IR A  LISTADO DE PAGOS" class="boton">
                  <?php

           if($fecha_pago==date('Y-m-d',time()) ){
			if($cod_estado_pago<>2){
			?>
            <input name="modificarDatos" type="button" class="boton" id="modificarDatos" value="MODIFICAR DATOS" onclick="modificar()"/>
            <?php
				}
			}
			?>


      </div>
</form>

</body>
</html>
