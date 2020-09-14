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
			divResultado.innerHTML = ajax.responseText
		}
	}
	ajax.send(null)
}

function buscar()
{
	for (i=0;i<document.form1.codestotB.length;i++){ 
       if (document.form1.codestotB[i].checked) 
          break; 
    }	
	if(document.form1.codActivoFecha.checked){
		valorchecked="on";
	}else{
		valorchecked="off";
	}

resultados_ajax('searchOrdenTrabajo.php?codestotB='+document.form1.codestotB[i].value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&nroOrdenTrabajoB='+document.form1.nroOrdenTrabajoB.value+'&numeroOrdenTrabajoB='+document.form1.numeroOrdenTrabajoB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&cod_estado_pago_docB='+document.form1.cod_estado_pago_docB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value);

}
function paginar(f)
{	
	for (i=0;i<document.form1.codestotB.length;i++){ 
       if (document.form1.codestotB[i].checked) 
          break; 
    }	
	if(document.form1.codActivoFecha.checked){
		valorchecked="on";
	}else{
		valorchecked="off";
	}
		location.href='listOrdenTrabajo.php?codestotB='+document.form1.codestotB[i].value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&nroOrdenTrabajoB='+document.form1.nroOrdenTrabajoB.value+'&numeroOrdenTrabajoB='+document.form1.numeroOrdenTrabajoB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&cod_estado_pago_docB='+document.form1.cod_estado_pago_docB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&pagina='+document.form1.pagina.value;
}
function paginar1(f,pagina)
{		

		f.pagina.value=pagina*1;		
		for (i=0;i<document.form1.codestotB.length;i++){ 
       if (document.form1.codestotB[i].checked) 
          break; 
    }	
	if(document.form1.codActivoFecha.checked){
		valorchecked="on";
	}else{
		valorchecked="off";
	}
		location.href='listOrdenTrabajo.php?codestotB='+document.form1.codestotB[i].value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&nroOrdenTrabajoB='+document.form1.nroOrdenTrabajoB.value+'&numeroOrdenTrabajoB='+document.form1.numeroOrdenTrabajoB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&cod_estado_pago_docB='+document.form1.cod_estado_pago_docB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&pagina='+document.form1.pagina.value;
}
function openPopup(url){
	window.open(url,'','top=50,left=200,width=600,height=400,scrollbars=1,resizable=1');
}
</script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#FFFFFF" onload="document.form1.nombreClienteB.focus()" >
<!---Autor:Gabriela Quelali Si�ani
02 de Julio de 2008
-->

<h3 align="center" style="background:#FFFFFF;font-size: 14px;color: #E78611;font-weight:bold;">LISTADO DE ORDENES DE TRABAJO</h3>
<form name="form1" id="form1"  method="post" >
<?php


	$nroOrdenTrabajoB=$_GET['nroOrdenTrabajoB'];
	$numeroOrdenTrabajoB=$_GET['numeroOrdenTrabajoB'];
	$nombreClienteB=$_GET['nombreClienteB'];
	$codActivoFecha=$_GET['codActivoFecha'];
	$fechaInicioB=$_GET['fechaInicioB'];
	$fechaFinalB=$_GET['fechaFinalB'];
	$cod_estado_pago_docB=$_GET['cod_estado_pago_docB'];
	$codestotB=$_GET['codestotB'];


