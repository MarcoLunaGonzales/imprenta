<?php

header("Cache-Control: no-store, no-cache, must-revalidate");
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
//coneccion a la Base de Datos
require("conexion.inc");
include("funciones.php");
	$nroIngresoB=$_GET['nroIngresoB'];
	$nombreProveedorB=$_GET['nombreProveedorB'];
	$almacenSalidaB=$_GET['almacenSalidaB'];
	$nrofacturaB=$_GET['nrofacturaB'];	
	$tipoIngresoB=$_GET['tipoIngresoB'];
	$estadoIngresoB=$_GET['estadoIngresoB'];
	$codActivoFecha=$_GET['codActivoFecha'];
	$fechaInicioB=$_GET['fechaInicioB'];
	$fechaFinalB=$_GET['fechaFinalB'];
	$descCompletaMaterialB=$_GET['descCompletaMaterialB'];
//para sacar los datos de la busqueda
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

<title>Documento sin t&iacute;tulo</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php 

	//Paginador
	
	$fechaNow=date('Y-m-d', time());
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
	$sql.=" from ingresos i, estados_ingresos_almacen eia, gestiones g, tipos_ingreso ti";
	$sql.=" where i.cod_estado_ingreso=eia.cod_estado_ingreso";
	$sql.=" and i.cod_gestion=g.cod_gestion";
	$sql.=" and i.cod_tipo_ingreso=ti.cod_tipo_ingreso";
	$sql.=" and i.cod_almacen=".$_COOKIE['cod_almacen_global'];
	if($_GET['nroIngresoB']<>""){	
		$sql.=" and CONCAT(i.nro_ingreso,'/',g.gestion) LIKE '%".$_GET['nroIngresoB']."%' ";
	}
	if($_GET['nombreProveedorB']<>""){	
		$sql.=" and i.cod_proveedor in( select cod_proveedor from proveedores where nombre_proveedor like '%".$_GET['nombreProveedorB']."%')";
	}	
	if($_GET['almacenSalidaB']<>""){	
		$sql.=" and i.cod_salida in( select cod_salida from salidas ";
		$sql.=" where cod_almacen in(select cod_almacen from almacenes where nombre_almacen like '%".$_GET['almacenSalidaB']."%'))";
	}	
	if($_GET['nrofacturaB']<>""){	
		$sql.=" and i.nro_factura  like '%".$_GET['nrofacturaB']."%'";
	}
	if($_GET['tipoIngresoB']<>""){	
		$sql.=" and ti.nombre_tipo_ingreso  like '%".$_GET['tipoIngresoB']."%'";
	}
	if($_GET['estadoIngresoB']<>""){	
		$sql.=" and eia.desc_estado_ingreso  like '%".$_GET['$estadoIngresoB']."%'";
	}		

	if($_GET['descCompletaMaterialB']<>""){
		$sql.=" and i.cod_ingreso in(select cod_ingreso from ingresos_detalle where cod_material in(select cod_material from materiales where desc_completa_material like '%".$_GET['descCompletaMaterialB']."%'))";
	}
	if($codActivoFecha=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);
				
				$sql.=" and i.fecha_ingreso>='".$aI."-".$mI."-".$dI."' and i.fecha_ingreso<='".$aF."-".$mF."-".$dF."' ";

		}
	}

	//Fin Busqueda/////////////////	
	//echo $sql;
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

	$sql=" select i.cod_ingreso, i.cod_gestion, g.gestion,  i.nro_ingreso, i.cod_tipo_ingreso,  ti.nombre_tipo_ingreso, "; 
	$sql.=" i.fecha_ingreso, i.cod_usuario_ingreso, i.cod_proveedor, i.cod_contacto_proveedor, i.cod_salida,";
	$sql.=" i.nro_factura, i.obs_ingreso, i.fecha_modifica,";
	$sql.=" i.cod_usuario_modifica, i.cod_estado_ingreso, eia.desc_estado_ingreso, i.obs_anular";
	$sql.=" from ingresos i, estados_ingresos_almacen eia, gestiones g, tipos_ingreso ti";
	$sql.=" where i.cod_estado_ingreso=eia.cod_estado_ingreso";
	$sql.=" and i.cod_gestion=g.cod_gestion";
	$sql.=" and i.cod_tipo_ingreso=ti.cod_tipo_ingreso";
	$sql.=" and i.cod_almacen=".$_COOKIE['cod_almacen_global'];
	if($_GET['nroIngresoB']<>""){	
		$sql.=" and CONCAT(i.nro_ingreso,'/',g.gestion) LIKE '%".$_GET['nroIngresoB']."%' ";
	}
	if($_GET['nombreProveedorB']<>""){	
		$sql.=" and i.cod_proveedor in( select cod_proveedor from proveedores where nombre_proveedor like '%".$_GET['nombreProveedorB']."%')";
	}	
	if($_GET['almacenSalidaB']<>""){	
		$sql.=" and i.cod_salida in( select cod_salida from salidas ";
		$sql.=" where cod_almacen in(select cod_almacen from almacenes where nombre_almacen like '%".$_GET['almacenSalidaB']."%'))";
	}	
	if($_GET['nrofacturaB']<>""){	
		$sql.=" and i.nro_factura  like '%".$_GET['nrofacturaB']."%'";
	}
	if($_GET['tipoIngresoB']<>""){	
		$sql.=" and ti.nombre_tipo_ingreso  like '%".$_GET['tipoIngresoB']."%'";
	}
	if($_GET['estadoIngresoB']<>""){	
		$sql.=" and eia.desc_estado_ingreso  like '%".$_GET['$estadoIngresoB']."%'";
	}		

	if($_GET['descCompletaMaterialB']<>""){
		$sql.=" and i.cod_ingreso in(select cod_ingreso from ingresos_detalle where cod_material in(select cod_material from materiales where desc_completa_material like '%".$_GET['descCompletaMaterialB']."%'))";
	}
	if($codActivoFecha=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);
				
				$sql.=" and i.fecha_ingreso>='".$aI."-".$mI."-".$dI."' and i.fecha_ingreso<='".$aF."-".$mF."-".$dF."' ";

		}
	}


	$sql.=" order by i.cod_ingreso desc";
		//$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		$resp = mysql_query($sql);
		$cont=0;
