<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Eliminar Banco</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function eliminar(f){
		f.submit();
	}
	
	function cancelar(f){
					window.location="navegadorTiposCotizacion.php";
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<form name="form1" method="post" action="eliminarTiposCotizacion.php">
<?php 

	require("conexion.inc");
	include("funciones.php");	
	$datos=$_GET["datos"];	
	
?>
<input type="hidden" name="datos" value="<?php echo $datos; ?>">
	<h3 align="center" style="background:white;font-size: 14px;color: #E78611;font-weight:bold;">Confirmacion de Eliminacion de Bancos </h3>


    <?php

		$datosEliminar="";
		$datosNoEliminar="";
		$vector_datos=explode(",",$datos);	
		$n=sizeof($vector_datos);
		for($i=0;$i<$n;$i++){	
		
				$cod_tipo_cotizacion=$vector_datos[$i];
				
				$sw=0;			
				$sql=" select  *  from cotizaciones  where cod_tipo_cotizacion='".$cod_tipo_cotizacion."'";			
				$resp= mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){
					$sw=1;
				}
				

				if($sw==0){
					/****************************/
						if($datosEliminar<>""){
							$datosEliminar=$datosEliminar.",".$cod_tipo_cotizacion;
						}else{
							$datosEliminar=$cod_tipo_cotizacion;
						}
					/****************************/
				}else{
					/***************************/
						if($datosNoEliminar<>""){
								$datosNoEliminar=$datosNoEliminar.",".$cod_tipo_cotizacion;
						}else{
							$datosNoEliminar=$cod_tipo_cotizacion;
						}
					/**************************/		
				}
									
		}
						
?>
<?php if($datosNoEliminar<>""){?>
<h3 align="center" style="background:white;font-size: 11px;color:#E78611;">Registros que no pueden ser Elimandos</h3>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	   	<tr height="20px" align="center"  class="titulo_tabla">
    		<td>Banco</td>			
    		<td>Estado</td>			
    		<td>Registro</td>
			<td>Ultima Edici&oacute;n</td>					
		</tr>
		<?php
			$vectordatosNoEliminar=explode(",",$datosNoEliminar);	
			$num=sizeof($vectordatosNoEliminar);
			for($j=0;$j<$num;$j++){	
				$cod_tipo_cotizacion=$vectordatosNoEliminar[$j];
				
				$sql=" select nombre_tipo_cotizacion, obs_tipo_cotizacion, cod_estado_registro, ";
				$sql.=" cod_usuario_registro, fecha_registro, cod_usuario_modifica, fecha_modifica ";
				$sql.=" from tipos_cotizacion ";
				$sql.=" where cod_tipo_cotizacion=".$cod_tipo_cotizacion;	
				$resp = mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){	
		
						$nombre_tipo_cotizacion=$dat[0];
						$obs_tipo_cotizacion=$dat[1];
						$codestadoregistro=$dat[2];
						$cod_usuario_registro=$dat[3];
						$fecha_registro=$dat[4];				
						$cod_usuario_modifica=$dat[5];
						$fecha_modifica=$dat[6];
						

						if($fecha_registro<>""){
						$fechaRegistroVector=explode(" ",$fecha_registro);
						$fechaRegistroVector2=explode("-",$fechaRegistroVector[0]);
						$fechaRegistroFormato=$fechaRegistroVector2[2]."/".$fechaRegistroVector2[1]."/".$fechaRegistroVector2[0]." ".$fechaRegistroVector[1];
						}				

						$fechaModificaFormato="";
						if($fecha_modifica<>""){
							$fechaModificaVector=explode(" ",$fecha_modifica);
							$fechaModificaVector2=explode("-",$fechaModificaVector[0]);
							$fechaModificaFormato=$fechaModificaVector2[2]."/".$fechaModificaVector2[1]."/".$fechaModificaVector2[0]." ".$fechaModificaVector[1];
						}					

				//**************************************************************
					$nombre_estado_registro="";				
					$sql2="select nombre_estado_registro from estados_referenciales";
					$sql2.=" where cod_estado_registro='".$cod_estado_registro."'";	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_estado_registro=$dat2[0];
					}	
				//**************************************************************	
				//******************************USUARIO REGISTRO********************************
					$usuarioRegistro="";				
					$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios";
					$sql2.=" where cod_usuario='".$cod_usuario_registro."'";	
					$resp2= mysql_query($sql2);
					$dat2=mysql_fetch_array($resp2);
					$usuarioRegistro=substr($dat2[0],0).substr($dat2[1],0).substr($dat2[2],0);
				//*******************************FIN USUARIO REGISTRO*******************************									
				
				//******************************USUARIO MODIFICA********************************
					$usuarioModifica="";				
					$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios";
					$sql2.=" where cod_usuario='".$cod_usuario_modifica."'";	
					$resp2= mysql_query($sql2);
					$dat2=mysql_fetch_array($resp2);
					$usuarioModifica=substr($dat2[0],0).substr($dat2[1],0).substr($dat2[2],0);
				//*******************************FIN USUARIO MODIFICA*******************************										
				
	
				}
					
				
	
		?>		
			<tr bgcolor="#FFFFFF">
    		<td><?php echo $nombre_tipo_cotizacion;?></td>
    		<td><?php echo $obs_tipo_cotizacion;?></td>
    		<td><?php echo $nombre_estado_registro; ?></td>
			<td><?php echo $usuarioRegistro." ".$fechaRegistroFormato;?></td>
    		<td><?php echo $usuarioModifica." ".$fechaModificaFormato;?></td>
	    	 </tr>
		<?php
			}
		?>
	 </table>
