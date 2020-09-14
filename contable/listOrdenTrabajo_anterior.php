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

resultados_ajax('searchOrdenTrabajo.php?codestotB='+document.form1.codestotB[i].value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&nroOrdenTrabajoB='+document.form1.nroOrdenTrabajoB.value+'&numeroOrdenTrabajoB='+document.form1.numeroOrdenTrabajoB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value);

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
		location.href='listOrdenTrabajo.php?codestotB='+document.form1.codestotB[i].value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&nroOrdenTrabajoB='+document.form1.nroOrdenTrabajoB.value+'&numeroOrdenTrabajoB='+document.form1.numeroOrdenTrabajoB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&pagina='+document.form1.pagina.value;
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
		location.href='listOrdenTrabajo.php?codestotB='+document.form1.codestotB[i].value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&nroOrdenTrabajoB='+document.form1.nroOrdenTrabajoB.value+'&numeroOrdenTrabajoB='+document.form1.numeroOrdenTrabajoB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&pagina='+document.form1.pagina.value;
}

</script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#F7F5F3" onload="document.form1.nombreClienteB.focus()" >
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->

<h3 align="center" style="background:#F7F5F3;font-size: 14px;color: #E78611;font-weight:bold;">LISTADO DE ORDENES DE TRABAJO</h3>
<form name="form1" id="form1"  method="post" >
<?php


	$nroOrdenTrabajoB=$_GET['nroOrdenTrabajoB'];
	$numeroOrdenTrabajoB=$_GET['numeroOrdenTrabajoB'];
	$nombreClienteB=$_GET['nombreClienteB'];
	$codActivoFecha=$_GET['codActivoFecha'];
	$fechaInicioB=$_GET['fechaInicioB'];
	$fechaFinalB=$_GET['fechaFinalB'];
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

    <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
     
      <tr class="texto">
        <td width="90" align="right" class="al_derecha">Cliente:</td>
          <td width="256" align="left"><span id="sprytextfield4">
            <label for="nombreClienteB"></label>
            <input type="text" name="nombreClienteB" id="nombreClienteB"  class="textoform" size="30" value="<?php echo $nombreClienteB;?>" onkeyup="buscar()"/>
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
      </tr>                   
   <tr class="texto">
         <td width="90" align="right" class="al_derecha">Nro de Orden de Trabajo:</td>
          <td width="256" align="left"><span id="sprytextfield5">
            <label for="nroOrdenTrabajoB"></label>
            <input type="text" name="nroOrdenTrabajoB" id="nroOrdenTrabajoB"  class="textoform" size="30" value="<?php echo $nroOrdenTrabajoB; ?>" onkeyup="buscar()" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
       </tr> 
   <tr class="texto">
      <td width="90" align="right" class="al_derecha">Numero:</td>
          <td width="256" align="left"><span id="sprytextfield1">
            <label for="numeroOrdenTrabajoB"></label>
            <input type="text" name="numeroOrdenTrabajoB" id="numeroOrdenTrabajoB" class="textoform" value="<?php echo $numeroOrdenTrabajoB;?>"  onkeyup="buscar()"/>
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
      </tr>        
   <tr class="texto">
         <td width="90" align="right" class="al_derecha">Rango de Fecha:</td>
          <td width="256" align="left"><span id="sprytextfield6">
          <label for="fechaInicioB">De</label>
          <input type="text" name="fechaInicioB" id="fechaInicioB" class="textoform" size="10" value="<?php echo $fechaInicioB;?>" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span><span id="sprytextfield7">
          <label for="fechaFinalB">Hasta</label>
          <input type="text" name="fechaFinalB" id="fechaFinalB" class="textoform" size="10" value="<?php echo $fechaFinalB;?>" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span><input type="checkbox" name="codActivoFecha" id="codActivoFecha" onClick="buscar()" <?php if($codActivoFecha=="on"){?>checked="checked"<?php }?> ></td>
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
	$sql.=" order by ot.nro_orden_trabajo desc,g.gestion desc ";
	

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
			<td>Detalle</td>
            <td>Observacion</td>
			<td>Estado Actual</td>	
			<td>Fecha de Registro</td>
			<td>Fecha de Ultima Edicion</td>
            <td>&nbsp;</td>   																													            
		</tr>
		<tr><th colspan="11" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
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
	$sql=" select ot.cod_orden_trabajo, ot.nro_orden_trabajo, ot.cod_gestion, g.gestion, ot.cod_est_ot, ";
	$sql.=" eo.desc_est_ot, ot.numero_orden_trabajo, ot.fecha_orden_trabajo, ot.cod_cliente, cli.nombre_cliente, ";
	$sql.=" ot.detalle_orden_trabajo, ot.obs_orden_trabajo, ot.monto_orden_trabajo, ot.cod_usuario_registro, ot.fecha_registro,";
	$sql.=" ot.cod_usuario_modifica, ot.fecha_modifica ";
	$sql.=" from ordentrabajo ot, gestiones g, estado_ordentrabajo eo, clientes cli ";
	$sql.=" where ot.cod_gestion=g.cod_gestion ";
	$sql.=" and ot.cod_est_ot=eo.cod_est_ot ";
	$sql.=" and ot.cod_cliente=cli.cod_cliente ";
	if($codestotB<>0){
		$sql.=" and ot.cod_est_ot=".$codestotB."";
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
	$sql.=" order by ot.nro_orden_trabajo desc,g.gestion desc ";
	$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
	$resp = mysql_query($sql);

?>	
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
    <tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="12">
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
            <td>Nro Orden Trabajo</td>
			<td>Fecha de Orden Trabajo</td>
            <td>Numero</td>
            <td>Cliente</td>
            <td>Monto</td>				
			<td>Detalle</td>
            <td>Observacion</td>
			<td>Estado Actual</td>	
			<td>Fecha de Registro</td>
			<td>Fecha de Ultima Edicion</td>
            <td>Facturas</td>
          <td>&nbsp;</td>                      	            																	
		</tr>

<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){
		
				$cod_orden_trabajo=$dat['cod_orden_trabajo'];
				$nro_orden_trabajo=$dat['nro_orden_trabajo'];
				$cod_gestion=$dat['cod_gestion'];
				$gestion=$dat['gestion'];
				$cod_est_ot=$dat['cod_est_ot'];
				$desc_est_ot=$dat['desc_est_ot'];
				$numero_orden_trabajo=$dat['numero_orden_trabajo'];
				$fecha_orden_trabajo=$dat['fecha_orden_trabajo'];
				$cod_cliente=$dat['cod_cliente'];
				$nombre_cliente=$dat['nombre_cliente'];
				$detalle_orden_trabajo=$dat['detalle_orden_trabajo'];
				$obs_orden_trabajo=$dat['obs_orden_trabajo'];
				$monto_orden_trabajo=$dat['monto_orden_trabajo'];
				$cod_usuario_registro=$dat['cod_usuario_registro'];
				$fecha_registro=$dat['fecha_registro'];
				$cod_usuario_modifica=$dat['cod_usuario_modifica'];
				$fecha_modifica=$dat['fecha_modifica'];

?> 
		<tr bgcolor="#FFFFFF">	
            <td align="right"><?php echo $nro_orden_trabajo."/".$gestion; ?></td>
			<td align="right"><?php echo strftime("%d/%m/%Y",strtotime($fecha_orden_trabajo));?></td>
            <td><?php echo $numero_orden_trabajo;?></td>
            <td><?php echo $nombre_cliente; ?></td>
            <td><?php echo $monto_orden_trabajo; ?></td>				
			<td><?php echo $detalle_orden_trabajo; ?></td>
            <td><?php echo $obs_orden_trabajo; ?></td>
			<td><?php echo $desc_est_ot;?></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
            <td>
            <table border="0" align="left">
            <?php
				$sqlFactura=" select f.cod_factura, f.nro_factura, f.nombre_factura, ";
				$sqlFactura.=" f.nit_factura, f.fecha_factura, f.detalle_factura,f.obs_factura, f.cod_est_fac,  ";
				$sqlFactura.=" ef.desc_est_fac, f.monto_factura, f.cod_usuario_registro,   ";
				$sqlFactura.=" f.fecha_registro, f.cod_usuario_modifica, f.fecha_modifica  ";
				$sqlFactura.=" from facturas f, estado_factura ef  ";
				$sqlFactura.=" where f.cod_est_fac=ef.cod_est_fac ";
				$sqlFactura.=" and f.cod_factura in(select cod_factura from factura_ordentrabajo where cod_orden_trabajo=".$cod_orden_trabajo.")";
				
					$resp3= mysql_query($sqlFactura);
					while($dat3=mysql_fetch_array($resp3)){
						
						$cod_factura=$dat3['cod_factura'];
						$nro_factura=$dat3['nro_factura'];
						$nombre_factura=$dat3['nombre_factura'];
						$nit_factura=$dat3['nit_factura'];
						$fecha_factura=$dat3['fecha_factura'];
						$detalle_factura=$dat3['detalle_factura'];
						$obs_factura=$dat3['obs_factura'];
						$cod_est_fac=$dat3['cod_est_fac'];
						$desc_est_fac=$dat3['desc_est_fac'];
						$monto_factura=$dat3['monto_factura'];
						$cod_usuario_registro=$dat3['cod_usuario_registro'];
						$fecha_registro=$dat3['fecha_registro'];
						$cod_usuario_modifica=$dat3['cod_usuario_modifica'];
						$fecha_modifica=$dat3['fecha_modifica'];		
			?>
				<tr>
                	<td align="right"><a><?php echo "Nro".$nro_factura." NIT:". $nit_factura." Monto:".$monto_factura ?></a></td>
                </tr>

			<?php
				}
			?>
			</table>
            </td>
            
          <td>
          <?php if($cod_est_ot<>2){?>
	          <a href="newFacturaOrdenTrabajo.php?cod_orden_trabajo=<?php echo $cod_orden_trabajo;?>">+ Factura</a>
           <?php }?>
          </td>     					
   	  </tr>
<?php
		 } 
?>			

	<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="12">
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
<script type="text/javascript">
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "date", {format:"dd/mm/yyyy"});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
</body>
</html>


