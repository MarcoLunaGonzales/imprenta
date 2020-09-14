
<?php
	require("conexion.inc");
	include("funciones.php");
	$sql=" select max(inf_aud_cod) from informe_auditoria where cod_hoja_ruta=".$_GET['hr']."";
	$inf_aud_cod=obtenerCodigo($sql);
	
	$sqlAux2=" update hojas_rutas set";
	if($_GET['estado']=="SI"){
		$sqlAux2.=" informe='SI'";				
	}
	if($_GET['estado']=="NO"){
		$sqlAux2.=" informe='NO'";
	}
	$sqlAux2.=" where cod_hoja_ruta='".$_GET['hr']."'";
	mysql_query($sqlAux2);
	
	$sql="select cod_hoja_ruta,informe from hojas_rutas  where cod_hoja_ruta='".$_GET['hr']."'";
	$resp= mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$cod_hoja_ruta=$dat['cod_hoja_ruta'];
		$informe=$dat['informe'];
	}
		$sqlAux3=" insert into informe_auditoria set ";
		$sqlAux3.=" cod_hoja_ruta=".$_GET['hr'].",";
		$sqlAux3.=" inf_aud_cod=".$inf_aud_cod.",";
		$sqlAux3.=" cod_usuario=".$_COOKIE['usuario_global'].",";
		$sqlAux3.=" inf_aud_fecha='".date('Y-m-d h:i:s', time())."',";
		if($_GET['estado']=="SI"){
			$sqlAux3.=" inf_aud_obs='CERRADO'";
		}
		if($_GET['estado']=="NO"){
			$sqlAux3.=" inf_aud_obs='ABIERTO'";
		}
		mysql_query($sqlAux3);	
	//echo "holaaaaaaaaaa";
?>
<?php if($informe=="NO"){?><a href="javascript:cambiarEstadoInf(<?php echo $cod_hoja_ruta; ?>,'SI')" >CERRAR</a><?php }?>
			<?php if($informe=="SI"){?><img src="images/cerrado.jpg" height="25px" width="25px"><br/><a href="javascript:cambiarEstadoInf(<?php echo $cod_hoja_ruta; ?>,'NO')" >ABRIR</a><?php }?>