<?php

header("Cache-Control: no-store, no-cache, must-revalidate");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BUSQUEDA DE CLIENTES</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
</head>

<body>


<?php


require("conexion.inc");

	$sql=" select count( DISTINCT(cot.cod_cliente)) ";
	$sql.=" from cotizaciones cot, hojas_rutas hr, clientes cli ";
	$sql.=" where cot.cod_cotizacion=hr.cod_cotizacion ";
	$sql.=" and cot.cod_cliente=cli.cod_cliente";
	$sql.=" and cli.cod_cuenta is null ";

		if($_GET['nombre_clienteB']<>""){
			$sql.=" and ( cli.nombre_cliente like'%".$_GET['nombre_clienteB']."%'";
			$sql.=" or cli.cod_cliente in (select cod_cliente from clientes_contactos ";
			$sql.=" where CONCAT(nombre_contacto,ap_paterno_contacto,ap_materno_contacto)like'%".$_GET['nombre_clienteB']."%'))";
		}


		$resp = mysql_query($sql);
		$numRows=0;
		while($dat=mysql_fetch_array($resp)){
			$numRows=$dat[0];			
		}
		if($numRows==0){
			
		?>
	<table width="98%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
            <td>Nombre</td>
    		<td>Ciudad</td>
    		<td>Direccion</td>
    		<td>Telefono</td>
    		<td>Celular</td>
            <td>Fax</td>
    		<td>Contactos</td>			
    		<td>Estado</td>	
    		<td>Registro</td>			
    		<td>Edicion</td>																		
		</tr>
		<tr bgcolor="#FFFFFF" align="center" ><th colspan="10">No Existen registros</th></tr>
        </table>        
        <?php
		}else{
		?>

<h3 align="center" style="background:#F7F5F3;font-size: 10px;color: #E78611;font-weight:bold;"><?php echo "Nro de Registros :".$numRows;?></h3>
<?php

		$sql=" select DISTINCT(cot.cod_cliente), cli.nombre_cliente ,cli.cod_ciudad , cli.direccion_cliente , ";
		$sql.=" cli.telefono_cliente, cli.celular_cliente, cli.fax_cliente, cli.email_cliente, cli.cod_estado_registro,";
		$sql.=" cli.fecha_registro, cli.cod_usuario_registro, cli.fecha_modifica, cli.cod_usuario_modifica,cli.cod_cuenta ";
		$sql.=" from cotizaciones cot, hojas_rutas hr, clientes cli ";
		$sql.=" where cot.cod_cotizacion=hr.cod_cotizacion ";
		$sql.=" and cot.cod_cliente=cli.cod_cliente";
		$sql.=" and cli.cod_cuenta is null ";
		
		if($_GET['nombre_clienteB']<>""){
		$sql.=" and ( cli.nombre_cliente like'%".$_GET['nombre_clienteB']."%' ";
		$sql.=" or cli.cod_cliente in (select cod_cliente from clientes_contactos ";
		$sql.=" where CONCAT(nombre_contacto,ap_paterno_contacto,ap_materno_contacto)like'%".$_GET['nombre_clienteB']."%'))";
		}
		$sql.=" group by cli.cod_cliente";
		$sql.=" order by cli.nombre_cliente asc";
		echo $sql."<br/>";
			$resp = mysql_query($sql);

?>	
	<table width="98%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
            <td>Nombre</td>
    		<td>Ciudad</td>
    		<td>Direccion</td>
    		<td>Telefono</td>
    		<td>Celular</td>
            <td>Fax</td>
    		<td>Contactos</td>			
    		<td>Estado</td>	
    		<td>Registro</td>			
    		<td>Edicion</td>																			
		</tr>

<?php   
		while($dat=mysql_fetch_array($resp)){	

			$cod_cliente=$dat['cod_cliente'];
			$nombre_cliente=$dat['nombre_cliente'];
			$cod_ciudad=$dat['cod_ciudad'];
				$desc_ciudad="";
				$sql2="select desc_ciudad from ciudades where cod_ciudad=".$cod_ciudad;
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$desc_ciudad=$dat2[0];
				}				
			$direccion_cliente=$dat['direccion_cliente'];
			$telefono_cliente=$dat['telefono_cliente']; 
			$celular_cliente=$dat['celular_cliente'];
			$fax_cliente=$dat['fax_cliente'];
			$email_cliente=$dat['email_cliente'];
			$cod_estado_registro=$dat['cod_estado_registro'];
			$fecha_registro=$dat['fecha_registro'];
			$cod_usuario_registro=$dat['cod_usuario_registro'];
			$fecha_modifica=$dat['fecha_modifica'];
			$cod_usuario_modifica=$dat['cod_usuario_modifica'];
			$nombre_estado_registro="";
				$sql2="select nombre_estado_registro from estados_referenciales where cod_estado_registro='".$cod_estado_registro."'";
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_estado_registro=$dat2[0];
				}		
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
																		
?> 
		<tr bgcolor="#FFFFFF" class="text">	
                <td align="left"><a href="javascript:enviarDatos('<?php echo $cod_cliente;?>','<?php echo $nombre_cliente;?>')"><?php echo $nombre_cliente;?></a></td>
                <td align="left"><?php echo $desc_ciudad;?></td>
                <td align="left"><?php echo $direccion_cliente;?></td>
                <td align="left"><?php echo $telefono_cliente;?></td>
                <td align="left"><?php echo $celular_cliente;?></td>
                <td align="left"><?php echo $fax_cliente;?></td>
                <td align="left"><?php 

					$sqlAux=" select cod_contacto, nombre_contacto, ap_paterno_contacto, ap_materno_contacto, cargo_contacto,";
					$sqlAux.=" telefono_contacto, celular_contacto";
					$sqlAux.=" from clientes_contactos ";
					$sqlAux.=" where cod_cliente=".$cod_cliente;
					$sqlAux.=" order by ap_paterno_contacto, ap_materno_contacto, nombre_contacto asc ";
					$respAux= mysql_query($sqlAux);
					while($datAux=mysql_fetch_array($respAux)){
						$cod_contacto=$datAux['cod_contacto'];
						$nombre_contacto=$datAux['nombre_contacto'];
						$ap_paterno_contacto=$datAux['ap_paterno_contacto'];
						$ap_materno_contacto=$datAux['ap_materno_contacto'];
						$cargo_contacto=$datAux['cargo_contacto'];
						$telefono_contacto=$datAux['telefono_contacto'];
						$celular_contacto=$datAux['celular_contacto'];
						if($cargo_contacto<>""){
				echo $nombre_contacto." ".$ap_paterno_contacto."(".$cargo_contacto.") ".$telefono_contacto." ".$celular_contacto."<br/>";			
						}else{
				echo $nombre_contacto." ".$ap_paterno_contacto." ".$telefono_contacto." ".$celular_contacto."<br/>";	
						}
					}
				?>
				</td>         		
                <td align="left"><?php echo $nombre_estado_registro;?></td>		
            <td align="left">&nbsp;<?php 
			if($fecha_registro<>""){
				echo strftime("%d/%m/%Y",strtotime($fecha_registro))." ".$usuario_registro;
			}

			?></td>
             <td align="right">&nbsp;
			 <?php	 			  
			if($fecha_modifica<>""){
				echo strftime("%d/%m/%Y",strtotime($fecha_modifica))." ".$usuario_modifica;
			}
			?></td>				

    	 </tr>
<?php
		 } 
?>			
</table>
<?php
		 } 
?>

</body>
</html>


