
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

<script language='Javascript'>
function retornar()
	{
	location.href='listPagoProveedor.php?cod_pago_prov=<?php echo $_GET['cod_pago_prov'];?>';
	}

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
							totalDeudaSeleccionados=(totalDeudaSeleccionados*1)+(frm.elements[i+2].value*1);
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
var saldo=document.getElementById('id_totalPagoProveedorBs').innerHTML;
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
		//alert("totalAuxiliar="+(totalAuxiliar*1));
		//alert("document.getElementById('id_totalPagoProveedorBs').innerHTML*1"+document.getElementById('id_totalPagoProveedorBs').innerHTML*1);
			if((totalAuxiliar*1)!=(document.getElementById('id_totalPagoProveedorBs').innerHTML*1)){
			 sw=0;
				alert("El Monto Total de los Documentos que quiere cancelar no coincide con la Cantidad Cancelada");				
			}

			
			if(sw==1){
				frm.submit();
			}

}</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>
<body bgcolor="#FFFFFF">

<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<?php

	$sql=" select pp.cod_proveedor,p.nombre_proveedor, pp.nro_pago_prov, pp.cod_gestion, ";
	$sql.=" g.gestion_nombre, pp.fecha_pago_prov, pp.obs_pago_prov ";
	$sql.=" from pago_proveedor pp ";
	$sql.=" left join proveedores p on (pp.cod_proveedor=p.cod_proveedor) ";
	$sql.=" left join gestiones g on (pp.cod_gestion=g.cod_gestion)";
	$sql.=" where pp.cod_pago_prov=".$_GET['cod_pago_prov'];
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$cod_proveedor=$dat['cod_proveedor'];	
		$nombre_proveedor=$dat['nombre_proveedor'];
		$nro_pago_prov=$dat['nro_pago_prov'];
		$cod_gestion=$dat['cod_gestion'];
		$gestion_nombre=$dat['gestion_nombre'];
		$fecha_pago_prov=$dat['fecha_pago_prov'];
		$obs_pago_prov=$dat['obs_pago_prov'];
		
	}


			$sql3="select cambio_bs from tipo_cambio";
		$sql3.=" where fecha_tipo_cambio='".$fecha_registro."'";
		$sql3.=" and cod_moneda=2";
		$resp3 = mysql_query($sql3);
		$cambio_bs=0;
		while($dat3=mysql_fetch_array($resp3)){
			$cambio_bs=$dat3['cambio_bs'];
		}

?>
<form   method="post"  name="form1" id="form1" action="saveEditPagoProveedor.php">
<input type="hidden" id="cambio_bs" name="cambio_bs" value="<?php echo $cambio_bs;?>"> 
<input type="hidden" name="total_bs" id="total_bs">
<input type="hidden" name="cod_pago_prov" id="cod_pago_prov" value="<?php echo $_GET['cod_pago_prov'];?>" >
<input type="hidden" name="cod_proveedor" id="cod_proveedor" value="<?php echo $cod_proveedor;?>" >

<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">EDICION DE PAGO PROVEEDOR </br> No. <?php echo $nro_pago_prov;?>/<?php echo $gestion_nombre;?></h3>

</br>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Introduzca Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Proveedor</td>
      		<td><?php echo $nombre_proveedor;?></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha Pago</td>
      		<td><input type="text"name="fecha_pago_prov" id="fecha_pago_prov" class="textoform" size="40" value="<?php echo strftime("%d/%m/%Y",strtotime($fecha_pago_prov));?>"></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
      		<td><textarea name="obs_pago_prov" id="obs_pago_prov" cols="90" class="textoform" >
			<?php echo $obs_pago_prov;?></textarea></td>
    	</tr>  
                    
  </table>
         <div id="divDetallePago">
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1">
          <tr class="titulo_tabla">
            <td align="center" height="20"><input type="checkbox" name="seleccionarTodo"  id="seleccionarTodo" onClick="checkearRegistros()" checked="true" ></td>
            <td align="center" height="20">Tipo Doc.</td>
            <td align="center" height="20">Nro Doc.</td>
            <td align="center" height="20">Fecha Doc.</td> 
            <td align="center" height="20">Monto Bs</td> 
            <td align="center" height="20">A Cuenta Bs</td>
            <td align="center" height="20">Saldo Bs</td>             
            <td align="center" height="20">Monto Pago</td>
		</tr>
          
           
