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
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
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
		var param="?";
		param+='nroIngresoB='+document.form1.nroIngresoB.value;
		param+='&nombreProveedorB='+document.form1.nombreProveedorB.value;
		param+='&almacenSalidaB='+document.form1.almacenSalidaB.value;
		param+='&nrofacturaB='+document.form1.nrofacturaB.value;
		param+='&descCompletaMaterialB='+document.form1.descCompletaMaterialB.value;
		param+='&cod_tipo_pagoB='+document.form1.cod_tipo_pagoB.value;
		param+='&cod_estado_pago_docB='+document.form1.cod_estado_pago_docB.value;
		param+='&cod_tipo_ingresoB='+document.form1.cod_tipo_ingresoB.value;
		param+='&cod_estado_ingresoB='+document.form1.cod_estado_ingresoB.value;
		param+='&codActivoFecha='+valorchecked;
		param+='&fechaInicioB='+document.form1.fechaInicioB.value;
		param+='&fechaFinalB='+document.form1.fechaFinalB.value;
		resultados_ajax('searchIngresos.php'+param);

}



function paginar(f)
{	
if(document.form1.codActivoFecha.checked){
		valorchecked="on";
	}else{
		valorchecked="off";
	}
		var param="?";
		param+='nroIngresoB='+document.form1.nroIngresoB.value;
		param+='&nombreProveedorB='+document.form1.nombreProveedorB.value;
		param+='&almacenSalidaB='+document.form1.almacenSalidaB.value;
		param+='&nrofacturaB='+document.form1.nrofacturaB.value;
		param+='&descCompletaMaterialB='+document.form1.descCompletaMaterialB.value;
		param+='&cod_tipo_pagoB='+document.form1.cod_tipo_pagoB.value;
		param+='&cod_estado_pago_docB='+document.form1.cod_estado_pago_docB.value;
		param+='&cod_tipo_ingresoB='+document.form1.cod_tipo_ingresoB.value;
		param+='&cod_estado_ingresoB='+document.form1.cod_estado_ingresoB.value;
		param+='&codActivoFecha='+valorchecked;
		param+='&fechaInicioB='+document.form1.fechaInicioB.value;
		param+='&fechaFinalB='+document.form1.fechaFinalB.value;
		param+='&pagina='+document.form1.pagina.value		
		resultados_ajax('searchIngresos.php'+param);

}
function paginar1(f,pagina)
{		
f.pagina.value=pagina*1;
		var param="?";
		param+='nroIngresoB='+document.form1.nroIngresoB.value;
		param+='&nombreProveedorB='+document.form1.nombreProveedorB.value;
		param+='&almacenSalidaB='+document.form1.almacenSalidaB.value;
		param+='&nrofacturaB='+document.form1.nrofacturaB.value;
		param+='&descCompletaMaterialB='+document.form1.descCompletaMaterialB.value;
		param+='&cod_tipo_pagoB='+document.form1.cod_tipo_pagoB.value;
		param+='&cod_estado_pago_docB='+document.form1.cod_estado_pago_docB.value;
		param+='&cod_tipo_ingresoB='+document.form1.cod_tipo_ingresoB.value;
		param+='&cod_estado_ingresoB='+document.form1.cod_estado_ingresoB.value;
		param+='&codActivoFecha='+valorchecked;
		param+='&fechaInicioB='+document.form1.fechaInicioB.value;
		param+='&fechaFinalB='+document.form1.fechaFinalB.value;
		param+='&pagina='+document.form1.pagina.value		
		resultados_ajax('searchIngresos.php'+param);

}

function anular(cod_ingreso,nro_ingreso,swValIngreso,cod_estado_ingreso)
{	//alert ('variable'+swValIngreso);
			if(cod_estado_ingreso==2){
				alert('El Ingreso No.'+nro_ingreso+' ya se encuentra anulado.');
			}else{
				
				if(swValIngreso==0){
					alert('El Ingreso No.'+nro_ingreso+' no se puede Anular, porque se hicieron salidas del mismo.');
					
				}else{
					msj=confirm('Esta seguro de Anular el Ingreso No.'+nro_ingreso);
					if(msj==true)
					{
						izquierda=(screen.width)?(screen.width-300)/2:100
						arriba=(screen.height)?(screen.height-400)/2:100
						url="anularIngreso.php?cod_ingreso="+cod_ingreso;
						opciones=" toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=1,resizable=0, width=500, height=280, left="+izquierda+" top="+arriba;
	
						window.open(url,'popUp',opciones)
					}

				}
			}
	
}

