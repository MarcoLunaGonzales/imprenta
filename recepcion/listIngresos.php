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
<title>MODULO DE ALMACENES</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript" src="ajax/searchAjax.js"></script>
<script type="text/javascript">

function buscar()
{	
if(document.form1.codActivoFecha.checked){
	valorchecked="on";
}else{
	valorchecked="off";
}

resultados_ajax('searchIngresos.php?nroIngresoB='+document.form1.nroIngresoB.value+'&nombreProveedorB='+document.form1.nombreProveedorB.value+'&almacenSalidaB='+document.form1.almacenSalidaB.value+'&nrofacturaB='+document.form1.nrofacturaB.value+'&tipoIngresoB='+document.form1.tipoIngresoB.value+'&estadoIngresoB='+document.form1.estadoIngresoB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&descCompletaMaterialB='+document.form1.descCompletaMaterialB.value);

}



function paginar(f)
{	
	if(document.form1.codActivoFecha.checked){
		valorchecked="on";
	}else{
		valorchecked="off";
	}
resultados_ajax('searchIngresos.php?nroIngresoB='+document.form1.nroIngresoB.value+'&nombreProveedorB='+document.form1.nombreProveedorB.value+'&almacenSalidaB='+document.form1.almacenSalidaB.value+'&nrofacturaB='+document.form1.nrofacturaB.value+'&tipoIngresoB='+document.form1.tipoIngresoB.value+'&estadoIngresoB='+document.form1.estadoIngresoB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&descCompletaMaterialB='+document.form1.descCompletaMaterialB.value+'&pagina='+document.form1.pagina.value);

}
function paginar1(f,pagina)
{		
f.pagina.value=pagina*1;
if(document.form1.codActivoFecha.checked){
	valorchecked="on";
}else{
	valorchecked="off";
}
resultados_ajax('searchIngresos.php?nroIngresoB='+document.form1.nroIngresoB.value+'&nombreProveedorB='+document.form1.nombreProveedorB.value+'&almacenSalidaB='+document.form1.almacenSalidaB.value+'&nrofacturaB='+document.form1.nrofacturaB.value+'&tipoIngresoB='+document.form1.tipoIngresoB.value+'&estadoIngresoB='+document.form1.estadoIngresoB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&descCompletaMaterialB='+document.form1.descCompletaMaterialB.value+'&pagina='+document.form1.pagina.value);

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

</script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#F7F5F3">
<form name="form1" method="post"  id="form1">
<?php

	
	require("conexion.inc");
	include("funciones.php");

	$sql2="select nombre_almacen from almacenes where cod_almacen='".$_COOKIE['cod_almacen_global']."'";
	$resp2= mysql_query($sql2);
	$nombre_almacen="";
	while($dat2=mysql_fetch_array($resp2)){
		$nombre_almacen=$dat2[0];
	}	
	


?>
<h3 align="center" style="background:#F7F5F3;font-size: 14px;color: #E78611;font-weight:bold;">INGRESOS <?php echo strtoupper($nombre_almacen);?></h3>

<table border="0" align="center">
<tr>
<td><strong>Nro de Ingreso</strong></td>
<td colspan="3"><input type="text" name="nroIngresoB" id="nroIngresoB" size="10" class="textoform" onkeyup="buscar()" ></td>
</tr>
<tr>
<td><strong>Proveedor</strong></td>
<td>
 <input name="nombreProveedorB" id="nombreProveedorB" size="30" class="textoform"  onkeyup="buscar()">
	</td>
<td><strong>Almacen de Salida</strong></td>
<td><input type="text" name="almacenSalidaB" id="almacenSalidaB" size="30" class="textoform" onkeyup="buscar()" ></td>
</tr>

<tr>
<td><strong>Factura</strong></td>
<td><input type="text" name="nrofacturaB" id="nrofacturaB" size="30" class="textoform" onkeyup="buscar()" ></td>
<td><strong>Tipo de Ingreso</strong></td>
<td><input type="text" name="tipoIngresoB" id="tipoIngresoB" size="30"  class="textoform" onkeyup="buscar()" ></td>
</tr>
<tr>
<td><strong>Estado de Ingreso</strong></td>
<td><input type="text" name="estadoIngresoB" id="estadoIngresoB" size="30"  class="textoform" onkeyup="buscar()" ></td>
<td><strong>Material</strong></td>
<td><input type="text" name="descCompletaMaterialB" id="descCompletaMaterialB" size="50" class="textoform" onkeyup="buscar()" ></td>
</tr>
<tr >
     		<td>&nbsp;<b>Rango de Fecha<br/>(dd//mm/aaaa)</b>&nbsp;</td>			
     		<td colspan="3"><strong>De&nbsp;</strong>
                <input type="text" name="fechaInicioB" id="fechaInicioB" class="textoform" >
       <strong>&nbsp;Hasta&nbsp;</strong>
        <input type="text" name="fechaFinalB" id="fechaFinalB" class="textoform"  >
<input type="checkbox" name="codActivoFecha" id="codActivoFecha"  onClick="buscar()" ><strong>(Chekear para buscar por fechas)</strong>
			</td>
    	</tr>
</table>

<div id="resultados">
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
?>
<h3 align="center" style="background:#F7F5F3;font-size: 10px;color:#E78611;font-weight:bold;">Nro de Registros <?php echo $nro_filas_sql;?></h3>
<?php		
	if($nro_filas_sql==0){
?>
	<table width="90%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>Nro Ingreso</td>
    		<td>Fecha</td>	
            <td>Tipo de Ingreso</td>
			<td>Proveedor</td>														
    		<td>Almacen de Traspaso</td>
            <td>Factura</td>	
    		<td>Observaciones</td>	            
			<td>Estado</td>         
		</tr>
		<tr><th colspan="8" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
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

	$sql=" select i.cod_ingreso, i.cod_gestion, g.gestion,  i.nro_ingreso, i.cod_tipo_ingreso,  ti.nombre_tipo_ingreso, "; 
	$sql.=" i.fecha_ingreso, i.cod_usuario_ingreso, i.cod_proveedor, i.cod_salida, i.nro_factura, i.obs_ingreso, i.fecha_modifica,";
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


	$sql.=" order by g.gestion desc, i.nro_ingreso desc";
		$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		$resp = mysql_query($sql);
		$cont=0;
?>	
	<table width="95%" align="center" cellpadding="1" id="cotizacion" cellspacing="1" bgColor="#cccccc">
<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="9">
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
			<td>Nro Ingreso</td>
    		<td>Fecha</td>	
            <td>Tipo de Ingreso</td>
			<td>Proveedor</td>														
    		<td>Almacen de Traspaso</td>
            <td>Factura</td>
    		<td>Observaciones</td>	            
			<td>Estado</td> 
            <td>&nbsp;</td> 

            
		</tr>
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
  			<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="9">
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
<br>
</form>
</body>
</html>

