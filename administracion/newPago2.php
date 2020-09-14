
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml version="1.0" encoding="ISO-8859-1">
<head>
<meta http-equiv="Content-Type" content="application/json; text/html; charset=iso-8859-1" />
<title>INVENTA</title>
<link rel="stylesheet" type="text/css" href="pagina.css" />
<script type="text/javascript" src="ajax/searchAjax.js"></script>
<script type="text/javascript">
function redond(num, ndec) { 
  var fact = Math.pow(10, ndec); // 10 elevado a ndec 

  /* Se desplaza el punto decimal ndec posiciones, 
se redondea el número y se vuelve a colocar 
el punto decimal en su sitio. */ 
  return Math.round(num * fact) / fact; 
}

function replaceAll( text, busca, reemplaza ){

  while (text.toString().indexOf(busca) != -1)

      text = text.toString().replace(busca,reemplaza);

  return text;

}

var totalDeudaSeleccionados=0;
var totalPagoClienteBs=0;
function verDocumentos(){
		resultados_ajax('ajaxDetallePago2.php?cod_cliente='+document.getElementById("cod_cliente").value);	

}



function checkearRegistros(){
totalDeudaSeleccionados=0;

		var frm = document.getElementById("form1");
		
		
		if(document.getElementById("seleccionarTodo").checked){
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('cod_hoja_ruta')!=-1){
					if(frm.elements[i].type =='checkbox'){
					
					totalDeudaSeleccionados=redond(totalDeudaSeleccionados,2)+redond(replaceAll(frm.elements[i+3].value,",",""),2);
						frm.elements[i].checked=true;


						frm.elements[i+3].disabled=false;
						document.getElementById(frm.elements[i+3].id).value=redond(replaceAll(frm.elements[i+2].value,",",""),2);
						//alert("aqui");
						

						
					
								
					}
				}

			}
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('cod_orden_trabajo')!=-1){
					if(frm.elements[i].type =='checkbox'){
					totalDeudaSeleccionados=redond(totalDeudaSeleccionados,2)+redond(replaceAll(frm.elements[i+3].value,",",""),2);
						frm.elements[i].checked=true;
						frm.elements[i+3].disabled=false;
								
					}
				}

			}
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('cod_salida')!=-1){
					if(frm.elements[i].type =='checkbox'){
					totalDeudaSeleccionados=redond(totalDeudaSeleccionados,2)+redond(replaceAll(frm.elements[i+3].value,",",""),2);
						frm.elements[i].checked=true;
						frm.elements[i+3].value=redond(frm.elements[i+2].value,2);
						frm.elements[i+3].disabled=false;								
					}
				}

			}			
				
		}else{
			totalDeudaSeleccionados=0;
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('cod_hoja_ruta')!=-1){
					if(frm.elements[i].type =='checkbox'){
						frm.elements[i].checked=false;
						frm.elements[i+3].disabled=true;
					}
				}

			}
			///////////////////////////////////
			////////////////////////////////
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('cod_orden_trabajo')!=-1){
					if(frm.elements[i].type =='checkbox'){
						frm.elements[i].checked=false;
						frm.elements[i+3].disabled=true;										
						
						
					}
				}

			}
			///////////////////////////////////
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('cod_salida')!=-1){
					if(frm.elements[i].type =='checkbox'){
						frm.elements[i].checked=false;
						frm.elements[i+3].disabled=true;											
						
						
					}
				}

			}			
		}
document.getElementById('id_totalDeudaSeleccionados').innerHTML=totalDeudaSeleccionados;
	sumarSeleccionados();
	sumarMontosPagar();
	//distribuirDinero();
}

function habilitarFilaVenta(codigo){

	if(document.getElementById("cod_salida"+codigo).checked){

		document.getElementById("monto_pago_venta"+codigo).disabled=false;

	}else{

		document.getElementById("monto_pago_venta"+codigo).disabled=true;

	}
			sumarSeleccionados();
			sumarMontosPagar();
	//distribuirDinero();
}
function habilitarFilaOrdenTrabajo(codigo){

	if(document.getElementById("cod_orden_trabajo"+codigo).checked){
		document.getElementById("monto_pago_ot"+codigo).disabled=false;

	}else{

		document.getElementById("monto_pago_ot"+codigo).disabled=true;
	}
	sumarSeleccionados();
	sumarMontosPagar()
	//distribuirDinero();
}