?>
<table width="323" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr >
          <td width="122" align="right" >TODOS</td>
          <td width="20"><label>
            <input name="codestotB" type="radio" id="codestotB" value="0" <?php if($codestotB==0){?>checked="checked"<?php }?> onclick="buscar()"/>
          </label></td>
          <?php 
		  	$queryEstado=" select cod_est_ot, desc_est_ot  from estado_ordentrabajo ";
			$queryEstado.=" order by  cod_est_ot ";
			$resp= mysql_query($queryEstado);
			while($dat=mysql_fetch_array($resp)){
				$cod_est_ot=$dat['cod_est_ot'];
				$desc_est_ot=$dat['desc_est_ot'];
		 ?>
         	    <td width="126" align="right" ><?php echo $desc_est_ot;?></td>
        		<td width="20">
		    	 <label>
	               <input name="codestotB" type="radio" id="codestotB" value="<?php echo $cod_est_ot;?>"<?php if($codestotB==$cod_est_ot){?>checked="checked"<?php }?>  onclick="buscar()"/>
        		  </label>
          		</td>
		 <?php
			}
		  
		  ?>
        </tr>
      </table>
      <br/>

    <table width="500" border="0" align="center" cellpadding="2" cellspacing="0">
     
      <tr class="texto">
        <td width="90" align="right" class="al_derecha"><strong>Cliente:</strong></td>
          <td width="256" align="left">
            <input type="text" name="nombreClienteB" id="nombreClienteB"  class="textoform" size="30" value="<?php echo $nombreClienteB;?>" onkeyup="buscar()"/></td>
      </tr>                   
   <tr class="texto">
         <td width="90" align="right" class="al_derecha"><strong>Nro de Orden de Trabajo:</strong></td>
          <td width="256" align="left">
            <input type="text" name="nroOrdenTrabajoB" id="nroOrdenTrabajoB"  class="textoform" size="30" value="<?php echo $nroOrdenTrabajoB; ?>" onkeyup="buscar()" /></td>
       </tr> 
   <tr class="texto">
      <td width="90" align="right" class="al_derecha"><strong>Numero:</strong></td>
          <td width="256" align="left">
            <input type="text" name="numeroOrdenTrabajoB" id="numeroOrdenTrabajoB" class="textoform" value="<?php echo $numeroOrdenTrabajoB;?>"  onkeyup="buscar()"/></td>
      </tr>     
      <tr class="texto">
         <td width="90" align="right"><strong>Estado de Pago:</strong></td>
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
   
   <tr class="texto">
         <td width="90" align="right" class="al_derecha"><strong>Rango de Fecha<br/>(dd/mm/aaaa):</strong></td>
          <td width="256" align="left"><strong>De&nbsp;</strong>
          <input type="text" name="fechaInicioB" id="fechaInicioB" class="textoform" size="10" value="<?php echo $fechaInicioB;?>" />
         <strong>&nbsp;Hasta&nbsp;</strong>
          <input type="text" name="fechaFinalB" id="fechaFinalB" class="textoform" size="10" value="<?php echo $fechaFinalB;?>" />
         <input type="checkbox" name="codActivoFecha" id="codActivoFecha" onClick="buscar()" <?php if($codActivoFecha=="on"){?>checked="checked"<?php }?> ><strong>Chekear la casilla para buscar por fechas.</strong></td>
       </tr>     
                               
  </table>

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
	
	$sql=" select count(*) ";
	$sql.=" from ordentrabajo ot, gestiones g, estado_ordentrabajo eo, clientes cli ";
	$sql.=" where ot.cod_gestion=g.cod_gestion ";
	$sql.=" and ot.cod_est_ot=eo.cod_est_ot ";
	$sql.=" and ot.cod_cliente=cli.cod_cliente ";

	if($codestotB<>0){
		$sql.=" and ot.cod_est_ot=".$codestotB."";
	}
	if($cod_estado_pago_docB<>0){
		$sql.=" and ot.cod_estado_pago_doc=".$cod_estado_pago_docB."";
	}
	
	if($nombreClienteB<>""){
		$sql.=" and cli.nombre_cliente like '%".$nombreClienteB."%'";
	}
	if($nroOrdenTrabajoB<>""){	
		$sql.=" and CONCAT(ot.nro_orden_trabajo,'/',g.gestion)like '%".$nroOrdenTrabajoB."%'";
	}
	if($numeroOrdenTrabajoB<>""){	
		$sql.=" and ot.numero_orden_trabajo like '%".$numeroOrdenTrabajoB."%'";
	}		
	
	if($codActivoFecha=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);	
		$sql.=" and (ot.fecha_orden_trabajo>='".$aI."-".$mI."-".$dI."' and ot.fecha_orden_trabajo<='".$aF."-".$mF."-".$dF."')";
		}
	}
	$sql.=" order by ot.cod_orden_trabajo desc ";
	

	$resp = mysql_query($sql);
	while($dat_aux=mysql_fetch_array($resp)){
		$nro_filas_sql=$dat_aux[0];
	}
?>
	<div id="nroRows" align="center" class="textoform"><?php echo "Nro. de Registros: ".$nro_filas_sql; ?></div>
    <br/>
