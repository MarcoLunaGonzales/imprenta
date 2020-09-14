<?php 
require("conexion.inc");
include("funciones.php");
	$num=$_GET['codigo'];
	$codItemAnterio=$_GET['codItemAnterio'];
?>
<table border="0" align="center" cellSpacing="1" cellPadding="1" width="100%"  style="border:#ccc 1px solid;" id="data<?php echo $num?>" >
<tr bgcolor="#FFFFFF">
<td width="48%" align="left">
<br>
&nbsp;&nbsp;<select class="textoform" id="cod_item<?php echo $num?>" onChange="javascript:items_caracteristicas(this.form,'<?php echo $num?>');">				
<?php
	$sql_00="select desc_item from items where cod_item=".$codItemAnterio;
	$resp_00= mysql_query($sql_00);
	$nombreItemAnterior="";
	if($dat_00=mysql_fetch_array($resp_00)){
		$nombreItemAnterior=$dat_00[0];
	}
	?>
	<option value="<?php echo $codItemAnterio;?>"><?php echo $nombreItemAnterior;?></option>
	<?php
	$sql="select cod_item,desc_item from items where cod_item<>".$codItemAnterio." order by desc_item asc";
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
			$cod_item=$dat[0];
			$desc_item=$dat[1];
?>
				<option value="<?php echo $cod_item;?>"><?php echo $desc_item;?></option>
<?php										
	}
?>
</select>
<br>
&nbsp;&nbsp;<textarea cols="50" rows="1" name="obs" id="obs<?php echo $num?>"  class="textoform" ></textarea>
<div id="div_items_caracteristicas<?php echo $num?>" align="center">
<?php 
	$cod_item=$codItemAnterio;
	$fila=$num;
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
			$sql3="SELECT cc.COD_CARAC,c.desc_carac FROM componentes_caracteristica cc, caracteristicas c WHERE  cc.COD_CARAC=c.COD_CARAC and COD_COMPITEM='".$codCompItem."' ORDER BY cc.orden ASC";
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
</div>
</td>
<td align="center" width="11%"><input type="text" class="textoform" value="0"  id="cantidadUnitaria<?php echo $num?>"  size="8" onKeyUp="importe('<?php echo $num?>')" ></td>
<td align="center" width="12%"><input type="text" class="textoform" value="0" id="precioVenta<?php echo $num?>" onKeyUp="importe('<?php echo $num?>')" size="8"></td>
<td align="center" width="11%"><input type="text" class="textoform" value="0" id="descuento<?php echo $num?>" onKeyUp="importe('<?php echo $num?>')" size="8"></td>
<td align="center"  width="8%" ><input type="text" class="textoform" value="0" id="importe<?php echo $num?>" onKeyUp="importetotal('<?php echo $num?>')" size="8"></td>
<td align="right" width="5%" style="font-weight:bold;"><INPUT type="checkbox" id="chk<?php echo $num?>"  value="" checked   /></td>
<td><input class="boton" type="button" value="R" title="Replicar Item"  onclick="replicar(<?php echo $num?>)" /></td>
</tr>
</table>