?>	
	<table width="95%" align="center" cellpadding="1" id="cotizacion" cellspacing="1" bgColor="#cccccc" class="tablaReporte" style="width:100% !important;">
<thead>
	    <tr height="20px" align="center"  class="bg-success text-white">
			<th>Nro Ingreso</th>
    		<th>Fecha</th>	
            <th>Tipo de Ingreso</th>
			<th>Proveedor</th>														
    		<th>Almacen de Traspaso</th>
            <th>Factura</th>
    		<th>Observaciones</th>	            
			<th>Estado</th> 
            <th>&nbsp;</th> 

            
		</tr>
		</thead>  
		<tbody>
<?php   
		while($dat=mysql_fetch_array($resp)){
				
			$cod_ingreso=$dat['cod_ingreso'];
			$cod_gestion=$dat['cod_gestion'];
			$gestion=$dat['gestion'];
			$nro_ingreso=$dat['nro_ingreso'];
			$cod_tipo_ingreso=$dat['cod_tipo_ingreso'];
			$nombre_tipo_ingreso=$dat['nombre_tipo_ingreso'];
			$fecha_ingreso=$dat['fecha_ingreso'];
			$cod_usuario_ingreso=$dat['cod_usuario_ingreso'];
			$cod_proveedor=$dat['cod_proveedor'];
			$cod_contacto_proveedor=$dat['cod_contacto_proveedor'];
			$cod_salida=$dat['cod_salida'];
			$nro_factura=$dat['nro_factura'];
			$obs_ingreso=$dat['obs_ingreso'];
			$fecha_modifica=$dat['fecha_modifica'];
			$cod_usuario_modifica=$dat['cod_usuario_modifica'];
			$cod_estado_ingreso=$dat['cod_estado_ingreso'];
			$desc_estado_ingreso=$dat['desc_estado_ingreso'];
			$obs_anular=$dat['obs_anular'];

		
								
		?> 
		<tr bgcolor="#FFFFFF" valign="middle" >	
    		<td align="right"><?php echo $nro_ingreso."/".$gestion; ?></td>	
			<td align="right">
			<?php 
				echo strftime("%d/%m/%Y",strtotime($fecha_ingreso));

            		$sql2="select u.nombres_usuario, u.ap_paterno_usuario, u.ap_materno_usuario ";
					$sql2.=" from usuarios u ";
					$sql2.=" where u.cod_usuario=".$cod_usuario_ingreso;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){				
						$nombres_usuario=$dat2['nombres_usuario'];
						$ap_paterno_usuario=$dat2['ap_paterno_usuario'];
						$ap_materno_usuario=$dat2['ap_materno_usuario'];
					}	
					echo " (".$nombres_usuario[0].$ap_paterno_usuario[0].$ap_materno_usuario[0].")";	
			
			?></td>	
			<td align="left"><?php echo $nombre_tipo_ingreso; ?></td>											
    		<td align="left">&nbsp;
				<?php 
				if($cod_proveedor<>""){				
					$sql2="select nombre_proveedor from proveedores where cod_proveedor=".$cod_proveedor;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){				
						$nombre_proveedor=$dat2['nombre_proveedor'];
					}	
					echo $nombre_proveedor;		
				} 
				if($cod_contacto_proveedor<>"" and $cod_contacto_proveedor<>0  ){				
					$sql2="select nombre_contacto, ap_paterno_contacto from proveedores_contactos where cod_contacto_proveedor=".$cod_contacto_proveedor;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){				
						$nombre_contacto=$dat2['nombre_contacto'];
						$ap_paterno_contacto=$dat2['ap_paterno_contacto'];
					}	
					echo "<br/>(".$nombre_contacto." ".$ap_paterno_contacto.")";		
				}				
				?>
            </td>
          <td align="left">&nbsp;<?php 
				if($cod_salida<>""){
					$sql2="select s.nro_salida, s.cod_gestion, g.gestion ";
					$sql2.=" from salidas s, gestiones g ";
					$sql2.=" where s.cod_gestion=g.cod_gestion ";
					$sql2.=" and s.cod_salida=".$cod_salida;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){				
						$nro_salida=$dat2['nro_salida'];
						$cod_gestion=$dat2['cod_gestion'];
						$gestion=$dat2['gestion'];
					}

									
					$sql2="select nombre_almacen from almacenes ";
					$sql2.=" where cod_almacen in (select cod_almacen from salidas where cod_salida=".$cod_salida." )";
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){				
						$nombre_almacen=$dat2['nombre_almacen'];
					}	
					echo $nombre_almacen." (".$nro_salida."/".$gestion.")";		
				} 
			?></td>
			<td>&nbsp;<?php echo $nro_factura ;?></td>
	
			<td align="left">&nbsp; <?php echo $obs_ingreso ;?></td>
            <td align="left">&nbsp;<?php echo $desc_estado_ingreso ;?></td>
			<td> <a href="detalleIngreso.php?cod_ingreso=<?php echo $cod_ingreso; ?>" target="_blank">View </a></td>																	

							
							            
   	  </tr>
<?php
		 } 
?>			
  			</tbody>
		</table>
		</body>
</html>