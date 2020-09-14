<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>Salidas</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>

function paginar(f)
{	
var param="?pagina="+f.pagina.value;
		location.href='navegadorSalidas.php'+param;		
}
function paginar1(f,pagina)
{		

		f.pagina.value=pagina*1;
var param="?pagina="+f.pagina.value;
			
		location.href='navegadorSalidas.php'+param;	
}

function buscar(f){

var param="?nombreMaterialB="+f.nombreMaterialB.value;
	param+="&pagina="+f.pagina.value;

	location.href="navegadorMateriales.php"+param;

}

function anular(cod_salida,nro_salida,cod_estado_salida,swValIngreso)
{	
		if(swValIngreso==0){
			alert('La Salida No.'+nro_salida+' no puede ser anulada, porque esta genero un Ingreso en otro Almacen.');
		}else{
			if(cod_estado_salida==2){
				alert('La Salida No.'+nro_salida+' ya se encuentra anulada.');
			}else{
				
					msj=confirm('Esta seguro de Anular la Salida No.'+nro_salida);
					if(msj==true)
					{
						izquierda=(screen.width)?(screen.width-300)/2:100
						arriba=(screen.height)?(screen.height-400)/2:100
						url="anularSalida.php?cod_salida="+cod_salida;
						opciones=" toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=1,resizable=0, width=500, height=280, left="+izquierda+" top="+arriba;
	
						window.open(url,'popUp',opciones);
					}

				
			}
		}
	
}

function editar(cod_salida,nro_salida,cod_estado_salida,swValFecha,swValIngreso)
{	
		if(cod_estado_salida==2){
			alert("La Salida No."+nro_salida+", no puede ser Editada porque se encuentra Anulada.");	

		}else{
			if(swValFecha==0){
				alert('La Salida No.'+nro_salida+' solo puede  ser editada el dia que se registro.');
				
			}else{
				if(swValIngreso==0){
					alert('La Salida No.'+nro_salida+' no puede ser editada, porque esta genero un Ingreso en otro Almacen.');
					
				}else{
					window.location="editarSalida.php?cod_salida="+cod_salida;
				}
			}		
			
		}
	
}


</script></head>
<body bgcolor="#F7F5F3">
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->

<form name="form1" method="post" action="#">
<?php 
	require("conexion.inc");
	include("funciones.php");
	
	$cod_almacenP=$_COOKIE['cod_almacen_global'];
	$sql2="select nombre_almacen from almacenes where cod_almacen='".$cod_almacenP."'";
	$resp2= mysql_query($sql2);
	$nombre_almacen="";
	while($dat2=mysql_fetch_array($resp2)){
		$nombre_almacen=$dat2[0];
	}		

?>
<h3 align="center" style="background:#F7F5F3;font-size: 14px;color: #E78611;font-weight:bold;">Salidas <?php echo $nombre_almacen; ?></h3>

<table border="0" align="center">

<tr>
<td><strong>Almacen Traspaso:</strong></td>
<td colspan="3">

			<select name="codalmacenB" id="codalmacenB" class="textoform" >
				<option value="0">Seleccione una opcion</option>	
              <?php
					$sql2=" select cod_almacen, nombre_almacen from almacenes where cod_almacen<>'".$cod_almacenP."'";
					$sql2.=" order by  nombre_almacen asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_almacen=$dat2[0];	
			  		 		$nombre_almacen=$dat2[1];	
				 ?>
				 <option value="<?php echo $cod_almacen;?>" <?php if($cod_almacen==$codalmacenB){echo "selected='selected'";}?>><?php echo $nombre_almacen;?>
				 </option>					 

              <?php		
					}
				?>
            </select>
