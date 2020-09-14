<?php
header("Cache-Control: no-store, no-cache, must-revalidate");

//coneccion a la Base de Datos
require("conexion.inc");
include("funciones.php");
$nrocotizacionB=$_GET['nrocotizacionB'];
$nombreClienteB=$_GET['nombreClienteB'];
$nroHojaRutaB=$_GET['nroHojaRutaB'];
$codActivoFecha=$_GET['codActivoFecha'];
$fechaInicioB=$_GET['fechaInicioB'];
$fechaFinalB=$_GET['fechaFinalB'];
$cod_estado_pago_docB=$_GET['cod_estado_pago_docB'];
//para sacar los datos de la busqueda
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="pagina.css" rel="stylesheet" type="text/css" />
</head>

<body>

<?php 

	$nro_filas_show=50;	
	$pagina=$_GET['pagina'];

	if ($pagina==""){
		$pagina = 1;
		$fila_inicio=0;
		$fila_final=$nro_filas_show;
	}else{
		$fila_inicio=(($pagina*$nro_filas_show)-$nro_filas_show);
		$fila_final=($fila_inicio+$nro_filas_show);
	}	
	

	
	$sql=" select count(*) ";
	$sql.=" from hojas_rutas hr, gestiones g, estados_hojas_rutas ehr, cotizaciones c, clientes cli, estado_pago_documento ephr ";
	$sql.=" where hr.cod_gestion=g.cod_gestion ";
	$sql.=" and hr.cod_estado_hoja_ruta=ehr.cod_estado_hoja_ruta ";
	$sql.=" and hr.cod_cotizacion=c.cod_cotizacion ";
	$sql.=" and c.cod_cliente=cli.cod_cliente ";
	$sql.=" and hr.cod_estado_pago_doc=ephr.cod_estado_pago_doc ";
////Busqueda//////////////////
	if($nroHojaRutaB<>""){
		$sql.=" and CONCAT(hr.nro_hoja_ruta,'/',g.gestion) LIKE '%".$nroHojaRutaB."%' ";
	}
	if($nombreClienteB<>""){
		$sql.=" and cli.nombre_cliente like '%".$nombreClienteB."%' ";	
	}
	if($codActivoFecha=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);
				
				$sql.=" and hr.fecha_hoja_ruta>='".$aI."-".$mI."-".$dI."' and hr.fecha_hoja_ruta<='".$aF."-".$mF."-".$dF."' ";

		}
	}
	if($nrocotizacionB<>""){
		$sql.=" and c.cod_cotizacion in(select coti.cod_cotizacion from cotizaciones coti, gestiones ge  ";
		$sql.=" where coti.cod_gestion=ge.cod_gestion and CONCAT(COTI.nro_cotizacion,'/',ge.gestion) LIKE '%".$nrocotizacionB."%') ";
	}
	if($cod_estado_pago_docB<>0){
		$sql.=" and hr.cod_estado_pago_doc=".$cod_estado_pago_docB; 
	}	
	//Fin Busqueda/////////////////	
	//echo $sql;
	$resp_aux = mysql_query($sql);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}
?>
<h3 align="center" style="background:#FFF;font-size: 10px;color:#E78611;font-weight:bold;">Nro de Registros <?php echo $nro_filas_sql;?></h3>
<table border="0" align="center" >
<tr>

