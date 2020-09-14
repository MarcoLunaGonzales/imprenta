<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Eliminación de Grupos</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function eliminar(f){
		f.submit();
	}
	
	function cancelar(f){
					window.location="navegadorSubGrupos.php?cod_grupo="+f.cod_grupo.value;
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<form name="form1" method="post" action="eliminarSubGrupos.php">
<?php 

	require("conexion.inc");
	include("funciones.php");	
	$datos=$_GET["datos"];	
	$cod_grupo=$_GET["cod_grupo"];	
	$sql="select nombre_grupo from grupos where cod_grupo=".$cod_grupo;
	$resp = mysql_query($sql);
	$nombre_grupo="";
	if($dat=mysql_fetch_array($resp)){
		$nombre_grupo=$dat[0];
	}		
	
?>
<input type="hidden" name="cod_grupo" value="<?php echo $cod_grupo; ?>">
	<h3 align="center" style="background:white;font-size: 14px;color: #E78611;font-weight:bold;">Confirmacion de Eliminacion de Subgrupos del Grupo <?php echo $nombre_grupo; ?></h3>


    <?php

		$datosEliminar="";
		$datosNoEliminar="";
		$vector_datos=explode(",",$datos);	
		$n=sizeof($vector_datos);
		for($i=0;$i<$n;$i++){	
		
				$cod_subgrupo=$vector_datos[$i];
				$sw=0;			
				$sql=" select  *  from materiales  where cod_subgrupo='".$cod_subgrupo."'";			
				$resp= mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){
					$sw=1;
				}
				

				
				if($sw==0){
					/****************************/
						if($datosEliminar<>""){
							$datosEliminar=$datosEliminar.",".$cod_subgrupo;
						}else{
							$datosEliminar=$cod_subgrupo;
						}
					/****************************/
				}else{
					/***************************/
						if($datosNoEliminar<>""){
							$datosNoEliminar=$datosNoEliminar.",".$cod_subgrupo;
						}else{
							$datosNoEliminar=$cod_subgrupo;
						}
					/**************************/		
				}
									
		}
						
?>
<?php if($datosNoEliminar<>""){?>
<h3 align="center" style="background:white;font-size: 11px;color:#E78611;">Registros que no pueden ser Elimandos</h3>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	   	<tr height="20px" align="center"  class="titulo_tabla">
			<td>SubGrupo</td>
            <td>Abreviatura</td>
			<td>Estado</td>			
		</tr>
		<?php
			$vectordatosNoEliminar=explode(",",$datosNoEliminar);	
			$num=sizeof($vectordatosNoEliminar);
			for($j=0;$j<$num;$j++){	
				$cod_subgrupo=$vectordatosNoEliminar[$j];
				
				$sql=" select nombre_subgrupo, abrev_subgrupo, cod_estado_registro";
				$sql.=" from subgrupos";				
				$sql.=" where cod_subgrupo='".$cod_subgrupo."'";
				$resp = mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){	
		
					$nombre_subgrupo=$dat['nombre_subgrupo'];
					$abrev_subgrupo=$dat['abrev_subgrupo'];
					$cod_estado_registro=$dat['cod_estado_registro'];		
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
    				<td><?php echo $nombre_subgrupo;?></td>
                    <td><?php echo $abrev_subgrupo;?></td>
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
			<td>SubGrupo</td>
            <td>Abreviatura</td>
			<td>Estado</td>	
		</tr>
		<?php
			$vectordatosEliminar=explode(",",$datosEliminar);	
			$num=sizeof($vectordatosEliminar);
			for($j=0;$j<$num;$j++){	
				$cod_subgrupo=$vectordatosEliminar[$j];
				$sql=" select nombre_subgrupo, abrev_subgrupo,  cod_estado_registro";
				$sql.=" from subgrupos";				
				$sql.=" where cod_subgrupo='".$cod_subgrupo."'";
				$resp = mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){	
		
					$nombre_subgrupo=$dat['nombre_subgrupo'];
					$abrev_subgrupo=$dat['abrev_subgrupo'];
					$cod_estado_registro=$dat['cod_estado_registro'];
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
    		<td><?php echo $nombre_subgrupo;?></td>
           <td><?php echo $abrev_subgrupo;?></td>
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
