<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Eliminación de Almacenes</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function eliminar(f){
		f.submit();
	}
	
	function cancelar(f){
					window.location="navegadorAlmacenes.php";
	}
	
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<form name="form1" method="post" action="eliminarAlmacenes.php">
<?php 

	require("conexion.inc");
	include("funciones.php");	
	$datos=$_GET["datos"];	
	
?>
<input type="hidden" name="datos" value="<?php echo $datos; ?>">
	<h3 align="center" style="background:white;font-size: 14px;color: #E78611;font-weight:bold;">Confirmacion de Eliminacion de Almacenes </h3>


    <?php

		$datosEliminar="";
		$datosNoEliminar="";
		$vector_datos=explode(",",$datos);	
		$n=sizeof($vector_datos);
		for($i=0;$i<$n;$i++){	
		
				$cod_almacen=$vector_datos[$i];
				$sw=0;			
				$sql=" select  *  from ingresos  where cod_almacen='".$cod_almacen."'";			
				$resp= mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){
					$sw=1;
				}
				
				if($sw==0){
					/****************************/
						if($datosEliminar<>""){
							$datosEliminar=$datosEliminar.",".$cod_almacen;
						}else{
							$datosEliminar=$cod_almacen;
						}
					/****************************/
				}else{
					/***************************/
						if($datosNoEliminar<>""){
							$datosNoEliminar=$datosNoEliminar.",".$cod_almacen;
						}else{
							$datosNoEliminar=$cod_almacen;
						}
					/**************************/		
				}
									
		}
						
?>
<?php if($datosNoEliminar<>""){?>
<h3 align="center" style="background:white;font-size: 11px;color:#E78611;">Registros que no pueden ser Elimandos</h3>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	   	<tr height="20px" align="center"  class="titulo_tabla">
    		<td>Almacen</td>
    		<td>Sucursal</td>	
    		<td>Estado</td>				
		</tr>
		<?php
			$vectordatosNoEliminar=explode(",",$datosNoEliminar);	
			$num=sizeof($vectordatosNoEliminar);
			for($j=0;$j<$num;$j++){	
				$cod_almacen=$vectordatosNoEliminar[$j];
				$sql="select cod_almacen, cod_sucursal, nombre_almacen, cod_estado_registro";
				$sql.=" from almacenes ";	
				$sql.=" where cod_almacen='".$cod_almacen."'";
				$resp = mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){	
		
					$cod_almacen=$dat[0];
					$cod_sucursal=$dat[1];
					$nombre_almacen=$dat[2];
					$cod_estado_registro=$dat[3];		
					//**************************************************************
					$nombre_sucursal="";
					$sql2="select nombre_sucursal from sucursales where cod_sucursal='".$cod_sucursal."'";
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_sucursal=$dat2[0];
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
    		<td><?php echo $nombre_almacen;?></td>
    		<td><?php echo $nombre_sucursal;?></td>
    		<td><?php echo $nombre_estado_registro;?></td>
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
    		<td>Almacen</td>
    		<td>Sucursal</td>	
    		<td>Estado</td>	
		</tr>
		<?php
			$vectordatosEliminar=explode(",",$datosEliminar);	
			$num=sizeof($vectordatosEliminar);
			for($j=0;$j<$num;$j++){	
				$cod_almacen=$vectordatosEliminar[$j];
				$sql="select cod_almacen, cod_sucursal, nombre_almacen, cod_estado_registro";
				$sql.=" from almacenes ";	
				$sql.=" where cod_almacen='".$cod_almacen."'";
				$resp = mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){	
		
					$cod_almacen=$dat[0];
					$cod_sucursal=$dat[1];
					$nombre_almacen=$dat[2];
					$cod_estado_registro=$dat[3];		
					//**************************************************************
					$nombre_sucursal="";
					$sql2="select nombre_sucursal from sucursales where cod_sucursal='".$cod_sucursal."'";
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_sucursal=$dat2[0];
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
    		<td><?php echo $nombre_almacen;?></td>
    		<td><?php echo $nombre_sucursal;?></td>
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
