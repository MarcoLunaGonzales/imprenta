<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Comprobantes</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
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
function buscar()
{	
	//alert("buscar");
	if(document.form1.codActivoFecha.checked){
		valorchecked="on";
	}else{
		valorchecked="off";
	}
		var param="?";
		param+='codtipocbteB='+document.form1.codtipocbteB.value;
		param+='&nrocbteB='+document.form1.nrocbteB.value;		
		param+='&nombreB='+document.form1.nombreB.value;
		param+='&glosaB='+document.form1.glosaB.value;
		param+='&codActivoFecha='+valorchecked;
		param+='&fechaInicioB='+document.form1.fechaInicioB.value;
		param+='&fechaFinalB='+document.form1.fechaFinalB.value;
		param+='&cuentaB='+document.form1.cuentaB.value;
		param+='&glosaDetB='+document.form1.glosaDetB.value;
		param+='&codtipodocB='+document.form1.codtipodocB.value;
		param+='&nroDocB='+document.form1.nroDocB.value;
		param+='&clienteB='+document.form1.clienteB.value;
		param+='&proveedorB='+document.form1.proveedorB.value;
		param+='&nro_filas_show=1';
		//alert("param="+param);
		
		divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchComprobantes.php'+param);
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
	//alert("paginar");
	if(document.form1.codActivoFecha.checked){
		valorchecked="on";
	}else{
		valorchecked="off";
	}
		var param="?";
		param+='codtipocbteB='+document.form1.codtipocbteB.value;
		param+='&nrocbteB='+document.form1.nrocbteB.value;
		param+='&nombreB='+document.form1.nombreB.value;	
		param+='&glosaB='+document.form1.glosaB.value;
		param+='&codActivoFecha='+valorchecked;
		param+='&fechaInicioB='+document.form1.fechaInicioB.value;
		param+='&fechaFinalB='+document.form1.fechaFinalB.value;
		param+='&cuentaB='+document.form1.cuentaB.value;
		param+='&glosaDetB='+document.form1.glosaDetB.value;
		param+='&codtipodocB='+document.form1.codtipodocB.value;
		param+='&nroDocB='+document.form1.nroDocB.value;
		param+='&clienteB='+document.form1.clienteB.value;
		param+='&proveedorB='+document.form1.proveedorB.value;
		param+='&nro_filas_show='+document.form1.nro_filas_show.value;
		param+='&pagina='+document.form1.pagina1.value;
		//alert("aquii="+param);
	
		divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchComprobantes.php'+param);
			ajax.onreadystatechange=function() {
				if (ajax.readyState==4) {
					divResultado.innerHTML = ajax.responseText
				}
			}
		ajax.send(null)	
}
function paginar1(f,pagina)
{	
//alert("paginar1 GABRIELA");
if(document.form1.codActivoFecha.checked){
		valorchecked="on";
	}else{
		valorchecked="off";
	}
		document.form1.pagina1.value=pagina*1;
		var param="?";
		param+='codtipocbteB='+document.form1.codtipocbteB.value;
		param+='&nrocbteB='+document.form1.nrocbteB.value;
		param+='&nombreB='+document.form1.nombreB.value;		
		param+='&glosaB='+document.form1.glosaB.value;
		param+='&codActivoFecha='+valorchecked;
		param+='&fechaInicioB='+document.form1.fechaInicioB.value;
		param+='&fechaFinalB='+document.form1.fechaFinalB.value;
		param+='&cuentaB='+document.form1.cuentaB.value;
		param+='&glosaDetB='+document.form1.glosaDetB.value;
		param+='&codtipodocB='+document.form1.codtipodocB.value;
		param+='&nroDocB='+document.form1.nroDocB.value;
		param+='&clienteB='+document.form1.clienteB.value;
		param+='&proveedorB='+document.form1.proveedorB.value;
		param+='&nro_filas_show='+document.form1.nro_filas_show.value;	
		param+='&pagina='+document.form1.pagina1.value;
//	alert(param);
		divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
		//alert('searchComprobantes.php'+param);
			ajax.open("GET",'searchComprobantes.php'+param);
			ajax.onreadystatechange=function() {
				if (ajax.readyState==4) {
					divResultado.innerHTML = ajax.responseText
				}
			}
		ajax.send(null)	
}
function paginar2(f)
{	
//alert("paginar2");
if(document.form1.codActivoFecha.checked){
		valorchecked="on";
	}else{
		valorchecked="off";
	}
		var param="?";
		param+='codtipocbteB='+document.form1.codtipocbteB.value;
		param+='&nrocbteB='+document.form1.nrocbteB.value;
		param+='&nombreB='+document.form1.nombreB.value;		
		param+='&glosaB='+document.form1.glosaB.value;
		param+='&codActivoFecha='+valorchecked;
		param+='&fechaInicioB='+document.form1.fechaInicioB.value;
		param+='&fechaFinalB='+document.form1.fechaFinalB.value;
		param+='&cuentaB='+document.form1.cuentaB.value;
		param+='&glosaDetB='+document.form1.glosaDetB.value;
		param+='&codtipodocB='+document.form1.codtipodocB.value;
		param+='&nroDocB='+document.form1.nroDocB.value;
		param+='&clienteB='+document.form1.clienteB.value;
		param+='&proveedorB='+document.form1.proveedorB.value;
		param+='&nro_filas_show='+document.form1.nro_filas_show.value;
		param+='&pagina='+document.form1.pagina2.value;
	//	alert(param);
			divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchComprobantes.php'+param);
			ajax.onreadystatechange=function() {
				if (ajax.readyState==4) {
					divResultado.innerHTML = ajax.responseText
				}
			}
		ajax.send(null)
}
function anular(cod_bte,nro_cbte)
{	

					msj=confirm('Esta seguro de Anular el Cbte  No.'+nro_cbte);
					if(msj==true)
					{
						izquierda=(screen.width)?(screen.width-300)/2:100
						arriba=(screen.height)?(screen.height-400)/2:100
						url="anularCbte.php?cod_cbte="+cod_bte+"&nro_cbte="+nro_cbte;
						opciones=" toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=1,resizable=0, width=500, height=280, left="+izquierda+" top="+arriba;
	
						window.open(url,'popUp',opciones)
				}
	
}
function registrar(f){
	f.submit();
}


