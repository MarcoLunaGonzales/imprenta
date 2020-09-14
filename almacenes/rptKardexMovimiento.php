<?php
	require("conexion.inc");
	include("funciones.php");
	include("funcionCantActualMaterial.php");
	
	$cod_almacen=$_COOKIE['cod_almacen_global'];
	$sqlAlmacen="select nombre_almacen from almacenes where cod_almacen=".$cod_almacen;
	$respAlmacen=mysql_query($sqlAlmacen);
	while($datAlmacen=mysql_fetch_array($respAlmacen)){
		$nombre_almacen=$datAlmacen['nombre_almacen'];
	}
	$cod_material=$_POST['cod_material'];
	
	$sql2=" select  m.cod_subgrupo, s.nombre_subgrupo, s.cod_grupo, g.nombre_grupo, ";  
	$sql2.=" m.cod_unidad_medida, um.nombre_unidad_medida, um.abrev_unidad_medida, m.nombre_material,";
	$sql2.=" m.desc_completa_material, m.stock_minimo, m.stock_maximo, m.cod_estado_registro";
	$sql2.=" from materiales m, subgrupos s, grupos g, unidades_medidas um";
	$sql2.=" where m.cod_unidad_medida=um.cod_unidad_medida ";
	$sql2.=" and m.cod_subgrupo=s.cod_subgrupo";
	$sql2.=" and s.cod_grupo=g.cod_grupo";
	$sql2.=" and m.cod_material=".$cod_material;
	$sql2.=" order by g.nombre_grupo asc, s.nombre_subgrupo asc";
	$resp2=mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2))
	{
			$cod_subgrupo=$dat2['cod_subgrupo'];
			$nombre_subgrupo=$dat2['nombre_subgrupo'];
			$cod_grupo=$dat2['cod_grupo'];
			$nombre_grupo=$dat2['nombre_grupo'];
			$cod_unidad_medida=$dat2['cod_unidad_medida'];
			$nombre_unidad_medida=$dat2['nombre_unidad_medida'];
			$abrev_unidad_medida=$dat2['abrev_unidad_medida'];
			$nombre_material=$dat2['nombre_material'];
			$desc_completa_material=$dat2['desc_completa_material'];
			$stock_minimo=$dat2['stock_minimo'];
			$stock_maximo=$dat2['stock_maximo'];
			$cod_estado_registro=$dat2['cod_estado_registro'];
	}
	$fecha_inicio=$_POST['fecha_inicio'];
	$fecha_final=$_POST['fecha_final'];
	if($fecha_inicio<>"" && $fecha_final<>"" ){
		list($dI,$mI,$aI)=explode("/",$fecha_inicio);	
		list($dF,$mF,$aF)=explode("/",$fecha_final);	
	}
	
	$fecha=$aI."-".$mI."-".$dI;
	$dias=1;
	/////////////////////////Saldos Iniciales//////////////////////
	$sumIngresosInicial=0;
	$sql=" select SUM(id.cantidad) ";
	$sql.=" from ingresos_detalle id, ingresos i ";
	$sql.=" where id.cod_material=".$cod_material;
	$sql.=" and id.cod_ingreso=i.cod_ingreso  ";
	$sql.=" and i.cod_estado_ingreso<>2  ";
	$sql.=" and i.cod_almacen=".$cod_almacen;
	if($fecha_inicio<>"" && $fecha_final<>"" ){
		$sql.=" and i.fecha_ingreso<'".$aI."-".$mI."-".$dI."'";
	}
	$resp=mysql_query($sql);
	while($dat=mysql_fetch_array($resp))
	{ 
		$sumIngresosInicial=$dat[0];
	}
	//echo "sumIngresosInicial=".$sumIngresosInicial;
	$sumSalidaInicial=0;
	$sql=" select sum(sd.cant_salida) ";
	$sql.=" from salidas_detalle sd, salidas s ";
	$sql.=" where sd.cod_material=".$cod_material;
	$sql.=" and sd.cod_salida=s.cod_salida ";
	$sql.=" and s.cod_almacen=".$cod_almacen;
	$sql.=" and s.cod_estado_salida<>2 ";
	$sql.=" and s.fecha_salida<'".$aI."-".$mI."-".$dI."'";
//	echo $sql;
	$resp=mysql_query($sql);
	while($dat=mysql_fetch_array($resp))
	{ 
		$sumSalidaInicial=$dat[0];
	}	
