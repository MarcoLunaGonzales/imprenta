<?php
header('Content-Type: text/html; charset=ISO-8859-1 Cache-Control: no-store, no-cache, must-revalidate');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';


require("conexion.inc");
include("funcionCantActualMaterial.php");
?>
 <a href="javascript:cerrarDivBusqueda();">CERRAR BUSQUEDA</a><br/>
<?
		$sql=" select count(*)";
		$sql.=" from materiales m, subgrupos sbg, grupos g ";
		$sql.=" where m.cod_material<>0 ";
		$sql.=" and m.cod_subgrupo=sbg.cod_subgrupo";
		$sql.=" and sbg.cod_grupo=g.cod_grupo ";
		if($_GET['cod_grupo']<>0){
			$sql.=" and sbg.cod_grupo='".$_GET['cod_grupo']."'";
				if($_GET['cod_subgrupo']<>0){
					$sql.=" and m.cod_subgrupo=".$_GET['cod_subgrupo']."";
				}	
		}			
		
		if($_GET['nombreMaterialB']<>""){
			$sql.=" and m.desc_completa_material like '%".$_GET['nombreMaterialB']."%'";
		}			

		$sql.=" order by g.nombre_grupo, sbg.nombre_subgrupo, m.desc_completa_material asc ";
		$resp = mysql_query($sql);
		$numRows=0;
		while($dat=mysql_fetch_array($resp)){
			$numRows=$dat[0];			
		}
		if($numRows==0){
			
		?>
	<table width="98%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			  <td>Grupo</td>
              <td>SubGrupo</td>
              <td>ID</td>
              <td>Material</td>
              <td>&nbsp;</td>
              <td>Cant. Actual</td>	   																		
		</tr>
		<tr bgcolor="#FFFFFF" align="center" ><th colspan="6">No Existen registros</th></tr>
        </table>        
        <?php
		}else{
	$sql=" select sbg.cod_grupo, g.nombre_grupo,g.abrev_grupo, m.cod_subgrupo, sbg.nombre_subgrupo, sbg.abrev_subgrupo,";
		$sql.="  m.cod_material, m.nombre_material, m.desc_completa_material, "; 
		$sql.=" m.cod_unidad_medida, m.stock_minimo, m.stock_maximo, m.cod_estado_registro, ";
		$sql.=" m.cod_usuario_registro, m.fecha_registro, m.cod_usuario_modifica, m.fecha_modifica, ";
		$sql.=" m.idMaterial, m.idMaterialDesc";
		$sql.=" from materiales m, subgrupos sbg, grupos g ";
		$sql.=" where m.cod_material<>0 ";
		$sql.=" and m.cod_subgrupo=sbg.cod_subgrupo";
		$sql.=" and sbg.cod_grupo=g.cod_grupo ";
		if($_GET['cod_grupo']<>0){
			$sql.=" and sbg.cod_grupo='".$_GET['cod_grupo']."'";
				if($_GET['cod_subgrupo']<>0){
					$sql.=" and m.cod_subgrupo=".$_GET['cod_subgrupo']."";
				}	
		}			
		
		if($_GET['nombreMaterialB']<>""){
			$sql.=" and m.desc_completa_material like '%".$_GET['nombreMaterialB']."%'";
		}			

		$sql.=" order by g.nombre_grupo, sbg.nombre_subgrupo, m.desc_completa_material asc ";
		$resp = mysql_query($sql);

?>	
	<table width="98%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			  <td>Grupo</td>
              <td>SubGrupo</td>
              <td>ID</td>
              <td>Material</td>
              <td>&nbsp;</td>
              <td>Cant. Actual</td>	   																		
		</tr>

<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){	
		
				$cod_grupo=$dat['cod_grupo']; 
				$nombre_grupo=$dat['nombre_grupo'];
				$abrev_grupo=$dat['abrev_grupo'];
				$cod_subgrupo=$dat['cod_subgrupo'];
				$nombre_subgrupo=$dat['nombre_subgrupo'];
				$abrev_subgrupo=$dat['abrev_subgrupo'];
				$cod_material=$dat['cod_material'];
				$nombre_material=$dat['nombre_material'];
				$desc_completa_material=$dat['desc_completa_material'];
				$cod_unidad_medida=$dat['cod_unidad_medida'];
				$stock_minimo=$dat['stock_minimo'];
				$stock_maximo=$dat['stock_maximo'];
				$cod_estado_registro=$dat['cod_estado_registro'];
			    $cod_usuario_registro=$dat['cod_usuario_registro'];
				$fecha_registro=$dat['fecha_registro'];
				$cod_usuario_modifica=$dat['cod_usuario_modifica'];
				$fecha_modifica=$dat['fecha_modifica'];
				$idMaterial=$dat['idMaterial'];
				$idMaterialDesc=$dat['idMaterialDesc'];

				//**************************************************************
				$nombre_unidad_medida="";
				$sql2="select nombre_unidad_medida from unidades_medidas where cod_unidad_medida='".$cod_unidad_medida."'";
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_unidad_medida=$dat2[0];
				}					
				//**************************************************************								

?> 
		<tr bgcolor="#FFFFFF">	
			<td><?php echo $nombre_grupo;?></td>
			<td><?php echo $nombre_subgrupo;?></td>
            <td align="left"><?php 
			if($cod_material<10){
				$varAux="0000";
			}
			if($cod_material>=10 and $cod_material<100 ){
				$varAux="000";
			}	
			if($cod_material>=100 and $cod_material<1000 ){
				$varAux="00";
			}
			if($cod_material>=1000 and $cod_material<10000 ){
				$varAux="0";
			}						
			echo $abrev_grupo." ".$abrev_subgrupo." ".$varAux.$cod_material;?></td>							
    		<td align="left"><a href="javascript:setMateriales(form1,'<?php echo $cod_material;?>','<?php echo $desc_completa_material;?>')"><?php echo $desc_completa_material;?></a></td>
			<td align="left"><?php echo $nombre_unidad_medida;?></td>
			<td align="left"><?php echo  cantActualMaterial($cod_material,$_COOKIE['cod_almacen_global']);?></td>			

    	 </tr>
<?php
		 } 
?>			


</table>
<?php
		 } 
?>