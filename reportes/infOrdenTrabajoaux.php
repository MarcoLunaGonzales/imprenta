<?php
require("conexion1.inc");
require("fpdf.php");

include("funcionesNumerosALetras.php");


class PDF extends FPDF
{


//Cabecera de página
	function Header()
	{	
	$this->Image('punto.jpg',15,15,185.17,250);	
		
		$cod_orden_trabajo=$_GET['cod_orden_trabajo'];
	/////////////////////////////////////ORDEN DE TRABAJO///////////////	
	$sql=" select cod_est_ot, nro_orden_trabajo,cod_gestion,numero_orden_trabajo, ";
	$sql.=" fecha_orden_trabajo, cod_cliente, cod_contacto,  detalle_orden_trabajo, obs_orden_trabajo, ";
	$sql.=" monto_orden_trabajo, cod_usuario_registro, fecha_registro, cod_usuario_modifica, fecha_modifica, ";
	$sql.=" cod_estado_pago_doc, cod_tipo_pago, obs_anulacion, fecha_anulacion, cod_usuario_anulacion, ";
	$sql.=" incremento_orden_trabajo, incremento_fecha, incremento_obs,cod_usuario_incremento, ";
	$sql.=" descuento_orden_trabajo, descuento_fecha,descuento_obs, cod_usuario_descuento";
	$sql.=" from ordentrabajo";
	$sql.=" where  cod_orden_trabajo=".$_GET['cod_orden_trabajo'];
	
	$resp=mysql_query($sql);
	while ($dat=mysql_fetch_array($resp)){
		
		$cod_est_ot=$dat['cod_est_ot']; 
		$nro_orden_trabajo=$dat['nro_orden_trabajo']; 
		$cod_gestion=$dat['cod_gestion']; 
		$numero_orden_trabajo=$dat['numero_orden_trabajo']; 
		$fecha_orden_trabajo=$dat['fecha_orden_trabajo']; 
		$cod_cliente=$dat['cod_cliente']; 
		$cod_contacto=$dat['cod_contacto']; 
		$detalle_orden_trabajo=$dat['detalle_orden_trabajo'];  
		$obs_orden_trabajo=$dat['obs_orden_trabajo']; 
		$monto_orden_trabajo=$dat['monto_orden_trabajo']; 
		$cod_usuario_registro=$dat['cod_usuario_registro']; 
		$fecha_registro=$dat['fecha_registro']; 
		$cod_usuario_modifica=$dat['cod_usuario_modifica'];  
		$fecha_modifica=$dat['fecha_modifica']; 
		$cod_estado_pago_doc=$dat['cod_estado_pago_doc']; 
		$cod_tipo_pago=$dat['cod_tipo_pago'];  
		$obs_anulacion=$dat['obs_anulacion']; 
		$fecha_anulacion=$dat['fecha_anulacion']; 
		$cod_usuario_anulacion=$dat['cod_usuario_anulacion']; 
	    $incremento_orden_trabajo=$dat['incremento_orden_trabajo']; 
		$incremento_fecha=$dat['incremento_fecha']; 
		$incremento_obs=$dat['incremento_obs']; 
		$cod_usuario_incremento=$dat['cod_usuario_incremento']; 
		$descuento_orden_trabajo=$dat['descuento_orden_trabajo']; 
		$descuento_fecha=$dat['descuento_fecha']; 
		$descuento_obs=$dat['descuento_obs']; 
		$cod_usuario_descuento=$dat['cod_usuario_descuento']; 
		
		list($aOT,$mOT,$dOT)=explode("-",$fecha_orden_trabajo);
	
			/************CLIENTE********************/
			$sql2=" select nombre_cliente, direccion_cliente, telefono_cliente, celular_cliente, fax_cliente ";
			$sql2.=" from clientes where cod_cliente='".$cod_cliente."'";
			$resp2= mysql_query($sql2);
			$nombre_cliente="";
			while($dat2=mysql_fetch_array($resp2)){
				$nombre_cliente=$dat2['nombre_cliente'];
				$direccion_cliente=$dat2['direccion_cliente'];
				$telefono_cliente=$dat2['telefono_cliente'];
				$celular_cliente=$dat2['celular_cliente'];
				$fax_cliente=$dat2['fax_cliente'];
			}
			if($cod_contacto<>"" and $cod_contacto<>0 ){		
				$sql2=" select  nombre_contacto, ap_paterno_contacto, ap_materno_contacto, ";
				$sql2.=" telefono_contacto,celular_contacto, email_contacto, cargo_contacto ";
				$sql2.=" from clientes_contactos ";
				$sql2.=" where cod_contacto=".$cod_contacto;
				$resp2= mysql_query($sql2);
				$nombre_contacto_cliente="";
				while($dat2=mysql_fetch_array($resp2)){
				
					$nombre_contacto_cliente=$dat2['nombre_contacto']." ".$dat2['ap_paterno_contacto']." ".$dat2['ap_materno_contacto'];
					$telefono_contacto=$dat2['telefono_contacto'];
					$celular_contacto=$dat2['celular_contacto'];
					$email_contacto=$dat2['email_contacto'];
					$cargo_contacto=$dat2['cargo_contacto'];				
				}	
			}
						
			/************FIN CLIENTE********************/
		
			/************GESTION********************/
			$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion."'";
			$resp2= mysql_query($sql2);
			$gestionHojaRuta="";
			while($dat2=mysql_fetch_array($resp2)){
				$gestionOrdenTrabajo=$dat2[0];
			}		
			/************FIN GESTION********************/		


		//////////////////Tipo Pago///////////////
		$nombre_tipo_pago_ordentrabajo="";
		$sql2=" select nombre_tipo_pago  from tipos_pago ";
		$sql2.=" where cod_tipo_pago='".$cod_tipo_pago."'";
		$resp2=mysql_query($sql2);
		while ($dat2=mysql_fetch_array($resp2)){
			$nombre_tipo_pago_ordentrabajo=$dat2['nombre_tipo_pago'];
		}		
		///////////////////Fin Tipo pago/////////////////////

	}
	////////////////////////FIN DATOS GENERALES ORDEN TRABAJO///////////////////////////		

/**********************DATOS DE CABECERA*********************/

	
		$sql5="select  valor_x, valor_y from coordenadas_impresion where cod_coordenada=1";
		$resp5=mysql_query($sql5);
		while ($dat5=mysql_fetch_array($resp5)){
			$valorX=$dat5[0];
			$valorY=$dat5[1];
		}


		/**********************Fin Datos de Cliente******************************/	

			


	
	$facturas="";
	$sqlAux=" select fot.cod_factura, f.nro_factura, f.fecha_factura, f.monto_factura ";
	$sqlAux.=" from factura_ordentrabajo fot, facturas f ";
	$sqlAux.=" where fot.cod_factura=f.cod_factura  and f.cod_est_fac<>2 ";
	$sqlAux.=" and fot.cod_orden_trabajo=".$cod_orden_trabajo;
	$respAux=mysql_query($sqlAux);
	while ($datAux=mysql_fetch_array($respAux)){
		$cod_factura=$datAux['cod_factura'];
		$nro_factura=$datAux['nro_factura'];
		$fecha_factura=$datAux['fecha_factura'];
		$monto_factura=$datAux['monto_factura'];
		$facturas=$facturas."Nro. ".$nro_factura." ".$fecha_factura." (".$monto_factura."); ";
	}
	$totalFacturas=0;
	if($facturas<>""){
		$totalFacturas=0;
		$sqlAux=" select sum(f.monto_factura) ";
		$sqlAux.=" from factura_ordentrabajo fot, facturas f ";
		$sqlAux.=" where fot.cod_factura=f.cod_factura  and f.cod_est_fac<>2 ";
		$sqlAux.=" and fot.cod_orden_trabajo=".$cod_orden_trabajo;
		$respAux=mysql_query($sqlAux);
		while ($datAux=mysql_fetch_array($respAux)){
			$totalFacturas=$datAux[0];
		}
		
	}

		/**********************Fin Datos de Cliente******************************/	

			
$this->SetFont('Arial','B',10);
			$this->SetTextColor(0,0,0);	
			$this->SetFont('Arial','B',9);
			$this->SetXY(160,16);
    	    $this->Cell(0,4,'Página '.$this->PageNo().' de '.' {nb}',0,1,'R',false);
						
			$this->SetFont('Arial','B',14);
			$this->SetTextColor(0,0,0);
			$this->Text(74,18,"INFORME DE ORDEN DE TRABAJO");
			$this->SetFont('Arial','B',14);
			$this->SetTextColor(0,0,0);
			$this->Text(94,24,"NRO. ".$nro_orden_trabajo."/".$gestionOrdenTrabajo);	
			$this->SetFont('Arial','B',14);
			$this->SetTextColor(0,0,0);
			$this->Text(89,30,"FECHA: ".$dOT."/".$mOT."/".$aOT);	
						
					
			
			$val_Y_cabecera=37;
			$this->SetFont('Arial','B',10);
			$this->SetXY(12,$val_Y_cabecera);
			$this->Cell(20,5,'CLIENTE:',0,0,'L');
			$this->SetFont('Arial','',10);
			$this->SetXY(36,$val_Y_cabecera);
			$this->Cell(0,5,$nombre_cliente,0,0,'L');
			if($cod_contacto<>"" and $cod_contacto<>0){
				$val_Y_cabecera=$val_Y_cabecera+5;
				$this->SetFont('Arial','B',10);
				$this->SetXY(36,$val_Y_cabecera);
				$this->Cell(17,5,'Contacto:',0,0,'L');
				$this->SetFont('Arial','',10);
				$this->SetXY(55,$val_Y_cabecera);
				$this->Cell(0,5,$nombre_contacto_cliente,0,0,'L');
				$this->SetFont('Arial','B',10);
				$this->SetXY(120,$val_Y_cabecera);
				$this->Cell(12,5,'Telf:',0,0,'L');
				$this->SetFont('Arial','',10);
				$this->SetXY(132,$val_Y_cabecera);
				$this->Cell(0,5,$telefono_contacto." ".$celular_contacto,0,0,'L');				
			}
			$val_Y_cabecera=$val_Y_cabecera+5;
			$this->SetXY(12,$val_Y_cabecera);
			$this->SetFont('Arial','B',10);
			$this->Cell(20,5,'DIRECCION:',0,0,'L');
			$this->SetFont('Arial','',10);
			$this->SetXY(36,$val_Y_cabecera);
			$this->Cell(0,5,$direccion_cliente,0,0,'L');
			$val_Y_cabecera=$val_Y_cabecera+5;
			
			$this->SetXY(12,$val_Y_cabecera);
			$this->SetFont('Arial','B',10);
			$this->Cell(20,5,'TELF:',0,0,'L');
			$this->SetFont('Arial','',10);
			$this->SetXY(36,$val_Y_cabecera);
			$this->Cell(0,5,$telefono_cliente,0,0,'L');
			$this->SetXY(90,$val_Y_cabecera);
			$this->SetFont('Arial','B',10);
			$this->Cell(20,5,'CELULAR:',0,0,'L');
			$this->SetFont('Arial','',10);
			$this->SetXY(110,$val_Y_cabecera);
			$this->Cell(0,5,$celular_cliente,0,0,'L');
			$this->SetXY(150,$val_Y_cabecera);
			$this->SetFont('Arial','B',10);
			$this->Cell(12,5,'FAX:',0,0,'L');
			$this->SetFont('Arial','',10);
			$this->SetXY(162,$val_Y_cabecera);
			$this->Cell(0,5,$fax_cliente,0,0,'L');
			
			$val_Y_cabecera=$val_Y_cabecera+5;
			
			$this->SetXY(12,$val_Y_cabecera);
			$this->SetFont('Arial','B',10);
			$this->Cell(0,5,'TIPO PAGO:',0,0,'L');
			$this->SetFont('Arial','',10);
			$this->SetXY(36,$val_Y_cabecera);
			$this->Cell(0,5,$nombre_tipo_pago_ordentrabajo,0,0,'L');

			

		/************************FIN DATOS DE CABECERA*************************************/			
			$val_Y_cabecera=$val_Y_cabecera+5;
			
			$this->SetXY(12,$val_Y_cabecera);
			$this->SetFont('Arial','B',10);
			$this->Cell(25,5,"FACTURAS:",0,0,'L');		
			$this->SetXY(37,$val_Y_cabecera);
			$this->SetFont('Arial','',10);
			$this->Cell(170,5,$facturas,0,0,'L');	
			$val_Y_cabecera=$val_Y_cabecera+5;
			$this->SetXY(12,$val_Y_cabecera);
			$this->SetFont('Arial','B',10);
			$this->Cell(25,5,"TOTAL FACT:",0,0,'L');
			$this->SetFont('Arial','',10);		
			$this->SetXY(37,$val_Y_cabecera);
			$this->Cell(170,5,number_format($totalFacturas,2),0,0,'L');
			
			
			//$this->Text(12,25,"CLIENTE:".$nombre_cliente);

			$this->SetY(75);
		/************************FIN DATOS DE CABECERA*************************************/

			
	}

