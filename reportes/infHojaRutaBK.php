<?php
require("conexion1.inc");
require("fpdf.php");

include("funcionesNumerosALetras.php");


class PDF extends FPDF
{


//Cabecera de página
	function Header()
	{	
	//$this->Image('cotizacion2.jpg',15,15,185.17,250);	
		
		$cod_hoja_ruta=$_GET['cod_hoja_ruta'];
	/////////////////////////////////////DATOS HOJA RUTA///////////////	
	$sql=" select  cod_gestion, nro_hoja_ruta, fecha_hoja_ruta, cod_usuario_hoja_ruta, ";
	$sql.=" obs_hoja_ruta, cod_cotizacion, cod_estado_hoja_ruta, factura_si_no, cod_usuario_comision, cod_tipo_pago,informe";
	$sql.=" from hojas_rutas ";
	$sql.=" where  cod_hoja_ruta='".$cod_hoja_ruta."'";
	$resp=mysql_query($sql);
	while ($dat=mysql_fetch_array($resp)){
	
		$cod_gestion=$dat[0];
			/************GESTION********************/
			$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion."'";
			$resp2= mysql_query($sql2);
			$gestionHojaRuta="";
			while($dat2=mysql_fetch_array($resp2)){
				$gestionHojaRuta=$dat2[0];
			}		
			/************FIN GESTION********************/		
		$nro_hoja_ruta=$dat[1];
		$fecha_hoja_ruta=$dat[2];
		/********************************/
		$fechaHojaRutaVecto=explode(" ",$fecha_hoja_ruta);
		$fechaHojaRutaVectoAux=explode("-",$fechaHojaRutaVecto[0]);	
		/********************************/	
		$cod_usuario_hoja_ruta=$dat[3];
		$sql2="select nombres_usuario,ap_paterno_usuario from usuarios  where cod_usuario='".$cod_usuario_hoja_ruta."'";	
		$resp2= mysql_query($sql2);
		$dat2=mysql_fetch_array($resp2);
		$usuarioHojaRuta=$dat2[0]." ".$dat2[1]." ".$dat2[2];
				
		$obs_hoja_ruta=$dat[4];
		$cod_cotizacion=$dat[5];
		$cod_estado_hoja_ruta=$dat[6];
		$factura_si_no=$dat[7];
		$cod_usuario_comision=$dat[8];
		$cod_tipo_pago=$dat['cod_tipo_pago'];
		$informe=$dat['informe'];
		//////////////////Tipo Pago///////////////
		$nombre_tipo_pago_hojaruta="";
		$sql2=" select nombre_tipo_pago  from tipos_pago ";
		$sql2.=" where cod_tipo_pago='".$cod_tipo_pago."'";
		$resp2=mysql_query($sql2);
		while ($dat2=mysql_fetch_array($resp2)){
			$nombre_tipo_pago_hojaruta=$dat2['nombre_tipo_pago'];

		}		
		///////////////////Fin Tipo pago/////////////////////
		 $usuarioComision="";
		if($cod_usuario_comision<>0){
			$sql2="select nombres_usuario,ap_paterno_usuario from usuarios  where cod_usuario='".$cod_usuario_comision."'";	
			$resp2= mysql_query($sql2);
			$dat2=mysql_fetch_array($resp2);
			$nombres_usuario=$dat2[0];
			$ap_paterno_usuario=$dat2[1];

			$usuarioComision=$nombres_usuario." ".$ap_paterno_usuario;		
		 }
	}
	////////////////////////FIN DATOS GENERALES HOJA RUTA////////////////////////////		

/**********************DATOS DE CABECERA*********************/

	
		$sql5="select  valor_x, valor_y from coordenadas_impresion where cod_coordenada=1";
		$resp5=mysql_query($sql5);
		while ($dat5=mysql_fetch_array($resp5)){
			$valorX=$dat5[0];
			$valorY=$dat5[1];
		}


	$sql=" select cod_cotizacion, cod_tipo_cotizacion, cod_estado_cotizacion, nro_cotizacion,";
	$sql.=" cod_cliente, fecha_cotizacion, obs_cotizacion, cod_usuario_registro, cod_tipo_pago, ";
	$sql.=" fecha_modifica, cod_gestion, cod_usuario_modifica, cod_sumar, considerar_precio_unitario ";
	$sql.=" from cotizaciones ";
	$sql.=" where  cod_cotizacion='".$cod_cotizacion."'";
	$resp=mysql_query($sql);
	while ($dat=mysql_fetch_array($resp)){

		$cod_cotizacion=$dat[0];
		$cod_tipo_cotizacion=$dat[1];
		$cod_estado_cotizacion=$dat[2];
		$nro_cotizacion=$dat[3];
		$cod_cliente=$dat[4];
		$fecha_cotizacion=$dat[5];
		$fechaCotizacionVecto=explode(" ",$fecha_cotizacion);
		$fechaCotizacionVectoAux=explode("-",$fechaCotizacionVecto[0]);
		$fecha=$fechaCotizacionVectoAux[2]."/".$fechaCotizacionVectoAux[1]."/".$fechaCotizacionVectoAux[0];
		$obs_cotizacion=$dat[6];
		$cod_usuario_registro=$dat[7];
		$cod_tipo_pago=$dat[8];
		$fecha_modifica=$dat[9];
		$cod_gestion=$dat[10];
		$sql5="select gestion from gestiones where cod_gestion='".cod_gestion."'";
		$resp5=mysql_query($sql5);
		while ($dat5=mysql_fetch_array($resp5)){
			$gestion=$dat5[0];
		}			
		$cod_usuario_modifica=$dat[11];
		$cod_sumar=$dat[12];
		$considerar_precio_unitaria=$dat[13];
		
		/***************Datos Cliente****************/	
			$sql2=" select nombre_cliente, nit_cliente, cod_categoria, cod_ciudad,  ";
			$sql2.=" direccion_cliente, telefono_cliente, celular_cliente, fax_cliente, email_cliente, ";
			$sql2.=" obs_cliente ";
			$sql2.=" from clientes ";
			$sql2.=" where cod_cliente='".$cod_cliente."'";
			$resp2=mysql_query($sql2);
			while ($dat2=mysql_fetch_array($resp2)){
				$nombre_cliente=$dat2[0];
				$nit_cliente=$dat2[1];
				$cod_categoria=$dat2[2];
				$cod_ciudad=$dat2[3];
				$direccion_cliente=$dat2[4];
				$telefono_cliente=$dat2[5];
				$celular_cliente=$dat2[6];
				$fax_cliente=$dat2[7];
				$email_cliente=$dat2[8];
				$obs_cliente=$dat2[9];		
			}
		/**********************Fin Datos de Cliente******************************
		/***************Datos Cliente****************/	
		$sql2=" select gestion  from gestiones ";
		$sql2.=" where cod_gestion='".$cod_gestion."'";
		$resp2=mysql_query($sql2);
		while ($dat2=mysql_fetch_array($resp2)){
			$gestion=$dat2[0];

		}
		//////////////////Tipo Pago///////////////
		$sql2=" select nombre_tipo_pago  from tipos_pago ";
		$sql2.=" where cod_tipo_pago='".$cod_tipo_pago."'";
		$resp2=mysql_query($sql2);
		$nombre_tipo_pago_cotizacion="";
		while ($dat2=mysql_fetch_array($resp2)){
			$nombre_tipo_pago_cotizacion=$dat2['nombre_tipo_pago'];

		}		
		///////////////////Fin Tipo pago/////////////////////
	}
	
	$facturas="";
	$sqlAux=" select fhr.cod_factura, f.nro_factura, f.fecha_factura, f.monto_factura, f.obs_factura ";
	$sqlAux.=" from factura_hojaruta fhr, facturas f ";
	$sqlAux.=" where fhr.cod_factura=f.cod_factura  and f.cod_est_fac<>2 ";
	$sqlAux.=" and fhr.cod_hoja_ruta=".$cod_hoja_ruta;
	$respAux=mysql_query($sqlAux);
	while ($datAux=mysql_fetch_array($respAux)){
		$cod_factura=$datAux['cod_factura'];
		$nro_factura=$datAux['nro_factura'];
		$fecha_factura=$datAux['fecha_factura'];
		$monto_factura=$datAux['monto_factura'];
		$obs_factura=$datAux['obs_factura'];
		if($obs_factura==""){
			$facturas=$facturas.$nro_factura." ".strftime("%d/%m/%Y",strtotime($fecha_factura))."(".$monto_factura."); ";
		}else{
			$facturas=$facturas.$nro_factura." ".strftime("%d/%m/%Y",strtotime($fecha_factura))."(".$monto_factura."); Obs.:".$obs_factura;
		}
	}
	$totalFacturas=0;
	if($facturas<>""){
		$totalFacturas=0;
		$sqlAux=" select sum(f.monto_factura) ";
		$sqlAux.=" from factura_hojaruta fhr, facturas f ";
		$sqlAux.=" where fhr.cod_factura=f.cod_factura  and f.cod_est_fac<>2 ";
		$sqlAux.=" and fhr.cod_hoja_ruta=".$cod_hoja_ruta;
		$respAux=mysql_query($sqlAux);
		while ($datAux=mysql_fetch_array($respAux)){
			$totalFacturas=$datAux[0];
		}
		
	}

		/**********************Fin Datos de Cliente******************************/	

			$this->SetFont('Arial','B',10);
			$this->SetTextColor(0,0,0);	
			$this->SetFont('Arial','B',9);
			$this->SetXY(160,10);
    	    $this->Cell(0,4,'Página '.$this->PageNo().' de '.' {nb}',0,1,'R',false);
						
			$this->SetFont('Arial','B',14);
			$this->SetTextColor(0,0,0);
			$this->Text(85,13,"INFORME DE HOJA DE RUTA");
			$this->SetFont('Arial','B',10);
			$this->SetXY(12,15);
			if($informe=='SI'){
			$this->Cell(0,5,'CERRADO',0,0,'R');
			}
			
			$this->SetXY(12,22);
			$this->Cell(20,5,'CLIENTE:',0,0,'L');
			$this->SetFont('Arial','',10);
			$this->SetXY(36,22);
			$this->Cell(0,5,$nombre_cliente,0,0,'L');
			$this->SetXY(12,27);
			$this->SetFont('Arial','B',10);
			$this->Cell(20,5,'DIRECCION:',0,0,'L');
			$this->SetFont('Arial','',10);
			$this->SetXY(36,27);
			$this->Cell(0,5,$direccion_cliente,0,0,'L');
			$this->SetXY(12,32);
			$this->SetFont('Arial','B',10);
			$this->Cell(20,5,'TELF:',0,0,'L');
			$this->SetFont('Arial','',10);
			$this->SetXY(36,32);
			$this->Cell(0,5,$telefono_cliente,0,0,'L');
			$this->SetXY(80,32);
			$this->SetFont('Arial','B',10);
			$this->Cell(20,5,'CELULAR:',0,0,'L');
			$this->SetFont('Arial','',10);
			$this->SetXY(103,32);
			$this->Cell(0,5,$celular_cliente,0,0,'L');
			$this->SetXY(140,32);
			$this->SetFont('Arial','B',10);
			$this->Cell(20,5,'FAX:',0,0,'L');
			$this->SetFont('Arial','',10);
			$this->SetXY(163,32);
			$this->Cell(0,5,$fax_cliente,0,0,'L');
			
			$this->SetFont('Arial','B',10);
			$this->SetXY(12,37);
			$this->Cell(0,5,'HR:',0,0,'L');
			$this->SetFont('Arial','',10);
			$this->SetXY(23,37);
			$this->Cell(0,5,$nro_hoja_ruta."/".$gestionHojaRuta,0,0,'L');			
			$this->SetFont('Arial','B',10);
			$this->SetXY(42,37);
			$this->Cell(0,5,'FECHA HR:',0,0,'L');
			$this->SetFont('Arial','',10);
			$this->SetXY(64,37);
			$this->Cell(0,5,$fechaHojaRutaVectoAux[2]."/".$fechaHojaRutaVectoAux[1]."/".$fechaHojaRutaVectoAux[0],0,0,'L');
			$this->SetXY(85,37);
			$this->SetFont('Arial','B',10);
			$this->Cell(0,5,'TIPO PAGO:',0,0,'L');
			$this->SetFont('Arial','',10);
			$this->SetXY(107,37);
			$this->Cell(0,5,$nombre_tipo_pago_hojaruta,0,0,'L');
			$this->SetXY(130,37);
			$this->SetFont('Arial','B',10);
			$this->Cell(0,5,'C:',0,0,'L');
			$this->SetFont('Arial','',10);
			$this->SetXY(135,37);
			$this->Cell(0,5,$factura_si_no,0,0,'L');
			$this->SetXY(140,37);
			$this->SetFont('Arial','B',10);
			$this->Cell(0,5,'C3:',0,0,'L');
			$this->SetFont('Arial','',10);
			$this->SetXY(148,37);
			$this->Cell(0,5,$usuarioComision,0,0,'L');
						
						
			
			$this->SetFont('Arial','B',10);
			$this->SetXY(12,42);
			$this->Cell(0,5,'COT:',0,0,'L');
			$this->SetFont('Arial','',10);
			$this->SetXY(23,42);
			$this->Cell(0,5,$nro_cotizacion."/".$gestion,0,0,'L');			
			$this->SetFont('Arial','B',10);
			$this->SetXY(42,42);
			$this->Cell(0,5,'FECHA COT:',0,0,'L');
			$this->SetFont('Arial','',10);
			$this->SetXY(64,42);
			$this->Cell(0,5,$fecha,0,0,'L');
			$this->SetXY(85,42);
			$this->SetFont('Arial','B',10);
			$this->Cell(0,5,'TIPO PAGO:',0,0,'L');
			$this->SetFont('Arial','',10);
			$this->SetXY(107,42);
			$this->Cell(0,5,$nombre_tipo_pago_cotizacion,0,0,'L');	
			$this->SetXY(12,47);
			$this->SetFont('Arial','B',10);
			$this->Cell(25,5,"FACTURAS:",0,0,'L');		
			$this->SetXY(37,47);
			$this->SetFont('Arial','',7);
			$this->MultiCell(170,4,$facturas,0,'J',false);
			$AuxY=$this->GetY();
			
			$this->SetXY(12,$AuxY);
			$this->SetFont('Arial','B',10);
			$this->Cell(25,5,"TOTAL FACT:",0,0,'L');
			$this->SetFont('Arial','',10);		
			$this->SetXY(37,$AuxY);
			$this->Cell(170,5,number_format($totalFacturas,2),0,1,'L');
			if($obs_hoja_ruta<>""){
				$AuxY=$this->GetY();			
				$this->SetXY(12,$AuxY);
				$this->SetFont('Arial','B',10);
				$this->Cell(25,5,"OBS. HR.:",0,0,'L');		
				$this->SetXY(37,$AuxY);
				$this->SetFont('Arial','',7);
				$this->MultiCell(170,4,$obs_hoja_ruta,0,'J',false);
			}
			if($obs_cotizacion<>""){
				$AuxY=$this->GetY();			
				$this->SetXY(12,$AuxY);
				$this->SetFont('Arial','B',10);
				$this->Cell(25,5,"OBS. COT.:",0,0,'L');		
				$this->SetXY(37,$AuxY);
				$this->SetFont('Arial','',7);
				$this->MultiCell(170,4,$obs_cotizacion,0,'J',false);			
			}
			$AuxY=$this->GetY();
			
			//$this->Text(12,25,"CLIENTE:".$nombre_cliente);

			//$this->SetY(62);

			$this->SetY($AuxY+5);
		/************************FIN DATOS DE CABECERA*************************************/

			
	}

