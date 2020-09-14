<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>Materiales</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>


function guardar(f){
	f.submit();
}

</script>
<style type="text/css">
<!--
.Estilo1 {color: #006633}
.Estilo2 {
	color: #990066;
	font-weight: bold;
}
-->
</style>
</head>
<body bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">Materiales</h3>
<form name="form1" method="post" action="saveCambioPrecioMaterial.php">
<?php 
	require("conexion.inc");
	include("funciones.php");
	$cod_grupo=$_POST['cod_grupo'];
	$cod_subgrupo=$_POST['cod_subgrupo'];

?>
<input type="hidden" name="cod_grupo" value="<?php echo $cod_grupo; ?>">
<input type="hidden" name="cod_subgrupo" value="<?php echo $cod_subgrupo; ?>">
<?php	
	//Paginador

		$sql_aux=" select count(*)";
		$sql_aux.=" from materiales m, subgrupos sbg, grupos g ";
		$sql_aux.=" where m.cod_material<>0 ";
		$sql_aux.=" and m.cod_subgrupo=sbg.cod_subgrupo";
		$sql_aux.=" and sbg.cod_grupo=g.cod_grupo ";
		if($cod_grupo<>0){
			$sql_aux.=" and sbg.cod_grupo='".$cod_grupo."'";
				if($cod_subgrupo<>0){
					$sql_aux.=" and m.cod_subgrupo=".$cod_subgrupo."";
				}	
		}			
	
	//echo $sql_aux;
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
			<td>ID Material ANTIGUO </td>
            <td>ID Material ACTUAL</td>
    		<td>Material</td>
			<td>Unidad</td>			
											
		</tr>
		<tr><th colspan="6" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
  </table>
	
<?php	
	}else{
	
?>
<h3 align="center" style="background:#FFF;font-size: 10px;color: #E78611;font-weight:bold;"><?php echo "Nro de Registros :".$nro_filas_sql;?></h3>
<?php

		$sql=" select  cod_material,count(*) AS cant ";
		$sql.=" from ingresos_detalle ";
		$sql.=" where cant_actual>0 ";
		if($cod_subgrupo<>0){
			$sql.=" and cod_material in (select cod_material from materiales where cod_subGrupo=".$cod_subgrupo.") ";
		}else{
			if($cod_grupo<>0){
				$sql.=" and cod_material in (select cod_material from materiales ";
				$sql.=" where cod_subGrupo in (select cod_subGrupo from subgrupos where cod_grupo=".$cod_grupo.") ) ";
			}
		}
		
		$sql.=" group by cod_material ";
		$sql.=" order by cant desc ";
		//echo $sql;

		$resp = mysql_query($sql);
		$bandera=1;
		$nroColumnas=1;
		while($bandera==1 and ($dat=mysql_fetch_array($resp))){
			$bandera=0;
			$cod_material=$dat[0];
			$nroColumnas=$dat[1];
		}
		//echo "nroColumnas".$nroColumnas;

		$sql=" select sbg.cod_grupo, g.nombre_grupo, m.cod_subgrupo, sbg.nombre_subgrupo,";
		$sql.="  m.cod_material, m.nombre_material, m.desc_completa_material, "; 
		$sql.=" m.cod_unidad_medida, m.stock_minimo, m.stock_maximo, m.cod_estado_registro, ";
		$sql.=" m.cod_usuario_registro, m.fecha_registro, m.cod_usuario_modifica, m.fecha_modifica, ";
		$sql.=" m.precio_venta, m.idMaterial, m.idMaterialDesc ";
		$sql.=" from materiales m, subgrupos sbg, grupos g ";
		$sql.=" where m.cod_material<>0 ";
		$sql.=" and m.cod_subgrupo=sbg.cod_subgrupo";
		$sql.=" and sbg.cod_grupo=g.cod_grupo ";
		if($cod_grupo<>0){
			$sql.=" and sbg.cod_grupo='".$cod_grupo."'";
				if($cod_subgrupo<>0){
					$sql.=" and m.cod_subgrupo=".$cod_subgrupo."";
				}	
		}			
		$sql.=" order by g.nombre_grupo, sbg.nombre_subgrupo, m.desc_completa_material asc ";	
		$resp = mysql_query($sql);

?>	
	<table width="95%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td rowspan="2">&nbsp;</td>
			<td rowspan="2">Grupo</td>
			<td rowspan="2">SubGrupo</td>
			<td rowspan="2">Id Material</td>
			<td rowspan="2">Material</td>			
			<td rowspan="2">Unidad</td>	
			<td colspan="<?php echo ($nroColumnas*2); ?>">Detalle</td>		 																		
			<td rowspan="2">Precio Venta Actual</td>		 																					
			<td rowspan="2">Nuevo Precio </td>		 																					
		</tr>
		<tr height="20px" align="center"  class="titulo_tabla">
		<?php for($i=1;$i<=$nroColumnas;$i++){?>
			<td>&nbsp;</td>			
			<td>Precio</td>	
 		    <?php }?>																			
		</tr>
	

<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){	
		
				$cod_grupo=$dat[0]; 
				$nombre_grupo=$dat[1];
				$cod_subgrupo=$dat[2];
				$nombre_subgrupo=$dat[3];
				$cod_material=$dat[4];
				$nombre_material=$dat[5];
				$desc_completa_material=$dat[6];
				$cod_unidad_medida=$dat[7];
				$stock_minimo=$dat[8];
				$stock_maximo=$dat[9];
				$cod_estado_registro=$dat[10];
			    $cod_usuario_registro=$dat[11];
				$fecha_registro=$dat[12];
				$cod_usuario_modifica=$dat[13];
				$fecha_modifica=$dat[14];
				$precio_venta=$dat[15];
				$idMaterial=$dat[16];
				$idMaterialDesc=$dat[17];

						
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
				$abrev_unidad_medida="";
				$sql2="select abrev_unidad_medida from unidades_medidas where cod_unidad_medida='".$cod_unidad_medida."'";
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$abrev_unidad_medida=$dat2[0];
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
				$sql2=" select  count(*) ";
				$sql2.=" from ingresos_detalle ";
				$sql2.=" where cant_actual>0 ";		
				$sql2.=" and cod_material=".$cod_material;
				$resp2= mysql_query($sql2);
				$nroColMaterial=0;
				while($dat2=mysql_fetch_array($resp2)){
					$nroColMaterial=$dat2[0];
				}
				//echo "$nroColMaterial".$nroColMaterial;
					

				
				
	
									
				
		
				//**************************************************************	



							

				
?> 
		<tr bgcolor="#FFFFFF">	
			<td>
			<input type="checkbox" name="cod_material<?php echo $cod_material;?>"  id="cod_material<?php echo $cod_material;?>" checked="checked"><?php echo $cod_material;?>
			</td>
			<td><?php echo $nombre_grupo;?></td>
			<td><?php echo $nombre_subgrupo;?></td>
			<td><?php echo $idMaterialDesc;?></td>							
    		<td><?php echo $desc_completa_material;?></td>
			<td><?php echo $abrev_unidad_medida;?></td>			
			<?php
				for($i=1;$i<=($nroColumnas-$nroColMaterial);$i=$i+1){
			?>	
				<td>&nbsp;</td>	
				<td bgcolor="#FFFF99">&nbsp;</td>	
			<?php
				}
			?>	
			<?php
				$sql2=" select id.cod_ingreso,i.nro_ingreso,i.cod_gestion, ";
				$sql2.=" g.gestion,i.fecha_ingreso,id.cant_actual, id.precio_compra_uni ";
				$sql2.=" from ingresos_detalle id, ingresos i, gestiones g ";
				$sql2.=" where id.cod_material=".$cod_material;
				$sql2.=" and id.cant_actual>0 ";
				$sql2.=" and id.cod_ingreso=i.cod_ingreso ";
				$sql2.=" and i.cod_gestion=g.cod_gestion ";
				$sql2.=" order by  fecha_ingreso asc";
				$resp2= mysql_query($sql2);				
				while($dat2=mysql_fetch_array($resp2)){
					$cod_ingreso=$dat2[0];
					$nro_ingreso=$dat2[1];
					$cod_gestion=$dat2[2];
					$gestion=$dat2[3];
					$fecha_ingreso=$dat2[4];
					$cant_actual=$dat2[5];
					$precio_compra_uni=$dat2[6];
				
			?>	
				<td align="right"><a href="detalleIngreso.php?cod_ingreso=<?php echo $cod_ingreso; ?>" target="_blank"><?php echo "Cant:".$cant_actual;?><br><?php echo "Nro:".$nro_ingreso."/".$gestion;?>
				<br><?php echo "Fecha:".$fecha_ingreso;?></a>				</td>
				<td align="right" bgcolor="#FFFF99"><strong><?php echo $precio_compra_uni;?></strong></td>	
			<?php
				}
			?>
			<td align="right" bgcolor="#99FFFF"><strong><?php echo $precio_venta; ?></strong></td>
			<td align="center">
			<input type="text" name="precio_venta<?php echo $cod_material;?>" id="precio_venta<?php echo $cod_material;?>" class="textoform" size="8" value="<?php echo $precio_venta; ?>">			
			</td>
   	  </tr>
<?php
		 } 
?>			
  </table>
					
<?php
	}
?>
	<br>
<div align="center">
	<input type="submit" class="boton" name="btn_guardar" value="Guardar"   >
</div>		
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
