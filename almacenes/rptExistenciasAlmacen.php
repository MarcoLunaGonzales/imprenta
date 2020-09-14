<?php
	require("conexion.inc");
	include("funciones.php");
	include("funcionCantActualMaterial.php");
	
	$cod_almacen=$_COOKIE['cod_almacen_global'];
	$sqlAlmacen="select nombre_almacen from almacenes where cod_almacen=".$cod_almacen;
	$respAlmacen=mysql_query($sqlAlmacen);
	while($datAlmacen=mysql_fetch_array($respAlmacen)){
		$nombre_almacen=$datAlmacen['nombre_almacen'];
	}
	$codgrupo=$_POST['cod_grupo'];
	//echo "codgrupo".$codgrupo."<br>";

	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>MODULO DE ALMACENES</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>


</script>
</head>
<body bgcolor="#FFFFFF">
<h3 align="center" style="background:#FFFFFF;font-size: 14px;color: #E78611;font-weight:bold;">REPORTE DE EXISTENCIAS CON STOCK</h3>
<h3 align="center" style="background:#FFFFFF;font-size: 12px;color: #663300;font-weight:bold;">ALMACEN: <?php echo $nombre_almacen;?></h3>
<h3 align="center" style="background:#FFFFFF;font-size: 12px;color: #663300;font-weight:bold;">A FECHA: <?php echo $_POST['fecha'];?></h3>
<div align="center"><a href="filtroRptExistencias.php"><--Volver Atras</a>
</div>

<div align="center"><a onClick="window.print();"><img src="img/imprimir.jpg" border="0"></a>
</div>

<form name="form1" method="post" action="rptExistenciasAlmacen.php">

<table width="95%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">

