<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Eliminación de Proveedores</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function eliminar(f){
		f.submit();
	}
	
	function cancelar(f){
		window.location="listProveedores.php?proveedorContactoB="+f.nombre_proveedor.value;
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<form name="form1" method="post" action="eliminarProveedores.php">
<?php 

	require("conexion.inc");
	include("funciones.php");	

	
?>
<input  type="hidden" name="cod_proveedor" id="cod_proveedor" value="<?php echo $_GET["cod_proveedor"];?>">
	<h3 align="center" style="background:white;font-size: 14px;color: #E78611;font-weight:bold;">Confirmacion de Eliminacion de Proveedores </h3>

    <?php


				$sw=0;			
				$sql=" select  count(*)  from ingresos  where cod_proveedor='".$_GET["cod_proveedor"]."'";			
				$resp= mysql_query($sql);
				$nroIngresos=0;
				while($dat=mysql_fetch_array($resp)){
					$nroIngresos=$dat[0];
					if($nroIngresos>0){
						$sw=1;
					}
				}
				
				$sql=" select  count(*)  from gastos_ordentrabajo  where cod_proveedor='".$_GET["cod_proveedor"]."'";			
				$resp= mysql_query($sql);
				$nroOT=0;
				while($dat=mysql_fetch_array($resp)){
					$nroOT=$dat[0];
					if($nroOT>0){
						$sw=1;
					}
				}

				$sql=" select  count(*)  from gastos_hojasrutas  where cod_proveedor='".$_GET["cod_proveedor"]."'";			
				$resp= mysql_query($sql);
				$nroHR=0;
				while($dat=mysql_fetch_array($resp)){
					$nroHR=$dat[0];
					if($nroHR>0){
						$sw=1;
					}
				}
				
				

								
									

						
?>
<?php if($sw==1){?>
	<h3 align="center" style="background:white;font-size: 11px;color:#E78611;">EL PROVEEDOR NO PUEDE SER ELIMINADO</h3>
<?php
	}else{
?>
<h3 align="center" style="background:white;font-size: 11px;color:#E78611;">EL PROVEEDOR  PUEDE SER ELIMINADO</h3>
<?php
	}
?>
<table border="0" cellpadding="0" cellspacing="1" align="center">
<tr><th align="left">Nro Ingresos:</th><td align="left"><?php echo $nroIngresos;?></td></tr>
<tr><th align="left">Nro Gastos HR:</th><td align="left"><?php echo $nroOT;?></td></tr>
<tr><th align="left">Nro Gastos OT:</th><td align="left"><?php echo $nroHR;?></td></tr>
</table>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	   	<tr height="20px" align="center"  class="titulo_tabla">
			<td>Proveedor</td>
    		<td>Nit</td>
    		<td>Ciudad</td>
    		<td>Direcci&oacute;n</td>
    		<td>Telefonos</td>
    		<td>Fax</td>			
    		<td>Email</td>					
    		<td>Observaciones</td>			
    		<td>Estado</td>					
		</tr>
		<?php

				$sql=" select  nombre_proveedor, nit_proveedor, cod_ciudad, ";
				$sql.=" direccion_proveedor, telefono_proveedor, celular_proveedor,fax_proveedor, ";
				$sql.=" mail_proveedor, obs_proveedor, cod_usuario_registro, ";
				$sql.=" fecha_registro, cod_usuario_modifica, fecha_modifica, cod_estado_registro ";
				$sql.=" from proveedores ";				
				$sql.=" where  cod_proveedor='".$_GET["cod_proveedor"]."'";	
				$resp = mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){	
				
					$nombre_proveedor=$dat['nombre_proveedor'];
					$nit_proveedor=$dat['nit_proveedor'];
					$cod_ciudad=$dat['cod_ciudad'];
					$direccion_proveedor=$dat['direccion_proveedor'];
					$telefono_proveedor=$dat['telefono_proveedor'];
					$celular_proveedor=$dat['celular_proveedor'];
					$fax_proveedor=$dat['fax_proveedor'];
					$mail_proveedor=$dat['mail_proveedor'];
					$obs_proveedor=$dat['obs_proveedor'];	
					$cod_usuario_registro=$dat['cod_usuario_registro']; 
					$fecha_registro=$dat['fecha_registro'];
					$cod_usuario_modifica=$dat['cod_usuario_modifica'];
					$fecha_modifica=$dat['fecha_modifica'];
					$cod_estado_registro=$dat['cod_estado_registro'];
					//**************************************************************
					$desc_ciudad="";
					$sql2="select desc_ciudad from ciudades where cod_ciudad='".$cod_ciudad."'";
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$desc_ciudad=$dat2[0];
					}					
					//**************************************************************					
					//**************************************************************
						$nombre_estado_registro="";				
						$sql2="select nombre_estado_registro from estados_referenciales";
						$sql2.=" where cod_estado_registro='".$cod_estado_registro."'";	
						$resp2= mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2)){
							$nombre_estado_registro=$dat2[0];
						}	
					//**************************************************************
				}										

	
		?>		
			<tr bgcolor="#FFFFFF">
    		<td><?php echo $nombre_proveedor;?></td>
    		<td><?php echo $nit_proveedor;?></td>
    		<td><?php echo $desc_ciudad; ?></td>
    		<td><?php echo $direccion_proveedor;?></td>
    		<td><?php echo $telefono_proveedor; if($celular_proveedor!=""){echo "- ".$celular_proveedor;}?></td>
    		<td><?php echo $fax_proveedor;?></td>
			<td><?php echo $email_proveedor;?></td>						
			<td><?php echo $obs_proveedor;?></td>	
    		<td><?php echo $nombre_estado_registro;?></td>
	    	 </tr>

	 </table>

</div>			

<input type="hidden" name="nombre_proveedor" id="nombre_proveedor" value="<?php echo $nombre_proveedor;?>">
<br/>
<div align="center">

<?php if($sw==0){?>
<INPUT type="button" class="boton" name="btn_eliminar"  value="CONFIRMAR ELIMINICACION" onClick="eliminar(this.form);">
<?php }?>
<INPUT type="button" class="boton" name="btn_eliminar"  value="IR A LISTADO DE CLIENTES" onClick="cancelar(this.form);">

</div>
		
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
