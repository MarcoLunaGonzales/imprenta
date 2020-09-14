<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Nuevo Material</title>
<?php 

require("conexion.inc");
include("funciones.php");
	$num=$_GET['codigo'];
?>

<table border="0" cellSpacing="1" cellPadding="1" width="100%"  style="border:#ccc 1px solid;" id="data<?php echo $num?>" >
<tr bgcolor="#FFFFFF" align="left">
<td width="55%" align="left">

<a href="javascript:buscarMaterial(<?php echo $num;?>)" >Buscar</a>
<input type="hidden" name="cod_material<?php echo $num;?>" id="cod_material<?php echo $num;?>" value="0">
<input type="text" class="textoform" id="desc_material<?php echo $num;?>" name="desc_material<?php echo $num;?>" size="70" readonly>
</td>
<td align="left" width="5%">
<div id="div_unidad<?php echo $num;?>" align="left"></div>
</td>
<td align="left" width="8%">
<input type="text" class="textoform" value="0"  id="cantidad<?php echo $num;?>" name="cantidad<?php echo $num;?>" size="5" onKeyUp="importe('<?php echo $num;?>')" >
</td>
<td align="left" width="8%">
<input type="text" class="textoform" value="0" id="precioCompra<?php echo $num;?>" name="precioCompra<?php echo $num;?>" onKeyUp="importe('<?php echo $num;?>')" size="5" >
</td>
<td align="left" width="8%">
<div id="div_precioVenta<?php echo $num;?>" align="left">

</div>
</td>
<td align="center"  width="8%" ><input type="text" class="textoform" value="0" name="importe<?php echo $num;?>" id="importe<?php echo $num;?>"  size="8" readonly="true"></td>


<td align="center"  width="8%" ><input class="boton" type="button" value="Remover" onclick="menos(<?php echo $num;?>)" /></td>

</tr>
</table>

</head>
</html>