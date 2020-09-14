<?php
header("Cache-Control: no-store, no-cache, must-revalidate");

//coneccion a la Base de Datos
require("conexion.inc");
include("funciones.php");

$nombreClienteB=$_GET['nombreClienteB'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="pagina.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php 

	$nro_filas_show=100;	
	$pagina=$_GET['pagina'];

	if ($pagina==""){
		$pagina = 1;
		$fila_inicio=0;
		$fila_final=$nro_filas_show;
	}else{
		$fila_inicio=(($pagina*$nro_filas_show)-$nro_filas_show);
		$fila_final=($fila_inicio+$nro_filas_show);
	}	
	
	$sql=" select count(*) ";
	$sql.=" from clientes where cod_cliente<>0 ";
	if($nombreClienteB<>""){
			$sql.=" and   nombre_cliente like '%".$nombreClienteB."%' ";	
	}
	if($_GET['filtroCliente']==1){
	$sql.=" and cod_cliente in(select DISTINCT(c.cod_cliente) from hojas_rutas hr,cotizaciones c where hr.cod_cotizacion=c.cod_cotizacion and cod_estado_hoja_ruta<>2)";		
		}	
	if($_GET['filtroCliente']==2){
	$sql.=" and cod_cliente in(select DISTINCT(cod_cliente) from ordentrabajo where cod_est_ot<>2)";		
		}
		
	if($_GET['filtroCliente']==3){
				$sql.=" and ( cod_cliente in (select DISTINCT(c.cod_cliente) from hojas_rutas hr,cotizaciones c where hr.cod_cotizacion=c.cod_cotizacion and cod_estado_hoja_ruta<>2)";	
				$sql.=" or cod_cliente in (select DISTINCT(cod_cliente) from ordentrabajo where cod_est_ot<>2))";		
		}		
	if($_GET['filtroCliente']==4){
		$sql.=" and cod_cliente <> all(select DISTINCT(c.cod_cliente) from hojas_rutas hr,cotizaciones c where hr.cod_cotizacion=c.cod_cotizacion and cod_estado_hoja_ruta<>2)";		
		$sql.=" and cod_cliente <> all(select DISTINCT(cod_cliente) from ordentrabajo where cod_est_ot<>2)";
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
			<td>Cliente</td>            
    		<td>Nit</td>
            <td>Categoria</td>	
            <td>Ciudad</td>
			<td>Direcci&oacute;n</td>
            <td>Telefono </td>
			<td>Fax</td>
            <td>Celular</td>
            <td>Email</td>
			<td>Observaciones</td>             														    		
			<td>Estado</td>      
            <td>Fecha Registro</td>                
			<td>Ultima Modificacion</td>    
		</tr>
		<tr><th colspan="13" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
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
		$sql=" select cod_cliente,nombre_cliente, nit_cliente, cod_categoria, cod_ciudad, direccion_cliente, ";
		$sql.=" telefono_cliente, celular_cliente, fax_cliente, email_cliente, obs_cliente, cod_usuario_registro, fecha_registro, ";
		$sql.=" cod_usuario_modifica, fecha_modifica, cod_estado_registro ";
		$sql.=" from clientes  where cod_cliente<>0";
		if($nombreClienteB<>""){
			$sql.=" and   nombre_cliente like '%".$nombreClienteB."%' ";	
		}
			if($_GET['filtroCliente']==1){
	$sql.=" and cod_cliente in(select DISTINCT(c.cod_cliente) from hojas_rutas hr,cotizaciones c where hr.cod_cotizacion=c.cod_cotizacion and cod_estado_hoja_ruta<>2)";		
		}	
	if($_GET['filtroCliente']==2){
	$sql.=" and cod_cliente in(select DISTINCT(cod_cliente) from ordentrabajo where cod_est_ot<>2)";		
		}
		
	if($_GET['filtroCliente']==3){
				$sql.=" and ( cod_cliente in (select DISTINCT(c.cod_cliente) from hojas_rutas hr,cotizaciones c where hr.cod_cotizacion=c.cod_cotizacion and cod_estado_hoja_ruta<>2)";	
				$sql.=" or cod_cliente in (select DISTINCT(cod_cliente) from ordentrabajo where cod_est_ot<>2))";		
		}		
	if($_GET['filtroCliente']==4){
		$sql.=" and cod_cliente <> all(select DISTINCT(c.cod_cliente) from hojas_rutas hr,cotizaciones c where hr.cod_cotizacion=c.cod_cotizacion and cod_estado_hoja_ruta<>2)";		
		$sql.=" and cod_cliente <> all(select DISTINCT(cod_cliente) from ordentrabajo where cod_est_ot<>2)";
 }
		$sql.=" order  by nombre_cliente asc";
		$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		//echo $sql;
		$resp = mysql_query($sql);
		$cont=0;
?>	
	<table width="95%" align="center" cellpadding="1" id="cotizacion" cellspacing="1" bgColor="#cccccc">
	<tr bgcolor="#FFFFFF" align="center">
    <td colspan="14" align="right"><input type="submit" name="imprimir" value="Imprimir Clientes" class="boton"></td>
	</tr>
<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="14">
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
			<td>&nbsp;</td>
            <td>Cliente</td>            
    		<td>Nit</td>
            <td>Categoria</td>	
            <td>Ciudad</td>
			<td>Direcci&oacute;n</td>
            <td>Telefono </td>
			<td>Fax</td>
            <td>Celular</td>
            <td>Email</td>
			<td>Observaciones</td>             														    		
			<td>Estado</td>      
            <td>Fecha Registro</td>                
			<td>Ultima Modificacion</td>     
		</tr>
<?php   
			$nro=0;
		while($dat=mysql_fetch_array($resp)){
				
			 $cod_cliente=$dat['cod_cliente'];
			 $nombre_cliente=$dat['nombre_cliente'];
			 $nit_cliente=$dat['nit_cliente'];
			 $cod_categoria=$dat['cod_categoria'];
			 $cod_ciudad=$dat['cod_ciudad'];			 			 
			 $direccion_cliente=$dat['direccion_cliente'];
   		     $telefono_cliente=$dat['telefono_cliente'];
			 $celular_cliente=$dat['celular_cliente'];
			 $fax_cliente=$dat['fax_cliente'];
			 $email_cliente=$dat['email_cliente'];
			 $obs_cliente=$dat['obs_cliente'];
			 $cod_usuario_registro=$dat['cod_usuario_registro'];
			 $fecha_registro=$dat['fecha_registro'];			 
		     $cod_usuario_modifica=$dat['cod_usuario_modifica'];
			 $fecha_modifica=$dat['fecha_modifica'];
			 $cod_estado_registro=$dat['cod_estado_registro'];
			 /// Obteniendo Categoria///////
			 			 $desc_categoria="";
			 if($cod_categoria<>"" && $cod_categoria<>0){
				 $sqlAux="select desc_categoria from clientes_categorias where cod_categoria=".$cod_categoria;
				 $respAux = mysql_query($sqlAux);
				 while($datAux=mysql_fetch_array($respAux)){
					 $desc_categoria=$datAux['desc_categoria'];
				 }
			 }			 
			 //Fin obteniendo Catgeoria////////////
			 //////////Obteniendo Ciudad///////			 			 
			 $desc_ciudad="";
			  if($cod_ciudad<>"" && $cod_ciudad<>0){
				 $sqlAux="select desc_ciudad from ciudades where cod_ciudad=".$cod_ciudad;
				 $respAux = mysql_query($sqlAux);
				 while($datAux=mysql_fetch_array($respAux)){
					 $desc_ciudad=$datAux['desc_ciudad'];
				 }
			 }
			//////////Obteniendo Fin Ciudad/////// 
			 //////////Obteniendo Ciudad///////			 			 
			 $nombre_estado_registro="";
			  if($cod_estado_registro<>"" && $cod_estado_registro<>0){
				 $sqlAux="select nombre_estado_registro from estados_referenciales where cod_estado_registro=".$cod_estado_registro;
				 $respAux = mysql_query($sqlAux);
				 while($datAux=mysql_fetch_array($respAux)){
					 $nombre_estado_registro=$datAux['nombre_estado_registro'];
				 }
			 }
			//////////Obteniendo Fin Ciudad/////// 	
			
			///////////////////////Usuario Registro//////////////////////////
			  $usuario_registro="";
			  if($cod_usuario_registro<>"" && $cod_usuario_registro<>0){
				 $sqlAux="select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios where cod_usuario=".$cod_usuario_registro;
				 $respAux = mysql_query($sqlAux);
				 while($datAux=mysql_fetch_array($respAux)){
					 $usuario_registro=$datAux['nombres_usuario'][0].$datAux['ap_paterno_usuario'][0].$datAux['ap_materno_usuario'][0];
				 }
			 }			 
			///////////////////////Fin Usuario Registro/////////////////////
			///////////////////////Usuario Modifica//////////////////////////
			  $usuario_modifica="";
			  if($cod_usuario_modifica<>"" && $cod_usuario_modifica<>0){
				 $sqlAux="select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios where cod_usuario=".$cod_usuario_modifica;
				 $respAux = mysql_query($sqlAux);
				 while($datAux=mysql_fetch_array($respAux)){
					 $usuario_modifica=$datAux['nombres_usuario'][0].$datAux['ap_paterno_usuario'][0].$datAux['ap_materno_usuario'][0];
				 }
			 }			 
			///////////////////////Fin Usuario Modifica/////////////////////		
			$nro=$nro+1;
								
		?> 
		<tr bgcolor="#FFFFFF" valign="middle" >	
    		<td align="left"><?php echo $nro+$fila_inicio;?></td>
            <td align="left"><?php echo $nombre_cliente;?></td>
            <td align="left"><?php echo $nit_cliente;?></td>
            <td align="left"><?php echo $desc_categoria;?></td>
            <td align="left"><?php echo $desc_ciudad;?></td>	
            <td align="left"><?php echo $direccion_cliente;?></td>
            <td align="left"><?php echo $telefono_cliente;?></td>	
            <td align="left"><?php echo $fax_cliente;?></td>	
            <td align="left"><?php echo $celular_cliente;?></td>
            <td align="left"><?php echo $email_cliente;?></td>
            <td align="left"><?php echo $obs_cliente;?></td>
            <td align="left"><?php echo $nombre_estado_registro;?></td>
            <td align="left">
			<?php 
			if($fecha_registro<>""){
				echo strftime("%d/%m/%Y",strtotime($fecha_registro))." ".$usuario_registro;
			}

			?></td>
             <td align="right">
			 <?php 
			if($fecha_modifica<>""){
				echo strftime("%d/%m/%Y",strtotime($fecha_registro))." ".$usuario_modifica;
			}

			?></td>
							            
   	  </tr>
<?php
		 } 
?>			
  			<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="14">
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
	
</body>
</html>