<?php 
	require("conexion.inc");
	include("funciones.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>INVENTA</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function cancelar(){
			window.location="listOrdenTrabajo.php";
			//window.close();
	}
</script></head>
<body bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->


<form name="form1" id="form1" method="post" action="newGastoOrdenTrabajo.php">

<input type="hidden" name="cod_orden_trabajo" id="cod_orden_trabajo" value="<?php echo $_GET['cod_orden_trabajo'];?>">
 <?php
		$sql=" select nro_orden_trabajo, numero_orden_trabajo, cod_gestion, fecha_orden_trabajo, cod_cliente,";	
		$sql.="  cod_contacto, monto_orden_trabajo,detalle_orden_trabajo,";
		$sql.=" incremento_orden_trabajo, incremento_fecha, incremento_obs,";
		$sql.=" descuento_orden_trabajo, descuento_fecha, descuento_obs ";
		$sql.=" from ordentrabajo";
		$sql.=" where cod_orden_trabajo=".$_GET['cod_orden_trabajo'];
		$resp = mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){

			$nro_orden_trabajo=$dat['nro_orden_trabajo'];
			$numero_orden_trabajo=$dat['numero_orden_trabajo'];
			$cod_gestion=$dat['cod_gestion'];
			$fecha_orden_trabajo=$dat['fecha_orden_trabajo'];
			$cod_cliente=$dat['cod_cliente'];
			$cod_contacto=$dat['cod_contacto'];
 			$monto_orden_trabajo=$dat['monto_orden_trabajo'];
			$detalle_orden_trabajo=$dat['detalle_orden_trabajo'];
			$incremento_orden_trabajo=$dat['incremento_orden_trabajo'];
			$incremento_fecha=$dat['incremento_fecha'];
			$incremento_obs=$dat['incremento_obs'];
			$descuento_orden_trabajo=$dat['descuento_orden_trabajo'];
			$descuento_fecha=$dat['descuento_fecha'];
			$descuento_obs=$dat['descuento_obs'];

			    $sql2="  select gestion from gestiones ";
				$sql2.=" where cod_gestion=".$cod_gestion;
				$resp2= mysql_query($sql2);
				$gestion="";
				while($dat2=mysql_fetch_array($resp2)){
					$gestion=$dat2['gestion'];
				}
				

			    $sql2="  select nombre_cliente from clientes ";
				$sql2.=" where cod_cliente=".$cod_cliente;
				$resp2= mysql_query($sql2);
				$nombre_cliente="";
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_cliente=$dat2['nombre_cliente'];
				}
				if($cod_contacto<>"" and $cod_contacto<>0){
				    $sql2="  select nombre_contacto, ap_paterno_contacto, ap_materno_contacto ";
					$sql2.=" from clientes_contactos ";
					$sql2.=" where cod_contacto=".$cod_contacto;
					$resp2= mysql_query($sql2);
					$nombre_completo_contacto="";
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_completo_contacto=$dat2['nombre_contacto']." ".$dat2['ap_paterno_contacto']." ".$dat2['ap_materno_contacto'];

					}
				}
	 	} 
?>
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">COSTOS INTERNOS  DE ORDEN DE TRABAJO<?php echo " Nro. ".$nro_orden_trabajo."/".$gestion." (".$numero_orden_trabajo.")"; ?></br> CLIENTE: <?php echo $nombre_cliente;
if($nombre_completo_contacto<>""){
	echo " (Contacto:".$nombre_completo_contacto.")";
	}
?></h3>
<div align="center"><a href="../reportes/impresionOrdenTrabajo.php?cod_orden_trabajo=<?php echo $_GET['cod_orden_trabajo']; ?>" target="_blank">VER ORDEN DE TRABAJO</a></div>
<div align="center"><a href="../reportes/infOrdenTrabajo.php?cod_orden_trabajo=<?php echo $_GET['cod_orden_trabajo']; ?>" target="_blank">VER INFORME</a></div>
      <br/>

 <div id="resultados" align="center">   
<?php

	$sql=" select count(*)";
	$sql.=" from gastos_ordentrabajo ";
	$sql.=" where  cod_orden_trabajo=".$_GET['cod_orden_trabajo'];


	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$nro_filas_sql=$dat[0];
	}
?>
	<div id="nroRows" align="center" class="textoform"><?php echo "Nro. de Registros: ".$nro_filas_sql; ?></div>
    <br/>