function editar(cod_ingreso,nro_ingreso, swValFecha,swValIngreso,cod_estado_ingreso)
{	
		if(cod_estado_ingreso==2){
			alert('No se puede editar un Ingreso Anulado.');	

		}else{
			if(swValFecha==0){
				alert('El Ingreso No.'+nro_ingreso+' solo puede  ser editado los proximos 7 dias de su registro.');
				
			}else{
			
				if(swValIngreso==0){
				//alert("cod_ingreso"+cod_ingreso);
					window.location="editarIngresoCabecera.php?cod_ingreso="+cod_ingreso;					
				}else{			
					window.location="editarIngreso.php?cod_ingreso="+cod_ingreso;
				}
			}		
			
		}
	
}

</script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF">
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
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">INGRESOS <?php echo strtoupper($nombre_almacen);?>
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
	$sql.=" from ingresos i";
	$sql.=" left join gestiones g on(i.cod_gestion=g.cod_gestion)";
	$sql.=" left join almacenes a on (i.cod_almacen=a.cod_almacen)";
	$sql.=" left join tipos_ingreso ti on (i.cod_tipo_ingreso=ti.cod_tipo_ingreso)";
	$sql.=" left join proveedores p on (i.cod_proveedor=p.cod_proveedor)";
	$sql.=" left join proveedores_contactos pc on (i.cod_proveedor=p.cod_proveedor and i.cod_contacto_proveedor=pc.cod_contacto_proveedor)";
	$sql.=" left join salidas s on (i.cod_salida=s.cod_salida)";
	$sql.=" left join almacenes sa on (s.cod_almacen=sa.cod_almacen)";
	$sql.=" left join estados_ingresos_almacen ei on (i.cod_estado_ingreso=ei.cod_estado_ingreso)";
	$sql.=" left join tipos_pago tp on (i.cod_tipo_pago=tp.cod_tipo_pago)";
	$sql.=" left join estado_pago_documento epd on (i.cod_estado_pago_doc=epd.cod_estado_pago_doc)";
	$sql.=" where i.cod_ingreso<>0  ";
	$sql.=" and i.cod_almacen=".$_COOKIE['cod_almacen_global'];
	if($_GET['nroIngresoB']<>""){	
		$sql.=" and CONCAT(i.nro_ingreso,'/',g.gestion_nombre) LIKE '%".$_GET['nroIngresoB']."%' ";
	}
	if($_GET['nombreProveedorB']<>""){	
		$sql.=" and p.nombre_proveedor like '%".$_GET['nombreProveedorB']."%'";
	}	
	if($_GET['almacenSalidaB']<>""){	
		$sql.=" where nombre_almacen_salida  like '%".$_GET['almacenSalidaB']."%'";
	}	
	if($_GET['nrofacturaB']<>""){	
		$sql.=" and i.nro_factura  like '%".$_GET['nrofacturaB']."%'";
	}
	if($_GET['cod_tipo_ingresoB']<>0){	
		$sql.=" and i.cod_tipo_ingreso='".$_GET['cod_tipo_ingresoB']."%'";
	}	
	if($_GET['cod_estado_ingresoB']<>0){	
		$sql.=" and i.cod_estado_ingreso='".$_GET['cod_estado_ingresoB']."'";
	}
	if($_GET['cod_tipo_pagoB']<>0){	
		$sql.=" and i.cod_tipo_pago='".$_GET['cod_tipo_pagoB']."'";
	}	
	if($_GET['cod_estado_pago_docB']<>0){	
		$sql.=" and i.cod_estado_pago_doc='".$_GET['cod_estado_pago_docB']."'";
	}					
	if($_GET['descCompletaMaterialB']<>""){
		$sql.=" and i.cod_ingreso in(select cod_ingreso from ingresos_detalle where cod_material in(select cod_material from materiales where desc_completa_material like '%".$_GET['descCompletaMaterialB']."%'))";
	}
	if($codActivoFecha=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);
				
				$sql.=" and i.fecha_ingreso>='".$aI."-".$mI."-".$dI."' and i.fecha_ingreso<='".$aF."-".$mF."-".$dF."' ";

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
	$sql=" select i.cod_ingreso,i.cod_gestion, g.gestion, g.gestion_nombre, i.cod_almacen, a.nombre_almacen, ";
	$sql.=" i.nro_ingreso, i.cod_tipo_ingreso, ti.nombre_tipo_ingreso, i.fecha_ingreso, i.cod_usuario_ingreso, ";
	$sql.=" i.cod_proveedor,p.nombre_proveedor, i.cod_contacto_proveedor, pc.nombre_contacto, pc.ap_paterno_contacto, pc.ap_materno_contacto,";
	$sql.=" i.cod_salida, s.nro_salida,s.cod_almacen as cod_almacen_salida,sa.nombre_almacen as nombre_almacen_salida,s.fecha_salida,";
	$sql.=" i.nro_factura, i.fecha_factura, i.obs_ingreso,i.cod_estado_ingreso, ei.desc_estado_ingreso,";
	$sql.=" i.total_bs, i.cod_tipo_pago, tp.nombre_tipo_pago, i.cod_estado_pago_doc, epd.desc_estado_pago_doc, ";
	$sql.=" i.dias_plazo_pago, i.fecha_modifica, i.cod_usuario_modifica, i.obs_anular";
	$sql.=" from ingresos i";
	$sql.=" left join gestiones g on(i.cod_gestion=g.cod_gestion)";
	$sql.=" left join almacenes a on (i.cod_almacen=a.cod_almacen)";
	$sql.=" left join tipos_ingreso ti on (i.cod_tipo_ingreso=ti.cod_tipo_ingreso)";
	$sql.=" left join proveedores p on (i.cod_proveedor=p.cod_proveedor)";
	$sql.=" left join proveedores_contactos pc on (i.cod_proveedor=p.cod_proveedor and i.cod_contacto_proveedor=pc.cod_contacto_proveedor)";
	$sql.=" left join salidas s on (i.cod_salida=s.cod_salida)";
	$sql.=" left join almacenes sa on (s.cod_almacen=sa.cod_almacen)";
	$sql.=" left join estados_ingresos_almacen ei on (i.cod_estado_ingreso=ei.cod_estado_ingreso)";
	$sql.=" left join tipos_pago tp on (i.cod_tipo_pago=tp.cod_tipo_pago)";
	$sql.=" left join estado_pago_documento epd on (i.cod_estado_pago_doc=epd.cod_estado_pago_doc)";
	$sql.=" where i.cod_ingreso<>0  ";
	$sql.=" and i.cod_almacen=".$_COOKIE['cod_almacen_global'];
	if($_GET['nroIngresoB']<>""){	
		$sql.=" and CONCAT(i.nro_ingreso,'/',g.gestion_nombre) LIKE '%".$_GET['nroIngresoB']."%' ";
	}
	if($_GET['nombreProveedorB']<>""){	
		$sql.=" and p.nombre_proveedor like '%".$_GET['nombreProveedorB']."%'";
	}	
	if($_GET['almacenSalidaB']<>""){	
		$sql.=" where nombre_almacen_salida  like '%".$_GET['almacenSalidaB']."%'";
	}	
	if($_GET['nrofacturaB']<>""){	
		$sql.=" and i.nro_factura  like '%".$_GET['nrofacturaB']."%'";
	}
	if($_GET['cod_tipo_ingresoB']<>0){	
		$sql.=" and i.cod_tipo_ingreso='".$_GET['cod_tipo_ingresoB']."%'";
	}	
	if($_GET['cod_estado_ingresoB']<>0){	
		$sql.=" and i.cod_estado_ingreso='".$_GET['cod_estado_ingresoB']."'";
	}
	if($_GET['cod_tipo_pagoB']<>0){	
		$sql.=" and i.cod_tipo_pago='".$_GET['cod_tipo_pagoB']."'";
	}	
	if($_GET['cod_estado_pago_docB']<>0){	
		$sql.=" and i.cod_estado_pago_doc='".$_GET['cod_estado_pago_docB']."'";
	}					
	if($_GET['descCompletaMaterialB']<>""){
		$sql.=" and i.cod_ingreso in(select cod_ingreso from ingresos_detalle where cod_material in(select cod_material from materiales where desc_completa_material like '%".$_GET['descCompletaMaterialB']."%'))";
	}
	if($codActivoFecha=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);
				
				$sql.=" and i.fecha_ingreso>='".$aI."-".$mI."-".$dI."' and i.fecha_ingreso<='".$aF."-".$mF."-".$dF."' ";

		}
	}


	$sql.=" order by  i.cod_ingreso desc";
	$sql.=" limit 50";
	$resp = mysql_query($sql);
	$cont=0;
