
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml version="1.0" encoding="ISO-8859-1">
<head>
<meta http-equiv="Content-Type" content="application/json; text/html; charset=iso-8859-1" />
<title>INVENTA</title>
<link rel="stylesheet" type="text/css" href="pagina.css" />
<script type="text/javascript" src="ajax/searchAjax.js"></script>
<script type="text/javascript">

var totalDeudaSeleccionados=0;
var totalPagoProveedorBs=0;
function verDocumentos(){
		resultados_ajax('ajaxDetallePagoProv.php?cod_proveedor='+document.getElementById("cod_proveedor").value);	

}



function checkearRegistros(){
totalDeudaSeleccionados=0;

		var frm = document.getElementById("form1");
		
		
		if(document.getElementById("seleccionarTodo").checked){
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('cod_ingreso')!=-1){
					if(frm.elements[i].type =='checkbox'){
					totalDeudaSeleccionados=(totalDeudaSeleccionados*1)+(frm.elements[i+3].value*1);
						frm.elements[i].checked=true;
						frm.elements[i+3].disabled=false;
								
					}
				}

			}
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('cod_gasto_gral')!=-1){
					if(frm.elements[i].type =='checkbox'){
					totalDeudaSeleccionados=(totalDeudaSeleccionados*1)+(frm.elements[i+3].value*1);
						frm.elements[i].checked=true;
						frm.elements[i+3].disabled=false;
								
					}
				}

			}
			
				
		}else{
			totalDeudaSeleccionados=0;
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('cod_ingreso')!=-1){
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
				if((frm.elements[i].name).indexOf('cod_gasto_gral')!=-1){
					if(frm.elements[i].type =='checkbox'){
						frm.elements[i].checked=false;
						frm.elements[i+3].disabled=true;										
						
						
					}
				}

			}					
		}
document.getElementById('id_totalDeudaSeleccionados').innerHTML=totalDeudaSeleccionados;
	sumarSeleccionados();
	distribuirDinero();
}

function habilitarFilaIngreso(codigo){

	if(document.getElementById("cod_ingreso"+codigo).checked){

		document.getElementById("monto_pago_ingreso"+codigo).disabled=false;

	}else{

		document.getElementById("monto_pago_ingreso"+codigo).disabled=true;

	}
			sumarSeleccionados();
	distribuirDinero();
}


function habilitarFilaGastoGral(codigo){

	if(document.getElementById("cod_gasto_gral"+codigo).checked){

		document.getElementById("monto_pago_gasto_gral"+codigo).disabled=false;

	}else{

		document.getElementById("monto_pago_gasto_gral"+codigo).disabled=true;


	}
	sumarSeleccionados();
	distribuirDinero();
}
function sumarSeleccionados(){
totalDeudaSeleccionados=0;
		var frm = document.getElementById("form1");
		for (i=0;i<frm.elements.length;i++){
				if((frm.elements[i].name).indexOf('cod_ingreso')!=-1){
					if(frm.elements[i].type =='checkbox'){
						if(frm.elements[i].checked){
							totalDeudaSeleccionados=(((totalDeudaSeleccionados*1)+(frm.elements[i+2].value*1))*1);
						//	alert (totalDeudaSeleccionados);
					}
								
					}
				}

			}
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('cod_gasto_gral')!=-1){
					if(frm.elements[i].type =='checkbox'){
					if(frm.elements[i].checked){
				totalDeudaSeleccionados=(totalDeudaSeleccionados*1)+(frm.elements[i+2].value*1);
				//	alert((frm.elements[i+2].value*1));
					//aux=(frm.elements[i+2].value)*1;
					//	totalDeudaSeleccionados=(totalDeudaSeleccionados)+(aux);
						//totalDeudaSeleccionados=totalDeudaSeleccionados*1;
						//	alert (totalDeudaSeleccionados);					
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
							montos=(montos*1)+(frm.elements[i+3].value*1);
					}
								
					}
				}

			}
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('cod_orden_trabajo')!=-1){
					if(frm.elements[i].type =='checkbox'){
					if(frm.elements[i].checked){
					montos=(montos*1)+(frm.elements[i+3].value*1);
					}

								
					}
				}

			}
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('cod_salida')!=-1){
					if(frm.elements[i].type =='checkbox'){
					if(frm.elements[i].checked){
						montos=(montos*1)+(frm.elements[i+3].value*1);
					}
								
					}
				}

			}	
			document.getElementById('id_montoDocBs').innerHTML=montos*1;	
}

