<?php

header("Cache-Control: no-store, no-cache, must-revalidate");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
</head>

<body>
<?php 

require("conexion.inc");
include("funciones.php");
	$cod_tipo_salida=$_GET['cod_tipo_salida'];
	$cod_almacen=$_GET['cod_almacen'];
?>

<?php if($cod_tipo_salida==1){?>
<table border="0" cellpadding="1" cellspacing="1">
<tr>
	<td align="left"><strong>Tipo de Pago</strong></td>
<td><select name="cod_tipo_pago" id="cod_tipo_pago" class="textoform">
				<?php
					$sql2=" select cod_tipo_pago, nombre_tipo_pago ";
					$sql2.=" from tipos_pago ";
					$sql2.=" where cod_tipo_pago=1 or cod_tipo_pago=2";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_tipo_pago=$dat2['cod_tipo_pago'];	
			  		 		$nombre_tipo_pago=$dat2['nombre_tipo_pago'];	
				 ?>
 
					 <option value="<?php echo $cod_tipo_pago;?>"><?php echo $nombre_tipo_pago;?></option>							 
				<?php		
					}
				?>						
			</select>
</td>
</tr>
<tr>
<td><strong>Cliente</strong></td>
<td>
<input type="hidden" name="cod_cliente_venta" id="cod_cliente_venta" value="0" >
<input type="text" class="textoform" id="nombre_cliente_venta" name="nombre_cliente_venta" size="40" readonly>
<a href="javascript:buscarCliente()" accesskey="B">[Buscar Cliente]</strong></a>
<a  href="javascript:cargar_cliente();">[Nuevo Cliente]</a>
<a  href="javascript:datosCliente(this.form);">[Datos Cliente]</a>
</td>
</tr>
<tr><td align="left"><strong>Contacto</strong></td><td><div id="div_contactoCliente">
<select name="cod_contacto" id="cod_contacto" class="textoform" disabled>
<option value="0">----</option>

</select>
</div></td></tr>
</table>

<?php } ?>

<?php if($cod_tipo_salida==2){?>

						<select name="cod_hoja_ruta" id="cod_hoja_ruta" class="textoform" onChange="verHojaRuta(this.form)" >
				<option value="0">Seleccione una opcion</option>	
              <?php
					$sql2=" select hr.cod_hoja_ruta,hr.nro_hoja_ruta,hr.cod_gestion,g.gestion,hr.cod_cotizacion,c.cod_cliente, ";
					$sql2.=" cli.nombre_cliente ";
					$sql2.=" from hojas_rutas hr, cotizaciones c, clientes cli, gestiones g ";
					$sql2.=" where hr.cod_gestion=g.cod_gestion ";
					$sql2.=" and hr.cod_cotizacion=c.cod_cotizacion ";
					$sql2.=" and c.cod_cliente=cli.cod_cliente ";
					$sql2.=" and (cod_estado_hoja_ruta=1 and informe='NO') ";
					$sql2.=" order by g.gestion desc, hr.nro_hoja_ruta desc ";

					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_hoja_ruta=$dat2[0];
							$nro_hoja_ruta=$dat2[1];	
			  		 		$cod_gestion=$dat2[2];	
							$gestion=$dat2[3];	
							$cod_cotizacion=$dat2[4];	
							$cod_cliente=$dat2[5];
							$nombre_cliente=$dat2[6];	
				 ?>
      		  <option value="<?php echo $cod_hoja_ruta;?>"><?php echo $nro_hoja_ruta."/".$gestion." (".$nombre_cliente.")";?></option>
              <?php		
					}
				?>
            </select>
	
<?php } ?>
<?php if($cod_tipo_salida==3){?>

			<select name="cod_almacen_traspaso" id="cod_almacen_traspaso" class="textoform" >
				<option value="0">Seleccione una opcion</option>	
              <?php
					$sql2=" select cod_almacen, nombre_almacen ";
					$sql2.=" from almacenes where cod_almacen<>".$cod_almacen;
					$sql2.=" and cod_estado_registro=1";
					$sql2.=" order by  nombre_almacen asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_almacen=$dat2[0];	
			  		 		$nombre_almacen=$dat2[1];	
				 ?>
      		  <option value="<?php echo $cod_almacen;?>"><?php echo $nombre_almacen;?></option>
              <?php		
					}
				?>
            </select>

