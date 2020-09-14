<?php
require("conexion.inc");
include("funciones.php");

	$sql="update cotizaciones set ";

		$sql.=" descuento_cotizacion=".$_POST['descuento_cotizacion'].","; 
		$sql.=" descuento_fecha='".date('Y-m-d', time())."',";
		$sql.=" cod_usuario_descuento='".$_COOKIE['usuario_global']."',";
		$sql.=" descuento_obs='".$_POST['descuento_obs']."'";
		$sql.=" where cod_cotizacion='".$_POST['cod_cotizacion']."'"; 
		mysql_query($sql);
		
	$sql="select cod_hoja_ruta from hojas_rutas where cod_cotizacion='".$_POST['cod_cotizacion']."'";
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$cod_hoja_ruta=$dat['cod_hoja_ruta'];
	}
	
	
					$monto_hojaruta=0;				
					$sqlAux=" select sum(cd.IMPORTE_TOTAL) ";
					$sqlAux.=" from hojas_rutas_detalle hrd, cotizaciones_detalle cd ";
					$sqlAux.=" where hrd.cod_hoja_ruta=".$cod_hoja_ruta;
					$sqlAux.=" and hrd.cod_cotizacion=cd.cod_cotizacion ";
					$sqlAux.=" and hrd.cod_cotizaciondetalle=cd.cod_cotizaciondetalle ";
					$respAux = mysql_query($sqlAux);
					while($datAux=mysql_fetch_array($respAux)){
							$monto_hojaruta=$datAux[0];
					}
					$descuento_cotizacion=0;
					$sqlAux="select descuento_cotizacion from cotizaciones where cod_cotizacion=".$cod_cotizacion;
					$respAux = mysql_query($sqlAux);
					while($datAux=mysql_fetch_array($respAux)){
							$descuento_cotizacion=$datAux[0];
					}
					$incremento_cotizacion=0;
					$sqlAux="select incremento_cotizacion from cotizaciones where cod_cotizacion=".$cod_cotizacion;
					$respAux = mysql_query($sqlAux);
					while($datAux=mysql_fetch_array($respAux)){
							$incremento_cotizacion=$datAux[0];
					}
					
					$monto_real=(($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion);
				
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

					if($cod_moneda==1){
						$acuenta_hojaruta=$acuenta_hojaruta+$monto_pago_detalle;
					}else{
							$sql3=" select cambio_bs from tipo_cambio";
							$sql3.=" where fecha_tipo_cambio='".$fecha_pago."'";
							$sql3.=" and cod_moneda=".$cod_moneda;

							$resp3=mysql_query($sql3);
							$cambio_bs=0;
							while($dat3=mysql_fetch_array($resp3)){
								$cambio_bs=$dat3['cambio_bs'];
							}
							if($cambio_bs<>0){
								$acuenta_hojaruta=$acuenta_hojaruta+($monto_pago_detalle*$cambio_bs);
							
							}
						
					}
				}				

			 			 
			 $saldoActual=$monto_real-$acuenta_hojaruta;

			 
			 if($saldoActual==0){
						$sql4=" update hojas_rutas set ";
						$sql4.=" cod_estado_pago_doc=3";
						$sql4.=" where cod_hoja_ruta=".$cod_hoja_ruta;
						//echo $sql4."<br/>";
						mysql_query($sql4);
			}else{
				if($acuenta_hojaruta==0){
						$sql4=" update hojas_rutas set ";
						$sql4.=" cod_estado_pago_doc=1";
						$sql4.=" where cod_hoja_ruta=".$cod_hoja_ruta;		
						mysql_query($sql4);	
					//	echo $sql4."<br/>";									
				}else{

						$sql4=" update hojas_rutas set ";
						$sql4.=" cod_estado_pago_doc=2";
						$sql4.=" where cod_hoja_ruta=".$cod_hoja_ruta;		
						mysql_query($sql4);		
						//echo $sql4."<br/>";									
				}		
			}

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
	location.href="listCotizaciones.php";
		window.close();
        window.opener.location.reload();
</script>
