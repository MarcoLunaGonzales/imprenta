<?php 
require("conexion.inc");

		

	$sql=" delete from proveedores_contactos where cod_contacto_proveedor='".$_POST['cod_contacto_proveedor']."'";
	mysql_query($sql);				

	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="listContactosProveedor.php?cod_proveedor=<?php echo $_POST['cod_proveedor'];?>";
</script>
