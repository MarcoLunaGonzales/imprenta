<?php
require_once("conexion.inc");
include("funciones.php");

	$cod_cliente=$_POST['cod_cliente'];
	$sql="select max(cod_pago) from pagos ";
	$cod_pago=obtenerCodigo($sql);
	$vectorFechaPago = explode("/", $_POST['fecha_pago']);
	$fechaPago = $vectorFechaPago[2] . "-" . $vectorFechaPago[1] . "-" . $vectorFechaPago[0];
	
	$cod_gestion=gestionActiva();
	
	$sql="select max(nro_pago) from pagos where cod_gestion='".$cod_gestion."'";
	$nro_pago=obtenerCodigo($sql);
	$cod_estado_pago=1;
	
	$sql="insert into pagos set ";
	$sql.=" cod_pago='".$cod_pago."',"; 
	$sql.=" cod_cliente='".$_POST['cod_cliente']."',"; 
	$sql.=" nro_pago='".$nro_pago."',"; 
	$sql.=" cod_gestion='".$cod_gestion."',"; 
	$sql.=" fecha_pago='".$fechaPago."',"; 
	$sql.=" cod_usuario_pago='".$_COOKIE['usuario_global']."',"; 
	$sql.=" obs_pago='".$_POST['obs_pago']."',"; 
	$sql.=" cod_estado_pago='".$cod_estado_pago."',";
	$sql.=" total_bs='".$_POST['total_bs']."',"; 
	$sql.=" fecha_registro='".date('Y-m-d', time())."',"; 
	$sql.=" cod_usuario_registro='".$_COOKIE['usuario_global']."'"; 
//	echo $sql."<br/>";
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
			 $monto_pago_detalle=$_POST['monto_pago_hr'.$cod_hoja_ruta];	
 
			 
			 	$sql2=" select max(cod_pago_detalle) from pagos_detalle ";
				$cod_pago_detalle=obtenerCodigo($sql2);
			 
			 $sql2=" insert into  pagos_detalle set ";
			 $sql2.=" cod_pago_detalle='".$cod_pago_detalle."',";
			 $sql2.=" cod_pago='".$cod_pago."',";
			 $sql2.=" codigo_doc='".$cod_hoja_ruta."',";
			 $sql2.=" cod_tipo_doc=1,";			 
			 $sql2.=" monto_pago_detalle='".$monto_pago_detalle."'";
	 

			 mysql_query($sql2);
			 
			 /////////////////////ACTUALIZAR ESTADO DE PAGO DE HOJAS DE RUTAS////////////
			 
					$monto_pago_detalle_bs=0;
						$monto_pago_detalle_bs=$monto_pago_detalle;

					
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
			 $monto_pago_detalle=$_POST['monto_pago_ot'.$cod_orden_trabajo];		 
			 
			 	$sql2=" select max(cod_pago_detalle) from pagos_detalle ";
				$cod_pago_detalle=obtenerCodigo($sql2);
			 
			 $sql2=" insert into  pagos_detalle set ";
			 $sql2.=" cod_pago_detalle='".$cod_pago_detalle."',";
			 $sql2.=" cod_pago='".$cod_pago."',";
			 $sql2.=" codigo_doc='".$cod_orden_trabajo."',";
			 $sql2.=" cod_tipo_doc=2,";			 			 
			 $sql2.=" monto_pago_detalle='".$monto_pago_detalle."'";

			 

			 mysql_query($sql2);
			 
			 /////////////////////ACTUALIZAR ESTADO DE PAGO DE ORDENES DE TRABAJO////////////
			 
					$monto_pago_detalle_bs=0;

						$monto_pago_detalle_bs=$monto_pago_detalle;

					
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
			 $monto_pago_detalle=$_POST['monto_pago_venta'.$cod_salida];			 
			 
			 	$sql2=" select max(cod_pago_detalle) from pagos_detalle ";
				$cod_pago_detalle=obtenerCodigo($sql2);
			 
			 $sql2=" insert into  pagos_detalle set ";
			 $sql2.=" cod_pago_detalle='".$cod_pago_detalle."',";
			 $sql2.=" cod_pago='".$cod_pago."',";
			 $sql2.=" codigo_doc='".$cod_salida."',";
			 $sql2.=" cod_tipo_doc=3,";			 			
			 $sql2.=" monto_pago_detalle='".$monto_pago_detalle."'";
	 

			 mysql_query($sql2);
			 
			 /////////////////////ACTUALIZAR ESTADO DE PAGO DE SALIDA////////////
			 
					$monto_pago_detalle_bs=0;
					$monto_pago_detalle_bs=$monto_pago_detalle;

					
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

