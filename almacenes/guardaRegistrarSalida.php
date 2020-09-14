<?php

require("conexion.inc");
include("funciones.php");

$cod_almacen=$_POST['cod_almacen'];
$cod_tipo_salida=$_POST['cod_tipo_salida'];
if($cod_tipo_salida==1){
	$cod_cliente_venta=$_POST['cod_cliente_venta'];
	$cod_contacto=$_POST['cod_contacto'];
	$cod_tipo_pago=$_POST['cod_tipo_pago'];
	
}

if($cod_tipo_salida==2 or $cod_tipo_salida==4){
	$cod_hoja_ruta=$_POST['cod_hoja_ruta'];
}
if($cod_tipo_salida==3){
	$cod_almacen_traspaso=$_POST['cod_almacen_traspaso'];
}

if($cod_tipo_salida==5){
	$cod_orden_trabajo=$_POST['cod_orden_trabajo'];
}

$obs_salida=$_POST['obs_salida'];
$num=$_POST['num'];

$cod_estado_salida=1;





$sql=" select max(cod_salida) from salidas ";
$cod_salida=obtenerCodigo($sql);

$cod_gestion=gestionActiva();
	
$sql="select max(nro_salida) from salidas where cod_gestion='".$cod_gestion."' and cod_almacen='".$cod_almacen."'";
$nro_salida=obtenerCodigo($sql);


$sql="insert into salidas set ";
$sql.=" cod_salida='".$cod_salida."',"; 
$sql.=" fecha_salida='".date('Y/m/d', time())."',"; 
$sql.=" cod_usuario_salida='".$_COOKIE['usuario_global']."',";
$sql.=" cod_almacen='".$cod_almacen."',";
$sql.=" cod_gestion='".$cod_gestion."',"; 
$sql.=" nro_salida='".$nro_salida."',"; 
$sql.=" cod_tipo_salida='".$cod_tipo_salida."',";
$sql.=" cod_estado_salida='".$cod_estado_salida."',";
if($cod_tipo_salida==1){
	$sql.=" cod_cliente_venta=".$cod_cliente_venta.",";
	if($cod_contacto<>0){
		$sql.=" cod_contacto=".$cod_contacto.",";
	}
	$sql.=" cod_tipo_pago=".$cod_tipo_pago.",";
	$sql.=" cod_estado_pago_doc=1,";
	
}

if($cod_tipo_salida==2 or  $cod_tipo_salida==4){
	$sql.=" cod_hoja_ruta='".$cod_hoja_ruta."',";
}
if($cod_tipo_salida==3){
	$sql.=" cod_almacen_traspaso='".$cod_almacen_traspaso."',";
	
}
if($cod_tipo_salida==5){
	$sql.=" cod_orden_trabajo='".$cod_orden_trabajo."',";
	
}
if($cod_tipo_salida==6){
	$sql.=" cod_area='".$_POST['cod_area']."',";
	$sql.=" cod_usuario='".$_POST['cod_usuario']."',";
	
	
}
 
$sql.=" obs_salida='".$obs_salida."'";
//echo $sql;

mysql_query($sql);


$sql="select cod_salida from ingresos where cod_salida=".$cod_salida;
$resp=mysql_query($sql);
while($dat=mysql_fetch_array($resp)){
	$cod_salida=$dat[0];
}	
//echo "cod_salida=".$cod_salida;

