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
	$cod_estado_pago_docB=$_GET['cod_estado_pago_docB'];
//para sacar los datos de la busqueda
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgcolor="#FFFFFF">
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
	if($cod_estado_pago_docB<>0){
		$sql.=" and ot.cod_estado_pago_doc=".$cod_estado_pago_docB."";
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
	

	$resp = mysql_query($sql);
	while($dat_aux=mysql_fetch_array($resp)){
		$nro_filas_sql=$dat_aux[0];
	}

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
	$sql=" select ot.cod_orden_trabajo, ot.nro_orden_trabajo, ot.cod_gestion, g.gestion_nombre, ot.cod_est_ot, ";
	$sql.=" eo.desc_est_ot, ot.numero_orden_trabajo, ot.fecha_orden_trabajo, ot.cod_cliente, cli.nombre_cliente, ";
	$sql.=" cli.direccion_cliente, cli.telefono_cliente, cli.celular_cliente, ";
	$sql.=" ot.cod_contacto, ot.detalle_orden_trabajo, ot.obs_orden_trabajo, ";
	$sql.=" ot.monto_orden_trabajo, ot.cod_usuario_registro, ot.fecha_registro,";
	$sql.=" ot.cod_usuario_modifica, ot.fecha_modifica, ot.cod_tipo_pago, ot.cod_estado_pago_doc, ";
	$sql.=" ot.incremento_orden_trabajo, ot.incremento_fecha, ot.incremento_obs, ot.cod_usuario_incremento,";
	$sql.=" ot.descuento_orden_trabajo, ot.descuento_fecha, ot.descuento_obs, ot.cod_usuario_descuento";
	$sql.=" from ordentrabajo ot, gestiones g, estado_ordentrabajo eo, clientes cli ";
	$sql.=" where ot.cod_gestion=g.cod_gestion ";
	$sql.=" and ot.cod_est_ot=eo.cod_est_ot ";
	$sql.=" and ot.cod_cliente=cli.cod_cliente ";
	if($codestotB<>0){
		$sql.=" and ot.cod_est_ot=".$codestotB."";
	}
		if($cod_estado_pago_docB<>0){
		$sql.=" and ot.cod_estado_pago_doc=".$cod_estado_pago_docB."";
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
	$sql.=" order by  ot.cod_orden_trabajo desc ";
	//$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
	$resp = mysql_query($sql);

?>	
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc" class="tablaReporte" style="width:100% !important;">
       <thead>
	    <tr height="20px" align="center"  class="bg-success text-white">
            <th>Nro O.T.</th>          
			<th>Fecha O.T.</th>            
            <th>Cliente</th>
			<th>Tipo de Pago</th>
            <th>Monto</th>
            <th>Inc</th>
            <th>Desc</th> 
            <th>Tot. Monto</th>            
            <th>A cuenta</th>	
            <th>Saldo</th>
            <th>Gastos</th>					
			<th>Estado Actual</th>
            <th>Estado de Pago</th>	
            <th>Pagos</th>
            <th>Facturas</th>
    	    <th>&nbsp;</th> 
            <th>&nbsp;</th> 
            <th>&nbsp;</th> 
         
                     	            																	
		</tr>
		</thead>
        <tbody>
<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){
		
				$cod_orden_trabajo=$dat['cod_orden_trabajo'];
				$nro_orden_trabajo=$dat['nro_orden_trabajo'];
				$cod_gestion=$dat['cod_gestion'];
				$gestion=$dat['gestion_nombre'];
				$cod_est_ot=$dat['cod_est_ot'];
				$desc_est_ot=$dat['desc_est_ot'];
				$numero_orden_trabajo=$dat['numero_orden_trabajo'];
				$fecha_orden_trabajo=$dat['fecha_orden_trabajo'];
				$cod_cliente=$dat['cod_cliente'];
				$cod_contacto=$dat['cod_contacto'];
				$nombre_cliente=$dat['nombre_cliente'];
				$direccion_cliente=$dat['direccion_cliente'];
				$telefono_cliente=$dat['telefono_cliente'];
				$celular_cliente=$dat['celular_cliente'];
				$detalle_orden_trabajo=$dat['detalle_orden_trabajo'];
				$obs_orden_trabajo=$dat['obs_orden_trabajo'];
				$monto_orden_trabajo=$dat['monto_orden_trabajo'];
				$cod_usuario_registro=$dat['cod_usuario_registro'];
				$fecha_registro=$dat['fecha_registro'];
				$cod_usuario_modifica=$dat['cod_usuario_modifica'];
				$fecha_modifica=$dat['fecha_modifica'];
				$cod_tipo_pago=$dat['cod_tipo_pago'];
				$cod_estado_pago_doc=$dat['cod_estado_pago_doc'];	
				$incremento_orden_trabajo=$dat['incremento_orden_trabajo'];	
				$incremento_fecha=$dat['incremento_fecha'];	
				$incremento_obs=$dat['incremento_obs'];	
				$cod_usuario_incremento=$dat['cod_usuario_incremento'];	
				$descuento_orden_trabajo=$dat['descuento_orden_trabajo'];	
				$descuento_fecha=$dat['descuento_fecha'];	
				$descuento_obs=$dat['descuento_obs'];	
				$cod_usuario_descuento=$dat['cod_usuario_descuento'];	
							
				$nombre_tipo_pago="";
				$sql2="select nombre_tipo_pago from tipos_pago where cod_tipo_pago=".$cod_tipo_pago;
				$resp2= mysql_query($sql2);	
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_tipo_pago=$dat2['nombre_tipo_pago'];
				}
		
				$desc_estado_pago_doc="";
				$sql2="select desc_estado_pago_doc from estado_pago_documento where cod_estado_pago_doc=".$cod_estado_pago_doc;
				$resp2= mysql_query($sql2);	
				while($dat2=mysql_fetch_array($resp2)){
					$desc_estado_pago_doc=$dat2['desc_estado_pago_doc'];
				}
				$acuenta_ordentrabajo=0;
				$sql3=" select sum(monto_pago_detalle) ";
				$sql3.=" from pagos_detalle pd, pagos p";
				$sql3.=" where pd.cod_pago=p.cod_pago";
				$sql3.=" and p.cod_estado_pago<>2";
				$sql3.=" and pd.codigo_doc=".$cod_orden_trabajo;
				$sql3.=" and pd.cod_tipo_doc=2";
				$resp3= mysql_query($sql3);					
				while($dat3=mysql_fetch_array($resp3)){
					$acuenta_ordentrabajo=$dat3[0];
				}	
				if($acuenta_ordentrabajo==""){
					$acuenta_ordentrabajo=0;
				}
			$contacto="";
					if($cod_contacto<>"" and $cod_contacto<>0 and $cod_contacto<>NULL){
					  $sql5="  select nombre_contacto, ap_paterno_contacto, ap_materno_contacto, telefono_contacto, celular_contacto, ";
					  $sql5.=" email_contacto, cargo_contacto ";
					  $sql5.="  from clientes_contactos ";
					  $sql5.=" where cod_contacto=".$cod_contacto;
					  $resp5= mysql_query($sql5);
					  while($dat5=mysql_fetch_array($resp5)){
							$contacto=$dat5['nombre_contacto']." ".$dat5['ap_paterno_contacto']." ".$dat5['ap_materno_contacto'];
							$telefono_contacto=$dat5['telefono_contacto'];
							$celular_contacto=$dat5['celular_contacto'];
					  		$email_contacto=$dat5['email_contacto']; 
							$cargo_contacto=$dat5['cargo_contacto'];
					  }
					}		
?> 
		<tr bgcolor="#FFFFFF">	
            <td align="right"><a href="../reportes/impresionOrdenTrabajo.php?cod_orden_trabajo=<?php echo $cod_orden_trabajo; ?>" target="_blank"><?php echo $nro_orden_trabajo."/".$gestion."(Int.".$numero_orden_trabajo.")"; ?></a><br/>
<a href="../reportes/impresionOrdenTrabajoSinPrecio.php?cod_orden_trabajo=<?php echo $cod_orden_trabajo; ?>" target="_blank"><?php echo $nro_orden_trabajo."/".$gestion; ?></a></td>
            <td align="right"><?php 
			list($aOT,$mOT,$dOT)=explode("-",$fecha_orden_trabajo);
			 echo $dOT.".".$mOT.".".$aOT;
			 ?></td>            
            <td><?php echo "<strong>".$nombre_cliente."</strong>"; 

						echo "<br/><strong>Direccion:</strong>".$direccion_cliente;
					echo "<br/><strong>Telf:</strong>".$telefono_cliente." ".$celular_cliente;
				if($contacto<>""){
					echo "<br/<strong>CONTACTO</strong>: ".$contacto;
					echo "<br/><strong>Cargo:/</strong>".$cargo_contacto;					
					echo "<br/><strong>Telefono:<strong> ".$telefono_contacto." ".$celular_contacto;

				}
			
			?></td>
            <td align="right"><?php echo $nombre_tipo_pago; ?></td>
			<td align="right"><?php echo number_format($monto_orden_trabajo,2); ?></td>
             <td align="right"><?php 
			 	if($incremento_orden_trabajo==""){
					$incremento_orden_trabajo=0;
				 }
				 	echo number_format($incremento_orden_trabajo,2);
				 
			 ?></td>
              <td align="right"><?php 
			 	if($descuento_orden_trabajo==""){
					$descuento_orden_trabajo=0;
				 }
					 echo number_format($descuento_orden_trabajo,2);
			 ?></td>
              <td align="right"><?php echo number_format((($monto_orden_trabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo),2); ?></td>
            <td align="right"><?php echo number_format($acuenta_ordentrabajo,2); ?></td>
            <td align="right"><?php echo number_format(((($monto_orden_trabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo)-$acuenta_ordentrabajo),2); ?></td>		

              <td><?php
              		$monto_gasto=0;
					$sqlAux=" select count(*) ";
					$sqlAux.=" from gastos_ordentrabajo where cod_orden_trabajo=".$cod_orden_trabajo;
					$respAux = mysql_query($sqlAux);
					$swGasto=0;
					while($datAux=mysql_fetch_array($respAux)){
								$swGasto=$datAux[0];
					}
					if($swGasto>0){
							$sqlAux="select sum(monto_gasto) ";
							$sqlAux.=" from gastos_ordentrabajo where cod_orden_trabajo=".$cod_orden_trabajo;
							$respAux = mysql_query($sqlAux);
							while($datAux=mysql_fetch_array($respAux)){
								$monto_gasto=$datAux[0];
							}										
					}
					echo number_format($monto_gasto,2);
			  
			  ?></td>		
			<td><?php echo $desc_est_ot;?></td>	
            <td><?php echo $desc_estado_pago_doc;?></td>	
            <td>
            <table border="0" align="center">
            <?php
            	$sql3=" select p.nro_pago, g.gestion, p.fecha_pago ";
				$sql3.=" from pagos_detalle pd, pagos p, gestiones g ";
				$sql3.=" where pd.cod_pago=p.cod_pago ";
				$sql3.=" and p.cod_gestion=g.cod_gestion";
				$sql3.=" and p.cod_estado_pago<>2 ";
				$sql3.=" and pd.codigo_doc=".$cod_orden_trabajo;
				$sql3.=" and pd.cod_tipo_doc=2 ";
				$resp3= mysql_query($sql3);	
				$nro_pago="";
				$gestion_pago="";
				$fecha_pago=""; 
				while($dat3=mysql_fetch_array($resp3)){
					$nro_pago=$dat3['nro_pago'];
					$gestion_pago=$dat3['gestion'];
					$fecha_pago=$dat3['fecha_pago']; 
					list($aP,$mP,$dP)=explode("-",$fecha_pago);
			?>
            	<tr>
                	<td><?php echo "Nro".$nro_pago."/".$gestion_pago; ?></td>
                    <td><?php echo $dP.".".$mP.".".$aP; ?></td>
                </tr>
            <?php
				}	
			?>
            </table>
            </td>
            <td>
            <table border="0" align="center">
            <?php
            	$sql3=" select fot.cod_factura,f.nro_factura,f.fecha_factura ";
				$sql3.=" from factura_ordentrabajo fot, facturas f ";
				$sql3.=" where fot.cod_factura=f.cod_factura ";
				$sql3.=" and f.cod_est_fac<>2 ";
				$sql3.=" and fot.cod_orden_trabajo=".$cod_orden_trabajo;
				$resp3= mysql_query($sql3);	
				$cod_factura="";
				$nro_factura="";
				$fecha_factura=""; 
				while($dat3=mysql_fetch_array($resp3)){
					$cod_factura=$dat3['cod_factura'];
					$nro_factura=$dat3['nro_factura'];
					$fecha_factura=$dat3['fecha_factura']; 
					list($aF,$mF,$dF)=explode("-",$fecha_factura);
			?>
            	<tr>
                	<td><?php echo "Nro.".$nro_factura; ?></td>
                    <td><?php echo $dF.".".$mF.".".$aF; ?></td>
                </tr>
            <?php
				}	
			?>
            </table>
            </td>     
              <td>
			  <?php
              	if($cod_est_ot<>2){
			  ?>
              <a href="editOrdenTrabajo.php?cod_orden_trabajo=<?php echo $cod_orden_trabajo;?>" >Editar</a></td>    
             <?php
				}else{
				echo "Editar";
				}
			  ?>                 
			<td>
			<?php 
				$sql3=" select count(*) ";
				$sql3.=" from pagos_detalle pd, pagos p";
				$sql3.=" where pd.cod_pago=p.cod_pago";
				$sql3.=" and p.cod_estado_pago<>2";
				$sql3.=" and pd.codigo_doc=".$cod_orden_trabajo;
				$sql3.=" and pd.cod_tipo_doc=2";
				$resp3= mysql_query($sql3);	
				$nroPagosOT=0;
				while($dat3=mysql_fetch_array($resp3)){
					$nroPagosOT=$dat3[0];
				}				

				if($cod_est_ot==2 or $nroPagosOT>0 ){
					 echo "Anular";}else{?>
	            <a href="anularOrdenTrabajo.php?cod_orden_trabajo=<?php echo $cod_orden_trabajo; ?>">Anular</a>
              <?php }?>
              </td>     
 			<td><a href="duplicarOrdenTrabajo.php?cod_orden_trabajo=<?php echo $cod_orden_trabajo; ?>" target="_blank">Duplicar O.T.</a></td>
          					                 					
   	  </tr>
<?php
		 } 
?>			

	   </tbody>
		</table>
		


</body>
</html>