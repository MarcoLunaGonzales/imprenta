<?php
header("Cache-Control: no-store, no-cache, must-revalidate");

//coneccion a la Base de Datos
require("conexion.inc");
	$nroOrdenTrabajoB=$_GET['nroOrdenTrabajoB'];
	$numeroOrdenTrabajoB=$_GET['numeroOrdenTrabajoB'];
	$nombreClienteB=$_GET['nombreClienteB'];
	$codActivoFecha=$_GET['codActivoFecha'];
	$fechaInicioB=$_GET['fechaInicioB'];
	$fechaFinalB=$_GET['fechaFinalB'];
	$codestotB=$_GET['codestotB'];
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
<div id="resultados">
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
	
	$sql=" select count(*) ";
	$sql.=" from ordentrabajo ot, gestiones g, estado_ordentrabajo eo, clientes cli ";
	$sql.=" where ot.cod_gestion=g.cod_gestion ";
	$sql.=" and ot.cod_est_ot=eo.cod_est_ot ";
	$sql.=" and ot.cod_cliente=cli.cod_cliente ";

	if($codestotB<>0){
		$sql.=" and ot.cod_est_ot=".$codestotB."";
	}
	if($nombreClienteB<>""){
		$sql.=" and cli.nombre_cliente like '%".$nombreClienteB."%'";
	}
	if($nroOrdenTrabajoB<>""){	
		$sql.=" and CONCAT(ot.nro_orden_trabajo,'/',g.gestion)like'%".$nroOrdenTrabajoB."%'";
	}
	if($numeroOrdenTrabajoB<>""){	
		$sql.=" and ot.numero_orden_trabajo like '%".$numeroOrdenTrabajoB."%'";
	}		
	
	if($codActivoFecha=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);	
		$sql.=" and (ot.fecha_orden_trabajo>='".$aI."-".$mI."-".$dI."' and ot.fecha_orden_trabajo<='".$aF."-".$mF."-".$dF."')";
		}
	}
	$sql.=" order by ot.nro_orden_trabajo desc,g.gestion desc ";

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
            <td>Nro Orden Trabajo</td>
		  <td>Fecha de Orden Trabajo</td>
            <td>Numero</td>
            <td>Cliente</td>
            <td>Monto</td>				
			<td>Detalle</td>
            <td>Observacion</td>
			<td>Estado Actual</td>	
			<td>Fecha de Registro</td>
			<td>Fecha de Ultima Edicion</td>
            <td>&nbsp;</td>   																													            
		</tr>
		<tr><th colspan="11" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
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
	$sql=" select ot.cod_orden_trabajo, ot.nro_orden_trabajo, ot.cod_gestion, g.gestion, ot.cod_est_ot, ";
	$sql.=" eo.desc_est_ot, ot.numero_orden_trabajo, ot.fecha_orden_trabajo, ot.cod_cliente, cli.nombre_cliente, ";
	$sql.=" ot.detalle_orden_trabajo, ot.obs_orden_trabajo, ot.monto_orden_trabajo, ot.cod_usuario_registro, ot.fecha_registro,";
	$sql.=" ot.cod_usuario_modifica, ot.fecha_modifica ";
	$sql.=" from ordentrabajo ot, gestiones g, estado_ordentrabajo eo, clientes cli ";
	$sql.=" where ot.cod_gestion=g.cod_gestion ";
	$sql.=" and ot.cod_est_ot=eo.cod_est_ot ";
	$sql.=" and ot.cod_cliente=cli.cod_cliente ";
	if($codestotB<>0){
		$sql.=" and ot.cod_est_ot=".$codestotB."";
	}
	if($nombreClienteB<>""){
		$sql.=" and cli.nombre_cliente like '%".$nombreClienteB."%'";
	}
	if($nroOrdenTrabajoB<>""){	
		$sql.=" and CONCAT(ot.nro_orden_trabajo,'/',g.gestion)like '%".$nroOrdenTrabajoB."%'";
	}
	if($numeroOrdenTrabajoB<>""){	
		$sql.=" and ot.numero_orden_trabajo like '%".$numeroOrdenTrabajoB."%'";
	}		
	
	if($codActivoFecha=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);	
		$sql.=" and (ot.fecha_orden_trabajo>='".$aI."-".$mI."-".$dI."' and ot.fecha_orden_trabajo<='".$aF."-".$mF."-".$dF."')";
		}
	}
	$sql.=" order by ot.nro_orden_trabajo desc,g.gestion desc ";
	$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
	$resp = mysql_query($sql);

