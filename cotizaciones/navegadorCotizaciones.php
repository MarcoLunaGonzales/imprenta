<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>Cotizaciones</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
function onrowmouseout(fila){
	cotizacion=document.getElementById('cotizacion');
	var rowsElement=cotizacion.rows;
	var cellsElement=rowsElement[fila].cells;
	cellsElement[0].style.backgroundColor='#FFFFFF';
	cellsElement[1].style.backgroundColor='#FFFFFF';
	cellsElement[2].style.backgroundColor='#FFFFFF';
	cellsElement[3].style.backgroundColor='#FFFFFF';
	cellsElement[4].style.backgroundColor='#FFFFFF';
	cellsElement[5].style.backgroundColor='#FFFFFF';
	cellsElement[6].style.backgroundColor='#FFFFFF';
	cellsElement[7].style.backgroundColor='#FFFFFF';
	cellsElement[8].style.backgroundColor='#FFFFFF';
	cellsElement[9].style.backgroundColor='#FFFFFF';	
	cellsElement[10].style.backgroundColor='#FFFFFF';	
}
function onrowmouseover(fila){
	cotizacion=document.getElementById('cotizacion');
	var rowsElement=cotizacion.rows;
	var cellsElement=rowsElement[fila].cells;
	var cel_0=cellsElement[0];
	cellsElement[0].style.backgroundColor='#E7F1E8';
	cellsElement[1].style.backgroundColor='#E7F1E8';
	cellsElement[2].style.backgroundColor='#E7F1E8';
	cellsElement[3].style.backgroundColor='#E7F1E8';
	cellsElement[4].style.backgroundColor='#E7F1E8';
	cellsElement[5].style.backgroundColor='#E7F1E8';
	cellsElement[6].style.backgroundColor='#E7F1E8';
	cellsElement[7].style.backgroundColor='#E7F1E8';
	cellsElement[8].style.backgroundColor='#E7F1E8';	
	cellsElement[9].style.backgroundColor='#E7F1E8';		
	cellsElement[10].style.backgroundColor='#E7F1E8';			
}

function openPopup(url){
	window.open(url,'DETALLE','top=50,left=200,width=800,height=600,scrollbars=1,resizable=1');
}

function paginar(f)
{	
		//location.href="navegadorCotizaciones.php?pagina="+f.pagina.value;		
location.href="navegadorCotizaciones.php?nrocotizacionB="+f.nrocotizacionB.value+"&codclienteB="+f.codclienteB.value+"&codItemB="+f.codItemB.value+"&codActivoFecha="+f.codActivoFecha.checked+"&fechaInicioB="+f.fechaInicioB.value+"&fechaFinalB="+f.fechaFinalB.value+"&pagina="+f.pagina.value;
}
function paginar1(f,pagina)
{		
		f.pagina.value=pagina*1;
location.href="navegadorCotizaciones.php?nrocotizacionB="+f.nrocotizacionB.value+"&codclienteB="+f.codclienteB.value+"&codItemB="+f.codItemB.value+"&codActivoFecha="+f.codActivoFecha.checked+"&fechaInicioB="+f.fechaInicioB.value+"&fechaFinalB="+f.fechaFinalB.value+"&pagina="+f.pagina.value;
		//location.href="navegadorCotizaciones.php?pagina="+f.pagina.value;		
}
function buscar(f){

location.href="navegadorCotizaciones.php?nrocotizacionB="+f.nrocotizacionB.value+"&codclienteB="+f.codclienteB.value+"&codItemB="+f.codItemB.value+"&codActivoFecha="+f.codActivoFecha.checked+"&fechaInicioB="+f.fechaInicioB.value+"&fechaFinalB="+f.fechaFinalB.value;
}

