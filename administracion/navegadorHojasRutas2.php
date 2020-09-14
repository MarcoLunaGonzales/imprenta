<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>Hojas de Ruta</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
function paginar(f)
{	
		location.href="navegadorHojasRutas.php?pagina="+f.pagina.value;		
}
function paginar1(f,pagina)
{		
		f.pagina.value=pagina*1;
		location.href="navegadorHojasRutas.php?pagina="+f.pagina.value;		
}

function anularNotaRemision(cod_nota_remision)
{		
		if(confirm('Esta seguro de anular la Nota de Remision No'+cod_nota_remision)){
			location.href="anularNotaRemision.php?cod_nota_remision="+cod_nota_remision;	
		}			
}
function buscar(f){

var param='?codHojaRutaB='+f.codHojaRutaB.value;
	param+='&nrocotizacionB='+f.nrocotizacionB.value;
	param+='&codclienteB='+f.codclienteB.value;
	param+='&codActivoFecha='+f.codActivoFecha.checked;
	param+='&fechaInicioB='+f.fechaInicioB.value;
	param+='&fechaFinalB='+f.fechaFinalB.value;
	param+='&pagina='+f.pagina.value;

	location.href='navegadorHojasRutas.php'+param;

}

function editar(f)
{	
	var i;
	var j=0;
	var cod_registro;
	for(i=0;i<=f.length-1;i++)
	{
		if(f.elements[i].type=='checkbox')		
		{	
			if(f.elements[i].name=='cod_hoja_ruta'){
				if(f.elements[i].checked==true)
				{	cod_registro=f.elements[i].value;
					j=j+1;
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
			window.location="editarHojaRuta.php?cod_hoja_ruta="+cod_registro;
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
					if(f.elements[i].name=='cod_hoja_ruta'){
				if(f.elements[i].checked==true)
				{	cod_registro=f.elements[i].value;
					j=j+1;
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
			alert('Debe seleccionar un registro.');
		}
		else
		{
			if(confirm("Esta seguro de Anular la Hoja de Ruta seleccionada?")){
				window.location="anularHojaRuta.php?cod_hoja_ruta="+cod_registro;
			}
			
		}
	}
}



</script>
</head>
<body>
<form name="form1" method="post"  id="form1">
<?php
	require("conexion.inc");
	include("funciones.php");
	
	$nrocotizacionB=$_GET['nrocotizacionB'];
	$codclienteB=$_GET['codclienteB'];
	$codActivoFecha=$_GET['codActivoFecha'];
	$codHojaRutaB=$_GET['codHojaRutaB'];

	$fechaInicioB=$_GET['fechaInicioB'];
	$VectorFecha=explode("/",$fechaInicioB);
	$fechaInicioB_2=$VectorFecha[2]."-".$VectorFecha[1]."-".$VectorFecha[0];
	
	$fechaFinalB=$_GET['fechaFinalB'];
	$VectorFecha=explode("/",$fechaFinalB);
	$fechaFinalB_2=$VectorFecha[2]."-".$VectorFecha[1]."-".$VectorFecha[0];
	
?>

<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">LISTADO DE HOJAS DE RUTA </h3>

<table border="0" align="center">
<tr>
<td><strong>Nro de Cotizacion</strong></td>
<td colspan="3"><input type="text" name="nrocotizacionB" size="10" class="textoform" value="<?php echo $nrocotizacionB;?>" ></td>
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
					}
				?>						
</select>
	</td>
	<td rowspan="2"><a  onClick="buscar(form1)"><img src="images/buscar_header.jpg" border="0" alt="Buscar"></a></td>
</tr>

<tr>
<td><strong>Nro de Hoja de Ruta</strong></td>
<td colspan="3"><input type="text" name="codHojaRutaB" size="10" class="textoform" value="<?php echo $codHojaRutaB;?>" ></td>
</tr>
<tr bgcolor="#FFFFFF">
     		<td>&nbsp;<b>Rango de Fecha</b>&nbsp;</td>			
     		<td>
				de&nbsp;<input type="text" class="textoform" size="12"  value="" name="fechaInicioB" id="fechaInicioB" >
				&nbsp;hasta&nbsp;<input type="text" class="textoform" size="12"  value="" name="fechaFinalB" id="fechaFinalB" >
				<input type="checkbox" name="codActivoFecha" id="codActivoFecha"  >
			</td>
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
	}	
	
	
	
	$sql=" select count(*) from hojas_rutas where cod_hoja_ruta<>0 ";
	
	$sql.=" and cod_cotizacion in (select cod_cotizacion from cotizaciones where cod_cotizacion<>0";
		if($nrocotizacionB<>""){
			$sql.=" and nro_cotizacion=".$nrocotizacionB;
		}
		if($codclienteB<>0 && $codclienteB<>""){
			$sql.=" and cod_cliente=".$codclienteB;
		}		
	$sql.=" )";
	
	if($codHojaRutaB<>""){
			$sql.=" and cod_hoja_ruta=".$codHojaRutaB;
	}	
	if($codActivoFecha=="true"){
		if($fechaInicioB<>"" && $fechaFinalB<>"" ){
			$sql.=" and (fecha_hoja_ruta>='".$fechaInicioB_2."' and fecha_hoja_ruta<='".$fechaFinalB_2."')";
		}
	}
		
	$resp_aux = mysql_query($sql);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}
?>
<h3 align="center" style="background:white;font-size: 10px;color: #d20000;font-weight:bold;">Nro de Registros <?php echo $nro_filas_sql;?></h3>
<?php		
	if($nro_filas_sql==0){
?>
	<table width="90%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>&nbsp;</td>
			<td>No</td>
    		<td>Fecha</td>	
			<td>Usuario</td>						
			<td>Observaciones</td>						
    		<td>Estado</td>
			<td>Ref. Cotizacion</td>
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
		$sql=" select cod_hoja_ruta,cod_gestion, nro_hoja_ruta, fecha_hoja_ruta, cod_usuario_hoja_ruta,";
		$sql.=" obs_hoja_ruta, cod_cotizacion, cod_estado_hoja_ruta ";
		$sql.=" from hojas_rutas ";
		$sql.="  where cod_hoja_ruta<>0 ";
		$sql.=" and cod_cotizacion in (select cod_cotizacion from cotizaciones where cod_cotizacion<>0";
		if($nrocotizacionB<>""){
			$sql.=" and nro_cotizacion=".$nrocotizacionB;
		}
		if($codclienteB<>0 && $codclienteB<>""){
			$sql.=" and cod_cliente=".$codclienteB;
		}		
		$sql.=" )";
	
		if($codHojaRutaB<>""){
			$sql.=" and cod_hoja_ruta=".$codHojaRutaB;
		}	
		if($codActivoFecha=="true"){
			if($fechaInicioB<>"" && $fechaFinalB<>"" ){
					$sql.=" and (fecha_hoja_ruta>='".$fechaInicioB_2."' and fecha_hoja_ruta<='".$fechaFinalB_2."')";
			}
		}		
		$sql.=" ORDER BY cod_hoja_ruta desc ,fecha_hoja_ruta desc";
		$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		$resp = mysql_query($sql);
		$cont=0;
?>	
	<table width="95%" align="center" cellpadding="1" id="cotizacion" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>&nbsp;</td>
			<td>No</td>
    		<td>Fecha</td>	
			<td>Usuario</td>											
    		<td>Estado</td>
			<td>Ref. Cotizacion</td>
			<td>Notas de Remision</td>
			<td>PDF</td>
		</tr>
<?php   
		while($dat=mysql_fetch_array($resp)){	
			 $cont++;
				$cod_hoja_ruta=$dat[0];
				$cod_gestion=$dat[1];
				/****************************************/
					$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion."'";
					$resp2= mysql_query($sql2);
					$gestion="";
					while($dat2=mysql_fetch_array($resp2)){
						$gestion=$dat2[0];
					}
				/***************************************/				
				$nro_hoja_ruta=$dat[2];
				$fecha_hoja_ruta=$dat[3];
				$cod_usuario_hoja_ruta=$dat[4];				
				$obs_hoja_ruta=$dat[5];
				$cod_cotizacion=$dat[6];
				$cod_estado_hoja_ruta=$dat[7];				
				
				//**************************************************************
					$usuarioHojaRuta="";
					$sql2="select nombres_usuario,ap_paterno_usuario from usuarios ";
					$sql2.=" where cod_usuario='".$cod_usuario_hoja_ruta."'";	
					$resp2= mysql_query($sql2);
					$dat2=mysql_fetch_array($resp2);
					$usuarioHojaRuta=$dat2[0]." ".$dat2[1]." ".$dat2[2];
				//**************************************************************
				//**************************************************************
					$nombre_estado_hoja_ruta="";
					$sql2="select nro_cotizacion,cod_gestion, cod_cliente, fecha_cotizacion from cotizaciones";
					$sql2.=" where cod_cotizacion='".$cod_cotizacion."'";	
					$resp2= mysql_query($sql2);
					$dat2=mysql_fetch_array($resp2);
					$nro_cotizacion=$dat2[0];
					$cod_gestion=$dat2[1];
					$cod_cliente=$dat2[2];
					$fecha_cotizacion=$dat2[3];
						//**************************************************************
						$gestion="";				
						$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion."'";	
						$resp2= mysql_query($sql2);
						$dat2=mysql_fetch_array($resp2);
						$gestion=$dat2[0];						
						//**************************************************************										
						//**************************************************************
						$nombre_cliente="";				
						$sql2="select nombre_cliente from clientes where cod_cliente='".$cod_cliente."'";	
						$resp2= mysql_query($sql2);
						$dat2=mysql_fetch_array($resp2);
						$nombre_cliente=$dat2[0];						
						//**************************************************************										
												
				//**************************************************************
					$nombre_estado_hoja_ruta="";
					$sql2="select nombre_estado_hoja_ruta from estados_hojas_rutas";
					$sql2.=" where cod_estado_hoja_ruta='".$cod_estado_hoja_ruta."'";	
					$resp2= mysql_query($sql2);
					$dat2=mysql_fetch_array($resp2);
					$nombre_estado_hoja_ruta=$dat2[0];
				//**************************************************************				
		?> 
		<tr bgcolor="#FFFFFF" valign="middle" >	

			<td>&nbsp;
			<?php if($cod_estado_hoja_ruta==1){?>
				<input type="checkbox"name="cod_hoja_ruta"value="<?php echo $cod_hoja_ruta;?>">
			<?php }?>
			</td>
    		<td><?php echo $nro_hoja_ruta."/".$gestion; ?></td>	
			<td><?php echo $fecha_hoja_ruta; ?></td>	
			<td><?php echo $usuarioHojaRuta; ?></td>											
    		<td><?php echo $nombre_estado_hoja_ruta; ?></td>
			<td><a href=""><?php echo $nro_cotizacion."/".$gestion." (".$nombre_cliente.")"; ?></a></td>
			<td>
			<?php 
				$numNotasRemision=0;
				$sql3=" select count(*) from notas_remision  where cod_hoja_ruta='".$cod_hoja_ruta."'";
				$resp3= mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3)){
					$numNotasRemision=$dat3[0];
				}
				
				if($numNotasRemision>0){
			?>
				<table border="0" width="100%">
				<tr valign="top"><td>No</td><td>Fecha</td><td>&nbsp;</td><td>&nbsp;</td></tr>
			<?php	
					$sql3=" select cod_nota_remision, fecha_nota_remision, cod_usuario_nota_remision,";
					$sql3.=" obs_nota_remision, cod_estado_nota_remision ";
					$sql3.=" from notas_remision  where cod_hoja_ruta='".$cod_hoja_ruta."'";
					$resp3= mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						
						$cod_nota_remision=$dat3[0];
						$fecha_nota_remision=$dat3[1];
						$cod_usuario_nota_remision=$dat3[2];
						$obs_nota_remision=$dat3[3];
						$cod_estado_nota_remision=$dat3[4];
						
						$sql4=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario  ";
						$sql4.=" from usuarios where cod_usuario='".$cod_usuario_nota_remision."'";
						$UsuarioNotaRemision="";
						$resp4= mysql_query($sql4);
						while($dat4=mysql_fetch_array($resp4)){
							$UsuarioNotaRemision=$dat4[0]." ".$dat4[1];
						}

			?>
			
				<tr>
				 <td>
				 <a href="../reportes/impresionNotaRemision.php?cod_nota_remision=<?php echo $cod_nota_remision; ?>" target="_blank">
				 <?php echo $cod_nota_remision;?></a>
				 </td>
				 <td><?php echo $fecha_nota_remision;?></td>
  				 <td>
				 	<?php if($cod_estado_nota_remision==1){?>
					 <a href="editarNotaRemision.php?cod_nota_remision=<?php echo $cod_nota_remision;?>"title="Editar">@</a>
					 <?php }else{
					 	echo "@";
					 }?>
				 </td>
				 <td>
				 	<?php if($cod_estado_nota_remision==1){?>
				 	<a href="javascript:anularNotaRemision(<?php echo $cod_nota_remision;?>)">X</a>
					<?php }else{
					 	echo "X";
					 }?>
				 </td>
				</tr>
				
			<?php	}
			?>

				</table>							
					
			<?php }	?>
			<br>
<a href="registroNotaRemision.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta;?>"> + Nota Remision</a>	
			

</td>		
			<td><a href="../reportes/impresionHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta; ?>" target="_blank"><img src="../reportes/pdf.jpg" border="0"></a> </td>								
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
		</table>
		
<?php
	}
?>
		
<?php require("cerrar_conexion.inc");
?>
<br>
<div align="center">
	<INPUT type="button" class="boton" name="btn_editar"  value="Editar" onClick="editar(this.form);">
	<INPUT type="button" class="boton" name="btn_anular"  value="Anular" onClick="anular(this.form);">
	<!--INPUT type="button" class="boton" name="btn_anular"  value="Imprimir" onClick="imprimir(this.form);"-->
	
</div>

</form>
</body>
</html>
