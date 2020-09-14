
<?php 

	require("conexion.inc");
	include("funciones.php");
	
	$cod_pago_prov=$_GET['cod_pago_prov'];
	$sql=" select pp.cod_pago_prov, pp.cod_proveedor,p.nombre_proveedor, pp.nro_pago_prov, pp.cod_gestion,";
	$sql.=" g.gestion_nombre, pp.fecha_pago_prov,pp.cod_estado_pago_prov, epp.desc_estado_pago_prov,";
	$sql.=" pp.cod_usuario_pago_prov, pp.obs_pago_prov, pp.monto_pago_prov,";
	$sql.=" pp.fecha_registro,  pp.cod_usuario_registro, ur.nombres_usuario as nom_usu_reg,ur.ap_paterno_usuario as paterno_usu_reg,";
	$sql.=" pp.fecha_modifica, pp.cod_usuario_modifica, um.nombres_usuario as nom_usu_mod, um.ap_paterno_usuario as paterno_usu_mod,";
	$sql.=" pp.fecha_anulacion,pp.obs_anulacion, pp.cod_usuario_anulacion, ua.nombres_usuario as nom_usu_anu, ua.ap_paterno_usuario as paterno_usu_anu,";
	$sql.=" pp.cod_cbte";
	$sql.=" from pago_proveedor pp ";
	$sql.=" left JOIN proveedores p on (pp.cod_proveedor=p.cod_proveedor)";
	$sql.=" left JOIN gestiones g on (pp.cod_gestion=g.cod_gestion)";
	$sql.=" left JOIN estado_pago_proveedor epp on (pp.cod_estado_pago_prov=epp.cod_estado_pago_prov)";
	$sql.=" left join usuarios ur on(pp.cod_usuario_registro=ur.cod_usuario)";
	$sql.=" left join usuarios um on(pp.cod_usuario_modifica=um.cod_usuario)";
	$sql.=" left join usuarios ua on(pp.cod_usuario_anulacion=ua.cod_usuario)";
	$sql.=" where cod_pago_prov=".$_GET['cod_pago_prov'];
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
				$cod_pago_prov=$dat['cod_pago_prov'];
				$cod_proveedor=$dat['cod_proveedor'];
				$nombre_proveedor=$dat['nombre_proveedor'];
				$nro_pago_prov=$dat['nro_pago_prov'];
				$cod_gestion=$dat['cod_gestion'];
				$gestion_nombre=$dat['gestion_nombre'];
				$fecha_pago_prov=$dat['fecha_pago_prov'];
				$cod_estado_pago_prov=$dat['cod_estado_pago_prov'];
				$desc_estado_pago_prov=$dat['desc_estado_pago_prov'];
				$cod_usuario_pago_prov=$dat['cod_usuario_pago_prov'];
				$obs_pago_prov=$dat['obs_pago_prov'];
				$monto_pago_prov=$dat['monto_pago_prov'];
				$fecha_registro=$dat['fecha_registro'];
				$cod_usuario_registro=$dat['cod_usuario_registro'];
				$nom_usu_reg=$dat['nom_usu_reg'];
				$paterno_usu_reg=$dat['paterno_usu_reg'];
				$fecha_modifica=$dat['fecha_modifica'];
				$cod_usuario_modifica=$dat['cod_usuario_modifica'];
				$nom_usu_mod=$dat['nom_usu_mod'];
				$paterno_usu_mod=$dat['paterno_usu_mod'];
				$fecha_anulacion=$dat['fecha_anulacion'];
				$obs_anulacion=$dat['obs_anulacion'];
				$cod_usuario_anulacion=$dat['cod_usuario_anulacion'];
				$nom_usu_anu=$dat['nom_usu_anu'];
				$paterno_usu_anu=$dat['paterno_usu_anu'];
				$cod_cbte=$dat['cod_cbte'];
			

		
			
			$sql3="select cambio_bs from tipo_cambio";
		$sql3.=" where fecha_tipo_cambio='".$fecha_registro."'";
		$sql3.=" and cod_moneda=2";
		$resp3 = mysql_query($sql3);
		$cambio_bs=0;
		while($dat3=mysql_fetch_array($resp3)){
			$cambio_bs=$dat3['cambio_bs'];
		}

}

	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>IMPRENTA</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->


