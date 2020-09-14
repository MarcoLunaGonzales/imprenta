<?php
require("conexion.inc");
include("funciones.php");


	list($dI,$mI,$aI)=explode("/",$_POST['fecha_gasto_gral']);
	$sql=" update gastos_gral set ";
	if($_POST['cod_tipo_doc']<>null and $_POST['cod_tipo_doc']<>"" ){
		$sql.=" cod_tipo_doc='".$_POST['cod_tipo_doc']."',";
		$sql.=" codigo_doc='".$_POST['codigo_doc']."',";
	}
	if($_POST['cod_proveedor']<>null and $_POST['cod_proveedor']<>"" ){
		$sql.=" cod_proveedor='".$_POST['cod_proveedor']."',";
	}
	$sql.=" fecha_gasto_gral='".$aI."-".$mI."-".$dI."',";
	$sql.=" nro_recibo='".$_POST['nro_recibo']."',";
	$sql.=" monto_gasto_gral=".$_POST['monto_gasto_gral'].",";
	$sql.=" cant_gasto_gral='".$_POST['cant_gasto_gral']."',";
	$sql.=" desc_gasto_gral='".$_POST['desc_gasto_gral']."',";
	$sql.=" cod_gasto='".$_POST['cod_gasto']."',";
	$sql.=" cod_tipo_pago='".$_POST['cod_tipo_pago']."',";
	$sql.=" fecha_modifica='".date('Y-m-d h:i:s', time())."',";
	$sql.=" cod_usuario_modifica='".$_COOKIE['usuario_global']."'";
	$sql.=" where cod_gasto_gral='".$_POST['cod_gasto_gral']."'";
	//echo $sql;
	mysql_query($sql);

	if($_POST['cod_tipo_doc']<>null && $_POST['cod_tipo_doc']<>"" ){
		$sql2=" select  count(*),sum(ppd.monto_pago_prov_detalle) ";
		$sql2.=" from pago_proveedor_detalle ppd ";
		$sql2.=" inner join  pago_proveedor pp on(ppd.cod_pago_prov=pp.cod_pago_prov and pp.cod_estado_pago_prov<>2) ";
		$sql2.=" and ppd.codigo_doc=".$_POST['codigo_doc'];
		$sql2.=" and ppd.cod_tipo_doc=".$_POST['cod_tipo_doc'];
		$resp2 = mysql_query($sql2);
		$acuenta_pago_prov=0;
		while($dat2=mysql_fetch_array($resp2)){					
			$num_pago_prov=$dat2[0];
			if($num_pago_prov>0){
				$acuenta_pago_prov=$dat2[1];									
			}
		}
					 $saldoActual=$_POST['monto_gasto_gral']-$acuenta_pago_prov;

			 
			 if($saldoActual==0){
						$sql4=" update gastos_gral set ";
						$sql4.=" cod_estado_pago_doc=3";
						$sql4.=" where cod_gasto_gral='".$_POST['cod_gasto_gral']."'"; 

						mysql_query($sql4);
			}else{
				if($acuenta_pago_prov==0){
						$sql4=" update gastos_gral set ";
						$sql4.=" cod_estado_pago_doc=1";
						$sql4.=" where cod_gasto_gral='".$_POST['cod_gasto_gral']."'";  	
						mysql_query($sql4);	
								
				}else{

						$sql4=" update gastos_gral set ";
						$sql4.=" cod_estado_pago_doc=2";
						$sql4.=" where cod_gasto_gral='".$_POST['cod_gasto_gral']."'";  		
						mysql_query($sql4);		
								
				}		
			}
			//FIN ACTUALIZACION DE ESTADO PAGO DE INGRESO////	
	}

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listGastosGral.php";
</script>