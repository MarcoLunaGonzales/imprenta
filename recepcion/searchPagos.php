<?
header("Cache-Control: no-store, no-cache, must-revalidate");

//coneccion a la Base de Datos
require("conexion.inc");
include("funciones.php");
	$nroPagoB=$_GET['nroPagoB'];
	$nombreClienteB=$_GET['nombreClienteB'];
	$cod_estado_pagoB=$_GET['cod_estado_pagoB'];
	$nroHojaRutaB=$_GET['nroHojaRutaB'];
	$nroOrdenTrabajoB=$_GET['nroOrdenTrabajoB'];
	$nroSalidaB=$_GET['nroSalidaB'];
	$fechaInicioB=$_GET['fechaInicioB'];
	$fechaFinalB=$_GET['fechaFinalB'];
	$codActivoFecha=$_GET['codActivoFecha'];
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
	$sql=" select count(*) ";
	$sql.=" from pagos p, gestiones g,  clientes cli, estados_pago ep";
	$sql.=" where  p.cod_gestion=g.cod_gestion";
	$sql.=" and p.cod_cliente=cli.cod_cliente ";
	$sql.=" and p.cod_estado_pago=ep.cod_estado_pago ";
	if($nroPagoB<>""){
		$sql.=" and CONCAT(p.nro_pago,'/',g.gestion) LIKE '%".$nroPagoB."%' ";
	}	
	if($nombreClienteB<>""){
		$sql.=" and cli.nombre_cliente LIKE '%".$nombreClienteB."%' ";
	}	
	if($cod_estado_pagoB<>0){
		$sql.=" and p.cod_estado_pago=".$cod_estado_pagoB." ";
	}	
	if($nroHojaRutaB<>""){
			$sql.=" and p.cod_pago in(select pd.cod_pago from pagos_detalle pd, hojas_rutas hr, gestiones g ";
			$sql.=" where pd.cod_tipo_doc=1 and pd.codigo_doc=hr.cod_hoja_ruta and hr.cod_gestion=g.cod_gestion ";
			$sql.=" and CONCAT(hr.nro_hoja_ruta,'/',g.gestion)like  '%".$nroHojaRutaB."%' )";
	}
	
	if($nroOrdenTrabajoB<>""){
			$sql.=" and p.cod_pago in(select pd.cod_pago from pagos_detalle pd, ordentrabajo ot, gestiones g ";
			$sql.=" where pd.cod_tipo_doc=2 and pd.codigo_doc=ot.cod_orden_trabajo and ot.cod_gestion=g.cod_gestion ";
			$sql.=" and ( (CONCAT(ot.nro_orden_trabajo,'/',g.gestion)like  '%".$nroOrdenTrabajoB."%') or (ot.numero_orden_trabajo like  '%".$nroOrdenTrabajoB."%') )";
	}
	if($nroSalidaB<>""){
			$sql.=" and p.cod_pago in(select pd.cod_pago from pagos_detalle pd, salidas s, gestiones g ";
			$sql.=" where pd.cod_tipo_doc=3 and pd.codigo_doc=s.cod_salida and s.cod_gestion=g.cod_gestion ";
			$sql.=" and CONCAT(s.nro_salida,'/',g.gestion)like  '%".$nroSalidaB."%' )";
	}	
	if($codActivoFecha=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);
				
				$sql.=" and p.fecha_pago>='".$aI."-".$mI."-".$dI."' and p.fecha_pago<='".$aF."-".$mF."-".$dF."' ";

		}
	}
	$sql.=" order by g.gestion desc, p.nro_pago desc ";	
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
            <td>Nro de Pago</td>
			<td>Fecha Pago</td>
            <td>Cliente</td>
            <td>Monto Total (Bs)</td>
            <td>Documentos</td>				
			<td>Observaciones</td>
            <td>Estado</td>
			<td>&nbsp;</td>	
			<td>&nbsp;</td>	
			<td>&nbsp;</td>																													            
		</tr>
		<tr><th colspan="10" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
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
		$sql=" select p.cod_pago,  p.nro_pago, p.cod_gestion, g.gestion, ";
		$sql.=" p.cod_cliente, cli.nombre_cliente,  p.fecha_pago, p.cod_usuario_pago, p.obs_pago, p.monto_pago, ";
		$sql.=" p.cod_estado_pago, ep.desc_estado_pago";
		$sql.=" from pagos p, gestiones g,  clientes cli, estados_pago ep ";
		$sql.=" where  p.cod_gestion=g.cod_gestion ";
		$sql.=" and p.cod_cliente=cli.cod_cliente ";
		$sql.=" and p.cod_estado_pago=ep.cod_estado_pago ";
		if($nroPagoB<>""){
			$sql.=" and CONCAT(p.nro_pago,'/',g.gestion) LIKE '%".$nroPagoB."%' ";
		}	
		if($nombreClienteB<>""){
			$sql.=" and cli.nombre_cliente LIKE '%".$nombreClienteB."%' ";
		}	
		if($cod_estado_pagoB<>0){
			$sql.=" and p.cod_estado_pago=".$cod_estado_pagoB." ";
		}	
		if($nroHojaRutaB<>""){
			$sql.=" and p.cod_pago in(select pd.cod_pago from pagos_detalle pd, hojas_rutas hr, gestiones g ";
			$sql.=" where pd.cod_tipo_doc=1 and pd.codigo_doc=hr.cod_hoja_ruta and hr.cod_gestion=g.cod_gestion ";
			$sql.=" and CONCAT(hr.nro_hoja_ruta,'/',g.gestion)like  '%".$nroHojaRutaB."%' )";
		}
	if($nroOrdenTrabajoB<>""){
			$sql.=" and p.cod_pago in(select pd.cod_pago from pagos_detalle pd, ordentrabajo ot, gestiones g ";
			$sql.=" where pd.cod_tipo_doc=2 and pd.codigo_doc=ot.cod_orden_trabajo and ot.cod_gestion=g.cod_gestion ";
			$sql.=" and ( (CONCAT(ot.nro_orden_trabajo,'/',g.gestion)like  '%".$nroOrdenTrabajoB."%') or (ot.numero_orden_trabajo like  '%".$nroOrdenTrabajoB."%') )";
	}	
	if($nroSalidaB<>""){
			$sql.=" and p.cod_pago in(select pd.cod_pago from pagos_detalle pd, salidas s, gestiones g ";
			$sql.=" where pd.cod_tipo_doc=3 and pd.codigo_doc=s.cod_salida and s.cod_gestion=g.cod_gestion ";
			$sql.=" and CONCAT(s.nro_salida,'/',g.gestion)like  '%".$nroSalidaB."%' )";
	}		
		if($codActivoFecha=="on"){
			$fechaInicioB=$_GET['fechaInicioB'];
			$fechaFinalB=$_GET['fechaFinalB'];
			if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);
				
				$sql.=" and p.fecha_pago>='".$aI."-".$mI."-".$dI."' and p.fecha_pago<='".$aF."-".$mF."-".$dF."' ";

			}
		}
		
		$sql.=" order by g.gestion desc, p.nro_pago desc ";
		$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		$resp = mysql_query($sql);

