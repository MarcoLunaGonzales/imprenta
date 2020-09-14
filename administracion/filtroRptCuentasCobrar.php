
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

<form id="form1" name="form1" method="post" action="rptCuentasCobrar.php" target="_blank" >

<?php 
	require("conexion.inc");
	include("funciones.php");

	

?>
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">REPORTE DE CUENTAS POR COBRAR</h3>
<h3 align="center" style="background:#FFF;font-size: 12px;color: #E78611;font-weight:bold;">&nbsp;</h3>
<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
     <tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Introduzca Datos</td>
		 </tr>
	 <tr bgcolor="#FFFFFF">
     		<td>Cliente</td>
      		<td>
            <select name="cod_cliente" id="cod_cliente" class="textoform"  >
				<option value="0">Seleccione un Opci&oacute;n</option>
				<?php
					
				$sql2=" select clientes.cod_cliente, clientes.nombre_cliente ";
				$sql2.=" from (select DISTINCT(c.cod_cliente)from hojas_rutas hr, cotizaciones c ";
				$sql2.=" where hr.cod_cotizacion=c.cod_cotizacion and hr.cod_estado_hoja_ruta<>2 and hr.cod_estado_pago_doc<>3";
				$sql2.=" UNION ";
				$sql2.=" select DISTINCT(cod_cliente) from ordentrabajo where cod_est_ot<>2 and ";
				$sql2.=" cod_estado_pago_doc<>3 ";
				$sql2.=" UNION ";
				$sql2.=" select DISTINCT(cod_cliente_venta) from salidas where cod_tipo_salida=1";
				$sql2.=" and cod_estado_salida=1 and cod_estado_pago_doc<>3) as clientesDeudores INNER JOIN clientes ";
				$sql2.="  on(clientesDeudores.cod_cliente=clientes.cod_cliente) ";
				$sql2.=" order by clientes.nombre_cliente asc ";				
				$resp2=mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2))
				{
							$cod_cliente=$dat2['cod_cliente'];	
			  		 		$nombre_cliente=$dat2['nombre_cliente'];	
				 ?>
                 <option value="<?php echo $cod_cliente;?>"><?php echo $nombre_cliente;?></option>				
				<?php		
				 }
				?>						
			</select>
</td>
    	</tr>     
  <tr bgcolor="#FFFFFF">
     		<td>Tipo Pago </td>
      		<td>
				<?php
					$sql2=" select cod_tipo_pago, nombre_tipo_pago from tipos_pago ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_tipo_pago=$dat2[0];	
			  		 		$nombre_tipo_pago=$dat2[1];	
				?>
				 <input type="checkbox" name="cod_tipo_pago<?php echo $cod_tipo_pago;?>" class="textoform" checked="true"><?php echo $nombre_tipo_pago; ?><br/>
				<?php
					}
				?>						

</td>
    	</tr>  

    <tr bgcolor="#FFFFFF">
     <td>Formato Fecha (dd/mm/yyyy)</td>
     <td>Fecha Inicio <input type="text"name="fecha_inicio" id="fecha_inicio" class="textoform" size="20" value="<?php echo date("d/m/Y");?>"> Fecha Final <input type="text"name="fecha_final" id="fecha_final" class="textoform" size="20" value="<?php echo date("d/m/Y");?>">
     </td>
       <tr bgcolor="#FFFFFF">
     		<td>Tipo de Documento </td>
      		<td>
            <select name="codtipodoc" id="codtipodoc" class="textoform"  >
				<option value="0">Todos los Tipos de Documentos</option>            
				<?php
					$sql2=" select cod_tipo_doc, desc_tipo_doc from tipo_documento ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_tipo_doc=$dat2[0];	
			  		 		$desc_tipo_doc=$dat2[1];	
				?>
                 <option value="<?php echo $cod_tipo_doc;?>"><?php echo $desc_tipo_doc;?></option>				
				<?php		
				 }
				?>						
			</select>					

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
