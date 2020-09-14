<?php
require("conexion1.inc");
require("fpdf.php");

include("funcionesNumerosALetras.php");


class PDF extends FPDF
{

//Cabecera de página
	function Header()
	{	
		$this->Image('punto.jpg',1,1,0);
	
			
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
		
		$cod_pago=$_GET['cod_pago'];
	/////////////////////////////////////PAGO///////////////	
	$sql=" select  p.nro_pago, p.cod_gestion, g.gestion, ";
	$sql.=" p.cod_cliente, cli.nombre_cliente, cli.direccion_cliente, cli.telefono_cliente, cli.celular_cliente, cli.fax_cliente,";
	$sql.=" p.fecha_pago, p.cod_usuario_pago, p.obs_pago, p.monto_pago, ";
	$sql.=" p.cod_estado_pago, ep.desc_estado_pago, p.fecha_anulacion, p.obs_anulacion, p.cod_usuario_anulacion, p.fecha_registro ";
	$sql.=" from pagos p, gestiones g,  clientes cli, estados_pago ep ";
	$sql.=" where  p.cod_gestion=g.cod_gestion ";
	$sql.=" and p.cod_cliente=cli.cod_cliente ";
	$sql.=" and p.cod_estado_pago=ep.cod_estado_pago ";
	$sql.=" and p.cod_pago=".$_GET['cod_pago'];
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		
				$nro_pago=$dat['nro_pago'];				
				$cod_gestion=$dat['cod_pago'];
				$gestion=$dat['gestion'];
				$cod_cliente=$dat['cod_cliente'];
				$nombre_cliente=$dat['nombre_cliente'];	
				$direccion_cliente=$dat['direccion_cliente'];	
				$telefono_cliente=$dat['telefono_cliente'];	
				$celular_cliente=$dat['celular_cliente'];	
				$fax_cliente=$dat['fax_cliente'];								
				$fecha_pago=$dat['fecha_pago'];
				$cod_usuario_pago=$dat['cod_usuario_pago'];
				$obs_pago=$dat['obs_pago'];
				$monto_pago=$dat['monto_pago'];
				$cod_estado_pago=$dat['cod_estado_pago'];
				$desc_estado_pago=$dat['desc_estado_pago'];
				$fecha_anulacion=$dat['fecha_anulacion'];
				$obs_anulacion=$dat['obs_anulacion'];
				$cod_usuario_anulacion=$dat['cod_usuario_anulacion'];
				$fecha_registro=$dat['fecha_registro'];
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
				
	}


/**********************DATOS DE CABECERA*********************/

	
		$sql5="select  valor_x, valor_y from coordenadas_impresion where cod_coordenada=1";
		$resp5=mysql_query($sql5);
		while ($dat5=mysql_fetch_array($resp5)){
			$valorX=$dat5[0];
			$valorY=$dat5[1];
		}


		/**********************Fin Datos de Cliente******************************/	

			$pdf->SetFont('Arial','B',10);
			$pdf->SetTextColor(0,0,0);	
			$pdf->SetFont('Arial','B',9);
			$pdf->SetXY(160,16);

						
			$pdf->SetFont('Arial','B',14);
			$pdf->SetTextColor(0,0,0);
			$pdf->Text(85,40,"RECIBO OFICIAL");
			$pdf->SetFont('Arial','B',12);
			$pdf->SetTextColor(0,0,0);
			$pdf->Text(87,45,"NRO. ".$nro_pago."/".$gestion);	
			$pdf->SetFont('Arial','B',12);
			$pdf->SetTextColor(0,0,0);
			$pdf->Text(85,50,"FECHA: ".strftime("%d/%m/%Y",strtotime($fecha_pago)));	
						
			$val_Y_cabecera=55;
			$pdf->SetFont('Arial','B',10);
			$pdf->SetXY(12,$val_Y_cabecera);
			$pdf->Cell(0,5,'Hemos Recibido de:',0,0,'L');
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(48,$val_Y_cabecera);
			$pdf->Cell(0,5,$nombre_cliente,0,0,'L');
		
						
			/*$val_Y_cabecera=$val_Y_cabecera+5;			
			$pdf->SetXY(12,$val_Y_cabecera);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,5,'OBS:',0,0,'L');
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(36,$val_Y_cabecera);
			$pdf->Cell(0,5,$obs_pago,0,0,'L');*/
			$x=160;
			$y=30;
			
			$sql=" select cod_moneda,desc_moneda, abrev_moneda from monedas ";
			$resp = mysql_query($sql);
			while($dat=mysql_fetch_array($resp)){
			$cod_moneda=$dat['cod_moneda'];
			$desc_moneda=$dat['desc_moneda'];
			$abrev_moneda=$dat['abrev_moneda'];
			$sql2="select count(*) from pagos_descripcion where cod_pago=".$cod_pago." and cod_moneda=".$cod_moneda;
			$resp2= mysql_query($sql2);
			$nroPagoMoneda=0;
			while($dat2=mysql_fetch_array($resp2)){
				$nroPagoMoneda=$dat2[0];
			}
			if($nroPagoMoneda>0){
				$y=$y+5;
				$sql2="select sum(monto_pago)  from pagos_descripcion where cod_pago=".$cod_pago." and cod_moneda=".$cod_moneda;
				$resp2= mysql_query($sql2);
				$montoTotalPagoMoneda=0;
				while($dat2=mysql_fetch_array($resp2)){
					$montoTotalPagoMoneda=$dat2[0];
				}
				$pdf->SetXY($x,$y);
				$pdf->Cell(8,5,$abrev_moneda,0,0,'L');
				$pdf->Cell(25,5,number_format($montoTotalPagoMoneda, 2, ",", ".").".-",1,1,'L');
				
				if($cod_moneda<>1){
					$y=$y+5;				
					$sql3="select cambio_bs from tipo_cambio where cod_moneda=2 and fecha_tipo_cambio='".$fecha_registro."'";
					$resp3= mysql_query($sql3);
					$cambio_bs=0;
					while($dat3=mysql_fetch_array($resp3)){
						$cambio_bs=$dat3['cambio_bs'];
					}
					$pdf->SetXY($x,$y);
					$pdf->Cell(8,5,"T.C.",0,0,'L');
					$pdf->Cell(25,5,number_format($cambio_bs, 2, ",", ".").".-",1,1,'L');
				}		
		}
		
	}
	$y=60;
	$x=25;
	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY($x,$y);
	$pdf->Cell(10,4,"La suma de:",0,0,'R');
	$pdf->SetFont('Arial','',8);
	$sql3="select  fp.desc_forma_pago,pd.monto_pago, ba.desc_banco,pd.nro_cheque,pd.nro_cuenta,mo.desc_moneda";
	$sql3.=" from pagos_descripcion pd  inner join forma_pago fp on(pd.cod_forma_pago=fp.cod_forma_pago)";
	$sql3.=" left JOIN bancos ba on(pd.cod_banco=ba.cod_banco)";
	$sql3.=" left JOIN monedas mo on(pd.cod_moneda=mo.cod_moneda)";
	$sql3.=" where pd.cod_pago=".$cod_pago;
	$sql3.=" order by pd.cod_moneda,pd.cod_forma_pago";
	$resp3= mysql_query($sql3);
	while($dat3=mysql_fetch_array($resp3)){
		
		$desc_forma_pago=$dat3['desc_forma_pago'];
		$monto_pago_detalle=$dat3['monto_pago'];
		$desc_banco=$dat3['desc_banco'];
		$nro_cheque=$dat3['nro_cheque'];
		$nro_cuenta=$dat3['nro_cuenta'];
		$desc_moneda=$dat3['desc_moneda'];

		$pdf->SetX(35);
		$pdf->Cell(100,4,convertir($monto_pago_detalle)."00/100 ".$desc_moneda,0,0,'L');
		$pdf->SetX(130);
		$pdf->Cell(30,4,$desc_forma_pago." ".$nro_cheque.$nro_cuenta,0,0,'L');
		$pdf->SetX(165);
		$pdf->Cell(40,4,$desc_banco,0,1,'L');
		
	}
	$y=75;
	$x=34;
	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY($x,$y);
	$pdf->Cell(10,5,"Por Concepto de:",0,1,'R');
	$pdf->SetFont('Arial','',8);
	$pdf->SetX(14);
	         $pdf->Cell(7,4,"Doc",1,0,'C',false);
			 $pdf->Cell(15,4,"Nro",1,0,'C',false);  
			 $pdf->Cell(15,4,"Fecha",1,0,'C',false);  
			 $pdf->Cell(20,4,"Total",1,0,'C',false);
			 $pdf->Cell(93,4,"Descripcion",1,0,'C',false);
			 $pdf->Cell(20,4,"Pago",1,0,'C',false); 
			 $pdf->Cell(18,4,"Estado",1,1,'C',false);  
			  