	//Pie de página
	function Footer()
	{	
	
	}

}

	$sql5="select  valor_x, valor_y from coordenadas_impresion where cod_coordenada=1";
	$resp5=mysql_query($sql5);
	while ($dat5=mysql_fetch_array($resp5)){
			$valorX=$dat5[0];
			$valorY=$dat5[1];
	}
	$cod_orden_trabajo=$_GET['cod_orden_trabajo'];

		
	//Creación del objeto de la clase heredada
	//$pdf=new PDF('P','mm','Letter');
	$pdf=new PDF('P','mm',array(214,279));
	//$pdf->SetAutoPageBreak(true,75-$valorY);
	
	$pdf->AliasNbPages();
	$pdf->AddPage();
	//$pdf->Line(0, 0, 214,279);

$sql=" select cod_est_ot, nro_orden_trabajo,cod_gestion,numero_orden_trabajo, ";
	$sql.=" fecha_orden_trabajo, cod_cliente, cod_contacto,  detalle_orden_trabajo, obs_orden_trabajo, ";
	$sql.=" monto_orden_trabajo, cod_usuario_registro, fecha_registro, cod_usuario_modifica, fecha_modifica, ";
	$sql.=" cod_estado_pago_doc, cod_tipo_pago, obs_anulacion, fecha_anulacion, cod_usuario_anulacion, ";
	$sql.=" incremento_orden_trabajo, incremento_fecha, incremento_obs,cod_usuario_incremento, ";
	$sql.=" descuento_orden_trabajo, descuento_fecha,descuento_obs, cod_usuario_descuento";
	$sql.=" from ordentrabajo";
	$sql.=" where  cod_orden_trabajo=".$_GET['cod_orden_trabajo'];
	
	$resp=mysql_query($sql);
	while ($dat=mysql_fetch_array($resp)){
		
		$cod_est_ot=$dat['cod_est_ot']; 
		$nro_orden_trabajo=$dat['nro_orden_trabajo']; 
		$cod_gestion=$dat['cod_gestion']; 
		$numero_orden_trabajo=$dat['numero_orden_trabajo']; 
		$fecha_orden_trabajo=$dat['fecha_orden_trabajo']; 
		$cod_cliente=$dat['cod_cliente']; 
		$cod_contacto=$dat['cod_contacto']; 
		$detalle_orden_trabajo=$dat['detalle_orden_trabajo'];  
		$obs_orden_trabajo=$dat['obs_orden_trabajo']; 
		$monto_orden_trabajo=$dat['monto_orden_trabajo']; 
		$cod_usuario_registro=$dat['cod_usuario_registro']; 
		$fecha_registro=$dat['fecha_registro']; 
		$cod_usuario_modifica=$dat['cod_usuario_modifica'];  
		$fecha_modifica=$dat['fecha_modifica']; 
		$cod_estado_pago_doc=$dat['cod_estado_pago_doc']; 
		$cod_tipo_pago=$dat['cod_tipo_pago'];  
		$obs_anulacion=$dat['obs_anulacion']; 
		$fecha_anulacion=$dat['fecha_anulacion']; 
		$cod_usuario_anulacion=$dat['cod_usuario_anulacion']; 
	    $incremento_orden_trabajo=$dat['incremento_orden_trabajo']; 
		$incremento_fecha=$dat['incremento_fecha']; 
		$incremento_obs=$dat['incremento_obs']; 
		$cod_usuario_incremento=$dat['cod_usuario_incremento']; 
		$descuento_orden_trabajo=$dat['descuento_orden_trabajo']; 
		$descuento_fecha=$dat['descuento_fecha']; 
		$descuento_obs=$dat['descuento_obs']; 
		$cod_usuario_descuento=$dat['cod_usuario_descuento']; 
		list($aOT,$mOT,$dOT)=explode("-",$fecha_orden_trabajo);
	
				/************CLIENTE********************/
			$sql2=" select nombre_cliente, direccion_cliente, telefono_cliente, celular_cliente, fax_cliente";
			$sql2.=" from clientes where cod_cliente='".$cod_cliente."'";
			$resp2= mysql_query($sql2);
			$nombre_cliente="";
			while($dat2=mysql_fetch_array($resp2)){
				$nombre_cliente=$dat2['nombre_cliente'];
				$direccion_cliente=$dat2['direccion_cliente'];
				$telefono_cliente=$dat2['telefono_cliente'];
				$celular_cliente=$dat2['celular_cliente'];
				$fax_cliente=$dat2['fax_cliente'];
			}		
			/************FIN CLIENTE********************/
		
			/************GESTION********************/
			$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion."'";
			$resp2= mysql_query($sql2);
			$gestionHojaRuta="";
			while($dat2=mysql_fetch_array($resp2)){
				$gestionOrdenTrabajo=$dat2[0];
			}		
			/************FIN GESTION********************/		


		//////////////////Tipo Pago///////////////
		$nombre_tipo_pago_ordentrabajo="";
		$sql2=" select nombre_tipo_pago  from tipos_pago ";
		$sql2.=" where cod_tipo_pago='".$cod_tipo_pago."'";
		$resp2=mysql_query($sql2);
		while ($dat2=mysql_fetch_array($resp2)){
			$nombre_tipo_pago_ordentrabajo=$dat2['nombre_tipo_pago'];
		}		
		///////////////////Fin Tipo pago/////////////////////

	}
	
	
