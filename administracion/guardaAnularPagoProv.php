<?php
require_once("conexion.inc");
include("funciones.php");



	

//echo "aquiii=".$_POST['cod_pago_prov']."<br/>";	
	$sql="update pago_proveedor set ";
	$sql.=" cod_estado_pago_prov=2,";
	$sql.=" obs_anulacion='".$_POST['obs_anulacion']."',"; 
	$sql.=" fecha_anulacion='".date('Y-m-d H:i:s', time())."',"; 
	$sql.=" cod_usuario_anulacion='".$_COOKIE['usuario_global']."'"; 
	$sql.=" where cod_pago_prov='".$_POST['cod_pago_prov']."'"; 	

	mysql_query($sql);
	
	//////////////ACTUALIZAR ESTADOS//////////
		$sql=" select codigo_doc ";
		$sql.=" from pago_proveedor_detalle ";
		$sql.=" where cod_pago_prov=".$_POST['cod_pago_prov'];
		$sql.=" and cod_tipo_doc=4";
		$resp= mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){
			$cod_ingreso=$dat['codigo_doc'];
			$monto_ingreso=0;
			
			$sql2=" select  total_bs from ingresos  where cod_ingreso=".$cod_ingreso;
			$resp2= mysql_query($sql2);
			while($dat2=mysql_fetch_array($resp2)){
				 $monto_ingreso=$dat2['total_bs'];
			 }
		//ACTUALIZACION DE ESTADO PAGO DE INGRESO//
		$sql2=" select  count(*),sum(ppd.monto_pago_prov_detalle) ";
		$sql2.=" from pago_proveedor_detalle ppd ";
		$sql2.=" inner join  pago_proveedor pp on(ppd.cod_pago_prov=pp.cod_pago_prov and pp.cod_estado_pago_prov<>2) ";
		$sql2.=" and ppd.codigo_doc=".$cod_ingreso;
		$sql2.=" and ppd.cod_pago_prov<>".$_POST['cod_pago_prov'];
		$sql2.=" and ppd.cod_tipo_doc=4 ";
		$resp2 = mysql_query($sql2);
		$acuenta_pago_prov=0;
		while($dat2=mysql_fetch_array($resp2)){					
			$num_pago_prov=$dat2[0];
			if($num_pago_prov>0){
				$acuenta_pago_prov=$dat2[1];									
			}
		}
					 $saldoActual=$monto_ingreso-$acuenta_pago_prov;

			 
			 if($saldoActual==0){
						$sql4=" update ingresos set ";
						$sql4.=" cod_estado_pago_doc=3";
						$sql4.=" where cod_ingreso='".$cod_ingreso."'"; 

						mysql_query($sql4);
			}else{
				if($acuenta_pago_prov==0){
						$sql4=" update ingresos set ";
						$sql4.=" cod_estado_pago_doc=1";
						$sql4.=" where cod_ingreso='".$cod_ingreso."'";  	
						mysql_query($sql4);	
								
				}else{

						$sql4=" update ingresos set ";
						$sql4.=" cod_estado_pago_doc=2";
						$sql4.=" where cod_ingreso='".$cod_ingreso."'";  		
						mysql_query($sql4);		
								
				}		
			}
			//FIN ACTUALIZACION DE ESTADO PAGO DE INGRESO////
		}
		
		
		$sql=" select codigo_doc ";
		$sql.=" from pago_proveedor_detalle ";
		$sql.=" where cod_pago_prov=".$_POST['cod_pago_prov'];
		$sql.=" and cod_tipo_doc=5";
		$resp= mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){
			$cod_gasto_gral=$dat['codigo_doc'];
			$monto_gasto_gral=0;
			$sql2=" select  monto_gasto_gral from gastos_gral  where cod_gasto_gral=".$cod_gasto_gral;
			$resp2= mysql_query($sql2);
			while($dat2=mysql_fetch_array($resp2)){
				 $monto_gasto_gral=$dat2['monto_gasto_gral'];
			 }
			 $sql2=" select  count(*),sum(ppd.monto_pago_prov_detalle) ";
		$sql2.=" from pago_proveedor_detalle ppd ";
		$sql2.=" inner join  pago_proveedor pp on(ppd.cod_pago_prov=pp.cod_pago_prov and pp.cod_estado_pago_prov<>2) ";
		$sql2.=" and ppd.codigo_doc=".$cod_gasto_gral;
		$sql2.=" and ppd.cod_pago_prov<>".$_POST['cod_pago_prov'];
		$sql2.=" and ppd.cod_tipo_doc=5";
		$resp2 = mysql_query($sql2);
		$acuenta_pago_prov=0;
		while($dat2=mysql_fetch_array($resp2)){					
			$num_pago_prov=$dat2[0];
			if($num_pago_prov>0){
				$acuenta_pago_prov=$dat2[1];									
			}
		}
					 $saldoActual=$monto_gasto_gral-$acuenta_pago_prov;

			 
			 if($saldoActual==0){
						$sql4=" update gastos_gral set ";
						$sql4.=" cod_estado_pago_doc=3";
						$sql4.=" where cod_gasto_gral='".$cod_gasto_gral."'"; 

						mysql_query($sql4);
			}else{
				if($acuenta_pago_prov==0){
						$sql4=" update gastos_gral set ";
						$sql4.=" cod_estado_pago_doc=1";
						$sql4.=" where cod_gasto_gral='".$cod_gasto_gral."'";  	
						mysql_query($sql4);	
								
				}else{

						$sql4=" update gastos_gral set ";
						$sql4.=" cod_estado_pago_doc=2";
						$sql4.=" where cod_gasto_gral='".$cod_gasto_gral."'";  		
						mysql_query($sql4);		
								
				}		
			}
		}	 
	///////////////////////////////////////////////

	


require("cerrar_conexion.inc");
?>
<script language="JavaScript">
	opener.location.reload();
window.close();
</script>
