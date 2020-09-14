<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>MODULO DE ALMACENES</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script language='Javascript'>
	function nuevoAjax()
	{	var xmlhttp=false;
 		try {
 			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	 	} catch (e) {
 			try {
 				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
 			} catch (E) {
 				xmlhttp = false;
 			}
	  	}
		if (!xmlhttp && typeof XMLHttpRequest!="undefined") {
 			xmlhttp = new XMLHttpRequest();
		}
		return xmlhttp;
	}
function buscarMaterial( numMaterial){

		izquierda = (screen.width) ? (screen.width-600)/2 : 100;

	    arriba = (screen.height) ? (screen.height-400)/2 : 100;

		
		url="ajax_listMaterial_Auxiliar.php";

		opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=650,left='+izquierda+',top=' + arriba + '';

	   	window.open(url, 'popUp', opciones);
	

}
function setMateriales(cod, nombreMat){

	
	document.getElementById('desc_material').value=nombreMat;
	document.getElementById('cod_material').value=cod;
	
	
		

		
	
}	
</script>
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF">
<h3 align="center" style="background:#FFFFFF;font-size: 14px;color: #E78611;font-weight:bold;">KARDEX DE MOVIMIENTO</h3>
<h3 align="center" style="background:#FFFFFF;font-size: 11px;color: #663300;font-weight:bold;">Seleccione los Parametros del Reporte</h3>
<form name="form1" method="post" action="rptKardexMovimiento.php" target="_blank">
<?php
	require("conexion.inc");
	include("funciones.php");
?>
<table align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
       
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td colspan="2">Introduzca los Parametros de Busqueda</td>									
		</tr>
        
<tr>
<td class="fila_par" align="left"><strong>Material:</strong></td>
<td class="fila_par" align="left">
<a href="javascript:buscarMaterial()" >Buscar</a>
<input type="hidden" name="cod_material" id="cod_material" value="0">
<input type="text" class="textoform" id="desc_material" name="desc_material" size="70" readonly>
</td>
</tr>
<td class="fila_par" align="left"><strong>Fecha Inicio (dd/mm/aaaa):</strong></td>
<td class="fila_par" align="left"><input type="text" name="fecha_inicio" id="fecha_inicio" class="textoform" value="<?php echo date("d/m/Y");?>"></td>

</tr>
<tr>
<td class="fila_par" align="left"><strong>Fecha Final (dd/mm/aaaa):</strong></td>
<td class="fila_par" align="left"><input type="text" name="fecha_final" id="fecha_final" class="textoform" value="<?php echo date("d/m/Y");?>"></td>

</tr>
</table>
		
<?php require("cerrar_conexion.inc");
?>
<br>
<div align="center">
	<INPUT type="submit" class="boton" name="btn_editar"  value="Aceptar">
</div>

</form>

</body>
</html>
