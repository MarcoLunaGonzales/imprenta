<?php
header("Cache-Control: no-store, no-cache, must-revalidate");

//coneccion a la Base de Datos
require("conexion.inc");


//para sacar los datos de la busqueda
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Clientes</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
</head>
<body bgcolor="#FFFFFF">

<?php	
	//Paginador
	if($_GET['$nro_filas_show']==""){
		$nro_filas_show=20;
	}
	$pagina = $_GET['pagina'];

	if ($pagina == ""){
		$pagina = 1;
		$fila_inicio=0;
		$fila_final=$nro_filas_show;
	}else{
		$fila_inicio=(($pagina*$nro_filas_show)-$nro_filas_show);
		$fila_final=($fila_inicio+$nro_filas_show);
	}	
	
		$sql=" select count(*) ";
		$sql.=" from proveedores where cod_proveedor<>0 ";
		//$sql.=" where( cod_proveedor in (select cod_proveedor from ingresos where cod_estado_ingreso<>2 )) ";
		if($_GET['proveedorContactoB']<>""){
		$sql.=" and (nombre_proveedor like'%".$_GET['proveedorContactoB']."%' ";
		$sql.=" or cod_proveedor in(select cod_proveedor from proveedores_contactos ";
		$sql.=" where CONCAT(nombre_contacto,ap_paterno_contacto,ap_materno_contacto)like '%".$_GET['proveedorContactoB']."%'))";
		}
		if($_GET['codcuentaB']=="true"){
			$sql.=" and (cod_cuenta IS NULL or cod_cuenta='')";
		}	
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
		$sql=" select cod_proveedor, nombre_proveedor, nit_proveedor, mail_proveedor, telefono_proveedor, celular_proveedor, ";
		$sql.=" fax_proveedor, direccion_proveedor, cod_ciudad, contacto1_proveedor, cel_contacto1_proveedor,";
		$sql.=" contacto2_proveedor, cel_contacto2_proveedor, cod_estado_registro, cod_usuario_registro, fecha_registro, ";
		$sql.=" cod_usuario_registro, fecha_modifica, cod_usuario_modifica,cod_cuenta";
		$sql.=" from proveedores where cod_proveedor<>0 ";
	 		//$sql.=" where( cod_proveedor in (select cod_proveedor from ingresos where cod_estado_ingreso<>2)) ";
		if($_GET['proveedorContactoB']<>""){
		$sql.=" and (nombre_proveedor like'%".$_GET['proveedorContactoB']."%' ";
		$sql.=" or cod_proveedor in(select cod_proveedor from proveedores_contactos ";
		$sql.=" where CONCAT(nombre_contacto,ap_paterno_contacto,ap_materno_contacto)like '%".$_GET['proveedorContactoB']."%'))";
		}
		if($_GET['codcuentaB']=="true"){
			$sql.=" and (cod_cuenta IS NULL or cod_cuenta='')";
		}	
	
		$sql.=" order by nombre_proveedor asc";
		//$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;

		$resp = mysql_query($sql);

?>	

	<table width="89%" align="center" cellpadding="1" cellspacing="1" bgColor="#CCCCCC" class="tablaReporte" style="width:100% !important;">
    <thead>
	    <tr height="20px" align="center"  class="bg-success text-white">
    		<th>ID</th>
            <th>Nro Cuenta</th>
            <th>Nombre Cuenta</th>
            <th>Proveedor</th>
            <th>Nit</th>
            <th>Ciudad</th>            
            <th>Direccion</th>
            <th>Telf/Celular/Fax</th>
            <th>**Contactos**</th>
            <th>Contactos</th>
            <th>ING</th>
            <th>&nbsp;</th>            															
		</tr>
    </thead> 
    <tbody>
