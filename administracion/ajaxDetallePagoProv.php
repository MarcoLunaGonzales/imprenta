<?php 
header("Cache-Control: no-store, no-cache, must-revalidate");
require("conexion.inc");
include("funciones.php");


$cod_cliente=$_GET['cod_cliente'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Documento sin t&iacute;tulo</title>
<link href="pagina.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
	$sql="select cambio_bs from tipo_cambio where fecha_tipo_cambio='".date('Y-m-d', time())."'";
	$resp= mysql_query($sql);
	$cambio_bs='';
	while($dat=mysql_fetch_array($resp)){
		$cambio_bs=$dat['cambio_bs'];
	}
?>
<input type="hidden" id="cambio_bs" name="cambio_bs" value="<?php echo $cambio_bs?>">
<?php
if($cambio_bs==null or $cambio_bs=='' ){
?>
<div align="center" style="background:#FFF;font-size: 14px;color: #FF0000;font-weight:bold;">ATENCION!!! No existe el Cambio de Dolar para Hoy</div>
<?php
}
?>
<?php
	$sql=" select cod_cuenta ";
	$sql.=" from proveedores";
	$sql.=" where cod_proveedor=".$_GET['cod_proveedor'];
	$resp= mysql_query($sql);
	$cod_cuenta="";
	while($dat=mysql_fetch_array($resp)){
		$cod_cuenta=$dat['cod_cuenta'];
	}
?>
<?php
if($cod_cuenta==null or $cod_cuenta=='' ){
?>
<div align="center" style="background:#FFF;font-size: 14px;color: #FF0000;font-weight:bold;">ATENCION!!! El Proveedor No tiene una Cta. Asignada</div>
<?php
}
?>
<input type="hidden" id="cod_cuenta" name="cod_cuenta" value="<?php echo $cod_cuenta?>">
<?php
	
	$sql=" select count(*) ";
	$sql.=" from ingresos i, gestiones g";
	$sql.=" where i.cod_gestion=g.cod_gestion";
	$sql.=" and i.cod_proveedor=".$_GET['cod_proveedor'];
	$sql.=" and i.cod_estado_ingreso<>2";
	$sql.=" and i.cod_estado_pago_doc<>3";
	$resp= mysql_query($sql);
	$nroRowsING=0;
	while($dat=mysql_fetch_array($resp)){
		$nroRowsING=$dat[0];
		
	}
	/////////////////////GASTOS//////////////////////
	$sql=" select count(*) ";
	$sql.=" from gastos_gral  ";
	$sql.=" where cod_estado_pago_doc<>3 ";
	$sql.=" and cod_estado<>2 ";
	$sql.=" and cod_proveedor=".$_GET['cod_proveedor'];
	$resp= mysql_query($sql);
	$nroRowsGastos=0;
	while($dat=mysql_fetch_array($resp)){
		$nroRowsGastos=$dat[0];
		
	}	
	


	if($nroRowsING==0 and $nroRowsGastos==0 ){
?>
 <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1">
          <tr class="titulo_tabla">
            <td align="center" height="20">Tipo Doc.</td>
            <td align="center" height="20">Nro Doc.</td>
            <td align="center" height="20">Fecha Doc.</td> 
            <td align="center" height="20">Monto Bs</td> 
            <td align="center" height="20">A Cuenta Bs</td>
            <td align="center" height="20">Saldo Bs</td>             
            <td align="center" height="20">Monto Pago</td>         
           </tr>
          <tr  bgcolor="#FFFFFF">
            <td align="center" colspan="7">DETALLE DE PAGOS</td>              
          </tr>          
        </table>   
<?php		
			
	}else{
?> 

        <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1">
          <tr class="titulo_tabla">
            <td align="center" height="20"><input type="checkbox" name="seleccionarTodo"  id="seleccionarTodo" onclick="checkearRegistros()" checked="true" ></td>
            <td align="center" height="20">Tipo Doc.</td>
            <td align="center" height="20">Nro Doc.</td>
            <td align="center" height="20">Fecha Doc.</td> 
            <td align="center" height="20">Monto Bs</td> 
            <td align="center" height="20">A Cuenta Bs</td>
            <td align="center" height="20">Saldo Bs</td>             
            <td align="center" height="20">Monto Pago</td>
		</tr>
          
           
<?php 
	$totalDeuda=0;
	$sql=" select i.cod_ingreso, i.nro_ingreso, i.cod_gestion, g.gestion,  i.fecha_ingreso, i.total_bs ";
	$sql.=" from ingresos i, gestiones g";
	$sql.=" where i.cod_gestion=g.cod_gestion";
	$sql.=" and i.cod_proveedor=".$_GET['cod_proveedor'];
	$sql.=" and i.cod_estado_ingreso<>2";
	$sql.=" and i.cod_estado_pago_doc<>3";
	$sql.=" order by  i.fecha_ingreso asc , i.nro_ingreso asc  ";

	$resp= mysql_query($sql);
	$gestion="";
	while($dat=mysql_fetch_array($resp)){
		 $cod_ingreso=$dat['cod_ingreso'];
		 $nro_ingreso=$dat['nro_ingreso'];
		 $cod_gestion=$dat['cod_gestion'];
		 $gestion=$dat['gestion'];
		 $fecha_ingreso=$dat['fecha_ingreso'];
		 $monto_ingreso=$dat['total_bs'];
?>		

          <tr >
            <td align="left"><input type="checkbox" name="cod_ingreso<?php echo $cod_ingreso;?>" id="cod_ingreso<?php echo $cod_ingreso;?>" value="<?php echo $cod_ingreso;?>" class="textoform" onclick="habilitarFilaIngreso(<?php echo $cod_ingreso;?>)" checked="true"></td>
            <td>ING</td> 
             <td align="left"><a href="../almacenes/detalleIngreso.php?cod_ingreso=<?php echo $cod_ingreso; ?>" target="_blank"> <?php echo $nro_ingreso."/".$gestion; ?></a></td>  
             <td align="left">&nbsp;<?php echo strftime("%d.%m.%Y",strtotime($fecha_ingreso)); ?></td> 
             
             <td align="right" >&nbsp;<?php echo $monto_ingreso; ?>
			<input type="hidden"name="monto_ingreso<?php echo $cod_ingreso;?>"id="monto_ingreso<?php echo $cod_ingreso;?>" value="<?php echo $monto_ingreso;?>"></td> 
             <td align="right">&nbsp;<?php 
			 	$sql2=" select SUM(ppd.monto_pago_prov_detalle) ";
			 	$sql2.=" from pago_proveedor_detalle ppd, pago_proveedor pp";
			 	$sql2.=" where ppd.cod_pago_prov=pp.cod_pago_prov";
			 	$sql2.=" and pp.cod_estado_pago_prov<>2";
			 	$sql2.=" and ppd.codigo_doc=".$cod_ingreso;
				$sql2.=" and ppd.cod_tipo_doc=4";
				$resp2 = mysql_query($sql2);
				$acuenta_ingreso=0;
				$monto_pago_prov_detalle=0;
				while($dat2=mysql_fetch_array($resp2)){
					$monto_pago_prov_detalle=$dat2[0];										
				}	
				$acuenta_ingreso=$acuenta_ingreso+$monto_pago_prov_detalle;			
			 echo $acuenta_ingreso;
			 $totalDeuda=$totalDeuda+($monto_ingreso-$acuenta_ingreso);
			 ?></td> 
             <td align="right"><?php echo ($monto_ingreso-$acuenta_ingreso);?>
             <input type="hidden" name="saldo_ingreso<?php echo $cod_ingreso;?>" id="saldo_ingreso<?php echo $cod_ingreso;?>" value="<?php echo ($monto_ingreso-$acuenta_ingreso);?>" ></td>       

			<td align="right">
			  <input type="text" name="monto_pago_ingreso<?php echo $cod_ingreso; ?>" id="monto_pago_ingreso<?php echo $cod_ingreso; ?>" value="<?php echo ($monto_ingreso-$acuenta_ingreso);?>" class="textoform" size="8" onKeyUp="validaFloat2(this)" onChange="validaFloat2(this)" >
            </td>                                                                
          </tr>          

<?php
	}
?>   

<?php
	$sql=" select gg.cod_gasto_gral, gg.nro_gasto_gral,g.gestion_nombre,gg.cod_tipo_doc,td.abrev_tipo_doc,gg.codigo_doc,";
	$sql.=" gg.fecha_gasto_gral,gg.nro_recibo, gg.monto_gasto_gral,gg.cant_gasto_gral,gg.desc_gasto_gral,gg.cod_gasto,";
	$sql.=" gg.cod_estado_pago_doc,gg.cod_tipo_pago";
	$sql.=" from gastos_gral gg";
	$sql.=" left join gestiones g on(gg.cod_gestion=g.cod_gestion)";
	$sql.=" left join tipo_documento td on(gg.cod_tipo_doc=td.cod_tipo_doc)";
	$sql.=" where gg.cod_proveedor=".$_GET['cod_proveedor'];
	$sql.=" and gg.cod_estado_pago_doc<>3";
	$sql.=" and gg.cod_estado<>2";
	$sql.=" order by fecha_gasto_gral asc, gg.nro_gasto_gral asc";
	$resp= mysql_query($sql);
	$gestion="";
	while($dat=mysql_fetch_array($resp)){
		$cod_gasto_gral=$dat['cod_gasto_gral'];
		$nro_gasto_gral=$dat['nro_gasto_gral'];
		$gestion_nombre=$dat['gestion_nombre'];
		$cod_tipo_doc=$dat['cod_tipo_doc'];
		$abrev_tipo_doc=$dat['abrev_tipo_doc'];
		$codigo_doc=$dat['codigo_doc'];
		$fecha_gasto_gral=$dat['fecha_gasto_gral'];
		$nro_recibo=$dat['nro_recibo'];
		$monto_gasto_gral=$dat['monto_gasto_gral'];
		$cant_gasto_gral=$dat['cant_gasto_gral'];
		$desc_gasto_gral=$dat['desc_gasto_gral'];
		$cod_gasto=$dat['cod_gasto'];
		$cod_estado_pago_doc=$dat['cod_estado_pago_doc'];
		$cod_tipo_pago=$dat['cod_tipo_pago'];
		
		$sql2=" select  count(*),sum(ppd.monto_pago_prov_detalle) ";
		$sql2.=" from pago_proveedor_detalle ppd ";
		$sql2.=" inner join  pago_proveedor pp on(ppd.cod_pago_prov=pp.cod_pago_prov and pp.cod_estado_pago_prov<>2) ";
		$sql2.=" and ppd.codigo_doc=".$cod_gasto_gral;
		$sql2.=" and ppd.cod_tipo_doc=5";
		$resp2 = mysql_query($sql2);
		$acuenta_gasto_gral=0;
		while($dat2=mysql_fetch_array($resp2)){					
			$num_pago_prov=$dat2[0];
			if($num_pago_prov>0){
				$acuenta_gasto_gral=$dat2[1];									
			}
		}
			
		 
?>
 <tr >
            <td align="left"><input type="checkbox" name="cod_gasto_gral<?php echo $cod_gasto_gral;?>" id="cod_gasto_gral<?php echo $cod_gasto_gral;?>" value="<?php echo $cod_gasto_gral;?>" class="textoform" onclick="habilitarFilaGastoGral(<?php echo $cod_gasto_gral;?>)" checked="true"></td>
            <td>GASTOS</td> 
             <td align="left"><a href="../contable/vistaGastoGral.php?cod_gasto_gral=<?php echo $cod_gasto_gral; ?>" target="_blank"> <?php echo $nro_gasto_gral."/".$gestion_nombre."(Rec.".$nro_recibo.")"; ?></a><a href="../reportes/impresionHojaRuta.php?cod_hoja_ruta=<?php echo $codigo_doc; ?>" target="_blank"> <?php echo "( HR ".$nro_hoja_ruta."/".$gestion.")"; ?></a></td>  
             <td align="left">&nbsp;<?php echo strftime("%d.%m.%Y",strtotime($fecha_gasto_gral)); ?></td> 
             
             <td align="right" >&nbsp;<?php echo $monto_gasto_gral; ?>
			<input type="hidden"name="monto_gasto_gral<?php echo $cod_gasto_gral;?>"id="monto_gasto_gral<?php echo $cod_gasto_gral;?>" value="<?php echo $monto_gasto_gral;?>"></td> 
             <td align="right">&nbsp;<?php echo ($acuenta_gasto_gral);?></td> 
             <td align="right">
			 <?php 
			 echo ($monto_gasto_gral-$acuenta_gasto_gral);
			  $totalDeuda=$totalDeuda+($monto_gasto_gral-$acuenta_gasto_gral);
			 ?>
             <input type="hidden" name="saldo_gasto_gral<?php echo $cod_gasto_gral;?>" id="saldo_gasto_gral<?php echo $cod_gasto_gral;?>" value="<?php echo ($monto_gasto_gral-$acuenta_gasto_gral);?>"></td>       

			<td align="right">
			  <input type="text" name="monto_pago_gasto_gral<?php echo $cod_gasto_gral; ?>" id="monto_pago_gasto_gral<?php echo $cod_gasto_gral; ?>" value="<?php echo ($monto_gasto_gral-$acuenta_gasto_hojaruta);?>" class="textoform" size="8" onKeyUp="validaFloat2(this)" onChange="validaFloat2(this)" >
            </td> 
                                                                 
          </tr>          
<?php
	
	}
?>
 
<tr>
<td colspan="6" align="right"><strong>Total Deuda</strong></td>
<td align="right"><div id="id_totalDeuda"><?php echo $totalDeuda;?></div></td>
<td align="right">&nbsp;</td>

</tr>
<tr>
<td colspan="6" align="right"><strong>Total Deuda Seleccionados</strong></td>
<td align="right"><div id="id_totalDeudaSeleccionados"><?php echo $totalDeuda;?></div></td>
<td align="right"><div id="id_montoDocBs" style="display:inline"><?php echo $totalDeuda;?></div>&nbsp;&nbsp;<strong>Bs</strong></td>

</tr>
<?php
	$sql="select cambio_bs from tipo_cambio where fecha_tipo_cambio='".date('Y-m-d', time())."'";
	$resp= mysql_query($sql);
	$cambio_bs=0;
	while($dat=mysql_fetch_array($resp)){
		$cambio_bs=$dat['cambio_bs'];
	}
?>

<tr>
<td colspan="13">
<table border="0" cellpadding="0" cellspacing="1" width="100%">
 <tr class="titulo_tabla" height="20">
<td colspan="4" align="center"><strong> BOLIVIANOS</strong></td>
<td colspan="4" align="center">DOLARES</td>
</tr>
 <tr class="titulo_tabla" height="20">
<td colspan="2" align="center"><strong>Monto Pago</strong></td>
<td align="center">Banco</td>
<td align="center">Nro Cheque/ Nro Cta.</td>
<td colspan="2" align="center"><strong>Monto Pago</strong></td>
<td align="center">Banco</td>
<td align="center">Nro Cheque/ Nro Cta.</td>
</tr>
<?php
					$sql2=" select cod_forma_pago, desc_forma_pago";
					$sql2.=" from   forma_pago  ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_forma_pago=$dat2['cod_forma_pago'];	
			  		 		$desc_forma_pago=$dat2['desc_forma_pago'];	
?>

<tr>
<td ><strong><?php echo $desc_forma_pago; ?></strong></td>
<td  align="right"><input type="text" class="textoform" name="montoPagoBs<?php echo $cod_forma_pago;?>" id="formaPagoBs<?php echo $cod_forma_pago;?>" size="7" onKeyUp="validaFloat(this)" onChange="validaFloat(this)" value="0"></td>
<td  align="right">
<?php if($cod_forma_pago==2 or $cod_forma_pago==3){?>
<select name="bancoBs<?php echo $cod_forma_pago;?>" id="bancoBs<?php echo $cod_forma_pago;?>" class="textoform" >
				<?php
					$sql3=" select cod_banco, desc_banco";
					$sql3.=" from   bancos ";
					$sql3.=" order by desc_banco asc ";
					$resp3=mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3))
						{
							$cod_banco=$dat3['cod_banco'];	
			  		 		$desc_banco=$dat3['desc_banco'];	
				 ?>
                 <option value="<?php echo $cod_banco;?>"><?php echo utf8_decode($desc_banco);?></option>				
				<?php		
					}
				?>						
			</select>
				<?php		
					}
				?>				
			</td>