<td bgcolor="#FFFF66">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td ><strong>Comision</strong></td>
</tr>
</table>
<?php		
	if($nro_filas_sql==0){
?>
	<table width="90%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>Nro Hoja Ruta</td>            
    		<td>Fecha</td>
            <td>Cliente</td>	
            <td>Monto Bs.</td>
			<td>Desc. Bs.</td>
            <td>Inc. Bs.</td>
			<td>Total Monto Bs.</td>
            <td>A cuenta Bs.</td>
            <td>Saldo Bs.</td>
			<td>Monto Gastos Bs.</td>             														    		
			<td>Estado HR</td>      
            <td>Estado de Pago</td>                
			<td>Ref. Cotizacion</td>
            <td>Notas de Remision</td>
            <td>Facturas</td>          
		</tr>
		<tr><th colspan="15" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
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
		$sql=" select hr.cod_hoja_ruta, hr.cod_gestion, hr.nro_hoja_ruta, g.gestion , hr.fecha_hoja_ruta, hr.cod_cotizacion, ";
		$sql.=" c.cod_cliente, cli.nombre_cliente, cli.direccion_cliente, cli.telefono_cliente, cli.celular_cliente, c.cod_contacto, c.cod_unidad,";
		$sql.=" hr.cod_estado_hoja_ruta, ehr.nombre_estado_hoja_ruta, hr.factura_si_no, hr.cod_usuario_comision,  ";
		$sql.=" hr.cod_usuario_anular, hr.fecha_anular, hr.obs_anular, hr.fecha_registro, hr.cod_usuario_registro, ";
		$sql.=" hr.fecha_modifica, hr.cod_usuario_modifica, hr.obs_hoja_ruta, hr.cod_estado_pago_doc,";
		$sql.=" ephr.desc_estado_pago_doc, hr.informe ";
		$sql.=" from hojas_rutas hr, gestiones g, estados_hojas_rutas ehr, cotizaciones c, clientes cli,estado_pago_documento ephr ";
		$sql.=" where hr.cod_gestion=g.cod_gestion ";
		$sql.=" and hr.cod_estado_hoja_ruta=ehr.cod_estado_hoja_ruta ";
		$sql.=" and hr.cod_cotizacion=c.cod_cotizacion ";
		$sql.=" and c.cod_cliente=cli.cod_cliente ";
		$sql.=" and hr.cod_estado_pago_doc=ephr.cod_estado_pago_doc ";
		
////Busqueda//////////////////
	if($nroHojaRutaB<>""){
		$sql.=" and CONCAT(hr.nro_hoja_ruta,'/',g.gestion) LIKE '%".$nroHojaRutaB."%' ";
	}
	if($nombreClienteB<>""){
		$sql.=" and cli.nombre_cliente like '%".$nombreClienteB."%' ";	
	}
	if($codActivoFecha=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);
				
				$sql.=" and hr.fecha_hoja_ruta>='".$aI."-".$mI."-".$dI."' and hr.fecha_hoja_ruta<='".$aF."-".$mF."-".$dF."' ";

		}
	}

	if($nrocotizacionB<>""){
		$sql.=" and c.cod_cotizacion in(select coti.cod_cotizacion from cotizaciones coti, gestiones ge  ";
		$sql.=" where coti.cod_gestion=ge.cod_gestion and CONCAT(COTI.nro_cotizacion,'/',ge.gestion) LIKE '%".$nrocotizacionB."%') ";
	}
	if($cod_estado_pago_docB<>0){
		$sql.=" and hr.cod_estado_pago_doc=".$cod_estado_pago_docB; 
	}
	//Fin Busqueda/////////////////	
	$sql.=" order by  hr.cod_hoja_ruta desc";	
	//echo $sql;
		$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		//	echo $sql;
		$resp = mysql_query($sql);
		$cont=0;
?>	
	<table width="95%" align="center" cellpadding="1" id="cotizacion" cellspacing="1" bgColor="#cccccc">
<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="15">
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
			<td>Hoja Ruta</td>            
            <td>Cliente</td>	
            <td>Monto Bs.</td>
			<td>Desc. Bs.</td>
            <td>Inc. Bs.</td>
			<td>Total Monto Bs.</td>
            <td>A cuenta Bs.</td>
            <td>Saldo Bs.</td>
			<td>Monto Gastos Bs.</td>             														    		
			<td>Estado HR</td>      
            <td>Estado de Pago</td>                
            <td>Notas de Remision</td>
            <td>Facturas</td>
            <td>&nbsp;</td>
			 <td>&nbsp;</td>
		</tr>
