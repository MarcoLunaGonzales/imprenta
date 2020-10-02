<?php
function suma_fechas($fecha,$ndias)
{
             
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
            
              list($año,$mes,$dia)=split("-", $fecha);
            
 
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            
 
              list($año,$mes,$dia)=split("-",$fecha);
        $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
        $nuevafecha=date("Y-m-d",$nueva);
             
      return ($nuevafecha);  
          
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">

<title>MODULO DE ALMACENES</title>
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

	
resultados_ajax('searchSalidas.php?nroSalidaB='+document.form1.nroSalidaB.value+'&tipoSalidaB='+document.form1.tipoSalidaB.value+'&nroHojaRutaB='+document.form1.nroHojaRutaB.value+'&nroOrdenTrabajoB='+document.form1.nroOrdenTrabajoB.value+'&almacenTraspasoB='+document.form1.almacenTraspasoB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&estadoSalidaB='+document.form1.estadoSalidaB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&descCompletaMaterialB='+document.form1.descCompletaMaterialB.value);

}



function paginar(f)
{	
	if(document.form1.codActivoFecha.checked){
		valorchecked="on";
	}else{
		valorchecked="off";
	}
resultados_ajax('searchSalidas.php?nroSalidaB='+document.form1.nroSalidaB.value+'&tipoSalidaB='+document.form1.tipoSalidaB.value+'&nroHojaRutaB='+document.form1.nroHojaRutaB.value+'&nroOrdenTrabajoB='+document.form1.nroOrdenTrabajoB.value+'&almacenTraspasoB='+document.form1.almacenTraspasoB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&estadoSalidaB='+document.form1.estadoSalidaB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&descCompletaMaterialB='+document.form1.descCompletaMaterialB.value+'&pagina='+document.form1.pagina.value);


}
function paginar1(f,pagina)
{		
f.pagina.value=pagina*1;
if(document.form1.codActivoFecha.checked){
	valorchecked="on";
}else{
	valorchecked="off";
}
resultados_ajax('searchSalidas.php?nroSalidaB='+document.form1.nroSalidaB.value+'&tipoSalidaB='+document.form1.tipoSalidaB.value+'&nroHojaRutaB='+document.form1.nroHojaRutaB.value+'&nroOrdenTrabajoB='+document.form1.nroOrdenTrabajoB.value+'&almacenTraspasoB='+document.form1.almacenTraspasoB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&estadoSalidaB='+document.form1.estadoSalidaB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&descCompletaMaterialB='+document.form1.descCompletaMaterialB.value+'&pagina='+document.form1.pagina.value);
}
function anular(cod_salida,nro_salida,cod_estado_salida,swValIngreso)
{	
		if(swValIngreso==0){
			alert('La Salida No.'+nro_salida+' no puede ser anulada, porque esta genero un Ingreso en otro Almacen.');
		}else{
			if(cod_estado_salida==2){
				alert('La Salida No.'+nro_salida+' ya se encuentra anulada.');
			}else{
				
					msj=confirm('Esta seguro de Anular la Salida No.'+nro_salida);
					if(msj==true)
					{
						izquierda=(screen.width)?(screen.width-300)/2:100
						arriba=(screen.height)?(screen.height-400)/2:100
						url="anularSalida.php?cod_salida="+cod_salida;
						opciones=" toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=1,resizable=0, width=500, height=280, left="+izquierda+" top="+arriba;
	
						window.open(url,'popUp',opciones);
					}

				
			}
		}
	
}

function editar(cod_salida,nro_salida,cod_estado_salida,swValFecha,swValIngreso)
{	
		if(cod_estado_salida==2){
			alert("La Salida No."+nro_salida+", no puede ser Editada porque se encuentra Anulada.");	

		}else{
			if(swValFecha==0){
				alert('La Salida No.'+nro_salida+' solo puede  ser editada el dia que se registro.');
				
			}else{
				if(swValIngreso==0){
					alert('La Salida No.'+nro_salida+' no puede ser editada, porque esta genero un Ingreso en otro Almacen.');
					
				}else{
					window.location="editarSalida.php?cod_salida="+cod_salida;
				}
			}		
			
		}
	
}