function habilitarFilaHojaRuta(codigo){

	if(document.getElementById("cod_hoja_ruta"+codigo).checked){

		document.getElementById("monto_pago_hr"+codigo).disabled=false;

	}else{

		document.getElementById("monto_pago_hr"+codigo).disabled=true;


	}
	sumarSeleccionados();
	sumarMontosPagar()
	//distribuirDinero();
}
function sumarSeleccionados(){
totalDeudaSeleccionados=0;
		var frm = document.getElementById("form1");
		for (i=0;i<frm.elements.length;i++){
				if((frm.elements[i].name).indexOf('cod_hoja_ruta')!=-1){
					if(frm.elements[i].type =='checkbox'){
						if(frm.elements[i].checked){
							totalDeudaSeleccionados=redond(totalDeudaSeleccionados,2)+redond(replaceAll(frm.elements[i+2].value,",",""),2);
					}
								
					}
				}

			}
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('cod_orden_trabajo')!=-1){
					if(frm.elements[i].type =='checkbox'){
					if(frm.elements[i].checked){
					totalDeudaSeleccionados=redond(totalDeudaSeleccionados,2)+redond(replaceAll(frm.elements[i+2].value,",",""),2);
					}

								
					}
				}

			}
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('cod_salida')!=-1){
					if(frm.elements[i].type =='checkbox'){
					if(frm.elements[i].checked){
						totalDeudaSeleccionados=redond(totalDeudaSeleccionados,2)+redond(replaceAll(frm.elements[i+2].value,",",""),2);
					}
								
					}
				}

			}	
			document.getElementById('id_totalDeudaSeleccionados').innerHTML=totalDeudaSeleccionados;	
}



	

function validaFloat(dat){
	var er_num=/^([0-9])*[.]?[0-9]*$/;
	var valido;
	if(dat.value != ""){
		if(!er_num.test(dat.value)){
			alert('Contenido del campo no válido');
			dat.value=0;
			dat.focus();
			valido=false;
		}
	}
	 
	calcularTotalPago();
	return true;
	
}
function validaFloat2(dat){
	var er_num=/^([0-9])*[.]?[0-9]*$/;
	var valido;
	if(dat.value != ""){
		if(!er_num.test(dat.value)){
			alert('Contenido del campo no válido');
			dat.value=0;
			dat.focus();
			valido=false;
		}
	}
	 
	sumarMontosPagar();
	return true;
	
}
function sumarMontosPagar(){
var montos=0;
		var frm = document.getElementById("form1");
		for (i=0;i<frm.elements.length;i++){
				if((frm.elements[i].name).indexOf('cod_hoja_ruta')!=-1){
					if(frm.elements[i].type =='checkbox'){
						if(frm.elements[i].checked){
							//montos=(montos*1)+(frm.elements[i+3].value*1);
							montos=redond(montos,2)+redond(replaceAll(frm.elements[i+3].value,",",""),2);	
					}
								
					}
				}

			}
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('cod_orden_trabajo')!=-1){
					if(frm.elements[i].type =='checkbox'){
					if(frm.elements[i].checked){
					montos=redond(montos,2)+redond(replaceAll(frm.elements[i+3].value,",",""),2);	
					}

								
					}
				}

			}
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('cod_salida')!=-1){
					if(frm.elements[i].type =='checkbox'){
					if(frm.elements[i].checked){
						montos=redond(montos,2)+redond(replaceAll(frm.elements[i+3].value,",",""),2);	
					}
								
					}
				}

			}	
			document.getElementById('id_montoDocBs').innerHTML=montos;	
}

