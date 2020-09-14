<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Eliminación de Cuentas</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function eliminar(f){
		f.submit();
	}
	
	function cancelar(f){
		window.location="listCuentas.php";
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<form name="form1" method="post" action="eliminarCuentas.php">
<?php 

	require("conexion.inc");
	include("funciones.php");	
	$cod_cuenta=$_GET["cod_cuenta"];	
	
?>
<input  type="hidden" name="cod_cuenta" id="cod_cliente" value="<?php echo $_GET["cod_cuenta"];?>">
	<h3 align="center" style="background:white;font-size: 14px;color: #E78611;font-weight:bold;">Confirmacion de Eliminacion de Cuenta </h3>

    <?php
					
				$sw=0;			
				$sql=" select count(*) from cuentas where cod_cuenta_padre=".$_GET["cod_cuenta"];		
				$resp= mysql_query($sql);
				$nroCuentas=0;
				while($dat=mysql_fetch_array($resp)){
					$nroCuentas=$dat[0];
					if($nroCuentas>0){
						$sw=1;
					}
				}
				
				$sql=" select count(*) from clientes where cod_cuenta=".$_GET["cod_cuenta"];		
				$resp= mysql_query($sql);
				$nroClientes=0;
				while($dat=mysql_fetch_array($resp)){
					$nroClientes=$dat[0];
					if($nroClientes>0){
						$sw=1;
					}
				}
				
				$sql=" select count(*) from proveedores where cod_cuenta=".$_GET["cod_cuenta"];		
				$resp= mysql_query($sql);
				$nroProveedores=0;
				while($dat=mysql_fetch_array($resp)){
					$nroProveedores=$dat[0];
					if($nroProveedores>0){
						$sw=1;
					}
				}	
				
				$sql=" select count(*) from comprobante_detalle where cod_cuenta=".$_GET["cod_cuenta"];			
				$resp= mysql_query($sql);
				$nroCbte=0;
				while($dat=mysql_fetch_array($resp)){
					$nroCbte=$dat[0];
					if($nroCbte>0){
						$sw=1;
					}
				}								
									

						
?>
<?php if($sw==1){?>
	<h3 align="center" style="background:white;font-size: 11px;color:#E78611;">LA CUENTA NO PUEDE SER ELIMINADA</h3>
<?php
	}else{
?>
<h3 align="center" style="background:white;font-size: 11px;color:#E78611;">LA CUENTA PUEDE SER ELIMINADA</h3>
<?php
	}
?>
<table border="0" cellpadding="0" cellspacing="1" align="center">
<tr><th align="left">Nro Cuentas que Dependientes:</th><td align="left"><?php echo $nroCuentas;?></td></tr>
<tr><th align="left">Nro Clientes:</th><td align="left"><?php echo $nroClientes;?></td></tr>
<tr><th align="left">Nro Proveedores:</th><td align="left"><?php echo $nroProveedores;?></td></tr>
<tr><th align="left">Nro Comprobantes:</th><td align="left"><?php echo $nroCbte;?></td></tr>
</table>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	   	<tr height="20px" align="center"  class="titulo_tabla">
    		<td>Nro Cuenta</td>
            <td>Cuenta</td> 
			<td>Cliente</td> 
			<td>Proveedor</td>            
            <td>Detalle</td>
            <td>Vinculacion</td>
    		<td>Moneda</td>
    		<td>Estado</td>
    		<td>Registro</td>
    		<td>Ultima Edici&oacute;n</td>					
		</tr>
		<?php

				$sql=" select  nro_cuenta, desc_cuenta, detalle_cuenta, cod_moneda, cod_cuenta_padre, ";
				$sql.=" cod_estado_registro, cod_usuario_registro, fecha_registro, cod_usuario_modifica, fecha_modifica ";
				$sql.=" from cuentas ";			
				$sql.=" where  cod_cuenta='".$_GET["cod_cuenta"]."'";	
				$resp = mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){	
		
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
			}
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
               

	    	 </tr>

	 </table>

</div>			

<input type="hidden" name="nombre_cliente" id="nombre_cliente" value="<?php echo $nombre_cliente;?>">
<br/>
<div align="center">

<?php if($sw==0){?>
<INPUT type="button" class="boton" name="btn_eliminar"  value="CONFIRMAR ELIMINICACION" onClick="eliminar(this.form);">
<?php }?>
<INPUT type="button" class="boton" name="btn_eliminar"  value="IR A LISTADO DE CUENTAS" onClick="cancelar(this.form);">

</div>
		
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
