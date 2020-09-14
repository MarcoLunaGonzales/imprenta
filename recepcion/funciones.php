<?php
date_default_timezone_set('America/Caracas');
//require("conexion.inc");
/**
 * Funciones 
 * Autor: Gabriela Quelali Siñani
 * @version $Id$
 * @copyright 2008 
 **/
function obtenerCodigo($sql)
{	require("conexion.inc");
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

function gestionActiva()
{	require("conexion.inc");
	$codigo=0;
	$sql="select cod_gestion from gestiones where gestion_activa=1";
	$resp=mysql_query($sql);
	while($dat=mysql_fetch_array($resp))
	{	
		$codigo=$dat[0];
	}

	return($codigo);
}

function cambiarFormatoFechaSql($fecha_sql)
{	require("conexion.inc");
	$fecha="";
	if($fecha_sql<>""){
		$vector=explode(" ",$fecha_sql);
		$cadena1=$vector[0];
		$vector2=explode("-",$cadena1);
		$fecha=$vector2[2]."/".$vector2[1]."/".$vector2[0];
	}
	return($fecha);
}

function llevarAFormatoFechaSql($fecha1)
{	require("conexion.inc");
	$vector=explode("/",$fecha1);
	$fecha=$vector[1]."-".$vector[0]."-".$vector[2];
	return($fecha);
}
   function ultimoDiaMes($mes,$anio) 
   { 
      for ($dia=28;$dia<=31;$dia++) 
         if(checkdate($mes,$dia,$anio)) $fecha="$dia/$mes/$anio"; 
      return $fecha; 
   } 

?>