</td>
</tr>
<tr>
<td><strong>Tipo Salida:</strong></td>
<td colspan="3">
	<select name="codtiposalidaB" id="codtiposalidaB" class="textoform" >
				<option value="0">Seleccione una opcion</option>	
              <?php
					$sql2=" select cod_tipo_salida, nombre_tipo_salida from tipos_salida ";
					$sql2.=" order by  nombre_tipo_salida asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_tipo_salida=$dat2[0];	
			  		 		$nombre_tipo_salida=$dat2[1];	
				 ?>
				 <option value="<?php echo $cod_tipo_salida;?>" <?php if($cod_tipo_salida==$codtiposalidaB){echo "selected='selected'";}?>><?php echo $nombre_tipo_salida;?>
				 </option>					 

              <?php		
					}
				?>
            </select>
</td>

</tr>

<tr >
     		<td><strong>Rango de Fecha:</strong></td>			
     		<td colspan="3">
				DE&nbsp;<input type="text" class="textoform" size="12"  value="<?php echo $fechaInicioB;?>" name="fechaInicioB" id="fechaInicioB" >
				&nbsp;HASTA&nbsp;<input type="text" class="textoform" size="12"  value="<?php echo $fechaFinalB;?>" name="fechaFinalB" id="fechaFinalB" >
				<input type="checkbox" name="codActivoFecha" id="codActivoFecha" <?php if($codActivoFecha=="true"){echo "checked='checked'";} ?> >
			</td>		
   	</tr>
	<!--tr>
			<td rowspan="2"><a  onClick="buscar(form1)"><img src="images/buscar_header.jpg" border="0" alt="Buscar"></a></td>	
	</tr-->
</table>

<?php	
	//Paginador
	$nro_filas_show=50;	
	$pagina = $_GET['pagina'];

	if ($pagina == ""){
		$pagina = 1;
		$fila_inicio=0;
		$fila_final=$nro_filas_show;
	}else{
		$fila_inicio=(($pagina*$nro_filas_show)-$nro_filas_show);
		$fila_final=($fila_inicio+$nro_filas_show);
	}	
	
	$sql_aux=" select count(*) from salidas  where cod_almacen=".$cod_almacenP;

	$resp_aux = mysql_query($sql_aux);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}
	if($nro_filas_sql==0){
?>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>Nro Salida</td>
			<td>Fecha Salida</td>
			<td>Tipo Salida</td>    						    			
			<td>Responsable de Salida</td>			
			<td>Observaci&oacute;n</td>
			<td>Estado</td>		
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
		
		$sql=" select s.cod_salida, s.cod_tipo_salida, s.nro_salida,  ";
		$sql.=" s.cod_gestion, g.gestion, s.cod_almacen, s.fecha_salida,  ";
 		$sql.=" s.cod_usuario_salida, s.obs_salida,  ";
		$sql.=" s.cod_almacen_traspaso, s.cod_hoja_ruta, s.cliente_venta ,";
		$sql.=" s.cod_estado_salida, s.fecha_modifica, s.cod_usuario_modifica,";
		$sql.=" s.fecha_anulacion, s.cod_usuario_anulacion, s.obs_anulacion, s.cod_orden_trabajo ";
		$sql.=" from salidas s, gestiones g  ";
		$sql.=" where s.cod_gestion=g.cod_gestion  ";
		$sql.=" and s.cod_almacen='".$cod_almacenP."'";
		$sql.=" order by g.gestion desc , s.nro_salida desc ";
		//echo $sql;
		$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		$resp = mysql_query($sql);

?>	
	<table width="95%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>&nbsp;</td>
    		<td>Nro Salida</td>
			<td>Fecha Salida</td> 
			<td colspan="2">Tipo Salida</td>    			
			<td>Responsable de Salida</td>			
			<td>Observaci&oacute;n</td>
			<td>Estado</td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>																		
		</tr>

<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){
				
				$cod_salida=$dat[0];
				$cod_tipo_salida=$dat[1];
				$nro_salida=$dat[2];
				$cod_gestion=$dat[3];
				$gestion=$dat[4];
				$cod_almacen=$dat[5];
				$fecha_salida=$dat[6];
 				$cod_usuario_salida=$dat[7];
				$obs_salida=$dat[8];
				$cod_almacen_traspaso=$dat[9];
				$cod_hoja_ruta=$dat[10];
				$cliente_venta=$dat[11];
				$cod_estado_salida=$dat[12];
				$fecha_modifica=$dat[13];
				$cod_usuario_modifica=$dat[14];
				$fecha_anulacion=$dat[15];
				$cod_usuario_anulacion=$dat[16];
				$obs_anulacion=$dat[17];
				$cod_orden_trabajo=$dat[18];
		 
		
		
				

				
				$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios ";
				$sql2.=" where cod_usuario='".$cod_usuario_salida."'";
				$resp2= mysql_query($sql2);
				$nombres_usuario="";
				$ap_paterno_usuario="";
				$ap_materno_usuario="";		
				while($dat2=mysql_fetch_array($resp2)){	
					$nombres_usuario=$dat2[0];
					$ap_paterno_usuario=$dat2[1];
					$ap_materno_usuario=$dat2[2];		
				}	
				
				//******************************TIPO DE salida********************************
				$nombre_tipo_salida="";
				$sql2="select nombre_tipo_salida from tipos_salida where cod_tipo_salida='".$cod_tipo_salida."'";
				$resp2= mysql_query($sql2);			
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_tipo_salida=$dat2[0];
				}
				
				$nombre_almacen_traspaso="";
				$sql2="select nombre_almacen from almacenes where cod_almacen='".$cod_almacen_traspaso."'";
				$resp2= mysql_query($sql2);			
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_almacen_traspaso=$dat2[0];
				}
				if($cod_tipo_salida==3){
						$nombre_almacen_traspaso="";
						$sql2="select nombre_almacen from almacenes where cod_almacen='".$cod_almacen_traspaso."'";
						//echo $sql2;
						$resp2= mysql_query($sql2);			
						while($dat2=mysql_fetch_array($resp2)){
							$nombre_almacen_traspaso=$dat2[0];
						}
				}
