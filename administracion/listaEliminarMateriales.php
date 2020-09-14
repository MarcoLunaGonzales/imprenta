<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Eliminación de Materiales</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function eliminar(f){
		f.submit();
	}
	
	function cancelar(f){
					window.location="navegadorMateriales.php";
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<form name="form1" method="post" action="eliminarMateriales.php">
<?php 

	require("conexion.inc");
	include("funciones.php");	
	$datos=$_GET["datos"];	
	
?>
<input type="hidden" name="datos" value="<?php echo $datos; ?>">
	<h3 align="center" style="background:white;font-size: 14px;color: #E78611;font-weight:bold;">Confirmacion de Eliminacion de Materiales </h3>


    <?php

		$datosEliminar="";
		$datosNoEliminar="";
		$vector_datos=explode(",",$datos);	
		$n=sizeof($vector_datos);
		for($i=0;$i<$n;$i++){	
		
				$cod_material=$vector_datos[$i];
				$sw=0;			
				$sql=" select  *  from ingresos_detalle  where cod_material='".$cod_material."'";			
				$resp= mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){
					$sw=1;
				}
			
				
				if($sw==0){
					/****************************/
						if($datosEliminar<>""){
							$datosEliminar=$datosEliminar.",".$cod_material;
						}else{
							$datosEliminar=$cod_material;
						}
					/****************************/
				}else{
					/***************************/
						if($datosNoEliminar<>""){
							$datosNoEliminar=$datosNoEliminar.",".$cod_material;
						}else{
							$datosNoEliminar=$cod_material;
						}
					/**************************/		
				}
									
		}
						
?>
<?php if($datosNoEliminar<>""){?>
<h3 align="center" style="background:white;font-size: 11px;color:#E78611;">Registros que no pueden ser Elimandos</h3>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	   	<tr height="20px" align="center"  class="titulo_tabla">
    		<td>Material</td>
			<td>Unidad</td>
			<td>Stock Minimo</td>
			<td>Stock Maximo</td>	
			<td>Estado</td>				
		</tr>
		<?php
			$vectordatosNoEliminar=explode(",",$datosNoEliminar);	
			$num=sizeof($vectordatosNoEliminar);
			for($j=0;$j<$num;$j++){	
				$cod_material=$vectordatosNoEliminar[$j];
				
				$sql="select  nombre_material,cod_subgrupo, cod_unidad_medida,";
				$sql.=" stock_minimo, stock_maximo,cod_estado_registro ";
				$sql.=" from materiales ";
				$sql.=" where cod_material=".$cod_material."";
				$resp = mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){	
			
					$nombre_material=$dat[0];				
					$cod_subgrupo=$dat[1];
					$cod_unidad_medida=$dat[2];
					$stock_minimo=$dat[3];
					$stock_maximo=$dat[4];
					$cod_estado_registro=$dat[5];

				
					//**************************************************************
					$nombre_subgrupo="";
					$sql2="select cod_grupo,nombre_subgrupo from subgrupos where cod_subgrupo='".$cod_subgrupo."'";
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$cod_grupo=$dat2[0];
						$nombre_subgrupo=$dat2[1];
					}					
					//**************************************************************

						$sql3="select desc_material_grupo_caracteristica from  materiales_grupos_caracteristicas ";
						$sql3.=" where cod_material='".$cod_material."'";
						$sql3.=" and  cod_grupo_carac in(select cod_grupo_carac from grupos_caracteristicas ";
						$sql3.=" where cod_grupo='".$cod_grupo."' order by orden asc)";		
						$resp3= mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3)){
							$desc_material_grupo_caracteristica=$dat3[0];
							$nombre_material=$nombre_material." ".$desc_material_grupo_caracteristica;
						}						


	
					//**************************************************************
					$nombre_grupo="";
					$sql2="select nombre_grupo from grupos where cod_grupo='".$cod_grupo."'";
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_grupo=$dat2[0];
					}					
					//**************************************************************				
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
		
				}				
				
							
	
		?>		
			<tr bgcolor="#FFFFFF">
    		<td><?php echo $nombre_grupo;?>&nbsp;<?php echo $nombre_subgrupo;?>&nbsp;<?php echo $nombre_material;?></td>
			<td><?php echo $nombre_unidad_medida;?></td>
			<td><?php echo $stock_minimo;?></td>			
			<td><?php echo $stock_maximo;?></td>			
			<td><?php echo $nombre_estado_registro;?></td>	
	    	 </tr>
		<?php
			}
		?>
	 </table>
