<?php
	require("conexion.inc");
	include("funciones.php");
	

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>INVENTA</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script language='Javascript'>
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
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
</head>
<body onload="document.form1.numero_orden_trabajo.focus()">
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="saveEditOrdenTrabajo.php" name="form1" id="form1">

<?php 
$cod_orden_trabajo=$_POST['cod_orden_trabajo'];

$sql=" SELECT nro_orden_trabajo, cod_gestion, cod_est_ot, numero_orden_trabajo, ";
$sql.=" fecha_orden_trabajo, cod_cliente, detalle_orden_trabajo, obs_orden_trabajo, monto_orden_trabajo, ";
$sql.=" cod_usuario_registro,fecha_registro, cod_usuario_modifica, fecha_modifica ";
$sql.=" from ordentrabajo ";
$sql.=" where cod_orden_trabajo=".$cod_orden_trabajo;
$resp = mysql_query($sql);	

while($dat=mysql_fetch_array($resp)){
		$nro_orden_trabajo=$dat['nro_orden_trabajo'];
		$cod_gestion=$dat['cod_gestion'];		
		$codestot=$dat['cod_est_ot'];
		$numero_orden_trabajo=$dat['numero_orden_trabajo'];
		$fecha_orden_trabajo=$dat['fecha_orden_trabajo'];
		$codcliente=$dat['cod_cliente'];
		$detalle_orden_trabajo=$dat['detalle_orden_trabajo'];
		$obs_orden_trabajo=$dat['obs_orden_trabajo'];
		$monto_orden_trabajo=$dat['monto_orden_trabajo'];
		$cod_usuario_registro=$dat['cod_usuario_registro'];
		$fecha_registro=$dat['fecha_registro'];
		$cod_usuario_modifica=$dat['cod_usuario_modifica'];
		$fecha_modifica=$dat['fecha_modifica'];
}
	$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion."'";
	$resp2= mysql_query($sql2);
	$gestion="";
	while($dat2=mysql_fetch_array($resp2)){
		$gestion=$dat2[0];
	}


?>
<input type="hidden" name="cod_orden_trabajo" id="cod_orden_trabajo" value="<?php echo $cod_orden_trabajo;?>">
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">EDICION DE ORDEN DE TRABAJO</h3>
<p align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">Nro.<?php echo $nro_orden_trabajo."/".$gestion; ?></p>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Introduzca Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Numero Interno</td>
      		<td><span id="sprytextfield1">
            <label for="numero_orden_trabajo"></label>
            <input type="text" name="numero_orden_trabajo" id="numero_orden_trabajo" class="textoform" value="<?php echo $numero_orden_trabajo; ?>">
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha Orden de Trabajo</td>
      		<td><span id="sprytextfield2">
            <label for="fecha_orden_trabajo"></label>
            <input type="text" name="fecha_orden_trabajo" id="fecha_orden_trabajo" class="textoform" value="<?php echo strftime("%d/%m/%Y",strtotime($fecha_orden_trabajo));?>">
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    	</tr>        
		 <tr bgcolor="#FFFFFF">
     		<td>Cliente</td>
      		<td><span id="spryselect1">
      		  <label for="cod_cliente"></label>
			<div id="div_cliente">
			<select name="cod_cliente" id="cod_cliente" class="textoform" >
				<option value="0">Seleccione un Opci&oacute;n</option>
				<?php
					$sql2="select cod_cliente,nombre_cliente from clientes order by  nombre_cliente asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_cliente=$dat2[0];	
			  		 		$nombre_cliente=$dat2[1];	
				 ?><option value="<?php echo $cod_cliente;?>" <?php if($cod_cliente==$codcliente){?>selected<?php }?>><?php echo $nombre_cliente;?></option>				
				<?php		
					}
				?>						
			</select>
			<a  href="javascript:cargar_cliente();">[ Nuevo Cliente]</a>
			&nbsp;<a  href="javascript:datosCliente(this.form);">[Datos Cliente]</a>			</div>	
   		    <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Monto</td>
      		<td><span id="sprytextfield3">
            <label for="monto_orden_trabajo"></label>
            <input type="text" name="monto_orden_trabajo" id="monto_orden_trabajo" class="textoform" value="<?php echo $monto_orden_trabajo;?>">
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    	</tr>   
		 <tr bgcolor="#FFFFFF">
     		<td>Detalle</td>
      		<td><span id="sprytextarea1">
      		  <label for="detalle_orden_trabajo"></label>
      		  <textarea name="detalle_orden_trabajo" id="detalle_orden_trabajo" cols="45" rows="3" class="textoform"><?php echo $detalle_orden_trabajo;?></textarea>
</span></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
      		<td><span id="sprytextarea2">
      		  <label for="obs_orden_trabajo"></label>
      		  <textarea name="obs_orden_trabajo" id="obs_orden_trabajo" cols="45" rows="3" class="textoform"><?php echo $obs_orden_trabajo;?></textarea>
</span></td>
    	</tr>                              
		<tr bgcolor="#FFFFFF">
     		<td>Estado de Orden de Trabajo</td>
      		<td><span id="spryselect2">
      		  <label for="cod_est_ot"></label>
      		  <select name="cod_est_ot" id="cod_est_ot" class="textoform">
		<?php
    		$sql2=" select cod_est_ot, desc_est_ot from estado_ordentrabajo ";
		    $resp2 = mysql_query($sql2);	
	
			while($dat2=mysql_fetch_array($resp2)){
				$cod_est_ot=$dat2['cod_est_ot'];
				$desc_est_ot=$dat2['desc_est_ot'];
		?>
        	<option value="<?php echo $cod_est_ot;?>" <?php if($cod_est_ot==$codestot){?> selected <?php }?> ><?php echo $desc_est_ot;?></optgroup>        
        <?php
				
			}              
		?>
   		    </select>
   		    <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
    	</tr>		
										
		</tbody>
	</table>	
	<br>
<div align="center">
<INPUT type="button" class="boton" name="btn_guardar" value="IR ATRAS" onClick="cancelar(this.form);"  >
<INPUT type="submit" class="boton" name="btn_guardar" value="GUARDAR CAMBIOS"   >
</div>
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"dd/mm/yyyy"});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "real");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false});
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {isRequired:false});
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
</script>
</body>
</html>
