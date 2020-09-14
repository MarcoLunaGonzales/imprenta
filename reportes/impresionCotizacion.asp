<?php
require("conexion1.inc");
require("fpdf.php");

include("funcionesNumerosALetras.php");


class PDF extends FPDF
{


//Cabecera de página
	function Header()
	{	
	$this->Image('cotizacion.jpg',0,0,214);	
		
		$cod_cotizacion=$_GET['cod_cotizacion'];
/**********************DATOS DE CABECERA*********************/

	
		$sql5="select  valor_x, valor_y from coordenadas_impresion where cod_coordenada=1";
		$resp5=mysql_query($sql5);
		while ($dat5=mysql_fetch_array($resp5)){
			$valorX=$dat5[0];
			$valorY=$dat5[1];
		}


	$sql=" select cod_cotizacion, cod_tipo_cotizacion, cod_estado_cotizacion, nro_cotizacion,";
	$sql.=" cod_cliente, fecha_cotizacion, obs_cotizacion, cod_usuario_registro, cod_tipo_pago, ";
	$sql.=" fecha_modificacion_cotizacion, cod_gestion, cod_usuario_modificacion, cod_sumar, considerar_precio_unitario ";
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
		$fecha_modificacion_cotizacion=$dat[9];
		$cod_gestion=$dat[10];
		$sql5="select gestion from gestiones where cod_gestion='".cod_gestion."'";
		$resp5=mysql_query($sql5);
		while ($dat5=mysql_fetch_array($resp5)){
			$gestion=$dat5[0];
		}			
		$cod_usuario_modificacion=$dat[11];
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
	}
		/**********************Fin Datos de Cliente******************************/	

			$this->SetFont('Arial','B',10);
			$this->SetTextColor(0,0,0);	
			$this->Text($valorX+163,$valorY+28,$fechaCotizacionVectoAux[2]);
			$this->Text($valorX+176,$valorY+28,$fechaCotizacionVectoAux[1]);
			$this->Text($valorX+189,$valorY+28,$fechaCotizacionVectoAux[0]);	
			$this->SetFont('Arial','B',9);
			$this->SetXY($valorX+160,$valorY+40);
    	    $this->Cell(0,4,'Página '.$this->PageNo().' de '.' {nb}',0,1,'R',false);
			$this->SetFont('Arial','B',16);
			$this->Text($valorX+93,$valorY+45,"No. ".$nro_cotizacion."/".$gestion);
			
			$this->SetFont('Arial','B',10);
			$this->SetTextColor(0,0,0);
			$this->Text($valorX+55,$valorY+63,$nombre_cliente);
			$this->Text($valorX+55,$valorY+70,$direccion_cliente);
			$this->Text($valorX+55,$valorY+77,$telefono_cliente);
			$this->Text($valorX+105,$valorY+77,"Celular:".$celular_cliente);		
			$this->Text($valorX+150,$valorY+77,"Fax:".$fax_cliente);
			$this->SetY(102);
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
	
		global $sw;
		global $suma;
		global $suma_literal;
		global $cod_sumar;
	
		if($sw==1 && $cod_sumar==1 ){
			$this->SetY($valorY+205);
			$this->SetX($valorX+170);
			$this->SetFont('Arial','B',9);	
			$numero_formato=number_format($suma,2);					
			$this->Cell(20,6,$numero_formato,0,1,'L',false);
			$suma_literal=convertir($suma);
			$this->SetY($valorY+218);
			$this->SetX($valorX+26);
			$this->Cell(146,6,$suma_literal,0,1,'L',false);
		}
	
		
		$cod_cotizacion=$_GET['cod_cotizacion'];
	/***************************DATOS DE CABECERA********************************/
		$sql=" select cod_usuario_registro from cotizaciones ";
		$sql.=" where  cod_cotizacion='".$cod_cotizacion."'";
		$resp=mysql_query($sql);
		while ($dat=mysql_fetch_array($resp)){
			$cod_usuario_registro=$dat[0];
		}
		
		$sql=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios ";
		$sql.=" where  cod_usuario='".$cod_usuario_registro."'";
		$resp=mysql_query($sql);
		while ($dat=mysql_fetch_array($resp)){
			$nombres_usuario=$dat[0];
			$ap_paterno_usuario=$dat[1]; 
			$ap_materno_usuario=$dat[2];
			
		}
		$this->SetY($valorY+255);
		$this->SetX($valorX+142);
		$this->SetFont('Arial','B',9);
		$this->Cell(0,6,"Lic. ".$nombres_usuario." ".$ap_paterno_usuario." ".$ap_materno_usuario,0,1,'L',false);
		
	
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
	//$pdf=new PDF('P','mm','Letter');
	$pdf=new PDF('P','mm',array(214,279));
	$pdf->SetAutoPageBreak(true,75-$valorY);
	
	
	$pdf->AliasNbPages();
	$pdf->AddPage();
	//$pdf->Line(0, 0, 214,279);

