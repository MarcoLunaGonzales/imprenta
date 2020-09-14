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
			window.location="listHojasRutas.php";
	}
</script></head>
<body bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->


<form name="form1" id="form1" method="post" action="newGastoHojaRuta.php">
<?php
 $cod_hoja_ruta=$_GET['cod_hoja_ruta'];
 ?>
 <input type="hidden" name="cod_hoja_ruta" id="cod_hoja_ruta" value="<?php echo $cod_hoja_ruta;?>">
 <?php
 $sql=" select hr.nro_hoja_ruta, hr.cod_gestion, g.gestion, hr.cod_cotizacion, ";
 $sql.=" c.cod_cliente, cli.nombre_cliente ";
 $sql.=" from hojas_rutas hr, gestiones g, cotizaciones c, clientes cli ";
 $sql.=" where hr.cod_gestion=g.cod_gestion ";
 $sql.=" and  hr.cod_cotizacion=c.cod_cotizacion ";
 $sql.=" and c.cod_cliente=cli.cod_cliente ";
 $sql.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
 $resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$nro_hoja_ruta=$dat['nro_hoja_ruta'];
		$cod_gestion=$dat['cod_gestion'];
		$gestion=$dat['gestion'];
		$cod_cotizacion=$dat[''];
		$cod_cotizacion=$dat['cod_cotizacion'];
		$cod_cliente=$dat['cod_cliente'];
		$nombre_cliente=$dat['nombre_cliente'];
	} 
?>
<h3 align="center" style="background:#FFFFFF;font-size: 14px;color: #E78611;font-weight:bold;">COSTOS   DE HOJA DE RUTA <?php echo "Nro. ".$nro_hoja_ruta."/".$gestion; ?></br> CLIENTE: <?php echo $nombre_cliente;?></h3>
<div align="center"><a href="../reportes/impresionHojaRuta.php?cod_hoja_ruta=<?php echo $_GET['cod_hoja_ruta']; ?>" target="_blank">VER HOJA RUTA</a></div>
<div align="center"><a href="../reportes/infHojaRuta.php?cod_hoja_ruta=<?php echo $_GET['cod_hoja_ruta']; ?>" target="_blank">VER INFORME</a></div>

 <div id="resultados" align="center">   
<?php
	$sql=" select count(*)  ";
	$sql.=" from gastos_hojasrutas  ghr";
	$sql.=" left join proveedores p on (ghr.cod_proveedor=p.cod_proveedor)";
	$sql.=" left join gastos g on (ghr.cod_gasto=g.cod_gasto)";
	$sql.=" where ghr.cod_hoja_ruta=".$cod_hoja_ruta;

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
	
	$sql=" select ghr.cod_gasto_hojaruta, ghr.cod_gasto, g.desc_gasto, ghr.cod_hoja_ruta, ghr.monto_gasto, ghr.fecha_gasto, ghr.cant_gasto, ";
	$sql.=" ghr.descripcion_gasto, ghr.cod_proveedor, p.nombre_proveedor, ghr.recibo_gasto, ghr.cod_usuario_registro, ghr.fecha_registro,";
	$sql.=" ghr.cod_usuario_modifica,ghr.fecha_modifica  ";
	$sql.=" from gastos_hojasrutas  ghr";
	$sql.=" left join proveedores p on (ghr.cod_proveedor=p.cod_proveedor)";
	$sql.=" left join gastos g on (ghr.cod_gasto=g.cod_gasto)";
	$sql.=" where ghr.cod_hoja_ruta=".$cod_hoja_ruta;
	$sql.=" order by ghr.fecha_gasto desc";

		$resp = mysql_query($sql);

?>	

	<table width="60%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">

			</tr>     
	    <tr height="20px" align="center"  class="titulo_tabla">
            <td>Fecha </td>
			<td>Trabajo</td>
            <td>Descripcion</td>
            <td>Cantidad</td>
            <td>Proveedor</td>	
            <td>Nro Recibo </td>
            <td>Monto</td>	
            <td>&nbsp;</td>	
            <td>&nbsp;</td>																					
		</tr>

<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){
		
				$cod_gasto_hojaruta=$dat['cod_gasto_hojaruta'];
				$cod_gasto=$dat['cod_gasto'];
				$desc_gasto=$dat['desc_gasto'];
				$cod_hoja_ruta=$dat['cod_hoja_ruta'];
				$monto_gasto=$dat['monto_gasto'];
				$fecha_gasto=$dat['fecha_gasto'];
				$cant_gasto=$dat['cant_gasto'];
				$descripcion_gasto=$dat['descripcion_gasto'];
				$cod_proveedor=$dat['cod_proveedor'];
				$nombre_proveedor=$dat['nombre_proveedor'];
				$recibo_gasto=$dat['recibo_gasto'];
				$cod_usuario_registro=$dat['cod_usuario_registro'];
				$fecha_registro=$dat['fecha_registro'];
				$cod_usuario_modifica=$dat['cod_usuario_modifica'];
				$fecha_modifica=$dat['fecha_modifica'];
					
								
?> 
		<tr bgcolor="#FFFFFF">	
            <td><?php echo strftime("%d/%m/%Y",strtotime($fecha_gasto)); ?></td>
			<td><?php echo $desc_gasto; ?></td>
            <td><?php echo $descripcion_gasto; ?></td>
            <td><?php echo $cant_gasto; ?></td>
            <td><?php echo $nombre_proveedor; ?></td>	
            <td><?php echo $recibo_gasto; ?></td>
            <td align="right"><?php echo $monto_gasto;?></td>
            <td align="center"><a href="editGastoHojaRuta.php?cod_gasto_hojaruta=<?php echo $cod_gasto_hojaruta;?>">Editar</a></td>		
            <td align="center"><a href="eliminarGastoHojaRuta.php?cod_gasto_hojaruta=<?php echo $cod_gasto_hojaruta;?>">Eliminar</a></td>		
					
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
<INPUT type="button"  class="boton"  name="btn_atras" value="IR  A LISTADO DE HOJAS DE RUTA" onClick="cancelar();"  >
<INPUT type="submit" class="boton" name="btn_guardar" value="NUEVO COSTO">

</div>
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
