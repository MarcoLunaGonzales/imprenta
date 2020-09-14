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
			window.location="listFacturas.php";
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
<form   method="post" action="editFactura.php" name="form1">

<?php

	$cod_factura=$_GET['cod_factura']; 
	
	$sql=" select nro_factura, nombre_factura,nit_factura, fecha_factura, detalle_factura, ";
	$sql.=" obs_factura, cod_est_fac, monto_factura, cod_usuario_registro, fecha_registro, cod_usuario_modifica, fecha_modifica ";
	$sql.=" from facturas";
	$sql.=" where cod_factura=".$cod_factura;
    $resp= mysql_query($sql);	
	while($dat=mysql_fetch_array($resp)){
		
		$nro_factura=$dat['nro_factura'];
		$nombre_factura=$dat['nombre_factura'];
		$nit_factura=$dat['nit_factura'];
		$fecha_factura=$dat['fecha_factura'];
		$detalle_factura=$dat['detalle_factura'];
		$obs_factura=$dat['obs_factura'];
		$cod_est_fac=$dat['cod_est_fac'];
		$monto_factura=$dat['monto_factura'];
		$cod_usuario_registro=$dat['cod_usuario_registro'];
		$fecha_registro=$dat['fecha_registro'];
		$cod_usuario_modifica=$dat['cod_usuario_modifica'];
		$fecha_modifica=$dat['fecha_modifica'];
		
	}
		$sql2=" select desc_est_fac from estado_factura where cod_est_fac='".$cod_est_fac."'";
    $resp2 = mysql_query($sql2);	
	$desc_est_fac="";
	while($dat2=mysql_fetch_array($resp2)){
		$desc_est_fac=$dat2[0];
	}
	
///Datos Hoja Ruta////
	$queryFacHojaRuta="select cod_hoja_ruta from factura_hojaruta where cod_factura=".$cod_factura;
	$resp3 = mysql_query($queryFacHojaRuta);
	$cod_hoja_ruta=0;
	while($dat3=mysql_fetch_array($resp3)){
		$cod_hoja_ruta=$dat3['cod_hoja_ruta'];
	}
	
	if($cod_hoja_ruta<>0){
		$sql3=" select  hr.cod_gestion, hr.nro_hoja_ruta, g.gestion , hr.fecha_hoja_ruta, hr.cod_cotizacion, ";
		$sql3.=" c.cod_cliente, cli.nombre_cliente, cli.nit_cliente,  hr.cod_estado_hoja_ruta, ";
		$sql3.=" ehr.nombre_estado_hoja_ruta";
		$sql3.=" from hojas_rutas hr, gestiones g, estados_hojas_rutas ehr, cotizaciones c, clientes cli ";
		$sql3.=" where hr.cod_gestion=g.cod_gestion ";
		$sql3.=" and hr.cod_estado_hoja_ruta=ehr.cod_estado_hoja_ruta ";
		$sql3.=" and hr.cod_cotizacion=c.cod_cotizacion ";
		$sql3.=" and c.cod_cliente=cli.cod_cliente ";
		$sql3.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
		$resp3 = mysql_query($sql3);
		while($dat3=mysql_fetch_array($resp3)){
				$cod_gestion=$dat3['cod_gestion'];
				$nro_hoja_ruta=$dat3['nro_hoja_ruta'];
				$gestion=$dat3['gestion'];
				$fecha_hoja_ruta=$dat3['fecha_hoja_ruta'];
				$cod_cotizacion=$dat3['cod_cotizacion'];
				$cod_cliente=$dat3['cod_cliente'];
				$nombre_cliente=$dat3['nombre_cliente'];
				$nit_cliente=$dat3['nit_cliente'];
				$cod_estado_hoja_ruta=$dat3['cod_estado_hoja_ruta'];
				$nombre_estado_hoja_ruta=$dat3['nombre_estado_hoja_ruta'];
		}
		 
	}
                				
				///Fin Datos Hoja Ruta//	

?>
<input type="hidden" name="cod_factura" id="cod_factura" value="<?php echo $cod_factura;?>">
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">DETALLE DE FACTURA</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="50%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td width="25%">Nro Factura</td>
      		<td width="75%"><?php echo $nro_factura;?></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha Factura</td>
      		<td><?php echo strftime("%d/%m/%Y",strtotime($fecha_factura));?></td>
    	</tr>        
		 <tr bgcolor="#FFFFFF">
     		<td>Nombre</td>
      		<td><?php echo $nombre_factura;?></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>NIT</td>
      		<td><?php echo $nit_factura;?></td>
    	</tr>   
		 <tr bgcolor="#FFFFFF">
     		<td>Detalle</td>
      		<td><?php echo $detalle_factura;?></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Monto</td>
      		<td><?php echo $monto_factura;?></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
      		<td><?php echo $obs_detalle;?></td>
    	</tr>                              
		<tr bgcolor="#FFFFFF">
     		<td>Estado de Factura</td>
      		<td><?php echo $desc_est_fac;?></td>
    	</tr>
        <?php if($cod_hoja_ruta<>0){?>	
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Datos de Hoja Ruta</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td width="25%">Nro Hoja Ruta</td>
      		<td width="75%"><?php echo $nro_hoja_ruta."/".$gestion;?></td>
    	</tr>        
		 <tr bgcolor="#FFFFFF">
     		<td width="25%">Cliente</td>
      		<td width="75%"><?php echo $nombre_cliente;?></td>
    	</tr>          
         <?php 
		 }?>	
										
		</tbody>
	</table>	
	<br>
<div align="center">
<INPUT type="button" class="boton" name="btn_guardar" value="IR A LISTADO DE FACTURAS" onClick="cancelar();"  >
<INPUT type="submit" class="boton" name="btn_guardar" value="EDITAR DATOS"  >
</div>
</form>

</body>
</html>
