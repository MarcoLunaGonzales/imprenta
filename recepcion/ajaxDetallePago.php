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
	
	$sql=" select count(*) ";
	$sql.=" from hojas_rutas hr, cotizaciones c, gestiones g";
	$sql.=" where hr.cod_cotizacion=c.cod_cotizacion";
	$sql.=" and hr.cod_gestion=g.cod_gestion";
	$sql.=" and c.cod_cliente=".$cod_cliente;
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
            <td align="center" height="20">&nbsp;</td>
            <td align="center" height="20">Tipo Doc.</td>
            <td align="center" height="20">Nro. Doc.</td>
            <td align="center" height="20">Fecha Doc.</td> 
            <td align="center" height="20">Monto Bs</td> 
            <td align="center" height="20">A Cuenta Bs</td>
            <td align="center" height="20">Saldo Bs</td> 
            <td align="center" height="20">Forma de Pago</td>
            <td align="center" height="20">Banco</td>               
            <td align="center" height="20">Moneda</td>
            <td align="center" height="20">Nro Cuenta</td>
			<td align="center" height="20">Nro Cheque</td>            
            <td align="center" height="20">Monto Pago</td>
            <td align="center" height="20">Nro Comprobante</td>
            <td align="center" height="20">Fecha Comprobante</td>            
           </tr>
          <tr  bgcolor="#FFFFFF">
            <td align="center" colspan="15">DETALLE DE PAGOS</td>              
          </tr>          
        </table>   