/*********************************CUERPO DE COTIZACION****************************************/
		$variableY=$pdf->GetY();
		$pdf->SetFont('Arial','',10);
		$pdf->SetXY(12,$variableY);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(158,6,"DESCRIPCION DE TRABAJO",1,0,'C');	
		$pdf->SetX(170);
		$pdf->Cell(35,6,"IMPORTE",1,1,'C');
		
		$variableY=$pdf->GetY();
		$pdf->SetFont('Arial','',10);
		$pdf->setXY(170,$variableY);
		$pdf->Cell(25,6,number_format($monto_orden_trabajo,2),0,1,'R');
		$pdf->setXY(14,$variableY);		
		$pdf->MultiCell(155,5,$detalle_orden_trabajo,0, 'L',false);
		$pdf->Ln();
		$variableY=$pdf->GetY();		
		if($obs_orden_trabajo<>""){
			$pdf->SetFont('Arial','B',10);
			$pdf->setXY(170,$variableY);
			$pdf->Cell(0,6,"",0,1,'R');		
			$pdf->setXY(14,$variableY);
			$pdf->MultiCell(155,5,"NOTA:".$obs_orden_trabajo,0, 'L',false);
			
		}
		$pdf->Ln();
		$variableY=$pdf->GetY();	
		$pdf->line(12,$variableY,205,$variableY);
		$variableY=$variableY+5;
		$pdf->setXY(14,$variableY);	
		$pdf->SetFont('Arial','B',10);	
		$pdf->Cell(155,6,"TOTAL:",0,0,'R');	

		$pdf->SetFont('Arial','',10);		
		$pdf->setXY(170,$variableY);
		$pdf->Cell(25,6,number_format($monto_orden_trabajo,2),0,1,'R');
		
		$variableY=$variableY+5;
		$pdf->setXY(14,$variableY);	
		$pdf->SetFont('Arial','B',10);	
		$pdf->Cell(155,6,"INCREMENTO:",0,0,'R');	
		$pdf->SetFont('Arial','',10);		
		$pdf->setXY(170,$variableY);
		$pdf->Cell(25,6,number_format($incremento_orden_trabajo,2),0,1,'R');		
		$variableY=$variableY+5;
		$pdf->setXY(14,$variableY);	
		$pdf->SetFont('Arial','B',10);	
		$pdf->Cell(155,6,"DESCUENTO:",0,0,'R');	
		$pdf->SetFont('Arial','',10);		
		$pdf->setXY(170,$variableY);
		$pdf->Cell(25,6,number_format($descuento_orden_trabajo,2),0,1,'R');				
		$variableY=$variableY+5;
		$pdf->setXY(14,$variableY);	
		$pdf->SetFont('Arial','B',10);	
		$pdf->Cell(155,6,"TOTAL  O.T.:",0,0,'R');	
		$pdf->SetFont('Arial','',10);		
		$pdf->setXY(170,$variableY);
		$pdf->Cell(25,6,number_format((($monto_orden_trabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo),2),0,1,'R');	

		
	///////////////////ACUENTA///////////////
	$sql2=" select pd.cod_moneda, pd.monto_pago_detalle, p.fecha_pago ";
			 	$sql2.=" from pagos_detalle pd, pagos p";
			 	$sql2.=" where pd.cod_pago=p.cod_pago";
			 	$sql2.=" and p.cod_estado_pago<>2";
			 	$sql2.=" and pd.codigo_doc=".$cod_orden_trabajo;
				$sql2.=" and pd.cod_tipo_doc=2";
				$resp2 = mysql_query($sql2);
				$acuenta_ordentrabajo=0;
				while($dat2=mysql_fetch_array($resp2)){
					//$cod_moneda=$dat2['cod_moneda'];
					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					$fecha_pago=$dat2['fecha_pago'];
					//if($cod_moneda==1){
						$acuenta_ordentrabajo=$acuenta_ordentrabajo+$monto_pago_detalle;
					/*}else{
							$sql3="select cambio_bs from tipo_cambio";
							$sql3.=" where fecha_tipo_cambio='".$fecha_pago."'";
							$sql3.=" and cod_moneda=".$cod_moneda;
							$resp3 = mysql_query($sql3);
							$cambio_bs=0;
							while($dat3=mysql_fetch_array($resp3)){
								$cambio_bs=$dat3['cambio_bs'];
							}
							if($cambio_bs<>0){
								$acuenta_ordentrabajo=$acuenta_ordentrabajo+($monto_pago_detalle*$cambio_bs);
							
							}
						
					}*/
				}				
			 
	///////////////FIN A CUENTA/////////////////////
	$monto_real_ot=0;
	$monto_real_ot=(($monto_orden_trabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo);
	$variableY=$variableY+5;
		$pdf->setXY(14,$variableY);	
		$pdf->SetFont('Arial','B',10);	
		$pdf->Cell(155,6,"A CUENTA  O.T.:",0,0,'R');	
		$pdf->SetFont('Arial','',10);		
		$pdf->setXY(170,$variableY);
		$pdf->Cell(25,6,number_format(($acuenta_ordentrabajo),2),0,1,'R');	
	$variableY=$variableY+5;
		$pdf->setXY(14,$variableY);	
		$pdf->SetFont('Arial','B',10);	
		$pdf->Cell(155,6,"SALDO O.T.:",0,0,'R');	
		$pdf->SetFont('Arial','',10);		
		$pdf->setXY(170,$variableY);
		$pdf->Cell(25,6,number_format(($monto_real_ot-$acuenta_ordentrabajo),2),0,1,'R');				


	
	//////////////////////////DETALLE DE PAGOS////////////////////////
		$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);	
	$pdf->SetX(12);
	$pdf->Cell(195,6,"DETALLE DE PAGOS",1,1,'C',false);	
			
	$pdf->SetFont('Arial','B',7);
	$pdf->SetX(12);
	$pdf->Cell(30,4,"Nro Comprobante",1,0,'C',false);
	$pdf->SetX(42);
	$pdf->Cell(30,4,"Fecha Comprobante",1,0,'C',false);
	$pdf->SetX(72);
	$pdf->Cell(20,4,"Nro Pago",1,0,'C',false);
	$pdf->SetX(92);
	$pdf->Cell(20,4,"Fecha Pago",1,0,'C',false);
	$pdf->SetX(112);	
	$pdf->Cell(25,4,"Forma Pago",1,0,'C',false);
	$pdf->SetX(137);
	$pdf->Cell(25,4,"Monto Pago",1,0,'C',false);
	$pdf->SetX(162);
	$pdf->Cell(25,4,"Cambio",1,0,'C',false);	
	$pdf->SetX(187);
	$pdf->Cell(20,4,"Monto Bs",1,1,'C',false);	
	
	$acuenta_ordentrabajo=0;
	$sqlAux=" select p.nro_pago, p.cod_gestion, g.gestion,  pd.cod_moneda, pd.monto_pago_detalle, p.fecha_pago, "; 
	$sqlAux.=" pd.nro_comprobante, pd.fecha_comprobante, pd.cod_forma_pago,";
	$sqlAux.=" pd.cod_banco,pd.cod_moneda ";
	$sqlAux.=" from pagos_detalle pd, pagos p, gestiones g";
	$sqlAux.=" where pd.cod_pago=p.cod_pago ";
	$sqlAux.=" and p.cod_gestion=g.cod_gestion ";
	//$sqlAux.=" and pd.cod_forma_pago=fp.cod_forma_pago ";
	//$sqlAux.=" and pd.cod_moneda=m.cod_moneda ";
	$sqlAux.=" and p.cod_estado_pago<>2 ";
	$sqlAux.=" and pd.codigo_doc=".$_GET['cod_orden_trabajo'];
	$sqlAux.=" and pd.cod_tipo_doc=2";
	$sqlAux.=" order by  pd.fecha_comprobante desc, pd.nro_comprobante desc  ";
	$respAux = mysql_query($sqlAux);
	while($datAux=mysql_fetch_array($respAux)){
		$nro_pago=$datAux['nro_pago'];
		$cod_gestion=$datAux['cod_gestion'];
		$gestion=$datAux['gestion'];
		$cod_moneda=$datAux['cod_moneda'];
		$monto_pago_detalle=$datAux['monto_pago_detalle'];
		$fecha_pago=$datAux['fecha_pago'];
		$nro_comprobante=$datAux['nro_comprobante'];
		$fecha_comprobante=$datAux['fecha_comprobante'];
		$cod_forma_pago=$datAux['cod_forma_pago'];
		//$desc_forma_pago=$datAux['desc_forma_pago'];
		$cod_banco=$datAux['cod_banco'];
		$cod_moneda=$datAux['cod_moneda'];
		//$abrev_moneda=$datAux['abrev_moneda'];	
					$cambio_bs=1;
					//if($cod_moneda==1){
						$acuenta_ordentrabajo=$acuenta_ordentrabajo+$monto_pago_detalle;
					/*}else{
							$sql3="select cambio_bs from tipo_cambio";
							$sql3.=" where fecha_tipo_cambio='".$fecha_pago."'";
							$sql3.=" and cod_moneda=".$cod_moneda;
							$resp3 = mysql_query($sql3);
							$cambio_bs=1;
							while($dat3=mysql_fetch_array($resp3)){
								$cambio_bs=$dat3['cambio_bs'];
							}
							$acuenta_ordentrabajo=$acuenta_ordentrabajo+($monto_pago_detalle*$cambio_bs);

					}*/
							
		
			$pdf->SetFont('Arial','',6);
			$pdf->SetX(12);
			$pdf->Cell(30,4,$nro_comprobante,1,0,'R',false);
			$pdf->SetX(42);
			$pdf->Cell(30,4,$fecha_comprobante,1,0,'R',false);
			$pdf->SetX(72);
			$pdf->Cell(20,4,$nro_pago."/".$gestion,1,0,'R',false);			
			$pdf->SetX(92);
			$pdf->Cell(20,4,$fecha_pago,1,0,'R',false);
			$pdf->SetX(112);			
			$pdf->Cell(25,4,$desc_forma_pago,1,0,'R',false);
			$pdf->SetX(137);
			$pdf->Cell(25,4,number_format($monto_pago_detalle*$cambio_bs,2)." ".$abrev_moneda,1,0,'R',false);
			$pdf->SetX(162);
			if($cod_moneda==1){
				$pdf->Cell(25,4,"",1,0,'C',false);	
			}else{
				$pdf->Cell(25,4,$cambio_bs,1,0,'C',false);
			}
			$pdf->SetX(187);
			$pdf->Cell(20,4,number_format($monto_pago_detalle*$cambio_bs,2)." Bs.",1,1,'R',false);	
			
	}	
	$pdf->SetFont('Arial','B',6);
	$pdf->SetX(12);
	$pdf->Cell(175,4,"TOTAL A CUENTA",1,0,'R',false);	
	$pdf->SetX(187);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(20,4,number_format($acuenta_ordentrabajo,2)." Bs.",1,1,'R',false);	

	/////////////////////////FIN DETALLE DE PAGOS///////////////////////
	
	//////////////////////SALIDAS DE ALMACEN/////////////////
	$pdf->Ln();
		$pdf->SetFont('Arial','B',10);	
	$pdf->SetX(12);
	$pdf->Cell(195,6,"DETALLE SALIDAS DE ALMACEN",1,1,'C',false);		
	
	$pdf->SetFont('Arial','B',7);
	$pdf->SetX(12);
	$pdf->Cell(12,4,"Nro Sal.",1,0,'C',false);
	$pdf->SetX(24);
	$pdf->Cell(13,4,"Fecha Sal.",1,0,'C',false);
	$pdf->SetX(37);
	$pdf->Cell(20,4,"Almacen",1,0,'C',false);
	$pdf->SetX(57);
	$pdf->Cell(60,4,"Material",1,0,'C',false);
	$pdf->SetX(117);	
	$pdf->Cell(15,4,"Cantidad",1,0,'C',false);
	$pdf->SetX(132);
	$pdf->Cell(45,4,"Proveedor",1,0,'C',false);
	$pdf->SetX(177);
	$pdf->Cell(15,4,"Factura",1,0,'C',false);	
	$pdf->SetX(192);
	$pdf->Cell(15,4,"Monto Bs",1,1,'C',false);
		
	$sqlAux=" select s.cod_salida, s.nro_salida, s.cod_gestion, g.gestion, s.fecha_salida, s.cod_almacen, s.cod_usuario_salida, ";
	$sqlAux.=" sd.cod_material, m.nombre_material, m.desc_completa_material, m.cod_unidad_medida,um.abrev_unidad_medida,";
	$sqlAux.=" sd.cant_salida, sd.precio_venta";
	$sqlAux.=" from salidas s, salidas_detalle sd, gestiones g, materiales m, unidades_medidas um";
	$sqlAux.=" where s.cod_salida=sd.cod_salida";
	$sqlAux.=" and s.cod_gestion=g.cod_gestion";
	$sqlAux.=" and sd.cod_material=m.cod_material";
	$sqlAux.=" and m.cod_unidad_medida=um.cod_unidad_medida";
	$sqlAux.=" and s.cod_orden_trabajo=".$_GET['cod_orden_trabajo'];
	$sqlAux.=" and s.cod_estado_salida<>2";
	$sqlAux.=" order by s.nro_salida asc, g.gestion asc	";
	$respAux = mysql_query($sqlAux);
	$cambio_bs=1;
	$costoTotalSalidas=0;
	while($datAux=mysql_fetch_array($respAux)){
		$cod_salida=$datAux['cod_salida'];
		$nro_salida=$datAux['nro_salida'];
		$cod_gestion=$datAux['cod_gestion'];
		$gestionSalida=$datAux['gestion'];
		$fecha_salida=$datAux['fecha_salida'];
		$cod_almacen=$datAux['cod_almacen'];
		///Nombre Almacen/////
			$sql3="select nombre_almacen from almacenes where cod_almacen=".$cod_almacen;
			$resp3 = mysql_query($sql3);
			$nombre_almacen="";
			while($dat3=mysql_fetch_array($resp3)){
					$nombre_almacen=$dat3['nombre_almacen'];
			}
		/// Fin Nombre Almacen/// 
		$cod_usuario_salida=$datAux['cod_usuario_salida'];
		$cod_material=$datAux['cod_material'];
		$nombre_material=$datAux['nombre_material'];
		$desc_completa_material=$datAux['desc_completa_material'];
		$cod_unidad_medida=$datAux['cod_unidad_medida'];
		$abrev_unidad_medida=$datAux['abrev_unidad_medida'];
		$cant_salida=$datAux['cant_salida'];
		$precio_venta=$datAux['precio_venta'];
		
		//////////////////
					$costoMaterial=0;
					$proveedor="";
					$facturas="";
					$sql2=" select cant_salida_ingreso, cod_ingreso_detalle ";
					$sql2.=" from salidas_detalle_ingresos ";
					$sql2.=" WHERE cod_salida=".$cod_salida;
					$sql2.=" and cod_material=".$cod_material;
					$sql2.=" order by cod_ingreso_detalle asc";
					$resp2 = mysql_query($sql2);					
					while($dat2=mysql_fetch_array($resp2)){
						$cant_salida_ingreso=$dat2[0];
						$cod_ingreso_detalle=$dat2[1];	
						
						$sql3=" select ig.cod_ingreso, i.nro_ingreso, i.cod_gestion, g.gestion,  ";
						$sql3.=" ig.precio_compra_uni, i.cod_proveedor, p.nombre_proveedor, i.nro_factura";
						$sql3.=" from ingresos_detalle ig, ingresos i, gestiones g, proveedores p ";
						$sql3.=" where ig.cod_ingreso=i.cod_ingreso ";
						$sql3.=" and  g.cod_gestion=i.cod_gestion ";
						$sql3.=" and  i.cod_proveedor=p.cod_proveedor ";
						$sql3.=" and ig.cod_ingreso_detalle=".$cod_ingreso_detalle;
						$sql3.=" and ig.cod_material=".$cod_material;
						
						$resp3 = mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3)){
							$cod_ingreso=$dat3['cod_ingreso'];
							$nro_ingreso=$dat3['nro_ingreso'];
							$cod_gestion_ingreso=$dat3['cod_gestion'];													
							$gestion_ingreso=$dat3['gestion'];													
							$precio_compra_uni=$dat3['precio_compra_uni'];
							$cod_proveedor=$dat3['cod_proveedor'];
							$nombre_proveedor=$dat3['nombre_proveedor'];
							$nro_factura=$dat3['nro_factura'];
							$costoMaterial=$costoMaterial+($cant_salida_ingreso*$precio_compra_uni);
							$proveedor=$proveedor.$nombre_proveedor.";";
							$facturas=$facturas.$nro_factura.";";
						}
					}
					$costoTotalSalidas=$costoTotalSalidas+$costoMaterial;
		//////////////////////////
		
		$pdf->SetFont('Arial','',6);
		//$pdf->Cell(0,4,$sql3,1,0,'R',false);
		
		$pdf->SetX(12);
		$pdf->Cell(12,4,$nro_salida."/".$gestionSalida,1,0,'R',false);
		$pdf->SetX(24);
		$pdf->Cell(13,4,$fecha_salida,1,0,'R',false);
		$pdf->SetX(37);
		$pdf->SetFont('Arial','',5);
		$pdf->Cell(20,4,$nombre_almacen,1,0,'R',false);
		$pdf->SetX(57);
		$pdf->Cell(60,4,$desc_completa_material,1,0,'R',false);
		$pdf->SetFont('Arial','',6);
		$pdf->SetX(117);	
		$pdf->Cell(15,4,number_format($cant_salida,2)." ".$abrev_unidad_medida,1,0,'R',false);
		$pdf->SetX(132);
		$pdf->SetFont('Arial','',4);
		$pdf->Cell(45,4,$proveedor,1,0,'R',false);
		$pdf->SetX(177);
		$pdf->Cell(15,4,$facturas,1,0,'R',false);
		$pdf->SetFont('Arial','',6);	
		$pdf->SetX(192);
		$pdf->Cell(15,4,number_format($costoMaterial,2)." Bs",1,1,'R',false);
		//$pdf->Cell(15,4,($precio_compra_uni)." aaaaBs",1,1,'R',false);

	
	}
	$pdf->SetFont('Arial','B',6);	
	$pdf->SetX(12);
	$pdf->Cell(180,4,"TOTAL SALIDA MATERIAL",1,0,'R',false);	
	$pdf->SetX(192);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(15,4,number_format($costoTotalSalidas,2)." Bs",1,1,'R',false);
	//////////////////////FIN SALIDAS DE ALMACEN///////////////////////
