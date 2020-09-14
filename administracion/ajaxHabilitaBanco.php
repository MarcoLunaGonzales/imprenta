
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
if($banco=='SI'){
?>
<select name="cod_banco<?php echo $_GET['numero'];?>" id="cod_banco<?php echo $numero;?>" class="textoform" >
				<?php
					$sql4="select cod_banco,desc_banco from bancos";
					$resp4=mysql_query($sql4);
						while($dat4=mysql_fetch_array($resp4))
						{
							$cod_banco=$dat4['cod_banco'];	
			  		 		$desc_banco=$dat4['desc_banco'];	
				 ?><option value="<?php echo $cod_banco;?>"><?php echo $desc_banco;?></option>				
				<?php		
					}
				?>						
			</select>
<?php }?>