	//Pie de página
	function Footer()
	{	
	/*$cod_cotizacion=$_GET['cod_cotizacion'];
					$sql=" select  descuento_cotizacion ";
	$sql.=" from cotizaciones ";
	$sql.=" where  cod_cotizacion='".$cod_cotizacion."'";
	$resp=mysql_query($sql);
	while ($dat=mysql_fetch_array($resp)){

		$descuento_cotizacion=$dat[0];
	}	
		$sql5="select  valor_x, valor_y from coordenadas_impresion where cod_coordenada=1";
		$resp5=mysql_query($sql5);
		while ($dat5=mysql_fetch_array($resp5)){
			$valorX=$dat5[0];
			$valorY=$dat5[1];
		}
	
		global $sw;
		global $suma;
		global $suma_literal;
		global $cod_sumar;
	
		if($sw==1 && $cod_sumar==1 ){
			$this->SetY($valorY+202);
			$this->SetX($valorX+170);
			$this->SetFont('Arial','B',9);	
			$numero_formato=number_format($suma-$descuento_cotizacion,2);					
			$this->Cell(20,6,$numero_formato,0,1,'L',false);
			$suma_literal=convertir($suma-$descuento_cotizacion);
			$longitud=strlen($suma_literal);
			$x=146-$longitud;
			for($i=1;$i<=$x/1.43;$i++){
				$suma_literal=$suma_literal."-";
			}
			
			$this->SetY($valorY+214);
			$this->SetX($valorX+26);
			$this->Cell(146,6,$suma_literal,0,1,'L',false);
		}
	
	
		$cod_hoja_ruta=$_GET['cod_hoja_ruta'];
		$sql=" select  cod_cotizacion";
		$sql.=" from hojas_rutas ";
		$sql.=" where  cod_hoja_ruta='".$cod_hoja_ruta."'";
		$resp=mysql_query($sql);
		while ($dat=mysql_fetch_array($resp)){
			$cod_cotizacion=$dat['cod_cotizacion'];
		}
		
		$cod_cotizacion=$_GET['cod_cotizacion'];

		$sql=" select cod_usuario_firma from cotizaciones ";
		$sql.=" where  cod_cotizacion='".$cod_cotizacion."'";
		$resp=mysql_query($sql);
		while ($dat=mysql_fetch_array($resp)){
			$cod_usuario_firma=$dat[0];
		}
		
		$sql=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario,cod_grado from usuarios ";
		$sql.=" where  cod_usuario='".$cod_usuario_firma."'";
		$resp=mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){
			$nombres_usuario=$dat[0];
			$ap_paterno_usuario=$dat[1]; 
			$ap_materno_usuario=$dat[2];
			$cod_grado=$dat[3];
			$sql2="select abrev_grado from grado_academico where cod_grado='".$cod_grado."'";
			$resp2=mysql_query($sql2);
			while($dat2=mysql_fetch_array($resp2)){
				$abrev_grado=$dat2[0];
			}
			
		}
		$this->SetY($valorY+250);
		$this->SetX($valorX+142);
		$this->SetFont('Arial','B',9);
		$this->Cell(0,6,$abrev_grado." ".$nombres_usuario." ".$ap_paterno_usuario." ".$ap_materno_usuario,0,1,'L',false);

	*/
	}

}

	$sql5="select  valor_x, valor_y from coordenadas_impresion where cod_coordenada=1";
	$resp5=mysql_query($sql5);
	while ($dat5=mysql_fetch_array($resp5)){
			$valorX=$dat5[0];
			$valorY=$dat5[1];
	}
	$cod_hoja_ruta=$_GET['cod_hoja_ruta'];
	$sql=" select  cod_cotizacion";
	$sql.=" from hojas_rutas ";
	$sql.=" where  cod_hoja_ruta='".$cod_hoja_ruta."'";
	$resp=mysql_query($sql);
	while ($dat=mysql_fetch_array($resp)){
		$cod_cotizacion=$dat['cod_cotizacion'];
	}
		
	//Creación del objeto de la clase heredada
	//$pdf=new PDF('P','mm','Letter');
	$pdf=new PDF('P','mm',array(214,279));
	//$pdf->SetAutoPageBreak(true,75-$valorY);
	
	$pdf->AliasNbPages();
	$pdf->AddPage();
	//$pdf->Line(0, 0, 214,279);


	/********************datos extras de cotizacion***************/	
	$sql=" select cod_cotizacion, cod_tipo_cotizacion, cod_estado_cotizacion, nro_cotizacion,";
		$sql.=" cod_cliente, fecha_cotizacion, obs_cotizacion, cod_usuario_registro, cod_tipo_pago, ";
		$sql.=" fecha_modifica, cod_gestion, cod_usuario_modifica, cod_sumar, considerar_precio_unitario ";
		$sql.=" from cotizaciones ";
		$sql.=" where  cod_cotizacion='".$cod_cotizacion."'";
		$resp=mysql_query($sql);
		while ($dat=mysql_fetch_array($resp)){

			$cod_cotizacion=$dat[0];
			$cod_tipo_cotizacion=$dat[1];
			$cod_estado_cotizacion=$dat[2];
			$nro_cotizacion=$dat[3];
			$cod_cliente=$dat[4];
			$fecha_cotizacion=$dat[5];
			$fechaCotizacionVecto=explode(" ",$fecha_cotizacion);
			$fechaCotizacionVectoAux=explode("-",$fechaCotizacionVecto[0]);
			$fecha=$fechaCotizacionVectoAux[2]."/".$fechaCotizacionVectoAux[1]."/".$fechaCotizacionVectoAux[0];
			$obs_cotizacion=$dat[6];
			$cod_usuario_registro=$dat[7];
			$cod_tipo_pago=$dat[8];
			$fecha_modifica=$dat[9];
			$cod_gestion=$dat[10];	
			$cod_usuario_modifica=$dat[11];
			$cod_sumar=$dat[12];
			$considerar_precio_unitario=$dat[13];
		}
	/***********************************/
	
