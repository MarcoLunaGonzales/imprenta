
<?php 

require("conexion.inc");
include("funciones.php");

		
		$cod_material=$_GET['cod_material'];
		$num=$_GET['numero'];
		$cod_tipo_salida=$_GET['cod_tipo_salida'];

		
		

?>
<?php  if($cod_tipo_salida==1){?>
<input type="text" class="textoform"name="importe<?php echo $num;?>" id="importe<?php echo $num;?>" value="0"  size="8" >

<?php  }?>
	