//				echo $nombre_almacen_traspaso;
				if($cod_tipo_salida==2 or $cod_tipo_salida==4){
					$sql2=" select  hr.nro_hoja_ruta, hr.cod_gestion,g.gestion, hr.cod_cotizacion,";
					$sql2.=" c.cod_cliente, cli.nombre_cliente ";
					$sql2.=" from hojas_rutas hr, gestiones g, cotizaciones c, clientes cli ";
					$sql2.=" where hr.cod_hoja_ruta=".$cod_hoja_ruta;
					$sql2.=" and hr.cod_gestion=g.cod_gestion ";
					$sql2.=" and hr.cod_cotizacion=c.cod_cotizacion ";
					$sql2.=" and c.cod_cliente=cli.cod_cliente ";
					$resp2= mysql_query($sql2);
					$nro_hoja_ruta_salida="";
					$cod_gestion_salida="";
					$gestion_salida="";
					$cod_cotizacion_salida="";
					$cod_cliente_salida="";
					$nombre_cliente_salida="";
					while($dat2=mysql_fetch_array($resp2)){
					
						$nro_hoja_ruta_salida=$dat2[0];
						$cod_gestion_salida=$dat2[1];
						$gestion_hoja_ruta_salida=$dat2[2];
						$cod_cotizacion_salida=$dat2[3];
						$cod_cliente_salida=$dat2[4];
						$nombre_cliente_salida=$dat2[5];
					
					}
				}
				
				$desc_estado_salida="";
				$sql2="select desc_estado_salida from estados_salidas_almacen where cod_estado_salida='".$cod_estado_salida."'";
				//echo $sql2;
				$resp2= mysql_query($sql2);			
				while($dat2=mysql_fetch_array($resp2)){
					$desc_estado_salida=$dat2[0];
				}
				$swValFecha=0;
				$fechaNow=date('Y-m-d', time());

				if($fecha_salida==$fechaNow){
					$swValFecha=1;
				}
				if($cod_tipo_salida==3){
						$swValIngreso=0;
						
						$sql8="select cod_estado_ingreso from ingresos where cod_salida=".$cod_salida;
						$resp8= mysql_query($sql8);			
						while($dat8=mysql_fetch_array($resp8)){
							$cod_estado_ingreso=$dat8[0];
						}						
						if($cod_estado_ingreso==2){
							$swValIngreso=1;
						}
				}else{
					$swValIngreso=1;
				}


				
		
							

				
