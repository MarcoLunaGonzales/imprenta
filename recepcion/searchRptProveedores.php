<?
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
	
						
	$sql="select count(*) ";
	$sql.=" from proveedores p, ciudades c ";
	$sql.=" where  p.cod_ciudad=c.cod_ciudad ";
	if($nombreProveedorB<>""){
	$sql.=" and p.nombre_proveedor like'%".$nombreProveedorB."%'";
	}
	$sql.=" order by p.nombre_proveedor asc ";
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
		$sql="select p.cod_proveedor, p.nombre_proveedor,  p.mail_proveedor, p.telefono_proveedor,";
		$sql.=" p.direccion_proveedor, p.cod_ciudad, c.desc_ciudad,p.contacto1_proveedor, p.cel_contacto1_proveedor,  ";
		$sql.=" p.contacto2_proveedor, p.cel_contacto2_proveedor, p.cod_estado_registro, p.cod_usuario_registro, p.fecha_registro,";
		$sql.=" p.cod_usuario_modifica, p.fecha_modifica ";
		$sql.=" from proveedores p, ciudades c ";
		$sql.=" where  p.cod_ciudad=c.cod_ciudad ";
		if($nombreProveedorB<>""){
			$sql.=" and p.nombre_proveedor like'%".$nombreProveedorB."%'";
		}
		$sql.=" order by p.nombre_proveedor asc ";
	
		$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		//echo $sql;
		$resp = mysql_query($sql);
		$cont=0;
?>	
	<table width="95%" align="center" cellpadding="1" id="cotizacion" cellspacing="1" bgColor="#cccccc">
	<tr bgcolor="#FFFFFF" align="center">
    <td colspan="14" align="right"><input type="submit" name="imprimir" value="Imprimir Proveedores" class="boton"></td>
	</tr>    
<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="12">
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
            <td>Proveedor</td>            
    		<td>Mail</td>
            <td>Ciudad</td>
            <td>Direccion</td>
            <td>Telefono</td>				
            <td>Contacto 1 </td>
            <td>Celular Contacto 1</td>
			<td>Contacto 2</td>    
             <td>Celular Contacto 2</td>
            <td>Fecha Registro</td>                
			<td>Ultima Modificacion</td>     
		</tr>
<?php   
			$nro=0;
		while($dat=mysql_fetch_array($resp)){
				
			$cod_proveedor=$dat['cod_proveedor']; 
			$nombre_proveedor=$dat['nombre_proveedor'];
			$mail_proveedor=$dat['mail_proveedor'];
			$telefono_proveedor=$dat['telefono_proveedor'];
			$direccion_proveedor=$dat['direccion_proveedor'];
			$cod_ciudad=$dat['cod_ciudad'];
			$desc_ciudad=$dat['desc_ciudad'];
			$contacto1_proveedor=$dat['contacto1_proveedor'];
			$cel_contacto1_proveedor=$dat['cel_contacto1_proveedor'];
			$contacto2_proveedor=$dat['contacto2_proveedor'];
			$cel_contacto2_proveedor=$dat['cel_contacto2_proveedor'];
			$cod_estado_registro=$dat['cod_estado_registro'];
			$cod_usuario_registro=$dat['cod_usuario_registro'];
			$fecha_registro=$dat['fecha_registro'];
			$cod_usuario_modifica=$dat['cod_usuario_modifica'];
			$fecha_modifica=$dat['fecha_modifica'];

			
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
            <td align="left"><?php echo $nombre_proveedor;?></td>
            <td align="left"><?php echo $mail_proveedor;?></td>
            <td align="left"><?php echo $desc_ciudad;?></td>
            <td align="left"><?php echo $direccion_proveedor;?></td>	
            <td align="left"><?php echo $telefono_proveedor;?></td>
            <td align="left"><?php echo $contacto1_proveedor;?></td>	
            <td align="left"><?php echo $cel_contacto1_proveedor; ?></td>	            
            <td align="left"><?php echo $contacto2_proveedor;?></td>	
             <td align="left"><?php echo $cel_contacto2_proveedor; ?></td>
            <td align="left">
			<?php 
			if($fecha_registro<>""){
				echo strftime("%d/%m/%Y",strtotime($fecha_registro))." ".$usuario_registro;
			}

			?></td>
             <td align="right">
			 <?php 
			if($fecha_modifica<>""){
				echo strftime("%d/%m/%Y",strtotime($fecha_modifica))." ".$usuario_modifica;
			}

			?></td>
							            
   	  </tr>
<?php
		 } 
?>			
  			<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="12">
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