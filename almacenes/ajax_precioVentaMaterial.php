
<?php 

require("conexion.inc");
include("funciones.php");

		$num=$_GET['num'];
		$cod_material=$_GET['cod_material'];
		


		
		$sql=" select precio_venta  from materiales where cod_material=".$cod_material."";
		$resp= mysql_query($sql);
		$precio_venta=0;
		while($dat=mysql_fetch_array($resp)){
				$precio_venta=$dat[0]; 									
		}		
		
		

?>

<input type="text" class="textoform"name="precioVenta<?php echo $num;?>" id="precioVenta<?php echo $num;?>" value="<?php echo $precio_venta;?>"  size="6" onKeyUp="importe('<?php echo $num;?>')">


	