	/********************datos extras de cotizacion***************/	
	$sql=" select cod_cotizacion, cod_tipo_cotizacion, cod_estado_cotizacion, nro_cotizacion,";
		$sql.=" cod_cliente, fecha_cotizacion, obs_cotizacion, cod_usuario_registro, cod_tipo_pago, ";
		$sql.=" fecha_modificacion_cotizacion, cod_gestion, cod_usuario_modificacion, cod_sumar, considerar_precio_unitario ";
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
			$fecha_modificacion_cotizacion=$dat[9];
			$cod_gestion=$dat[10];	
			$cod_usuario_modificacion=$dat[11];
			$cod_sumar=$dat[12];
			$considerar_precio_unitario=$dat[13];
		}
	/***********************************/
	
/*********************************CUERPO DE COTIZACION****************************************/
		$cont=0;
		$sql=" select cod_cotizaciondetalle,  cod_item, descripcion_item, ";
		$sql.=" cantidad_unitariacotizacion, cantidad_unitariacotizacionefectuada, ";
		$sql.=" cod_estado_detallecotizacionitem,precio_venta, descuento, importe_total, orden ";
		$sql.=" from cotizaciones_detalle ";
		$sql.=" where  cod_cotizacion='".$cod_cotizacion."'";
		$sql.=" order by cod_cotizaciondetalle asc";
		$resp=mysql_query($sql);
		$suma=0;

	
		while ($dat=mysql_fetch_array($resp)){

			$val_aux_coordenadaY=$pdf->GetY();
			$val_aux_coordenadaYanterior=$pdf->GetY();
			
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
			
			$pdf->SetFont('Arial','B',9);
			
			
			$pdf->SetXY($valorX+21,$valorY+$val_aux_coordenadaY);
			
			$pdf->Cell(16,6,$cantidad_unitariacotizacion,0,1,'R',false);

			$pdf->SetXY($valorX+50,$valorY+$val_aux_coordenadaY);
						
			$pdf->MultiCell(80,6,utf8_decode($desc_item)." ".utf8_decode($descripcion_item),0,'L',false);
			$val_aux_coordenadaY=$pdf->GetY();
			
			$pdf->SetXY($valorX+135,$valorY+$val_aux_coordenadaYanterior);

			if($considerar_precio_unitario==1){
			
				$precio_venta_formato=number_format($precio_venta,2);		
				$pdf->Cell(15,6,$precio_venta_formato,0,0,'R',false);
				$pdf->Cell(20,6,"",0,0,'R',false);
				$precio_unitario_formato=number_format($cantidad_unitariacotizacion*$precio_venta,2);
				$pdf->Cell(20,6,$precio_unitario_formato,0,1,'R',false);
				$suma=$suma+($cantidad_unitariacotizacion*$precio_venta);
				
			}else{
			
				$pdf->Cell(35,6,"",0,0,'R',false);
				$importe_total_formato=number_format($importe_total,2);
				$pdf->Cell(20,6,$importe_total_formato,0,1,'R',false);
				$suma=$suma+($importe_total);
			}
			
			$pdf->SetY($val_aux_coordenadaY+$valorY);
			
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
				$nombre_componenteitem="";
				$sql5=" select nombre_componenteitem from componente_items where cod_compitem='".$cod_compitem."'";
				$resp5=mysql_query($sql5);
				while ($dat5=mysql_fetch_array($resp5)){
					$nombre_componenteitem=$dat5[0];	
				}
				if($cant_comp>1){
					$pdf->SetFont('Arial','B',9);
					$pdf->SetX($valorx+51);
					$pdf->Cell(0,5,utf8_decode($nombre_componenteitem),0,1,'L',false);
				}
						
				/**********************************/
				$sql3=" select  cod_carac, desc_carac, cod_estado_registro ";
				$sql3.=" from cotizacion_detalle_caracteristica ";
				$sql3.=" where cod_cotizaciondetalle='".$cod_cotizaciondetalle."'";
				$sql3.=" and cod_cotizacion='".$cod_cotizacion."'";
				$sql3.=" and cod_compitem='".$cod_compitem."'";
				$sql3.=" and cod_estado_registro=1";
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
						$pdf->SetX($valorX+52);
						$pdf->Cell(0,5,utf8_decode($desc_caracT)." ".utf8_decode($desc_carac),0,1,'L',false);

					
				}
			}
	
}
$sw=1;
		/*********************************FIN CUERPO DE COTIZACION***************************************/
	

 
$pdf->Output();


require("cerrar_conexion.inc");
?>