</script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#F7F5F3">
<form name="form1" method="post"  id="form1">
<?php

	
	require("conexion.inc");
	include("funciones.php");

	$sql2="select nombre_almacen from almacenes where cod_almacen='".$_COOKIE['cod_almacen_global']."'";
	$resp2= mysql_query($sql2);
	$nombre_almacen="";
	while($dat2=mysql_fetch_array($resp2)){
		$nombre_almacen=$dat2[0];
	}	
	


?>
<h3 align="center" style="background:#F7F5F3;font-size: 14px;color: #E78611;font-weight:bold;">SALIDAS DE  <?php echo strtoupper($nombre_almacen);?>
   <a class="btn btn-warning btn-lg float-right text-white boton-filtro-iframe" href="#" data-toggle="modal" data-target="#filtroModal">
       <i class="fa fa-search"></i> BUSCAR REGISTROS
    </a>
</h3>

<div id="resultados">
<?php 


	//Paginador
	
	$fechaNow=date('Y-m-d', time());
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
	


	$sql=" select count(*)";
	$sql.=" from salidas s, gestiones g,  tipos_salida ts, estados_salidas_almacen esa ";
	$sql.=" where s.cod_gestion=g.cod_gestion "; 
	$sql.=" and s.cod_tipo_salida=ts.cod_tipo_salida ";
	$sql.=" and s.cod_estado_salida=esa.cod_estado_salida ";
	$sql.=" and s.cod_almacen=".$_COOKIE['cod_almacen_global'];
	if($_GET['nroSalidaB']<>""){	
		$sql.=" and CONCAT(s.nro_salida,'/',g.gestion) LIKE '%".$_GET['nroSalidaB']."%' ";
	}
	if($_GET['tipoSalidaB']<>""){	
		$sql.=" and ts.nombre_tipo_salida like '%".$_GET['tipoSalidaB']."%'";
	}
	if($_GET['nroHojaRutaB']<>""){	
		$sql.=" and s.cod_hoja_ruta in(select hr.cod_hoja_ruta from hojas_rutas hr, gestiones g ";
		$sql.=" where hr.cod_gestion=g.cod_gestion and CONCAT(hr.nro_hoja_ruta,'/',g.gestion) LIKE '%".$_GET['nroHojaRutaB']."%')";
	}
	if($_GET['nroOrdenTrabajoB']<>""){	
		$sql.=" and s.cod_orden_trabajo in(select ot.cod_orden_trabajo from ordentrabajo ot, gestiones g ";
		$sql.=" where ot.cod_gestion=g.cod_gestion and (CONCAT(ot.nro_orden_trabajo,'/',g.gestion) LIKE '%".$_GET['nroOrdenTrabajoB']."%' or ot.numero_orden_trabajo like '%".$_GET['nroOrdenTrabajoB']."%'))";
	}
	if($_GET['almacenTraspasoB']<>""){	
		$sql.=" and s.cod_almacen_traspaso in(select cod_almacen from almacenes where nombre_almacen like '%".$_GET['almacenTraspasoB']."%')";
	}	
	if($_GET['nombreClienteB']<>""){	
				$sql.=" and (cod_orden_trabajo in(select cod_orden_trabajo from ordentrabajo, clientes";
				$sql.=" where ordentrabajo.cod_cliente=clientes.cod_cliente and clientes.nombre_cliente LIKE '%".$_GET['nombreClienteB']."%')";
				$sql.=" or (cod_hoja_ruta in(select cod_hoja_ruta from hojas_rutas, cotizaciones, clientes ";
				$sql.=" where hojas_rutas.cod_cotizacion=cotizaciones.cod_cotizacion ";
				$sql.=" and  cotizaciones.cod_cliente=clientes.cod_cliente and clientes.nombre_cliente LIKE '%".$_GET['nombreClienteB']."%' ))";
				$sql.=" or(cliente_venta  like '%".$_GET['nombreClienteB']."%' or cod_cliente_venta in (select cod_cliente from clientes where nombre_cliente like '%".$_GET['nombreClienteB']."%')))";

	}		
		
	if($_GET['estadoSalidaB']<>""){	
		$sql.=" and esa.desc_estado_salida  like '%".$_GET['estadoSalidaB']."%'";
	}		

	if($_GET['descCompletaMaterialB']<>""){
		$sql.=" and s.cod_salida in(select cod_salida from salidas_detalle where cod_material in(select cod_material from materiales where desc_completa_material like '%".$_GET['descCompletaMaterialB']."%'))";
	}
	if($codActivoFecha=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);
				
				$sql.=" and s.fecha_salida>='".$aI."-".$mI."-".$dI."' and s.fecha_salida<='".$aF."-".$mF."-".$dF."' ";

		}
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

			$sql=" select s.cod_salida, s.cod_tipo_salida, ts.nombre_tipo_salida, s.nro_salida, s.cod_gestion, ";
			$sql.=" g.gestion, s.cod_almacen, s.fecha_salida, s.cod_usuario_salida, s.obs_salida, s.cod_almacen_traspaso, ";
		$sql.=" s.cod_hoja_ruta, s.cliente_venta, s.cod_estado_salida, esa.desc_estado_salida, s.fecha_modifica, ";
			$sql.=" s.cod_usuario_modifica, s.fecha_anulacion, s.cod_usuario_anulacion, s.obs_anulacion,";
			$sql.=" s.cod_orden_trabajo, s.cod_cliente_venta, s.cod_contacto,";
			$sql.=" s.cod_tipo_pago, s.cod_area, s.cod_usuario, s.cod_estado_pago_doc ";
			$sql.=" from salidas s, gestiones g,  tipos_salida ts, estados_salidas_almacen esa ";
			$sql.=" where s.cod_gestion=g.cod_gestion ";
			$sql.=" and s.cod_tipo_salida=ts.cod_tipo_salida ";
			$sql.=" and s.cod_estado_salida=esa.cod_estado_salida ";
			$sql.=" and s.cod_almacen=".$_COOKIE['cod_almacen_global'];

