<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Eliminación de Clientes</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function eliminar(f){
		f.submit();
	}
	
	function cancelar(f){
		window.location="navegadorClientes.php?clienteContactoB="+f.nombre_cliente.value;
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<form name="form1" method="post" action="eliminarClientes.php">
<?php 

	require("conexion.inc");
	include("funciones.php");	
	$cod_cliente=$_GET["cod_cliente"];	
	
?>
<input  type="hidden" name="cod_cliente" id="cod_cliente" value="<?php echo $cod_cliente;?>">
	<h3 align="center" style="background:white;font-size: 14px;color: #E78611;font-weight:bold;">Confirmacion de Eliminacion de Clientes </h3>

    <?php


				$sw=0;			
				$sql=" select  count(*)  from cotizaciones  where cod_cliente='".$cod_cliente."'";			
				$resp= mysql_query($sql);
				$nroCotizaciones=0;
				while($dat=mysql_fetch_array($resp)){
					$nroCotizaciones=$dat[0];
					if($nroCotizaciones>0){
						$sw=1;
					}
				}
				
				$sql=" select  count(*)  from ordentrabajo  where cod_cliente='".$cod_cliente."'";			
				$resp= mysql_query($sql);
				$nroOT=0;
				while($dat=mysql_fetch_array($resp)){
					$nroOT=$dat[0];
					if($nroOT>0){
						$sw=1;
					}
				}
				
				$sql=" select  count(*)  from pagos  where cod_cliente='".$cod_cliente."'";			
				$resp= mysql_query($sql);
				$nroPagos=0;
				while($dat=mysql_fetch_array($resp)){
					$nroPagos=$dat[0];
					if($nroPagos>0){
						$sw=1;
					}
				}	
				
				$sql=" select  count(*)  from salidas  where cod_cliente_venta='".$cod_cliente."' and cod_tipo_salida=1";			
				$resp= mysql_query($sql);
				$nroSalidas=0;
				while($dat=mysql_fetch_array($resp)){
					$nroSalidas=$dat[0];
					if($nroSalidas>0){
						$sw=1;
					}
				}								
				$sql=" select  count(*)  from facturas  where cod_cliente='".$cod_cliente."'";			
				$resp= mysql_query($sql);
				$nroFacturas=0;
				while($dat=mysql_fetch_array($resp)){
					$nroFacturas=$dat[0];
					if($nroFacturas>0){
						$sw=1;
					}					
				}									


									

						
?>
<?php if($sw==1){?>
	<h3 align="center" style="background:white;font-size: 11px;color:#E78611;">EL CLIENTE NO PUEDE SER ELIMINADO</h3>
<?php
	}else{
?>
<h3 align="center" style="background:white;font-size: 11px;color:#E78611;">EL CLIENTE  PUEDE SER ELIMINADO</h3>
<?php
	}
?>
<table border="0" cellpadding="0" cellspacing="1" align="center">
<tr><th align="left">Nro Cotizaciones:</th><td align="left"><?php echo $nroCotizaciones;?></td></tr>
<tr><th align="left">Nro Ordenes de Trabajo:</th><td align="left"><?php echo $nroOT;?></td></tr>
<tr><th align="left">Nro Salidas:</th><td align="left"><?php echo $nroSalidas;?></td></tr>
<tr><th align="left">Nro Pagos:</th><td align="left"><?php echo $nroPagos;?></td></tr>
<tr><th align="left">Nro Facturas:</th><td align="left"><?php echo $nroFacturas;?></td></tr>
</table>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	   	<tr height="20px" align="center"  class="titulo_tabla">
			<td>Cliente</td>
    		<td>Nit</td>
    		<td>Categoria</td>
    		<td>Ciudad</td>
    		<td>Direcci&oacute;n</td>
    		<td>Telefonos</td>
    		<td>Fax</td>			
    		<td>Email</td>					
    		<td>Observaciones</td>			
    		<td>Estado</td>					
		</tr>
		<?php

				$sql=" select cod_cliente, nombre_cliente, nit_cliente,cod_categoria, cod_ciudad, ";
				$sql.=" direccion_cliente, telefono_cliente, celular_cliente,fax_cliente, ";
				$sql.=" email_cliente, obs_cliente, cod_usuario_registro, ";
				$sql.=" fecha_registro, cod_usuario_modifica, fecha_modifica, cod_estado_registro ";
				$sql.=" from clientes ";				
				$sql.=" where  cod_cliente='".$cod_cliente."'";	
				$resp = mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){	
		
					$cod_cliente=$dat[0];
					$nombre_cliente=$dat[1]; 
					$nit_cliente=$dat[2];
					$cod_categoria=$dat[3];
					//**************************************************************
						$desc_categoria="";				
						$sql2="select desc_categoria from clientes_categorias where cod_categoria='".$cod_categoria."'";	
						$resp2= mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2)){
							$desc_categoria=$dat2[0];
						}	
					//**************************************************************					
					$cod_ciudad=$dat[4];
					//**************************************************************
					$desc_ciudad="";
					$sql2="select desc_ciudad from ciudades where cod_ciudad='".$cod_ciudad."'";
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$desc_ciudad=$dat2[0];
					}					
					//**************************************************************
					$direccion_cliente=$dat[5];
					$telefono_cliente=$dat[6];
					$celular_cliente=$dat[7];
					$fax_cliente=$dat[8];
					$email_cliente=$dat[9];
					$obs_cliente=$dat[10];
					$cod_usuario_registro=$dat[11]; 
					$fecha_registro=$dat[12];
					$cod_usuario_modifica=$dat[13];
					$fecha_modifica=$dat[14];
					$cod_estado_registro=$dat[15];
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
    		<td><?php echo $nombre_cliente;?></td>
    		<td><?php echo $nit_cliente;?></td>
    		<td><?php echo $desc_categoria; ?></td>
    		<td><?php echo $desc_ciudad; ?></td>
    		<td><?php echo $direccion_cliente;?></td>
    		<td><?php echo $telefono_cliente; if($celular_cliente!=""){echo "- ".$celular_cliente;}?></td>
    		<td><?php echo $fax_cliente;?></td>
			<td><?php echo $email_cliente;?></td>						
			<td><?php echo $obs_cliente;?></td>	
    		<td><?php echo $nombre_estado_registro;?></td>
	    	 </tr>

	 </table>

</div>			

<input type="hidden" name="nombre_cliente" id="nombre_cliente" value="<?php echo $nombre_cliente;?>">
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
