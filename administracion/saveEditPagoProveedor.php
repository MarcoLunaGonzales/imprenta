<?php
require_once("conexion.inc");
include("funciones.php");


	$vectorFechaPago = explode("/", $_POST['fecha_pago_prov']);
	$fechaPagoProv = $vectorFechaPago[2] . "-" . $vectorFechaPago[1] . "-" . $vectorFechaPago[0];
	

	
	$sql="update pago_proveedor set ";
	$sql.=" fecha_pago_prov='".$fechaPagoProv."',"; 
	$sql.=" obs_pago_prov='".$_POST['obs_pago_prov']."',"; 
	$sql.=" monto_pago_prov='".$_POST['total_bs']."',"; 
	$sql.=" fecha_modifica='".date('Y-m-d H:i:s', time())."',"; 
	$sql.=" cod_usuario_modifica='".$_COOKIE['usuario_global']."'"; 
	$sql.=" where cod_pago_prov='".$_POST['cod_pago_prov']."'"; 	
//	echo $sql."<br/>";
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
			//echo $sql2;
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
		/*echo "cod_ingreso=".$cod_ingreso."<br/>";
		echo "monto_ingreso=".$monto_ingreso."<br/>";
		echo "acuenta_pago_prov=".$acuenta_pago_prov."<br/>";
		echo "saldoActual=".$saldoActual."<br/>";*/
		
					 $saldoActual=$monto_ingreso-$acuenta_pago_prov;

			 
			 if($saldoActual==0){
						$sql4=" update ingresos set ";
						$sql4.=" cod_estado_pago_doc=3";
						$sql4.=" where cod_ingreso='".$cod_ingreso."'"; 
						echo $sql4."<br/>";
						mysql_query($sql4);
			}else{
				if($acuenta_pago_prov==0){
						$sql4=" update ingresos set ";
						$sql4.=" cod_estado_pago_doc=1";
						$sql4.=" where cod_ingreso='".$cod_ingreso."'";  
						echo $sql4."<br/>";	
						mysql_query($sql4);	
								
				}else{

						$sql4=" update ingresos set ";
						$sql4.=" cod_estado_pago_doc=2";
						$sql4.=" where cod_ingreso='".$cod_ingreso."'";  	
						echo $sql4."<br/>";	
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

	
////////////////////////////////DETALLE DE INGRESOS///////////////////////////////////
	$sql="delete from pago_proveedor_detalle where cod_pago_prov=".$_POST['cod_pago_prov']." and cod_tipo_doc=4";
	mysql_query($sql);
	$sql=" select i.cod_ingreso, i.nro_ingreso, i.cod_gestion, g.gestion,  i.fecha_ingreso, i.total_bs ";
	$sql.=" from ingresos i, gestiones g";
	$sql.=" where i.cod_gestion=g.cod_gestion";
	$sql.=" and i.cod_proveedor=".$_POST['cod_proveedor'];
	$sql.=" and i.cod_estado_ingreso<>2";
	$sql.=" and i.cod_estado_pago_doc<>3";
	$sql.=" order by  i.fecha_ingreso asc , i.nro_ingreso asc  ";
	$resp= mysql_query($sql);
	$gestion="";
	while($dat=mysql_fetch_array($resp)){
		 $cod_ingreso=$dat['cod_ingreso'];
		 $nro_ingreso=$dat['nro_ingreso'];
		 $cod_gestion=$dat['cod_gestion'];
		 $gestion=$dat['gestion'];
		 $fecha_ingreso=$dat['fecha_ingreso'];
		 $monto_ingreso=$dat['total_bs'];

		 
		 if($_POST['cod_ingreso'.$cod_ingreso]){
			 
			 $saldo_ingreso=$_POST['saldo_ingreso'.$cod_ingreso];
			 $monto_pago_prov_detalle=$_POST['monto_pago_ingreso'.$cod_ingreso];	
 
			 
			 	$sql2=" select max(cod_pago_prov_detalle) from pago_proveedor_detalle where cod_pago_prov=".$_POST['cod_pago_prov'];
				$cod_pago_prov_detalle=obtenerCodigo($sql2);
			 
			 $sql2=" insert into  pago_proveedor_detalle set ";
			 $sql2.=" cod_pago_prov_detalle='".$cod_pago_prov_detalle."',";
			 $sql2.=" cod_pago_prov='".$_POST['cod_pago_prov']."',";
			 $sql2.=" codigo_doc='".$cod_ingreso."',";
			 $sql2.=" cod_tipo_doc=4,";			 
			 $sql2.=" monto_pago_prov_detalle='".$monto_pago_prov_detalle."'";	 
			 mysql_query($sql2);
			 
		//ACTUALIZACION DE ESTADO PAGO DE INGRESO//
		$sql2=" select  count(*),sum(ppd.monto_pago_prov_detalle) ";
		$sql2.=" from pago_proveedor_detalle ppd ";
		$sql2.=" inner join  pago_proveedor pp on(ppd.cod_pago_prov=pp.cod_pago_prov and pp.cod_estado_pago_prov<>2) ";
		$sql2.=" and ppd.codigo_doc=".$cod_ingreso;
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
		 
	}

////////////////////////////////DETALLE DE GASTOS///////////////////////////////////
	$sql="delete from pago_proveedor_detalle where cod_pago_prov=".$_POST['cod_pago_prov']." and cod_tipo_doc=5";
	mysql_query($sql);
	$sql=" select cod_gasto_gral,  fecha_gasto_gral, monto_gasto_gral ";
	$sql.=" from gastos_gral ";
	$sql.=" where cod_proveedor=".$_POST['cod_proveedor'];
	$sql.=" and cod_estado<>2";
	$sql.=" and cod_estado_pago_doc<>3";
	$sql.=" order by  fecha_gasto_gral asc , nro_gasto_gral asc  ";
	$resp= mysql_query($sql);
	$gestion="";
	while($dat=mysql_fetch_array($resp)){
		 $cod_gasto_gral=$dat['cod_gasto_gral'];
		 $fecha_gasto_gral=$dat['fecha_gasto_gral'];
		 $monto_gasto_gral=$dat['monto_gasto_gral'];

		 
		 if($_POST['cod_gasto_gral'.$cod_gasto_gral]){
			 
			 $saldo_gasto_gral=$_POST['saldo_gasto_gral'.$cod_gasto_gral];
			 $monto_pago_prov_detalle=$_POST['monto_pago_gasto_gral'.$cod_gasto_gral];	
 
			 
			 $sql2=" select max(cod_pago_prov_detalle) from pago_proveedor_detalle where cod_pago_prov=".$_POST['cod_pago_prov'];
			 $cod_pago_prov_detalle=obtenerCodigo($sql2);
			 
			 $sql2=" insert into  pago_proveedor_detalle set ";
			 $sql2.=" cod_pago_prov_detalle='".$cod_pago_prov_detalle."',";
			 $sql2.=" cod_pago_prov='".$_POST['cod_pago_prov']."',";
			 $sql2.=" codigo_doc='".$cod_gasto_gral."',";
			 $sql2.=" cod_tipo_doc=5,";			 
			 $sql2.=" monto_pago_prov_detalle='".$monto_pago_prov_detalle."'";	 
			 mysql_query($sql2);
			 
		//ACTUALIZACION DE ESTADO PAGO DE INGRESO//
		$sql2=" select  count(*),sum(ppd.monto_pago_prov_detalle) ";
		$sql2.=" from pago_proveedor_detalle ppd ";
		$sql2.=" inner join  pago_proveedor pp on(ppd.cod_pago_prov=pp.cod_pago_prov and pp.cod_estado_pago_prov<>2) ";
		$sql2.=" and ppd.codigo_doc=".$cod_gasto_gral;
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
			//FIN ACTUALIZACION DE ESTADO PAGO DE INGRESO////
					

		 }
		 
	}
	$sql="delete from pago_proveedor_descripcion where cod_pago_prov=".$_POST['cod_pago_prov']." ";
	mysql_query($sql);

$sql3="select cambio_bs from tipo_cambio";
$sql3.=" where fecha_tipo_cambio='".date('Y-m-d', time())."'";
$sql3.=" and cod_moneda=2";
$resp3 = mysql_query($sql3);
$cambio_bs=0;
while($dat3=mysql_fetch_array($resp3)){
	$cambio_bs=$dat3['cambio_bs'];
}
							
$sql=" select cod_forma_pago from forma_pago";
$resp= mysql_query($sql);
while($dat=mysql_fetch_array($resp)){
	$cod_forma_pago=$dat['cod_forma_pago'];	
	$montoPagoBs=0;	
	if($_POST['montoPagoBs'.$cod_forma_pago]){
		$montoPagoBs=$_POST['montoPagoBs'.$cod_forma_pago];
	}
	$bancoBs=NULL;
	if($_POST['bancoBs'.$cod_forma_pago]){
		$bancoBs=$_POST['bancoBs'.$cod_forma_pago];
	}
	$nro_chequeBs="";
	if($_POST['nro_chequeBs'.$cod_forma_pago]){
		$nro_chequeBs=$_POST['nro_chequeBs'.$cod_forma_pago];
	}
	$nro_cuentaBs="";	
	if($_POST['nro_cuentaBs'.$cod_forma_pago]){
		$nro_cuentaBs=$_POST['nro_cuentaBs'.$cod_forma_pago];
	}	
	if($montoPagoBs>0){
		$sql2="	insert into pago_proveedor_descripcion set ";
		$sql2.=" cod_pago_prov=".$_POST['cod_pago_prov']. ",";
		$sql2.=" cod_forma_pago=".$cod_forma_pago. ",";
		$sql2.=" cod_moneda=1,"; 
		$sql2.=" monto_pago_prov=".$montoPagoBs.","; 
		if($cod_forma_pago==2 or $cod_forma_pago==3){
			$sql2.=" cod_banco=".$bancoBs. ",";
		}
		$sql2.=" nro_cheque='".$nro_chequeBs."',";
		$sql2.=" nro_cuenta='".$nro_cuentaBs."'";
		//echo $sql2;
		 mysql_query($sql2);
	
	}	
	
	$montoPagoSus=0;	
	if($_POST['montoPagoSus'.$cod_forma_pago]){
		$montoPagoSus=$_POST['montoPagoSus'.$cod_forma_pago];
	}
	$bancoSus=NULL;
	if($_POST['bancoSus'.$cod_forma_pago]){
		$bancoSus=$_POST['bancoSus'.$cod_forma_pago];
	}
	$nro_chequeSus="";
	if($_POST['nro_chequeSus'.$cod_forma_pago]){
		$nro_chequeSus=$_POST['nro_chequeSus'.$cod_forma_pago];
	}
	$nro_cuentaSus="";	
	if($_POST['nro_cuentaSus'.$cod_forma_pago]){
		$nro_cuentaSus=$_POST['nro_cuentaSus'.$cod_forma_pago];
	}	
	if($montoPagoSus>0){
		$sql2="	insert into pago_proveedor_descripcion set ";
		$sql2.=" cod_pago_prov=".$_POST['cod_pago_prov']. ",";
		$sql2.=" cod_forma_pago=".$cod_forma_pago. ",";
		$sql2.=" cod_moneda=2,"; 
		$sql2.=" monto_pago_prov=".$montoPagoSus.","; 
		if($cod_forma_pago==2 or $cod_forma_pago==3){
			$sql2.=" cod_banco=".$bancoSus. ",";
		}
		$sql2.=" nro_cheque='".$nro_chequeSus."',";
		$sql2.=" nro_cuenta='".$nro_cuentaSus."'";
		//echo $sql2;
		mysql_query($sql2);	
	}		
	
}


require("cerrar_conexion.inc");
?>

<script language="JavaScript">
location.href="listPagoProveedor.php";
</script>
