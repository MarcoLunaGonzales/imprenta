
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


</script>
</head>
<body bgcolor="#FFFFFF">

<form id="form1" name="form1" method="post" action="../reportes/rptLibroDiario.php" target="_blank" >

<?php 
	require("conexion.inc");
	include("funciones.php");

	

?>
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">REPORTE DE LIBRO DIARIO </h3>
<h3 align="center" style="background:#FFF;font-size: 12px;color: #E78611;font-weight:bold;">&nbsp;</h3>
<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
     <tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Parametros de Reporte</td>
		 </tr>
	 <tr bgcolor="#FFFFFF">
            <th align="left">Tipo Cbte.:</th>
      		<td><select name="cod_tipo_cbte" id="cod_tipo_cbte" class="textoform" onChange="generaNroComprobante(this.form)">		
	            <option value="0">Todos</option>		
				<?php
					$sql2="select cod_tipo_cbte, nombre_tipo_cbte from tipo_comprobante ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_tipo_cbte=$dat2['cod_tipo_cbte'];		
			  		 		$nombre_tipo_cbte=$dat2['nombre_tipo_cbte'];	
				 ?><option value="<?php echo $cod_tipo_cbte;?>"><?php echo $nombre_tipo_cbte;?></option>				
				<?php		
					}
				?>						
			</select></td>  
    	</tr>     
  

    <tr bgcolor="#FFFFFF">
     <th align="left">Rango de Fechas</th>
     <td>Fecha Inicio <input type="text"name="fecha_inicio" id="fecha_inicio" class="textoform" size="20" value="<?php echo date("d/m/Y");?>"> Fecha Final <input type="text"name="fecha_final" id="fecha_final" class="textoform" size="20" value="<?php echo date("d/m/Y");?>">
     </td>
</tr>
</table>
<br/>
<div align="center">
	<input type="submit" class="boton" value="Ver Reporte" >

</div>
</form>

</body>
</html>
