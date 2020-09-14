<?php
require("conexion1.inc");
require("fpdf.php");

include("funcionesNumerosALetras.php");

function llevarAFormatoFechaSqlMarco($fecha1)

{         

                $vector=explode("/",$fecha1);

                $fecha=$vector[2]."-".$vector[1]."-".$vector[0];

                return($fecha);

}



class PDF extends FPDF
{


//Cabecera de página
	function Header()
	{	
	//$this->Image('cotizacion.jpg',0,0,214);	
		
		$cod_tipo_cbte=$_POST['cod_tipo_cbte'];
		$fecha_inicio=$_POST['fecha_inicio'];
		$fecha_final=$_POST['fecha_final'];
/**********************DATOS DE CABECERA*********************/

	
		$sql5="select  valor_x, valor_y from coordenadas_impresion where cod_coordenada=1";
		$resp5=mysql_query($sql5);
		while ($dat5=mysql_fetch_array($resp5)){
			$valorX=$dat5[0];
			$valorY=$dat5[1];
		}


	/*$sql=" select co.cod_gestion,co.cod_tipo_cbte,tco.nombre_tipo_cbte, co.nro_cbte, ";
	$sql.=" co.cod_moneda, co.cod_estado_cbte,co.fecha_cbte,co.glosa, co.cod_usuario_registro,";
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
*/
		/**********************Fin Datos de Cliente******************************/	
			$this->SetFont('Arial','B',14);
			//$this->Text(20,10,"PIXEL");
			$this->SetTextColor(0,0,0);	
			$this->Text(90,18,"LIBRO DIARIO ");
			$this->SetFont('Arial','',9);
			$this->Text(84,24,"Del ".$_POST['fecha_inicio']." al ".$_POST['fecha_final']);
			if($_POST['cod_tipo_cbte']<>0){
					$sql5="select nombre_tipo_cbte from tipo_comprobante where cod_tipo_cbte=".$_POST['cod_tipo_cbte'];
					$resp5=mysql_query($sql5);
					while ($dat5=mysql_fetch_array($resp5)){
						$nombre_tipo_cbte=$dat5['nombre_tipo_cbte'];
					}
				$this->Text(82,29,"Tipo de Comprobante:".$nombre_tipo_cbte);
				$this->Text(82,34,"Expresado en Moneda Nacional");
			}else{
				$this->Text(82,29,"Expresado en Moneda Nacional");			
			}
			$this->SetFont('Arial','B',10);

			$this->SetXY(170,20);
    	    $this->Cell(0,4,'Página '.$this->PageNo().' de '.' {nb}',0,1,'L',false);
			$this->SetXY(170,25);
			$this->Cell(0,4,date('d/m/Y H:i:s', time()),0,1,'L',false);	

			
			
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','B',9);
			$this->SetXY(10,35);
			$this->Cell(12,5,"Cuenta",'TB',0,'C',false);
			$this->Cell(75,5,"Nombre Cuenta",'TB',0,'C',false);
			$this->Cell(45,5,"Glosa",'TB',0,'C',false);
			$this->Cell(35,5,"Respaldo",'TB',0,'C',false);
			$this->Cell(15,5,"Debe",'TB',0,'C',false);
			$this->Cell(15,5,"Haber",'TB',0,'C',false);

			
			$this->SetY(42);
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
	$cod_cotizacion=$_GET['cod_cotizacion'];
	//Creación del objeto de la clase heredada
	//$pdf=new PDF('P','mm','A4');
	$pdf=new PDF('P','mm',array(214,279));
	$pdf->SetAutoPageBreak(true,20-$valorY);
	
	$cod_tipo_cbte=$_POST['cod_tipo_cbte'];
	$fecha_inicio=$_POST['fecha_inicio'];
	$fecha_final=$_POST['fecha_final'];
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$sql=" select cod_tipo_cbte,nombre_tipo_cbte,orden ";
	$sql.=" from tipo_comprobante ";
	if($_POST['cod_tipo_cbte']<>0){
		$sql.=" where cod_tipo_cbte=".$_POST['cod_tipo_cbte'];
	}
	$sql.=" order by orden asc";
	
	$resp=mysql_query($sql);
	while ($dat=mysql_fetch_array($resp)){
			$cod_tipo_cbte=$dat['cod_tipo_cbte'];
			$nombre_tipo_cbte=$dat['nombre_tipo_cbte'];
			$orden=$dat['orden'];
		$sql2=" select cod_cbte,cod_empresa,cod_gestion,nro_cbte,cod_moneda,";
		$sql2.=" cod_estado_cbte,fecha_cbte,nro_cheque,nro_factura,banco,nombre,glosa,cod_usuario_registro,fecha_registro,";
		$sql2.=" cod_usuario_modifica,fecha_modifica";
		$sql2.=" from comprobante";
		$sql2.=" where fecha_cbte>='".llevarAFormatoFechaSqlMarco($_POST['fecha_inicio'])."' and fecha_cbte<='".llevarAFormatoFechaSqlMarco($_POST['fecha_final'])."'";
		$sql2.=" and cod_tipo_cbte=".$cod_tipo_cbte;
		$sql2.=" order by nro_cbte asc";
		$resp2=mysql_query($sql2);
		$sumaDebe=0;
		$sumaHaber=0;
		$nombre="";
		while ($dat2=mysql_fetch_array($resp2)){
			$cod_cbte=$dat2['cod_cbte'];
			$cod_empresa=$dat2['cod_empresa'];
			$cod_gestion=$dat2['cod_gestion'];
			$nro_cbte=$dat2['nro_cbte'];
			$cod_moneda=$dat2['cod_moneda'];
			$cod_estado_cbte=$dat2['cod_estado_cbte'];
			$fecha_cbte=$dat2['fecha_cbte'];
			$nro_cheque=$dat2['nro_cheque'];
			$nro_factura=$dat2['nro_factura'];
			$banco=$dat2['banco'];
			$nombre=$dat2['nombre'];
			$glosa=$dat2['glosa'];
			$cod_usuario_registro=$dat2['cod_usuario_registro'];
			$fecha_registro=$dat2['fecha_registro'];
			$cod_usuario_modifica=$dat2['cod_usuario_modifica'];
			$fecha_modifica=$dat2['fecha_modifica'];
			
			$sql3="select nombre_estado_cbte from estado_comprobante where cod_estado_cbte=".$cod_estado_cbte;
			$resp3=mysql_query($sql3);
			while ($dat3=mysql_fetch_array($resp3)){
				$nombre_estado_cbte=$dat3['nombre_estado_cbte'];
			}
			$sql7="select count(*) from pagos where cod_cbte=".$cod_cbte;
			$resp7=mysql_query($sql7);
			$nro_pago=0;
			while ($dat7=mysql_fetch_array($resp7)){
				$nro_pago=$dat7[0];							
			}
			$nombre_cliente="";
			if($nro_pago>0){
				$sql7=" select pagos.cod_pago, pagos.nro_pago,pagos.fecha_pago,pagos.cod_cliente, clientes.nombre_cliente";
				$sql7.=" from pagos inner join clientes on(pagos.cod_cliente=clientes.cod_cliente)";
				$sql7.=" where cod_cbte=".$cod_cbte;
				$resp7=mysql_query($sql7);
				while ($dat7=mysql_fetch_array($resp7)){
					$cod_pago=$dat7['cod_pago'];
					$nro_pago=$dat7['nro_pago'];
					$fecha_pago=$dat7['fecha_pago'];
					$cod_cliente=$dat7['cod_cliente'];
					$nombre_cliente=$dat7['nombre_cliente'];			
				}
			}
			$pdf->SetX(10);
			$pdf->SetFont('Arial','B',8);
			$pdf->SetX(150);
			if($nro_pago>0){
			 $pdf->Cell(25,4,"Pago # ".$nro_pago."/".strftime("%Y",strtotime($fecha_pago)),0,0,'L',false);
			 }else{
			 $pdf->Cell(25,4,"",0,0,'L',false);
			 }
			$pdf->SetX(10);
			$pdf->MultiCell(140,4,"Cbte Nro.".$nro_cbte." de ".$nombre_tipo_cbte." de ".$nombre_cliente.$nombre." del ".strftime("%d/%m/%Y",strtotime($fecha_cbte))." (".$nombre_estado_cbte.") de ".$nombre." ".$glosa,0,'J',false);


			$sql3=" select cod_cbte_detalle,cod_cuenta,nro_factura,fecha_factura,dias_venc_factura,";
			$sql3.=" glosa,debe,haber,debe_sus,haber_sus ";
			$sql3.=" from comprobante_detalle";
			$sql3.=" where cod_cbte=".$cod_cbte;
			$sql3.=" order by cod_cbte_detalle asc";
			$resp3=mysql_query($sql3);
			while ($dat3=mysql_fetch_array($resp3)){
				 $cod_cbte_detalle=$dat3['cod_cbte_detalle'];
				 $cod_cuenta=$dat3['cod_cuenta'];
				 
				 $sql4="select nro_cuenta,desc_cuenta from cuentas where cod_cuenta=".$cod_cuenta;
				 $resp4=mysql_query($sql4);
				 while($dat4=mysql_fetch_array($resp4)){
				 	$nro_cuenta=$dat4['nro_cuenta'];
					$desc_cuenta=$dat4['desc_cuenta'];
				 }
				 $nro_factura=$dat3['nro_factura'];
				 $fecha_factura=$dat3['fecha_factura'];
				 $dias_venc_factura=$dat3['dias_venc_factura'];
				 $glosaD=$dat3['glosa'];
				 $debe=$dat3['debe'];
				 $haber=$dat3['haber'];
				 $debe_sus=$dat3['debe_sus'];
				 $haber_sus=$dat3['haber_sus'];
				 if($cod_estado_cbte<>2){
				 $sumaDebe=$sumaDebe+$debe;
				 $sumaHaber=$sumaHaber+$haber;
			 }
			 /*Detalle de Pago*/
	
			/*Fin de Pago*/	 
				 		/*	$this->Cell(12,5,"Cuenta",'TB',0,'C',false);
			$this->Cell(75,5,"Nombre Cuenta",'TB',0,'C',false);
			$this->Cell(45,5,"Glosa",'TB',0,'C',false);
			$this->Cell(35,5,"Respaldo",'TB',0,'C',false);
			$this->Cell(15,5,"Debe",'TB',0,'C',false);
			$this->Cell(15,5,"Haber",'TB',0,'C',false);*/
			
				 $pdf->SetFont('Arial','',8);
				 $pdf->SetX(10);
				
		  		 $pdf->Cell(12,4,$nro_cuenta,0,0,'L',false);
				 //$pdf->SetX(22);
				 $pdf->Cell(75,4,$desc_cuenta,0,0,'L',false);
				// $pdf->SetX(75);
			   //  $pdf->Cell(40,5,$glosaD,0,0,'L',false);
				 $pdf->SetX(157);
			     $pdf->Cell(35,4,"",0,0,'C',false);
				 $pdf->SetX(177);
			     $pdf->Cell(15,4,number_format($debe, 2, ",", "."),0,0,'R',false);
				 $pdf->SetX(192);
			     $pdf->Cell(15,4,number_format($haber, 2, ",", "."),0,0,'R',false);
				 $pdf->SetX(97);
				 $pdf->MultiCell(60,4,$glosaD,0,'J',false);
				
			
			}
			 $pdf->Cell(0,1,"",0,1,'L',false);
			$pdf->Line(10,$pdf->GetY(),205,$pdf->GetY());
			$pdf->Cell(0,1,"",0,1,'L',false);
		}
				$pdf->SetFont('Arial','B',10);
				$pdf->SetX(160);
				 $pdf->Cell(15,4,"TOTAL ".$nombre_tipo_cbte,0,0,'R',false);
				// $pdf->SetX(175);
			    // $pdf->Cell(15,4,number_format($sumaDebe, 2, ",", "."),0,0,'R',false);
				 $pdf->SetX(190);
			     $pdf->Cell(15,4,number_format($sumaHaber, 2, ",", "."),0,1,'R',false);
	}
	


	
	
	

 
$pdf->Output();


require("cerrar_conexion.inc");
?>


