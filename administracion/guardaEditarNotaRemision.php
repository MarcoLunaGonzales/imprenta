<?php
require("conexion.inc");
include("funciones.php");


$cod_hoja_ruta = $_POST['cod_hoja_ruta'];
$cod_nota_remision = $_POST['cod_nota_remision'];
$cod_usuario_entregado_por = $_POST['cod_usuario_entregado_por'];
$recibido_por = $_POST['recibido_por'];

$sql="select cod_cotizacion from hojas_rutas where cod_hoja_ruta='".$cod_hoja_ruta."'";
$resp= mysql_query($sql);			
$dat=mysql_fetch_array($resp);
$cod_cotizacion=$dat[0];
						



$sql=" update notas_remision set  ";
$sql.=" cod_usuario_entregado_por=".$cod_usuario_entregado_por.",";
$sql.=" recibido_por='".$recibido_por."', "; 
$sql.=" obs_nota_remision='".$obs_nota_remision."', ";
$sql.=" cod_usuario_modifica='".$_COOKIE['usuario_global']."',";
$sql.=" fecha_modifica='".date('Y/m/d', time())."'";
$sql.=" where cod_nota_remision='".$cod_nota_remision."'";

mysql_query($sql);


$vectorCotizacionDetalle = $_POST['vectorCotizacionDetalle'];
$vectorCantidadesAEntregar = $_POST['vectorCantidadesAEntregar'];
	
$vectorCotizacionDetalle_2=explode(",",$vectorCotizacionDetalle);
$vectorCantidadesAEntregar_2=explode(",",$vectorCantidadesAEntregar);
$n=sizeof($vectorCotizacionDetalle_2);	
	

$sql=" delete from notas_remision_detalle where cod_nota_remision='".$cod_nota_remision."'";
mysql_query($sql);	
		
	for($i=0;$i<$n;$i++){	

		$sql= " insert into notas_remision_detalle set ";
		$sql.=" cod_nota_remision='".$cod_nota_remision."',";
		$sql.=" cod_cotizacion='".$cod_cotizacion."',";
		$sql.=" cod_cotizaciondetalle='".$vectorCotizacionDetalle_2[$i]."',";
		$sql.=" cantidad='".$vectorCantidadesAEntregar_2[$i]."'";
		mysql_query($sql);
	}	
///Cambiar Estado de Hoja ruta
	
	$bandera=0;
	$sql3="select hrd.cod_cotizacion, hrd.cod_cotizaciondetalle, cd.cantidad_unitariacotizacion ";
	$sql3.=" from hojas_rutas_detalle hrd, cotizaciones_detalle cd ";
	$sql3.=" where hrd.cod_hoja_ruta=".$cod_hoja_ruta;
	$sql3.=" and hrd.cod_cotizacion=cd.cod_cotizacion ";
	$sql3.=" and hrd.cod_cotizaciondetalle=cd.cod_cotizaciondetalle ";	
	$resp3=mysql_query($sql3);
	$sw=1;	
	//echo "sql3=".$sql3."<br>";
	while($sw==1 and ($dat3=mysql_fetch_array($resp3))){
	// echo "holaaaaaaaaaaa";
			$bandera=1;
			$cod_cotizacion=$dat3[0];
			$cod_cotizaciondetalle=$dat3[1];
			$cantidad_unitariacotizacion=$dat3[2];
			////////////////////////////////////////////
			$sql4=" select  sum(cantidad)";
			$sql4.=" from notas_remision_detalle ";
			$sql4.=" where cod_nota_remision in(select cod_nota_remision from notas_remision where cod_estado_nota_remision=1 ";
			$sql4.=" and cod_hoja_ruta='".$cod_hoja_ruta."') ";
			$sql4.=" and cod_cotizacion='".$cod_cotizacion."' ";
			$sql4.=" and cod_cotizaciondetalle='".$cod_cotizaciondetalle."' ";
			//echo "sql4=".$sql4."<br>";
			$resp4=mysql_query($sql4);
			$cantEntregada=0;			
			while($dat4=mysql_fetch_array($resp4)){
					$cantEntregada=$dat4[0];										
			}	
			if($cantEntregada>=$cantidad_unitariacotizacion){
				$sw=1;
			}else{
				$sw=0;
			}
			//////////////////////////////////////////////////
	}	
	if($bandera==1){
		if($sw==1){				
			$sql="update  hojas_rutas set ";
			$sql.=" cod_estado_hoja_ruta=3"; 
			$sql.=" where cod_hoja_ruta='".$cod_hoja_ruta."'"; 
			//echo $sql."<br>";
			mysql_query($sql);
		}
	}
///Fin Cambiar Estado de Hoja ruta		
?>
<script language="JavaScript">				
	location.href="navegadorNotasRemision.php";
</script>
