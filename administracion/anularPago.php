
<?php 

	require("conexion.inc");
	include("funciones.php");
	
	$cod_pago=$_GET['cod_pago'];
	$sql=" select  p.nro_pago, p.cod_gestion, g.gestion, ";
	$sql.=" p.cod_cliente, cli.nombre_cliente,  p.fecha_pago, p.cod_usuario_pago, p.obs_pago, p.monto_pago, ";
	$sql.=" p.cod_estado_pago, ep.desc_estado_pago, p.total_bs, p.fecha_registro ";
	$sql.=" from pagos p, gestiones g,  clientes cli, estados_pago ep ";
	$sql.=" where  p.cod_gestion=g.cod_gestion ";
	$sql.=" and p.cod_cliente=cli.cod_cliente ";
	$sql.=" and p.cod_estado_pago=ep.cod_estado_pago ";
	$sql.=" and p.cod_pago=".$_GET['cod_pago'];
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
								$total_bs=$dat['total_bs'];
				$fecha_registro=$dat['fecha_registro'];
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
			
	}
			$sql3="select cambio_bs from tipo_cambio";
		$sql3.=" where fecha_tipo_cambio='".$fecha_registro."'";
		$sql3.=" and cod_moneda=2";
		$resp3 = mysql_query($sql3);
		$cambio_bs=0;
		while($dat3=mysql_fetch_array($resp3)){
			$cambio_bs=$dat3['cambio_bs'];
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
		if(document.form1.obs_anulacion.value==""){
			alert("Por favor llenar la razon porque se anula el pago");
			document.form1.obs_anulacion.focus();
		}else{
			location.href='saveAnularPago.php?obs_anulacion='+document.form1.obs_anulacion.value+'&cod_pago='+document.form1.cod_pago.value;
		}
	}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>
<body>

<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post"  name="form1" id="form1">
<input type="hidden" name="cod_pago" id="cod_pago" value="<?php echo $cod_pago;?>">

<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">ANULACION DE PAGO</br> No. <?php echo $nro_pago;?>/<?php echo $gestion;?></h3>

</br>
<table align="center" border="0">
<tr><td bgcolor="#FFCC00">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td style="background:#FFF;font-size: 10px;color: #E78611;font-weight:bold;">Hojas Rutas con Descuento</td></tr>
</table>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="4" align="center">Introduzca Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Cliente</td>
      		<td colspan="3"><?php echo $nombre_cliente;?></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha Pago</td>
      		<td colspan="3"><?php echo strftime("%d/%m/%Y",strtotime($fecha_pago))." ". $nombres_usuario_pago[0].$ap_paterno_usuario_pago[0].$ap_materno_usuario_pago[0];?></td>
    	</tr> 
<tr bgcolor="#FFFFFF">
     		 <tr bgcolor="#FFFFFF">
     		<td>Fecha Registro</td>
      		<td colspan="3"><?php echo strftime("%d/%m/%Y",strtotime($fecha_registro));?></td>
    	</tr>		
		 <tr bgcolor="#FFFFFF">
     		<td>Monto Total de Pago</td>
      		<td colspan="3"><?php echo $total_bs." Bs.";?></td>
    	</tr>	
		 <tr bgcolor="#FFFFFF">
     		<td>Estado de Pago Actual</td>
      		<td colspan="3"><?php echo $desc_estado_pago;?></td>
    	</tr>   
