<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Eliminación de Sucursales</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function eliminar(f){
		f.submit();
	}
	
	function cancelar(f){
					window.location="navegadorSucursales.php";
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<form name="form1" method="post" action="eliminarSucursales.php">
<?php 

	require("conexion.inc");
	include("funciones.php");	
	$datos=$_GET["datos"];	
	
?>
<input type="hidden" name="datos" value="<?php echo $datos; ?>">
	<h3 align="center" style="background:white;font-size: 14px;color: #E78611;font-weight:bold;">Confirmacion de Eliminacion de Sucursales </h3>


    <?php

		$datosEliminar="";
		$datosNoEliminar="";
		$vector_datos=explode(",",$datos);	
		$n=sizeof($vector_datos);
		for($i=0;$i<$n;$i++){	
		
				$cod_sucursal=$vector_datos[$i];
				$sw=0;			
				$sql=" select  *  from almacenes  where cod_sucursal='".$cod_sucursal."'";			
				$resp= mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){
					$sw=1;
				}
				
				if($sw==0){
					/****************************/
						if($datosEliminar<>""){
							$datosEliminar=$datosEliminar.",".$cod_sucursal;
						}else{
							$datosEliminar=$cod_sucursal;
						}
					/****************************/
				}else{
					/***************************/
						if($datosNoEliminar<>""){
							$datosNoEliminar=$datosNoEliminar.",".$cod_sucursal;
						}else{
							$datosNoEliminar=$cod_sucursal;
						}
					/**************************/		
				}
									
		}
						
?>
<?php if($datosNoEliminar<>""){?>
<h3 align="center" style="background:white;font-size: 11px;color:#E78611;">Registros que no pueden ser Elimandos</h3>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	   	<tr height="20px" align="center"  class="titulo_tabla">
    		<td>Sucursal</td>
    		<td>Ciudad</td>
    		<td>Direcci&oacute;n</td>
    		<td>Telefono</td>		
    		<td>Estado</td>					
		</tr>
		<?php
			$vectordatosNoEliminar=explode(",",$datosNoEliminar);	
			$num=sizeof($vectordatosNoEliminar);
			for($j=0;$j<$num;$j++){	
				$cod_sucursal=$vectordatosNoEliminar[$j];
				$sql=" select cod_sucursal, nombre_sucursal, cod_ciudad,direccion_sucursal,";
				$sql.=" telf_sucursal, cod_estado_registro ";
				$sql.=" from sucursales ";				
				$sql.=" where  cod_sucursal='".$cod_sucursal."'";	
				$resp = mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){	
		
					$cod_sucursal=$dat[0]; 
					$nombre_sucursal =$dat[1];
					$cod_ciudad=$dat[2];
					$direccion_sucursal=$dat[3];
					$telf_sucursal=$dat[4];
					$cod_estado_registro=$dat[5];
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
    		<td><?php echo $nombre_sucursal;?></td>
    		<td><?php echo $desc_ciudad;?></td>
    		<td><?php echo $direccion_sucursal; ?></td>
    		<td><?php echo $telf_sucursal;?></td>
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
    		<td>Sucursal</td>
    		<td>Ciudad</td>
    		<td>Direcci&oacute;n</td>
    		<td>Telefono</td>		
    		<td>Estado</td>		
		</tr>
		<?php
			$vectordatosEliminar=explode(",",$datosEliminar);	
			$num=sizeof($vectordatosEliminar);
			for($j=0;$j<$num;$j++){	
				$cod_sucursal=$vectordatosEliminar[$j];
				$sql=" select cod_sucursal, nombre_sucursal, cod_ciudad,direccion_sucursal,";
				$sql.=" telf_sucursal, cod_estado_registro ";
				$sql.=" from sucursales ";				
				$sql.=" where  cod_sucursal='".$cod_sucursal."'";	
				$resp = mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){	
		
					$cod_sucursal=$dat[0]; 
					$nombre_sucursal =$dat[1];
					$cod_ciudad=$dat[2];
					$direccion_sucursal=$dat[3];
					$telf_sucursal=$dat[4];
					$cod_estado_registro=$dat[5];
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
    		<td><?php echo $nombre_sucursal;?></td>
    		<td><?php echo $desc_ciudad;?></td>
    		<td><?php echo $direccion_sucursal; ?></td>
    		<td><?php echo $telf_sucursal;?></td>
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
<INPUT type="button" class="boton" name="btn_eliminar"  value="Atras" onClick="cancelar(this.form);">

</div>
		
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
