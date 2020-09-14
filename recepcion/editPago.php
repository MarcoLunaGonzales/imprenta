
<?php 

	require("conexion.inc");
	include("funciones.php");
	
	$cod_pago=$_GET['cod_pago'];
	$sql=" select  p.nro_pago, p.cod_gestion, g.gestion, ";
	$sql.=" p.cod_cliente, cli.nombre_cliente,  p.fecha_pago, p.cod_usuario_pago, p.obs_pago, p.monto_pago, ";
	$sql.=" p.cod_estado_pago, ep.desc_estado_pago";
	$sql.=" from pagos p, gestiones g,  clientes cli, estados_pago ep ";
	$sql.=" where  p.cod_gestion=g.cod_gestion ";
	$sql.=" and p.cod_cliente=cli.cod_cliente ";
	$sql.=" and p.cod_estado_pago=ep.cod_estado_pago ";
	$sql.=" and p.cod_pago=".$cod_pago;
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		
				$nro_pago=$dat['nro_pago'];				
				$cod_gestion=$dat['cod_pago'];
				$gestion=$dat['gestion'];
				$cod_cliente=$dat['cod_cliente'];
				$nombre_cliente=$dat['nombre_cliente'];								
				$fecha_pago=$dat['fecha_pago'];
				$cod_usuario_pago=$dat['cod_usuario_pago'];
				$obs_pago=$dat['obs_pago'];
				$monto_pago=$dat['monto_pago'];
				$cod_estado_pago=$dat['cod_estado_pago'];
				$desc_estado_pago=$dat['desc_estado_pago'];
				///Usuario de Registro//////////
				if($cod_usuario_pago<>""){
					$sqlAux=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
					$sqlAux.=" from usuarios ";
					$sqlAux.=" where cod_usuario=".$cod_usuario_pago;
					$respAux = mysql_query($sqlAux);
					$nombres_usuario_pago="";
					$ap_paterno_usuario_pago="";
					$ap_materno_usuario_pago="";						
					while($datAux=mysql_fetch_array($respAux)){
						
						$nombres_usuario_pago=$datAux['nombres_usuario'];
						$ap_paterno_usuario_pago=$datAux['ap_paterno_usuario'];
						$ap_materno_usuario_pago=$datAux['ap_materno_usuario'];						
					}
				}
				////////////////////////////////
	}



	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>INVENTA</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />

