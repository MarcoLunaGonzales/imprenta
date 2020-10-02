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
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script language='Javascript'>
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
	ajax.open("GET", datos);
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
	for (i=0;i<document.form1.tipo_factura.length;i++){ 
       if (document.form1.tipo_factura[i].checked) 
          break; 
    }	
	if(document.form1.codActivoFecha.checked){
		valorchecked="on";
	}else{
		valorchecked="off";
	}

resultados_ajax('searchFacturas.php?nroFacturaB='+document.form1.nroFacturaB.value+'&nitFacturaB='+document.form1.nitFacturaB.value+'&nombreFacturaB='+document.form1.nombreFacturaB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&descEstFacB='+document.form1.descEstFacB.value+'&nroHojaRutaB='+document.form1.nroHojaRutaB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&tipo_factura='+document.form1.tipo_factura[i].value);

}
function paginar(f)
{	
	for (i=0;i<document.form1.tipo_factura.length;i++){ 
       if (document.form1.tipo_factura[i].checked) 
          break; 
    }	
	if(document.form1.codActivoFecha.checked){
		valorchecked="on";
	}else{
		valorchecked="off";
	}
		location.href='listFacturas.php?nroFacturaB='+document.form1.nroFacturaB.value+'&nitFacturaB='+document.form1.nitFacturaB.value+'&nombreFacturaB='+document.form1.nombreFacturaB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&descEstFacB='+document.form1.descEstFacB.value+'&nroHojaRutaB='+document.form1.nroHojaRutaB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&tipo_factura='+document.form1.tipo_factura[i].value+'&pagina='+document.form1.pagina.value;
}
function paginar1(f,pagina)
{		

		f.pagina.value=pagina*1;		
		for (i=0;i<document.form1.tipo_factura.length;i++){ 
       if (document.form1.tipo_factura[i].checked) 
          break; 
    }	
	if(document.form1.codActivoFecha.checked){
		valorchecked="on";
	}else{
		valorchecked="off";
	}
		location.href='listFacturas.php?nroFacturaB='+document.form1.nroFacturaB.value+'&nitFacturaB='+document.form1.nitFacturaB.value+'&nombreFacturaB='+document.form1.nombreFacturaB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&descEstFacB='+document.form1.descEstFacB.value+'&nroHojaRutaB='+document.form1.nroHojaRutaB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&tipo_factura='+document.form1.tipo_factura[i].value+'&pagina='+document.form1.pagina.value;	
}

</script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#F7F5F3" onload="document.form1.nroFacturaB.focus()" >
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->

<h3 align="center" style="background:#F7F5F3;font-size: 14px;color: #E78611;font-weight:bold;">LISTADO DE FACTURAS
  <a class="btn btn-warning btn-lg float-right text-white boton-filtro-iframe" href="#" data-toggle="modal" data-target="#filtroModal">
       <i class="fa fa-search"></i> BUSCAR REGISTROS
    </a>
</h3>
<form name="form1" method="post" >
<?php
	$tipo_factura=$_GET['tipo_factura'];
	$nroFacturaB=$_GET['nroFacturaB'];
	$nitFacturaB=$_GET['nitFacturaB'];
	$nombreFacturaB=$_GET['nombreFacturaB'];
	$nombreClienteB=$_GET['nombreClienteB'];
	$nroHojaRutaB=$_GET['nroHojaRutaB'];
	$fechaInicioB=$_GET['fechaInicioB'];
	$fechaFinalB=$_GET['fechaFinalB'];
	$descEstFacB=$_GET['descEstFacB'];

?>


<br/>
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
		
		$sql.=" order by f.nro_factura desc ";
			$sql.=" limit 50";
		$resp = mysql_query($sql);

?>	
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc" class="tablaReporte" style="width:100% !important;">
<thead>
	    <tr height="20px" align="center"  class="bg-success text-white">
            <th>Nro Factura</th>
			<th>Fecha Factura</th>
            <th>NIT</th>
            <th>Nombre</th>            
            <th>Monto (Bs.)</th>	
            <th>Detalle</th>			
<th>Observacion</th>
            <th>Hoja de Ruta</th>
            <th>Orden de Trabajo</th>	
			<th>Estado Actual</th>	
			<th>Fecha de Registro</th>
			<th>Fecha de Ultima Edicion</th> 
	        <th>&nbsp;</th>                      	            																	
		</tr>
		</thead>
  <tbody>
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
				//echo $queryFacHojaRuta;
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
            <td align="justify"><?php /*echo $detalle_factura; */?></td>
            <td><?php echo $obs_factura; ?></td>
            <td>
            <?php 
			if($cod_hoja_ruta<>0){
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
			<?php echo $cod_hoja_ruta." ".$nro_hoja_ruta."/".$gestion." (".$nombre_cliente.")"; ?>
            </a>
            <?php
					
				}?>
          </td>