<?php 
	$totalDeuda=0;
	$sql=" select i.cod_ingreso, i.nro_ingreso, i.cod_gestion, g.gestion,  i.fecha_ingreso, i.total_bs ";
	$sql.=" from ingresos i, gestiones g";
	$sql.=" where i.cod_gestion=g.cod_gestion";
	$sql.=" and i.cod_proveedor=".$cod_proveedor;
	$sql.=" and i.cod_estado_ingreso<>2";
	$sql.=" and ((i.cod_estado_pago_doc<>3) or i.cod_ingreso in(select codigo_doc from pago_proveedor_detalle where cod_pago_prov=".$_GET['cod_pago_prov']." and cod_tipo_doc=4))";
	$sql.=" order by  i.fecha_ingreso asc , i.nro_ingreso asc  ";
	
	$resp= mysql_query($sql);
	$gestion="";
	while($dat=mysql_fetch_array($resp)){
		 $cod_ingreso=$dat['cod_ingreso'];
		 $nro_ingreso=$dat['nro_ingreso'];
		 $cod_gestion=$dat['cod_gestion'];
		 $gestion=$dat['gestion'];
		 $fecha_ingreso=$dat['fecha_ingreso'];
		 $monto_ingreso=$dat['total_bs'];
		  ////////////////////
		 $swIngreso=0;
		 $sql2=" select monto_pago_prov_detalle ";
		 $sql2.=" from pago_proveedor_detalle";
		 $sql2.=" where cod_pago_prov=".$_GET['cod_pago_prov'];
		 $sql2.=" and codigo_doc=".$cod_ingreso;
		 $sql2.=" and cod_tipo_doc=4";
		 $resp2= mysql_query($sql2);
		
		 $montopagoprovdetalle=0;
				
		 while($dat2=mysql_fetch_array($resp2)){
	 		    $swIngreso=1;
			 	$montopagoprovdetalle=$dat2['monto_pago_prov_detalle'];

		 }
		 ///////////////////////
?>		

          <tr >
            <td align="left"><input type="checkbox" name="cod_ingreso<?php echo $cod_ingreso;?>" id="cod_ingreso<?php echo $cod_ingreso;?>" value="<?php echo $cod_ingreso;?>" class="textoform" onclick="habilitarFilaIngreso(<?php echo $cod_ingreso;?>)" <?php if($swIngreso==1){?> checked="true"<?php }?>></td>
            <td>ING</td> 
             <td align="left"><a href="../almacenes/detalleIngreso.php?cod_ingreso=<?php echo $cod_ingreso; ?>" target="_blank"> <?php echo $nro_ingreso."/".$gestion; ?></a></td>  
             <td align="left">&nbsp;<?php echo strftime("%d.%m.%Y",strtotime($fecha_ingreso)); ?></td> 
             
             <td align="right" >&nbsp;<?php echo $monto_ingreso; ?>
			<input type="hidden"name="monto_ingreso<?php echo $cod_ingreso;?>"id="monto_ingreso<?php echo $cod_ingreso;?>" value="<?php echo $monto_ingreso;?>"></td> 
             <td align="right">&nbsp;<?php 
			 		
			 	$sql2=" select SUM(ppd.monto_pago_prov_detalle) ";
			 	$sql2.=" from pago_proveedor_detalle ppd, pago_proveedor pp";
			 	$sql2.=" where ppd.cod_pago_prov=pp.cod_pago_prov";
			 	$sql2.=" and pp.cod_estado_pago_prov<>2";
			 	$sql2.=" and ppd.codigo_doc=".$cod_ingreso;
				$sql2.=" and ppd.cod_pago_prov<>".$_GET['cod_pago_prov'];
				$sql2.=" and ppd.cod_tipo_doc=4";
				$resp2 = mysql_query($sql2);
				$acuenta_ingreso=0;
				$monto_pago_prov_detalle=0;
				while($dat2=mysql_fetch_array($resp2)){
					$monto_pago_prov_detalle=$dat2[0];										
				}	
				$acuenta_ingreso=$acuenta_ingreso+$monto_pago_prov_detalle;			
			 echo $acuenta_ingreso;
			 $totalDeuda=$totalDeuda+($monto_ingreso-$acuenta_ingreso);
			 ?></td> 
             <td align="right"><?php echo ($monto_ingreso-$acuenta_ingreso);?>
             <input type="hidden" name="saldo_ingreso<?php echo $cod_ingreso;?>" id="saldo_ingreso<?php echo $cod_ingreso;?>" value="<?php echo ($monto_ingreso-$acuenta_ingreso);?>" ></td>       

			<td align="right">
			  <input type="text" name="monto_pago_ingreso<?php echo $cod_ingreso; ?>" id="monto_pago_ingreso<?php echo $cod_ingreso; ?>"  value="<?php if($swIngreso==0){ echo ($monto_ingreso-$acuenta_ingreso);}else{ echo $montopagoprovdetalle;}?>" class="textoform" size="8" onKeyUp="validaFloat2(this)" onChange="validaFloat2(this)"  <?php if($swIngreso==0){?> disabled="true" <?php } ?> >            </td>                                                                
          </tr>          

<?php
	}