function calcularTotalPago(){
		var frm = document.getElementById("form1");
		totalPagoProveedorBs=0;
		var totalPagoBs=0;
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('montoPagoBs')!=-1){					
					totalPagoBs=(totalPagoBs*1)+(frm.elements[i].value*1);								
				}

			}
			document.getElementById('id_totalBs').innerHTML=(totalPagoBs*1);
			
		var totalPagoBsSus=0;
		var totalPagoSus=0;
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('montoPagoSus')!=-1){					
					totalPagoSus=(totalPagoSus*1)+(frm.elements[i].value*1);								
					totalPagoBsSus=(totalPagoBsSus*1)+((frm.elements[i].value*1)*(document.getElementById('cambio_bs').value));								
				}

			}
			document.getElementById('id_totalSus').innerHTML=(totalPagoSus*1);
			document.getElementById('id_totalBsSus').innerHTML=(totalPagoBsSus*1);
			totalPagoProveedorBs=(totalPagoBs*1)+(totalPagoBsSus*1);
			document.getElementById('id_totalPagoProveedorBs').innerHTML=(totalPagoBs*1)+(totalPagoBsSus*1);
			//distribuirDinero();
	
}
function distribuirDinero(){
var frm = document.getElementById("form1");
var saldo=totalPagoProveedorBs;
var montoDocBs=0;
			for (i=0;i<frm.elements.length;i++){
				if((frm.elements[i].name).indexOf('cod_ingreso')!=-1){
				
				if(frm.elements[i].type =='checkbox'){
							if((frm.elements[i].checked) && (saldo*1)>0){	
								if(saldo>=(frm.elements[i+2].value*1)){
									saldo=(saldo*1)-(frm.elements[i+2].value*1);
									frm.elements[i+3].value=frm.elements[i+2].value;
									montoDocBs=(montoDocBs*1)+(frm.elements[i+3].value*1);	
								}else{
									frm.elements[i+3].value=saldo;
									montoDocBs=(montoDocBs*1)+(frm.elements[i+3].value*1);	
									saldo=0;
								}
								
							}else{
								frm.elements[i+3].value=0;
								montoDocBs=(montoDocBs*1)+(frm.elements[i+3].value*1);	
							}	
											
					}	
				}

			}
for (i=0;i<frm.elements.length;i++){
				if((frm.elements[i].name).indexOf('cod_gasto_gral')!=-1){
				
				if(frm.elements[i].type =='checkbox'){
							if((frm.elements[i].checked) && (saldo*1)>0){	
								if(saldo>=(frm.elements[i+2].value*1)){
									saldo=(saldo*1)-(frm.elements[i+2].value*1);
									frm.elements[i+3].value=frm.elements[i+2].value;
									montoDocBs=(montoDocBs*1)+(frm.elements[i+3].value*1);	
								}else{
									frm.elements[i+3].value=saldo;
									montoDocBs=(montoDocBs*1)+(frm.elements[i+3].value*1);	
									saldo=0;
								}
								
							}else{
								frm.elements[i+3].value=0;
								montoDocBs=(montoDocBs*1)+(frm.elements[i+3].value*1);	
							}	
													
					}	
				}

			}	
	
		document.getElementById('id_montoDocBs').innerHTML=(montoDocBs*1);					
}
function guardar(f){

		var frm = document.getElementById("form1");
		var totalAuxiliar=0;
		
			var sw=1;
			/*if(document.getElementById("cod_cuenta").value==null ||  document.getElementById("cod_cuenta").value=='' ){
						 sw=0;
				alert("Para realizar el Pago el Cliente debe tener un Nro. de Cuenta");	
			
			}*/
			if(document.getElementById("cambio_bs").value==null ||  document.getElementById("cambio_bs").value=='' ){
						 sw=0;
				alert("Para realizar el Pago se debe contar con el Cambio de Dolar del dia Hoy.");	
			
			}	
			for (i=0;i<frm.elements.length;i++){

				if(frm.elements[i].type =='checkbox'){

					if( ((frm.elements[i].name).indexOf('cod_ingreso')!=-1) || ((frm.elements[i].name).indexOf('cod_gasto_gral')!=-1)){	
						if((frm.elements[i].checked)){		
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
		document.getElementById("total_bs").value=(totalAuxiliar*1);
		//alert("total_bs"+document.getElementById("total_bs").value);
			if((totalAuxiliar*1)!=(totalPagoProveedorBs*1)){
			 sw=0;
				alert("El Monto Total de los Documentos que quiere cancelar no coincide con la Cantidad Cancelada");				
			}

			
			if(sw==1){
				frm.submit();
			}

}
</script>
</head>
<body bgcolor="#FFFFFF">
<form id="form1" name="form1" method="post" action="savePagoProveedor.php" >
<input type="hidden" name="total_bs" id="total_bs">
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
	$sql="select max(nro_pago_prov) from pago_proveedor where cod_gestion='".$cod_gestion."'";
	$nro_pago_prov=obtenerCodigo($sql);

	$sql="select cambio_bs from tipo_cambio where fecha_tipo_cambio='".date('Y-m-d', time())."'";
	$resp= mysql_query($sql);
	$cambio_bs=0;
	while($dat=mysql_fetch_array($resp)){
		$cambio_bs=$dat['cambio_bs'];
	}
	

?>
<input type="hidden" id="cambio_bs" name="cambio_bs" value="<?php echo $cambio_bs;?>">
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">REGISTRO DE PAGO PROVEEDOR </h3>
<h3 align="center" style="background:#FFF;font-size: 12px;color: #E78611;font-weight:bold;"> No. <?php echo $nro_pago_prov;?>/<?php echo $gestion;?></h3>
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
     		<td>Proveedor</td>
      		<td>	
            	<select name="cod_proveedor" id="cod_proveedor" class="textoform" onChange="verDocumentos()" >
				<option value="0">Seleccione un Opci&oacute;n</option>
				<?php
					
				$sql2=" select proveedores.cod_proveedor, proveedores.nombre_proveedor,cuentas.nro_cuenta ";
				$sql2.=" from (select DISTINCT(cod_proveedor)from ingresos ";
				$sql2.=" where  cod_estado_ingreso<>2 and cod_estado_pago_doc<>3 ";
				$sql2.=" UNION ";
				$sql2.=" select DISTINCT(cod_proveedor) from  gastos_gral where cod_estado_pago_doc<>3 and cod_estado<>2";
				$sql2.=" ) ";
				$sql2.="  as proveedoresPago INNER JOIN proveedores ";
				$sql2.=" on(proveedoresPago.cod_proveedor=proveedores.cod_proveedor) ";
				$sql2.=" left join cuentas on(proveedores.cod_cuenta=cuentas.cod_cuenta) ";
				$sql2.=" order by proveedores.nombre_proveedor asc ";

				$resp2=mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2))
				{
							$cod_proveedor=$dat2['cod_proveedor'];	
			  		 		$nombre_proveedor=$dat2['nombre_proveedor'];	
							$nro_cuenta=$dat2['nro_cuenta'];	
				 ?>
                 <option value="<?php echo $cod_proveedor;?>"><?php echo $nombre_proveedor." (Nro. Cta. ".$nro_cuenta.")";?></option>				
				<?php		
				 }
				?>						
			</select></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha Pago</td>
      		<td>
            <input type="text"name="fecha_pago_prov" id="fecha_pago_prov" class="textoform" size="40" value="<?php echo date("d/m/Y");?>">
</td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
      		<td><textarea name="obs_pago_prov" id="obs_pago_prov" class="textoform" rows="2" cols="60"></textarea></td>
    	</tr>		      
		</table>
<div id="resultados" >
        <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1">
          <tr class="titulo_tabla">
            <td align="center" height="20">Tipo Doc.</td>
            <td align="center" height="20">Nro Doc.</td>
            <td align="center" height="20">Fecha Doc.</td> 
            <td align="center" height="20">Monto Bs</td> 
            <td align="center" height="20">A Cuenta Bs</td>
            <td align="center" height="20">Saldo Bs</td>             
            <td align="center" height="20">Monto Pago</td>         
           </tr>
          <tr  bgcolor="#FFFFFF">
            <td align="center" colspan="7">DETALLE DE PAGOS</td>              
          </tr>          
        </table>            
</div>    

</form>

</body>
</html>
