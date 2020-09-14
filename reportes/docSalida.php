<?php
require("conexion1.inc");
require("fpdf.php");

include("funcionesNumerosALetras.php");


class PDF extends FPDF
{

//Cabecera de página
	function Header()
	{	

	
			
	}

	//Pie de página
	function Footer()		
	{	
		
	}

}	
				
	$pdf=new PDF('P','mm',array(214,300));

 	//$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','b',8);
	$pdf->SetAutoPageBreak(true,5);
		

	/////////////////////////////////////PAGO///////////////	
	$sql=" select  s.cod_tipo_salida,ts.nombre_tipo_salida,ts.leyenda,  s.nro_salida, s.cod_gestion, g.gestion_nombre, s.cod_almacen, a.nombre_almacen,";
	$sql.="  s.fecha_salida, s.cod_usuario_salida, u.nombres_usuario, u.ap_paterno_usuario, u.ap_materno_usuario, ";
	$sql.="  s.obs_salida,s.cod_almacen_traspaso,s.cod_hoja_ruta,s.cliente_venta,";
	$sql.="  s.cod_estado_salida,esa.desc_estado_salida, s.cod_usuario_modifica,s.fecha_modifica,s.fecha_anulacion, s.cod_usuario_anulacion, s.obs_anulacion,";
	$sql.="  s.cod_orden_trabajo,s.cod_cliente_venta,s.cod_contacto, s.cod_tipo_pago,s.cod_area, s.cod_usuario, s.cod_estado_pago_doc";
	$sql.="  from salidas s";
	$sql.="  left join tipos_salida ts on(s.cod_tipo_salida=ts.cod_tipo_salida)";
	$sql.="  left join  gestiones g on(s.cod_gestion=g.cod_gestion)";
	$sql.="  left join almacenes a on(s.cod_almacen=a.cod_almacen)";	
	$sql.="  left join  estados_salidas_almacen esa on(s.cod_estado_salida=esa.cod_estado_salida)";
	$sql.="  left join usuarios u on(s.cod_usuario_salida=u.cod_usuario)";
	$sql.="  where s.cod_salida=".$_GET['cod_salida'];
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		
			$cod_tipo_salida=$dat['cod_tipo_salida'];
			$nombre_tipo_salida=$dat['nombre_tipo_salida'];
			$leyenda=$dat['leyenda'];
			$nro_salida=$dat['nro_salida'];
			$cod_gestion=$dat['cod_gestion'];
			$gestion_nombre=$dat['gestion_nombre'];
			$cod_almacen=$dat['cod_almacen'];
			$nombre_almacen=$dat['nombre_almacen'];
			$fecha_salida=$dat['fecha_salida'];
			$cod_usuario_salida=$dat['cod_usuario_salida'];
			$usuario_salida= $dat['nombres_usuario']." ".$dat['ap_paterno_usuario']." ".$dat['ap_materno_usuario'];
			$obs_salida=$dat['obs_salida'];
			$cod_almacen_traspaso=$dat['cod_almacen_traspaso'];
			$cod_hoja_ruta=$dat['cod_hoja_ruta'];
			$cliente_venta=$dat['cliente_venta'];
			$cod_estado_salida=$dat['cod_estado_salida'];
			$desc_estado_salida=$dat['desc_estado_salida'];
			$cod_usuario_modifica=$dat['cod_usuario_modifica'];
			$fecha_modifica=$dat['fecha_modifica'];
			$fecha_anulacion=$dat['fecha_anulacion'];
			$cod_usuario_anulacion=$dat['cod_usuario_anulacion'];
			$obs_anulacion=$dat['obs_anulacion'];
			$cod_orden_trabajo=$dat['cod_orden_trabajo'];
			$cod_cliente_venta=$dat['cod_cliente_venta'];
			$cod_contacto=$dat['cod_contacto'];
			$cod_tipo_pago=$dat['cod_tipo_pago'];
			$cod_area=$dat['cod_area'];
			$cod_usuario=$dat['cod_usuario'];
			$cod_estado_pago_doc=$dat['cod_estado_pago_doc'];
				
	}


