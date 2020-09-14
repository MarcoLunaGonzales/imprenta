<html><head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<title>SISTEMA DE GESTION</title>
<link href="style3.css" rel="stylesheet" type="text/css" />

</head>
<body style="margin: 0pt; padding: 0pt; background: rgb(199, 200, 200) url(images/tall.jpg) repeat-x scroll left bottom; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;">
<div align="center">
<?php
require("conexion_inicio.inc");
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
	<tbody>
	<tr>
		<td colspan="3">
			<img src="images/banner1.jpg"   width="980" height="92"alt="" ></td>
	</tr>
	<tr>
		<td colspan="3"><img src="images/barraheader.jpg"  alt="" >
		<div style="position: absolute; top:90px; left: 400px; margin: 10px; width: 1024px;">
  <span class="cabecera"><?php echo $nombre_modulo." - Usuario: ".$nombres_usuario." ".$ap_paterno_usuario; ?></span></div>

</td>
	</tr>
	<tr valign="top"  height="200" align="center" width="980" >
		<td width="200">&nbsp;</td>	
		<td width="500"   align="center">

		  <form method="post">
	 


    <table align="center" cellSpacing="1" cellPadding="4" width="20%" bgColor="#FFFFFF" border="0">
		<tbody>
    
			<?php
			
			$sql=" select cod_sucursal, nombre_sucursal";
			$sql.=" from sucursales ";
			$sql.=" where cod_estado_registro=1 ";
			$sql.=" order by  cod_sucursal asc";
			$resp = mysql_query($sql);

			while($dat=mysql_fetch_array($resp)){	
															 		
				$cod_sucursal=$dat['cod_sucursal'];	
				$nombre_sucursal=$dat['nombre_sucursal'];
			?>
					 <tr >
						   <td   align="center"><span class="tituloMenu"><?php echo "Sucursal ".$nombre_sucursal;?></span></td>
			    </tr>
			<?php
				$sql2=" select cod_almacen, nombre_almacen ";
					$sql2.=" from almacenes";
					$sql2.=" where cod_sucursal=".$cod_sucursal;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){	
						
						$cod_almacen=$dat2['cod_almacen'];
						$nombre_almacen=$dat2['nombre_almacen'];	
			?>
            			 <tr bgcolor="#FFFFFF">
   						
			      		<td align="center"><a href="direccionar.php?cod_almacen_global=<?php echo $cod_almacen; ?>&cod_modulo=<?php echo $_GET['cod_modulo'];?>" class="link" ><?php echo $nombre_almacen;?></a></td>
			    	</tr>	
            <?php				
					}

			}
		
		?>	
        <tr bgcolor="#FFFFFF">
   						
			      		<td align="center"><a href="../modules.php" class="link" >Ir a Menu de Modulos</a>	</td>
		</tr>	        
		</tbody>
	</table>	         

		    </form>

	</td>
	<td width="200">&nbsp;</td>	
	</tr>	
	<tr>
	<td colspan="3"><img src="../images/index_05.jpg" alt="" ></td>
	<td width="1" colspan="3"></td>
	</tr>
		<tr>
	<td colspan="3"><img src="../images/barraheader.jpg" alt="" ></td>
	</tr>
</tbody>
</table>
</div>
</body>
</html>