</script>

</head>
<body  bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">COMPROBANTES
   <a class="btn btn-warning btn-lg float-right text-white boton-filtro-iframe" href="#" data-toggle="modal" data-target="#filtroModal">
       <i class="fa fa-search"></i> BUSCAR REGISTROS
    </a>
</h3>
<form name="form1" id="form1" method="post" >
<?php 
	require("conexion.inc");
	include("funciones.php");

?>



<div id="resultados">


<?php	
	//Paginador
	if($_GET['$nro_filas_show']==""){
		$nro_filas_show=20;
	}
	$pagina = $_GET['pagina'];

	if ($pagina == ""){
		$pagina = 1;
		$fila_inicio=0;
		$fila_final=$nro_filas_show;
	}else{
		$fila_inicio=(($pagina*$nro_filas_show)-$nro_filas_show);
		$fila_final=($fila_inicio+$nro_filas_show);
	}	

		$sql=" select COUNT( DISTINCT(c.cod_cbte)) ";
		$sql.=" from comprobante_detalle cd  ";
		$sql.=" right JOIN  comprobante c on(cd.cod_cbte=c.cod_cbte)";
		$sql.=" inner join gestiones g on(c.cod_gestion=g.cod_gestion)";
		$sql.=" inner join tipo_comprobante tc on(c.cod_tipo_cbte=tc.cod_tipo_cbte)";
		$sql.=" inner join estado_comprobante ec on(c.cod_estado_cbte=ec.cod_estado_cbte)";
		$sql.=" left join  cuentas cu on(cd.cod_cuenta=cu.cod_cuenta)";
		$sql.=" left join usuarios u on(c.cod_usuario_registro=u.cod_usuario)";
		$sql.=" left join usuarios um on(c.cod_usuario_modifica=um.cod_usuario)";
		$sql.=" left join pago_proveedor_detalle ppd on(c.cod_tipo_cbte=2 and cd.id_pago=ppd.cod_pago_prov and cd.id_pago_detalle=ppd.cod_pago_prov_detalle)";
		$sql.=" left join pago_proveedor  pp on ( ppd.cod_pago_prov=pp.cod_pago_prov)";
		$sql.=" left join proveedores pro on( pp.cod_proveedor=pro.cod_proveedor)";
		$sql.=" left join gastos_gral gg  on( ppd.cod_tipo_doc=5 and ppd.codigo_doc=gg.cod_gasto_gral)";
		$sql.=" left join ingresos i  on(  ppd.cod_tipo_doc=4 and ppd.codigo_doc=i.cod_ingreso)";
		$sql.=" left join pagos_detalle pd on(c.cod_tipo_cbte=3 and cd.id_pago=pd.cod_pago and cd.id_pago_detalle=pd.cod_pago_detalle)";
		$sql.=" left join pagos  p on ( pd.cod_pago=p.cod_pago)";
		$sql.=" left join clientes cli on(p.cod_cliente=cli.cod_cliente )";
		$sql.=" left join ordentrabajo ot  on( pd.cod_tipo_doc=2 and pd.codigo_doc=ot.cod_orden_trabajo)";
		$sql.=" left join hojas_rutas hr  on( pd.cod_tipo_doc=1 and pd.codigo_doc=hr.cod_hoja_ruta)";
		$sql.=" left join salidas s  on( pd.cod_tipo_doc=3 and pd.codigo_doc=s.cod_salida)";		
		$sql.=" where c.cod_cbte<>0";
		////Busqueda//////////////////
		if($_GET['codtipocbteB']<>0){
			$sql.=" and c.cod_tipo_cbte =".$_GET['codtipocbteB'];
		}			
		if($_GET['nrocbteB']<>""){
			$sql.=" and CONCAT(c.nro_cbte,'/',g.gestion_nombre) LIKE '%".$_GET['nrocbteB']."%' ";

		}
		if($_GET['nombreB']<>""){
			$sql.=" and  c.nombre like '%".$_GET['nombreB']."%'";
		}			
		if($_GET['glosaB']<>""){
			$sql.=" and  c.glosa like '%".$_GET['glosaB']."%'";
		}		

		if($_GET['codActivoFecha']=="on"){
			$fechaInicioB=$_GET['fechaInicioB'];
			$fechaFinalB=$_GET['fechaFinalB'];
			if($fechaInicioB<>"" and $fechaFinalB<>""){
					list($dI,$mI,$aI)=explode("/",$fechaInicioB);
					list($dF,$mF,$aF)=explode("/",$fechaFinalB);				
					$sql.=" and c.fecha_cbte>='".$aI."-".$mI."-".$dI."' and c.fecha_cbte<='".$aF."-".$mF."-".$dF."' ";
			}
		}			
		if($_GET['cuentaB']<>""){
			$sql.=" and ( cu.nro_cuenta like '%".$_GET['cuentaB']."%' or cu.desc_cuenta like '%".$_GET['cuentaB']."%')";
		}		
		if($_GET['glosaDetB']<>""){
			$sql.=" and  cd.glosa like '%".$_GET['glosaDetB']."%'";
		}							
		if($_GET['codtipodocB']<>0){
			$sql.=" and (ppd.cod_tipo_doc =".$_GET['codtipodocB']." or pd.cod_tipo_doc =".$_GET['codtipodocB']." )";
		}	
		if($_GET['nroDocB']<>0){
			$sql.=" and (hr.nro_hoja_ruta like '%".$_GET['nroDocB']."%' or ot.nro_orden_trabajo like '%".$_GET['nroDocB']."%'";
			$sql.=" or s.nro_salida like '%".$_GET['nroDocB']."%' or i.nro_ingreso like '%".$_GET['nroDocB']."%' or gg.nro_gasto_gral like '%".$_GET['nroDocB']."%')";
		}	
		
		if($_GET['clienteB']<>""){
			$sql.=" and  cli.nombre_cliente like '%".$_GET['clienteB']."%'";
		}	
		if($_GET['proveedorB']<>""){
			$sql.=" and  pro.nombre_proveedor like '%".$_GET['proveedorB']."%'";
		}						
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
		$sql=" select DISTINCT(c.cod_cbte), c.cod_empresa, c.cod_gestion, g.gestion_nombre, c.cod_tipo_cbte,tc.nombre_tipo_cbte, c.nro_cbte, ";
		$sql.=" c.cod_moneda, c.cod_estado_cbte, ec.nombre_estado_cbte, c.fecha_cbte, c.nro_cheque, c.nro_factura, ";
		$sql.=" c.nombre, c.glosa, c.cod_usuario_registro,u.nombres_usuario as nombres_usuario_reg,";
		$sql.=" u.ap_paterno_usuario as ap_paterno_usuario_reg,c.fecha_registro, ";
		$sql.=" c.cod_usuario_modifica, um.nombres_usuario as nombres_usuario_mod, um.ap_paterno_usuario as ap_paterno_usuario_mod,";
		$sql.=" c.fecha_modifica";
		$sql.=" from comprobante_detalle cd  ";
		$sql.=" right JOIN  comprobante c on(cd.cod_cbte=c.cod_cbte)";
		$sql.=" inner join gestiones g on(c.cod_gestion=g.cod_gestion)";
		$sql.=" inner join tipo_comprobante tc on(c.cod_tipo_cbte=tc.cod_tipo_cbte)";
		$sql.=" inner join estado_comprobante ec on(c.cod_estado_cbte=ec.cod_estado_cbte)";
		$sql.=" left join  cuentas cu on(cd.cod_cuenta=cu.cod_cuenta)";
		$sql.=" left join usuarios u on(c.cod_usuario_registro=u.cod_usuario)";
		$sql.=" left join usuarios um on(c.cod_usuario_modifica=um.cod_usuario)";
		$sql.=" left join pago_proveedor_detalle ppd on(c.cod_tipo_cbte=2 and cd.id_pago=ppd.cod_pago_prov and cd.id_pago_detalle=ppd.cod_pago_prov_detalle)";
		$sql.=" left join pago_proveedor  pp on ( ppd.cod_pago_prov=pp.cod_pago_prov)";
		$sql.=" left join proveedores pro on( pp.cod_proveedor=pro.cod_proveedor)";
		$sql.=" left join gastos_gral gg  on( ppd.cod_tipo_doc=5 and ppd.codigo_doc=gg.cod_gasto_gral)";
		$sql.=" left join ingresos i  on(  ppd.cod_tipo_doc=4 and ppd.codigo_doc=i.cod_ingreso)";
		$sql.=" left join pagos_detalle pd on(c.cod_tipo_cbte=3 and cd.id_pago=pd.cod_pago and cd.id_pago_detalle=pd.cod_pago_detalle)";
		$sql.=" left join pagos  p on ( pd.cod_pago=p.cod_pago)";
		$sql.=" left join clientes cli on(p.cod_cliente=cli.cod_cliente )";
		$sql.=" left join ordentrabajo ot  on( pd.cod_tipo_doc=2 and pd.codigo_doc=ot.cod_orden_trabajo)";
		$sql.=" left join hojas_rutas hr  on( pd.cod_tipo_doc=1 and pd.codigo_doc=hr.cod_hoja_ruta)";
		$sql.=" left join salidas s  on( pd.cod_tipo_doc=3 and pd.codigo_doc=s.cod_salida)";		
		$sql.=" where c.cod_cbte<>0";
		////Busqueda//////////////////
		if($_GET['codtipocbteB']<>0){
			$sql.=" and c.cod_tipo_cbte =".$_GET['codtipocbteB'];
		}			
		if($_GET['nrocbteB']<>""){
			$sql.=" and CONCAT(c.nro_cbte,'/',g.gestion_nombre) LIKE '%".$_GET['nrocbteB']."%' ";

		}
		if($_GET['glosaB']<>""){
			$sql.=" and  c.glosa like '%".$_GET['glosaB']."%'";
		}
		if($_GET['nombreB']<>""){
			$sql.=" and  c.nombre like '%".$_GET['nombreB']."%'";
		}		

		if($_GET['codActivoFecha']=="on"){
			$fechaInicioB=$_GET['fechaInicioB'];
			$fechaFinalB=$_GET['fechaFinalB'];
			if($fechaInicioB<>"" and $fechaFinalB<>""){
					list($dI,$mI,$aI)=explode("/",$fechaInicioB);
					list($dF,$mF,$aF)=explode("/",$fechaFinalB);				
					$sql.=" and c.fecha_cbte>='".$aI."-".$mI."-".$dI."' and c.fecha_cbte<='".$aF."-".$mF."-".$dF."' ";
			}
		}			
		if($_GET['cuentaB']<>""){
			$sql.=" and ( cu.nro_cuenta like '%".$_GET['cuentaB']."%' or cu.desc_cuenta like '%".$_GET['cuentaB']."%')";
		}		
		if($_GET['glosaDetB']<>""){
			$sql.=" and  cd.glosa like '%".$_GET['glosaDetB']."%'";
		}							
		if($_GET['codtipodocB']<>0){
			$sql.=" and (ppd.cod_tipo_doc =".$_GET['codtipodocB']." or pd.cod_tipo_doc =".$_GET['codtipodocB']." )";
		}	
		if($_GET['nroDocB']<>0){
			$sql.=" and (hr.nro_hoja_ruta like '%".$_GET['nroDocB']."%' or ot.nro_orden_trabajo like '%".$_GET['nroDocB']."%'";
			$sql.=" or s.nro_salida like '%".$_GET['nroDocB']."%' or i.nro_ingreso like '%".$_GET['nroDocB']."%' or gg.nro_gasto_gral like '%".$_GET['nroDocB']."%')";
		}	
		
		if($_GET['clienteB']<>""){
			$sql.=" and  cli.nombre_cliente like '%".$_GET['clienteB']."%'";
		}	
		if($_GET['proveedorB']<>""){
			$sql.=" and  pro.nombre_proveedor like '%".$_GET['proveedorB']."%'";
		}							
			
		$sql.=" order by  c.fecha_cbte desc,c.nro_cbte desc";

		$sql.=" limit 50";
