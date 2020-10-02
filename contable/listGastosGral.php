<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml version="1.0" encoding="ISO-8859-1">
<head>
<meta http-equiv="Content-Type" content="application/json; text/html; charset=iso-8859-1" />
<title>Gastos</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript" src="ajax/searchAjax.js"></script>
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
function anular(cod_gasto_gral,nro_gasto_gral)
{	

					msj=confirm('Esta seguro de Anular el Gasto  No.'+nro_gasto_gral);
					if(msj==true)
					{
						izquierda=(screen.width)?(screen.width-300)/2:100
						arriba=(screen.height)?(screen.height-400)/2:100
						url="anularGastoGral.php?cod_gasto_gral="+cod_gasto_gral+"&nro_gasto_gral="+nro_gasto_gral;
						opciones=" toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=1,resizable=0, width=500, height=280, left="+izquierda+" top="+arriba;
	
						window.open(url,'popUp',opciones)
				}
	
}
function buscar()
{	

	if(document.form1.codActivoFecha.checked){
		valorchecked="on";
	}else{
		valorchecked="off";
	}
		var param="?";
		param+='nroGastoGralB='+document.form1.nroGastoGralB.value;
		param+='&nroDocB='+document.form1.nroDocB.value;
		param+='&cod_tipo_docB='+document.form1.cod_tipo_docB.value;
		param+='&nombreProveedorB='+document.form1.nombreProveedorB.value;
		param+='&cod_tipo_pagoB='+document.form1.cod_tipo_pagoB.value;
		param+='&cod_estado_pago_docB='+document.form1.cod_estado_pago_docB.value;
		param+='&cod_estadoB='+document.form1.cod_estadoB.value;
		param+='&codActivoFecha='+valorchecked;
		param+='&fechaInicioB='+document.form1.fechaInicioB.value;
		param+='&fechaFinalB='+document.form1.fechaFinalB.value;


		divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchGastosGral.php'+param);
			ajax.onreadystatechange=function() {
				if (ajax.readyState==4) {
					divResultado.innerHTML = ajax.responseText;
					cargarClasesFrame();	
			        agregarTablaReporteClase();
				}
			}
		ajax.send(null)

}
function paginar(f)
{	
	if(document.form1.codActivoFecha.checked){
		valorchecked="on";
	}else{
		valorchecked="off";
	}
		var param="?";
		param+='nroGastoGralB='+document.form1.nroGastoGralB.value;
		param+='&nroDocB='+document.form1.nroDocB.value;
		param+='&cod_tipo_docB='+document.form1.cod_tipo_docB.value;
		param+='&nombreProveedorB='+document.form1.nombreProveedorB.value;
		param+='&cod_tipo_pagoB='+document.form1.cod_tipo_pagoB.value;		
		param+='&cod_estado_pago_docB='+document.form1.cod_estado_pago_docB.value;
		param+='&cod_estadoB='+document.form1.cod_estadoB.value;
		param+='&codActivoFecha='+valorchecked;
		param+='&fechaInicioB='+document.form1.fechaInicioB.value;
		param+='&fechaFinalB='+document.form1.fechaFinalB.value;
		param+='&pagina='+document.form1.pagina1.value;		
		divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchGastosGral.php'+param);
			ajax.onreadystatechange=function() {
				if (ajax.readyState==4) {
					divResultado.innerHTML = ajax.responseText
				}
			}
		ajax.send(null)
}
function paginar1(f,pagina)
{		
	if(document.form1.codActivoFecha.checked){
		valorchecked="on";
	}else{
		valorchecked="off";
	}
		document.form1.pagina1.value=pagina*1;
		var param="?";
		param+='nroGastoGralB='+document.form1.nroGastoGralB.value;
		param+='&nroDocB='+document.form1.nroDocB.value;
		param+='&cod_tipo_docB='+document.form1.cod_tipo_docB.value;
		param+='&nombreProveedorB='+document.form1.nombreProveedorB.value;
		param+='&cod_tipo_pagoB='+document.form1.cod_tipo_pagoB.value;
		param+='&cod_estado_pago_docB='+document.form1.cod_estado_pago_docB.value;
		param+='&cod_estadoB='+document.form1.cod_estadoB.value;
		param+='&codActivoFecha='+valorchecked;
		param+='&fechaInicioB='+document.form1.fechaInicioB.value;
		param+='&fechaFinalB='+document.form1.fechaFinalB.value;
		param+='&pagina='+document.form1.pagina1.value;
		//alert(param);
		divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchGastosGral.php'+param);
			ajax.onreadystatechange=function() {
				if (ajax.readyState==4) {
					divResultado.innerHTML = ajax.responseText
				}
			}
		ajax.send(null)
}