<script language='Javascript'>
function retornar()
	{
	location.href='viewPago.php?cod_pago=<?php echo $_GET['cod_pago'];?>';
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>
<body>

<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post"  name="form1" id="form1" action="saveEditPago.php">
<input type="hidden" name="cod_pago" id="cod_pago" value="<?php echo $_GET['cod_pago'];?>" >

<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">EDICION DE PAGO</br> No. <?php echo $nro_pago;?>/<?php echo $gestion;?></h3>

<table align="center" border="0">
<tr><td bgcolor="#E8D2FB">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td style="background:#FFF;font-size: 10px;color: #E78611;font-weight:bold;">Hojas Rutas con Incremento</td></tr>
<tr><td bgcolor="#FFCC00">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td style="background:#FFF;font-size: 10px;color: #E78611;font-weight:bold;">Hojas Rutas con Descuento</td></tr>
</table>

</br>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Introduzca Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Cliente</td>
      		<td><?php echo $nombre_cliente;?></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha Pago</td>
      		<td><?php echo strftime("%d/%m/%Y",strtotime($fecha_pago))." ". $nombres_usuario_pago[0].$ap_paterno_usuario_pago[0].$ap_materno_usuario_pago[0];?></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
      		<td><textarea name="obs_pago" id="obs_pago" cols="90" class="textoform" >
			<?php echo $obs_pago;?></textarea></td>
    	</tr>  
		 <tr bgcolor="#FFFFFF">
     		<td>Estado de Pago</td>
      		<td><?php echo $desc_estado_pago;?></td>
    	</tr>                     
		</table>
         <div id="divDetallePago">
        <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1">
          <tr class="titulo_tabla">
            <td align="center" height="20"><input type="checkbox" name="seleccionarTodo"  id="seleccionarTodo" onclick="checkearRegistros()" ></td>
            <td align="center" height="20">Tipo Doc.</td>
            <td align="center" height="20">Nro. Doc.</td>
            <td align="center" height="20">Fecha Doc.</td> 
            <td align="center" height="20">Monto Bs</td> 
            <td align="center" height="20">A Cuenta Bs</td>
            <td align="center" height="20">Saldo Bs</td> 
 <td align="center" height="20">Forma de Pago<a onclick="repetirFormaPago()"><img src="images/repetir.jpg" border="0"></a></td>
            <td align="center" height="20">Banco<a onclick="repetirBanco()"><img src="images/repetir.jpg" border="0"></a></td>               
            <td align="center" height="20">Moneda<a onclick="repetirMoneda()"><img src="images/repetir.jpg" border="0"></td>
            <td align="center" height="20">Nro Cuenta<a onclick="repetirNroCuenta()"><img src="images/repetir.jpg" border="0"></a></td>
			<td align="center" height="20">Nro Cheque<a onclick="repetirNroCheque()"><img src="images/repetir.jpg" border="0"></a></td>            
            <td align="center" height="20">Monto Pago</td>
            <td align="center" height="20">Nro Comp<a onclick="repetirComp()"><img src="images/repetir.jpg" border="0"></a></td>
            <td align="center" height="20">Fecha Comp <a onclick="repetirFechaComp()"><img src="images/repetir.jpg" border="0"></a></td>

           </tr>
           
<?php 

	$sql=" select hr.cod_hoja_ruta, hr.nro_hoja_ruta, hr.cod_gestion, g.gestion,  hr.fecha_hoja_ruta, hr.cod_cotizacion ";
	$sql.=" from hojas_rutas hr, cotizaciones c, gestiones g";
	$sql.=" where hr.cod_cotizacion=c.cod_cotizacion";
	$sql.=" and hr.cod_gestion=g.cod_gestion";
	$sql.=" and c.cod_cliente=".$cod_cliente;
	$sql.=" and hr.cod_estado_hoja_ruta<>2";
	$sql.=" and (hr.cod_estado_pago_doc<>3 or hr.cod_hoja_ruta in(select codigo_doc from pagos_detalle where cod_pago=".$cod_pago." and cod_tipo_doc=1))";
	$sql.=" order by  hr.fecha_hoja_ruta asc , hr.nro_hoja_ruta asc  ";
	$resp= mysql_query($sql);
	$gestion="";
	while($dat=mysql_fetch_array($resp)){
		 $cod_hoja_ruta=$dat['cod_hoja_ruta'];
		 $nro_hoja_ruta=$dat['nro_hoja_ruta'];
		 $cod_gestion=$dat['cod_gestion'];
		 $gestion=$dat['gestion'];
		 $fecha_hoja_ruta=$dat['fecha_hoja_ruta'];
		 $cod_cotizacion=$dat['cod_cotizacion'];
		 
		 ////////////////////
		 $swHojaRuta=0;
		 $sql2=" select monto_pago_detalle, cod_forma_pago, cod_banco,";
		 $sql2.=" cod_moneda, nro_cheque, nro_cuenta, nro_comprobante, fecha_comprobante";
		 $sql2.=" from pagos_detalle";
		 $sql2.=" where cod_pago=".$cod_pago;
		 $sql2.=" and codigo_doc=".$cod_hoja_ruta;
		 $sql2.=" and cod_tipo_doc=1";
		 $resp2= mysql_query($sql2);
		 $montopagodetalle="";
		 $codformapago="";
		 $codbanco="";
		 $codmoneda="";
		 $nrocheque="";
		 $nrocuenta="";
		 $nrocomprobante="";
		 $fechacomprobante="";
				
		 while($dat2=mysql_fetch_array($resp2)){
	 		    $swHojaRuta=1;
			 	$montopagodetalle=$dat2['monto_pago_detalle'];
				$codformapago=$dat2['cod_forma_pago'];
				$codbanco=$dat2['cod_banco'];
				$codmoneda=$dat2['cod_moneda'];
				$nrocheque=$dat2['nro_cheque'];
				$nrocuenta=$dat2['nro_cuenta'];
				$nrocomprobante=$dat2['nro_comprobante'];
				$fechacomprobante=$dat2['fecha_comprobante'];
		 }
		 ///////////////////////
?>		
 <?php 
			 		$monto_hojaruta=0;
			 		$sql2=" select sum(cd.IMPORTE_TOTAL) ";
					$sql2.=" from hojas_rutas_detalle hrd, cotizaciones_detalle cd ";
					$sql2.=" where hrd.cod_hoja_ruta=".$cod_hoja_ruta;
					$sql2.=" and hrd.cod_cotizacion=cd.cod_cotizacion ";
					$sql2.=" and hrd.cod_cotizaciondetalle=cd.cod_cotizaciondetalle ";
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$monto_hojaruta=$dat2[0];
					}
					//////////////////////////
					$descuento_cotizacion=0;
					$sql2=" select c.descuento_cotizacion ";
					$sql2.=" from hojas_rutas hr, cotizaciones c ";
					$sql2.=" where hr.cod_cotizacion=c.cod_cotizacion ";
					$sql2.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$descuento_cotizacion=$dat2['descuento_cotizacion'];
					}
					///////////////////////////
					//////////////////////////
					$incremento_cotizacion=0;
					$sql2=" select c.incremento_cotizacion ";
					$sql2.=" from hojas_rutas hr, cotizaciones c ";
					$sql2.=" where hr.cod_cotizacion=c.cod_cotizacion ";
					$sql2.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$incremento_cotizacion=$dat2['incremento_cotizacion'];
					}
					///////////////////////////
										
					$monto_hojaruta=($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion;					
			 ?>
         <tr  bgcolor="<?php if($descuento_cotizacion>0){ echo'#FFCC00';} if($incremento_cotizacion>0){ echo '#E8D2FB'; }?>">
         
            <td align="left"><input type="checkbox" name="cod_hoja_ruta<?php echo $cod_hoja_ruta;?>" id="cod_hoja_ruta<?php echo $cod_hoja_ruta;?>" value="<?php echo $cod_hoja_ruta;?>" <?php if($swHojaRuta==1){?> checked="true"<?php }?> class="textoform" onclick="habilitarFilaHojaRuta(<?php echo $cod_hoja_ruta;?>)"></td> 
            <td>HR</td> 
             <td align="left">&nbsp;<a href="../reportes/impresionHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta; ?>" target="_blank"> <?php echo $nro_hoja_ruta."/".$gestion; ?></a></td>  
             <td align="left">&nbsp;<?php echo strftime("%d.%m.%Y",strtotime($fecha_hoja_ruta)); ?></td> 
             			
             <td align="right" >&nbsp;<?php echo $monto_hojaruta; ?>
<input type="hidden"name="monto_hojaruta<?php echo $cod_hoja_ruta;?>"id="monto_hojaruta<?php echo $cod_hoja_ruta;?>" value="<?php echo $monto_hojaruta;?>"></td> 
             <td align="right">&nbsp;<?php 
			 	$sql2=" select pd.cod_moneda, pd.monto_pago_detalle ";
			 	$sql2.=" from pagos_detalle pd, pagos p";
			 	$sql2.=" where pd.cod_pago=p.cod_pago";
			 	$sql2.=" and p.cod_estado_pago<>2";
			 	$sql2.=" and pd.codigo_doc=".$cod_hoja_ruta;
				$sql2.=" and pd.cod_tipo_doc=1";
				$sql2.=" and pd.cod_pago<>".$cod_pago;
				$resp2 = mysql_query($sql2);
				$acuenta_hojaruta=0;
				while($dat2=mysql_fetch_array($resp2)){
					$cod_moneda=$dat2['cod_moneda'];
					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					if($cod_moneda==1){
						$acuenta_hojaruta=$acuenta_hojaruta+$monto_pago_detalle;
					}else{
							$sql3="select cambio_bs from tipo_cambio";
							$sql3.="where fecha_tipo_cambio='".$fecha_pago."'";
							$sql3.="and cod_moneda=".$cod_moneda;
							$resp3 = mysql_query($sql3);
							$cambio_bs=0;
							while($dat3=mysql_fetch_array($resp3)){
								$cambio_bs=$dat3['cambio_bs'];
							}
							if($cambio_bs<>0){
								$acuenta_hojaruta=$acuenta_hojaruta+($monto_pago_detalle*$cambio_bs);
							
							}
						
					}
				}				
			 echo $acuenta_hojaruta;
			 ?></td> 
             <td align="right"><?php echo ($monto_hojaruta-$acuenta_hojaruta);?>
             <input type="hidden" name="saldo_hojaruta<?php echo $cod_hoja_ruta;?>" id="saldo_hojaruta<?php echo $cod_hoja_ruta;?>" value="<?php echo ($monto_hojaruta-$acuenta_hojaruta);?>"></td>       
             <td align="left">
             <select name="cod_forma_pago_hr<?php echo $cod_hoja_ruta;?>" id="cod_forma_pago_hr<?php echo $cod_hoja_ruta;?>" class="textoform"  <?php if($swHojaRuta==0){?> disabled="true" <?php }?> onchange="habilitarCampos(<?php echo $cod_hoja_ruta;?>)">
				<?php
					$sql3=" select cod_forma_pago, desc_forma_pago";
					$sql3.=" from   forma_pago ";
					$resp3=mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3))
						{
							$cod_forma_pago=$dat3['cod_forma_pago'];	
			  		 		$desc_forma_pago=$dat3['desc_forma_pago'];	
				 ?>
               <option value="<?php echo $cod_forma_pago;?>" <?php if($cod_forma_pago==$codformapago){ ?> selected="true" <?php }?>><?php echo utf8_decode($desc_forma_pago);?></option>				
				<?php		
					}
				?>						
			</select>
            </td>     
             <td align="left">
      <select name="cod_banco_hr<?php echo $cod_hoja_ruta;?>" id="cod_banco_hr<?php echo $cod_hoja_ruta;?>" class="textoform"
      <?php if($codbanco==''){?> disabled="true" <?php }?> >
				<?php
					$sql3=" select cod_banco, desc_banco";
					$sql3.=" from   bancos ";
					$sql3.=" order by desc_banco asc ";
					$resp3=mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3))
						{
							$cod_banco=$dat3['cod_banco'];	
			  		 		$desc_banco=$dat3['desc_banco'];	
				 ?>
                 <option value="<?php echo $cod_banco;?>" <?php if($cod_banco==$codbanco){?> selected="true" <?php }?>><?php echo utf8_decode($desc_banco);?></option>				
				<?php		
					}
				?>						
			</select>
            </td>   