function imprimir(f)
{	
var i;
	var j=0;
	var cod_registro;
	for(i=0;i<=f.length-1;i++)
	{
		if(f.elements[i].type=='checkbox')
		{	
			if(f.elements[i].name=='cod_cotizacion'){
				if(f.elements[i].checked==true)
				{	vectorAuxiliar=f.elements[i].value.split("|");
					cod_registro=vectorAuxiliar[0];
					j=j+1;					
				}
			}
		}
	}
	if(j>1)
	{	alert('Debe seleccionar solamente un registro.');
	}
	else
	{
		if(j==0)
		{
			alert('Debe seleccionar un registro.');
		}
		else
		{
			izquierda = (screen.width) ? (screen.width-600)/2 : 100 
    		arriba = (screen.height) ? (screen.height-400)/2 : 100 
			url="../reportes/impresionCotizacion.php?cod_cotizacion="+cod_registro;
			//url="../reportes/impresionCotizacionImprimir.php?cod_cotizacion="+cod_registro;
			
			opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,width=700,height=580,left='+izquierda+ ',top=' + arriba + '' 
		   	window.open(url, 'popUp', opciones)					
		}
	}
}

function imprimirSinFondo(f)
{	
var i;
	var j=0;
	var cod_registro;
	for(i=0;i<=f.length-1;i++)
	{
		if(f.elements[i].type=='checkbox')
		{	
		
			if(f.elements[i].name=='cod_cotizacion'){
				if(f.elements[i].checked==true)
				{	vectorAuxiliar=f.elements[i].value.split("|");
					cod_registro=vectorAuxiliar[0];
					j=j+1;					
				}
			}
		}
	}
	if(j>1)
	{	alert('Debe seleccionar solamente un registro.');
	}
	else
	{
		if(j==0)
		{
			alert('Debe seleccionar un registro.');
		}
		else
		{
			izquierda = (screen.width) ? (screen.width-600)/2 : 100 
    		arriba = (screen.height) ? (screen.height-400)/2 : 100 
			url="../reportes/impresionCotizacionImprimir4.php?cod_cotizacion="+cod_registro;
			
			opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,width=700,height=580,left='+izquierda+ ',top=' + arriba + '' 
		   	window.open(url, 'popUp', opciones)					
		}
	}
}
function editar(f)
{	
	var i;
	var j=0;
	var cod_registro;
	var vectorAuxiliar=new Array();
	for(i=0;i<=f.length-1;i++)
	{
		if(f.elements[i].type=='checkbox')
		{	
			if(f.elements[i].name=='cod_cotizacion'){
				if(f.elements[i].checked==true)
				{	vectorAuxiliar=f.elements[i].value.split("|");
					if(vectorAuxiliar[1]==0){
						cod_registro=vectorAuxiliar[0];
						j=j+1;
					}else{
						alert("La Cotizacion seleccionada no puede ser Editada.");
						return false;
					}
					
				}
			}

		}
	}
	if(j>1)
	{	alert('Debe seleccionar solamente un registro para modificar.');
	}
	else
	{
		if(j==0)
		{
			alert('Debe seleccionar un registro para modificar.');
		}
		else
		{
			window.location="modificarCotizacion.php?codCotizacion="+cod_registro;
		}
	}
}


function anular(f)
{
	var i;
	var j=0;
	var cod_registro;
	for(i=0;i<=f.length-1;i++)
	{
		if(f.elements[i].type=='checkbox')
		{
			if(f.elements[i].name=='cod_cotizacion'){
				if(f.elements[i].checked==true)
				{	vectorAuxiliar=f.elements[i].value.split("|");
					if(vectorAuxiliar[1]==0){
						cod_registro=vectorAuxiliar[0];
						j=j+1;
					}else{
						alert("La Cotizacion seleccionada no puede ser Anulada.");
						return false;
					}
					
				}
			}
		
		}
	}
	if(j>1)
	{	alert('Debe seleccionar solamente un registro para anular.');
	}
	else
	{
		if(j==0)
		{
			alert('Debe seleccionar un registro para anular.');
		}
		else
		{
			if(confirm("Esta seguro de anular.")){
				window.location="anularRegistrarCotizacion.php?codCotizacion="+cod_registro;
			}else{
				return false;
			}
		}
	}
}

