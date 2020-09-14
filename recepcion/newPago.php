
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml version="1.0" encoding="ISO-8859-1">
<head>
<meta http-equiv="Content-Type" content="application/json; text/html; charset=iso-8859-1" />
<title>INVENTA</title>
<link rel="stylesheet" type="text/css" href="pagina.css" />
<script type="text/javascript" src="ajax/searchAjax.js"></script>
<script type="text/javascript">



function verDocumentos(){
		resultados_ajax('ajaxDetallePago.php?cod_cliente='+document.getElementById("cod_cliente").value);	

}



function checkearRegistros(){

		var frm = document.getElementById("form1");
		
		if(document.getElementById("seleccionarTodo").checked){
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('cod_hoja_ruta')!=-1){
					if(frm.elements[i].type =='checkbox'){
						frm.elements[i].checked=true;
						frm.elements[i+3].disabled=false;
						frm.elements[i+5].disabled=false;
						frm.elements[i+8].disabled=false;
						frm.elements[i+9].disabled=false;
						frm.elements[i+10].disabled=false;
								
					}
				}

			}
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('cod_orden_trabajo')!=-1){
					if(frm.elements[i].type =='checkbox'){
						frm.elements[i].checked=true;
						frm.elements[i+3].disabled=false;
						frm.elements[i+5].disabled=false;
						frm.elements[i+8].disabled=false;
						frm.elements[i+9].disabled=false;
						frm.elements[i+10].disabled=false;
								
					}
				}

			}
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('cod_salida')!=-1){
					if(frm.elements[i].type =='checkbox'){
						frm.elements[i].checked=true;
						frm.elements[i+3].disabled=false;
						frm.elements[i+5].disabled=false;
						frm.elements[i+8].disabled=false;
						frm.elements[i+9].disabled=false;
						frm.elements[i+10].disabled=false;
								
					}
				}

			}			
				
		}else{
			////////////////////////////////
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('cod_hoja_ruta')!=-1){
					if(frm.elements[i].type =='checkbox'){
						frm.elements[i].checked=false;
						frm.elements[i+3].value=1;
						frm.elements[i+3].disabled=true;
						frm.elements[i+4].value=1;
						frm.elements[i+4].disabled=true;
						frm.elements[i+5].value=1;
						frm.elements[i+5].disabled=true;	
						frm.elements[i+6].disabled=true;
						frm.elements[i+7].disabled=true;
						frm.elements[i+8].disabled=true;
						frm.elements[i+9].value="";
						frm.elements[i+9].disabled=true;
						frm.elements[i+10].disabled=true;												
						
						
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
						frm.elements[i+3].value=1;
						frm.elements[i+3].disabled=true;
						frm.elements[i+4].value=1;
						frm.elements[i+4].disabled=true;
						frm.elements[i+5].value=1;
						frm.elements[i+5].disabled=true;	
						frm.elements[i+6].disabled=true;
						frm.elements[i+7].disabled=true;
						frm.elements[i+8].disabled=true;
						frm.elements[i+9].value="";
						frm.elements[i+9].disabled=true;
						frm.elements[i+10].disabled=true;												
						
						
					}
				}

			}
			///////////////////////////////////
			for (i=0;i<frm.elements.length;i++)
			{
				if((frm.elements[i].name).indexOf('cod_salida')!=-1){
					if(frm.elements[i].type =='checkbox'){
						frm.elements[i].checked=false;
						frm.elements[i+3].value=1;
						frm.elements[i+3].disabled=true;
						frm.elements[i+4].value=1;
						frm.elements[i+4].disabled=true;
						frm.elements[i+5].value=1;
						frm.elements[i+5].disabled=true;	
						frm.elements[i+6].disabled=true;
						frm.elements[i+7].disabled=true;
						frm.elements[i+8].disabled=true;
						frm.elements[i+9].value="";
						frm.elements[i+9].disabled=true;
						frm.elements[i+10].disabled=true;												
						
						
					}
				}

			}			
		}

}