?>   

<?php
	$sql=" select gg.cod_gasto_gral, gg.nro_gasto_gral,g.gestion_nombre,gg.cod_tipo_doc,td.abrev_tipo_doc,gg.codigo_doc,";
	$sql.=" gg.fecha_gasto_gral,gg.nro_recibo, gg.monto_gasto_gral,gg.cant_gasto_gral,gg.desc_gasto_gral,gg.cod_gasto,";
	$sql.=" gg.cod_estado_pago_doc,gg.cod_tipo_pago";
	$sql.=" from gastos_gral gg";
	$sql.=" left join gestiones g on(gg.cod_gestion=g.cod_gestion)";
	$sql.=" left join tipo_documento td on(gg.cod_tipo_doc=td.cod_tipo_doc)";
	$sql.=" where gg.cod_proveedor=".$cod_proveedor;
	$sql.=" and gg.cod_estado<>2";
	$sql.=" and (gg.cod_estado_pago_doc<>3  or gg.cod_gasto_gral in(select codigo_doc from pago_proveedor_detalle where cod_pago_prov=".$_GET['cod_pago_prov']." and cod_tipo_doc=5))";	
	$sql.=" order by fecha_gasto_gral asc, gg.nro_gasto_gral asc";
	$resp= mysql_query($sql);
	$gestion="";
	while($dat=mysql_fetch_array($resp)){
		$cod_gasto_gral=$dat['cod_gasto_gral'];
		$nro_gasto_gral=$dat['nro_gasto_gral'];
		$gestion_nombre=$dat['gestion_nombre'];
		$cod_tipo_doc=$dat['cod_tipo_doc'];
		$abrev_tipo_doc=$dat['abrev_tipo_doc'];
		$codigo_doc=$dat['codigo_doc'];
		$fecha_gasto_gral=$dat['fecha_gasto_gral'];
		$nro_recibo=$dat['nro_recibo'];
		$monto_gasto_gral=$dat['monto_gasto_gral'];
		$cant_gasto_gral=$dat['cant_gasto_gral'];
		$desc_gasto_gral=$dat['desc_gasto_gral'];
		$cod_gasto=$dat['cod_gasto'];
		$cod_estado_pago_doc=$dat['cod_estado_pago_doc'];
		$cod_tipo_pago=$dat['cod_tipo_pago'];
			 		 ////////////////////
		 $swGastoGral=0;
		 $sql2=" select monto_pago_prov_detalle ";
		 $sql2.=" from pago_proveedor_detalle";
		 $sql2.=" where cod_pago_prov=".$_GET['cod_pago_prov'];
		 $sql2.=" and codigo_doc=".$cod_gasto_gral;
		 $sql2.=" and cod_tipo_doc=5";
		 $resp2= mysql_query($sql2);
		
		 $montopagoprovdetalle=0;
				
		 while($dat2=mysql_fetch_array($resp2)){
	 		    $swGastoGral=1;
			 	$montopagoprovdetalle=$dat2['monto_pago_prov_detalle'];

		 }
		 ///////////////////////
		 		
		$sql2=" select  count(*),sum(ppd.monto_pago_prov_detalle) ";
		$sql2.=" from pago_proveedor_detalle ppd ";
		$sql2.=" inner join  pago_proveedor pp on(ppd.cod_pago_prov=pp.cod_pago_prov and pp.cod_estado_pago_prov<>2) ";
		$sql2.=" and ppd.codigo_doc=".$cod_gasto_gral;
		$sql2.=" and ppd.cod_pago_prov<>".$_GET['cod_pago_prov'];
		$sql2.=" and ppd.cod_tipo_doc=5";
		$resp2 = mysql_query($sql2);
		$acuenta_gasto_gral=0;
		while($dat2=mysql_fetch_array($resp2)){					
			$num_pago_prov=$dat2[0];
			if($num_pago_prov>0){
				$acuenta_gasto_gral=$dat2[1];									
			}
		}
			
		 
?>
 <tr >
            <td align="left"><input type="checkbox" name="cod_gasto_gral<?php echo $cod_gasto_gral;?>" id="cod_gasto_gral<?php echo $cod_gasto_gral;?>" value="<?php echo $cod_gasto_gral;?>" class="textoform" onclick="habilitarFilaGastoGral(<?php echo $cod_gasto_gral;?>)" <?php if($swGastoGral==1){?> checked="true"<?php }?>></td>
            <td>GASTOS</td> 
             <td align="left"><a href="../contable/vistaGastoGral.php?cod_gasto_gral=<?php echo $cod_gasto_gral; ?>" target="_blank"> <?php echo $nro_gasto_gral."/".$gestion_nombre; ?></a></td>  
             <td align="left">&nbsp;<?php echo strftime("%d.%m.%Y",strtotime($fecha_gasto_gral)); ?></td> 
             
             <td align="right" >&nbsp;<?php echo $monto_gasto_gral; ?>
			<input type="hidden"name="monto_gasto_gral<?php echo $cod_gasto_gral;?>"id="monto_gasto_gral<?php echo $cod_gasto_gral;?>" value="<?php echo $monto_gasto_gral;?>"></td> 
             <td align="right">&nbsp;<?php echo ($acuenta_gasto_gral);?></td> 
             <td align="right">
			 <?php 
			 echo ($monto_gasto_gral-$acuenta_gasto_gral);
			  $totalDeuda=$totalDeuda+($monto_gasto_gral-$acuenta_gasto_gral);
			 ?>
             <input type="hidden" name="saldo_gasto_gral<?php echo $cod_gasto_gral;?>" id="saldo_gasto_gral<?php echo $cod_gasto_gral;?>" value="<?php echo ($monto_gasto_gral-$acuenta_gasto_gral);?>"></td>       

			<td align="right">
			  <input type="text" name="monto_pago_gasto_gral<?php echo $cod_gasto_gral; ?>" id="monto_pago_gasto_gral<?php echo $cod_gasto_gral; ?>"
			  value="<?php if($swGastoGral==0){ echo ($monto_gasto_gral-$acuenta_gasto_hojarutao);}else{ echo $montopagoprovdetalle;}?>" class="textoform" size="8" onKeyUp="validaFloat2(this)" onChange="validaFloat2(this)"  <?php if($swGastoGral==0){?> disabled="true" <?php } ?> >            </td> 
          </tr>          
<?php
	
	}