<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">PAGO A PROVEEDOR </br> No. <?php echo $nro_pago_prov;?>/<?php echo $gestion_nombre;?></h3>



	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="4" align="center">DATOS</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Proveedor:</td>
      		<td colspan="3"><?php echo $nombre_proveedor;?></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha de Pago:</td>
      		<td colspan="3"><?php echo strftime("%d/%m/%Y",strtotime($fecha_pago_prov));?></td>
    	</tr>		
		 <tr bgcolor="#FFFFFF">
     		<td>Monto Total de Pago</td>
      		<td colspan="3"><?php echo $monto_pago_prov." Bs.";?></td>
    	</tr>		 
		 <tr bgcolor="#FFFFFF">
     		<td>Estado de Pago</td>
      		<td colspan="3"><?php echo $desc_estado_pago_prov;?></td>
    	</tr>  
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha Registro:</td>
      		<td colspan="3"><?php 
			if($nom_usu_reg<>"" && $nom_usu_reg<>NULL){
				echo strftime("%d/%m/%Y",strtotime($fecha_registro))." ".$nom_usu_reg." ".$paterno_usu_reg;
			}
			?></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha Ultima Edicion:</td>
      		<td colspan="3"><?php 
			if($nom_usu_mod<>"" && $nom_usu_mod<>NULL){
				echo strftime("%d/%m/%Y",strtotime($fecha_modifica))." ".$nom_usu_mod." ".$paterno_usu_mod;
			}	
			?></td>
    	</tr>		
					
		 <tr class="titulo_tabla">
		   <td  colSpan="4" align="center">Detalle de Pago</td>
		 </tr> 	
		 <tr class="titulo_tabla">
		   <td  align="center">Monto</td>
		   <td  align="center">Forma de Pago</td>
		   <td  align="center">Banco</td>
		   <td  align="center">Nro Cheque/Cuenta </td>
		 </tr> 		

		<?php
		$sql2=" select ppd.cod_forma_pago,fp.desc_forma_pago,ppd.cod_moneda,mon.desc_moneda, mon.abrev_moneda,";
		$sql2.=" ppd.monto_pago_prov,";
		$sql2.=" ppd.cod_banco, ban.desc_banco, ppd.nro_cheque,ppd.nro_cuenta";
		$sql2.=" from pago_proveedor_descripcion ppd";
		$sql2.=" left JOIN forma_pago fp on(ppd.cod_forma_pago=fp.cod_forma_pago)";
		$sql2.=" left join monedas mon on (ppd.cod_moneda=mon.cod_moneda)";
		$sql2.=" left join bancos ban on (ppd.cod_banco=ban.cod_banco)";
		$sql2.=" where ppd.cod_pago_prov=".$_GET['cod_pago_prov'];
		
		//echo $sql2;
		$resp2 = mysql_query($sql2);
		while($dat2=mysql_fetch_array($resp2)){
			$cod_forma_pago=$dat2['cod_forma_pago'];
			$desc_forma_pago=$dat2['desc_forma_pago'];
			$cod_moneda=$dat2['cod_moneda'];
			$desc_moneda=$dat2['desc_moneda'];
			$abrev_moneda=$dat2['abrev_moneda'];
			$monto_pago_prov=$dat2['monto_pago_prov'];
			$cod_banco=$dat2['cod_banco'];
			$desc_banco=$dat2['desc_banco'];
			$nro_cheque=$dat2['nro_cheque'];
			$nro_cuenta=$dat2['nro_cuenta'];
	?>
		 <tr bgcolor="#FFFFFF">
     		<td align="right"><?php echo $monto_pago_prov." ".$abrev_moneda; 
			if($cod_moneda==2){
				echo " ( T.C. ".$cambio_bs." Equivale: ".$monto_pago_prov*$cambio_bs." Bs. )";
			}
			?></td>
			<td align="right"><?php echo $desc_forma_pago; ?></td>
			<td align="right"><?php echo $desc_banco; ?></td>
			<td align="right"><?php echo $nro_cheque.$nro_cuenta; ?></td>
    	</tr> 
	<?php			
		}
		
		?> 
		        <?php if($cod_estado_pago_prov==2){?>  
		 <tr class="titulo_tabla">
		   <td  colSpan="4" align="center">Datos de Anulaci&oacute;n</td>
		 </tr>        
        <tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
      		<td colspan="3"><?php echo $obs_anulacion;?></td>
    	</tr>
       <tr bgcolor="#FFFFFF">
     		<td>Fecha Anulaci&oacute;n</td>
      		<td colspan="3">
			<?php 
			if($nom_usu_anu<>"" && $nom_usu_anu<>NULL){
				echo strftime("%d/%m/%Y",strtotime($fecha_anulacion))." ".$nom_usu_anu." ".$paterno_usu_anu;
			}	?></td>
    	</tr>
                         
       <?php }?>                   
		</table>
		<div id="divDetallePago">
        <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1">
          <tr class="titulo_tabla">
            <td align="center" height="20">Tipo Doc</td>
            <td align="center" height="20">Nro Doc </td>
            <td align="center" height="20">Fecha DOC</td>              
            <td align="center" height="20">Monto DOC</td> 
            <td align="center" height="20">Descripcion</td>                    
            <td align="center" height="20">Monto Pago(Bs)</td>
			<td align="center" height="20">Estado Actual DOC</td>            
           </tr>
		    <?php  
        
				$sql2=" select ppd.cod_pago_prov_detalle, ppd.codigo_doc, i.nro_ingreso, i.total_bs, g.gestion,i.fecha_ingreso,";
				$sql2.=" i.cod_estado_pago_doc, ppd.monto_pago_prov_detalle";
				$sql2.=" from pago_proveedor_detalle ppd, ingresos i, gestiones g ";
				$sql2.=" where ppd.cod_pago_prov=".$_GET['cod_pago_prov'];
				$sql2.=" and ppd.codigo_doc=i.cod_ingreso ";
				$sql2.=" and ppd.cod_tipo_doc=4";
				$sql2.=" and i.cod_gestion=g.cod_gestion ";
				$sql2.=" order by i.fecha_ingreso asc, i.nro_ingreso asc, g.gestion asc";
				
				$resp2 = mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$cod_pago_prov_detalle=$dat2['cod_pago_prov_detalle'];
					$cod_ingreso=$dat2['codigo_doc'];
					$gestion=$dat2['gestion'];
					$nro_ingreso=$dat2['nro_ingreso'];
					$total_bs=$dat2['total_bs'];
					$fecha_ingreso=$dat2['fecha_ingreso'];
					$cod_estado_pago_doc=$dat2['cod_estado_pago_doc'];
					$monto_pago_prov_detalle=$dat2['monto_pago_prov_detalle'];		
				
			?>   
