	<?php
require("conexion.inc");
include("funciones.php");

?>
<table>
<?php
$sql=" select cod_grupo, nombre_grupo from grupos order by cod_grupo ";
$resp=mysql_query($sql);
while($dat=mysql_fetch_array($resp))
{
	$cod_grupo=$dat['cod_grupo'];
	$nombre_grupo=$dat['nombre_grupo'];
?>
	<tr><td align="right" colspan="5"><h1><?php echo "GRUPO".$nombre_grupo; ?></h1></td></tr>
<?php	
	$sql2=" select cod_subgrupo,nombre_subgrupo from subgrupos where cod_grupo=".$cod_grupo." order by cod_subgrupo";
	$resp2=mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2))
	{
		$cod_subgrupo=$dat2['cod_subgrupo'];
		$nombre_subgrupo=$dat2['nombre_subgrupo'];
?>
	<tr><td align="center" colspan="5"><h2><?php echo "SUBGRUPO".$nombre_subgrupo; ?></h2></td></tr>
<?php		
	
		$sql3=" select cod_material, nombre_material, desc_completa_material,idMaterial,idMaterialDesc ";
		$sql3.=" from materiales where cod_subgrupo=".$cod_subgrupo." order by cod_subgrupo";
		$resp3=mysql_query($sql3);
		while($dat3=mysql_fetch_array($resp3))
		{
			$cod_material=$dat3['cod_material'];
			$nombre_material=$dat3['nombre_material'];
			$desc_completa_material=$dat3['desc_completa_material'];
			$idMaterial=$dat3['idMaterial'];
			$idMaterialDesc=$dat3['idMaterialDesc'];
?>
	<tr>
    <td align="left"><?php echo $cod_material; ?></td>
    <td align="left"><?php echo $nombre_material; ?></td>
    <td align="left"><?php echo $desc_completa_material; ?></td>
    <td align="left"><?php echo $idMaterial; ?></td>
    <td align="left"><?php echo $idMaterialDesc; ?></td>
    </tr>
<?php			
		}
		
	}
	
}
?>
</table>
<?php
/*$sql2=" select cod_material, nombre_material,cod_subgrupo from materiales order by  cod_subgrupo, desc_completa_material asc ";
echo $sql2;
$resp2=mysql_query($sql2);
while($dat2=mysql_fetch_array($resp2))
{	
	$cod_material=$dat2[0];
	$nombre_material=$dat2[1];
	$cod_subgrupo=$dat2[2];
	
	$sql3=" select  nombre_subgrupo,cod_grupo from subgrupos where  cod_subgrupo=".$cod_subgrupo;
	$resp3=mysql_query($sql3);
	while($dat3=mysql_fetch_array($resp3)){
		$nombre_subgrupo=$dat3[0];
		$cod_grupo=$dat3[1];
	}
	$sql3=" select  nombre_grupo from grupos where  cod_grupo=".$cod_grupo;
	$resp3=mysql_query($sql3);
	while($dat3=mysql_fetch_array($resp3)){
		$nombre_grupo=$dat3[0];
	}
	$sql3=" select max(idMaterial) from materiales where cod_subgrupo=".$cod_subgrupo;
	$idMaterial=obtenerCodigo($sql3);
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
		echo $idMaterial."<br>";
	$sql3="update  materiales set ";
	$sql3.=" idMaterial=".$idMaterial.","; 
	$sql3.=" idMaterialDesc='".$nombre_grupo[0].$nombre_grupo[1].$nombre_grupo[2]."-".$nombre_subgrupo[0].$nombre_subgrupo[1].$nombre_subgrupo[2]."-".$idMaterialDesc."'"; 
	$sql3.=" where cod_material='".$cod_material."'"; 
	echo $sql3."<br>";
	mysql_query($sql3);

}*/

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
//location.href="navegadorMateriales.php";
</script>