?>
 

<?php
	$sql="select cambio_bs from tipo_cambio where fecha_tipo_cambio='".date('Y-m-d', time())."'";
	$resp= mysql_query($sql);
	$cambio_bs=0;
	while($dat=mysql_fetch_array($resp)){
		$cambio_bs=$dat['cambio_bs'];
	}
?>

<tr>
<td colspan="13">
<table border="0" cellpadding="0" cellspacing="1" width="100%">
 <tr class="titulo_tabla" height="20">
<td colspan="4" align="center"><strong> BOLIVIANOS</strong></td>
<td colspan="4" align="center">DOLARES</td>
</tr>
 <tr class="titulo_tabla" height="20">
<td colspan="2" align="center"><strong>Monto Pago</strong></td>
<td align="center">Banco</td>
<td align="center">Nro Cheque/ Nro Cta.</td>
<td colspan="2" align="center"><strong>Monto Pago</strong></td>
<td align="center">Banco</td>
<td align="center">Nro Cheque/ Nro Cta.</td>
</tr>
<?php
					$sql2=" select cod_forma_pago, desc_forma_pago";
					$sql2.=" from   forma_pago  ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_forma_pago=$dat2['cod_forma_pago'];	
			  		 		$desc_forma_pago=$dat2['desc_forma_pago'];	
							
							$sql5=" select cod_moneda,monto_pago_prov, cod_banco,nro_cheque, nro_cuenta ";
							$sql5.=" from pago_proveedor_descripcion ";
							$sql5.=" where cod_pago_prov=".$_GET['cod_pago_prov']." and cod_forma_pago=".$cod_forma_pago;
							$sql5.=" and cod_moneda=1 ";

							$codmoneda=0;
							$montopagoprov=0;
							$codbanco=0;
							$nrocheque="";
							$nrocuenta="";							
							$resp5=mysql_query($sql5);
							while($dat5=mysql_fetch_array($resp5)){
								$codmoneda=$dat5['cod_moneda'];
								$montopagoprov=$dat5['monto_pago_prov'];
								$codbanco=$dat5['cod_banco'];
								$nrocheque=$dat5['nro_cheque'];
								$nrocuenta=$dat5['nro_cuenta'];
							}
							