</script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF">
<form name="form1" method="post"  id="form1">
<?php
	require("conexion.inc");
	include("funciones.php");

?>
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">LISTADO DE GASTOS 
  <a class="btn btn-warning btn-lg float-right text-white boton-filtro-iframe" href="#" data-toggle="modal" data-target="#filtroModal">
       <i class="fa fa-search"></i> BUSCAR REGISTROS
    </a>
</h3>


<div id="resultados">
<?php 

	$nro_filas_show=20;	
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
	$sql.=" from gastos_gral gg ";
$sql.=" left join proveedores p on(gg.cod_proveedor=p.cod_proveedor)";
	$sql.=" left join tipo_documento td on(gg.cod_tipo_doc=td.cod_tipo_doc)";
	$sql.=" left join estados_gastos_gral egg on(gg.cod_estado=egg.cod_estado)";
	$sql.=" left join gestiones g on(gg.cod_gestion=g.cod_gestion)";
	$sql.=" left join gastos ga on(gg.cod_gasto=ga.cod_gasto)";
	$sql.=" left join estado_pago_documento epd on(gg.cod_estado_pago_doc=epd.cod_estado_pago_doc)";
	$sql.=" left join tipos_pago tp on(gg.cod_tipo_pago=tp.cod_tipo_pago)";
	$sql.=" left join hojas_rutas hr  on( gg.cod_tipo_doc=1 and gg.codigo_doc=hr.cod_hoja_ruta)";
	$sql.=" left join ordentrabajo ot  on( gg.cod_tipo_doc=2 and gg.codigo_doc=ot.cod_orden_trabajo)";
	$sql.=" where  gg.cod_gasto_gral<>0 ";
	if($_GET['nroGastoGralB']<>""){
		$sql.=" and gg.nro_gasto_gral like '%".$_GET['nroGastoGralB']."%'";
	}
	if($_GET['nroDocB']<>""){
		$sql.=" and (hr.nro_hoja_ruta like '%".$_GET['nroDocB']."%' or ot.nro_orden_trabajo like '%".$_GET['nroDocB']."%')";
	}
	if($_GET['cod_tipo_docB']<>0){
		$sql.=" and gg.cod_tipo_doc=".$_GET['cod_tipo_docB'];
	}
	
	if($_GET['nombreProveedorB']<>""){
		$sql.=" and p.nombre_proveedor like '%".$_GET['nombreProveedorB']."%'";
	}
	if($_GET['cod_tipo_pagoB']<>0){
		$sql.=" and gg.cod_tipo_pago=".$_GET['cod_tipo_pagoB'];
	}
	
	if($_GET['cod_estado_pago_docB']<>0){
		$sql.=" and gg.cod_estado_pago_doc=".$_GET['cod_estado_pago_docB'];
	}
	if($_GET['cod_estadoB']<>0){
		$sql.=" and gg.cod_estado=".$_GET['cod_estadoB'];
	}
 	if($_GET['codActivoFecha']=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);
				
				$sql.=" and gg.fecha_gasto_gral>='".$aI."-".$mI."-".$dI."' and gg.fecha_gasto_gral<='".$aF."-".$mF."-".$dF."' ";

		}
	}	
	$sql.=" order by gg.fecha_gasto_gral,gg.nro_gasto_gral desc";

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
	$sql="select gg.cod_gasto_gral, gg.cod_gestion,g.gestion,g.gestion_nombre, gg.nro_gasto_gral, gg.codigo_doc,";
	$sql.=" gg.cod_tipo_doc, td.desc_tipo_doc, td.abrev_tipo_doc, gg.cod_proveedor, ";
	$sql.=" p.nombre_proveedor, gg.fecha_gasto_gral, ";
	$sql.=" gg.nro_recibo, gg.monto_gasto_gral,gg.cant_gasto_gral,gg.desc_gasto_gral,";
	$sql.=" gg.cod_gasto, ga.desc_gasto,gg.cod_estado_pago_doc, epd.desc_estado_pago_doc,gg.cod_tipo_pago, tp.nombre_tipo_pago,";
	$sql.=" gg.fecha_registro, gg.cod_usuario_registro,";
	$sql.=" gg.fecha_modifica, gg.cod_usuario_modifica,gg.cod_estado, egg.desc_estado, hr.nro_hoja_ruta, ot.nro_orden_trabajo ";
	$sql.=" from gastos_gral gg ";
	$sql.=" left join proveedores p on(gg.cod_proveedor=p.cod_proveedor)";
	$sql.=" left join tipo_documento td on(gg.cod_tipo_doc=td.cod_tipo_doc)";
	$sql.=" left join estados_gastos_gral egg on(gg.cod_estado=egg.cod_estado)";
	$sql.=" left join gestiones g on(gg.cod_gestion=g.cod_gestion)";
	$sql.=" left join gastos ga on(gg.cod_gasto=ga.cod_gasto)";
	$sql.=" left join estado_pago_documento epd on(gg.cod_estado_pago_doc=epd.cod_estado_pago_doc)";
	$sql.=" left join tipos_pago tp on(gg.cod_tipo_pago=tp.cod_tipo_pago)";
	$sql.=" left join hojas_rutas hr  on( gg.cod_tipo_doc=1 and gg.codigo_doc=hr.cod_hoja_ruta)";
	$sql.=" left join ordentrabajo ot  on( gg.cod_tipo_doc=2 and gg.codigo_doc=ot.cod_orden_trabajo)";
	$sql.=" where  gg.cod_gasto_gral<>0 ";
	if($_GET['nroGastoGralB']<>""){
		$sql.=" and gg.nro_gasto_gral like '%".$_GET['nroGastoGralB']."%'";
	}
	if($_GET['nroDocB']<>""){
		$sql.=" and (hr.nro_hoja_ruta like '%".$_GET['nroDocB']."%' or ot.nro_orden_trabajo like '%".$_GET['nroDocB']."%')";
	}
	if($_GET['cod_tipo_docB']<>0){
		$sql.=" and gg.cod_tipo_doc=".$_GET['cod_tipo_docB'];
	}
	
	if($_GET['nombreProveedorB']<>""){
		$sql.=" and p.nombre_proveedor like '%".$_GET['nombreProveedorB']."%'";
	}
	if($_GET['cod_tipo_pagoB']<>0){
		$sql.=" and gg.cod_tipo_pago=".$_GET['cod_tipo_pagoB'];
	}
		
	if($_GET['cod_estado_pago_docB']<>0){
		$sql.=" and gg.cod_estado_pago_doc=".$_GET['cod_estado_pago_docB'];
	}
	if($_GET['cod_estadoB']<>0){
		$sql.=" and gg.cod_estado=".$_GET['cod_estadoB'];
	}
 	if($_GET['codActivoFecha']=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);
				
				$sql.=" and gg.fecha_gasto_gral>='".$aI."-".$mI."-".$dI."' and gg.fecha_gasto_gral<='".$aF."-".$mF."-".$dF."' ";

		}
	}
	$sql.=" order by gg.fecha_gasto_gral desc ,gg.nro_gasto_gral desc";
	$sql.=" limit 50";

	$resp = mysql_query($sql);
	$cont=0;
