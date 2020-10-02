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
		param+='nro_pago_provB='+document.form1.nro_pago_provB.value;
		param+='&nombre_proveedorB='+document.form1.nombre_proveedorB.value;
		param+='&cod_estado_pago_provB='+document.form1.cod_estado_pago_provB.value;
		param+='&cod_tipo_docB='+document.form1.cod_tipo_docB.value;
		param+='&nro_docB='+document.form1.nro_docB.value;
		param+='&nro_doc_externoB='+document.form1.nro_doc_externoB.value;
		param+='&codActivoFecha='+valorchecked;
		param+='&fechaInicioB='+document.form1.fechaInicioB.value;
		param+='&fechaFinalB='+document.form1.fechaFinalB.value;
		
	
		resultados_ajax('searchPagoProveedor.php'+param);

}
function paginar(f)
{	
if(document.form1.codActivoFecha.checked){
		valorchecked="on";
	}else{
		valorchecked="off";
	}
		var param="?";
		param+='nro_pago_provB='+document.form1.nro_pago_provB.value;
		param+='&nombre_proveedorB='+document.form1.nombre_proveedorB.value;
		param+='&cod_estado_pago_provB='+document.form1.cod_estado_pago_provB.value;
		param+='&cod_tipo_docB='+document.form1.cod_tipo_docB.value;
		param+='&nro_docB='+document.form1.nro_docB.value;
		param+='&nro_doc_externoB='+document.form1.nro_doc_externoB.value;
		param+='&codActivoFecha='+valorchecked;
		param+='&fechaInicioB='+document.form1.fechaInicioB.value;
		param+='&fechaFinalB='+document.form1.fechaFinalB.value;
		param+='&pagina='+document.form1.pagina.value;		
		resultados_ajax('searchPagoProveedor.php'+param);
		
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
		param+='nro_pago_provB='+document.form1.nro_pago_provB.value;
		param+='&nombre_proveedorB='+document.form1.nombre_proveedorB.value;
		param+='&cod_estado_pago_provB='+document.form1.cod_estado_pago_provB.value;
		param+='&cod_tipo_docB='+document.form1.cod_tipo_docB.value;
		param+='&nro_docB='+document.form1.nro_docB.value;
		param+='&nro_doc_externoB='+document.form1.nro_doc_externoB.value;
		param+='&codActivoFecha='+valorchecked;
		param+='&fechaInicioB='+document.form1.fechaInicioB.value;
		param+='&fechaFinalB='+document.form1.fechaFinalB.value;
		param+='&pagina='+document.form1.pagina1.value;		
		resultados_ajax('searchPagoProveedor.php'+param);
}
function anular(cod_pago_prov,nro_pago_prov)
{	

					msj=confirm('Esta seguro de Anular el Pago  No.'+nro_pago_prov);
					if(msj==true)
					{
						izquierda=(screen.width)?(screen.width-300)/2:100
						arriba=(screen.height)?(screen.height-400)/2:100
						//alert("cod_pago_prov="+cod_pago_prov+"&nro_pago_prov="+nro_pago_prov);
						url="anularPagoProv.php?cod_pago_prov="+cod_pago_prov+"&nro_pago_prov="+nro_pago_prov;
						opciones=" toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=1,resizable=0, width=500, height=280, left="+izquierda+" top="+arriba;
	
						window.open(url,'popUp',opciones)
				}
	
}

</script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#FFFFFF" onload="document.form1.nroPagoB.focus()" >
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->

<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">LISTADO DE PAGOS A PROVEEDOR 
    <a class="btn btn-warning btn-lg float-right text-white boton-filtro-iframe" href="#" data-toggle="modal" data-target="#filtroModal">
       <i class="fa fa-search"></i> BUSCAR REGISTROS
    </a>