<td>
 <?php 
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
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr >
          <td width="122" align="right">TODAS FACTURAS</td>
          <td width="20">
          <label>
            <input name="tipo_factura" type="radio" id="tipo_factura" value="0" checked="checked" <?php if($tipo_factura==0){?>checked="checked"<?php }?> onclick="buscar()"/>
          </label></td>

         	    <td width="126" align="right" >FACT POR HOJAS DE RUTAS</td>
        		<td width="20">
		    	 <label>
	               <input name="tipo_factura" type="radio" id="tipo_factura" value="1" <?php if($tipo_factura==1){?>checked="checked"<?php }?>   onclick="buscar()"/>
        		  </label>
          		</td>
         	    <td width="126" align="right" >FACT POR ORD. DE TRABAJO</td>
        		<td width="20">
		    	 <label>
	               <input name="tipo_factura" type="radio" id="tipo_factura" value="2" <?php if($tipo_factura==2){?>checked="checked"<?php }?>  onclick="buscar()"/>
        		  </label>
          		</td>          
         	    <td width="126" align="right" >FACT POR OTROS CONCEPTOS</td>
        		<td width="20">
		    	 <label>
	               <input name="tipo_factura" type="radio" id="tipo_factura" value="3" <?php if($tipo_factura==3){?>checked="checked"<?php }?>  onclick="buscar()"/>
        		  </label>
          		</td>                        
</tr>
      </table>
<br/>

    <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr class="texto">
          <td width="150" align="right" class="al_derecha">Nro Factura:</td>
          <td width="350" align="left"><span id="sprytextfield1">
            <label for="nroFacturaB"></label>
            <input type="text" name="nroFacturaB" id="nroFacturaB" class="textoform" size="30" value="<?php echo $nroFacturaB;?>" onkeyup="buscar()" />
        <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
      <tr class="texto">
        <td width="150" align="right" class="al_derecha">NIT:</td>
          <td width="350" align="left"><span id="sprytextfield2">
            <label for="nitFacturaB"></label>
            <input type="text" name="nitFacturaB" id="nitFacturaB" class="textoform" size="30" value="<?php echo $nitFacturaB;?>" onkeyup="buscar()"  />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
      </tr>
      <tr class="texto">
        <td width="90" align="right" class="al_derecha">Nombre:</td>
          <td width="256" align="left"><span id="sprytextfield3">
            <label for="nombreFacturaB"></label>
            <input type="text" name="nombreFacturaB" id="nombreFacturaB" value="<?php echo $nombreFacturaB; ?>" class="textoform" size="30" onkeyup="buscar()" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
      </tr> 
      <tr class="texto">
        <td width="90" align="right" class="al_derecha">Cliente:</td>
          <td width="256" align="left"><span id="sprytextfield4">
            <label for="nombreClienteB"></label>
            <input type="text" name="nombreClienteB" id="nombreClienteB"  class="textoform" value="<?php echo $nombreClienteB;?>" size="30" onkeyup="buscar()"/>
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
      </tr>        
       <tr class="texto">
         <td width="90" align="right" class="al_derecha">Estado de Factura:</td>
         <td width="256" align="left"><span id="sprytextfield8">
           <label for="descEstFacB"></label>
           <input type="text" name="descEstFacB" id="descEstFacB" value="<?php echo $descEstFacB; ?>" class="textoform" size="30"onkeyup="buscar()" />
         <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
       </tr>       
   <tr class="texto">
         <td width="90" align="right" class="al_derecha">Nro de Hoja de Ruta:</td>
          <td width="256" align="left"><span id="sprytextfield5">
            <label for="nroHojaRutaB"></label>
            <input type="text" name="nroHojaRutaB" id="nroHojaRutaB"  class="textoform" size="30" value="<?php echo $nroHojaRutaB;?>" onkeyup="buscar()"/>
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
       </tr> 
       <tr class="texto">
         <td width="90" align="right" class="al_derecha">Rango de Fecha:</td>
          <td width="256" align="left"><span id="sprytextfield6">
          <label for="fechaInicioB">De</label>
          <input type="text" name="fechaInicioB" id="fechaInicioB" class="textoform" value="<?php echo $fechaInicioB; ?>" size="10" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span><span id="sprytextfield7">
          <label for="fechaFinalB">Hasta</label>
          <input type="text" name="fechaFinalB" id="fechaFinalB" class="textoform" value="<?php echo $fechaFinalB;?>" size="10"  />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span><input type="checkbox" name="codActivoFecha" id="codActivoFecha" onClick="buscar()" <?php if($codActivoFecha=="on"){?>checked="checked"<?php }?>></td>
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


</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "date", {format:"dd/mm/yyyy"});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy"});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8");
</script>
</body>
</html>