</script>
</head>
<body bgcolor="#F7F5F3">
<form name="form1" method="post" >

<h3 align="center" style="background:#F7F5F3;font-size: 14px;color: #E78611;font-weight:bold;">LISTADO DE  COTIZACIONES</h3>

<?php 
	require("conexion.inc");
	//include("funciones.php");
	
	
	$nrocotizacionB=$_GET['nrocotizacionB'];
	$codgestionB=$_GET['codgestionB'];
	$codItemB=$_GET['codItemB'];
	$codclienteB=$_GET['codclienteB'];
	$codActivoFecha=$_GET['codActivoFecha'];

	$fechaInicioB=$_GET['fechaInicioB'];
	$VectorFecha=explode("/",$fechaInicioB);
	$fechaInicioB_2=$VectorFecha[2]."-".$VectorFecha[1]."-".$VectorFecha[0];
	
	$fechaFinalB=$_GET['fechaFinalB'];
	$VectorFecha=explode("/",$fechaFinalB);
	$fechaFinalB_2=$VectorFecha[2]."-".$VectorFecha[1]."-".$VectorFecha[0];
	

?>

<table border="0" align="center">
<tr><td><strong>Nro de Cotizacion</strong></td>
<td colspan="3"><input type="text" name="nrocotizacionB" id="nrocotizacionB" size="10" class="textoform" value="<?php echo $nrocotizacionB;?>" ></td>

<td>
</td>
<td></td>
</tr>
<tr><td><strong>Item</strong></td>
<td colspan="3">
<select name="codItemB" id="codItemB" class="textoform" >
				<option value="0">Todos los Items</option>
				<?php
					$sql2="select cod_item,desc_item from items order by  desc_item asc";
					echo $sql2;	
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_item=$dat2[0];	
			  		 		$desc_item=$dat2[1];	
				 if($cod_item==$codItemB){		
				 ?>
				  <option value="<?php echo $cod_item;?>" selected="selected"><?php echo $desc_item;?></option>				
				<?php		
					}else{
				?>	
					 <option value="<?php echo $cod_item;?>"><?php echo $desc_item;?></option>				
				<?php		
					}
				?>	
				 
				
				<?php		
					}
				?>						
</select></td>

<td>
</td>
<td></td>
</tr>
<tr><td><strong>Clientes</strong></td>
<td colspan="3">
<select name="codclienteB" id="codclienteB" class="textoform" >
				<option value="0">Todos los Clientes</option>
				<?php
					$sql2="select cod_cliente,nombre_cliente from clientes order by  nombre_cliente asc";
					echo $sql2;	
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_cliente=$dat2[0];	
			  		 		$nombre_cliente=$dat2[1];	
				 if($cod_cliente==$codclienteB){		
				 ?>
				  <option value="<?php echo $cod_cliente;?>" selected="selected"><?php echo $nombre_cliente;?></option>				
				<?php		
					}else{
				?>	
					 <option value="<?php echo $cod_cliente;?>"><?php echo $nombre_cliente;?></option>				
				<?php		
					}
				?>	
				 
				
				<?php		
					}
				?>						
</select>
	</td>
	<td rowspan="2"><a   onClick="buscar(form1)"><img src="images/buscar_header.jpg" border="0" alt="Buscar"></a></td>
</tr>

<tr >
     		<td>&nbsp;<b>Rango de Fecha</b>&nbsp;</td>			
     		<td>
				de&nbsp;<input type="text" class="textoform" size="12"  value="<?php echo $fechaInicioB;?>" name="fechaInicioB" id="fechaInicioB" >
				&nbsp;hasta&nbsp;<input type="text" class="textoform" size="12"  value="<?php echo $fechaFinalB;?>" name="fechaFinalB" id="fechaFinalB" >
				<input type="checkbox" name="codActivoFecha" id="codActivoFecha" <?php if($codActivoFecha=="true"){echo "checked='checked'";} ?> >
			</td>
   	</tr>
