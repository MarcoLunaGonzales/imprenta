<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>Notas de Remision</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
function paginar(f)
{	
		
	var param='?nroNotaRemisionB='+f.nroNotaRemisionB.value;
	param+='&nroHojaRutaB='+f.nroHojaRutaB.value;
	param+='&codclienteB='+f.codclienteB.value;
	param+='&codActivoFecha='+f.codActivoFecha.checked;
	param+='&fechaInicioB='+f.fechaInicioB.value;
	param+='&fechaFinalB='+f.fechaFinalB.value;
	param+='&pagina='+f.pagina.value;

		
	location.href="navegadorNotasRemision.php"+param;	
}
function paginar1(f,pagina)
{		
		f.pagina.value=pagina*1;
	var param='?nroNotaRemisionB='+f.nroNotaRemisionB.value;
	param+='&nroHojaRutaB='+f.nroHojaRutaB.value;
	param+='&codclienteB='+f.codclienteB.value;
	param+='&codActivoFecha='+f.codActivoFecha.checked;
	param+='&fechaInicioB='+f.fechaInicioB.value;
	param+='&fechaFinalB='+f.fechaFinalB.value;
	param+='&pagina='+f.pagina.value;

		
	location.href="navegadorNotasRemision.php"+param;			
}
function buscar(f){

	var param='?nroNotaRemisionB='+f.nroNotaRemisionB.value;
	param+='&nroHojaRutaB='+f.nroHojaRutaB.value;
	param+='&codclienteB='+f.codclienteB.value;
	param+='&codActivoFecha='+f.codActivoFecha.checked;
	param+='&fechaInicioB='+f.fechaInicioB.value;
	param+='&fechaFinalB='+f.fechaFinalB.value;
		
	location.href="navegadorNotasRemision.php"+param;
}

</script>
</head>
<body bgcolor="#F7F5F3">
<form name="form1" method="post"  id="form1">
<?php
	require("conexion.inc");
	include("funciones.php");
	
	$nroNotaRemisionB=$_GET['nroNotaRemisionB'];
	$codclienteB=$_GET['codclienteB'];
	$codActivoFecha=$_GET['codActivoFecha'];
	$nroHojaRutaB=$_GET['nroHojaRutaB'];

	$fechaInicioB=$_GET['fechaInicioB'];
	$VectorFecha=explode("/",$fechaInicioB);
	$fechaInicioB_2=$VectorFecha[2]."-".$VectorFecha[1]."-".$VectorFecha[0];
	
	$fechaFinalB=$_GET['fechaFinalB'];
	$VectorFecha=explode("/",$fechaFinalB);
	$fechaFinalB_2=$VectorFecha[2]."-".$VectorFecha[1]."-".$VectorFecha[0];
	

?>
<h3 align="center" style="background:#F7F5F3;font-size: 14px;color: #E78611;font-weight:bold;">LISTADO DE NOTAS DE REMISION</h3>
<table border="0" align="center">
<tr>
<td><strong>Nro de Nota de Remision </strong></td>
<td colspan="3"><input type="text" name="nroNotaRemisionB" id="nroNotaRemisionB" size="10" class="textoform" value="<?php echo $nroNotaRemisionB;?>" ></td>
</tr>
<tr>
<td><strong>Nro de Hoja de Ruta</strong></td>
<td colspan="3"><input type="text" name="nroHojaRutaB" id="nroHojaRutaB" size="10" class="textoform" value="<?php echo $nroHojaRutaB;?>" ></td>
</tr>
<tr><td><strong>Clientes</strong></td>
<td colspan="3">
<select name="codclienteB" class="textoform" id="codclienteB" >
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
					}
				?>						
</select>
	</td>
	<td rowspan="2"><a  onClick="buscar(form1)"><img src="images/buscar_header.jpg" border="0" alt="Buscar"></a></td>
</tr>


<tr >
     		<td>&nbsp;<b>Rango de Fecha</b>&nbsp;</td>			
     		<td>
				de&nbsp;<input type="text" class="textoform" size="12"  name="fechaInicioB" id="fechaInicioB"  value="<?php echo $fechaInicioB;?>" >
				&nbsp;hasta&nbsp;<input type="text" class="textoform" size="12"   name="fechaFinalB" id="fechaFinalB" 
				value="<?php echo $fechaFinalB;?>" >
				<input type="checkbox" name="codActivoFecha" id="codActivoFecha"  >
			</td>
    	</tr>
