<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml version="1.0" encoding="ISO-8859-1">
<head>
<meta http-equiv="Content-Type" content="application/json; text/html; charset=iso-8859-1" />
<title>Hojas de Ruta</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">
function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function resultados_ajax(datos){
	divResultado = document.getElementById('resultados');
	ajax=objetoAjax();
	ajax.open("GET",datos);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			divResultado.innerHTML = ajax.responseText;
			cargarClasesFrame();	
			agregarTablaReporteClase();
		}
	}
	ajax.send(null)
}
function buscar()
{	
	if(document.form1.codActivoFecha.checked){
		valorchecked="on";
	}else{
		valorchecked="off";
	}

		resultados_ajax('searchHojasRutas.php?nrocotizacionB='+document.form1.nrocotizacionB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&nroHojaRutaB='+document.form1.nroHojaRutaB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&cod_estado_pago_docB='+document.form1.cod_estado_pago_docB.value);

}
function paginar(f)
{	
if(document.form1.codActivoFecha.checked){
	valorchecked="on";
}else{
	valorchecked="off";
}
		resultados_ajax('searchHojasRutas.php?nrocotizacionB='+document.form1.nrocotizacionB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&nroHojaRutaB='+document.form1.nroHojaRutaB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&cod_estado_pago_docB='+document.form1.cod_estado_pago_docB.value+'&pagina='+document.form1.pagina.value);
			

}
function paginar1(f,pagina)
{		
if(document.form1.codActivoFecha.checked){
	valorchecked="on";
}else{
	valorchecked="off";
}
		f.pagina.value=pagina*1;		
		resultados_ajax('searchHojasRutas.php?nrocotizacionB='+document.form1.nrocotizacionB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&nroHojaRutaB='+document.form1.nroHojaRutaB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&cod_estado_pago_docB='+document.form1.cod_estado_pago_docB.value+'&pagina='+document.form1.pagina.value);
			
}

function openPopup(url){
	window.open(url,'GASTOS','top=50,left=200,width=400,height=300,scrollbars=1,resizable=1');
}
</script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF">
<form name="form1" method="post"  id="form1">
<?php
	require("conexion.inc");
	include("funciones.php");
	
	$nrocotizacionB=$_GET['nrocotizacionB'];
	$nombreClienteB=$_GET['nombreClienteB'];
	$nroHojaRutaB=$_GET['nroHojaRutaB'];
	$codActivoFecha=$_GET['codActivoFecha'];
	$fechaInicioB=$_GET['fechaInicioB'];
	$fechaFinalB=$_GET['fechaFinalB'];
	$cod_estado_pago_docB=$_GET['cod_estado_pago_docB'];

?>
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">LISTADO DE HOJAS DE RUTA 
   <a class="btn btn-warning btn-lg float-right text-white boton-filtro-iframe" href="#" data-toggle="modal" data-target="#filtroModal">
       <i class="fa fa-search"></i> BUSCAR REGISTROS
    </a>
</h3>



<div id="resultados">
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
		$sql=" select hr.cod_hoja_ruta, hr.cod_gestion, hr.nro_hoja_ruta, g.gestion, g.gestion_nombre, hr.fecha_hoja_ruta, hr.cod_cotizacion, ";
		$sql.=" c.cod_cliente, cli.nombre_cliente,";
		$sql.=" hr.cod_estado_hoja_ruta, ehr.nombre_estado_hoja_ruta, hr.factura_si_no, hr.cod_usuario_comision,  ";
		$sql.=" hr.cod_usuario_anular, hr.fecha_anular, hr.obs_anular, hr.fecha_registro, hr.cod_usuario_registro, ";
		$sql.=" hr.fecha_modifica, hr.cod_usuario_modifica, hr.obs_hoja_ruta, hr.cod_estado_pago_doc,";
		$sql.=" ephr.desc_estado_pago_doc ";
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
		$sql.=" limit 50";
		//	echo $sql;
		$resp = mysql_query($sql);
		$cont=0;
