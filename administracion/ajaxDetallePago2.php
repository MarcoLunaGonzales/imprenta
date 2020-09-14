<?php 
header("Cache-Control: no-store, no-cache, must-revalidate");
require("conexion.inc");
include("funciones.php");


$cod_cliente=$_GET['cod_cliente'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Documento sin t&iacute;tulo</title>
<link href="pagina.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
	$sql="select cambio_bs from tipo_cambio where fecha_tipo_cambio='".date('Y-m-d', time())."'";
	$resp= mysql_query($sql);
	$cambio_bs='';
	while($dat=mysql_fetch_array($resp)){
		$cambio_bs=$dat['cambio_bs'];
	}
?>
<input type="hidden" id="cambio_bs" name="cambio_bs" value="<?php echo $cambio_bs?>">
<?php
if($cambio_bs==null or $cambio_bs=='' ){
?>
<div align="center" style="background:#FFF;font-size: 14px;color: #FF0000;font-weight:bold;">ATENCION!!! No existe el Cambio de Dolar para Hoy</div>
<?php
}
?>
<?php
	$sql=" select cod_cuenta ";
	$sql.=" from clientes";
	$sql.=" where cod_cliente=".$_GET['cod_cliente'];
	$resp= mysql_query($sql);
	$cod_cuenta="";
	while($dat=mysql_fetch_array($resp)){
		$cod_cuenta=$dat['cod_cuenta'];
	}
?>
<?php
if($cod_cuenta==null or $cod_cuenta=='' ){
?>
<div align="center" style="background:#FFF;font-size: 14px;color: #FF0000;font-weight:bold;">ATENCION!!! El Cliente No tiene una Cta. Asignada</div>
<?php
}
?>
<input type="hidden" id="cod_cuenta" name="cod_cuenta" value="<?php echo $cod_cuenta?>">
<?php
	
	$sql=" select count(*) ";
	$sql.=" from hojas_rutas hr, cotizaciones c, gestiones g";
	$sql.=" where hr.cod_cotizacion=c.cod_cotizacion";
	$sql.=" and hr.cod_gestion=g.cod_gestion";
	$sql.=" and c.cod_cliente=".$_GET['cod_cliente'];
	$sql.=" and hr.cod_estado_hoja_ruta<>2";
	$sql.=" and hr.cod_estado_pago_doc<>3";
	$sql.=" order by  hr.fecha_hoja_ruta asc , hr.nro_hoja_ruta asc  ";
	$resp= mysql_query($sql);
	$nroRowsHR=0;
	while($dat=mysql_fetch_array($resp)){
		$nroRowsHR=$dat[0];
		
	}
	/////////////////////ORDENES DE TRABAJO//////////////////////
	$sql=" select count(*) ";
	$sql.=" from ordentrabajo ot, gestiones g ";
	$sql.=" where ot.cod_est_ot<>2 ";
	$sql.=" and ot.cod_estado_pago_doc<>3 ";
	$sql.=" and ot.cod_gestion=g.cod_gestion "; 
	$sql.=" and ot.cod_cliente=".$cod_cliente;
	$sql.=" order by ot.fecha_orden_trabajo desc, ot.nro_orden_trabajo desc ";
	$resp= mysql_query($sql);
	$nroRowsOT=0;
	while($dat=mysql_fetch_array($resp)){
		$nroRowsOT=$dat[0];
		
	}	
	/////////////////////SALIDAS DE ALMACEN//////////////////////	
	
	$sql=" select count(*)";
	$sql.=" from salidas s, gestiones g ";
	$sql.=" where s.cod_gestion=g.cod_gestion";
	$sql.=" and s.cod_tipo_salida=1 ";
	$sql.=" and s.cod_estado_salida=1 ";
	$sql.=" and s.cod_estado_pago_doc<>3 ";
	$sql.=" and s.cod_cliente_venta=".$_GET['cod_cliente'];

	$resp= mysql_query($sql);
	$nroRowsVentas=0;
	while($dat=mysql_fetch_array($resp)){
		$nroRowsVentas=$dat[0];
		
	}		


	if($nroRowsHR==0 and $nroRowsOT==0 and $nroRowsVentas==0 ){
?>
 <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1">
          <tr class="titulo_tabla">
            <td align="center" height="20">Tipo Doc.</td>
            <td align="center" height="20">Nro Doc.</td>
            <td align="center" height="20">Fecha Doc.</td> 
            <td align="center" height="20">Monto Bs</td> 
            <td align="center" height="20">A Cuenta Bs</td>
            <td align="center" height="20">Saldo Bs</td>             
            <td align="center" height="20">Monto Pago</td>         
           </tr>
          <tr  bgcolor="#FFFFFF">
            <td align="center" colspan="7">DETALLE DE PAGOS</td>              
          </tr>          
        </table>   
<?php		
			
	}else{
?> 

        <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1">
          <tr class="titulo_tabla">
            <td align="center" height="20"><input type="checkbox" name="seleccionarTodo"  id="seleccionarTodo" onclick="checkearRegistros()" checked="true" ></td>
            <td align="center" height="20">Tipo Doc.</td>
            <td align="center" height="20">Nro Doc.</td>
            <td align="center" height="20">Fecha Doc.</td> 
            <td align="center" height="20">Monto Bs</td> 
            <td align="center" height="20">A Cuenta Bs</td>
            <td align="center" height="20">Saldo Bs</td>             
            <td align="center" height="20">Monto Pago</td>
		</tr>
          
           
<?php 
	$totalDeuda=0;
	$sql=" select hr.cod_hoja_ruta, hr.nro_hoja_ruta, hr.cod_gestion, g.gestion,  hr.fecha_hoja_ruta, hr.cod_cotizacion ";
	$sql.=" from hojas_rutas hr, cotizaciones c, gestiones g";
	$sql.=" where hr.cod_cotizacion=c.cod_cotizacion";
	$sql.=" and hr.cod_gestion=g.cod_gestion";
	$sql.=" and c.cod_cliente=".$_GET['cod_cliente'];
	$sql.=" and hr.cod_estado_hoja_ruta<>2";
	$sql.=" and hr.cod_estado_pago_doc<>3";
	$sql.=" order by  hr.fecha_hoja_ruta asc , hr.nro_hoja_ruta asc  ";

	$resp= mysql_query($sql);
	$gestion="";
	while($dat=mysql_fetch_array($resp)){
		 $cod_hoja_ruta=$dat['cod_hoja_ruta'];
		 $nro_hoja_ruta=$dat['nro_hoja_ruta'];
		 $cod_gestion=$dat['cod_gestion'];
		 $gestion=$dat['gestion'];
		 $fecha_hoja_ruta=$dat['fecha_hoja_ruta'];
		 $cod_cotizacion=$dat['cod_cotizacion'];
?>		
 <?php 
			 		$monto_hojaruta=0;
			 		$sql2=" select sum(cd.IMPORTE_TOTAL) ";
					$sql2.=" from hojas_rutas_detalle hrd, cotizaciones_detalle cd ";
					$sql2.=" where hrd.cod_hoja_ruta=".$cod_hoja_ruta;
					$sql2.=" and hrd.cod_cotizacion=cd.cod_cotizacion ";
					$sql2.=" and hrd.cod_cotizaciondetalle=cd.cod_cotizaciondetalle ";
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$monto_hojaruta=$dat2[0];
					}
					$descuento_cotizacion=0;
					$sql2=" select c.descuento_cotizacion ";
					$sql2.=" from hojas_rutas hr, cotizaciones c ";
					$sql2.=" where hr.cod_cotizacion=c.cod_cotizacion ";
					$sql2.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$descuento_cotizacion=$dat2['descuento_cotizacion'];
					}
					$incremento_cotizacion=0;
					$sql2=" select c.incremento_cotizacion ";
					$sql2.=" from hojas_rutas hr, cotizaciones c ";
					$sql2.=" where hr.cod_cotizacion=c.cod_cotizacion ";
					$sql2.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$incremento_cotizacion=$dat2['incremento_cotizacion'];
					}		
								
					$monto_hojaruta=($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion;
					
			 ?>
          <tr  bgcolor="<?php if($descuento_cotizacion>0){echo '#FFCC00';} if($incremento_cotizacion>0){ echo'#E8D2FB';}?>" >
            <td align="left"><input type="checkbox" name="cod_hoja_ruta<?php echo $cod_hoja_ruta;?>" id="cod_hoja_ruta<?php echo $cod_hoja_ruta;?>" value="<?php echo $cod_hoja_ruta;?>" class="textoform" onclick="habilitarFilaHojaRuta(<?php echo $cod_hoja_ruta;?>)" checked="true"></td>
            <td>HR</td> 
             <td align="left"><a href="../reportes/impresionHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta; ?>" target="_blank"> <?php echo $nro_hoja_ruta."/".$gestion; ?></a></td>  
             <td align="left">&nbsp;<?php echo strftime("%d.%m.%Y",strtotime($fecha_hoja_ruta)); ?></td> 
             
             <td align="right" >&nbsp;<?php echo $monto_hojaruta; ?>
			<input type="hidden"name="monto_hojaruta<?php echo $cod_hoja_ruta;?>"id="monto_hojaruta<?php echo $cod_hoja_ruta;?>" value="<?php echo $monto_hojaruta;?>"></td> 
             <td align="right">&nbsp;<?php 
			 	$sql2=" select SUM(pd.monto_pago_detalle) ";
			 	$sql2.=" from pagos_detalle pd, pagos p";
			 	$sql2.=" where pd.cod_pago=p.cod_pago";
			 	$sql2.=" and p.cod_estado_pago<>2";
			 	$sql2.=" and pd.codigo_doc=".$cod_hoja_ruta;
				$sql2.=" and pd.cod_tipo_doc=1";
				//echo $sql2;
				$resp2 = mysql_query($sql2);
				$acuenta_hojaruta=0;
				$monto_pago_detalle=0;
				while($dat2=mysql_fetch_array($resp2)){
					$monto_pago_detalle=$dat2[0];										
				}	
				$acuenta_hojaruta=$acuenta_hojaruta+$monto_pago_detalle;			
			 echo $acuenta_hojaruta;
			 $totalDeuda=$totalDeuda+$monto_hojaruta-$acuenta_hojaruta;
			 ?></td> 
             <td align="right"><?php echo number_format($monto_hojaruta-$acuenta_hojaruta,2);?>
             <input type="hidden" name="saldo_hojaruta<?php echo $cod_hoja_ruta;?>" id="saldo_hojaruta<?php echo $cod_hoja_ruta;?>" value="<?php echo number_format($monto_hojaruta-$acuenta_hojaruta,2);?>" ></td>       

			<td align="right">
			  <input type="text" name="monto_pago_hr<?php echo $cod_hoja_ruta; ?>" id="monto_pago_hr<?php echo $cod_hoja_ruta; ?>" value="<?php echo number_format($monto_hojaruta-$acuenta_hojaruta,2);?>" class="textoform" size="8" onKeyUp="validaFloat2(this)" onChange="validaFloat2(this)" >
            </td>                                                                
          </tr>          

<?php
	}