function habilitarCampos(codigo){

	if(document.getElementById("cod_forma_pago_hr"+codigo).value==1){
		
		document.getElementById("cod_moneda_hr"+codigo).disabled=false;
		document.getElementById("monto_pago_hr"+codigo).disabled=false;
		document.getElementById("cod_banco_hr"+codigo).disabled=true;
		document.getElementById("nro_cheque_hr"+codigo).disabled=true;
		document.getElementById("nro_cuenta_hr"+codigo).disabled=true;
	}
	if(document.getElementById("cod_forma_pago_hr"+codigo).value==2){
		document.getElementById("cod_banco_hr"+codigo).disabled=false;
		document.getElementById("cod_moneda_hr"+codigo).disabled=false;
		document.getElementById("nro_cheque_hr"+codigo).disabled=false;
		document.getElementById("monto_pago_hr"+codigo).disabled=false;
		document.getElementById("nro_cuenta_hr"+codigo).value="";
		document.getElementById("nro_cuenta_hr"+codigo).disabled=true;
	}	
	
	if(document.getElementById("cod_forma_pago_hr"+codigo).value==3){
		document.getElementById("cod_banco_hr"+codigo).disabled=false;
		document.getElementById("cod_moneda_hr"+codigo).disabled=false;
		document.getElementById("monto_pago_hr"+codigo).disabled=false;
		document.getElementById("nro_cuenta_hr"+codigo).disabled=false;
		document.getElementById("nro_cheque_hr"+codigo).value="";
		document.getElementById("nro_cheque_hr"+codigo).disabled=true;
	}
}

