<?php
require("conexion.inc");
include("funciones.php");
set_time_limit(0);
/*$sql=" delete from bingo_detalle ";
mysql_query($sql);
$sql=" delete from bingo ";
mysql_query($sql);*/
mt_srand (time());


//echo "nro_cartones=".$_POST['nro_cartones'];
for ( $g = 1 ; $g <= $_POST['nro_cartones'] ; $g ++) {

	$sql=" select max(cod_bingo) from bingo ";
	$cod_bingo=obtenerCodigo($sql);

	$sql="insert into bingo set ";
	$sql.=" cod_bingo='".$cod_bingo."',"; 
	$sql.=" desc_bingo=' Carton Nro ".$cod_bingo."'";
	 
	mysql_query($sql);
	//echo $sql."<br/>";
	$inicio=1;
	$final=15;
	
	for ( $i = 1 ; $i <= 5 ; $i ++) {
		$numero="";
		$n=0;
		if($i==3){
			$stop=4;
		}else{
			$stop=5;
		}

		while ($n<$stop){

	
			$sql2=" insert into bingo_detalle set ";
			$sql2.=" cod_bingo='".$cod_bingo."',"; 
			$sql2.=" cod_bingo_detalle='".mt_rand($inicio,$final)."'"; 
		//	echo $sql2."<br/>";
			if(mysql_query($sql2)){
				$n=$n+1;
				
			}
		}
	$inicio=$inicio+15;
    $final=$final+15;
	}
	$sql3="select cod_bingo_detalle from bingo_detalle where cod_bingo='".$cod_bingo."' order by cod_bingo_detalle asc";
	$resp3 = mysql_query($sql3);
	$numero_bingo="";
	while($dat3=mysql_fetch_array($resp3)){
		$cod_bingo_detalle=$dat3['cod_bingo_detalle'];
		$numero_bingo=$numero_bingo.$cod_bingo_detalle."|";
	}
	
	$sql4="select  count(*) from bingo where numero_bingo='".$numero_bingo."'";
	$resp4 = mysql_query($sql4);
	$cant_repetidos=0;
	while($dat4=mysql_fetch_array($resp4)){
		$cant_repetidos=$dat4['0'];
	}
	
	if($cant_repetidos==0){
	
		$sql5=" update bingo set ";
		$sql5.=" numero_bingo='".$numero_bingo."'";
		$sql5.=" where cod_bingo='".$cod_bingo."'"; 	 
		mysql_query($sql5);
	}else{
		
		$sql6=" delete from bingo_detalle where cod_bingo=".$cod_bingo.""; 
		mysql_query($sql6);
		$sql7=" delete from bingo where cod_bingo=".$cod_bingo.""; 
		mysql_query($sql7);
	}

}

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listBingo.php";
</script>