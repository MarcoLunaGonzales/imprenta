<?php
require("conexion1.inc");
require("fpdf.php");

include("funcionesNumerosALetras.php");


class PDF extends FPDF
{


//Cabecera de página
	function Header()
	{	
	//$this->Image('cotizacion.jpg',0,0,214);	
		
		$cod_cotizacion=$_GET['cod_cotizacion'];
/**********************DATOS DE CABECERA*********************/

	
		$sql5="select  valor_x, valor_y from coordenadas_impresion where cod_coordenada=1";
		$resp5=mysql_query($sql5);
		while ($dat5=mysql_fetch_array($resp5)){
			$valorX=$dat5[0];
			$valorY=$dat5[1];
		}


	$sql=" select co.cod_gestion,co.cod_tipo_cbte,tco.nombre_tipo_cbte, co.nro_cbte, ";
	$sql.=" co.cod_moneda, co.cod_estado_cbte,co.fecha_cbte,co.nro_cheque,co.nro_factura,co.banco,co.nombre,co.glosa, co.cod_usuario_registro,";
	$sql.=" co.fecha_registro,co.cod_usuario_modifica,co.fecha_modifica";
	$sql.=" from comprobante co inner join tipo_comprobante tco on(co.cod_tipo_cbte=tco.cod_tipo_cbte)";
	$sql.=" where cod_cbte='".$_GET['cod_cbte']."'";
	$resp=mysql_query($sql);
	while ($dat=mysql_fetch_array($resp)){

		$cod_gestion=$dat['cod_gestion'];
		$cod_tipo_cbte=$dat['cod_tipo_cbte'];
		$nombre_tipo_cbte=$dat['nombre_tipo_cbte'];
		$nro_cbte=$dat['nro_cbte'];
		$cod_moneda=$dat['cod_moneda'];
		$cod_estado_cbte=$dat['cod_estado_cbte'];
		$fecha_cbte=$dat['fecha_cbte'];
		$nro_cheque=$dat['nro_cheque'];
		$nro_factura=$dat['nro_factura'];
		$banco=$dat['banco'];
		$nombre=$dat['nombre'];
		$glosa=$dat['glosa'];
		$cod_usuario_registro=$dat['cod_usuario_registro'];
		$fecha_registro=$dat['fecha_registro'];
		$cod_usuario_modifica=$dat['cod_usuario_modifica'];
		$fecha_modifica=$dat['fecha_modifica'];
	}	

		//Aqui se obtiene el Pago que genero Automaticamente el Comprobate		
			$sql2="select count(*) from pagos where cod_cbte=".$_GET['cod_cbte'];
			$resp2=mysql_query($sql2);
			$nro_pago=0;
			while ($dat2=mysql_fetch_array($resp2)){
				$nro_pago=$dat2[0];							
			}
			if($nro_pago>0){
				$sql2=" select pagos.nro_pago,pagos.fecha_pago,pagos.cod_cliente, clientes.nombre_cliente";
				$sql2.=" from pagos inner join clientes on(pagos.cod_cliente=clientes.cod_cliente)";
				$sql2.=" where cod_cbte=".$_GET['cod_cbte'];
				$resp2=mysql_query($sql2);
				while ($dat2=mysql_fetch_array($resp2)){
					$nro_pago=$dat2['nro_pago'];
					$fecha_pago=$dat2['fecha_pago'];
					$cod_cliente=$dat2['cod_cliente'];
					$nombre_cliente=$dat2['nombre_cliente'];			
				}
			}

		/**********************Fin Datos de Cliente******************************/	
			$this->SetFont('Arial','B',18);
			$this->SetTextColor(0,0,0);	
			$this->Text(60,40,"COMPROBANTE DE ".$nombre_tipo_cbte);
	
			$this->SetFont('Arial','B',10);
			$this->Text($valorX+164,$valorY+42,"No. ".$nro_cbte);
			$this->SetXY(164,45);
			$this->SetFont('Arial','B',6);
			$this->Cell(12,3,strftime("Dia",strtotime($fecha_cbte)),1,0,'C',false);
			$this->Cell(12,3,strftime("Mes",strtotime($fecha_cbte)),1,0,'C',false);
			$this->Cell(12,3,strftime("Anio",strtotime($fecha_cbte)),1,1,'C',false);
			$this->SetXY(164,48);
			$this->SetFont('Arial','B',10);
			$this->Cell(12,5,strftime("%d",strtotime($fecha_cbte)),1,0,'C',false);
			$this->Cell(12,5,strftime("%m",strtotime($fecha_cbte)),1,0,'C',false);
			$this->Cell(12,5,strftime("%Y",strtotime($fecha_cbte)),1,1,'C',false);
		
			
			$this->SetFont('Arial','B',10);
			$this->SetTextColor(0,0,0);
			$this->Text($valorX+20,$valorY+47,"DE:");
			//if($cod_tipo_cbte==3){			
			$this->Text($valorX+35,$valorY+47,$nombre_cliente.$nombre);
			//}
			$this->Text($valorX+20,$valorY+54,"POR CONCEPTO DE:");
			$this->SetXY(58,51);
			$this->MultiCell(104,4,$glosa,0,'L',false);
			$this->SetXY($valorX+167,$valorY+55);
    	    $this->Cell(0,4,'Página '.$this->PageNo().' de '.' {nb}',0,1,'R',false);	
			
			if($nro_pago>0){
				$this->SetXY($valorX+160,$valorY+60);
	    	    $this->Cell(40,4,"Pago:".$nro_pago."/".strftime("%Y",strtotime($fecha_pago)),0,1,'R',false);						
			}
			if($banco!="" || $nro_cheque!="" || $nro_factura!="" ){						
				$this->SetXY($valorX+20,$valorY+64);	    	
				$this->Cell(15,4,"Banco:",0,0,'L',false);
				$this->Cell(70,4,$banco,0,0,'L',false);
				$this->Cell(22,4,"Nro Cheque:",0,0,'L',false);
				$this->Cell(30,4,$nro_cheque,0,0,'L',false);
				$this->Cell(22,4,"Nro Factura:",0,0,'L',false);	
				$this->Cell(30,4,$nro_factura,0,1,'L',false);
			}
			$this->SetFont('Arial','B',9);
			$this->setXY(110,71);
			$this->Cell(45,5,"BOLIVIANOS",1,0,'C',false);
			$this->setXY(155,71);
			$this->Cell(45,5,"DOLARES AMERICANOS",1,1,'C',false);
			$this->setXY(18,76);		
			$this->Cell(22,5,"Cuenta",1,0,'C',false);
			$this->Cell(70,5,"Nombre de Cuenta",1,0,'C',false);
			$this->Cell(22,5,"Debe",1,0,'C',false);
			$this->Cell(23,5,"Haber",1,0,'C',false);
			$this->Cell(22,5,"Debe",1,0,'C',false);
			$this->Cell(23,5,"Haber",1,1,'C',false);			
			
			
			$this->Line(18,78,18,249);
			$this->Line(40,78,40,249);
			$this->Line(110,78,110,249);
			$this->Line(132,78,132,249);
			$this->Line(155,78,155,249);
			$this->Line(177,78,177,249);
			$this->Line(200,78,200,249);
			$this->Line(18,249,200,249);
		
			
			$this->SetY(84);
		/************************FIN DATOS DE CABECERA*************************************/

			
	}

