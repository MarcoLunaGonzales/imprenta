<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>SISTEMA DE GESTION</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="images/favicon.ico">

<script type="text/javascript" src="jquery-latest.pack.js"></script>
<script type="text/javascript" src="jquery.pngFix.js"></script> 
<script type="text/javascript"> 
    $(document).ready(function(){ 
        $(document).pngFix(); 
    }); 
	function mainmenu(){
$(" #nav ul ").css({display: "none"}); // Opera Fix
$(" #nav li").hover(function(){
		$(this).find('ul:first').css({visibility: "visible",display: "none"}).show(400);
		},function(){
		$(this).find('ul:first').css({visibility: "hidden"});
		});
}
 $(document).ready(function(){					
	mainmenu();
});
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
<table width="980" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff" id="Table_01" >
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
<div id="nicemenu" >
 <ul id="nav">
 	  <li><a href="../cotizaciones/listClientesProveedores.php" target="cuerpo">Clientes y Proveedores</a></li> 
     <li><a href="#" target="cuerpo">Plan de Cuentas</a>
	       <ul>    		
	        <li><a href="listCuentas.php" target="cuerpo">Cuentas</a></li>
            <li><a href="listClientesCuentas.php" target="cuerpo">Clientes</a></li>
            <li><a href="listProveedoresCuentas.php" target="cuerpo">Proveedores</a></li>
      </ul>	
	 </li>
     <!--li><a href="listClientesCuentas.php" target="cuerpo">Clientes</a></li-->
     <!--li><a href="newComprobante.php" target="cuerpo">Registro de Comprobante</a></li-->
     <li><a href="listComprobantes.php" target="cuerpo">Comprobantes</a></li>

    </li>
  
	 <li><a href="#" target="cuerpo">Operaciones</a>    
		<ul>
		  <li><a href="../administracion/selectAlmacenIngreso.php" target="cuerpo">Ingresos</a> 
  <li><a href="../administracion/selectAlmacenSalida.php" target="cuerpo">Salidas</a> 		
 <li><a href="listCotizaciones.php" target="cuerpo">Cotizaciones</a>    														
    </li>  
 <li><a href="listHojasRutas.php" target="cuerpo">Hojas de Ruta</a>    														
    </li> 
 <li><a href="listOrdenTrabajo.php" target="cuerpo">Orden de Trabajo</a> </li>  
   <li><a href="listNotasRemision.php" target="cuerpo">Notas de Remision</a>
    </li>
		  <li><a href="listGastosGral.php" target="cuerpo">Gastos</a> </li>
	    </ul>														
    </li>  
   <li><a href="#">Cobranzas</a>
      <ul>    		
	        <li><a href="../administracion/listPagos.php" target="cuerpo">Listado de Pagos</a></li>
            <li><a href="../administracion/newPago.php" target="cuerpo">Registro de Pago</a></li>
			<li><a href="../administracion/newPago2.php" target="cuerpo">Registro de Pago - Traspaso</a></li>
      </ul>	
    </li>
    <li><a href="#">Pagos Proveedor</a>
      <ul>    		
			<li><a href="../administracion/listPagoProveedor.php" target="cuerpo">Lista Pago Proveedor</a></li>
            <li><a href="../administracion/newPagoProveedor.php" target="cuerpo">Registro de Pago Proveedor</a></li>			
			<!--li><a href="procesoIngresos.php" target="cuerpo">Proceso Ingresos</a></li-->
      </ul>	
    </li>	  
    <li><a href="#">Facturas</a>
      <ul>
    		
	        <li><a href="listFacturas.php" target="cuerpo">Listado de Facturas</a></li>
            <li><a href="newFactura.php" target="cuerpo">Registro de Factura</a></li>
			 <li><a href="imprimirFacturas.php" target="cuerpo">Reporte Facturas</a></li>
 <li><a href="filtroReporteFacturas.php" target="cuerpo">Reporte Facturas 2</a></li>			 
                        
	
      </ul>	
    </li>	   
    
        <li><a href="#">Reportes</a>
      <ul>  
	  <li><a href="filtroLibroDiario.php" target="cuerpo">Libro Diario</a></li>  
	  <li><a href="filtroEstadoCuenta.php" target="cuerpo">Estado de Cuenta</a></li>  		
	        <li><a href="../administracion/filtroRptCuentasCobrar.php" target="cuerpo">Cuentas por Cobrar</a></li>
            <li><a href="../administracion/filtroRptCotizacionesItem.php" target="cuerpo">Reporte Cotizaciones por Item</a></li>
            <li><a href="../administracion/rptClientes.php" target="cuerpo">Reporte Clientes</a></li>
            <li><a href="../administracion/rptProveedores.php" target="cuerpo">Reporte Proveedores</a></li>
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
<!--cabecera fin -->


<!--cuerpo inicio -->
<div id="body">
<!--right panel inicio -->
<div id="right2">
<p class="rightTop"></p>

<div id="cuerpoinformacion" style="width:1024px; margin-left:5px; margin-right:5px;">
<iframe src="listComprobantes.php" width="972px" frameborder="0"  style="min-height:365px;"  name="cuerpo" ></iframe>
</div>


<p class="rightBottom"></p>
<br class="spacer" />
</div>

<!--right panel fin -->
<br class="spacer" />
</div>
<!--body fin-->

<!--footer inicio -->
<!--footer fin -->
</body>
</html>