/*********************************CUERPO DE COTIZACION****************************************/
		$pdf->SetFont('Arial','B',7);
		$pdf->SetX(12);
		$pdf->Cell(9,4,"ITEM",0,0,'C',false);
		$pdf->SetX(21);
		$pdf->Cell(29,4,"CANT",0,0,'C',false);
		$pdf->SetX(50);
		$pdf->Cell(120,4,"DESCRIPCION",0,0,'C',false);
		$pdf->SetX(170);
		$pdf->Cell(20,4,"CANT ENT",0,0,'C',false);
		$pdf->SetX(195);
		$pdf->Cell(20,4,"COSTO",0,1,'C',false);
	
		$cont=0;
		$sql=" select cod_cotizaciondetalle,  cod_item, descripcion_item, ";
		$sql.=" cantidad_unitariacotizacion, cantidad_unitariacotizacionefectuada, ";
		$sql.=" cod_estado_detallecotizacionitem,precio_venta, descuento, importe_total, orden ";
		$sql.=" from cotizaciones_detalle ";
		$sql.=" where  cod_cotizacion='".$cod_cotizacion."'";
		$sql.=" and   cod_cotizaciondetalle in(select cod_cotizaciondetalle from hojas_rutas_detalle";
		$sql.=" where cod_hoja_ruta=".$cod_hoja_ruta.")";
		$sql.=" order by cod_cotizaciondetalle asc";
		$resp=mysql_query($sql);
		$suma=0;

		$contador=0;
		while ($dat=mysql_fetch_array($resp)){
			$contador=$contador+1;

			$val_aux_coordenadaY=$pdf->GetY();
			
			$cod_cotizaciondetalle=$dat[0];
			/////////////////////////////////DETALLE DE NOTAS REMISION/////////
			$nro_nr_item=0;
			$sql5="select  count(*) ";
			$sql5.=" from notas_remision_detalle nrd, notas_remision nr ";
			$sql5.=" where nrd.cod_nota_remision=nr.cod_nota_remision ";
			$sql5.=" and nr.cod_estado_nota_remision=1 ";
			$sql5.=" and nrd.cod_cotizacion='".$cod_cotizacion."'";
			$sql5.=" and nrd.cod_cotizaciondetalle='".$cod_cotizaciondetalle."'";
			$resp5=mysql_query($sql5);
			$nro_nr_item=0;
			while ($dat5=mysql_fetch_array($resp5)){
				$nro_nr_item=$dat5[0];								
			}
			$notas_remision_item="";
			$tot_cant_notas_remision_item=0;
			if($nro_nr_item>0){
				$notas_remision_item="";
				$tot_cant_notas_remision_item=0;
				$sql5="select sum(nrd.cantidad)";
				$sql5.=" from notas_remision_detalle nrd, notas_remision nr, gestiones g";
				$sql5.=" where nrd.cod_nota_remision=nr.cod_nota_remision";
				$sql5.=" and nr.cod_estado_nota_remision=1";
				$sql5.=" and  nr.cod_gestion=g.cod_gestion";
				$sql5.=" and nrd.cod_cotizacion='".$cod_cotizacion."'";
				$sql5.=" and nrd.cod_cotizaciondetalle='".$cod_cotizaciondetalle."'";
				$sql5.=" order by nr.nro_nota_remision desc, g.gestion desc ";
				$resp5=mysql_query($sql5);
				while ($dat5=mysql_fetch_array($resp5)){
					$tot_cant_notas_remision_item=$dat5[0];
				}
				
				
				$sql5="select nrd.cantidad,nr.cod_nota_remision, nr.nro_nota_remision, g.gestion, nr.fecha_nota_remision,";
				$sql5.=" nr.obs_nota_remision ";
				$sql5.=" from notas_remision_detalle nrd, notas_remision nr, gestiones g";
				$sql5.=" where nrd.cod_nota_remision=nr.cod_nota_remision";
				$sql5.=" and nr.cod_estado_nota_remision=1";
				$sql5.=" and  nr.cod_gestion=g.cod_gestion";
				$sql5.=" and nrd.cod_cotizacion='".$cod_cotizacion."'";
				$sql5.=" and nrd.cod_cotizaciondetalle='".$cod_cotizaciondetalle."'";
				$sql5.=" order by nr.nro_nota_remision desc, g.gestion desc ";
				$resp5=mysql_query($sql5);
				while ($dat5=mysql_fetch_array($resp5)){
					$cantidad=$dat5['cantidad'];	
					$cod_nota_remision=$dat5['cod_nota_remision'];	
					$nro_nota_remision=$dat5['nro_nota_remision'];		
					$gestion_nota_remision=$dat5['gestion'];				
					$fecha_nota_remision=$dat5['fecha_nota_remision'];
					$obs_nota_remision=$dat5['obs_nota_remision'];
					if($obs_nota_remision==""){
				$notas_remision_item=$notas_remision_item." NR.:".$nro_nota_remision."/".$gestion_nota_remision." (".strftime("%d/%m/%Y",strtotime($fecha_nota_remision)).") Cant.: ".$cantidad.";";
					}else{
						$notas_remision_item=$notas_remision_item." NR.:".$nro_nota_remision."/".$gestion_nota_remision." (".strftime("%d/%m/%Y",strtotime($fecha_nota_remision)).") Cant.: ".$cantidad."; Obs.:".$obs_nota_remision;
						
					}
				}			
			
			}

			
			//////////////////////////////DETALLE nOTAS rEMISION///////////////
			
			$cod_item=$dat[1];
			
			$sql4= " select desc_item  from items  where cod_item='".$cod_item."'";
			$desc_item="";
			$resp4=mysql_query($sql4);
			while ($dat4=mysql_fetch_array($resp4)){
		
				$desc_item=$dat4[0];
			}
			
			$descripcion_item=$dat[2];
			$descripcion_item=str_replace("|",",",$descripcion_item);
			$cantidad_unitariacotizacion=$dat[3];
			$cantidad_unitariacotizacionefectuada=$dat[4];
			$cod_estado_detallecotizacionitem=$dat[5];
			$precio_venta=$dat[6];
			$descuento=$dat[7];
			$importe_total=$dat[8];
			$orden=$dat[9];
			
			$pdf->SetFont('Arial','',7);
			$pdf->Line(12,$val_aux_coordenadaY,207,$val_aux_coordenadaY);
			
			$pdf->SetX(12);
			$pdf->Cell(9,4,$contador,0,0,'L',false);
			$pdf->SetX(21);
			
			$pdf->Cell(16,4,$cantidad_unitariacotizacion,0,0,'R',false);


			$pdf->SetX($valorX+135);
			if($considerar_precio_unitario==1){
			
				$precio_venta_formato=number_format($precio_venta,2);		
				$pdf->Cell(15,4,$precio_venta_formato,0,0,'R',false);
				$pdf->Cell(20,4,"",0,0,'R',false);
				$pdf->SetFont('Arial','',7);
				$pdf->Cell(15,4,$tot_cant_notas_remision_item,0,0,'R',false);
				$pdf->Cell(10,4,"",0,0,'R',false);
				$pdf->SetFont('Arial','',7);
				$precio_unitario_formato=number_format($cantidad_unitariacotizacion*$precio_venta,2);				
				$pdf->Cell(20,4,$precio_unitario_formato,0,0,'R',false);
				$suma=$suma+($cantidad_unitariacotizacion*$precio_venta);
				
			}else{
			
				$pdf->Cell(35,4,"",0,0,'R',false);
				$pdf->SetFont('Arial','',7);
				$pdf->Cell(15,4,$tot_cant_notas_remision_item,0,0,'R',false);
				$pdf->Cell(5,4,"",0,0,'R',false);
				$pdf->SetFont('Arial','',7);
				$importe_total_formato=number_format($importe_total,2);
				$pdf->Cell(20,4,$importe_total_formato,0,0,'R',false);
				
				$suma=$suma+($importe_total);
			}
			
			$pdf->SetFont('Arial','B',7);
			$pdf->SetX(50);		
			$pdf->MultiCell(85,4,utf8_decode($desc_item)." ".utf8_decode($descripcion_item),0,'L',false);

			
			$sql7=" select count(DISTINCT(cod_compitem))as cant_comp ";
			$sql7.=" from cotizacion_detalle_caracteristica";
			$sql7.=" where cod_cotizaciondetalle='".$cod_cotizaciondetalle."' and cod_cotizacion='".$cod_cotizacion."'";
			$resp7=mysql_query($sql7);
			$cant_comp=0;
			while ($dat7=mysql_fetch_array($resp7)){
				$cant_comp=$dat7[0];	
			}
			
			$detalle_item="";
			$sql2=" select  distinct(cod_compitem) as cod_compitem  from cotizacion_detalle_caracteristica ";
			$sql2.=" where cod_cotizaciondetalle='".$cod_cotizaciondetalle."' and cod_cotizacion='".$cod_cotizacion."'";
			
			$resp2=mysql_query($sql2);
			while ($dat2=mysql_fetch_array($resp2)){
		
				$cod_compitem=$dat2[0];
				
				$sql4=" select  count(*) from cotizacion_detalle_caracteristica ";
				$sql4.=" where cod_cotizaciondetalle='".$cod_cotizaciondetalle."' and cod_cotizacion='".$cod_cotizacion."'";
				$sql4.=" and cod_compitem='".$cod_compitem."' and cod_estado_registro=1";
				$resp4=mysql_query($sql4);
				$nro_carac=0;
				while($dat4=mysql_fetch_array($resp4)){
					$nro_carac=$dat4[0];
				}
				
				if($nro_carac>0){
				/***************************************************************/
								
				$nombre_componenteitem="";
				$sql5=" select nombre_componenteitem from componente_items where cod_compitem='".$cod_compitem."'";
				$resp5=mysql_query($sql5);
				while ($dat5=mysql_fetch_array($resp5)){
					$nombre_componenteitem=$dat5[0];	
				}
				if($cant_comp>1){
					$pdf->SetFont('Arial','B',7);
					$pdf->SetX(51);
					$pdf->Cell(0,4,utf8_decode($nombre_componenteitem),0,1,'L',false);
				}
						
				/**********************************/
				$sql3=" select  cod_carac, desc_carac, cod_estado_registro ";
				$sql3.=" from cotizacion_detalle_caracteristica ";
				$sql3.=" where cod_cotizaciondetalle='".$cod_cotizaciondetalle."'";
				$sql3.=" and cod_cotizacion='".$cod_cotizacion."'";
				$sql3.=" and cod_compitem='".$cod_compitem."'";
				$sql3.=" and cod_estado_registro=1 order by orden asc";
				$resp3=mysql_query($sql3);
				$carac="";
				while ($dat3=mysql_fetch_array($resp3)){
						
						$cod_carac=$dat3[0];
						
						/*************************/
						$desc_caracT="";
						$sql5=" select desc_carac from caracteristicas where cod_carac='".$cod_carac."'";
						$resp5=mysql_query($sql5);
						while ($dat5=mysql_fetch_array($resp5)){
							$desc_caracT=$dat5[0];	
						}
						/*************************/

						$desc_carac=$dat3[1];
						$desc_carac=str_replace("|",",",$desc_carac);
						$cod_estado_registro=$dat3[2];
						$carac=$carac.$desc_caracT.": ".$desc_carac.";";
						
						//$pdf->SetFont('Arial','',7);
						//$pdf->SetX(52);
						//$pdf->Cell(0,4,utf8_decode($desc_caracT).": ".utf8_decode($desc_carac),0,1,'L',false);					
				}
				/***************************************************************/
						$pdf->SetFont('Arial','',7);
						$pdf->SetX(52);
						//$pdf->Cell(0,4,utf8_decode($desc_caracT).": ".utf8_decode($desc_carac),0,1,'L',false);	
						$pdf->SetFont('Arial','',7);
						$pdf->SetX(52);		
						$pdf->MultiCell(120,4,$carac,0,'L',false);
						
				}
					
								
			}
			$pdf->SetFont('Arial','I',7);
			$pdf->MultiCell(193,4,$notas_remision_item,0,'J',false);
			
			//$pdf->SetX(12);
			//$pdf->Cell(0,4,$notas_remision_item,0,1,'L',false);
	
}
$sw=1;
		/*********************************FIN CUERPO DE COTIZACION***************************************/
		
	$monto_hojaruta=0;
	$sqlAux=" select sum(cd.IMPORTE_TOTAL) ";
	$sqlAux.=" from hojas_rutas_detalle hrd, cotizaciones_detalle cd ";
	$sqlAux.=" where hrd.cod_hoja_ruta=".$cod_hoja_ruta;
	$sqlAux.=" and hrd.cod_cotizacion=cd.cod_cotizacion ";
	$sqlAux.=" and hrd.cod_cotizaciondetalle=cd.cod_cotizaciondetalle ";	
	$respAux = mysql_query($sqlAux);
	while($datAux=mysql_fetch_array($respAux)){
		$monto_hojaruta=$datAux[0];
	}
									
	$descuento_cotizacion=0;
	$sql=" select  descuento_cotizacion, descuento_fecha, descuento_obs ";
	$sql.=" from cotizaciones ";
	$sql.=" where  cod_cotizacion='".$cod_cotizacion."'";
	$resp=mysql_query($sql);
	while ($dat=mysql_fetch_array($resp)){

		$descuento_cotizacion=$dat['descuento_cotizacion'];
		$descuento_fecha=$dat['descuento_fecha'];
		$descuento_obs =$dat['descuento_obs'];
	}
	
	$incremento_cotizacion=0;
	$sql=" select  incremento_cotizacion, incremento_fecha, incremento_obs ";
	$sql.=" from cotizaciones ";
	$sql.=" where  cod_cotizacion='".$cod_cotizacion."'";
	$resp=mysql_query($sql);
	while ($dat=mysql_fetch_array($resp)){

		$incremento_cotizacion=$dat['incremento_cotizacion'];
		$incremento_fecha=$dat['incremento_fecha'];
		$incremento_obs=$dat['incremento_obs'];
	}
		
	$pdf->SetFont('Arial','B',6);
	$pdf->SetX(135);
	$pdf->Cell(35,4,"",0,0,'R',false);
	$pdf->Cell(15,4,"",0,0,'R',false);
	$pdf->Cell(5,4,"SUBTOTAL:",0,0,'R',false);		
	$pdf->Cell(20,4,number_format($monto_hojaruta,2),0,1,'R',false);
	$pdf->SetX(12);
	//$pdf->Cell(35,4,"",0,0,'R',false);
	//$pdf->Cell(15,4,"",0,0,'R',false);
	if($incremento_cotizacion>0){
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(5,4,"(".strftime("%d/%m/%Y",strtotime($incremento_fecha)).") ".$incremento_obs,0,0,'L',false);
	}
	$pdf->SetX(185);
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(5,4,"INCREMENTO:",0,0,'R',false);	
	$pdf->Cell(20,4,number_format($incremento_cotizacion,2),0,1,'R',false);	
	$pdf->SetX(135);
	$pdf->SetX(12);
	if($descuento_cotizacion>0){
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(0,4,"(".strftime("%d/%m/%Y",strtotime($descuento_fecha)).") ".$descuento_obs,0,0,'L',false);
	}
	$pdf->SetX(185);	
	$pdf->Cell(5,4,"DESCUENTO:",0,0,'R',false);	
	$pdf->Cell(20,4,number_format($descuento_cotizacion,2),0,1,'R',false);		
	$pdf->SetX(135);
	$pdf->Cell(35,4,"",0,0,'R',false);
	$pdf->Cell(15,4,"",0,0,'R',false);
	$pdf->Cell(5,4,"**TOTAL**:",0,0,'R',false);	
	$pdf->Cell(20,4,number_format((($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion),2),1,1,'R',false);		
		
	///////////////////ACUENTA///////////////
	$sql2=" select pd.cod_moneda, pd.monto_pago_detalle, p.fecha_pago ";
			 	$sql2.=" from pagos_detalle pd, pagos p";
			 	$sql2.=" where pd.cod_pago=p.cod_pago";
			 	$sql2.=" and p.cod_estado_pago<>2";
			 	$sql2.=" and pd.codigo_doc=".$cod_hoja_ruta;
				$sql2.=" and pd.cod_tipo_doc=1";
				$resp2 = mysql_query($sql2);
				$acuenta_hojaruta=0;
				while($dat2=mysql_fetch_array($resp2)){
					//$cod_moneda=$dat2['cod_moneda'];
					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					$fecha_pago=$dat2['fecha_pago'];
					//if($cod_moneda==1){
						$acuenta_hojaruta=$acuenta_hojaruta+$monto_pago_detalle;
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
								$acuenta_hojaruta=$acuenta_hojaruta+($monto_pago_detalle*$cambio_bs);
							
							}
						
					}*/
				}				
			 
	///////////////FIN A CUENTA/////////////////////

	$pdf->SetX(135);
	$pdf->Cell(35,4,"",0,0,'R',false);
	$pdf->Cell(15,4,"",0,0,'R',false);
	$pdf->Cell(5,4,"**A CUENTA**:",0,0,'R',false);	
	$pdf->Cell(20,4,number_format(($acuenta_hojaruta),2),0,1,'R',false);
	$pdf->SetX(135);
	$pdf->Cell(35,4,"",0,0,'R',false);
	$pdf->Cell(15,4,"",0,0,'R',false);
	$pdf->Cell(5,4,"**SALDO**:",0,0,'R',false);	
	$pdf->Cell(20,4,number_format(((($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion)-($acuenta_hojaruta)),2),0,1,'R',false);	
	
	//////////////////////////DETALLE DE PAGOS////////////////////////
		$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);	
	$pdf->SetX(12);
	$pdf->Cell(195,6,"DETALLE DE PAGOS",1,1,'C',false);	
			
	$pdf->SetFont('Arial','B',7);
	$pdf->SetX(12);
	$pdf->Cell(12,4,"Nro Cbte",1,0,'C',false);
	$pdf->SetX(24);
	$pdf->Cell(14,4,"Fecha Cbte",1,0,'C',false);
	$pdf->SetX(38);
	$pdf->Cell(13,4,"Nro Pago",1,0,'C',false);
	$pdf->SetX(51);
	$pdf->Cell(15,4,"Fecha Pago",1,0,'C',false);
	$pdf->SetX(66);	
	$pdf->Cell(25,4,"Forma Pago",1,0,'C',false);
	$pdf->SetX(91);	
	$pdf->Cell(68,4,"Observacion",1,0,'C',false);	
	$pdf->SetX(159);
	$pdf->Cell(18,4,"Monto Pago",1,0,'C',false);
	$pdf->SetX(177);
	$pdf->Cell(10,4,"Cambio",1,0,'C',false);	
	$pdf->SetX(187);
	$pdf->Cell(20,4,"Monto Bs",1,1,'C',false);	
	
	$acuenta_hojaruta=0;
	$sqlAux=" select p.nro_pago, p.cod_gestion, g.gestion,  pd.cod_moneda, pd.monto_pago_detalle, p.fecha_pago, p.obs_pago, "; 
	$sqlAux.=" pd.nro_comprobante, pd.fecha_comprobante, pd.cod_forma_pago,";
	$sqlAux.=" pd.cod_banco,pd.cod_moneda";
	$sqlAux.=" from pagos_detalle pd, pagos p, gestiones g ";
	$sqlAux.=" where pd.cod_pago=p.cod_pago ";
	$sqlAux.=" and p.cod_gestion=g.cod_gestion ";
