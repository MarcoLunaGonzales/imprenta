<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Anulacion de  Ingreso </title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>


function guardar(f)
{	
	if(f.obs_anular.value==""){
		 		alert('El '); 			 	
		 		return(false);
	}	
			f.submit();
}	
	function cancelar(f)
	{	
		window.close();
	}			
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="guardaAnularIngreso.php">
<?php 	


	require("conexion.inc");
	include("funciones.php");
	$cod_ingreso=$_GET['cod_ingreso'];


	
	
	$sql=" select cod_gestion, cod_almacen, nro_ingreso, cod_tipo_ingreso, fecha_ingreso, ";
	$sql.=" cod_usuario_ingreso, cod_proveedor, cod_salida, nro_factura, obs_ingreso, ";
	$sql.=" fecha_modifica, cod_usuario_modifica, cod_estado_ingreso ";
	$sql.=" from ingresos ";
	$sql.=" where  cod_ingreso=".$cod_ingreso;
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$cod_gestion=$dat[0];
		$cod_almacen=$dat[1];
		$nro_ingreso=$dat[2];
		$cod_tipo_ingreso=$dat[3];
		$fecha_ingreso=$dat[4];
		$cod_usuario_ingreso=$dat[5];
		$codproveedor=$dat[6];
		$cod_salida=$dat[7];
		$nro_factura=$dat[8];
		$obs_ingreso=$dat[9];
		$fecha_modifica=$dat[10];
		$cod_usuario_modifica=$dat[11];
		$cod_estado_ingreso=$dat[12];
	
				////////////////GESTION////////////////////
					$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion."'";
					$resp2= mysql_query($sql2);
					$gestion="";
					while($dat2=mysql_fetch_array($resp2)){
						$gestion=$dat2[0];
					}
				//******************************AlMACEN ********************************
				$nombre_almacen="";
				$sql2="select nombre_almacen from almacenes where cod_almacen='".$cod_almacen."'";
				$resp2= mysql_query($sql2);			
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_almacen=$dat2[0];
				}						
				

				
				$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios ";
				$sql2.=" where cod_usuario='".$cod_usuario_ingreso."'";
				$resp2= mysql_query($sql2);
				$nombres_usuario="";
				$ap_paterno_usuario="";
				$ap_materno_usuario="";		
				while($dat2=mysql_fetch_array($resp2)){	
					$nombres_usuario=$dat2[0];
					$ap_paterno_usuario=$dat2[1];
					$ap_materno_usuario=$dat2[2];		
				}					
			//******************************TIPO DE INGRESO********************************
				$nombre_tipo_ingreso="";
				$sql2="select nombre_tipo_ingreso from tipos_ingreso where cod_tipo_ingreso='".$cod_tipo_ingreso."'";
				$resp2= mysql_query($sql2);			
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_tipo_ingreso=$dat2[0];
				}

				
				//******************************ESTADO********************************
				$desc_estado_ingreso="";
				$sql2=" select desc_estado_ingreso from estados_ingresos_almacen ";
				$sql2.=" where cod_estado_ingreso='".$cod_estado_ingreso."'";
				$resp2= mysql_query($sql2);			
				while($dat2=mysql_fetch_array($resp2)){
					$desc_estado_ingreso=$dat2[0];
				}		
	}		

?>
<input type="hidden" name="cod_ingreso" value="<?php echo $cod_ingreso;?>">
<h3 align="center" style="background:white;font-size: 12px;color:#E78611;font-weight:bold;">Anulacion de Ingreso <br>
  No. <?php echo $nro_ingreso;?>/<?php echo $gestion;?><br><?php echo "Fecha: ".strftime("%d/%m/%Y",strtotime($fecha_ingreso))?></h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="50%" bgColor="#cccccc" border="0">
	<tbody>

		<tr height="20px" align="center"  class="titulo_tabla">
			<td>Motivo de Anulacion</td>
		</tr>		
		<tr bgcolor="#FFFFFF">
			<td >
			<textarea cols="70" rows="4" name="obs_anular" id="obs_anular"  class="textoform" ></textarea>
			</td>
		</tr>							
	  </tbody>
	</table>	

		
<br>
<div align="center">
	<input type="button" class="boton" name="btn_guardar" value="Aceptar" onClick="guardar(this.form);"  >
	<input type="reset"  class="boton"  name="btn_limpiar" value="Cancelar" onClick="cancelar(this.form);" >
</div>
</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>