?>
<table width="95%" align="center" cellpadding="1" id="cotizacion" cellspacing="1" bgcolor="#cccccc" class="tablaReporte" style="width:100% !important;">
  <thead>
  <tr height="20px" align="center"  class="bg-success text-white">
    <th>Nro Ingreso</th>
    <th>Fecha</th>
    <th>Tipo de Ingreso</th>
    <th>Proveedor</th>
    <th>Almacen de Traspaso</th>
    <th>Factura</th>
    <th>Plazo Pago </th>
    <th>Monto Total</th>	
    <th>A Cuenta</th>
	<th>Saldo</th>
    <th>Estado Pago</th>
    <th>Tipo Pago</th>
    <th>Observaciones</th>
    <th>Estado</th>
    <th>Ultima  Edicion</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
 </thead> 
 <tbody>
  <?php   
		while($dat=mysql_fetch_array($resp)){
				
			$cod_ingreso=$dat['cod_ingreso'];
			$cod_gestion=$dat['cod_gestion'];
			$gestion=$dat['gestion'];
			$gestion_nombre=$dat['gestion_nombre'];
			$cod_almacen=$dat['cod_almacen'];
			$nombre_almacen=$dat['nombre_almacen'];
			$nro_ingreso=$dat['nro_ingreso'];
			$cod_tipo_ingreso=$dat['cod_tipo_ingreso'];
			$nombre_tipo_ingreso=$dat['nombre_tipo_ingreso'];
			$fecha_ingreso=$dat['fecha_ingreso'];
			$cod_usuario_ingreso=$dat['cod_usuario_ingreso'];
			$cod_proveedor=$dat['cod_proveedor'];
			$nombre_proveedor=$dat['nombre_proveedor'];
			$cod_contacto_proveedor=$dat['cod_contacto_proveedor'];
			$nombre_contacto=$dat['nombre_contacto'];
			$ap_paterno_contacto=$dat['ap_paterno_contacto'];
			$ap_materno_contacto=$dat['ap_materno_contacto'];
			$cod_salida=$dat['cod_salida'];
			$nro_salida=$dat['nro_salida'];
			$cod_almacen_salida=$dat['cod_almacen_salida'];
			$nombre_almacen_salida=$dat['nombre_almacen_salida'];
			$fecha_salida=$dat['fecha_salida'];
			$nro_factura=$dat['nro_factura'];
			$fecha_factura=$dat['fecha_factura'];
			$obs_ingreso=$dat['obs_ingreso'];
			$cod_estado_ingreso=$dat['cod_estado_ingreso'];
			$desc_estado_ingreso=$dat['desc_estado_ingreso'];
			$total_bs=$dat['total_bs'];
			$cod_tipo_pago=$dat['cod_tipo_pago'];
			$nombre_tipo_pago=$dat['nombre_tipo_pago'];
			$cod_estado_pago_doc=$dat['cod_estado_pago_doc'];
			$desc_estado_pago_doc=$dat['desc_estado_pago_doc'];
			$dias_plazo_pago=$dat['dias_plazo_pago'];
		    $fecha_modifica=$dat['fecha_modifica'];
			$cod_usuario_modifica=$dat['cod_usuario_modifica'];
			$obs_anular=$dat['obs_anular'];
			$datosEdicion=""; 
			if($cod_usuario_modifica!="" || $cod_usuario_modifica!=NULL){
				$datosEdicion=strftime("%d/%m/%Y",strtotime($fecha_modifica));
				$sqlAux="select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios where cod_usuario=".$cod_usuario_modifica;
				$respAux = mysql_query($sqlAux);
				while($datAux=mysql_fetch_array($respAux)){
					$datosEdicion=$datosEdicion." ".$datAux['nombres_usuario']." ".$datAux['ap_paterno_usuario'];

				}
			}

		
								
		?>
  <tr bgcolor="#FFFFFF" valign="middle" >
    <td align="right"><?php echo $nro_ingreso."/".$gestion_nombre; ?></td>
    <td align="right"><?php 
				echo strftime("%d/%m/%Y",strtotime($fecha_ingreso));

            		$sql2="select u.nombres_usuario, u.ap_paterno_usuario, u.ap_materno_usuario ";
					$sql2.=" from usuarios u ";
					$sql2.=" where u.cod_usuario=".$cod_usuario_ingreso;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){				
						$nombres_usuario=$dat2['nombres_usuario'];
						$ap_paterno_usuario=$dat2['ap_paterno_usuario'];
						$ap_materno_usuario=$dat2['ap_materno_usuario'];
					}	
					echo " (".$nombres_usuario[0].$ap_paterno_usuario[0].$ap_materno_usuario[0].")";	
			
			?></td>
    <td align="left"><?php echo $nombre_tipo_ingreso; ?></td>
    <td align="left">&nbsp; <?php echo $nombre_proveedor;		
					if($nombre_contacto<>""){
					echo "<br/>(".$nombre_contacto." ".$ap_paterno_contacto.")";		
					}
 				
				?> </td>
    <td align="left">&nbsp;
        <?php 
				if($cod_salida<>""){					
					echo $nombre_almacen_salida." (".$nro_salida."-".strftime("%d/%m/%Y",strtotime($fecha_salida)).")";		
				} 
			?></td>
    <td><?php echo $nro_factura ;?><br/><?php if($fecha_factura!=NULL && $fecha_factura!="" ){echo strftime("%d/%m/%Y",strtotime($fecha_factura));}?></td>
    <td><?php echo $dias_plazo_pago ;?></td>
	<td><?php echo $total_bs ;?></td>
	<td><?php 
		$sql2=" select  count(*),sum(ppd.monto_pago_prov_detalle) ";
		$sql2.=" from pago_proveedor_detalle ppd ";
		$sql2.=" inner join  pago_proveedor pp on(ppd.cod_pago_prov=pp.cod_pago_prov and pp.cod_estado_pago_prov<>2) ";
		$sql2.=" and ppd.codigo_doc=".$cod_ingreso;
		$sql2.=" and ppd.cod_tipo_doc=4 ";
		$resp2 = mysql_query($sql2);
		$acuenta_pago_prov=0;
		while($dat2=mysql_fetch_array($resp2)){					
			$num_pago_prov=$dat2[0];
			if($num_pago_prov>0){
				$acuenta_pago_prov=$dat2[1];									
			}
		}	
				
	
	echo $acuenta_pago_prov; ;?></td>
	<td><?php echo ($total_bs-$acuenta_pago_prov) ;?></td>
    <td align="left"><?php echo $desc_estado_pago_doc ;?></td>
    <td align="left"><?php echo $nombre_tipo_pago ;?></td>
    <td align="left"><?php echo $obs_ingreso ;?></td>
    <td align="left"><?php echo $desc_estado_ingreso ;?></td>
    <td align="left"><?php echo $datosEdicion;?></td>
    <td><a href="detalleIngreso.php?cod_ingreso=<?php echo $cod_ingreso; ?>" target="_blank">View </a></td>
    <td><?php
				$swValFecha=0;	
				if(suma_fechas($fecha_ingreso,7)>$fechaNow){
					$swValFecha=1;
				}				
				$sql3=" select count(*) ";
