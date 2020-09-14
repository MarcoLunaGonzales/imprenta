<?php 
require("conexion.inc");
		

		$sql=" delete from proveedores where cod_proveedor='".$_POST['cod_proveedor']."'";
		mysql_query($sql);				

require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="listProveedores.php?proveedorContactoB=<?php echo $_GET['nombre_proveedor']?>";
</script>