$sql.=" and s.cod_almacen=".$_COOKIE['cod_almacen_global'];
	if($_GET['nroSalidaB']<>""){	
		$sql.=" and CONCAT(s.nro_salida,'/',g.gestion) LIKE '%".$_GET['nroSalidaB']."%' ";
	}
	if($_GET['tipoSalidaB']<>""){	
		$sql.=" and ts.nombre_tipo_salida like '%".$_GET['tipoSalidaB']."%'";
	}
	if($_GET['nroHojaRutaB']<>""){	
		$sql.=" and s.cod_hoja_ruta in(select hr.cod_hoja_ruta from hojas_rutas hr, gestiones g ";
		$sql.=" where hr.cod_gestion=g.cod_gestion and CONCAT(hr.nro_hoja_ruta,'/',g.gestion) LIKE '%".$_GET['nroHojaRutaB']."%')";
	}
	if($_GET['nroOrdenTrabajoB']<>""){	
		$sql.=" and s.cod_orden_trabajo in(select ot.cod_orden_trabajo from ordentrabajo ot, gestiones g ";
		$sql.=" where ot.cod_gestion=g.cod_gestion and (CONCAT(ot.nro_orden_trabajo,'/',g.gestion) LIKE '%".$_GET['nroOrdenTrabajoB']."%' or ot.numero_orden_trabajo like '%".$_GET['nroOrdenTrabajoB']."%'))";
	}
	if($_GET['almacenTraspasoB']<>""){	
		$sql.=" and s.cod_almacen_traspaso in(select cod_almacen from almacenes where nombre_almacen like '%".$_GET['almacenTraspasoB']."%')";
	}	
	if($_GET['nombreClienteB']<>""){	
				$sql.=" and (cod_orden_trabajo in(select cod_orden_trabajo from ordentrabajo, clientes";
				$sql.=" where ordentrabajo.cod_cliente=clientes.cod_cliente and clientes.nombre_cliente LIKE '%".$_GET['nombreClienteB']."%')";
				$sql.=" or (cod_hoja_ruta in(select cod_hoja_ruta from hojas_rutas, cotizaciones, clientes ";
				$sql.=" where hojas_rutas.cod_cotizacion=cotizaciones.cod_cotizacion ";
				$sql.=" and  cotizaciones.cod_cliente=clientes.cod_cliente and clientes.nombre_cliente LIKE '%".$_GET['nombreClienteB']."%' ))";
				$sql.=" or(cliente_venta  like '%".$_GET['nombreClienteB']."%' or cod_cliente_venta in (select cod_cliente from clientes where nombre_cliente like '%".$_GET['nombreClienteB']."%')))";

	}		
		
	if($_GET['estadoSalidaB']<>""){	
		$sql.=" and esa.desc_estado_salida  like '%".$_GET['estadoSalidaB']."%'";
	}		

	if($_GET['descCompletaMaterialB']<>""){
		$sql.=" and s.cod_salida in(select cod_salida from salidas_detalle where cod_material in(select cod_material from materiales where desc_completa_material like '%".$_GET['descCompletaMaterialB']."%'))";
	}
	if($codActivoFecha=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);
				
				$sql.=" and s.fecha_salida>='".$aI."-".$mI."-".$dI."' and s.fecha_salida<='".$aF."-".$mF."-".$dF."' ";

		}
	}
		$sql.=" order by  s.cod_salida desc ";
		$sql.=" limit 50";
		$resp = mysql_query($sql);
		$cont=0;