<tr class="titulo_tabla">
		   <td  colSpan="4" align="center">Detalle de Pago</td>
		 </tr> 	
		 <tr class="titulo_tabla">
		   <td  align="center">Monto</td>
		   <td  align="center">Forma de Pago</td>
		   <td  align="center">Banco</td>
		   <td  align="center">Nro Cheque/Cuenta </td>
		 </tr> 			 		
		<?php
		$sql=" select pd.cod_forma_pago,fp.desc_forma_pago,pd.cod_moneda,m.desc_moneda,m.abrev_moneda, ";
		$sql.=" pd.monto_pago,pd.cod_banco,b.desc_banco, pd.nro_cheque,pd.nro_cuenta ";
		$sql.=" from pagos_descripcion pd ";
		$sql.=" left JOIN forma_pago fp on(pd.cod_forma_pago=fp.cod_forma_pago)";
		$sql.=" left JOIN monedas m on(pd.cod_moneda=m.cod_moneda)";
		$sql.=" left JOIN bancos b on(pd.cod_banco=b.cod_banco)";
		$sql.=" where pd.cod_pago=".$_GET['cod_pago'];
		$resp = mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){
			$cod_forma_pago=$dat['cod_forma_pago'];
			$desc_forma_pago=$dat['desc_forma_pago'];
			$cod_moneda=$dat['cod_moneda'];
			$desc_moneda=$dat['desc_moneda'];
			$abrev_moneda=$dat['abrev_moneda'];
			$monto_pago=$dat['monto_pago'];
			$cod_banco=$dat['cod_banco'];
			$desc_banco=$dat['desc_banco'];
			$nro_cheque=$dat['nro_cheque'];
			$nro_cuenta=$dat['nro_cuenta'];
	?>
		 <tr bgcolor="#FFFFFF">
     		<td align="right"><?php echo $monto_pago." ".$abrev_moneda; 
			if($cod_moneda==2){
				echo " ( T.C. ".$cambio_bs." Equivale: ".$monto_pago*$cambio_bs." Bs. )";
			}
			?></td>
			<td align="right"><?php echo $desc_forma_pago; ?></td>
			<td align="right"><?php echo $desc_banco; ?></td>
			<td align="right"><?php echo $nro_cheque.$nro_cuenta; ?></td>
    	</tr> 
	<?php			
		}
		
		?>		
		 <tr class="titulo_tabla">
		   <td  colSpan="4" align="center">Datos de Anulaci&oacute;n</td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
      		<td colspan="3"><textarea name="obs_anulacion" id="obs_anulacion" class="textoform" cols="80"></textarea></td>
    	</tr>                                    
		</table>
 <div id="divDetallePago">
        <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1">
          <tr class="titulo_tabla">
            <td align="center" height="20">Tipo Doc</td>
            <td align="center" height="20">Nro Doc </td>
            <td align="center" height="20">Fecha DOC</td>              
            <td align="center" height="20">Monto DOC</td> 
            <td align="center" height="20">Descripcion</td>                    
            <td align="center" height="20">Monto Pago(Bs)</td>
			<td align="center" height="20">Estado Actual DOC</td>            
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
					$total_pago=$total_pago+$monto_pago_detalle;
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
            <td align="right">&nbsp;</td> 
            <td align="right"><?php echo $monto_pago_detalle;?></td>                                                   
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
						$monto_ordetrabajo=$dat3['monto_orden_trabajo'];
						$descuento_orden_trabajo=$dat3['descuento_orden_trabajo'];
						$incremento_orden_trabajo=$dat3['incremento_orden_trabajo'];
					}
					///////////////////////////	
					$total_pago=$total_pago+$monto_pago_detalle;
				
					$monto_ordetrabajo=($monto_ordetrabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo;																					
			 ?>                   
          <tr  bgcolor="#FFFFFF">
            <td align="left">OT</td> 
            <td align="left"><?php echo $nro_orden_trabajo."/".$gestion."(".$numero_orden_trabajo.")"; ?></td> 
            <td align="left"><?php echo strftime("%d/%m/%Y",strtotime($fecha_orden_trabajo)); ?></td> 
            <td align="right">&nbsp;<?php echo $monto_ordetrabajo; ?></td>                       
            <td align="right">&nbsp;</td>       
			<td align="right"><?php echo $monto_pago_detalle;?></td>       
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
			?>   
<?php 
	 				$monto_venta=0;
			 		$sql5=" select sum(sd.precio_venta*sd.cant_salida) ";
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
            <td align="right">&nbsp;</td> 
            <td align="right">&nbsp;<?php echo $monto_pago_detalle; ?></td> 
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
          </tr> 
          
         <?php }?>      
       

         
             <tr class="titulo_tabla">
             <td align="right" colspan="5">Monto Total Bs.</td> 
            <td align="right"><?php echo $total_pago." Bs."; ?></td> 
            <td align="right" colspan="1">&nbsp;</td> 
            <tr>      
        </table>            
      </div>                 
      <br/>
      <div align="center">
      <input type="button" name="atras" id="atras" onClick="retornar()" value="IR A  LISTADO DE PAGOS" class="boton">

            <input name="modificarDatos" type="button" class="boton" id="modificarDatos" value="CONFIRMAR ANULACION" onclick="modificar()"/>



      </div>
</form>

</body>
</html>
