
<?php 

require("conexion.inc");
include("funciones.php");

		
		$cod_material=$_GET['cod_material'];
		$num=$_GET['numero'];
		$cod_tipo_salida=$_GET['cod_tipo_salida'];


		

		
		$sql=" select precio_venta  from materiales where cod_material=".$cod_material."";
		$resp= mysql_query($sql);
		$precio_venta=0;
		while($dat=mysql_fetch_array($resp)){
				$precio_venta=$dat[0]; 									
		}	
		


?>
<?php  if($cod_tipo_salida==1){?>

<input type="hidden" class="textoform"name="precioVentaDef<?php echo $num;?>" id="precioVentaDef<?php echo $num;?>" value="<?php echo $precio_venta;?>" >
<?php echo $precio_venta;?>&nbsp;
<input type="text" class="textoform"name="precioVenta<?php echo $num;?>" id="precioVenta<?php echo $num;?>" value="<?php echo $precio_venta;?>"  size="6" onKeyUp="importe('<?php echo $num;?>')">

<?php  }?>
	


