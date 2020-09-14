<?php 
require("conexion.inc");

		

	$sql=" delete from clientes_contactos where cod_contacto='".$_POST['cod_contacto']."'";
	mysql_query($sql);				

	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="listContactosClientes.php?cod_cliente=<?php echo $_POST['cod_cliente'];?>";
</script>
