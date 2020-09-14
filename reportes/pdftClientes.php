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
		
		$nombreClienteB=$_POST['nombreClienteB'];
		$filtroCliente=$_POST['filtroCliente'];


    	    $this->SetFont('Arial','B',14);
			if($filtroCliente==0){
				$this->Text(100,10,'REPORTE DE CLIENTES (Todos)');
			}
			if($filtroCliente==1){
				$this->Text(100,10,'REPORTE DE CLIENTES (Con Hoja de Ruta)');
			}
			if($filtroCliente==2){
				$this->Text(100,10,'REPORTE DE CLIENTES (Con Orden de Trabajo)');
			}
			if($filtroCliente==3){
				$this->Text(100,10,'REPORTE DE CLIENTES (Con Hoja de Ruta o Orden de Trabajo) ');
			}
			if($filtroCliente==4){
				$this->Text(100,10,'REPORTE DE CLIENTES (Sin Hoja de Ruta y Orden de Trabajo)');
			}												

		    $this->SetFont('Arial','I',8);
  			$this->Text(130,15,'Page '.$this->PageNo().'/{nb}');
			$this->Text(120,20,"Date ".date('d/m/Y h:i:s', time()));
		
   		//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		

			$this->SetXY(5,25);
			$this->SetFont('Arial','B',6);
			$this->Cell(7,6,"No",1,0,'C',false);
			$this->Cell(82,6,"Cliente",1,0,'C',false);
			$this->Cell(16,6,"Nit",1,0,'C',false);
			$this->Cell(80,6,"Direccion",1,0,'C',false);
			$this->Cell(22,6,"Telefono",1,0,'C',false);
			$this->Cell(22,6,"Fax",1,0,'C',false);
			$this->Cell(22,6,"Celular",1,0,'C',false);									
			//$this->Cell(20,6,"Fecha Registro",1,0,'C',false);
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
	$sql=" select cod_cliente,nombre_cliente, nit_cliente, cod_categoria, cod_ciudad, direccion_cliente, ";
	$sql.=" telefono_cliente, celular_cliente, fax_cliente, email_cliente, obs_cliente, cod_usuario_registro, fecha_registro, ";
	$sql.=" cod_usuario_modifica, fecha_modifica, cod_estado_registro ";
	$sql.=" from clientes  where cod_cliente<>0";
	if($nombreClienteB<>""){
		$sql.=" and   nombre_cliente like '%".$nombreClienteB."%' ";	
	}
	if($_POST['filtroCliente']==1){
	$sql.=" and cod_cliente in(select DISTINCT(c.cod_cliente) from hojas_rutas hr,cotizaciones c where hr.cod_cotizacion=c.cod_cotizacion and cod_estado_hoja_ruta<>2)";		
	}	
	if($_POST['filtroCliente']==2){
	$sql.=" and cod_cliente in(select DISTINCT(cod_cliente) from ordentrabajo where cod_est_ot<>2)";		
	}
		
	if($_POST['filtroCliente']==3){
	$sql.=" and ( cod_cliente in (select DISTINCT(c.cod_cliente) from hojas_rutas hr,cotizaciones c where hr.cod_cotizacion=c.cod_cotizacion and cod_estado_hoja_ruta<>2)";	
	$sql.=" or cod_cliente in (select DISTINCT(cod_cliente) from ordentrabajo where cod_est_ot<>2))";		
	}		
	if($_POST['filtroCliente']==4){
	$sql.=" and cod_cliente <> all(select DISTINCT(c.cod_cliente) from hojas_rutas hr,cotizaciones c where hr.cod_cotizacion=c.cod_cotizacion and cod_estado_hoja_ruta<>2)";		
		$sql.=" and cod_cliente <> all(select DISTINCT(cod_cliente) from ordentrabajo where cod_est_ot<>2)";
	}
	$sql.=" order  by nombre_cliente asc";
	$resp = mysql_query($sql);	
	$nro=0;	
	while($dat=mysql_fetch_array($resp)){
				
			 $cod_cliente=$dat['cod_cliente'];
			 $nombre_cliente=$dat['nombre_cliente'];
			 $nit_cliente=$dat['nit_cliente'];
			 $cod_categoria=$dat['cod_categoria'];
			 $cod_ciudad=$dat['cod_ciudad'];			 			 
			 $direccion_cliente=$dat['direccion_cliente'];
   		     $telefono_cliente=$dat['telefono_cliente'];
			 $celular_cliente=$dat['celular_cliente'];
			 $fax_cliente=$dat['fax_cliente'];
			 $email_cliente=$dat['email_cliente'];
			 $obs_cliente=$dat['obs_cliente'];
			 $cod_usuario_registro=$dat['cod_usuario_registro'];
			 $fecha_registro=$dat['fecha_registro'];			 
		     $cod_usuario_modifica=$dat['cod_usuario_modifica'];
			 $fecha_modifica=$dat['fecha_modifica'];
			 $cod_estado_registro=$dat['cod_estado_registro'];
			 /// Obteniendo Categoria///////
			 			 $desc_categoria="";
			 if($cod_categoria<>"" && $cod_categoria<>0){
				 $sqlAux="select desc_categoria from clientes_categorias where cod_categoria=".$cod_categoria;
				 $respAux = mysql_query($sqlAux);
				 while($datAux=mysql_fetch_array($respAux)){
					 $desc_categoria=$datAux['desc_categoria'];
				 }
			 }			 
			 //Fin obteniendo Catgeoria////////////
			 //////////Obteniendo Ciudad///////			 			 
			 $desc_ciudad="";
			  if($cod_ciudad<>"" && $cod_ciudad<>0){
				 $sqlAux="select desc_ciudad from ciudades where cod_ciudad=".$cod_ciudad;
				 $respAux = mysql_query($sqlAux);
				 while($datAux=mysql_fetch_array($respAux)){
					 $desc_ciudad=$datAux['desc_ciudad'];
				 }
			 }
			//////////Obteniendo Fin Ciudad/////// 
			 //////////Obteniendo Ciudad///////			 			 
			 $nombre_estado_registro="";
			  if($cod_estado_registro<>"" && $cod_estado_registro<>0){
				 $sqlAux="select nombre_estado_registro from estados_referenciales where cod_estado_registro=".$cod_estado_registro;
				 $respAux = mysql_query($sqlAux);
				 while($datAux=mysql_fetch_array($respAux)){
					 $nombre_estado_registro=$datAux['nombre_estado_registro'];
				 }
			 }
			//////////Obteniendo Fin Ciudad/////// 	
			
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
			$pdf->Cell(7,5,$nro,1,0,'C',false);
			$pdf->Cell(82,5,$nombre_cliente,1,0,'L',false);
			$pdf->Cell(16,5,$nit_cliente,1,0,'L',false);
			//$pdf->Cell(15,5,$desc_categoria,1,0,'L',false);
			//$pdf->Cell(20,5,$desc_ciudad,1,0,'L',false);
			$pdf->Cell(80,5,$direccion_cliente,1,0,'L',false);
			$pdf->Cell(22,5,$telefono_cliente,1,0,'L',false);
			$pdf->Cell(22,5,$fax_cliente,1,0,'L',false);
			$pdf->Cell(22,5,$celular_cliente,1,0,'L',false);									
			//$pdf->Cell(20,5,$email_cliente,1,0,'L',false);
			//$pdf->Cell(10,5,$nombre_estado_registro,1,0,'L',false);
			/*if($fecha_registro<>""){
				$pdf->Cell(20,5, strftime("%d/%m/%Y",strtotime($fecha_registro))." ".$usuario_registro,1,0,'L',false);
			}else{
				$pdf->Cell(20,5,'',1,0,'L',false);
			}*/
			if($fecha_modifica<>""){
				$pdf->Cell(18,5, strftime("%d/%m/%Y",strtotime($fecha_modifica))." ".$usuario_modifica,1,1,'L',false);
			}else{
				$pdf->Cell(18,5,'',1,1,'L',false);
			}
			

						
	}
      
	

 
$pdf->Output();


require("cerrar_conexion.inc");
?>