<td  align="right">
<?php if($cod_forma_pago==2 ){?>
						<input type="text"  class="textoform" size="12" name="nro_chequeBs<?php echo $cod_forma_pago;?>" id="nro_chequeBs<?php echo $cod_forma_pago;?>" >

<?php }?>
<?php if($cod_forma_pago==3){?>
						<input type="text"  class="textoform" size="12" name="nro_cuentaBs<?php echo $cod_forma_pago;?>" id="nro_cuentaBs<?php echo $cod_forma_pago;?>" >

<?php }?>
</td>					
<td  align="left"><strong><?php echo $desc_forma_pago; ?></strong></td>
<td  align="right"><input type="text" class="textoform" name="montoPagoSus<?php echo $cod_forma_pago;?>" id="formaPagoSus<?php echo $cod_forma_pago;?>" size="7" onKeyUp="validaFloat(this)" onChange="validaFloat(this)" value="0"></td>
<td  align="right">
<?php if($cod_forma_pago==2 or $cod_forma_pago==3){?>
<select name="bancoSus<?php echo $cod_forma_pago;?>" id="bancoSus<?php echo $cod_forma_pago;?>" class="textoform" >
				<?php
					$sql3=" select cod_banco, desc_banco";
					$sql3.=" from   bancos ";
					$sql3.=" order by desc_banco asc ";
					$resp3=mysql_query($sql3);
						while($dat3=mysql_fetch_array($resp3))
						{
							$cod_banco=$dat3['cod_banco'];	
			  		 		$desc_banco=$dat3['desc_banco'];	
				 ?>
                 <option value="<?php echo $cod_banco;?>"><?php echo utf8_decode($desc_banco);?></option>				
				<?php		
					}
				?>						
			</select>
				<?php		
					}
				?>				
			</td>

