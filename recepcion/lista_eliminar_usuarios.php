<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Eliminación de Usuarios</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function eliminar(f){
		f.submit();
	}
	
	function cancelar(f){
					window.location="navegador_usuarios.php";
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<form name="form1" method="post" action="eliminar_usuarios.php">
<?php 

	require("conexion.inc");
	include("funciones.php");	
	$datos=$_GET["datos"];	
	
?>
<input type="hidden" name="datos" value="<?php echo $datos; ?>">
	<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">Eliminaci&oacute;n de Usuarios</h3>


    <?php

		$datosEliminar="";
		$datosNoEliminar="";
		$vector_datos=explode(",",$datos);	
		$n=sizeof($vector_datos);
		for($i=0;$i<$n;$i++){	
		
				$cod_usuario=$vector_datos[$i];
				$sw=0;	
						
				$sql=" select  *  from certificados_producto  where cod_usuario_registro='".$cod_usuario."'";			
				$resp= mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){
					$sw=1;
				}
				
				$sql=" select  *  from certificados_producto  where cod_usuario_modifica='".$cod_usuario."'";			
				$resp= mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){
					$sw=1;
				}

				$sql=" select  *  from certificados_producto  where cod_usuario_firma='".$cod_usuario."'";			
				$resp= mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){
					$sw=1;
				}
				
				$sql=" select  *  from fichas_producto  where cod_usuario_modifica='".$cod_usuario."'";			
				$resp= mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){
					$sw=1;
				}
				$sql=" select  *  from fichas_producto  where cod_usuario_aprobacion='".$cod_usuario."'";			
				$resp= mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){
					$sw=1;
				}				

				if($sw==0){
					/****************************/
						if($datosEliminar<>""){
							$datosEliminar=$datosEliminar.",".$cod_usuario;
						}else{
							$datosEliminar=$cod_usuario;
						}
					/****************************/
				}else{
					/***************************/
						if($datosNoEliminar<>""){
							$datosNoEliminar=$datosNoEliminar.",".$cod_usuario;
						}else{
							$datosNoEliminar=$cod_usuario;
						}
					/**************************/		
				}
									
		}
						
?>
<?php if($datosNoEliminar<>""){?>
<h3 align="center" style="background:white;font-size: 12px;color:#d20000;font-weight:bold;">Registros que no pueden ser Elimandos</h3>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
			<td>Nombre</td>
			<td>Cargo</td>							
			<td>Grado</td>		
			<td>Usuario/Contraseña</td>																		
			<td>Estado de Registro</td>			
		</tr>
		<?php
			$vectordatosNoEliminar=explode(",",$datosNoEliminar);	
			$num=sizeof($vectordatosNoEliminar);
			for($j=0;$j<$num;$j++){	
				$cod_usuario=$vectordatosNoEliminar[$j];
				$sql=" select nombre_usuario, ap_paterno_usuario, ap_materno_usuario, usuario, password, cod_cargo, cod_grado,cod_estado_registro";
				$sql.=" from usuarios where cod_usuario='".$cod_usuario."'";
				$resp= mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){
					$nombre_usuario=$dat[0];
					$ap_paterno_usuario=$dat[1];
					$ap_materno_usuario=$dat[2];
					$usuario=$dat[3];
					$password=$dat[4];
					$cod_cargo=$dat[5];
					/**************************************************************************/
						$sql2=" select nombre_cargo from cargos where cod_cargo='".$cod_cargo."'";
	    				$resp2 = mysql_query($sql2);	
						$nombre_cargo="";
						$dat2=mysql_fetch_array($resp2);
						$nombre_cargo=$dat2[0];					
					/**************************************************************************/				
					$cod_grado=$dat[6];
					/**************************************************************************/
						$sql2=" select nombre_grado from grados where cod_grado='".$cod_grado."'";
	    				$resp2 = mysql_query($sql2);	
						$nombre_grado="";
						$dat2=mysql_fetch_array($resp2);
						$nombre_grado=$dat2[0];					
					/**************************************************************************/						
					$cod_estado_registro=$dat[7];
					/**************************************************************************/
						$sql2=" select nombre_estado_registro from estados_referenciales where cod_estado_registro='".$cod_estado_registro."'";
	    				$resp2 = mysql_query($sql2);	
						$nombre_estado_registro="";
						$dat2=mysql_fetch_array($resp2);
						$nombre_estado_registro=$dat2[0];					
					/**************************************************************************/														
				}
	
		?>		
			<tr bgcolor="#FFFFFF">
				<td><?php echo $ap_paterno_usuario." ".$ap_materno_usuario." ".$nombre_usuario;?></td>
				<td><?php echo $nombre_cargo;?></td>							
				<td><?php echo $nombre_grado; ?></td>		
				<td>Usuario:<?php echo $usuario;?><br>Contraseña:<?php echo $password;?></td>																		
				<td><?php echo $nombre_estado_registro;?></td>	
	    	 </tr>
		<?php
			}
		?>
	 </table>