//echo "sumSalidaInicial=".$sumSalidaInicial;

	///////////////////////////////////////////////////////////////////
	$sql=" select max(aux_id) from aux_ingresossalidas ";
	$aux_id=obtenerCodigo($sql);
	
	$sql=" insert into aux_ingresossalidas(aux_id,cod_material,codigo,fecha_transaccion,tipo_trans,tipo,";
	$sql.=" nro_ing_sal, ges_ing_sal, tipo_ing_sal, motivo, observaciones, ingreso,salida, saldo) ";
	$sql.=" select ".$aux_id.",id.cod_material,id.cod_ingreso,i.fecha_ingreso,1,'Ingreso', i.nro_ingreso,  g.gestion,  ";
	$sql.=" i.cod_tipo_ingreso, ti.nombre_tipo_ingreso, i.obs_ingreso,SUM(id.cantidad),0,0 ";
	$sql.=" from ingresos_detalle id, ingresos i, gestiones g, tipos_ingreso ti ";
	$sql.=" where id.cod_material=".$cod_material;
	$sql.=" and id.cod_ingreso=i.cod_ingreso ";
	$sql.=" and i.cod_estado_ingreso<>2 ";
	$sql.=" and i.cod_gestion=g.cod_gestion ";
	$sql.=" and i.cod_tipo_ingreso=ti.cod_tipo_ingreso ";
	$sql.=" and i.cod_almacen=".$cod_almacen;
	if($fecha_inicio<>"" && $fecha_final<>"" ){
	$sql.=" and (i.fecha_ingreso>='".$aI."-".$mI."-".$dI."' and i.fecha_ingreso<='".$aF."-".$mF."-".$dF."') ";
	}
	$sql.=" group by id.cod_ingreso ";
	$sql.=" order by i.fecha_ingreso asc ";
	//echo $sql."<br/>";
	mysql_query($sql);
	
	
	$sql=" insert into aux_ingresossalidas(aux_id,cod_material,codigo,fecha_transaccion,tipo_trans,tipo,nro_ing_sal, ";
	$sql.=" ges_ing_sal, tipo_ing_sal, motivo, observaciones, ingreso,salida, saldo) ";
	$sql.=" select ".$aux_id.",sd.cod_material,sd.cod_salida,s.fecha_salida,2,'Salida',s.nro_salida,g.gestion,s.cod_tipo_salida,";
	$sql.=" ts.nombre_tipo_salida, s.obs_salida,0,sum(sd.cant_salida),0";
	$sql.=" from salidas_detalle sd, salidas s, gestiones g, tipos_salida ts";
	$sql.=" where sd.cod_material=".$cod_material;
	$sql.=" and sd.cod_salida=s.cod_salida";
	$sql.=" and s.cod_almacen=".$cod_almacen;
	$sql.=" and s.cod_gestion=g.cod_gestion";
	$sql.=" and s.cod_tipo_salida=ts.cod_tipo_salida";
	$sql.=" and s.cod_estado_salida<>2";
	if($fecha_inicio<>"" && $fecha_final<>"" ){
		$sql.=" and (s.fecha_salida>='".$aI."-".$mI."-".$dI."' and s.fecha_salida<='".$aF."-".$mF."-".$dF."')";
	}
	$sql.=" group by sd.cod_salida";
	$sql.=" order by s.fecha_salida asc";
	//echo $sql."<br/>";
	mysql_query($sql);


	

	$saldoInicialMaterial=$sumIngresosInicial-$sumSalidaInicial;
	$sumIngreso=0;
	$sql="select sum(ingreso) from aux_ingresossalidas where cod_material=".$cod_material." and aux_id=".$aux_id."";
	$resp=mysql_query($sql);
	while($dat=mysql_fetch_array($resp))
	{
		$sumIngreso=$dat[0];
	}
	$sumSalida=0;
	$sql="select sum(salida) from aux_ingresossalidas where cod_material=".$cod_material." and aux_id=".$aux_id."";
	$resp=mysql_query($sql);
	while($dat=mysql_fetch_array($resp))
	{
		$sumSalida=$dat[0];
	}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title></title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>


