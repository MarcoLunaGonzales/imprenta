<?php
require("conexion1.inc");
require("fpdf.php");

class PDF extends FPDF
{


//Cabecera de página
	function Header()
	{	
		$this->Image('punto.jpg',1,1,0);
		$cod_nota_remision=$_GET['cod_nota_remision'];
		$sql5="select  valor_x, valor_y from coordenadas_impresion where cod_coordenada=1";
		$resp5=mysql_query($sql5);
		while ($dat5=mysql_fetch_array($resp5)){
			$valorX=$dat5[0];
			$valorY=$dat5[1];
		}
		
		$cod_nota_remision=$_GET['cod_nota_remision'];
		$sql=" select fecha_nota_remision, cod_usuario_nota_remision,obs_nota_remision, ";
		$sql.=" cod_hoja_ruta, cod_estado_nota_remision, recibido_por, cod_usuario_anulacion, nro_nota_remision, cod_gestion ";
		$sql.=" from notas_remision ";
		$sql.=" where  cod_nota_remision='".$cod_nota_remision."'";
		$resp=mysql_query($sql);
		while ($dat=mysql_fetch_array($resp)){
			$fecha_nota_remision=$dat[0];
			$fecha_nota_remisionVecto=explode("-",$fecha_nota_remision);					
			$cod_usuario_nota_remision=$dat[1];
	
			$sql2="select nombres_usuario,ap_paterno_usuario from usuarios  where cod_usuario='".$cod_usuario_nota_remision."'";	
			$resp2= mysql_query($sql2);
			$dat2=mysql_fetch_array($resp2);
			$entregadoPor=$dat2[0]." ".$dat2[1]." ".$dat2[2];
	
			$obs_nota_remision=$dat[2];
			$cod_hoja_ruta=$dat[3]; 
			$cod_estado_nota_remision=$dat[4]; 
			$recibido_por=$dat[5];
			$cod_usuario_anulacion=$dat[6];
			$nro_nota_remision=$dat[7];
			$cod_gestion_nota_remision=$dat[8];
				$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion_nota_remision."'";
				$resp2= mysql_query($sql2);
				$gestionNotaRemision="";
				while($dat2=mysql_fetch_array($resp2)){
					$gestionNotaRemision=$dat2[0];
				}			
		}


	$sql=" select  fecha_hoja_ruta, cod_usuario_hoja_ruta, ";
	$sql.=" obs_hoja_ruta, cod_cotizacion, cod_estado_hoja_ruta, factura_si_no, cod_usuario_comision, nro_hoja_ruta, cod_gestion ";
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
		$obs_hoja_ruta=$dat[2];
		$cod_cotizacion=$dat[3];
		$cod_estado_hoja_ruta=$dat[4];
		$factura_si_no=$dat[5];
		$cod_usuario_comision=$dat[6];
		$nro_hoja_ruta=$dat[7];
		$cod_gestion_hoja_ruta=$dat[8];
		
				$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion_hoja_ruta."'";
				$resp2= mysql_query($sql2);
				$gestionHojaRuta="";
				while($dat2=mysql_fetch_array($resp2)){
					$gestionHojaRuta=$dat2[0];
				}			 
	}

