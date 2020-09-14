<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Detalle de Comprobante</title>
<?php 

require("conexion.inc");
include("funciones.php");
	$num=$_GET['codigo'];
?>

<table border="0" cellSpacing="1" cellPadding="1" width="100%"  style="border:#ccc 1px solid;" id="data<?php echo $num?>" >
<tr bgcolor="#FFFFFF" align="left">
<td width="5%" align="left">
<a href="javascript:buscarCuenta(<?php echo $num;?>)" >Buscar</a>
<input type="hidden" name="cod_cuenta<?php echo $num;?>" id="cod_cuenta<?php echo $num;?>" value="0">
</td>
<td width="8%" align="left">
<div id="nro_cuenta<?php echo $num;?>"></div>
</td>
<td width="20%" align="left">
<div id="desc_cuenta<?php echo $num;?>"></div>
</td>
<td align="left" width="10%">
<input type="text" class="textoform" size="12"id="nro_factura<?php echo $num;?>" name="nro_factura<?php echo $num;?>"  >
</td>
<td align="left" width="10%">
<input type="text" class="textoform"  size="12" id="fecha_factura<?php echo $num;?>" name="fecha_factura<?php echo $num;?>" >
</td>
<td align="left" width="10%">
<input type="text" class="textoform" size="12"id="debe<?php echo $num;?>" name="debe<?php echo $num;?>" onKeyUp="importe('<?php echo $num;?>')" >
</td>
<td align="left" width="10%">
<input type="text" class="textoform"  size="12"id="haber<?php echo $num;?>" name="haber<?php echo $num;?>" onKeyUp="importe('<?php echo $num;?>')">
</td>

<td align="left" width="20%">
<textarea class="textoform" cols="25" id="glosa<?php echo $num;?>" name="glosa<?php echo $num;?>"></textarea>
</td>
<td align="left" width="5%">
<input type="text" class="textoform" size="4" id="dias_venc_factura<?php echo $num;?>" name="dias_venc_factura<?php echo $num;?>" onKeyUp="importe('<?php echo $num;?>')">
</td>

<td align="center"  width="5%" ><input class="boton" type="button" value="R" onclick="menos(<?php echo $num;?>)" /></td>

</tr>
</table>

</head>
</html>