?> 
		<tr bgcolor="#FFFFFF">	
			<td><input type="checkbox"name="cod_salida"value="<?php echo $cod_salida;?>"></td>	
							
    		<td><?php echo $nro_salida."/".$gestion; ?></td>
			<td><?php echo $fecha_salida." ".$fechaNow; ?></td>  
			<td><?php echo $nombre_tipo_salida;?></td>  			
			<td>
			<?php					
				if($cod_tipo_salida==1) {
					echo $cliente_venta;
				}
				if($cod_tipo_salida==2 or $cod_tipo_salida==4  ) {
					echo "No. ".$nro_hoja_ruta_salida."/".$gestion_hoja_ruta_salida."<br>(".$nombre_cliente_salida.")";				
				}				
				if($cod_tipo_salida==3){
					echo $nombre_almacen_traspaso;
				}
				if($cod_tipo_salida==5){
					$sql9=" select ot.cod_orden_trabajo, ot.numero_orden_trabajo, ot.fecha_orden_trabajo, ";
					$sql9.=" ot.cod_cliente,c.nombre_cliente, ot.obs_orden_trabajo, ot.monto_orden_trabajo ";
					$sql9.=" from ordentrabajo	ot, clientes c ";
					$sql9.=" where ot.cod_cliente=c.cod_cliente ";
					$sql9.=" and ot.cod_orden_trabajo=".$cod_orden_trabajo;

					$resp9=mysql_query($sql9);
						while($dat9=mysql_fetch_array($resp9))
						{
							$cod_orden_trabajo=$dat9['cod_orden_trabajo'];
							$numero_orden_trabajo=$dat9['numero_orden_trabajo'];	
			  		 		$fecha_orden_trabajo=$dat9['fecha_orden_trabajo'];	
							$cod_cliente=$dat9['cod_cliente'];
							$nombre_cliente=$dat9['nombre_cliente'];	
							$cod_cliente=$dat9['cod_cliente'];
							$obs_orden_trabajo=$dat9['obs_orden_trabajo'];
							$monto_orden_trabajo=$dat9['monto_orden_trabajo'];	
						}
					echo $numero_orden_trabajo." (".$nombre_cliente.")";
				}
			?>
			</td>
			<td><?php echo $nombres_usuario."".$ap_paterno_usuario;?></td>			
			<td><?php echo $obs_salida; ?></td>	
			<td><?php echo $desc_estado_salida; ?></td>
			<td> <a href="detalleSalida.php?cod_salida=<?php echo $cod_salida; ?>" target="_blank">View </a></td>
			<td> <a href="javascript:editar(<?php echo $cod_salida; ?>,'<?php echo $nro_salida."/".$gestion; ?>',<?php echo $cod_estado_salida; ?>,<?php echo $swValFecha;?>,<?php echo $swValIngreso; ?>)">Editar </a></td>										
			<td><a href="javascript:anular(<?php echo $cod_salida; ?>,'<?php echo $nro_salida."/".$gestion; ?>',<?php echo $cod_estado_salida; ?>,<?php echo $swValIngreso; ?>)">Anular</a>
			</td>																				
				
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
						Ir a Pagina<input type="text" name="pagina"  id="pagina" size="5"><input  type="button" size="8"  value="Go" onClick="paginar(this.form)">												
				</td>
			</tr>
  </TABLE>
		</div>			
<?php
	}
?>
		
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
