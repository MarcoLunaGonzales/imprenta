<?php
//require("conexion.inc");
/**
 * Funciones 
 * Autor: Gabriela Quelali Siñani
 * @version $Id$
 * @copyright 2008 
 **/
function obtenerCodigo($sql)
{	require("conexion1.inc");
	$resp=mysql_query($sql);
	$nro_filas_sql = mysql_num_rows($resp);
	if($nro_filas_sql==0){
		$codigo=1;
	}else{
		while($dat=mysql_fetch_array($resp))
		{	$codigo =$dat[0];
		}
			$codigo = $codigo+1;
	}
	return($codigo);
}

function ultimoDiaMes($mes,$anio) 
{ 
  for ($dia=28;$dia<=31;$dia++) 
     if(checkdate($mes,$dia,$anio)) $fecha="$dia/$mes/$anio"; 
    return $fecha; 
} 

?>