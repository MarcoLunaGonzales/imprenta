<?php
	require("conexion.inc");
	$cod_orden_trabajo=$_GET['cod_orden_trabajo'];

		//Fin de calculo de paginas
	$sql=" select  ot.nro_orden_trabajo, ot.cod_gestion, g.gestion, ot.cod_est_ot, ";
	$sql.=" eo.desc_est_ot, ot.numero_orden_trabajo, ot.fecha_orden_trabajo, ot.cod_cliente, cli.nombre_cliente, cli.nit_cliente, ";
	$sql.=" ot.detalle_orden_trabajo, ot.obs_orden_trabajo, ot.monto_orden_trabajo, ot.cod_usuario_registro, ot.fecha_registro,";
	$sql.=" ot.cod_usuario_modifica, ot.fecha_modifica, ot.descuento_orden_trabajo, ot.descuento_obs,";
	$sql.=" ot.incremento_orden_trabajo, ot.incremento_obs ";
	$sql.=" from ordentrabajo ot, gestiones g, estado_ordentrabajo eo, clientes cli ";
	$sql.=" where ot.cod_gestion=g.cod_gestion ";
	$sql.=" and ot.cod_est_ot=eo.cod_est_ot ";
	$sql.=" and ot.cod_cliente=cli.cod_cliente ";
	$sql.=" and ot.cod_orden_trabajo=".$cod_orden_trabajo;
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
			$nro_orden_trabajo=$dat['nro_orden_trabajo'];
				$cod_gestion=$dat['cod_gestion'];
				$gestion=$dat['gestion'];
				$cod_est_ot=$dat['cod_est_ot'];
				$desc_est_ot=$dat['desc_est_ot'];
				$numero_orden_trabajo=$dat['numero_orden_trabajo'];
				$fecha_orden_trabajo=$dat['fecha_orden_trabajo'];
				$codcliente=$dat['cod_cliente'];
				$nombre_cliente=$dat['nombre_cliente'];
				$nit_cliente=$dat['nit_cliente'];
				$detalle_orden_trabajo=$dat['detalle_orden_trabajo'];
				$obs_orden_trabajo=$dat['obs_orden_trabajo'];
				$monto_orden_trabajo=$dat['monto_orden_trabajo'];
				$cod_usuario_registro=$dat['cod_usuario_registro'];
				$fecha_registro=$dat['fecha_registro'];
				$cod_usuario_modifica=$dat['cod_usuario_modifica'];
				$fecha_modifica=$dat['fecha_modifica'];
				$descuento_orden_trabajo=$dat['descuento_orden_trabajo'];
				$descuento_obs=$dat['descuento_obs'];
				$incremento_orden_trabajo=$dat['incremento_orden_trabajo'];
				$incremento_obs=$dat['incremento_obs'];
		}


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>INVENTA</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script language='Javascript'>

	function cancelar(){
			window.location="listOrdenTrabajo.php";
	}
	function nuevoAjax()
{	var xmlhttp=false;
 		try {
 			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	 	} catch (e) {
 			try {
 				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
 			} catch (E) {
 				xmlhttp = false;
 			}
	  	}
		if (!xmlhttp && typeof XMLHttpRequest!="undefined") {
 			xmlhttp = new XMLHttpRequest();
		}
		return xmlhttp;
}
function cargar_cliente_ajax(url)
{	var div_cliente;
		div_cliente=document.getElementById("div_cliente");
		ajax=nuevoAjax();
		ajax.open("GET", url,true);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4) {
			div_cliente.innerHTML=ajax.responseText;
			}
		}
		ajax.send(null)
}	
function cargar_cliente()
{			
		izquierda = (screen.width) ? (screen.width-600)/2 : 100 
	    arriba = (screen.height) ? (screen.height-400)/2 : 100 
		url="registrarClienteAjax.php";
		opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=500,height=400,left='+izquierda+',top=' + arriba + '' 
	   	window.open(url, 'popUp', opciones);
}	
function datosCliente(f)
{	 

		var cod_cliente=document.getElementById("cod_cliente").value;
		cod_cliente=cod_cliente*1;
		if(cod_cliente!=0){
		
			izquierda = (screen.width) ? (screen.width-600)/2 : 100 
		    arriba = (screen.height) ? (screen.height-400)/2 : 100 
			url="datosClienteAjax.php?cod_cliente="+cod_cliente;
			opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=500,height=400,left='+izquierda+',top=' + arriba + '' 
		   	window.open(url, 'popUp', opciones)
			
		}else{
			alert("Seleccione un Cliente");
			
		}
}	


