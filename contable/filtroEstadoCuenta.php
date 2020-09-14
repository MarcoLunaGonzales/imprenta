
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml version="1.0" encoding="ISO-8859-1">
<head>
<meta http-equiv="Content-Type" content="application/json; text/html; charset=iso-8859-1" />
<title>INVENTA</title>
<link rel="stylesheet" type="text/css" href="pagina.css" />
<script type="text/javascript" src="ajax/searchAjax.js"></script>
<script type="text/javascript">
function abrirVentana(){


	window.open("prueba.html",'ESTADO DE CUENTAS POR COBRAR','top=50,left=200,width=800,height=600,scrollbars=1,resizable=1');
}
function buscarCuenta(numDetalleCbte){

		izquierda = (screen.width) ? (screen.width-600)/2 : 100;

	    arriba = (screen.height) ? (screen.height-400)/2 : 100;

		
		url="ajax_listCuentas2.php?numDetalleCbte="+numDetalleCbte;

		opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=650,left='+izquierda+',top=' + arriba + '';

	   	window.open(url, 'popUp', opciones);
	

}
function setCuentas(numero,cod_cuenta,nro_cuenta,desc_cuenta){

	document.getElementById('cod_cuenta'+numero).value=cod_cuenta;

	document.getElementById('div_nro_cuenta'+numero).innerHTML=nro_cuenta;
document.getElementById('div_desc_cuenta'+numero).innerHTML=desc_cuenta;
			
	}
	function validarDatos(f){
	
		if(document.getElementById('cod_cuenta0').value!=0){
			f.submit();
		}else{
			alert("Seleccione una Cuenta para el reporte");
		}
	}

</script>
</head>
<body bgcolor="#FFFFFF">

<form id="form1" name="form1" method="post" action="../reportes/rptEstadoCuenta.php" target="_blank" >

<?php 
	require("conexion.inc");
	include("funciones.php");

	

?>
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">FILTRO ESTADO CUENTA  </h3>
<h3 align="center" style="background:#FFF;font-size: 12px;color: #E78611;font-weight:bold;">&nbsp;</h3>
<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
     <tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="4" align="center">Parametros de Reporte</td>
		 </tr>
	 <tr bgcolor="#FFFFFF">
            <th align="left">Cuenta.:</th>
      		<td><a href="javascript:buscarCuenta(0)" >Buscar</a>
<input type="hidden" name="cod_cuenta0" id="cod_cuenta0" value="0"></td>
<td><div id="div_nro_cuenta0"></div></td>
<td><div id="div_desc_cuenta0"></div></td>
  
    	</tr>     
  

    <tr bgcolor="#FFFFFF">
     <th align="left">Rango de Fechas</th>
     <td colspan="3">Fecha Inicio <input type="text"name="fecha_inicio" id="fecha_inicio" class="textoform" size="20" value="<?php echo date("d/m/Y");?>"> Fecha Final <input type="text"name="fecha_final" id="fecha_final" class="textoform" size="20" value="<?php echo date("d/m/Y");?>">
     </td>

    
       
</table>
<br/>
<div align="center">
	<input type="button" class="boton" onclick="validarDatos(this.form)" value="Ver Reporte" >

</div>
</form>

</body>
</html>
