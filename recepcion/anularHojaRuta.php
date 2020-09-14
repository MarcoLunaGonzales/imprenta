<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>ANULAR HOJA DE RUTA</title>
<script language="Javascript"> 
function anular(f)
{
	if(f.obs_anular.value==""){
		alert("Debe llenar el Campo: Observaciones");
		f.obs_anular.focus();
		return false;
	}
	
	f.submit();		
}

function cancelar(f)
{
	location.href="navegadorHojasRutas.php";	
}
</script>
</head>
<body >
<form method="post"  name="form1" action="guardaAnularHojaRuta.php">

<?php 	
	require("conexion.inc");
	include("funciones.php");	
	$cod_hoja_ruta=$_GET['cod_hoja_ruta'];
?>
<input type="hidden" name="cod_hoja_ruta" value="<?php echo $cod_hoja_ruta;?>">
<?php
	

		$sql2="select nombres_usuario,ap_paterno_usuario from usuarios  where cod_usuario='".$_COOKIE['usuario_global']."'";	
		$resp2= mysql_query($sql2);
		$dat2=mysql_fetch_array($resp2);
		$usuarioAnulacion=$dat2[0]." ".$dat2[1]." ".$dat2[2];	
		

	$sql=" select  fecha_hoja_ruta, cod_usuario_hoja_ruta, ";
	$sql.=" obs_hoja_ruta, cod_cotizacion, cod_estado_hoja_ruta, factura_si_no, cod_usuario_comision ";
	$sql.=" from hojas_rutas ";
	$sql.=" where cod_hoja_ruta='".$cod_hoja_ruta."'";

	$resp= mysql_query($sql);
	$dat=mysql_fetch_array($resp);

	$fecha_hoja_ruta=$dat[0];
	$cod_usuario_hoja_ruta=$dat[1];
		$sql2="select nombres_usuario,ap_paterno_usuario from usuarios  where cod_usuario='".$cod_usuario_hoja_ruta."'";	
		$resp2= mysql_query($sql2);
		$dat2=mysql_fetch_array($resp2);
		$usuarioHojaRuta=$dat2[0]." ".$dat2[1]." ".$dat2[2];	
	$obs_hoja_ruta=$dat[2]; 
	$cod_cotizacion=$dat[3]; 
	$cod_estado_hoja_ruta=$dat[4]; 
	$factura_si_no=$dat[5];
	$cod_usuario_comision=$dat[6];
		$sql2="select nombres_usuario,ap_paterno_usuario from usuarios  where cod_usuario='".$cod_usuario_comision."'";	
		$resp2= mysql_query($sql2);
		$dat2=mysql_fetch_array($resp2);
		$usuarioComision=$dat2[0]." ".$dat2[1]." ".$dat2[2];			
	

		
		/********************DATOS COTIZACION********************/
			$sql2=" select nro_cotizacion, cod_gestion, cod_cliente, fecha_cotizacion ";
			$sql2.=" from cotizaciones ";
			$sql2.=" where cod_cotizacion=".$cod_cotizacion;
			$resp2= mysql_query($sql2);
			$dat2=mysql_fetch_array($resp2);
				$nro_cotizacion=$dat2[0];
				$cod_gestion=$dat2[1];
				$cod_cliente=$dat2[2];		
				$fecha_cotizacion=$dat2[3];	
				/***********GESTION********/
					$sql3="select gestion  from gestiones where cod_gestion='".$cod_gestion."'";
					$resp3= mysql_query($sql3);
					$dat3=mysql_fetch_array($resp3);
						$gestion=$dat3[0];
				/************************************/	
				/*******************CLIENTE*********************/	
					$sql3=" select nombre_cliente, direccion_cliente, telefono_cliente, celular_cliente, fax_cliente";
					$sql3.=" from clientes where cod_cliente='".$cod_cliente."'";
					$resp3= mysql_query($sql3);			
					$dat3=mysql_fetch_array($resp3);
						$nombre_cliente=$dat3[0];
						$direccion_cliente=$dat3[1];
						$telefono_cliente=$dat3[2];
						$celular_cliente=$dat3[3];
						$fax_cliente=$dat3[4];				
				/************************************/
		/******************FIN DATOS COTIZACION*********************/		

		
	?>
	
	<h3 align="center" style="background:white;font-size: 12px;color: #d20000;font-weight:bold;">ANULAR HOJA DE RUTA</h3>
		<h3 align="center" style="background:white;font-size: 12px;color: #d20000;font-weight:bold;">No. <?php echo $cod_hoja_ruta;?><br><?php echo $fecha_hoja_ruta;?></h3>
    
	<table  cellSpacing="1" cellPadding="2" width="70%" bgColor="#cccccc" border="0" id="tabla" align="center">
		<tr  bgcolor="#FFFFFF">
			<td  colSpan="2"  align="center">&nbsp;</td>
			<td  class="titulo_tabla" align="center">REF</td>
			<td  class="titulo_tabla" align="center">C</td>		
		</tr>
		<tr bgcolor="#FFFFFF">
     		<td>Cliente</td>
			<td><?php echo $nombre_cliente;?></td>
			<td rowspan="2" align="center"><?php echo $nro_cotizacion;?>/<?php echo $gestion;?></td>
			<td rowspan="2" align="center"><?php echo $factura_si_no;?></td>
		</tr>	
		<tr bgcolor="#FFFFFF">
     		<td>Telf.</td>
			<td><?php echo $telefono_cliente;?>/<?php echo $celular_cliente;?></td>
		</tr>	
		<tr bgcolor="#FFFFFF">
     		<td>Autorizado por</td>
			<td colspan="3"><?php echo $usuarioHojaRuta;?></td>
		</tr>	
		<tr bgcolor="#FFFFFF">
     		<td>Comision:</td>
			<td colspan="3"><?php echo $usuarioHojaRuta;?></td>
		</tr>									

		<tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
     		<td colspan="3"><?php echo $obs_hoja_ruta;?></td>
		</tr>	

		<tr bgcolor="#FFFFFF">
     		<td>Comisión</td>
     		<td colspan="3"><?php echo $usuarioComision;?></td>
		</tr>
		<tr bgcolor="#FFFFFF" class="titulo_tabla">
     		<td colspan="4" align="center">DATOS DE ANULACION</td>
		</tr>
		<tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
     		<td colspan="3"><textarea name="obs_anular" class="textoform" cols="60"></textarea></td>
		</tr>		
		<tr bgcolor="#FFFFFF">
     		<td>Usuario</td>
     		<td colspan="3"><?php echo $usuarioAnulacion;?></td>
		</tr>
		<tr bgcolor="#FFFFFF">
     		<td>Fecha</td>
     		<td colspan="3"><?php echo date('d/m/Y h:i:s', time());?></td>
		</tr>
		</table>					
	  <br>
	  
<div align="center">

	<input type="button"  class="boton" name="btn1" value="Continuar" onclick="anular(this.form)">
	<input type="button"  class="boton" name="btn2" value="Cancelar" onclick="cancelar(this.form)">
</div>

</form>

</body>
</html>
