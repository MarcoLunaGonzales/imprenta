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
<script language='Javascript'>
	function cancelar(f){
			window.location="listGastosGral.php";
	}
	function guardar(f){
		if(f.cod_proveedor.value==""){
			alert("El campo Proveedor se encuentra vacio.")
			f.cod_proveedor.focus();
		 	return(false);
			
		}
		if(f.monto_gasto_gral.value==""){
			alert("El campo Monto se encuentra vacio.")
			f.monto_gasto_gral.focus();
		 	return(false);
			
		}
		f.submit();
	}
	
function nuevoAjax()
{	var xmlhttp=false;
 		try {
 			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	 	} catch (e) {
 			try {
 				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
 			} catch (E) {
 				xmlhttp = false;
 			}
	  	}
		if (!xmlhttp && typeof XMLHttpRequest!="undefined") {
 			xmlhttp = new XMLHttpRequest();
		}
		return xmlhttp;
}
function buscarDocumento(){
		izquierda = (screen.width) ? (screen.width-600)/2 : 100 
	    arriba = (screen.height) ? (screen.height-400)/2 : 100 
		url="ajax_listDocumento.php";
opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=650,left='+izquierda+',top=' + arriba + '' 
	   	window.open(url, 'popUp', opciones);
}
function setDocumento(cod_tipod_doc,codigo_doc,descripcion){
	document.getElementById('cod_tipo_doc').value=cod_tipod_doc;
	document.getElementById('codigo_doc').value=codigo_doc;
	document.getElementById('desc_documento').value=descripcion;	
	
}

function eliminarDocumento(){
	document.getElementById('cod_tipo_doc').value=null;
	document.getElementById('codigo_doc').value=null;
	document.getElementById('desc_documento').value="";	
}	

function buscarProveedor(){
		izquierda = (screen.width) ? (screen.width-600)/2 : 100 
	    arriba = (screen.height) ? (screen.height-400)/2 : 100 
		url="ajax_listProveedoresGral.php";
opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=650,left='+izquierda+',top=' + arriba + '' 
	   	window.open(url, 'popUp', opciones);
}
function setProveedor(cod_proveedor, proveedor){
	document.getElementById('nombre_proveedor').value=proveedor;
	document.getElementById('cod_proveedor').value=cod_proveedor;		
}

function eliminarProveedor(){
	document.getElementById('cod_proveedor').value=null;
	document.getElementById('nombre_proveedor').value="";	
}	


</script></head>
<body bgcolor="#FFFFFF" onload="document.form1.nro_recibo.focus()">


<form name="form1" id="form1" method="post" action="saveEditGastoGral.php">
<input type="hidden" id="cod_gasto_gral" name="cod_gasto_gral" value="<?php echo $_GET['cod_gasto_gral']; ?>">
<?php


	$sql=" select cod_gestion, nro_gasto_gral,codigo_doc,cod_tipo_doc,";
	$sql.=" cod_proveedor,fecha_gasto_gral,nro_recibo,monto_gasto_gral,cant_gasto_gral,";
	$sql.=" desc_gasto_gral,cod_gasto,cod_estado_pago_doc,cod_tipo_pago,fecha_registro,";
	$sql.=" cod_usuario_registro, fecha_modifica, cod_usuario_modifica,";
	$sql.=" cod_estado, cod_usuario_anulacion, fecha_anulacion, obs_anulacion";
	$sql.=" from gastos_gral";
	$sql.=" where cod_gasto_gral=".$_GET['cod_gasto_gral'];
	$resp=mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
	
		$cod_gestion=$dat['cod_gestion']; 
		$nro_gasto_gral=$dat['nro_gasto_gral'];
		$codigodoc=$dat['codigo_doc'];
		$codtipodoc=$dat['cod_tipo_doc'];
		$codproveedor=$dat['cod_proveedor'];
		$fecha_gasto_gral=$dat['fecha_gasto_gral'];
		$nro_recibo=$dat['nro_recibo'];
		$monto_gasto_gral=$dat['monto_gasto_gral'];
		$cant_gasto_gral=$dat['cant_gasto_gral'];
		$desc_gasto_gral=$dat['desc_gasto_gral'];
		$codgasto=$dat['cod_gasto'];
		$cod_estado_pago_doc=$dat['cod_estado_pago_doc'];
		$codtipopago=$dat['cod_tipo_pago'];
		$fecha_registro=$dat['fecha_registro'];
		$cod_usuario_registro=$dat['cod_usuario_registro'];
		$fecha_modifica=$dat['fecha_modifica'];
		$cod_usuario_modifica=$dat['cod_usuario_modifica'];
		$cod_estado=$dat['cod_estado'];
		$cod_usuario_anulacion=$dat['cod_usuario_anulacion'];
		$fecha_anulacion=$dat['fecha_anulacion'];
		$obs_anulacion=$dat['obs_anulacion'];
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
$datosAnulacion=""; 
			if($cod_usuario_anulacion!="" || $cod_usuario_anulacion!=NULL){
				$datosEdicion=strftime("%d/%m/%Y %H:%M:%S",strtotime($fecha_anulacion));
				$sqlAux="select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios where cod_usuario=".$cod_usuario_anulacion;
				$respAux = mysql_query($sqlAux);
				while($datAux=mysql_fetch_array($respAux)){
					$datosAnulacion=$datosAnulacion." ".$datAux['nombres_usuario']." ".$datAux['ap_paterno_usuario'];

				}
			}						
	}

 	$sql2="select gestion_nombre from gestiones where cod_gestion=".$cod_gestion;
	$resp2=mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2)){
		$gestion_nombre=$dat2['gestion_nombre'];
	}
	if($codproveedor<>"" and $codproveedor!=NULL){
		$sql="select nombre_proveedor  from proveedores where cod_proveedor=".$codproveedor;
		$resp=mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){
			$nombre_proveedor=$dat['nombre_proveedor'];
		}	
	}	
	$desc_documento="";
	$abrev_tipo_doc="";
	if($codtipodoc<>"" and $codtipodoc!=NULL){
		$sql="select abrev_tipo_doc  from tipo_documento where cod_tipo_doc=".$codtipodoc;
		$resp=mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){
			$abrev_tipo_doc=$dat['abrev_tipo_doc'];
		}	
	}
	if($codtipodoc==1){
		$sql=" select hr.nro_hoja_ruta, hr.fecha_hoja_ruta,c.cod_cliente, cli.nombre_cliente,g.gestion_nombre ";
		$sql.=" from hojas_rutas hr ";
		$sql.=" left join cotizaciones c on(c.cod_cotizacion=hr.cod_cotizacion)";
		$sql.=" left join  clientes cli on(c.cod_cliente=cli.cod_cliente)";
		$sql.=" left join  gestiones g on(hr.cod_gestion=g.cod_gestion)";
		$sql.=" where cod_hoja_ruta=".$codigodoc;
		$resp=mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){
			$desc_documento=$abrev_tipo_doc." ".$dat['nro_hoja_ruta']."/".$dat['gestion_nombre']." ".$dat['nombre_cliente']." (".strftime("%d/%m/%Y",strtotime($dat['fecha_hoja_ruta'])).")";
		}
	
	}
	if($codtipodoc==2){
		$sql=" select ot.nro_orden_trabajo, ot.fecha_orden_trabajo, cli.nombre_cliente,g.gestion_nombre ";
		$sql.=" from ordentrabajo ot ";
		$sql.=" left join  clientes cli on(ot.cod_cliente=cli.cod_cliente)";
		$sql.=" left join  gestiones g on(ot.cod_gestion=g.cod_gestion)";
		$sql.=" where cod_orden_trabajo=".$codigodoc;
		$resp=mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){
			$desc_documento=$abrev_tipo_doc." ".$dat['nro_orden_trabajo']."/".$dat['gestion_nombre']." ".$dat['nombre_cliente']." (".strftime("%d/%m/%Y",strtotime($dat['fecha_orden_trabajo'])).")";
		}
	
	}	


 ?>


