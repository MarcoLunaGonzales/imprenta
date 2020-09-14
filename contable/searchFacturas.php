<?php
header("Cache-Control: no-store, no-cache, must-revalidate");

//coneccion a la Base de Datos
require("conexion.inc");
	$tipo_factura=$_GET['tipo_factura'];
	$nroFacturaB=$_GET['nroFacturaB'];
	$nitFacturaB=$_GET['nitFacturaB'];
	$nombreFacturaB=$_GET['nombreFacturaB'];
	$nombreClienteB=$_GET['nombreClienteB'];
	$nroHojaRutaB=$_GET['nroHojaRutaB'];
	$fechaInicioB=$_GET['fechaInicioB'];
	$fechaFinalB=$_GET['fechaFinalB'];
	$descEstFacB=$_GET['descEstFacB'];
//para sacar los datos de la busqueda
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php 


	//Paginador
	
	
	$nro_filas_show=50;	
	$pagina=$_GET['pagina'];
	//echo $pagina;
	if ($pagina==""){
		$pagina = 1;
		$fila_inicio=0;
		$fila_final=$nro_filas_show;
	}else{
		$fila_inicio=(($pagina*$nro_filas_show)-$nro_filas_show);
		$fila_final=($fila_inicio+$nro_filas_show);
	}	
	
	$sql=" select count(*) from facturas f, estado_factura ef ";
	$sql.=" where f.cod_est_fac=ef.cod_est_fac ";
	if($descEstFacB<>""){
		$sql.=" and ef.desc_est_fac like '%".$descEstFacB."%'";
	}
	if($nroFacturaB<>""){
		$sql.=" and f.nro_factura like '%".$nroFacturaB."%'";
	}
	if($nitFacturaB<>""){	
		$sql.=" and f.nit_factura like '%".$nitFacturaB."%'";
	}
	if($nombreFacturaB<>""){
		$sql.=" and f.nombre_factura like '%".$nombreFacturaB."%'";
	}
	if($codActivoFecha=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);	
		$sql.=" and (f.fecha_factura>='".$aI."-".$mI."-".$dI."' and f.fecha_factura<='".$aF."-".$mF."-".$dF."')";
		}
	}
	if($nroHojaRutaB<>""){
		$sql.=" and f.cod_factura in(select cod_factura from factura_hojaruta where cod_hoja_ruta in";
		$sql.=" (select hr.cod_hoja_ruta from hojas_rutas hr, gestiones g";
		$sql.=" where hr.cod_gestion=g.cod_gestion and CONCAT(hr.nro_hoja_ruta,'/',g.gestion) like '%".$nroHojaRutaB."%'))";
	}
	if($nombreClienteB<>""){
	$sql.=" and f.cod_factura in(select cod_factura from factura_hojaruta where cod_hoja_ruta in(select hr.cod_hoja_ruta ";
	$sql.=" from hojas_rutas hr, cotizaciones c, clientes cli";
	$sql.=" where hr.cod_cotizacion=c.cod_cotizacion ";
	$sql.=" and c.cod_cliente=cli.cod_cliente";
	$sql.=" and cli.nombre_cliente like '%".$nombreClienteB."%'))";
	}
	if($tipo_factura==1){
		$sql.=" and f.cod_factura in(select cod_factura from factura_hojaruta)";
	}
	if($tipo_factura==2){
		$sql.=" and f.cod_factura in(select cod_factura from factura_ordentrabajo)";	
	}
	if($tipo_factura==3){
		$sql.=" and f.cod_factura <> all(select cod_factura from factura_hojaruta)";
		$sql.=" and f.cod_factura <> all(select cod_factura from factura_ordentrabajo)";		
	}	
	$sql.=" order by  f.nro_factura desc";			
	$resp = mysql_query($sql);
	while($dat_aux=mysql_fetch_array($resp)){
		$nro_filas_sql=$dat_aux[0];
	}
?>
	<div id="nroRows" align="center" class="textoform"><?php echo "Nro. de Registros: ".$nro_filas_sql; ?></div>
    <br/>
