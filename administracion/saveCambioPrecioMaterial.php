

<?php 
	require("conexion.inc");
	include("funciones.php");
	$cod_grupo=$_POST['cod_grupo'];
	$cod_subgrupo=$_POST['cod_subgrupo'];
	//echo $cod_grupo."<br>".$cod_subgrupo;


	//Paginador

		$sql=" select m.cod_material";
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
		//echo $sql."<br>";
	//echo $sql_aux;
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$cod_material=$dat[0];
		
		//echo $_POST['cod_material'.$cod_material];

		if($_POST['cod_material'.$cod_material]=="on"){
			$precioVenta=$_POST['precio_venta'.$cod_material];
		//	echo $precioVenta."<br>";
			if($precioVenta<>""){
				$sql3=" update materiales set";
				$sql3.=" precio_venta=".$precioVenta;
				$sql3.=" where cod_material=".$cod_material;
				//echo $sql3."<br>";			
				mysql_query($sql3);
			}
		}

	}


//echo "cambioPrecioMaterial.php?cod_grupo=".$cod_grupo."&cod_subgrupo".$cod_subgrupo;
?>
<script language="JavaScript">
location.href="filtroCambioPreciosMateriales.php";
</script>`
