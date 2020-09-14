<?php
require_once("conexion.inc");
include("funciones.php");

	$cod_cliente=$_POST['cod_cliente'];
	$sql="select max(cod_pago) from pagos ";
	$cod_pago=obtenerCodigo($sql);
	
	$cod_gestion=gestionActiva();
	
	$sql="select max(nro_pago) from pagos where cod_gestion='".$cod_gestion."'";
	$nro_pago=obtenerCodigo($sql);
	$cod_estado_pago=1;
	
	$sql="insert into pagos set ";
	$sql.=" cod_pago='".$cod_pago."',"; 
	$sql.=" cod_cliente='".$cod_cliente."',"; 
	$sql.=" nro_pago='".$nro_pago."',"; 
	$sql.=" cod_gestion='".$cod_gestion."',"; 
	$sql.=" fecha_pago='".date('Y-m-d', time())."',"; 
	$sql.=" cod_usuario_pago='".$_COOKIE['usuario_global']."',"; 
	$sql.=" obs_pago='".$_POST['obs_pago']."',"; 
	$sql.=" cod_estado_pago='".$cod_estado_pago."'"; 
	//echo $sql."<br>";
	mysql_query($sql);

////////////////////////////////DETALLE HOJAS RUTAS///////////////////////////////////
	$sql=" select hr.cod_hoja_ruta,hr. nro_hoja_ruta, hr.cod_gestion, g.gestion,  hr.fecha_hoja_ruta, hr.cod_cotizacion ";
	$sql.=" from hojas_rutas hr, cotizaciones c, gestiones g";
	$sql.=" where hr.cod_cotizacion=c.cod_cotizacion";
	$sql.=" and hr.cod_gestion=g.cod_gestion";
	$sql.=" and c.cod_cliente=".$cod_cliente;
	$sql.=" and hr.cod_estado_hoja_ruta<>2";
	$sql.=" and hr.cod_estado_pago_doc<>3";
	$sql.=" order by hr.fecha_hoja_ruta asc , nro_hoja_ruta asc  ";
	$resp= mysql_query($sql);
	$gestion="";
	while($dat=mysql_fetch_array($resp)){
		 $cod_hoja_ruta=$dat['cod_hoja_ruta'];
		 $nro_hoja_ruta=$dat['nro_hoja_ruta'];
		 $cod_gestion=$dat['cod_gestion'];
		 $gestion=$dat['gestion'];
		 $fecha_hoja_ruta=$dat['fecha_hoja_ruta'];
		 $cod_cotizacion=$dat['cod_cotizacion'];
		 
		 if($_POST['cod_hoja_ruta'.$cod_hoja_ruta]){
			 
			 $saldo_hojaruta=$_POST['saldo_hojaruta'.$cod_hoja_ruta];
			 $cod_forma_pago=$_POST['cod_forma_pago_hr'.$cod_hoja_ruta];
			 $cod_banco=$_POST['cod_banco_hr'.$cod_hoja_ruta];
			 $cod_moneda=$_POST['cod_moneda_hr'.$cod_hoja_ruta];
			 $nro_cuenta=$_POST['nro_cuenta_hr'.$cod_hoja_ruta];
			 $nro_cheque=$_POST['nro_cheque_hr'.$cod_hoja_ruta];
			 $monto_pago_detalle=$_POST['monto_pago_hr'.$cod_hoja_ruta];	
			 $nro_comprobante=$_POST['nro_comprobante_hr'.$cod_hoja_ruta];	
			 $fecha_comprobante=$_POST['fecha_comprobante_hr'.$cod_hoja_ruta];			 
			 
			 	$sql2=" select max(cod_pago_detalle) from pagos_detalle ";
				$cod_pago_detalle=obtenerCodigo($sql2);
			 
			 $sql2=" insert into  pagos_detalle set ";
			 $sql2.=" cod_pago_detalle='".$cod_pago_detalle."',";
			 $sql2.=" cod_pago='".$cod_pago."',";
			 $sql2.=" codigo_doc='".$cod_hoja_ruta."',";
			 $sql2.=" cod_tipo_doc=1,";			 
			 $sql2.=" cod_forma_pago='".$cod_forma_pago."',";
			 if($cod_forma_pago<>1){
				 $sql2.=" cod_banco='".$cod_banco."',";
			 }
			 $sql2.=" cod_moneda='".$cod_moneda."',";
			 if($cod_forma_pago==2){
				 $sql2.=" nro_cheque='".$nro_cheque."',";
			 }
			 if($cod_forma_pago==3){
				 $sql2.=" nro_cuenta='".$nro_cuenta."',";
			 }
			 $sql2.=" monto_pago_detalle='".$monto_pago_detalle."',";
			 $sql2.=" nro_comprobante='".$nro_comprobante."',";
			 list($dI,$mI,$aI)=explode("/",$fecha_comprobante);
			 $sql2.=" fecha_comprobante='".$aI."-".$mI."-".$dI."'";
			 

			 mysql_query($sql2);
			 
			 /////////////////////ACTUALIZAR ESTADO DE PAGO DE HOJAS DE RUTAS////////////
			 
					$monto_pago_detalle_bs=0;
					if($cod_moneda==1){
						$monto_pago_detalle_bs=$monto_pago_detalle;
					}else{
							$sql3="select cambio_bs from tipo_cambio";
							$sql3.=" where fecha_tipo_cambio='".date('Y-m-d', time())."'";
							$sql3.=" and cod_moneda=".$cod_moneda;
							$resp3=mysql_query($sql3);
							$cambio_bs=0;
							while($dat3=mysql_fetch_array($resp3)){
								$cambio_bs=$dat3['cambio_bs'];
							}
							if($cambio_bs<>0){
								$monto_pago_detalle_bs=($monto_pago_detalle*$cambio_bs);
							
							}						
					}	
					
					$saldo_actual=$saldo_hojaruta-$monto_pago_detalle_bs;
					if($saldo_actual<=0){
						$sql4=" update hojas_rutas set ";
						$sql4.=" cod_estado_pago_doc=3";
						$sql4.=" where cod_hoja_ruta=".$cod_hoja_ruta;
						mysql_query($sql4);
					}else{
						$sql4=" update hojas_rutas set ";
						$sql4.=" cod_estado_pago_doc=2";
						$sql4.=" where cod_hoja_ruta=".$cod_hoja_ruta;		
						mysql_query($sql4);				
					}
					
			///////////////////// FIN ACTUALIZAR ESTADO DE PAGO DE HOJAS DE RUTAS////////////

		 }
		 
	}

