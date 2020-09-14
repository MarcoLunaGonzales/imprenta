<?php 
require("conexion.inc");
include("funciones.php");
$cod_grupo=$_GET['cod_grupo'];
$cod_subgrupo=$_GET['cod_subgrupo'];

$sql2=" select  nombre_grupo from grupos where  cod_grupo=".$cod_grupo;
$resp2=mysql_query($sql2);
while($dat2=mysql_fetch_array($resp2)){
	$nombre_grupo=$dat2[0];
}

$sql2=" select  nombre_subgrupo from subgrupos where  cod_subgrupo=".$cod_subgrupo;
$resp2=mysql_query($sql2);
while($dat2=mysql_fetch_array($resp2)){
	$nombre_subgrupo=$dat2[0];
}
				
$sql=" select max(idMaterial) from materiales where cod_subgrupo=".$cod_subgrupo;
$idMaterial=obtenerCodigo($sql);
	if($idMaterial<10){
		$idMaterialDesc="0000".$idMaterial;
	}
	if($idMaterial>=10 and $idMaterial<100 ){
		$idMaterialDesc="000".$idMaterial;
	}
	if($idMaterial>=100 and $idMaterial<1000 ){
		$idMaterialDesc="00".$idMaterial;
	}
	if($idMaterial>=1000 and $idMaterial<9999 ){
		$idMaterialDesc="0".$idMaterial;
	}
	if($idMaterial>=10000){
		$idMaterialDesc=$idMaterial;
	}

		

echo $nombre_grupo[0].$nombre_grupo[1].$nombre_grupo[2]."-".$nombre_subgrupo[0].$nombre_subgrupo[1].$nombre_subgrupo[2]."-".$idMaterialDesc;		
?>