function habilitarCamposOT(codigo){

	if(document.getElementById("cod_forma_pago_ot"+codigo).value==1){
		
		document.getElementById("cod_moneda_ot"+codigo).disabled=false;
		document.getElementById("monto_pago_ot"+codigo).disabled=false;
		document.getElementById("cod_banco_ot"+codigo).disabled=true;
		document.getElementById("nro_cheque_ot"+codigo).disabled=true;
		document.getElementById("nro_cuenta_ot"+codigo).disabled=true;
	}
	if(document.getElementById("cod_forma_pago_ot"+codigo).value==2){
		document.getElementById("cod_banco_ot"+codigo).disabled=false;
		document.getElementById("cod_moneda_ot"+codigo).disabled=false;
		document.getElementById("nro_cheque_ot"+codigo).disabled=false;
		document.getElementById("monto_pago_ot"+codigo).disabled=false;
		document.getElementById("nro_cuenta_ot"+codigo).value="";
		document.getElementById("nro_cuenta_ot"+codigo).disabled=true;
	}	
	
	if(document.getElementById("cod_forma_pago_ot"+codigo).value==3){
		document.getElementById("cod_banco_ot"+codigo).disabled=false;
		document.getElementById("cod_moneda_ot"+codigo).disabled=false;
		document.getElementById("monto_pago_ot"+codigo).disabled=false;
		document.getElementById("nro_cuenta_ot"+codigo).disabled=false;
		document.getElementById("nro_cheque_ot"+codigo).value="";
		document.getElementById("nro_cheque_ot"+codigo).disabled=true;
	}
}
function habilitarCamposVenta(codigo){

	if(document.getElementById("cod_forma_pago_venta"+codigo).value==1){
		
		document.getElementById("cod_moneda_venta"+codigo).disabled=false;
		document.getElementById("monto_pago_venta"+codigo).disabled=false;
		document.getElementById("cod_banco_venta"+codigo).disabled=true;
		document.getElementById("nro_cheque_venta"+codigo).disabled=true;
		document.getElementById("nro_cuenta_venta"+codigo).disabled=true;
	}
	if(document.getElementById("cod_forma_pago_venta"+codigo).value==2){
		document.getElementById("cod_banco_venta"+codigo).disabled=false;
		document.getElementById("cod_moneda_venta"+codigo).disabled=false;
		document.getElementById("nro_cheque_venta"+codigo).disabled=false;
		document.getElementById("monto_pago_venta"+codigo).disabled=false;
		document.getElementById("nro_cuenta_venta"+codigo).value="";
		document.getElementById("nro_cuenta_venta"+codigo).disabled=true;
	}	
	
	if(document.getElementById("cod_forma_pago_venta"+codigo).value==3){
		document.getElementById("cod_banco_venta"+codigo).disabled=false;
		document.getElementById("cod_moneda_venta"+codigo).disabled=false;
		document.getElementById("monto_pago_venta"+codigo).disabled=false;
		document.getElementById("nro_cuenta_venta"+codigo).disabled=false;
		document.getElementById("nro_cheque_venta"+codigo).value="";
		document.getElementById("nro_cheque_venta"+codigo).disabled=true;
	}
}
function habilitarFilaVenta(codigo){

	if(document.getElementById("cod_salida"+codigo).checked){
		document.getElementById("cod_forma_pago_venta"+codigo).disabled=false;
		document.getElementById("cod_moneda_venta"+codigo).disabled=false;
		document.getElementById("monto_pago_venta"+codigo).disabled=false;
		document.getElementById("cod_banco_venta"+codigo).disabled=true;
		document.getElementById("nro_cheque_venta"+codigo).disabled=true;
		document.getElementById("nro_cuenta_venta"+codigo).disabled=true;
		document.getElementById("nro_comprobante_venta"+codigo).disabled=false;
		document.getElementById("fecha_comprobante_venta"+codigo).disabled=false;
	}else{
		document.getElementById("cod_forma_pago_venta"+codigo).value=1;
		document.getElementById("cod_forma_pago_venta"+codigo).disabled=true;
		document.getElementById("cod_moneda_venta"+codigo).value=1;
		document.getElementById("cod_moneda_venta"+codigo).disabled=true;
		document.getElementById("monto_pago_venta"+codigo).disabled=true;
		document.getElementById("cod_banco_venta"+codigo).disabled=true;
		document.getElementById("nro_cheque_venta"+codigo).disabled=true;
		document.getElementById("nro_cuenta_venta"+codigo).disabled=true;
		document.getElementById("nro_comprobante_venta"+codigo).value="";
		document.getElementById("nro_comprobante_venta"+codigo).disabled=true;
		document.getElementById("fecha_comprobante_venta"+codigo).disabled=true;
	}
}
function habilitarFilaOrdenTrabajo(codigo){

	if(document.getElementById("cod_orden_trabajo"+codigo).checked){
		document.getElementById("cod_forma_pago_ot"+codigo).disabled=false;
		document.getElementById("cod_moneda_ot"+codigo).disabled=false;
		document.getElementById("monto_pago_ot"+codigo).disabled=false;
		document.getElementById("cod_banco_ot"+codigo).disabled=true;
		document.getElementById("nro_cheque_ot"+codigo).disabled=true;
		document.getElementById("nro_cuenta_ot"+codigo).disabled=true;
		document.getElementById("nro_comprobante_ot"+codigo).disabled=false;
		document.getElementById("fecha_comprobante_ot"+codigo).disabled=false;
	}else{
		document.getElementById("cod_forma_pago_ot"+codigo).value=1;
		document.getElementById("cod_forma_pago_ot"+codigo).disabled=true;
		document.getElementById("cod_moneda_ot"+codigo).value=1;
		document.getElementById("cod_moneda_ot"+codigo).disabled=true;
		document.getElementById("monto_pago_ot"+codigo).disabled=true;
		document.getElementById("cod_banco_ot"+codigo).disabled=true;
		document.getElementById("nro_cheque_ot"+codigo).disabled=true;
		document.getElementById("nro_cuenta_ot"+codigo).disabled=true;
		document.getElementById("nro_comprobante_ot"+codigo).value="";
		document.getElementById("nro_comprobante_ot"+codigo).disabled=true;
		document.getElementById("fecha_comprobante_ot"+codigo).disabled=true;
	}
}


