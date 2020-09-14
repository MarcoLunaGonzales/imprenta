<?php
require("conexion.inc");
include("funciones.php");

$cod_hoja_ruta = $_POST['cod_hoja_ruta'];

$sql="select cod_cotizacion from hojas_rutas where cod_hoja_ruta='".$cod_hoja_ruta."'";
$resp= mysql_query($sql);
while($dat=mysql_fetch_array($resp)){
	$cod_cotizacion=$dat[0];
}

$vectorCotizacionDetalle = $_POST['vectorCotizacionDetalle'];
//echo "Vector Cotizacion Detalle".$vectorCotizacionDetalle."<br>";
$vectorUsuariosDiseno = $_POST['vectorUsuariosDiseno'];
//echo "Vector vectorUsuariosDiseno".$vectorUsuariosDiseno."<br>";
$vectorMaquinaria = $_POST['vectorMaquinaria'];
//echo "Vector vectorMaquinaria".$vectorMaquinaria."<br>";
$vectorObservaciones = $_POST['vectorObservaciones'];
//echo "Vector vectorObservaciones".$vectorObservaciones."<br>";

	
$vectorCotizacionDetalle_2=explode(",",$vectorCotizacionDetalle);
$vectorUsuariosDiseno_2=explode(",",$vectorUsuariosDiseno);
$vectorMaquinaria_2=explode(",",$vectorMaquinaria);
$vectorObservaciones_2=explode(",",$vectorObservaciones);	
$n=sizeof($vectorCotizacionDetalle_2);	
	
for($i=0;$i<$n;$i++){	
		//echo "Itmeeeeeeeee".$i;
		$cod_cotizaciondetalle=$vectorCotizacionDetalle_2[$i];
		//echo "cod_cotizaciondetalle=".$cod_cotizaciondetalle."<br>";
		$cod_usuario_diseno=$vectorUsuariosDiseno_2[$i];		
		//echo "cod_usuario_diseno=".$cod_usuario_diseno."<br>";
		$obs_trabajo=$vectorObservaciones_2[$i];
		//echo "obs_trabajo=".$obs_trabajo."<br>";
		
	

		$sql= " update  cotizaciones_detalle set ";
		$sql.=" cod_usuario_diseno='".$cod_usuario_diseno."',";
		$sql.=" obs_trabajo='".$obs_trabajo."'";
		$sql.=" where cod_cotizacion='".$cod_cotizacion."'";
		$sql.=" and cod_cotizaciondetalle='".$cod_cotizaciondetalle."'";
		//echo "sql=".$sql."<br>";
		mysql_query($sql);
		
		
		$vectorMaquinaria_3=explode("|",$vectorMaquinaria_2[$i]);
		$longitud=sizeof($vectorMaquinaria_3);	
		for($j=0;$j<$longitud-1;$j++){
			
			$cod_maquina=$vectorMaquinaria_3[$j];
			//echo "cod_maquina=".$cod_maquina."<br>";
			$sql=" insert into cotizaciones_detalle_maquinaria set ";
			$sql.=" cod_cotizacion='".$cod_cotizacion."',";
			$sql.=" cod_cotizaciondetalle='".$cod_cotizaciondetalle."',";
			$sql.=" cod_maquina='".$cod_maquina."'";
		//	echo "sql=".$sql."<br>";
			mysql_query($sql);
		}

}	
	

?>
		
<script language="JavaScript">				
	location.href="navegadorHojasRutas.php";
</script>