<?php }?>
<br>

<?php if($datosEliminar<>""){?>
<h3 align="center" style="background:white;font-size: 11px;color:#E78611;">Registros que pueden ser Elimandos</h3>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	   	<tr height="20px" align="center"  class="titulo_tabla">
    		<td>Material</td>
			<td>Unidad</td>
			<td>Stock Minimo</td>
			<td>Stock Maximo</td>	
			<td>Estado</td>	
		</tr>
		<?php
			$vectordatosEliminar=explode(",",$datosEliminar);	
			$num=sizeof($vectordatosEliminar);
			for($j=0;$j<$num;$j++){	
				$cod_material=$vectordatosEliminar[$j];
				
				$sql="select  nombre_material,cod_subgrupo, cod_unidad_medida,";
				$sql.=" stock_minimo, stock_maximo,cod_estado_registro ";
				$sql.=" from materiales ";
				$sql.=" where cod_material=".$cod_material."";
				$resp = mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){	
			
					$nombre_material=$dat[0];				
					$cod_subgrupo=$dat[1];
					$cod_unidad_medida=$dat[2];
					$stock_minimo=$dat[3];
					$stock_maximo=$dat[4];
					$cod_estado_registro=$dat[5];

				
					//**************************************************************
					$nombre_subgrupo="";
					$sql2="select cod_grupo,nombre_subgrupo from subgrupos where cod_subgrupo='".$cod_subgrupo."'";
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$cod_grupo=$dat2[0];
						$nombre_subgrupo=$dat2[1];
					}					
					//**************************************************************

						$sql3="select desc_material_grupo_caracteristica from  materiales_grupos_caracteristicas ";
						$sql3.=" where cod_material='".$cod_material."'";
						$sql3.=" and  cod_grupo_carac in(select cod_grupo_carac from grupos_caracteristicas ";
						$sql3.=" where cod_grupo='".$cod_grupo."' order by orden asc)";		
						$resp3= mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3)){
							$desc_material_grupo_caracteristica=$dat3[0];
							$nombre_material=$nombre_material." ".$desc_material_grupo_caracteristica;
						}						


	
					//**************************************************************
					$nombre_grupo="";
					$sql2="select nombre_grupo from grupos where cod_grupo='".$cod_grupo."'";
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_grupo=$dat2[0];
					}					
					//**************************************************************				
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
		
				}				

						
				
		?>
		<tr bgcolor="#FFFFFF">		
    		<td><?php echo $nombre_grupo;?>&nbsp;<?php echo $nombre_subgrupo;?>&nbsp;<?php echo $nombre_material;?></td>
			<td><?php echo $nombre_unidad_medida;?></td>
			<td><?php echo $stock_minimo;?></td>			
			<td><?php echo $stock_maximo;?></td>			
			<td><?php echo $nombre_estado_registro;?></td>	
	    	 </tr>
		<?php
			}
		?>
	 </table>
<?php }?>
</div>			

<br>
<input type="hidden" name="datosEliminar" value="<?php echo $datosEliminar;?>">
<div align="center">

<INPUT type="button" class="boton" name="btn_eliminar"  value="Confirmar Eliminación" onClick="eliminar(this.form);">
<INPUT type="button" class="boton" name="btn_eliminar"  value="Cancelar" onClick="cancelar(this.form);">

</div>
		
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
