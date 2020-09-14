<?php
require("conexion.inc");
include("funciones.php");

$cod_ingreso=$_POST['cod_ingreso'];
$cod_almacen=$_POST['cod_almacen'];
$cod_tipo_ingreso=$_POST['cod_tipo_ingreso'];
$cod_proveedor=$_POST['cod_proveedor'];
$nro_factura=$_POST['nro_factura'];
$obs_ingreso=$_POST['obs_ingreso'];



$sql=" update ingresos set ";
$sql.=" fecha_modifica='".date('Y-m-d h:i:s', time())."',"; 
$sql.=" cod_usuario_modifica='".$_COOKIE['usuario_global']."',";
if($_POST['cod_tipo_ingreso']==1){
	$sql.=" cod_proveedor='".$_POST['cod_proveedor']."',";
	if($_POST['cod_contacto_proveedor']<>0){
		$sql.=" cod_contacto_proveedor='".$_POST['cod_contacto_proveedor']."',";
	}
}
$sql.=" nro_factura='".$_POST['nro_factura']."',";
if($_POST['fecha_factura']<>"" && $_POST['fecha_factura']!=NULL ){
	list($dI,$mI,$aI)=explode("/",$_POST['fecha_factura']);
	$sql.=" fecha_factura='".$aI."-".$mI."-".$dI."',";
}
$sql.=" total_bs='".$_POST['total_bs']."',";
$sql.=" dias_plazo_pago='".$_POST['dias_plazo_pago']."',";
$sql.=" cod_tipo_pago='".$_POST['cod_tipo_pago']."',";
$sql.=" obs_ingreso='".$_POST['obs_ingreso']."' ";
$sql.=" where cod_ingreso='".$_POST['cod_ingreso']."'";
mysql_query($sql);
 if($_POST['cod_tipo_ingreso']==1){
		//ACTUALIZACION DE ESTADO PAGO DE INGRESO//
		$sql2=" select  count(*),sum(ppd.monto_pago_prov_detalle) ";
		$sql2.=" from pago_proveedor_detalle ppd ";
		$sql2.=" inner join  pago_proveedor pp on(ppd.cod_pago_prov=pp.cod_pago_prov and pp.cod_estado_pago_prov<>2) ";
		$sql2.=" and ppd.codigo_doc=".$_POST['cod_ingreso'];
		$sql2.=" and ppd.cod_tipo_doc=4 ";
		$resp2 = mysql_query($sql2);
		$acuenta_pago_prov=0;
		while($dat2=mysql_fetch_array($resp2)){					
			$num_pago_prov=$dat2[0];
			if($num_pago_prov>0){
				$acuenta_pago_prov=$dat2[1];									
			}
		}
					 $saldoActual=$_POST['total_bs']-$acuenta_pago_prov;

			 
			 if($saldoActual==0){
						$sql4=" update ingresos set ";
						$sql4.=" cod_estado_pago_doc=3";
						$sql4.=" where cod_ingreso='".$_POST['cod_ingreso']."'"; 

						mysql_query($sql4);
			}else{
				if($acuenta_pago_prov==0){
						$sql4=" update ingresos set ";
						$sql4.=" cod_estado_pago_doc=1";
						$sql4.=" where cod_ingreso='".$_POST['cod_ingreso']."'";  	
						mysql_query($sql4);	
								
				}else{

						$sql4=" update ingresos set ";
						$sql4.=" cod_estado_pago_doc=2";
						$sql4.=" where cod_ingreso='".$_POST['cod_ingreso']."'";  		
						mysql_query($sql4);		
								
				}		
			}
			//FIN ACTUALIZACION DE ESTADO PAGO DE INGRESO////
}
if($_POST['num']){

		$num=$_POST['num'];
		if($cod_ingreso<>""){
	
			$sql3="delete from  ingresos_detalle where cod_ingreso='".$cod_ingreso."'";	
			mysql_query($sql3);

			for($i = 1;$i <=$num ;$i++) {	
			

			$cod_material=$_POST['cod_material'.$i];
			$cantidad=$_POST['cantidad'.$i];
			$precioCompra=$_POST['precioCompra'.$i];
			$precioVenta=$_POST['precioVenta'.$i];
			$importe=$_POST['importe'.$i];
			
	

			$sql=" select max(cod_ingreso_detalle) from ingresos_detalle ";
			$cod_ingreso_detalle=obtenerCodigo($sql);

			if($cod_ingreso_detalle<>"" and $cod_ingreso<>"" and $cod_material<>"" and $precioCompra<>"" and $precioVenta<>"" ){

				$sql3="insert into ingresos_detalle set";
				$sql3.=" cod_ingreso_detalle='".$cod_ingreso_detalle."',";
				$sql3.=" cod_ingreso='".$cod_ingreso."',";
				$sql3.=" cod_material='".$cod_material."',";
				$sql3.=" precio_compra_uni='".$precioCompra."',";	
				$sql3.=" cantidad='".$cantidad."',";	
				$sql3.=" cant_actual='".$cantidad."'";	
				
				//echo $sql3."<br/>";
				mysql_query($sql3);
			
				$sql3=" update materiales set";
				$sql3.=" precio_venta=".$precioVenta;
				$sql3.=" where cod_material=".$cod_material;					
				mysql_query($sql3);
			}
		}
	}
}

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
	location.href="listIngresos.php?cod_almacen=<?php echo $cod_almacen;?>";
</script>