			 	$pdf->SetFont('Arial','',8);
				$total_pago=0;          
				$sql2=" select pd.cod_pago_detalle, pd.codigo_doc, hr.nro_hoja_ruta, g.gestion,hr.fecha_hoja_ruta,";
				$sql2.="  hr.cod_estado_pago_doc, pd.monto_pago_detalle, pd.cod_forma_pago, pd.cod_banco,";
				$sql2.=" pd.cod_moneda, pd.nro_cheque, pd.nro_cuenta, pd.nro_comprobante, pd.fecha_comprobante";
				$sql2.=" from pagos_detalle pd, hojas_rutas hr, gestiones g ";
				$sql2.=" where pd.cod_pago=".$cod_pago;
				$sql2.=" and pd.codigo_doc=hr.cod_hoja_ruta ";
				$sql2.=" and pd.cod_tipo_doc=1 ";
				$sql2.=" and hr.cod_gestion=g.cod_gestion ";
				$sql2.=" order by hr.fecha_hoja_ruta asc ,hr.nro_hoja_ruta asc, g.gestion asc";
				$resp2 = mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$cod_pago_detalle=$dat2['cod_pago_detalle'];
					$cod_hoja_ruta=$dat2['codigo_doc'];
					$nro_hoja_ruta=$dat2['nro_hoja_ruta'];
					$gestion=$dat2['gestion'];
					$fecha_hoja_ruta=$dat2['fecha_hoja_ruta'];
					$cod_estado_pago_doc=$dat2['cod_estado_pago_doc'];
					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					$cod_forma_pago=$dat2['cod_forma_pago'];
					$cod_banco=$dat2['cod_banco'];
					$cod_moneda=$dat2['cod_moneda'];
					$nro_cheque=$dat2['nro_cheque'];
					$nro_cuenta=$dat2['nro_cuenta'];	
					$nro_comprobante=$dat2['nro_comprobante'];
					$fecha_comprobante=$dat2['fecha_comprobante'];		



