<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>Hojas de Ruta</title>
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
if(document.form1.codActivoFecha.checked){
	valorchecked="on";
}else{
	valorchecked="off";
}

resultados_ajax('searchNotasRemision.php?nrocotizacionB='+document.form1.nrocotizacionB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&nroNotaRemisionB='+document.form1.nroNotaRemisionB.value+'&nroHojaRutaB='+document.form1.nroHojaRutaB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value);

}
function paginar(f)
{	
if(document.form1.codActivoFecha.checked){
	valorchecked="on";
}else{
	valorchecked="off";
}
	
	resultados_ajax('searchNotasRemision.php?nrocotizacionB='+document.form1.nrocotizacionB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&nroNotaRemisionB='+document.form1.nroNotaRemisionB.value+'&nroHojaRutaB='+document.form1.nroHojaRutaB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&pagina='+document.form1.pagina.value);

}
function paginar1(f,pagina)
{		
if(document.form1.codActivoFecha.checked){
	valorchecked="on";
}else{
	valorchecked="off";
}
		f.pagina.value=pagina*1;		
	resultados_ajax('searchNotasRemision.php?nrocotizacionB='+document.form1.nrocotizacionB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&nroNotaRemisionB='+document.form1.nroNotaRemisionB.value+'&nroHojaRutaB='+document.form1.nroHojaRutaB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&pagina='+document.form1.pagina.value);
}


