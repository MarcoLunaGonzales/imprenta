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
		window.location="listContactosProveedor.php?cod_proveedor="+f.cod_proveedor.value;
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<form name="form1" method="post" action="eliminarContactoProveedor.php">
<?php 

	require("conexion.inc");
	include("funciones.php");	
	$cod_contacto_proveedor=$_GET["cod_contacto_proveedor"];	
	
	$sql2="select nombre_proveedor from proveedores where cod_proveedor in( select cod_proveedor from proveedores_contactos where cod_contacto_proveedor=".$_GET["cod_contacto_proveedor"].")";
	$resp2= mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2)){
		$nombre_proveedor=$dat2[0];
	}
	
?>

	<h3 align="center" style="background:white;font-size: 14px;color: #E78611;font-weight:bold;">Eliminacion de Contactos de <?php echo $nombre_proveedor;?></h3>

    <?php


				$sw=0;			
				$sql=" select  count(*)  from ingresos  where cod_contacto_proveedor='".$_GET["cod_contacto_proveedor"]."'";			
				$resp= mysql_query($sql);
				$nroIngresos=0;
				while($dat=mysql_fetch_array($resp)){
					$nroCotizaciones=$dat[0];
					if($nroCotizaciones>0){
						$sw=1;
					}
				}
				
				$sql=" select  count(*)  from gastos_ordentrabajo  where cod_contacto_proveedor='".$_GET["cod_contacto_proveedor"]."'";			
				$resp= mysql_query($sql);
				$nroOT=0;
				while($dat=mysql_fetch_array($resp)){
					$nroOT=$dat[0];
					if($nroOT>0){
						$sw=1;
					}
				}

				$sql=" select  count(*)  from gastos_hojasrutas  where cod_contacto_proveedor='".$_GET["cod_contacto_proveedor"]."'";			
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
	<h3 align="center" style="background:white;font-size: 11px;color:#E78611;">EL CONTACTO NO PUEDE SER ELIMINADO</h3>
<?php
	}else{
?>
<h3 align="center" style="background:white;font-size: 11px;color:#E78611;">EL CONTACTO  PUEDE SER ELIMINADO</h3>
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

		$sql2=" select  cod_proveedor,nombre_contacto, ap_paterno_contacto,";
		$sql2.=" ap_materno_contacto, telefono_contacto, celular_contacto,";
		$sql2.=" email_contacto, cargo_contacto, cod_usuario_registro, ";
		$sql2.=" fecha_registro, cod_usuario_modifica, fecha_modifica, cod_estado_registro";
		$sql2.=" from proveedores_contactos";
		$sql2.=" where cod_contacto_proveedor=".$_GET['cod_contacto_proveedor'];
		$sql2.=" order by ap_paterno_contacto,ap_materno_contacto,nombre_contacto";
		$resp2=mysql_query($sql2);
		while($dat2=mysql_fetch_array($resp2)){

			$cod_proveedor=$dat2['cod_proveedor'];
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

<input type="hidden" name="cod_proveedor" id="cod_proveedor" value="<?php echo $cod_proveedor;?>">
<input type="hidden" name="cod_contacto_proveedor" id="cod_contacto_proveedor" value="<?php echo $_GET['cod_contacto_proveedor'];?>">
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
