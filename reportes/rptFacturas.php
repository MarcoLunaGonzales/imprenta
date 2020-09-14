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
		

		$fecha_inicio=$_POST['fecha_inicio'];
		$fecha_final=$_POST['fecha_final'];
/**********************DATOS DE CABECERA*********************/

	
		$sql5="select  valor_x, valor_y from coordenadas_impresion where cod_coordenada=1";
		$resp5=mysql_query($sql5);
		while ($dat5=mysql_fetch_array($resp5)){
			$valorX=$dat5[0];
			$valorY=$dat5[1];
		}

		/**********************Fin Datos de Cliente******************************/	
			$this->SetFont('Arial','B',14);
			$this->Text(20,10,"INVENTA PUBLICIDAD E IMPRESOS");
			$this->SetTextColor(0,0,0);	
			$this->Text(75,18,"REPORTE DE FACTURAS ");
			$this->SetFont('Arial','',9);
			$this->Text(84,24,"Del ".$_POST['fecha_inicio']." al ".$_POST['fecha_final']);
			/*if($_POST['cod_tipo_cbte']<>0){
					$sql5="select nombre_tipo_cbte from tipo_comprobante where cod_tipo_cbte=".$_POST['cod_tipo_cbte'];
					$resp5=mysql_query($sql5);
					while ($dat5=mysql_fetch_array($resp5)){
						$nombre_tipo_cbte=$dat5['nombre_tipo_cbte'];
					}
				$this->Text(82,29,"Tipo de Comprobante:".$nombre_tipo_cbte);
				$this->Text(82,34,"Expresado en Moneda Nacional");
			}else{
				$this->Text(82,29,"Expresado en Moneda Nacional");			
			}*/
			$this->SetFont('Arial','B',10);

			$this->SetXY(170,20);
    	    $this->Cell(0,4,'Página '.$this->PageNo().' de '.' {nb}',0,1,'L',false);
			$this->SetXY(170,25);
			$this->Cell(0,4,date('d/m/Y H:i:s', time()),0,1,'L',false);	

			
			
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','B',9);
			$this->SetXY(10,35);
			$this->Cell(20,5,"Nit",'TB',0,'C',false);
			$this->Cell(70,5,"Nombre ",'TB',0,'C',false);
			$this->Cell(80,5,"Glosa",'TB',0,'C',false);
			$this->Cell(35,5,"Monto",'TB',0,'C',false);

			
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
	

	$fecha_inicio=$_POST['fecha_inicio'];
	$fecha_final=$_POST['fecha_final'];
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$sql="select nro_factura,fecha_factura,SUM(monto_factura)  from facturas ";
	//$sql.=" where cod_est_fac<>2 ";
	$sql.=" where fecha_factura>='".llevarAFormatoFechaSqlMarco($_POST['fecha_inicio'])."'";
	$sql.=" and fecha_factura<='".llevarAFormatoFechaSqlMarco($_POST['fecha_final'])."'";
	$sql.=" group by nro_factura,fecha_factura ";		
	$sql.=" order by fecha_factura asc,nro_factura asc ";	
	$resp=mysql_query($sql);
	$montoTotal=0;
	while ($dat=mysql_fetch_array($resp)){
	
			$nro_factura=$dat[0];
			$fecha_factura=$dat[1];
			$monto=0;
			/////// Extra
		$sqlAux="select SUM(monto_factura)  from facturas ";
		$sqlAux.=" where cod_est_fac<>2 ";
		$sqlAux.=" and fecha_factura='".$fecha_factura."'";
		$sqlAux.=" and nro_factura='".$nro_factura."'";
		$respAux=mysql_query($sqlAux);
		
		while ($datAux=mysql_fetch_array($respAux)){
			$monto=$datAux[0];
		}
		if($monto==NULL or $monto==''){
		$monto=0;
		}
	///////
			$montoTotal=$montoTotal+$monto;
			$pdf->SetX(10);
			$pdf->SetFont('Arial','B',8);
			$pdf->SetX(150);
			$pdf->SetX(10);
			$pdf->MultiCell(140,4," Nro Factura.".$nro_factura." Fecha de Factura: ".strftime("%d/%m/%Y",strtotime($fecha_factura))." Monto: ".$monto."  Suma Parcial:".$montoTotal,0,'J',false);			
			
		$sql2=" select f.cod_factura, f.nombre_factura, f.nit_factura, f.detalle_factura, ";
		$sql2.=" f.obs_factura, f.monto_factura, f.cod_usuario_registro, f.fecha_registro,";
		$sql2.=" f.cod_usuario_modifica,f.fecha_modifica, f.cod_cliente,f.cod_est_fac, ef.desc_est_fac, fhr.cod_hoja_ruta,";
		$sql2.=" fot.cod_orden_trabajo ";
		$sql2.=" from facturas f";
		$sql2.=" left join factura_hojaruta fhr on (f.cod_factura=fhr.cod_factura)";
		$sql2.=" left join estado_factura ef on (f.cod_est_fac=ef.cod_est_fac)";
		$sql2.=" left join hojas_rutas hr on(fhr.cod_hoja_ruta=hr.cod_hoja_ruta)";
		$sql2.=" left join factura_ordentrabajo fot on (f.cod_factura=fot.cod_factura)";
		$sql2.=" left join ordentrabajo ot on(fot.cod_orden_trabajo=ot.cod_orden_trabajo)";
		//$sql2.=" where f.nro_factura=".$nro_factura." and f.fecha_factura='".$fecha_factura."' and  cod_est_fac<>2";
		$sql2.=" where f.nro_factura=".$nro_factura." and f.fecha_factura='".$fecha_factura."' ";
		
		$resp2=mysql_query($sql2);
		

		while ($dat2=mysql_fetch_array($resp2)){
			$cod_factura=$dat2['cod_factura'];
			$nombre_factura=$dat2['nombre_factura'];
			$nit_factura=$dat2['nit_factura'];
			$detalle_factura=$dat2['detalle_factura'];
			$obs_factura=$dat2['obs_factura'];
			$monto_factura=$dat2['monto_factura'];
			$cod_usuario_registro=$dat2['cod_usuario_registro'];
			$fecha_registro=$dat2['fecha_registro'];
			$cod_usuario_modifica=$dat2['cod_usuario_modifica'];
			$fecha_modifica=$dat2['fecha_modifica'];
			$cod_cliente=$dat2['cod_cliente'];
			$cod_est_fac=$dat2['cod_est_fac'];
			$desc_est_fac=$dat2['desc_est_fac'];
			$cod_hoja_ruta=$dat2['cod_hoja_ruta'];
			$cod_orden_trabajo=$dat2['cod_orden_trabajo'];

			
			/*$sql3="select nombre_estado_cbte from estado_comprobante where cod_estado_cbte=".$cod_estado_cbte;
			$resp3=mysql_query($sql3);
			while ($dat3=mysql_fetch_array($resp3)){
				$nombre_estado_cbte=$dat3['nombre_estado_cbte'];
			}*/
			$descHR="";
			if($cod_hoja_ruta!=NULL && $cod_hoja_ruta!=''){
			$sql7=" select hr.nro_hoja_ruta,hr.fecha_hoja_ruta, g.gestion_nombre,c.cod_cliente,";
			$sql7.=" c.cod_cotizacion,c.nro_cotizacion,gc.gestion_nombre as gestion_cot,";
			$sql7.=" cli.nombre_cliente,c.fecha_cotizacion";
			$sql7.=" from hojas_rutas hr";
			$sql7.=" left join gestiones g on (hr.cod_gestion=g.cod_gestion)";
			$sql7.=" left join cotizaciones c on (hr.cod_cotizacion=c.cod_cotizacion)";
			$sql7.=" left join clientes cli on (c.cod_cliente=cli.cod_cliente)";
			$sql7.=" left join gestiones gc on (c.cod_gestion=gc.cod_gestion)";
			$sql7.=" where hr.cod_hoja_ruta=".$cod_hoja_ruta;
			$resp7=mysql_query($sql7);
			while ($dat7=mysql_fetch_array($resp7)){
					$nro_hoja_ruta=$dat7['nro_hoja_ruta'];
					$gestion_nombre=$dat7['gestion_nombre'];
					$fecha_hoja_ruta=$dat7['fecha_hoja_ruta'];
					$cod_cotizacion=$dat7['cod_cotizacion'];
					$nro_cotizacion=$dat7['nro_cotizacion'];
					$gestion_cot=$dat7['gestion_cot'];
					$nombre_cliente=$dat7['nombre_cliente'];
					$fecha_cotizacion=$dat7['fecha_cotizacion'];
			}
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
					$sqlAux="select descuento_cotizacion from cotizaciones where cod_cotizacion=".$cod_cotizacion;
					$respAux = mysql_query($sqlAux);
					while($datAux=mysql_fetch_array($respAux)){
							$descuento_cotizacion=$datAux[0];
					}
					
					if($descuento_cotizacion>0){
						//echo $descuento_cotizacion;
					}else{
						$descuento_cotizacion=0;
						//echo "0";
					}
					$incremento_cotizacion=0;
					$sqlAux="select incremento_cotizacion from cotizaciones where cod_cotizacion=".$cod_cotizacion;
					$respAux = mysql_query($sqlAux);
					while($datAux=mysql_fetch_array($respAux)){
							$incremento_cotizacion=$datAux[0];
					}
					
					if($incremento_cotizacion>0){
						//echo $incremento_cotizacion;
					}else{
						$incremento_cotizacion=0;
						//echo "0";
					}	
										
			$descHR="HR:".$nro_hoja_ruta." (" .$fecha_hoja_ruta.")".$nombre_cliente ." COT.".$nro_cotizacion." ( ".$fecha_cotizacion." ) Bs:".(($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion);
			}
			$descOT="";
if($cod_orden_trabajo!=NULL && $cod_orden_trabajo!=''){
			$sql7=" select ot.nro_orden_trabajo, ot.fecha_orden_trabajo, cli.nombre_cliente, ot.monto_orden_trabajo ";
			$sql7.=" from ordentrabajo ot ";
			$sql7.=" left join clientes cli on (ot.cod_cliente=cli.cod_cliente) ";
			$sql7.=" where ot.cod_orden_trabajo=".$cod_orden_trabajo;

			$resp7=mysql_query($sql7);
			while ($dat7=mysql_fetch_array($resp7)){
					$nro_orden_trabajo=$dat7['nro_orden_trabajo'];
					$fecha_orden_trabajo=$dat7['fecha_orden_trabajo'];
					$nombre_cliente=$dat7['nombre_cliente'];
					$monto_orden_trabajo=$dat7['monto_orden_trabajo'];
			}
			$descOT="OT:".$nro_orden_trabajo." (" .$fecha_orden_trabajo.")".$nombre_cliente ." Bs.".$monto_orden_trabajo;
			}			


			
				 $pdf->SetFont('Arial','',6);
				 $pdf->SetX(10);				
		  		 $pdf->Cell(20,4,$nit_factura,0,0,'L',false);
				 $pdf->Cell(80,4,$nombre_factura,0,0,'L',false);
				// $pdf->Cell(80,4,$descHR,0,0,'L',false);				
				 $pdf->SetX(170);
				 $pdf->Cell(35,4,$monto_factura,0,0,'R',false);
				 $pdf->SetX(115);
				 if($cod_est_fac==2){
				 $pdf->MultiCell(75,4,$descHR.$descOT." (".$desc_est_fac.")",0,'J',false);
				 }else{
				 $pdf->MultiCell(75,4,$descHR.$descOT,0,'J',false);
				 }
				 

				
			
			}
			 $pdf->Cell(0,1,"",0,1,'L',false);
			$pdf->Line(10,$pdf->GetY(),205,$pdf->GetY());
			$pdf->Cell(0,1,"",0,1,'L',false);
		}
				$pdf->SetFont('Arial','B',10);
				$pdf->SetX(160);
				 $pdf->Cell(15,4,"TOTAL ",0,0,'R',false);

				 $pdf->SetX(190);
			     $pdf->Cell(15,4,number_format($montoTotal, 2, ",", "."),0,1,'R',false);
	
	


	
	
	

 
$pdf->Output();


require("cerrar_conexion.inc");
?>