<?php
	$costoTotalAlmacen=0;
	$totalGrupo=0;
	$totalGrupo2=0;
	$sqlGrupo=" select cod_grupo, nombre_grupo, abrev_grupo ";
	$sqlGrupo.=" from grupos where cod_estado_registro=1 ";
	if($codgrupo<>0){
		$sqlGrupo.="and cod_grupo=".$codgrupo;
	}
	$sqlGrupo.=" order by  nombre_grupo asc";
	//echo $sqlGrupo."<br>";	
	$respGrupo=mysql_query($sqlGrupo);
	while($datGrupo=mysql_fetch_array($respGrupo)){
	$totalGrupo=0;
	$totalGrupo2=0;
				$cod_grupo=$datGrupo['cod_grupo'];	
		 		$nombre_grupo=$datGrupo['nombre_grupo'];
				$abrev_grupo=$datGrupo['abrev_grupo'];
?>
    <tr height="20px" align="center"  class="titulo_tabla">
	  <td colspan="9"><?php echo strtoupper($nombre_grupo);?></td>									
	</tr>        
<?php	

		$sqlSubGrupo=" select cod_subgrupo, nombre_subgrupo, abrev_subgrupo ";
		$sqlSubGrupo.=" from subgrupos  ";
		$sqlSubGrupo.=" where cod_grupo=".$cod_grupo;
		
		if($codgrupo<>0){
			////////////////////////////////////////////////////////////////
			$sqlSubGrupoAux=" select cod_subgrupo from subgrupos ";
			$resp2=mysql_query($sqlSubGrupoAux);
			$sw=1;
			while($dat2=mysql_fetch_array($resp2)){								
				$codsubgrupo=$dat2['cod_subgrupo'];
				if($_POST['cod_subgrupo'.$codsubgrupo]=="on"){
					///////////////////////////////////////////
					if($sw==1){
						$sqlSubGrupo.=" and( cod_subgrupo=".$codsubgrupo;
						$sw=0;
					}else{
						$sqlSubGrupo.=" or cod_subgrupo=".$codsubgrupo;
					}
					/////////////////////////////////////////
				}
			}
			if($sw==0){
				$sqlSubGrupo.=")";
			}
			////////////////////////////////////////////////////////////////////
		}	
			
		$sqlSubGrupo.=" order by nombre_subgrupo  ";
		$respSubGrupo=mysql_query($sqlSubGrupo);
		while($datSubGrupo=mysql_fetch_array($respSubGrupo)){	
			$cod_subgrupo=$datSubGrupo['cod_subgrupo'];
			$nombre_subgrupo=$datSubGrupo['nombre_subgrupo'];
			$abrev_subgrupo=$datSubGrupo['abrev_subgrupo'];
	?>
    	    <tr height="20px" align="left"  class="titulo_tabla">
			  <td colspan="9"><?php echo strtoupper($nombre_subgrupo);?></td>									
			</tr> 
    	    <tr height="20px" align="center"  class="titulo_tabla">
			  <td>ID ANTIGUO</td>
              <td>ID ACTUAL</td>
              <td>MATERIAL</td>
              <td>&nbsp;</td>
              <td>CANT</td>
			  <td>COSTO</td>	
              <td>COSTO POR UNIDAD</td>
              <!--td>COSTO TOTAL</td-->
              <td>PRECIO VENTA</td>									
			</tr>             
    <?php
		
			////////////LISTADO DE MATERIALES////////////
				$sqlMateriales=" select cod_material, nombre_material, desc_completa_material, idMaterial, idMaterialDesc,";
				$sqlMateriales.=" cod_unidad_medida, precio_venta";
				$sqlMateriales.=" from materiales  ";
				$sqlMateriales.=" where  cod_subgrupo=".$cod_subgrupo;
				$sqlMateriales.=" order by desc_completa_material asc";
				$respMateriales=mysql_query($sqlMateriales);
				$costoTotalSubGrupo=0;
				$costoTotalSubGrupo2=0;
				while($datMateriales=mysql_fetch_array($respMateriales)){
					$cod_material=$datMateriales['cod_material'];
					$nombre_material=$datMateriales['nombre_material'];
					$desc_completa_material=$datMateriales['desc_completa_material'];
					$idMaterial=$datMateriales['idMaterial'];
					$idMaterialDesc=$datMateriales['idMaterialDesc'];
					$cod_unidad_medida=$datMateriales['cod_unidad_medida'];
					$precio_venta=$datMateriales['precio_venta'];
					////DESCRIPCION UNIDAD MEDIDA
						$sqlUniMedida="select nombre_unidad_medida, abrev_unidad_medida from unidades_medidas";
						$sqlUniMedida.=" where cod_unidad_medida=".$cod_unidad_medida;
						$respUniMedida=mysql_query($sqlUniMedida);
						while($datUniMedida=mysql_fetch_array($respUniMedida)){
							$nombre_unidad_medida=$datUniMedida['nombre_unidad_medida'];
							$abrev_unidad_medida=$datUniMedida['abrev_unidad_medida'];
						}
					////FIN DESCRIPCION UNIDAD MEDIDA
					
					////////////////COSTO ACTUAL DE MATERIAL//////////
					$sqlCosto=" select count(*) ";
					$sqlCosto.=" from ingresos_detalle ";
					$sqlCosto.=" where cod_material=".$cod_material;
					$sqlCosto.=" and cod_ingreso in(select cod_ingreso from ingresos";
					$sqlCosto.=" where cod_estado_ingreso=1 and cod_almacen=".$cod_almacen." )";
					$sqlCosto.=" and cant_actual>0" ;
					$sqlCosto.=" order by cod_ingreso_detalle desc";
					$nroRows=0;
					$respCosto=mysql_query($sqlCosto);
						while($datCosto=mysql_fetch_array($respCosto)){
							$nroRows=$datCosto[0];
						}
						

					//////////////FIN COSTO MATERIAL////////////////////////
		list($stock,$costo)=explode("_",cantActualMaterialFecha($cod_material,$cod_almacen,$_POST['fecha']));	
	if($stock>0){					
				$costoTotalAlmacen=$costoTotalAlmacen+$costo;	
				$costoTotalSubGrupo2=$costoTotalSubGrupo2+$costo;
	?>
		<tr bgcolor="#FFFFFF">	
        <td align="left"><?php echo $idMaterialDesc;?></td>
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
		
            <td><?php echo $desc_completa_material;?></td>
            <td><?php echo $abrev_unidad_medida;?></td>	
            <td align="right"><?php echo number_format($stock,2);?></td>
            <td align="right"><?php echo number_format($costo,3);?></td>
            
            <td align="right">
            <?php 
				$costoTotal=0;
				if($nroRows==0) { 
					$costoTotal=0;
					echo "0";
				}else{
			?>
            	<table border="0" cellpadding="0" cellspacing="1">
            <?php
					$sqlCosto=" select precio_compra_uni, sum(cant_actual) ";
					$sqlCosto.=" from ingresos_detalle ";
					$sqlCosto.=" where cod_material=".$cod_material;
					$sqlCosto.=" and cod_ingreso in(select cod_ingreso from ingresos ";
					$sqlCosto.=" where cod_estado_ingreso=1 and cod_almacen=".$cod_almacen.")";
					$sqlCosto.=" and cant_actual>0" ;
					$sqlCosto.=" group by precio_compra_uni ";
					$sqlCosto.=" order by cod_ingreso_detalle desc";
					$respCosto=mysql_query($sqlCosto);
						$costoTotal=0;
						while($datCosto=mysql_fetch_array($respCosto)){
							$precio_compra_uni=$datCosto[0];
							$cant_actual=$datCosto[1];
			?>
            		<tr bgcolor="#FFFFFF"><td class="textoform"><?php echo $precio_compra_uni." Bs.";?></td>
                    <td><?php echo number_format($cant_actual,2)." cant"; ?></td></tr>
            <?php
	
							$costoTotal=$costoTotal+($precio_compra_uni*$cant_actual);
						}
			?>
              </table>
            <?php						
				}

				$costoTotalSubGrupo=$costoTotalSubGrupo+$costoTotal;
			?>
          
            </td>
            <!--td align="right"><?php echo $costoTotal;?></td-->		
            <td align="right"><?php echo $precio_venta;?></td>		            								
    </tr>
    
    <?php
	}
		}

					
			////////////FIN LISTADO DE MATERIALES///////////		
	?>
    <tr bgcolor="#FFFFFF">
		<td align="right" colspan="5"><strong><?php echo "TOTAL ".strtoupper($nombre_subgrupo);?></strong></td>
    	<td align="right" ><?php echo $costoTotalSubGrupo2;?></td>
        <td align="right"   colspan="2">&nbsp;</td>
    </tr>
    <?php
			$totalGrupo=$totalGrupo+$costoTotalSubGrupo;
			$totalGrupo2=$totalGrupo2+$costoTotalSubGrupo2;
		}
	?>
        <tr bgcolor="#FFFFFF">
		<td align="right"  colspan="5"><strong><?php echo "TOTAL GRUPO: ".strtoupper($nombre_grupo);?></strong></td>
    	<td align="right" ><strong><?php echo $totalGrupo2;?></strong></td>
        <td align="right" colspan="2">&nbsp;</td>
    </tr>
	<?php					
	}
?>
        <tr bgcolor="#FFFFFF">
    	<td align="right"  colspan="5"><strong><?php echo "TOTAL FINAL: ";?></strong></td>
	    <td align="right"><strong><?php echo $costoTotalAlmacen;?></strong></td>
        <td align="right" colspan="2">&nbsp;</td>
    </tr>


</table>
		
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>

