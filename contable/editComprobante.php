<?php
	require("conexion.inc");
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
 function Solo_Numerico(variable){
        Numer=parseInt(variable);
        if (isNaN(Numer)){
            return "";
        }
        return Numer;
    }
function validaEntero(Control){
        Control.value=Solo_Numerico(Control.value);
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
function validarDebe(fila){

		//var debe=document.getElementById('debe'+fila).value;
	
	//	var precioCompra=document.getElementById('precioCompra'+fila).value;
		
	//	var debe=document.getElementById('debe'+fila);
		//debe.value=(parseFloat(debe));
		//debe.value=Math.round(debe.value*100)/100;

	//if(debe.value=="NaN"){
		//debe.value=0;
	//}

		sumarDebe();

}
function validarHaber(fila){

		//var debe=document.getElementById('debe'+fila).value;
	
	//	var precioCompra=document.getElementById('precioCompra'+fila).value;
		
	//	var debe=document.getElementById('debe'+fila);
		//debe.value=(parseFloat(debe));
		//debe.value=Math.round(debe.value*100)/100;

	//if(debe.value=="NaN"){
		//debe.value=0;
	//}

		sumarHaber();

}

function sumarDebe(){
 //alert("hola debe");
	var debeTotal=document.getElementById('debeTotal');
	var sumDebeTotal=0;
	for(i=1;i<=num;i++){
		
		if(document.getElementById('debe'+i)){
			sumDebeTotal=parseFloat(sumDebeTotal)+parseFloat(document.getElementById('debe'+i).value);
		}
	}	
	debeTotal.innerHTML=Math.round(sumDebeTotal*100)/100;
}
function sumarHaber(){
 //alert("hola haber");
	var haberTotal=document.getElementById('haberTotal');
	var sumHaberTotal=0;
	for(i=1;i<=num;i++){
		
		if(document.getElementById('haber'+i)){
			sumHaberTotal=parseFloat(sumHaberTotal)+parseFloat(document.getElementById('haber'+i).value);
		}
	}	
	haberTotal.innerHTML=Math.round(sumHaberTotal*100)/100;
}

function generaNroComprobante(f)
{	
		var div_nroCbte,cod_tipo_cbte;
		div_nroCbte=document.getElementById("div_nroCbte");			
		cod_tipo_cbte=f.cod_tipo_cbte.value;	
		ajax=nuevoAjax();
	
		ajax.open("GET","ajax_GenerarNroCbte.php?cod_tipo_cbte="+cod_tipo_cbte,true);				
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
			div_nroCbte.innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null)	
		
}	
	<?php 
	
	$sql2="select count(*) from comprobante_detalle where cod_cbte=".$_GET['cod_cbte'];
	$resp2=mysql_query($sql2);
	$nroDetalle=0;
	while($dat2=mysql_fetch_array($resp2)){
		$nroDetalle=$dat2[0];
	}
	?>
num=<?php echo $nroDetalle;?>;
	
	function mas(obj) {
//alert("num="+num);
  		num++;
		fi = document.getElementById('fiel');
		contenedor = document.createElement('div');
		contenedor.id = 'div'+num;  
		fi.type="style";
		fi.appendChild(contenedor);
		var div_material;
		div_detalleCbte=document.getElementById("div"+num);			
		ajax=nuevoAjax();
		ajax.open("GET","ajax_newDetalleCbte.php?codigo="+num,true);
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
				div_detalleCbte.innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null);
		buscarCuenta(num);
	}	
		
	function menos(numero) {


		 fi = document.getElementById('fiel');
  		 fi.removeChild(document.getElementById('div'+numero));
 		// num=parseInt(num)-1;
 		// calcularTotal();
	}
function buscarCuenta(numDetalleCbte){

		izquierda = (screen.width) ? (screen.width-600)/2 : 100;

	    arriba = (screen.height) ? (screen.height-400)/2 : 100;

		
		url="ajax_listCuentas2.php?numDetalleCbte="+numDetalleCbte;

		opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=650,left='+izquierda+',top=' + arriba + '';

	   	window.open(url, 'popUp', opciones);
	

}
function setCuentas(numero,cod_cuenta,nro_cuenta,desc_cuenta){

		

	
	document.getElementById('cod_cuenta'+numero).value=cod_cuenta;

	document.getElementById('div_nro_cuenta'+numero).innerHTML=nro_cuenta;
document.getElementById('div_desc_cuenta'+numero).innerHTML=desc_cuenta;
			
	}