function habilitarFilaHojaRuta(codigo){

	if(document.getElementById("cod_hoja_ruta"+codigo).checked){
		document.getElementById("cod_forma_pago_hr"+codigo).disabled=false;
		document.getElementById("cod_moneda_hr"+codigo).disabled=false;
		document.getElementById("monto_pago_hr"+codigo).disabled=false;
		document.getElementById("cod_banco_hr"+codigo).disabled=true;
		document.getElementById("nro_cheque_hr"+codigo).disabled=true;
		document.getElementById("nro_cuenta_hr"+codigo).disabled=true;
		document.getElementById("nro_comprobante_hr"+codigo).disabled=false;
		document.getElementById("fecha_comprobante_hr"+codigo).disabled=false;
	}else{
		document.getElementById("cod_forma_pago_hr"+codigo).value=1;
		document.getElementById("cod_forma_pago_hr"+codigo).disabled=true;
		document.getElementById("cod_moneda_hr"+codigo).value=1;
		document.getElementById("cod_moneda_hr"+codigo).disabled=true;
		document.getElementById("monto_pago_hr"+codigo).disabled=true;
		document.getElementById("cod_banco_hr"+codigo).disabled=true;
		document.getElementById("nro_cheque_hr"+codigo).disabled=true;
		document.getElementById("nro_cuenta_hr"+codigo).disabled=true;
		document.getElementById("nro_comprobante_hr"+codigo).value="";
		document.getElementById("nro_comprobante_hr"+codigo).disabled=true;
		document.getElementById("fecha_comprobante_hr"+codigo).disabled=true;
	}
}
function repetirFormaPago(){

	var frm = document.getElementById("form1");
	var sw=0;
	var valor=0;

			for (i=0;i<frm.elements.length;i++){

				
				if((frm.elements[i].name).indexOf('cod_forma_pago')!=-1){

						if(frm.elements[i-3].checked){

							if(sw==0){
								sw=1;
							    valor=frm.elements[i].value;
								if(valor==2){
									frm.elements[i+1].disabled=false;
									frm.elements[i+3].value="";
									frm.elements[i+3].disabled=true;
									frm.elements[i+4].disabled=false;
								}
								if(valor==3){
									frm.elements[i+1].disabled=false;
									frm.elements[i+3].disabled=false;
									frm.elements[i+4].value="";
									frm.elements[i+4].disabled=true;
								}								
								if(valor==1){
									frm.elements[i+3].value='';
									frm.elements[i+4].value='';
									frm.elements[i+1].disabled=true;
								}								
							}else{
								frm.elements[i].value=valor;
								if(valor==2){
									frm.elements[i+1].disabled=false;
									frm.elements[i+3].value="";
									frm.elements[i+3].disabled=true;
									frm.elements[i+4].disabled=false;
								}
								if(valor==3){
									frm.elements[i+1].disabled=false;
									frm.elements[i+3].disabled=false;
									frm.elements[i+4].value="";
									frm.elements[i+4].disabled=true;
								}								
								if(valor==1){
									frm.elements[i+3].value='';
									frm.elements[i+4].value='';
									frm.elements[i+1].disabled=true;
								}									
							}
						
						}

					
				}
			}


}

function repetirMoneda(){
	var frm = document.getElementById("form1");
	var sw=0;
	var valor=0;

			for (i=0;i<frm.elements.length;i++){
				
				if((frm.elements[i].name).indexOf('cod_moneda')!=-1){

						if(frm.elements[i-5].checked){

							if(sw==0){
								sw=1;
							    valor=frm.elements[i].value;
							
							}else{
								frm.elements[i].value=valor;
								
							}
						
						}

					
				}
			}
	
	}
