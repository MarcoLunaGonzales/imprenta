<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>IBNORCA</title>
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
<!--cabecera inicio -->
<?php
	require("asociados/conexion.inc");
	include("asociados/funciones.php");
	include("asociados/funcionesSql.php");
	
	$sql=" select  nombre_contacto, ap_paterno_contacto, ap_materno_contacto from contactos ";
	$sql.=" where cod_contacto='".$_COOKIE['contacto_global']."'";
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){	
		$nombre_contacto=$dat[0];
		$ap_paterno_contacto=$dat[1];
		$ap_materno_contacto=$dat[2];
	}
	$sql=" select  rotulo_comercial from empresas  where cod_empresa='".$_COOKIE['empresa_global']."'";
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){	
		$rotulo_comercial=$dat[0];
	}
	require("asociados/cerrar_conexion.inc");
?>

<div id="header">
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="981" height="176">

  <param name="movie" value="images/banner.swf">
  <param name="quality" value="high">
  <embed src="images/banner.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="981" height="176"></embed>
</object>


<div id="menu2">
	<ul class="nav">
		<li class="navLink"><a href="index.html" class="home">Salir de sistema </a></li>
		<li class="navLink"><a href="#" class="usuario">contacto de <?php echo $rotulo_comercial;?> : <?php echo $nombre_contacto." ".$ap_paterno_contacto." ".$ap_materno_contacto;?> </a></li>
	  </ul>
 </div>
 
</div>
<br>
<br>
<br>

				
<div id="nicemenu">
 <ul id="nav">
 
    <li><a href="#">Fichas Tecnicas</a>
      <ul>
            <li><a href="asociados/registerFichaProducto.php" target="cuerpo">Registro de Ficha Tecnica</a></li>
            <li><a href="asociados/fichasTecnicasRegistradas.php" target="cuerpo">Fichas Registradas</a></li>
            <li><a href="asociados/fichasTecnicasEnviadasRevision.php" target="cuerpo">Fichas Enviadas a Revisión</a></li>
            <li><a href="asociados/fichasTecnicasAprobadas.php" target="cuerpo">Fichas Aprobadas</a></li>
      </ul>	
	  	  	  	  	    
    </li>
	
    <li><a href="#">Certificados de Producto</a>
      <ul>
            <li><a href="asociados/certificadosAprobados.php" target="cuerpo">Certificados Aprobados</a></li>
            <li><a href="asociados/certificadosEnProcesoAprobacion.php" target="cuerpo">Certificados en Proceso de Aprobación</a></li>
      </ul>
    </li>		
	
    <li><a href="#">Solicitudes de Importación</a>
		<ul>
            <li><a href="asociados/registrar_formSolCertImp.php" target="cuerpo">Registro de Solicitud de Importación</a></li>
            <li><a href="asociados/formSolCertImpRegistradas.php" target="cuerpo">Solicitudes de Importación Registradas</a></li>
            <li><a href="asociados/formSolCertImpEnviadas.php" target="cuerpo">Solicitudes de Importación Enviadas</a></li>
            <!--li><a href="#" target="cuerpo">Solicitudes de Importación En Revision</a></li>
            <li><a href="#" target="cuerpo">Solicitudes de Importación Observadas</a></li>
            <li><a href="#" target="cuerpo">Solicitudes de Importación Sin Observaciones</a></li>
            <li><a href="#" target="cuerpo">Solicitudes de Importación Atendidas</a></li-->
	    </ul>														
    </li>
	
    <li><a href="#">Certificados de Importacion</a>
      <ul>
            <!--li><a href="" target="cuerpo">Ver Certificados</a></li-->
      </ul>
    </li>	
</ul>
</div>
<!--cabecera fin -->


<!--cuerpo inicio -->
<div id="body">
<!--right panel inicio -->
<div id="right2">
<p class="rightTop"></p>

<div id="cuerpoinformacion" style="width:960px; margin-left:5px; margin-right:5px;">
		<iframe src="asociados/registerFichaProducto.php" width="960" frameborder="0"  style="min-height:430px;" name="cuerpo" ></iframe>
</div>


<p class="rightBottom"></p>
<br class="spacer" />
</div>

<!--right panel fin -->
<br class="spacer" />
</div>
<!--body fin-->

<!--footer inicio -->
<div id="footer">
<ul>
	<li><a href="index.html">Inicio</a>|</li>
	<li><a href="otro.html">Soporte Técnico</a></li>
  </ul>
   <p class="copyright">&copy; IBNORCA - Todos los Derechos Reservados.</p>
   
</div>
<!--footer fin -->
</body>
</html>