$sql3.=" from (select sdi.* from salidas s inner join salidas_detalle_ingresos sdi on(s.cod_salida=sdi.cod_salida and  s.cod_estado_salida=1 ) ) sdi2 ";
				$sql3.=" where sdi2.cod_ingreso_detalle in( ";
				$sql3.=" select cod_ingreso_detalle ";
				$sql3.=" from ingresos_detalle ";
				$sql3.=" where cod_ingreso='".$cod_ingreso."'";
				$sql3.=" )";
				$resp3= mysql_query($sql3);	
				$numSalidas=0;		
				while($dat3=mysql_fetch_array($resp3)){
					$numSalidas=$dat3[0];
				}				
				$swValIngreso=0;
				if($numSalidas==0){
					$swValIngreso=1;
				}
			?>
      <a href="javascript:editar(<?php echo $cod_ingreso; ?>,'<?php echo $nro_ingreso."/".$gestion_nombre; ?>',<?php echo $swValFecha; ?>,<?php echo $swValIngreso; ?>,<?php echo $cod_estado_ingreso; ?>)"> Editar </a> </td>
    <td><a href="javascript:anular(<?php echo $cod_ingreso; ?>,'<?php echo $nro_ingreso."/".$gestion_nombre; ?>',<?php echo $swValIngreso; ?>,<?php echo $cod_estado_ingreso; ?>)">Anular</a> </td>
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
<td><strong>Nro de Ingreso</strong></td>
<td colspan="3"><input type="text" name="nroIngresoB" id="nroIngresoB" size="10" class="textoform" onkeyup="buscar()" ></td>
</tr>
<tr>
<td><strong>Proveedor</strong></td>
<td>
 <input name="nombreProveedorB" id="nombreProveedorB" size="30" class="textoform"  onkeyup="buscar()">
	</td>