</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
</head>
<body onload="document.form1.nro_factura.focus()">
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="saveFacturaOrdenTrabajo.php" name="form1">
<input type="hidden" name="cod_orden_trabajo" id="cod_orden_trabajo" value="<?php echo $cod_orden_trabajo;?>">
<?php 

	$cod_est_fac=1;
	$sql2=" select desc_est_fac from estado_factura where cod_est_fac='".$cod_est_fac."'";
    $resp2 = mysql_query($sql2);	
	$desc_est_fac="";
	while($dat2=mysql_fetch_array($resp2)){
		$desc_est_fac=$dat2[0];
	}

?>
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">REGISTRO DE FACTURA</h3>
<h3 align="center" style="background:#FFF;font-size: 12px;color: #E78611;font-weight:bold;">Nro Orden Trabajo:<?php echo $nro_orden_trabajo."/".$gestion;?> - Cliente: <?php echo $nombre_cliente;?></h3>
<div align="center"><a href="../reportes/impresionOrdenTrabajo.php?cod_orden_trabajo=<?php echo $_GET['cod_orden_trabajo']; ?>" target="_blank">VER ORDEN DE TRABAJO</a></div>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Introduzca Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Nro Factura</td>
      		<td><span id="sprytextfield1">
            <label for="nro_factura"></label>
            <input type="text" name="nro_factura" id="nro_factura" class="textoform" size="40">
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha Factura</td>
      		<td><span id="sprytextfield2">
            <label for="fecha_factura"></label>
            <input type="text"name="fecha_factura" id="fecha_factura" class="textoform" size="40" value="<?php echo date("d/m/Y");?>">
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    	</tr>        
<tr bgcolor="#FFFFFF">
     		<td>Cliente Factura</td>
      		<td>
      		  <input type="text" name="nombre_factura" id="nombre_factura" class="textoform" size="40" value="<?php echo $nombre_cliente;?>"></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>NIT</td>
      		<td><input type="text" name="nit_factura" id="nit_factura" class="textoform" size="40" value="<?php echo $nit_cliente;?>"></td>
    	</tr>   
  
		 <tr bgcolor="#FFFFFF">
     		<td>Detalle</td>
      		<td><span id="sprytextarea1">
      		  <label for="detalle_factura"></label>
      		  <textarea name="detalle_factura" id="detalle_factura" cols="40" class="textoform"  rows="2"><?php echo $detalle_orden_trabajo;?></textarea>
</span></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Monto</td>
      		<td><span id="sprytextfield5">
            <label for="monto_factura"></label>
            <input type="text"name="monto_factura"id="monto_factura" class="textoform" size="40" value="<?php echo (($monto_orden_trabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo);?>"><p style="background:#FFF;font-size: 10px;color: #660099;font-weight:bold;">
			<?php if($descuento_orden_trabajo>0){ ?>
				<?php echo "MONTO SIN DESCUENTO: ".$monto_orden_trabajo." Bs. </br>DESCUENTO AUTORIZADO: ".$descuento_orden_trabajo." Bs."; ?>
			<?php }?>
				<?php if($descuento_obs<>''){ ?>
				<?php echo "</br>IMPORTANTE: ".$descuento_obs; ?>
			<?php }?>
            
			<?php if($incremento_orden_trabajo>0){ ?>
				<?php echo "MONTO SIN INCREMENTO: ".$monto_orden_trabajo." Bs. </br>INCREMENTO AUTORIZADO: ".$incremento_orden_trabajo." Bs."; ?>
			<?php }?>
            				<?php if($incremento_obs<>''){ ?>
				<?php echo "</br>IMPORTANTE: ".$incremento_obs; ?>
			<?php }?>

                        
			</p>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
            
            </td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
      		<td><span id="sprytextarea2">
      		  <label for="obs_factura"></label>
      		  <textarea name="obs_factura" id="obs_factura" cols="40" rows="2" class="textoform"></textarea>
</span></td>
    	</tr>                              
		<tr bgcolor="#FFFFFF">
     		<td>Estado de Factura</td>
      		<td><?php echo $desc_est_fac;?></td>
    	</tr>		
										
		</tbody>
	</table>	
	<br>
<div align="center">
<INPUT type="submit" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
<INPUT type="button"  class="boton"  name="btn_limpiar" value="Cancelar" onClick="cancelar();"  >
</div>
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"dd/mm/yyyy"});

var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "real");
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {isRequired:false});
</script>
</body>
</html>