<?php }?>
<br>

<?php if($datosEliminar<>""){?>
<h3 align="center" style="background:white;font-size: 11px;color:#E78611;">Registros que pueden ser Elimandos</h3>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	   	<tr height="20px" align="center"  class="titulo_tabla">
    		<td>Tipo de Cotizaci&oacute;n</td>
			<td>Obsservaciones</td>				
    		<td>Estado</td>			
    		<td>Registro</td>
			<td>Ultima Edici&oacute;n</td>		
		</tr>
		<?php
			$vectordatosEliminar=explode(",",$datosEliminar);	
			$num=sizeof($vectordatosEliminar);
			for($j=0;$j<$num;$j++){	
				$cod_tipo_cotizacion=$vectordatosEliminar[$j];
					
				$sql=" select nombre_tipo_cotizacion, obs_tipo_cotizacion, cod_estado_registro, ";
				$sql.=" cod_usuario_registro, fecha_registro, cod_usuario_modifica, fecha_modifica ";
				$sql.=" from tipos_cotizacion ";
				$sql.=" where cod_tipo_cotizacion=".$cod_tipo_cotizacion;	
				$resp = mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){	
		
						$nombre_tipo_cotizacion=$dat[0];
						$obs_tipo_cotizacion=$dat[1];
						$codestadoregistro=$dat[2];
						$cod_usuario_registro=$dat[3];
						$fecha_registro=$dat[4];				
						$cod_usuario_modifica=$dat[5];
						$fecha_modifica=$dat[6];
						

						if($fecha_registro<>""){
						$fechaRegistroVector=explode(" ",$fecha_registro);
						$fechaRegistroVector2=explode("-",$fechaRegistroVector[0]);
						$fechaRegistroFormato=$fechaRegistroVector2[2]."/".$fechaRegistroVector2[1]."/".$fechaRegistroVector2[0]." ".$fechaRegistroVector[1];
						}				

						$fechaModificaFormato="";
						if($fecha_modifica<>""){
							$fechaModificaVector=explode(" ",$fecha_modifica);
							$fechaModificaVector2=explode("-",$fechaModificaVector[0]);
							$fechaModificaFormato=$fechaModificaVector2[2]."/".$fechaModificaVector2[1]."/".$fechaModificaVector2[0]." ".$fechaModificaVector[1];
						}					

				//**************************************************************
					$nombre_estado_registro="";				
					$sql2="select nombre_estado_registro from estados_referenciales";
					$sql2.=" where cod_estado_registro='".$cod_estado_registro."'";	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_estado_registro=$dat2[0];
					}	
				//**************************************************************	
				//******************************USUARIO REGISTRO********************************
					$usuarioRegistro="";				
					$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios";
					$sql2.=" where cod_usuario='".$cod_usuario_registro."'";	
					$resp2= mysql_query($sql2);
					$dat2=mysql_fetch_array($resp2);
					$usuarioRegistro=substr($dat2[0],0).substr($dat2[1],0).substr($dat2[2],0);
				//*******************************FIN USUARIO REGISTRO*******************************									
				
				//******************************USUARIO MODIFICA********************************
					$usuarioModifica="";				
					$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios";
					$sql2.=" where cod_usuario='".$cod_usuario_modifica."'";	
					$resp2= mysql_query($sql2);
					$dat2=mysql_fetch_array($resp2);
					$usuarioModifica=substr($dat2[0],0).substr($dat2[1],0).substr($dat2[2],0);
				//*******************************FIN USUARIO MODIFICA*******************************										
				
	
				}					
				

		?>
		<tr bgcolor="#FFFFFF">		
    		<td><?php echo $nombre_tipo_cotizacion;?></td>
    		<td><?php echo $obs_tipo_cotizacion;?></td>
    		<td><?php echo $nombre_estado_registro; ?></td>
			<td><?php echo $usuarioRegistro." ".$fechaRegistroFormato;?></td>
    		<td><?php echo $usuarioModifica." ".$fechaModificaFormato;?></td>
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
