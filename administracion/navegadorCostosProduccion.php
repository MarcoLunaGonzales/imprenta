<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>COSTOS DE PRODUCCION</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>

function paginar(f)
{	
		location.href="navegadorCostosProduccion.php?pagina="+f.pagina.value;		
}
function paginar1(f,pagina)
{		
		f.pagina.value=pagina*1;
		location.href="navegadorCostosProduccion.php?pagina="+f.pagina.value;		
}
function buscar(f){

location.href="navegadorCostosProduccion.php?nrocotizacionB="+f.nrocotizacionB.value+"&codclienteB="+f.codclienteB.value+"&codActivoFecha="+f.codActivoFecha.checked+"&fechaInicioB="+f.fechaInicioB.value+"&fechaFinalB="+f.fechaFinalB.value+"&pagina="+f.pagina.value;
}

</script>
</head>
<body bgcolor="#F7F5F3">
<form name="form1" method="post" >
<h3 align="center" style="background:#F7F5F3;font-size: 14px;color: #E78611;font-weight:bold;">DETALLE DE GASTOS</h3>


<?php 
	require("conexion.inc");
	include("funciones.php");
	
	
	$nrocotizacionB=$_GET['nrocotizacionB'];
	$codgestionB=$_GET['codgestionB'];
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
<td colspan="3"><input type="text" name="nrocotizacionB" size="10" class="textoform" value="<?php echo $nrocotizacionB;?>" ></td>

<td>
</td>
<td></td>
</tr>
<tr><td><strong>Clientes</strong></td>
<td colspan="3">
<select name="codclienteB" class="textoform" >
				<option value="0">Todos los Clientes</option>
				<?php
					$sql2="select cod_cliente,nombre_cliente from clientes order by  nombre_cliente asc";
						
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

<tr>
     		<td>&nbsp;<b>Rango de Fecha</b>&nbsp;</td>			
     		<td>
				de&nbsp;<input type="text" class="textoform" size="12"  value="<?php echo $fechaInicioB;?>" name="fechaInicioB" id="fechaInicioB" >
				&nbsp;hasta&nbsp;<input type="text" class="textoform" size="12"  value="<?php echo $fechaFinalB;?>" name="fechaFinalB" id="fechaFinalB" >
				<input type="checkbox" name="codActivoFecha" id="codActivoFecha" <?php if($codActivoFecha=="true"){echo "checked='checked'";} ?> >
			</td>
   	</tr>