<?php
	if($nro_filas_sql==0){
?>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
            <td>Nro Factura</td>
			<td>Fecha Factura</td>
            <td>NIT</td>
            <td>Nombre</td>
            <td>Monto (Bs.)</td>				
			<td>Detalle</td>
            <td>Observacion</td>
            <td>Hoja de Ruta</td>
<td>Orden de Trabajo</td>	
			<td>Estado Actual</td>	
			<td>Fecha de Registro</td>
			<td>Fecha de Ultima Edicion</td>  
          <td>&nbsp;</td>
         															
		</tr>
		<tr><th colspan="13" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
	</table>
	
<?php	
	}else{
		//Calculo de Nro de Paginas
			$nropaginas=1;
			if($nro_filas_sql<$nro_filas_show){
				$nropaginas=1;
			}else{
				$nropag_aux=round($nro_filas_sql/$nro_filas_show);

				if($nro_filas_sql>($nropag_aux*$nro_filas_show)){
					$nropaginas=$nropag_aux+1;
				}else{
					$nropaginas=$nropag_aux;
				}
			}					
		//Fin de calculo de paginas
		$sql=" select f.cod_factura, f.nro_factura, f.nombre_factura, f.nit_factura, f.fecha_factura,f.detalle_factura, ";
		$sql.=" f.obs_factura, f.cod_est_fac, ef.desc_est_fac, f.monto_factura, f.cod_usuario_registro, ";
		$sql.=" f.fecha_registro, f.cod_usuario_modifica, f.fecha_modifica ";
		$sql.=" from facturas f, estado_factura ef ";
		$sql.=" where f.cod_est_fac=ef.cod_est_fac ";
if($descEstFacB<>""){
		$sql.=" and ef.desc_est_fac like '%".$descEstFacB."%'";
	}
	if($nroFacturaB<>""){
		$sql.=" and f.nro_factura like '%".$nroFacturaB."%'";
	}
	if($nitFacturaB<>""){	
		$sql.=" and f.nit_factura like '%".$nitFacturaB."%'";
	}
	if($nombreFacturaB<>""){
		$sql.=" and f.nombre_factura like '%".$nombreFacturaB."%'";
	}
	if($codActivoFecha=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);	
		$sql.=" and (f.fecha_factura>='".$aI."-".$mI."-".$dI."' and f.fecha_factura<='".$aF."-".$mF."-".$dF."')";
		}
	}
	if($nroHojaRutaB<>""){
		$sql.=" and f.cod_factura in(select cod_factura from factura_hojaruta where cod_hoja_ruta in";
		$sql.=" (select hr.cod_hoja_ruta from hojas_rutas hr, gestiones g";
		$sql.=" where hr.cod_gestion=g.cod_gestion and CONCAT(hr.nro_hoja_ruta,'/',g.gestion) like '%".$nroHojaRutaB."%'))";
	}
	if($nombreClienteB<>""){
	$sql.=" and f.cod_factura in(select cod_factura from factura_hojaruta where cod_hoja_ruta in(select hr.cod_hoja_ruta ";
	$sql.=" from hojas_rutas hr, cotizaciones c, clientes cli";
	$sql.=" where hr.cod_cotizacion=c.cod_cotizacion ";
	$sql.=" and c.cod_cliente=cli.cod_cliente";
	$sql.=" and cli.nombre_cliente like '%".$nombreClienteB."%'))";
	}
	if($tipo_factura==1){
		$sql.=" and f.cod_factura in(select cod_factura from factura_hojaruta)";
	}
	if($tipo_factura==2){
		$sql.=" and f.cod_factura in(select cod_factura from factura_ordentrabajo)";	
	}
	if($tipo_factura==3){
		$sql.=" and f.cod_factura <> all(select cod_factura from factura_hojaruta)";
		$sql.=" and f.cod_factura <> all(select cod_factura from factura_ordentrabajo)";		
	}	
		
		$sql.=" order by  f.nro_factura desc ";
			$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		$resp = mysql_query($sql);

