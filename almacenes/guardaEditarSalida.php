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


$sql=" select cod_material, cod_ingreso_detalle , cant_salida_ingreso";
$sql.=" from salidas_detalle_ingresos";
$sql.=" where cod_salida='".$cod_salida."'";
$sql.=" order by cod_material, cod_ingreso_detalle";
$resp= mysql_query($sql);
while($dat=mysql_fetch_array($resp)){
		$cod_material=$dat[0]; 
		$cod_ingreso_detalle=$dat[1];
		$cant_salida_ingreso=$dat[2];
		
		$sql2="select cant_actual ";
		$sql2.=" from ingresos_detalle";
		$sql2.=" where cod_ingreso_detalle='".$cod_ingreso_detalle."'";
		$sql2.= "and cod_material='".$cod_material."'";
		$resp2= mysql_query($sql2);
		while($dat2=mysql_fetch_array($resp2)){
			$cant_actual=$dat2[0];
			
			$sql3=" update ingresos_detalle set ";
			$sql3.=" cant_actual=".($cant_actual+$cant_salida_ingreso);
			$sql3.=" where cod_ingreso_detalle='".$cod_ingreso_detalle."'";
			$sql3.=" and cod_material='".$cod_material."'";
			mysql_query($sql3);
		}
				
}





$sql="update salidas set ";
if($cod_tipo_salida==1){
	$sql.=" cod_cliente_venta=".$cod_cliente_venta.",";
	if($cod_contacto<>0){
		$sql.=" cod_contacto=".$cod_contacto.",";
	}else{
		$sql.=" cod_contacto=0,";
	}
	$sql.=" cod_tipo_pago=".$cod_tipo_pago.",";
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
$sql.=" obs_salida='".$obs_salida."'";
$sql.=" where cod_salida='".$cod_salida."'"; 
//echo $sql;

mysql_query($sql);


//echo "cod_salida=".$cod_salida;

if($cod_salida<>""){
		$sql3=" delete from  salidas_detalle where  cod_salida='".$cod_salida."'";
		mysql_query($sql3);
		$sql3=" delete from  salidas_detalle_ingresos where  cod_salida='".$cod_salida."'";
		mysql_query($sql3);		
				
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
				mysql_query($sql3);
				$cant_salida2=$cant_salida;
		
				$sql4=" select id.cod_ingreso,i.fecha_ingreso,id.cod_ingreso_detalle,id.cant_actual,id.precio_compra_uni "; 
				$sql4.=" from ingresos_detalle id,ingresos i ";
				$sql4.=" where id.cod_material=".$cod_material."";
				$sql4.=" and id.cant_actual>0 ";
				$sql4.=" and id.cod_ingreso=i.cod_ingreso";
				$sql4.=" order by i.fecha_ingreso,id.cod_ingreso,id.cod_ingreso_detalle asc";
			//	echo $sql4."<br>";
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
			//		echo "<br>".$sql5;
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

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listSalidas.php?cod_almacen=<?php echo $cod_almacen;?>";
</script>