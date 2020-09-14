<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Eliminación de Certificados</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function eliminar(f){
		f.submit();
	}
	
	function cancelar(f){
					window.location="listaCertificadosEmpresas.php?cod_empresa="+f.cod_empresa.value;
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<form name="form1" method="post" action="eliminar_certificados.php">
<?php 

	require("conexion.inc");
	include("funciones.php");	
	$datos=$_GET["datos"];	
	$cod_empresa=$_GET["cod_empresa"];			
	$sql=" select  rotulo_comercial from empresas  where cod_empresa='".$cod_empresa."'";
	$resp=mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$rotulo_comercial=$dat[0];
	}		
	
?>
<input type="hidden" name="datos" value="<?php echo $datos; ?>">
<input type="hidden" name="cod_empresa" value="<?php echo $cod_empresa; ?>">
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">Eliminaci&oacute;n de Cetificados de Productos de <?php echo $rotulo_comercial;?>  </h3>


    <?php

		$datosEliminar="";
		$datosNoEliminar="";
		$vector_datos=explode(",",$datos);	
		$n=sizeof($vector_datos);
		for($i=0;$i<$n;$i++){	
		
				$cod_cert_prod=$vector_datos[$i];
				$sw=0;			
				$sql=" select  *  from certificados_producto  where cod_cert_prod='".$cod_cert_prod."' and cod_estado_certificado=2";			
				$resp= mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){
					$sw=1;
				}
				

				if($sw==0){
					/****************************/
						if($datosEliminar<>""){
							$datosEliminar=$datosEliminar.",".$cod_cert_prod;
						}else{
							$datosEliminar=$cod_cert_prod;
						}
					/****************************/
				}else{
					/***************************/
						if($datosNoEliminar<>""){
							$datosNoEliminar=$datosNoEliminar.",".$cod_cert_prod;
						}else{
							$datosNoEliminar=$cod_cert_prod;
						}
					/**************************/		
				}
									
		}
						