	//Pie de página
	function Footer()
	{	
			

	
		$sql5="select  valor_x, valor_y from coordenadas_impresion where cod_coordenada=1";
		$resp5=mysql_query($sql5);
		while ($dat5=mysql_fetch_array($resp5)){
			$valorX=$dat5[0];
			$valorY=$dat5[1];
		}
		$sql=" select fecha_cbte, cod_usuario_registro,";
		$sql.=" fecha_registro,cod_usuario_modifica,fecha_modifica";
		$sql.=" from comprobante ";
		$sql.=" where cod_cbte='".$_GET['cod_cbte']."'";
		
		$resp=mysql_query($sql);
		while ($dat=mysql_fetch_array($resp)){
			$fecha_cbte=$dat['fecha_cbte'];
			$cod_usuario_registro=$dat['cod_usuario_registro'];
			$fecha_registro=$dat['fecha_registro'];
			$cod_usuario_modifica=$dat['cod_usuario_modifica'];
			$fecha_modifica=$dat['fecha_modifica'];
		}
		
		$sql3="select cambio_bs from tipo_cambio";
		$sql3.=" where fecha_tipo_cambio='".$fecha_cbte."'";
		$sql3.=" and cod_moneda=2";
		$resp3 = mysql_query($sql3);
		$cambio_bs=0;
		while($dat3=mysql_fetch_array($resp3)){
			$cambio_bs=$dat3['cambio_bs'];
		}

		
		global $sw;
		$sql5="select sum(debe), sum(haber),sum(debe_sus),sum(haber_sus)";
		$sql5.=" from comprobante_detalle";
		$sql5.=" where cod_cbte=".$_GET['cod_cbte'];
		$resp5=mysql_query($sql5);
		while ($dat5=mysql_fetch_array($resp5)){
			$sum_debe=$dat5[0];
			$sum_haber=$dat5[1];
			$sum_debe_sus=$dat5[2];
			$sum_haber_sus=$dat5[3];
		}		
	

		if($sw==1 ){
			$this->SetY($valorY+249);
			$this->SetX($valorX+170);
			$this->SetFont('Arial','B',9);	
			
			$this->Cell(20,6,$numero_formato,0,1,'R',false);
			$suma_literal=convertir($sum_haber);
			$longitud=strlen($suma_literal);
			$x=146-$longitud;
			for($i=1;$i<=$x/1.6;$i++){
				$suma_literal=$suma_literal."-";
			}
			$this->SetXY(18,249);
			$this->Line(18,254,200,254);
			$this->Cell(32,5,"T.C. $us ".number_format($cambio_bs, 2, ",", "."),"L",0,'L',false);
			$this->Cell(60,5,"Total Comprobante",0,0,'R',false);
			$this->Cell(22,5,number_format($sum_debe, 2, ",", "."),1,0,'R',false);
			$this->Cell(23,5,number_format($sum_haber, 2, ",", "."),1,0,'R',false);
			$this->Cell(22,5,number_format($sum_debe_sus, 2, ",", "."),1,0,'R',false);
			$this->Cell(23,5,number_format($sum_haber_sus, 2, ",", "."),1,1,'R',false);	
			
			$this->SetY($valorY+254);
			$this->SetX($valorX+18);

			$this->Cell(182,5,"Son:".$suma_literal."00/100 Bolivianos.",1,1,'L',false);
		}
		
		
		
		
		
		
	

	
	/***************************DATOS DE CABECERA********************************/

		
		$sql=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario,cod_grado from usuarios ";
		$sql.=" where  cod_usuario='".$cod_usuario_registro."'";
		$resp=mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){
			$nombres_usuario=$dat[0];
			$ap_paterno_usuario=$dat[1]; 
			$ap_materno_usuario=$dat[2];
			$cod_grado=$dat[3];

			
		}
		$this->SetXY(18,264);