<?php   
		while($dat=mysql_fetch_array($resp)){
				
			 $cod_hoja_ruta=$dat['cod_hoja_ruta'];
			 $cod_gestion=$dat['cod_gestion'];
			 $nro_hoja_ruta=$dat['nro_hoja_ruta'];
			 $gestion=$dat['gestion'];
			 $fecha_hoja_ruta=$dat['fecha_hoja_ruta'];
			 $cod_cotizacion=$dat['cod_cotizacion'];
			 $cod_cliente=$dat['cod_cliente'];
			 $nombre_cliente=$dat['nombre_cliente'];
			  $cod_contacto=$dat['cod_contacto'];
 			 $cod_unidad=$dat['cod_unidad'];
			 $direccion_cliente=$dat['direccion_cliente'];
			 $telefono_cliente=$dat['telefono_cliente'];
			 $celular_cliente=$dat['celular_cliente'];
			 $cod_estado_hoja_ruta=$dat['cod_estado_hoja_ruta'];
			 $nombre_estado_hoja_ruta=$dat['nombre_estado_hoja_ruta'];
			 $factura_si_no=$dat['factura_si_no'];
			 $cod_usuario_comision=$dat['cod_usuario_comision'];
			 $cod_usuario_anular=$dat['cod_usuario_anular'];
			 $fecha_anular=$dat['fecha_anular'];
			 $obs_anular=$dat['obs_anular']; 
			 $fecha_registro=$dat['fecha_registro'];
			 $cod_usuario_registro=$dat['cod_usuario_registro']; 
			 $fecha_modifica=$dat['fecha_modifica'];
			 $cod_usuario_modifica=$dat['cod_usuario_modifica'];
			 $obs_hoja_ruta=$dat['obs_hoja_ruta'];
			 $cod_estado_pago_doc=$dat['cod_estado_pago_doc'];
			 $desc_estado_pago_doc=$dat['desc_estado_pago_doc'];
 			 $informe=$dat['informe'];

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
					$nombre_unidad="";
					if($cod_unidad<>"" and $cod_unidad<>0 and $cod_unidad<>NULL){
					  $sql2="  select nombre_unidad,direccion_unidad, telf_unidad  from clientes_unidades ";
					  $sql2.=" where cod_unidad=".$cod_unidad;
					  $resp2= mysql_query($sql2);
					  while($dat2=mysql_fetch_array($resp2)){
							$nombre_unidad=$dat2['nombre_unidad'];
							$direccion_unidad=$dat2['direccion_unidad'];
							$telf_unidad=$dat2['telf_unidad'];
					  }
					}

							$nombre_usuario_comision="";				
					$sql2="select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios";
					$sql2.=" where cod_usuario='".$cod_usuario_comision."'";	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_usuario_comision=$dat2['nombres_usuario']." ".$dat2['ap_paterno_usuario']." ".$dat2['ap_materno_usuario'];
					}
								
		?> 
				<tr bgcolor="<?php if($cod_usuario_comision==2){ echo '#FFFFFF';}else{echo '#FFFF66';}?>" class="text"  title="<?php echo "De: ".$nombre_usuario_comision;?>" valign="middle">
    		<td align="right"><a href="../reportes/impresionHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta; ?>" target="_blank">HR:  <?php echo $nro_hoja_ruta."/".$gestion; ?></a>
			<br/><center><?php echo strftime("%d/%m/%Y",strtotime($fecha_hoja_ruta))." ".$usuarioHojaRuta; ?></center>
			<br/>
<?php 
				//Datos de Cotizacion////
			 	$sqlCotizacion=" select c.nro_cotizacion, g.gestion ";
				$sqlCotizacion.=" from cotizaciones c, gestiones g";
				$sqlCotizacion.=" where c.cod_gestion=g.cod_gestion";
				$sqlCotizacion.=" and c.cod_cotizacion=".$cod_cotizacion;
				$resp2 = mysql_query($sqlCotizacion);
				while($dat2=mysql_fetch_array($resp2)){
					$nro_cotizacion=$dat2['nro_cotizacion'];
					$gestion_cotizacion=$dat2['gestion'];
				}
			 ///Fin Datos de Cotizacion///
			 
			 ?>
            
            COT.:<a href="../reportes/impresionCotizacion.php?cod_cotizacion=<?php echo $cod_cotizacion; ?>" target="_blank">
			<?php echo $nro_cotizacion."/".$gestion_cotizacion;?></a>
            

			</td>	
            <td><?php echo "<strong>".$nombre_cliente."</strong>";
			
						echo "<br/><strong>Direccion:</strong>".$direccion_cliente;
					echo "<br/><strong>Telf:</strong>".$telefono_cliente." ".$celular_cliente;
			if($nombre_unidad<>""){
					echo "<br/><strong>UNIDAD:</strong> ".$nombre_unidad;
					echo "<br/><strong>Direccion:</strong> ".$direccion_unidad;
					echo "<br/>Telf: ".$telf_unidad;
				}
				if($contacto<>""){
					echo "<br/<strong>CONTACTO</strong>: ".$contacto;
					echo "<br/><strong>Cargo:/</strong>".$cargo_contacto;					
					echo "<br/><strong>Telefono:<strong> ".$telefono_contacto." ".$celular_contacto;

				}