			 		$monto_hojaruta=0;
			 		$sql3=" select sum(cd.IMPORTE_TOTAL) ";
					$sql3.=" from hojas_rutas_detalle hrd, cotizaciones_detalle cd ";
					$sql3.=" where hrd.cod_hoja_ruta=".$cod_hoja_ruta;
					$sql3.=" and hrd.cod_cotizacion=cd.cod_cotizacion ";
					$sql3.=" and hrd.cod_cotizaciondetalle=cd.cod_cotizaciondetalle ";
					$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$monto_hojaruta=$dat3[0];
					}
					$descripcion_hojaruta="";
			 		$sql3=" select items.desc_item,cd.descripcion_item ";
					$sql3.=" from hojas_rutas_detalle hrd, cotizaciones_detalle cd,items ";
					$sql3.=" where hrd.cod_hoja_ruta=".$cod_hoja_ruta;
					$sql3.=" and hrd.cod_cotizacion=cd.cod_cotizacion ";
					$sql3.=" and hrd.cod_cotizaciondetalle=cd.cod_cotizaciondetalle ";
					$sql3.=" and items.cod_item=cd.cod_item ";
					$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$desc_item=$dat3['desc_item'];
						$descripcion_item=$dat3['descripcion_item'];
						//$descripcion_hojaruta=$descripcion_hojaruta." ".$desc_item." ".$descripcion_item;
						$descripcion_hojaruta=$descripcion_hojaruta." ".$desc_item;
					}
					

					$descuento_cotizacion=0;
					$sql3=" select c.descuento_cotizacion ";
					$sql3.=" from hojas_rutas hr, cotizaciones c ";
					$sql3.=" where hr.cod_cotizacion=c.cod_cotizacion ";
					$sql3.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
					$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$descuento_cotizacion=$dat3['descuento_cotizacion'];
					}

					$incremento_cotizacion=0;
					$sql3=" select c.incremento_cotizacion ";
					$sql3.=" from hojas_rutas hr, cotizaciones c ";
					$sql3.=" where hr.cod_cotizacion=c.cod_cotizacion ";
					$sql3.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
					$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$incremento_cotizacion=$dat3['incremento_cotizacion'];
					}
				
					$monto_hojaruta=($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion;												
		   
		   	 $pdf->SetX(14);
 			$pdf->SetFont('Arial','',8);
	         $pdf->Cell(7,4,"HR",1,0,'C',false);
			 $pdf->Cell(15,4,$nro_hoja_ruta."/".strftime("%Y",strtotime($fecha_hoja_ruta)),1,0,'C',false);  
			 $pdf->Cell(15,4,strftime("%d/%m/%Y",strtotime($fecha_hoja_ruta)),1,0,'C',false);  
			 $pdf->Cell(20,4,number_format($monto_hojaruta, 2, ",", ".")." Bs",1,0,'R',false);  
			 $pdf->SetFont('Arial','',4);
			 $pdf->Cell(93,4,$descripcion_hojaruta,1,0,'L',false);  

			$sql3=" select desc_estado_pago_doc ";
			$sql3.=" from estado_pago_documento ";
			$sql3.=" where cod_estado_pago_doc=".$cod_estado_pago_doc;
			$resp3 = mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3)){
							$desc_estado_pago_doc=$dat3['desc_estado_pago_doc'];
				}
            

					$total_pago=$total_pago+$monto_pago_detalle;
		 			$pdf->SetFont('Arial','',8);
			$pdf->Cell(20,4,number_format($monto_pago_detalle, 2, ",", ".")." Bs",1,0,'R',false); 
			 			$pdf->SetFont('Arial','',5);
			 $pdf->Cell(18,4,$desc_estado_pago_doc,1,1,'C',false); 

         
      } 

        
				$sql2=" select pd.cod_pago_detalle, pd.codigo_doc, ot.nro_orden_trabajo, ot.numero_orden_trabajo, g.gestion, ";
				$sql2.=" ot.fecha_orden_trabajo, ot.cod_estado_pago_doc, pd.monto_pago_detalle, pd.cod_forma_pago, pd.cod_banco,";
				$sql2.=" pd.cod_moneda, pd.nro_cheque, pd.nro_cuenta, pd.nro_comprobante, pd.fecha_comprobante";

				$sql2.=" from pagos_detalle pd, ordentrabajo ot, gestiones g ";
				$sql2.=" where pd.cod_pago=".$cod_pago;
				$sql2.=" and pd.codigo_doc=ot.cod_orden_trabajo ";
				$sql2.=" and pd.cod_tipo_doc=2 ";
				$sql2.=" and ot.cod_gestion=g.cod_gestion ";
				$sql2.=" order by ot.nro_orden_trabajo asc, g.gestion asc";
				$resp2 = mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$cod_pago_detalle=$dat2['cod_pago_detalle'];
					$cod_orden_trabajo=$dat2['codigo_doc'];
					$nro_orden_trabajo=$dat2['nro_orden_trabajo'];
					$numero_orden_trabajo=$dat2['numero_orden_trabajo'];
					$gestion=$dat2['gestion'];
					$fecha_orden_trabajo=$dat2['fecha_orden_trabajo'];
					$cod_estado_pago_doc=$dat2['cod_estado_pago_doc'];
					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					$cod_forma_pago=$dat2['cod_forma_pago'];
					$cod_banco=$dat2['cod_banco'];
					$cod_moneda=$dat2['cod_moneda'];
					$nro_cheque=$dat2['nro_cheque'];
					$nro_cuenta=$dat2['nro_cuenta'];	
					$nro_comprobante=$dat2['nro_comprobante'];
					$fecha_comprobante=$dat2['fecha_comprobante'];	
	 				$monto_ordetrabajo=0;
					$descuento_orden_trabajo=0;
					$incremento_orden_trabajo=0;
			 		$sql3=" select monto_orden_trabajo, descuento_orden_trabajo, incremento_orden_trabajo";
					$sql3.=" from ordentrabajo";
					$sql3.=" where cod_orden_trabajo=".$cod_orden_trabajo;
					$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$monto_ordetrabajo=$dat3['monto_orden_trabajo'];
						$descuento_orden_trabajo=$dat3['descuento_orden_trabajo'];
						$incremento_orden_trabajo=$dat3['incremento_orden_trabajo'];
					}
					///////////////////////////	
				
					$monto_ordetrabajo=($monto_ordetrabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo;			
				$pdf->setX(14);
	 			$pdf->SetFont('Arial','',8);
	         	$pdf->Cell(7,4,"OT",1,0,'C',false);
			 	$pdf->Cell(15,4,$nro_orden_trabajo."/".strftime("%Y",strtotime($fecha_orden_trabajo)),1,0,'C',false);  
			 	$pdf->Cell(15,4,strftime("%d/%m/%Y",strtotime($fecha_orden_trabajo)),1,0,'C',false);  
			 	$pdf->Cell(20,4,number_format($monto_ordetrabajo, 2, ",", ".")." Bs",1,0,'R',false); 
			 	$pdf->Cell(93,4,"",1,0,'L',false);  																	                			
				$sql3=" select desc_estado_pago_doc ";
				$sql3.=" from estado_pago_documento ";
				$sql3.=" where cod_estado_pago_doc=".$cod_estado_pago_doc;
	 			$pdf->SetFont('Arial','',5);
				$resp3 = mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3)){
							$desc_estado_pago_doc=$dat3['desc_estado_pago_doc'];
				}
				$total_pago=$total_pago+$monto_pago_detalle;
				 			$pdf->SetFont('Arial','',8);
				 $pdf->Cell(20,4,number_format($monto_pago_detalle, 2, ",",".")." Bs",1,0,'R',false); 
				  			$pdf->SetFont('Arial','',5); 
				 $pdf->Cell(18,4,$desc_estado_pago_doc,1,1,'C',false); 
          
		}


				$sql2=" select pd.cod_pago_detalle, pd.codigo_doc, s.nro_salida, g.gestion,s.fecha_salida,";
				$sql2.=" s.cod_estado_pago_doc, pd.monto_pago_detalle, pd.cod_forma_pago, pd.cod_banco,";
				$sql2.=" pd.cod_moneda, pd.nro_cheque, pd.nro_cuenta, pd.nro_comprobante, pd.fecha_comprobante";
				$sql2.=" from pagos_detalle pd, salidas s, gestiones g ";
				$sql2.=" where pd.cod_pago=".$cod_pago;
				$sql2.=" and pd.codigo_doc=s.cod_salida ";
				$sql2.=" and pd.cod_tipo_doc=3";
				$sql2.=" and s.cod_gestion=g.cod_gestion ";
				$sql2.=" order by s.fecha_salida asc, s.nro_salida asc, g.gestion asc";
				
				$resp2 = mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$cod_pago_detalle=$dat2['cod_pago_detalle'];
					$cod_salida=$dat2['codigo_doc'];
					$nro_salida=$dat2['nro_salida'];
					$gestion=$dat2['gestion'];
					$fecha_salida=$dat2['fecha_salida'];
					$cod_estado_pago_doc=$dat2['cod_estado_pago_doc'];
					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					$cod_forma_pago=$dat2['cod_forma_pago'];
					$cod_banco=$dat2['cod_banco'];
					$cod_moneda=$dat2['cod_moneda'];
					$nro_cheque=$dat2['nro_cheque'];
					$nro_cuenta=$dat2['nro_cuenta'];	
					$nro_comprobante=$dat2['nro_comprobante'];
					$fecha_comprobante=$dat2['fecha_comprobante'];		


	 				$monto_venta=0;
			 		$sql5=" select sum(sd.precio_venta*sd.cant_salida) ";
					$sql5.=" from salidas_detalle sd ";
					$sql5.=" where sd.cod_salida=".$cod_salida;
					$resp5 = mysql_query($sql5);
					while($dat5=mysql_fetch_array($resp5)){
						$monto_venta=$dat5[0];
					}

					$descripcion_venta="";
					$sql5=" select cod_material, cant_salida, precio_venta ";
					$sql5.=" from salidas_detalle ";
					$sql5.=" where cod_salida=".$cod_salida;
					
					$resp5= mysql_query($sql5);
					$cont=0;
					$sumaTotal=0;
					while($dat5=mysql_fetch_array($resp5)){	
					
						$cont=$cont+1;
						$codmaterial=$dat5['cod_material'];
						$cant_salida=$dat5['cant_salida'];
						$precioventa=$dat5['precio_venta'];

						$sql6=" select m.desc_completa_material, m.precio_venta,  um.abrev_unidad_medida ";
						$sql6.=" from materiales m, unidades_medidas um ";
						$sql6.=" where m.cod_unidad_medida=um.cod_unidad_medida ";
						$sql6.=" and m.cod_material=".$codmaterial;
						$resp6= mysql_query($sql6);
						while($dat6=mysql_fetch_array($resp6)){
							$desc_completa_material=$dat6['desc_completa_material'];
							$precio_venta=$dat6['precio_venta'];
							$abrev_unidad_medida=$dat6['abrev_unidad_medida'];
						
						}
						$descripcion_venta=$descripcion_venta." ".$cant_salida." ".$abrev_unidad_medida." ".$desc_completa_material;
					}
						
			 
			 $pdf->setX(14);
 			$pdf->SetFont('Arial','',8);
	         $pdf->Cell(7,4,"VTA",1,0,'C',false);
			 $pdf->Cell(15,4,$nro_salida."/".strftime("%Y",strtotime($fecha_salida)),1,0,'C',false);  
			 $pdf->Cell(15,4,strftime("%d/%m/%Y",strtotime($fecha_salida)),1,0,'C',false);  
			 $pdf->Cell(20,4,number_format($monto_venta, 2, ",",".")." Bs",1,0,'R',false); 
			 $pdf->SetFont('Arial','',4); 												
			$pdf->Cell(93,4,$descripcion_venta,1,0,'L',false);  

			$sql3=" select desc_estado_pago_doc ";
			$sql3.=" from estado_pago_documento ";
			$sql3.=" where cod_estado_pago_doc=".$cod_estado_pago_doc;
			$resp3 = mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3)){
							$desc_estado_pago_doc=$dat3['desc_estado_pago_doc'];
				}
			$total_pago=$total_pago+$monto_pago_detalle;
			 			$pdf->SetFont('Arial','',8);
            $pdf->Cell(20,4,number_format($monto_pago_detalle, 2, ",",".")." Bs",1,0,'R',false);  
			 			$pdf->SetFont('Arial','',5);
			$pdf->Cell(18,4,$desc_estado_pago_doc,1,1,'C',false); 

          
		}	
		 $pdf->setX(14);
		$pdf->SetFont('Arial','B',8); 
		$pdf->Cell(150,4,"Total Pago",1,0,'R');
		$pdf->Cell(20,4,number_format($total_pago, 2, ",",".")." Bs",1,0,'R');
		$pdf->Cell(18,4,"",1,1,'C',false); 
		$pdf->setX(14);
		$pdf->SetFont('Arial','B',8); 
		$pdf->Cell(188,4,"Son: ".convertir($total_pago)."00/100  Bolivianos.",0,1,'L');

		
		$y=85;
	
	
	
	
	$totalDeuda=0;
	$sql=" select hr.cod_hoja_ruta, hr.nro_hoja_ruta, hr.cod_gestion, g.gestion,  hr.fecha_hoja_ruta, hr.cod_cotizacion ";
	$sql.=" from hojas_rutas hr, cotizaciones c, gestiones g";
	$sql.=" where hr.cod_cotizacion=c.cod_cotizacion";
	$sql.=" and hr.cod_gestion=g.cod_gestion";
	$sql.=" and c.cod_cliente=".$cod_cliente;
	$sql.=" and hr.cod_estado_hoja_ruta<>2";
	$sql.=" and hr.cod_estado_pago_doc<>3";
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
					$descuento_cotizacion=0;
					$sql2=" select c.descuento_cotizacion ";
					$sql2.=" from hojas_rutas hr, cotizaciones c ";
					$sql2.=" where hr.cod_cotizacion=c.cod_cotizacion ";
					$sql2.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$descuento_cotizacion=$dat2['descuento_cotizacion'];
					}
					$incremento_cotizacion=0;
					$sql2=" select c.incremento_cotizacion ";
					$sql2.=" from hojas_rutas hr, cotizaciones c ";
					$sql2.=" where hr.cod_cotizacion=c.cod_cotizacion ";
					$sql2.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$incremento_cotizacion=$dat2['incremento_cotizacion'];
					}										
					$monto_hojaruta=($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion;								
			 	$sql2=" select sum(pd.monto_pago_detalle)";
			 	$sql2.=" from pagos_detalle pd, pagos p";
			 	$sql2.=" where pd.cod_pago=p.cod_pago";
			 	$sql2.=" and p.cod_estado_pago<>2";
			 	$sql2.=" and pd.codigo_doc=".$cod_hoja_ruta;
				$sql2.=" and pd.cod_tipo_doc=1";
				$resp2 = mysql_query($sql2);
				$acuenta_hojaruta=0;
				$monto_pago_detalle=0;
				while($dat2=mysql_fetch_array($resp2)){
					$monto_pago_detalle=$dat2[0];		
				}	
				$acuenta_hojaruta=$acuenta_hojaruta+$monto_pago_detalle;	
			    $totalDeuda=$totalDeuda+($monto_hojaruta-$acuenta_hojaruta);
	}
	$sql=" select ot.cod_orden_trabajo, ot.nro_orden_trabajo, g.gestion ,ot.cod_gestion, ot.numero_orden_trabajo, ";
	$sql.=" ot.fecha_orden_trabajo, ot.monto_orden_trabajo, ot.descuento_orden_trabajo, ot.incremento_orden_trabajo ";
	$sql.=" from ordentrabajo ot, gestiones g ";
	$sql.=" where ot.cod_est_ot<>2  ";
	$sql.=" and ot.cod_estado_pago_doc<>3 ";
	$sql.=" and ot.cod_gestion=g.cod_gestion "; 
	$sql.=" and ot.cod_cliente=".$cod_cliente;
	$sql.=" order by ot.fecha_orden_trabajo asc, ot.nro_orden_trabajo asc ";
	$resp= mysql_query($sql);
	$gestion="";
	while($dat=mysql_fetch_array($resp)){
		 $cod_orden_trabajo=$dat['cod_orden_trabajo'];
		 $nro_orden_trabajo=$dat['nro_orden_trabajo'];
		 $gestion=$dat['gestion'];
		 $cod_gestion=$dat['cod_gestion'];
		 $numero_orden_trabajo=$dat['numero_orden_trabajo'];
		 $fecha_orden_trabajo=$dat['fecha_orden_trabajo'];
		 $monto_orden_trabajo=$dat['monto_orden_trabajo'];
		 $descuento_orden_trabajo=$dat['descuento_orden_trabajo'];
		 $incremento_orden_trabajo=$dat['incremento_orden_trabajo'];
		 $monto_orden_trabajo=($monto_orden_trabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo;
		 

			 	$sql2=" select  sum(pd.monto_pago_detalle)";
			 	$sql2.=" from pagos_detalle pd, pagos p";
			 	$sql2.=" where pd.cod_pago=p.cod_pago";
			 	$sql2.=" and p.cod_estado_pago<>2";
			 	$sql2.=" and pd.codigo_doc=".$cod_orden_trabajo;
				$sql2.=" and pd.cod_tipo_doc=2";
				$resp2 = mysql_query($sql2);
				$acuenta_ordentrabajo=0;
				while($dat2=mysql_fetch_array($resp2)){
					$monto_pago_detalle=$dat2[0];							
				}
	$acuenta_ordentrabajo=$acuenta_ordentrabajo+$monto_pago_detalle;
			  $totalDeuda=$totalDeuda+($monto_orden_trabajo-$acuenta_ordentrabajo);
}

$sql=" select s.cod_salida, s.nro_salida, s.cod_gestion, g.gestion, s.cliente_venta, s.fecha_salida ";
	$sql.=" from salidas s, gestiones g ";
	$sql.=" where s.cod_gestion=g.cod_gestion ";
	$sql.=" and s.cod_tipo_salida=1 ";
	$sql.=" and s.cod_estado_salida=1 ";
	$sql.=" and s.cod_estado_pago_doc<>3 ";
	$sql.=" and s.cod_cliente_venta=".$cod_cliente;
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
		

	 		$monto_venta=0;
			 		$sql2=" select sum(sd.precio_venta*sd.cant_salida) ";
					$sql2.=" from salidas_detalle sd ";
					$sql2.=" where sd.cod_salida=".$cod_salida;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$monto_venta=$dat2[0];
					}

			 	$sql2=" select sum(pd.monto_pago_detalle) ";
			 	$sql2.=" from pagos_detalle pd, pagos p";
			 	$sql2.=" where pd.cod_pago=p.cod_pago";
			 	$sql2.=" and p.cod_estado_pago<>2";
			 	$sql2.=" and pd.codigo_doc=".$cod_salida;
				$sql2.=" and pd.cod_tipo_doc=3";
				$resp2 = mysql_query($sql2);
				$acuenta_venta=0;
				$monto_pago_detalle=0;
				while($dat2=mysql_fetch_array($resp2)){
					$monto_pago_detalle=$dat2[0];

				}				
				$acuenta_venta=$acuenta_venta+$monto_pago_detalle;
			 $totalDeuda=$totalDeuda+($monto_venta-$acuenta_venta);

	}
	$pdf->SetXY(70,130);
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(8,5,"A cuenta:",0,0,'R');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(25,5,number_format($total_pago, 2, ",", ".")." Bs",0,0,'L');
	$pdf->SetXY(110,130);
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(12,5,"Saldo:",0,0,'R');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(25,5,number_format($totalDeuda, 2, ",", ".")." Bs",0,0,'L');
	
	$sql=" select  p.cod_usuario_pago ";
	$sql.=" from pagos p, gestiones g,  clientes cli, estados_pago ep ";
	$sql.=" where  p.cod_gestion=g.cod_gestion ";
	$sql.=" and p.cod_cliente=cli.cod_cliente ";
	$sql.=" and p.cod_estado_pago=ep.cod_estado_pago ";
	$sql.=" and p.cod_pago=".$_GET['cod_pago'];
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){

				$cod_usuario_pago=$dat['cod_usuario_pago'];

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
	}
	$pdf->SetFont('Arial','',8);
		$pdf->SetXY(30,135);
		$pdf->Cell(30,1,".........................................................",0,1,'C',false);
		$pdf->SetX(30);
		$pdf->Cell(30,4,"Recibi Conforme",0,1,'C',false);
		$pdf->SetX(30);
		$pdf->Cell(30,8,"Nombre: ".$nombres_usuario_pago." ".$ap_paterno_usuario_pago,0,1,'C',false);
		
		$pdf->SetXY(155,135);
		$pdf->Cell(30,1,".........................................................",0,1,'C',false);
		$pdf->SetX(155);
		$pdf->Cell(30,4,"Entregue Conforme",0,1,'C',false);
		$pdf->SetX(155);
		$pdf->Cell(30,8,"Nombre.................................................",0,1,'C',false);
		