<?php		
			
	}else{
?> 

        <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1">
          <tr class="titulo_tabla">
            <td align="center" height="20"><input type="checkbox" name="seleccionarTodo"  id="seleccionarTodo" onclick="checkearRegistros()" ></td>
            <td align="center" height="20">Tipo Doc.</td>
            <td align="center" height="20">Nro Doc.</td>
            <td align="center" height="20">Fecha Doc.</td> 
            <td align="center" height="20">Monto Bs</td> 
            <td align="center" height="20">A Cuenta Bs</td>
            <td align="center" height="20">Saldo Bs</td> 
            <td align="center" height="20">Forma de Pago<a onclick="repetirFormaPago()"><img src="images/repetir.jpg" border="0"></a></td>
            <td align="center" height="20">Banco<a onclick="repetirBanco()"><img src="images/repetir.jpg" border="0"></a></td>               
            <td align="center" height="20">Moneda<a onclick="repetirMoneda()"><img src="images/repetir.jpg" border="0"></td>
            <td align="center" height="20">Nro Cuenta<a onclick="repetirNroCuenta()"><img src="images/repetir.jpg" border="0"></a></td>
			<td align="center" height="20">Nro Cheque<a onclick="repetirNroCheque()"><img src="images/repetir.jpg" border="0"></a></td>            
            <td align="center" height="20">Monto Pago</td>
            <td align="center" height="20">Nro Comp<a onclick="repetirComp()"><img src="images/repetir.jpg" border="0"></a></td>
            <td align="center" height="20">Fecha Comp <a onclick="repetirFechaComp()"><img src="images/repetir.jpg" border="0"></a></td>
           </tr>
          
           
<?php 

	$sql=" select hr.cod_hoja_ruta, hr.nro_hoja_ruta, hr.cod_gestion, g.gestion,  hr.fecha_hoja_ruta, hr.cod_cotizacion ";
	$sql.=" from hojas_rutas hr, cotizaciones c, gestiones g";
	$sql.=" where hr.cod_cotizacion=c.cod_cotizacion";
	$sql.=" and hr.cod_gestion=g.cod_gestion";
	$sql.=" and c.cod_cliente=".$cod_cliente;
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
            <td align="left"><input type="checkbox" name="cod_hoja_ruta<?php echo $cod_hoja_ruta;?>" id="cod_hoja_ruta<?php echo $cod_hoja_ruta;?>" value="<?php echo $cod_hoja_ruta;?>" class="textoform" onclick="habilitarFilaHojaRuta(<?php echo $cod_hoja_ruta;?>)"></td>
            <td>HR</td> 
             <td align="left"><a href="../reportes/impresionHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta; ?>" target="_blank"> <?php echo $nro_hoja_ruta."/".$gestion; ?></a></td>  
             <td align="left">&nbsp;<?php echo strftime("%d.%m.%Y",strtotime($fecha_hoja_ruta)); ?></td> 
             
             <td align="right" >&nbsp;<?php echo $monto_hojaruta; ?>
			<input type="hidden"name="monto_hojaruta<?php echo $cod_hoja_ruta;?>"id="monto_hojaruta<?php echo $cod_hoja_ruta;?>" value="<?php echo $monto_hojaruta;?>"></td> 
             <td align="right">&nbsp;<?php 
			 	$sql2=" select pd.cod_moneda, pd.monto_pago_detalle, p.fecha_pago ";
			 	$sql2.=" from pagos_detalle pd, pagos p";
			 	$sql2.=" where pd.cod_pago=p.cod_pago";
			 	$sql2.=" and p.cod_estado_pago<>2";
			 	$sql2.=" and pd.codigo_doc=".$cod_hoja_ruta;
				$sql2.=" and pd.cod_tipo_doc=1";
				$resp2 = mysql_query($sql2);
				$acuenta_hojaruta=0;
				while($dat2=mysql_fetch_array($resp2)){
					$cod_moneda=$dat2['cod_moneda'];
					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					$fecha_pago=$dat2['fecha_pago'];
					$fecha_pago=strftime("%Y-%m-%d",strtotime($fecha_pago));
					if($cod_moneda==1){
						$acuenta_hojaruta=$acuenta_hojaruta+$monto_pago_detalle;
					}else{
							$sql3="select cambio_bs from tipo_cambio";
							$sql3.="where fecha_tipo_cambio='".$fecha_pago."'";
							$sql3.="and cod_moneda=".$cod_moneda;
							$resp3 = mysql_query($sql3);
							$cambio_bs=0;
							while($dat3=mysql_fetch_array($resp3)){
								$cambio_bs=$dat3['cambio_bs'];
							}
							if($cambio_bs<>0){
								$acuenta_hojaruta=$acuenta_hojaruta+($monto_pago_detalle*$cambio_bs);
							
							}
						
					}
				}				
			 echo $acuenta_hojaruta;
			 ?></td> 
             <td align="right"><?php echo ($monto_hojaruta-$acuenta_hojaruta);?>
             <input type="hidden" name="saldo_hojaruta<?php echo $cod_hoja_ruta;?>" id="saldo_hojaruta<?php echo $cod_hoja_ruta;?>" value="<?php echo ($monto_hojaruta-$acuenta_hojaruta);?>"></td>       
             <td align="left">
             <select name="cod_forma_pago_hr<?php echo $cod_hoja_ruta;?>" id="cod_forma_pago_hr<?php echo $cod_hoja_ruta;?>" class="textoform" disabled="disabled"  onchange="habilitarCampos(<?php echo $cod_hoja_ruta;?>)">
				<?php
					$sql2=" select cod_forma_pago, desc_forma_pago";
					$sql2.=" from   forma_pago ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_forma_pago=$dat2['cod_forma_pago'];	
			  		 		$desc_forma_pago=$dat2['desc_forma_pago'];	
				 ?>
               <option value="<?php echo $cod_forma_pago;?>"><?php echo utf8_decode($desc_forma_pago);?></option>				
				<?php		
					}
				?>						
			</select>
            </td>     
             <td align="left">
      <select name="cod_banco_hr<?php echo $cod_hoja_ruta;?>" id="cod_banco_hr<?php echo $cod_hoja_ruta;?>" class="textoform" disabled="disabled">
				<?php
					$sql2=" select cod_banco, desc_banco";
					$sql2.=" from   bancos ";
					$sql2.=" order by desc_banco asc ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_banco=$dat2['cod_banco'];	
			  		 		$desc_banco=$dat2['desc_banco'];	
				 ?>
                 <option value="<?php echo $cod_banco;?>"><?php echo utf8_decode($desc_banco);?></option>				
				<?php		
					}
				?>						
			</select>
            </td>   