<td align="left">
<select name="cod_moneda_hr<?php echo $cod_hoja_ruta;?>" id="cod_moneda_hr<?php echo $cod_hoja_ruta;?>" class="textoform" <?php if($codmoneda==""){?> disabled="true"<?php }?>>
				<?php
					$sql3=" select cod_moneda, desc_moneda, abrev_moneda";
					$sql3.=" from   monedas ";
					$sql3.=" order by desc_moneda asc ";
					$resp3=mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3))
						{
							$cod_moneda=$dat3['cod_moneda'];	
			  		 		$desc_moneda=$dat3['desc_moneda'];
							$abrev_moneda=$dat3['abrev_moneda'];	
				 ?>
                 <option value="<?php echo $cod_moneda;?>" <?php if($cod_moneda==$codmoneda){?> selected="true" <?php }?>><?php echo utf8_decode($abrev_moneda);?></option>				
				<?php		
					}
				?>						
			</select>
            </td> 
			<td align="left">
				<input type="text" name="nro_cuenta_hr<?php echo $cod_hoja_ruta; ?>" id="nro_cuenta_hr<?php echo $cod_hoja_ruta; ?>" class="textoform" size="12" <?php if($codformapago<>3){?> disabled="true" <?php } ?> value="<?php echo $nrocuenta;?>">
            </td> 
			<td align="left">
				<input type="text" name="nro_cheque_hr<?php echo $cod_hoja_ruta; ?>" id="nro_cheque_hr<?php echo $cod_hoja_ruta; ?>" class="textoform" size="12" <?php if($codformapago<>2){?> disabled="true" <?php } ?> value="<?php echo $nrocheque;?>">
            </td> 
			<td align="right">
			  <input type="text" name="monto_pago_hr<?php echo $cod_hoja_ruta; ?>" id="monto_pago_hr<?php echo $cod_hoja_ruta; ?>" value="<?php if($montopagodetalle==""){ echo ($monto_hojaruta-$acuenta_hojaruta);}else{ echo $montopagodetalle;}?>" class="textoform" size="8" <?php if($montopagodetalle==""){?> disabled="true" <?php } ?>  >
            </td> 
			<td align="left">
				<input type="text" name="nro_comprobante_hr<?php echo $cod_hoja_ruta; ?>" id="nro_comprobante_hr<?php echo $cod_hoja_ruta; ?>" class="textoform" size="10" <?php if($swHojaRuta==0){?> disabled="true"<?php }?> value="<?php echo $nrocomprobante; ?>">
            </td> 
			<td align="left">
			  <input type="text" name="fecha_comprobante_hr<?php echo $cod_hoja_ruta; ?>" id="fecha_comprobante_hr<?php echo $cod_hoja_ruta; ?>" <?php if($swHojaRuta==0){?> disabled="true"<?php }?> value="<?php if($swHojaRuta<>0){echo strftime("%d/%m/%Y",strtotime($fechacomprobante));}else{ echo date("d/m/Y");}?>" class="textoform" size="10" >
            </td>                                                                  
          </tr>     