//////////////////////////COPIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////////////////////////////

/////////////////////////////////////PAGO///////////////	
	$sql=" select  p.nro_pago, p.cod_gestion, g.gestion, ";
	$sql.=" p.cod_cliente, cli.nombre_cliente, cli.direccion_cliente, cli.telefono_cliente, cli.celular_cliente, cli.fax_cliente,";
	$sql.=" p.fecha_pago, p.cod_usuario_pago, p.obs_pago, p.monto_pago, ";
	$sql.=" p.cod_estado_pago, ep.desc_estado_pago, p.fecha_anulacion, p.obs_anulacion, p.cod_usuario_anulacion, p.fecha_registro ";
	$sql.=" from pagos p, gestiones g,  clientes cli, estados_pago ep ";
	$sql.=" where  p.cod_gestion=g.cod_gestion ";
	$sql.=" and p.cod_cliente=cli.cod_cliente ";
	$sql.=" and p.cod_estado_pago=ep.cod_estado_pago ";
	$sql.=" and p.cod_pago=".$_GET['cod_pago'];
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		
				$nro_pago=$dat['nro_pago'];				
				$cod_gestion=$dat['cod_pago'];
				$gestion=$dat['gestion'];
				$cod_cliente=$dat['cod_cliente'];
				$nombre_cliente=$dat['nombre_cliente'];	
				$direccion_cliente=$dat['direccion_cliente'];	
				$telefono_cliente=$dat['telefono_cliente'];	
				$celular_cliente=$dat['celular_cliente'];	
				$fax_cliente=$dat['fax_cliente'];								
				$fecha_pago=$dat['fecha_pago'];
				$cod_usuario_pago=$dat['cod_usuario_pago'];
				$obs_pago=$dat['obs_pago'];
				$monto_pago=$dat['monto_pago'];
				$cod_estado_pago=$dat['cod_estado_pago'];
				$desc_estado_pago=$dat['desc_estado_pago'];
				$fecha_anulacion=$dat['fecha_anulacion'];
				$obs_anulacion=$dat['obs_anulacion'];
				$cod_usuario_anulacion=$dat['cod_usuario_anulacion'];
				$fecha_registro=$dat['fecha_registro'];
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
				
	}


