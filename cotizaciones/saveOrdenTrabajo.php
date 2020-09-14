<?php
require("conexion.inc");
include("funciones.php");


$cod_est_ot=1;


$sql=" select max(cod_orden_trabajo) from ordentrabajo ";
$cod_orden_trabajo=obtenerCodigo($sql);

$cod_gestion=gestionActiva();

$sql="select max(nro_orden_trabajo) from ordentrabajo where cod_gestion='".$cod_gestion."'";
$nro_orden_trabajo=obtenerCodigo($sql);

list($d,$m,$a)=explode("/",$_POST['fecha_orden_trabajo']);

$sql="insert into ordentrabajo set ";
$sql.=" cod_orden_trabajo='".$cod_orden_trabajo."',"; 
$sql.=" nro_orden_trabajo='".$nro_orden_trabajo."',"; 
$sql.=" cod_gestion='".$cod_gestion."',";
$sql.=" cod_est_ot='".$cod_est_ot."',";
$sql.=" numero_orden_trabajo='".$_POST['numero_orden_trabajo']."',";
$sql.=" fecha_orden_trabajo='".$a."-".$m."-".$d."',";
$sql.=" cod_cliente='".$_POST['cod_cliente']."',";
$sql.=" cod_contacto='".$_POST['cod_contacto']."',";
$sql.=" detalle_orden_trabajo='".$_POST['detalle_orden_trabajo']."',";
$sql.=" obs_orden_trabajo='".$_POST['obs_orden_trabajo']."',";
$sql.=" monto_orden_trabajo='".$_POST['monto_orden_trabajo']."',";
$sql.=" cod_usuario_registro='".$_COOKIE['usuario_global']."',";
$sql.=" fecha_registro='".date('Y-m-d', time())."',";
$sql.=" cod_tipo_pago=".$_POST['cod_tipo_pago'].",";
$sql.=" incremento_orden_trabajo=0,";
$sql.=" descuento_orden_trabajo=0,";
if($cod_tipo_pago==3){
	$sql.=" cod_estado_pago_doc=3";
}else{
	$sql.=" cod_estado_pago_doc=1";
}
$resp=mysql_query($sql);

