<?php
require("conexion1.inc");
require("fpdf.php");

class PDF extends FPDF
{


//Cabecera de página
	function Header()
	{	
		
		$cod_hoja_ruta=$_GET['cod_hoja_ruta'];
		$sql5="select  valor_x, valor_y from coordenadas_impresion where cod_coordenada=1";
		$resp5=mysql_query($sql5);
		while ($dat5=mysql_fetch_array($resp5)){
			$valorX=$dat5[0];
			$valorY=$dat5[1];
		}


	$sql=" select  cod_gestion, nro_hoja_ruta, fecha_hoja_ruta, cod_usuario_hoja_ruta, ";
	$sql.=" obs_hoja_ruta, cod_cotizacion, cod_estado_hoja_ruta, factura_si_no, cod_usuario_comision, cod_tipo_pago ";
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
		$cod_tipo_pago=$dat[9]; 
		if($cod_usuario_comision<>0){
			$sql2="select nombres_usuario,ap_paterno_usuario from usuarios  where cod_usuario='".$cod_usuario_comision."'";	
			$resp2= mysql_query($sql2);
			$dat2=mysql_fetch_array($resp2);
			$nombres_usuario=$dat2[0];
			$ap_paterno_usuario=$dat2[1];

			$usuarioComision=$cod_usuario_comision." ".$nombres_usuario[0].$ap_paterno_usuario[0];		
		}

			$sql2="select nombre_tipo_pago from tipos_pago  where cod_tipo_pago='".$cod_tipo_pago."'";	
			$resp2= mysql_query($sql2);
			while($dat2=mysql_fetch_array($resp2)){;
				$nombre_tipo_pago=$dat2['nombre_tipo_pago'];
			}

	
	}

	$sql=" select nro_cotizacion, cod_cliente, fecha_cotizacion, cod_gestion ";
	$sql.=" from cotizaciones ";
	$sql.=" where  cod_cotizacion='".$cod_cotizacion."'";
	$resp=mysql_query($sql);
	while ($dat=mysql_fetch_array($resp)){

		$nro_cotizacion=$dat[0];
		$cod_cliente=$dat[1];
		$fecha_cotizacion=$dat[2];
		$cod_gestion=$dat[3];
		
		$fechaCotizacionVecto=explode(" ",$fecha_cotizacion);
		$fechaCotizacionVectoAux=explode("-",$fechaCotizacionVecto[0]);	
		
		$sql5="select gestion from gestiones where cod_gestion='".$cod_gestion."'";
		$resp5=mysql_query($sql5);
		while ($dat5=mysql_fetch_array($resp5)){
			$gestionCotizacion=$dat5[0];
		}			

		$sql2=" select nombre_cliente, telefono_cliente, celular_cliente, fax_cliente";
		$sql2.=" from clientes where cod_cliente='".$cod_cliente."'";
		$resp2=mysql_query($sql2);
		while ($dat2=mysql_fetch_array($resp2)){
				$nombre_cliente=$dat2[0];		
				$telefono_cliente=$dat2[1];
				$celular_cliente=$dat2[2];
				$fax_cliente=$dat2[3];
		}

	}
		/**********************Fin Datos de Cliente******************************/	

	/*****************************NOTAS DE REMISION***********************************/
		$sql2="select count(*) from notas_remision where cod_hoja_ruta='".$cod_hoja_ruta."'";
		$sql2.=" and cod_estado_nota_remision=1";
		$resp2=mysql_query($sql2);
		$numeroNotasRemision=0;
		while ($dat2=mysql_fetch_array($resp2)){
				$numeroNotasRemision=$dat2[0];	
		}
		
