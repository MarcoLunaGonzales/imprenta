<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Eliminación de Cargos</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function eliminar(f){
		if(confirm("Esta seguro de eliminar.")){
			f.submit();
		}		
	}
	
	function cancelar(f){
					window.location="navegadorItems.php";
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<form name="form1" method="post" action="eliminarCompCarac.php">
<?php 

	require("conexion.inc");
	include("funciones.php");
	$datos=$_GET['datos'];
	$codItem=$_GET['codItem'];
	$codCompItem=$_GET['codCompItem'];
	
?>
	<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">CONFIRMACI&Oacute;N DE ELIMINACI&Oacute;N DE ITEMS </h3>


    <?php

		$datosEliminar="";
		$datosNoEliminar="";
		$vector_datos=explode(",",$datos);	
		$n=sizeof($vector_datos);
		for($i=0;$i<$n;$i++){	
		
				$cod_item=$vector_datos[$i];
				$sw=0;			
				$sql="select * from cotizacion_detalle_caracteristica where cod_carac='".$cod_item."'";		
				$resp= mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){
					$sw=1;
				}
				
				if($sw==0){
					/****************************/
						if($datosEliminar<>""){
							$datosEliminar=$datosEliminar.",".$cod_item;
						}else{
							$datosEliminar=$cod_item;
						}
					/****************************/
				}else{
					/***************************/
						if($datosNoEliminar<>""){
							$datosNoEliminar=$datosNoEliminar.",".$cod_item;
						}else{
							$datosNoEliminar=$cod_item;
						}
					/**************************/		
				}
									
		}
						
?>
<?php if($datosNoEliminar<>""){?>
<h3 align="center" style="background:white;font-size: 11px;color:#d20000;">Registros que no pueden ser Elimandos</h3>
	<table width="50%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	   	<tr height="20px" align="center"  class="titulo_tabla">
			<td>Caracteristica</td>
		</tr>
		<?php
			$vectordatosNoEliminar=explode(",",$datosNoEliminar);	
			$num=sizeof($vectordatosNoEliminar);
			for($j=0;$j<$num;$j++){	
				$cod_item=$vectordatosNoEliminar[$j];
				$sql="select desc_carac from caracteristicas where cod_carac='".$cod_item."'";
				$resp= mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){
					$desc_carac=$dat[0];
				}
	
		?>		
			<tr bgcolor="#FFFFFF">
				<td><?php echo $desc_carac;?></td>
	    	 </tr>
		<?php
			}
		?>
	 </table>
<?php }?>
<br>

<?php if($datosEliminar<>""){?>
<h3 align="center" style="background:white;font-size: 11px;color:#d20000;">Registros que pueden ser Elimandos</h3>
	<table width="50%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	   	<tr height="20px" align="center"  class="titulo_tabla">
			<td>Item</td>						
			<td>Estado de Registro</td>	
		</tr>
		<?php
			$vectordatosEliminar=explode(",",$datosEliminar);	
			$num=sizeof($vectordatosEliminar);
			for($j=0;$j<$num;$j++){	
				$cod_item=$vectordatosEliminar[$j];
				$sql="select desc_carac from caracteristicas where cod_carac='".$cod_item."'";
				$resp= mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){
					$desc_carac=$dat[0];																		
				}
		?>		
			<tr bgcolor="#FFFFFF">
				<td><?php echo $desc_item;?></td>														
				<td><?php echo $desc_carac;?></td>
	    	 </tr>
		<?php
			}
		?>
	 </table>
<?php }?>
</div>			

<br>
<input type="hidden" name="datos" value="<?php echo $datosEliminar;?>">
<input type="hidden" name="codItem" value="<?php echo $codItem;?>">
<input type="hidden" name="codCompItem" value="<?php echo $codCompItem;?>">

<div align="center">

<INPUT type="button" class="boton" name="btn_eliminar"  value="Confirmar Eliminación" onClick="eliminar(this.form);">
<INPUT type="button" class="boton" name="btn_eliminar"  value="Cancelar" onClick="cancelar(this.form);">

</div>
		
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
