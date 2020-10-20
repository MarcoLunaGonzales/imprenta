<?php
header('Content-Type: text/html; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';

//coneccion a la Base de Datos
require("conexion.inc");
include("funciones.php");

//para sacar los datos de la busqueda
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CUENTAS</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>

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

		$sql=" select count(*)  ";
		$sql.=" from cuentas ";
		if($_GET['numero_cuentaB']<>""){
			$sql.=" where (nro_cuenta like'%".$_GET['numero_cuentaB']."%' ";
			$sql.=" or desc_cuenta like'%".$_GET['numero_cuentaB']."%')";			
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

		$sql=" select cod_cuenta, nro_cuenta, desc_cuenta, detalle_cuenta, cod_moneda, cod_cuenta_padre, ";
		$sql.=" cod_estado_registro, cod_usuario_registro, fecha_registro, cod_usuario_modifica, fecha_modifica ";
		$sql.=" from cuentas ";
		if($_GET['numero_cuentaB']<>""){
			$sql.=" where (nro_cuenta like'%".$_GET['numero_cuentaB']."%' ";
			$sql.=" or desc_cuenta like'%".$_GET['numero_cuentaB']."%')";			
		}
		$sql.=" order by nro_cuenta asc";
		//$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;

		
		$resp = mysql_query($sql);

?>	

	<table width="95%" align="center" cellpadding="1" cellspacing="1" bgColor="#CCCCCC" class="tablaReporte" style="width:100% !important;">
   <thead>
	    <tr height="20px" align="center"  class="bg-success text-white">
    		<th>Nro Cuenta</th>
            <th>Cuenta</th> 
			<th>Cliente</th> 
			<th>Proveedor</th>            
            <th>Detalle</th>
            <th>Vinculacion</th>
    		<th>Moneda</th>
    		<th>Estado</th>
    		<th>Registro</th>
    		<th>Ultima Edici&oacute;n</th>	
            <th>Editar</th>	
			<th>Eliminar</th>		                   																                   															
		</tr>
   </thead>  
   <tbody>  
<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){	
				$cod_cuenta=$dat['cod_cuenta'];
				///
				
				$sql2=" select nombre_proveedor";
				$sql2.=" from proveedores";
				$sql2.=" where cod_cuenta=".$cod_cuenta;
				$nombre_proveedor="";
				$resp2 = mysql_query($sql2);	
				while($dat2=mysql_fetch_array($resp2)){			
						$nombre_proveedor=$dat2['nombre_proveedor'];			
				}
				$sql2=" select nombre_cliente";
				$sql2.=" from clientes";
				$sql2.=" where cod_cuenta=".$cod_cuenta;
				$nombre_cliente="";
				$resp2 = mysql_query($sql2);	
				while($dat2=mysql_fetch_array($resp2)){			
						$nombre_cliente=$dat2['nombre_cliente'];			
				}				

				$nro_cuenta=$dat['nro_cuenta'];
				$desc_cuenta=$dat['desc_cuenta'];
				$detalle_cuenta=$dat['detalle_cuenta'];
				$cod_moneda=$dat['cod_moneda'];
				$cod_cuenta_padre=$dat['cod_cuenta_padre'];
				$cod_estado_registro=$dat['cod_estado_registro'];
				$cod_usuario_registro=$dat['cod_usuario_registro'];
				$fecha_registro=$dat['fecha_registro'];
				$cod_usuario_modifica=$dat['cod_usuario_modifica'];
				$fecha_modifica=$dat['fecha_modifica'];
				$nro_cuenta_padre="";
				$desc_cuenta_padre="";
				if($cod_cuenta_padre!= NULL){
					$sql2=" select  nro_cuenta, desc_cuenta ";
					$sql2.=" from cuentas ";
					$sql2.=" where cod_cuenta=".$cod_cuenta_padre." ";
					$resp2 = mysql_query($sql2);	
					while($dat2=mysql_fetch_array($resp2)){
			
						$nro_cuenta_padre=$dat2['nro_cuenta'];
						$desc_cuenta_padre=$dat2['desc_cuenta'];			
					}
				}				
				//Obteniendo la descripcion de la Moneda
					$sql2="select desc_moneda from monedas where cod_moneda=".$cod_moneda;
					$resp2 = mysql_query($sql2);
					$desc_moneda="";
					while($dat2=mysql_fetch_array($resp2)){
						$desc_moneda=$dat2['desc_moneda'];
					}
				// Fin Obteniendo la descripcion de la Moneda
				//Obteniendo la descripcion del Estado de Registro
					$sql2="select nombre_estado_registro from estados_referenciales where cod_estado_registro=".$cod_estado_registro;
					$resp2 = mysql_query($sql2);
					$nombre_estado_registro="";
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_estado_registro=$dat2['nombre_estado_registro'];
					}
				// Fin Obteniendo la descripcion del Estado de Registro				
				
				//Obteniendo la descripcion del Estado de Registro
					$sql2="select nombre_estado_registro from estados_referenciales where cod_estado_registro=".$cod_estado_registro;
					$resp2 = mysql_query($sql2);
					$nombre_estado_registro="";
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_estado_registro=$dat2['nombre_estado_registro'];
					}
				// Fin Obteniendo la descripcion del Estado de Registro	
				//Obteniendo Fecha de Registro
					$usuario_registro="";
				if($cod_usuario_registro!=NULL){
					$sql2=" select nombres_usuario, nombres_usuario2, nombres_pila, ap_paterno_usuario, ap_materno_usuario ";
					$sql2.=" from usuarios where cod_usuario=".$cod_usuario_registro;
					$resp2 = mysql_query($sql2);
				
					while($dat2=mysql_fetch_array($resp2)){
						$nombres_usuario=$dat2['nombres_usuario'];
						$nombres_usuario2=$dat2['nombres_usuario2'];
						$nombres_pila=$dat2['nombres_pila'];
						$ap_paterno_usuario=$dat2['ap_paterno_usuario'];
						$ap_materno_usuario=$dat2['ap_materno_usuario'];
						$usuario_registro=$nombres_usuario[0].$ap_paterno_usuario[0].$ap_materno_usuario[0];
					}
					
						$usuario_registro=strftime("%d/%m/%Y %H:%M:%S",strtotime($fecha_registro))." ".$usuario_registro;
				}
				// Fin Obteniendo Fecha de Registro	
				//Obteniendo Fecha de Registro
					$usuario_modifica="";
				if($cod_usuario_modifica!=NULL){
					$sql2=" select nombres_usuario, nombres_usuario2, nombres_pila, ap_paterno_usuario, ap_materno_usuario ";
					$sql2.=" from usuarios where cod_usuario=".$cod_usuario_modifica;
					$resp2 = mysql_query($sql2);
				
					while($dat2=mysql_fetch_array($resp2)){
						$nombres_usuario=$dat2['nombres_usuario'];
						$nombres_usuario2=$dat2['nombres_usuario2'];
						$nombres_pila=$dat2['nombres_pila'];
						$ap_paterno_usuario=$dat2['ap_paterno_usuario'];
						$ap_materno_usuario=$dat2['ap_materno_usuario'];
						$usuario_modifica=$nombres_usuario[0].$ap_paterno_usuario[0].$ap_materno_usuario[0];
					}
					
						$usuario_modifica=strftime("%d/%m/%Y %H:%M:%S",strtotime($fecha_modifica))." ".$usuario_modifica;
					}
				// Fin Obteniendo Fecha de Registro					