function calcularTotalPago(){

		var frm = document.getElementById("form1");
		totalPagoClienteBs=0;
		var totalPagoBs=0;
		var monto=0;

		
		for(i=1;i<=num;i++){
		
		if(document.getElementById('monto_pago_detalle'+i)){
		monto=0;
			if(document.getElementById('cod_moneda'+i).value==1){
			 	monto=document.getElementById('monto_pago_detalle'+i).value;
			 }
			if(document.getElementById('cod_moneda'+i).value==2){
			 	monto=document.getElementById('monto_pago_detalle'+i).value*document.getElementById('cambio_bs').value;
			 }			 
			totalPagoBs=parseFloat(totalPagoBs)+parseFloat(monto);
		}
	}
	

			totalPagoClienteBs=(totalPagoBs*1);
			document.getElementById('id_totalPagoClienteBs').innerHTML=(totalPagoBs*1);
	
	
}
function distribuirDinero(){
var frm = document.getElementById("form1");

var saldo=totalPagoClienteBs;

var montoDocBs=0;
			for (i=0;i<frm.elements.length;i++){
				if((frm.elements[i].name).indexOf('cod_hoja_ruta')!=-1){
				
				if(frm.elements[i].type =='checkbox'){
							if((frm.elements[i].checked) && (redond(saldo,2))>0){	
								deudaItem=replaceAll(frm.elements[i+2].value,",","");
								if(redond(saldo,2)>=redond(deudaItem,2)){
									frm.elements[i+3].value=redond(deudaItem,2);
									saldo=redond(saldo,2)-redond(deudaItem,2);									
									montoDocBs=redond(montoDocBs,2)+redond(frm.elements[i+3].value,2);	
								}else{
									frm.elements[i+3].value=redond(saldo,2);
									montoDocBs=redond(montoDocBs,2)+redond(frm.elements[i+3].value,2);	
									saldo=0;
								}
								
							}else{
								frm.elements[i+3].value=0;
								montoDocBs=redond(montoDocBs,2)+redond(frm.elements[i+3].value,2);	
							}	
											
					}	
				}

			}
for (i=0;i<frm.elements.length;i++){
				if((frm.elements[i].name).indexOf('cod_orden_trabajo')!=-1){
				
				if(frm.elements[i].type =='checkbox'){
							if((frm.elements[i].checked) && (redond(saldo,2))>0){	
								deudaItem=replaceAll(frm.elements[i+2].value,",","");
								if(redond(saldo,2)>=redond(deudaItem,2)){
									frm.elements[i+3].value=redond(deudaItem,2);
									saldo=redond(saldo,2)-redond(deudaItem,2);									
									montoDocBs=redond(montoDocBs,2)+redond(frm.elements[i+3].value,2);	
								}else{
									frm.elements[i+3].value=redond(saldo,2);
									montoDocBs=redond(montoDocBs,2)+redond(frm.elements[i+3].value,2);	
									saldo=0;
								}
								
							}else{
								frm.elements[i+3].value=0;
								montoDocBs=redond(montoDocBs,2)+redond(frm.elements[i+3].value,2);	
							}	
													
					}	
				}

			}	
for (i=0;i<frm.elements.length;i++){
				if((frm.elements[i].name).indexOf('cod_salida')!=-1){
				
				if(frm.elements[i].type =='checkbox'){
				if((frm.elements[i].checked) && (redond(saldo,2))>0){	
								deudaItem=replaceAll(frm.elements[i+2].value,",","");
								if(redond(saldo,2)>=redond(deudaItem,2)){
									frm.elements[i+3].value=redond(deudaItem,2);
									saldo=redond(saldo,2)-redond(deudaItem,2);									
									montoDocBs=redond(montoDocBs,2)+redond(frm.elements[i+3].value,2);	
								}else{
									frm.elements[i+3].value=redond(saldo,2);
									montoDocBs=redond(montoDocBs,2)+redond(frm.elements[i+3].value,2);	
									saldo=0;
								}
								
							}else{
								frm.elements[i+3].value=0;
								montoDocBs=redond(montoDocBs,2)+redond(frm.elements[i+3].value,2);	
							}						
					}	
				}

			}		
		document.getElementById('id_montoDocBs').innerHTML=(montoDocBs*1);					
}
function guardar(f){
//alert("ingresooooooo1");
		var frm = document.getElementById("form1");
		var totalAuxiliar=0;
		
			var sw=1;
			if(document.getElementById("cod_cuenta").value==null ||  document.getElementById("cod_cuenta").value=='' ){
						 sw=0;
				alert("Para realizar el Pago el Cliente debe tener un Nro. de Cuenta");	
			
			}
			if(document.getElementById("cambio_bs").value==null ||  document.getElementById("cambio_bs").value=='' ){
						 sw=0;
				alert("Para realizar el Pago se debe contar con el Cambio de Dolar del dia Hoy.");	
			
			}	
			for (i=0;i<frm.elements.length;i++){

				if(frm.elements[i].type =='checkbox'){

					if( ((frm.elements[i].name).indexOf('cod_hoja_ruta')!=-1) || ((frm.elements[i].name).indexOf('cod_orden_trabajo')!=-1) || ((frm.elements[i].name).indexOf('cod_salida')!=-1)){	
						if((frm.elements[i].checked)){	
							//alert("gabriela");	
							if((frm.elements[i+3].value*1)<=0){								
								alert("Los montos a cancelar no pueden ser menor o iguales a 0");
								sw=0;
								break;
							}
							if((frm.elements[i+3].value*1)>(frm.elements[i+2].value*1)){								
								alert("Los montos a cancelar no puede ser mayor al saldo");
								sw=0;
								break;
							}	
							totalAuxiliar=(totalAuxiliar*1)+(frm.elements[i+3].value*1);																																			
						}
					}

				}	
		}	
		//alert("ingresooooooo3"+totalAuxiliar);
		document.getElementById("total_bs").value=(totalAuxiliar*1);
		//alert("ingresooooooo4"+document.getElementById("total_bs").value);
		document.getElementById("num").value=num;
//alert("ingresooooooo5");
	//	alert("total_bs"+document.getElementById("total_bs").value);
			if((totalAuxiliar*1)!=(totalPagoClienteBs*1)){
			 sw=0;
				alert("El Monto Total de los Documentos que quiere cancelar no coincide con la Cantidad Cancelada");				
			}

			
			if(sw==1){
				frm.submit();
			}

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
	
	function habilitaOpcionesPago(numero){
	//alert("gabriela"+numero);
	var div_cod_banco;
		div_cod_banco=document.getElementById("div_cod_banco"+numero);			
		ajax=nuevoAjax();
		ajax.open("GET","ajaxHabilitaBanco.php?numero="+numero+"&codFormaPago="+document.getElementById("cod_forma_pago"+numero).value,true);
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
				div_cod_banco.innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null);
		
	var div_nro_cheque;
		div_nro_cheque=document.getElementById("div_nro_cheque"+numero);			
		ajax8=nuevoAjax();
		ajax8.open("GET","ajaxHabilitaCheque.php?numero="+numero+"&codFormaPago="+document.getElementById("cod_forma_pago"+numero).value,true);
		ajax8.onreadystatechange=function(){
			if (ajax8.readyState==4) {
				div_nro_cheque.innerHTML=ajax8.responseText;
		    }
	    }		
		ajax8.send(null);
	var div_nro_cuenta;
		div_nro_cuenta=document.getElementById("div_nro_cuenta"+numero);			
		ajax9=nuevoAjax();
		ajax9.open("GET","ajaxHabilitaCuenta.php?numero="+numero+"&codFormaPago="+document.getElementById("cod_forma_pago"+numero).value,true);
		ajax9.onreadystatechange=function(){
			if (ajax9.readyState==4) {
				div_nro_cuenta.innerHTML=ajax9.responseText;
		    }
	    }		
		ajax9.send(null);	
			
	var div_cod_cuenta;
		div_cod_cuenta=document.getElementById("div_cod_cuenta"+numero);			
		ajax7=nuevoAjax();
		ajax7.open("GET","ajaxHabilitaCodCuenta.php?numero="+numero+"&codFormaPago="+document.getElementById("cod_forma_pago"+numero).value,true);
		ajax7.onreadystatechange=function(){
			if (ajax7.readyState==4) {
				div_cod_cuenta.innerHTML=ajax7.responseText;
		    }
	    }		
		ajax7.send(null);			
				
	}
