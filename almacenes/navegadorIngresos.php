<?php

function suma_fechas($fecha,$ndias)
{
             
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
            
              list($año,$mes,$dia)=split("-", $fecha);
            
 
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            
 
              list($año,$mes,$dia)=split("-",$fecha);
        $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
        $nuevafecha=date("Y-m-d",$nueva);
             
      return ($nuevafecha);  
          
}

 

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>Ingresos</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>


function paginar(f)
{	
var param="?pagina="+f.pagina.value;
		location.href='navegadorIngresos.php'+param;		
}
function paginar1(f,pagina)
{		

		f.pagina.value=pagina*1;
var param="?pagina="+f.pagina.value;
			
		location.href='navegadorIngresos.php'+param;	
}

function buscar(f){

var param="?nombreMaterialB="+f.nombreMaterialB.value;
	param+="&pagina="+f.pagina.value;

	location.href="navegadorMateriales.php"+param;

}

function anular(cod_ingreso,nro_ingreso,swValIngreso,cod_estado_ingreso)
{	
			if(cod_estado_ingreso==2){
				alert('El Ingreso No.'+nro_ingreso+' ya se encuentra anulado.');
			}else{
				
				if(swValIngreso==0){
					alert('El Ingreso No.'+nro_ingreso+' no se puede Anular, porque se hicieron salidas del mismo.');
					
				}else{
					msj=confirm('Esta seguro de Anular el Ingreso No.'+nro_ingreso);
					if(msj==true)
					{
						izquierda=(screen.width)?(screen.width-300)/2:100
						arriba=(screen.height)?(screen.height-400)/2:100
						url="anularIngreso.php?cod_ingreso="+cod_ingreso;
						opciones=" toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=1,resizable=0, width=500, height=280, left="+izquierda+" top="+arriba;
	
						window.open(url,'popUp',opciones)
					}

				}
			}
	
}

function editar(cod_ingreso,nro_ingreso, swValFecha,swValIngreso,cod_estado_ingreso)
{	
		if(cod_estado_ingreso==2){
			alert('No se puede editar un Ingreso Anulado.');	

		}else{
			if(swValFecha==0){
				alert('El Ingreso No.'+nro_ingreso+' solo puede  ser editado los proximos 7 dias de su registro.');
				
			}else{
				if(swValIngreso==0){
					window.location="editarIngresoCabecera.php?cod_ingreso="+cod_ingreso;
					//alert('El Ingreso No.'+nro_ingreso+' no puede  ser editado, porque se hicieron salidas del mismo.');
				}else{					
					window.location="editarIngreso.php?cod_ingreso="+cod_ingreso;
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
<h3 align="center" style="background:#F7F5F3;font-size: 14px;color: #E78611;font-weight:bold;">Ingresos a <?php echo $nombre_almacen; ?></h3>

<table border="0" align="center">
<tr>
<td><strong>Proveedor:</strong></td>
<td colspan="3">
<select name="codproveedorB" id="codproveedorB" class="textoform" >
				<option value="0">Seleccione una opcion</option>	
              <?php
					$sql2="select cod_proveedor, nombre_proveedor from proveedores order by  nombre_proveedor asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_proveedor=$dat2[0];	
			  		 		$nombre_proveedor=$dat2[1];	
				 ?>
				 <option value="<?php echo $cod_proveedor;?>" <?php if($cod_proveedor==$codproveedorB){echo "selected='selected'";}?>><?php echo $nombre_proveedor;?>
				 </option>					 

              <?php		
					}
				?>
            </select>
</td>
</tr>
<tr>
<td><strong>Almacen:</strong></td>
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
<td><strong>Tipo Ingreso:</strong></td>
<td colspan="3">
	<select name="codtipoingresoB" id="codtipoingresoB" class="textoform" >
				<option value="0">Seleccione una opcion</option>	
              <?php
					$sql2=" select cod_tipo_ingreso, nombre_tipo_ingreso from tipos_ingreso ";
					$sql2.=" order by  nombre_tipo_ingreso asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_tipo_ingreso=$dat2[0];	
			  		 		$nombre_tipo_ingreso=$dat2[1];	
				 ?>
				 <option value="<?php echo $cod_tipo_ingreso;?>" <?php if($cod_tipo_ingreso==$codtipoingresoB){echo "selected='selected'";}?>><?php echo $nombre_tipo_ingreso;?>
				 </option>					 

              <?php		
					}
				?>
            </select>
</td>

</tr>

<tr>
<td><strong>Nro Factura :</strong></td>
<td colspan="3"><input type="text" name="nroFacturaB" id="nroFacturaB" size="30" class="textoform" value="<?php echo $nroFacturaB;?>" ></td>
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
	
		$fechaNow=date('Y-m-d', time());
	
	
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
	
	$sql_aux=" select count(*) from ingresos  where cod_almacen=".$cod_almacenP;

	$resp_aux = mysql_query($sql_aux);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}
	if($nro_filas_sql==0){
?>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>Nro Ingreso</td>
			<td>Fecha Ingreso</td>    			
    		<td>Proveedor</td>
			<td>Almacen Traspaso </td>
			<td>Tipo Ingreso</td> 
			<td>Nro Factura</td>
			<td>Responsable de Ingreso</td>			
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
		
		$sql=" select i.cod_ingreso, i.cod_gestion, g.gestion,  i.cod_almacen, ";
		$sql.=" i.nro_ingreso, i.cod_tipo_ingreso, i.fecha_ingreso, i.cod_usuario_ingreso, ";
		$sql.=" i.cod_proveedor, i.cod_salida, i.nro_factura, i.obs_ingreso, i.fecha_modifica, i.cod_usuario_modifica, ";
		$sql.=" i.cod_estado_ingreso , obs_anular";
		$sql.=" from ingresos i, gestiones g ";
		$sql.=" where i.cod_gestion=g.cod_gestion";
		$sql.=" and i.cod_almacen='".$cod_almacenP."'";
		$sql.=" order by g.gestion desc , i.nro_ingreso desc";
		$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		$resp = mysql_query($sql);

?>	
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>Nro Ingreso</td>
			<td>Fecha Ingreso</td>    			
    		<td>Proveedor</td>
			<td>Almacen Traspaso </td>
			<td>Tipo Ingreso</td> 
			<td>Nro Factura</td>
			<td>Responsable de Ingreso</td>			
			<td>Observaci&oacute;n</td>
			<td>Estado</td>
			<td>&nbsp;</td>	
			<td>&nbsp;</td>	
			<td>&nbsp;</td>																		
		</tr>

<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){
		
				$cod_ingreso=$dat[0];
				$cod_gestion=$dat[1];
				$gestion=$dat[2];
				$cod_almacen=$dat[3];
				$nro_ingreso=$dat[4];
				$cod_tipo_ingreso=$dat[5];
				$fecha_ingreso=$dat[6];
				
				$cod_usuario_ingreso=$dat[7];
				$cod_proveedor=$dat[8];
				$cod_salida=$dat[9];
				$nro_factura=$dat[10];
				$obs_ingreso=$dat[11];
				$fecha_modifica=$dat[12];
				$cod_usuario_modifica=$dat[13];
				$cod_estado_ingreso=$dat[14];
				$obs_anular=$dat[15];
		

			
				
				//**************************************************************
				$nombre_proveedor="";
				$sql2="select nombre_proveedor from proveedores where cod_proveedor='".$cod_proveedor."'";
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_proveedor=$dat2[0];
				}					

				
				$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios ";
				$sql2.=" where cod_usuario='".$cod_usuario_ingreso."'";
				$resp2= mysql_query($sql2);
				$nombres_usuario="";
				$ap_paterno_usuario="";
				$ap_materno_usuario="";		
				while($dat2=mysql_fetch_array($resp2)){	
					$nombres_usuario=$dat2[0];
					$ap_paterno_usuario=$dat2[1];
					$ap_materno_usuario=$dat2[2];		
				}	
				
				//******************************TIPO DE INGRESO********************************
				$nombre_tipo_ingreso="";
				$sql2="select nombre_tipo_ingreso from tipos_ingreso where cod_tipo_ingreso='".$cod_tipo_ingreso."'";
				$resp2= mysql_query($sql2);			
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_tipo_ingreso=$dat2[0];
				}

				$nombre_almacen_ingreso="";
				if($cod_tipo_ingreso==2){
				//******************************AlMACEN INGRESO********************************
				
					$sql2="select nombre_almacen from almacenes where cod_almacen_ingreso=".$cod_almacen_ingreso."";
					$resp2= mysql_query($sql2);			
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_almacen_ingreso=$dat2[0];
					}
				}
				
				//******************************ESTADO********************************
				$desc_estado_ingreso="";
				$sql2=" select desc_estado_ingreso from estados_ingresos_almacen ";
				$sql2.=" where cod_estado_ingreso='".$cod_estado_ingreso."'";
				$resp2= mysql_query($sql2);			
				while($dat2=mysql_fetch_array($resp2)){
					$desc_estado_ingreso=$dat2[0];
				}
				
		
							

				