?> 								
 

		<tr bgcolor="#FFFFFF" class="text">	
				<td align="left"><strong><?php echo $nro_cuenta;?></strong></td>
                <td align="left"><?php echo $desc_cuenta;?></td>
				 <td align="left"><?php echo $nombre_cliente;?></td>
				  <td align="left"><?php echo $nombre_proveedor;?></td>
                <td align="left"><?php echo $detalle_cuenta;?></td>
                <td align="left"><?php echo $nro_cuenta_padre." ".$desc_cuenta_padre;?></td>
                <td align="left"><?php echo $desc_moneda;?></td>
                <td align="left"><?php echo $nombre_estado_registro;?></td>
                <td align="left"><?php echo $usuario_registro;?></td>
                <td align="left"><?php echo $usuario_modifica;?></td>
                <td align="left"><a href="editCuenta.php?cod_cuenta=<?php echo $cod_cuenta;?>">Editar</a></td>    
				<td align="left">
				<?php 
					$sql3="select count(*) from cuentas where cod_cuenta_padre=".$cod_cuenta;
					$resp3 = mysql_query($sql3);
					$cont1=0;
					while($dat3=mysql_fetch_array($resp3)){
						$cont1=$dat3[0];
					}
					$sql3="select count(*) from clientes where cod_cuenta=".$cod_cuenta;
					$resp3 = mysql_query($sql3);
					$cont2=0;
					while($dat3=mysql_fetch_array($resp3)){
						$cont2=$dat3[0];
					}	
					$sql3="select count(*) from proveedores where cod_cuenta=".$cod_cuenta;
					$resp3 = mysql_query($sql3);
					$cont3=0;
					while($dat3=mysql_fetch_array($resp3)){
						$cont3=$dat3[0];
					}
					$sql3="select count(*) from comprobante_detalle where cod_cuenta=".$cod_cuenta;
					$resp3 = mysql_query($sql3);
					$cont4=0;
					while($dat3=mysql_fetch_array($resp3)){
						$cont4=$dat3[0];
					}															
					if($cont1==0 and $cont2==0 and $cont3==0 and $cont4==0){
				?>
					<a href="listaEliminarCuentas.php?cod_cuenta=<?php echo $cod_cuenta;?>">Eliminar</a>    
				<?php
					}else{
				?>
					<a href="listaEliminarCuentas.php?cod_cuenta=<?php echo $cod_cuenta;?>" style="color:#FF0000">Eliminar</a>   
				<?php
					}
				?>  
				</td>         
         </tr>

<?php
		 } 
?>			
	</tbody>
		</table>

</body>
</html>