</table>

	
<?php	
	//Paginador
	
	
	$nro_filas_show=50;	
	$pagina=$_GET['pagina'];
	if ($pagina==""){
		$pagina = 1;
		$fila_inicio=0;
		$fila_final=$nro_filas_show;
	}else{
		$fila_inicio=(($pagina*$nro_filas_show)-$nro_filas_show);
		$fila_final=($fila_inicio+$nro_filas_show);
	}	
	
	
	
	$sql=" select count(*) from cotizaciones ";
	$sql.=" where cod_estado_cotizacion=1 ";
	$sql.=" and cod_cotizacion in(select cod_cotizacion from hojas_rutas where cod_estado_hoja_ruta=1)";
		if($nrocotizacionB<>""){
			$sql.=" and nro_cotizacion=".$nrocotizacionB;
		}
	if($codgestionB<>0 && $codgestionB<>""){
		$sql.=" and cod_gestion=".$codgestionB;
	}
	if($codclienteB<>0 && $codclienteB<>""){
		$sql.=" and cod_cliente=".$codclienteB;
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
?>
<h3 align="center" style="background:#F7F5F3;font-size: 10px;color:#E78611;font-weight:bold;">Nro de Registros <?php echo $nro_filas_sql;?></h3>
<?php	
	if($nro_filas_sql==0){
?>

	<table width="95%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>Hoja de Ruta</td>			
    		<td>Fecha</td>	
			<td>Cliente</td>															
    		<td>Tipo de Cotizaci&oacute;n</td>
			<td>Tipo de Pago</td>			
			<td>Firmado Por:</td>
    		<td>Registrado por </td>
    		<td>Editado por </td>
			<td>No. Cot. </td>
			<td>Notas de Remision</td>
			<td>Gastos</td>
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
		
		$sql=" select cod_cotizacion, cod_tipo_cotizacion, cod_estado_cotizacion, ";
		$sql.=" cod_gestion, nro_cotizacion, cod_cliente, fecha_cotizacion, obs_cotizacion, cod_tipo_pago, ";
		$sql.=" cod_sumar, considerar_precio_unitario, cod_usuario_registro, fecha_registro, ";
		$sql.=" cod_usuario_modifica, fecha_modifica, obs_cotizacion_impresion, cod_usuario_firma ";
		$sql.=" from cotizaciones ";
		$sql.=" where cod_estado_cotizacion=1 ";
		$sql.=" and cod_cotizacion in(select cod_cotizacion from hojas_rutas where cod_estado_hoja_ruta=1) ";		
		
		if($nrocotizacionB<>""){
			$sql.=" and nro_cotizacion=".$nrocotizacionB;
		}
	if($codgestionB<>0 && $codgestionB<>""){
		$sql.=" and cod_gestion=".$codgestionB;
	}
	if($codclienteB<>0 && $codclienteB<>""){
		$sql.=" and cod_cliente=".$codclienteB;
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
			<td>&nbsp;</td>
			<td>Hoja de Ruta</td>			
    		<td>Fecha</td>	
			<td>Cliente</td>															
    		<td>Tipo de Cotizaci&oacute;n</td>
			<td>Tipo de Pago</td>			
			<td>Firmado Por:</td>
    		<td>Registrado por </td>
    		<td>Editado por </td>
			<td>No. Cot. </td>
			<td>Notas de Remision</td>
			<td>Gastos</td>
		</tr>

<?php   
		while($dat=mysql_fetch_array($resp)){	
				
				$cod_cotizacion=$dat[0];
				$cod_tipo_cotizacion=$dat[1];			
				$cod_estado_cotizacion=$dat[2];
				$cod_gestion=$dat[3];				
				$nro_cotizacion=$dat[4];
				$cod_cliente=$dat[5];			
				$fecha_cotizacion=$dat[6];
				$fechaCotizacionVectoAux=explode("-",$fecha_cotizacion);
				$obs_cotizacion=$dat[7];
				$cod_tipo_pago=$dat[8];								
				$cod_sumar=$dat[9];
				$considerar_precio_unitario=$dat[10];
				$cod_usuario_registro=$dat[11];
				$fecha_registro=$dat[12];
				$fechaRegistroFormato="";
				if($fecha_registro<>""){
					$fechaRegistroVector=explode(" ",$fecha_registro);
					$fechaRegistroVector2=explode("-",$fechaRegistroVector[0]);
					$fechaRegistroFormato=$fechaRegistroVector2[2]."/".$fechaRegistroVector2[1]."/".$fechaRegistroVector2[0]." ".$fechaRegistroVector[1];
				}
				$cod_usuario_modifica=$dat[13];
				$fecha_modifica=$dat[14];
				$fechaModificaFormato="";
				if($fecha_modifica<>""){
					$fechaModificaVector=explode(" ",$fecha_modifica);
					$fechaModificaVector2=explode("-",$fechaModificaVector[0]);
					$fechaModificaFormato=$fechaModificaVector2[2]."/".$fechaModificaVector2[1]."/".$fechaModificaVector2[0]." ".$fechaModificaVector[1];
				}				
				$obs_cotizacion_impresion=$dat[15]; 
				$cod_usuario_firma=$dat[16];
				
				//***************************TIPO COTIZACION***********************************
				$nombre_tipo_cotizacion="";				
				$sql2="select nombre_tipo_cotizacion from tipos_cotizacion where cod_tipo_cotizacion='".$cod_tipo_cotizacion."'";	
				$resp2= mysql_query($sql2);
				$dat2=mysql_fetch_array($resp2);
					$nombre_tipo_cotizacion=$dat2[0];
				//*******************************FIN TIPO COTIZACION*******************************	
				//*****************************GESTION*********************************
					$gestion="";				
					$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion."'";	
					$resp2= mysql_query($sql2);
					$dat2=mysql_fetch_array($resp2);
						$gestion=$dat2[0];
				//******************************FIN GESTION********************************		
				//*****************************CLIENTE*********************************
					$nombre_cliente="";				
					$sql2="select nombre_cliente from clientes where cod_cliente='".$cod_cliente."'";	
					$resp2= mysql_query($sql2);
					$dat2=mysql_fetch_array($resp2);
						$nombre_cliente=$dat2[0];
				//*****************************FIN CLIENTE*********************************			
				//******************************TIPO DE PAGO********************************
					$nombre_tipo_pago="";				
					$sql2="select nombre_tipo_pago from tipos_pago where cod_tipo_pago='".$cod_tipo_pago."'";	
					$resp2= mysql_query($sql2);
					$dat2=mysql_fetch_array($resp2);
					$nombre_tipo_pago=$dat2[0];
				//*******************************FIN TIPO PAGO*******************************	
				//******************************USUARIO REGISTRO********************************
					$usuarioRegistro="";				
					$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios";
					$sql2.=" where cod_usuario='".$cod_usuario_registro."'";	
					$resp2= mysql_query($sql2);
					$dat2=mysql_fetch_array($resp2);
					$usuarioRegistro=substr($dat2[0],0).substr($dat2[1],0).substr($dat2[2],0);
				//*******************************FIN USUARIO REGISTRO*******************************									
				
				//******************************USUARIO MODIFICA********************************
					$usuarioModifica="";				
					$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios";
					$sql2.=" where cod_usuario='".$cod_usuario_modifica."'";	
					$resp2= mysql_query($sql2);
					$dat2=mysql_fetch_array($resp2);
					$usuarioModifica=substr($dat2[0],0).substr($dat2[1],0).substr($dat2[2],0);
				//*******************************FIN USUARIO MODIFICA*******************************
								
				///////Verificacion si la Cotizacion tiene su Hoja de Ruta Activa//////////////////
					$sql2="  select cod_hoja_ruta, cod_gestion, nro_hoja_ruta from hojas_rutas ";
					$sql2.=" where cod_cotizacion='".$cod_cotizacion."' and cod_estado_hoja_ruta=1";
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$cod_hoja_ruta=$dat2[0]; 
						$cod_gestion_hoja_ruta=$dat2[1];
						$nro_hoja_ruta=$dat2[2];						
						$gestionHojaRuta="";
						/////////////////////////////////////////////////////////////////////				
							$sql3="select gestion from gestiones where cod_gestion='".$cod_gestion_hoja_ruta."'";	
							$resp3= mysql_query($sql3);
							$dat3=mysql_fetch_array($resp3);
							$gestionHojaRuta=$dat3[0];												
						//////////////////////////////////////////////////////////////////////////

							
					}
				///////Fin 	Verificacion si la Cotizacion tiene su Hoja de Ruta Activa//////////////	
				//******************************USUARIO FIRMA********************************
					$usuarioFirma="";				
					$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios";
					$sql2.=" where cod_usuario='".$cod_usuario_firma."'";	
					$resp2= mysql_query($sql2);
					$dat2=mysql_fetch_array($resp2);
					$usuarioFirma=substr($dat2[0],0).substr($dat2[1],0).substr($dat2[2],0);
				//*******************************FIN USUARIO FIRMA*******************************										
?> 
		<tr bgcolor="#FFFFFF">			
			<td><input type="checkbox"name="cod_cotizacion"value="<?php echo $cod_cotizacion; ?>"></td>					
    		<td><?php echo $nro_hoja_ruta."/".$gestionHojaRuta?></td>
    		<td><?php echo $fechaCotizacionVectoAux[2]."/".$fechaCotizacionVectoAux[1]."/".$fechaCotizacionVectoAux[0]; ?></td>	
			<td><?php echo $nombre_cliente;?></td>															
    		<td><?php echo $nombre_tipo_cotizacion;?></td>
			<td><?php echo $nombre_tipo_pago;?></td>			
			<td><?php echo $usuarioFirma;?></td>
    		<td><?php echo $usuarioRegistro." ".$fechaRegistroFormato;?></td>
    		<td><?php echo $usuarioModifica." ".$fechaModificaFormato;?></td>
			<td><?php echo $nro_cotizacion."/".$gestion;?></td>
			
			<td><?php
					if($cod_hoja_ruta<>""){
						$sql3="select cod_nota_remision, cod_gestion, nro_nota_remision ";
						$sql3.=" from notas_remision where cod_hoja_ruta=".$cod_hoja_ruta;
						$resp3= mysql_query($sql3);
						while ($dat3=mysql_fetch_array($resp3)){
							$cod_nota_remision=$dat3[0];
							$cod_gestion_nota_remision=$dat3[1];
							$nro_nota_remision=$dat3[2];
							/////////////////////////////////////////////////////////////////////				
							$sql4="select gestion from gestiones where cod_gestion='".$cod_gestion_nota_remision."'";	
							$resp4= mysql_query($sql4);
							$dat4=mysql_fetch_array($resp4);
							$gestionNotaRemision=$dat4[0];												
							//////////////////////////////////////////////////////////////////////////
						echo $nro_nota_remision."/".$gestionNotaRemision."; ";										
						}
					}
			
			 ?>
		  </td>
			 <td><a href="gastosDeTrabajo.php?cod_cotizacion=<?php echo $cod_cotizacion;?>" target="_blank" >Gastos</a></td>			

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


</form>
</body>
</html>