<?php
	}
?>           
<?php 

	$sql=" select ot.cod_orden_trabajo, ot.nro_orden_trabajo, ot.numero_orden_trabajo, ";
	$sql.=" ot.cod_gestion, g.gestion,  ot.fecha_orden_trabajo";
	$sql.=" from ordentrabajo ot, gestiones g";
	$sql.=" where ot.cod_gestion=g.cod_gestion";
	$sql.=" and ot.cod_cliente=".$cod_cliente;
	$sql.=" and ot.cod_est_ot<>2";
	$sql.=" and (ot.cod_estado_pago_doc<>3 or ot.cod_orden_trabajo in(select codigo_doc from pagos_detalle where cod_pago=".$cod_pago." and cod_tipo_doc=2))";
$sql.=" order by  ot.nro_orden_trabajo asc,ot.fecha_orden_trabajo asc ";
//echo $sql;
	$resp= mysql_query($sql);
	$gestion="";
	while($dat=mysql_fetch_array($resp)){
		 $cod_orden_trabajo=$dat['cod_orden_trabajo'];
		 $nro_orden_trabajo=$dat['nro_orden_trabajo'];
		 $numero_orden_trabajo=$dat['numero_orden_trabajo'];
		 $cod_gestion=$dat['cod_gestion'];
		 $gestion=$dat['gestion'];
		 $fecha_orden_trabajo=$dat['fecha_orden_trabajo'];
		 
		 ////////////////////
		 $swOrdenTrabajo=0;
		 $sql2=" select monto_pago_detalle, cod_forma_pago, cod_banco,";
		 $sql2.=" cod_moneda, nro_cheque, nro_cuenta, nro_comprobante, fecha_comprobante";
		 $sql2.=" from pagos_detalle";
		 $sql2.=" where cod_pago=".$cod_pago;
		 $sql2.=" and codigo_doc=".$cod_orden_trabajo;
		 $sql2.=" and cod_tipo_doc=2";
		// echo "<br/>".$sql2;
		 $resp2= mysql_query($sql2);
		 $montopagodetalle="";
		 $codformapago="";
		 $codbanco="";
		 $codmoneda="";
		 $nrocheque="";
		 $nrocuenta="";
		 $nrocomprobante="";
		 $fechacomprobante="";
				
		 while($dat2=mysql_fetch_array($resp2)){
	 		    $swOrdenTrabajo=1;
			 	$montopagodetalle=$dat2['monto_pago_detalle'];
				$codformapago=$dat2['cod_forma_pago'];
				$codbanco=$dat2['cod_banco'];
				$codmoneda=$dat2['cod_moneda'];
				$nrocheque=$dat2['nro_cheque'];
				$nrocuenta=$dat2['nro_cuenta'];
				$nrocomprobante=$dat2['nro_comprobante'];
				$fechacomprobante=$dat2['fecha_comprobante'];
		 }
		 ///////////////////////
?>		
 <?php 
			 		$monto_orden_trabajo=0;
					$descuento_orden_trabajo=0;
					$incremento_orden_trabajo=0;					
			 		$sql2=" select monto_orden_trabajo, descuento_orden_trabajo, incremento_orden_trabajo ";
					$sql2.=" from ordentrabajo ";
					$sql2.=" where cod_orden_trabajo=".$cod_orden_trabajo;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$monto_orden_trabajo=$dat2['monto_orden_trabajo'];
						$descuento_orden_trabajo=$dat2['descuento_orden_trabajo'];
						$incremento_orden_trabajo=$dat2['incremento_orden_trabajo'];
					}
					$monto_orden_trabajo=($monto_orden_trabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo;
			
			 ?>
         <tr  bgcolor="<?php if($descuento_orden_trabajo>0){ echo'#FFCC00';} if($incremento_orden_trabajo>0){ echo '#E8D2FB'; }?>">
         
            <td align="left"><input type="checkbox" name="cod_orden_trabajo<?php echo $cod_orden_trabajo;?>" id="cod_orden_trabajo<?php echo $cod_orden_trabajo;?>" value="<?php echo $cod_orden_trabajo;?>" <?php if($swOrdenTrabajo==1){?> checked="true"<?php }?> class="textoform" onclick="habilitarFilaOrdenTrabajo(<?php echo $cod_orden_trabajo;?>)"></td> 
            <td>OT</td> 
             <td align="left">&nbsp;<a href="" target="_blank"> <?php echo $nro_orden_trabajo."/".$gestion."(".$numero_orden_trabajo.")"; ?></a></td>  
             <td align="left">&nbsp;<?php echo strftime("%d.%m.%Y",strtotime($fecha_orden_trabajo)); ?></td> 
             			
             <td align="right" >&nbsp;<?php echo $monto_orden_trabajo; ?>
<input type="hidden"name="monto_ordentrabajo<?php echo $cod_orden_trabajo;?>"id="monto_ordentrabajo<?php echo $cod_orden_trabajo;?>" value="<?php echo $monto_orden_trabajo;?>"></td> 
             <td align="right">&nbsp;<?php 
			 	$sql2=" select pd.cod_moneda, pd.monto_pago_detalle ";
			 	$sql2.=" from pagos_detalle pd, pagos p";
			 	$sql2.=" where pd.cod_pago=p.cod_pago";
			 	$sql2.=" and p.cod_estado_pago<>2";
			 	$sql2.=" and pd.codigo_doc=".$cod_orden_trabajo;
				$sql2.=" and pd.cod_tipo_doc=2";
				$sql2.=" and pd.cod_pago<>".$cod_pago;
				$resp2 = mysql_query($sql2);
				$acuenta_ordentrabajo=0;
				while($dat2=mysql_fetch_array($resp2)){
					$cod_moneda=$dat2['cod_moneda'];
					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					if($cod_moneda==1){
						$acuenta_ordentrabajo=$acuenta_ordentrabajo+$monto_pago_detalle;
					}else{
							$sql3="select cambio_bs from tipo_cambio";
							$sql3.="where fecha_tipo_cambio='".$fecha_pago."'";
							$sql3.="and cod_moneda=".$cod_moneda;
							$resp3 = mysql_query($sql3);
							$cambio_bs=0;
							while($dat3=mysql_fetch_array($resp3)){
								$cambio_bs=$dat3['cambio_bs'];
							}
							if($cambio_bs<>0){
								$acuenta_ordentrabajo=$acuenta_ordentrabajo+($monto_pago_detalle*$cambio_bs);
							
							}
						
					}
				}				
			 echo $acuenta_ordentrabajo;
			 ?></td> 
             <td align="right"><?php echo ($monto_orden_trabajo-$acuenta_ordentrabajo);?>
             <input type="hidden" name="saldo_ordentrabajo<?php echo $cod_orden_trabajo;?>" id="saldo_ordentrabajo<?php echo $cod_orden_trabajo;?>" value="<?php echo ($monto_orden_trabajo-$acuenta_ordentrabajo);?>"></td>       
             <td align="left">
             <select name="cod_forma_pago_ot<?php echo $cod_orden_trabajo;?>" id="cod_forma_pago_ot<?php echo $cod_orden_trabajo;?>" class="textoform"  <?php if($swOrdenTrabajo==0){?> disabled="true" <?php }?> onchange="habilitarCamposOT(<?php echo $cod_orden_trabajo;?>)">
				<?php
					$sql3=" select cod_forma_pago, desc_forma_pago";
					$sql3.=" from   forma_pago ";
					$resp3=mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3))
						{
							$cod_forma_pago=$dat3['cod_forma_pago'];	
			  		 		$desc_forma_pago=$dat3['desc_forma_pago'];	
				 ?>
               <option value="<?php echo $cod_forma_pago;?>" <?php if($cod_forma_pago==$codformapago){ ?> selected="true" <?php }?>><?php echo utf8_decode($desc_forma_pago);?></option>				
				<?php		
					}
				?>						
			</select>
            </td>     
             <td align="left">
      <select name="cod_banco_ot<?php echo $cod_orden_trabajo;?>" id="cod_banco_ot<?php echo $cod_orden_trabajo;?>" class="textoform"
      <?php if($codbanco==''){?> disabled="true" <?php }?> >
				<?php
					$sql3=" select cod_banco, desc_banco";
					$sql3.=" from   bancos ";
					$sql3.=" order by desc_banco asc ";
					$resp3=mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3))
						{
							$cod_banco=$dat3['cod_banco'];	
			  		 		$desc_banco=$dat3['desc_banco'];	
				 ?>
                 <option value="<?php echo $cod_banco;?>" <?php if($cod_banco==$codbanco){?> selected="true" <?php }?>><?php echo utf8_decode($desc_banco);?></option>				
				<?php		
					}
				?>						
			</select>
            </td>   
