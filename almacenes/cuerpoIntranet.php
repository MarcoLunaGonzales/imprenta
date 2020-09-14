
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>SISTEMA DE GESTION</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<!--link rel="shortcut icon" href="images/favicon.ico"-->

<!--script type="text/javascript" src="jquery-latest.pack.js"></script>
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
</script-->


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

	<li><a href="#">Datos Generales</a>
      <ul>
    		
	        <!--li><a href="navegadorSucursales.php" target="cuerpo">Sucursales</a></li>
			<li><a href="navegadorAlmacenes.php" target="cuerpo">Almacenes</a></li-->
			<li><a href="navegadorGrupos.php" target="cuerpo">Grupos</a></li>
			<li><a href="navegadorMateriales.php" target="cuerpo">Materiales</a></li>
			<li><a href="filtroCambioPreciosMateriales.php" target="cuerpo">Cambio Precio Venta Materiales</a></li>						
			<li><a href="listProveedores.php" target="cuerpo">Proveedores</a></li>			
			<li><a href="navegadorUnidadesMedida.php" target="cuerpo">Unidades de Medida</a></li>

			<!--li><a href="actualizarMateriales.php" target="cuerpo">ActualizarMateriales</a-->
			<!--li><a href="actualizarEstadoHojaRuta.php" target="cuerpo">Actualizar hojas de ruta</a>
    </li--->			
	
      </ul>	
    </li> 
	
    <!--li><a href="#"target="cuerpo">Ingresos</a>
      <ul>
    		
	        <li><a href="registrarIngresoExterno.php" target="cuerpo">Registro de Ingreso</a></li>
			<li><a href="navegadorIngresos.php" target="cuerpo">Listado de Ingresos</a></li>
	
      </ul>		

    </li-->
	  <li><a href="../cotizaciones/listClientesProveedores.php" target="cuerpo">Clientes y Proveedores</a></li> 
    <li><a href="#"target="cuerpo">Ingresos</a>
      <ul>
      		<li><a href="registrarIngresoExterno.php" target="cuerpo">Registro de Ingreso</a></li>
			<li><a href="listIngresos.php" target="cuerpo">Listado de Ingresos</a></li>
	
      </ul>		

    </li>    		
	
	 <li><a href="#"target="cuerpo">Salida</a>
      <ul>
    		
	        <li><a href="registrarSalida.php" target="cuerpo">Registro de Salida</a></li>
			<li><a href="listSalidas.php" target="cuerpo">Listado de Salidas</a></li>
	
      </ul>		

    </li>  
 <li><a href="listHojasRutas.php" target="cuerpo">Hojas de Ruta</a></li>  
        
 <li><a href="listOrdenTrabajo.php" target="cuerpo">Orden de Trabajo</a></li>  

    </li>	
	    <li><a href="#"target="cuerpo">Reportes</a>
      <ul>
    		
            <li><a href="filtroRptExistencias.php" target="cuerpo">Reporte de Existencias Con Stock</a></li>
            <li><a href="filtroRptExistenciasSinStock.php" target="cuerpo">Reporte de Existencias Sin Stock</a></li>
            <li><a href="filtroRptKardexMovimiento.php" target="cuerpo">Kardex de Movimiento</a></li>
            <li><a href="rptStockMaterial.php" target="cuerpo">Stock de Materiales</a></li>
            <li><a href="../administracion/rptClientes.php" target="cuerpo">Reporte Clientes</a></li>
            <li><a href="../administracion/rptProveedores.php" target="cuerpo">Reporte Proveedores</a></li>			
	
      </ul>		
	 <li><a href="procesoSalidaCosto.php" target="cuerpo">Calculo Costo/Salida</a></li> 
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
<iframe src="registrarIngresoExterno.php" width="972px" frameborder="0"  style="min-height:365px;"  name="cuerpo" ></iframe>
</div>


<p class="rightBottom"></p>
<br class="spacer" />
</div>
</div>

<!--right panel fin -->

<!--body fin-->

<!--footer inicio -->
<!--footer fin -->
</body>
</html>