?>	
	<table width="95%" align="center" cellpadding="1" id="cotizacion" cellspacing="1" bgColor="#cccccc" class="tablaReporte" style="width:100% !important;">
        <thead>   
	    <tr height="20px" align="center"  class="bg-success text-white">
			<th>Nro Salida</th>
    		<th>Fecha</th>	
            <th>Tipo de Salida</th>
            <th>Monto</th>	
            <th>A cuenta</th>
            <th>Saldo</th>														
    		<th>Observaciones</th>	            
			<th>Estado</th>
            <th>Estado de Pago</th> 
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>       
            
		</tr>
		</thead>
		<tbody>
<?php   
		while($dat=mysql_fetch_array($resp)){
				$cod_salida=$dat['cod_salida']; 
				$cod_tipo_salida=$dat['cod_tipo_salida']; 
				$nombre_tipo_salida=$dat['nombre_tipo_salida']; 
				$nro_salida=$dat['nro_salida']; 
				$cod_gestion=$dat['cod_gestion']; 
				$gestion=$dat['gestion']; 
				$cod_almacen=$dat['cod_almacen']; 
				$fecha_salida=$dat['fecha_salida']; 
				$cod_usuario_salida=$dat['cod_usuario_salida']; 
				$obs_salida=$dat['obs_salida']; 
				$cod_almacen_traspaso=$dat['cod_almacen_traspaso']; 
				$cod_hoja_ruta=$dat['cod_hoja_ruta']; 
				$cliente_venta=$dat['cliente_venta']; 
				$cod_estado_salida=$dat['cod_estado_salida']; 
				$desc_estado_salida=$dat['desc_estado_salida']; 
				$fecha_modifica=$dat['fecha_modifica']; 
				$cod_usuario_modifica=$dat['cod_usuario_modifica']; 
				$fecha_anulacion=$dat['fecha_anulacion']; 
				$cod_usuario_anulacion=$dat['cod_usuario_anulacion']; 
				$obs_anulacion=$dat['obs_anulacion']; 
				$cod_orden_trabajo=$dat['cod_orden_trabajo']; 
				$cod_cliente_venta=$dat['cod_cliente_venta'];
				$cod_contacto=$dat['cod_contacto'];
				$cod_tipo_pago=$dat['cod_tipo_pago'];
				$cod_area=$dat['cod_area'];
				$cod_usuario=$dat['cod_usuario'];
				$cod_estado_pago_doc=$dat['cod_estado_pago_doc'];
				///////////////////////////
				$swValFecha=0;
				$fechaNow=date('Y-m-d', time());

				if($fecha_salida==$fechaNow){
					$swValFecha=1;
				}
				if($cod_tipo_salida==3){
						$swValIngreso=0;
						
						$sql8="select cod_estado_ingreso from ingresos where cod_salida=".$cod_salida;
						$resp8= mysql_query($sql8);			
						while($dat8=mysql_fetch_array($resp8)){
							$cod_estado_ingreso=$dat8[0];
						}						
						if($cod_estado_ingreso==2){
							$swValIngreso=1;
						}
				}else{
					$swValIngreso=1;
				}
				
				////////////////////////////			
				if($cod_tipo_salida==6){
					$nombre_area="";
					$usuario_uso_interno="";
					if($cod_area<>""){
						$sql2="select  nombre_area";
						$sql2.=" from areas ";
						$sql2.=" where cod_area=".$cod_area;		
						$resp2= mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2)){
							$nombre_area=$dat2['nombre_area']; 
						}
					}
					if($cod_usuario<>""){
						$sql2="select nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
						$sql2.=" from usuarios ";
						$sql2.=" where cod_usuario=".$cod_usuario;		
						$resp2= mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2)){
							$usuario_uso_interno=$dat2['ap_paterno_usuario']." ".$dat2['nombres_usuario']; 

						}
					}					

						
				}			
			
		
								
		?> 
		<tr bgcolor="#FFFFFF" valign="middle" >	
    		<td align="left"><?php echo $nro_salida."/".$gestion; ?></td>	
			<td align="left">
			<?php 
				echo strftime("%d/%m/%Y",strtotime($fecha_salida));

            		$sql2="select u.nombres_usuario, u.ap_paterno_usuario, u.ap_materno_usuario ";
					$sql2.=" from usuarios u ";
					$sql2.=" where u.cod_usuario=".$cod_usuario_salida;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){				
						$nombres_usuario=$dat2['nombres_usuario'];
						$ap_paterno_usuario=$dat2['ap_paterno_usuario'];
						$ap_materno_usuario=$dat2['ap_materno_usuario'];
					}	
					echo " (".$nombres_usuario[0].$ap_paterno_usuario[0].$ap_materno_usuario[0].")";	
			
			?></td>	
			<td align="left"><strong><?php echo $nombre_tipo_salida; ?></strong><br>
			<?php
            if($cod_almacen_traspaso<>""){
				$sqlAux="select nombre_almacen from almacenes where cod_almacen=".$cod_almacen_traspaso;
				$respAux = mysql_query($sqlAux);
					while($datAux=mysql_fetch_array($respAux)){	
						echo $datAux['nombre_almacen'];
					}				
			}
            if($cod_hoja_ruta<>""){
				$sqlAux=" select hr.nro_hoja_ruta,g.gestion, cli.nombre_cliente ";
				$sqlAux.=" from hojas_rutas hr, gestiones g, cotizaciones c, clientes cli";
				$sqlAux.=" where hr.cod_gestion=g.cod_gestion ";
				$sqlAux.=" and hr.cod_cotizacion=c.cod_cotizacion ";
				$sqlAux.=" and c.cod_cliente=cli.cod_cliente";
				$sqlAux.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
				$respAux = mysql_query($sqlAux);
					while($datAux=mysql_fetch_array($respAux)){	
			?>
            	<a href="../reportes/impresionHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta;?>" target="_blank"><?php echo $datAux['nro_hoja_ruta']."/".$datAux['gestion'];?></a><br/><?php echo $datAux['nombre_cliente'];?>
            <?php
						
					}	
		
			}			
			

				if($cod_tipo_salida==1){
						if($cod_tipo_pago<>""){
							$sqlAux="select nombre_tipo_pago from tipos_pago where cod_tipo_pago=".$cod_tipo_pago;
							$respAux = mysql_query($sqlAux);
							while($datAux=mysql_fetch_array($respAux)){	
								$nombre_tipo_pago=$datAux['nombre_tipo_pago'];
							}
						}		
						echo $nombre_tipo_pago."<br/>";			
						
						$nombre_cliente_venta="";
						$nombre_contacto="";
						$ap_paterno_contacto="";
						$nombre_tipo_pago="";
						
						if($cod_cliente_venta<>""){
							$sqlAux="select nombre_cliente from clientes where cod_cliente=".$cod_cliente_venta;
							$respAux = mysql_query($sqlAux);
							while($datAux=mysql_fetch_array($respAux)){	
								$nombre_cliente_venta=$datAux['nombre_cliente'];
							}	
							if($cod_contacto<>""){
								$sqlAux=" select nombre_contacto, ap_paterno_contacto from clientes_contactos ";
								$sqlAux.=" where cod_contacto=".$cod_contacto;
								$respAux = mysql_query($sqlAux);
								while($datAux=mysql_fetch_array($respAux)){	
									$nombre_contacto=$datAux['nombre_contacto'];
									$ap_paterno_contacto=$datAux['ap_paterno_contacto'];
								}
							}
						}
						
						if($nombre_cliente_venta<>""){
							if($nombre_contacto<>""){
								echo "Cliente:".$nombre_cliente_venta."<br/>";
							}else{
								echo "Cliente:".$nombre_cliente_venta."(Contacto:".$nombre_contacto." ".$ap_paterno_contacto.")<br/>";							
							}
						}
						if($cliente_venta<>""){
							echo "**".$cliente_venta."**";
						
						}

						
						
						
				}
			
			if($cod_orden_trabajo<>""){
				$sqlAux=" select ot.nro_orden_trabajo, g.gestion, ot.numero_orden_trabajo, cli.nombre_cliente ";
				$sqlAux.=" from ordentrabajo ot, gestiones g, clientes cli";
				$sqlAux.=" where ot.cod_gestion=g.cod_gestion ";
				$sqlAux.=" and ot.cod_cliente=cli.cod_cliente ";
				$sqlAux.=" and ot.cod_orden_trabajo=".$cod_orden_trabajo;
				$respAux = mysql_query($sqlAux);
					while($datAux=mysql_fetch_array($respAux)){	
			?>
				<a href="../reportes/impresionOrdenTrabajo.php?cod_orden_trabajo=<?php echo $cod_orden_trabajo;?>" target="_blank"><?php echo $datAux['nro_orden_trabajo']."/".$datAux['gestion']." (".$datAux['numero_orden_trabajo'].")";?></a><br/><?php echo $datAux['nombre_cliente']?>
			<?php
					}	
			}
			if($cod_tipo_salida==6){
				echo $nombre_area."(Solicitante:".$usuario_uso_interno.")";
			}
			
			?>      
                  
            </td>	
			<td align="left">
            <?php
            	if($cod_tipo_salida==1){
	 				$monto_venta=0;
			 		$sqlAux=" select sum(sd.precio_venta*sd.cant_salida) ";
					$sqlAux.=" from salidas_detalle sd ";
					$sqlAux.=" where sd.cod_salida=".$cod_salida;
					$respAux = mysql_query($sqlAux);
					while($datAux=mysql_fetch_array($respAux)){
						$monto_venta=$datAux[0];
					}	
					echo $monto_venta;		
				}
			?>
            </td> 
			<td align="left">
