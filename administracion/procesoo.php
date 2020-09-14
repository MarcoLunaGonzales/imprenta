<?php
require("conexion.inc");
include("funciones.php");


$cod_estado_registro=1;
set_time_limit ( 300 );
echo "PROCESOOO <br/>";

		
$sql=" select cod_gasto_gral, cant_gasto_gral  from gastos_gral ";

	$cont=0;
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$cod_gasto_gral=$dat[0];
		$cant_gasto_gral=$dat[1];
		
		$cadena = $cant_gasto_gral;
        $numero = "";
    
    	for( $index = 0; $index < strlen($cadena); $index++ )
    {
        if( is_numeric($cadena[$index]) )
        {
            $numero .= $cadena[$index];
        }
    }  
		
		$cont=$cont+1;
		echo $cont." -codigo=".$cod_gasto_gral." - cantidad=".$cant_gasto_gral."-".$numero."<br/>";

		//if($numero<>NULL && $numero<>"" ){
		$sql2="update gastos_gral set ";
		$sql2.=" desc_gasto_gral= concat(desc_gasto_gral,' - ',cant_gasto_gral),";
		$sql2.=" cant_gasto_gral='".$numero."'"; 
		$sql2.=" where 	cod_gasto_gral='".$cod_gasto_gral."'"; 
		echo $sql2;
		$resp2=mysql_query($sql2);
	
		echo "ok=".$resp2."<br/>";
		
		//}
	}
	


require("cerrar_conexion.inc");
?>
