
<?php 
require("conexion.inc");
include("funciones.php");
	$num=$_GET['codigo'];
	$cod_tipo_salida=$_GET['cod_tipo_salida'];
?>

<table border="0" align="center" cellSpacing="1" cellPadding="1" width="100%"  style="border:#ccc 1px solid;" id="data<?php echo $num?>" >
<tr bgcolor="#FFFFFF">
<td width="57%" align="left">

<a href="javascript:buscarMaterial(<?php echo $num;?>)" accesskey="B">Buscar</a>
<input type="hidden" name="cod_material<?php echo $num;?>" id="cod_material<?php echo $num;?>" value="0">
<input type="text" class="textoform" id="desc_material<?php echo $num;?>" name="desc_material<?php echo $num;?>" size="70" readonly>
                  
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