</table>

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
	
	
	
	$sql=" select count(*) from notas_remision where cod_nota_remision<>0 ";
	$sql.=" and cod_hoja_ruta in (select cod_hoja_ruta from hojas_rutas where cod_cotizacion in (select cod_cotizacion ";
	$sql.=" from cotizaciones   where cod_cotizacion<>0";
		if($codclienteB<>0 && $codclienteB<>""){
			$sql.=" and cod_cliente=".$codclienteB;
		}		
	$sql.=" ))";
	
	if($nroNotaRemisionB<>""){
			$sql.=" and nro_nota_remision=".$nroNotaRemisionB;
	}	
	
	if($nroHojaRutaB<>""){
			$sql.=" and cod_hoja_ruta=".$nroHojaRutaB."";
	}	
	if($codActivoFecha=="true"){
		if($fechaInicioB<>"" && $fechaFinalB<>"" ){
			$sql.=" and (fecha_nota_remision>='".$fechaInicioB_2."' and fecha_nota_remision<='".$fechaFinalB_2."')";
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
	<table width="90%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">

			<td>No</td>
    		<td>Fecha</td>								
			<td>Entregado por:</td>											
    		<td>Recibido por:</td>
			<td>Registro</td>
			<td>Edici&oacute;n</td>
			<td>Datos Adicionales</td>
		</tr>
		<tr><th colspan="7" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
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
		$sql=" select cod_nota_remision, cod_gestion, nro_nota_remision, fecha_nota_remision, ";
		$sql.=" obs_nota_remision, cod_hoja_ruta,cod_estado_nota_remision, recibido_por, cod_usuario_anulacion,";
		$sql.=" cod_usuario_registro, fecha_registro, cod_usuario_modifica, fecha_modifica, cod_usuario_entregado_por";
		$sql.=" from notas_remision";
		$sql.="  where cod_nota_remision<>0 ";
	$sql.=" and cod_hoja_ruta in (select cod_hoja_ruta from hojas_rutas where cod_cotizacion in (select cod_cotizacion ";
	$sql.=" from cotizaciones   where cod_cotizacion<>0";
		if($codclienteB<>0 && $codclienteB<>""){
			$sql.=" and cod_cliente=".$codclienteB;
		}		
	$sql.=" ))";
	
	if($nroNotaRemisionB<>""){
			$sql.=" and nro_nota_remision=".$nroNotaRemisionB;
	}	
	
	if($nroHojaRutaB<>""){
			$sql.=" and cod_hoja_ruta=".$nroHojaRutaB."";
	}	
	if($codActivoFecha=="true"){
		if($fechaInicioB<>"" && $fechaFinalB<>"" ){
			$sql.=" and (fecha_nota_remision>='".$fechaInicioB_2."' and fecha_nota_remision<='".$fechaFinalB_2."')";
		}
	}			
		$sql.=" order by cod_nota_remision desc	";	
		$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		$resp = mysql_query($sql);
		$cont=0;
?>	
	<table width="95%" align="center" cellpadding="1" id="cotizacion" cellspacing="1" bgColor="#cccccc">
  			<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="8">
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

			<td>No</td>
    		<td>Fecha</td>								
			<td>Entregado por:</td>											
    		<td>Recibido por:</td>
			<td>Registro</td>
			<td>Edici&oacute;n</td>
    		<td>Datos Adicionales</td>	
			<td>Estado</td>		
		</tr>
<?php   
		while($dat=mysql_fetch_array($resp)){	
		
			$cod_nota_remision=$dat[0];
			$cod_gestion_nota_remision=$dat[1];			
			$nro_nota_remision=$dat[2];
			$fecha_nota_remision=$dat[3];
			$fechaVector=explode("-",$fecha_nota_remision);
			$fecha_nota_remision_formato=$fechaVector[2]."/".$fechaVector[1]."/".$fechaVector[0];			
			$obs_nota_remision=$dat[4];
			$cod_hoja_ruta=$dat[5];
			$cod_estado_nota_remision=$dat[6];
			$recibido_por=$dat[7];
			$cod_usuario_anulacion=$dat[8];
			$cod_usuario_registro=$dat[9];
			$fecha_registro=$dat[10];
			if($fecha_registro<>""){
				$fechaRegistroVector=explode(" ",$fecha_registro);
				$fechaRegistroVector2=explode("-",$fechaRegistroVector[0]);
				$fechaRegistroFormato=$fechaRegistroVector2[2]."/".$fechaRegistroVector2[1]."/".$fechaRegistroVector2[0]." ".$fechaRegistroVector[1];
			}			
			$cod_usuario_modifica=$dat[11];
			$fecha_modifica=$dat[12];
				if($fecha_modifica<>""){
					$fechaModificaVector=explode(" ",$fecha_modifica);
					$fechaModificaVector2=explode("-",$fechaModificaVector[0]);
					$fechaModificaFormato=$fechaModificaVector2[2]."/".$fechaModificaVector2[1]."/".$fechaModificaVector2[0]." ".$fechaModificaVector[1];
				}			
			$cod_usuario_entregado_por=$dat[13];
			//*************************Datos Hoja de Ruta*************************************								
				$sql2=" select cod_cotizacion, cod_gestion, nro_hoja_ruta from hojas_rutas";
				$sql2.=" where cod_hoja_ruta='".$cod_hoja_ruta."'";	
				$resp2=mysql_query($sql2);
				$dat2=mysql_fetch_array($resp2);
					$cod_cotizacion=$dat2[0];	 
					$cod_gestion_hoja_ruta=$dat2[1];	
					$nro_hoja_ruta=$dat2[2];	
			//**************************************************************
				$gestionHojaRuta="";				
				$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion_hoja_ruta."'";	
				$resp2=mysql_query($sql2);
				$dat2=mysql_fetch_array($resp2);
				$gestionHojaRuta=$dat2[0];						
			//**************************************************************
													
			//*************************Fin Datos Hoja Ruta*************************************
			

			//*************************Datos de Cotizacion*************************************								
				$sql2=" select cod_gestion, nro_cotizacion, cod_cliente from cotizaciones";
				$sql2.=" where cod_cotizacion='".$cod_cotizacion."'";	
				$resp2=mysql_query($sql2);
				$dat2=mysql_fetch_array($resp2);
					$cod_gestion_cotizacion=$dat2[0];	 
					$nro_cotizacion=$dat2[1];	
					$cod_cliente=$dat2[2];
			//**************************************************************
				$gestionCotizacion="";				
				$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion_cotizacion."'";	
				$resp2=mysql_query($sql2);
				$dat2=mysql_fetch_array($resp2);
				$gestionCotizacion=$dat2[0];						
			//**************************************************************		
				//*****************************CLIENTE*********************************
					$nombre_cliente="";				
					$sql2="select nombre_cliente from clientes where cod_cliente='".$cod_cliente."'";	
					$resp2= mysql_query($sql2);
					$dat2=mysql_fetch_array($resp2);
						$nombre_cliente=$dat2[0];
				//*****************************FIN CLIENTE*********************************												
			//*************************Fin Datos de Cotizacion*************************************
			
			//**************************************************************
				$gestionNotaRemision="";				
				$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion_nota_remision."'";	
				$resp2=mysql_query($sql2);
				$dat2=mysql_fetch_array($resp2);
				$gestionNotaRemision=$dat2[0];						
			//**************************************************************
			//**************************************************************
				$nombre_estado_nota_remision="";				
				$sql2=" select nombre_estado_nota_remision from estados_notas_remision ";
				$sql2.=" where cod_estado_nota_remision=".$cod_estado_nota_remision;
					
				$resp2=mysql_query($sql2);
				$dat2=mysql_fetch_array($resp2);
				$nombre_estado_nota_remision=$dat2[0];						
			//**************************************************************
				//******************************USUARIO ENTREGADO POR********************************
					$usuarioEntregadoPor="";				
					$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios";
					$sql2.=" where cod_usuario='".$cod_usuario_entregado_por."'";	
					$resp2= mysql_query($sql2);
					$dat2=mysql_fetch_array($resp2);
					$usuarioEntregadoPor=substr($dat2[0],0).substr($dat2[1],0).substr($dat2[2],0);
				//*******************************FIN USUARIO ENTREGADO POR*******************************				
				//******************************USUARIO REGISTRO********************************
					$usuarioRegistro="";				
					$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios";
					$sql2.=" where cod_usuario='".$cod_usuario_registro."'";	
					$resp2= mysql_query($sql2);
					$dat2=mysql_fetch_array($resp2);
					//$usuarioRegistro=substr($dat2[0],0).substr($dat2[1],0).substr($dat2[2],0);
					$nombres_usuario_reg=$dat2[0];
					$ap_paterno_usuario_reg=$dat2[1];
					$ap_materno_usuario_reg=$dat2[2];
					$usuarioRegistro=$nombres_usuario_reg[0].$ap_paterno_usuario_reg[0].$ap_materno_usuario_reg[0];
				//*******************************FIN USUARIO REGISTRO*******************************									
				
				//******************************USUARIO MODIFICA********************************
					$usuarioModifica="";				
					$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios";
					$sql2.=" where cod_usuario='".$cod_usuario_modifica."'";	
					$resp2= mysql_query($sql2);
					$dat2=mysql_fetch_array($resp2);
					//$usuarioModifica=substr($dat2[0],0).substr($dat2[1],0).substr($dat2[2],0);
					$nombres_usuario_mod=$dat2[0];
					$ap_paterno_usuario_mod=$dat2[1];
					$ap_materno_usuario_mod=$dat2[2];
					$usuarioRegistro=$nombres_usuario_mod[0].$ap_paterno_usuario_mod[0].$ap_materno_usuario_mod[0];					
				//*******************************FIN USUARIO MODIFICA*******************************									
			 				
?> 
		<tr bgcolor="#FFFFFF" valign="middle" >	

    		<td>
			<a href="../reportes/impresionNotaRemision.php?cod_nota_remision=<?php echo $cod_nota_remision; ?>" target="_blank"><?php echo $nro_nota_remision."/".$gestionNotaRemision;?></a>
			</td>
			<td><?php echo $fecha_nota_remision_formato;?></td>
    		<td><?php echo $usuarioEntregadoPor;?></td>
			<td><?php echo $recibido_por;?></td>
			<td><?php echo $usuarioRegistro." ".$fechaRegistroFormato;?></td>
    		<td><?php echo $usuarioModifica." ".$fechaModificaFormato;?></td>
			<td><?php echo "HR:".$nro_hoja_ruta."/".$gestionHojaRuta."; COT:".$nro_cotizacion."/".$gestionCotizacion."<br>".$nombre_cliente;?></td>
			<td><?php echo $nombre_estado_nota_remision;?></td>							
							
   	  </tr>
<?php
		 } 
?>			
  			<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="8">
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
		
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
