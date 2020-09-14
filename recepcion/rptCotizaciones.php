<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Usuarios</title>
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
	location.href="navegadorCotizaciones.php?pagina="+f.pagina.value;
		
}
function registrar(f){
alert("En construccion");
	//f.submit();
}
function editar(f)
{	
	var i;
	var j=0;
	var cod_registro;
	for(i=0;i<=f.length-1;i++)
	{
		if(f.elements[i].type=='checkbox')
		{	if(f.elements[i].checked==true)
			{	cod_registro=f.elements[i].value;
				j=j+1;
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
		{	if(f.elements[i].checked==true)
			{	cod_registro=f.elements[i].value;
				j=j+1;
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Rene Ergueta Illanes
02 de Julio de 2008
-->
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">NAVEGADOR COTIZACIONES</h3>
<form name="form1" method="get" action="registrarGestion.php" >
<?php 
	require("conexion.inc");
	include("funciones.php");
	$codClienteF = $_POST['codClienteF'];
	$codTipoCotizacionF = $_POST['codTipoCotizacionF'];
	$codEstadoCotizacionF = $_POST['codEstadoCotizacionF'];
	$codTipoPagoF= $_POST['codTipoPagoF'];
	$fechaInicioF = $_POST['fechaInicioF'];
	$fechaFinalF = $_POST['fechaFinalF'];
	$codItemF = $_POST['codItemF'];
	$codActivoFechaF = $_POST['codActivoFechaF'];
	/*echo "codCliente:".$codClienteF;
	echo "codTipoCliente:".$codTipoCotizacionF;
	echo "codEstadoCliente:".$codEstadoCotizacionF;
	echo "fechaInicio:".$fechaInicioF;
	echo "fechaFinal:".$fechaFinalF;*/
	if($codItemF==""){
		$codItemF=0;
	}
	$fechaInicioFaux = explode("/", $fechaInicioF);
	$fechaFinalFaux = explode("/", $fechaFinalF);
	$fechaI = $fechaInicioFaux[2] . "/" . $fechaInicioFaux[1] . "/" . $fechaInicioFaux[0];
	$fechaF = $fechaFinalFaux[2] . "/" . $fechaFinalFaux[1] . "/" . $fechaFinalFaux[0];	
?>
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
	$nro_filas_show=10;	
	$pagina = $_GET['pagina'];

	if ($pagina == ""){
		$pagina = 1;
		$fila_inicio=0;
		$fila_final=$nro_filas_show;
	}else{
		$fila_inicio=(($pagina*$nro_filas_show)-$nro_filas_show);
		$fila_final=($fila_inicio+$nro_filas_show);
	}	
	
	$sql_aux=" select count(*) from cotizaciones ";
	$resp_aux = mysql_query($sql_aux);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}
	if($nro_filas_sql==0){
?>
	<table width="95%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>&nbsp;</td>
			<td>N&uacute;mero</td>
    		<td>Fecha</td>	
			<td>Cliente</td>						
			<td>Tipo de Pago</td>						
    		<td>Tipo de Cotizacion</td>
			<td>Observacion</td>
    		<td>Estado</td>
    		<td>Usuario</td>
    		<td>Detalle</td>
			<td>Replicar</td>
		</tr>
		<tr><th colspan="9" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
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
		$sql=" SELECT c.COD_COTIZACION,c.NRO_COTIZACION,c.FECHA_COTIZACION,c.COD_CLIENTE,c.COD_TIPO_COTIZACION";
		$sql.=" ,c.COD_ESTADO_COTIZACION,c.OBS_COTIZACION,c.COD_TIPO_PAGO,c.COD_USUARIO_REGISTRO FROM COTIZACIONES c";
		$sql.=" where c.fecha_cotizacion>='1990/01/01'";
		if($codActivoFechaF==1){
			$sql.=" and c.fecha_cotizacion BETWEEN '".$fechaI." 00:00:00' and '".$fechaF." 23:59:59'";
		}		
		if($codClienteF!=0){
			$sql.=" and c.cod_cliente=".$codClienteF;
		}
		if($codTipoCotizacionF!=0){
			$sql.=" and c.cod_tipo_cotizacion in (".$codTipoCotizacionF.") ";
		}
		if($codEstadoCotizacionF!=0){
			$sql.=" and c.cod_tipo_cotizacion in (".$codEstadoCotizacionF.") ";
		}
		if($codTipoPagoF!=0){
			$sql.=" and c.cod_tipo_cotizacion in (".$codTipoPagoF.") ";
		}				
		if($codItemF!=0){
			$sql.=" and c.COD_COTIZACION in (select cd.cod_cotizacion from cotizaciones_detalle cd where c.cod_cotizacion=cd.cod_cotizacion and cd.cod_item in (".$codItemF."))";
		}
		$sql.=" ORDER BY COD_COTIZACION desc";
		$sql.=" limit ".$fila_inicio." , ".$fila_final;
		$resp = mysql_query($sql);
		$cont=0;
?>	
	<table width="95%" align="center" cellpadding="1" id="cotizacion" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td width="4%">&nbsp;</td>
			<td width="7%">N&uacute;mero</td>
    		<td width="8%">Fecha</td>	
			<td>Cliente</td>						
			<td width="10%">Tipo de Pago</td>									
    		<td>Tipo de Cotizaci&oacute;n</td>
			<td>Observaci&oacute;n</td>
    		<td width="7%">Estado</td>
    		<td>Usuario</td>
    		<td width="7%">Detalle</td>		
			<td>Replicar</td>	
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
?> 
		<tr bgcolor="#FFFFFF">	
			<?php if($codEstadoCotizacion==1){?>
			<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);"><input type="checkbox"name="cod_cotizacion"value="<?php echo $codCotizacion;?>"></td>					
    		<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);">&nbsp;&nbsp;<?php echo $nroCotizacion;?></td>
    		<td align="center" style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);"><?php echo $fechaCotizacionVectoAux[2]."/".$fechaCotizacionVectoAux[1]."/".$fechaCotizacionVectoAux[0];?></td>
    		<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);"><?php echo $nombreCliente;?></td>
    		<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);"><?php echo $nombreTipoPago;?></td>			
    		<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);"><?php echo $nombreTipoCotizacion;?></td>			
    		<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);"><?php echo $obsCotizacion;?></td>
    		<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);"><?php echo $nombreEstadoCotizacion;?></td>
    		<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);"><?php echo $nombreUsuarioRegistro;?></td>			
    		<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);"><a href=""  onclick="openPopup('cotizacionesDetalle.php?codigo=<?php echo $codCotizacion;?>');" title="Click para ver detalle">Detalle</a></td>				
			<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);"><a href=""  onclick="openPopup('replicarCotizacion.php?codigo=<?php echo $codCotizacion;?>');" title="Click para replicar">Replicar</a></td>
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
    		<td style="<?php echo $styl;?>"><a href=""  onclick="openPopup('cotizacionesDetalle.php?codigo=<?php echo $codCotizacion;?>');" title="Click para ver detalle">Detalle</a></td>
			<td style="<?php echo $styl;?>" onmouseout="onrowmouseout(<?php echo $cont;?>);" onmouseover="onrowmouseover(<?php echo $cont;?>);">Replicar</td>
			<?php }?>
    	 </tr>
<?php
		 } 
?>			
  			<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="13">
					Pagina <?php echo $pagina; ?> de <?php echo $nropaginas; ?>&nbsp;&nbsp;&nbsp;	
					<select onchange="paginar(this.form);" name="pagina" >
				    <?php for($i=1;$i<=$nropaginas;$i++){	
							if($pagina==$i){
					?>
								<option value="<?php echo $i; ?>"  selected><?php echo $i; ?></option>";
				    	<?php }else{?>	
								<option value="<?php echo $i; ?>"  ><?php echo $i; ?></option>";
						<?php }?>						
					<?php }?>
					</select>													
				</td>
			</tr>
		</TABLE>
		</div>			
<?php
	}
?>
		
<?php require("cerrar_conexion.inc");
?>
<br>
<div align="center">
	<!--<INPUT type="button" class="boton" name="btn_registrar"  value="Registrar" onClick="registrar(this.form);">	-->
	<INPUT type="button" class="boton" name="btn_editar"  value="Editar" onClick="editar(this.form);">
	<INPUT type="button" class="boton" name="btn_anular"  value="Anular" onClick="anular(this.form);">
	
</div>

</form>
</body>
</html>