<?php
	if($nro_filas_sql==0){
?>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
            <td>Nro Orden Trabajo</td>
		  <td>Fecha de Orden Trabajo</td>
            <td>Numero</td>
            <td>Cliente</td>
            <td>Monto</td>
            <td>Tipo de Pago</td>					
			<td>Detalle</td>
            <td>Observacion</td>
			<td>Estado Actual</td>
            <td>Estado de Pago</td>	
			<td>Fecha de Registro</td>
			<td>Fecha de Ultima Edicion</td>
            <td>&nbsp;</td>   																													            
		</tr>
		<tr><th colspan="13" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
	</table>
	
<?php	
	}else{
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
	$sql=" select ot.cod_orden_trabajo, ot.nro_orden_trabajo, ot.cod_gestion, g.gestion_nombre, ot.cod_est_ot, ";
	$sql.=" eo.desc_est_ot, ot.numero_orden_trabajo, ot.fecha_orden_trabajo, ot.cod_cliente, cli.nombre_cliente, ";
	$sql.=" cli.direccion_cliente, cli.telefono_cliente, cli.celular_cliente, ";
	$sql.=" ot.cod_contacto, ot.detalle_orden_trabajo, ot.obs_orden_trabajo, ";
	$sql.=" ot.monto_orden_trabajo, ot.cod_usuario_registro, ot.fecha_registro,";
	$sql.=" ot.cod_usuario_modifica, ot.fecha_modifica, ot.cod_tipo_pago, ot.cod_estado_pago_doc, ";
	$sql.=" ot.incremento_orden_trabajo, ot.incremento_fecha, ot.incremento_obs, ot.cod_usuario_incremento,";
	$sql.=" ot.descuento_orden_trabajo, ot.descuento_fecha, ot.descuento_obs, ot.cod_usuario_descuento";
	$sql.=" from ordentrabajo ot, gestiones g, estado_ordentrabajo eo, clientes cli ";
	$sql.=" where ot.cod_gestion=g.cod_gestion ";
	$sql.=" and ot.cod_est_ot=eo.cod_est_ot ";
	$sql.=" and ot.cod_cliente=cli.cod_cliente ";
	if($codestotB<>0){
		$sql.=" and ot.cod_est_ot=".$codestotB."";
	}
		if($cod_estado_pago_docB<>0){
		$sql.=" and ot.cod_estado_pago_doc=".$cod_estado_pago_docB."";
	}
	if($nombreClienteB<>""){
		$sql.=" and cli.nombre_cliente like '%".$nombreClienteB."%'";
	}
	if($nroOrdenTrabajoB<>""){	
		$sql.=" and CONCAT(ot.nro_orden_trabajo,'/',g.gestion)like '%".$nroOrdenTrabajoB."%'";
	}
	if($numeroOrdenTrabajoB<>""){	
		$sql.=" and ot.numero_orden_trabajo like '%".$numeroOrdenTrabajoB."%'";
	}		
	
	if($codActivoFecha=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);	
		$sql.=" and (ot.fecha_orden_trabajo>='".$aI."-".$mI."-".$dI."' and ot.fecha_orden_trabajo<='".$aF."-".$mF."-".$dF."')";
		}
	}
	$sql.=" order by  ot.fecha_orden_trabajo desc,g.gestion desc,ot.nro_orden_trabajo desc ";
	$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
	$resp = mysql_query($sql);

?>	
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
    <tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="18">
						<p align="center">						
						<b><?php if($pagina>1){ ?>
							<a href="#" onclick="paginar1(form1,<?php echo $pagina-1; ?>)"><--Anterior</a>
							<?php }?>
						</b>
						<b> Pagina <?php echo $pagina; ?> de <?php echo $nropaginas; ?> </b>
						<b><?php if($nropaginas>$pagina){ ?> 
							<a href="#" onclick="paginar1(form1,<?php echo $pagina+1; ?>)">Siguiente--></a>
						<?php }?></b>
						</p>
</td>
			</tr>

	    <tr height="20px" align="center"  class="titulo_tabla">
            <td>Nro O.T.</td>          
			<td>Fecha O.T.</td>            
            <td>Cliente</td>
			<td>Tipo de Pago</td>
            <td>Monto</td>
            <td>Inc</td>
            <td>Desc</td> 
            <td>Tot. Monto</td>            
            <td>A cuenta</td>	
            <td>Saldo</td>
            <td>Gastos</td>					
			<td>Estado Actual</td>
            <td>Estado de Pago</td>	
            <td>Pagos</td>
            <td>Facturas</td>
    	    <td>&nbsp;</td> 
            <td>&nbsp;</td> 
            <td>&nbsp;</td> 
         
                     	            																	
		</tr>