////////////////////////////////FIN DETALLE HOJAS RUTAS///////////////////////////////////

////////////////////////////////DETALLE ORDENES DE TRABAJO///////////////////////////////////
	$sql=" select ot.cod_orden_trabajo, ot.nro_orden_trabajo, g.gestion ,ot.cod_gestion, ot.numero_orden_trabajo, ";
	$sql.=" ot.fecha_orden_trabajo, ot.monto_orden_trabajo ";
	$sql.=" from ordentrabajo ot, gestiones g ";
	$sql.=" where ot.cod_est_ot<>2  ";
	$sql.=" and ot.cod_estado_pago_doc<>3 ";
	$sql.=" and ot.cod_gestion=g.cod_gestion "; 
	$sql.=" and ot.cod_cliente=".$cod_cliente;
	$sql.=" order by ot.fecha_orden_trabajo desc, ot.nro_orden_trabajo desc ";
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
		 
		 if($_POST['cod_orden_trabajo'.$cod_orden_trabajo]){
			 
			 $saldo_ordentrabajo=$_POST['saldo_ordentrabajo'.$cod_orden_trabajo];
			 $cod_forma_pago=$_POST['cod_forma_pago_ot'.$cod_orden_trabajo];
			 $cod_banco=$_POST['cod_banco_ot'.$cod_orden_trabajo];
			 $cod_moneda=$_POST['cod_moneda_ot'.$cod_orden_trabajo];
			 $nro_cuenta=$_POST['nro_cuenta_ot'.$cod_orden_trabajo];
			 $nro_cheque=$_POST['nro_cheque_ot'.$cod_orden_trabajo];
			 $monto_pago_detalle=$_POST['monto_pago_ot'.$cod_orden_trabajo];	
			 $nro_comprobante=$_POST['nro_comprobante_ot'.$cod_orden_trabajo];	
			 $fecha_comprobante=$_POST['fecha_comprobante_ot'.$cod_orden_trabajo];			 
			 
			 	$sql2=" select max(cod_pago_detalle) from pagos_detalle ";
				$cod_pago_detalle=obtenerCodigo($sql2);
			 
			 $sql2=" insert into  pagos_detalle set ";
			 $sql2.=" cod_pago_detalle='".$cod_pago_detalle."',";
			 $sql2.=" cod_pago='".$cod_pago."',";
			 $sql2.=" codigo_doc='".$cod_orden_trabajo."',";
			 $sql2.=" cod_tipo_doc=2,";			 
			 $sql2.=" cod_forma_pago='".$cod_forma_pago."',";
			 if($cod_forma_pago<>1){
				 $sql2.=" cod_banco='".$cod_banco."',";
			 }
			 $sql2.=" cod_moneda='".$cod_moneda."',";
			 if($cod_forma_pago==2){
				 $sql2.=" nro_cheque='".$nro_cheque."',";
			 }
			 if($cod_forma_pago==3){
				 $sql2.=" nro_cuenta='".$nro_cuenta."',";
			 }
			 $sql2.=" monto_pago_detalle='".$monto_pago_detalle."',";
			 $sql2.=" nro_comprobante='".$nro_comprobante."',";
			 list($dI,$mI,$aI)=explode("/",$fecha_comprobante);
			 $sql2.=" fecha_comprobante='".$aI."-".$mI."-".$dI."'";
			 

			 mysql_query($sql2);
			 
			 /////////////////////ACTUALIZAR ESTADO DE PAGO DE ORDENES DE TRABAJO////////////
			 
					$monto_pago_detalle_bs=0;
					if($cod_moneda==1){
						$monto_pago_detalle_bs=$monto_pago_detalle;
					}else{
							$sql3="select cambio_bs from tipo_cambio";
							$sql3.=" where fecha_tipo_cambio='".date('Y-m-d', time())."'";
							$sql3.=" and cod_moneda=".$cod_moneda;
							$resp3=mysql_query($sql3);
							$cambio_bs=0;
							while($dat3=mysql_fetch_array($resp3)){
								$cambio_bs=$dat3['cambio_bs'];
							}
							if($cambio_bs<>0){
								$monto_pago_detalle_bs=($monto_pago_detalle*$cambio_bs);
							
							}						
					}	
					
					$saldo_actual=$saldo_ordentrabajo-$monto_pago_detalle_bs;
					if($saldo_actual<=0){
						$sql4=" update ordentrabajo set ";
						$sql4.=" cod_estado_pago_doc=3";
						$sql4.=" where cod_orden_trabajo=".$cod_orden_trabajo;
						mysql_query($sql4);
					}else{
						$sql4=" update ordentrabajo set ";
						$sql4.=" cod_estado_pago_doc=2";
						$sql4.=" where cod_orden_trabajo=".$cod_orden_trabajo;		
						mysql_query($sql4);				
					}
					
			///////////////////// FIN ACTUALIZAR ESTADO DE PAGO DE ORDENES DE TRABAJO////////////

		 }
		 
	}