//$pdf->Cell(0,4,$sql3,1,0,'R',false);
	 $pdf->Ln();
	 
	$pdf->Ln();
	
	$pdf->SetFont('Arial','B',10);	
	$pdf->SetX(12);
	$pdf->Cell(195,6,"DETALLE DE GASTOS EXTRAS",1,1,'C',false);			
	$pdf->SetFont('Arial','B',7);
	$pdf->SetX(12);
	$pdf->Cell(13,4,"Fecha",1,0,'C',false);
	$pdf->SetX(25);
	$pdf->Cell(15,4,"Nro. Recibo",1,0,'C',false);
	$pdf->SetX(40);
	$pdf->Cell(45,4,"Proveedor",1,0,'C',false);				
	$pdf->SetX(85);
	$pdf->Cell(25,4,"Gasto",1,0,'C',false);
	$pdf->SetX(110);	
	$pdf->Cell(67,4,"Descripcion",1,0,'C',false);
	$pdf->SetX(177);
	$pdf->Cell(15,4,"Cant",1,0,'C',false);	
	$pdf->SetX(192);
	$pdf->Cell(15,4,"Monto",1,1,'C',false);	
					

	////////////GASTOS EXTRAS/////////////
		$gastosExtras=0;
		$sqlAux=" select got.cod_gasto_ordentrabajo, got.cod_gasto, g.desc_gasto, ";
		$sqlAux.=" got.fecha_gasto, got.monto_gasto, got.cant_gasto, got.descripcion_gasto,got.cod_proveedor, ";
		$sqlAux.=" p.nombre_proveedor, got.cod_contacto_proveedor, got.recibo_gasto, got.cod_usuario_registro, ";
		$sqlAux.=" got.fecha_registro, got.cod_usuario_modifica, got.fecha_modifica";
		$sqlAux.=" from gastos_ordentrabajo got, proveedores p, gastos g";
		$sqlAux.=" where got.cod_proveedor=p.cod_proveedor";
		$sqlAux.=" and got.cod_gasto=g.cod_gasto";
		$sqlAux.=" and got.cod_orden_trabajo=".$_GET['cod_orden_trabajo'];
		$sqlAux.=" order by got.fecha_gasto desc ";
		$respAux = mysql_query($sqlAux);
		while($datAux=mysql_fetch_array($respAux)){
		
				$cod_gasto_hojaruta=$datAux['cod_gasto_hojaruta'];
				$cod_gasto=$datAux['cod_gasto']; 
				$desc_gasto=$datAux['desc_gasto'];
				$fecha_gasto=$datAux['fecha_gasto'];
				$monto_gasto=$datAux['monto_gasto'];
				$cant_gasto=$datAux['cant_gasto'];
				$descripcion_gasto=$datAux['descripcion_gasto'];
				$cod_proveedor=$datAux['cod_proveedor']; 
				$nombre_proveedor=$datAux['nombre_proveedor']; 
				$cod_contacto_proveedor=$datAux['cod_proveedor']; 
				$recibo_gasto=$datAux['recibo_gasto']; 
				$cod_usuario_registro=$datAux['cod_usuario_registro'];
				$fecha_registro=$datAux['fecha_registro'];
				$cod_usuario_modifica=$datAux['cod_usuario_modifica'];
				$fecha_modifica=$datAux['fecha_modifica'];

				$pdf->SetFont('Arial','',6);
				$pdf->SetX(12);
				$pdf->Cell(13,4,strftime("%d/%m/%Y",strtotime($fecha_gasto)),1,0,'L',false);
				$pdf->SetX(25);
				$pdf->Cell(15,4,$recibo_gasto,1,0,'L',false);
				$pdf->SetX(40);
				$pdf->SetFont('Arial','',4);
				$pdf->Cell(45,4,$nombre_proveedor,1,0,'L',false);				
		 		$pdf->SetX(85);
				$pdf->Cell(25,4,$desc_gasto,1,0,'L',false);
				$pdf->SetX(110);	
				$pdf->Cell(67,4,$descripcion_gasto,1,0,'L',false);
				$pdf->SetX(177);
				$pdf->SetFont('Arial','',6);
				$pdf->Cell(15,4,number_format($cant_gasto,2),1,0,'R',false);	
				$pdf->SetX(192);
				$pdf->Cell(15,4,number_format($monto_gasto,2)." Bs",1,1,'R',false);	
				$gastosExtras=$gastosExtras+$monto_gasto;				
		
		}
	$pdf->SetFont('Arial','B',6);	
	$pdf->SetX(12);
	$pdf->Cell(180,4,"TOTAL GASTOS EXTRAS",1,0,'R',false);	
	$pdf->SetX(192);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(15,4,number_format($gastosExtras,2)." Bs",1,1,'R',false);
	