<td align="left">
<select name="cod_moneda_ot<?php echo $cod_orden_trabajo;?>" id="cod_moneda_ot<?php echo $cod_orden_trabajo;?>" class="textoform" <?php if($codmoneda==""){?> disabled="true"<?php }?>>
				<?php
					$sql3=" select cod_moneda, desc_moneda, abrev_moneda";
					$sql3.=" from   monedas ";
					$sql3.=" order by desc_moneda asc ";
					$resp3=mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3))
						{
							$cod_moneda=$dat3['cod_moneda'];	
			  		 		$desc_moneda=$dat3['desc_moneda'];
							$abrev_moneda=$dat3['abrev_moneda'];	
				 ?>
                 <option value="<?php echo $cod_moneda;?>" <?php if($cod_moneda==$codmoneda){?> selected="true" <?php }?>><?php echo utf8_decode($abrev_moneda);?></option>				
				<?php		
					}
				?>						
			</select>
            </td> 
			<td align="left">
				<input type="text" name="nro_cuenta_ot<?php echo $cod_orden_trabajo; ?>" id="nro_cuenta_ot<?php echo $cod_orden_trabajo; ?>" class="textoform" size="12" <?php if($codformapago<>3){?> disabled="true" <?php } ?> value="<?php echo $nrocuenta;?>">
            </td> 
			<td align="left">
				<input type="text" name="nro_cheque_ot<?php echo $cod_orden_trabajo; ?>" id="nro_cheque_ot<?php echo $cod_orden_trabajo; ?>" class="textoform" size="12" <?php if($codformapago<>2){?> disabled="true" <?php } ?> value="<?php echo $nrocheque;?>">
            </td> 
			<td align="right">
			  <input type="text" name="monto_pago_ot<?php echo $cod_orden_trabajo; ?>" id="monto_pago_ot<?php echo $cod_orden_trabajo; ?>" value="<?php if($montopagodetalle==""){ echo ($monto_orden_trabajo-$acuenta_ordentrabajo);}else{ echo $montopagodetalle;}?>" class="textoform" size="8" <?php if($montopagodetalle==""){?> disabled="true" <?php } ?>  >
            </td> 
			<td align="left">
				<input type="text" name="nro_comprobante_ot<?php echo $cod_orden_trabajo; ?>" id="nro_comprobante_ot<?php echo $cod_orden_trabajo; ?>" class="textoform" size="10" <?php if($swOrdenTrabajo==0){?> disabled="true"<?php }?> value="<?php echo $nrocomprobante; ?>">
            </td> 
			<td align="left">
			  <input type="text" name="fecha_comprobante_ot<?php echo $cod_orden_trabajo; ?>" id="fecha_comprobante_ot<?php echo $cod_orden_trabajo; ?>" <?php if($swOrdenTrabajo==0){?> disabled="true"<?php }?> value="<?php if($swOrdenTrabajo<>0){echo strftime("%d/%m/%Y",strtotime($fechacomprobante));}else { echo date("d/m/Y");}?>" class="textoform" size="10" >
            </td>                                                                  
          </tr>     