num=0;
function mas(obj) {
	//alert("aquiii");
  		num++;
		fi = document.getElementById('fiel');
		contenedor = document.createElement('div');
		contenedor.id = 'div'+num;  
		fi.type="style";
		fi.appendChild(contenedor);
		var div_material;
		div_material=document.getElementById("div"+num);			
		ajax=nuevoAjax();
		ajax.open("GET","ajaxNewFormaPago.php?codigo="+num,true);
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
				div_material.innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null);
	}	
		
	function menos(numero) {


		 fi = document.getElementById('fiel');
  		 fi.removeChild(document.getElementById('div'+numero));
 		// num=parseInt(num)-1;
 		 calcularTotalPago();
	}
function buscarCuentaPago(numero){

		izquierda = (screen.width) ? (screen.width-600)/2 : 100;

	    arriba = (screen.height) ? (screen.height-400)/2 : 100;
	// alert("numero="+numero);
		
		url="ajax_listaCuentasPago.php?numero="+numero;

		opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=650,left='+izquierda+',top=' + arriba + '';

	   	window.open(url, 'popUp', opciones);
	

}
function setCuentas(cod_cuenta,desc_cuenta,numero){

	//	alert("ingresoooo setCuuentas"+cod_cuenta);
	//	alert("ingresoooo setCuuentas"+desc_cuenta);
	//	alert("ingresoooo setCuuentas"+numero);

	
	document.getElementById('cod_cuenta'+numero).value=cod_cuenta;
//alert("ingresoooo setCuuentas2");
	document.getElementById('nro_cuenta'+numero).value=desc_cuenta;
			
	}	