<td><strong>Almacen de Salida</strong></td>
<td><input type="text" name="almacenSalidaB" id="almacenSalidaB" size="30" class="textoform" onkeyup="buscar()" ></td>
</tr>

<tr>
<td><strong>Factura</strong></td>
<td><input type="text" name="nrofacturaB" id="nrofacturaB" size="30" class="textoform" onkeyup="buscar()" ></td>
</tr>
<tr>
<td><strong>Material</strong></td>
<td colspan="4"><input type="text" name="descCompletaMaterialB" id="descCompletaMaterialB" size="70" class="textoform" onkeyup="buscar()" ></td>
</tr>
<tr>
<td><strong>Tipo de Pago </strong></td>
<td><select name="cod_tipo_pagoB" id="cod_tipo_pagoB" class="textoform" onchange="buscar()"  >
<option value="0">Elija un Opci&oacute;n</option>
				<?php
					$sql4="select cod_tipo_pago,nombre_tipo_pago from tipos_pago";
					$resp4=mysql_query($sql4);
						while($dat4=mysql_fetch_array($resp4))
						{
							$cod_tipo_pago=$dat4[0];	
			  		 		$nombre_tipo_pago=$dat4[1];	
				 ?><option value="<?php echo $cod_tipo_pago;?>" <?php if($_GET['cod_tipo_pagoB']==$cod_tipo_pago){?>selected<?php }?>><?php echo $nombre_tipo_pago;?></option>				
				<?php		
					}
				?>						
			</select>