?>
			</td>

            <td align="right" bgcolor="#FFFFCC">
				<?php
							$monto_hojaruta=0;				
							$sqlAux=" select sum(cd.IMPORTE_TOTAL) ";
							$sqlAux.=" from hojas_rutas_detalle hrd, cotizaciones_detalle cd ";
							$sqlAux.=" where hrd.cod_hoja_ruta=".$cod_hoja_ruta;
							$sqlAux.=" and hrd.cod_cotizacion=cd.cod_cotizacion ";
							$sqlAux.=" and hrd.cod_cotizaciondetalle=cd.cod_cotizaciondetalle ";
							$respAux = mysql_query($sqlAux);
							while($datAux=mysql_fetch_array($respAux)){
								$monto_hojaruta=$datAux[0];
							}
							echo $monto_hojaruta;
				 ?>
             </td>	
            <td align="right" bgcolor="#FFFFCC" >
				<?php  
					$descuento_cotizacion=0;
					$sqlAux="select descuento_cotizacion from cotizaciones where cod_cotizacion=".$cod_cotizacion;
					$respAux = mysql_query($sqlAux);
					while($datAux=mysql_fetch_array($respAux)){
							$descuento_cotizacion=$datAux[0];
					}
					
					if($descuento_cotizacion>0){
						echo $descuento_cotizacion;
					}else{
						$descuento_cotizacion=0;
						echo "0";
					}	
				?>
             </td>	
            <td align="right" bgcolor="#FFFFCC" >
				<?php  
					$incremento_cotizacion=0;
					$sqlAux="select incremento_cotizacion from cotizaciones where cod_cotizacion=".$cod_cotizacion;
					$respAux = mysql_query($sqlAux);
					while($datAux=mysql_fetch_array($respAux)){
							$incremento_cotizacion=$datAux[0];
					}
					
					if($incremento_cotizacion>0){
						echo $incremento_cotizacion;
					}else{
						$incremento_cotizacion=0;
						echo "0";
					}	
				?>
             </td>             
            <td align="right" bgcolor="#FFFFCC">
				<?php	echo (($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion); ?>
             </td>	
             <td align="right" bgcolor="#FFFFCC"><?php 
			 	$sql2=" select  pd.monto_pago_detalle, p.fecha_pago ";
			 	$sql2.=" from pagos_detalle pd, pagos p";
			 	$sql2.=" where pd.cod_pago=p.cod_pago";
			 	$sql2.=" and p.cod_estado_pago<>2";
			 	$sql2.=" and pd.codigo_doc=".$cod_hoja_ruta;
				$sql2.=" and pd.cod_tipo_doc=1";
				$resp2 = mysql_query($sql2);
				$acuenta_hojaruta=0;
				while($dat2=mysql_fetch_array($resp2)){
					
					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					$fecha_pago=$dat2['fecha_pago'];
					$acuenta_hojaruta=$acuenta_hojaruta+$monto_pago_detalle;
				
				}				
			 echo $acuenta_hojaruta;

			 
			 ?></td>	
			<td align="right" bgcolor="#FFFFCC"><?php echo ((($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion)-$acuenta_hojaruta);?></td>	 			 			 
            <td align="right">
			<?php
					$monto_gasto=0;
					$sqlAux="select count(*) from gastos_hojasrutas where cod_hoja_ruta=".$cod_hoja_ruta;
					$respAux = mysql_query($sqlAux);
					$swGasto=0;
					while($datAux=mysql_fetch_array($respAux)){
								$swGasto=$datAux[0];
					}
					if($swGasto>0){
							$sqlAux="select sum(monto_gasto) from gastos_hojasrutas where cod_hoja_ruta=".$cod_hoja_ruta;
							$respAux = mysql_query($sqlAux);
							while($datAux=mysql_fetch_array($respAux)){
								$monto_gasto=$datAux[0];
							}										
					}
					echo $monto_gasto;
            ?>
            </td> 
                       											
    		<td class="colh1"><?php echo $nombre_estado_hoja_ruta;?>
				<?php if($cod_estado_hoja_ruta==2){ ?>
					<?php echo "\n".$obs_anular; ?>
				<?php }?>			
          </td>
<td align="left" <?php if(((($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion)-$acuenta_hojaruta)>0 and $cod_estado_pago_doc==3){?>  bgcolor="#FF3333"<?php }?>><?php echo $desc_estado_pago_doc; ?></td>

            
		  <td>
			<?php 
				$numNotasRemision=0;
				$sql3=" select count(*) from notas_remision  where cod_hoja_ruta='".$cod_hoja_ruta."'";
				$resp3= mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3)){
					$numNotasRemision=$dat3[0];
				}
				
				if($numNotasRemision>0){

					$sql3=" select cod_nota_remision, nro_nota_remision, cod_gestion,";
					$sql3.=" fecha_nota_remision, cod_usuario_nota_remision,";
					$sql3.=" obs_nota_remision, cod_estado_nota_remision ";
					$sql3.=" from notas_remision  where cod_hoja_ruta='".$cod_hoja_ruta."'";
					$resp3= mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						
						$cod_nota_remision=$dat3[0];
						$nro_nota_remision=$dat3[1];
						$cod_gestion_nota_remision=$dat3[2];
						$fecha_nota_remision=$dat3[3];
						$cod_usuario_nota_remision=$dat3[4];
						$obs_nota_remision=$dat3[5];
						$cod_estado_nota_remision=$dat3[6];
						
						$sql4=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario  ";
						$sql4.=" from usuarios where cod_usuario='".$cod_usuario_nota_remision."'";
						$UsuarioNotaRemision="";
						$resp4= mysql_query($sql4);
						while($dat4=mysql_fetch_array($resp4)){
							$UsuarioNotaRemision=$dat4[0]." ".$dat4[1];
						}
						$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion_nota_remision."'";
						$resp2= mysql_query($sql2);
						$gestionNotaRemision="";
						while($dat2=mysql_fetch_array($resp2)){
							$gestionNotaRemision=$dat2[0];
						}

			?>

				 <a href="../reportes/impresionNotaRemision.php?cod_nota_remision=<?php echo $cod_nota_remision; ?>" target="_blank"><?php echo $nro_nota_remision."/".$gestionNotaRemision."; ";?></a>


				
			<?php	}
			 }	?>
 			
