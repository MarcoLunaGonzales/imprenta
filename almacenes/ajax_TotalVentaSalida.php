
<?php 

require("conexion.inc");
include("funciones.php");

		$cod_tipo_salida=$_GET['cod_tipo_salida'];

		

?>
<?php  if($cod_tipo_salida==1){?>
<table align="center"class="text" cellSpacing="1" cellPadding="2" width="98%" border="0" id="dataTotal">
	<tr class="titulo_tabla">
	<td width="90%" colspan="5">&nbsp;<b>Total</b></td>
	<td width="10%" align="right"><SPAN id="importeTotal">0</SPAN></td>
	<td width="10%" align="right">&nbsp;</td>		
	</tr>
</table>	
<?php  }?>
	


