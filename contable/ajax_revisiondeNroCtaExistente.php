<?php header("Cache-Control: no-store, no-cache, must-revalidate");?>
<?php
	require("conexion.inc");
if($_GET['nro_cuenta']<>""){

	$sql2=" select count(*) from cuentas where nro_cuenta like '%".$_GET['nro_cuenta']."%'";
   	$resp2 = mysql_query($sql2);	
	$existe=0;
	while($dat2=mysql_fetch_array($resp2)){
		$existe=$dat2[0];
	}
	
	if($existe>0){
?>
<p style="background-color:#FF9">Alerta!!!</p>
<?php		
		$sql2=" select nro_cuenta, desc_cuenta from cuentas where nro_cuenta like'%".$_GET['nro_cuenta']."%'";
	   	$resp2 = mysql_query($sql2);	
		
		while($dat2=mysql_fetch_array($resp2)){
			$nro_cuenta=$dat2['nro_cuenta'];
			$desc_cuenta=$dat2['desc_cuenta'];
?>
<p style="background-color:#FFFFFF"><?php echo $nro_cuenta." ".$desc_cuenta;?></p>
<?php	
		}
	
		
	}
	
}
?>