<?php
	}
?>           
   
<?php 

	$sql=" select s.cod_salida, s.nro_salida, s.cod_gestion, g.gestion, s.cliente_venta, s.fecha_salida ";
	$sql.=" from salidas s, gestiones g ";
	$sql.=" where s.cod_gestion=g.cod_gestion ";
	$sql.=" and s.cod_cliente_venta=".$cod_cliente;
	$sql.=" and s.cod_tipo_salida=1 ";
	$sql.=" and s.cod_estado_salida=1 ";
	$sql.=" and (s.cod_estado_pago_doc<>3 or s.cod_salida in(select codigo_doc from pagos_detalle where cod_pago=".$cod_pago." and cod_tipo_doc=3))";
	$sql.=" order by fecha_salida asc,s.nro_salida asc ";


	$resp= mysql_query($sql);
	$gestionVenta="";
	while($dat=mysql_fetch_array($resp)){
		
		  $cod_salida=$dat['cod_salida'];
		  $nro_salida=$dat['nro_salida'];
		  $cod_gestion=$dat['cod_gestion'];
		  $gestionVenta=$dat['gestion'];
		  $cliente_venta=$dat['cliente_venta'];
		  $fecha_salida=$dat['fecha_salida'];
		


					
		 
		 ////////////////////
		 $swVenta=0;
		 $sql2=" select monto_pago_detalle, cod_forma_pago, cod_banco,";
		 $sql2.=" cod_moneda, nro_cheque, nro_cuenta, nro_comprobante, fecha_comprobante";
		 $sql2.=" from pagos_detalle";
		 $sql2.=" where cod_pago=".$cod_pago;
		 $sql2.=" and codigo_doc=".$cod_salida;
		 $sql2.=" and cod_tipo_doc=3";
		 $resp2= mysql_query($sql2);
		 $montopagodetalle="";
		 $codformapago="";
		 $codbanco="";
		 $codmoneda="";
		 $nrocheque="";
		 $nrocuenta="";
		 $nrocomprobante="";
		 $fechacomprobante="";
				
		 while($dat2=mysql_fetch_array($resp2)){
	 		    $swVenta=1;
			 	$montopagodetalle=$dat2['monto_pago_detalle'];
				$codformapago=$dat2['cod_forma_pago'];
				$codbanco=$dat2['cod_banco'];
				$codmoneda=$dat2['cod_moneda'];
				$nrocheque=$dat2['nro_cheque'];
				$nrocuenta=$dat2['nro_cuenta'];
				$nrocomprobante=$dat2['nro_comprobante'];
				$fechacomprobante=$dat2['fecha_comprobante'];
		 }
		 ///////////////////////
?>		
 <?php 
	 		$monto_venta=0;
			 		$sql2=" select sum(sd.precio_venta*sd.cant_salida) ";
					$sql2.=" from salidas_detalle sd ";
					$sql2.=" where sd.cod_salida=".$cod_salida;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$monto_venta=$dat2[0];
					}
										
			
			 ?>
         <tr  bgcolor="#FFFFFF">
         
            <td align="left"><input type="checkbox" name="cod_salida<?php echo $cod_salida;?>" id="cod_salida<?php echo $cod_salida;?>" value="<?php echo $cod_salida;?>" <?php if($swVenta==1){?> checked="true"<?php }?> class="textoform" onclick="habilitarFilaVenta(<?php echo $cod_salida;?>)"></td> 
            <td>VENTA</td> 
             <td align="left">&nbsp;<a href="../almacenes/detalleSalida.php?cod_salida=<?php echo $cod_salida; ?>" target="_blank"> <?php echo $nro_salida."/".$gestionVenta; ?></a></td>  
             <td align="left">&nbsp;<?php echo strftime("%d.%m.%Y",strtotime($fecha_salida)); ?></td> 
             			
             <td align="right" >&nbsp;<?php echo $monto_venta; ?>
