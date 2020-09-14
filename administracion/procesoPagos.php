<?php
require_once("conexion.inc");
include("funciones.php");
set_time_limit(1200);

?>
<table border="0" cellpadding="0" cellspacing="1">

<tr><td>Nro Pago</td><td>Cliente</td><td>Detalle</td><td>Detalle Pagos</td></tr>

<?php
	$sql=" select p.cod_pago, p.nro_pago, p.cod_gestion,g.gestion,p.cod_cliente, c.nombre_cliente ";
	$sql.=" from pagos p ";
	$sql.=" left join gestiones g on( p.cod_gestion=g.cod_gestion) ";
	$sql.=" left join clientes c on( p.cod_cliente=c.cod_cliente) ";
	$resp= mysql_query($sql);;
	while($dat=mysql_fetch_array($resp)){
		$cod_pago=$dat['cod_pago'];
		$nro_pago=$dat['nro_pago'];
		$cod_gestion=$dat['cod_gestion'];
		$gestion=$dat['gestion'];
		$cod_cliente=$dat['cod_cliente'];
		$nombre_cliente=$dat['nombre_cliente'];
		$sql2=" select count(*) from pagos_detalle where cod_pago=".$cod_pago."";
		$resp2= mysql_query($sql2);
		$nrodetalle=0;
		while($dat2=mysql_fetch_array($resp2)){
			$nrodetalle=$dat2[0];
		}
		

		
		$sql2=" select count(*) from pagos_detalle where cod_pago=".$cod_pago." and  cod_moneda=1";
		$resp2= mysql_query($sql2);
		$nroMonedaBs=0;
		while($dat2=mysql_fetch_array($resp2)){
			$nroMonedaBs=$dat2[0];
		}
		$sql2=" select count(*) from pagos_detalle where cod_pago=".$cod_pago." and  cod_moneda=2";
		$resp2= mysql_query($sql2);
		$nroMonedaExtranjera=0;
		while($dat2=mysql_fetch_array($resp2)){
			$nroMonedaExtranjera=$dat2[0];
		}

		
		if($nroMonedaExtranjera==0 and $nrodetalle>0 ){
		
			$sql3="select cod_forma_pago from forma_pago";
			echo $sql3;
			$resp3= mysql_query($sql3);
			while($dat3=mysql_fetch_array($resp3)){
				$cod_forma_pago=$dat3['cod_forma_pago'];
				
				$sql4="select count(*) from pagos_detalle  where cod_pago=".$cod_pago." and  cod_forma_pago=".$cod_forma_pago;
				$resp4= mysql_query($sql4);
				$nroAux=0;
				while($dat4=mysql_fetch_array($resp4)){
					$nroAux=$dat4[0];
				}
				
				
				if($nroAux>0){
					$sql5="select sum(monto_pago_detalle) from pagos_detalle  where cod_pago=".$cod_pago." and  cod_forma_pago=".$cod_forma_pago;
					$resp5= mysql_query($sql5);
					$montoPagoFPAux=0;
					while($dat5=mysql_fetch_array($resp5)){
						$montoPagoFPAux=$dat5[0];
					}
					$cod_banco=0;
					$nro_cheque='';
					$nro_cuenta='';
					if($cod_forma_pago==2 or $cod_forma_pago==3){	
						$sql5="select cod_banco,nro_cheque,nro_cuenta from pagos_detalle  where cod_pago=".$cod_pago." and  cod_forma_pago=".$cod_forma_pago;
						$resp5= mysql_query($sql5);
						$montoPagoFPAux=0;
						while($dat5=mysql_fetch_array($resp5)){
							$cod_banco=$dat5['cod_banco'];
							$nro_cheque=$dat5['nro_cheque'];
							$nro_cuenta=$dat5['nro_cuenta'];
						}
					}
					
					$sql6=" insert into pagos_descripcion set";
					$sql6.=" cod_pago=".$cod_pago.",";
					$sql6.=" cod_forma_pago=".$cod_forma_pago.",";
					$sql6.=" monto_pago=".$montoPagoFPAux.",";
					$sql6.=" cod_moneda=1,";
					$sql6.=" cod_banco=".$cod_banco.",";
					$sql6.=" nro_cheque='".$nro_cheque."',";
					$sql6.=" nro_cuenta='".$nro_cuenta."'";	
					echo $sql6."<br/>";
					mysql_query($sql6);			
				
				}
			}
						$sql9="select sum(monto_pago) from pagos_descripcion where cod_pago=".$cod_pago;
						echo $sql9;
			$resp9= mysql_query($sql9);
			$montoPagoDescripcion=0;
			while($dat9=mysql_fetch_array($resp9)){
				$montoPagoDescripcion=$dat9[0];
			}
			 $sql8=" update pagos set";
			 $sql8.=" total_bs=".$montoPagoDescripcion.",";
			 $sql8.=" cod_usuario_modifica=2,";
			 $sql8.=" fecha_modifica='2013-03-23'";
			 $sql8.=" where cod_pago=".$cod_pago;
			 echo $sql8."<br/>";
			  mysql_query($sql8);
			$sql9="select total_bs from pagos where cod_pago=".$cod_pago;
			$resp9= mysql_query($sql9);
			$total_bsFinal=0;
			while($dat9=mysql_fetch_array($resp9)){
				$total_bsFinal=$dat9[0];
			}

			  
			$sql9="select sum(monto_pago_detalle) from pagos_detalle where cod_pago=".$cod_pago;
			$resp9= mysql_query($sql9);
			$montoPagoDetalle=0;
			while($dat9=mysql_fetch_array($resp9)){
				$montoPagoDetalle=$dat9[0];
			}

			}
			

			
		
	//}
		
?>
<tr <?php if($nroMonedaExtranjera>0){ ?> style="background-color:#FF0000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"<?php }?>>
	<td><?php echo $nro_pago."/".$gestion." (".$cod_pago.")";?></td>
	<td><?php echo $nombre_cliente;?></td>
	<td><?php echo "Nro:".$nrodetalle." Nro Pago Bs: ".$nroMonedaBs." Nro Pago Sus: ".$nroMonedaExtranjera; ?></td>
	<td><?php echo "Tabla Pago:".$total_bsFinal." Tabla Pago Descipcion:".$montoPagoDescripcion." Tabla Pago Detalle:".$montoPagoDetalle; ?></td>
</tr>
<?php				
	}	
?>
</table>
<?php	
		 
require("cerrar_conexion.inc");
?>