$sql3="select cambio_bs from tipo_cambio";
$sql3.=" where fecha_tipo_cambio='".date('Y-m-d', time())."'";
$sql3.=" and cod_moneda=2";
$resp3 = mysql_query($sql3);
$cambio_bs=0;
while($dat3=mysql_fetch_array($resp3)){
	$cambio_bs=$dat3['cambio_bs'];
}

$num=$_POST['num'];

for($i = 1;$i <=$num ;$i++) {	
	if($_POST["cod_forma_pago".$i]){
		$sql2="	insert into pagos_descripcion set ";
		$sql2.=" cod_pago=".$cod_pago. ",";
		$sql2.=" cod_forma_pago=".$_POST["cod_forma_pago".$i]. ",";
		$sql2.=" cod_moneda=".$_POST["cod_moneda".$i]. ","; 
		
		if($_POST["cod_banco".$i]){
			$sql2.=" cod_banco=".$_POST["cod_banco".$i]. ","; 
		}
				if($_POST["nro_cheque".$i]){
			$sql2.=" nro_cheque=".$_POST["nro_cheque".$i]. ","; 
		}
		if($_POST["cuenta".$i]){
			$sql2.=" nro_cuenta=".$_POST["cuenta".$i]. ","; 
			$sql2.=" cod_cuenta=".$_POST["cod_cuenta".$i]. ","; 
		}		
		if($_POST["cod_cuenta".$i]){
			$sql2.=" cod_cuenta=".$_POST["cod_cuenta".$i]. ","; 
		}	
		$sql2.=" monto_pago=".$_POST["monto_pago_detalle".$i]. ""; 

		echo $sql2;
		mysql_query($sql2);	

	}
}
							

/// CREACION DE COMPROBANTE/////


// Obtiene Nro de Cuentas
	$sql="select cod_cuenta from clientes where cod_cliente=".$_POST['cod_cliente'];
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$cod_cuenta_haber=$dat['cod_cuenta'];
	}

	$sql="select nombre_cliente from clientes where cod_cliente=".$_POST['cod_cliente'];
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$nombre_cliente=$dat['nombre_cliente'];
	}
// Fin Obtiene Nro de Cuentas

	
// Obtiene Glosa par comprobante	
	$sql=" select cod_tipo_doc,codigo_doc, monto_pago_detalle ";
	$sql.=" from pagos_detalle ";
	$sql.=" where cod_pago=".$cod_pago;
	$sql.=" order by cod_tipo_doc,codigo_doc";
	$resp= mysql_query($sql);
	$glosa="";
	while($dat=mysql_fetch_array($resp)){
		$cod_tipo_doc=$dat['cod_tipo_doc'];
		$codigo_doc=$dat['codigo_doc'];
		$monto_pago_detalle=$dat['monto_pago_detalle']; 
		$sql2="select abrev_tipo_doc from tipo_documento where cod_tipo_doc=".$cod_tipo_doc;
		$resp2= mysql_query($sql2);
		$abrev_tipo_doc="";
		while($dat2=mysql_fetch_array($resp2)){
			$abrev_tipo_doc=$dat2['abrev_tipo_doc'];
		}
		$nro_documento="";
		if($cod_tipo_doc==1){	
				$sql2=" select hr.nro_hoja_ruta,g.gestion from hojas_rutas hr, gestiones g ";
				$sql2.=" where hr.cod_gestion=g.cod_gestion and hr.cod_hoja_ruta=".$codigo_doc;
				$resp2= mysql_query($sql2);
				$nro_documento="";
				while($dat2=mysql_fetch_array($resp2)){
					$nro_documento=$dat2['nro_hoja_ruta']."/".$dat2['gestion'];
				}	
		}
		if($cod_tipo_doc==2){
				$sql2=" select ot.nro_orden_trabajo,g.gestion from ordentrabajo ot, gestiones g ";
				$sql2.=" where ot.cod_gestion=g.cod_gestion and ot.cod_orden_trabajo=".$codigo_doc;
				$resp2= mysql_query($sql2);
				$nro_documento="";
				while($dat2=mysql_fetch_array($resp2)){
					$nro_documento=$dat2['nro_orden_trabajo']."/".$dat2['gestion'];
				}	
		}
		if($cod_tipo_doc==3){
				$sql2=" select sal.nro_salida,g.gestion from salidas sal, gestiones g ";
				$sql2.=" where sal.cod_gestion=g.cod_gestion and sal.cod_salida=".$codigo_doc;
				//echo $sql2;
				$resp2= mysql_query($sql2);
				$nro_documento="";
				while($dat2=mysql_fetch_array($resp2)){
					$nro_documento=$dat2['nro_salida']."/".$dat2['gestion'];
				}	
		}	
		$glosa=$glosa."Pago de ".$abrev_tipo_doc." ".$nro_documento." ".$monto_pago_detalle." Bs ;";	
				
	}