?>	
	<table width="95%" align="center" cellpadding="1" id="cotizacion" cellspacing="1" bgColor="#cccccc" class="tablaReporte" style="width:100% !important;">
        <thead>  
	    <tr height="20px" align="center"  class="bg-success text-white">
			<th>Nro Hoja Ruta</th>            
    		<th>Fecha</th>
            <th>Cliente</th>	
            <!--th>Monto Bs.</th>
			<th>Desc. Bs.</th>
            <th>Inc. Bs.</th>
			<th>Total Monto Bs.</th>
            <th>A cuenta Bs.</th>
            <th>Saldo Bs.</th>
			<th>Monto Gastos Bs.</th-->             														    		
			<th>Estado HR</th>      
            <th>Estado de Pago</th>                
			<th>Ref. Cotizacion</th>
            <th>Notas de Remision</th>
            <th>Facturas</th>
            <!--th>&nbsp;</th>
            <th>Informe</th-->   
		</tr>
	</thead> 
	<tbody>	
<?php   
		while($dat=mysql_fetch_array($resp)){
				
			 $cod_hoja_ruta=$dat['cod_hoja_ruta'];
			 $cod_gestion=$dat['cod_gestion'];
			 $nro_hoja_ruta=$dat['nro_hoja_ruta'];
			 $gestion=$dat['gestion'];
			 $gestion_nombre=$dat['gestion_nombre'];
			 $fecha_hoja_ruta=$dat['fecha_hoja_ruta'];
			 $cod_cotizacion=$dat['cod_cotizacion'];
			 $cod_cliente=$dat['cod_cliente'];
			 $nombre_cliente=$dat['nombre_cliente'];
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

		
								
		?> 
		<tr bgcolor="#FFFFFF" valign="middle" >	
    		<td align="right"><a href="../reportes/impresionHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta; ?>" target="_blank"> <?php echo $nro_hoja_ruta."/".$gestion_nombre; ?></a></td>	
			<td><?php echo strftime("%d/%m/%Y",strtotime($fecha_hoja_ruta))." ".$usuarioHojaRuta; ?></td>
            <td><?php echo $nombre_cliente;?></td>

            <!--td align="right" bgcolor="#FFFFCC">
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
             </td-->	
            <!--td align="right" bgcolor="#FFFFCC" >
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
             </td-->	
            <!--td align="right" bgcolor="#FFFFCC" >
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
             </td-->             
            <!--td align="right" bgcolor="#FFFFCC">
				<?php	echo (($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion); ?>
             </td-->	
             <!--td align="right" bgcolor="#FFFFCC"><?php 
			 	$sql2=" select pd.cod_moneda, pd.monto_pago_detalle, p.fecha_pago ";
			 	$sql2.=" from pagos_detalle pd, pagos p";
			 	$sql2.=" where pd.cod_pago=p.cod_pago";
			 	$sql2.=" and p.cod_estado_pago<>2";
			 	$sql2.=" and pd.codigo_doc=".$cod_hoja_ruta;
				$sql2.=" and pd.cod_tipo_doc=1";
				$resp2 = mysql_query($sql2);
				$acuenta_hojaruta=0;
				while($dat2=mysql_fetch_array($resp2)){
					$cod_moneda=$dat2['cod_moneda'];
					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					$fecha_pago=$dat2['fecha_pago'];

					if($cod_moneda==1){
						$acuenta_hojaruta=$acuenta_hojaruta+$monto_pago_detalle;
					}else{
							$sql3=" select cambio_bs from tipo_cambio";
							$sql3.=" where fecha_tipo_cambio='".$fecha_pago."'";
							$sql3.=" and cod_moneda=".$cod_moneda;

							$resp3=mysql_query($sql3);
							$cambio_bs=0;
							while($dat3=mysql_fetch_array($resp3)){
								$cambio_bs=$dat3['cambio_bs'];
							}
							if($cambio_bs<>0){
								$acuenta_hojaruta=$acuenta_hojaruta+($monto_pago_detalle*$cambio_bs);
							
							}
						
					}
				}				
			 echo $acuenta_hojaruta;

			 
			 ?></td-->	
			<!--td align="right" bgcolor="#FFFFCC"><?php echo ((($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion)-$acuenta_hojaruta);?></td-->	 			 			 
            <!--td align="right">
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
            </td--> 
                       											
    		<td class="colh1"><?php echo $nombre_estado_hoja_ruta;?>
				<?php if($cod_estado_hoja_ruta==2){ ?>
					<?php echo "\n".$obs_anular; ?>
				<?php }?>			
          </td>
          <td><?php echo $desc_estado_pago_doc; ?></td>
			<td><?php 
				//Datos de Cotizacion////
			 	$sqlCotizacion=" select c.nro_cotizacion, g.gestion_nombre ";
				$sqlCotizacion.=" from cotizaciones c, gestiones g";
				$sqlCotizacion.=" where c.cod_gestion=g.cod_gestion";
				$sqlCotizacion.=" and c.cod_cotizacion=".$cod_cotizacion;
				$resp2 = mysql_query($sqlCotizacion);
				while($dat2=mysql_fetch_array($resp2)){
					$nro_cotizacion=$dat2['nro_cotizacion'];
					$gestion_cotizacion=$dat2['gestion_nombre'];
				}
			 ///Fin Datos de Cotizacion///
			 
			 ?>
            
            <a href="../reportes/impresionCotizacionFormato.php?cod_cotizacion=<?php echo $cod_cotizacion; ?>" target="_blank">
			<?php echo $nro_cotizacion."/".$gestion_cotizacion;?></a>
            
          </td>
            
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
            <!--td>
            <?php if($cod_estado_hoja_ruta<>2){?><a href="listGastoHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta;?>"> + Gastos</a>
             <?php }?>
            </td>
            <td>
<a href="../reportes/infHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta; ?>" target="_blank">Informe</a>
            </td-->            								
							            
   	  </tr>
<?php
		 } 
?>			

			</tbody>
		</table>
		
</div>	




<!-- MODAL FILTRO-->
  <div class="modal fade modal-arriba" id="filtroModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Buscar</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </div>
        <div class="modal-body">
<table border="0" align="center">
<td><strong>Nro de Hoja de Ruta</strong></td>
<td colspan="3"><input type="text" name="nroHojaRutaB" id="nroHojaRutaB" size="10" value="<?php echo $nroHojaRutaB;?>" class="textoform" onkeyup="buscar()" ></td>
</tr>
<tr>
<td><strong>Nro de Cotizacion</strong></td>
<td colspan="3"><input type="text" name="nrocotizacionB" id="nrocotizacionB" size="10" class="textoform" onkeyup="buscar()" value="<?php echo $nrocotizacionB;?>" ></td>
</tr>
<tr><td><strong>Clientes</strong></td>
<td colspan="3">
 <input name="nombreClienteB" id="nombreClienteB" size="30" class="textoform" value="<?php echo $nombreClienteB; ?>" onkeyup="buscar()">
	</td>
	<td rowspan="2">&nbsp;</td>
</tr>

<tr>

<tr class="texto">
         <td width="90" align="left" ><strong>Estado de Pago</strong></td>
         <td width="256" align="left"><select name="cod_estado_pago_docB" id="cod_estado_pago_docB" onchange="buscar();" class="textoform">
				<option value="0">Elija un Opci&oacute;n</option>
				<?php
					$sql2=" select cod_estado_pago_doc, desc_estado_pago_doc";
					$sql2.=" from   estado_pago_documento ";
					$sql2.=" order by cod_estado_pago_doc asc ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_estado_pago_doc=$dat2['cod_estado_pago_doc'];	
			  		 		$desc_estado_pago_doc=$dat2['desc_estado_pago_doc'];	
				 ?>
                 <option value="<?php echo $cod_estado_pago_doc;?>" <?php if($cod_estado_pago_docB==$cod_estado_pago_doc){?> selected="selected" <?php } ?>><?php echo utf8_decode($desc_estado_pago_doc);?></option>				
				<?php		
					}
				?>						
			</select></td>
       </tr>       

<tr >
     		<td>&nbsp;<b>Rango de Fecha<br/>(dd/mm/aaaa)</b>&nbsp;</td>			
     		<td><strong>De&nbsp;</strong>
                <input type="text" name="fechaInicioB" id="fechaInicioB" class="textoform" value="<?php echo $fechaInicioB; ?>">
        <strong>&nbsp;Hasta&nbsp;</strong>
        <input type="text" name="fechaFinalB" id="fechaFinalB" class="textoform" value="<?php echo $fechaFinalB; ?>" >
<input type="checkbox" name="codActivoFecha" id="codActivoFecha" <?php if($codActivoFecha=="on"){?>checked="checked"<?php }?> onClick="buscar()" ><strong>Chekear la casilla para buscar por fechas.</strong>
			</td>
    	</tr>
</table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
<?php require("cerrar_conexion.inc");
?>
<br>

</form>

</body>
</html>