?>	
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
    <tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="9">
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
            <td>Nro de Pago</td>
			<td>Fecha Pago</td>
            <td>Cliente</td>
            <td>Monto Total (Bs)</td>
            <td>Documentos</td>				
			<td>Observaciones</td>
            <td>Estado</td>
			<td>&nbsp;</td>	
			<td>&nbsp;</td>	                  	            																	
		</tr>

<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){
				$cod_pago=$dat['cod_pago'];
				$nro_pago=$dat['nro_pago'];				
				$cod_gestion=$dat['cod_pago'];
				$gestion=$dat['gestion'];
				$cod_cliente=$dat['cod_cliente'];
				$nombre_cliente=$dat['nombre_cliente'];								
				$fecha_pago=$dat['fecha_pago'];
				$cod_usuario_pago=$dat['cod_usuario_pago'];
				$obs_pago=$dat['obs_pago'];
				$monto_pago=$dat['monto_pago'];
				$cod_estado_pago=$dat['cod_estado_pago'];
				$desc_estado_pago=$dat['desc_estado_pago'];
				///Usuario de Registro//////////
				if($cod_usuario_pago<>""){
					$sqlAux=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
					$sqlAux.=" from usuarios ";
					$sqlAux.=" where cod_usuario=".$cod_usuario_pago;
					$respAux = mysql_query($sqlAux);
					$nombres_usuario_pago="";
					$ap_paterno_usuario_pago="";
					$ap_materno_usuario_pago="";						
					while($datAux=mysql_fetch_array($respAux)){
						
						$nombres_usuario_pago=$datAux['nombres_usuario'];
						$ap_paterno_usuario_pago=$datAux['ap_paterno_usuario'];
						$ap_materno_usuario_pago=$datAux['ap_materno_usuario'];						
					}
				}
				////////////////////////////////				
	
?> 
		<tr bgcolor="#FFFFFF">	
    		<td align="right"><?php echo $nro_pago."/".$gestion;?></td>
    		<td align="right"><?php echo strftime("%d/%m/%Y",strtotime($fecha_pago))." ". $nombres_usuario_pago[0].$ap_paterno_usuario_pago[0].$ap_materno_usuario_pago[0];?></td>
			<td><?php echo $nombre_cliente; ?></td>            
            <td align="right">
            <?php 
			 	$sql2=" select pd.cod_moneda, pd.monto_pago_detalle, p.fecha_pago ";
			 	$sql2.=" from pagos_detalle pd, pagos p";
			 	$sql2.=" where pd.cod_pago=p.cod_pago";
			 	$sql2.=" and pd.cod_pago=".$cod_pago;

				$resp2 = mysql_query($sql2);
				$monto_pago_total=0;
				while($dat2=mysql_fetch_array($resp2)){
					$cod_moneda=$dat2['cod_moneda'];

					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					$fecha_pago=$dat2['fecha_pago'];
					if($cod_moneda==1){
						$monto_pago_total=$monto_pago_total+$monto_pago_detalle;
					}else{
							$cambio_bs=0;
							$sql3="select cambio_bs from tipo_cambio";
							$sql3.=" where fecha_tipo_cambio='".$fecha_pago."' and cod_moneda='".$cod_moneda."'";
							$resp3=mysql_query($sql3);
							
							while($dat3=mysql_fetch_array($resp3)){
								$cambio_bs=$dat3['cambio_bs'];
							}
							if($cambio_bs<>0){
								$monto_pago_total=$monto_pago_total+($monto_pago_detalle*$cambio_bs);
							
							}
						
					}
				}				
				echo $monto_pago_total;
			?>
            </td> 
            <td>
			<table border="0" cellpadding="0" cellspacing="0">
			<?php
	            $sql3=" select pd.cod_pago_detalle, pd.codigo_doc, hr.nro_hoja_ruta, g.gestion, hr.fecha_hoja_ruta, ";
				$sql3.=" pd.monto_pago_detalle, pd.cod_forma_pago, pd.cod_banco, ";
				$sql3.=" pd.cod_moneda, pd.nro_cheque, pd.nro_cuenta ";
				$sql3.=" from pagos_detalle pd, hojas_rutas hr, gestiones g ";
				$sql3.=" where pd.cod_pago=".$cod_pago;
				$sql3.=" and pd.cod_tipo_doc=1 ";
				$sql3.=" and pd.codigo_doc=hr.cod_hoja_ruta ";
				$sql3.=" and hr.cod_gestion=g.cod_gestion ";
				$resp3 = mysql_query($sql3);				
				while($dat3=mysql_fetch_array($resp3)){
					$cod_pago_detalle=$dat3['cod_pago_detalle'];
					$cod_hoja_ruta=$dat3['codigo_doc'];
					$nro_hoja_ruta=$dat3['nro_hoja_ruta'];
					$gestionHojaRuta=$dat3['gestion'];
					$fecha_hoja_ruta=$dat3['fecha_hoja_ruta'];		
				?>	
                <tr>
                <td><a href="../reportes/impresionHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta; ?>" target="_blank"> <?php echo "HR.".$nro_hoja_ruta."/".$gestionHojaRuta?></a>&nbsp;</td>
                <td>&nbsp;<?php echo strftime("%d/%m/%Y",strtotime($fecha_hoja_ruta));?></td></tr>
			<?php
            	}

			?>
            	<?php
					$sql3=" select pd.cod_pago_detalle, pd.codigo_doc, ot.nro_orden_trabajo, g.gestion, ot.fecha_orden_trabajo,";
					$sql3.=" ot.numero_orden_trabajo,pd.monto_pago_detalle, pd.cod_forma_pago, pd.cod_banco, ";
					$sql3.=" pd.cod_moneda, pd.nro_cheque, pd.nro_cuenta ";
					$sql3.=" from pagos_detalle pd, ordentrabajo ot, gestiones g ";
					$sql3.=" where pd.cod_pago=".$cod_pago;
					$sql3.=" and pd.cod_tipo_doc=2 ";
					$sql3.=" and pd.codigo_doc=ot.cod_orden_trabajo ";
					$sql3.=" and ot.cod_gestion=g.cod_gestion ";
					$resp3 = mysql_query($sql3);				
					while($dat3=mysql_fetch_array($resp3)){
						$cod_pago_detalle=$dat3['cod_pago_detalle'];
						$cod_orden_trabajo=$dat3['codigo_doc'];
						$nro_orden_trabajo=$dat3['nro_orden_trabajo'];
						$gestionOrdenTrabajo=$dat3['gestion'];
						$fecha_orden_trabajo=$dat3['fecha_orden_trabajo'];
						$numero_orden_trabajo=$dat3['numero_orden_trabajo'];
				?>	
              
                <tr>
                <td><a href="../reportes/impresionOrdenTrabajo.php?cod_orden_trabajo=<?php echo $cod_orden_trabajo;?>" target="_blank"> <?php echo "OT.".$nro_orden_trabajo."/".$gestionOrdenTrabajo."(Int.".$numero_orden_trabajo.")"?></a>&nbsp;</td>
                <td>&nbsp;<?php echo strftime("%d/%m/%Y",strtotime($fecha_orden_trabajo));?></td>
                </tr>
			<?php
            	}

			?>
				<?php
	            $sql3=" select pd.cod_pago_detalle, pd.codigo_doc, s.nro_salida, g.gestion, s.fecha_salida, ";
				$sql3.=" pd.monto_pago_detalle, pd.cod_forma_pago, pd.cod_banco, ";
				$sql3.=" pd.cod_moneda, pd.nro_cheque, pd.nro_cuenta ";
				$sql3.=" from pagos_detalle pd, salidas s, gestiones g ";
				$sql3.=" where pd.cod_pago=".$cod_pago;
				$sql3.=" and pd.cod_tipo_doc=3 ";
				$sql3.=" and pd.codigo_doc=s.cod_salida ";
				$sql3.=" and s.cod_gestion=g.cod_gestion ";
				$resp3 = mysql_query($sql3);				
				while($dat3=mysql_fetch_array($resp3)){
					$cod_pago_detalle=$dat3['cod_pago_detalle'];
					$cod_salida=$dat3['codigo_doc'];
					$nro_salida=$dat3['nro_salida'];
					$gestionSalida=$dat3['gestion'];
					$fecha_salida=$dat3['fecha_salida'];		
				?>	
                <tr>
                <td><a href="../almacenes/detalleSalida.php?cod_salida=<?php echo $cod_salida; ?>" target="_blank"> <?php echo "VENTA.".$nro_salida."/".$gestionSalida?></a>&nbsp;</td>
                <td>&nbsp;<?php echo strftime("%d/%m/%Y",strtotime($fecha_salida));?></td>
                </tr>
			<?php
            	}

			?>              
            
            </table>
            </td>    
            <td align="justify"><?php echo $obs_pago; ?></td>      
    		<td align="right"><?php echo $desc_estado_pago; ?></td>  
            <td><a href="viewPago.php?cod_pago=<?php echo $cod_pago;?>">Detalle</a></td>  
            <td>
            <?php if($cod_estado_pago<>2){?>
            	<a href="anularPago.php?cod_pago=<?php echo $cod_pago;?>">Anular</a>
            <?php }?>
            </td> 
            
     					
   	  </tr>
<?php
		 } 
?>			

	<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="9">
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