if($cod_salida<>""){

	/*if($_POST['cod_tipo_salida']==1){
		$sql3="select cod_cuenta, nombre_cliente from clientes where cod_cliente=".$_POST['cod_cliente_venta'];
		$resp3 = mysql_query($sql3);
		while($dat3=mysql_fetch_array($resp3)){	
			$cod_cuenta=$dat3['cod_cuenta'];
			$nombre_cliente=$dat3['nombre_cliente'];		
		}
		if($cod_cuenta==NULL or $cod_cuenta=="" ){	
			$sql=" select max(cod_cuenta) from cuentas ";
			$cod_cuenta=obtenerCodigo($sql);
			$sql="insert into cuentas set ";
			$sql.=" cod_cuenta='".$cod_cuenta."',"; 
			$sql.=" nro_cuenta=0,"; 
			$sql.=" desc_cuenta='".$nombre_cliente."',"; 
			$sql.=" cod_moneda='1',"; 
			$sql.=" cod_estado_registro=1,"; 
			$sql.=" cod_usuario_registro='".$_COOKIE['usuario_global']."',";
			$sql.=" fecha_registro='".date('Y-m-d H:i:s', time())."'";
			mysql_query($sql);
			$sql=" update clientes set ";
			$sql.=" cod_cuenta=".$cod_cuenta;
			$sql.=" where cod_cliente=".$_POST['cod_cliente_venta'];
			mysql_query($sql);
		}

	}*/


	for($i = 1;$i <=$num ;$i++) {	
		
		////////////////////////////////////////////////////	
		$cod_material=$_POST['cod_material'.$i];
		$cant_salida=$_POST['cantidad'.$i];
		
		if($cod_tipo_salida==1){
			$precio_venta=$_POST['precioVenta'.$i];
		}else{
			$precio_venta="0";
		}
			
		
		
		 if($cod_material<>"" and $cant_salida<>"" and $precio_venta<>""){

				$sql3=" insert into salidas_detalle set ";
				$sql3.=" cod_salida='".$cod_salida."',";
				$sql3.=" cod_material='".$cod_material."',";
				$sql3.=" cant_salida='".$cant_salida."',";
				$sql3.=" precio_venta='".$precio_venta."'";	
			//	echo $sql3;		
				mysql_query($sql3);
				$cant_salida2=$cant_salida;
		
				$sql4=" select id.cod_ingreso,i.fecha_ingreso,id.cod_ingreso_detalle,id.cant_actual,id.precio_compra_uni "; 
				$sql4.=" from ingresos_detalle id,ingresos i ";
				$sql4.=" where id.cod_material=".$cod_material."";
				$sql4.=" and id.cant_actual>0 ";
				$sql4.=" and id.cod_ingreso=i.cod_ingreso";
				$sql4.=" and i.cod_estado_ingreso<>2";
				$sql4.=" order by i.fecha_ingreso,id.cod_ingreso,id.cod_ingreso_detalle asc";
				//echo $sql4."<br>";
				$resp4=mysql_query($sql4);
				$bandera=0;
		
				while(($dat4=mysql_fetch_array($resp4)) && ($bandera==0)){
			
					$cod_ingreso=$dat4[0];
					$fecha_ingreso=$dat4[1];
					$cod_ingreso_detalle=$dat4[2];
				//	echo "cod_ingreso_detalle=".$cod_ingreso_detalle."<br>";
					$cant_actual=$dat4[3];
					$precio_compra_uni=$dat4[4];
			
				
					$sql5=" update ingresos_detalle set ";	
					if($cant_actual>=$cant_salida2){
						$bandera=1;			
						$sql5.=" cant_actual='".($cant_actual-$cant_salida2)."'";
					}else{
						$sql5.=" cant_actual=0";
					}
					$sql5.=" where cod_ingreso_detalle=".$cod_ingreso_detalle;
					$sql5.=" and cod_material=".$cod_material;
				//echo "<br>".$sql5;
					mysql_query($sql5);
				
				
						$sql6=" insert into salidas_detalle_ingresos set  ";
						$sql6.=" cod_salida=".$cod_salida.",";
						$sql6.=" cod_material=".$cod_material.",";
						$sql6.=" cod_ingreso_detalle=".$cod_ingreso_detalle.",";
						if($bandera==1){
							$sql6.=" cant_salida_ingreso=".$cant_salida2;
						}else{
						
							$sql6.=" cant_salida_ingreso=".$cant_actual;
							$cant_salida2=$cant_salida2-$cant_actual;
						}
						mysql_query($sql6);
						//echo $sql6."<br/>";
						//echo "canta salida=".$cant_salida2."<br/>";
									
				}	
		
		///////////////////////////////////////////////	
		
		 if($cod_tipo_salida==3){
		 		$cod_tipo_ingreso=2;
				$cod_estado_ingreso=1;
				$obs_ingreso="Traspaso";
		 		$sql=" select max(cod_ingreso) from ingresos ";
				$cod_ingreso=obtenerCodigo($sql);
				$sql="select max(nro_ingreso) from ingresos where cod_gestion='".$cod_gestion."' ";
				$sql.=" and cod_almacen='".$cod_almacen_traspaso."'";
				$nro_ingreso=obtenerCodigo($sql);
				
				$sql="insert into ingresos set ";
				$sql.=" cod_ingreso='".$cod_ingreso."',"; 
				$sql.=" fecha_ingreso='".date('Y/m/d', time())."',"; 
				$sql.=" cod_usuario_ingreso='".$_COOKIE['usuario_global']."',";				
				$sql.=" cod_almacen='".$cod_almacen_traspaso."',";
				$sql.=" cod_gestion='".$cod_gestion."',"; 
				$sql.=" nro_ingreso='".$nro_ingreso."',"; 
				$sql.=" cod_tipo_ingreso='".$cod_tipo_ingreso."',"; 
				$sql.=" cod_salida='".$cod_salida."',"; 
				$sql.=" obs_ingreso='".$obs_ingreso."',";
				$sql.=" cod_estado_ingreso='".$cod_estado_ingreso."'";	
			//	echo $sql."<br>";
				mysql_query($sql);			
		 	//	echo "traspaso";
				
				///Detalle Ingreso
				
				$sql="select sdi.cod_material, sdi.cod_ingreso_detalle,id.precio_compra_uni,";
				$sql.=" sdi.cant_salida_ingreso ";
				$sql.=" from salidas_detalle_ingresos  sdi, ingresos_detalle id";
				$sql.=" where sdi.cod_salida=".$cod_salida;
				$sql.=" and sdi.cod_ingreso_detalle=id.cod_ingreso_detalle";
				$resp=mysql_query($sql);				
				while($dat=mysql_fetch_array($resp)){
					$cod_material=$dat[0];
					$cod_ingreso_detalle_salida=$dat[1];
					$precio_compra_uni=$dat[2];
					$cant_salida_ingreso=$dat[3];
					
					$sql3=" select max(cod_ingreso_detalle) from ingresos_detalle ";
					$cod_ingreso_detalle=obtenerCodigo($sql3);
				
					$sql3="insert into ingresos_detalle set";
					$sql3.=" cod_ingreso_detalle='".$cod_ingreso_detalle."',";
					$sql3.=" cod_ingreso='".$cod_ingreso."',";
					$sql3.=" cod_material='".$cod_material."',";
					$sql3.=" precio_compra_uni='".$precio_compra_uni."',";	
					$sql3.=" cantidad='".$cant_salida_ingreso."',";	
					$sql3.=" cant_actual='".$cant_salida_ingreso."'";				
				//	echo "sql3".$sql3."<br>";
					mysql_query($sql3);					
				
				
				
				}

				//Fin Detalle Ingreso
		 }	
		////fin Item Existente
		}				
	}					
}
	if($_POST['cod_tipo_salida']==1){
	///CREACION DE CUENTA////
	$sql3=" select cod_cliente_venta from salidas where cod_salida=".$cod_salida;
	$resp3 = mysql_query($sql3);
	while($dat3=mysql_fetch_array($resp3)){	
		$cod_cliente=$dat3['cod_cliente_venta'];
	}
	$sql3="select  nombre_cliente from clientes where cod_cliente=".$cod_cliente;

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
	$resp3 = mysql_query($sql3);
	while($dat3=mysql_fetch_array($resp3)){	
		$cod_cuenta_padre_conf=$dat3['cod_cuenta_padre'];
	}		
	$fechaFinal=date('Y-m-d', time());
	//echo "parametro=".$parametro2."<br/>";
	$fechaInicio=date('Y-m-d', strtotime(-$parametro2."month"));
		//echo "$fechaInicio=".$fechaInicio."<br/>";
	//echo "$fechaFinal=".$fechaFinal."<br/>";

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
	//echo $sql3."<br/>";
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
	
	//echo "nroDoc:".$nroDoc."<br/>";
	//echo "parametro1:".$parametro1."<br/>";

	if($nroDoc>=$parametro1){
	//echo "entro por verdad parametro=".$parametro1;;
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
				//echo $sql."<br/>";
				mysql_query($sql);
				$sql=" update clientes set ";
				$sql.=" cod_cuenta=".$cod_cuenta_nueva;
				$sql.=" where cod_cliente=".$cod_cliente;
				mysql_query($sql);		
			}
	}else{
	//echo "entro por falso";
		if($cod_cuenta==NULL or $cod_cuenta=="" ){
			$sql=" update clientes set ";
			$sql.=" cod_cuenta=".$cod_cuenta_conf;
			$sql.=" where cod_cliente=".$cod_cliente;
			mysql_query($sql);
		}
	
	}

	}


require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listSalidas.php?cod_almacen=<?php echo $cod_almacen;?>";
</script>