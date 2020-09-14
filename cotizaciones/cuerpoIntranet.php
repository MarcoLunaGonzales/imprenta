<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SISTEMA DE GESTION</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="images/favicon.ico">

<script type="text/javascript" src="jquery-latest.pack.js"></script>
<script type="text/javascript" src="jquery.pngFix.js"></script> 
<script type="text/javascript"> 

</script>


</head>
<body>



<!--img src="images/cabecera.jpg" />
<!--cabecera inicio -->
<?php
	require("conexion.inc");
	$sql=" select  nombres_usuario, ap_paterno_usuario, ap_materno_usuario,cod_perfil  from usuarios ";
	$sql.=" where cod_usuario='".$_COOKIE['usuario_global']."'";
	$resp=mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
	
		$nombres_usuario=$dat[0]; 
		$ap_paterno_usuario=$dat[1];
		$ap_materno_usuario=$dat[2];
		$cod_perfil=$dat[3];

		
	}	
		
	$sql=" select  nombre_modulo, ubicacion_fisica  from modulos ";
			$sql.=" where cod_modulo=".$_GET['cod_modulo']."";
			$resp = mysql_query($sql);

			while($dat=mysql_fetch_array($resp)){																 		
				$nombre_modulo=$dat['nombre_modulo'];
	
			}
	
	
?>
<table width="980" border="0" cellpadding="0" cellspacing="0" bgcolor="#F3F9FC" id="Table_01" >
	<tr>
		<td colspan="3">
			<img src="images/banner1.jpg"  width="1024px" height="92"alt="" ></td>
	</tr>
	<tr>
		<td colspan="3"><img src="images/barraheader.jpg" alt="" width="1024px" >
		<div style="position: absolute; top:100px; left: 400px; margin: 10px; width: 1024px;">
  <span class="cabecera"><?php echo $nombre_modulo." - Usuario: ".$nombres_usuario." ".$ap_paterno_usuario; ?></span></div>

</td>
	</tr>
	</table>
<div id="nicemenu">
 <ul id="nav">
  <li><a href="listClientesProveedores.php" target="cuerpo">Clientes y Proveedores</a></li> 
	<li><a href="#">Cotizaciones</a>
      <ul>
    		
	        <li><a href="registrarCotizacion.php" target="cuerpo">Registro Cotizaci&oacute;n</a></li>
			<li><a href="listCotizaciones.php" target="cuerpo">Cotizaciones</a></li>
	
      </ul>	
    </li>
    </li>	
    <li><a href="listHojasRutas.php"target="cuerpo">Hojas de Ruta</a>
    </li>	    	
	
	
    <!--li><a href="navegadorNotasRemision.php" target="cuerpo">Notas de Remision</a-->
        <li><a href="listNotasRemision.php" target="cuerpo">Notas Remision</a>
    </li>	
	    <li><a href="#">Ordenes de Trabajo </a>
      <ul>
            <li><a href="newOrdenTrabajo.php" target="cuerpo">Registro de O.T.</a></li>    		
	        <li><a href="listOrdenTrabajo.php" target="cuerpo">Listado de O.T.</a></li>

                        
	
      </ul>	
    </li>

    
          
        <li><a href="#">Reportes</a>
      <ul>    		
	        <li><a href="../administracion/filtroRptCuentasCobrar.php" target="cuerpo">Cuentas por Cobrar</a></li>
            <li><a href="../administracion/filtroRptCotizacionesItem.php" target="cuerpo">Reporte Cotizaciones por Item</a></li>
            <!--li><a href="../administracion/rptClientes.php" target="cuerpo">Reporte Clientes</a></li>
            <li><a href="../administracion/rptProveedores.php" target="cuerpo">Reporte Proveedores</a></li-->
            <li><a href="selectAlmacen.php" target="cuerpo">Stock Materiales</a></li>	
      </ul>	
    </li>    
	
	<?php
				$sql="select count(*) from usuarios_modulos where cod_usuario=".$_COOKIE['usuario_global'];
				$resp = mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){	
			 			$numModulos=$dat[0];					
				}	
	?>
	<?php	if($numModulos>1) {?>

	    <li><a href="../modules.php">Menu de Modulos</a></li>	
	<?php } ?>
    <li><a href="../salirSistema.php">Salir de Sistema</a>
    </li>		
</ul>

</div>


<!--div id="right2"-->


<div id="body">
<!--right panel inicio -->
<div id="right2">
<p class="rightTop"></p>

<div id="cuerpoinformacion" style="width:1024px; margin-left:5px; margin-right:5px;">
<iframe src="listCotizaciones.php" width="972px" frameborder="0"  style="min-height:365px;"  name="cuerpo" ></iframe>
</div>


<p class="rightBottom"></p>
<br class="spacer" />
</div>

<!--right panel fin -->
<br class="spacer" />
</div>
<!--/div-->


</body>
</html>
