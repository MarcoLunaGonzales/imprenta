


<?php


require("conexion.inc");
include("funcionCantActualMaterial.php");

$codgrupoB=$_GET['cod_grupo'];
$codsubgrupoB=$_GET['cod_subgrupo'];
$desccompletamaterialB=$_GET['nombreMaterialB'];



$sql_aux=" select count(*)";
		$sql_aux.=" from materiales m, subgrupos sbg, grupos g ";
		$sql_aux.=" where m.cod_material<>0 ";
		$sql_aux.=" and m.cod_subgrupo=sbg.cod_subgrupo";
		$sql_aux.=" and sbg.cod_grupo=g.cod_grupo ";
		if($codgrupoB<>0){
			$sql_aux.=" and sbg.cod_grupo='".$codgrupoB."'";
				if($codsubgrupoB<>0){
					$sql_aux.=" and m.cod_subgrupo=".$codsubgrupoB."";
				}	
		}			
		if($desccompletamaterialB<>""){
			$sql_aux.=" and m.desc_completa_material like '%".$desccompletamaterialB."%'";
		}			
	
	$resp_aux = mysql_query($sql_aux);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}
	if($nro_filas_sql==0){
?>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>Grupo</td>
			<td>SubGrupo</td>
			<td>Id Material ACTUAL</td>  
    		<td>Material</td>
			<td>Unidad</td>			
			<td>Cant Actual</td>									
		</tr>
		<tr><th colspan="6" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
	</table>
	
<?php	
	}else{
	
?>
<h3 align="center" style="background:#F7F5F3;font-size: 10px;color: #E78611;font-weight:bold;"><?php echo "Nro de Registros :".$nro_filas_sql;?></h3>
<?php

		
		$sql=" select sbg.cod_grupo, g.nombre_grupo,g.abrev_grupo, m.cod_subgrupo, sbg.nombre_subgrupo, sbg.abrev_subgrupo,";
		$sql.="  m.cod_material, m.nombre_material, m.desc_completa_material, "; 
		$sql.=" m.cod_unidad_medida, m.stock_minimo, m.stock_maximo, m.cod_estado_registro, ";
		$sql.=" m.cod_usuario_registro, m.fecha_registro, m.cod_usuario_modifica, m.fecha_modifica, ";
		$sql.=" m.idMaterial, m.idMaterialDesc";
		$sql.=" from materiales m, subgrupos sbg, grupos g ";
		$sql.=" where m.cod_material<>0 ";
		$sql.=" and m.cod_subgrupo=sbg.cod_subgrupo";
		$sql.=" and sbg.cod_grupo=g.cod_grupo ";
		if($codgrupoB<>0){
			$sql.=" and sbg.cod_grupo='".$codgrupoB."'";
				if($codsubgrupoB<>0){
					$sql.=" and m.cod_subgrupo=".$codsubgrupoB."";
				}	
		}			
		if($desccompletamaterialB<>""){
			$sql.=" and m.desc_completa_material like '%".$desccompletamaterialB."%'";
		}			

		$sql.=" order by g.nombre_grupo, sbg.nombre_subgrupo, m.desc_completa_material asc ";

		
		$resp = mysql_query($sql);

?>	
	<table width="98%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
    	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>Grupo</td>
			<td>SubGrupo</td>
			<td>Id Material</td>            
			<td>Material</td>			
			<td>Unidad</td>		
			<td>Cant Actual</td>    																		
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
						
						$nombre_material=$nombre_material." ".$desc_material_grupo_caracteristica;
					}						
			
				//**************************************************************
				$nombre_unidad_medida="";
				$sql2="select nombre_unidad_medida from unidades_medidas where cod_unidad_medida='".$cod_unidad_medida."'";
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_unidad_medida=$dat2[0];
				}					
				//**************************************************************								
				//**************************************************************
					$nombre_estado_registro="";				
					$sql2="select nombre_estado_registro from estados_referenciales";
					$sql2.=" where cod_estado_registro='".$cod_estado_registro."'";	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_estado_registro=$dat2[0];
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
    		<td><a href="javascript:enviarDatos('<?php echo $_GET['numMaterial'];?>','<?php echo $cod_material;?>','<?php echo $desc_completa_material;?>')"><?php echo $desc_completa_material;?></a></td>
            <td><?php echo $nombre_unidad_medida;?></td>
			<td><?php echo  cantActualMaterial($cod_material,$_COOKIE['cod_almacen_global']);?></td>
							
				
    	 </tr>
<?php
		 } 
?>			

		</TABLE>
					
<?php
	}
?>

<?php require("cerrar_conexion.inc");

