<?php
	require("conexion.inc");
	


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>INVENTA</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script language='Javascript'>

	function cancelar(){
			window.location="listOrdenTrabajo.php";
	}
	
	function anular(f)
	{
		if(f.obs_anulacion.value==""){
			alert("Debe describir la razon por la que se anula la Orden de Trabajo");
			f.obs_anulacion.focus();
			return false;
		}
	
		f.submit();		
	}
		

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF" >
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="saveAnularOrdenTrabajo.php" name="form1">

<?php

	$cod_orden_trabajo=$_GET['cod_orden_trabajo']; 
	
	$sql=" select  ot.nro_orden_trabajo, ot.cod_gestion, g.gestion, ot.cod_est_ot, ";
	$sql.=" eo.desc_est_ot, ot.numero_orden_trabajo, ot.fecha_orden_trabajo, ot.cod_cliente, cli.nombre_cliente, ";
	$sql.=" ot.detalle_orden_trabajo, ot.obs_orden_trabajo, ot.monto_orden_trabajo, ot.cod_usuario_registro, ot.fecha_registro,";
	$sql.=" ot.cod_usuario_modifica, ot.fecha_modifica, ot.cod_tipo_pago, ot.cod_estado_pago_doc ";
	$sql.=" from ordentrabajo ot, gestiones g, estado_ordentrabajo eo, clientes cli ";
	$sql.=" where ot.cod_gestion=g.cod_gestion ";
	$sql.=" and ot.cod_est_ot=eo.cod_est_ot ";
	$sql.=" and ot.cod_cliente=cli.cod_cliente ";
	$sql.=" and ot.cod_orden_trabajo=".$cod_orden_trabajo;
    $resp= mysql_query($sql);	
	while($dat=mysql_fetch_array($resp)){
		
		$nro_orden_trabajo=$dat['nro_orden_trabajo'];
		$cod_gestion=$dat['cod_gestion'];
		$gestion=$dat['gestion'];
		$cod_est_ot=$dat['cod_est_ot'];
		$desc_est_ot=$dat['desc_est_ot'];
		$numero_orden_trabajo=$dat['numero_orden_trabajo'];
		$fecha_orden_trabajo=$dat['fecha_orden_trabajo'];
		$cod_cliente=$dat['cod_cliente'];
		$nombre_cliente=$dat['nombre_cliente'];
		$detalle_orden_trabajo=$dat['detalle_orden_trabajo'];
		$obs_orden_trabajo=$dat['obs_orden_trabajo'];
		$monto_orden_trabajo=$dat['monto_orden_trabajo'];
		$cod_usuario_registro=$dat['cod_usuario_registro'];
		$fecha_registro=$dat['fecha_registro'];
		$cod_usuario_modifica=$dat['cod_usuario_modifica'];
		$fecha_modifica=$dat['fecha_modifica'];
		$cod_tipo_pago=$dat['cod_tipo_pago'];
		$cod_estado_pago_doc=$dat['cod_estado_pago_doc']; 
		
		$nombre_tipo_pago="";
		$sql2="select nombre_tipo_pago from tipos_pago where cod_tipo_pago=".$cod_tipo_pago;
		$resp2= mysql_query($sql2);	
		while($dat2=mysql_fetch_array($resp2)){
			$nombre_tipo_pago=$dat2['nombre_tipo_pago'];
		}
		
		$desc_estado_pago_doc="";
		$sql2="select desc_estado_pago_doc from estado_pago_documento where cod_estado_pago_doc=".$cod_estado_pago_doc;
		$resp2= mysql_query($sql2);	
		while($dat2=mysql_fetch_array($resp2)){
			$desc_estado_pago_doc=$dat2['desc_estado_pago_doc'];
		}
		
		
	}

	
?>
<input type="hidden" name="cod_orden_trabajo" id="cod_factura" value="<?php echo $cod_orden_trabajo;?>">
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">ANULACION  DE ORDEN DE TRABAJO</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4"  bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Datos</td>
		 </tr>
	
<tr bgcolor="#FFFFFF">
     		<td>Numero Interno</td>
      		<td><?php echo $numero_orden_trabajo;?></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha Orden de Trabajo</td>
      		<td><?php echo strftime("%d/%m/%Y",strtotime($fecha_orden_trabajo));?></td>
    	</tr>        
		 <tr bgcolor="#FFFFFF">
     		<td>Cliente</td>
      		<td><?php echo $nombre_cliente;	?></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Monto</td>
      		<td><?php echo $monto_orden_trabajo; ?></td>
    	</tr> 
        <tr bgcolor="#FFFFFF">
     		<td>Tipo de Pago</td>
      		<td><?php echo $nombre_tipo_pago; ?></td>
    	</tr>   
		 <tr bgcolor="#FFFFFF">
     		<td>Detalle</td>
      		<td><?php echo  $detalle_orden_trabajo; ?></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
      		<td><?php echo  $obs_orden_trabajo; ?></td>
    	</tr>                              
		<tr bgcolor="#FFFFFF">
     		<td>Estado de Registro</td>
      		<td><?php echo $desc_est_ot;?></td>
    	</tr>
		<tr bgcolor="#FFFFFF">
     		<td>Estado de Pago</td>
      		<td><?php echo $desc_estado_pago_doc;?></td>
    	</tr>        		
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Datos de Anulaci&oacute;n</td>
		 </tr>  
		<tr bgcolor="#FFFFFF">
     		<td>Razon  de Anulacion</td>
      		<td><textarea name="obs_anulacion" id="obs_anulacion" cols="60" rows="1"></textarea></td>
    	</tr>                  						
		</tbody>
	</table>	
	<br>
<div align="center">
<INPUT type="button" class="boton" name="btn_guardar" value="IR A LISTADO DE ORDENES DE TRABAJO" onClick="cancelar();"  >
<INPUT type="button" class="boton" name="btn_anular" value="ACEPTAR ANULACION" onClick="anular(this.form);" >
</div>
</form>

</body>
</html>