<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){
		
				$cod_orden_trabajo=$dat['cod_orden_trabajo'];
				$nro_orden_trabajo=$dat['nro_orden_trabajo'];
				$cod_gestion=$dat['cod_gestion'];
				$gestion=$dat['gestion_nombre'];
				$cod_est_ot=$dat['cod_est_ot'];
				$desc_est_ot=$dat['desc_est_ot'];
				$numero_orden_trabajo=$dat['numero_orden_trabajo'];
				$fecha_orden_trabajo=$dat['fecha_orden_trabajo'];
				$cod_cliente=$dat['cod_cliente'];
				$cod_contacto=$dat['cod_contacto'];
				$nombre_cliente=$dat['nombre_cliente'];
				$direccion_cliente=$dat['direccion_cliente'];
				$telefono_cliente=$dat['telefono_cliente'];
				$celular_cliente=$dat['celular_cliente'];
				$detalle_orden_trabajo=$dat['detalle_orden_trabajo'];
				$obs_orden_trabajo=$dat['obs_orden_trabajo'];
				$monto_orden_trabajo=$dat['monto_orden_trabajo'];
				$cod_usuario_registro=$dat['cod_usuario_registro'];
				$fecha_registro=$dat['fecha_registro'];
				$cod_usuario_modifica=$dat['cod_usuario_modifica'];
				$fecha_modifica=$dat['fecha_modifica'];
				$cod_tipo_pago=$dat['cod_tipo_pago'];
				$cod_estado_pago_doc=$dat['cod_estado_pago_doc'];	
				$incremento_orden_trabajo=$dat['incremento_orden_trabajo'];	
				$incremento_fecha=$dat['incremento_fecha'];	
				$incremento_obs=$dat['incremento_obs'];	
				$cod_usuario_incremento=$dat['cod_usuario_incremento'];	
				$descuento_orden_trabajo=$dat['descuento_orden_trabajo'];	
				$descuento_fecha=$dat['descuento_fecha'];	
				$descuento_obs=$dat['descuento_obs'];	
				$cod_usuario_descuento=$dat['cod_usuario_descuento'];	
							
				$nombre_tipo_pago="";
				$sql2="select nombre_tipo_pago from tipos_pago where cod_tipo_pago=".$cod_tipo_pago;
				$resp2= mysql_query($sql2);	
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_tipo_pago=$dat2['nombre_tipo_pago'];
				}
		
				$desc_estado_pago_doc="";
				$sql2="select desc_estado_pago_doc from estado_pago_documento where cod_estado_pago_doc=".$cod_estado_pago_doc;
				$resp2= mysql_query($sql2);	
				while($dat2=mysql_fetch_array($resp2)){
					$desc_estado_pago_doc=$dat2['desc_estado_pago_doc'];
				}
				$acuenta_ordentrabajo=0;
				$sql3=" select sum(monto_pago_detalle) ";
				$sql3.=" from pagos_detalle pd, pagos p";
				$sql3.=" where pd.cod_pago=p.cod_pago";
				$sql3.=" and p.cod_estado_pago<>2";
				$sql3.=" and pd.codigo_doc=".$cod_orden_trabajo;
				$sql3.=" and pd.cod_tipo_doc=2";
				$resp3= mysql_query($sql3);					
				while($dat3=mysql_fetch_array($resp3)){
					$acuenta_ordentrabajo=$dat3[0];
				}	
				if($acuenta_ordentrabajo==""){
					$acuenta_ordentrabajo=0;
				}
			$contacto="";
					if($cod_contacto<>"" and $cod_contacto<>0 and $cod_contacto<>NULL){
					  $sql5="  select nombre_contacto, ap_paterno_contacto, ap_materno_contacto, telefono_contacto, celular_contacto, ";
					  $sql5.=" email_contacto, cargo_contacto ";
					  $sql5.="  from clientes_contactos ";
					  $sql5.=" where cod_contacto=".$cod_contacto;
					  $resp5= mysql_query($sql5);
					  while($dat5=mysql_fetch_array($resp5)){
							$contacto=$dat5['nombre_contacto']." ".$dat5['ap_paterno_contacto']." ".$dat5['ap_materno_contacto'];
							$telefono_contacto=$dat5['telefono_contacto'];
							$celular_contacto=$dat5['celular_contacto'];
					  		$email_contacto=$dat5['email_contacto']; 
							$cargo_contacto=$dat5['cargo_contacto'];
					  }
					}		
