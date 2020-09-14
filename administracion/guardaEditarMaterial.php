<?php
require("conexion.inc");
include("funciones.php");

$cod_material=$_POST['cod_material'];

$sql="select cod_subgrupo from materiales where cod_material=".$cod_material;
$resp=mysql_query($sql);
while($dat=mysql_fetch_array($resp))
{		
	$cod_subgrupo=$dat[0];
}



$nombre_material=$_POST['nombre_material'];
$cod_unidad_medida=$_POST['cod_unidad_medida'];
$stock_minimo=$_POST['stock_minimo'];
$stock_maximo=$_POST['stock_maximo'];
$cod_estado_registro=$_POST['cod_estado_registro'];

$sql="select cod_grupo from subgrupos where cod_subgrupo='".$cod_subgrupo."'";
$resp=mysql_query($sql);
while($dat=mysql_fetch_array($resp))
{		
	$cod_grupo=$dat[0];
}



$sql="update  materiales set ";
$sql.=" nombre_material='".$nombre_material."',"; 
$sql.=" cod_unidad_medida='".$cod_unidad_medida."',";
$sql.=" stock_minimo='".$stock_minimo."',";
$sql.=" stock_maximo='".$stock_maximo."',";
$sql.=" cod_usuario_modifica='".$_COOKIE['usuario_global']."',"; 
$sql.=" fecha_modifica='".date('Y/m/d', time())."',"; 
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
$sql.=" where cod_material='".$cod_material."'"; 
mysql_query($sql);


$sql="delete from materiales_grupos_caracteristicas where cod_material='".$cod_material."'";
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