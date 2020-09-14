<?php
require("conexion.inc");
include("funciones.php");
$valor_x=$_POST['valor_x'];
$valor_y=$_POST['valor_y'];
$cod_coordenada=$_POST['cod_coordenada'];



$sql="update coordenadas_impresion set ";
$sql.=" valor_x='".$valor_x."',";
$sql.=" valor_y='".$valor_y."'";
$sql.=" where cod_coordenada='".$cod_coordenada."' ";
$resp=mysql_query($sql);
require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorCoordenadasImpresion.php";
</script>