<?php
	if($nro_filas_sql==0){
?>
	<table width="60%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
            <td>Gasto</td>
			<td>Monto</td>																		
		</tr>
		<tr><th colspan="2" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
	</table>
	
<?php	
	}else{
		$sql=" select cod_gasto_ordentrabajo, cod_gasto, descripcion_gasto,monto_gasto, cant_gasto, ";
		$sql.=" fecha_gasto, cod_proveedor, cod_contacto_proveedor, recibo_gasto, cod_usuario_registro, ";
		$sql.=" fecha_registro,cod_usuario_modifica, fecha_modifica";
		$sql.=" from gastos_ordentrabajo";
		$sql.=" where cod_orden_trabajo=".$_GET['cod_orden_trabajo'];
		$sql.=" order by fecha_gasto desc";
		$resp = mysql_query($sql);

?>	

	<table width="60%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">

			</tr>     
	    <tr height="20px" align="center"  class="titulo_tabla">
            <td>Fecha Costo </td>
			<td>Trabajo</td>
            <td>Descripcion</td>
            <td>Cantidad</td>
            <td>Proveedor</td>	
            <td>Recibo</td>
            <td>Monto</td>	
            <td>&nbsp;</td>	
            <td>&nbsp;</td>																					
		</tr>

<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){
		
				$cod_gasto_ordentrabajo=$dat['cod_gasto_ordentrabajo'];
				$cod_gasto=$dat['cod_gasto'];
				$descripcion_gasto=$dat['descripcion_gasto'];
				$monto_gasto=$dat['monto_gasto'];
				$cant_gasto=$dat['cant_gasto'];
				$fecha_gasto=$dat['fecha_gasto'];
				$cod_proveedor=$dat['cod_proveedor'];
				$cod_contacto_proveedor=$dat['cod_contacto_proveedor']; 
				$recibo_gasto=$dat['recibo_gasto'];
				$cod_usuario_registro=$dat['cod_usuario_registro'];
				$fecha_registro=$dat['fecha_registro'];
				$cod_usuario_modifica=$dat['cod_usuario_modifica'];
				$fecha_modifica=$dat['fecha_modifica'];
				/////////////////////////
				$desc_gasto="";
				$sql2=" select desc_gasto from gastos where  cod_gasto=".$cod_gasto;
				$resp2 = mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$desc_gasto=$dat2['desc_gasto'];
				}
				$nombre_proveedor="";
				$sql2=" select nombre_proveedor from proveedores where  cod_proveedor=".$cod_proveedor;
				$resp2 = mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_proveedor=$dat2['nombre_proveedor'];
				}	
				$contactoProveedor="";
				if($cod_contacto_proveedor<>"" and $cod_contacto_proveedor<>0){
					$sql2=" select nombre_contacto, ap_paterno_contacto, ap_materno_contacto ";
					$sql2.=" from proveedores_contactos ";
					$sql2.=" where  cod_contacto_proveedor=".$cod_contacto_proveedor;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$contactoProveedor=$dat2['nombre_contacto']." ".$dat2['ap_paterno_contacto'];
					}
				}
				///////////////////////		
								
?> 
		<tr bgcolor="#FFFFFF">	
            <td><?php echo strftime("%d/%m/%Y",strtotime($fecha_gasto)); ?></td>
			<td><?php echo $desc_gasto; ?></td>
            <td><?php echo $descripcion_gasto; ?></td>
            <td><?php echo $cant_gasto; ?></td>
            <td><?php echo $nombre_proveedor;
				if($contactoProveedor<>""){
				echo " (Contacto:".$contactoProveedor.")";		
				}
			 ?></td>	
            <td><?php echo $recibo_gasto; ?></td>
            <td align="right"><?php echo $monto_gasto;?></td>
            <td align="center"><a href="editGastoOrdenTrabajo.php?cod_gasto_ordentrabajo=<?php echo $cod_gasto_ordentrabajo;?>&cod_orden_trabajo=<?php echo $_GET['cod_orden_trabajo'];?>">Editar</a></td>		
            <td align="center"><a href="eliminarGastoOrdenTrabajo.php?cod_gasto_ordentrabajo=<?php echo $cod_gasto_ordentrabajo;?>&cod_orden_trabajo=<?php echo $_GET['cod_orden_trabajo'];?>"">Eliminar</a></td>		
					
   	  </tr>
<?php
		 } 
?>		

  </table>
		</div>			
<?php
	}
?>
</div>	
	<br>
<div align="center">
<INPUT type="button"  class="boton"  name="btn_atras" value="IR A ORDENES DE TRABAJO" onClick="cancelar();"  >
<INPUT type="submit" class="boton" name="btn_guardar" value="NUEVO COSTO">

</div>
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
