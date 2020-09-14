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
	
	$sql=" select  nombre_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios ";
	$sql.=" where cod_usuario='".$_COOKIE['usuario_global']."'";
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){	
	
		$nombre_usuario=$dat[0];
		$ap_paterno_usuario=$dat[1];
		$ap_materno_usuario=$dat[2];
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
	<li class="navLink"><a href="index.html" class="home">SALIR DE SISTEMA </a></li>
	<li class="navLink"><a href="#" class="usuario">Usuario:<?php echo $nombre_usuario; ?>&nbsp;<?php echo $ap_paterno_usuario;?>&nbsp;<?php echo $ap_materno_usuario;?></a></li>
	  </ul>
 </div>
 
</div>
<br>
<br>
<br>

				
<!--cabecera fin -->


<!--cuerpo inicio -->
<div id="body">
<!--right panel inicio -->
<div id="right2">
<p class="rightTop"></p>

<div id="menuizquierdo" style=" width:230px; margin-left:5px; margin-right:5px; float:left">
<iframe src="administrador/menu.html" width="230" frameborder="0"  style="min-height:460px;"  ></iframe>

</div>
<div id="cuerpoinformacion" style="width:730px; margin-right:5px; float:right">
<iframe src="administrador/cuerpo.html" name="mainFrame" width="730" frameborder="0"  style="min-height:460px;"  ></iframe>
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