		$this->Cell(92,5,"CONTABILIDAD",1,0,'C',false);
		$this->Cell(91,5,"CLIENTE",1,1,'C',false);
		$this->SetX(18);
		$this->SetXY(18,269);
		$this->SetFont('Arial','',9);		
		$this->Cell(92,15,$nombres_usuario." ".$ap_paterno_usuario." ".$ap_materno_usuario,1,0,'C',false);
		$this->Cell(91,15,"",1,1,'C',false);
		$this->SetXY(18,272);
		$this->SetFont('Arial','',9);
		
		$this->Cell(92,4,"..................................",0,0,'C',false);
		$this->Cell(91,4,"",0,1,'C',false);
		
			
			}

	
}
	$sql5="select  valor_x, valor_y from coordenadas_impresion where cod_coordenada=1";
	$resp5=mysql_query($sql5);
	while ($dat5=mysql_fetch_array($resp5)){
			$valorX=$dat5[0];
			$valorY=$dat5[1];
	}
	$cod_cotizacion=$_GET['cod_cotizacion'];
	//Creación del objeto de la clase heredada
	//$pdf=new PDF('P','mm','A4');
	$pdf=new PDF('P','mm',array(214,300));
	$pdf->SetAutoPageBreak(true,55-$valorY);
	
	
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$y=79;
	/********************datos extras de cotizacion***************/	
		$sql=" select cd.cod_cuenta,c.nro_cuenta,c.desc_cuenta,cd.glosa,cd.debe,cd.haber,cd.debe_sus,cd.haber_sus ";
		$sql.=" from comprobante_detalle cd inner join cuentas c on(cd.cod_cuenta=c.cod_cuenta)";
		$sql.=" where cd.cod_cbte=".$_GET['cod_cbte'];
		$sql.=" order by cd.cod_cbte_detalle asc";
		$resp=mysql_query($sql);
		while ($dat=mysql_fetch_array($resp)){
			$cod_cuenta=$dat['cod_cuenta'];
			$nro_cuenta=$dat['nro_cuenta'];
			$desc_cuenta=$dat['desc_cuenta'];
			$glosa=$dat['glosa'];
			$debe=$dat['debe'];
			$haber=$dat['haber'];
			$debe_sus=$dat['debe_sus'];
			$haber_sus=$dat['haber_sus'];
			$y=$y+5;
			$pdf->setXY(18,$y);		
			$pdf->Cell(22,5,$nro_cuenta,0,0,'L',false);
			$pdf->Cell(70,5,$desc_cuenta,0,0,'L',false);
			$pdf->Cell(22,5,number_format($debe, 2, ",", "."),0,0,'R',false);
			$pdf->Cell(23,5,number_format($haber, 2, ",", "."),0,0,'R',false);
			$pdf->Cell(22,5,number_format($debe_sus, 2, ",", "."),0,0,'R',false);
			$pdf->Cell(23,5,number_format($haber_sus, 2, ",", "."),0,1,'R',false);		
			$pdf->setX(40);		
			$pdf->MultiCell(70,5,$glosa,0,'L',false);					
			$y=$pdf->GetY();
		}
		$sw=1;
	/***********************************/
	
	
	

 
$pdf->Output();


require("cerrar_conexion.inc");
?>