</h3>
<form name="form1" method="post" >


    

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

		$sql=" select count(distinct(pp.cod_pago_prov)) ";
		$sql.=" from pago_proveedor_detalle ppd";
		$sql.=" left join pago_proveedor pp on(ppd.cod_pago_prov=pp.cod_pago_prov)";
		$sql.=" left join proveedores p on (pp.cod_proveedor=p.cod_proveedor)";
		$sql.=" left join gestiones g on(pp.cod_gestion=g.cod_gestion)";
		$sql.=" left join estado_pago_proveedor epp on(pp.cod_estado_pago_prov=epp.cod_estado_pago_prov)";
		$sql.=" left join usuarios u on(pp.cod_usuario_registro=u.cod_usuario)";
		$sql.=" left join usuarios um on(pp.cod_usuario_modifica=um.cod_usuario)";
		$sql.=" left join usuarios ua on(pp.cod_usuario_modifica=ua.cod_usuario)";
		$sql.=" left join ingresos i on(ppd.cod_tipo_doc=4 and ppd.codigo_doc=i.cod_ingreso) ";
		$sql.=" left join gastos_gral gg on(ppd.cod_tipo_doc=5 and ppd.codigo_doc=gg.cod_gasto_gral) ";		
		$sql.=" where  ppd.cod_pago_prov_detalle<>0 ";
		if($_GET['nro_pago_provB']<>""){
			$sql.=" and CONCAT(pp.nro_pago_prov,'-',g.gestion_nombre) LIKE '%".$_GET['nro_pago_provB']."%' ";
		}	
		if($_GET['nombre_proveedorB']<>""){
			$sql.=" and p.nombre_proveedor LIKE '%".$_GET['nombre_proveedorB']."%' ";
		}	
		if($_GET['cod_estado_pago_provB']<>0){
			$sql.=" and pp.cod_estado_pago_prov=".$_GET['cod_estado_pago_provB']." ";
		}	
				if($_GET['cod_tipo_docB']<>0){
			$sql.=" and ppd.cod_tipo_doc =".$_GET['cod_tipo_docB'];
		}
		if($_GET['nro_docB']<>""){
			$sql.=" and (i.nro_ingreso like '%".$_GET['nro_docB']."%' or gg.nro_gasto_gral like '%".$_GET['nro_docB']."%')";
		}	
		if($_GET['nro_doc_externoB']<>""){
			$sql.=" and (i.nro_factura like '%".$_GET['nro_doc_externoB']."%' or gg.nro_recibo like '%".$_GET['nro_doc_externoB']."%')";
		}	
		if($codActivoFecha=="on"){
			$fechaInicioB=$_GET['fechaInicioB'];
			$fechaFinalB=$_GET['fechaFinalB'];
			if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);
				
				$sql.=" and pp.fecha_pago_prov>='".$aI."-".$mI."-".$dI."' and pp.fecha_pago_prov<='".$aF."-".$mF."-".$dF."' ";

			}
		}
		//echo $sql;
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
		$sql=" select DISTINCT(pp.cod_pago_prov), pp.cod_proveedor, p.nombre_proveedor, pp.nro_pago_prov,";
		$sql.=" pp.cod_gestion, g.gestion_nombre, pp.fecha_pago_prov, pp.cod_estado_pago_prov,";
		$sql.=" epp.desc_estado_pago_prov, pp.cod_usuario_pago_prov, pp.obs_pago_prov, pp.monto_pago_prov, pp.fecha_registro,";
		$sql.=" pp.cod_usuario_registro, u.nombres_usuario as nombres_usuario_reg,u.ap_paterno_usuario as ap_paterno_usuario_reg, ";
		$sql.=" pp.fecha_modifica, pp.cod_usuario_modifica, um.nombres_usuario as nombres_usuario_mod, um.ap_paterno_usuario as ap_paterno_usuario_mod,";
		$sql.=" pp.obs_anulacion, pp.fecha_anulacion, pp.cod_usuario_anulacion,";
		$sql.=" ua.nombres_usuario as nombres_usuario_anu, ua.ap_paterno_usuario as ap_paterno_usuario_anu,pp.cod_cbte";
		$sql.=" from pago_proveedor_detalle ppd";
		$sql.=" left join pago_proveedor pp on(ppd.cod_pago_prov=pp.cod_pago_prov)";
		$sql.=" left join proveedores p on (pp.cod_proveedor=p.cod_proveedor)";
		$sql.=" left join gestiones g on(pp.cod_gestion=g.cod_gestion)";
		$sql.=" left join estado_pago_proveedor epp on(pp.cod_estado_pago_prov=epp.cod_estado_pago_prov)";
		$sql.=" left join usuarios u on(pp.cod_usuario_registro=u.cod_usuario)";
		$sql.=" left join usuarios um on(pp.cod_usuario_modifica=um.cod_usuario)";
		$sql.=" left join usuarios ua on(pp.cod_usuario_modifica=ua.cod_usuario)";
		$sql.=" left join ingresos i on(ppd.cod_tipo_doc=4 and ppd.codigo_doc=i.cod_ingreso) ";
		$sql.=" left join gastos_gral gg on(ppd.cod_tipo_doc=5 and ppd.codigo_doc=gg.cod_gasto_gral) ";
		$sql.=" where  ppd.cod_pago_prov_detalle<>0 ";
		if($_GET['nro_pago_provB']<>""){
			$sql.=" and CONCAT(pp.nro_pago_prov,'-',g.gestion_nombre) LIKE '%".$_GET['nro_pago_provB']."%' ";
		}	
		if($_GET['nombre_proveedorB']<>""){
			$sql.=" and p.nombre_proveedor LIKE '%".$_GET['nombre_proveedorB']."%' ";
		}	
		if($_GET['cod_estado_pago_provB']<>0){
			$sql.=" and pp.cod_estado_pago_prov=".$_GET['cod_estado_pago_provB']." ";
		}	
				if($_GET['cod_tipo_docB']<>0){
			$sql.=" and ppd.cod_tipo_doc =".$_GET['cod_tipo_docB'];
		}
		if($_GET['nro_docB']<>""){
			$sql.=" and (i.nro_ingreso like '%".$_GET['nro_docB']."%' or gg.nro_gasto_gral like '%".$_GET['nro_docB']."%')";
		}	
		if($_GET['nro_doc_externoB']<>""){
			$sql.=" and (i.nro_factura like '%".$_GET['nro_doc_externoB']."%' or gg.nro_recibo like '%".$_GET['nro_doc_externoB']."%')";
		}	

		if($codActivoFecha=="on"){
			$fechaInicioB=$_GET['fechaInicioB'];
			$fechaFinalB=$_GET['fechaFinalB'];
			if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);
				
				$sql.=" and pp.fecha_pago_prov>='".$aI."-".$mI."-".$dI."' and pp.fecha_pago_prov<='".$aF."-".$mF."-".$dF."' ";

			}
		}
		
		$sql.=" order  by pp.fecha_pago_prov desc,pp.nro_pago_prov desc ";
		//echo $sql;
		$sql.=" limit 50";
		$resp = mysql_query($sql);

