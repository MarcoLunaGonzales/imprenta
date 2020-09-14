
<?php 

require("conexion.inc");
include("funciones.php");
	$num=$_GET['codigo'];
	$cod_tipo_salida=$_GET['cod_tipo_salida'];
?>

<table border="0" align="center" cellSpacing="1" cellPadding="1" width="100%"  style="border:#ccc 1px solid;" id="data<?php echo $num?>" >
<tr bgcolor="#FFFFFF">
<td width="57%" align="left">


<select class="textoform" id="cod_material<?php echo $num;?>" name="cod_material<?php echo $num;?>" onChange="listaDatosMateriales(this.form,<?php echo $num;?>)">
				<option value="0">SELECCIONE UNA OPCION</option>
<?php


		$sql=" select sbg.cod_grupo, g.nombre_grupo, m.cod_subgrupo, sbg.nombre_subgrupo,";
		$sql.="  m.cod_material, m.nombre_material, m.desc_completa_material, "; 
		$sql.=" m.cod_unidad_medida, m.stock_minimo, m.stock_maximo, m.cod_estado_registro ";
		$sql.=" from materiales m, subgrupos sbg, grupos g ";
		$sql.=" where m.cod_estado_registro=1 ";
		$sql.=" and m.cod_subgrupo=sbg.cod_subgrupo";
		$sql.=" and sbg.cod_grupo=g.cod_grupo ";
		$sql.=" order by g.nombre_grupo, sbg.nombre_subgrupo, m.desc_completa_material asc ";		
		$resp= mysql_query($sql);
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
	
?>
				<option value="<?php echo $cod_material;?>"><?php echo $nombre_grupo." ".$nombre_subgrupo." ".$desc_completa_material;?></option>
<?php										
	}
?>
</select>
</td>
<td align="center" width="3%">
<div id="div_unidad<?php echo $num;?>"></div>
</td>
<td align="center" width="5%">
<div id="div_cantActual<?php echo $num;?>">
</div>
</td>
<td align="center" width="8%">
<input type="text" class="textoform" value="0"  name="cantidad<?php echo $num;?>" id="cantidad<?php echo $num;?>" onKeyUp="importe('<?php echo $num;?>')" size="6">
</td>

<td align="center"  width="11%" >
<div id="div_precioVenta<?php echo $num;?>">
</div>
</td>
<td align="center"  width="9%" >
<div id="div_importe<?php echo $num;?>">
</div>
</td>
<td align="right"  width="7%" ><input class="boton" type="button" value="Delete" onclick="menos(<?php echo $num;?>)" /></td>
</tr>
</table>