</table>

	<table align="center" >
		<tr>
			<td styleClass="tituloCampo" style="vertical-align:cente;text-align:center;font-weight:bold;">Leyenda ::</td>
			<td styleClass="tituloCampo">Normal ::</td>
			<td styleClass="tituloCampo" style="width:50px;border:1px solid #000000;"></td>
			<td styleClass="tituloCampo">Anulado ::</td>
			<td styleClass="tituloCampo" style="width:50px;border:1px solid #000000;background-color:white;background:#FF5955;"></td>
		</tr>
	</table>
	
<?php	
	//Paginador
	
	
	$nro_filas_show=15;	
	$pagina=$_GET['pagina'];
	//echo $pagina;
	if ($pagina==""){
		$pagina = 1;
		$fila_inicio=0;
		$fila_final=$nro_filas_show;
	}else{
		$fila_inicio=(($pagina*$nro_filas_show)-$nro_filas_show);
		$fila_final=($fila_inicio+$nro_filas_show);
		//echo  "Fila Inicio".$fila_inicio."fila final".$fila_final;
	}	
	
	
	
	$sql=" select count(*) from cotizaciones where cod_cotizacion<>0 ";
		if($nrocotizacionB<>""){
			$sql.=" and nro_cotizacion=".$nrocotizacionB;
		}
	if($codgestionB<>0 && $codgestionB<>""){
		$sql.=" and cod_gestion=".$codgestionB;
	}
	if($codclienteB<>0 && $codclienteB<>""){
		$sql.=" and cod_cliente=".$codclienteB;
	}

	if($codItemB<>0 && $codItemB<>""){
		$sql.=" and cod_cotizacion in(select cod_cotizacion from cotizaciones_detalle where cod_item=".$codItemB.")";
	}

	if($codActivoFecha=="true"){
		if($fechaInicioB<>"" && $fechaFinalB<>"" ){
			$sql.=" and (fecha_cotizacion>='".$fechaInicioB_2."' and fecha_cotizacion<='".$fechaFinalB_2."')";
		}
	}
	

	$resp_aux = mysql_query($sql);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}
	//echo $sql;