function guardar(f){
	f.cantidad_material.value=num;
	sumarDebe();
	sumarHaber();
/*	if(f.cod_tipo_cbte.value==0){
		alert("Debe elegir el Tipo de Comprobante.");
		return(0);
	}*/
	if(num<=0){
		alert("El Comprobante no tiene detalle.");
		return(0);
	}else{
		var cuenta="";
		var debe="";
		var haber="";
			//	alert("hasta aqui="+num);
		for(var i=1; i<=num; i++){
		 if(document.getElementById('div'+i)){
			cuenta=document.getElementById("div_desc_cuenta"+i).innerHTML;
			debe=parseFloat(document.getElementById("debe"+i).value);
			haber=parseFloat(document.getElementById("haber"+i).value);
			if(cuenta==""){
				alert("La cuenta no puede estar vacia. Fila:"+i);
				return(0);
			}
			if(debe>0 && haber>0){
				alert("Un detalle no puede tener debe y haber al mismo tiempo. Fila: "+i);
				return(0);
			}
			}			
		}
		
		var debeTotal=parseFloat(document.getElementById("debeTotal").innerHTML);
		var haberTotal=parseFloat(document.getElementById("haberTotal").innerHTML);

		if(debeTotal!=haberTotal){
			alert("El comprobante no esta balanceado en sus totales.");
			return(0);
		}
	}
	
	f.submit();
}	
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>
<body >
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form method="POST" action="saveEditComprobante.php" name="form1">

<input type="hidden" id="cod_cbte" name="cod_cbte" value="<?php echo $_GET['cod_cbte']?>">
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">EDICION DE COMPROBANTE</h3>
<?php
	$sql="select cambio_bs from tipo_cambio where fecha_tipo_cambio='".date('Y-m-d', time())."'";
	$resp= mysql_query($sql);
	$cambio_bs='';
	while($dat=mysql_fetch_array($resp)){
		$cambio_bs=$dat['cambio_bs'];
	}
?>
<input type="hidden" id="cambio_bs" name="cambio_bs" value="<?php echo $cambio_bs?>">
<?php
if($cambio_bs==null or $cambio_bs=='' ){
?>
<div align="center" style="background:#FFF;font-size: 14px;color: #FF0000;font-weight:bold;">ATENCION!!! No existe el Cambio de Dolar para Hoy</div>
<?php
}


$sql="select c.cod_empresa, c.cod_gestion, c.cod_tipo_cbte, tc.nombre_tipo_cbte, c.nro_cbte, c.cod_moneda, ";
$sql.=" c.cod_estado_cbte, c.fecha_cbte, c.nro_cheque, c.nro_factura, c.banco,c.nombre, c.glosa, ";
$sql.=" c.cod_usuario_registro, c.fecha_registro, c.cod_usuario_modifica, c.fecha_modifica ";
$sql.=" from comprobante c inner join tipo_comprobante tc  on (c.cod_tipo_cbte=tc.cod_tipo_cbte) "; 
$sql.=" where c.cod_cbte='".$_GET['cod_cbte']."'";
$resp= mysql_query($sql);
$cambio_bs='';
while($dat=mysql_fetch_array($resp)){
		$cod_empresa=$dat['cod_empresa'];
		$cod_gestion=$dat['cod_gestion'];
		$cod_tipo_cbte=$dat['cod_tipo_cbte'];
		$nombre_tipo_cbte=$dat['nombre_tipo_cbte'];
		$nro_cbte=$dat['nro_cbte'];
		$codmoneda=$dat['cod_moneda'];
		$cod_estado_cbte=$dat['cod_estado_cbte'];
		$fecha_cbte=$dat['fecha_cbte'];
		$nro_cheque=$dat['nro_cheque'];
		$nro_factura=$dat['nro_factura'];
		$banco=$dat['banco'];
		$nombre=$dat['nombre'];
		$glosa=$dat['glosa'];
		$cod_usuario_registro=$dat['cod_usuario_registro'];
		$fecha_registro=$dat['fecha_registro'];
		$cod_usuario_modifica=$dat['cod_usuario_modifica'];
		$fecha_modifica=$dat['fecha_modifica'];
} 

