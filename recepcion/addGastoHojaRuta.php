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
	function cancelar(f){
			window.location="listGastoHojaRuta.php?cod_hoja_ruta="+f.cod_hoja_ruta.value;
	}
</script></head>
<body bgcolor="#F7F5F3">
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->


<form name="form1" id="form1" method="post" action="saveAddGastoHojaRuta.php">
<?php
 $cod_hoja_ruta=$_POST['cod_hoja_ruta'];
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
<h3 align="center" style="background:#F7F5F3;font-size: 14px;color: #E78611;font-weight:bold;">GASTOS DE HOJA DE RUTA <?php echo "Nro. ".$nro_hoja_ruta."/".$gestion; ?></br> CLIENTE: <?php echo $nombre_cliente;?></h3>
      <br/>

 <div id="resultados" align="center">   
<?php

	
	$sql=" select count(*)  ";
	$sql.=" from gastos g, estados_referenciales er ";
	$sql.=" where g.cod_estado_registro=er.cod_estado_registro ";	
	$sql.=" and g.cod_estado_registro=1";	

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
		$sql=" select g.cod_gasto, g.desc_gasto, g.obs_gasto, g.cod_estado_registro, ";
		$sql.=" er.nombre_estado_registro, g.cod_usuario_registro, g.fecha_registro, ";
		$sql.=" g.cod_usuario_modifica, g.fecha_modifica ";
		$sql.=" from gastos g, estados_referenciales er ";
		$sql.=" where g.cod_estado_registro=er.cod_estado_registro ";
		$sql.=" and g.cod_estado_registro=1";
		$sql.=" order by g.desc_gasto";
		$resp = mysql_query($sql);

?>	

	<table width="40%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">

			</tr>     
	    <tr height="20px" align="center"  class="titulo_tabla">
            <td>&nbsp;</td>	
            <td>Gasto</td>
			<td>Monto</td>																					
		</tr>

<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){
		
				$cod_gasto=$dat['cod_gasto'];
				$desc_gasto=$dat['desc_gasto'];
				$sqlAux=" select monto_gasto from gastos_hojasrutas ";
				$sqlAux.=" where cod_hoja_ruta=".$cod_hoja_ruta;
				$sqlAux.=" and cod_gasto=".$cod_gasto;
				$respAux = mysql_query($sqlAux);
				$sw=0;
				$monto_gasto=0;
				while($datAux=mysql_fetch_array($respAux)){
					$sw=1;
					$monto_gasto=$datAux['monto_gasto'];
				}
				
								
?> 
		<tr bgcolor="#FFFFFF">	
    		<td align="left">
            <input type="checkbox" name="cod_gasto<?php echo $cod_gasto;?>" id="cod_gasto<?php echo $cod_gasto;?>" <?php if($sw==1){?> checked="checked" <?php }?>>
            </td>
            <td align="left"><?php echo $desc_gasto;?></td>
    		<td align="right"><input  type="text" name="monto_gasto<?php echo $cod_gasto;?>" id="monto_gasto<?php echo $cod_gasto;?>" class="textoform" value="<?php echo $monto_gasto;?>"> </td>    							
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
<INPUT type="button"  class="boton"  name="btn_atras" value="IR  A LISTADO DE GASTOS DE HOJAS DE RUTA" onClick="cancelar(this.form);"  >
<INPUT type="submit" class="boton" name="btn_guardar" value="ACTUALIZAR GASTOS DE HOJA DE RUTA"  >

</div>
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