?>	
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="13">
						<p align="center">						
						<b><?php if($pagina>1){ ?>
							<a href="#" onclick="paginar1(form1,<?php echo $pagina-1; ?>)"><--Anterior</a>
							<?php }?>
						</b>
						<b> Pagina <?php echo $pagina; ?> de <?php echo $nropaginas; ?> </b>
						<b><?php if($nropaginas>$pagina){ ?> 
							<a href="#" onclick="paginar1(form1,<?php echo $pagina+1; ?>)">Siguiente--></a>
						<?php }?></b>
						</p>
</td>
			</tr>
    
	    <tr height="20px" align="center"  class="titulo_tabla">
            <td>Nro Factura</td>
			<td>Fecha Factura</td>
            <td>NIT</td>
            <td>Nombre</td>            
            <td>Monto (Bs.)</td>	
            <td>Detalle</td>			
<td>Observacion</td>
            <td>Hoja de Ruta</td>
            <td>Orden de Trabajo</td>	
			<td>Estado Actual</td>	
			<td>Fecha de Registro</td>
			<td>Fecha de Ultima Edicion</td>  
            <td>&nbsp;</td>        	            																	
		</tr>

<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){
		
				$cod_factura=$dat['cod_factura'];
				$nro_factura=$dat['nro_factura'];
				$nombre_factura=$dat['nombre_factura'];
				$nit_factura=$dat['nit_factura'];
				$fecha_factura=$dat['fecha_factura'];
				$detalle_factura=$dat['detalle_factura'];
				$obs_factura=$dat['obs_factura'];
				$cod_est_fac=$dat['cod_est_fac'];
				$desc_est_fac=$dat['desc_est_fac'];
				$monto_factura=$dat['monto_factura'];
				$cod_usuario_registro=$dat['cod_usuario_registro'];
				$fecha_registro=$dat['fecha_registro'];
				$cod_usuario_modifica=$dat['cod_usuario_modifica'];
				$fecha_modifica=$dat['fecha_modifica'];

				///Datos Hoja Ruta////
				$queryFacHojaRuta="select cod_hoja_ruta from factura_hojaruta where cod_factura=".$cod_factura;
				$resp3 = mysql_query($queryFacHojaRuta);
					$cod_hoja_ruta=0;
				while($dat3=mysql_fetch_array($resp3)){
					$cod_hoja_ruta=$dat3['cod_hoja_ruta'];
				}
				$cod_gestion="";
				$nro_hoja_ruta="";
				$gestion="";
				$fecha_hoja_ruta="";
				$cod_cotizacion="";
				$cod_cliente="";
				$nombre_cliente="";
				$nit_cliente="";
				$cod_estado_hoja_ruta="";
				$nombre_estado_hoja_ruta="";
				
				///Fin Datos Hoja Ruta//
				///Datos Orden Trabajo////
				$queryFacOrdenTrabajo="select cod_orden_trabajo from factura_ordentrabajo where cod_factura=".$cod_factura;
				$resp3 = mysql_query($queryFacOrdenTrabajo);
				$cod_orden_trabajo=0;
				while($dat3=mysql_fetch_array($resp3)){
					$cod_orden_trabajo=$dat3['cod_orden_trabajo'];
				}
					$nro_orden_trabajo="";
					$cod_gestion="";
					$gestion="";
					$cod_est_ot="";
					$desc_est_ot="";
					$numero_orden_trabajo="";
					$fecha_orden_trabajo="";
					$cod_cliente="";
					$nombre_cliente="";
					$detalle_orden_trabajo="";
					$obs_orden_trabajo="";
					$monto_orden_trabajo="";
					$cod_usuario_registro="";
					$fecha_registro="";
					$cod_usuario_modifica="";
					$fecha_modifica="";			
				///Fin Datos Orden Trabajo//
				

		


				
?> 
		<tr bgcolor="#FFFFFF">	
    		<td align="right"><?php echo $nro_factura;?></td>
    		<td align="right"><?php echo strftime("%d/%m/%Y",strtotime($fecha_factura));?></td>
			<td><?php echo $nit_factura; ?></td>            
            <td><?php echo $nombre_factura; ?></td>            
    		<td align="right"><?php echo $monto_factura; ?></td>            
            <td><?php echo $obs_factura; ?></td>
            <td>&nbsp;</td>
            <td>
            <?php if($cod_hoja_ruta<>0){
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
			?>
            <a href="../reportes/impresionHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta; ?>" target="_blank">
			<?php echo $nro_hoja_ruta."/".$gestion." (".$nombre_cliente.")"; ?>
            </a>
            <?php
				}?>
          </td>
<td> <?php 
			if($cod_orden_trabajo<>0){
				$sql3=" select  ot.nro_orden_trabajo, ot.cod_gestion, g.gestion, ot.cod_est_ot, ";
				$sql3.=" eo.desc_est_ot, ot.numero_orden_trabajo, ot.fecha_orden_trabajo, ot.cod_cliente, cli.nombre_cliente, ";
				$sql3.=" ot.detalle_orden_trabajo, ot.obs_orden_trabajo, ot.monto_orden_trabajo,";
				$sql3.=" ot.cod_usuario_registro, ot.fecha_registro,";
				$sql3.=" ot.cod_usuario_modifica, ot.fecha_modifica ";
				$sql3.=" from ordentrabajo ot, gestiones g, estado_ordentrabajo eo, clientes cli ";
				$sql3.=" where ot.cod_gestion=g.cod_gestion ";
				$sql3.=" and ot.cod_est_ot=eo.cod_est_ot ";
				$sql3.=" and ot.cod_cliente=cli.cod_cliente ";
				$sql3.=" and ot.cod_orden_trabajo=".$cod_orden_trabajo;
			    $resp3= mysql_query($sql3);	
				while($dat3=mysql_fetch_array($resp3)){
		
					$nro_orden_trabajo=$dat3['nro_orden_trabajo'];
					$cod_gestion=$dat3['cod_gestion'];
					$gestion=$dat3['gestion'];
					$cod_est_ot=$dat3['cod_est_ot'];
					$desc_est_ot=$dat3['desc_est_ot'];
					$numero_orden_trabajo=$da3t['numero_orden_trabajo'];
					$fecha_orden_trabajo=$dat3['fecha_orden_trabajo'];
					$cod_cliente=$dat3['cod_cliente'];
					$nombre_cliente=$dat3['nombre_cliente'];
					$detalle_orden_trabajo=$dat3['detalle_orden_trabajo'];
					$obs_orden_trabajo=$dat3['obs_orden_trabajo'];
					$monto_orden_trabajo=$dat3['monto_orden_trabajo'];
					$cod_usuario_registro=$dat3['cod_usuario_registro'];
					$fecha_registro=$dat3['fecha_registro'];
					$cod_usuario_modifica=$dat3['cod_usuario_modifica'];
					$fecha_modifica=$dat3['fecha_modifica'];
		
					}
					echo $nro_orden_trabajo."/".$gestion." (".$nombre_cliente.")"; 
				}?>
</td>
            <td><?php echo $desc_est_fac; ?></td>
            
          <td>&nbsp;</td>
            <td>&nbsp;</td>
         <td><a href="viewFactura.php?cod_factura=<?php echo $cod_factura;?>">Detalle</a></td>    


					
   	  </tr>
<?php
		 } 
?>			

	<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="13">
						<p align="center">						
						<b><?php if($pagina>1){ ?>
							<a href="#" onclick="paginar1(form1,<?php echo $pagina-1; ?>)"><--Anterior</a>
							<?php }?>
						</b>
						<b> Pagina <?php echo $pagina; ?> de <?php echo $nropaginas; ?> </b>
						<b><?php if($nropaginas>$pagina){ ?> 
							<a href="#" onclick="paginar1(form1,<?php echo $pagina+1; ?>)">Siguiente--></a>
						<?php }?></b>
						</p>
						<p align="center">				
						Ir a Pagina<input type="text" name="pagina" size="5"><input  type="button" size="8"  value="Go" onClick="paginar(this.form)">	
</td>
			</tr>
		</table>
		
<?php
	}
?>

</body>
</html>