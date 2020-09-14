<?php
require("conexion.inc");
include("funciones.php");
	set_time_limit(1200);


$sql=" select sdi.cod_salida, sdi.cod_material, sdi.cod_ingreso_detalle, ";
$sql.=" sdi.cant_salida_ingreso, sdi.costo_material ";
$sql.=" from salidas_detalle_ingresos sdi";
$resp=mysql_query($sql);				
echo "INICIANDO PROCESO OBTENIEDO COSTOS POR MATERIAL <BR/>";
$contador=0;
while($dat=mysql_fetch_array($resp)){
	$contador=$contador+1;

	$cod_salida=$dat['cod_salida'];
	$cod_material=$dat['cod_material'];
	$cod_ingreso_detalle=$dat['cod_ingreso_detalle'];
	$cant_salida_ingreso=$dat['cant_salida_ingreso'];
	$costo_material=$dat['costo_material'];
	echo "contador= ".$contador." material=".$cod_material."<br/>";
	
	$sql2="select precio_compra_uni ";
	$sql2.=" from ingresos_detalle ";
	$sql2.=" where cod_ingreso_detalle=".$cod_ingreso_detalle;
	$sql2.=" and cod_material=".$cod_material;
	$resp2=mysql_query($sql2);	
	$precio_compra_uni=0;			
	while($dat2=mysql_fetch_array($resp2)){
		$precio_compra_uni=$dat2['precio_compra_uni'];
	}
	$sql3="update salidas_detalle_ingresos set costo_material=".$precio_compra_uni." ";
	$sql3.=" where cod_salida=".$cod_salida;
	$sql3.=" and cod_material=".$cod_material;
	$sql3.=" and cod_ingreso_detalle=".$cod_ingreso_detalle;		
	mysql_query($sql3);
}
echo "ACTUALIZANDO COSTOS TOTATES DEL DETALLEPOR MATERIAL <BR/>";
$contador=0;

$sql=" select cod_salida,cod_material,cant_salida,costo_material_tot, precio_venta ";
$sql.=" from salidas_detalle ";
$resp=mysql_query($sql);				
while($dat=mysql_fetch_array($resp)){
	$contador=$contador+1;
	$cod_salida=$dat['cod_salida'];
	$cod_material=$dat['cod_material'];
	$cant_salida=$dat['cant_salida'];
	$costo_material_tot=$dat['costo_material_tot'];
	$precio_venta=$dat['precio_venta'];
	echo "contador= ".$contador." material=".$cod_material."<br/>";
		$sql2=" select SUM(costo_material*cant_salida_ingreso) from salidas_detalle_ingresos ";
		$sql2.=" where cod_salida=".$cod_salida;
		$sql2.=" and cod_material=".$cod_material;
		$resp2=mysql_query($sql2);			
		$totMaterial=0;	
		while($dat2=mysql_fetch_array($resp2)){
			$totMaterial=$dat2[0];
		}
		$sql3="update salidas_detalle set costo_material_tot=".$totMaterial." ";
		$sql3.=" where cod_salida=".$cod_salida;
		$sql3.=" and cod_material=".$cod_material;
		mysql_query($sql3);

}
?>
<table border="1" cellpadding="0" cellspacing="1">
<tr><td>nro</td<td>Salida</td><td>Material</td><td>Cantidad</td><td>Costo</td>
<td>Detalle</td>
</tr>
<?php
$sql=" select cod_salida,cod_material,cant_salida,costo_material_tot, precio_venta ";
$sql.=" from salidas_detalle ";
$resp=mysql_query($sql);		
$contador=0;		
while($dat=mysql_fetch_array($resp)){
	$contador=$contador+1;
	$cod_salida=$dat['cod_salida'];
	$cod_material=$dat['cod_material'];
			$sql2="select s.nro_salida, g.gestion from salidas s inner join gestiones g on (s.cod_gestion=g.cod_gestion) where s.cod_salida=".$cod_salida;
			$resp2=mysql_query($sql2);			
		$nro_salida="";	
		$gestion="";
		while($dat2=mysql_fetch_array($resp2)){
			$nro_salida=$dat2['nro_salida'];
			$gestion=$dat2['gestion'];
			
		}
	
		$sql2="select desc_completa_material from materiales where cod_material=".$cod_material;
			$resp2=mysql_query($sql2);			
		$desc_completa_material='';	
		while($dat2=mysql_fetch_array($resp2)){
			$desc_completa_material=$dat2['desc_completa_material'];
		}
	$cant_salida=$dat['cant_salida'];
	$costo_material_tot=$dat['costo_material_tot'];
	$precio_venta=$dat['precio_venta'];
?>
	<tr>
			<td><?php echo $contador; ?></td>
		<td><?php echo $cod_salida." (".$nro_salida."/".$gestion." )"; ?></td>
		<td><?php echo $cod_material." ".$desc_completa_material; ?></td>
		<td><?php echo $cant_salida; ?></td>
		<td><?php echo $costo_material_tot; ?></td>
		<td>
		<?php
			$sql5=" select  sdi.cod_ingreso_detalle, ";
			$sql5.=" sdi.cant_salida_ingreso, sdi.costo_material ";
			$sql5.=" from salidas_detalle_ingresos sdi";
			$sql5.=" where sdi.cod_salida=".$cod_salida." and sdi.cod_material=".$cod_material;
			$resp5=mysql_query($sql5);				
			while($dat5=mysql_fetch_array($resp5)){

			$cod_ingreso_detalle=$dat5['cod_ingreso_detalle'];
			$cant_salida_ingreso=$dat5['cant_salida_ingreso'];
			$costo_material=$dat5['costo_material'];

			echo "datos: ".$cant_salida_ingreso."//".$costo_material."<br/>";

			}
		?>
		</td>
	</tr>
<?php
}
?>
</table>