<input type="hidden"name="monto_venta<?php echo $cod_salida;?>"id="monto_venta<?php echo $cod_salida;?>" value="<?php echo $monto_venta;?>"></td> 
             <td align="right">&nbsp;<?php 
			 	$sql2=" select pd.cod_moneda, pd.monto_pago_detalle ";
			 	$sql2.=" from pagos_detalle pd, pagos p";
			 	$sql2.=" where pd.cod_pago=p.cod_pago";
			 	$sql2.=" and p.cod_estado_pago<>2";
			 	$sql2.=" and pd.codigo_doc=".$cod_salida;
				$sql2.=" and pd.cod_tipo_doc=3";
				$sql2.=" and pd.cod_pago<>".$cod_pago;
				$resp2 = mysql_query($sql2);
				$acuenta_venta=0;
				while($dat2=mysql_fetch_array($resp2)){
					$cod_moneda=$dat2['cod_moneda'];
					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					if($cod_moneda==1){
						$acuenta_venta=$acuenta_venta+$monto_pago_detalle;
					}else{
							$sql3="select cambio_bs from tipo_cambio";
							$sql3.="where fecha_tipo_cambio='".$fecha_pago."'";
							$sql3.="and cod_moneda=".$cod_moneda;
							$resp3 = mysql_query($sql3);
							$cambio_bs=0;
							while($dat3=mysql_fetch_array($resp3)){
								$cambio_bs=$dat3['cambio_bs'];
							}
							if($cambio_bs<>0){
								$acuenta_venta=$acuenta_venta+($monto_pago_detalle*$cambio_bs);
							
							}
						
					}
				}				
			 echo $acuenta_venta;
			 ?></td> 
             <td align="right"><?php echo ($monto_venta-$acuenta_venta);?>
             <input type="hidden" name="saldo_venta<?php echo $cod_salida;?>" id="saldo_venta<?php echo $cod_salida;?>" value="<?php echo ($monto_venta-$acuenta_venta);?>"></td>       
             <td align="left">
             <select name="cod_forma_pago_venta<?php echo $cod_salida;?>" id="cod_forma_pago_venta<?php echo $cod_salida;?>" class="textoform"  <?php if($swVenta==0){?> disabled="true" <?php }?> onchange="habilitarCamposVenta(<?php echo $cod_salida;?>)">
				<?php
					$sql3=" select cod_forma_pago, desc_forma_pago";
					$sql3.=" from   forma_pago ";
					$resp3=mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3))
						{
							$cod_forma_pago=$dat3['cod_forma_pago'];	
			  		 		$desc_forma_pago=$dat3['desc_forma_pago'];	
				 ?>
               <option value="<?php echo $cod_forma_pago;?>" <?php if($cod_forma_pago==$codformapago){ ?> selected="true" <?php }?>><?php echo utf8_decode($desc_forma_pago);?></option>				
				<?php		
					}
				?>						
			</select>
            </td>     
             <td align="left">
      <select name="cod_banco_venta<?php echo $cod_salida;?>" id="cod_banco_venta<?php echo $cod_salida;?>" class="textoform"
      <?php if($codbanco==''){?> disabled="true" <?php }?> >
				<?php
					$sql3=" select cod_banco, desc_banco";
					$sql3.=" from   bancos ";
					$sql3.=" order by desc_banco asc ";
					$resp3=mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3))
						{
							$cod_banco=$dat3['cod_banco'];	
			  		 		$desc_banco=$dat3['desc_banco'];	
				 ?>
                 <option value="<?php echo $cod_banco;?>" <?php if($cod_banco==$codbanco){?> selected="true" <?php }?>><?php echo utf8_decode($desc_banco);?></option>				
				<?php		
					}
				?>						
			</select>
            </td>   