<?php }?>
<br>

<?php if($datosEliminar<>""){?>
<h3 align="center" style="background:white;font-size: 12px;color:#d20000;font-weight:bold;">Registros que pueden ser Elimandos</h3>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	   	<tr height="20px" align="center"  class="titulo_tabla">
			<td>Nombre</td>
			<td>Cargo</td>							
			<td>Grado</td>		
			<td>Usuario/Contraseña</td>																		
			<td>Estado de Registro</td>				
		</tr>
		<?php
			$vectordatosEliminar=explode(",",$datosEliminar);	
			$num=sizeof($vectordatosEliminar);
			for($j=0;$j<$num;$j++){	
				$cod_usuario=$vectordatosEliminar[$j];
				$sql=" select nombre_usuario, ap_paterno_usuario, ap_materno_usuario, usuario, password, cod_cargo, cod_grado,cod_estado_registro";
				$sql.=" from usuarios where cod_usuario='".$cod_usuario."'";
				$resp= mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){
					$nombre_usuario=$dat[0];
					$ap_paterno_usuario=$dat[1];
					$ap_materno_usuario=$dat[2];
					$usuario=$dat[3];
					$password=$dat[4];
					$cod_cargo=$dat[5];
					/**************************************************************************/
						$sql2=" select nombre_cargo from cargos where cod_cargo='".$cod_cargo."'";
	    				$resp2 = mysql_query($sql2);	
						$nombre_cargo="";
						$dat2=mysql_fetch_array($resp2);
						$nombre_cargo=$dat2[0];					
					/**************************************************************************/				
					$cod_grado=$dat[6];
					/**************************************************************************/
						$sql2=" select nombre_grado from grados where cod_grado='".$cod_grado."'";
	    				$resp2 = mysql_query($sql2);	
						$nombre_grado="";
						$dat2=mysql_fetch_array($resp2);
						$nombre_grado=$dat2[0];					
					/**************************************************************************/						
					$cod_estado_registro=$dat[7];
					/**************************************************************************/
						$sql2=" select nombre_estado_registro from estados_referenciales where cod_estado_registro='".$cod_estado_registro."'";
	    				$resp2 = mysql_query($sql2);	
						$nombre_estado_registro="";
						$dat2=mysql_fetch_array($resp2);
						$nombre_estado_registro=$dat2[0];					
					/**************************************************************************/														
				}
		?>		
			<tr bgcolor="#FFFFFF">
				<td><?php echo $ap_paterno_usuario." ".$ap_materno_usuario." ".$nombre_usuario;?></td>
				<td><?php echo $nombre_cargo;?></td>							
				<td><?php echo $nombre_grado; ?></td>		
				<td>Usuario:<?php echo $usuario;?><br>Contraseña:<?php echo $password;?></td>																		
				<td><?php echo $nombre_estado_registro;?></td>	
	    	 </tr>
		<?php
			}
		?>
	 </table>
<?php }?>
</div>			

<br>
<input type="hidden" name="datosEliminar" value="<?php echo $datosEliminar;?>">
<div align="center">

<INPUT type="button" class="boton" name="btn_eliminar"  value="Confirmar Eliminación" onClick="eliminar(this.form);">
<INPUT type="button" class="boton" name="btn_eliminar"  value="Cancelar" onClick="cancelar(this.form);">

</div>
		
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