?>
<?php if($datosNoEliminar<>""){?>
<h3 align="center" style="background:white;font-size: 12px;color:#d20000;font-weight:bold;">Registros que no pueden ser Elimandos</h3>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	   	<tr height="20px" align="center"  class="titulo_tabla">
			<td>Nro de Cert.</td>							
			<td>Producto </td>
			<td>Marca</td>	
			<td>Fichas Tecnicas</td>				
			<td>Ciudad de Emisión</td>												
			<td>Fecha Emisión</td>		
			<td>Fecha de Registro</td>					
			<td>Fecha de Ultima Edición</td>								
			<td>Estado</td>				
		</tr>
		<?php
			$vectordatosNoEliminar=explode(",",$datosNoEliminar);	
			$num=sizeof($vectordatosNoEliminar);
			for($j=0;$j<$num;$j++){	
				$cod_cert_prod=$vectordatosNoEliminar[$j];
				
				$sql=" select cod_producto, modelo_certificacion, cia_productora, cia_productora_bolivia, fecha_emision, ";
				$sql.=" cod_usuario_firma, cod_usuario_registro, fecha_usuario_registro, cod_usuario_modifica, fecha_usuario_modifica, ";
				$sql.=" cod_estado_certificado, cod_ciudad";
				$sql.=" from certificados_producto ";
				$sql.=" where cod_cert_prod='".$cod_cert_prod."'";
				$resp= mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){

					$cod_producto=$dat[0];
						$sql2="select nombre_producto, cod_marca from productos where cod_producto='".$cod_producto."'";
						$resp2 = mysql_query($sql2);
						$nombre_marca="";
						$dat2=mysql_fetch_array($resp2);
						$nombre_producto=$dat2[0];
						$cod_marca=$dat2[1];
					/*------------------------------*/
						$sql5=" select nombre_marca from marcas where cod_marca='".$cod_marca."'";
						$resp5= mysql_query($sql5);
						$dat5=mysql_fetch_array($resp5);				
						$nombre_marca=$dat5[0];					
					/*------------------------------*/										
			
				$modelo_certificacion=$dat[1]; 
				$cia_productora=$dat[2];
				$cia_productora_bolivia=$dat[3]; 			
				$fecha_emision=$dat[4];
					if($fecha_emision<>""){
						$vector2=explode("-",$fecha_emision);				
						$fecha_emision=$vector2[2]."/".$vector2[1]."/".$vector2[0];
					}
							
				$cod_usuario_firma=$dat[5];
				/******************************/
						$nombre_usuario_firma="";
						$ap_paterno_usuario_firma="";
						$ap_materno_usuario_firma="";
					 	$cod_grado=0;
						$cod_cargo=0; 
						$sql4=" select nombre_usuario, ap_paterno_usuario, ap_materno_usuario, cod_grado, cod_cargo ";
						$sql4.=" from usuarios where cod_usuario='".$cod_usuario_firma."'";
						$resp4= mysql_query($sql4);
						$dat4=mysql_fetch_array($resp4);				
						$nombre_usuario_firma=$dat4[0];
						$ap_paterno_usuario_firma=$dat4[1];
						$ap_materno_usuario_firma=$dat4[2];	
					 	$cod_grado=$dat4[3];
						/*------------------------------*/
							$sql5=" select abrev_grado from grados where cod_grado='".$cod_grado."'";
							$resp5= mysql_query($sql5);
							$dat5=mysql_fetch_array($resp5);				
							$abrev_grado=$dat5[0];					
						/*------------------------------*/
						$cod_cargo=$dat4[4];
						/*------------------------------*/
							$sql5=" select nombre_cargo from cargos where cod_cargo='".$cod_cargo."'";
							$resp5= mysql_query($sql5);
							$dat5=mysql_fetch_array($resp5);				
							$nombre_cargo=$dat5[0];					
						/*------------------------------*/					
											
				/*********************************/
				
				$cod_usuario_registro=$dat[6];
					/******************************/
					$nombre_usuario_registro="";
					$ap_paterno_usuario_registro="";
					$ap_materno_usuario_registro="";
					$sql4=" select nombre_usuario, ap_paterno_usuario, ap_materno_usuario, cod_grado, cod_cargo";
					$sql4.=" from usuarios where cod_usuario='".$cod_usuario_registro."'";
					$resp4= mysql_query($sql4);
					$dat4=mysql_fetch_array($resp4);				
							$nombre_usuario_registro=$dat4[0];
							$ap_paterno_usuario_registro=$dat4[1];
							$ap_materno_usuario_registro=$dat4[2];							
					/*********************************/
						
				$fecha_usuario_registro=$dat[7];
				if($fecha_usuario_registro<>""){
					$vector=explode(" ",$fecha_usuario_registro);
					$vector2=explode("-",$vector[0]);				
					$fecha_usuario_registro=$vector2[2]."/".$vector2[1]."/".$vector2[0]." ".$vector[1];
				}
						
				$cod_usuario_modifica=$dat[8];
					/******************************/
					$nombre_usuario_modifica="";
					$ap_paterno_usuario_modifica="";
					$ap_materno_usuario_modifica="";
					$sql4=" select nombre_usuario, ap_paterno_usuario, ap_materno_usuario, cod_grado, cod_cargo ";
					$sql4.=" from usuarios where cod_usuario='".$cod_usuario_modifica."'";
					$resp4= mysql_query($sql4);
					$dat4=mysql_fetch_array($resp4);				
						$nombre_usuario_modifica=$dat4[0];
						$ap_paterno_usuario_modifica=$dat4[1];
						$ap_materno_usuario_modifica=$dat4[2];							
				/*********************************/
						
				$fecha_usuario_modifica=$dat[9];
					if($fecha_usuario_modifica<>""){
						$vector=explode(" ",$fecha_usuario_modifica);
						$vector2=explode("-",$vector[0]);				
						$fecha_usuario_modifica=$vector2[2]."/".$vector2[1]."/".$vector2[0]." ".$vector[1];
					}
						
				$cod_estado_certificado=$dat[10];
					$sql4=" select nombre_estado_certificado  from estados_certificados where cod_estado_certificado='".$cod_estado_certificado."'";
					$resp4= mysql_query($sql4);
					$dat4=mysql_fetch_array($resp4);				
						$nombre_estado_certificado=$dat4[0];
				
				$cod_ciudad=$dat[11];
					$sql4=" select nombre_ciudad  from ciudades where cod_ciudad='".$cod_ciudad."'";
					$resp4= mysql_query($sql4);
					$dat4=mysql_fetch_array($resp4);				
					$nombre_ciudad=$dat4[0];
								
				}
	
		?>		
			<tr bgcolor="#FFFFFF">
				<td><?php echo $cod_cert_prod;?></td>							
					<td><?php echo $nombre_producto; ?></td>
					<td><?php echo $nombre_marca;?></td>				
					<td><ul>
					<?php
						/****************Fichas Tecnicas***********************/
						$sql4=" select cod_ficha, sku, presentacion ";
						$sql4.=" from fichas_producto ";
						$sql4.=" where cod_ficha in(select cod_ficha from certificados_producto where cod_cert_prod='".$cod_cert_prod."')";
						$resp4= mysql_query($sql4);
						while($dat4=mysql_fetch_array($resp4)){				
							$cod_ficha=$dat4[0];
							$sku=$dat4[1];
						$presentacion=$dat4[2];
					?>
<li><a href="../reportes/fichaProducto.php?cod_ficha=<?php echo $cod_ficha;?>"  target="_blank">Nro:<?php echo $cod_ficha." ".$presentacion." (".$sku.")"; ?></a></li>
				<?php					
						}			
				?>
					</ul>
				</td>				
				<td><?php echo $nombre_ciudad;?></td>					
				<td>
					<?php echo $fecha_emision;?><br>
					<?php echo $abrev_grado." ".$nombre_usuario_firma." ".$ap_paterno_usuario_firma." ".$ap_materno_usuario_firma;?><br>
					<?php echo $nombre_cargo;?>
				</td>		
				<td>
					<?php echo $fecha_usuario_registro;?><br>
					<?php echo $nombre_usuario_registro." ".$ap_paterno_usuario_registro." ".$ap_materno_usuario_registro;?><br>
				</td>					
				<td>
					<?php echo $fecha_usuario_modifica;?><br>
					<?php echo $nombre_usuario_modifica." ".$ap_paterno_usuario_modifica." ".$ap_materno_usuario_modifica;?><br>
				</td>							
				<td><?php echo $nombre_estado_certificado; ?></td>		
				
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
			<td>Nro de Cert.</td>							
			<td>Producto </td>
			<td>Marca</td>	
			<td>Fichas Tecnicas</td>				
			<td>Ciudad de Emisión</td>												
			<td>Fecha Emisión</td>		
			<td>Fecha de Registro</td>					
			<td>Fecha de Ultima Edición</td>								
			<td>Estado</td>			
		</tr>
		<?php
			$vectordatosEliminar=explode(",",$datosEliminar);	
			$num=sizeof($vectordatosEliminar);
			for($j=0;$j<$num;$j++){	
				$cod_cert_prod=$vectordatosEliminar[$j];
				
				$sql=" select cod_producto, modelo_certificacion, cia_productora, cia_productora_bolivia, fecha_emision, ";
				$sql.=" cod_usuario_firma, cod_usuario_registro, fecha_usuario_registro, cod_usuario_modifica, fecha_usuario_modifica, ";
				$sql.=" cod_estado_certificado, cod_ciudad";
				$sql.=" from certificados_producto ";
				$sql.=" where cod_cert_prod='".$cod_cert_prod."'";
				$resp= mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){

					$cod_producto=$dat[0];
						$sql2="select nombre_producto, cod_marca from productos where cod_producto='".$cod_producto."'";
						$resp2 = mysql_query($sql2);
						$nombre_marca="";
						$dat2=mysql_fetch_array($resp2);
						$nombre_producto=$dat2[0];
						$cod_marca=$dat2[1];
					/*------------------------------*/
						$sql5=" select nombre_marca from marcas where cod_marca='".$cod_marca."'";
						$resp5= mysql_query($sql5);
						$dat5=mysql_fetch_array($resp5);				
						$nombre_marca=$dat5[0];					
					/*------------------------------*/										
			
				$modelo_certificacion=$dat[1]; 
				$cia_productora=$dat[2];
				$cia_productora_bolivia=$dat[3]; 			
				$fecha_emision=$dat[4];
					if($fecha_emision<>""){
						$vector2=explode("-",$fecha_emision);				
						$fecha_emision=$vector2[2]."/".$vector2[1]."/".$vector2[0];
					}
							
				$cod_usuario_firma=$dat[5];
				/******************************/
						$nombre_usuario_firma="";
						$ap_paterno_usuario_firma="";
						$ap_materno_usuario_firma="";
					 	$cod_grado=0;
						$cod_cargo=0; 
						$sql4=" select nombre_usuario, ap_paterno_usuario, ap_materno_usuario, cod_grado, cod_cargo ";
						$sql4.=" from usuarios where cod_usuario='".$cod_usuario_firma."'";
						$resp4= mysql_query($sql4);
						$dat4=mysql_fetch_array($resp4);				
						$nombre_usuario_firma=$dat4[0];
						$ap_paterno_usuario_firma=$dat4[1];
						$ap_materno_usuario_firma=$dat4[2];	
					 	$cod_grado=$dat4[3];
						/*------------------------------*/
							$sql5=" select abrev_grado from grados where cod_grado='".$cod_grado."'";
							$resp5= mysql_query($sql5);
							$dat5=mysql_fetch_array($resp5);				
							$abrev_grado=$dat5[0];					
						/*------------------------------*/
						$cod_cargo=$dat4[4];
						/*------------------------------*/
							$sql5=" select nombre_cargo from cargos where cod_cargo='".$cod_cargo."'";
							$resp5= mysql_query($sql5);
							$dat5=mysql_fetch_array($resp5);				
							$nombre_cargo=$dat5[0];					
						/*------------------------------*/					
											
				/*********************************/
				
				$cod_usuario_registro=$dat[6];
					/******************************/
					$nombre_usuario_registro="";
					$ap_paterno_usuario_registro="";
					$ap_materno_usuario_registro="";
					$sql4=" select nombre_usuario, ap_paterno_usuario, ap_materno_usuario, cod_grado, cod_cargo";
					$sql4.=" from usuarios where cod_usuario='".$cod_usuario_registro."'";
					$resp4= mysql_query($sql4);
					$dat4=mysql_fetch_array($resp4);				
							$nombre_usuario_registro=$dat4[0];
							$ap_paterno_usuario_registro=$dat4[1];
							$ap_materno_usuario_registro=$dat4[2];							
					/*********************************/
						
				$fecha_usuario_registro=$dat[7];
				if($fecha_usuario_registro<>""){
					$vector=explode(" ",$fecha_usuario_registro);
					$vector2=explode("-",$vector[0]);				
					$fecha_usuario_registro=$vector2[2]."/".$vector2[1]."/".$vector2[0]." ".$vector[1];
				}
						
				$cod_usuario_modifica=$dat[8];
					/******************************/
					$nombre_usuario_modifica="";
					$ap_paterno_usuario_modifica="";
					$ap_materno_usuario_modifica="";
					$sql4=" select nombre_usuario, ap_paterno_usuario, ap_materno_usuario, cod_grado, cod_cargo ";
					$sql4.=" from usuarios where cod_usuario='".$cod_usuario_modifica."'";
					$resp4= mysql_query($sql4);
					$dat4=mysql_fetch_array($resp4);				
						$nombre_usuario_modifica=$dat4[0];
						$ap_paterno_usuario_modifica=$dat4[1];
						$ap_materno_usuario_modifica=$dat4[2];							
				/*********************************/
						
				$fecha_usuario_modifica=$dat[9];
					if($fecha_usuario_modifica<>""){
						$vector=explode(" ",$fecha_usuario_modifica);
						$vector2=explode("-",$vector[0]);				
						$fecha_usuario_modifica=$vector2[2]."/".$vector2[1]."/".$vector2[0]." ".$vector[1];
					}
						
				$cod_estado_certificado=$dat[10];
					$sql4=" select nombre_estado_certificado  from estados_certificados where cod_estado_certificado='".$cod_estado_certificado."'";
					$resp4= mysql_query($sql4);
					$dat4=mysql_fetch_array($resp4);				
						$nombre_estado_certificado=$dat4[0];
				
				$cod_ciudad=$dat[11];
					$sql4=" select nombre_ciudad  from ciudades where cod_ciudad='".$cod_ciudad."'";
					$resp4= mysql_query($sql4);
					$dat4=mysql_fetch_array($resp4);				
					$nombre_ciudad=$dat4[0];
								
				}
				

		?>		
			<tr bgcolor="#FFFFFF">
				<td><?php echo $cod_cert_prod;?></td>							
					<td><?php echo $nombre_producto; ?></td>
					<td><?php echo $nombre_marca;?></td>				
					<td><ul>
					<?php
						/****************Fichas Tecnicas***********************/
						$sql4=" select cod_ficha, sku, presentacion ";
						$sql4.=" from fichas_producto ";
						$sql4.=" where cod_ficha in(select cod_ficha from certificados_producto where cod_cert_prod='".$cod_cert_prod."')";
						$resp4= mysql_query($sql4);
						while($dat4=mysql_fetch_array($resp4)){				
							$cod_ficha=$dat4[0];
							$sku=$dat4[1];
						$presentacion=$dat4[2];
					?>
<li><a href="../reportes/fichaProducto.php?cod_ficha=<?php echo $cod_ficha;?>"  target="_blank">Nro:<?php echo $cod_ficha." ".$presentacion." (".$sku.")"; ?></a></li>
				<?php					
						}			
				?>
					</ul>
				</td>				
				<td><?php echo $nombre_ciudad;?></td>					
				<td>
					<?php echo $fecha_emision;?><br>
					<?php echo $abrev_grado." ".$nombre_usuario_firma." ".$ap_paterno_usuario_firma." ".$ap_materno_usuario_firma;?><br>
					<?php echo $nombre_cargo;?>
				</td>		
				<td>
					<?php echo $fecha_usuario_registro;?><br>
					<?php echo $nombre_usuario_registro." ".$ap_paterno_usuario_registro." ".$ap_materno_usuario_registro;?><br>
				</td>					
				<td>
					<?php echo $fecha_usuario_modifica;?><br>
					<?php echo $nombre_usuario_modifica." ".$ap_paterno_usuario_modifica." ".$ap_materno_usuario_modifica;?><br>
				</td>							
				<td><?php echo $nombre_estado_certificado; ?></td>	
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
