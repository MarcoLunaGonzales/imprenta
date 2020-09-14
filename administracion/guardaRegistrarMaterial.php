<?php
require("conexion.inc");
include("funciones.php");

$cod_grupo=$_POST['cod_grupo'];
$cod_subgrupo=$_POST['cod_subgrupo'];
$nombre_material=$_POST['nombre_material'];
$cod_unidad_medida=$_POST['cod_unidad_medida'];
$stock_minimo=$_POST['stock_minimo'];
$stock_maximo=$_POST['stock_maximo'];
$cod_estado_registro=1;

///////////////////////
	$sql3=" select  nombre_subgrupo from subgrupos where  cod_subgrupo=".$cod_subgrupo;
	$resp3=mysql_query($sql3);
	while($dat3=mysql_fetch_array($resp3)){
		$nombre_subgrupo=$dat3[0];
	}
	$sql3=" select  nombre_grupo from grupos where  cod_grupo=".$cod_grupo;
	$resp3=mysql_query($sql3);
	while($dat3=mysql_fetch_array($resp3)){
		$nombre_grupo=$dat3[0];
	}
	$sql3=" select max(idMaterial) from materiales where cod_subgrupo=".$cod_subgrupo;
	$idMaterial=obtenerCodigo($sql3);
/////////////////////////

$sql=" select max(cod_material) from materiales ";
$cod_material=obtenerCodigo($sql);

$sql="insert into materiales set ";
$sql.=" cod_material='".$cod_material."',"; 
$sql.=" nombre_material='".$nombre_material."',"; 
$sql.=" desc_completa_material='".$nombre_material."',"; 
$sql.=" cod_subgrupo='".$cod_subgrupo."',";
$sql.=" cod_unidad_medida='".$cod_unidad_medida."',";
$sql.=" stock_minimo='".$stock_minimo."',";
$sql.=" stock_maximo='".$stock_maximo."',";
$sql.=" cod_usuario_registro='".$_COOKIE['usuario_global']."',"; 
$sql.=" fecha_registro='".date('Y/m/d', time())."',"; 
$sql.=" cod_estado_registro='".$cod_estado_registro."',";
$sql.=" idMaterial=".$idMaterial.","; 
$sql.=" idMaterialDesc='".$nombre_grupo[0].$nombre_grupo[1].$nombre_grupo[2]."-".$nombre_subgrupo[0].$nombre_subgrupo[1].$nombre_subgrupo[2]."-".$idMaterial."'";
mysql_query($sql);


$sql2=" select cod_grupo_carac from grupos_caracteristicas ";
$sql2.=" where cod_estado_registro=1  and cod_grupo=".$cod_grupo;
$resp2=mysql_query($sql2);
while($dat2=mysql_fetch_array($resp2))
{				
	$cod_grupo_carac=$dat2[0];	
	$nombre_grupo_carac=$dat2[1];	
	
	if($_POST[$cod_grupo_carac]<>""){

		$sql3="insert into materiales_grupos_caracteristicas set";
		$sql3.=" cod_material='".$cod_material."',";
		$sql3.=" cod_grupo_carac='".$cod_grupo_carac."',";
		$sql3.=" desc_material_grupo_caracteristica='".$_POST[$cod_grupo_carac]."'";
		mysql_query($sql3);
	
	}  
	

}
$desc_completa_material=$nombre_material;
$sql3=" SELECT mgc.desc_material_grupo_caracteristica,gc.nombre_grupo_carac, gc.orden ";
$sql3.=" FROM grupos_caracteristicas gc, materiales_grupos_caracteristicas mgc ";
$sql3.=" where mgc.cod_material='".$cod_material."'";
$sql3.=" and gc.cod_grupo_carac=mgc.cod_grupo_carac ";
$sql3.=" order by gc.orden asc ";
	
$resp3= mysql_query($sql3);
while($dat3=mysql_fetch_array($resp3)){
	$desc_material_grupo_caracteristica=$dat3[0];
	$nombre_grupo_carac=$dat3[1];
	$orden=$dat3[2];
						
	$desc_completa_material=$desc_completa_material." ".$desc_material_grupo_caracteristica;
}	
					
$sql="update  materiales set ";
$sql.=" desc_completa_material='".$desc_completa_material."'"; 
$sql.=" where cod_material='".$cod_material."'"; 
mysql_query($sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorMateriales.php";
</script>