<td align="left">
<select name="cod_moneda_venta<?php echo $cod_salida;?>" id="cod_moneda_venta<?php echo $cod_salida;?>" class="textoform" <?php if($codmoneda==""){?> disabled="true"<?php }?>>
				<?php
					$sql3=" select cod_moneda, desc_moneda, abrev_moneda";
					$sql3.=" from   monedas ";
					$sql3.=" order by desc_moneda asc ";
					$resp3=mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3))
						{
							$cod_moneda=$dat3['cod_moneda'];	
			  		 		$desc_moneda=$dat3['desc_moneda'];
							$abrev_moneda=$dat3['abrev_moneda'];	
				 ?>
                 <option value="<?php echo $cod_moneda;?>" <?php if($cod_moneda==$codmoneda){?> selected="true" <?php }?>><?php echo utf8_decode($abrev_moneda);?></option>				
				<?php		
					}
				?>						
			</select>
            </td> 
			<td align="left">
				<input type="text" name="nro_cuenta_venta<?php echo $cod_salida; ?>" id="nro_cuenta_venta<?php echo $cod_salida; ?>" class="textoform" size="12" <?php if($codformapago<>3){?> disabled="true" <?php } ?> value="<?php echo $nrocuenta;?>">
            </td> 
			<td align="left">
				<input type="text" name="nro_cheque_venta<?php echo $cod_salida; ?>" id="nro_cheque_venta<?php echo $cod_salida; ?>" class="textoform" size="12" <?php if($codformapago<>2){?> disabled="true" <?php } ?> value="<?php echo $nrocheque;?>">
            </td> 
			<td align="right">
			  <input type="text" name="monto_pago_venta<?php echo $cod_salida; ?>" id="monto_pago_venta<?php echo $cod_salida; ?>" value="<?php if($montopagodetalle==""){ echo ($monto_venta-$acuenta_venta);}else{ echo $montopagodetalle;}?>" class="textoform" size="8" <?php if($montopagodetalle==""){?> disabled="true" <?php } ?>  >
            </td> 
			<td align="left">
				<input type="text" name="nro_comprobante_venta<?php echo $cod_salida; ?>" id="nro_comprobante_venta<?php echo $cod_salida; ?>" class="textoform" size="10" <?php if($swVenta==0){?> disabled="true"<?php }?> value="<?php echo $nrocomprobante; ?>">
            </td> 
			<td align="left">
			  <input type="text" name="fecha_comprobante_venta<?php echo $cod_salida; ?>" id="fecha_comprobante_venta<?php echo $cod_salida; ?>" <?php if($swVenta==0){?> disabled="true"<?php }?> value="<?php if($swVenta<>0){echo strftime("%d/%m/%Y",strtotime($fechacomprobante));}else{ echo date("d/m/Y");}?>" class="textoform" size="10" >
            </td>                                                                  
          </tr>     

<?php
	}
?>                    
        </table>      
      </div>    
      <br/>
      <div align="center">
      <input type="button" name="atras" id="atras" onClick="retornar()" value="IR ATRAS" class="boton">
                  <?php
			 if($fecha_pago==date('Y-m-d',time()) ){
				if($cod_estado_pago<>2){
			?>
            <INPUT type="button" class="boton" name="btn_guardar" value="GUARDAR CAMBIOS" onClick="guardar(this.form);"  >
            <?php
				}
			}
			

			?>


      </div>
</form>

</body>
</html>
