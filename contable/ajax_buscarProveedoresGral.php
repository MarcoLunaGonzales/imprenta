<?php

header("Cache-Control: no-store, no-cache, must-revalidate");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BUSQUEDA DE PROVEEDORES</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
</head>

<body>


<?php


require("conexion.inc");

		$sql=" select count(*) ";
		$sql.=" from proveedores ";
		$sql.=" where cod_proveedor<>0 ";
		if($_GET['nombre_proveedorB']<>""){
		$sql.=" and( nombre_proveedor like'%".$_GET['nombre_proveedorB']."%' ";
		$sql.=" or cod_proveedor in (select cod_proveedor from proveedores_contactos  ";
		$sql.=" where CONCAT(nombre_contacto,ap_paterno_contacto,ap_materno_contacto)like'%".$_GET['nombre_proveedorB']."%')) ";
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
            <td>Proveedor</td>
			<td>NIT</td>
    		<td>Ciudad</td>
    		<td>Direccion</td>
    		<td>Telefono</td>
    		<td>Contactos</td>			
    		<td>Estado</td>	
    		<td>Registro</td>			
    		<td>Edicion</td>																		
		</tr>
		<tr bgcolor="#FFFFFF" align="center" ><th colspan="9">No Existen registros</th></tr>
        </table>        
        <?php
		}else{
		?>

<h3 align="center" style="background:#F7F5F3;font-size: 10px;color: #E78611;font-weight:bold;"><?php echo "Nro de Registros :".$numRows;?></h3>
<?php

		$sql=" select cod_proveedor, nit_proveedor,  nombre_proveedor, cod_ciudad, direccion_proveedor, ";
		$sql.=" telefono_proveedor, mail_proveedor, cod_estado_registro,";
		$sql.=" fecha_registro, cod_usuario_registro, fecha_modifica, cod_usuario_modifica  ";
		$sql.=" from proveedores";
		$sql.=" where cod_proveedor<>0 ";
		if($_GET['nombre_proveedorB']<>""){		
		$sql.=" and( nombre_proveedor like'%".$_GET['nombre_proveedorB']."%'";
		$sql.=" or cod_proveedor in (select cod_proveedor from proveedores_contactos ";
		$sql.=" where CONCAT(nombre_contacto,ap_paterno_contacto,ap_materno_contacto)like'%".$_GET['nombre_proveedorB']."%'))";
		}

		$sql.=" order by nombre_proveedor asc";
		//echo $sql."<br/>";
			$resp = mysql_query($sql);

?>	
	<table width="98%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
            <td>Proveedor</td>
            <td>NIT</td>			
    		<td>Ciudad</td>
    		<td>Direccion</td>
    		<td>Telefono</td>
    		<td>Contactos</td>			
    		<td>Estado</td>	
    		<td>Registro</td>			
    		<td>Edicion</td>																			
		</tr>

<?php   
		while($dat=mysql_fetch_array($resp)){	
		
			$cod_proveedor=$dat['cod_proveedor'];
			$nit_proveedor=$dat['nit_proveedor'];
			$nombre_proveedor=$dat['nombre_proveedor'];
			$cod_ciudad=$dat['cod_ciudad'];
				$desc_ciudad="";
				$sql2="select desc_ciudad from ciudades where cod_ciudad=".$cod_ciudad;
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$desc_ciudad=$dat2[0];
				}			
			$direccion_proveedor=$dat['direccion_proveedor'];
			$telefono_proveedor=$dat['telefono_proveedor'];
			$mail_proveedor=$dat['mail_proveedor'];
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
                <td align="left"><a href="javascript:enviarDatos('<?php echo $cod_proveedor;?>','<?php echo $nombre_proveedor;?>')"><?php echo $nombre_proveedor;?></a></td>
				<td align="left"><?php echo $nit_proveedor;?></td>
                <td align="left"><?php echo $desc_ciudad;?></td>
                <td align="left"><?php echo $direccion_proveedor;?></td>
                <td align="left"><?php echo $telefono_proveedor;?></td>
                <td align="left"><?php 

					$sqlAux=" select contacto1_proveedor, cel_contacto1_proveedor, contacto2_proveedor, cel_contacto2_proveedor";
					$sqlAux.=" from proveedores ";
					$sqlAux.=" where cod_proveedor=".$cod_proveedor;
					$respAux= mysql_query($sqlAux);
					$contacto1_proveedor="";
					$cel_contacto1_proveedor="";
					$contacto2_proveedor=""; 
					$cel_contacto2_proveedor="";
					while($datAux=mysql_fetch_array($respAux)){
							$contacto1_proveedor=$datAux['contacto1_proveedor'];
							$cel_contacto1_proveedor=$datAux['cel_contacto1_proveedor'];
							$contacto2_proveedor=$datAux['contacto2_proveedor']; 
							$cel_contacto2_proveedor=$datAux['cel_contacto2_proveedor'];
					}					
					
					if($contacto1_proveedor<>"" or $cel_contacto1_proveedor<>"" ){
					?>
						<p style="background:#FFCCFF"><?php echo $contacto1_proveedor." ".$cel_contacto1_proveedor."<br/>";?></p>
					<?php
					}
					if($contacto2_proveedor<>"" or $cel_contacto2_proveedor<>""){
										?>
						<p style="background:#FFCCFF"><?php echo $contacto2_proveedor." ".$cel_contacto2_proveedor."<br/>";?></p>
					<?php
						
					}
					$sqlAux=" select cod_contacto_proveedor, nombre_contacto, ap_paterno_contacto, ";
					$sqlAux.=" ap_materno_contacto, cargo_contacto,";
					$sqlAux.=" telefono_contacto, celular_contacto";
					$sqlAux.=" from proveedores_contactos ";
					$sqlAux.=" where cod_proveedor=".$cod_proveedor;
					$sqlAux.=" order by ap_paterno_contacto, ap_materno_contacto, nombre_contacto asc ";
					$respAux= mysql_query($sqlAux);
					while($datAux=mysql_fetch_array($respAux)){
						$cod_contacto_proveedor=$datAux['cod_contacto_proveedor'];
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


