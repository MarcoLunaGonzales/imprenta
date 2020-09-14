<?php
require("conexion.inc");
include("funciones.php");

$cod_salida=$_POST['cod_salida'];
$obs_anular=$_POST['obs_anular'];
$cod_estado_salida=2;



$sql=" update salidas set ";
$sql.=" obs_anulacion='".$obs_anular."', ";
$sql.=" cod_estado_salida='".$cod_estado_salida."' ";
$sql.=" where cod_salida='".$cod_salida."'";
mysql_query($sql);

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






require("cerrar_conexion.inc");
?>
<script language="JavaScript">
	opener.location.reload();
	window.close();
</script>