	$sql=" select  cod_cliente from cotizaciones  where cod_cotizacion='".$cod_cotizacion."'";
	$resp=mysql_query($sql);
	while ($dat=mysql_fetch_array($resp)){
		$cod_cliente=$dat[0]; 
			$sql2=" select nombre_cliente, nit_cliente, cod_categoria, cod_ciudad,  ";
			$sql2.=" direccion_cliente, telefono_cliente, celular_cliente, fax_cliente ";
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
			}	
	}
		/**********************Fin Datos de Cliente******************************/	

			$this->SetFont('Arial','B',14);
			$this->SetTextColor(0,0,0);
			$this->SetXY($valorX+25,$valorY+28);
			$this->Cell(183,6,"NOTA REMISION",0,1,'C',false);
			$this->SetTextColor(0,0,0);	
			$this->SetFont('Arial','B',10);
			$this->SetXY($valorX+25,$valorY+34);
			$this->Cell(183,5,"No. ".$nro_nota_remision."/".$gestionNotaRemision,0,1,'C',false);		
			$this->SetXY($valorX+25,$valorY+39);			
			$this->Cell(183,5,strftime("%d/%m/%Y",strtotime($fecha_nota_remision)),0,1,'C',false);				
			$this->SetTextColor(0,0,0);		
			$this->SetXY($valorX+170,$valorY+36);
    			$this->SetFont('Arial','B',9);
			$this->Cell(0,4,'Página '.$this->PageNo().' de '.' {nb}',0,1,'C',false);    	    					
			$this->SetXY($valorX+25,$valorY+43);
			$this->Cell(18,5,"Señor(es):",0,0,'L',false);
			$this->Cell(140,5,$nombre_cliente,0,0,'L',false);		
			$this->Cell(4,4,"HR:",0,0,'C',false);	
			$this->Cell(20,4,$nro_hoja_ruta."/".$gestionHojaRuta,0,1,'C',false);		
			$this->SetXY($valorX+25,$valorY+47);
			$this->Cell(18,5,"Telefono:",0,0,'L',false);	
			$this->Cell(42,5,$telefono_cliente,0,0,'L',false);	
			$this->Cell(18,5,"Celular:",0,0,'L',false);	
			$this->Cell(42,5,$celular_cliente,0,0,'L',false);
			$this->Cell(18,5,"Fax:",0,0,'L',false);	
			$this->Cell(45,5,$fax_cliente,0,1,'L',false);
			$this->SetXY($valorX+25,$valorY+51);
			$this->Cell(18,5,"Direccion:",0,0,'L',false);
			$this->Cell(165,5,$direccion_cliente,0,1,'L',false);	
						
			$this->SetFont('Arial','B',11);
			$this->SetTextColor(0,0,0);								
			$this->SetXY($valorX+25,$valorY+$valorY+58);			
			//$this->Cell(15,5,"",1,0,'C',false);						
			$this->Cell(175,5,"DETALLE",1,1,'C',false);	
			
		/************************FIN DATOS DE CABECERA*************************************/		
	}

	//Pie de página
	function Footer()
	{
		$cod_nota_remision=$_GET['cod_nota_remision'];
		$sql=" select fecha_nota_remision, cod_usuario_entregado_por,obs_nota_remision, ";
		$sql.=" cod_hoja_ruta, cod_estado_nota_remision, recibido_por, cod_usuario_anulacion ";
		$sql.=" from notas_remision ";
		$sql.=" where  cod_nota_remision='".$cod_nota_remision."'";
		$resp=mysql_query($sql);
		while ($dat=mysql_fetch_array($resp)){
			$fecha_nota_remision=$dat[0];
			$cod_usuario_entregado_por=$dat[1];
			$entregadoPor="";
			if($cod_usuario_entregado_por<>""){
			$sql2="select nombres_usuario,ap_paterno_usuario from usuarios  where cod_usuario='".$cod_usuario_entregado_por."'";	
			$resp2= mysql_query($sql2);
			$dat2=mysql_fetch_array($resp2);
			$entregadoPor=$dat2[0]." ".$dat2[1]." ".$dat2[2];
			}
			$obs_nota_remision=$dat[2];
			$cod_hoja_ruta=$dat[3]; 
			$cod_estado_nota_remision=$dat[4]; 
			$recibido_por=$dat[5];
			$cod_usuario_anulacion=$dat[6];
		}
			
		global $sw;
		$this->SetY(-15);
		//Arial italic 8
//		$this->SetFont('Arial','I',9);
		if($sw==1){
			$this->SetFont('Arial','',9);
			$this->SetXY($valorX+25,$valorY+$valorY+224);			
			$this->Cell(81,6,"...................................................................................",0,0,'C',false);						
			$this->Cell(84,6,"...................................................................................",0,1,'C',false);
			$this->SetFont('Arial','B',9);		
			$this->SetXY($valorX+25,$valorY+$valorY+228);			
			$this->Cell(81,5,"Entregado por:",0,0,'C',false);						
			$this->Cell(84,5,"Recibido por:",0,1,'C',false);
			$this->SetXY($valorX+35,$valorY+$valorY+236);			
			//$this->Cell(81,5,"Nombre: ".$entregadoPor,0,0,'L',false);						
			//$this->Cell(84,5,"Nombre: ".$recibido_por,0,1,'L',false);	
			$this->Cell(15,5,"Nombre:",0,0,'L',false);
			$this->SetFont('Arial','',9);
			if($entregadoPor<>""){
				$this->Cell(67,5,$entregadoPor,0,0,'L',false);
			}else{
				$this->Cell(67,5,"...................................................",0,0,'L',false);
			}						
			
			
			$this->SetFont('Arial','B',9);
			$this->Cell(15,5,"Nombre:",0,0,'L',false);
			$this->SetFont('Arial','',9);
			if($recibido_por<>""){
				$this->Cell(77,5,$recibido_por,0,0,'L',false);
			}else{
				$this->Cell(77,5,"...................................................",0,0,'L',false);
			}				
		}
		
	}
	
}
	$pdf=new PDF('P','mm',array(214,254));	
	$pdf->AliasNbPages();
	$pdf->AddPage();
	

	$sql5="select  valor_x, valor_y from coordenadas_impresion where cod_coordenada=1";
	$resp5=mysql_query($sql5);
	while ($dat5=mysql_fetch_array($resp5)){
		$valorX=$dat5[0];
		$valorY=$dat5[1];
	}
	$cod_nota_remision=$_GET['cod_nota_remision'];
	$sql=" select fecha_nota_remision, cod_usuario_entregado_por,obs_nota_remision, ";
	$sql.=" cod_hoja_ruta, cod_estado_nota_remision, recibido_por, cod_usuario_anulacion ";
	$sql.=" from notas_remision ";
	$sql.=" where  cod_nota_remision='".$cod_nota_remision."'";
	$resp=mysql_query($sql);
	while ($dat=mysql_fetch_array($resp)){
		$fecha_nota_remision=$dat[0];
		$cod_usuario_entregado_por=$dat[1];
		$obs_nota_remision=$dat[2];
		$cod_hoja_ruta=$dat[3]; 
		$cod_estado_nota_remision=$dat[4]; 
		$recibido_por=$dat[5];
		$cod_usuario_anulacion=$dat[6];
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
		$sql.=" and cod_cotizaciondetalle in (select cod_cotizaciondetalle from notas_remision_detalle ";
		$sql.=" where cod_nota_remision='".$cod_nota_remision."')";
		$sql.=" order by cod_cotizaciondetalle asc";
		$resp=mysql_query($sql);
		$suma=0;
		
		$val_aux_coordenadaY=0;
		while ($dat=mysql_fetch_array($resp)){

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
			
			$sql7=" select cantidad from notas_remision_detalle where cod_cotizacion='".$cod_cotizacion."'";
			$sql7.=" and cod_cotizaciondetalle='".$cod_cotizaciondetalle."'";
			$sql7.=" and cod_nota_remision='".$cod_nota_remision."' ";
			$sumaCantidadEntregada=0;
			$resp7=mysql_query($sql7);
			while($dat7=mysql_fetch_array($resp7))
			{
				$sumaCantidadEntregada=$dat7[0];				  							
			}
			if($sumaCantidadEntregada == NULL){
				$sumaCantidadEntregada=0;
			}
			
			$auxY_1=$pdf->GetY();		
			$pdf->SetFont('Arial','B',9);
			$pdf->SetXY($valorX+25,$valorY+$val_aux_coordenadaY);			
			$pdf->Cell(15,5,$sumaCantidadEntregada,'LT',0,'R',false);
			
			
			$pdf->MultiCell(160,5,utf8_decode($desc_item)." ".utf8_decode($descripcion_item),'R','L',false);	
			$auxY=$pdf->GetY();
			$pagina_actual=$pdf->PageNo();			
			if($auxY>$auxY_1){
				$pdf->Line(25,$auxY_1,25,$auxY);

			}else{
				$pdf->PageNo($pagina_actual-1);
				$pdf->Line(25,59,25,224);				
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
						$pdf->SetX($valorx+25);
						$pdf->Cell(15,5,"",'L',0,'L',false);
						$pdf->Cell(160,5,utf8_decode($nombre_componenteitem),'R',1,'L',false);
					}
						
					/**********************************/
					$sql3=" select  cod_carac, desc_carac, cod_estado_registro ";
					$sql3.=" from cotizacion_detalle_caracteristica ";
					$sql3.=" where cod_cotizaciondetalle='".$cod_cotizaciondetalle."'";
					$sql3.=" and cod_cotizacion='".$cod_cotizacion."'";
					$sql3.=" and cod_compitem='".$cod_compitem."'";
					$sql3.=" and cod_estado_registro=1";
					$resp3=mysql_query($sql3);
					$descCaracItem="";
					while ($dat3=mysql_fetch_array($resp3)){
						
						$cod_carac=$dat3[0];
						$desc_caracT="";
						$sql5=" select desc_carac from caracteristicas where cod_carac='".$cod_carac."'";
						$resp5=mysql_query($sql5);
						while ($dat5=mysql_fetch_array($resp5)){
							$desc_caracT=$dat5[0];	
						}
						$desc_carac=$dat3[1];
						$desc_carac=str_replace("|",",",$desc_carac);
						$cod_estado_registro=$dat3[2];
						
						$pdf->SetFont('Arial','',9);
						$pdf->SetX($valorx+25);
						$pdf->Cell(15,5,"",'L',0,'L',false);					
						$pdf->Cell(160,5,utf8_decode($desc_caracT).": ".utf8_decode($desc_carac),'R',1,'L',false);
					}
				/***************************************************************/
				}
				
			}

			$pdf->Line(25,$pdf->GetY(),200,$pdf->GetY());
		
}
$sw=1;
$pdf->Output();


require("cerrar_conexion.inc");
?>


