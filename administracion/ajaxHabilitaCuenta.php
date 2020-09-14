
<?php
require("conexion.inc");
include("funciones.php");
$numero=$_GET['numero'];
$sql=" select banco, cheque, cuenta  from forma_pago where cod_forma_pago=".$_GET['codFormaPago'];
$resp=mysql_query($sql);
while($dat=mysql_fetch_array($resp)){
	$banco=$dat['banco'];	
	$cheque=$dat['cheque'];
	$cuenta=$dat['cuenta'];	
}
if($cuenta=='SI'){
?>
<input type="text" class="textoform"   id="cuenta<?php echo $numero;?>" name="cuenta<?php echo $numero;?>" size="8" >


<?php }?>