?>
<table width="95%" align="center" cellpadding="1" id="cotizacion" cellspacing="1" bgcolor="#cccccc" class="tablaReporte" style="width:100% !important;">

  <thead>
  <tr height="20px" align="center"  class="bg-success text-white">
    <th>Nro Gasto</th>
    <th>Fecha Gasto</th>
    <th>Nro Rec</th>
    <th>Proveedor</th>
    <th>Gasto</th>
    <th>Cantidad</th>
    <th>Monto</th>
    <th>Ref</th>
	<th>Forma de Pago</th>
    <th>Estado de Pago</th>
    <th>Fecha Registro</th>
    <th>Fecha Edicion</th>
    <th>Estado de Doc</th>
	<th>Editar</th>
	<th>Anular</th>
	<th>Copiar</th>	
  </tr>
  </thead>
  <tbody>
  <?php   
		while($dat=mysql_fetch_array($resp)){
			$cod_gasto_gral=$dat['cod_gasto_gral']; 
			$cod_gestion=$dat['cod_gestion']; 
			$gestion=$dat['gestion'];
			$gestion_nombre=$dat['gestion_nombre']; 
			$nro_gasto_gral=$dat['nro_gasto_gral']; 
			$codigo_doc=$dat['codigo_doc']; 
			$cod_tipo_doc=$dat['cod_tipo_doc']; 
			$desc_tipo_doc=$dat['desc_tipo_doc']; 
			$abrev_tipo_doc=$dat['abrev_tipo_doc']; 
			$cod_proveedor=$dat['cod_proveedor']; 
			$nombre_proveedor=$dat['nombre_proveedor'];  
			$fecha_gasto_gral=$dat['fecha_gasto_gral']; 
			$nro_recibo=$dat['nro_recibo']; 
			$monto_gasto_gral=$dat['monto_gasto_gral']; 
			$cant_gasto_gral=$dat['cant_gasto_gral']; 
			$desc_gasto_gral=$dat['desc_gasto_gral']; 
			$cod_gasto=$dat['cod_gasto']; 
			$desc_gasto=$dat['desc_gasto'];
			$cod_estado_pago_doc=$dat['cod_estado_pago_doc'];
			$desc_estado_pago_doc=$dat['desc_estado_pago_doc'];
			$cod_tipo_pago=$dat['cod_tipo_pago'];
			$nombre_tipo_pago=$dat['nombre_tipo_pago'];
			$fecha_registro=$dat['fecha_registro']; 
			$cod_usuario_registro=$dat['cod_usuario_registro']; 
			$fecha_modifica=$dat['fecha_modifica']; 
			$cod_usuario_modifica=$dat['cod_usuario_modifica']; 
			$cod_estado=$dat['cod_estado'];  
			$desc_estado=$dat['desc_estado'];
			$datosRegistro=""; 
			if($cod_usuario_registro!="" || $cod_usuario_registro!=NULL){
				$datosRegistro=strftime("%d/%m/%Y %H:%M:%S",strtotime($fecha_registro));
				$sqlAux="select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios where cod_usuario=".$cod_usuario_registro;
				$respAux = mysql_query($sqlAux);
				while($datAux=mysql_fetch_array($respAux)){
					$datosRegistro=$datosRegistro." ".$datAux['nombres_usuario']." ".$datAux['ap_paterno_usuario'];

				}
			}
			$datosEdicion=""; 
			if($cod_usuario_modifica!="" || $cod_usuario_modifica!=NULL){
				$datosEdicion=strftime("%d/%m/%Y %H:%M:%S",strtotime($fecha_modifica));
				$sqlAux="select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios where cod_usuario=".$cod_usuario_modifica;
				$respAux = mysql_query($sqlAux);
				while($datAux=mysql_fetch_array($respAux)){
					$datosEdicion=$datosEdicion." ".$datAux['nombres_usuario']." ".$datAux['ap_paterno_usuario'];

				}
			}
			/////////////////Datos de Documento
			$nro_doc="";
			$cod_gestion_doc="";
			$gestion_nombre_doc="";
			$gestion_doc="";
			$cod_client_doc="";
			$nombre_cliente_doc="";
								
		?>
  <tr bgcolor="#FFFFFF" class="text"  valign="middle">
    <td align="right"><a href="vistaGastoGral.php?cod_gasto_gral=<?php echo $cod_gasto_gral;?>" target="_blank"><?php echo $nro_gasto_gral."/".$gestion_nombre;?></a></td>
    <td><?php echo strftime("%d/%m/%Y",strtotime($fecha_gasto_gral));?></td>
    <td><?php echo $nro_recibo;?></td>
    <td><?php echo $nombre_proveedor;?></td>
    <td><?php echo $desc_gasto."<br/>".$desc_gasto_gral;?></td>
    <td><?php echo $cant_gasto_gral;?></td>
    <td><?php echo $monto_gasto_gral;?></td>
    <td><?php
	
				$nro_doc="";
				$cod_gestion_doc="";
				$gestion_nombre_doc="";
				$gestion_doc="";
				$cod_cliente_doc="";
				$nombre_cliente_doc="";
				if($cod_tipo_doc==1){
				$sqlAux=" select hr.nro_hoja_ruta,hr.cod_gestion, g.gestion_nombre, g.gestion, c.cod_cliente,cli.nombre_cliente";
				$sqlAux.=" from hojas_rutas hr ";
				$sqlAux.=" inner join cotizaciones c on(hr.cod_cotizacion=c.cod_cotizacion)";
				$sqlAux.=" left join clientes cli on (cli.cod_cliente=c.cod_cliente)";
				$sqlAux.=" left join gestiones g on (hr.cod_gestion =g.cod_gestion )";
				$sqlAux.=" where hr.cod_hoja_ruta=".$codigo_doc;
				$respAux = mysql_query($sqlAux);
				while($datAux=mysql_fetch_array($respAux)){
					$nro_doc=$datAux['nro_hoja_ruta'];
					$cod_gestion_doc=$datAux['cod_gestion'];
					$gestion_nombre_doc=$datAux['gestion_nombre'];
					$gestion_doc=$datAux['gestion'];
					$cod_cliente_doc=$datAux['cod_cliente'];
					$nombre_cliente_doc=$datAux['nombre_cliente'];

				}
				?>
        <a href="../reportes/impresionHojaRuta.php?cod_hoja_ruta=<?php echo $codigo_doc; ?>" target="_blank"><?php echo $abrev_tipo_doc." ".$nro_doc."/".$gestion_nombre_doc." (".$nombre_cliente_doc.")";?></a>
        <?php
				}
?>
        <?php 
				if($cod_tipo_doc==2){
				$sqlAux=" select ot.nro_orden_trabajo,ot.cod_gestion, g.gestion_nombre, g.gestion, ot.cod_cliente,cli.nombre_cliente ";
				$sqlAux.=" from ordentrabajo  ot ";
				$sqlAux.=" left join clientes cli on (cli.cod_cliente=ot.cod_cliente) ";
				$sqlAux.=" left join gestiones g on (ot.cod_gestion =g.cod_gestion )";
				$sqlAux.=" where ot.cod_orden_trabajo=".$codigo_doc;
				$respAux = mysql_query($sqlAux);
				while($datAux=mysql_fetch_array($respAux)){
					$nro_doc=$datAux['nro_orden_trabajo'];
					$cod_gestion_doc=$datAux['cod_gestion'];
					$gestion_nombre_doc=$datAux['gestion_nombre'];
					$gestion_doc=$datAux['gestion'];
					$cod_client_doc=$datAux['cod_cliente'];
					$nombre_cliente_doc=$datAux['nombre_cliente'];

				}
				?>
        <a href="../reportes/impresionOrdenTrabajo.php?cod_orden_trabajo=<?php echo $codigo_doc; ?>" target="_blank"><?php echo $abrev_tipo_doc." ".$nro_doc."/".$gestion_nombre_doc." (".$nombre_cliente_doc.")";?></a>
        <?php
				}
?>
    </td>	
	<td><?php echo $nombre_tipo_pago;?></td>
    <td><?php echo $desc_estado_pago_doc;?></td>
    <td><?php echo $datosRegistro;?></td>
    <td><?php echo $datosEdicion;?></td>
    <td><?php echo $desc_estado;?></td>
	<td>
	<?php 
	
		$sqlAux=" select COUNT(*) ";
		$sqlAux.=" from pago_proveedor_detalle ppd ";
		$sqlAux.=" left join pago_proveedor pp on(ppd.cod_pago_prov=pp.cod_pago_prov) ";
		$sqlAux.=" where ppd.cod_tipo_doc=5 and ppd.codigo_doc=".$cod_gasto_gral;
		$sqlAux.=" and pp.cod_estado_pago_prov<>2 ";
		$respAux = mysql_query($sqlAux);
		$nroPagoProv=0;
		while($datAux=mysql_fetch_array($respAux)){
			$nroPagoProv=$datAux[0];
		}
		if($cod_estado==1 and $nroPagoProv==0){	
			$sqlAux=" select cod_perfil from usuarios where cod_usuario=".$_COOKIE['usuario_global'];
			$respAux = mysql_query($sqlAux);
			while($datAux=mysql_fetch_array($respAux)){
				$cod_perfil=$datAux['cod_perfil'];
			}
			if($cod_perfil==1){
			?>
				<a href="editGastoGral.php?cod_gasto_gral=<?php echo $cod_gasto_gral;?>">Editar</a>
			<?php			
			}else{
			 	if(suma_fechas(strftime("%Y-%m-%d",strtotime($fecha_registro)),2)>(date('Y-m-d', time()))){
				?>
				<a href="editGastoGral.php?cod_gasto_gral=<?php echo $cod_gasto_gral;?>">Editar</a>
			<?php
				}
			}
		}
	?>
	</td>
	<td>
	<?php 
		if($cod_estado==1 and $nroPagoProv==0){
	?>
		<a href="javascript:anular(<?php echo $cod_gasto_gral; ?>,'<?php echo $nro_gasto_gral."/".$gestion_nombre; ?>')" >Anular</a> 
	
	<?php
		}else{
	?>
	Anular
		<?php
		}
	?>
</td>
<td><a href="CopyGastoGral.php?cod_gasto_gral=<?php echo $cod_gasto_gral;?>">Copiar</a></td>
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
<td><strong>Nro de Gasto</strong></td>
<td colspan="3"><input type="text" name="nroGastoGralB" id="nroGastoGralB" size="10" value="<?php echo $nroGastoGralB;?>" class="textoform" onkeyup="buscar()" ></td>
</tr>
<tr class="texto">
		 <td><strong>Nro de Doc</strong></td>
		 <td ><input type="text" name="nroDocB" id="nroDocB" size="10" value="<?php echo $nroDocB;?>" class="textoform" onkeyup="buscar()" ></td>
         <td align="left" ><strong>Tipo de Documento</strong></td>
         <td align="left"><select name="cod_tipo_docB" id="cod_tipo_docB" onchange="buscar();" class="textoform">
				<option value="0">Elija un Opci&oacute;n</option>
				<?php
					$sql2=" select cod_tipo_doc, desc_tipo_doc";
					$sql2.=" from   tipo_documento ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_tipo_doc=$dat2['cod_tipo_doc'];	
			  		 		$desc_tipo_doc=$dat2['desc_tipo_doc'];	
				 ?>
                 <option value="<?php echo $cod_tipo_doc;?>" <?php if($cod_tipo_docB==$cod_tipo_doc){?> selected="selected" <?php } ?>><?php echo utf8_decode($desc_tipo_doc);?></option>				
				<?php		
					}
				?>						
			</select></td>
 </tr>     