?>

	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="70%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="8" align="center">Datos Generales</td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<th align="left">Fecha:</th>
      		<td><input type="text" name="fecha_cbte" id="fecha_cbte"  value="<?php echo strftime("%d/%m/%Y",strtotime($fecha_cbte));?>" class="textoform" ></td>            
            <th align="left">Tipo Cbte.:</th>
      		<td><?php echo $nombre_tipo_cbte;?>						
			</select></td>             
            <th align="left">Nro. Cbte.:</th>
      		<td><input type="text" name="nro_cbte" id="nro_cbte"  class="textoform" value="<?php echo $nro_cbte;?>" size="5" readonly="true" ></td>               
            <th align="left">Moneda:</th>  
      		<td><select name="cod_moneda" id="cod_moneda" class="textoform">				
				<?php
					$sql2="select cod_moneda, desc_moneda from monedas ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_moneda=$dat2['cod_moneda'];		
			  		 		$desc_moneda=$dat2['desc_moneda'];	
				 ?><option value="<?php echo $cod_moneda;?>"<?php if($codmoneda==$cod_moneda){?> selected="selected"<?php }?> ><?php echo $desc_moneda;?></option>				
				<?php		
					}
				?>						
			</select></td>                                   
         </tr>	
				 		 <tr bgcolor="#FFFFFF">
     		<th align="left">Nombre:</th>
      		<td  colspan="7"><input type="text" name="nombre" id="nombre"  class="textoform" value="<?php echo $nombre;?>" size="60" ></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<th align="left">Glosa:</th>
      		<td  colspan="7"><textarea name="glosa" id="glosa" class="textoform" cols="100"><?php echo $glosa;?></textarea></td>
    	</tr>    
				 <tr bgcolor="#FFFFFF">
     		<th align="left">Banco:</th>
      		<td><input type="text" name="banco" id="banco" value="<?php echo $banco;?>" class="textoform" ></td>            
            <th align="left">Nro Cheque:</th>
      		<td><input type="text" name="nro_cheque" id="nro_cheque" value="<?php echo $nro_cheque;?>" class="textoform" ></td>             
            <th align="left">Nro. Factura:</th>
      		<td colspan="3"><input type="text" name="nro_factura" id="nro_factura" value="<?php echo $nro_factura;?>" class="textoform" ></td>               
                                
         </tr>	    
        					
		</tbody>
	</table>	
	<?php 
	
	$sql2="select count(*) from comprobante_detalle where cod_cbte=".$_GET['cod_cbte'];
	$resp2=mysql_query($sql2);
	$nroDetalle=0;
	while($dat2=mysql_fetch_array($resp2)){
		$nroDetalle=$dat2[0];
	}
	?>
	<center>
		<fieldset id="fiel" style="width:98%;border:0;" >
			<table align="center"class="text" cellSpacing="1" cellPadding="2" width="98%" border="0" id="data0">
				<tr>
					<td align="center" colspan="10">
						<input class="boton" type="button" value="Nuevo Item (+)" onclick="mas(this)" />
						<!--input class="boton" type="button" value="Memos Item (-)" onclick="menos(this)" /-->						
					</td>
				</tr>
			
				<tr class="titulo_tabla" align="center">
					<td width="4%">&nbsp;</td>
                    <td width="7%">Nro</td>
					<td width="20%">Cuenta</td>
					<td width="10%">Nro Factura</td>
                    <td width="10%">Fecha Factura</td>
					<td width="10%">Debe</td>
					<td width="10%">Haber</td>
					<td width="20%">Glosa</td>
                    <td width="3%">Dias Venc.</td>
                    <td width="4%">&nbsp;</td>

				</tr>
				
			</table>
<?php 
$totalHaber=0;
$totalDebe=0;
			
			$sql2=" select cod_cbte_detalle,cod_cuenta,nro_factura,fecha_factura,";
			$sql2.=" dias_venc_factura,glosa,debe,haber ";
			$sql2.=" from comprobante_detalle where cod_cbte=".$_GET['cod_cbte'];
			$resp2=mysql_query($sql2);
			while($dat2=mysql_fetch_array($resp2)){
				$cod_cbte_detalle=$dat2['cod_cbte_detalle'];
				$cod_cuenta=$dat2['cod_cuenta'];
					$sql3="select nro_cuenta,desc_cuenta from cuentas where cod_cuenta=".$cod_cuenta;
					$resp3=mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$nro_cuenta=$dat3['nro_cuenta'];
						$desc_cuenta=$dat3['desc_cuenta'];
					}
				
				$nro_factura=$dat2['nro_factura'];
				$fecha_factura=$dat2['fecha_factura'];
				$dias_venc_factura=$dat2['dias_venc_factura'];
				$glosa=$dat2['glosa'];
				$debe=$dat2['debe'];
				$haber=$dat2['haber'];
				$totalHaber=$totalHaber+$haber;
				$totalDebe=$totalDebe+$debe;
			?>
			<div id="div<?php echo $cod_cbte_detalle;?>">	
			<table border="0" cellSpacing="1" cellPadding="1" width="98%"  style="border:#ccc 1px solid;" id="data<?php echo $cod_cbte_detalle?>" >
