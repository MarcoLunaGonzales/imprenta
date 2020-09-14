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

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
</head>
<body >
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="editOrdenTrabajo.php" name="form1">

<?php

	$cod_orden_trabajo=$_GET['cod_orden_trabajo']; 
	
	$sql=" select  ot.nro_orden_trabajo, ot.cod_gestion, g.gestion, ot.cod_est_ot, ";
	$sql.=" eo.desc_est_ot, ot.numero_orden_trabajo, ot.fecha_orden_trabajo, ot.cod_cliente, cli.nombre_cliente, ";
	$sql.=" ot.detalle_orden_trabajo, ot.obs_orden_trabajo, ot.monto_orden_trabajo, ot.cod_usuario_registro, ot.fecha_registro,";
	$sql.=" ot.cod_usuario_modifica, ot.fecha_modifica ";
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
		
	}

	
?>
<input type="hidden" name="cod_orden_trabajo" id="cod_factura" value="<?php echo $cod_orden_trabajo;?>">
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">DETALLE DE ORDEN DE TRABAJO</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="50%" bgColor="#cccccc" border="0">
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

        						
		</tbody>
	</table>	
	<br>
<div align="center">
<INPUT type="button" class="boton" name="btn_guardar" value="IR A LISTADO DE ORDENES DE TRABAJO" onClick="cancelar();"  >
<INPUT type="submit" class="boton" name="btn_guardar" value="EDITAR DATOS"  >
</div>
</form>

</body>
</html>