////////////////////////////////FIN DETALLE ORDENES DE TRABAJO///////////////////////////////////

////////////////////////////////DETALLE SALIDAS POR VENTA///////////////////////////////////
	$sql=" select s.cod_salida, s.nro_salida, s.cod_gestion, g.gestion, s.cliente_venta, s.fecha_salida ";
	$sql.=" from salidas s, gestiones g ";
	$sql.=" where s.cod_gestion=g.cod_gestion ";
	$sql.=" and s.cod_tipo_salida=1 ";
	$sql.=" and s.cod_estado_salida=1 ";
	$sql.=" and s.cod_estado_pago_doc<>3 ";
	$sql.=" and s.cod_cliente_venta=".$_POST['cod_cliente'];
	$sql.=" order by fecha_salida asc,s.nro_salida asc ";
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		
		  $cod_salida=$dat['cod_salida'];
		  $nro_salida=$dat['nro_salida'];
		  $cod_gestion=$dat['cod_gestion'];
		  $gestionVenta=$dat['gestion'];
		  $cliente_venta=$dat['cliente_venta'];
		  $fecha_salida=$dat['fecha_salida'];
		

		 
		 if($_POST['cod_salida'.$cod_salida]){
			 
			 $saldo_venta=$_POST['saldo_venta'.$cod_salida];
			 $cod_forma_pago=$_POST['cod_forma_pago_venta'.$cod_salida];
			 $cod_banco=$_POST['cod_banco_venta'.$cod_salida];
			 $cod_moneda=$_POST['cod_moneda_venta'.$cod_salida];
			 $nro_cuenta=$_POST['nro_cuenta_venta'.$cod_salida];
			 $nro_cheque=$_POST['nro_cheque_venta'.$cod_salida];
			 $monto_pago_detalle=$_POST['monto_pago_venta'.$cod_salida];	
			 $nro_comprobante=$_POST['nro_comprobante_venta'.$cod_salida];	
			 $fecha_comprobante=$_POST['fecha_comprobante_venta'.$cod_salida];			 
			 
			 	$sql2=" select max(cod_pago_detalle) from pagos_detalle ";
				$cod_pago_detalle=obtenerCodigo($sql2);
			 
			 $sql2=" insert into  pagos_detalle set ";
			 $sql2.=" cod_pago_detalle='".$cod_pago_detalle."',";
			 $sql2.=" cod_pago='".$cod_pago."',";
			 $sql2.=" codigo_doc='".$cod_salida."',";
			 $sql2.=" cod_tipo_doc=3,";			 
			 $sql2.=" cod_forma_pago='".$cod_forma_pago."',";
			 if($cod_forma_pago<>1){
				 $sql2.=" cod_banco='".$cod_banco."',";
			 }
			 $sql2.=" cod_moneda='".$cod_moneda."',";
			 if($cod_forma_pago==2){
				 $sql2.=" nro_cheque='".$nro_cheque."',";
			 }
			 if($cod_forma_pago==3){
				 $sql2.=" nro_cuenta='".$nro_cuenta."',";
			 }
			 $sql2.=" monto_pago_detalle='".$monto_pago_detalle."',";
			 $sql2.=" nro_comprobante='".$nro_comprobante."',";
			 list($dI,$mI,$aI)=explode("/",$fecha_comprobante);
			 $sql2.=" fecha_comprobante='".$aI."-".$mI."-".$dI."'";			 

			 mysql_query($sql2);
			 
			 /////////////////////ACTUALIZAR ESTADO DE PAGO DE SALIDA////////////
			 
					$monto_pago_detalle_bs=0;
					if($cod_moneda==1){
						$monto_pago_detalle_bs=$monto_pago_detalle;
					}else{
							$sql3="select cambio_bs from tipo_cambio";
							$sql3.=" where fecha_tipo_cambio='".date('Y-m-d', time())."'";
							$sql3.=" and cod_moneda=".$cod_moneda;
							$resp3=mysql_query($sql3);
							$cambio_bs=0;
							while($dat3=mysql_fetch_array($resp3)){
								$cambio_bs=$dat3['cambio_bs'];
							}
							if($cambio_bs<>0){
								$monto_pago_detalle_bs=($monto_pago_detalle*$cambio_bs);
							
							}						
					}	
					
					$saldo_actual=$saldo_venta-$monto_pago_detalle_bs;
					if($saldo_actual<=0){
						$sql4=" update salidas set ";
						$sql4.=" cod_estado_pago_doc=3";
						$sql4.=" where cod_salida=".$cod_salida;
						mysql_query($sql4);
					}else{
						$sql4=" update salidas set ";
						$sql4.=" cod_estado_pago_doc=2";
						$sql4.=" where cod_salida=".$cod_salida;		
						mysql_query($sql4);				
					}
					
			///////////////////// FIN ACTUALIZAR ESTADO DE PAGO DE SALIDAS POR VENTA////////////

		 }
		 
	}

////////////////////////////////FIN DETALLE SALIDAS POR VENTA///////////////////////////////////


require("cerrar_conexion.inc");
?>

<script language="JavaScript">
location.href="viewPago.php?cod_pago=<?php echo $cod_pago;?>";
</script>