<tr bgcolor="#FFFFFF" align="left">
<td width="4%" align="left">
<a href="javascript:buscarCuenta(<?php echo $cod_cbte_detalle;?>)" >Buscar</a>
<input type="hidden" name="cod_cuenta<?php echo $cod_cbte_detalle;?>" id="cod_cuenta<?php echo $cod_cbte_detalle;?>" value="<?php echo $cod_cuenta;?>">
</td>
<td width="7%" align="left">
<div id="div_nro_cuenta<?php echo $cod_cbte_detalle;?>"><?php echo $nro_cuenta; ?></div>
</td>
<td width="20%" align="left">

<div id="div_desc_cuenta<?php echo $cod_cbte_detalle;?>"><?php echo $desc_cuenta; ?></div>
</td>
<td align="left" width="10%">
<input type="text" class="textoform" size="10"id="nro_factura<?php echo $cod_cbte_detalle;?>" name="nro_factura<?php echo $cod_cbte_detalle;?>" onKeyUp="validaEntero(this)" onChange="validaEntero(this)" value="<?php echo $nro_factura;?>" >
</td>
<td align="left" width="10%">
<input type="text" class="textoform"  size="10" id="fecha_factura<?php echo $cod_cbte_detalle;?>" name="fecha_factura<?php echo $cod_cbte_detalle;?>" value="<?php if($fecha_factura!=null){echo strftime("%d/%m/%Y",strtotime($fecha_factura));}?>" >
</td>
<td align="left" width="10%">
<input type="text" class="textoform" size="8"id="debe<?php echo $cod_cbte_detalle;?>" name="debe<?php echo $cod_cbte_detalle;?>" onKeyUp="validarDebe('<?php echo $cod_cbte_detalle;?>')"  value="<?php echo $debe;?>" >
</td>
<td align="left" width="10%">
<input type="text" class="textoform"  size="8"id="haber<?php echo $cod_cbte_detalle;?>" name="haber<?php echo $cod_cbte_detalle;?>" onKeyUp="validarHaber('<?php echo $cod_cbte_detalle;?>')" value="<?php echo $haber;?>" >
</td>

<td align="left" width="20%">
<textarea class="textoform" cols="18" id="glosa<?php echo $cod_cbte_detalle;?>" name="glosa<?php echo $cod_cbte_detalle;?>"><?php echo $glosa;?></textarea>
</td>
<td align="left" width="3%">
<input type="text" class="textoform" size="3" maxlength="3" id="dias_venc_factura<?php echo $cod_cbte_detalle;?>" name="dias_venc_factura<?php echo $cod_cbte_detalle;?>" value="<?php echo $dias_venc_factura;?>"onKeyUp="validaEntero(this)" onChange="validaEntero(this)">
</td>

<td align="center"  width="4%" ><input class="boton" type="button" value="E" onclick="menos(<?php echo $cod_cbte_detalle;?>)" /></td>

</tr>
</table>
			</div>
			<?php
			} 

			?>			
		</fieldset>
    


		<table align="center"class="text" cellSpacing="1" cellPadding="2" width="98%" border="0" id="dataTotal">
				<tr class="titulo_tabla">
					<td  width="51%" colspan="5">&nbsp;<b>Total</b></td>
                    <td  width="10%" ><SPAN id="debeTotal"><?php echo $totalDebe;?></SPAN></td>
                    <td  width="10%"><SPAN id="haberTotal"><?php echo $totalHaber;?></SPAN></td>
					<td width="20%">&nbsp;</td>
					<td colspan="2" width="7%">&nbsp;</td>
					
				</tr>		
		</table>
	</center>	    
	<br>
<div align="center">
<INPUT type="button" class="boton" name="btn_guardar" value="Guardar Cambios" onClick="guardar(this.form);">
<INPUT type="button" class="boton" name="atras" value="Cancelar Registro" onClick="javascript:history.back(1)">
</div>

<input type="hidden" name="cantidad_material">

</form>

</body>
</html>