?>

<tr>
<td ><strong><?php echo $desc_forma_pago; ?></strong></td>
<td  align="right"><input type="text" class="textoform" name="montoPagoBs<?php echo $cod_forma_pago;?>" id="formaPagoBs<?php echo $cod_forma_pago;?>" size="7" onKeyUp="validaFloat(this)" onChange="validaFloat(this)"value="<?php echo $montopagoprov;?>"></td>
<td  align="right">
<?php if($cod_forma_pago==2 or $cod_forma_pago==3){?>
<select name="bancoBs<?php echo $cod_forma_pago;?>" id="bancoBs<?php echo $cod_forma_pago;?>" class="textoform" >
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
                 <option value="<?php echo $cod_banco;?>" <?php if($cod_banco==$codbanco){?> selected="selected"<?php }?>><?php echo utf8_decode($desc_banco);?></option>				
				<?php		
					}
				?>						
			</select>
				<?php		
					}
				?>			</td>
<td  align="right">
<?php if($cod_forma_pago==2 ){?>
		<input type="text"  class="textoform" size="12" name="nro_chequeBs<?php echo $cod_forma_pago;?>" id="nro_chequeBs<?php echo $cod_forma_pago;?>" value="<?php echo $nrocheque;?>" >

<?php }?>
<?php if($cod_forma_pago==3){?>
						<input type="text"  class="textoform" size="12" name="nro_cuentaBs<?php echo $cod_forma_pago;?>" id="nro_cuentaBs<?php echo $cod_forma_pago;?>" value="<?php echo $nrocuenta;?>" >

<?php }?></td>	
<?php

						$sql5=" select cod_moneda,monto_pago_prov, cod_banco,nro_cheque, nro_cuenta ";
						$sql5.=" from pago_proveedor_descripcion ";
						$sql5.=" where cod_pago_prov=".$_GET['cod_pago_prov']." and cod_forma_pago=".$cod_forma_pago;
						$sql5.=" and cod_moneda=2 ";
						$codmoneda=0;
						$montopagoprov=0;
						$codbanco=0;
						$nrocheque="";
						$nrocuenta="";							
						$resp5=mysql_query($sql5);
						while($dat5=mysql_fetch_array($resp5)){
							$codmoneda=$dat5['cod_moneda'];
							$montopagoprov=$dat5['monto_pago_prov'];
							$codbanco=$dat5['cod_banco'];
							$nrocheque=$dat5['nro_cheque'];
							$nrocuenta=$dat5['nro_cuenta'];
						}
?>				
<td  align="left"><strong><?php echo $desc_forma_pago; ?></strong></td>
<td  align="right"><input type="text" class="textoform" name="montoPagoSus<?php echo $cod_forma_pago;?>" id="formaPagoSus<?php echo $cod_forma_pago;?>" size="7" onKeyUp="validaFloat(this)" onChange="validaFloat(this)" value="<?php echo $montopagoprov;?>"></td>
<td  align="right">
<?php if($cod_forma_pago==2 or $cod_forma_pago==3){?>
<select name="bancoSus<?php echo $cod_forma_pago;?>" id="bancoSus<?php echo $cod_forma_pago;?>" class="textoform" >
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
                 <option value="<?php echo $cod_banco;?>" <?php if($cod_banco==$codbanco){?> selected="selected"<?php }?>><?php echo utf8_decode($desc_banco);?></option>				
				<?php		
					}
				?>						
			</select>
				<?php		
					}
				?>			</td>