<?php 

if($total_bs<>"" && $total_bs<>NULL){
	$monto_ingreso=$total_bs;
}else{
	 				$monto_ingreso=0;
			 		$sql5=" select sum(id.precio_compra_uni*id.cantidad) ";
					$sql5.=" from ingresos_detalle id ";
					$sql5.=" where id.cod_ingreso=".$cod_ingreso;
					$resp5 = mysql_query($sql5);
					while($dat5=mysql_fetch_array($resp5)){
						$monto_ingreso=$dat5[0];
					}
					}
									$total_pago=$total_pago+$monto_ingreso;
			 ?>                   
          <tr  <?php if($descuento_cotizacion>0){ ?> bgcolor="#FFCC00" <?php }else{?>bgcolor="#FFFFFF"<?php } ?>>
            <td align="left">INGRESO</td> 
            <td align="left"><?php echo $nro_ingreso."/".$gestion; ?></td> 
            <td align="left"><?php echo strftime("%d/%m/%Y",strtotime($fecha_ingreso)); ?></td> 
            <td align="right">&nbsp;<?php echo $monto_ingreso; ?></td> 
            <td align="right">&nbsp;</td> 
            <td align="right">&nbsp;<?php echo $monto_pago_prov_detalle; ?></td> 
            <td align="center"><?php 
			
			$sql3=" select desc_estado_pago_doc ";
			$sql3.=" from estado_pago_documento ";
			$sql3.=" where cod_estado_pago_doc=".$cod_estado_pago_doc;
			$resp3 = mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3)){
							$desc_estado_pago_doc=$dat3['desc_estado_pago_doc'];
				}
				echo $desc_estado_pago_doc;
			
			 ?></td>              
          </tr> 
          
         <?php }?>  