?> 
		<tr bgcolor="#FFFFFF">	
            <td align="right"><a href="../reportes/impresionOrdenTrabajo.php?cod_orden_trabajo=<?php echo $cod_orden_trabajo; ?>" target="_blank"><?php echo $nro_orden_trabajo."/".$gestion."(Int.".$numero_orden_trabajo.")"; ?></a>
			<br/>
<a href="../reportes/impresionOrdenTrabajoSinPrecio.php?cod_orden_trabajo=<?php echo $cod_orden_trabajo; ?>" target="_blank"><?php echo $nro_orden_trabajo."/".$gestion; ?></a>
</td>
            <td align="right"><?php 
			list($aOT,$mOT,$dOT)=explode("-",$fecha_orden_trabajo);
			 echo $dOT.".".$mOT.".".$aOT;
			 ?></td>            
            <td><?php echo "<strong>".$nombre_cliente."</strong>"; 

						echo "<br/><strong>Direccion:</strong>".$direccion_cliente;
					echo "<br/><strong>Telf:</strong>".$telefono_cliente." ".$celular_cliente;
				if($contacto<>""){
					echo "<br/<strong>CONTACTO</strong>: ".$contacto;
					echo "<br/><strong>Cargo:/</strong>".$cargo_contacto;					
					echo "<br/><strong>Telefono:<strong> ".$telefono_contacto." ".$celular_contacto;

				}
			
			?></td>
            <td align="right"><?php echo $nombre_tipo_pago; ?></td>
			<td align="right"><?php echo number_format($monto_orden_trabajo,2); ?></td>
             <td align="right"><?php 
			 	if($incremento_orden_trabajo==""){
					$incremento_orden_trabajo=0;
				 }
				 	echo number_format($incremento_orden_trabajo,2);
				 
			 ?></td>
              <td align="right"><?php 
			 	if($descuento_orden_trabajo==""){
					$descuento_orden_trabajo=0;
				 }
					 echo number_format($descuento_orden_trabajo,2);
			 ?></td>
              <td align="right"><?php echo number_format((($monto_orden_trabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo),2); ?></td>
            <td align="right"><?php echo number_format($acuenta_ordentrabajo,2); ?></td>
            <td align="right"><?php echo number_format(((($monto_orden_trabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo)-$acuenta_ordentrabajo),2); ?></td>		

              <td><?php
              		$monto_gasto=0;
					$sqlAux=" select count(*) ";
					$sqlAux.=" from gastos_ordentrabajo where cod_orden_trabajo=".$cod_orden_trabajo;
					$respAux = mysql_query($sqlAux);
					$swGasto=0;
					while($datAux=mysql_fetch_array($respAux)){
								$swGasto=$datAux[0];
					}
					if($swGasto>0){
							$sqlAux="select sum(monto_gasto) ";
							$sqlAux.=" from gastos_ordentrabajo where cod_orden_trabajo=".$cod_orden_trabajo;
							$respAux = mysql_query($sqlAux);
							while($datAux=mysql_fetch_array($respAux)){
								$monto_gasto=$datAux[0];
							}										
					}
					echo number_format($monto_gasto,2);
			  
			  ?></td>		
			<td><?php echo $desc_est_ot;?></td>	
            <td><?php echo $desc_estado_pago_doc;?></td>	
            <td>
            <table border="0" align="center">
            <?php
            	$sql3=" select p.nro_pago, g.gestion, p.fecha_pago ";
				$sql3.=" from pagos_detalle pd, pagos p, gestiones g ";
				$sql3.=" where pd.cod_pago=p.cod_pago ";
				$sql3.=" and p.cod_gestion=g.cod_gestion";
				$sql3.=" and p.cod_estado_pago<>2 ";
				$sql3.=" and pd.codigo_doc=".$cod_orden_trabajo;
				$sql3.=" and pd.cod_tipo_doc=2 ";
				$resp3= mysql_query($sql3);	
				$nro_pago="";
				$gestion_pago="";
				$fecha_pago=""; 
				while($dat3=mysql_fetch_array($resp3)){
					$nro_pago=$dat3['nro_pago'];
					$gestion_pago=$dat3['gestion'];
					$fecha_pago=$dat3['fecha_pago']; 
					list($aP,$mP,$dP)=explode("-",$fecha_pago);
			?>
            	<tr>
                	<td><?php echo "Nro".$nro_pago."/".$gestion_pago; ?></td>
                    <td><?php echo $dP.".".$mP.".".$aP; ?></td>
                </tr>
            <?php
				}	
			?>
            </table>
            </td>
            <td>
            <table border="0" align="center">
            <?php
            	$sql3=" select fot.cod_factura,f.nro_factura,f.fecha_factura ";
				$sql3.=" from factura_ordentrabajo fot, facturas f ";
				$sql3.=" where fot.cod_factura=f.cod_factura ";
				$sql3.=" and f.cod_est_fac<>2 ";
				$sql3.=" and fot.cod_orden_trabajo=".$cod_orden_trabajo;
				$resp3= mysql_query($sql3);	
				$cod_factura="";
				$nro_factura="";
				$fecha_factura=""; 
				while($dat3=mysql_fetch_array($resp3)){
					$cod_factura=$dat3['cod_factura'];
					$nro_factura=$dat3['nro_factura'];
					$fecha_factura=$dat3['fecha_factura']; 
					list($aF,$mF,$dF)=explode("-",$fecha_factura);
			?>
            	<tr>
                	<td><?php echo "Nro.".$nro_factura; ?></td>
                    <td><?php echo $dF.".".$mF.".".$aF; ?></td>
                </tr>
            <?php
				}	
			?>
            </table>
            </td>     
              <td>
			  <?php
              	if($cod_est_ot<>2){
			  ?>
              <a href="editOrdenTrabajo.php?cod_orden_trabajo=<?php echo $cod_orden_trabajo;?>" >Editar</a></td>    
             <?php
				}else{
				echo "Editar";
				}
			  ?>                 
			<td>
			<?php 
				$sql3=" select count(*) ";
				$sql3.=" from pagos_detalle pd, pagos p";
				$sql3.=" where pd.cod_pago=p.cod_pago";
				$sql3.=" and p.cod_estado_pago<>2";
				$sql3.=" and pd.codigo_doc=".$cod_orden_trabajo;
				$sql3.=" and pd.cod_tipo_doc=2";
				$resp3= mysql_query($sql3);	
				$nroPagosOT=0;
				while($dat3=mysql_fetch_array($resp3)){
					$nroPagosOT=$dat3[0];
				}				

				if($cod_est_ot==2 or $nroPagosOT>0 ){
					 echo "Anular";}else{?>
	            <a href="anularOrdenTrabajo.php?cod_orden_trabajo=<?php echo $cod_orden_trabajo; ?>">Anular</a>
              <?php }?>
              </td>     
 			<td><a href="duplicarOrdenTrabajo.php?cod_orden_trabajo=<?php echo $cod_orden_trabajo; ?>" target="_blank">Duplicar O.T.</a></td>
          					                 					
   	  </tr>
<?php
		 } 
?>			

	<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="18">
						<p align="center">						
						<b><?php if($pagina>1){ ?>
							<a href="#" onclick="paginar1(form1,<?php echo $pagina-1; ?>)"><--Anterior</a>
							<?php }?>
						</b>
						<b> Pagina <?php echo $pagina; ?> de <?php echo $nropaginas; ?> </b>
						<b><?php if($nropaginas>$pagina){ ?> 
							<a href="#" onclick="paginar1(form1,<?php echo $pagina+1; ?>)">Siguiente--></a>
						<?php }?></b>
						</p>
						<p align="center">				
						Ir a Pagina<input type="text" name="pagina" size="5"><input  type="button" size="8"  value="Go" onClick="paginar(this.form)">	
</td>
			</tr>
		</table>
		
<?php
	}
?>
</div>	
<?php require("cerrar_conexion.inc");
?>


</form>

</body>
</html>

