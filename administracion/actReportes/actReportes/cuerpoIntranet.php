<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>INVENTA</title>
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
	
?>
<div>
<img src="images/cabecera.jpg" style="position: absolute; top: 0; left: 0;" alt="" width="1024px" height="105px" >
<div style="position: absolute; top:75px; left: 500px; margin: 10px; width: 1024px;">
  <span class="cabecera"><?php echo "Bienvenido: ".$nombres_usuario." ".$ap_paterno_usuario; ?></span></div>
</div>

<br>
<br>
<br>
<br>

<div id="nicemenu" >
 <ul id="nav">

	<li><a href="#">Cotizaciones</a>
      <ul>
    		
	        <li><a href="registrarCotizacion.php" target="cuerpo">Registro Cotizaci&oacute;n</a></li>
			<li><a href="navegadorCotizaciones.php" target="cuerpo">Cotizaciones</a></li>
	
      </ul>	
    </li>
	
    <li><a href="#"target="cuerpo">Hojas de Ruta</a>
      <ul>
    		
	        <li><a href="navegadorHojasRutas.php" target="cuerpo">Listado</a></li>
	
      </ul>		

    </li>		
	
	
    <li><a href="#">Notas de Remision</a>
      <ul>
    		
	        <li><a href="navegadorNotasRemision.php" target="cuerpo">Listado</a></li>
	
      </ul>	
    </li>	
    <li><a href="#">Detalle de Gastos</a>
      <ul>
    		
	        <li><a href="navegadorCostosProduccion.php" target="cuerpo">Listado</a></li>
                        
	
      </ul>	
    </li>	
     <li><a href="#">Datos Generales</a>
		<ul>
			<?php if($cod_perfil==1){?>	
			<li><a href="navegadorCargos.php" target="cuerpo">Cargos</a></li>
			<li><a href="navegadorGradoAcademico.php" target="cuerpo">Grados Academicos</a></li>
            <li><a href="navegadorUsuarios.php" target="cuerpo">Usuarios</a></li>		
            <li><a href="navegadorGestiones.php" target="cuerpo">Gestiones</a></li>
			<li><a href="navegadorTiposCotizacion.php" target="cuerpo">Tipos de Cotizaci&oacute;n</a></li>	
			<li><a href="navegadorTiposPago.php" target="cuerpo">Tipos de Pago</a></li>
			<li><a href="navegadorClientesCategorias.php" target="cuerpo">Categorias de Clientes</a></li>				
			<?php }?>
			<li><a href="navegadorCaracteristicas.php" target="cuerpo">Caracteristicas</a></li>
            <li><a href="navegadorItems.php" target="cuerpo">Items</a></li>			
            <li><a href="navegadorClientes.php" target="cuerpo">Clientes</a></li>	
			<li><a href="navegadorMaquinas.php" target="cuerpo">Maquinas</a></li>	
            <li><a href="listGastos.php" target="cuerpo">Gastos</a></li>	

						
	    </ul>														
    </li>	
    
     <li><a href="#">Reportes</a>
		<ul>
			<li><a href="rptClientes.php" target="cuerpo">Clientes</a></li>

						
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
<iframe src="cuerpo.html" width="972px" frameborder="0"  style="min-height:365px;"  name="cuerpo" ></iframe>
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