//		echo $sql;
		
		$resp = mysql_query($sql);

?>	

	<table width="95%" align="center" cellpadding="1" cellspacing="1" bgColor="#CCCCCC" class="tablaReporte" style="width:100% !important;">
    
	<thead>
	    <tr height="20px" align="center"  class="bg-success text-white">
    		<th>Fecha Cbte</th>
            <th>Tipo Cbte</th>
    		<th>Nro Cbte</th>
			<th>Referencias</th>
    		<th>Nro Factura</th>
    		<th>Glosa</th>
            <th>Estado</th>
    		<th>Registro</th>
            <th>Ultima Edición</th>	
            <th>Editar</th>		
			<th>Anular</th>	                   																                   															
		</tr>
		</thead>
     <tbody>
<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){	
			$cod_cbte=$dat['cod_cbte'];
			$cod_empresa=$dat['cod_empresa'];
			$cod_gestion=$dat['cod_gestion'];
			$gestion_nombre=$dat['gestion_nombre'];
			$cod_tipo_cbte=$dat['cod_tipo_cbte'];
			$nombre_tipo_cbte=$dat['nombre_tipo_cbte'];
			$nro_cbte=$dat['nro_cbte'];
			$cod_moneda=$dat['cod_moneda'];
			$cod_estado_cbte=$dat['cod_estado_cbte'];
			$nombre_estado_cbte=$dat['nombre_estado_cbte'];
			$fecha_cbte=$dat['fecha_cbte'];
			$nro_cheque=$dat['nro_cheque'];
			$nro_factura=$dat['nro_factura'];
			$nombre=$dat['nombre'];
			$glosa=$dat['glosa'];
			$cod_usuario_registro=$dat['cod_usuario_registro'];
			$nombres_usuario_reg=$dat['nombres_usuario_reg'];
			$ap_paterno_usuario_reg=$dat['ap_paterno_usuario_reg'];
			$fecha_registro=$dat['fecha_registro'];
			$cod_usuario_modifica=$dat['cod_usuario_modifica'];
			$nombres_usuario_mod=$dat['nombres_usuario_mod'];
			$ap_paterno_usuario_mod=$dat['ap_paterno_usuario_mod'];
			$fecha_modifica=$dat['fecha_modifica'];
	
			if($cod_moneda!= NULL){	
					$sql2="select desc_moneda from monedas where cod_moneda=".$cod_moneda;
					$resp2 = mysql_query($sql2);
					$desc_moneda="";
					while($dat2=mysql_fetch_array($resp2)){
						$desc_moneda=$dat2['desc_moneda'];
					}
				}
				//Obteniendo Fecha de Registro
				$usuario_registro="";
				if($cod_usuario_registro!=NULL){					
						$usuario_registro=strftime("%d/%m/%Y %H:%M:%S",strtotime($fecha_registro))." ".$nombres_usuario_reg." ".$ap_paterno_usuario_reg;
				}
				// Fin Obteniendo Fecha de Registro	
				//Obteniendo Fecha de Registro
				$usuario_modifica="";
				if($cod_usuario_modifica!=NULL){

						$usuario_modifica=strftime("%d/%m/%Y %H:%M:%S",strtotime($fecha_modifica))." ".$nombres_usuario_mod." ".$ap_paterno_usuario_mod;
					}
				// Fin Obteniendo Fecha de Registro		
					
?> 								
 

		<tr bgcolor="#FFFFFF" class="text">	
				<td align="left"><strong><?php echo strftime("%d/%m/%Y",strtotime($fecha_cbte));?></strong></td>
                <td align="left"><?php echo $nombre_tipo_cbte;?></td>				
                <td align="left"><a href="../reportes/impresionComprobante.php?cod_cbte=<?php echo $cod_cbte;?>" target="_blank"><?php echo $nro_cbte."/".$gestion_nombre;?></a></td>
				<td align="left">				
				<?php
				if($cod_tipo_cbte==2){
				?>
				<table border="0">
				<?php
					 $sql2=" select cd.cod_cbte_detalle,cd.cod_cuenta,cu.nro_cuenta, cu.desc_cuenta,cd.nro_factura,cd.fecha_factura, ";
 				 	 $sql2.=" cd.dias_venc_factura,cd.glosa, cd.debe, cd.haber, cd.debe_sus, cd.haber_sus, cd.id_pago, cd.id_pago_detalle,";
					 $sql2.=" ppd.cod_tipo_doc,ppd.codigo_doc,p.nombre_proveedor";
					 $sql2.=" from comprobante_detalle cd";
					 $sql2.=" left join cuentas cu on(cd.cod_cuenta=cu.cod_cuenta)";
					 $sql2.=" left join pago_proveedor_detalle ppd on( cd.id_pago=ppd.cod_pago_prov and cd.id_pago_detalle=ppd.cod_pago_prov_detalle) ";
					 $sql2.=" left join pago_proveedor pp on( pp.cod_pago_prov=ppd.cod_pago_prov) ";
					 $sql2.=" left join proveedores p on( pp.cod_proveedor=p.cod_proveedor) ";					 
					 $sql2.=" where cd.cod_cbte=".$cod_cbte;
					 $sql2.=" order by  cod_cbte_detalle asc";
					 //echo $sql2;
					 $resp2=mysql_query($sql2);
					 while ($dat2=mysql_fetch_array($resp2)){
					 		$cod_cbte_detalle=$dat2['cod_cbte_detalle'];
							$cod_cuenta=$dat2['cod_cuenta'];
							$nro_cuenta=$dat2['nro_cuenta'];
							$desc_cuenta=$dat2['desc_cuenta'];
							$nro_factura=$dat2['nro_factura'];
							$fecha_factura=$dat2['fecha_factura'];
 				 	 		$dias_venc_factura=$dat2['dias_venc_factura'];
							$glosa2=$dat2['glosa'];
							$debe=$dat2['debe'];
							$haber=$dat2['haber'];
							$debe_sus=$dat2['debe_sus'];
							$haber_sus=$dat2['haber_sus'];
							$id_pago=$dat2['id_pago'];
							$id_pago_detalle=$dat2['id_pago_detalle'];
					 		$cod_tipo_doc=$dat2['cod_tipo_doc'];
							$codigo_doc=$dat2['codigo_doc'];
							$nombre_proveedor=$dat2['nombre_proveedor'];
						?>
						<tr><td><?php echo $nro_cuenta;?></td> <td><?php echo $desc_cuenta;?></td><td><?php echo $nombre_cliente;?></td>
						<td><?php echo $debe;?></td><td><?php echo $haber;?></td>
						<?php
							//Hoja de Ruta
						if($cod_tipo_doc==1){
							$sql3=" select hr.cod_hoja_ruta,hr.nro_hoja_ruta,g.gestion_nombre, hr.fecha_hoja_ruta ";
							$sql3.=" from hojas_rutas hr left join gestiones g on (hr.cod_gestion=g.cod_gestion) ";
							$sql3.=" where hr.cod_hoja_ruta=".$codigo_doc;
							$resp3=mysql_query($sql3);
							while ($dat3=mysql_fetch_array($resp3)){
								$cod_hoja_ruta=$dat3['cod_hoja_ruta'];
								$nro_hoja_ruta=$dat3['nro_hoja_ruta']." / ".$dat3['gestion_nombre']."( ".strftime("%d/%m/%Y",strtotime($dat3['fecha_hoja_ruta'])).")";									
					 		}
					?>
						<td><a href="../reportes/impresionHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta; ?>" target="_blank"><?php echo  $nro_hoja_ruta;?></a></td>		
  					<?php
						}
							//Orden Trabajo
						if($cod_tipo_doc==2){
						    $sql3=" select ot.cod_orden_trabajo,ot.nro_orden_trabajo,g.gestion_nombre, ot.fecha_orden_trabajo ";
							$sql3.=" from ordentrabajo ot left join gestiones g on (ot.cod_gestion=g.cod_gestion) ";
							$sql3.=" where ot.cod_orden_trabajo=".$codigo_doc;
							$resp3=mysql_query($sql3);
							while ($dat3=mysql_fetch_array($resp3)){
								$cod_orden_trabajo=$dat3['cod_orden_trabajo'];
								$nro_orden_trabajo=$dat3['nro_orden_trabajo']." / ".$dat3['gestion_nombre']."( ".strftime("%d/%m/%Y",strtotime($dat3['fecha_orden_trabajo'])).")";									
					 		}
						?>
							<td><a href="../reportes/impresionOrdenTrabajo.php?cod_orden_trabajo=<?php echo $cod_orden_trabajo; ?>" target="_blank"><?php echo  $nro_orden_trabajo;?></a></td>		
	  					<?php														
							}
							//Venta
							if($cod_tipo_doc==3){
							$sql3=" select s.cod_salida,s.nro_salida,g.gestion_nombre, s.fecha_salida ";
							$sql3.=" from salidas s left join gestiones g on (s.cod_gestion=g.cod_gestion) ";
							$sql3.=" where s.cod_salida=".$codigo_doc;
							$resp3=mysql_query($sql3);
							while ($dat3=mysql_fetch_array($resp3)){
								$cod_salida=$dat3['cod_salida'];
								$nro_salida=$dat3['nro_salida']." / ".$dat3['gestion_nombre']."( ".strftime("%d/%m/%Y",strtotime($dat3['fecha_salida'])).")";									
					 		}
						?>
							<td><a href="../almacenes/detalleSalida.php?cod_salida=<?php echo $cod_salida; ?>" target="_blank"><?php echo  $nro_salida;?></a></td>		
	  					<?php								
							}
							//Ingresos
							if($cod_tipo_doc==4){
								$sql3=" select i.cod_ingreso, i.nro_ingreso ,g.gestion_nombre, i.fecha_ingreso ";
								$sql3.=" from ingresos i left join gestiones g on (i.cod_gestion=g.cod_gestion) ";
								$sql3.=" where i.cod_ingreso=".$codigo_doc;
								$resp3=mysql_query($sql3);
								while ($dat3=mysql_fetch_array($resp3)){
									$cod_ingreso=$dat3['cod_ingreso'];
									$nro_ingreso=$dat3['nro_ingreso']." / ".$dat3['gestion_nombre']."( ".strftime("%d/%m/%Y",strtotime($dat3['fecha_ingreso'])).")";									
					 			}
						?>
							<td><a href="../almacenes/detalleIngreso.php?cod_ingreso=<?php echo $cod_ingreso; ?>" target="_blank"><?php echo  $nro_ingreso;?></a></td>		
	  					<?php								
							}
							//Gastos
							if($cod_tipo_doc==5){
								$sql3=" select gg.cod_gasto_gral, gg.nro_gasto_gral ,g.gestion_nombre, gg.fecha_gasto_gral ";
								$sql3.=" from gastos_gral gg left join gestiones g on (gg.cod_gestion=g.cod_gestion) ";
								$sql3.=" where gg.cod_gasto_gral=".$codigo_doc;
							//	echo $sql3;
								$resp3=mysql_query($sql3);
								while ($dat3=mysql_fetch_array($resp3)){
									$cod_gasto_gral=$dat3['cod_gasto_gral'];
									$nro_gasto_gral=$dat3['nro_gasto_gral']." / ".$dat3['gestion_nombre']."( ".strftime("%d/%m/%Y",strtotime($dat3['fecha_gasto_gral'])).")";									
					 			}
						?>
							<td><a href="vistaGastoGral.php?cod_gasto_gral=<?php echo $cod_gasto_gral; ?>" target="_blank"><?php echo  $nro_gasto_gral;?></a></td>		
	  					<?php							
							}
						?>
						</tr>																												
						<?php
					 }
					 ?>
					 </table>
					 <?php
				}
				?>
<?php
				if($cod_tipo_cbte==3){
				?>
				<table border="0">
				<?php
					 $sql2=" select cd.cod_cbte_detalle,cd.cod_cuenta,cu.nro_cuenta, cu.desc_cuenta,cd.nro_factura,cd.fecha_factura, ";
 				 	 $sql2.=" cd.dias_venc_factura,cd.glosa, cd.debe, cd.haber, cd.debe_sus, cd.haber_sus, cd.id_pago, cd.id_pago_detalle,";
					 $sql2.=" pd.cod_tipo_doc,pd.codigo_doc,cli.nombre_cliente";
					 $sql2.=" from comprobante_detalle cd";
					 $sql2.=" left join cuentas cu on(cd.cod_cuenta=cu.cod_cuenta)";
					 $sql2.=" left join pagos_detalle pd on( cd.id_pago=pd.cod_pago and cd.id_pago_detalle=pd.cod_pago_detalle) ";
					 $sql2.=" left join pagos p on( p.cod_pago=pd.cod_pago) ";
					 $sql2.=" left join clientes cli on( cli.cod_cliente=p.cod_cliente) ";					 
					 $sql2.=" where cd.cod_cbte=".$cod_cbte;
					// echo $sql2;
					 $sql2.=" order by  cod_cbte_detalle asc";
					 $resp2=mysql_query($sql2);
					 while ($dat2=mysql_fetch_array($resp2)){
					 		$cod_cbte_detalle=$dat2['cod_cbte_detalle'];
							$cod_cuenta=$dat2['cod_cuenta'];
							$nro_cuenta=$dat2['nro_cuenta'];
							$desc_cuenta=$dat2['desc_cuenta'];
							$nro_factura=$dat2['nro_factura'];
							$fecha_factura=$dat2['fecha_factura'];
 				 	 		$dias_venc_factura=$dat2['dias_venc_factura'];
							$glosa2=$dat2['glosa'];
							$debe=$dat2['debe'];
							$haber=$dat2['haber'];
							$debe_sus=$dat2['debe_sus'];
							$haber_sus=$dat2['haber_sus'];
							$id_pago=$dat2['id_pago'];
							$id_pago_detalle=$dat2['id_pago_detalle'];
					 		$cod_tipo_doc=$dat2['cod_tipo_doc'];
							$codigo_doc=$dat2['codigo_doc'];
							$nombre_cliente=$dat2['nombre_cliente'];
						?>
												<tr><td><?php echo $nro_cuenta;?></td> <td><?php echo $desc_cuenta;?></td><td><?php echo $nombre_cliente;?></td>
						<td><?php echo $debe;?></td><td><?php echo $haber;?></td>
						<?php
							//Hoja de Ruta
						if($cod_tipo_doc==1){
							$sql3=" select hr.cod_hoja_ruta,hr.nro_hoja_ruta,g.gestion_nombre, hr.fecha_hoja_ruta ";
							$sql3.=" from hojas_rutas hr left join gestiones g on (hr.cod_gestion=g.cod_gestion) ";
							$sql3.=" where hr.cod_hoja_ruta=".$codigo_doc;
							$resp3=mysql_query($sql3);
							while ($dat3=mysql_fetch_array($resp3)){
								$cod_hoja_ruta=$dat3['cod_hoja_ruta'];
								$nro_hoja_ruta=$dat3['nro_hoja_ruta']." / ".$dat3['gestion_nombre']."( ".strftime("%d/%m/%Y",strtotime($dat3['fecha_hoja_ruta'])).")";									
					 		}
					?>
						<td><a href="../reportes/impresionHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta; ?>" target="_blank"><?php echo  $nro_hoja_ruta;?></a></td>		
  					<?php
						}
							//Orden Trabajo
						if($cod_tipo_doc==2){
						    $sql3=" select ot.cod_orden_trabajo,ot.nro_orden_trabajo,g.gestion_nombre, ot.fecha_orden_trabajo ";
							$sql3.=" from ordentrabajo ot left join gestiones g on (ot.cod_gestion=g.cod_gestion) ";
							$sql3.=" where ot.cod_orden_trabajo=".$codigo_doc;
							$resp3=mysql_query($sql3);
							while ($dat3=mysql_fetch_array($resp3)){
								$cod_orden_trabajo=$dat3['cod_orden_trabajo'];
								$nro_orden_trabajo=$dat3['nro_orden_trabajo']." / ".$dat3['gestion_nombre']."( ".strftime("%d/%m/%Y",strtotime($dat3['fecha_orden_trabajo'])).")";									
					 		}
						?>
							<td><a href="../reportes/impresionOrdenTrabajo.php?cod_orden_trabajo=<?php echo $cod_orden_trabajo; ?>" target="_blank"><?php echo  $nro_orden_trabajo;?></a></td>		
	  					<?php														
							}
							//Venta
							if($cod_tipo_doc==3){
							$sql3=" select s.cod_salida,s.nro_salida,g.gestion_nombre, s.fecha_salida ";
							$sql3.=" from salidas s left join gestiones g on (s.cod_gestion=g.cod_gestion) ";
							$sql3.=" where s.cod_salida=".$codigo_doc;
							$resp3=mysql_query($sql3);
							while ($dat3=mysql_fetch_array($resp3)){
								$cod_salida=$dat3['cod_salida'];
								$nro_salida=$dat3['nro_salida']." / ".$dat3['gestion_nombre']."( ".strftime("%d/%m/%Y",strtotime($dat3['fecha_salida'])).")";									
					 		}
						?>
							<td><a href="../almacenes/detalleSalida.php?cod_salida=<?php echo $cod_salida; ?>" target="_blank"><?php echo  $nro_salida;?></a></td>		
	  					<?php								
							}
							//Ingresos
							if($cod_tipo_doc==4){
								$sql3=" select i.cod_ingreso, i.nro_ingreso ,g.gestion_nombre, i.fecha_ingreso ";
								$sql3.=" from ingresos i left join gestiones g on (i.cod_gestion=g.cod_gestion) ";
								$sql3.=" where i.cod_ingreso=".$codigo_doc;
								$resp3=mysql_query($sql3);
								while ($dat3=mysql_fetch_array($resp3)){
									$cod_ingreso=$dat3['cod_ingreso'];
									$nro_ingreso=$dat3['nro_ingreso']." / ".$dat3['gestion_nombre']."( ".strftime("%d/%m/%Y",strtotime($dat3['fecha_ingreso'])).")";									
					 			}
						?>
							<td><a href="../almacenes/detalleIngreso.php?cod_ingreso=<?php echo $cod_ingreso; ?>" target="_blank"><?php echo  $nro_ingreso;?></a></td>		
	  					<?php								
							}
							//Gastos
							if($cod_tipo_doc==5){
								$sql3=" select gg.cod_gasto_gral, gg.nro_gasto_gral ,g.gestion_nombre, gg.fecha_gasto_gral ";
								$sql3.=" from gastos_gral gg left join gestiones g on (gg.cod_gestion=g.cod_gestion) ";
								$sql3.=" where i.cod_ingreso=".$codigo_doc;
								$resp3=mysql_query($sql3);
								while ($dat3=mysql_fetch_array($resp3)){
									$cod_gasto_gral=$dat3['cod_gasto_gral'];
									$nro_gasto_gral=$dat3['nro_gasto_gral']." / ".$dat3['gestion_nombre']."( ".strftime("%d/%m/%Y",strtotime($dat3['fecha_gasto_gral'])).")";									
					 			}
						?>
							<td><a href="vistaGastoGral.php?cod_gasto_gral=<?php echo $cod_gasto_gral; ?>" target="_blank"><?php echo  $nro_gasto_gral;?></a></td>			
	  					<?php							
							}
						?>
						</tr>																												
						<?php
					 }
					 ?>
					 </table>
					 <?php
				}
				?>				
				</td>
                <td align="left"><?php echo $nro_cheque." ".$nro_factura;?></td>
                <td align="left"><?php echo $glosa;?></td>
                <td align="left"><?php echo $nombre_estado_cbte;?></td>
                <td align="left"><?php echo $usuario_registro;?></td>
                <td align="left"><?php echo $usuario_modifica;?></td>
                <td align="left"><a href="editComprobante.php?cod_cbte=<?php echo $cod_cbte;?>">Editar</a></td> 
				<td align="left">
				<?php if($cod_estado_cbte<>2){
					$sqlAux=" select cod_perfil from usuarios where cod_usuario=".$_COOKIE['usuario_global'];
					$respAux = mysql_query($sqlAux);
					while($datAux=mysql_fetch_array($respAux)){
						$cod_perfil=$datAux['cod_perfil'];
					}
				if($cod_perfil==1){
			?>
				<a href="javascript:anular(<?php echo $cod_cbte; ?>,'<?php echo $nro_cbte."/".$gestion_nombre; ?>')" >Anular</a> 
			<?php			
			}else{
			 	if(suma_fechas(strftime("%Y-%m-%d",strtotime($fecha_registro)),2)>(date('Y-m-d', time()))){
				?>
				<a href="javascript:anular(<?php echo $cod_cbte; ?>,'<?php echo $nro_cbte."/".$gestion_nombre; ?>')" >Anular</a> 
			<?php
				}
			}
			}else{
			 echo "Anular";
			}
          ?>
			 </td>               
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
 <th align="left">Tipo Cbte.:</th>
      		<td><select name="codtipocbteB" id="codtipocbteB" class="textoform" onChange="buscar()">		
	            <option value="0">Todos</option>		
				<?php
					$sql2="select cod_tipo_cbte, nombre_tipo_cbte from tipo_comprobante ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_tipo_cbte=$dat2['cod_tipo_cbte'];		
			  		 		$nombre_tipo_cbte=$dat2['nombre_tipo_cbte'];	
				 ?><option value="<?php echo $cod_tipo_cbte;?>" <?php if($cod_tipo_cbte==$_GET['codtipocbteB']){?> selected="selected" <?php }?>><?php echo $nombre_tipo_cbte;?></option>				
				<?php		
					}
				?>						
			</select></td> 