?>
<h3 align="center" style="background:#F7F5F3;font-size: 10px;color:#E78611;font-weight:bold;">Nro de Registros <?php echo $nro_filas_sql;?></h3>
<?php	
	if($nro_filas_sql==0){
?>

	<table width="95%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>&nbsp;</td>
			<td>No.</td>
    		<td>Fecha</td>	
			<td>Cliente</td>						
			<td>Tipo de Pago</td>						
    		<td>Tipo de Cotizacion</td>
			<td>Observacion</td>
    		<td>Estado</td>
    		<td>Usuario</td>
		</tr>
		<tr><th colspan="10" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
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
		$sql=" SELECT COD_COTIZACION,NRO_COTIZACION,FECHA_COTIZACION,COD_CLIENTE,COD_TIPO_COTIZACION";
		$sql.=" ,COD_ESTADO_COTIZACION,OBS_COTIZACION,COD_TIPO_PAGO,COD_USUARIO_REGISTRO, cod_gestion FROM COTIZACIONES where cod_cotizacion<>0 ";
		if($nrocotizacionB<>""){
			$sql.=" and nro_cotizacion=".$nrocotizacionB;
		}
	if($codgestionB<>0 && $codgestionB<>""){
		$sql.=" and cod_gestion=".$codgestionB;
	}
	if($codclienteB<>0 && $codclienteB<>""){
		$sql.=" and cod_cliente=".$codclienteB;
	}
		if($codItemB<>0 && $codItemB<>""){
		$sql.=" and cod_cotizacion in(select cod_cotizacion from cotizaciones_detalle where cod_item=".$codItemB.")";
	}

	if($codActivoFecha=="true"){
		if($fechaInicioB<>"" && $fechaFinalB<>"" ){
			$sql.=" and (fecha_cotizacion>='".$fechaInicioB_2."' and fecha_cotizacion<='".$fechaFinalB_2."')";
		}
	}
	
		$sql.=" ORDER BY COD_COTIZACION desc";
		$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		$resp = mysql_query($sql);
		$cont=0;
?>	
	<table width="95%" align="center" cellpadding="1" id="cotizacion" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td width="4%">&nbsp;</td>
			<td width="7%">No.</td>
    		<td width="8%">Fecha</td>	
			<td>Cliente</td>						
			<td width="10%">Tipo de Pago</td>									
    		<td>Tipo de Cotizaci&oacute;n</td>
			<td>Observaci&oacute;n</td>
    		<td width="7%">Estado</td>
    		<td>Usuario</td>
    		<!--td width="7%">Detalle</td-->
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>

<?php   
		while($dat=mysql_fetch_array($resp)){	
				$cont++;
				$codCotizacion=$dat[0];
				$nroCotizacion=$dat[1];
				$fechaCotizacion=$dat[2];
				$codCliente=$dat[3];
				$codTipoCotizacion=$dat[4];
				$codEstadoCotizacion=$dat[5];
				$obsCotizacion=$dat[6];
				$codTipoPago=$dat[7];
				$codUsuarioRegistro=$dat[8];
				$codGestion=$dat[9];
				$fechaCotizacionVecto=explode(" ",$fechaCotizacion);
				$fechaCotizacionVectoAux=explode("-",$fechaCotizacionVecto[0]);
				$styl="";
				if($codEstadoCotizacion==2){
					$styl="width:50px;border:0px solid #000000;background-color:white;background:#FF5955;";
				}
				//**************************************************************
					$nombreCliente="";				
					$sql2="select nombre_cliente from clientes";
					$sql2.=" where cod_cliente='".$codCliente."'";	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nombreCliente=$dat2[0];
					}
				//**************************************************************								
				//**************************************************************
					$nombreTipoCotizacion="";				
					$sql2="select nombre_tipo_cotizacion from tipos_cotizacion";
					$sql2.=" where cod_tipo_cotizacion='".$codTipoCotizacion."'";	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nombreTipoCotizacion=$dat2[0];
					}
				//**************************************************************
				//**************************************************************
					$nombreEstadoCotizacion="";				
					$sql2="select nombre_estado_cotizacion from estados_cotizacion";
					$sql2.=" where cod_estado_cotizacion='".$codEstadoCotizacion."'";	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nombreEstadoCotizacion=$dat2[0];
					}
				//**************************************************************
				//**************************************************************
					$nombreTipoPago="";				
					$sql2="select nombre_tipo_pago from tipos_pago";
					$sql2.=" where cod_tipo_pago='".$codTipoPago."'";	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nombreTipoPago=$dat2[0];
					}
				//**************************************************************
				//**************************************************************
					$nombreUsuarioRegistro="";
					$sql2="select nombres_usuario,ap_paterno_usuario from usuarios";
					$sql2.=" where cod_usuario='".$codUsuarioRegistro."'";	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nombreUsuarioRegistro=$dat2[0]." ".$dat2[1];
					}	
				//**************************************************************
					$gestion="";				
					$sql2="select gestion from gestiones";
					$sql2.=" where cod_gestion='".$codGestion."'";	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$gestion=$dat2[0];
					}
				//**************************************************************	
				
				///////Verificacion si la Cotizacion tiene su Hoja de Ruta Activa//////////////////
					$sql2="  select count(*) swHojasRuta from hojas_rutas ";
					$sql2.=" where cod_cotizacion='".$codCotizacion."' and (cod_estado_hoja_ruta=1 or cod_estado_hoja_ruta=3)";
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$swHojasRuta=$dat2[0];
					}					
				///////Fin 	Verificacion si la Cotizacion tiene su Hoja de Ruta Activa//////////////							
