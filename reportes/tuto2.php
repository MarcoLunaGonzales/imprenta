<?php
require("conexion1.inc");
require('fpdf.php');



class PDF extends FPDF
{
//Cabecera de página
function Header()
{
	//Logo
//	$this->Image('',10,8,33);
	//Arial bold 15
	$this->SetFont('Arial','B',12);
	//Movernos a la derecha
	$this->Cell(80);
	//Título
	$this->Cell(30,8,'FICHA TECNICA PARA PRODUCTOS DE TABACO',0,1,'C');
	$this->Cell(180,8,'IMPORTADOS O FABRICADOS EN EL PAIS CIGARRILLOS',0,0,'C');
	//Salto de línea
	$this->Ln(20);
}

//Pie de página
function Footer()
{
	//Posición: a 1,5 cm del final
	$this->SetY(-15);
	//Arial italic 8
	$this->SetFont('Arial','I',8);
	//Número de página
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

$cod_ficha=$_GET['cod_ficha'];
//Creación del objeto de la clase heredada
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('times','',10);
$sql=" select cod_ficha, cod_tipo_cigarrillo, cod_emp_prim_cant, ";
$sql.=" cod_emp_secc_cant, cod_embalaje_cant, cod_marca, sku, sku_local,";
$sql.=" marca, producto,presentacion, cod_pais, cia_productora,cia_productora_en_bolivia, filtro_si_no, ";
$sql.=" presen_hard_soft_pack, cod_contacto";
$sql.=" from fichas_producto ";
$sql.=" where cod_ficha='".$cod_ficha."'";

$resp=mysql_query($sql);
while ($dat=mysql_fetch_array($resp)){		
	$cod_ficha=$dat[0];
	
	$cod_tipo_cigarrillo=$dat[1];
	$nombre_tipo_cigarrillo="";	
	$sql3=" select  nombre_tipo_cigarrillo from tipos_cigarrillo where cod_tipo_cigarrillo='".$cod_tipo_cigarrillo."'";
	$resp3=mysql_query($sql3);
	while ($dat3=mysql_fetch_array($resp3)){	
		$nombre_tipo_cigarrillo=$dat3[0];
	}	
		
	$cod_emp_prim_cant=$dat[2];
	$sql3=" select cant_emp_prim_cant from empaque_primario_cantidades where cod_emp_prim_cant='".$cod_emp_prim_cant."'";
	$cant_emp_prim_cant="";
	$resp3=mysql_query($sql3);
	while ($dat3=mysql_fetch_array($resp3)){	
		$cant_emp_prim_cant=$dat3[0];
	}	
	
	$cod_emp_secc_cant=$dat[3];
	$sql3=" select cant_emp_secc_cant from empaque_secundario_cantidades where cod_emp_secc_cant='".$cod_emp_secc_cant."'";
	$cant_emp_secc_cant="";
	$resp3=mysql_query($sql3);
	while ($dat3=mysql_fetch_array($resp3)){
		$cant_emp_secc_cant=$dat3[0];
	}	
	
	$cod_embalaje_cant=$dat[4];
	$sql3=" select cant_embalaje_cant from embalaje_cantidades where cod_embalaje_cant='".$cod_embalaje_cant."'";

	$cant_embalaje_cant="";
	$resp3=mysql_query($sql3);
	while ($dat3=mysql_fetch_array($resp3)){
		$cant_embalaje_cant=$dat3[0];
	}	
	
	$cod_marca=$dat[5];
	$sku=$dat[6];
	$sku_local=$dat[7];
	$marca=$dat[8];
	$producto=$dat[9];
	$presentacion=$dat[10];
	
	$cod_pais=$dat[11];
	$sql3=" select  nombre_pais  from paises where cod_pais='".$cod_pais."'";
	$empresa="";
	$resp3=mysql_query($sql3);
	while ($dat3=mysql_fetch_array($resp3)){	
		$nombre_pais=$dat3[0];
	}	
	$cia_productora=$dat[12];
	$cia_productorabolivia=$dat[13];
	$filtro_si_no=$dat[14];
	$presen_hard_soft_pack=$dat[15];
	$cod_contacto=$dat[16];
	$sql3=" select  rotulo_comercial  from empresas where cod_empresa in (select cod_empresa from contactos where cod_contacto='".$cod_contacto."')";
	$empresa="";
	$resp3=mysql_query($sql3);
	while ($dat3=mysql_fetch_array($resp3)){		
		$empresa=$dat3[0];
	}
	

}

	$pdf->Cell(85,6,'1. Datos de Solicitante ',0,0);
	$pdf->Cell(70,6,$empresa,0,1);
	$pdf->Cell(85,6,'2. Marca',0,0);
	$pdf->Cell(50,6,$marca,0,1);
	$pdf->Cell(85,6,'3. Producto ',0,0);
	$pdf->Cell(50,6,$producto,0,1);	
	$pdf->Cell(85,6,'4. Presentación ',0,0);
	$pdf->Cell(50,6,$presentacion,0,1);		
	$pdf->Cell(85,6,'5. SKU Origen ',0,0);
	$pdf->Cell(50,6,$sku,0,1);	
	$pdf->Cell(85,6,'6. SKU Local',0,0);
	$pdf->Cell(50,6,$sku_local,0,1);
	$pdf->Cell(85,6,'7. Lugar de Producción',0,0);
	$pdf->Cell(50,6,$nombre_pais,0,1);	
	$pdf->Cell(85,6,'8. Compañia Productora',0,0);
	$pdf->Cell(50,6,$cia_productora,0,1);			
	$pdf->Cell(85,6,'9. Compañia Productora o Comercializadora en Bolivia',0,0);
	$pdf->Cell(50,6,$cia_productorabolivia,0,1);
	
	$pdf->Cell(85,6,'10. Cigarrillos con Filtro',0,0);	
	if($filtro_si_no==1){
		$pdf->Cell(8,6,'Si',0,0);
		$pdf->Cell(5,4,'x',1,0);
		$pdf->Cell(5,5,' ',0,0);
		$pdf->Cell(8,6,'No',0,0);
		$pdf->Cell(5,4,' ',1,1);
	}else{
		$pdf->Cell(8,6,'Si',0,0);
		$pdf->Cell(5,4,'',1,0);
		$pdf->Cell(5,5,' ',0,0);
		$pdf->Cell(8,6,'No',0,0);
		$pdf->Cell(5,4,'x',1,1);
	}
	$pdf->Cell(85,2,'',0,1);
	
	$pdf->Cell(85,6,'11. Presentación ',0,0);
	if($presen_hard_soft_pack==1){
		$pdf->Cell(20,6,'Hard Pack',0,0);
		$pdf->Cell(5,4,'x',1,0);
		$pdf->Cell(5,6,' ',0,0);
		$pdf->Cell(20,6,'Hard Pack',0,0);
		$pdf->Cell(5,4,' ',1,1);
	}else{
		$pdf->Cell(20,6,'Hard Pack',0,0);
		$pdf->Cell(5,4,'',1,0);
		$pdf->Cell(5,6,' ',0,0);
		$pdf->Cell(20,6,'Hard Pack',0,0);
		$pdf->Cell(5,4,'x',1,1);
	}
	$pdf->Cell(85,2,'',0,1);
	$pdf->Cell(85,6,'12. Tipo de Cigarrillo',0,0);
	$pdf->Cell(50,6,$nombre_tipo_cigarrillo,0,1);
	$pdf->Cell(85,6,'13. Tipo de Embalaje',0,1);
	
	$pdf->Cell(85,6,' a) Cantidad de Cajetilla',0,0);
	$pdf->Cell(50,6,$cant_emp_prim_cant,0,1);
	
	$pdf->Cell(85,6,' b) Cantidad de Cartones/Paquetes',0,0);
	$pdf->Cell(50,6,$cant_emp_secc_cant,0,1);
	
	$pdf->Cell(85,6,' c) Cantidad de Master Cases o Jaba',0,0);
	$pdf->Cell(50,6,$cant_embalaje_cant,0,1);

	$pdf->Cell(85,6,'14. Información en la Cajetilla',0,1);
	
	$sql3=" select cod_emp_prim_inf, nombre_emp_prim_inf from empaque_primario_informacion ";
	$resp3=mysql_query($sql3);
	while ($dat3=mysql_fetch_array($resp3)){	
	
		$cod_emp_prim_inf=$dat3[0];
		$nombre_emp_prim_inf=$dat3[1];
		$sql4=" select count(*) as existe from  ficha_inf_emp_primario ";
		$sql4.=" where cod_emp_prim_inf='".$cod_emp_prim_inf."'";
		$sql4.=" and cod_ficha='".$cod_ficha."'";
		$resp4=mysql_query($sql4);
		while ($dat4=mysql_fetch_array($resp4)){	
			$existe=$dat4[0];	
		}
		$pdf->Cell(85,6,'',0,0);
		if($existe>0){
			$pdf->Cell(4,4,'x',1,0);
		}else{
			$pdf->Cell(4,4,'',1,0);
		}
		$pdf->Cell(50,6,$nombre_emp_prim_inf,0,1);
		
	}		

	
	$pdf->Cell(85,6,'15. Información de Cartones/Paquetes',0,1);	
	$sql3=" select cod_emp_secc_inf, nombre_emp_secc_inf from empaque_secundario_informacion ";
	$resp3=mysql_query($sql3);
	while ($dat3=mysql_fetch_array($resp3)){	
	
		$cod_emp_secc_inf=$dat3[0];
		$nombre_emp_secc_inf=$dat3[1];
		$sql4=" select count(*) as existe from  ficha_inf_emp_secundario ";
		$sql4.=" where cod_emp_secc_inf='".$cod_emp_secc_inf."'";
		$sql4.=" and cod_ficha='".$cod_ficha."'";
		$resp4=mysql_query($sql4);
		while ($dat4=mysql_fetch_array($resp4)){	
			$existe=$dat4[0];	
		}
		$pdf->Cell(85,6,'',0,0);
		if($existe>0){
			$pdf->Cell(4,4,'x',1,0);
		}else{
			$pdf->Cell(4,4,'',1,0);
		}
		$pdf->Cell(50,6,$nombre_emp_secc_inf,0,1);		
	}		
	
	$pdf->Cell(85,6,'16.  Información de Master Cases / Jaba',0,1);	
	$sql3=" select cod_embalaje_inf, nombre_embalaje_inf from embalaje_informacion ";
	$resp3=mysql_query($sql3);
	while ($dat3=mysql_fetch_array($resp3)){	
	
		$cod_embalaje_inf=$dat3[0];	
		$nombre_embalaje_inf=$dat3[1];
		$sql4=" select count(*) as existe from  ficha_inf_embalaje ";
		$sql4.=" where cod_embalaje_inf='".$cod_embalaje_inf."'";
		$sql4.=" and cod_ficha='".$cod_ficha."'";
		$resp4=mysql_query($sql4);
		while ($dat4=mysql_fetch_array($resp4)){	
			$existe=$dat4[0];
		}
		$pdf->Cell(85,6,'',0,0);
		if($existe>0){
			$pdf->Cell(4,4,'x',1,0);
		}else{
			$pdf->Cell(4,4,'',1,0);
		}
		$pdf->Cell(50,6,$nombre_embalaje_inf,0,1);		
	}		
	
	
$pdf->Output();
require("cerrar_conexion.inc");
?>

