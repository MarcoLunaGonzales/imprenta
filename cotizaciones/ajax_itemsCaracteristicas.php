<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title></title>
<script language='Javascript'>
	
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>



<?php 
require("conexion.inc");
include("funciones.php");

	$cod_item=$_GET['cod_item'];
	$fila=$_GET['fila'];	
	$sql2="select count(*) from componente_items where cod_item='".$cod_item."' order by cod_compitem asc";
	$resp2= mysql_query($sql2);	
	$countF=0;
	while($dat2=mysql_fetch_array($resp2)){
		$countF=$dat2[0];
	}
	$sql2="select cod_compitem,nombre_componenteitem from componente_items where cod_item='".$cod_item."' order by cod_compitem asc";
	$resp2= mysql_query($sql2);
	$filaComp=0;
	?>
<table border="0" width="100%" id="dataCarac<?php echo $fila?>">
	<?php
	while($dat2=mysql_fetch_array($resp2)){
			$codCompItem=$dat2[0];
			$nombreComponente=$dat2[1];
			$filaComp++;
			if($countF<=1){
				$nombreComponente="";
			}
			?>
			<tr bgcolor="#FFFFFF">
				<td style="font-weight:bold;">&nbsp;</td>
				<td colspan="2">&nbsp;<b><?php echo $nombreComponente;?></b></td>
			</tr>
			<?php
			$sql3="SELECT cc.COD_CARAC,c.desc_carac,cc.orden FROM componentes_caracteristica cc, caracteristicas c WHERE  cc.COD_CARAC=c.COD_CARAC and COD_COMPITEM='".$codCompItem."' ORDER BY cc.orden ASC";
			$resp3= mysql_query($sql3);
			$filaCarac=0;
			while($dat3=mysql_fetch_array($resp3)){
					$codCarac=$dat3[0];
					$descCarac=$dat3[1];
					$filaCarac++;
?>
			<tr bgcolor="#FFFFFF">
				<td><input type="checkbox" checked="checked" id="codCarac<?php echo $filaComp;?><?php echo $codCarac;?>" value="<?php echo $codCarac;?>"></td>
				<td>&nbsp;<?php echo $descCarac;?>&nbsp;</td>
				<td><input class="textoform" type="text" id="descCarac<?php echo $filaComp;?><?php echo $codCarac;?>" size="35"  ></td>
			</tr>
<?php						
			}
						
	}

?>
</table>
</body>
</html>
