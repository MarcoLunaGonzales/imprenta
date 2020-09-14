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
		window.location="listContactosClientes.php?cod_cliente="+f.cod_cliente.value;
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<form name="form1" method="post" action="eliminarContactoCliente.php">
<?php 

	require("conexion.inc");
	include("funciones.php");	
	$cod_contacto=$_GET["cod_contacto"];	
	
	$sql2="select nombre_cliente from clientes where cod_cliente in( select cod_cliente from clientes_contactos where cod_contacto=".$cod_contacto.")";
	$resp2= mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2)){
		$nombre_cliente=$dat2[0];
	}
	
?>

	<h3 align="center" style="background:white;font-size: 14px;color: #E78611;font-weight:bold;">Eliminacion de Contactos de <?php echo $nombre_cliente;?></h3>

    <?php


				$sw=0;			
				$sql=" select  count(*)  from cotizaciones  where cod_contacto='".$cod_contacto."'";			
				$resp= mysql_query($sql);
				$nroCotizaciones=0;
				while($dat=mysql_fetch_array($resp)){
					$nroCotizaciones=$dat[0];
					if($nroCotizaciones>0){
						$sw=1;
					}
				}
				
				$sql=" select  count(*)  from ordentrabajo  where cod_contacto='".$cod_contacto."'";			
				$resp= mysql_query($sql);
				$nroOT=0;
				while($dat=mysql_fetch_array($resp)){
					$nroOT=$dat[0];
					if($nroOT>0){
						$sw=1;
					}
				}
				
				/*$sql=" select  count(*)  from pagos  where cod_cliente='".$cod_cliente."'";			
				$resp= mysql_query($sql);
				$nroPagos=0;
				while($dat=mysql_fetch_array($resp)){
					$nroPagos=$dat[0];
					$sw=1;
				}	*/
				
				$sql=" select  count(*)  from salidas  where cod_contacto='".$cod_contacto."' and cod_tipo_salida=1";			
				$resp= mysql_query($sql);
				$nroSalidas=0;
				while($dat=mysql_fetch_array($resp)){
					$nroSalidas=$dat[0];
					if($nroSalidas>0){
						$sw=1;
					}
				}								
				
				/*$sql=" select  count(*)  from facturas  where cod_cliente='".$cod_cliente."'";			
				$resp= mysql_query($sql);
				$nroFacturas=0;
				while($dat=mysql_fetch_array($resp)){
					$nroFacturas=$dat[0];
				}	*/								


									

						
?>

<?php if($sw==1){?>
	<h3 align="center" style="background:white;font-size: 11px;color:#E78611;">EL CONTACTO NO PUEDE SER ELIMINADO</h3>
<?php
	}else{
?>
<h3 align="center" style="background:white;font-size: 11px;color:#E78611;">EL CONTACTO  PUEDE SER ELIMINADO</h3>
<?php
	}