///CREACION DE CUENTA////

	$sql3="select  nombre_cliente from clientes where cod_cliente=".$_POST['cod_cliente'];

	$resp3 = mysql_query($sql3);
	while($dat3=mysql_fetch_array($resp3)){	
		$nombre_cliente=$dat3['nombre_cliente'];		
	}	
	$sql3=" select  cod_cuenta_conf,parametro1,parametro2 ";
	$sql3.=" from configuracion_cuentas where cod_conf_cuenta=1";
	$resp3 = mysql_query($sql3);
	while($dat3=mysql_fetch_array($resp3)){	
		$cod_cuenta_conf=$dat3['cod_cuenta_conf'];
		$parametro1=$dat3['parametro1'];
		$parametro2=$dat3['parametro2'];
	}	
	$sql3=" select  cod_cuenta_padre from cuentas where cod_cuenta=".$cod_cuenta_conf;
	//echo $sql3;
	$resp3 = mysql_query($sql3);
	while($dat3=mysql_fetch_array($resp3)){	
		$cod_cuenta_padre_conf=$dat3['cod_cuenta_padre'];
	}		
	$fechaFinal=date('Y-m-d', time());
	//echo "parametro=".$parametro2."<br/>";
	$fechaInicio=date('Y-m-d', strtotime(-$parametro2."month"));
	//		echo "$fechaInicio=".$fechaInicio."<br/>";
	//		echo "$fechaFinal=".$fechaFinal."<br/>";

	$sql3=" select  cli.cod_cuenta,cuentas.nro_cuenta,cuentas.desc_cuenta,";
	$sql3.=" clientesVal.nroVTA, clientesVal.nroHR, clientesVal.nroOT, ";
	$sql3.=" (clientesVal.nroVTA+clientesVal.nroHR+clientesVal.nroOT) as nroDoc";
	$sql3.=" FROM(select cod_cliente,SUM(nroHR) as nroHR,SUM(nroOT) as nroOT,SUM(nroVTA) as nroVTA ";
	$sql3.=" from (select c.cod_cliente,count(*) as nroHR, 0 as nroOT, 0 as nroVTA ";
	$sql3.="  from  hojas_rutas hr inner join cotizaciones c ";
	$sql3.="  ON( hr.cod_cotizacion=c.cod_cotizacion and  hr.cod_estado_hoja_ruta<>2)";
	$sql3.=" and fecha_hoja_ruta>='".$fechaInicio."' and fecha_hoja_ruta<='".$fechaFinal."'";
 	$sql3.=" group by c.cod_cliente ";
	$sql3.="  UNION ";
	$sql3.=" select cod_cliente, 0 as nroHR, COUNT(*) as nroOT, 0 as nroVTA";
	$sql3.=" from ordentrabajo where cod_est_ot<>2 ";
	$sql3.=" and fecha_orden_trabajo>='".$fechaInicio."' and fecha_orden_trabajo<='".$fechaFinal."'";
	$sql3.=" group by cod_cliente ";
	$sql3.="  UNION ";
	$sql3.=" select cod_cliente_venta as cod_cliente, 0 as nroHR, 0 as nroOT, COUNT(*) as nroVTA";
	$sql3.=" from  salidas where cod_tipo_salida=1  and cod_estado_salida<>2  ";
	$sql3.=" and fecha_salida>='".$fechaInicio."' and fecha_salida<='".$fechaFinal."'";
	$sql3.="  group by cod_cliente) as clientesValidos ";
	$sql3.=" GROUP BY cod_cliente) as clientesVal  INNER join clientes cli ON(clientesVal.cod_cliente=cli.cod_cliente) ";
	$sql3.=" LEFT JOIN cuentas  on (cli.cod_cuenta=cuentas.cod_cuenta) ";
	$sql3.=" where cli.cod_cliente=".$cod_cliente;
	$resp3 = mysql_query($sql3);
	$cod_cuenta=NULL;
	$nro_cuenta="";
	$desc_cuenta="";
	$nroVTA=0;
	$nroHR=0;
	$nroOT=0;
	$nroDoc=0;
	while($dat3=mysql_fetch_array($resp3)){	
		$cod_cuenta=$dat3['cod_cuenta'];
		$nro_cuenta=$dat3['nro_cuenta'];
		$desc_cuenta=$dat3['desc_cuenta'];
	 	$nroVTA=$dat3['nroVTA'];
		$nroHR=$dat3['nroHR'];
		$nroOT=$dat3['nroOT'];
		$nroDoc=$dat3['nroDoc'];
	}

	if($nroDoc>=$parametro1){
			if(($cod_cuenta==$cod_cuenta_conf) or ($cod_cuenta==NULL or $cod_cuenta=="" )){
				$sql=" select max(cod_cuenta) from cuentas ";
				$cod_cuenta_nueva=obtenerCodigo($sql);
		
				$sql="insert into cuentas set ";
				$sql.=" cod_cuenta='".$cod_cuenta_nueva."',"; 
				$sql.=" nro_cuenta=0,"; 
				$sql.=" desc_cuenta='".$nombre_cliente."',"; 
				$sql.=" cod_moneda='1',"; 
				$sql.=" cod_cuenta_padre=".$cod_cuenta_padre_conf.","; 
				$sql.=" cod_estado_registro=1,"; 
				$sql.=" cod_usuario_registro='".$_COOKIE['usuario_global']."',";
				$sql.=" fecha_registro='".date('Y-m-d H:i:s', time())."'";
				mysql_query($sql);
				$sql=" update clientes set ";
				$sql.=" cod_cuenta=".$cod_cuenta_nueva;
				$sql.=" where cod_cliente=".$cod_cliente;
				mysql_query($sql);		
			}
	}else{
		if($cod_cuenta==NULL or $cod_cuenta=="" ){
			$sql=" update clientes set ";
			$sql.=" cod_cuenta=".$cod_cuenta_conf;
			$sql.=" where cod_cliente=".$cod_cliente;
			mysql_query($sql);
		}
	
	}

	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listOrdenTrabajo.php?cod_orden_trabajo=<?php echo $cod_orden_trabajo;?>";
</script>