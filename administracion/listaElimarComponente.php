<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Eliminación de Cargos</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function eliminar(f){
		f.submit();
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
<form name="form1" method="post" action="eliminarComponente.php">
<?php 

	require("conexion.inc");
	include("funciones.php");
		
	$datos=$_GET["datos"];	
	$codItemF=$_GET["codItemF"];		
	
?>
	<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">CONFIRMACI&Oacute;N DE ELIMINACI&Oacute;N DE COMPONENTES</h3>


    <?php

		$datosEliminar="";
		$datosNoEliminar="";
		$vector_datos=explode(",",$datos);	
		$n=sizeof($vector_datos);
		for($i=0;$i<$n;$i++){	
		
				$cod_item=$vector_datos[$i];
				$sw=0;			
				$sql="select * from cotizacion_detalle_caracteristica where cod_compitem='".$cod_item."'";		
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
			<td>Item</td>						
		</tr>
		<?php
			$vectordatosNoEliminar=explode(",",$datosNoEliminar);	
			$num=sizeof($vectordatosNoEliminar);
			for($j=0;$j<$num;$j++){	
				$cod_item=$vectordatosNoEliminar[$j];
				$sql="select nombre_componenteitem from componente_items where cod_compitem='".$cod_item."'";
				$resp= mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){
					$nombreComponenteItem=$dat[0];																
				}
	
		?>		
			<tr bgcolor="#FFFFFF">
				<td><?php echo $nombreComponenteItem;?></td>
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
			<td>Componente</td>						
		</tr>
		<?php
			$vectordatosEliminar=explode(",",$datosEliminar);	
			$num=sizeof($vectordatosEliminar);
			for($j=0;$j<$num;$j++){	
				$cod_item=$vectordatosEliminar[$j];
				$sql="select nombre_componenteitem from componente_items where cod_compitem='".$cod_item."'";
				$resp= mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){
					$nombreComponenteItem=$dat[0];																		
				}
		?>		
			<tr bgcolor="#FFFFFF">
				<td><?php echo $nombreComponenteItem;?></td>														
	    	 </tr>
		<?php
			}
		?>
	 </table>
<?php }?>
</div>			

<br>
<input type="hidden" name="datosEliminar" value="<?php echo $datosEliminar;?>">
<input type="hidden" name="codItemF" value="<?php echo $codItemF;?>">
<div align="center">

<INPUT type="button" class="boton" name="btn_eliminar"  value="Confirmar Eliminación" onClick="eliminar(this.form);">
<INPUT type="button" class="boton" name="btn_eliminar"  value="Cancelar" onClick="cancelar(this.form);">

</div>
		
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