<?php } ?>
<?php if($cod_tipo_salida==4){?>

				<select name="cod_hoja_ruta" id="cod_hoja_ruta" class="textoform" onChange="verHojaRuta(this.form)" >
				<option value="0">Seleccione una opcion</option>	
              <?php
					$sql2=" select hr.cod_hoja_ruta,hr.nro_hoja_ruta,hr.cod_gestion,g.gestion,hr.cod_cotizacion,c.cod_cliente, ";
					$sql2.=" cli.nombre_cliente ";
					$sql2.=" from hojas_rutas hr, cotizaciones c, clientes cli, gestiones g ";
					$sql2.=" where hr.cod_gestion=g.cod_gestion ";
					$sql2.=" and hr.cod_cotizacion=c.cod_cotizacion ";
					$sql2.=" and c.cod_cliente=cli.cod_cliente ";
					$sql2.=" and (cod_estado_hoja_ruta=3 and informe='NO') ";
					$sql2.=" order by g.gestion desc, hr.nro_hoja_ruta desc ";

					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_hoja_ruta=$dat2[0];
							$nro_hoja_ruta=$dat2[1];	
			  		 		$cod_gestion=$dat2[2];	
							$gestion=$dat2[3];	
							$cod_cotizacion=$dat2[4];	
							$cod_cliente=$dat2[5];
							$nombre_cliente=$dat2[6];	
				 ?>
      		  <option value="<?php echo $cod_hoja_ruta;?>"><?php echo $nro_hoja_ruta."/".$gestion." (".$nombre_cliente.")";?></option>
              <?php		
					}
				?>
            </select>
	
<?php } ?>

<?php if($cod_tipo_salida==5){?>

				
				<select name="cod_orden_trabajo" id="cod_orden_trabajo" class="textoform"  >
				<option value="0">Seleccione una opcion</option>	
              <?php
					$sql2=" select ot.cod_orden_trabajo, ot.numero_orden_trabajo, ot.fecha_orden_trabajo, ";
					$sql2.=" ot.cod_cliente,c.nombre_cliente, ot.obs_orden_trabajo, ot.monto_orden_trabajo,";
					$sql2.=" ot.nro_orden_trabajo, ot.cod_gestion  ";
					$sql2.=" from ordentrabajo	ot, clientes c ";
					$sql2.=" where ot.cod_cliente=c.cod_cliente ";
					$sql2.=" order by ot.fecha_orden_trabajo desc, ot.nro_orden_trabajo desc ";

					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_orden_trabajo=$dat2['cod_orden_trabajo'];
							$numero_orden_trabajo=$dat2['numero_orden_trabajo'];	
			  		 		$fecha_orden_trabajo=$dat2['fecha_orden_trabajo'];	
							$cod_cliente=$dat2['cod_cliente'];	
							$nombre_cliente=$dat2['nombre_cliente'];	
							$cod_cliente=$dat2['cod_cliente'];
							$obs_orden_trabajo=$dat2['obs_orden_trabajo'];
							$monto_orden_trabajo=$dat2['monto_orden_trabajo'];	
							$nro_orden_trabajo=$dat2['nro_orden_trabajo'];
							$cod_gestion_ot=$dat2['cod_gestion'];
							$gestion_ot="";
							$sql3=" select gestion from gestiones where  cod_gestion=".$cod_gestion_ot;
							$resp3=mysql_query($sql3);
							while($dat3=mysql_fetch_array($resp3))
							{
								$gestion_ot=$dat3['gestion'];	
			  		 		}
							
				 ?>
      		  <option value="<?php echo $cod_orden_trabajo;?>"><?php echo $nro_orden_trabajo."/".$gestion_ot." ( Nro Int.".$numero_orden_trabajo." ".$nombre_cliente.")";?></option>
              <?php		
					}
				?>
            </select>
	
<?php } ?>
<?php if($cod_tipo_salida==6){?>
<table border="0" cellpadding="1" cellspacing="1">
<tr>
	<td align="left"><strong>Area</strong></td>
	<td><select name="cod_area" id="area" class="textoform">
				<?php
					$sql2=" select cod_area, nombre_area ";
					$sql2.=" from areas ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_area=$dat2['cod_area'];	
			  		 		$nombre_area=$dat2['nombre_area'];	
				 ?>
			 <option value="<?php echo $cod_area;?>"><?php echo $nombre_area;?></option>							 
				<?php		
					}
				?>						
			</select>
	</td>
</tr>
<tr>
<td><strong>Usuario</strong></td>
<td>
<select name="cod_usuario" id="cod_usuario" class="textoform">
				<?php
					$sql2=" select cod_usuario, nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
					$sql2.=" from usuarios ";
					$sql2.=" order by ap_paterno_usuario asc, ap_materno_usuario asc, nombres_usuario asc ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_usuario=$dat2['cod_usuario'];	
							$nombres_usuario=$dat2['nombres_usuario'];	
			  		 		$ap_paterno_usuario=$dat2['ap_paterno_usuario'];
							$ap_materno_usuario=$dat2['ap_materno_usuario'];	
				 ?>

					 <option value="<?php echo $cod_usuario;?>"><?php echo $ap_paterno_usuario." ".$ap_materno_usuario." ".$nombres_usuario;?></option>							 
				<?php		
					}
				?>						
			</select>
</td>
</tr>

</table>

<?php } ?>
</body>
</html>