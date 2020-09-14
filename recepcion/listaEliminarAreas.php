<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>INVENTA</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function eliminar(f){
		f.submit();
	}
	
	function cancelar(f){
					window.location="listAreas.php";
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<form name="form1" method="post" action="deleteAreas.php">
<?php 

	require("conexion.inc");
	include("funciones.php");	
	$datos=$_GET["datos"];	
	
?>
<input type="hidden" name="datos" value="<?php echo $datos; ?>">
	<h3 align="center" style="background:white;font-size: 14px;color: #E78611;font-weight:bold;">Confirmacion de Eliminacion de Areas </h3>


    <?php

		$datosEliminar="";
		$datosNoEliminar="";
		$vector_datos=explode(",",$datos);	
		$n=sizeof($vector_datos);
		for($i=0;$i<$n;$i++){	
		
				$cod_area=$vector_datos[$i];
				$sw=0;			
				$sql=" select  *  from usuarios  where cod_area='".$cod_area."'";			
				$resp= mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){
					$sw=1;
				}
				

				if($sw==0){
					/****************************/
						if($datosEliminar<>""){
							$datosEliminar=$datosEliminar.",".$cod_area;
						}else{
							$datosEliminar=$cod_area;
						}
					/****************************/
				}else{
					/***************************/
						if($datosNoEliminar<>""){
							$datosNoEliminar=$datosNoEliminar.",".$cod_area;
						}else{
							$datosNoEliminar=$cod_area;
						}
					/**************************/		
				}
									
		}
						
?>
<?php if($datosNoEliminar<>""){?>
<h3 align="center" style="background:white;font-size: 11px;color:#E78611;">Registros que no pueden ser Elimandos</h3>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	   	<tr height="20px" align="center"  class="titulo_tabla">
            <td>Area</td>
			<td>Observaciones</td>				
    		<td>Estado</td>
			<td>Fecha de Registro</td>	
			<td>Ultima Edicion</td>			
		</tr>
		<?php
			$vectordatosNoEliminar=explode(",",$datosNoEliminar);	
			$num=sizeof($vectordatosNoEliminar);
			for($j=0;$j<$num;$j++){	
				$cod_area=$vectordatosNoEliminar[$j];
				$sql=" select  a.nombre_area, a.obs_area, a.cod_estado_registro, ";
				$sql.=" e.nombre_estado_registro, a.fecha_registro, ";
				$sql.=" a.cod_usuario_registro, a.fecha_modifica, a.cod_usuario_modifica ";
				$sql.=" from areas a , estados_referenciales e ";
				$sql.=" where a.cod_estado_registro=e.cod_estado_registro ";
				$sql.=" and a.cod_area=".$cod_area;
				$resp = mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){	
		
					$cod_area=$dat['cod_area'];
					$nombre_area=$dat['nombre_area'];
					$obs_area=$dat['obs_area'];
					$cod_estado_registro=$dat['cod_estado_registro'];
					$nombre_estado_registro=$dat['nombre_estado_registro'];
					$fecha_registro=$dat['fecha_registro'];
					$cod_usuario_registro=$dat['cod_usuario_registro'];
					$fecha_modifica=$dat['fecha_modifica'];
					$cod_usuario_modifica=$dat['cod_usuario_modifica'];
				}										

	
		?>		
			<tr bgcolor="#FFFFFF">
    		<td><?php echo $nombre_area;?></td>
    		<td><?php echo $obs_area;?></td>
    		<td><?php echo $nombre_estado_registro; ?></td>
			<td>&nbsp;</td>
   			<td>&nbsp;</td>
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
            <td>Area</td>
			<td>Observaciones</td>				
    		<td>Estado</td>
			<td>Fecha de Registro</td>	
			<td>Ultima Edicion</td>		
		</tr>
		<?php
			$vectordatosEliminar=explode(",",$datosEliminar);	
			$num=sizeof($vectordatosEliminar);
			for($j=0;$j<$num;$j++){	
				$cod_area=$vectordatosEliminar[$j];
				$sql=" select  a.nombre_area, a.obs_area, a.cod_estado_registro, ";
				$sql.=" e.nombre_estado_registro, a.fecha_registro, ";
				$sql.=" a.cod_usuario_registro, a.fecha_modifica, a.cod_usuario_modifica ";
				$sql.=" from areas a , estados_referenciales e ";
				$sql.=" where a.cod_estado_registro=e.cod_estado_registro ";
				$sql.=" and a.cod_area=".$cod_area;
				$resp = mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){	
		
					$cod_area=$dat['cod_area'];
					$nombre_area=$dat['nombre_area'];
					$obs_area=$dat['obs_area'];
					$cod_estado_registro=$dat['cod_estado_registro'];
					$nombre_estado_registro=$dat['nombre_estado_registro'];
					$fecha_registro=$dat['fecha_registro'];
					$cod_usuario_registro=$dat['cod_usuario_registro'];
					$fecha_modifica=$dat['fecha_modifica'];
					$cod_usuario_modifica=$dat['cod_usuario_modifica'];
				}	
		?>
			<tr bgcolor="#FFFFFF">
    		<td><?php echo $nombre_area;?></td>
    		<td><?php echo $obs_area;?></td>
    		<td><?php echo $nombre_estado_registro; ?></td>
			<td>&nbsp;</td>
   			<td>&nbsp;</td>
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
