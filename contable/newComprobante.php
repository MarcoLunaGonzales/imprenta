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
num=0;
	
	function mas(obj) {

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
	if(f.cod_tipo_cbte.value==0){
		alert("Debe elegir el Tipo de Comprobante.");
		return(0);
	}
	if(num<=0){
		alert("El Comprobante no tiene detalle.");
		return(0);
	}else{
		var cuenta="";
		var debe="";
		var haber="";
				
		for(var i=1; i<=num; i++){
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
<body bgcolor="#FFFFFF" >
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form method="POST" action="saveComprobante.php" name="form1">

<?php 

	$cod_est_fac=1;
	$sql2=" select desc_est_fac from estado_factura where cod_est_fac='".$cod_est_fac."'";
    $resp2 = mysql_query($sql2);	
	$desc_est_fac="";
	while($dat2=mysql_fetch_array($resp2)){
		$desc_est_fac=$dat2[0];
	}

?>
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">REGISTRO DE COMPROBANTE</h3>
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
?>

	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="70%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="8" align="center">Datos Generales</td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<th align="left">Fecha:</th>
      		<td><input type="text" name="fecha_cbte"  id="fecha_cbte" value="<?php echo date('d/m/Y', time());?>" class="textoform" ></td>            
            <th align="left">Tipo Cbte.:</th>
      		<td><select name="cod_tipo_cbte" id="cod_tipo_cbte" class="textoform" onChange="generaNroComprobante(this.form)">		
	            <option value="<?php echo NULL;?>">Seleccione el Tipo de Cbte.</option>		
				<?php
					$sql2="select cod_tipo_cbte, nombre_tipo_cbte from tipo_comprobante ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_tipo_cbte=$dat2['cod_tipo_cbte'];		
			  		 		$nombre_tipo_cbte=$dat2['nombre_tipo_cbte'];	
				 ?><option value="<?php echo $cod_tipo_cbte;?>"><?php echo $nombre_tipo_cbte;?></option>				
				<?php		
					}
				?>						
			</select></td>             
            <th align="left">Nro. Cbte.:</th>
      		<td><div id="div_nroCbte"></div></td>               
            <th align="left">Moneda:</th>  
      		<td><select name="cod_moneda" id="cod_moneda" class="textoform">				
				<?php
					$sql2="select cod_moneda, desc_moneda from monedas ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_moneda=$dat2['cod_moneda'];		
			  		 		$desc_moneda=$dat2['desc_moneda'];	
				 ?><option value="<?php echo $cod_moneda;?>"><?php echo $desc_moneda;?></option>				
				<?php		
					}
				?>						
			</select></td>                                   
         </tr>	
						 		 <tr bgcolor="#FFFFFF">
     		<th align="left">Nombre:</th>
      		<td  colspan="7"><input type="text" name="nombre" id="nombre"  class="textoform"  size="60" ></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<th align="left">Glosa:</th>
      		<td  colspan="7"><textarea name="glosa" id="glosa" class="textoform" cols="100"></textarea></td>
    	</tr>        
	 <tr bgcolor="#FFFFFF">
     		<th align="left">Banco:</th>
      		<td><input type="text" name="banco" id="banco"  class="textoform" ></td>            
            <th align="left">Nro Cheque:</th>
      		<td><input type="text" name="nro_cheque" id="nro_cheque" class="textoform" ></td>             
            <th align="left">Nro. Factura:</th>
      		<td colspan="3"><input type="text" name="nro_factura" id="nro_factura"  class="textoform" ></td>               
                                
         </tr>	 			
         <tr bgcolor="#FFFFFF">
	         <th align="left" >Estado:</th>
			<td colspan="7">ACTIVO</td>
		</tr>	        					
		</tbody>
	</table>	
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
		</fieldset>
           

		
		<table align="center"class="text" cellSpacing="1" cellPadding="2" width="98%" border="0" id="dataTotal">
				<tr class="titulo_tabla">
					<td  width="51%" colspan="5">&nbsp;<b>Total</b></td>
                    <td  width="10%" ><SPAN id="debeTotal">0</SPAN></td>
                    <td  width="10%"><SPAN id="haberTotal">0</SPAN></td>
					<td width="20%">&nbsp;</td>
					<td colspan="2" width="7%">&nbsp;</td>
					
				</tr>		
		</table>
	</center>	    
	<br>
<div align="center">
<INPUT type="button" class="boton" name="btn_guardar" value="Guardar Registro" onClick="guardar(this.form);">
<INPUT type="button" class="boton" name="atras" value="Cancelar Registro" onClick="javascript:history.back(1)">
</div>

<input type="hidden" name="cantidad_material">

</form>

</body>
</html>