<h3 align="center" style="background:#FFFFFF;font-size: 14px;color: #E78611;font-weight:bold;">Gasto Nro. <?php echo $nro_gasto_gral."/".$gestion_nombre;?></h3>

 <div id="resultados" align="center">   

    <table align="center"class="text" cellSpacing="1" cellPadding="4" width="75%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Introduzca Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td align="left">Nro Recibo</td>
      		<td align="left"><?php echo $nro_recibo;?></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha de Gasto</td>
      		<td align="left"><?php echo strftime("%d/%m/%Y",strtotime($fecha_gasto_gral));?></td>
    	</tr>  
 		 <tr bgcolor="#FFFFFF">
     		<td>Documento</td>
   		   <td><?php echo $desc_documento;?></td>
    	</tr>
		     
		 <tr bgcolor="#FFFFFF">
     		<td>Proveedor</td>
      		<td><?php echo $nombre_proveedor;?></td>
    	</tr>  
		<tr bgcolor="#FFFFFF">
		<td >Forma de Pago </td>
			<td >
				<?php
					$sql4="select nombre_tipo_pago from tipos_pago where cod_tipo_pago=".$codtipopago;
					$resp4=mysql_query($sql4);
						while($dat4=mysql_fetch_array($resp4))
						{
							echo $nombre_tipo_pago=$dat4['nombre_tipo_pago'];			
					}
				?>						
			</td>	
		  </tr>
		<tr bgcolor="#FFFFFF">
     		<td>Gasto</td>
      		<td align="left">
            <?php
            	$sql2="select cod_gasto, desc_gasto";
            	$sql2.=" from gastos  where cod_gasto=".$codgasto;
				$resp2 = mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					 echo $desc_gasto=$dat2['desc_gasto'];
			
				}				

			?></td>
    	</tr>		
		 <tr bgcolor="#FFFFFF">
     		<td>Descripcion</td>
      		<td align="left"><?php echo $desc_gasto_gral;?></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Cantidad</td>
      		<td align="left"><?php echo $cant_gasto_gral;?></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Monto</td>
      		<td align="left"><?php echo $monto_gasto_gral;?></td>
    	</tr>    
		<tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Datos de Sistema</td>
		 </tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha Registro</td>
      		<td align="left"><?php echo $datosRegistro;?></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Ultima Edicion</td>
      		<td align="left"><?php echo $datosEdicion;?></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha Anulacion</td>
      		<td align="left"><?php echo $datosAnulacion." ".$obs_anulacion;?></td>
    	</tr> 						             										
		</tbody>
	</table>
 </div>			

</div>	

<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