?>
<table border="0" cellpadding="0" cellspacing="1" align="center">
<tr><th align="left">Nro Cotizaciones:</th><td align="left"><?php echo $nroCotizaciones;?></td></tr>
<tr><th align="left">Nro Ordenes de Trabajo:</th><td align="left"><?php echo $nroOT;?></td></tr>
<tr><th align="left">Nro Salidas:</th><td align="left"><?php echo $nroSalidas;?></td></tr>
<!--tr><th align="left">Nro Pagos:</th><td align="left"><?php echo $nroPagos;?></td></tr>
<tr><th align="left">Nro Facturas:</th><td align="left"><?php echo $nroFacturas;?></td></tr-->
</table>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	   	<tr height="20px" align="center"  class="titulo_tabla">
    		<td>Contacto</td>
            <td>Cargo</td>
    		<td>Telf</td>
    		<td>Celular</td>
    		<td>Email</td>
    		<td>Fecha de Registro</td>
    		<td>Ultima Edicion</td>			
    		<td>Estado</td>				
		</tr>
		<?php

		$sql2=" select  cod_cliente,nombre_contacto, ap_paterno_contacto,";
		$sql2.=" ap_materno_contacto, telefono_contacto, celular_contacto,";
		$sql2.=" email_contacto, cargo_contacto, cod_usuario_registro, ";
		$sql2.=" fecha_registro, cod_usuario_modifica, fecha_modifica, cod_estado_registro";
		$sql2.=" from clientes_contactos";
		$sql2.=" where cod_contacto=".$cod_contacto;
		$sql2.=" order by ap_paterno_contacto,ap_materno_contacto,nombre_contacto";
		$resp2=mysql_query($sql2);
		while($dat2=mysql_fetch_array($resp2)){

			$cod_cliente=$dat2['cod_cliente'];
			$nombre_contacto=$dat2['nombre_contacto'];
			$ap_paterno_contacto=$dat2['ap_paterno_contacto'];
			$ap_materno_contacto=$dat2['ap_materno_contacto'];
			$telefono_contacto=$dat2['telefono_contacto'];
			$celular_contacto=$dat2['celular_contacto'];
			$email_contacto=$dat2['email_contacto'];
			$cargo_contacto=$dat2['cargo_contacto'];
			$cod_usuario_registro=$dat2['cod_usuario_registro'];
			$fecha_registro=$dat2['fecha_registro'];
			$usuario_registro="";
			if($cod_usuario_registro<>""){
				$sql3=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
				$sql3.=" from usuarios ";
				$sql3.=" where cod_usuario=".$cod_usuario_registro;
				$resp3=mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3)){
					$usuario_registro=$dat3['nombres_usuario'][0].$dat3['ap_paterno_usuario'][0].$dat3['ap_materno_usuario'][0];
				}
				if($fecha_registro<>""){
					$usuario_registro= $usuario_registro." ".strftime("%d/%m/%Y",strtotime($fecha_registro));
				}		
			}
					
			$cod_usuario_modifica=$dat2['cod_usuario_modifica'];
			$fecha_modifica=$dat2['fecha_modifica'];
			$usuario_modifica="";
			if($cod_usuario_modifica<>""){
				$sql3=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
				$sql3.=" from usuarios ";
				$sql3.=" where cod_usuario=".$cod_usuario_modifica;
				$resp3=mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3)){
					$usuario_modifica=$dat3['nombres_usuario'][0].$dat3['ap_paterno_usuario'][0].$dat3['ap_materno_usuario'][0];
				}
				if($fecha_modifica<>""){
					$usuario_modifica= $usuario_modifica." ".strftime("%d/%m/%Y",strtotime($fecha_modifica));
				}		
			}				
			
			$cod_estado_registro=$dat2['cod_estado_registro'];	
			$sql3=" select nombre_estado_registro ";
			$sql3.=" from estados_referenciales ";
			$sql3.=" where cod_estado_registro=".$cod_estado_registro;
			$resp3=mysql_query($sql3);
			$nombre_estado_registro="";
			while($dat3=mysql_fetch_array($resp3)){
				$nombre_estado_registro=$dat3['nombre_estado_registro'];
			}							

		}
		?>		
			<tr bgcolor="#FFFFFF">
        	<td><?php echo $ap_paterno_contacto." ".$ap_materno_contacto." ".$nombre_contacto;?></td>
            <td><?php echo $cargo_contacto;?></td>
            <td><?php echo $telefono_contacto;?></td>
            <td><?php echo $celular_contacto;?></td>
            <td><?php echo $email_contacto;?></td> 
            <td><?php echo $usuario_registro;?></td>
            <td><?php echo $usuario_modifica;?></td> 
			<td><?php echo $nombre_estado_registro;?></td> 
   	  </tr>

  </table>

</div>			

<input type="hidden" name="cod_cliente" id="cod_cliente" value="<?php echo $cod_cliente;?>">
<input type="hidden" name="cod_contacto" id="cod_contacto" value="<?php echo $cod_contacto;?>">
<br/>
<div align="center">

<?php if($sw==0){?>
<INPUT type="button" class="boton" name="btn_eliminar"  value="CONFIRMAR ELIMINACION" onClick="eliminar(this.form);">
<?php }?>
<INPUT type="button" class="boton" name="btn_eliminar"  value="IR A LISTADO DE CONTACTOS" onClick="cancelar(this.form);">

</div>
		
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
