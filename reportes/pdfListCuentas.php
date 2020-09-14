<?php
require("conexion1.inc");
require("fpdf.php");

include("funcionesNumerosALetras.php");


class PDF extends FPDF
{


//Cabecera de página
	function Header()
	{	
	//$this->Image('COTIZACIONA.jpg',0,0,214);	
		

		

    	    $this->SetFont('Arial','B',14);
	
	$this->Text(10,10,'PIXEL');
				$this->Text(85,18,'PLAN DE CUENTAS');
											

		    $this->SetFont('Arial','I',8);
  			$this->Text(170,10,'Page '.$this->PageNo().'/{nb}');
			$this->Text(170,15,"Fecha: ".date('d/m/Y h:i:s', time()));
		
   		//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		

			$this->SetXY(12,25);
			$this->SetFont('Arial','B',8);
			$this->Cell(7,6,"Nro",1,0,'C',false);;
			$this->Cell(60,6,"Cuenta",1,0,'C',false);
			$this->Cell(104,6,"Nombre de la Cuenta",1,0,'C',false);
			$this->Cell(16,6,"Moneda",1,0,'C',false);
			$this->SetY(31);

		/************************FIN DATOS DE CABECERA*************************************/
			
	}

	//Pie de página
	function Footer()
	{	
	}

	
}

	$nombreClienteB=$_POST['nombreClienteB'];

	$pdf=new PDF('L','mm',array(279,214));
//	$pdf->SetAutoPageBreak(true,75-$valorY);
	
	
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetY(31);
	$sql=" select cu.cod_cuenta, cu.nro_cuenta, cu.cod_cuenta_padre, cu.desc_cuenta, cu.cod_moneda, mo.abrev_moneda ";
	$sql.=" from cuentas cu, monedas mo ";
	$sql.=" where cu.cod_moneda =mo.cod_moneda ";
	$sql.=" order by nro_cuenta asc";

	$resp = mysql_query($sql);	
	$nro=0;	
	while($dat=mysql_fetch_array($resp)){
				
			 $cod_cuenta=$dat['cod_cuenta'];
			 $nro_cuenta=$dat['nro_cuenta'];
			 $cod_cuenta_padre=$dat['cod_cuenta_padre'];
			 $desc_cuenta=$dat['desc_cuenta'];
			 $cod_moneda=$dat['cod_moneda'];			 			 
			 $abrev_moneda=$dat['abrev_moneda'];
			 
			 	$nroHijos=0;
			 	$sql2=" select count(*) ";
				$sql2.=" from cuentas ";
				$sql2.=" where cod_cuenta_padre = ".$cod_cuenta;
				$resp2 = mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$nroHijos=$dat2[0];
				}
	

			///////////////////////Fin Usuario Modifica/////////////////////		
			$nro=$nro+1;

			$pdf->SetX(12);
			$pdf->SetFont('Arial','B',6);
			$pdf->Cell(7,5,$nro,1,0,'C',false);
			
			if($nroHijos>0){
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(60,5,$nro_cuenta,1,0,'L',false);
				$pdf->Cell(104,5,$desc_cuenta,1,0,'L',false);
			}else{
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(60,5,$nro_cuenta,1,0,'L',false);
				$pdf->Cell(104,5,$desc_cuenta,1,0,'L',false);
			}
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(16,5,$abrev_moneda,1,1,'L',false);


						
	}
      
	

 
$pdf->Output();


require("cerrar_conexion.inc");
?>


