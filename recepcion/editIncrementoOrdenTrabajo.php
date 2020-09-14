<?php
	require("conexion.inc");
	

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>INVENTA</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />

<script language='Javascript'>

	function cerrarVentana(){
			window.close();
	}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>
<body >
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="saveEditIncrementoOrdenTrabajo.php" name="form1">

<?php 

	$cod_orden_trabajo=$_POST['cod_orden_trabajo'];
	
?>
<input type="hidden" name="cod_orden_trabajo" id="cod_orden_trabajo" value="<?php echo $_POST['cod_orden_trabajo']; ?>">
<?php
	
		$sql=" select nro_orden_trabajo, numero_orden_trabajo, cod_gestion, fecha_orden_trabajo, cod_cliente,";	
		$sql.="  cod_contacto, monto_orden_trabajo,detalle_orden_trabajo,";
		$sql.=" incremento_orden_trabajo, incremento_fecha, incremento_obs,";
		$sql.=" descuento_orden_trabajo, descuento_fecha, descuento_obs ";
		$sql.=" from ordentrabajo";
		$sql.=" where cod_orden_trabajo=".$_POST['cod_orden_trabajo'];
		$resp = mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){

			$nro_orden_trabajo=$dat['nro_orden_trabajo'];
			$numero_orden_trabajo=$dat['numero_orden_trabajo'];
			$cod_gestion=$dat['cod_gestion'];
			$fecha_orden_trabajo=$dat['fecha_orden_trabajo'];
			$cod_cliente=$dat['cod_cliente'];
			$cod_contacto=$dat['cod_contacto'];
 			$monto_orden_trabajo=$dat['monto_orden_trabajo'];
			$detalle_orden_trabajo=$dat['detalle_orden_trabajo'];
			$incremento_orden_trabajo=$dat['incremento_orden_trabajo'];
			$incremento_fecha=$dat['incremento_fecha'];
			$incremento_obs=$dat['incremento_obs'];
			$descuento_orden_trabajo=$dat['descuento_orden_trabajo'];
			$descuento_fecha=$dat['descuento_fecha'];
			$descuento_obs=$dat['descuento_obs'];

			    $sql2="  select gestion from gestiones ";
				$sql2.=" where cod_gestion=".$cod_gestion;
				$resp2= mysql_query($sql2);
				$gestion="";
				while($dat2=mysql_fetch_array($resp2)){
					$gestion=$dat2['gestion'];
				}
				

			    $sql2="  select nombre_cliente from clientes ";
				$sql2.=" where cod_cliente=".$cod_cliente;
				$resp2= mysql_query($sql2);
				$nombre_cliente="";
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_cliente=$dat2['nombre_cliente'];
				}
				if($cod_contacto<>"" and $cod_contacto<>0){
				    $sql2="  select nombre_contacto, ap_paterno_contacto, ap_materno_contacto ";
					$sql2.=" from clientes_contactos ";
					$sql2.=" where cod_contacto=".$cod_contacto;
					$resp2= mysql_query($sql2);
					$nombre_completo_contacto="";
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_completo_contacto=$dat2['nombre_contacto']." ".$dat2['ap_paterno_contacto']." ".$dat2['ap_materno_contacto'];

					}
				}
	 	}
	
?>
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">EDICION DE INCREMENTO</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0">

		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">DETALLE DE DESCUENTO </td>
		 </tr>
		<tr bgcolor="#FFFFFF">
     		<td>Nro Orden Trabajo</td>
      		<td> <?php echo $nro_orden_trabajo."/".$gestion." (Nro. Int.".$numero_orden_trabajo.")"; ?> </td>
    	</tr>
		<tr bgcolor="#FFFFFF">
     		<td>Fecha Orden Trabajo</td>
      		<td> <?php echo strftime("%d/%m/%Y",strtotime($fecha_orden_trabajo));?> </td>
    	</tr>
		<tr bgcolor="#FFFFFF">
     		<td>Cliente</td>
      		<td><?php echo $nombre_cliente;
				if($nombre_completo_contacto<>""){
					echo " (Contacto:".$nombre_completo_contacto.")";
					}
			?></td>
    	</tr>			
		
		 <tr bgcolor="#FFFFFF">
     		<td>Monto </td>
      		<td>
			<?php
							echo $monto_orden_trabajo-$descuento_orden_trabajo." Bs.";

					
				 ?>
				 </td>
    	</tr>


		 <tr bgcolor="#FFFFFF">
     		<td>Monto de Incremento</td>
      		<td>

			<input type="text" name="incremento_orden_trabajo" id="incremento_orden_trabajo" value="<?php echo $incremento_orden_trabajo; ?>" class="textoform"></td>
    	</tr>      
		 <tr bgcolor="#FFFFFF">
     		<td>Obs. Incremento</td>
      		<td><textarea name="incremento_obs" id="incremento_obs" class="textoform" cols="60" ><?php echo $incremento_obs; ?></textarea></td>
    	</tr>
								

  </table>	
	<br>
<div align="center">
<INPUT type="button" class="boton"  value="Cancelar" onClick="cerrarVentana(this.form);"  >
<INPUT type="submit" class="boton" value="Guardar Cambios"   >
</div>
</form>

</body>
</html>