<td  align="right">
<?php if($cod_forma_pago==2 ){?>
						<input type="text"  class="textoform" size="12" name="nro_chequeSus<?php echo $cod_forma_pago;?>" id="nro_chequeSus<?php echo $cod_forma_pago;?>" value="<?php echo $nrocheque; ?>" >

<?php }?>
<?php if($cod_forma_pago==3){?>
						<input type="text"  class="textoform" size="12" name="nro_cuentaSus<?php echo $cod_forma_pago;?>" id="nro_cuentaSus<?php echo $cod_forma_pago;?>" value="<?php echo $nrocuenta; ?>" >

<?php }?></td>
</tr>
<?php
		}
?>
<?php
	$sql7="select count(*)  from pago_proveedor_descripcion where cod_pago_prov=".$_GET['cod_pago_prov']." and cod_moneda=1";
	$resp7=mysql_query($sql7);
	$nroPagoBs=0;
	while($dat7=mysql_fetch_array($resp7)){
		$nroPagoBs=$dat7[0];
	}
	$totalBs=0;
	if($nroPagoBs>0){
			$sql7="select sum(monto_pago_prov)  from pago_proveedor_descripcion where cod_pago_prov=".$_GET['cod_pago_prov']." and cod_moneda=1";
			$resp7=mysql_query($sql7);
			$totalBs=0;
			while($dat7=mysql_fetch_array($resp7)){
				$totalBs=$dat7[0];
			}
	
	}
	$sql7="select count(*)  from pago_proveedor_descripcion where cod_pago_prov=".$_GET['cod_pago_prov']." and cod_moneda=2";
	$resp7=mysql_query($sql7);
	$nroPagoSus=0;
	while($dat7=mysql_fetch_array($resp7)){
		$nroPagoSus=$dat7[0];
	}
	$totalSus=0;
	if($nroPagoSus>0){
			$sql7="select sum(monto_pago_prov)  from pago_proveedor_descripcion where cod_pago_prov=".$_GET['cod_pago_prov']." and cod_moneda=2";
			$resp7=mysql_query($sql7);
			$totalSus=0;
			while($dat7=mysql_fetch_array($resp7)){
				$totalSus=$dat7[0];
			}
	
	}	
?>
<tr align="right">
<td ><strong>Total Bs </strong>&nbsp;&nbsp;</td>
     		<td align="left" colspan="3"><div id="id_totalBs" align="right"  style="display:inline"><?php echo $totalBs; ?></div><strong>&nbsp;&nbsp;Bs.</strong>			</td>
<td ><strong>Total $us </strong>&nbsp;&nbsp;</td>			
     		<td align="left" colspan="3"><div id="id_totalSus" align="right"  style="display:inline"><?php echo $totalSus;?></div>
     		<strong>&nbsp;&nbsp;$us</strong> <strong></strong>&nbsp;&nbsp;<?php echo $cambio_bs;?>&nbsp;Bs.<strong>Bolivianos</strong>
     		<div id="id_totalBsSus" align="right"  style="display:inline">0</div><strong>&nbsp;&nbsp;Bs.</strong>			</td>			
			</tr>
			
<tr align="right">
     		<td align="right" colspan="8"><strong>Total Pago:</strong>&nbsp;&nbsp;<div id="id_totalPagoProveedorBs" align="right"  style="display:inline"><?php echo ($totalBs+($totalSus*$cambio_bs))?></div><strong>&nbsp;&nbsp;Bs.</strong>
			<a href="javascript:distribuirDinero();"><img src="images/repartir.jpg" width="30" height="30" border="0" title="Distribuir"></a></td>
			</tr>
</table></td>
</tr>
        </table>

        <div align="center">
        <INPUT type="button" class="boton" name="btn_guardar" value="Guardar Pago" onClick="guardar(this.form);"  >
        </div>

</form>

</body>
</html>
