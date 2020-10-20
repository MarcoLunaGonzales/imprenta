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
	require("../conexion.inc");
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
	     <li><a href="#">Adm. Usuarios</a>
		<ul>
			<li><a href="navegadorCargos.php" target="cuerpo">Cargos</a></li>
			<li><a href="navegadorGradoAcademico.php" target="cuerpo">Grados Academicos</a></li>
            <li><a href="listAreas.php" target="cuerpo">Areas</a></li>
            <li><a href="listUsuarios.php" target="cuerpo">Usuarios</a></li>		
						
	    </ul>														
    </li>	

     <li><a href="#">Adm. Datos de Generales</a>
		<ul>
        	<li><a href="navegadorGestiones.php" target="cuerpo">Gestiones</a></li>
			<li><a href="navegadorCaracteristicas.php" target="cuerpo">Caracteristicas</a></li>
            <li><a href="navegadorItems.php" target="cuerpo">Items</a></li>			           
			<li><a href="navegadorTiposCotizacion.php" target="cuerpo">Tipos de Cotizaci&oacute;n</a></li>	
			<!--li><a href="navegadorTiposPago.php" target="cuerpo">Tipos de Pago</a></li-->				
			<li><a href="navegadorMaquinas.php" target="cuerpo">Maquinas</a></li>	
			<li><a href="navegadorClientesCategorias.php" target="cuerpo">Categorias de Clientes</a></li>						
            <li><a href="navegadorClientes.php" target="cuerpo">Clientes</a></li>  
            <li><a href="navegadorBancos.php" target="cuerpo">Bancos</a></li> 
            <li><a href="listTipoCambio.php" target="cuerpo">Tipo Cambio</a></li> 
            <li><a href="listGastos.php" target="cuerpo">Gastos</a></li>
            <li><a href="navegadorSucursales.php" target="cuerpo">Sucursales</a></li>
            <li><a href="navegadorAlmacenes.php" target="cuerpo">Almacenes</a></li>
            <li><a href="navegadorGrupos.php" target="cuerpo">Grupos</a></li>
            <li><a href="navegadorMateriales.php" target="cuerpo">Materiales</a></li>
            <li><a href="listProveedores.php" target="cuerpo">Proveedores</a></li>
            <li><a href="navegadorUnidadesMedida.php" target="cuerpo">Unidades de Medida</a></li>
        	<li><a href="filtroCambioPreciosMateriales.php" target="cuerpo">Cambio Precio Venta Materiales</a></li>	
            <!--li><a href="actualizarDatosHojasRutas.php" target="cuerpo">Query Actualizar Hojas Rutas</a></li-->                       							
	    </ul>														
    </li>  
     <li><a href="#" target="cuerpo">Almacenes</a>    
		<ul>
  <li><a href="selectAlmacenIngreso.php" target="cuerpo">Ingresos</a> 
  <li><a href="selectAlmacenSalida.php" target="cuerpo">Salidas</a> 							
	    </ul>														
    </li>  
	
 <li><a href="#" target="cuerpo">Operaciones</a>    
		<ul>
 <li><a href="listCotizaciones.php" target="cuerpo">Cotizaciones</a>    														
    </li>  
 <li><a href="listHojasRutas.php" target="cuerpo">Hojas de Ruta</a>    														
    </li> 
 <li><a href="listOrdenTrabajo.php" target="cuerpo">Orden de Trabajo</a></li>
  <li><a href="../contable/listGastosGral.php" target="cuerpo">Gastos</a></li>  						
	    </ul>														
    </li>  

   														
    </li>  
            	
        <li><a href="#">Cobranzas</a>
      <ul>    		
	        <li><a href="listPagos.php" target="cuerpo">Listado de Pagos</a></li>
            <li><a href="newPago.php" target="cuerpo">Registro de Pago</a></li>
            <li><a href="newPago2.php" target="cuerpo">Registro de Pago Traspaso</a></li>
      </ul>	
    </li>
    <li><a href="#">Pagos Proveedor</a>
      <ul>    		
            <li><a href="newPagoProveedor.php" target="cuerpo">Registro de Pago Proveedor</a></li>
			<li><a href="listPagoProveedor.php" target="cuerpo">Lista Pago Proveedor</a></li>
			<!--li><a href="procesoIngresos.php" target="cuerpo">Proceso Ingresos</a></li-->
      </ul>	
    </li>	        
        <li><a href="#">Reportes</a>
      <ul>    		
	        <li><a href="filtroRptCuentasCobrar.php" target="cuerpo">Cuentas por Cobrar</a></li>
            <li><a href="filtroRptCotizacionesItem.php" target="cuerpo">Reporte Cotizaciones por Item</a></li>
            <li><a href="rptClientes.php" target="cuerpo">Reporte Clientes</a></li>
            <li><a href="rptProveedores.php" target="cuerpo">Reporte Proveedores</a></li>
      </ul>	
    </li>	 	
	        <!--li><a href="procesoPagos.php">Proceso Pagos</a-->
	
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
		     <!--li><a href="#">Bingo</a>
		<ul>
	        <li><a href="eliminarBingo.php" target="cuerpo">Eliminar Bingo Existentes</a></li>
			<li><a href="generarBingo.php" target="cuerpo">Genera rBingo</a></li>
			<li><a href="listBingo.php" target="_blank">Ver Bingo</a></li>
	
						
	    </ul>														
    </li==>	
	    <!--li><a href="generarBingo.php" target="cuerpo">Generar Bingo</a></li-->	
    <li><a href="../salirSistema.php">Salir de Sistema</a></li>		
</ul>

</div>
<!--cabecera fin -->


<!--cuerpo inicio -->
<div id="body">
<!--right panel inicio -->
<div id="right2">
<p class="rightTop"></p>

<div id="cuerpoinformacion" style="width:1024px; margin-left:5px; margin-right:5px;">
<iframe src="listPagos.php" width="972px" frameborder="0"  style="min-height:365px;"  name="cuerpo" ></iframe>
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