// FinObtiene Glosa par comprobante		
// COMPROBANTES CASO TRASPASO
	$sqlAux=" select count(*) from  pagos_descripcion ";
	$sqlAux.=" where cod_forma_pago in(select cod_forma_pago from forma_pago where codcuenta='SI') and cod_pago=".$cod_pago;
	$respAux= mysql_query($sqlAux);
	while($datAux=mysql_fetch_array($respAux)){
		$nro_codcuenta=$datAux[0];
	}

if($nro_codcuenta>0){

	$sqlAux=" select cod_forma_pago, cod_moneda, monto_pago, cod_banco, nro_cheque, nro_cuenta, cod_cuenta  from  pagos_descripcion ";
	$sqlAux.=" where cod_forma_pago in(select cod_forma_pago from forma_pago where codcuenta='SI') and cod_pago=".$cod_pago;
	$respAux= mysql_query($sqlAux);
	while($datAux=mysql_fetch_array($respAux)){
		$cod_forma_pago=$datAux['cod_forma_pago'];
		$cod_moneda=$datAux['cod_moneda'];
		$monto_pago=$datAux['monto_pago'];
		$cod_banco=$datAux['cod_banco'];
		$nro_cheque=$datAux['nro_cheque'];
		$nro_cuenta=$datAux['nro_cuenta'];
		$cod_cuenta_haber=$datAux['cod_cuenta'];
		$sqlAux2=" select desc_banco from bancos where cod_banco=".$cod_banco;
		$respAux2= mysql_query($sqlAux2);
		$desc_banco="";
		while($datAux2=mysql_fetch_array($respAux2)){
			$desc_banco=$datAux2['desc_banco'];
		}
		
		// Comprobante de Traspaso
			//echo "glosa=".$glosa;
			$cod_gestion=gestionActiva();
			$sql="select max(cod_cbte) from comprobante ";
			$cod_cbte=obtenerCodigo($sql);
			$sql="select max(nro_cbte) from comprobante where cod_gestion='".$cod_gestion."' and cod_tipo_cbte=4 ";
			$nro_cbte=obtenerCodigo($sql);
			$sql=" insert into comprobante  set ";
			$sql.=" cod_cbte=".$cod_cbte.",";
			$sql.=" cod_empresa=1,"; 
			$sql.=" cod_gestion=".$cod_gestion.",";
			$sql.=" cod_tipo_cbte=4,";
			$sql.=" nro_cbte=".$nro_cbte.",";
			$sql.=" cod_moneda=".$cod_moneda.",";
			$sql.=" cod_estado_cbte=1,";
			$sql.=" fecha_cbte='".date('Y-m-d', time())."',";
			$sql.=" nro_cheque='".$nro_cheque."',"; 
			//$sql.=" nro_factura, 
			$sql.=" banco='".$desc_banco."',";
			$sql.=" glosa='".$glosa."',";
			$sql.=" nombre='".$nombre_cliente."',";
			$sql.=" cod_usuario_registro=".$_COOKIE['usuario_global'].",";
			$sql.=" fecha_registro='".date('Y-m-d H:i:s', time())."'";
			echo $sql."<br/>";
			mysql_query($sql);
			$sql="update pagos set cod_cbte=".$cod_cbte." where cod_pago=".$cod_pago;
			mysql_query($sql);
			$sql2="select cod_cuenta from configuracion_tipo_cbte where cod_moneda=".$cod_moneda." and cod_tipo_cbte=4";
			$resp2= mysql_query($sql2);
			while($dat2=mysql_fetch_array($resp2)){
				$cod_cuenta_debe=$dat2['cod_cuenta'];
			}
			
			if($cod_moneda==1){
				$montoTotalPagoMoneda=$monto_pago;
				$montoTotalPagoMonedaSus=$monto_pago/$cambio_bs;
			}
			if($cod_moneda==2){
				$montoTotalPagoMonedaSus=$monto_pago;
				$montoTotalPagoMoneda=$monto_pago*$cambio_bs;
				
				
			}
			
			//echo "moneda bs=".$montoTotalPagoMoneda;
			//echo "moneda sus=".$montoTotalPagoMonedaSus;
			$sql="select max(cod_cbte_detalle) from comprobante_detalle where cod_cbte='".$cod_cbte."'";
			$cod_cbte_detalle=obtenerCodigo($sql);			
			$sql3=" insert into comprobante_detalle set ";
			$sql3.=" cod_cbte=".$cod_cbte.",";
			$sql3.=" cod_cbte_detalle=".$cod_cbte_detalle.",";
			$sql3.=" cod_cuenta=".$cod_cuenta_debe.",";
			$sql3.=" debe=".$montoTotalPagoMoneda.",";
			$sql3.=" haber=0,";
			$sql3.=" haber_sus=".$montoTotalPagoMonedaSus.",";
			$sql3.=" debe_sus=0,";					 
			$sql3.=" glosa='".$glosa."'";
			echo $sql3."<br/>";
			mysql_query($sql3);
			$sql="select max(cod_cbte_detalle) from comprobante_detalle where cod_cbte='".$cod_cbte."'";
			$cod_cbte_detalle=obtenerCodigo($sql);
			$sql3=" insert into comprobante_detalle set ";
			$sql3.=" cod_cbte=".$cod_cbte.",";
			$sql3.=" cod_cbte_detalle=".$cod_cbte_detalle.",";
			$sql3.=" cod_cuenta=".$cod_cuenta_haber.","; 
			$sql3.=" debe=0,";
			$sql3.=" haber=".$montoTotalPagoMoneda.",";	
			$sql3.=" haber_sus=0,";
			$sql3.=" debe_sus=".$montoTotalPagoMonedaSus.",";					 
			$sql3.=" glosa='".$glosa."'";
			mysql_query($sql3);		
			echo $sql3."<br/>";		
	}
}
// FIN CASO TRASPASO
// COMPROBBANTE CASO NORMAL - COMPROBANTE DE INGRESO

	$sqlAux=" select count(*) from  pagos_descripcion ";
	$sqlAux.=" where cod_forma_pago in(select cod_forma_pago from forma_pago where codcuenta<>'SI') and cod_pago=".$cod_pago;
	$respAux= mysql_query($sqlAux);
	$nro_codcuentaNormal=0;
	while($datAux=mysql_fetch_array($respAux)){
		$nro_codcuentaNormal=$datAux[0];
	}
	if($nro_codcuentaNormal>0){

			
			$cod_gestion=gestionActiva();
			$sql="select max(cod_cbte) from comprobante ";
			$cod_cbte=obtenerCodigo($sql);
			$sql="select max(nro_cbte) from comprobante where cod_gestion='".$cod_gestion."' and cod_tipo_cbte=3 ";
			$nro_cbte=obtenerCodigo($sql);
			//////////////////////////////////////
			$sql=" insert into comprobante  set ";
			$sql.=" cod_cbte=".$cod_cbte.",";
			$sql.=" cod_empresa=1,"; 
			$sql.=" cod_gestion=".$cod_gestion.",";
			$sql.=" cod_tipo_cbte=3,";
			$sql.=" nro_cbte=".$nro_cbte.",";
			$sql.=" cod_moneda=1,";
			$sql.=" cod_estado_cbte=1,";
			$sql.=" fecha_cbte='".date('Y-m-d', time())."',";
		//	$sql.=" nro_cheque='".$nro_cheque."',"; 
			//$sql.=" nro_factura, 
			//$sql.=" banco='".$desc_banco."',";
			$sql.=" glosa='".$glosa."',";
			$sql.=" nombre='".$nombre_cliente."',";
			$sql.=" cod_usuario_registro=".$_COOKIE['usuario_global'].",";
			$sql.=" fecha_registro='".date('Y-m-d H:i:s', time())."'";
			echo $sql."<br/>";
			mysql_query($sql);

	
			$sql="update pagos set cod_cbte=".$cod_cbte." where cod_pago=".$cod_pago;
			mysql_query($sql);
			
			
			$sql="select cod_cuenta from clientes where cod_cliente=".$_POST['cod_cliente'];
			echo $sql."<br/>";
			$resp= mysql_query($sql);
			while($dat=mysql_fetch_array($resp)){
				$cod_cuenta_haber=$dat['cod_cuenta'];					
			}	
			$sqlAux=" select cod_forma_pago, cod_moneda, monto_pago, cod_banco, nro_cheque, nro_cuenta, cod_cuenta  from  pagos_descripcion ";
			$sqlAux.=" where cod_forma_pago in(select cod_forma_pago from forma_pago where codcuenta<>'SI') and cod_pago=".$cod_pago;
			$respAux= mysql_query($sqlAux);
			while($datAux=mysql_fetch_array($respAux)){
				$cod_forma_pago=$datAux['cod_forma_pago'];
				$cod_moneda=$datAux['cod_moneda'];
				$monto_pago=$datAux['monto_pago'];
				$cod_banco=$datAux['cod_banco'];
				$nro_cheque=$datAux['nro_cheque'];
				$nro_cuenta=$datAux['nro_cuenta'];

				
				$sqlAux2=" select desc_banco from bancos where cod_banco=".$cod_banco;
				$respAux2= mysql_query($sqlAux2);
				$desc_banco="";
				while($datAux2=mysql_fetch_array($respAux2)){
					$desc_banco=$datAux2['desc_banco'];
				}
				
				$sql2="select cod_cuenta from configuracion_tipo_cbte where cod_moneda=".$cod_moneda." and cod_tipo_cbte=3";
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$cod_cuenta_debe=$dat2['cod_cuenta'];
				}
			
				if($cod_moneda==1){
					$montoTotalPagoMoneda=$monto_pago;
					$montoTotalPagoMonedaSus=$monto_pago/$cambio_bs;
				}
						
				if($cod_moneda==2){
					$montoTotalPagoMonedaSus=$monto_pago;
					$montoTotalPagoMoneda=$monto_pago*$cambio_bs;
				}
				$sql="select max(cod_cbte_detalle) from comprobante_detalle where cod_cbte='".$cod_cbte."'";
				$cod_cbte_detalle=obtenerCodigo($sql);			
				$sql3=" insert into comprobante_detalle set ";
				$sql3.=" cod_cbte=".$cod_cbte.",";
				$sql3.=" cod_cbte_detalle=".$cod_cbte_detalle.",";
				$sql3.=" cod_cuenta=".$cod_cuenta_debe.",";
				$sql3.=" debe=".$montoTotalPagoMoneda.",";
				$sql3.=" haber=0,";
				$sql3.=" haber_sus=".$montoTotalPagoMonedaSus.",";
				$sql3.=" debe_sus=0,";					 
				$sql3.=" glosa='".$glosa."'";
				echo $sql3."<br/>";
				mysql_query($sql3);
				$sql="select max(cod_cbte_detalle) from comprobante_detalle where cod_cbte='".$cod_cbte."'";
				$cod_cbte_detalle=obtenerCodigo($sql);
				$sql3=" insert into comprobante_detalle set ";
				$sql3.=" cod_cbte=".$cod_cbte.",";
				$sql3.=" cod_cbte_detalle=".$cod_cbte_detalle.",";
				$sql3.=" cod_cuenta=".$cod_cuenta_haber.","; 
				$sql3.=" debe=0,";
				$sql3.=" haber=".$montoTotalPagoMoneda.",";	
				$sql3.=" haber_sus=0,";
				$sql3.=" debe_sus=".$montoTotalPagoMonedaSus.",";					 
				$sql3.=" glosa='".$glosa."'";
				echo $sql3."<br/>";
				mysql_query($sql3);
			}
			
		}



///FIN CREACION COMPROBANTE//////


require("cerrar_conexion.inc");
?>

<script language="JavaScript">
location.href="listPagos.php?cod_pago=<?php echo $cod_pago;?>";
</script>