</td>
<td><strong>Estado de Pago </strong></td>
<td><select name="cod_estado_pago_docB" id="cod_estado_pago_docB" onchange="buscar();" class="textoform">
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
                 <option value="<?php echo $cod_estado_pago_doc;?>" <?php if($_GET['cod_estado_pago_docB']==$cod_estado_pago_doc){?> selected="selected" <?php } ?>><?php echo utf8_decode($desc_estado_pago_doc);?></option>				
				<?php		
					}
				?>						
			</select></td>
</tr>
<tr>
<td><strong>Tipo de Ingreso</strong></td>
<td><select name="cod_tipo_ingresoB" id="cod_tipo_ingresoB" class="textoform" onchange="buscar()"  >
<option value="0">Elija un Opci&oacute;n</option>
				<?php
					$sql4="select cod_tipo_ingreso,nombre_tipo_ingreso from tipos_ingreso";
					$resp4=mysql_query($sql4);
						while($dat4=mysql_fetch_array($resp4))
						{
							$cod_tipo_ingreso=$dat4['cod_tipo_ingreso'];	
			  		 		$nombre_tipo_ingreso=$dat4['nombre_tipo_ingreso'];	
				 ?><option value="<?php echo $cod_tipo_ingreso;?>" <?php if($_GET['cod_tipo_ingresoB']==$cod_tipo_ingreso){?>selected<?php }?>><?php echo $nombre_tipo_ingreso;?></option>				
				<?php		
					}
				?>						
			</select>
			</td>
<td><strong>Estado de Ingreso</strong></td>
<td><select name="cod_estado_ingresoB" id="cod_estado_ingresoB" class="textoform" onchange="buscar()"  >
<option value="0">Elija un Opci&oacute;n</option>
				<?php
					$sql4="select cod_estado_ingreso, desc_estado_ingreso from estados_ingresos_almacen";
					$resp4=mysql_query($sql4);
						while($dat4=mysql_fetch_array($resp4))
						{
							$cod_estado_ingreso=$dat4['cod_estado_ingreso'];	
			  		 		$desc_estado_ingreso=$dat4['desc_estado_ingreso'];	
				 ?><option value="<?php echo $cod_estado_ingreso;?>" <?php if($_GET['cod_estado_ingresoB']==$cod_estado_ingreso){?>selected<?php }?>><?php echo $desc_estado_ingreso;?></option>				
				<?php		
					}
				?>						
			</select></td>
</tr>


<tr >
     		<td>&nbsp;<b>Rango de Fecha<br/>(dd//mm/aaaa)</b>&nbsp;</td>			
     		<td colspan="3"><strong>De&nbsp;</strong>
                <input type="text" name="fechaInicioB" id="fechaInicioB" class="textoform" >
       <strong>&nbsp;Hasta&nbsp;</strong>
        <input type="text" name="fechaFinalB" id="fechaFinalB" class="textoform"  >
<input type="checkbox" name="codActivoFecha" id="codActivoFecha"  onClick="buscar()" ><strong>(Chekear para buscar por fechas)</strong>
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