?> 
		<tr bgcolor="#FFFFFF">	
									
    		<td><?php echo $nro_ingreso."/".$gestion; ?></td>
			<td><?php echo $fecha_ingreso; ?></td>    			
    		<td><?php echo $nombre_proveedor; ?></td>
			<td><?php echo $nombre_almacen_ingreso; ?></td>
			<td><?php echo $nombre_tipo_ingreso; ?></td>
			<td><?php echo $nro_factura;?></td>		
			<td><?php echo $nombres_usuario."".$ap_paterno_usuario;?></td>			
			<td><?php echo $obs_ingreso; ?></td>
			<td><?php echo $desc_estado_ingreso; ?></td>			
			<td> <a href="detalleIngreso.php?cod_ingreso=<?php echo $cod_ingreso; ?>" target="_blank">View </a></td>																	
			<td> 
			<?php
				$swValFecha=0;	
				if(suma_fechas($fecha_ingreso,7)>$fechaNow){
					$swValFecha=1;
				}
				
				$sql3=" select count(*) ";
				$sql3.=" from salidas_detalle_ingresos ";
				$sql3.=" where cod_ingreso_detalle in( ";
				$sql3.=" select cod_ingreso_detalle ";
				$sql3.=" from ingresos_detalle ";
				$sql3.=" where cod_ingreso='".$cod_ingreso."'";
				$sql3.=" )";
				$resp3= mysql_query($sql3);	
				$numSalidas=0;		
				while($dat3=mysql_fetch_array($resp3)){
					$numSalidas=$dat3[0];
				}
				
				$swValIngreso=0;
				if($numSalidas==0){
					$swValIngreso=1;
					//$swValIngreso=0;
				}
			?>
			<a href="javascript:editar(<?php echo $cod_ingreso; ?>,'<?php echo $nro_ingreso."/".$gestion; ?>',<?php echo $swValFecha; ?>,<?php echo $swValIngreso; ?>,<?php echo $cod_estado_ingreso; ?>)">
			Editar 
			</a>
			</td>
			<td> 
			<a href="javascript:anular(<?php echo $cod_ingreso; ?>,'<?php echo $nro_ingreso."/".$gestion; ?>',<?php echo $swValIngreso; ?>,<?php echo $cod_estado_ingreso; ?>)">Anular</a>
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
