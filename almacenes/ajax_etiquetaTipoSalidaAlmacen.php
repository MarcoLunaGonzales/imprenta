
<?php 

require("conexion.inc");
include("funciones.php");
	$cod_tipo_salida=$_GET['cod_tipo_salida'];

?>
<?php if($cod_tipo_salida==1){
	//echo "Cliente:";
 } 
 if($cod_tipo_salida==2 or $cod_tipo_salida==4){
 echo "Hoja de Ruta:";
  } 
  
 if($cod_tipo_salida==3){
   echo "Almacen Traspaso:";
}
 if($cod_tipo_salida==5){
   echo "Orden de Trabajo:";
}
 ?>