<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){	
		
				$cod_proveedor=$dat['cod_proveedor'];
				$nombre_proveedor=$dat['nombre_proveedor'];
				$nit_proveedor=$dat['nit_proveedor'];
				$mail_proveedor=$dat['mail_proveedor'];
				$telefono_proveedor=$dat['telefono_proveedor'];
				$celular_proveedor=$dat['celular_proveedor'];
				$fax_proveedor=$dat['fax_proveedor'];
				$direccion_proveedor=$dat['direccion_proveedor'];
				$cod_ciudad=$dat['cod_ciudad'];
				$contacto1_proveedor=$dat['contacto1_proveedor']; 
				$cel_contacto1_proveedor=$dat['cel_contacto1_proveedor'];
				$contacto2_proveedor=$dat['contacto2_proveedor'];
				$cel_contacto2_proveedor=$dat['cel_contacto2_proveedor'];
				$cod_estado_registro=$dat['cod_estado_registro'];
				$cod_usuario_registro=$dat['cod_usuario_registro'];
				$fecha_registro=$dat['fecha_registro'];
				$cod_usuario_registro=$dat['cod_usuario_registro'];
				$fecha_modifica=$dat['fecha_modifica'];
				$cod_usuario_modifica=$dat['cod_usuario_modifica'];
				$cod_cuenta=$dat['cod_cuenta'];
		
				$sql2="select desc_ciudad from ciudades where cod_ciudad='".$cod_ciudad."'";
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$desc_ciudad=$dat2[0];
				}					

					$nombre_estado_registro="";				
					$sql2="select nombre_estado_registro from estados_referenciales";
					$sql2.=" where cod_estado_registro='".$cod_estado_registro."'";	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_estado_registro=$dat2[0];
					}	
				//**************************************************************
					$nroContactos=0;							
					$sql2="select count(*) from proveedores_contactos";
					$sql2.=" where cod_proveedor='".$cod_proveedor."'";	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nroContactos=$dat2[0];
					}	
					$nro_cuenta="";	
					$desc_cuenta="";
					if($cod_cuenta!='' and $cod_cuenta!=null )	{			
					$sql2="select nro_cuenta,desc_cuenta from cuentas where cod_cuenta=".$cod_cuenta;	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nro_cuenta=$dat2['nro_cuenta'];
						$desc_cuenta=$dat2['desc_cuenta'];
					}	
					}						
				$nroING=0;
				$sqlAux2=" select count(*) from  ingresos ";
				$sqlAux2.=" where cod_estado_ingreso<>2 and cod_proveedor=".$cod_proveedor."";
				$respAux2= mysql_query($sqlAux2);
					while($datAux2=mysql_fetch_array($respAux2)){
						$nroING=$datAux2[0];
					}	
?> 

		<tr bgcolor="<?php if($cod_cuenta==null or $cod_cuenta=="" ){ echo '#FFFF66';}else{echo '#FFFFFF';}?>" class="text" >	
				<td><?php echo $cod_proveedor;?></td>		
    		<td><?php echo $nro_cuenta;?></td>   
    		<td><?php echo $desc_cuenta;?></td>   							
    		<td><?php echo $nombre_proveedor;?></td>    		
            <td><?php echo $nit_proveedor;?></td>
            <td><?php echo $desc_ciudad;?></td>
    		<td><?php echo $direccion_proveedor;?></td>
    		<td><?php echo $telefono_proveedor." ".$celular_proveedor." ".$fax_proveedor;?></td>
            <td><?php 
				if($contacto1_proveedor<>"" or $cel_contacto1_proveedor){
					echo $contacto1_proveedor." ".$cel_contacto1_proveedor."<br/>";
				}
				if($contacto2_proveedor<>"" or $cel_contacto2_proveedor){
					echo $contacto2_proveedor." ".$cel_contacto2_proveedor;
				
				}				
			?>
               </td>
<td  align="center" >            
			<?php
	          	$sqlAux=" select cod_contacto_proveedor,nombre_contacto, ap_paterno_contacto, ap_materno_contacto, cargo_contacto,";
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
				?>
							<div align="justify"><?php  echo "*".$nombre_contacto." ".$ap_paterno_contacto." ".$cargo_contacto." ".$telefono_contacto." ".$celular_contacto; ?></div>

                <?php
				}					
			?>
			</td>
			<td><?php echo $nroING;?></td>
			<td><a href="vincularProveedorCuenta.php?cod_proveedor=<?php echo $cod_proveedor;?>" class="link_color1">Editar</a></td>
			</tr>
           
<?php
		 } 
?>			
	</tbody>   
		</table>

	
</body>
</html>