////////////COSTOS EXTRAS/////////////
	$pdf->Ln();
	$pdf->Ln();
$pdf->SetFont('Arial','B',10);	
	$pdf->SetX(12);
	$pdf->Cell(195,6,"COSTOS EXTERNOS",1,1,'C',false);			
	$pdf->SetFont('Arial','B',7);
	$pdf->SetX(12);
	$pdf->Cell(13,4,"Fecha",1,0,'C',false);
	$pdf->SetX(25);
	$pdf->Cell(15,4,"Nro. Recibo",1,0,'C',false);
	$pdf->SetX(40);
	$pdf->Cell(45,4,"Proveedor",1,0,'C',false);				
	$pdf->SetX(85);
	$pdf->Cell(25,4,"Gasto",1,0,'C',false);
	$pdf->SetX(110);	
	$pdf->Cell(67,4,"Descripcion",1,0,'C',false);
	$pdf->SetX(177);
	$pdf->Cell(15,4,"Cant",1,0,'C',false);	
	$pdf->SetX(192);
	$pdf->Cell(15,4,"Monto",1,1,'C',false);	
	$costosExternos=0;
	$sqlAux="select gg.cod_gasto_gral, gg.cod_gestion,g.gestion, gg.nro_gasto_gral, gg.codigo_doc,";
	$sqlAux.=" gg.cod_tipo_doc, tp.desc_tipo_doc, tp.abrev_tipo_doc, gg.cod_proveedor, ";
	$sqlAux.=" p.nombre_proveedor, gg.fecha_gasto_gral, ";
	$sqlAux.=" gg.nro_recibo, gg.monto_gasto_gral,gg.cant_gasto_gral,gg.desc_gasto_gral,";
	$sqlAux.=" gg.cod_gasto, ga.desc_gasto,gg.cod_estado_pago_doc, epd.desc_estado_pago_doc, gg.fecha_registro, gg.cod_usuario_registro,";
	$sqlAux.=" gg.fecha_modifica, gg.cod_usuario_modifica,gg.cod_estado, egg.desc_estado, hr.nro_hoja_ruta, ot.nro_orden_trabajo ";
	$sqlAux.=" from gastos_gral gg ";
	$sqlAux.=" left join proveedores p on(gg.cod_proveedor=p.cod_proveedor)";
	$sqlAux.=" left join tipo_documento tp on(gg.cod_tipo_doc=tp.cod_tipo_doc)";
	$sqlAux.=" left join estados_gastos_gral egg on(gg.cod_estado=egg.cod_estado)";
	$sqlAux.=" left join gestiones g on(gg.cod_gestion=g.cod_gestion)";
	$sqlAux.=" left join gastos ga on(gg.cod_gasto=ga.cod_gasto)";
	$sqlAux.=" left join estado_pago_documento epd on(gg.cod_estado_pago_doc=epd.cod_estado_pago_doc)";
	$sqlAux.=" left join hojas_rutas hr  on( gg.cod_tipo_doc=1 and gg.codigo_doc=hr.cod_hoja_ruta)";
	$sqlAux.=" left join ordentrabajo ot  on( gg.cod_tipo_doc=2 and gg.codigo_doc=ot.cod_orden_trabajo)";
	$sqlAux.=" where  gg.cod_gasto_gral<>0 and gg.cod_estado<>2 ";
	$sqlAux.=" and  gg.cod_tipo_doc=2 ";
	$sqlAux.=" and  gg.codigo_doc=".$_GET['cod_orden_trabajo'];
	$respAux = mysql_query($sqlAux);
	while($datAux=mysql_fetch_array($respAux)){		
			$cod_gasto_gral=$datAux['cod_gasto_gral']; 
			$cod_gestion=$datAux['cod_gestion']; 
			$gestion=$datAux['gestion']; 
			$nro_gasto_gral=$datAux['nro_gasto_gral']; 
			$codigo_doc=$datAux['codigo_doc']; 
			$cod_tipo_doc=$datAux['cod_tipo_doc']; 
			$desc_tipo_doc=$datAux['desc_tipo_doc']; 
			$abrev_tipo_doc=$datAux['abrev_tipo_doc']; 
			$cod_proveedor_gasto_gral=$datAux['cod_proveedor']; 
			$nombre_proveedor_gasto_gral=$datAux['nombre_proveedor'];  
			$fecha_gasto_gral=$datAux['fecha_gasto_gral']; 
			$nro_recibo=$datAux['nro_recibo']; 
			$monto_gasto_gral=$datAux['monto_gasto_gral']; 
			$cant_gasto_gral=$datAux['cant_gasto_gral']; 
			$desc_gasto_gral=$datAux['desc_gasto_gral']; 
			$cod_gasto2=$datAux['cod_gasto']; 
			$desc_gasto2=$datAux['desc_gasto'];
			$cod_estado_pago_doc=$datAux['cod_estado_pago_doc'];
			$desc_estado_pago_doc=$datAux['desc_estado_pago_doc'];
			$fecha_registro=$datAux['fecha_registro']; 
			$cod_usuario_registro=$datAux['cod_usuario_registro']; 
			$fecha_modifica=$datAux['fecha_modifica']; 
			$cod_usuario_modifica=$datAux['cod_usuario_modifica']; 
			$cod_estado=$datAux['cod_estado'];  
			$desc_estado=$datAux['desc_estado'];
			
				$pdf->SetFont('Arial','',6);
				$pdf->SetX(12);
				$pdf->Cell(13,4,strftime("%d/%m/%Y",strtotime($fecha_gasto_gral)),1,0,'L',false);
				$pdf->SetX(25);
				$pdf->Cell(15,4,$nro_recibo,1,0,'L',false);
				$pdf->SetX(40);
				$pdf->SetFont('Arial','',4);
				$pdf->Cell(45,4,$nombre_proveedor_gasto_gral,1,0,'L',false);
				
		 		$pdf->SetX(85);
				$pdf->Cell(25,4,$desc_gasto2,1,0,'L',false);
				$pdf->SetX(110);	
				$pdf->Cell(67,4,$desc_gasto_gral,1,0,'L',false);
				$pdf->SetX(177);
				$pdf->SetFont('Arial','',6);
				$pdf->Cell(15,4,number_format($cant_gasto_gral,2),1,0,'R',false);	
				$pdf->SetX(192);
				$pdf->Cell(15,4,number_format($monto_gasto_gral,2)." Bs",1,1,'R',false);	
				$costosExternos=$costosExternos+$monto_gasto_gral;				
		
		}



	$pdf->SetFont('Arial','B',6);	
	$pdf->SetX(12);
	$pdf->Cell(180,4,"COSTOS EXTERNOS",1,0,'R',false);	
	$pdf->SetX(192);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(15,4,number_format($costosExternos,2)." Bs",1,1,'R',false);			
 	$pdf->ln();
	$pdf->SetFont('Arial','B',6);	
	$pdf->SetX(12);
	$pdf->Cell(180,4,"TOTAL GASTOS",0,0,'R',false);	
	$pdf->SetX(192);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(15,4,number_format(($costoTotalSalidas+$gastosExtras+$costosExternos),2)." Bs",1,1,'R',false);
	
 	$ingreso_esperado=$monto_real_ot-($costoTotalSalidas+$gastosExtras+$costosExternos);
	$ingreso_en_contra=$acuenta_ordentrabajo-$ingreso_esperado;
	$ingreso_a_favor=$ingreso_esperado+$ingreso_en_contra;
	
 	$pdf->ln();
 	$pdf->SetFont('Arial','B',6);	
	$pdf->SetX(12);
	$pdf->Cell(180,4,"INGRESO ESPERADO",0,0,'R',false);	
	$pdf->SetX(192);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(15,4,number_format($ingreso_esperado,2)." Bs",1,1,'R',false);
 	$pdf->ln();
 	/*$pdf->SetFont('Arial','B',6);	
	$pdf->SetX(12);
	$pdf->Cell(180,4,"INGRESO A FAVOR ",0,0,'R',false);	
	$pdf->SetX(192);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(15,4,number_format($ingreso_a_favor,2)." Bs",1,1,'R',false);
 	$pdf->ln();
 	$pdf->SetFont('Arial','B',6);	
	$pdf->SetX(12);
	$pdf->Cell(180,4,"INGRESO EN CONTRA  ",0,0,'R',false);	
	$pdf->SetX(192);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(15,4,number_format($ingreso_en_contra,2)." Bs",1,1,'R',false);	
	*/	
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(216,5,"Fecha Revision:".date('d/m/Y', time()),0,0,'C',false); 
 
	$pdf->Output();


require("cerrar_conexion.inc");
?>