//	$sqlAux.=" and pd.cod_forma_pago=fp.cod_forma_pago ";
//	$sqlAux.=" and pd.cod_moneda=m.cod_moneda ";
	$sqlAux.=" and p.cod_estado_pago<>2 ";
	$sqlAux.=" and pd.codigo_doc=".$cod_hoja_ruta;
	$sqlAux.=" and pd.cod_tipo_doc=1";
	$sqlAux.=" order by  pd.fecha_comprobante desc, pd.nro_comprobante desc  ";
	$respAux = mysql_query($sqlAux);
	while($datAux=mysql_fetch_array($respAux)){
		$nro_pago=$datAux['nro_pago'];
		$cod_gestion=$datAux['cod_gestion'];
		$gestion=$datAux['gestion'];
		$cod_moneda=$datAux['cod_moneda'];
		$monto_pago_detalle=$datAux['monto_pago_detalle'];
		$fecha_pago=$datAux['fecha_pago'];
		$obs_pago=$datAux['obs_pago'];
		$nro_comprobante=$datAux['nro_comprobante'];
		$fecha_comprobante=$datAux['fecha_comprobante'];
		$cod_forma_pago=$datAux['cod_forma_pago'];
		//$desc_forma_pago=$datAux['desc_forma_pago'];
		$cod_banco=$datAux['cod_banco'];
		//$cod_moneda=$datAux['cod_moneda'];
		$abrev_moneda=$datAux['abrev_moneda'];	
					$cambio_bs=1;
					//if($cod_moneda==1){
						$acuenta_hojaruta=$acuenta_hojaruta+$monto_pago_detalle;
					/*}else{
							$sql3="select cambio_bs from tipo_cambio";
							$sql3.=" where fecha_tipo_cambio='".$fecha_pago."'";
							$sql3.=" and cod_moneda=".$cod_moneda;
							$resp3 = mysql_query($sql3);
							$cambio_bs=1;
							while($dat3=mysql_fetch_array($resp3)){
								$cambio_bs=$dat3['cambio_bs'];
							}
							$acuenta_hojaruta=$acuenta_hojaruta+($monto_pago_detalle*$cambio_bs);

					}*/
							
		
			$pdf->SetFont('Arial','',6);
			$pdf->SetX(12);
			$pdf->Cell(12,4,$nro_comprobante,1,0,'R',false);
			$pdf->SetX(24);
			$pdf->Cell(14,4,strftime("%d/%m/%Y",strtotime($fecha_comprobante)),1,0,'R',false);
			$pdf->SetX(38);
			$pdf->Cell(13,4,$nro_pago."/".$gestion,1,0,'R',false);			
			$pdf->SetX(51);
			$pdf->Cell(15,4,strftime("%d/%m/%Y",strtotime($fecha_pago)),1,0,'R',false);
			$pdf->SetX(66);			
			$pdf->Cell(25,4,$desc_forma_pago,1,0,'R',false);
			$pdf->SetX(91);	
			$pdf->Cell(68,4,$obs_pago,1,0,'L',false);
			$pdf->SetX(159);
			
			$pdf->Cell(18,4,number_format($monto_pago_detalle*$cambio_bs,2)." ".$abrev_moneda,1,0,'R',false);
			$pdf->SetX(177);
			if($cod_moneda==1){
				$pdf->Cell(10,4,"",1,0,'C',false);	
			}else{
				$pdf->Cell(10,4,$cambio_bs,1,0,'C',false);
			}
			$pdf->SetX(187);
			$pdf->Cell(20,4,number_format($monto_pago_detalle*$cambio_bs,2)." Bs.",1,1,'R',false);	
			
	}	
	$pdf->SetFont('Arial','B',6);
	$pdf->SetX(12);
	$pdf->Cell(175,4,"TOTAL A CUENTA",1,0,'R',false);	
	$pdf->SetX(187);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(20,4,number_format($acuenta_hojaruta,2)." Bs.",1,1,'R',false);	

	/////////////////////////FIN DETALLE DE PAGOS///////////////////////
	
	//////////////////////SALIDAS DE ALMACEN/////////////////
	$pdf->Ln();
		$pdf->SetFont('Arial','B',10);	
	$pdf->SetX(12);
	$pdf->Cell(195,6,"COSTOS DE MATERIAL",1,1,'C',false);		
	
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
	$sqlAux.=" and s.cod_hoja_ruta=".$cod_hoja_ruta;
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

	
	}
	$pdf->SetFont('Arial','B',6);	
	$pdf->SetX(12);
	$pdf->Cell(180,4,"TOTAL MATERIAL",1,0,'R',false);	
	$pdf->SetX(192);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(15,4,number_format($costoTotalSalidas,2)." Bs",1,1,'R',false);
	//////////////////////FIN SALIDAS DE ALMACEN///////////////////////

	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);	
	$pdf->SetX(12);
	$pdf->Cell(195,6,"COSTOS INTERNOS",1,1,'C',false);			
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
		$sqlAux=" select ghr.cod_gasto_hojaruta, ghr.cod_gasto, g.desc_gasto, ghr.cod_hoja_ruta,";
		$sqlAux.=" ghr.fecha_gasto, ghr.monto_gasto, ghr.cant_gasto, ghr.descripcion_gasto,ghr.cod_proveedor, ";
		$sqlAux.=" p.nombre_proveedor, ghr.recibo_gasto, ghr.cod_usuario_registro, ";
		$sqlAux.=" ghr.fecha_registro, ghr.cod_usuario_modifica, ghr.fecha_modifica";
		$sqlAux.=" from gastos_hojasrutas ghr, proveedores p, gastos g";
		$sqlAux.=" where ghr.cod_proveedor=p.cod_proveedor";
		$sqlAux.=" and ghr.cod_gasto=g.cod_gasto";
		$sqlAux.=" and ghr.cod_hoja_ruta=".$_GET['cod_hoja_ruta'];
		$sqlAux.=" order by ghr.fecha_gasto desc ";
		$respAux = mysql_query($sqlAux);
		while($datAux=mysql_fetch_array($respAux)){
		
				$cod_gasto_hojaruta=$datAux['cod_gasto_hojaruta'];
				$cod_gasto=$datAux['cod_gasto']; 
				$desc_gasto=$datAux['desc_gasto'];
				$cod_hoja_ruta=$datAux['cod_hoja_ruta']; 
				$fecha_gasto=$datAux['fecha_gasto'];
				$monto_gasto=$datAux['monto_gasto'];
				$cant_gasto=$datAux['cant_gasto'];
				$descripcion_gasto=$datAux['descripcion_gasto'];
				$cod_proveedor=$datAux['cod_proveedor']; 
				$nombre_proveedor=$datAux['nombre_proveedor']; 
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
	$pdf->Cell(180,4,"TOTAL COSTOS INTERNOS",1,0,'R',false);	
	$pdf->SetX(192);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(15,4,number_format($gastosExtras,2)." Bs",1,1,'R',false);
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
					

	////////////COSTOS EXTRAS/////////////
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
	$sqlAux.=" and  gg.cod_tipo_doc=1 ";
	$sqlAux.=" and  gg.codigo_doc=".$_GET['cod_hoja_ruta'];
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
	
	$monto_real_hr=($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion;
	$ingreso_esperado=$monto_real_hr-($costoTotalSalidas+$gastosExtras+$costosExternos);
	$ingreso_en_contra=$acuenta_hojaruta-$ingreso_esperado;
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
	$pdf->Cell(180,4,"INGRESO  A FAVOR",0,0,'R',false);	
	$pdf->SetX(192);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(15,4,number_format($ingreso_a_favor,2)." Bs",1,1,'R',false);	

 	$pdf->ln();
 	$pdf->SetFont('Arial','B',6);	
	$pdf->SetX(12);
	$pdf->Cell(180,4,"INGRESO EN CONTRA",0,0,'R',false);	
	$pdf->SetX(192);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(15,4,number_format($ingreso_en_contra,2)." Bs",1,1,'R',false);	
	*/
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(216,5,"Fecha Revision:".date('d/m/y', time()),0,0,'C',false);
 
	$pdf->Output();


require("cerrar_conexion.inc");
?>