?>	
	<table width="90%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc" class="tablaReporte" style="width:100% !important;">
   <thead>
	    <tr height="20px" align="center"  class="bg-success text-white">
            <th>Nro de Pago</th>
			<th>Fecha Pago</th>
            <th>Proveedor</th>
            <th>Monto Total (Bs)</th>
            <th>Documentos</th>				
			<th>Observaciones</th>
            <th>Estado</th>
			<th>Fecha Registro</th>	
			<th>Ultima Edicion</th>	
			<th>&nbsp;</th>	
			<th>&nbsp;</th>	  
			<th>&nbsp;</th>	                  	            																	
		</tr>
		</thead>
   <tbody>
<?php   

	$cont=0;
		while($dat=mysql_fetch_array($resp)){
				$cod_pago_prov=$dat['cod_pago_prov'];
				$cod_proveedor=$dat['cod_proveedor'];
				$nombre_proveedor=$dat['nombre_proveedor'];
				$nro_pago_prov=$dat['nro_pago_prov'];
				$cod_gestion=$dat['cod_gestion'];
				$gestion_nombre=$dat['gestion_nombre'];
				$fecha_pago_prov=$dat['fecha_pago_prov'];
				$cod_estado_pago_prov=$dat['cod_estado_pago_prov'];
				$desc_estado_pago_prov=$dat['desc_estado_pago_prov'];
				$cod_usuario_pago_prov=$dat['cod_usuario_pago_prov'];
				$obs_pago_prov=$dat['obs_pago_prov'];
				$monto_pago_prov=$dat['monto_pago_prov'];
				$fecha_registro=$dat['fecha_registro'];
				$cod_usuario_registro=$dat['cod_usuario_registro'];
				$nombres_usuario_reg=$dat['nombres_usuario_reg'];
				$ap_paterno_usuario_reg=$dat['ap_paterno_usuario_reg'];
				$fecha_modifica=$dat['fecha_modifica'];
				$cod_usuario_modifica=$dat['cod_usuario_modifica'];
				$nombres_usuario_mod=$dat['nombres_usuario_mod'];
				$ap_paterno_usuario_mod=$dat['ap_paterno_usuario_mod'];
				$obs_anulacion=$dat['obs_anulacion'];
				$fecha_anulacion=$dat['fecha_anulacion'];
				$cod_usuario_anulacion=$dat['cod_usuario_anulacion'];
				$nombres_usuario_anu=$dat['nombres_usuario_anu'];
				$ap_paterno_usuario_anu=$dat['ap_paterno_usuario_anu'];
				$cod_cbte=$dat['cod_cbte'];
				////////////////////////////////				
	
?> 
		<tr bgcolor="#FFFFFF">	
    		<td align="right"><a href="viewPagoProv.php?cod_pago_prov=<?php echo $cod_pago_prov;?>" target="_blank"><?php echo $nro_pago_prov."/".$gestion_nombre;?></a></td>
    		<td align="right"><?php echo strftime("%d/%m/%Y",strtotime($fecha_pago_prov))." ". $nombres_usuario_reg." ".$ap_paterno_usuario_reg;?></td>
			<td><?php echo $nombre_proveedor; ?></td>            
            <td align="right">
            <?php 		
				echo $monto_pago_prov;
			?>
            </td> 
          	<td><?php
				$sql2=" select ppd.cod_pago_prov_detalle,ppd.codigo_doc, ppd.cod_tipo_doc, td.abrev_tipo_doc, ppd.monto_pago_prov_detalle, ";
				$sql2.=" i.nro_ingreso,gi.gestion_nombre as gestion_ingreso,gg.nro_gasto_gral,ggg.gestion_nombre as gestion_gasto_gral ";
				$sql2.=" from pago_proveedor_detalle ppd ";
				$sql2.=" left join ingresos i on(ppd.cod_tipo_doc=4 and ppd.codigo_doc=i.cod_ingreso)  ";
				$sql2.=" left join gestiones gi on(i.cod_gestion=gi.cod_gestion) ";
				$sql2.=" left join gastos_gral gg on(ppd.cod_tipo_doc=5 and ppd.codigo_doc=gg.cod_gasto_gral) ";
				$sql2.=" left join gestiones ggg on(gg.cod_gestion=ggg.cod_gestion)  ";
				$sql2.=" left join tipo_documento td on(ppd.cod_tipo_doc=td.cod_tipo_doc) ";
				$sql2.=" where cod_pago_prov=".$cod_pago_prov;
				$sql2.=" order by ppd.cod_pago_prov_detalle asc";
				$resp2 = mysql_query($sql2);
				$datos_documento="";
				while($dat2=mysql_fetch_array($resp2)){
					if($dat2['cod_tipo_doc']==4){
						$datos_documento=$dat2['abrev_tipo_doc']." ".$dat2['nro_ingreso']."/".$dat2['gestion_ingreso'];
					?>
					<a href="detalleIngreso.php?cod_ingreso=<?php echo $dat2['codigo_doc']; ?>" target="_blank"><?php echo $datos_documento;?> </a><br/>
					<?php
					}
					if($dat2['cod_tipo_doc']==5){
						$datos_documento=$dat2['abrev_tipo_doc']." ".$dat2['nro_gasto_gral']."/".$dat2['gestion_gasto_gral'];
					?>
					<a href="../contable/vistaGastoGral.php?cod_gasto_gral=<?php echo $dat2['codigo_doc']; ?>" target="_blank"><?php echo $datos_documento;?> </a><br/>
					<?php											
					}
				}

				$sqlAux=" select COUNT(*) ";
	 			$sqlAux.=" from comprobante_detalle cd left join comprobante c on( cd.cod_cbte=c.cod_cbte) ";
 				$sqlAux.=" where c.cod_tipo_cbte=2 and c.cod_estado_cbte<>2 ";
	 			$sqlAux.=" and cd.id_pago=".$cod_pago_prov;
				$respAux = mysql_query($sqlAux);
				$cantCbte=0;
				while($datAux=mysql_fetch_array($respAux)){
					$cantCbte=$datAux[0];
				}	
			?></td>    
            <td align="justify"><?php echo $obs_pago_prov; ?></td>      
    		<td align="right"><?php echo $desc_estado_pago_prov; ?></td>  
			<td align="center"><?php 
			if($cod_usuario_registro<>NULL and $cod_usuario_registro<>""){
			echo strftime("%d/%m/%Y %H:%M:%S",strtotime($fecha_registro))." ". $nombres_usuario_reg." ".$ap_paterno_usuario_reg;
			}
			?></td>
			<td align="center"><?php 
			if($cod_usuario_modifica<>NULL and $cod_usuario_modifica<>""){
			echo strftime("%d/%m/%Y %H:%M:%S",strtotime($fecha_modifica))." ". $nombres_usuario_mod." ".$ap_paterno_usuario_mod;
			}
			?></td>
            <td>
			
			 <?php	
			 //echo $cantCbte;
			 if($cantCbte==0){

			?>
			<a href="editPagoProveedor.php?cod_pago_prov=<?php echo $cod_pago_prov;?>">Editar</a>
						 <?php	}

			?>
			</td>  
            <td>			
            <?php	
											
			if($cod_estado_pago_prov<>2 and $cantCbte==0){

			?>
			
			<a href="javascript:anular(<?php echo $cod_pago_prov; ?>,'<?php echo $nro_pago_prov."/".$gestion_nombre; ?>')" >Anular</a> 
            <?php }else{?>
			Anular
			<?php }?>
            </td> 
            <td align="right"><?php 
			
				if($cod_cbte=="" || $cod_cbte==NULL ){
				
			?>
					<a href="../contable/newCbtePagoProv.php?cod_pago_prov=<?php echo $cod_pago_prov;?>">Generar Cbte</a>
			<?php
			 	}else{
			?>

			<?php			 

					$sqlAux2=" select c.nro_cbte, g.gestion_nombre from comprobante c left join gestiones g on(c.cod_gestion=g.cod_gestion) ";
 					$sqlAux2.=" where cod_cbte=".$cod_cbte;
					$respAux2 = mysql_query($sqlAux2);
					$datosCbte="";
					while($datAux2=mysql_fetch_array($respAux2)){
						$datosCbte=$datAux2['nro_cbte']."/".$datAux2['gestion_nombre'];
					}
						

			?>
			<a href="../reportes/impresionComprobante.php?cod_cbte=<?php echo $cod_cbte;?>" target="_blank"><?php echo $datosCbte;?></a>
			<?php
				}	
				
			 
			
				

			
			 ?></td> 
     					
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
<table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr class="texto">
          <th align="right" >Nro Pago Proveedor:</th>
          <td  align="left" colspan="5">
            <input type="text" name="nro_pago_provB" id="nro_pago_provB" class="textoform" size="20" value="<?php echo $_GET['nro_pago_provB'];?>" onkeyup="buscar()" />
        </td>
          </tr>

      <tr class="texto">
        <th align="right" >Proveedor:</th>
          <td align="left" colspan="5">
            <input type="text" name="nombre_proveedorB" id="nombre_proveedorB"  class="textoform" value="<?php echo $_GET['nombre_proveedorB'];?>" size="30" onkeyup="buscar()"/>
         </td>
      </tr>        
       <tr class="texto">
         <th  align="right" >Estado de Pago Proveedor:</th>
         <td  align="left" colspan="5">
		 <select name="cod_estado_pago_provB" id="cod_estado_pago_provB" onchange="buscar();" class="textoform">
				<option value="0">Elija un Opci&oacute;n</option>
				<?php
					$sql2=" select cod_estado_pago_prov, desc_estado_pago_prov";
					$sql2.=" from   estado_pago_proveedor ";
					$sql2.=" order by cod_estado_pago_prov asc ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_estado_pago_prov=$dat2['cod_estado_pago_prov'];	
			  		 		$desc_estado_pago_prov=$dat2['desc_estado_pago_prov'];	
				 ?>
                 <option value="<?php echo $cod_estado_pago_prov;?>" <?php if($_GET['cod_estado_pago_provB']==$cod_estado_pago_prov){?> selected="selected" <?php } ?>><?php echo utf8_decode($desc_estado_pago_prov);?></option>				
				<?php		
					}
				?>						
			</select></td>
       </tr>       
   <tr class="texto">
         <th  align="right" >Tipo de Doc:</th>
          <td  align="left">
            <select name="cod_tipo_docB" id="cod_tipo_docB" onchange="buscar();" class="textoform">
				<option value="0">Elija un Opci&oacute;n</option>
				<?php
					$sql2=" select cod_tipo_doc, desc_tipo_doc";
					$sql2.=" from   tipo_documento  where (cod_tipo_doc=4 or cod_tipo_doc=5)";
					$sql2.=" order by cod_tipo_doc asc ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_tipo_doc=$dat2['cod_tipo_doc'];	
			  		 		$desc_tipo_doc=$dat2['desc_tipo_doc'];	
				 ?>
                 <option value="<?php echo $cod_tipo_doc;?>" <?php if($_GET['cod_tipo_docB']==$cod_tipo_doc){?> selected="selected" <?php } ?>><?php echo utf8_decode($desc_tipo_doc);?></option>				
				<?php		
					}
				?>						
			</select>
			</td>
 <th  align="right" >Nro Doc:</th>
          <td  align="left">
            <input type="text" name="nro_docB" id="nro_docB"  class="textoform" size="20" value="<?php echo $_GET['nro_docB'];?>" onkeyup="buscar()"/></td>
 <th align="right" >Fact o Rec:</th>
          <td  align="left">
            <input type="text" name="nro_doc_externoB" id="nro_doc_externoB"  class="textoform" size="20" value="<?php echo $_GET['nro_doc_externoB'];?>" onkeyup="buscar()"/></td>						
       </tr>
            
       <tr class="texto">
         <th  align="right" >Rango de Fecha:</th>
          <td  align="left" colspan="5"><span id="sprytextfield6">
          <label for="fechaInicioB">De</label>
          <input type="text" name="fechaInicioB" id="fechaInicioB" class="textoform" value="<?php echo $_GET['fechaInicioB']; ?>" size="10" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span><span id="sprytextfield7">
          <label for="fechaFinalB">Hasta</label>
          <input type="text" name="fechaFinalB" id="fechaFinalB" class="textoform" value="<?php echo $_GET['fechaFinalB'];?>" size="10"  />
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

var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "date", {format:"dd/mm/yyyy"});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy"});

</script>
</body>
</html>


