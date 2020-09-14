<?php
require("conexion1.inc");
require("fpdf.php");

include("funcionesNumerosALetras.php");

function llevarAFormatoFecha($fecha1)

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

			$sql=" select count(*) ";
			$sql.=" from comprobante_detalle cd inner JOIN comprobante c  on(cd.cod_cbte=c.cod_cbte) ";
			$sql.=" where cd.cod_cuenta=".$_POST['cod_cuenta0'];
			$sql.=" and  c.fecha_cbte<'".llevarAFormatoFecha($_POST['fecha_inicio'])."'";
			$sql.=" and c.cod_estado_cbte<>2";
			$resp=mysql_query($sql);
			$nroReg=0;
			while ($dat=mysql_fetch_array($resp)){
				$nroReg=$dat[0];
			}
			$saldo_inicial=0;
			if($nroReg>0){
				$sql=" select sum(debe) ";
				$sql.=" from comprobante_detalle cd inner JOIN comprobante c  on(cd.cod_cbte=c.cod_cbte) ";
				$sql.=" where cd.cod_cuenta=".$_POST['cod_cuenta0'];
				$sql.=" and  c.fecha_cbte<'".llevarAFormatoFecha($_POST['fecha_inicio'])."'";
				$sql.=" and c.cod_estado_cbte<>2";
				$resp=mysql_query($sql);
				$sumaDebe=0;
				while ($dat=mysql_fetch_array($resp)){
					$sumaDebe=$dat[0];
				}
				$sql=" select sum(haber) ";
				$sql.=" from comprobante_detalle cd inner JOIN comprobante c  on(cd.cod_cbte=c.cod_cbte) ";
				$sql.=" where cd.cod_cuenta=".$_POST['cod_cuenta0'];
				$sql.=" and  c.fecha_cbte<'".llevarAFormatoFecha($_POST['fecha_inicio'])."'";
				$sql.=" and c.cod_estado_cbte<>2";
				$resp=mysql_query($sql);
				$sumaHaber=0;
				while ($dat=mysql_fetch_array($resp)){
					$sumaHaber=$dat[0];
				}		
				$saldo_inicial=($sumaDebe-$sumaHaber);		
			}

			$this->SetFont('Arial','B',14);
			$this->Text(8,10,"INVENTA PUBLICIDAD E IMPRESOS");
			$this->SetTextColor(0,0,0);	
			$this->SetY(18);
			$this->Cell(0,4,"ESTADO DE CUENTA",0,1,'C',false);
			//$this->Text(90,18,"ESTADO DE CUENTA");
			$this->SetFont('Arial','',9);
			$this->SetY(23);
			$this->Cell(0,4,"Del ".$_POST['fecha_inicio']." al ".$_POST['fecha_final'],0,1,'C',false);
			//$this->Text(95,24,"Del ".$_POST['fecha_inicio']." al ".$_POST['fecha_final']);
			
					$sql5="select nro_cuenta,desc_cuenta from cuentas where cod_cuenta=".$_POST['cod_cuenta0'];
					$resp5=mysql_query($sql5);
					while ($dat5=mysql_fetch_array($resp5)){
						$nro_cuenta=$dat5['nro_cuenta'];
						$desc_cuenta=$dat5['desc_cuenta'];
					}
					$this->Cell(0,4,"Cuenta:".$nro_cuenta." ".$desc_cuenta,0,1,'C',false);
					$this->Cell(0,4,"Expresado en Moneda Nacional (Saldo Inicial: ".$saldo_inicial.")",0,1,'C',false);


			$this->SetFont('Arial','B',10);

			$this->SetXY(170,20);
    	    $this->Cell(0,4,'Página '.$this->PageNo().' de '.'{nb}',0,1,'L',false);
			$this->SetXY(170,25);
			$this->Cell(0,4,date('d/m/Y H:i:s', time()),0,1,'L',false);	

			
			
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','B',9);
			$this->SetXY(8,35);
			$this->Cell(12,5,"Fecha",'TB',0,'C',false);
			$this->Cell(20,5,"Nro Cbte.",'TB',0,'C',false);
			$this->Cell(45,5,"Beneficiario",'TB',0,'C',false);
			$this->Cell(35,5,"Glosa",'TB',0,'C',false);
			$this->Cell(10,5,"TC",'TB',0,'C',false);
			$this->Cell(15,5,"Equiv $us",'TB',0,'C',false);
			$this->Cell(20,5,"Cargos",'TB',0,'C',false);
			$this->Cell(20,5,"Abonos",'TB',0,'C',false);
			$this->Cell(20,5,"Saldo",'TB',1,'C',false);

			
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
	

	$pdf->AliasNbPages();
	$pdf->AddPage();
	
			$sql=" select count(*) ";
			$sql.=" from comprobante_detalle cd inner JOIN comprobante c  on(cd.cod_cbte=c.cod_cbte) ";
			$sql.=" where cd.cod_cuenta=".$_POST['cod_cuenta0'];
			$sql.=" and  c.fecha_cbte<'".llevarAFormatoFecha($_POST['fecha_inicio'])."'";
			$sql.=" and c.cod_estado_cbte<>2";
			$resp=mysql_query($sql);
			$nroReg=0;
			while ($dat=mysql_fetch_array($resp)){
				$nroReg=$dat[0];
			}
			$saldo_inicial=0;
			if($nroReg>0){
				$sql=" select sum(debe) ";
				$sql.=" from comprobante_detalle cd inner JOIN comprobante c  on(cd.cod_cbte=c.cod_cbte) ";
				$sql.=" where cd.cod_cuenta=".$_POST['cod_cuenta0'];
				$sql.=" and  c.fecha_cbte<'".llevarAFormatoFecha($_POST['fecha_inicio'])."'";
				$sql.=" and c.cod_estado_cbte<>2";
				$resp=mysql_query($sql);
				$sumaDebe=0;
				while ($dat=mysql_fetch_array($resp)){
					$sumaDebe=$dat[0];
				}
				$sql=" select sum(haber) ";
				$sql.=" from comprobante_detalle cd inner JOIN comprobante c  on(cd.cod_cbte=c.cod_cbte) ";
				$sql.=" where cd.cod_cuenta=".$_POST['cod_cuenta0'];
				$sql.=" and  c.fecha_cbte<'".llevarAFormatoFecha($_POST['fecha_inicio'])."'";
				$sql.=" and c.cod_estado_cbte<>2";
				$resp=mysql_query($sql);
				$sumaHaber=0;
				while ($dat=mysql_fetch_array($resp)){
					$sumaHaber=$dat[0];
				}		
				$saldo_inicial=($sumaDebe-$sumaHaber);		
			}

			

	
	$saldo=$saldo_inicial;
			$sql=" select c.cod_cbte,c.cod_tipo_cbte,c.nro_cbte,c.fecha_cbte,c.nombre,";
			$sql.=" cd.glosa,cd.debe,cd.haber,cd.haber_sus,cd.debe_sus ";
			$sql.=" from comprobante_detalle cd inner JOIN comprobante c  on(cd.cod_cbte=c.cod_cbte) ";
			$sql.=" where cd.cod_cuenta=".$_POST['cod_cuenta0'];
			$sql.=" and c.fecha_cbte>='".llevarAFormatoFecha($_POST['fecha_inicio'])."' and c.fecha_cbte<='".llevarAFormatoFecha($_POST['fecha_final'])."'";
			$sql.=" and c.cod_estado_cbte<>2";
			$sql.=" order  by c.fecha_cbte asc,c.cod_cbte asc ";
			$sumaDebe2=0;
			$sumaHaber2=0;
			$resp=mysql_query($sql);
			while ($dat=mysql_fetch_array($resp)){
				$cod_cbte=$dat['cod_cbte'];
				$cod_tipo_cbte=$dat['cod_tipo_cbte'];
				$nro_cbte=$dat['nro_cbte'];
				$fecha_cbte=$dat['fecha_cbte'];
				$nombre=$dat['nombre'];
				$glosa=$dat['glosa'];
				$debe=$dat['debe'];
				$haber=$dat['haber'];
				$haber_sus=$dat['haber_sus'];
				$debe_sus=$dat['debe_sus'];
				$sql5="select nombre_tipo_cbte from tipo_comprobante where cod_tipo_cbte=".$cod_tipo_cbte;
				$resp5=mysql_query($sql5);
				while ($dat5=mysql_fetch_array($resp5)){
					$nombre_tipo_cbte=$dat5['nombre_tipo_cbte'];
				}
				$sql5="select cambio_bs from tipo_cambio where fecha_tipo_cambio='".$fecha_cbte."'";
				$resp5= mysql_query($sql5);
				$cambio_bs='';
				while($dat5=mysql_fetch_array($resp5)){
					$cambio_bs=$dat5['cambio_bs'];
				}
				$sql2="select count(*) from pagos where cod_cbte=".$cod_cbte;
				$resp2=mysql_query($sql2);
				$nro_pago=0;
				while ($dat2=mysql_fetch_array($resp2)){
					$nro_pago=$dat2[0];							
				}
				$nombre_cliente="";
				if($nro_pago>0){
					$sql2=" select pagos.cod_pago, pagos.nro_pago,pagos.fecha_pago,pagos.cod_cliente, clientes.nombre_cliente";
					$sql2.=" from pagos inner join clientes on(pagos.cod_cliente=clientes.cod_cliente)";
					$sql2.=" where cod_cbte=".$cod_cbte;
					$resp2=mysql_query($sql2);
					while ($dat2=mysql_fetch_array($resp2)){
						$cod_pago=$dat2['cod_pago'];
						$nro_pago=$dat2['nro_pago'];
						$fecha_pago=$dat2['fecha_pago'];
						$cod_cliente=$dat2['cod_cliente'];
						$nombre_cliente=$dat2['nombre_cliente'];			
					}
				}
				$saldo=$saldo+($debe-$haber);
				$sumaDebe2=$sumaDebe2+$debe;
				$sumaHaber2=$sumaHaber2+$haber;
			
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('Arial','',7);
				$pdf->SetX(8);
				$pdf->Cell(12,5,strftime("%d/%m/%Y",strtotime($fecha_cbte)),0,0,'R',false);
				$pdf->SetFont('Arial','',7);
				$pdf->Cell(20,5,"No ".$nro_cbte." ".$nombre_tipo_cbte,0,0,'L',false);
				$pdf->SetFont('Arial','',7);
				$pdf->Cell(45,5,$nombre.$nombre_cliente,0,0,'L',false);
				$pdf->SetFont('Arial','',7);
				//$pdf->Cell(35,5,$glosa,'TB',0,'C',false);
				$pdf->SetX(120);
				$pdf->Cell(10,5,number_format($cambio_bs, 2, ",", "."),0,0,'L',false);
				$pdf->Cell(15,5,number_format($haber_sus+$debe_sus, 2, ",", "."),0,0,'R',false);
				$pdf->Cell(20,5,number_format($debe, 2, ",", "."),0,0,'R',false);
				$pdf->Cell(20,5,number_format($haber, 2, ",", "."),0,0,'R',false);
				$pdf->Cell(20,5,number_format($saldo, 2, ",", "."),0,0,'R',false);
				$pdf->SetX(90);
				$pdf->MultiCell(30,5,$glosa,0,'J',false);
				$pdf->Line(10,$pdf->GetY(),205,$pdf->GetY());
						
			}
			$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('Arial','',7);
				$pdf->SetX(8);
				$pdf->Cell(12,5,"",0,0,'R',false);
				$pdf->Cell(20,5,"",0,0,'L',false);
				$pdf->Cell(45,5,"",0,0,'L',false);
				$pdf->SetX(120);
				$pdf->Cell(10,5,"",0,0,'L',false);
				$pdf->Cell(15,5,"",0,0,'R',false);
				$pdf->Cell(20,5,number_format($sumaDebe2, 2, ",", "."),0,0,'R',false);
				$pdf->Cell(20,5,number_format($sumaHaber2, 2, ",", "."),0,0,'R',false);
				$pdf->Cell(20,5,"",0,0,'R',false);
				//$pdf->SetX(90);
				//$pdf->MultiCell(30,5,$glosa,0,'J',false);
				 

			
			


	
	

 
$pdf->Output();


require("cerrar_conexion.inc");
?>