/**********************DATOS DE CABECERA*********************/

	
		$sql5="select  valor_x, valor_y from coordenadas_impresion where cod_coordenada=1";
		$resp5=mysql_query($sql5);
		while ($dat5=mysql_fetch_array($resp5)){
			$valorX=$dat5[0];
			$valorY=$dat5[1];
		}


		/**********************Fin Datos de Cliente******************************/	

			$pdf->SetY(36);

						
			$pdf->SetFont('Arial','B',14);
			$pdf->SetTextColor(0,0,0);
			$pdf->Cell(0,5,"ENTREGA DE MATERIAL POR ".strtoupper($nombre_tipo_salida),0,1,'C');			
			$pdf->SetFont('Arial','B',12);		
			$pdf->Cell(0,5,"NRO. ".$nro_salida,0,1,'C');		
			$pdf->Cell(0,5,"FECHA: ".strftime("%d/%m/%Y",strtotime($fecha_salida)),0,1,'C');
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,5,$nombre_almacen,0,1,'R');
//			$pdf->Text(85,50,"FECHA: ".strftime("%d/%m/%Y",strtotime($fecha_salida)));	
						
			$val_Y_cabecera=56;
			$pdf->SetFont('Arial','B',10);
			$pdf->SetXY(12,$val_Y_cabecera);
			if($cod_tipo_salida==1){
				$nombre_contacto="";
						if($cod_cliente_venta<>""){
							$sqlAux="select nombre_cliente from clientes where cod_cliente=".$cod_cliente_venta;
							$respAux = mysql_query($sqlAux);
							while($datAux=mysql_fetch_array($respAux)){	
								$nombre_cliente_venta=$datAux['nombre_cliente'];
							}	
							if($cod_contacto<>""){
								$sqlAux=" select nombre_contacto, ap_paterno_contacto from clientes_contactos ";
								$sqlAux.=" where cod_contacto=".$cod_contacto;
								$respAux = mysql_query($sqlAux);
								while($datAux=mysql_fetch_array($respAux)){	
									$nombre_contacto=$datAux['nombre_contacto'];
									$ap_paterno_contacto=$datAux['ap_paterno_contacto'];
								}
							}
						}
		
						if($cod_tipo_pago<>""){
							$sqlAux="select nombre_tipo_pago from tipos_pago where cod_tipo_pago=".$cod_tipo_pago;
							$respAux = mysql_query($sqlAux);
							while($datAux=mysql_fetch_array($respAux)){	
								$nombre_tipo_pago=$datAux['nombre_tipo_pago'];
							}
						}
				
				$pdf->SetFont('Arial','B',10);
				$pdf->SetX(12);	
				$pdf->Cell(0,5,$leyenda." :",0,0,'L');
				$pdf->SetFont('Arial','',10);
				$pdf->SetX(45);	
				if($nombre_contacto<>""){
					$pdf->Cell(0,5,$cliente_venta.$nombre_cliente_venta."( ".$nombre_contacto." ".$ap_paterno_contacto.")",0,1,'L');
				}else{
					$pdf->Cell(0,5,$cliente_venta.$nombre_cliente_venta,0,1,'L');
				}		
			
				$pdf->SetFont('Arial','B',10);
				$pdf->SetX(12);
				$pdf->Cell(0,5,"TIPO DE PAGO: ",0,0,'L');
				$pdf->SetX(45);	
				$pdf->SetFont('Arial','',10);					
				$pdf->Cell(0,5,$nombre_tipo_pago,0,1,'L');
			
			 }	
			 
			 if($cod_tipo_salida==2 or $cod_tipo_salida==4){
			 		$sql2=" select  hr.nro_hoja_ruta, hr.cod_gestion,g.gestion, hr.fecha_hoja_ruta, hr.cod_cotizacion, hr.factura_si_no,";
					$sql2.=" c.nro_cotizacion, c.fecha_cotizacion, c.cod_cliente, cli.nombre_cliente ";
					$sql2.=" from hojas_rutas hr, gestiones g, cotizaciones c, clientes cli ";
					$sql2.=" where hr.cod_hoja_ruta=".$cod_hoja_ruta;
					$sql2.=" and hr.cod_gestion=g.cod_gestion ";
					$sql2.=" and hr.cod_cotizacion=c.cod_cotizacion ";
					$sql2.=" and c.cod_cliente=cli.cod_cliente ";
					$resp2= mysql_query($sql2);
					$nro_hoja_ruta_salida="";
					$cod_gestion_salida="";
					$gestion_salida="";
					$cod_cotizacion_salida="";
					$cod_cliente_salida="";
					$nombre_cliente_salida="";
					while($dat2=mysql_fetch_array($resp2)){					
						$nro_hoja_ruta_salida=$dat2['nro_hoja_ruta'];
						$cod_gestion_salida=$dat2['cod_gestion'];
						$gestion_hoja_ruta_salida=$dat2['gestion'];
						$fecha_hoja_ruta=$dat2['fecha_hoja_ruta'];
						$cod_cotizacion_salida=$dat2['cod_cotizacion'];
						$factura_si_no=$dat2['factura_si_no'];
						$nro_cotizacion=$dat2['nro_cotizacion'];
						$fecha_cotizacion=$dat2['fecha_cotizacion'];
						$cod_cliente_salida=$dat2['cod_cliente'];
						$nombre_cliente_salida=$dat2['nombre_cliente'];
					
					}
			 
			 	$pdf->SetFont('Arial','B',10);
				$pdf->SetX(12);	
				$pdf->Cell(0,5,$leyenda." :",0,0,'L');
				$pdf->SetFont('Arial','',10);
				$pdf->SetX(45);			
				$pdf->Cell(0,5,"Nº ".$nro_hoja_ruta_salida." (".strftime("%d/%m/%Y",strtotime($fecha_hoja_ruta)).") ".$nombre_cliente_salida,0,1,'L');
				$pdf->SetFont('Arial','B',10);
				$pdf->SetX(12);
				$pdf->Cell(0,5,"COT. :",0,0,'L');
				$pdf->SetX(45);	
				$pdf->SetFont('Arial','',10);					
				$pdf->Cell(0,5,"Nº ".$nro_cotizacion." (".strftime("%d/%m/%Y",strtotime($fecha_cotizacion)).")  C".$factura_si_no,0,1,'L');
  		
		
		 }	
		if($cod_tipo_salida==3){
				$sql2="select nombre_almacen from almacenes where cod_almacen='".$cod_almacen_traspaso."'";
				$resp2= mysql_query($sql2);
				$nombre_almacen_traspaso="";
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_almacen_traspaso=$dat2[0];
				}	
				$pdf->SetFont('Arial','B',10);
				$pdf->SetX(12);	
				$pdf->Cell(0,5,$leyenda.": ",0,0,'L');
				$pdf->SetFont('Arial','',10);
				$pdf->SetX(45);			
				$pdf->Cell(0,5,$nombre_almacen_traspaso,0,1,'L');
				

		}
		if($cod_tipo_salida==5){
						$sql2="select  numero_orden_trabajo, fecha_orden_trabajo, ";
						$sql2.=" cod_cliente, obs_orden_trabajo, monto_orden_trabajo,nro_orden_trabajo, cod_gestion ";
						$sql2.=" from ordentrabajo ";
						$sql2.=" where cod_orden_trabajo=".$cod_orden_trabajo;		
						$resp2= mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2)){
						//////////////////////////////////

							$numero_orden_trabajo=$dat2['numero_orden_trabajo']; 
							$fecha_orden_trabajo=$dat2['fecha_orden_trabajo']; 
							$cod_cliente=$dat2['cod_cliente']; 
							$obs_orden_trabajo=$dat2['obs_orden_trabajo']; 
							$monto_orden_trabajo=$dat2['monto_orden_trabajo']; 
							$nro_orden_trabajo=$dat2['nro_orden_trabajo'];
							$cod_gestion_ot=$dat2['cod_gestion'];
						}
						
						$nombre_cliente_orden_trabajo="";
						$sql2="select nombre_cliente from clientes where cod_cliente='".$cod_cliente."'";
						$resp2= mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2)){
							$nombre_cliente_orden_trabajo=$dat2['nombre_cliente'];
						}	
				$pdf->SetFont('Arial','B',10);
				$pdf->SetX(12);	
				$pdf->Cell(0,5,$leyenda.": ",0,0,'L');
				$pdf->SetFont('Arial','',10);
				$pdf->SetX(45);			
				$pdf->Cell(0,5,"Nº ".$nro_orden_trabajo." (".strftime("%d/%m/%Y",strtotime($fecha_orden_trabajo)).") ".$nombre_cliente_orden_trabajo,0,1,'L');

		}
		if($cod_tipo_salida==6){
				$nombre_area="";
					$usuario_uso_interno="";
					if($cod_area<>""){
						$sql2="select  nombre_area";
						$sql2.=" from areas ";
						$sql2.=" where cod_area=".$cod_area;		
						$resp2= mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2)){
							$nombre_area=$dat2['nombre_area']; 
						}
					}
					if($cod_usuario<>""){
						$sql2="select nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
						$sql2.=" from usuarios ";
						$sql2.=" where cod_usuario=".$cod_usuario;		
						$resp2= mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2)){
							$usuario_uso_interno=$dat2['ap_paterno_usuario']." ".$dat2['ap_materno_usuario']." ".$dat2['nombres_usuario']; 

						}
					}	
					$pdf->SetFont('Arial','B',10);
				$pdf->SetX(12);	
				$pdf->Cell(0,5,$leyenda.": ",0,0,'L');
				$pdf->SetFont('Arial','',10);
				$pdf->SetX(45);			
				$pdf->Cell(0,5,$nombre_area ." - ".$usuario_uso_interno,0,1,'L');
		
		}
   
		

	
	$y=75;
	$x=34;
	$pdf->SetFont('Arial','B',8);
	$pdf->SetXY($x,$y);
	$pdf->SetX(14);
	$pdf->Cell(8,4,"Nº",1,0,'C',false);
	$pdf->Cell(90,4,"Material",1,0,'C',false);
	$pdf->Cell(20,4,"Cantidad",1,0,'C',false); 
	$pdf->Cell(10,4,"",1,0,'C',false);
	if($cod_tipo_salida==1){  
		$pdf->Cell(30,4,"Precio Unitario",1,0,'C',false);  
		$pdf->Cell(30,4,"Importe",1,1,'C',false);
	}else{
		
		$pdf->Cell(60,4,"Costo Total",1,1,'C',false);
	}
	
			$costoTotalSalida=0;
			$precioVentaTotalSalida=0;
		 	$sql=" select sd.cod_material, m.desc_completa_material, m.cod_unidad_medida, ";
			$sql.=" um.abrev_unidad_medida, sd.cant_salida, sd.precio_venta ";
			$sql.=" from salidas_detalle sd, materiales m, unidades_medidas um ";
			$sql.=" where sd.cod_salida=".$_GET['cod_salida'];
			$sql.=" and sd.cod_material=m.cod_material ";
			$sql.=" and m.cod_unidad_medida=um.cod_unidad_medida ";
			$resp = mysql_query($sql);
			$correlativo=0;
			while($dat=mysql_fetch_array($resp)){
			$sw=0;
			$correlativo=$correlativo+1;
				$cod_material=$dat[0];
				$desc_completa_material=$dat[1];
				$cod_unidad_medida=$dat[2];
				$abrev_unidad_medida=$dat[3];
				$cant_salida=$dat[4];
				$precio_venta=$dat[5];	
				$precioVentaTotalSalida=$precioVentaTotalSalida+($cant_salida*$precio_venta);	
				
				//////////////////////////////////////////
					$costoTotal=0;
					$sql2=" select cant_salida_ingreso, cod_ingreso_detalle from salidas_detalle_ingresos ";
					$sql2.=" WHERE cod_salida=".$cod_salida." and cod_material=".$cod_material;
					$resp2 = mysql_query($sql2);					
					while($dat2=mysql_fetch_array($resp2)){
						$cant_salida_ingreso=$dat2[0];
						$cod_ingreso_detalle=$dat2[1];						
						
						$sql3=" select ig.cod_ingreso, i.nro_ingreso, i.cod_gestion, g.gestion, ig.precio_compra_uni";
						$sql3.=" from ingresos_detalle ig, ingresos i, gestiones g ";
						$sql3.=" where ig.cod_ingreso=i.cod_ingreso  and  g.cod_gestion=i.cod_gestion ";
						$sql3.=" and ig.cod_ingreso_detalle=".$cod_ingreso_detalle." and ig.cod_material=".$cod_material;
						$resp3 = mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3)){
							$cod_ingreso=$dat3[0];
							$nro_ingreso=$dat3[1];
							$cod_gestion_ingreso=$dat3[2];													
							$gestion_ingreso=$dat3[3];													
							$precio_compra_uni=$dat3[4];														
							$costoTotal=$costoTotal+($precio_compra_uni*$cant_salida_ingreso);	
					 }
					}	
					$costoTotalSalida=$costoTotalSalida+$costoTotal;			
				/////////////////////////////////////////
				
				$pdf->SetFont('Arial','',8);
				$pdf->SetX(14);
				$pdf->Cell(8,4,$correlativo,1,0,'L',false);
				$pdf->Cell(90,4,$desc_completa_material,1,0,'L',false);
				$pdf->Cell(20,4,number_format($cant_salida,1,'.',','),1,0,'R',false);  
				$pdf->Cell(10,4,$abrev_unidad_medida,1,0,'L',false);  
				if($cod_tipo_salida==1){  
					$pdf->Cell(30,4, number_format($precio_venta,2,'.',','),1,0,'R',false);  
					$pdf->Cell(30,4,number_format(($cant_salida*$precio_venta),2,',','.'),1,1,'R',false);	
				}else{
					 
					$pdf->Cell(60,4,number_format($costoTotal,2,'.',','),1,1,'R',false);	
				
				}

		}
		if($cod_tipo_salida==1){ 
			$pdf->SetFont('Arial','B',8);
			$pdf->SetX(14);
			$pdf->Cell(158,4," TOTAL Bs.",1,0,'R',false);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(30,4,number_format($precioVentaTotalSalida,2,'.',','),1,1,'R',false);
		//	$pdf->SetX(12);
		//	$pdf->Cell(0,4,"",0,1,'L'); 
		//	$pdf->Cell(0,4,"Son: ".convertir($precioVentaTotalSalida)." 00/100  Bolivianos.",0,1,'R');  	
		}else{
			$pdf->SetFont('Arial','B',8);
			$pdf->SetX(14);
			$pdf->Cell(128,4," TOTAL Bs.",1,0,'R',false);
				$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,4,number_format($costoTotalSalida,2,'.',','),1,1,'R',false);	
		//	$pdf->SetX(12);
		//	$pdf->Cell(0,4,"",0,1,'L');  
		//	$pdf->Cell(0,4,"Son: ".convertir($costoTotalSalida)." 00/100  Bolivianos.",0,1,'R');  
		}
		


		
	
	
	

		$pdf->SetFont('Arial','B',8);
		$pdf->SetXY(30,120);
		$pdf->Cell(30,1,".........................................................",0,1,'C',false);
		$pdf->SetX(30);
		$pdf->Cell(30,4,"Recibi Conforme",0,1,'C',false);
		$pdf->SetX(30);
		$pdf->Cell(30,8,"Nombre:................................................ ",0,1,'C',false);
		
		$pdf->SetXY(155,120);
		$pdf->Cell(30,1,".........................................................",0,1,'C',false);
		$pdf->SetX(155);
		$pdf->Cell(30,4,"Entregue Conforme",0,1,'C',false);
		$pdf->SetX(155);
		$pdf->Cell(30,8,"Nombre: ".$usuario_salida,0,1,'C',false);
		