</td>		
			<td align="left">
            
            <?php 
				$numFacturas=0;
				$sql3=" select count(*) from factura_hojaruta  where cod_hoja_ruta='".$cod_hoja_ruta."'";
				//echo $sql3;
				$resp3= mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3)){
					$numFacturas=$dat3[0];
				}
				
				if($numFacturas>0){
			?>
             <table border="0" align="left">
			<?php
				$sqlFactura=" select f.cod_factura, f.nro_factura, f.nombre_factura, ";
				$sqlFactura.=" f.nit_factura, f.fecha_factura, f.detalle_factura,f.obs_factura, f.cod_est_fac,  ";
				$sqlFactura.=" ef.desc_est_fac, f.monto_factura, f.cod_usuario_registro,   ";
				$sqlFactura.=" f.fecha_registro, f.cod_usuario_modifica, f.fecha_modifica  ";
				$sqlFactura.=" from facturas f, estado_factura ef  ";
				$sqlFactura.=" where f.cod_est_fac=ef.cod_est_fac ";
				$sqlFactura.=" and f.cod_factura in(select cod_factura from factura_hojaruta where cod_hoja_ruta=".$cod_hoja_ruta.")";
				
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
            <?php
			 }	
			?>
          </td>
          <!--td align="justify">
          	<?php
				$sql3=" select count(*) ";
				$sql3.=" from gastos_hojasrutas ghr, gastos g";
				$sql3.=" where ghr.cod_gasto=g.cod_gasto";
				$sql3.=" and ghr.cod_hoja_ruta=".$cod_hoja_ruta;
				$resp3 = mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3)){
					$nro_filas=$dat3[0];
				}
            ?>     
            <?php if($nro_filas>0){?>
            <table cellpadding="0" cellspacing="0" border="0">
            <?php
            	$sql3=" select ghr.cod_gasto, g.desc_gasto, ghr.monto_gasto ";
				$sql3.=" from gastos_hojasrutas ghr, gastos g";
				$sql3.=" where ghr.cod_gasto=g.cod_gasto";
				$sql3.=" and ghr.cod_hoja_ruta=".$cod_hoja_ruta;
				$resp3 = mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3)){
					$desc_gasto=$dat3['desc_gasto'];
					$monto_gasto=$dat3['monto_gasto'];

			?>
	            <tr>
                <td><?php echo $desc_gasto;?></td>
                <td align="right"><?php echo $monto_gasto;?></td>
                </tr>
            <?php }?>
            </table>            
			<?php }?>     
          </td-->
            <td>
			<a href="../reportes/infHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta; ?>" target="_blank">Informe</a>
			<br/><br/>
            <?php if($cod_estado_hoja_ruta<>2){?><a href="listGastoHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta;?>">Costos </a>
             <?php }?>
            </td>   
			<td><div id="div_estadoInf<?php echo $cod_hoja_ruta; ?>">
			<?php if($informe=="NO"){?><a href="javascript:cambiarEstadoInf(<?php echo $cod_hoja_ruta; ?>,'SI')" >CERRAR</a><?php }?>
			<?php if($informe=="SI"){?><img src="images/cerrado.jpg" height="25px" width="25px"><a href="javascript:cambiarEstadoInf(<?php echo $cod_hoja_ruta; ?>,'NO')" ><br/>ABRIR</a><?php }?></div>
			</td>       								
							            
   	  </tr>
<?php
		 } 
?>			
  			<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="15">
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