<?php
require("conexion.inc");
include("funciones.php");

	$sql="update ordentrabajo set ";
	$sql.=" incremento_orden_trabajo=".$_POST['incremento_orden_trabajo'].","; 
	$sql.=" incremento_fecha='".date('Y-m-d', time())."',";
	$sql.=" cod_usuario_incremento='".$_COOKIE['usuario_global']."',";
	$sql.=" incremento_obs='".$_POST['incremento_obs']."'";
	$sql.=" where cod_orden_trabajo='".$_POST['cod_orden_trabajo']."'"; 
	mysql_query($sql);
		

					$monto_orden_trabajo=0;
					$descuento_cotizacion=0;
					$incremento_cotizacion=0;
					$sqlAux=" select monto_orden_trabajo, incremento_orden_trabajo, descuento_orden_trabajo ";
					$sqlAux.=" from ordentrabajo where cod_orden_trabajo='".$_POST['cod_orden_trabajo']."'";
					$respAux = mysql_query($sqlAux);
					while($datAux=mysql_fetch_array($respAux)){
							$monto_orden_trabajo=$datAux['monto_orden_trabajo'];
							$incremento_orden_trabajo=$datAux['incremento_orden_trabajo'];
							$descuento_orden_trabajo=$datAux['descuento_orden_trabajo'];
					}
					
					$monto_real=(($monto_orden_trabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo);
				
				///////////////////ACUENTA///////////////
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
					if($cod_moneda==1){
						$acuenta_ordentrabajo=$acuenta_ordentrabajo+$monto_pago_detalle;
					}else{
							$sql3="select cambio_bs from tipo_cambio";
							$sql3.=" where fecha_tipo_cambio='".$fecha_pago."'";
							$sql3.=" and cod_moneda=".$cod_moneda;
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
			 
	///////////////FIN A CUENTA/////////////////////
			 			 
			 $saldoActual=$monto_real-$acuenta_ordentrabajo;

			 
			 if($saldoActual==0){
						$sql4=" update ordentrabajo set ";
						$sql4.=" cod_estado_pago_doc=3";
						$sql4.=" where cod_orden_trabajo='".$_POST['cod_orden_trabajo']."'"; 

						mysql_query($sql4);
			}else{
				if($acuenta_ordentrabajo==0){
						$sql4=" update ordentrabajo set ";
						$sql4.=" cod_estado_pago_doc=1";
						$sql4.=" where cod_orden_trabajo='".$_POST['cod_orden_trabajo']."'"; 	
						mysql_query($sql4);	
								
				}else{

						$sql4=" update ordentrabajo set ";
						$sql4.=" cod_estado_pago_doc=2";
						$sql4.=" where cod_orden_trabajo='".$_POST['cod_orden_trabajo']."'"; 		
						mysql_query($sql4);		
								
				}		
			}

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
	location.href="listOrdenTrabajo.php";
		window.close();
        window.opener.location.reload();
</script>