<?php 
		if($cod_tipo_salida==1){
			 	$sqlAux=" select  pd.monto_pago_detalle, p.fecha_pago ";
			 	$sqlAux.=" from pagos_detalle pd, pagos p";
			 	$sqlAux.=" where pd.cod_pago=p.cod_pago";
			 	$sqlAux.=" and p.cod_estado_pago<>2";
			 	$sqlAux.=" and pd.codigo_doc=".$cod_salida;
				$sqlAux.=" and pd.cod_tipo_doc=3";
				$respAux = mysql_query($sqlAux);
				$acuenta_venta=0;
				while($datAux=mysql_fetch_array($respAux)){

					$monto_pago_detalle=$datAux['monto_pago_detalle'];
					$fecha_pago=$datAux['fecha_pago'];
					$fecha_pago=strftime("%Y-%m-%d",strtotime($fecha_pago));

						$acuenta_venta=$acuenta_venta+$monto_pago_detalle;
					
				}				
			 echo $acuenta_venta;
		}
			 ?>
            </td> 
             <td align="left">&nbsp; <?php 
			 if($cod_tipo_salida==1){
				 echo($monto_venta-$acuenta_venta);
			 }
			 ?></td>                     										
			<td align="left">&nbsp; <?php echo $obs_salida ;?></td>
            <td align="left">&nbsp;<?php echo $desc_estado_salida ;?></td>
                       <td align="left" <?php if(($monto_venta-$acuenta_venta)>0 and $cod_tipo_salida==1 and $cod_estado_pago_doc==3){?>  bgcolor="#FF3333"=""<?php }?>>
            <?php
            if($cod_tipo_salida==1){
				 
		 			$sqlAux=" select desc_estado_pago_doc ";
					$sqlAux.=" from estado_pago_documento ";
					$sqlAux.=" where cod_estado_pago_doc=".$cod_estado_pago_doc;
					$respAux = mysql_query($sqlAux);
					while($datAux=mysql_fetch_array($respAux)){
							$desc_estado_pago_doc=$datAux['desc_estado_pago_doc'];
					}
					echo $desc_estado_pago_doc;
			 }
			
			?>
            </td>
			<td> <a href="detalleSalida.php?cod_salida=<?php echo $cod_salida; ?>" target="_blank"><img src="icons/page8.gif"  title="Detalle de Salida" height="15" width="15" align="middle">  </a><br/><br/>
			<center><a href="../reportes/docSalida.php?cod_salida=<?php echo $cod_salida; ?>" target="_blank">
			<img src="img/imprimir.jpg"  height="20" width="20" align="middle" title="Detalle para Impresion"> </a></center>
			</td>																	