<th align="left"><strong>Nro de Cbte: </strong></th>
<td ><input type="text" name="nrocbteB" id="nrocbteB" size="20" class="textoform" value="<?php echo $_GET['nrocbteB'];?>" onkeyup="buscar()" ></td>
			
</tr>
<tr>
<th align="left"><strong>De: </strong></th>
<td><input type="text" name="nombreB" id="nombreB" size="30" class="textoform" value="<?php echo $_GET['nombreB'];?>" onkeyup="buscar()" ></td>
<th align="left"><strong>Glosa: </strong></th>
<td><input type="text" name="glosaB" id="glosaB" size="30" class="textoform" value="<?php echo $_GET['glosaB'];?>" onkeyup="buscar()" ></td>
</tr>
    <tr bgcolor="#FFFFFF">
     <th align="left">Rango de Fechas: </th>
     <td colspan="3"><strong>De</strong>&nbsp;
                <input type="text" name="fechaInicioB" id="fechaInicioB" class="textoform" value="<?php echo $_GET['fechaInicioB']; ?>"><strong>Hasta</strong><input type="text" name="fechaFinalB" id="fechaFinalB" class="textoform" value="<?php echo $_GET['fechaFinalB']; ?>" >
<input type="checkbox" name="codActivoFecha" id="codActivoFecha" <?php if($codActivoFecha=="on"){?>checked="checked"<?php }?> onClick="buscar()" ><strong>Chekear la casilla para buscar por fechas.</strong>	   
     </td>
