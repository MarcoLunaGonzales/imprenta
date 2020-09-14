<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Registro de Cotizaci&oacute;n</title>
<?php 

require("conexion.inc");
include("funciones.php");
	$num=$_GET['codigo'];
?>

<table border="0" align="center" cellSpacing="1" cellPadding="1" width="100%"  style="border:#ccc 1px solid;" id="data<?php echo $num?>" >
<tr bgcolor="#FFFFFF">
<td width="48%" align="left">
<br>
&nbsp;&nbsp;<select class="textoform" id="cod_item<?php echo $num?>" onChange="javascript:items_caracteristicas(this.form,'<?php echo $num?>');">
				<option value="0">SELECCIONE UNA OPCION</option>
<?php
	$sql="select cod_item,desc_item from items order by desc_item asc";
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
</div>
</td>
<td align="center" width="11%"><input type="text" class="textoform" value="0"  id="cantidadUnitaria<?php echo $num?>"  size="8" onKeyUp="importe('<?php echo $num?>')" ></td>
<td align="center" width="12%"><input type="text" class="textoform" value="0" id="precioVenta<?php echo $num?>" onKeyUp="importe('<?php echo $num?>')" size="8" ></td>
<td align="center" width="11%"><input type="text" class="textoform" value="0" id="descuento<?php echo $num?>" onKeyUp="importe('<?php echo $num?>')" size="8"></td>
<td align="center"  width="8%" ><input type="text" class="textoform" value="0" id="importe<?php echo $num?>" onKeyUp="importetotal('<?php echo $num?>')" size="8"></td>
<td align="right" width="5%" style="font-weight:bold;"><INPUT type="checkbox" id="chk<?php echo $num?>"  value="" checked   /></td>
<td><input class="boton" type="button" value="R" title="Replicar Item"  onclick="replicar(<?php echo $num?>)" /></td>
</tr>
</table>

</head>
</html>