<td> <a href="javascript:editar(<?php echo $cod_salida; ?>,'<?php echo $nro_salida."/".$gestion; ?>',<?php echo $cod_estado_salida; ?>,<?php echo $swValFecha;?>,<?php echo $swValIngreso; ?>)">Editar </a><br/><a href="editarSalida.php?cod_salida=<?php echo $cod_salida; ?>" >Prueba</a>
</td>
										
			<td><a href="javascript:anular(<?php echo $cod_salida; ?>,'<?php echo $nro_salida."/".$gestion; ?>',<?php echo $cod_estado_salida; ?>,<?php echo $swValIngreso; ?>)">Anular</a></td>
							
							            
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
<tr>
<td><strong>Nro de Salida</strong></td>
<td ><input type="text" name="nroSalidaB" id="nroSalidaB" size="10" class="textoform" onkeyup="buscar()"  ></td>
<td><strong>Tipo de Salida</strong></td>
<td><input type="text" name="tipoSalidaB" id="tipoSalidaB" size="30" class="textoform" onkeyup="buscar()" ></td>
</tr>
<tr>
<td><strong>Nro Hoja de Ruta</strong></td>
<td><input type="text" name="nroHojaRutaB" id="nroHojaRutaB" size="30" class="textoform" onkeyup="buscar()" ></td>
<td><strong>Orden de Trabajo</strong></td>
<td><input type="text" name="nroOrdenTrabajoB" id="nroOrdenTrabajoB" size="30"  class="textoform" onkeyup="buscar()" ></td>
</tr>
<tr>
<td><strong>Almacen de Traspaso</strong></td>
<td><input type="text" name="almacenTraspasoB" id="almacenTraspasoB" size="30"  class="textoform" onkeyup="buscar()" ></td>
<td><strong>Cliente</strong></td>
<td><input type="text" name="nombreClienteB" id="nombreClienteB" size="30" class="textoform" onkeyup="buscar()" ></td>
</tr>
<tr>
<td><strong>Estado de Salida</strong></td>
<td ><input type="text" name="estadoSalidaB" id="estadoSalidaB" size="30"  class="textoform" onkeyup="buscar()" ></td>
<td><strong>Material</strong></td>
<td><input type="text" name="descCompletaMaterialB" id="descCompletaMaterialB" size="50"  class="textoform" onkeyup="buscar()" ></td>
</tr>
<tr >
     		<td>&nbsp;<b>Rango de Fecha<br/>(dd/mm/aaaa)</b>&nbsp;</td>			
     		<td colspan="3"><strong>De&nbsp;</strong>
                <input type="text" name="fechaInicioB" id="fechaInicioB" class="textoform">
        <strong>&nbsp;Hasta&nbsp;</strong><input type="text" name="fechaFinalB" id="fechaFinalB" class="textoform"><input type="checkbox" name="codActivoFecha" id="codActivoFecha"  onClick="buscar()"><strong>(Chekear para buscar por fechas)</strong>
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