<tr><td><strong>Proveedor</strong></td>
<td colspan="3">
 <input name="nombreProveedorB" id="nombreProveedorB" size="70" class="textoform" value="<?php echo $nombreProveedorB; ?>" onkeyup="buscar()">
	</td>
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
<td><strong>Estado de Pago</strong></td>
<td >
<select name="cod_estado_pago_docB" id="cod_estado_pago_docB" onchange="buscar();" class="textoform">
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
			</select>
	</td>
</tr>
<tr><td><strong>Estado de Gasto</strong></td>
<td colspan="3">
<select name="cod_estadoB" id="cod_estadoB" onchange="buscar();" class="textoform">
				<option value="0">Elija un Opci&oacute;n</option>
				<?php
					$sql2=" select cod_estado, desc_estado";
					$sql2.=" from   estados_gastos_gral ";
					$sql2.=" order by cod_estado asc ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_estado=$dat2['cod_estado'];	
			  		 		$desc_estado=$dat2['desc_estado'];	
				 ?>
                 <option value="<?php echo $cod_estado;?>" <?php if($_GET['cod_estadoB']==$cod_estado){?> selected="selected" <?php } ?>><?php echo utf8_decode($desc_estado);?></option>				
				<?php		
					}
				?>						
			</select>
	</td>
</tr>
<tr >
     		<td>&nbsp;<b>Rango de Fecha<br/>(dd/mm/aaaa)</b>&nbsp;</td>			
     		<td colspan="3"><strong>De&nbsp;</strong>
                <input type="text" name="fechaInicioB" id="fechaInicioB" class="textoform" value="<?php echo $fechaInicioB; ?>">
        <strong>&nbsp;Hasta&nbsp;</strong>
        <input type="text" name="fechaFinalB" id="fechaFinalB" class="textoform" value="<?php echo $fechaFinalB; ?>" >
<input type="checkbox" name="codActivoFecha" id="codActivoFecha" <?php if($codActivoFecha=="on"){?>checked="checked"<?php }?> onClick="buscar()" ><strong>Chekear la casilla para buscar por fechas.</strong>
			</td>
    	</tr>
</table>
<div align="right"><a href="newGastoGral.php"class="btn btn-warning"><i class="fa fa-plus"></i> NUEVO GASTO</a></div>

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