</script>
</head>
<body bgcolor="#FFFFFF">
<h3 align="center" style="background:#FFFFFF;font-size: 14px;color: #E78611;font-weight:bold;">KARDEX DE MOVIMIENTO</h3>
<!--h3 align="center" style="background:#F7F5F3;font-size: 12px;color: #663300;font-weight:bold;">ALMACEN: <?php echo $nombre_almacen;?></h3-->
<table border="0" align="center">
<tr>
<td>
<table border="0" align="left">
<tr><td class="fila_par"><strong>Material:</strong></td><td class="fila_par"><?php echo $desc_completa_material;?></td></tr>
<tr><td class="fila_par"><strong>Saldo Inicial (<?php echo  date("d/m/Y", strtotime("$fecha -$dias day"));?>):</strong></td><td class="fila_par"><?php echo $saldoInicialMaterial." ".$abrev_unidad_medida;?> </td></tr>
</table>
</td>
<td>
<table border="0" align="right">
<tr><td class="fila_par"><strong>Fecha Inicio:</strong></td><td class="fila_par"><?php echo $dI."/".$mI."/".$aI;?></td></tr>
<tr><td class="fila_par"><strong>Fecha Final:</strong></td><td class="fila_par"><?php echo $dF."/".$mF."/".$aF;?> </td></tr>
<tr><td class="fila_par"><strong>Almacen:</strong></td><td class="fila_par"><?php echo $nombre_almacen;?> </td></tr>
</table>
</td>
</tr>
</table>



<div align="center"><a onClick="window.print();">Imprimir</a>
</div>

<form name="form1" method="post" action="rptExistenciasAlmacen.php">

	<table width="95%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
    	    <tr height="20px" align="center"  class="titulo_tabla">
			  <td>Fecha</td>
              <td>Tipo</td>
              <td>Nro Ing/Sal</td>
              <td>Motivo</td>
              <td>Observaciones</td>	
              <td>Ingreso</td>
              <td>Salida</td>
              <td>Saldo</td>									
			</tr>             
	<?php 
	
		$sql=" select aux_id,cod_material, codigo, fecha_transaccion, tipo_trans, tipo, nro_ing_sal, ges_ing_sal,";
		$sql.=" tipo_ing_sal,motivo,observaciones, ingreso, salida,saldo ";
		$sql.=" from aux_ingresossalidas ";
		$sql.=" where cod_material=".$cod_material;
		$sql.=" and aux_id=".$aux_id;
		$resp=mysql_query($sql);
		$saldoMaterial=$saldoInicialMaterial;
		while($dat=mysql_fetch_array($resp))
		{
			$aux_id=$dat['aux_id'];
			$cod_material=$dat['cod_material'];
			$codigo=$dat['codigo'];
			$fecha_transaccion=$dat['fecha_transaccion'];
			list($anio,$mes,$dia)=explode("-",$fecha_transaccion);
			$tipo_trans=$dat['tipo_trans'];
			$tipo=$dat['tipo'];
			$nro_ing_sal=$dat['nro_ing_sal'];
			$ges_ing_sal=$dat['ges_ing_sal'];
			$tipo_ing_sal=$dat['tipo_ing_sal'];
			$motivo=$dat['motivo'];
			$observaciones=$dat['observaciones'];
			$ingreso=$dat['ingreso'];
			$salida=$dat['salida'];
			//$saldo=$dat['saldo'];
			$saldoMaterial=($saldoMaterial+$ingreso)-$salida;
		?>
        <tr bgcolor="#FFFFFF" class="<?php if($tipo_trans==1){ echo 'fila_par';}else{echo 'fila_impar';}?>">
	        <td><?php echo $dia."/".$mes."/".$anio;?></td>
            <td><?php echo $tipo;?></td>
            <td><?php echo $nro_ing_sal."/".$ges_ing_sal;?></td>
            <td><?php echo $motivo;?></td>
            <td><?php echo $observaciones;?></td>
            <td align="right"><?php echo number_format($ingreso,2)." ".$abrev_unidad_medida;?></td>
            <td align="right"><?php echo number_format($salida,2)." ".$abrev_unidad_medida;?></td>
        	<td align="right"><?php echo number_format($saldoMaterial,2)." ".$abrev_unidad_medida;?></td>    
        </tr>
        <?php		
		}
	?>
        <tr bgcolor="#FFFFFF" class="fila_par" >
	        <td colspan="5" align="right"><strong>TOTALES</strong></td>
            <td align="right"><strong><?php echo number_format(($sumIngreso+$saldoInicialMaterial),2)." ".$abrev_unidad_medida;?></strong></td>
            <td align="right"><strong><?php echo number_format($sumSalida,2)." ".$abrev_unidad_medida;?></strong></td>
        	<td align="right"><strong><?php echo number_format((($sumIngreso+$saldoInicialMaterial)-$sumSalida),2)." ".$abrev_unidad_medida;?></strong></td>    
        </tr>
	</table>


<?php
	$sql="delete from aux_ingresossalidas where aux_id=".$aux_id." and cod_material=".$cod_material."";
	mysql_query($sql);
?>		
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>