		$sql2=" select nr.cod_nota_remision, nr.nro_nota_remision, nr.cod_gestion, g.gestion ";
		$sql2.=" from notas_remision nr, gestiones g ";
		$sql2.=" where nr.cod_gestion=g.cod_gestion ";
		$sql2.=" and nr.cod_hoja_ruta='".$cod_hoja_ruta."' ";
		$sql2.=" and nr.cod_estado_nota_remision=1";
		$resp2=mysql_query($sql2);
		$notasRemision="";
		while ($dat2=mysql_fetch_array($resp2)){
				$cod_nota_remision=$dat2['cod_nota_remision'];	
				$nro_nota_remision=$dat2['nro_nota_remision'];
				$cod_gestion=$dat2['cod_gestion'];
				$gestion=$dat2['gestion'];
				$notasRemision=$notasRemision.$nro_nota_remision."/".$gestion."; ";
		}
	/***************************FIN NOTAS DE REMISION*************************************/
	/*****************************FACTURAS***********************************/
		$sql2=" select count(*) ";
		$sql2.=" from facturas ";
		$sql2.=" where cod_factura in( select cod_factura from factura_hojaruta where cod_hoja_ruta='".$cod_hoja_ruta."')";
		$sql2.=" and cod_est_fac=1";				
		$resp2=mysql_query($sql2);
		$numeroFacturas=0;
		while ($dat2=mysql_fetch_array($resp2)){
				$numeroFacturas=$dat2[0];	
		}
		
		$sql2=" select nro_factura ";
		$sql2.=" from facturas ";
		$sql2.=" where cod_factura in( select cod_factura from factura_hojaruta where cod_hoja_ruta='".$cod_hoja_ruta."')";
		$sql2.=" and cod_est_fac=1";
		$resp2=mysql_query($sql2);
		$facturas="";
		while ($dat2=mysql_fetch_array($resp2)){
				$nro_factura=$dat2['nro_factura'];	
				$facturas=$facturas.$nro_factura."; ";
		}
	/***************************FIN FACTURAS*************************************/	
			$this->SetFont('Arial','B',13);
			//$this->SetTextColor(0,0,0);
			//$this->SetXY($valorX,$valorY+15);
			//$this->Cell(0,6,"HOJA DE RUTA",0,1,'C',false);
			$this->SetTextColor(0,0,0);	
			$this->SetXY($valorX,$valorY+21);
			$this->Cell(0,6,"No. ".$nro_hoja_ruta." / ".$gestionHojaRuta,0,1,'C',false);
			$this->SetXY($valorX,$valorY+27);
			$this->Cell(0,6,$fechaHojaRutaVectoAux[2]."/".$fechaHojaRutaVectoAux[1]."/".$fechaHojaRutaVectoAux[0],0,1,'C',false);
								
			$this->SetFont('Arial','B',9);
			$this->SetTextColor(0,0,0);		
			$this->SetXY($valorX+160,$valorY+22);
    	    $this->Cell(0,4,'Página '.$this->PageNo().' de '.' {nb}',0,1,'R',false);

			$this->SetFont('Arial','B',9);
			$this->SetTextColor(0,0,0);				
			$this->Text($valorX+16,$valorY+38,"CLIENTE:");
			$this->Text($valorX+33,$valorY+38,$nombre_cliente);	
			
			$this->Text($valorX+178,$valorY+38,"REF");
			$this->Text($valorX+193,$valorY+38,"C");
			
			$this->Text($valorX+16,$valorY+43,"TELF. :");
			$this->Text($valorX+33,$valorY+43,$telefono_cliente);
			$this->Text($valorX+85,$valorY+43,"CEL. :");
			$this->Text($valorX+95,$valorY+43,$celular_cliente);
			$this->Text($valorX+133,$valorY+43,"FAX. :");
			$this->Text($valorX+143,$valorY+43,$fax_cliente);		
			
			
			$this->Text($valorX+175,$valorY+43,$nro_cotizacion."/".$gestionCotizacion);
			$this->Text($valorX+193,$valorY+43,$factura_si_no);
			
			$this->Text($valorX+16,$valorY+48,"OBS. :");
			$this->Text($valorX+33,$valorY+48,$obs_hoja_ruta);
			
