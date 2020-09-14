<?php
require("conexion.inc");
include("funciones.php");


$cod_nota_remision = $_GET['cod_nota_remision'];

$sql=" update notas_remision set  ";
$sql.=" cod_usuario_anulacion='".$_COOKIE['usuario_global']."',";
$sql.=" cod_estado_nota_remision=2";
$sql.=" where cod_nota_remision='".$cod_nota_remision."'";
mysql_query($sql);

$sql="select cod_hoja_ruta from notas_remision where cod_nota_remision=".$cod_nota_remision;
$resp=mysql_query($sql);
while($dat=mysql_fetch_array($resp)){
	$cod_hoja_ruta=$dat[0];
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