<td  align="right">
<?php if($cod_forma_pago==2 ){?>
						<input type="text"  class="textoform" size="12" name="nro_chequeSus<?php echo $cod_forma_pago;?>" id="nro_chequeSus<?php echo $cod_forma_pago;?>" >

<?php }?>
<?php if($cod_forma_pago==3){?>
						<input type="text"  class="textoform" size="12" name="nro_cuentaSus<?php echo $cod_forma_pago;?>" id="nro_cuentaSus<?php echo $cod_forma_pago;?>" >

<?php }?>
</td>
</tr>
<?php
		}
?>
<tr align="right">
<td ><strong>Total Bs </strong>&nbsp;&nbsp;</td>
     		<td align="left" colspan="3"><div id="id_totalBs" align="right"  style="display:inline">0</div><strong>&nbsp;&nbsp;Bs.</strong>
			</td>
<td ><strong>Total $us </strong>&nbsp;&nbsp;</td>			
     		<td align="left" colspan="3"><div id="id_totalSus" align="right"  style="display:inline">0</div>
     		<strong>&nbsp;&nbsp;$us</strong> <strong></strong>&nbsp;&nbsp;<?php echo $cambio_bs;?>&nbsp;Bs.<strong>Bolivianos</strong>
     		<div id="id_totalBsSus" align="right"  style="display:inline">0</div><strong>&nbsp;&nbsp;Bs.</strong>
			</td>			
			</tr>
			
<tr align="right">
     		<td align="right" colspan="8"><strong>Total Pago:</strong>&nbsp;&nbsp;<div id="id_totalPagoProveedorBs" align="right"  style="display:inline">0</div><strong>&nbsp;&nbsp;Bs.</strong>
			<a href="javascript:distribuirDinero();"><img src="images/repartir.jpg" width="30" height="30" border="0" title="Distribuir"></a></td>
			</tr>
</table>
</td>
</tr>
     
        </table>

        <div align="center">
        <INPUT type="button" class="boton" name="btn_guardar" value="Guardar Pago" onClick="guardar(this.form);"  >
        </div>
<?php
	}
?>            
</body>
</html>