//////////////////////////COPIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////////////////////////////

$pdf->SetY(190);

						
			$pdf->SetFont('Arial','B',14);
			$pdf->SetTextColor(0,0,0);
			$pdf->Cell(0,5,"ENTREGA DE MATERIAL POR ".strtoupper($nombre_tipo_salida),0,1,'C');			
			$pdf->SetFont('Arial','B',12);		
			$pdf->Cell(0,5,"NRO. ".$nro_salida,0,1,'C');		
			$pdf->Cell(0,5,"FECHA: ".strftime("%d/%m/%Y",strtotime($fecha_salida)),0,1,'C');
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,5,$nombre_almacen,0,1,'R');
//			$pdf->Text(85,50,"FECHA: ".strftime("%d/%m/%Y",strtotime($fecha_salida)));	
						
			$val_Y_cabecera=214;
			$pdf->SetFont('Arial','B',10);
			$pdf->SetXY(12,$val_Y_cabecera);
			if($cod_tipo_salida==1){
				$nombre_contacto="";
						if($cod_cliente_venta<>""){
							$sqlAux="select nombre_cliente from clientes where cod_cliente=".$cod_cliente_venta;
							$respAux = mysql_query($sqlAux);
							while($datAux=mysql_fetch_array($respAux)){	
								$nombre_cliente_venta=$datAux['nombre_cliente'];
							}	
							if($cod_contacto<>""){
								$sqlAux=" select nombre_contacto, ap_paterno_contacto from clientes_contactos ";
								$sqlAux.=" where cod_contacto=".$cod_contacto;
								$respAux = mysql_query($sqlAux);
								while($datAux=mysql_fetch_array($respAux)){	
									$nombre_contacto=$datAux['nombre_contacto'];
									$ap_paterno_contacto=$datAux['ap_paterno_contacto'];
								}
							}
						}
		
						if($cod_tipo_pago<>""){
							$sqlAux="select nombre_tipo_pago from tipos_pago where cod_tipo_pago=".$cod_tipo_pago;
							$respAux = mysql_query($sqlAux);
							while($datAux=mysql_fetch_array($respAux)){	
								$nombre_tipo_pago=$datAux['nombre_tipo_pago'];
							}
						}
				
				$pdf->SetFont('Arial','B',10);
				$pdf->SetX(12);	
				$pdf->Cell(0,5,$leyenda." :",0,0,'L');
				$pdf->SetFont('Arial','',10);
				$pdf->SetX(45);	
				if($nombre_contacto<>""){
					$pdf->Cell(0,5,$cliente_venta.$nombre_cliente_venta."( ".$nombre_contacto." ".$ap_paterno_contacto.")",0,1,'L');
				}else{
					$pdf->Cell(0,5,$cliente_venta.$nombre_cliente_venta,0,1,'L');
				}		
			
				$pdf->SetFont('Arial','B',10);
				$pdf->SetX(12);
				$pdf->Cell(0,5,"TIPO DE PAGO: ",0,0,'L');
				$pdf->SetX(45);	
				$pdf->SetFont('Arial','',10);					
				$pdf->Cell(0,5,$nombre_tipo_pago,0,1,'L');
			
			 }	
			 
			 if($cod_tipo_salida==2 or $cod_tipo_salida==4){
			 		$sql2=" select  hr.nro_hoja_ruta, hr.cod_gestion,g.gestion, hr.fecha_hoja_ruta, hr.cod_cotizacion, hr.factura_si_no,";
					$sql2.=" c.nro_cotizacion, c.fecha_cotizacion, c.cod_cliente, cli.nombre_cliente ";
					$sql2.=" from hojas_rutas hr, gestiones g, cotizaciones c, clientes cli ";
					$sql2.=" where hr.cod_hoja_ruta=".$cod_hoja_ruta;
					$sql2.=" and hr.cod_gestion=g.cod_gestion ";
					$sql2.=" and hr.cod_cotizacion=c.cod_cotizacion ";
					$sql2.=" and c.cod_cliente=cli.cod_cliente ";
					$resp2= mysql_query($sql2);
					$nro_hoja_ruta_salida="";
					$cod_gestion_salida="";
					$gestion_salida="";
					$cod_cotizacion_salida="";
					$cod_cliente_salida="";
					$nombre_cliente_salida="";
					while($dat2=mysql_fetch_array($resp2)){					
						$nro_hoja_ruta_salida=$dat2['nro_hoja_ruta'];
						$cod_gestion_salida=$dat2['cod_gestion'];
						$gestion_hoja_ruta_salida=$dat2['gestion'];
						$fecha_hoja_ruta=$dat2['fecha_hoja_ruta'];
						$cod_cotizacion_salida=$dat2['cod_cotizacion'];
						$factura_si_no=$dat2['factura_si_no'];
						$nro_cotizacion=$dat2['nro_cotizacion'];
						$fecha_cotizacion=$dat2['fecha_cotizacion'];
						$cod_cliente_salida=$dat2['cod_cliente'];
						$nombre_cliente_salida=$dat2['nombre_cliente'];
					
					}
			 
			 	$pdf->SetFont('Arial','B',10);
				$pdf->SetX(12);	
				$pdf->Cell(0,5,$leyenda." :",0,0,'L');
				$pdf->SetFont('Arial','',10);
				$pdf->SetX(45);			
				$pdf->Cell(0,5,"Nº ".$nro_hoja_ruta_salida." (".strftime("%d/%m/%Y",strtotime($fecha_hoja_ruta)).") ".$nombre_cliente_salida,0,1,'L');
				$pdf->SetFont('Arial','B',10);
				$pdf->SetX(12);
				$pdf->Cell(0,5,"COT. :",0,0,'L');
				$pdf->SetX(45);	
				$pdf->SetFont('Arial','',10);					
				$pdf->Cell(0,5,"Nº ".$nro_cotizacion." (".strftime("%d/%m/%Y",strtotime($fecha_cotizacion)).")  C".$factura_si_no,0,1,'L');
  		
		
		 }	
		if($cod_tipo_salida==3){
				$sql2="select nombre_almacen from almacenes where cod_almacen='".$cod_almacen_traspaso."'";
				$resp2= mysql_query($sql2);
				$nombre_almacen_traspaso="";
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_almacen_traspaso=$dat2[0];
				}	
				$pdf->SetFont('Arial','B',10);
				$pdf->SetX(12);	
				$pdf->Cell(0,5,$leyenda.": ",0,0,'L');
				$pdf->SetFont('Arial','',10);
				$pdf->SetX(45);			
				$pdf->Cell(0,5,$nombre_almacen_traspaso,0,1,'L');
				

		}
		if($cod_tipo_salida==5){
						$sql2="select  numero_orden_trabajo, fecha_orden_trabajo, ";
						$sql2.=" cod_cliente, obs_orden_trabajo, monto_orden_trabajo,nro_orden_trabajo, cod_gestion ";
						$sql2.=" from ordentrabajo ";
						$sql2.=" where cod_orden_trabajo=".$cod_orden_trabajo;		
						$resp2= mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2)){
						//////////////////////////////////

							$numero_orden_trabajo=$dat2['numero_orden_trabajo']; 
							$fecha_orden_trabajo=$dat2['fecha_orden_trabajo']; 
							$cod_cliente=$dat2['cod_cliente']; 
							$obs_orden_trabajo=$dat2['obs_orden_trabajo']; 
							$monto_orden_trabajo=$dat2['monto_orden_trabajo']; 
							$nro_orden_trabajo=$dat2['nro_orden_trabajo'];
							$cod_gestion_ot=$dat2['cod_gestion'];
						}
						
						$nombre_cliente_orden_trabajo="";
						$sql2="select nombre_cliente from clientes where cod_cliente='".$cod_cliente."'";
						$resp2= mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2)){
							$nombre_cliente_orden_trabajo=$dat2['nombre_cliente'];
						}	
				$pdf->SetFont('Arial','B',10);
				$pdf->SetX(12);	
				$pdf->Cell(0,5,$leyenda.": ",0,0,'L');
				$pdf->SetFont('Arial','',10);
				$pdf->SetX(45);			
				$pdf->Cell(0,5,"Nº ".$nro_orden_trabajo." (".strftime("%d/%m/%Y",strtotime($fecha_orden_trabajo)).") ".$nombre_cliente_orden_trabajo,0,1,'L');

		}
		if($cod_tipo_salida==6){
				$nombre_area="";
					$usuario_uso_interno="";
					if($cod_area<>""){
						$sql2="select  nombre_area";
						$sql2.=" from areas ";
						$sql2.=" where cod_area=".$cod_area;		
						$resp2= mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2)){
							$nombre_area=$dat2['nombre_area']; 
						}
					}
					if($cod_usuario<>""){
						$sql2="select nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
						$sql2.=" from usuarios ";
						$sql2.=" where cod_usuario=".$cod_usuario;		
						$resp2= mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2)){
							$usuario_uso_interno=$dat2['ap_paterno_usuario']." ".$dat2['ap_materno_usuario']." ".$dat2['nombres_usuario']; 

						}
					}	
					$pdf->SetFont('Arial','B',10);
				$pdf->SetX(12);	
				$pdf->Cell(0,5,$leyenda.": ",0,0,'L');
				$pdf->SetFont('Arial','',10);
				$pdf->SetX(45);			
				$pdf->Cell(0,5,$nombre_area ." - ".$usuario_uso_interno,0,1,'L');
		
		}
   
		

	
	$y=229;
	$x=34;
	$pdf->SetFont('Arial','B',8);
	$pdf->SetXY($x,$y);
	$pdf->SetX(14);
	$pdf->Cell(8,4,"Nº",1,0,'C',false);
	$pdf->Cell(90,4,"Material",1,0,'C',false);
	$pdf->Cell(20,4,"Cantidad",1,0,'C',false); 
	$pdf->Cell(10,4,"",1,0,'C',false);
	if($cod_tipo_salida==1){  
		$pdf->Cell(30,4,"Precio Unitario",1,0,'C',false);  
		$pdf->Cell(30,4,"Importe",1,1,'C',false);
	}else{
		
		$pdf->Cell(60,4,"Costo Total",1,1,'C',false);
	}
	
			$costoTotalSalida=0;
			$precioVentaTotalSalida=0;
		 	$sql=" select sd.cod_material, m.desc_completa_material, m.cod_unidad_medida, ";
			$sql.=" um.abrev_unidad_medida, sd.cant_salida, sd.precio_venta ";
			$sql.=" from salidas_detalle sd, materiales m, unidades_medidas um ";
			$sql.=" where sd.cod_salida=".$_GET['cod_salida'];
			$sql.=" and sd.cod_material=m.cod_material ";
			$sql.=" and m.cod_unidad_medida=um.cod_unidad_medida ";
			$resp = mysql_query($sql);
			$correlativo=0;
			while($dat=mysql_fetch_array($resp)){
			$sw=0;
			$correlativo=$correlativo+1;
				$cod_material=$dat[0];
				$desc_completa_material=$dat[1];
				$cod_unidad_medida=$dat[2];
				$abrev_unidad_medida=$dat[3];
				$cant_salida=$dat[4];
				$precio_venta=$dat[5];	
				$precioVentaTotalSalida=$precioVentaTotalSalida+($cant_salida*$precio_venta);	
				
				//////////////////////////////////////////
					$costoTotal=0;
					$sql2=" select cant_salida_ingreso, cod_ingreso_detalle from salidas_detalle_ingresos ";
					$sql2.=" WHERE cod_salida=".$cod_salida." and cod_material=".$cod_material;
					$resp2 = mysql_query($sql2);					
					while($dat2=mysql_fetch_array($resp2)){
						$cant_salida_ingreso=$dat2[0];
						$cod_ingreso_detalle=$dat2[1];						
						
						$sql3=" select ig.cod_ingreso, i.nro_ingreso, i.cod_gestion, g.gestion, ig.precio_compra_uni";
						$sql3.=" from ingresos_detalle ig, ingresos i, gestiones g ";
						$sql3.=" where ig.cod_ingreso=i.cod_ingreso  and  g.cod_gestion=i.cod_gestion ";
						$sql3.=" and ig.cod_ingreso_detalle=".$cod_ingreso_detalle." and ig.cod_material=".$cod_material;
						$resp3 = mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3)){
							$cod_ingreso=$dat3[0];
							$nro_ingreso=$dat3[1];
							$cod_gestion_ingreso=$dat3[2];													
							$gestion_ingreso=$dat3[3];													
							$precio_compra_uni=$dat3[4];														
							$costoTotal=$costoTotal+($precio_compra_uni*$cant_salida_ingreso);	
					 }
					}	
					$costoTotalSalida=$costoTotalSalida+$costoTotal;			
				/////////////////////////////////////////
				
				$pdf->SetFont('Arial','',8);
				$pdf->SetX(14);
				$pdf->Cell(8,4,$correlativo,1,0,'L',false);
				$pdf->Cell(90,4,$desc_completa_material,1,0,'L',false);
				$pdf->Cell(20,4,number_format($cant_salida,1,'.',','),1,0,'R',false);  
				$pdf->Cell(10,4,$abrev_unidad_medida,1,0,'L',false);  
				if($cod_tipo_salida==1){  
					$pdf->Cell(30,4, number_format($precio_venta,2,'.',','),1,0,'R',false);  
					$pdf->Cell(30,4,number_format(($cant_salida*$precio_venta),2,'.',','),1,1,'R',false);	
				}else{
					 
					$pdf->Cell(60,4,number_format($costoTotal,2,'.',','),1,1,'R',false);	
				
				}

		}
		if($cod_tipo_salida==1){ 
			$pdf->SetFont('Arial','B',8);
			$pdf->SetX(14);
			$pdf->Cell(158,4," TOTAL Bs.",1,0,'R',false);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(30,4,number_format($precioVentaTotalSalida,2,'.',','),1,1,'R',false);
			//$pdf->SetX(12);
			//$pdf->Cell(0,4,"",0,1,'L'); 
		//	$pdf->Cell(100,4,"Son: ".convertir(number_format($precioVentaTotalSalida,2,',','.'))." 00/100  Bolivianos.",0,1,'C');  	
		}else{
			$pdf->SetFont('Arial','B',8);
			$pdf->SetX(14);
			$pdf->Cell(128,4," TOTAL Bs.",1,0,'R',false);
				$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,4,number_format($costoTotalSalida,2,'.',','),1,1,'R',false);	
			//$pdf->SetX(12);
		//	$pdf->Cell(0,4,"",0,1,'L');  
		//	$pdf->Cell(100,4,"Son: ".convertir($costoTotalSalida)." 00/100  Bolivianos.",0,1,'c');  
		}


	
	
	

		$pdf->SetFont('Arial','B',8);
		$pdf->SetXY(30,270);
		$pdf->Cell(30,1,".........................................................",0,1,'C',false);
		$pdf->SetX(30);
		$pdf->Cell(30,4,"Recibi Conforme",0,1,'C',false);
		$pdf->SetX(30);
		$pdf->Cell(30,8,"Nombre:................................................ ",0,1,'C',false);
		
		$pdf->SetXY(155,270);
		$pdf->Cell(30,1,".........................................................",0,1,'C',false);
		$pdf->SetX(155);
		$pdf->Cell(30,4,"Entregue Conforme",0,1,'C',false);
		$pdf->SetX(155);
		$pdf->Cell(30,8,"Nombre: ".$usuario_salida,0,1,'C',false);
		

	 $pdf->Output();


require("cerrar_conexion.inc");
?>