<?php  
        
				$sql2=" select ppd.cod_pago_prov_detalle, ppd.codigo_doc, gg.nro_gasto_gral, g.gestion,gg.fecha_gasto_gral,gg.monto_gasto_gral,";
 				$sql2.=" gg.cod_estado_pago_doc, ppd.monto_pago_prov_detalle ";
 				$sql2.=" from pago_proveedor_detalle ppd, gastos_gral gg, gestiones g ";
 				$sql2.=" where ppd.cod_pago_prov=".$_GET['cod_pago_prov'];
 				$sql2.=" and ppd.codigo_doc=gg.cod_gasto_gral ";
 				$sql2.=" and ppd.cod_tipo_doc=5 ";
 				$sql2.=" and gg.cod_gestion=g.cod_gestion ";
 				$sql2.=" order by gg.fecha_gasto_gral asc, gg.nro_gasto_gral asc, g.gestion asc";
 
				$resp2 = mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$cod_pago_detalle=$dat2['cod_pago_detalle'];
					$cod_gasto_gral=$dat2['codigo_doc'];
					$nro_gasto_gral=$dat2['nro_gasto_gral'];					
					$gestion=$dat2['gestion'];
					$fecha_gasto_gral=$dat2['fecha_gasto_gral'];
					$cod_estado_pago_doc=$dat2['cod_estado_pago_doc'];
					$monto_pago_prov_detalle=$dat2['monto_pago_prov_detalle'];
					$monto_gasto_gral=$dat2['monto_gasto_gral'];
				
					
				
			
					$total_pago=$total_pago+$monto_pago_prov_detalle;
				
					
			 ?>                   
          <tr  bgcolor="#FFFFFF">
            <td align="left">GASTO</td> 
            <td align="left"><?php echo $nro_gasto_gral."/".$gestion; ?></td> 
            <td align="left"><?php echo strftime("%d/%m/%Y",strtotime($fecha_gasto_gral)); ?></td> 
            <td align="right">&nbsp;<?php echo $monto_gasto_gral; ?></td>                       
            <td align="right">&nbsp;</td>       
			<td align="right"><?php echo $monto_pago_prov_detalle;?></td>       
			 <td align="center"><?php 
			
			$sql3=" select desc_estado_pago_doc ";
			$sql3.=" from estado_pago_documento ";
			$sql3.=" where cod_estado_pago_doc=".$cod_estado_pago_doc;
			$resp3 = mysql_query($sql3);
				while($dat3=mysql_fetch_array($resp3)){
							$desc_estado_pago_doc=$dat3['desc_estado_pago_doc'];
				}
				echo $desc_estado_pago_doc;
			
			 ?></td>   			            
          </tr> 
          
         <?php }?>   		
         <tr class="titulo_tabla">
             <td align="right" colspan="5">Monto Total Bs.</td> 
            <td align="right"><?php echo $total_pago." Bs."; ?></td> 
            <td align="right" colspan="1">&nbsp;</td> 
            <tr>   		 
		   </table>
		</div>   
	         
      </div>    
      <br/>


</body>
</html>
