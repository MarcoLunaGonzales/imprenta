<?php
require("conexion1.inc");
require("fpdf.php");

include("funcionesNumerosALetras.php");


class PDF extends FPDF
{


//Cabecera de página
	function Header()
	{	
	$this->Image('sediscomlogotipo.jpg',15,15,0);	
	//$this->Image('cotizacion2.jpg',15,15,185.17,250);	
		
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
			$sql2="select gestion_nombre from gestiones where cod_gestion='".$cod_gestion."'";
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

			$this->SetFont('Arial','B',10);
			$this->SetTextColor(0,0,0);	
			$this->SetFont('Arial','B',9);
			$this->SetXY(160,16);
    	    $this->Cell(0,4,'Página '.$this->PageNo().' de '.' {nb}',0,1,'R',false);
						
			$this->SetFont('Arial','B',14);
			$this->SetTextColor(0,0,0);
			$this->Text(85,18,"ORDEN DE TRABAJO");
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

			
			$this->SetFont('Arial','',10);
			$this->SetXY(12,64);
			$this->SetFont('Arial','B',10);
			$this->Cell(193,6,"DESCRIPCION DE TRABAJO",1,0,'C');	
			$this->SetX(170);
			//$this->Cell(35,6,"IMPORTE",1,1,'C');

			$this->SetY(60);
			$this->Rect(12, 70, 193, 135);
			//$this->Line(170, 70, 170, 200);
			$this->SetY(75);
		/************************FIN DATOS DE CABECERA*************************************/

			
	}

	//Pie de página
	function Footer()		
	{	
	
	global $sw;
	/////////////////////////////////////ORDEN DE TRABAJO///////////////	
		$sql=" select cod_est_ot, obs_orden_trabajo, monto_orden_trabajo, incremento_orden_trabajo,  ";
		$sql.=" incremento_fecha, incremento_obs,cod_usuario_incremento,  descuento_orden_trabajo, ";
		$sql.=" descuento_fecha,descuento_obs, cod_usuario_descuento";
		$sql.=" from ordentrabajo";
		$sql.=" where  cod_orden_trabajo=".$_GET['cod_orden_trabajo'];
	
		$resp=mysql_query($sql);
		$incremento_orden_trabajo=0;
		$descuento_orden_trabajo=0;
		while ($dat=mysql_fetch_array($resp)){
		
			$cod_est_ot=$dat['cod_est_ot']; 
			$monto_orden_trabajo=$dat['monto_orden_trabajo']; 
		    $incremento_orden_trabajo=$dat['incremento_orden_trabajo']; 
			$incremento_fecha=$dat['incremento_fecha']; 
			$incremento_obs=$dat['incremento_obs']; 
			$cod_usuario_incremento=$dat['cod_usuario_incremento']; 
			$descuento_orden_trabajo=$dat['descuento_orden_trabajo']; 
			$descuento_fecha=$dat['descuento_fecha']; 
			$descuento_obs=$dat['descuento_obs']; 
			$cod_usuario_descuento=$dat['cod_usuario_descuento']; 
		}
	    ////////////////////////FIN DATOS GENERALES ORDEN TRABAJO///////////////////////////	
		if($incremento_orden_trabajo==""){
			$incremento_orden_trabajo=0;
		}
		if($descuento_orden_trabajo==""){
			$descuento_orden_trabajo=0;
		}		
		
			//$this->Rect(12, 200, 193, 25);
			if($sw==1){
			$this->SetY(205);
			$this->SetX(155);
			$this->SetFont('Arial','B',10);	
			//$this->Cell(15,6,"TOTAL:",0,0,'R',false);
			
			$this->SetY(205);
			$this->SetX(170);
			$this->SetFont('Arial','B',10);	
			$numero_formato=number_format((($monto_orden_trabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo),2);					
			//$this->Cell(25,6,$numero_formato,0,1,'R',false);
			$suma_literal=convertir(($monto_orden_trabajo+$incremento_orden_trabajo)-$descuento_orden_trabajo);
			$longitud=strlen($suma_literal);
			$x=146-$longitud;
			for($i=1;$i<=$x/1.45;$i++){
				$suma_literal=$suma_literal."-";
			}
			$this->SetY(218);
			$this->SetX(12);
			//$this->Cell(146,6,"Son: ".$suma_literal." 00/100 Bolivianos.",0,1,'L',false);
			

			}
			$this->SetFont('Arial','I',10);	
			$this->setXY(7,240);
			$cadena="Calle Jose Maria de Velasco, Nro. 1711. Zona San Pedro - Telf. 22914746 - Cel. 70637643";		
			$this->MultiCell(204,5,$cadena,0,'C',false);
			
			$this->SetFont('Arial','I',10);	
			$this->setXY(7,246);
			$cadena="E-mail:jenisse.impresiones@gmail.com - La Paz-Bolivia";		
			$this->MultiCell(204,5,$cadena,0,'C',false)	;			
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
	$pdf->SetAutoPageBreak(true,75);

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


		
				
		$pdf->SetFont('Arial','',10);
		$variableY=$pdf->GetY();
		$pdf->setXY(170,$variableY);
		//$pdf->Cell(25,6,number_format($monto_orden_trabajo,2),0,1,'R');

	
		$pdf->setXY(14,$variableY);
		
		$pdf->MultiCell(190,5,$detalle_orden_trabajo,0, 'L',false);
		$pdf->Ln();
		$variableY=$pdf->GetY();		
		/*if($incremento_orden_trabajo<>"" and $incremento_orden_trabajo>0){
			$pdf->SetFont('Arial','B',10);
			$pdf->setXY(170,$variableY);
			$pdf->Cell(25,6,number_format($incremento_orden_trabajo,2),0,1,'R');		
			$pdf->setXY(14,$variableY);
			$pdf->MultiCell(155,5,"INCREMENTO:".$incremento_obs,0,'L',false);
			
		}		
		$pdf->Ln();
		$variableY=$pdf->GetY();		
		if($descuento_orden_trabajo<>"" and $descuento_orden_trabajo>0){
			$pdf->SetFont('Arial','B',10);
			$pdf->setXY(170,$variableY);
			$pdf->Cell(25,6,number_format($descuento_orden_trabajo,2),0,1,'R');		
			$pdf->setXY(14,$variableY);
			$pdf->MultiCell(155,5,"DESCUENTO:".$descuento_obs,0, 'L',false);
			
		}	*/
		$pdf->Ln();
		$variableY=$pdf->GetY();		
		if($obs_orden_trabajo<>""){
			$pdf->SetFont('Arial','B',10);
			$pdf->setXY(170,$variableY);
			$pdf->Cell(0,6,"",0,1,'R');		
			$pdf->setXY(14,$variableY);
			$pdf->MultiCell(155,5,"NOTA:".$obs_orden_trabajo,0, 'L',false);
			
		}			
		$sw=1;
 
	$pdf->Output();


require("cerrar_conexion.inc");
?>