<td align="left">
<select name="cod_moneda_hr<?php echo $cod_hoja_ruta;?>" id="cod_moneda_hr<?php echo $cod_hoja_ruta;?>" class="textoform" disabled="disabled">
				<?php
					$sql2=" select cod_moneda, desc_moneda, abrev_moneda";
					$sql2.=" from   monedas ";
					$sql2.=" order by desc_moneda asc ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_moneda=$dat2['cod_moneda'];	
			  		 		$desc_moneda=$dat2['desc_moneda'];
							$abrev_moneda=$dat2['abrev_moneda'];	
				 ?>
                 <option value="<?php echo $cod_moneda;?>"><?php echo utf8_decode($abrev_moneda);?></option>				
				<?php		
					}
				?>						
			</select>
            </td> 
			<td align="left">
				<input type="text" name="nro_cuenta_hr<?php echo $cod_hoja_ruta; ?>" id="nro_cuenta_hr<?php echo $cod_hoja_ruta; ?>" class="textoform" size="12" disabled="disabled">
            </td> 
			<td align="left">
				<input type="text" name="nro_cheque_hr<?php echo $cod_hoja_ruta; ?>" id="nro_cheque_hr<?php echo $cod_hoja_ruta; ?>" class="textoform" size="12" disabled="disabled">
            </td> 
			<td align="right">
			  <input type="text" name="monto_pago_hr<?php echo $cod_hoja_ruta; ?>" id="monto_pago_hr<?php echo $cod_hoja_ruta; ?>" value="<?php echo ($monto_hojaruta-$acuenta_hojaruta);?>" class="textoform" size="8" disabled="disabled">
            </td> 
			<td align="left">
				<input type="text" name="nro_comprobante_hr<?php echo $cod_hoja_ruta; ?>" id="nro_comprobante_hr<?php echo $cod_hoja_ruta; ?>" class="textoform" size="10" disabled="disabled">
            </td> 
			<td align="left">
			  <input type="text" name="fecha_comprobante_hr<?php echo $cod_hoja_ruta; ?>" id="fecha_comprobante_hr<?php echo $cod_hoja_ruta; ?>" value="<?php echo date("d/m/Y");?>" class="textoform" size="10" disabled="disabled">
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
            <td align="left"><input type="checkbox" name="cod_orden_trabajo<?php echo $cod_orden_trabajo;?>" id="cod_orden_trabajo<?php echo $cod_orden_trabajo;?>" value="<?php echo $cod_orden_trabajo;?>" class="textoform" onclick="habilitarFilaOrdenTrabajo(<?php echo $cod_orden_trabajo;?>)"></td>
            <td>OT</td> 
             <td align="left"><a href="" target="_blank"> <?php echo $nro_orden_trabajo."/".$gestion."(".$numero_orden_trabajo.")"; ?></a></td>  
             <td align="left">&nbsp;<?php echo strftime("%d.%m.%Y",strtotime($fecha_orden_trabajo)); ?></td> 
             
             <td align="right" >&nbsp;<?php echo $monto_orden_trabajo; ?>
			<input type="hidden"name="monto_ordentrabajo<?php echo $cod_orden_trabajo;?>"id="monto_ordentrabajo<?php echo $cod_orden_trabajo;?>" value="<?php echo $monto_orden_trabajo;?>"></td> 
             <td align="right">&nbsp;<?php 
			 	$sql2=" select pd.cod_moneda, pd.monto_pago_detalle, p.fecha_pago ";
			 	$sql2.=" from pagos_detalle pd, pagos p";
			 	$sql2.=" where pd.cod_pago=p.cod_pago";
			 	$sql2.=" and p.cod_estado_pago<>2";
			 	$sql2.=" and pd.codigo_doc=".$cod_orden_trabajo;
				$sql2.=" and pd.cod_tipo_doc=2";
				$resp2 = mysql_query($sql2);
				$acuenta_ordentrabajo=0;
				while($dat2=mysql_fetch_array($resp2)){
					$cod_moneda=$dat2['cod_moneda'];
					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					$fecha_pago=$dat2['fecha_pago'];
					$fecha_pago=strftime("%Y-%m-%d",strtotime($fecha_pago));
					if($cod_moneda==1){
						$acuenta_ordentrabajo=$acuenta_ordentrabajo+$monto_pago_detalle;
					}else{
							$sql3="select cambio_bs from tipo_cambio";
							$sql3.="where fecha_tipo_cambio='".$fecha_pago."'";
							$sql3.="and cod_moneda=".$cod_moneda;
							$resp3 = mysql_query($sql3);
							$cambio_bs=0;
							while($dat3=mysql_fetch_array($resp3)){
								$cambio_bs=$dat3['cambio_bs'];
							}
							if($cambio_bs<>0){
								$acuenta_ordentrabajo=$acuenta_ordentrabajo+($monto_pago_detalle*$cambio_bs);
							
							}
						
					}
				}				
				
			 echo $acuenta_ordentrabajo;
			 ?></td> 
             <td align="right"><?php echo ($monto_orden_trabajo-$acuenta_ordentrabajo);?>
             <input type="hidden" name="saldo_ordentrabajo<?php echo $cod_orden_trabajo;?>" id="saldo_ordentrabajo<?php echo $cod_orden_trabajo;?>" value="<?php echo ($monto_orden_trabajo-$acuenta_ordentrabajo);?>"></td>       
             <td align="left">
             <select name="cod_forma_pago_ot<?php echo $cod_orden_trabajo;?>" id="cod_forma_pago_ot<?php echo $cod_orden_trabajo;?>" class="textoform" disabled="disabled"  onchange="habilitarCamposOT(<?php echo $cod_orden_trabajo;?>)">
				<?php
					$sql2=" select cod_forma_pago, desc_forma_pago";
					$sql2.=" from   forma_pago ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_forma_pago=$dat2['cod_forma_pago'];	
			  		 		$desc_forma_pago=$dat2['desc_forma_pago'];	
				 ?>
               <option value="<?php echo $cod_forma_pago;?>"><?php echo utf8_decode($desc_forma_pago);?></option>				
				<?php		
					}
				?>						
			</select>
            </td>     
             <td align="left">
      <select name="cod_banco_ot<?php echo $cod_orden_trabajo;?>" id="cod_banco_ot<?php echo $cod_orden_trabajo;?>" class="textoform" disabled="disabled">
				<?php
					$sql2=" select cod_banco, desc_banco";
					$sql2.=" from   bancos ";
					$sql2.=" order by desc_banco asc ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_banco=$dat2['cod_banco'];	
			  		 		$desc_banco=$dat2['desc_banco'];	
				 ?>
                 <option value="<?php echo $cod_banco;?>"><?php echo utf8_decode($desc_banco);?></option>				
				<?php		
					}
				?>						
			</select>
            </td>   
