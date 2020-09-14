<?php
require("conexion.inc");
include("funciones.php");

$cod_almacen=$_POST['cod_almacen'];
$cod_proveedor=$_POST['cod_proveedor'];
$nro_factura=$_POST['nro_factura'];
$obs_ingreso=$_POST['obs_ingreso'];
$cod_estado_ingreso=1;

$num=$_POST['num'];
//echo "num=".$num;

$cod_estado_registro=1;
$cod_tipo_ingreso=1;

$sql=" select max(cod_ingreso) from ingresos ";
$cod_ingreso=obtenerCodigo($sql);

$cod_gestion=gestionActiva();
	
$sql="select max(nro_ingreso) from ingresos where cod_gestion='".$cod_gestion."' and cod_almacen='".$cod_almacen."'";
$nro_ingreso=obtenerCodigo($sql);




$sql="insert into ingresos set ";
$sql.=" cod_ingreso='".$cod_ingreso."',"; 
$sql.=" fecha_ingreso='".date('Y/m/d', time())."',"; 
$sql.=" cod_usuario_ingreso='".$_COOKIE['usuario_global']."',";
$sql.=" cod_proveedor='".$cod_proveedor."',";
	if($_POST['cod_contacto_proveedor']<>0){
		$sql.=" cod_contacto_proveedor='".$_POST['cod_contacto_proveedor']."',";
	}
$sql.=" cod_almacen='".$cod_almacen."',";
if($_POST['nro_factura']<>""){
	list($dI,$mI,$aI)=explode("/",$_POST['fecha_factura']);
	$sql.=" nro_factura='".$_POST['nro_factura']."',";
	$sql.=" fecha_factura='".$aI."-".$mI."-".$dI."',";
}
$sql.=" cod_gestion='".$cod_gestion."',"; 
$sql.=" nro_ingreso='".$nro_ingreso."',"; 
$sql.=" cod_tipo_ingreso='".$cod_tipo_ingreso."',"; 
$sql.=" obs_ingreso='".$obs_ingreso."',";
$sql.=" cod_estado_ingreso='".$cod_estado_ingreso."',";
$sql.=" total_bs='".$_POST['total_bs']."',";
$sql.=" dias_plazo_pago='".$_POST['dias_plazo_pago']."',";
$sql.=" cod_tipo_pago='".$_POST['cod_tipo_pago']."',";
$sql.=" cod_estado_pago_doc='1'";
mysql_query($sql);


$sql5="select cod_ingreso from ingresos where cod_ingreso=".$cod_ingreso."";
$resp=mysql_query($sql5);

while($dat=mysql_fetch_array($resp)){
	$cod_ingreso=$dat[0];
}	

if($cod_ingreso<>""){


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

			mysql_query($sql3);
			
			$sql3=" update materiales set";
			$sql3.=" precio_venta=".$precioVenta;
			$sql3.=" where cod_material=".$cod_material;	
			
			mysql_query($sql3);
		}
	}
	///CREACION DE CUENTA////
			
}

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listIngresos.php?cod_almacen=<?php echo $cod_almacen;?>";
</script>