function anularNotaRemision(cod_nota_remision)
{		
		if(confirm('Esta seguro de anular la Nota de Remision No'+cod_nota_remision)){
			location.href="anularNotaRemision.php?cod_nota_remision="+cod_nota_remision;	
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


?>
<h3 align="center" style="background:#FFFFFF;font-size: 14px;color: #E78611;font-weight:bold;">LISTADO DE NOTAS DE REMISION
   <a class="btn btn-warning btn-lg float-right text-white boton-filtro-iframe" href="#" data-toggle="modal" data-target="#filtroModal">
       <i class="fa fa-search"></i> BUSCAR REGISTROS
    </a>
</h3>



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
	

	
		$sql=" select count(*)";
		$sql.=" from notas_remision nr, gestiones g";
		$sql.=" where  nr.cod_gestion=g.cod_gestion";
		if($_GET['nroNotaRemisionB']<>""){
			$sql.=" and CONCAT(nr.nro_nota_remision,'/',g.gestion) LIKE '%".$_GET['nroHojaRutaB']."%' ";
		}
		
		if($_GET['nroHojaRutaB']<>""){
			$sql.=" and nr.cod_hoja_ruta in(select hojas_rutas.cod_hoja_ruta from hojas_rutas, gestiones ";
			$sql.=" where hojas_rutas.cod_gestion=gestiones.cod_gestion and  CONCAT(hojas_rutas.nro_hoja_ruta,'/',gestiones.gestion) LIKE '%".$_GET['nroHojaRutaB']."%' )";
		}
		
		if($_GET['nrocotizacionB']<>""){
			$sql.=" and nr.cod_hoja_ruta in(select hojas_rutas.cod_hoja_ruta ";
			$sql.=" from hojas_rutas, cotizaciones, gestiones ";
			$sql.=" where hojas_rutas.cod_cotizacion=cotizaciones.cod_cotizacion ";
			$sql.=" and cotizaciones.cod_gestion=gestiones.cod_gestion ";
			$sql.=" and  CONCAT(cotizaciones.nro_cotizacion,'/',gestiones.gestion) LIKE '%".$_GET['nrocotizacionB']."%')";
		}	

		if($_GET['nombreClienteB']<>""){
			$sql.=" and nr.cod_hoja_ruta in(select hojas_rutas.cod_hoja_ruta ";
			$sql.=" from hojas_rutas, cotizaciones, clientes";
			$sql.=" where hojas_rutas.cod_cotizacion=cotizaciones.cod_cotizacion ";
			$sql.=" and cotizaciones.cod_cliente=clientes.cod_cliente";
			$sql.=" and  clientes.nombre_cliente LIKE '".$_GET['nombreClienteB']."%')";
		}			

		if($codActivoFecha=="on"){
			$fechaInicioB=$_GET['fechaInicioB'];
			$fechaFinalB=$_GET['fechaFinalB'];
			if($fechaInicioB<>"" and $fechaFinalB<>""){
					list($dI,$mI,$aI)=explode("/",$fechaInicioB);
					list($dF,$mF,$aF)=explode("/",$fechaFinalB);
					$fechaFinalB_2= date("Y-m-d", strtotime($aF."-".$mF."-".$dF +1));  				
					$sql.=" and nr.fecha_nota_remision>='".$aI."-".$mI."-".$dI."' and nr.fecha_nota_remision<'".$fechaFinalB_2."' ";
		}	

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
		//Fin de calculo de paginas
		$sql=" select nr.cod_nota_remision, nr.cod_gestion, g.gestion, nr.nro_nota_remision, nr.fecha_nota_remision,";
		$sql.=" nr.cod_usuario_nota_remision, nr.obs_nota_remision, nr.cod_hoja_ruta, nr.cod_estado_nota_remision,";
		$sql.=" nr.recibido_por, nr.cod_usuario_anulacion, nr.cod_usuario_registro, nr.fecha_registro, nr.cod_usuario_modifica,  ";
		$sql.=" nr.fecha_modifica,nr.cod_usuario_entregado_por";
		$sql.=" from notas_remision nr, gestiones g";
		$sql.=" where  nr.cod_gestion=g.cod_gestion";
		if($_GET['nroNotaRemisionB']<>""){
			$sql.=" and CONCAT(nr.nro_nota_remision,'/',g.gestion) LIKE '%".$_GET['nroHojaRutaB']."%' ";
		}
		
		if($_GET['nroHojaRutaB']<>""){
			$sql.=" and nr.cod_hoja_ruta in(select hojas_rutas.cod_hoja_ruta from hojas_rutas, gestiones ";
			$sql.=" where hojas_rutas.cod_gestion=gestiones.cod_gestion and  CONCAT(hojas_rutas.nro_hoja_ruta,'/',gestiones.gestion) LIKE '%".$_GET['nroHojaRutaB']."%' )";
		}
		
		if($_GET['nrocotizacionB']<>""){
			$sql.=" and nr.cod_hoja_ruta in(select hojas_rutas.cod_hoja_ruta ";
			$sql.=" from hojas_rutas, cotizaciones, gestiones ";
			$sql.=" where hojas_rutas.cod_cotizacion=cotizaciones.cod_cotizacion ";
			$sql.=" and cotizaciones.cod_gestion=gestiones.cod_gestion ";
			$sql.=" and  CONCAT(cotizaciones.nro_cotizacion,'/',gestiones.gestion) LIKE '%".$_GET['nrocotizacionB']."%')";
		}	

		if($_GET['nombreClienteB']<>""){
			$sql.=" and nr.cod_hoja_ruta in(select hojas_rutas.cod_hoja_ruta ";
			$sql.=" from hojas_rutas, cotizaciones, clientes";
			$sql.=" where hojas_rutas.cod_cotizacion=cotizaciones.cod_cotizacion ";
			$sql.=" and cotizaciones.cod_cliente=clientes.cod_cliente";
			$sql.=" and  clientes.nombre_cliente LIKE '".$_GET['nombreClienteB']."%')";
		}			

		if($codActivoFecha=="on"){
			$fechaInicioB=$_GET['fechaInicioB'];
			$fechaFinalB=$_GET['fechaFinalB'];
			if($fechaInicioB<>"" and $fechaFinalB<>""){
					list($dI,$mI,$aI)=explode("/",$fechaInicioB);
					list($dF,$mF,$aF)=explode("/",$fechaFinalB);
					$fechaFinalB_2= date("Y-m-d", strtotime($aF."-".$mF."-".$dF +1));  				
					$sql.=" and nr.fecha_nota_remision>='".$aI."-".$mI."-".$dI."' and nr.fecha_nota_remision<'".$fechaFinalB_2."' ";
		}	

		}
	  	$sql.=" order by nr.cod_nota_remision desc";	
		$sql.=" limit 50";
		//	echo $sql;
		$resp = mysql_query($sql);
		$cont=0;
?>	
	<table width="95%" align="center" cellpadding="1" id="cotizacion" cellspacing="1" bgColor="#cccccc" class="tablaReporte" style="width:100% !important;">
	<thead>		   
	    <tr height="20px" align="center"  class="bg-success text-white">
			<th>No</th>
    		<th>Fecha</th>								
			<th>Entregado por:</th>											
    		<th>Recibido por:</th>
			<th>Datos Adicionales</th>
            <th>Observaciones</th>		            
			<th>Registro</th>
			<th>Edici&oacute;n</th>    		
			<th>Estado</th>	
            <!--th>&nbsp;</th>	
            <th>&nbsp;</th-->	
		</tr>
		</thead>
		<tbody>
<?php   
		while($dat=mysql_fetch_array($resp)){
			
			$cod_nota_remision=$dat['cod_nota_remision'];
			$cod_gestion=$dat['cod_gestion'];
			$gestion=$dat['gestion'];
			$nro_nota_remision=$dat['nro_nota_remision']; 
			$fecha_nota_remision=$dat['fecha_nota_remision'];
			$cod_usuario_nota_remision=$dat['cod_usuario_nota_remision'];
			$obs_nota_remision=$dat['obs_nota_remision'];
			$cod_hoja_ruta=$dat['cod_hoja_ruta'];
			$cod_estado_nota_remision=$dat['cod_estado_nota_remision'];
			$recibido_por=$dat['recibido_por'];
			$cod_usuario_anulacion=$dat['cod_usuario_anulacion']; 
			$cod_usuario_registro=$dat['cod_usuario_registro'];
			$fecha_registro=$dat['fecha_registro'];
			$cod_usuario_modifica=$dat['cod_usuario_modifica'];
			$fecha_modifica=$dat['fecha_modifica'];
			$cod_usuario_entregado_por=$dat['cod_usuario_entregado_por'];
			//******************************USUARIO ENTREGADO POR********************************
					$usuarioEntregadoPor="";				
					$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios";
					$sql2.=" where cod_usuario='".$cod_usuario_entregado_por."'";	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){	
							$nombres_usuario=$dat2['nombres_usuario'];	
							$ap_paterno_usuario=$dat2['ap_paterno_usuario'];	
							$ap_materno_usuario=$dat2['ap_materno_usuario'];				
						$usuarioEntregadoPor=$nombres_usuario[0].$ap_paterno_usuario[0].$ap_materno_usuario[0];
					}
			//*******************************FIN USUARIO ENTREGADO POR*******************************	
			//******************************HOJA DE RUTA********************************		
					$sql2="select hr.nro_hoja_ruta, hr.cod_gestion, g.gestion, hr.cod_cotizacion ";
					$sql2.=" from hojas_rutas hr, gestiones g ";
					$sql2.=" where hr.cod_hoja_ruta=".$cod_hoja_ruta;
					$sql2.=" and hr.cod_gestion=g.cod_gestion ";
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){	
							$hoja_ruta=$dat2['nro_hoja_ruta']."/".$dat2['gestion'];	
							$cod_cotizacion=$dat2['cod_cotizacion'];	
					}
			//*******************************FIN HOJA DE RUTA*******************************
			//******************************COTIZACION********************************		
					$sql2="select c.nro_cotizacion, c.cod_gestion, g.gestion, c.cod_cliente, cli.nombre_cliente";
					$sql2.=" from cotizaciones c, gestiones g, clientes cli";
					$sql2.=" where c.cod_cotizacion=".$cod_cotizacion;
					$sql2.=" and c.cod_gestion=g.cod_gestion";
					$sql2.=" and c.cod_cliente=cli.cod_cliente";
	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){	
							$cotizacion=$dat2['nro_cotizacion']."/".$dat2['gestion'];	
							$nombre_cliente=$dat2['nombre_cliente'];	
					}
			//*******************************FIN COTIZACION*******************************	
//******************************USUARIO REGISTRO********************************
					$usuarioRegistro="";
					if($cod_usuario_registro<>0 and $cod_usuario_registro=="")	{					
						$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios";
						$sql2.=" where cod_usuario='".$cod_usuario_registro."'";	
						$resp2= mysql_query($sql2);
						$dat2=mysql_fetch_array($resp2);
						$nombres_usuario_reg=$dat2[0];
						$ap_paterno_usuario_reg=$dat2[1];
						$ap_materno_usuario_reg=$dat2[2];
						$usuarioRegistro=$nombres_usuario_reg[0].$ap_paterno_usuario_reg[0].$ap_materno_usuario_reg[0]." ".strftime("%d/%m/%Y %H:%M:%S",strtotime($fecha_registro));
					}
				//*******************************FIN USUARIO REGISTRO*******************************									
				
				//******************************USUARIO MODIFICA********************************
					$usuarioModifica="";	
					if($cod_usuario_modifica<>0 and $cod_usuario_modifica=="")	{		
						$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios";
						$sql2.=" where cod_usuario='".$cod_usuario_modifica."'";	
						$resp2= mysql_query($sql2);
						$dat2=mysql_fetch_array($resp2);
						$nombres_usuario_mod=$dat2[0];
						$ap_paterno_usuario_mod=$dat2[1];
						$ap_materno_usuario_mod=$dat2[2];
					$usuarioModifica=$nombres_usuario_mod[0].$ap_paterno_usuario_mod[0].$ap_materno_usuario_mod[0]." ".strftime("%d/%m/%Y %H:%M:%S",strtotime($fecha_modifica));						
					}
					
				//*******************************FIN USUARIO MODIFICA*******************************	
			//**************************************************************
				$nombre_estado_nota_remision="";				
				$sql2=" select nombre_estado_nota_remision from estados_notas_remision ";
				$sql2.=" where cod_estado_nota_remision=".$cod_estado_nota_remision;
					
				$resp2=mysql_query($sql2);
				$dat2=mysql_fetch_array($resp2);
				$nombre_estado_nota_remision=$dat2[0];						
			//**************************************************************												
			
		?> 
		<tr bgcolor="#FFFFFF" valign="middle" >	
    		<td align="right"><a href="../reportes/impresionNotaRemision.php?cod_nota_remision=<?php echo $cod_nota_remision; ?>" target="_blank"><?php echo $nro_nota_remision."/".$gestion;?></a></td>	
			<td><?php echo strftime("%d/%m/%Y %H:%M:%S",strtotime($fecha_nota_remision));?></td>	
			<td><?php echo $usuarioEntregadoPor; ?></td>											
    		<td><?php echo $recibido_por;?></td>
          <td>
          <a href="../reportes/impresionHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta?>" target="_blank"><?php echo "H.R. ".$hoja_ruta." ";?></a><a href="../reportes/impresionCotizacionFormato.php?cod_cotizacion=<?php echo $cod_cotizacion?>" target="_blank"><?php echo "COT. ".$cotizacion;?></a><br/>
          <?php echo $nombre_cliente;?>
          </td>
			<td><?php echo $obs_nota_remision?></td>           
		  <td><?php echo $usuarioRegistro;?></td>		
		  <td><?php echo $usuarioModifica;?></td>
          <td><?php echo $nombre_estado_nota_remision;?></td>            							
		  <!--td><a href="editarNotaRemision.php?cod_nota_remision=<?php echo $cod_nota_remision;?>">Editar</a></td>
		  <td><?php if($cod_estado_nota_remision==1){?><a href="javascript:anularNotaRemision(<?php echo $cod_nota_remision?>)">Anular</a><?php }else{ echo "Anular";}?></td-->          
							            
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
<td><strong>Nro de Nota Reminison</strong></td>
<td colspan="3"><input type="text" name="nroNotaRemisionB" id="nroNotaRemisionB" size="10"  class="textoform" onkeyup="buscar()" ></td>
</tr>
<tr>
<td><strong>Nro de Hoja de Ruta</strong></td>
<td colspan="3"><input type="text" name="nroHojaRutaB" id="nroHojaRutaB" size="10"  class="textoform" onkeyup="buscar()" ></td>
</tr>
<tr>
<td><strong>Nro de Cotizacion</strong></td>
<td colspan="3"><input type="text" name="nrocotizacionB" id="nrocotizacionB" size="10" class="textoform" onkeyup="buscar()"  ></td>
</tr>
<tr>
<td><strong>Cliente</strong></td>
<td colspan="3">
 <input name="nombreClienteB" id="nombreClienteB" size="30" class="textoform"  onkeyup="buscar()">
	</td>
	<td rowspan="2">&nbsp;</td>
</tr>


<tr >
     		<td>&nbsp;<b>Rango de Fecha<br/>(dd/mm/aaaa)</b>&nbsp;</td>			
     		<td><strong>De&nbsp;</strong>
                <input type="text" name="fechaInicioB" id="fechaInicioB" class="textoform">

        <strong>&nbsp;Hasta&nbsp;</strong>
        <input type="text" name="fechaFinalB" id="fechaFinalB" class="textoform"  >
<input type="checkbox" name="codActivoFecha" id="codActivoFecha"  onClick="buscar()" ><strong>Chekear la casilla para buscar por fechas.</strong>
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