<td align="left">
<select name="cod_moneda_ot<?php echo $cod_orden_trabajo;?>" id="cod_moneda_ot<?php echo $cod_orden_trabajo;?>" class="textoform" disabled="disabled">
				<?php
					$sql2=" select cod_moneda, desc_moneda, abrev_moneda";
					$sql2.=" from   monedas ";
					$sql2.=" order by desc_moneda asc ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_moneda=$dat2['cod_moneda'];	
			  		 		$desc_moneda=$dat2['desc_moneda'];
							$abrev_moneda=$dat2['abrev_moneda'];	
				 ?>
                 <option value="<?php echo $cod_moneda;?>"><?php echo utf8_decode($abrev_moneda);?></option>				
				<?php		
					}
				?>						
			</select>
            </td> 
			<td align="left">
				<input type="text" name="nro_cuenta_ot<?php echo $cod_orden_trabajo; ?>" id="nro_cuenta_ot<?php echo $cod_orden_trabajo; ?>" class="textoform" size="12" disabled="disabled">
            </td> 
			<td align="left">
				<input type="text" name="nro_cheque_ot<?php echo $cod_orden_trabajo; ?>" id="nro_cheque_ot<?php echo $cod_orden_trabajo; ?>" class="textoform" size="12" disabled="disabled">
            </td> 
			<td align="right">
			  <input type="text" name="monto_pago_ot<?php echo $cod_orden_trabajo; ?>" id="monto_pago_ot<?php echo $cod_orden_trabajo; ?>" value="<?php echo ($monto_orden_trabajo-$acuenta_ordentrabajo);?>" class="textoform" size="8" disabled="disabled">
            </td> 
			<td align="left">
				<input type="text" name="nro_comprobante_ot<?php echo $cod_orden_trabajo; ?>" id="nro_comprobante_ot<?php echo $cod_orden_trabajo; ?>" class="textoform" size="10" disabled="disabled">
            </td> 
			<td align="left">
			  <input type="text" name="fecha_comprobante_ot<?php echo $cod_orden_trabajo; ?>" id="fecha_comprobante_ot<?php echo $cod_orden_trabajo; ?>" value="<?php echo date("d/m/Y");?>" class="textoform" size="10" disabled="disabled">
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
            <td align="left"><input type="checkbox" name="cod_salida<?php echo $cod_salida;?>" id="cod_salida<?php echo $cod_salida;?>" value="<?php echo $cod_salida;?>" class="textoform" onclick="habilitarFilaVenta(<?php echo $cod_salida;?>)"></td>
            <td>VENTA</td> 
             <td align="left"><a href="../almacenes/detalleSalida.php?cod_salida=<?php echo $cod_salida; ?>" target="_blank"> <?php echo $nro_salida."/".$gestionVenta; ?></a></td>  
             <td align="left">&nbsp;<?php echo strftime("%d.%m.%Y",strtotime($fecha_salida)); ?></td> 
             
             <td align="right" >&nbsp;<?php echo $monto_venta; ?>
			<input type="hidden"name="monto_venta<?php echo $cod_salida;?>"id="monto_venta<?php echo $cod_salida;?>" value="<?php echo $monto_venta;?>"></td> 
             <td align="right">&nbsp;<?php 
			 	$sql2=" select pd.cod_moneda, pd.monto_pago_detalle, p.fecha_pago ";
			 	$sql2.=" from pagos_detalle pd, pagos p";
			 	$sql2.=" where pd.cod_pago=p.cod_pago";
			 	$sql2.=" and p.cod_estado_pago<>2";
			 	$sql2.=" and pd.codigo_doc=".$cod_salida;
				$sql2.=" and pd.cod_tipo_doc=3";
				$resp2 = mysql_query($sql2);
				$acuenta_venta=0;
				while($dat2=mysql_fetch_array($resp2)){
					$cod_moneda=$dat2['cod_moneda'];
					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					$fecha_pago=$dat2['fecha_pago'];
					$fecha_pago=strftime("%Y-%m-%d",strtotime($fecha_pago));
					if($cod_moneda==1){
						$acuenta_venta=$acuenta_venta+$monto_pago_detalle;
					}else{
							$sql3="select cambio_bs from tipo_cambio";
							$sql3.="where fecha_tipo_cambio='".$fecha_pago."'";
							$sql3.="and cod_moneda=".$cod_moneda;
							$resp3 = mysql_query($sql3);
							$cambio_bs=0;
							while($dat3=mysql_fetch_array($resp3)){
								$cambio_bs=$dat3['cambio_bs'];
							}
							if($cambio_bs<>0){
								$acuenta_venta=$acuenta_venta+($monto_pago_detalle*$cambio_bs);
							
							}
						
					}
				}				
			 echo $acuenta_venta;
			 ?></td> 
             <td align="right"><?php echo ($monto_venta-$acuenta_venta);?>
             <input type="hidden" name="saldo_venta<?php echo $cod_salida;?>" id="saldo_venta<?php echo $cod_salida;?>" value="<?php echo ($monto_venta-$acuenta_venta);?>"></td>       
             <td align="left">
             <select name="cod_forma_pago_venta<?php echo $cod_salida;?>" id="cod_forma_pago_venta<?php echo $cod_salida;?>" class="textoform" disabled="disabled"  onchange="habilitarCamposVenta(<?php echo $cod_salida;?>)">
				<?php
					$sql2=" select cod_forma_pago, desc_forma_pago";
					$sql2.=" from   forma_pago ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_forma_pago=$dat2['cod_forma_pago'];	
			  		 		$desc_forma_pago=$dat2['desc_forma_pago'];	
				 ?>
               <option value="<?php echo $cod_forma_pago;?>"><?php echo $desc_forma_pago;?></option>				
				<?php		
					}
				?>						
			</select>
            </td>     
             <td align="left">
      <select name="cod_banco_venta<?php echo $cod_salida;?>" id="cod_banco_venta<?php echo $cod_salida;?>" class="textoform" disabled="disabled">
				<?php
					$sql2=" select cod_banco, desc_banco";
					$sql2.=" from   bancos ";
					$sql2.=" order by desc_banco asc ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_banco=$dat2['cod_banco'];	
			  		 		$desc_banco=$dat2['desc_banco'];	
				 ?>
                 <option value="<?php echo $cod_banco;?>"><?php echo utf8_decode($desc_banco);?></option>				
				<?php		
					}
				?>						
			</select>
            </td>   