?>	
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
    <tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="12">
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
            <td>Nro Orden Trabajo</td>
			<td>Fecha de Orden Trabajo</td>
            <td>Numero</td>
            <td>Cliente</td>
            <td>Monto</td>				
			<td>Detalle</td>
            <td>Observacion</td>
			<td>Estado Actual</td>	
			<td>Fecha de Registro</td>
			<td>Fecha de Ultima Edicion</td>
                      <td>Facturas</td>
          <td>&nbsp;</td>                     	            																	
		</tr>

<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){
		
				$cod_orden_trabajo=$dat['cod_orden_trabajo'];
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

?> 
		<tr bgcolor="#FFFFFF">	
            <td align="right"><?php echo $nro_orden_trabajo."/".$gestion; ?></td>
			<td><?php echo strftime("%d/%m/%Y",strtotime($fecha_orden_trabajo));?></td>
            <td><?php echo $numero_orden_trabajo;?></td>
            <td><?php echo $nombre_cliente; ?></td>
            <td><?php echo $monto_orden_trabajo; ?></td>				
			<td><?php echo $detalle_orden_trabajo; ?></td>
            <td><?php echo $obs_orden_trabajo; ?></td>
			<td><?php echo $desc_est_ot;?></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
             <td>
             <table border="0" align="left">
            <?php
				$sqlFactura=" select f.cod_factura, f.nro_factura, f.nombre_factura, ";
				$sqlFactura.=" f.nit_factura, f.fecha_factura, f.detalle_factura,f.obs_factura, f.cod_est_fac,  ";
				$sqlFactura.=" ef.desc_est_fac, f.monto_factura, f.cod_usuario_registro,   ";
				$sqlFactura.=" f.fecha_registro, f.cod_usuario_modifica, f.fecha_modifica  ";
				$sqlFactura.=" from facturas f, estado_factura ef  ";
				$sqlFactura.=" where f.cod_est_fac=ef.cod_est_fac ";
				$sqlFactura.=" and f.cod_factura in(select cod_factura from factura_ordentrabajo where cod_orden_trabajo=".$cod_orden_trabajo.")";
				
					$resp3= mysql_query($sqlFactura);
					while($dat3=mysql_fetch_array($resp3)){
						
						$cod_factura=$dat3['cod_factura'];
						$nro_factura=$dat3['nro_factura'];
						$nombre_factura=$dat3['nombre_factura'];
						$nit_factura=$dat3['nit_factura'];
						$fecha_factura=$dat3['fecha_factura'];
						$detalle_factura=$dat3['detalle_factura'];
						$obs_factura=$dat3['obs_factura'];
						$cod_est_fac=$dat3['cod_est_fac'];
						$desc_est_fac=$dat3['desc_est_fac'];
						$monto_factura=$dat3['monto_factura'];
						$cod_usuario_registro=$dat3['cod_usuario_registro'];
						$fecha_registro=$dat3['fecha_registro'];
						$cod_usuario_modifica=$dat3['cod_usuario_modifica'];
						$fecha_modifica=$dat3['fecha_modifica'];		
			?>
				<tr>
                	<td align="right"><a><?php echo "Nro".$nro_factura." NIT:". $nit_factura." Monto:".$monto_factura ?></a></td>
                </tr>

			<?php
				}
			?>
  
          </table>

          <td>
          <?php if($cod_est_ot<>2){?>
	          <a href="newFacturaOrdenTrabajo.php?cod_orden_trabajo=<?php echo $cod_orden_trabajo;?>">+ Factura</a>
           <?php }?>
          </td>             
             	  </tr>
<?php
		 } 
?>			

	<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="12">
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
</div>	
</body>
</html>