/**********************DATOS DE CABECERA*********************/

	
		$sql5="select  valor_x, valor_y from coordenadas_impresion where cod_coordenada=1";
		$resp5=mysql_query($sql5);
		while ($dat5=mysql_fetch_array($resp5)){
			$valorX=$dat5[0];
			$valorY=$dat5[1];
		}


		/**********************Fin Datos de Cliente******************************/	

			$pdf->SetFont('Arial','B',10);
			$pdf->SetTextColor(0,0,0);	
			$pdf->SetFont('Arial','B',9);
			//$pdf->SetXY(160,166);

						
			$pdf->SetFont('Arial','B',14);
			$pdf->SetTextColor(0,0,0);
			$pdf->Text(85,190,"RECIBO OFICIAL");
			$pdf->SetFont('Arial','B',12);
			$pdf->SetTextColor(0,0,0);
			$pdf->Text(87,195,"NRO. ".$nro_pago."/".$gestion);	
			$pdf->SetFont('Arial','B',12);
			$pdf->SetTextColor(0,0,0);
			$pdf->Text(85,200,"FECHA: ".strftime("%d/%m/%Y",strtotime($fecha_pago)));	
						
			$val_Y_cabecera=205;
			$pdf->SetFont('Arial','B',10);
			$pdf->SetXY(12,$val_Y_cabecera);
			$pdf->Cell(0,5,'Hemos Recibido de:',0,0,'L');
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(48,$val_Y_cabecera);
			$pdf->Cell(0,5,$nombre_cliente,0,0,'L');
		
						
			/*$val_Y_cabecera=$val_Y_cabecera+5;			
			$pdf->SetXY(12,$val_Y_cabecera);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,5,'OBS:',0,0,'L');
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(36,$val_Y_cabecera);
			$pdf->Cell(0,5,$obs_pago,0,0,'L');*/
			$x=160;
			$y=180;
			
			$sql=" select cod_moneda,desc_moneda, abrev_moneda from monedas ";
			$resp = mysql_query($sql);
			while($dat=mysql_fetch_array($resp)){
			$cod_moneda=$dat['cod_moneda'];
			$desc_moneda=$dat['desc_moneda'];
			$abrev_moneda=$dat['abrev_moneda'];
			$sql2="select count(*) from pagos_descripcion where cod_pago=".$cod_pago." and cod_moneda=".$cod_moneda;
			$resp2= mysql_query($sql2);
			$nroPagoMoneda=0;
			while($dat2=mysql_fetch_array($resp2)){
				$nroPagoMoneda=$dat2[0];
			}
			if($nroPagoMoneda>0){
				$y=$y+5;
				$sql2="select sum(monto_pago)  from pagos_descripcion where cod_pago=".$cod_pago." and cod_moneda=".$cod_moneda;
				$resp2= mysql_query($sql2);
				$montoTotalPagoMoneda=0;
				while($dat2=mysql_fetch_array($resp2)){
					$montoTotalPagoMoneda=$dat2[0];
				}
				$pdf->SetXY($x,$y);
				$pdf->Cell(8,5,$abrev_moneda,0,0,'L');
				$pdf->Cell(25,5,number_format($montoTotalPagoMoneda, 2, ",", ".").".-",1,1,'L');
				
				if($cod_moneda<>1){
					$y=$y+5;				
					$sql3="select cambio_bs from tipo_cambio where cod_moneda=2 and fecha_tipo_cambio='".$fecha_registro."'";
					$resp3= mysql_query($sql3);
					$cambio_bs=0;
					while($dat3=mysql_fetch_array($resp3)){
						$cambio_bs=$dat3['cambio_bs'];
					}
					$pdf->SetXY($x,$y);
					$pdf->Cell(8,5,"T.C.",0,0,'L');
					$pdf->Cell(25,5,number_format($cambio_bs, 2, ",", ".").".-",1,1,'L');
				}		
		}
		
	}
	$y=210;
	$x=25;
	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY($x,$y);
	$pdf->Cell(10,4,"La suma de:",0,0,'R');
	$pdf->SetFont('Arial','',8);
	$sql3="select  fp.desc_forma_pago,pd.monto_pago, ba.desc_banco,pd.nro_cheque,pd.nro_cuenta,mo.desc_moneda";
	$sql3.=" from pagos_descripcion pd  inner join forma_pago fp on(pd.cod_forma_pago=fp.cod_forma_pago)";
	$sql3.=" left JOIN bancos ba on(pd.cod_banco=ba.cod_banco)";
	$sql3.=" left JOIN monedas mo on(pd.cod_moneda=mo.cod_moneda)";
	$sql3.=" where pd.cod_pago=".$cod_pago;
	$sql3.=" order by pd.cod_moneda,pd.cod_forma_pago";
	$resp3= mysql_query($sql3);
	while($dat3=mysql_fetch_array($resp3)){
		
		$desc_forma_pago=$dat3['desc_forma_pago'];
		$monto_pago_detalle=$dat3['monto_pago'];
		$desc_banco=$dat3['desc_banco'];
		$nro_cheque=$dat3['nro_cheque'];
		$nro_cuenta=$dat3['nro_cuenta'];
		$desc_moneda=$dat3['desc_moneda'];

	/*	$pdf->SetX(35);
		$pdf->Cell(80,4,convertir($monto_pago_detalle)."00/100 ".$desc_moneda,0,0,'L');
		$pdf->Cell(25,4,$desc_forma_pago,0,0,'L');
		$pdf->Cell(30,4,$nro_cheque.$nro_cuenta,0,0,'R');
		$pdf->Cell(40,4,$desc_banco,0,1,'L');*/
		$pdf->SetX(35);
		$pdf->Cell(100,4,convertir($monto_pago_detalle)."00/100 ".$desc_moneda,0,0,'L');
		$pdf->SetX(130);
		$pdf->Cell(30,4,$desc_forma_pago." ".$nro_cheque.$nro_cuenta,0,0,'L');
		$pdf->SetX(165);
		$pdf->Cell(40,4,$desc_banco,0,1,'L');		
		
	}
	$y=225;
	$x=34;
	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY($x,$y);
	$pdf->Cell(10,5,"Por Concepto de:",0,1,'R');
	$pdf->SetFont('Arial','',8);
	$pdf->SetX(14);
	         $pdf->Cell(7,4,"Doc",1,0,'C',false);
			 $pdf->Cell(15,4,"Nro",1,0,'C',false);  
			 $pdf->Cell(15,4,"Fecha",1,0,'C',false);  
			 $pdf->Cell(20,4,"Total",1,0,'C',false);
			 $pdf->Cell(93,4,"Descripcion",1,0,'C',false);
			 $pdf->Cell(20,4,"Pago",1,0,'C',false); 
			 $pdf->Cell(18,4,"Estado",1,1,'C',false);  
			  
			 	$pdf->SetFont('Arial','',8);
				$total_pago=0;          
				$sql2=" select pd.cod_pago_detalle, pd.codigo_doc, hr.nro_hoja_ruta, g.gestion,hr.fecha_hoja_ruta,";
				$sql2.="  hr.cod_estado_pago_doc, pd.monto_pago_detalle, pd.cod_forma_pago, pd.cod_banco,";
				$sql2.=" pd.cod_moneda, pd.nro_cheque, pd.nro_cuenta, pd.nro_comprobante, pd.fecha_comprobante";
				$sql2.=" from pagos_detalle pd, hojas_rutas hr, gestiones g ";
				$sql2.=" where pd.cod_pago=".$cod_pago;
				$sql2.=" and pd.codigo_doc=hr.cod_hoja_ruta ";
				$sql2.=" and pd.cod_tipo_doc=1 ";
				$sql2.=" and hr.cod_gestion=g.cod_gestion ";
				$sql2.=" order by hr.fecha_hoja_ruta asc ,hr.nro_hoja_ruta asc, g.gestion asc";
				$resp2 = mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$cod_pago_detalle=$dat2['cod_pago_detalle'];
					$cod_hoja_ruta=$dat2['codigo_doc'];
					$nro_hoja_ruta=$dat2['nro_hoja_ruta'];
					$gestion=$dat2['gestion'];
					$fecha_hoja_ruta=$dat2['fecha_hoja_ruta'];
					$cod_estado_pago_doc=$dat2['cod_estado_pago_doc'];
					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					$cod_forma_pago=$dat2['cod_forma_pago'];
					$cod_banco=$dat2['cod_banco'];
					$cod_moneda=$dat2['cod_moneda'];
					$nro_cheque=$dat2['nro_cheque'];
					$nro_cuenta=$dat2['nro_cuenta'];	
					$nro_comprobante=$dat2['nro_comprobante'];
					$fecha_comprobante=$dat2['fecha_comprobante'];		



			 		$monto_hojaruta=0;
			 		$sql3=" select sum(cd.IMPORTE_TOTAL) ";
					$sql3.=" from hojas_rutas_detalle hrd, cotizaciones_detalle cd ";
					$sql3.=" where hrd.cod_hoja_ruta=".$cod_hoja_ruta;
					$sql3.=" and hrd.cod_cotizacion=cd.cod_cotizacion ";
					$sql3.=" and hrd.cod_cotizaciondetalle=cd.cod_cotizaciondetalle ";
					$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$monto_hojaruta=$dat3[0];
					}
					$descripcion_hojaruta="";
			 		$sql3=" select items.desc_item,cd.descripcion_item ";
					$sql3.=" from hojas_rutas_detalle hrd, cotizaciones_detalle cd,items ";
					$sql3.=" where hrd.cod_hoja_ruta=".$cod_hoja_ruta;
					$sql3.=" and hrd.cod_cotizacion=cd.cod_cotizacion ";
					$sql3.=" and hrd.cod_cotizaciondetalle=cd.cod_cotizaciondetalle ";
					$sql3.=" and items.cod_item=cd.cod_item ";
					$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$desc_item=$dat3['desc_item'];
						$descripcion_item=$dat3['descripcion_item'];
						//$descripcion_hojaruta=$descripcion_hojaruta." ".$desc_item." ".$descripcion_item;
						$descripcion_hojaruta=$descripcion_hojaruta." ".$desc_item;
					}
					

					$descuento_cotizacion=0;
					$sql3=" select c.descuento_cotizacion ";
					$sql3.=" from hojas_rutas hr, cotizaciones c ";
					$sql3.=" where hr.cod_cotizacion=c.cod_cotizacion ";
					$sql3.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
					$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$descuento_cotizacion=$dat3['descuento_cotizacion'];
					}

					$incremento_cotizacion=0;
					$sql3=" select c.incremento_cotizacion ";
					$sql3.=" from hojas_rutas hr, cotizaciones c ";
					$sql3.=" where hr.cod_cotizacion=c.cod_cotizacion ";
					$sql3.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
					$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$incremento_cotizacion=$dat3['incremento_cotizacion'];
					}
				
					$monto_hojaruta=($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion;												
		   
		   	 $pdf->SetX(14);
 			$pdf->SetFont('Arial','',8);
	         $pdf->Cell(7,4,"HR",1,0,'C',false);
			 $pdf->Cell(15,4,$nro_hoja_ruta."/".strftime("%Y",strtotime($fecha_hoja_ruta)),1,0,'C',false);  
			 $pdf->Cell(15,4,strftime("%d/%m/%Y",strtotime($fecha_hoja_ruta)),1,0,'C',false);  
			 $pdf->Cell(20,4,number_format($monto_hojaruta, 2, ",", ".")." Bs",1,0,'R',false);  
			 $pdf->SetFont('Arial','',5);
			 
			 $pdf->Cell(93,4,$descripcion_hojaruta,1,0,'L',false);  

			$sql3=" select desc_estado_pago_doc ";
			$sql3.=" from estado_pago_documento ";
			$sql3.=" where cod_estado_pago_doc=".$cod_estado_pago_doc;
			$resp3 = mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3)){
							$desc_estado_pago_doc=$dat3['desc_estado_pago_doc'];
				}
            

					$total_pago=$total_pago+$monto_pago_detalle;
			//$pdf->SetX(164);
		 			$pdf->SetFont('Arial','',8);
			$pdf->Cell(20,4,number_format($monto_pago_detalle, 2, ",", ".")." Bs",1,0,'R',false); 
			 			$pdf->SetFont('Arial','',5);
			 $pdf->Cell(18,4,$desc_estado_pago_doc,1,1,'C',false); 