?>   

<?php
	$sql=" select ot.cod_orden_trabajo, ot.nro_orden_trabajo, g.gestion ,ot.cod_gestion, ot.numero_orden_trabajo, ";
	$sql.=" ot.fecha_orden_trabajo, ot.monto_orden_trabajo, ot.descuento_orden_trabajo, ot.incremento_orden_trabajo ";
	$sql.=" from ordentrabajo ot, gestiones g ";
	$sql.=" where ot.cod_est_ot<>2  ";
	$sql.=" and ot.cod_estado_pago_doc<>3 ";
	$sql.=" and ot.cod_gestion=g.cod_gestion "; 
	$sql.=" and ot.cod_cliente=".$cod_cliente;
	$sql.=" order by ot.fecha_orden_trabajo asc, ot.nro_orden_trabajo asc ";
	$resp= mysql_query($sql);
	$gestion="";
	while($dat=mysql_fetch_array($resp)){
		 $cod_orden_trabajo=$dat['cod_orden_trabajo'];
		 $nro_orden_trabajo=$dat['nro_orden_trabajo'];
		 $gestion=$dat['gestion'];
		 $cod_gestion=$dat['cod_gestion'];
		 $numero_orden_trabajo=$dat['numero_orden_trabajo'];
		 $fecha_orden_trabajo=$dat['fecha_orden_trabajo'];
		 $monto_orden_trabajo=$dat['monto_orden_trabajo'];
		 $descuento_orden_trabajo=$dat['descuento_orden_trabajo'];
		 $incremento_orden_trabajo=$dat['incremento_orden_trabajo'];
		 $monto_orden_trabajo=($monto_orden_trabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo;
		 
?>
 <tr  bgcolor="<?php if($descuento_orden_trabajo>0){echo '#FFCC00';} if($incremento_orden_trabajo>0){ echo'#E8D2FB';}?>" >
            <td align="left"><input type="checkbox" name="cod_orden_trabajo<?php echo $cod_orden_trabajo;?>" id="cod_orden_trabajo<?php echo $cod_orden_trabajo;?>" value="<?php echo $cod_orden_trabajo;?>" class="textoform" onclick="habilitarFilaOrdenTrabajo(<?php echo $cod_orden_trabajo;?>)" checked="true"></td>
            <td>OT</td> 
             <td align="left"><a href="../reportes/impresionOrdenTrabajo.php?cod_orden_trabajo=<?php echo $cod_orden_trabajo;?>" target="_blank"> <?php echo $nro_orden_trabajo."/".$gestion."(".$numero_orden_trabajo.")"; ?></a></td>  
             <td align="left">&nbsp;<?php echo strftime("%d.%m.%Y",strtotime($fecha_orden_trabajo)); ?></td> 
             
             <td align="right" >&nbsp;<?php echo $monto_orden_trabajo; ?>
			<input type="hidden"name="monto_ordentrabajo<?php echo $cod_orden_trabajo;?>"id="monto_ordentrabajo<?php echo $cod_orden_trabajo;?>" value="<?php echo $monto_orden_trabajo;?>"></td> 
             <td align="right">&nbsp;<?php 
			 	$sql2=" select SUM(pd.monto_pago_detalle) ";
			 	$sql2.=" from pagos_detalle pd, pagos p";
			 	$sql2.=" where pd.cod_pago=p.cod_pago";
			 	$sql2.=" and p.cod_estado_pago<>2";
			 	$sql2.=" and pd.codigo_doc=".$cod_orden_trabajo;
				$sql2.=" and pd.cod_tipo_doc=2";
				$resp2 = mysql_query($sql2);
				$acuenta_ordentrabajo=0;
				$monto_pago_detalle=0;
				while($dat2=mysql_fetch_array($resp2)){
					$monto_pago_detalle=$dat2[0];
				}	
				$acuenta_ordentrabajo=$acuenta_ordentrabajo+$monto_pago_detalle;			
				
			 echo $acuenta_ordentrabajo;
			  $totalDeuda=$totalDeuda+($monto_orden_trabajo-$acuenta_ordentrabajo);
			 ?></td> 
             <td align="right"><?php echo ($monto_orden_trabajo-$acuenta_ordentrabajo);?>
             <input type="hidden" name="saldo_ordentrabajo<?php echo $cod_orden_trabajo;?>" id="saldo_ordentrabajo<?php echo $cod_orden_trabajo;?>" value="<?php echo ($monto_orden_trabajo-$acuenta_ordentrabajo);?>"></td>       

			<td align="right">
			  <input type="text" name="monto_pago_ot<?php echo $cod_orden_trabajo; ?>" id="monto_pago_ot<?php echo $cod_orden_trabajo; ?>" value="<?php echo ($monto_orden_trabajo-$acuenta_ordentrabajo);?>" class="textoform" size="8" onKeyUp="validaFloat2(this)" onChange="validaFloat2(this)" >
            </td> 
                                                                 
          </tr>          
<?php
	
	}
?>


<?php 

	$sql=" select s.cod_salida, s.nro_salida, s.cod_gestion, g.gestion, s.cliente_venta, s.fecha_salida ";
	$sql.=" from salidas s, gestiones g ";
	$sql.=" where s.cod_gestion=g.cod_gestion ";
	$sql.=" and s.cod_tipo_salida=1 ";
	$sql.=" and s.cod_estado_salida=1 ";
	$sql.=" and s.cod_estado_pago_doc<>3 ";
	$sql.=" and s.cod_cliente_venta=".$_GET['cod_cliente'];
	$sql.=" order by fecha_salida asc,s.nro_salida asc ";

	$resp= mysql_query($sql);
	$gestionVenta="";
	while($dat=mysql_fetch_array($resp)){
		
		  $cod_salida=$dat['cod_salida'];
		  $nro_salida=$dat['nro_salida'];
		  $cod_gestion=$dat['cod_gestion'];
		  $gestionVenta=$dat['gestion'];
		  $cliente_venta=$dat['cliente_venta'];
		  $fecha_salida=$dat['fecha_salida'];
		

	 		$monto_venta=0;
			 		$sql2=" select sum(sd.precio_venta*sd.cant_salida) ";
					$sql2.=" from salidas_detalle sd ";
					$sql2.=" where sd.cod_salida=".$cod_salida;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$monto_venta=$dat2[0];
					}
					
					
			 ?>
          <tr  bgcolor="#FFFFFF" >
            <td align="left"><input type="checkbox" name="cod_salida<?php echo $cod_salida;?>" id="cod_salida<?php echo $cod_salida;?>" value="<?php echo $cod_salida;?>" class="textoform" onclick="habilitarFilaVenta(<?php echo $cod_salida;?>)" checked="true"></td>
            <td>VENTA</td> 
             <td align="left"><a href="../almacenes/detalleSalida.php?cod_salida=<?php echo $cod_salida; ?>" target="_blank"> <?php echo $nro_salida."/".$gestionVenta; ?></a></td>  
             <td align="left">&nbsp;<?php echo strftime("%d.%m.%Y",strtotime($fecha_salida)); ?></td> 
             
             <td align="right" >&nbsp;<?php echo $monto_venta; ?>
			<input type="hidden"name="monto_venta<?php echo $cod_salida;?>"id="monto_venta<?php echo $cod_salida;?>" value="<?php echo $monto_venta;?>"></td> 
             <td align="right">&nbsp;<?php 
			 	$sql2=" select SUM(pd.monto_pago_detalle) ";
			 	$sql2.=" from pagos_detalle pd, pagos p";
			 	$sql2.=" where pd.cod_pago=p.cod_pago";
			 	$sql2.=" and p.cod_estado_pago<>2";
			 	$sql2.=" and pd.codigo_doc=".$cod_salida;
				$sql2.=" and pd.cod_tipo_doc=3";
				$resp2 = mysql_query($sql2);
				$acuenta_venta=0;
				$monto_pago_detalle=0;
				while($dat2=mysql_fetch_array($resp2)){
					$monto_pago_detalle=$dat2[0];
				}
				$acuenta_venta=$acuenta_venta+$monto_pago_detalle;				
			 echo $acuenta_venta;
			 $totalDeuda=$totalDeuda+($monto_venta-$acuenta_venta);
			 ?></td> 
             <td align="right"><?php echo ($monto_venta-$acuenta_venta);?>
             <input type="hidden" name="saldo_venta<?php echo $cod_salida;?>" id="saldo_venta<?php echo $cod_salida;?>" value="<?php echo ($monto_venta-$acuenta_venta);?>"></td>       

			<td align="right">
			  <input type="text" name="monto_pago_venta<?php echo $cod_salida; ?>" id="monto_pago_venta<?php echo $cod_salida; ?>" value="<?php echo ($monto_venta-$acuenta_venta);?>" class="textoform" size="8" onKeyUp="validaFloat2(this)" onChange="validaFloat2(this)" >
            </td>                                                                 
          </tr>          

<?php
	}
