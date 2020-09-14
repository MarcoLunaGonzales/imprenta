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

<table border="0" cellSpacing="1" cellPadding="1" width="80%"  style="border:#ccc 1px solid;" id="data<?php echo $num?>" >
<tr bgcolor="#FFFFFF" align="left">
<td width="20%" align="left">
<select name="cod_forma_pago<?php echo $num;?>" id="cod_forma_pago<?php echo $num;?>" class="textoform" onchange="habilitaOpcionesPago(<?php echo $num;?>)" >

				<?php
					$sql4="select cod_forma_pago,desc_forma_pago from forma_pago";
					$resp4=mysql_query($sql4);
						while($dat4=mysql_fetch_array($resp4))
						{
							$cod_forma_pago=$dat4['cod_forma_pago'];	
			  		 		$desc_forma_pago=$dat4['desc_forma_pago'];	
				 ?><option value="<?php echo $cod_forma_pago;?>"><?php echo $desc_forma_pago;?></option>				
				<?php		
					}
				?>						
			</select>

</td>
<td align="left" width="11%">
<select name="cod_moneda<?php echo $num;?>" id="cod_moneda<?php echo $num;?>" class="textoform"  onChange="calcularTotalPago()">
				<?php
					$sql4="select cod_moneda,desc_moneda from monedas";
					$resp4=mysql_query($sql4);
						while($dat4=mysql_fetch_array($resp4))
						{
							$cod_moneda=$dat4['cod_moneda'];	
			  		 		$desc_moneda=$dat4['desc_moneda'];	
				 ?><option value="<?php echo $cod_moneda;?>"><?php echo $desc_moneda;?></option>				
				<?php		
					}
				?>						
			</select>
</td>
<td align="left" width="15%">
<input type="text" class="textoform" value="0"  id="monto_pago_detalle<?php echo $num;?>" name="monto_pago_detalle<?php echo $num;?>" size="8" 
onKeyUp="validaFloat(this)" onChange="validaFloat(this)" >
</td>
<td align="left" width="22%">
<div id="div_cod_banco<?php echo $num;?>" align="left"></div>
</td>
<td align="left" width="10%">
<div id="div_nro_cheque<?php echo $num;?>" align="left"></div>
</td>
<td align="left" width="10%">
<div id="div_nro_cuenta<?php echo $num;?>" align="left"></div>

</td>

<td align="left" width="9%">
<div id="div_cod_cuenta<?php echo $num;?>" align="left"></div>

</td>

<td align="center"  width="3%" ><input class="boton" type="button" value="X" onclick="menos(<?php echo $num;?>)" /></td>

</tr>
</table>

</head>
</html>