//			 $pdf->SetX(71);
			// $pdf->MultiCell(93,4,$descripcion_hojaruta,0,'L',false);
         
      } 

        
				$sql2=" select pd.cod_pago_detalle, pd.codigo_doc, ot.nro_orden_trabajo, ot.numero_orden_trabajo, g.gestion, ";
				$sql2.=" ot.fecha_orden_trabajo, ot.cod_estado_pago_doc, pd.monto_pago_detalle, pd.cod_forma_pago, pd.cod_banco,";
				$sql2.=" pd.cod_moneda, pd.nro_cheque, pd.nro_cuenta, pd.nro_comprobante, pd.fecha_comprobante";

				$sql2.=" from pagos_detalle pd, ordentrabajo ot, gestiones g ";
				$sql2.=" where pd.cod_pago=".$cod_pago;
				$sql2.=" and pd.codigo_doc=ot.cod_orden_trabajo ";
				$sql2.=" and pd.cod_tipo_doc=2 ";
				$sql2.=" and ot.cod_gestion=g.cod_gestion ";
				$sql2.=" order by ot.nro_orden_trabajo asc, g.gestion asc";
				$resp2 = mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$cod_pago_detalle=$dat2['cod_pago_detalle'];
					$cod_orden_trabajo=$dat2['codigo_doc'];
					$nro_orden_trabajo=$dat2['nro_orden_trabajo'];
					$numero_orden_trabajo=$dat2['numero_orden_trabajo'];
					$gestion=$dat2['gestion'];
					$fecha_orden_trabajo=$dat2['fecha_orden_trabajo'];
					$cod_estado_pago_doc=$dat2['cod_estado_pago_doc'];
					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					$cod_forma_pago=$dat2['cod_forma_pago'];
					$cod_banco=$dat2['cod_banco'];
					$cod_moneda=$dat2['cod_moneda'];
					$nro_cheque=$dat2['nro_cheque'];
					$nro_cuenta=$dat2['nro_cuenta'];	
					$nro_comprobante=$dat2['nro_comprobante'];
					$fecha_comprobante=$dat2['fecha_comprobante'];	
	 				$monto_ordetrabajo=0;
					$descuento_orden_trabajo=0;
					$incremento_orden_trabajo=0;
			 		$sql3=" select monto_orden_trabajo, descuento_orden_trabajo, incremento_orden_trabajo";
					$sql3.=" from ordentrabajo";
					$sql3.=" where cod_orden_trabajo=".$cod_orden_trabajo;
					$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$monto_ordetrabajo=$dat3['monto_orden_trabajo'];
						$descuento_orden_trabajo=$dat3['descuento_orden_trabajo'];
						$incremento_orden_trabajo=$dat3['incremento_orden_trabajo'];
					}
					///////////////////////////	
				
					$monto_ordetrabajo=($monto_ordetrabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo;			
				$pdf->setX(14);
	 			$pdf->SetFont('Arial','',8);
	         	$pdf->Cell(7,4,"OT",1,0,'C',false);
			 	$pdf->Cell(15,4,$nro_orden_trabajo."/".strftime("%Y",strtotime($fecha_orden_trabajo)),1,0,'C',false);  
			 	$pdf->Cell(15,4,strftime("%d/%m/%Y",strtotime($fecha_orden_trabajo)),1,0,'C',false);  
			 	$pdf->Cell(20,4,number_format($monto_ordetrabajo, 2, ",", ".")." Bs",1,0,'R',false); 
			 	$pdf->Cell(93,4,"",1,0,'L',false);  																	                			
				$sql3=" select desc_estado_pago_doc ";
				$sql3.=" from estado_pago_documento ";
				$sql3.=" where cod_estado_pago_doc=".$cod_estado_pago_doc;
	 			$pdf->SetFont('Arial','',5);
				$resp3 = mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3)){
							$desc_estado_pago_doc=$dat3['desc_estado_pago_doc'];
				}
				$total_pago=$total_pago+$monto_pago_detalle;
				 			$pdf->SetFont('Arial','',8);
				 $pdf->Cell(20,4,number_format($monto_pago_detalle, 2, ",",".")." Bs",1,0,'R',false); 
				  			$pdf->SetFont('Arial','',5); 
				 $pdf->Cell(18,4,$desc_estado_pago_doc,1,1,'C',false); 
          
		}


				$sql2=" select pd.cod_pago_detalle, pd.codigo_doc, s.nro_salida, g.gestion,s.fecha_salida,";
				$sql2.=" s.cod_estado_pago_doc, pd.monto_pago_detalle, pd.cod_forma_pago, pd.cod_banco,";
				$sql2.=" pd.cod_moneda, pd.nro_cheque, pd.nro_cuenta, pd.nro_comprobante, pd.fecha_comprobante";
				$sql2.=" from pagos_detalle pd, salidas s, gestiones g ";
				$sql2.=" where pd.cod_pago=".$cod_pago;
				$sql2.=" and pd.codigo_doc=s.cod_salida ";
				$sql2.=" and pd.cod_tipo_doc=3";
				$sql2.=" and s.cod_gestion=g.cod_gestion ";
				$sql2.=" order by s.fecha_salida asc, s.nro_salida asc, g.gestion asc";
				
				$resp2 = mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$cod_pago_detalle=$dat2['cod_pago_detalle'];
					$cod_salida=$dat2['codigo_doc'];
					$nro_salida=$dat2['nro_salida'];
					$gestion=$dat2['gestion'];
					$fecha_salida=$dat2['fecha_salida'];
					$cod_estado_pago_doc=$dat2['cod_estado_pago_doc'];
					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					$cod_forma_pago=$dat2['cod_forma_pago'];
					$cod_banco=$dat2['cod_banco'];
					$cod_moneda=$dat2['cod_moneda'];
					$nro_cheque=$dat2['nro_cheque'];
					$nro_cuenta=$dat2['nro_cuenta'];	
					$nro_comprobante=$dat2['nro_comprobante'];
					$fecha_comprobante=$dat2['fecha_comprobante'];		


	 				$monto_venta=0;
			 		$sql5=" select sum(sd.precio_venta*sd.cant_salida) ";
					$sql5.=" from salidas_detalle sd ";
					$sql5.=" where sd.cod_salida=".$cod_salida;
					$resp5 = mysql_query($sql5);
					while($dat5=mysql_fetch_array($resp5)){
						$monto_venta=$dat5[0];
					}

					$descripcion_venta="";
					$sql5=" select cod_material, cant_salida, precio_venta ";
					$sql5.=" from salidas_detalle ";
					$sql5.=" where cod_salida=".$cod_salida;
					
					$resp5= mysql_query($sql5);
					$cont=0;
					$sumaTotal=0;
					while($dat5=mysql_fetch_array($resp5)){	
					
						$cont=$cont+1;
						$codmaterial=$dat5['cod_material'];
						$cant_salida=$dat5['cant_salida'];
						$precioventa=$dat5['precio_venta'];

						$sql6=" select m.desc_completa_material, m.precio_venta,  um.abrev_unidad_medida ";
						$sql6.=" from materiales m, unidades_medidas um ";
						$sql6.=" where m.cod_unidad_medida=um.cod_unidad_medida ";
						$sql6.=" and m.cod_material=".$codmaterial;
						$resp6= mysql_query($sql6);
						while($dat6=mysql_fetch_array($resp6)){
							$desc_completa_material=$dat6['desc_completa_material'];
							$precio_venta=$dat6['precio_venta'];
							$abrev_unidad_medida=$dat6['abrev_unidad_medida'];
						
						}
						$descripcion_venta=$descripcion_venta." ".$cant_salida." ".$abrev_unidad_medida." ".$desc_completa_material;
					}
						
			 
			 $pdf->setX(14);
 			$pdf->SetFont('Arial','',8);
	         $pdf->Cell(7,4,"VTA",1,0,'C',false);
			 $pdf->Cell(15,4,$nro_salida."/".strftime("%Y",strtotime($fecha_salida)),1,0,'C',false);  
			 $pdf->Cell(15,4,strftime("%d/%m/%Y",strtotime($fecha_salida)),1,0,'C',false);  
			 $pdf->Cell(20,4,number_format($monto_venta, 2, ",",".")." Bs",1,0,'R',false); 
			 $pdf->SetFont('Arial','',4); 												
			$pdf->Cell(93,4,$descripcion_venta,1,0,'L',false);  

			$sql3=" select desc_estado_pago_doc ";
			$sql3.=" from estado_pago_documento ";
			$sql3.=" where cod_estado_pago_doc=".$cod_estado_pago_doc;
			$resp3 = mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3)){
							$desc_estado_pago_doc=$dat3['desc_estado_pago_doc'];
				}
			$total_pago=$total_pago+$monto_pago_detalle;
			 			$pdf->SetFont('Arial','',8);
            $pdf->Cell(20,4,number_format($monto_pago_detalle, 2, ",",".")." Bs",1,0,'R',false);  
			 			$pdf->SetFont('Arial','',5);
			$pdf->Cell(18,4,$desc_estado_pago_doc,1,1,'C',false); 

          
		}	
		 $pdf->setX(14);
		$pdf->SetFont('Arial','B',8); 
		$pdf->Cell(150,4,"Total Pago",1,0,'R');
		$pdf->Cell(20,4,number_format($total_pago, 2, ",",".")." Bs",1,0,'R');
		$pdf->Cell(18,4,"",1,1,'C',false); 
		$pdf->setX(14);
		$pdf->SetFont('Arial','B',8); 
		$pdf->Cell(188,4,"Son: ".convertir($total_pago)."00/100  Bolivianos.",0,1,'L');

		
		$y=235;
	
	
	
	
	$totalDeuda=0;
	$sql=" select hr.cod_hoja_ruta, hr.nro_hoja_ruta, hr.cod_gestion, g.gestion,  hr.fecha_hoja_ruta, hr.cod_cotizacion ";
	$sql.=" from hojas_rutas hr, cotizaciones c, gestiones g";
	$sql.=" where hr.cod_cotizacion=c.cod_cotizacion";
	$sql.=" and hr.cod_gestion=g.cod_gestion";
	$sql.=" and c.cod_cliente=".$cod_cliente;
	$sql.=" and hr.cod_estado_hoja_ruta<>2";
	$sql.=" and hr.cod_estado_pago_doc<>3";
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
					$descuento_cotizacion=0;
					$sql2=" select c.descuento_cotizacion ";
					$sql2.=" from hojas_rutas hr, cotizaciones c ";
					$sql2.=" where hr.cod_cotizacion=c.cod_cotizacion ";
					$sql2.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$descuento_cotizacion=$dat2['descuento_cotizacion'];
					}
					$incremento_cotizacion=0;
					$sql2=" select c.incremento_cotizacion ";
					$sql2.=" from hojas_rutas hr, cotizaciones c ";
					$sql2.=" where hr.cod_cotizacion=c.cod_cotizacion ";
					$sql2.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$incremento_cotizacion=$dat2['incremento_cotizacion'];
					}										
					$monto_hojaruta=($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion;								
			 	$sql2=" select sum(pd.monto_pago_detalle)";
			 	$sql2.=" from pagos_detalle pd, pagos p";
			 	$sql2.=" where pd.cod_pago=p.cod_pago";
			 	$sql2.=" and p.cod_estado_pago<>2";
			 	$sql2.=" and pd.codigo_doc=".$cod_hoja_ruta;
				$sql2.=" and pd.cod_tipo_doc=1";
				$resp2 = mysql_query($sql2);
				$acuenta_hojaruta=0;
				$monto_pago_detalle=0;
				while($dat2=mysql_fetch_array($resp2)){
					$monto_pago_detalle=$dat2[0];		
				}	
				$acuenta_hojaruta=$acuenta_hojaruta+$monto_pago_detalle;	
			    $totalDeuda=$totalDeuda+($monto_hojaruta-$acuenta_hojaruta);
	}
	$sql=" select ot.cod_orden_trabajo, ot.nro_orden_trabajo, g.gestion ,ot.cod_gestion, ot.numero_orden_trabajo, ";
	$sql.=" ot.fecha_orden_trabajo, ot.monto_orden_trabajo, ot.descuento_orden_trabajo, ot.incremento_orden_trabajo ";
	$sql.=" from ordentrabajo ot, gestiones g ";
	$sql.=" where ot.cod_est_ot<>2  ";
	$sql.=" and ot.cod_estado_pago_doc<>3 ";
	$sql.=" and ot.cod_gestion=g.cod_gestion "; 
	$sql.=" and ot.cod_cliente=".$cod_cliente;
	$sql.=" order by ot.fecha_orden_trabajo asc, ot.nro_orden_trabajo asc ";
	$resp= mysql_query($sql);
	$gestion="";
	while($dat=mysql_fetch_array($resp)){
		 $cod_orden_trabajo=$dat['cod_orden_trabajo'];
		 $nro_orden_trabajo=$dat['nro_orden_trabajo'];
		 $gestion=$dat['gestion'];
		 $cod_gestion=$dat['cod_gestion'];
		 $numero_orden_trabajo=$dat['numero_orden_trabajo'];
		 $fecha_orden_trabajo=$dat['fecha_orden_trabajo'];
		 $monto_orden_trabajo=$dat['monto_orden_trabajo'];
		 $descuento_orden_trabajo=$dat['descuento_orden_trabajo'];
		 $incremento_orden_trabajo=$dat['incremento_orden_trabajo'];
		 $monto_orden_trabajo=($monto_orden_trabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo;
		 

			 	$sql2=" select  sum(pd.monto_pago_detalle)";
			 	$sql2.=" from pagos_detalle pd, pagos p";
			 	$sql2.=" where pd.cod_pago=p.cod_pago";
			 	$sql2.=" and p.cod_estado_pago<>2";
			 	$sql2.=" and pd.codigo_doc=".$cod_orden_trabajo;
				$sql2.=" and pd.cod_tipo_doc=2";
				$resp2 = mysql_query($sql2);
				$acuenta_ordentrabajo=0;
				while($dat2=mysql_fetch_array($resp2)){
					$monto_pago_detalle=$dat2[0];							
				}
	$acuenta_ordentrabajo=$acuenta_ordentrabajo+$monto_pago_detalle;
			  $totalDeuda=$totalDeuda+($monto_orden_trabajo-$acuenta_ordentrabajo);
}

$sql=" select s.cod_salida, s.nro_salida, s.cod_gestion, g.gestion, s.cliente_venta, s.fecha_salida ";
	$sql.=" from salidas s, gestiones g ";
	$sql.=" where s.cod_gestion=g.cod_gestion ";
	$sql.=" and s.cod_tipo_salida=1 ";
	$sql.=" and s.cod_estado_salida=1 ";
	$sql.=" and s.cod_estado_pago_doc<>3 ";
	$sql.=" and s.cod_cliente_venta=".$cod_cliente;
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
		

	 		$monto_venta=0;
			 		$sql2=" select sum(sd.precio_venta*sd.cant_salida) ";
					$sql2.=" from salidas_detalle sd ";
					$sql2.=" where sd.cod_salida=".$cod_salida;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$monto_venta=$dat2[0];
					}

			 	$sql2=" select sum(pd.monto_pago_detalle) ";

			 	$sql2.=" from pagos_detalle pd, pagos p";
			 	$sql2.=" where pd.cod_pago=p.cod_pago";
			 	$sql2.=" and p.cod_estado_pago<>2";
			 	$sql2.=" and pd.codigo_doc=".$cod_salida;
				$sql2.=" and pd.cod_tipo_doc=3";
				$resp2 = mysql_query($sql2);
				$acuenta_venta=0;
				$monto_pago_detalle=0;
				while($dat2=mysql_fetch_array($resp2)){
					$monto_pago_detalle=$dat2[0];

				}				
				$acuenta_venta=$acuenta_venta+$monto_pago_detalle;
			 $totalDeuda=$totalDeuda+($monto_venta-$acuenta_venta);

	}
	$pdf->SetXY(70,275);
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(8,5,"A cuenta:",0,0,'R');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(25,5,number_format($total_pago, 2, ",", ".")." Bs",0,0,'L');
	$pdf->SetXY(110,275);
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(12,5,"Saldo:",0,0,'R');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(25,5,number_format($totalDeuda, 2, ",", ".")." Bs",0,0,'L');
	
	$sql=" select  p.cod_usuario_pago ";
	$sql.=" from pagos p, gestiones g,  clientes cli, estados_pago ep ";
	$sql.=" where  p.cod_gestion=g.cod_gestion ";
	$sql.=" and p.cod_cliente=cli.cod_cliente ";
	$sql.=" and p.cod_estado_pago=ep.cod_estado_pago ";
	$sql.=" and p.cod_pago=".$_GET['cod_pago'];
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){

				$cod_usuario_pago=$dat['cod_usuario_pago'];

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
	}
	$pdf->SetFont('Arial','',8);
		$pdf->SetXY(30,280);
		$pdf->Cell(30,1,".........................................................",0,1,'C',false);
		$pdf->SetX(30);
		$pdf->Cell(30,4,"Recibi Conforme",0,1,'C',false);
		$pdf->SetX(30);
		$pdf->Cell(30,6,"Nombre: ".$nombres_usuario_pago." ".$ap_paterno_usuario_pago,0,1,'C',false);
		
		$pdf->SetXY(155,280);
		$pdf->Cell(30,1,".........................................................",0,1,'C',false);
		$pdf->SetX(155);
		$pdf->Cell(30,4,"Entregue Conforme",0,1,'C',false);
		$pdf->SetX(155);
		$pdf->Cell(30,6,"Nombre.................................................",0,1,'C',false);
			
	 $pdf->Output();


require("cerrar_conexion.inc");
?>