<td align="left">
<select name="cod_moneda_venta<?php echo $cod_salida;?>" id="cod_moneda_venta<?php echo $cod_salida;?>" class="textoform" disabled="disabled">
				<?php
					$sql2=" select cod_moneda, desc_moneda, abrev_moneda";
					$sql2.=" from   monedas ";
					$sql2.=" order by desc_moneda asc ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_moneda=$dat2['cod_moneda'];	
			  		 		$desc_moneda=$dat2['desc_moneda'];
							$abrev_moneda=$dat2['abrev_moneda'];	
				 ?>
                 <option value="<?php echo $cod_moneda;?>"><?php echo $abrev_moneda;?></option>				
				<?php		
					}
				?>						
			</select>
            </td> 
			<td align="left">
				<input type="text" name="nro_cuenta_venta<?php echo $cod_salida; ?>" id="nro_cuenta_venta<?php echo $cod_salida; ?>" class="textoform" size="12" disabled="disabled">
            </td> 
			<td align="left">
				<input type="text" name="nro_cheque_venta<?php echo $cod_salida; ?>" id="nro_cheque_venta<?php echo $cod_salida; ?>" class="textoform" size="12" disabled="disabled">
            </td> 
			<td align="right">
			  <input type="text" name="monto_pago_venta<?php echo $cod_salida; ?>" id="monto_pago_venta<?php echo $cod_salida; ?>" value="<?php echo ($monto_venta-$acuenta_venta);?>" class="textoform" size="8" disabled="disabled">
            </td> 
			<td align="left">
				<input type="text" name="nro_comprobante_venta<?php echo $cod_salida; ?>" id="nro_comprobante_venta<?php echo $cod_salida; ?>" class="textoform" size="10" disabled="disabled">
            </td> 
			<td align="left">
			  <input type="text" name="fecha_comprobante_venta<?php echo $cod_salida; ?>" id="fecha_comprobante_venta<?php echo $cod_salida; ?>" value="<?php echo date("d/m/Y");?>" class="textoform" size="10" disabled="disabled">
            </td>                                                                  
          </tr>          

<?php
	}
?>   

        
      
        </table>
        <div align="center">
        <INPUT type="button" class="boton" name="btn_guardar" value="Guardar Pago" onClick="guardar(this.form);"  >
        </div>
<?php
	}
?>            
</body>
</html>