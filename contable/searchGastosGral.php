<?php
header('Content-Type: text/html; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';

//coneccion a la Base de Datos
require("conexion.inc");
include("funciones.php");

//para sacar los datos de la busqueda
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>GASTOS</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>

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


</body>
</html>