function repetirBanco(){
	var frm = document.getElementById("form1");
	var sw=0;
	var valor=0;

			for (i=0;i<frm.elements.length;i++){
				
				if((frm.elements[i].name).indexOf('cod_banco')!=-1){

						if(frm.elements[i-4].checked){

							if(sw==0){
								sw=1;
							    valor=frm.elements[i].value;
							
							}else{
								frm.elements[i].value=valor;
								
							}
						
						}

					
				}
			}
	
	}
	function repetirNroCheque(){
	var frm = document.getElementById("form1");
	var sw=0;
	var valor=0;
			for (i=0;i<frm.elements.length;i++){				
				if((frm.elements[i].name).indexOf('nro_cheque')!=-1){
						if(frm.elements[i-7].checked){
							if(sw==0){
								sw=1;
							   valor=frm.elements[i].value;							
							}else{
								frm.elements[i].value=valor;															
							}
						}
				}
			}
}
	function repetirNroCuenta(){
	var frm = document.getElementById("form1");
	var sw=0;
	var valor=0;
			for (i=0;i<frm.elements.length;i++){				
				if((frm.elements[i].name).indexOf('nro_cuenta')!=-1){
						if(frm.elements[i-6].checked){
							if(sw==0){
								sw=1;
							   valor=frm.elements[i].value;							
							}else{
								frm.elements[i].value=valor;															
							}
						}
				}
			}
}
	function repetirComp(){
	var frm = document.getElementById("form1");
	var sw=0;
	var valor=0;
			for (i=0;i<frm.elements.length;i++){				
				if((frm.elements[i].name).indexOf('nro_comprobante')!=-1){
						if(frm.elements[i-9].checked){
							if(sw==0){
								sw=1;
							   valor=frm.elements[i].value;							
							}else{
								frm.elements[i].value=valor;															
							}
						}
				}
			}
}
	function repetirFechaComp(){
	var frm = document.getElementById("form1");
	var sw=0;
	var valor=0;
			for (i=0;i<frm.elements.length;i++){				
				if((frm.elements[i].name).indexOf('fecha_comprobante')!=-1){
						if(frm.elements[i-10].checked){
							if(sw==0){
								sw=1;
							   valor=frm.elements[i].value;							
							}else{
								frm.elements[i].value=valor;															
							}
						}
				}
			}
}
function guardar(){

		var frm = document.getElementById("form1");
		
			var sw=1;
			for (i=0;i<frm.elements.length;i++)
			{
				if(frm.elements[i].type =='checkbox'){
					if( ((frm.elements[i].name).indexOf('cod_hoja_ruta')!=-1) || ((frm.elements[i].name).indexOf('cod_orden_trabajo')!=-1) || ((frm.elements[i].name).indexOf('cod_salida')!=-1)){	
						if((frm.elements[i].checked)){	
							if(frm.elements[i+3].value==0 || frm.elements[i+3].value==''){
								alert("Debe seleccionar la Forma de Pago de las Documentos que estan seleccionados.");
								sw=0;
								break;								
							}else{
								if(frm.elements[i+3].value==2){
										if(frm.elements[i+7].value==''){
											alert("Si la Forma de Pago es por Cheque debe llenar el campo Nro Cheque.");
											sw=0;
											break;							
										}

								}
								if(frm.elements[i+3].value==3){
										if(frm.elements[i+6].value==''){
											alert("Si la Forma de Pago es por Transferencia debe llenar el campo Nro Cuenta.");
											sw=0;
											break;							
										}

								}								
							
							}
							if((frm.elements[i+8].value*1)<=0){								
								alert("Los montos a cancelar no pueden ser menor o iguales a 0");
								sw=0;
								break;
							}
							if((frm.elements[i+8].value*1)>(frm.elements[i+2].value*1)){	
							
								alert("Los montos a cancelar no puede ser mayor al saldo");
								sw=0;
								break;
							}
							if(frm.elements[i+9].value=='' || frm.elements[i+10].value==''){								
								alert("Los campos Nro de Comprobante y Fecha de Comprobante no pueden encontrarse vacios.");
								sw=0;
								break;
							}	
							
							if(frm.elements[i+9].value=='' || frm.elements[i+10].value==''){								
								alert("Los campos Nro de Comprobante y Fecha de Comprobante no pueden encontrarse vacios.");
								sw=0;
								break;
							}	
																																					
						}
					}

				}	
			}

			
			
			if(sw==1){
				frm.submit();
			}

}
</script>
</head>
<body>

<form id="form1" name="form1" method="post" action="savePago.php" >

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


	

?>
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
					
				$sql2=" select cod_cliente, nombre_cliente ";
				$sql2.=" from clientes ";
				$sql2.=" where (cod_cliente in(select DISTINCT(c.cod_cliente)from hojas_rutas hr, cotizaciones c ";
				$sql2.=" where hr.cod_cotizacion=c.cod_cotizacion and hr.cod_estado_hoja_ruta<>2 and hr.cod_estado_pago_doc<>3)";
				$sql2.=" or  cod_cliente in(select DISTINCT(cod_cliente) from ordentrabajo where cod_est_ot<>2 and ";
				$sql2.=" cod_estado_pago_doc<>3)";				
				$sql2.=" or  cod_cliente in(select DISTINCT(cod_cliente_venta) from salidas where cod_tipo_salida=1";
				$sql2.=" and cod_estado_salida=1 and cod_estado_pago_doc<>3))";				
				$sql2.=" order by nombre_cliente";				

				$resp2=mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2))
				{
							$cod_cliente=$dat2['cod_cliente'];	
			  		 		$nombre_cliente=$dat2['nombre_cliente'];	
				 ?>
                 <option value="<?php echo $cod_cliente;?>"><?php echo $nombre_cliente;?></option>				
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
      		<td><textarea name="obs_pago" id="obs_pago" class="textoform" rows="3" cols="40"></textarea></td>
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
