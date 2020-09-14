<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>MODULO DE ADMINISTRACI&Oacute;N</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
		if(f.desc_gasto.value==""){
			alert("El campo Gasto se encuentra vacio.")
			f.desc_gasto.focus();
		 	return(false);
			
		}
		f.submit();
	}	
	function cancelar(){
			window.location="listGastos.php";
	}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="saveEditGasto.php">
<input type="hidden" name="cod_gasto" id="cod_gasto" value="<?php echo $_GET['cod_gasto'];?>">
<?php 
	require("conexion.inc");
	
		$sql=" select  desc_gasto, obs_gasto, cod_estado_registro,cod_usuario_registro, fecha_registro, ";
		$sql.=" cod_usuario_modifica, fecha_modifica ";
		$sql.=" from gastos ";
		$sql.=" where cod_gasto=".$_GET['cod_gasto'];
		$resp = mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){
			
				$desc_gasto=$dat['desc_gasto'];
				$obs_gasto=$dat['obs_gasto'];
				$codestadoregistro=$dat['cod_estado_registro'];
				$cod_usuario_registro=$dat['cod_usuario_registro'];				
				$fecha_registro=$dat['fecha_registro'];
				$cod_usuario_modifica=$dat['cod_usuario_modifica'];
				$fecha_modifica=$dat['fecha_modifica'];	
				///Usuario de Registro//////////
				if($cod_usuario_registro<>""){
					$sqlAux=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
					$sqlAux.=" from usuarios ";
					$sqlAux.=" where cod_usuario=".$cod_usuario_registro;
					$respAux = mysql_query($sqlAux);
					$nombres_usuario_registro="";
					$ap_paterno_usuario_registro="";
					$ap_materno_usuario_registro="";						
					while($datAux=mysql_fetch_array($respAux)){
						
						$nombres_usuario_registro=$datAux['nombres_usuario'];
						$ap_paterno_usuario_registro=$datAux['ap_paterno_usuario'];
						$ap_materno_usuario_registro=$datAux['ap_materno_usuario'];						
					}
				}
				////////////////////////////////	
				///Usuario de Modifica//////////
				if($cod_usuario_modifica<>""){
					$sqlAux=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
					$sqlAux.=" from usuarios ";
					$sqlAux.=" where cod_usuario=".$cod_usuario_modifica;
					$respAux = mysql_query($sqlAux);
					$nombres_usuario_modifica="";
					$ap_paterno_usuario_modifica="";
					$ap_materno_usuario_modifica="";						
					while($datAux=mysql_fetch_array($respAux)){
						
						$nombres_usuario_modifica=$datAux['nombres_usuario'];
						$ap_paterno_usuario_modifica=$datAux['ap_paterno_usuario'];
						$ap_materno_usuario_modifica=$datAux['ap_materno_usuario'];						
					}
				}
				////////////////////////////////				
		}

?>
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">Edici&oacute;n de Gasto</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="70%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Gasto</td>
      		<td><input type="text"  class="textoform" size="50" name="desc_gasto" id="desc_gasto" value="<?php echo $desc_gasto;?>" ></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
      		<td><input type="text"  class="textoform" size="50" name="obs_gasto" id="obs_gasto" value="<?php echo $obs_gasto;?>" ></td>
    	</tr>        

		<tr bgcolor="#FFFFFF">
     		<td>Estado de Registro</td>
      		<td>
            <select name="cod_estado_registro" id="cod_estado_registro" class="textoform">
				<?php
					$sql_2="select cod_estado_registro,nombre_estado_registro from estados_referenciales  ";
					$resp_2= mysql_query($sql_2);
					while($dat_2=mysql_fetch_array($resp_2)){	
			  		 	$cod_estado_registro= $dat_2[0];
    					$nombre_estado_registro=$dat_2[1];
				 ?>
				 	<?php if($cod_estado_registro==$codestadoregistro){?>
					
				 		<option value="<?php echo $cod_estado_registro;?>" selected><?php echo $nombre_estado_registro;?></option>				
					<?php }else{?>
						<option value="<?php echo $cod_estado_registro;?>"><?php echo $nombre_estado_registro;?></option>				
					<?php } ?>
				<?php		
					}
				?>						
			</select>
            </td>
    	</tr>	
		<tr bgcolor="#FFFFFF">
     		<td>Fecha de Registro</td>
      		<td>
            <?php
				if($fecha_registro<>""){ 
					echo strftime("%d/%m/%Y",strtotime($fecha_registro))." ". $nombres_usuario_registro[0].$ap_paterno_usuario_registro[0].$ap_materno_usuario_registro[0]; 
				}
			?>
            </td>
    	</tr>	
		<tr bgcolor="#FFFFFF">
     		<td>Ultima Edici&oacute;n</td>
      		<td>
            <?php
            				if($fecha_modifica<>""){
				echo strftime("%d/%m/%Y",strtotime($fecha_modifica))." ". $nombres_usuario_modifica[0].$ap_paterno_usuario_modifica[0].$ap_materno_usuario_modifica[0];
				}
			?>
            </td>
    	</tr>	                	
										
		</tbody>
</table>	
	<br>
<div align="center">
<INPUT type="button"  class="boton"  name="btn_limpiar" value="Cancelar" onClick="cancelar();"  >
<INPUT type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
</div>
</form>
<?php require("cerrar_conexion.inc");?>

</body>
</html>
