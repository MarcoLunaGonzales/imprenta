
<?php
require("conexion.inc");
include("funciones.php");
$numero=$_GET['numero'];
$sql=" select banco, cheque, cuenta,codcuenta  from forma_pago where cod_forma_pago=".$_GET['codFormaPago'];
$resp=mysql_query($sql);
while($dat=mysql_fetch_array($resp)){
	$banco=$dat['banco'];	
	$cheque=$dat['cheque'];
	$cuenta=$dat['cuenta'];	
	$codcuenta=$dat['codcuenta'];	
}
if($codcuenta=='SI'){
?>
<a href="javascript:buscarCuentaPago(<?php echo $_GET['numero'];?>)" >Buscar</a>
<input type="hidden" name="cod_cuenta<?php echo $numero;?>" id="cod_cuenta<?php echo $numero;?>" value="0">
<input type="text" class="textoform"   id="nro_cuenta<?php echo $numero;?>" name="nro_cuenta<?php echo $numero;?>" size="8" >

<?php }?>