			$this->Text($valorX+16,$valorY+53,"APROBADO POR :");
			$this->Text($valorX+46,$valorY+53,$usuarioHojaRuta);
			if($cod_usuario_comision<>0){
				$this->Text($valorX+132,$valorY+53,"C3 :");
				$this->Text($valorX+138,$valorY+53,$usuarioComision);
			}
			$this->Text($valorX+145,$valorY+53,"TIPO PAGO:");
			$this->Text($valorX+165,$valorY+53,$nombre_tipo_pago);
				
			if($numeroNotasRemision>0){
				$this->setXY(15,60);
				$this->MultiCell(0,4, "NOTAS REMISION : Nro.".$notasRemision, 0, 'L',false);
				//$this->Text($valorX+16,$valorY+63,"NOTAS REMISION :");
				//$this->Text($valorX+46,$valorY+63,"Nro. ".$notasRemision);
			}
			if($numeroFacturas>0){
				$this->Text($valorX+16,$valorY+71,"FACTURAS :");
				$this->Text($valorX+46,$valorY+71,"Nro. ".$facturas);
				//$y=$this->GetY();
				//$this->setXY(15,$y);
				//$this->MultiCell(0,4, "FACTURAS: Nro.".$facturas, 0, 'L',false);
			}

			$this->SetFont('Arial','B',11);
			$this->SetTextColor(0,0,0);		
		//	$y=$this->GetY();		
			$this->SetXY($valorX+16,73);			
			$this->Cell(184,5,"DETALLE",1,1,'C',false);		
			
		/************************FIN DATOS DE CABECERA*************************************/		
	}

	//Pie de página
	function Footer()
	{	
		
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		
	}
}
	$pdf=new PDF('P','mm',array(214,279));
	//$pdf->SetAutoPageBreak(true,15);		
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$cod_hoja_ruta=$_GET['cod_hoja_ruta'];
	$sql5="select  valor_x, valor_y from coordenadas_impresion where cod_coordenada=1";
	$resp5=mysql_query($sql5);
	while ($dat5=mysql_fetch_array($resp5)){
		$valorX=$dat5[0];
		$valorY=$dat5[1];
	}

	$sql=" select  fecha_hoja_ruta, cod_usuario_hoja_ruta, ";
	$sql.=" obs_hoja_ruta, cod_cotizacion, cod_estado_hoja_ruta ";
	$sql.=" from hojas_rutas ";
	$sql.=" where  cod_hoja_ruta='".$cod_hoja_ruta."'";
	$resp=mysql_query($sql);
	while ($dat=mysql_fetch_array($resp)){
		$fecha_hoja_ruta=$dat[0];
		/********************************/
		$fechaHojaRutaVecto=explode(" ",$fecha_hoja_ruta);
		$fechaHojaRutaVectoAux=explode("-",$fechaHojaRutaVecto[0]);	
		/********************************/	
		$cod_usuario_hoja_ruta=$dat[1];
		$sql2="select nombres_usuario,ap_paterno_usuario from usuarios  where cod_usuario='".$cod_usuario_hoja_ruta."'";	
		$resp2= mysql_query($sql2);
		$dat2=mysql_fetch_array($resp2);
		$usuarioHojaRuta=$dat2[0]." ".$dat2[1]." ".$dat2[2];

		$obs_hoja_ruta=$dat[2];
		$cod_cotizacion=$dat[3];
		$cod_estado_hoja_ruta=$dat[4];
	}


		
