<?php
require("conexion.inc");
include("funciones.php");
	$cod_gasto_ordentrabajo=$_GET['cod_gasto_ordentrabajo'];
	

			
		$sql2=" delete from gastos_ordentrabajo ";
		$sql2.=" where  cod_gasto_ordentrabajo=".$cod_gasto_ordentrabajo."";	
		mysql_query($sql2);



require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listGastoOrdenTrabajo.php?cod_orden_trabajo=<?php echo $cod_orden_trabajo; ?>";
</script>