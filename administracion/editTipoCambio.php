<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>MODULO DE ADMINISTRACI&Oacute;N</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
		if(f.cambio_bs.value=="" ||f.cambio_bs.value==0  ){
			alert("El Cambio a Bolivianos no puede ser vacio o igual a 0.")
			f.cambio_bs.focus();
		 	return(false);
			
		}
		f.submit();
	}	
	function cancelar(){
			window.location="listTipoCambio.php";
	}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form  method="post" action="saveEditTipoCambio.php">
<input type="hidden" name="fecha_tipo_cambio" id="fecha_tipo_cambio" value="<?php echo $_GET['fecha_tipo_cambio'];?>">
<input type="hidden" name="cod_moneda" id="cod_moneda" value="<?php echo $_GET['cod_moneda'];?>">
<?php 
	require("conexion.inc");
	
	$fecha_tipo_cambio=$_GET['fecha_tipo_cambio'];
	$cod_moneda=$_GET['cod_moneda'];
//	echo "fecha_tipo_cambio=".$fecha_tipo_cambio."<br>";
//	echo "cod_moneda=".$cod_moneda."<br>";
//	echo strftime("%Y-%m-%d",strtotime($fecha_tipo_cambio))."<br>";
	
		$sql=" select tc.fecha_tipo_cambio, tc.cod_moneda, m.desc_moneda, tc.cambio_bs ";
		$sql.=" from tipo_cambio tc, monedas m ";
		$sql.=" where tc.cod_moneda=m.cod_moneda ";
		$sql.=" and  tc.fecha_tipo_cambio='".strftime("%Y-%m-%d",strtotime($fecha_tipo_cambio))."'";
		$sql.=" and tc.cod_moneda=".$cod_moneda;
		$resp = mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){
			
				$fecha_tipo_cambio=$dat['fecha_tipo_cambio'];
				$cod_moneda=$dat['cod_moneda'];
				$desc_moneda=$dat['desc_moneda'];
				$cambio_bs=$dat['cambio_bs'];				
							
		}

?>
<h3 align="center" style="background:#F7F5F3;font-size: 14px;color: #E78611;font-weight:bold;">Edici&oacute;n de Tipo de Cambio</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="70%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Moneda</td>
      		<td><?php echo $desc_moneda;?></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha</td>
      		<td><?php echo strftime("%d/%m/%Y",strtotime($fecha_tipo_cambio));?></td>
    	</tr>        

		<tr bgcolor="#FFFFFF">
     		<td>Cambio Bs</td>
      		<td><input type="text"  class="textoform" name="cambio_bs" id="cambio_bs" value="<?php echo $cambio_bs;?>"></td>
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
