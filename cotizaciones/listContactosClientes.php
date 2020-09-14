<?php 
header("Cache-Control: no-store, no-cache, must-revalidate");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language='Javascript'>

	function cancelar(f){
		window.location="navegadorClientes.php?clienteContactoB="+f.nombre_cliente.value;
	}
</script>
</head>

<body bgcolor="#FFFFFF">
<form method="post" name="form1" id="form1" action="newContactoCliente.php">

<?php require("conexion.inc");
	$codcliente=$_GET['cod_cliente'];	
	$sql2=" select nombre_cliente";
	$sql2.=" from clientes ";
	$sql2.=" where cod_cliente=".$codcliente;
	$resp2=mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2)){
		$nombre_cliente=$dat2['nombre_cliente'];
	}
	
	$sql2=" select count(*)";
	$sql2.=" from clientes_contactos";
	$sql2.=" where cod_cliente=".$codcliente;
	$sql2.=" order by ap_paterno_contacto,ap_materno_contacto,nombre_contacto";
	$resp2=mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2)){
		$nro_filas=$dat2[0];
	}
		
?>
<input type="hidden" name="cod_cliente" id="cod_cliente" value="<?php echo $cod_cliente;?>">
<input type="hidden" name="nombre_cliente" id="nombre_cliente" value="<?php echo $nombre_cliente;?>">
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">CONTACTOS DE <?php echo $nombre_cliente;?></h3>
<?php

 if($nro_filas==0){ ?>
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
        <tr bgcolor="#FFFFFF">
        	<td colspan="8" align="center">No existen Registros</td>       
        </tr>
        </table>
<?php }else{?>

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
            <td>&nbsp;</td>
            <td>&nbsp;</td>											
		</tr>

<?php	
	$sql2=" select cod_contacto, nombre_contacto, ap_paterno_contacto,";
	$sql2.=" ap_materno_contacto, telefono_contacto, celular_contacto,";
	$sql2.=" email_contacto, cargo_contacto, cod_usuario_registro, ";
	$sql2.=" fecha_registro, cod_usuario_modifica, fecha_modifica, cod_estado_registro";
	$sql2.=" from clientes_contactos";
	$sql2.=" where cod_cliente=".$codcliente;
	$sql2.=" order by ap_paterno_contacto,ap_materno_contacto,nombre_contacto";
	$resp2=mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2)){
		$cod_contacto=$dat2['cod_contacto'];
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
            <td><a href="editContactoCliente.php?cod_contacto=<?php echo $cod_contacto;?>">Editar</a></td> 
            <td><a href="listEliminarContactoCliente.php?cod_contacto=<?php echo $cod_contacto;?>">Eliminar</a></td>       
        </tr>
    <?php
			
	
	}
?>

</table>
			
<?php }?>
<br/>
<div align="center">
<INPUT type="submit" class="boton" name="btn_registrar"  value="NUEVO CONTACTO" >
<INPUT type="button" class="boton" name="btn_eliminar"  value="IR A LISTADO DE CLIENTES" onClick="cancelar(this.form);">
</div>
</form>
</body>
</html>