/*********************************CUERPO DE COTIZACION****************************************/
		$cont=0;
		$sql=" select cod_cotizaciondetalle,  cod_item, descripcion_item, ";
		$sql.=" cantidad_unitariacotizacion, cantidad_unitariacotizacionefectuada, ";
		$sql.=" cod_estado_detallecotizacionitem,precio_venta, descuento, importe_total, orden ";
		$sql.=" from cotizaciones_detalle ";
		$sql.=" where  cod_cotizacion='".$cod_cotizacion."'";
		$sql.=" and cod_cotizaciondetalle in (select cod_cotizaciondetalle from hojas_rutas_detalle where cod_hoja_ruta='".$cod_hoja_ruta."')";
		$sql.=" order by cod_cotizaciondetalle asc";
		$resp=mysql_query($sql);
		$suma=0;

		$val_aux_coordenadaY=0;
		$numeroItem=0;
		while ($dat=mysql_fetch_array($resp)){
			$numeroItem=$numeroItem+1;
			$val_aux_coordenadaY=$pdf->GetY();
			
			$cod_cotizaciondetalle=$dat[0];
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
			$auxY_1=$pdf->GetY();						
			//$pdf->Line(16, $pdf->GetY(), 199,$pdf->GetY());
			$pdf->SetFont('Arial','B',9);			
			$pdf->SetXY($valorX+16,$valorY+$val_aux_coordenadaY);
			$pdf->Cell(184,5,"ITEM ".$numeroItem,1,1,'C',false);	
			$pdf->SetX($valorX+16);	
			$pdf->Cell(20,5,$cantidad_unitariacotizacion,0,0,'R',false);
			$pdf->MultiCell(164,5,utf8_decode($desc_item)." ".utf8_decode($descripcion_item),0,'L',false);
			$auxY=$pdf->GetY();
			$pagina_actual=$pdf->PageNo();			
			if($auxY>$auxY_1){
				//$pdf->Line(16,$auxY_1,16,$auxY);

			}else{
				$pdf->PageNo($pagina_actual-1);
			//	$pdf->Line(16,59,16,224);				
				$pdf->PageNo($pagina_actual);				
			}			
			$val_aux_coordenadaY=$pdf->GetY();
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
					$pdf->SetFont('Arial','B',9);
					$pdf->SetX($valorx+16);
					$pdf->Cell(184,5,utf8_decode($nombre_componenteitem),'',1,'L',false);
				}
						
				/**********************************/
				$sql3=" select  cod_carac, desc_carac, cod_estado_registro ";
				$sql3.=" from cotizacion_detalle_caracteristica ";
				$sql3.=" where cod_cotizaciondetalle='".$cod_cotizaciondetalle."'";
				$sql3.=" and cod_cotizacion='".$cod_cotizacion."'";
				$sql3.=" and cod_compitem='".$cod_compitem."'";
				$sql3.=" and cod_estado_registro=1 order by orden asc";
				$resp3=mysql_query($sql3);
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
						
						$pdf->SetFont('Arial','',9);
						$pdf->SetX($valorX+16);
						$pdf->Cell(184,5,utf8_decode($desc_caracT).": ".utf8_decode($desc_carac),'',1,'L',false);
				}
				/***************************************************************/
				}
			}
			/************************DETALLE HOJA RUTA****************************/
				$sql8=" select cod_usuario_diseno, obs_trabajo, diseno, diseno_aprobacion, placas, cantidad_cpt ";
				$sql8.=" from hojas_rutas_detalle ";
				$sql8.=" where  cod_hoja_ruta='".$cod_hoja_ruta."'";
				$sql8.=" and  cod_cotizacion='".$cod_cotizacion."'";
				$sql8.=" and cod_cotizaciondetalle='".$cod_cotizaciondetalle."'";
				$resp8=mysql_query($sql8);			
				$cod_usuario_diseno=0;
				$obs_trabajo="";
				$diseno="";
				$diseno_aprobacion=""; 
				$placas="";
				$cantidad_cpt="";
				while ($dat8=mysql_fetch_array($resp8)){
					$cod_usuario_diseno=$dat8[0];
					$obs_trabajo=$dat8[1];
					$diseno=$dat8[2];
					$diseno_aprobacion=$dat8[3]; 
					$placas=$dat8[4];
					$cantidad_cpt=$dat8[5];					
					$usuarioDiseno="";
					
					$sql2="select nombres_usuario,ap_paterno_usuario from usuarios ";
					$sql2.=" where cod_usuario='".$cod_usuario_diseno."'";	
					$resp2= mysql_query($sql2);
					$dat2=mysql_fetch_array($resp2);
					$usuarioDiseno=$dat2[0]." ".$dat2[1]." ".$dat2[2];
				
					$prensa="";

					if($diseno==1){$diseno="Inventa ";}
					if($diseno==2){$diseno="Cliente ";}
					if($diseno_aprobacion==1){$diseno_aprobacion="Inventa";}
					if($diseno_aprobacion==2){$diseno_aprobacion="Cliente";}
					if($placas==1){$placas="CPT"; }
					if($placas==2){$placas="CONVENC";  }					
					
					$sql4=" select cod_maquina from hojas_rutas_detalle_maquinaria ";
					$sql4.=" where cod_cotizacion='".$cod_cotizacion."'"; 
					$sql4.=" and cod_cotizaciondetalle='".$cod_cotizaciondetalle."'";
					$sql4.=" and cod_hoja_ruta='".$cod_hoja_ruta."'";
					$resp4=mysql_query($sql4);
					while($dat4=mysql_fetch_array($resp4))
					{
						$cod_maquina=$dat4[0];
						$desc_maquina="";
						$sql5="select desc_maquina from maquinaria where cod_maquina='".$cod_maquina."'";
						$resp5=mysql_query($sql5);
						while($dat5=mysql_fetch_array($resp5))
						{
							$desc_maquina=$dat5[0];
							$prensa=$prensa.$desc_maquina.";";
						}												
					}
			
				}				
						
			/************************FIN DETALLE HOJA RUTA****************************/
			$pdf->SetFont('Arial','B',9);
			$pdf->SetX(16);
			$pdf->Cell(184,5,"TRABAJO",'',1,'C',false);			
			$pdf->SetFont('Arial','B',9);
			$pdf->SetX(16);
			$pdf->Cell(19,4,"Asignado a:",'',0,'L',false);
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(50,4,$usuarioDiseno,0,0,'L',false);
			$pdf->SetX(82);
			$pdf->SetFont('Arial','B',9);	
			$pdf->Cell(13,4,"Diseno:",0,0,'',false);
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(16,4,$diseno,0,0,'L',false);	
			$pdf->SetX(112);
			$pdf->SetFont('Arial','B',9);	
			$pdf->Cell(23,4,"Aprobado por:",0,0,'',false);
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(14,4,$diseno_aprobacion,0,0,'L',false);	
			
			$pdf->SetX(152);
			$pdf->SetFont('Arial','B',9);	
			$pdf->Cell(12,4,"Placas:",0,0,'',false);
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(14,4,$placas,0,0,'L',false);	
			
			if($cantidad_cpt!=""){
			
				$pdf->SetX(182);
				$pdf->SetFont('Arial','B',9);	
				$pdf->Cell(10,4,"Cant.:",0,0,'',false);
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(8,4,$cantidad_cpt,'',1,'L',false);	
			
			}else{
				$pdf->SetX(182);
				$pdf->SetFont('Arial','B',9);	
				$pdf->Cell(10,4,"",0,0,'',false);
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(8,4,"",'',1,'L',false);	
				
			}	
						
			$pdf->SetFont('Arial','B',9);
			$pdf->SetX(16);
			$pdf->Cell(20,4,"Prensa:",'',0,'L',false);
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(164,4,$prensa,'',1,'L',false);
			
			$pdf->SetFont('Arial','B',9);
			$pdf->SetX(16);
			$pdf->Cell(20,4,"Obs:",'',0,'L',false);
			$pdf->SetFont('Arial','',9);
			$pdf->SetX(35);
			$pdf->MultiCell(164,3, $obs_trabajo ,0,'L',false);
			//$pdf->Cell(164,4,$obs_trabajo,'',1,'L',false);
			
		//	$auxY=$pdf->GetY();
			//$pdf->Line(16,$auxY_1,16,$auxY);
			//$pdf->Line(200,$auxY_1,200,$auxY);
			//$pdf->Line(16,$pdf->GetY(),200,$pdf->GetY());
}

			

		/*********************************FIN CUERPO DE COTIZACION***************************************/
	
	$pdf->Output();


require("cerrar_conexion.inc");
?>


