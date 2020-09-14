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
		
		$nombreProveedorB=$_POST['nombreProveedorB'];



    	    $this->SetFont('Arial','B',14);

				$this->Text(100,10,'REPORTE DE PROVEEDORES');
														

		    $this->SetFont('Arial','I',8);
  			$this->Text(130,15,'Page '.$this->PageNo().'/{nb}');
			$this->Text(120,20,"Date ".date('d/m/Y h:i:s', time()));
		
   		//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');

			$this->SetXY(5,25);
			$this->SetFont('Arial','B',6);
			$this->Cell(5,6,"No",1,0,'C',false);
			$this->Cell(55,6,"Proveedor",1,0,'C',false);
			$this->Cell(85,6,"Direccion",1,0,'C',false);
			$this->Cell(40,6,"Telefono",1,0,'C',false);
			$this->Cell(45,6,"Contacto 1",1,0,'C',false);
			$this->Cell(20,6,"Contacto 2",1,0,'C',false);										
			$this->Cell(18,6,"U/M",1,1,'C',false);
			$this->SetY(31);

		/************************FIN DATOS DE CABECERA*************************************/
			
	}

	//Pie de página
	function Footer()
	{	
	}

	
}

	$nombreClienteB=$_POST['nombreClienteB'];

	$pdf=new PDF('L','mm',array(214,279));
//	$pdf->SetAutoPageBreak(true,75-$valorY);
	
	
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetY(31);
		$sql="select p.cod_proveedor, p.nombre_proveedor,  p.mail_proveedor, p.telefono_proveedor,";
		$sql.=" p.direccion_proveedor, p.cod_ciudad, c.desc_ciudad,p.contacto1_proveedor, p.cel_contacto1_proveedor,  ";
		$sql.=" p.contacto2_proveedor, p.cel_contacto2_proveedor, p.cod_estado_registro, p.cod_usuario_registro, p.fecha_registro,";
		$sql.=" p.cod_usuario_modifica, p.fecha_modifica ";
		$sql.=" from proveedores p, ciudades c ";
		$sql.=" where  p.cod_ciudad=c.cod_ciudad ";
		if($nombreProveedorB<>""){
			$sql.=" and p.nombre_proveedor like'%".$nombreProveedorB."%'";
		}
		$sql.=" order by p.nombre_proveedor asc ";
	$resp = mysql_query($sql);	
	$nro=0;	
	while($dat=mysql_fetch_array($resp)){
				
			$cod_proveedor=$dat['cod_proveedor']; 
			$nombre_proveedor=$dat['nombre_proveedor'];
			$mail_proveedor=$dat['mail_proveedor'];
			$telefono_proveedor=$dat['telefono_proveedor'];
			$direccion_proveedor=$dat['direccion_proveedor'];
			$cod_ciudad=$dat['cod_ciudad'];
			$desc_ciudad=$dat['desc_ciudad'];
			$contacto1_proveedor=$dat['contacto1_proveedor'];
			$cel_contacto1_proveedor=$dat['cel_contacto1_proveedor'];
			$contacto2_proveedor=$dat['contacto2_proveedor'];
			$cel_contacto2_proveedor=$dat['cel_contacto2_proveedor'];
			$cod_estado_registro=$dat['cod_estado_registro'];
			$cod_usuario_registro=$dat['cod_usuario_registro'];
			$fecha_registro=$dat['fecha_registro'];
			$cod_usuario_modifica=$dat['cod_usuario_modifica'];
			$fecha_modifica=$dat['fecha_modifica'];

			
			///////////////////////Usuario Registro//////////////////////////
			  $usuario_registro="";
			  if($cod_usuario_registro<>"" && $cod_usuario_registro<>0){
				 $sqlAux="select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios where cod_usuario=".$cod_usuario_registro;
				 $respAux = mysql_query($sqlAux);
				 while($datAux=mysql_fetch_array($respAux)){
					 $usuario_registro=$datAux['nombres_usuario'][0].$datAux['ap_paterno_usuario'][0].$datAux['ap_materno_usuario'][0];
				 }
			 }			 
			///////////////////////Fin Usuario Registro/////////////////////
			///////////////////////Usuario Modifica//////////////////////////
			  $usuario_modifica="";
			  if($cod_usuario_modifica<>"" && $cod_usuario_modifica<>0){
				 $sqlAux="select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios where cod_usuario=".$cod_usuario_modifica;
				 $respAux = mysql_query($sqlAux);
				 while($datAux=mysql_fetch_array($respAux)){
					 $usuario_modifica=$datAux['nombres_usuario'][0].$datAux['ap_paterno_usuario'][0].$datAux['ap_materno_usuario'][0];
				 }
			 }			 
			///////////////////////Fin Usuario Modifica/////////////////////		
			$nro=$nro+1;

			$pdf->SetX(5);
			$pdf->SetFont('Arial','B',6);
			$pdf->Cell(5,5,$nro,1,0,'C',false);
			$pdf->Cell(55,5,substr($nombre_proveedor,0,50),1,0,'L',false);
			$pdf->Cell(85,5,$direccion_proveedor,1,0,'L',false);
			$pdf->Cell(40,5,$telefono_proveedor,1,0,'L',false);
			$pdf->Cell(45,5,$contacto1_proveedor. " ".$cel_contacto1_proveedor,1,0,'L',false);
			$pdf->Cell(20,5,$contacto2_proveedor."".$cel_contacto2_proveedor,1,0,'L',false);											
			if($fecha_modifica<>""){
				$pdf->Cell(18,5, strftime("%d/%m/%Y",strtotime($fecha_modifica))." ".$usuario_modifica,1,1,'L',false);
			}else{
				$pdf->Cell(18,5,'',1,1,'L',false);
			}
			

						
	}
      
	

 
$pdf->Output();


require("cerrar_conexion.inc");
?>