?>   
<tr>
<td colspan="6" align="right"><strong>Total Deuda</strong></td>
<td align="right"><div id="id_totalDeuda"><?php echo $totalDeuda;?></div></td>
<td align="right">&nbsp;</td>

</tr>
<tr>
<td colspan="6" align="right"><strong>Total Deuda Seleccionados</strong></td>
<td align="right"><div id="id_totalDeudaSeleccionados"><?php echo $totalDeuda;?></div></td>
<td align="right"><div id="id_montoDocBs" style="display:inline"><?php echo $totalDeuda;?></div>&nbsp;&nbsp;<strong>Bs</strong></td>

</tr>
<?php
	$sql="select cambio_bs from tipo_cambio where fecha_tipo_cambio='".date('Y-m-d', time())."'";
	$resp= mysql_query($sql);
	$cambio_bs=0;
	while($dat=mysql_fetch_array($resp)){
		$cambio_bs=$dat['cambio_bs'];
	}
?>

        </table>
<center>
		<fieldset id="fiel" style="width:98%;border:0;" >
			<table align="center"class="text" cellSpacing="1" cellPadding="2" width="80%" border="0" id="data0">
				<tr>
					<td align="center" colspan="6">
						<input class="boton" type="button" value="Nuevo Item (+)" onclick="mas(this)" />
						
					</td>
				</tr>
				<tr>
					<td align="center" colspan="6">
					<div style="width:85%;" align="center"><b>DETALLE DE PAGO</b></div>
					</td>				
				</tr>				
				<tr class="titulo_tabla" align="center">
					<td width="20%">Forma Pago</td>
					<td width="11%">Moneda</td>
					<td width="15%">Monto</td>
					<td width="22%">Banco</td>
					<td width="10%">Nro Cheque</td>
					<td width="10%">Nro de Cuenta </td>
					<td width="19%">Cuenta </td>
					<td width="3%">&nbsp;</td>					

				</tr>
			</table>
		</fieldset>
				<table align="center"class="text" cellSpacing="1" cellPadding="2" width="78%" border="0" id="dataTotal">
				<tr class="titulo_tabla">
					<td width="31%" colspan="2">&nbsp;<b>Total</b></td>
					<td width="15%" align="right"><SPAN id="id_totalPagoClienteBs">0</SPAN></td>
					<td width="54%" align="left"><a href="javascript:distribuirDinero();"><img src="images/repartir.jpg" width="30" height="30" border="0" title="Distribuir"></a></td>
					
				</tr>		
		</table>
        <div align="center">
        <INPUT type="button" class="boton" name="btn_guardar" value="Guardar Pago" onClick="guardar(this.form);"  >
        </div>
<?php
	}
?>            
</body>
</html>