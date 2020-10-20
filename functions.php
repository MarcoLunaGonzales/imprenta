<?php
require "conexion_inicio.inc";

function obtenerNombreCarpetaModulo($codigo){
 $carpeta="";
 $sql=" select cod_modulo, nombre_modulo, ubicacion_fisica  from modulos ";
 $sql.=" where cod_modulo = ".$codigo;
 $resp = mysql_query($sql);

  while($dat=mysql_fetch_array($resp)){ 
    $cod_modulo=$dat[0];  
    $nombre_modulo=$dat[1];
    $ubicacion_fisica=$dat[2];  
    $carpeta=explode("/",$ubicacion_fisica)[0];
  }
  return $carpeta;
}