?> 
		<tr bgcolor="#FFFFFF">	
			<?php if($codEstadoCotizacion==1 || $codEstadoCotizacion==3){?>
			
			<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);"><input type="checkbox"name="cod_cotizacion"value="<?php echo $codCotizacion."|".$swHojasRuta;?>"></td>					
    		<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);">&nbsp;&nbsp;<?php echo $nroCotizacion."/".$gestion;?></td>
    		<td align="center" style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);"><?php echo $fechaCotizacionVectoAux[2]."/".$fechaCotizacionVectoAux[1]."/".$fechaCotizacionVectoAux[0];?></td>
    		<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);"><?php echo $nombreCliente;?></td>
    		<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);"><?php echo $nombreTipoPago;?></td>			
    		<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);"><?php echo $nombreTipoCotizacion;?></td>			
    		<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);"><?php echo $obsCotizacion;?></td>
    		<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);"><?php echo $nombreEstadoCotizacion;?></td>
    		<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);"><?php echo $nombreUsuarioRegistro;?></td>			
    		<!--td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);"><a href=""  onclick="openPopup('cotizacionesDetalle.php?codigo=<?php echo $codCotizacion;?>');" title="Click para ver detalle">Detalle</a></td-->
			<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);"><a href=""  onclick="openPopup('replicarCotizacion.php?codigo=<?php echo $codCotizacion;?>');" title="Click para Copiar">Copiar</a></td>
			<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);">
			<?php if($swHojasRuta==0){?>
				<a href="generarHojaRuta.php?cod_cotizacion=<?php echo $codCotizacion;?>">Genera Hoja Ruta</a>
			<?php }else{?>
				Genera Hoja Ruta
			<?php }?>
			</td>			
			
			<?php }else{?>
			
			<td style="<?php echo $styl;?>">&nbsp;</td>
    		<td style="<?php echo $styl;?>">&nbsp;&nbsp;<?php echo $nroCotizacion;?></td>
    		<td align="center" style="<?php echo $styl;?>"><?php echo $fechaCotizacionVectoAux[2]."/".$fechaCotizacionVectoAux[1]."/".$fechaCotizacionVectoAux[0];?></td>
    		<td style="<?php echo $styl;?>"><?php echo $nombreCliente;?></td>
    		<td style="<?php echo $styl;?>"><?php echo $nombreTipoPago;?></td>			
    		<td style="<?php echo $styl;?>"><?php echo $nombreTipoCotizacion;?></td>			
    		<td style="<?php echo $styl;?>"><?php echo $obsCotizacion;?></td>
    		<td style="<?php echo $styl;?>"><?php echo $nombreEstadoCotizacion;?></td>
    		<td style="<?php echo $styl;?>"><?php echo $nombreUsuarioRegistro;?></td>			
    		<!--td style="<?php echo $styl;?>"><a href=""  onclick="openPopup('cotizacionesDetalle.php?codigo=<?php echo $codCotizacion;?>');" title="Click para ver detalle">Detalle</a></td-->
			<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);">Copiar</td>
			<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);">Generar Hoja Ruta </td>			
			
			<?php }?>
   	  </tr>
<?php
		 } 
?>			
  			<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="13">
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
  </TABLE>
		
<?php
	}
?>
		
<?php require("cerrar_conexion.inc");
?>
<br>
<div align="center">
	<INPUT type="button" class="boton" name="btn_editar"  value="Editar" onClick="editar(this.form);">
	<INPUT type="button" class="boton" name="btn_anular"  value="Anular" onClick="anular(this.form);">
	<INPUT type="button" class="boton" name="btn_eliminar"  value="Imprimir con Fondo" onClick="imprimir(this.form);">
	<!--INPUT type="button" class="boton" name="btn_eliminar"  value="Imprimir sin Fondo" onClick="imprimir2(this.form);"-->
	<INPUT type="button" class="boton" name="btn_eliminar"  value="Imprimir sin Fondo 2" onClick="imprimirSinFondo(this.form);">
	
</div>

</form>
</body>
</html>