</tr>
<tr>
<th align="left"><strong>Cuenta: </strong></th>
<td ><input type="text" name="cuentaB" id="cuentaB" size="30" class="textoform" value="<?php echo $_GET['cuentaB'];?>" onkeyup="buscar()" ></td>
<th align="left"><strong>Glosa Detalle: </strong></th>
<td ><input type="text" name="glosaDetB" id="glosaDetB" size="30" class="textoform" value="<?php echo $_GET['glosaDetB'];?>" onkeyup="buscar()" ></td>
</tr>
<tr>
<th align="left"><strong>Tipo Documento: </strong></th>
<td><select name="codtipodocB" id="codtipodocB" onchange="buscar();" class="textoform">
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
                 <option value="<?php echo $cod_tipo_doc;?>" <?php if($_GET['codtipodocB']==$cod_tipo_doc){?> selected="selected" <?php } ?>><?php echo utf8_decode($desc_tipo_doc);?></option>				
				<?php		
					}
				?>						
			</select></td>
<th align="left"><strong>Nro Documento: </strong></th>
<td><input type="text" name="nroDocB" id="nroDocB" size="10" value="<?php echo $nroDocB;?>" class="textoform" onkeyup="buscar()" ></td>
</tr>
<tr>
<th align="left"><strong>Cliente: </strong></th>
<td><input type="text" name="clienteB" id="clienteB" size="30" class="textoform" value="<?php echo $_GET['clienteB'];?>" onkeyup="buscar()" ></td>
<th align="left"><strong>Proveedor: </strong></th>
<td><input type="text" name="proveedorB" id="proveedorB" size="30" class="textoform" value="<?php echo $_GET['proveedorB'];?>" onkeyup="buscar()" ></td>
</tr>
</table>
<table border="0" align="center" width="89%">
<tr><td align="right">
<div align="right"><a href="newComprobante.php" class="btn btn-warning"><i class="fa fa-plus"></i>Nuevo Comprobante</a></div>
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


</form>
</body>
</html>
