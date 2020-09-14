<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>Editar Coordenada</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
		if(f.valor_x.value=="" || f.valor_y.value==""){
			alert("El valor de X y Y deben tener un valor.")
			f.valor_x.focus();
		 	return(false);
			
		}
		if(confirm("Esta seguro de continuar con la edicion.")){
			f.submit();
		}else{
			return(false);
		}
	}	
	function cancelar(){
			window.location="navegadorCoordenadasImpresion.php";
	}

</script>

</head>
<body>
<!---Autor:Gabriela Quelali Siani
	02 de Julio de 2008
-->
<form   method="post" action="guardaEditarCoordenadaImpresion.php" accept-charset="UTF-8">
<?php 
	require("conexion.inc");
	
	$cod_coordenada=$_GET['cod_coordenada'];
	
	$sql=" select desc_coordenada, valor_x, valor_y ";
	$sql.=" from coordenadas_impresion where cod_coordenada='".$cod_coordenada."'";
    $resp= mysql_query($sql);	
	$dat=mysql_fetch_array($resp);
	$desc_coordenada=$dat[0];
	$valor_x=$dat[1];	
	$valor_y=$dat[2];		

?>
<input type="hidden" name="cod_coordenada" value="<?php echo $cod_coordenada;?>">

<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">EDICI&Oacute;N DE COORDENADA DE  <?php echo $desc_coordenada;?> </h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">

		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Valo X</td>
      		<td>
			<input type="text"  class="textoform" size="50" name="valor_x"  value="<?php echo $valor_x;?>"></td>
    	</tr>
		<tr bgcolor="#FFFFFF">
     		<td>Valo Y</td>
      		<td>
			<input type="text"  class="textoform" size="50" name="valor_y"  value="<?php echo $valor_y;?>"></td>
    	</tr>
		</table>	
	<br>
<div align="center">
<INPUT type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
<INPUT type="button"  class="boton"  name="btn_limpiar" value="Cancelar" onClick="cancelar();"  >
</div>
</form>
<?php require("cerrar_conexion.inc");?>

</body>
</html>
