<?php 
require("conexion.inc");

		

	$sql=" delete from clientes_unidades where cod_unidad='".$_POST['cod_unidad']."'";
	mysql_query($sql);				

	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="listUnidadesClientes.php?cod_cliente=<?php echo $_POST['cod_cliente'];?>";
</script>
