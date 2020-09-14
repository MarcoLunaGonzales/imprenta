<?php
//require("conexion.inc");
/**
 * Funciones 
 * Autor: Gabriela Quelali Siñani
 * @version $Id$
 * @copyright 2008 
 **/

/*

function estadoRegistroSql($codigo)
{	require("conexion.inc");
		$nombre="";
		$sql="select nombre_estado_registro from estados_referenciales where cod_estado_registro='".$codigo."'";
		$resp=odbc_exec($con,$sql);
		$nombre=odbc_result($resp,"nombre_estado_registro");
	return($nombre);
}*/
function estadoEmpresaSql($codigo)
{	require("conexion1.inc");
		$nombre="";
		$sql="select nombre_estado_empresa from estados_empresa where cod_estado_empresa='".$codigo."'";
		$resp=mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){
			$nombre=$dat[0];
		}
	return($nombre);
}
function verificarEliminacionEmpresa($codigo)
{	
		require("conexion1.inc");
		$sw=1;
		$nro=0;
		$sql="select count(*)as nro from contactos where cod_empresa='".$codigo."'";
		$resp=mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){
			$nro=$dat[0];
		}	
		if($nro>0){
			$sw=2;
		}
		$sql="select count(*)as nro from productos_por_empresa where cod_empresa='".$codigo."'";
		$resp=mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){
			$nro=$dat[0];
		}				
		if($nro>0){
			$sw=2;
		}						
		
	return($sw);
}

function verificarEliminacionContacto($codigo)
{	
		require("conexion1.inc");
		$sw=1;
		$nro=0;
		$sql="select count(*)as nro from fichas_producto where cod_contacto='".$codigo."'";
		$resp=mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){
			$nro=$dat[0];
		}
								
	return($sw);
}

function ciudadSql($codigo)
{	require("conexion1.inc");
		$nombre="";
		$sql="select nombre_ciudad from ciudades where cod_ciudad='".$codigo."'";
		$resp=mysql_query($sql);
		while($dat=mysql_fetch_array($resp))
		{	$nombre=$dat[0];
		}
	return($nombre);
}/*
function estadoImpFabSql($codigo)
{	require("conexion.inc");
		$nombre="";
		$sql="select nombre_estado_imp_fab from estados_imp_fab where cod_estado_imp_fab='".$codigo."'";
		$resp=odbc_exec($con,$sql);
		$nombre=odbc_result($resp,"nombre_estado_imp_fab");
	return($nombre);
}
function nombreContactoSql($codigo)
{	require("conexion.inc");
		$nombre="";
		$sql="select  ap_paterno_contacto, ap_materno_contacto, nombre_contacto ";
		$sql=$sql." from contactos where cod_contacto='".$codigo."'";
		$resp=odbc_exec($con,$sql);
		$nombre=odbc_result($resp,"ap_paterno_contacto")." ".odbc_result($resp,"ap_materno_contacto")." ".odbc_result($resp,"nombre_contacto");
	return($nombre);
}
function nombreUsuarioSql($codigo)
{	require("conexion.inc");
		$nombre="";
		$sql="select  ap_paterno_usuario, ap_materno_usuario, nombre_usuario ";
		$sql=$sql." from usuarios where cod_usuario='".$codigo."'";
		$resp=odbc_exec($con,$sql);
		$nombre=odbc_result($resp,"ap_paterno_usuario")." ".odbc_result($resp,"ap_materno_usuario")." ".odbc_result($resp,"nombre_usuario");
	return($nombre);
}
function nombreTipoCigarrilloSql($codigo)
{	require("conexion.inc");
		$nombre="";
		$sql="select  nombre_tipo_cigarrillo ";
		$sql=$sql." from tipos_cigarrillo where cod_tipo_cigarrillo='".$codigo."'";
		$resp=odbc_exec($con,$sql);
		$nombre=odbc_result($resp,"nombre_tipo_cigarrillo");
	return($nombre);
}
function nombreEmpPrimCantSql($codigo)
{	require("conexion.inc");
		$nombre="";
		$sql="select  cant_emp_prim_cant ";
		$sql=$sql." from empaque_primario_cantidades where cod_emp_prim_cant='".$codigo."'";
		$resp=odbc_exec($con,$sql);
		$nombre=odbc_result($resp,"cant_emp_prim_cant");
	return($nombre);
}*/
function empresaContactoSql($codigo)
{	require("conexion1.inc");
		$nombre="";
		$sql="select  rotulo_comercial ";
		$sql=$sql." from empresas where cod_empresa in (select cod_empresa from contactos where cod_contacto='".$codigo."')";
		$resp=mysql_query($sql);
		while($dat=mysql_fetch_array($resp))
		{	$nombre=$dat[0];
		}
	
	return($nombre);
}

?>