</script>
</head>
<body>
<form id="form1" name="form1" method="post" action="savePago2.php" >
<input type="hidden" name="total_bs" id="total_bs">
<input type="hidden" name="num" id="num">
<?php 
	require("conexion.inc");
	include("funciones.php");
	$cod_gestion=gestionActiva();
	
	$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion."'";
	$resp2= mysql_query($sql2);
	$gestion="";
	while($dat2=mysql_fetch_array($resp2)){
		$gestion=$dat2[0];
	}
	$sql="select max(nro_pago) from pagos where cod_gestion='".$cod_gestion."'";
	$nro_pago=obtenerCodigo($sql);

	$sql="select cambio_bs from tipo_cambio where fecha_tipo_cambio='".date('Y-m-d', time())."'";
	$resp= mysql_query($sql);
	$cambio_bs=0;
	while($dat=mysql_fetch_array($resp)){
		$cambio_bs=$dat['cambio_bs'];
	}
	

?>
<input type="hidden" id="cambio_bs" name="cambio_bs" value="<?php echo $cambio_bs;?>">
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">REGISTRO DE PAGO</h3>
<h3 align="center" style="background:#FFF;font-size: 12px;color: #E78611;font-weight:bold;"> No. <?php echo $nro_pago;?>/<?php echo $gestion;?></h3>
<table align="center" border="0">
<tr><td bgcolor="#E8D2FB">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td style="background:#FFF;font-size: 10px;color: #E78611;font-weight:bold;">Hojas Rutas con Incremento</td></tr>
<tr><td bgcolor="#FFCC00">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td style="background:#FFF;font-size: 10px;color: #E78611;font-weight:bold;">Hojas Rutas con Descuento</td></tr>

</table>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Introduzca Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Cliente</td>
      		<td>	
            	<select name="cod_cliente" id="cod_cliente" class="textoform" onChange="verDocumentos()" >
				<option value="0">Seleccione un Opci&oacute;n</option>
				<?php
					
				$sql2=" select clientes.cod_cliente, clientes.nombre_cliente,cuentas.nro_cuenta ";
				$sql2.=" from (select DISTINCT(c.cod_cliente)from hojas_rutas hr, cotizaciones c ";
				$sql2.=" where hr.cod_cotizacion=c.cod_cotizacion and hr.cod_estado_hoja_ruta<>2 and hr.cod_estado_pago_doc<>3";
				$sql2.=" UNION ";
				$sql2.=" select DISTINCT(cod_cliente) from ordentrabajo where cod_est_ot<>2 and ";
				$sql2.=" cod_estado_pago_doc<>3 ";
				$sql2.=" UNION ";
				$sql2.=" select DISTINCT(cod_cliente_venta) from salidas where cod_tipo_salida=1";
				$sql2.=" and cod_estado_salida=1 and cod_estado_pago_doc<>3) as clientesDeudores INNER JOIN clientes ";
				$sql2.="  on(clientesDeudores.cod_cliente=clientes.cod_cliente) ";
				$sql2.="  left join cuentas on(clientes.cod_cuenta=cuentas.cod_cuenta) ";
				$sql2.=" order by clientes.nombre_cliente asc ";

				$resp2=mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2))
				{
							$cod_cliente=$dat2['cod_cliente'];	
			  		 		$nombre_cliente=$dat2['nombre_cliente'];	
							$nro_cuenta=$dat2['nro_cuenta'];	
				 ?>
                 <option value="<?php echo $cod_cliente;?>"><?php echo $nombre_cliente." (Nro. Cta. ".$nro_cuenta.")";?></option>				
				<?php		
				 }
				?>						
			</select></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha Pago</td>
      		<td>
            <input type="text"name="fecha_pago" id="fecha_pago" class="textoform" size="40" value="<?php echo date("d/m/Y");?>">
</td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
      		<td><textarea name="obs_pago" id="obs_pago" class="textoform" rows="2" cols="60"></textarea></td>
    	</tr>		      
		</table>
<div id="resultados" >
        <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1">
          <tr class="titulo_tabla">
            <td align="center" height="20">&nbsp;</td>
            <td align="center" height="20">HR</td>
            <td align="center" height="20">Fecha HR</td> 
            <td align="center" height="20">Monto Bs</td> 
            <td align="center" height="20">A Cuenta Bs</td>
            <td align="center" height="20">Saldo Bs</td> 
            <td align="center" height="20">Forma de Pago</td>
            <td align="center" height="20">Banco</td>               
            <td align="center" height="20">Moneda</td>
            <td align="center" height="20">Nro Cuenta</td>
			<td align="center" height="20">Nro Cheque</td>            
            <td align="center" height="20">Monto Pago</td>
            <td align="center" height="20">Nro Comprobante</td>
            <td align="center" height="20">Fecha Comprobante</td>            
           </tr>
          <tr  bgcolor="#FFFFFF">
            <td align="center" colspan="14">DETALLE DE PAGOS</td>              
          </tr>          
        </table>            
</div>    

</form>

</body>
</html>
