<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>Cambio Precio Materiales</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>

	function nuevoAjax()
	{	var xmlhttp=false;
 		try {
 			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	 	} catch (e) {
 			try {
 				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
 			} catch (E) {
 				xmlhttp = false;
 			}
	  	}
		if (!xmlhttp && typeof XMLHttpRequest!="undefined") {
 			xmlhttp = new XMLHttpRequest();
		}
		return xmlhttp;
	}
function listaSubGrupos(f)
{	
		var div_subgrupo,cod_grupo;
		div_subgrupo=document.getElementById("div_subgrupo");				
		cod_grupo=document.getElementById("cod_grupo").value;	
		ajax=nuevoAjax();
		//alert("ajax_listaSubGrupos.php?cod_grupo="+cod_grupo);
		ajax.open("GET","ajax_listaSubGrupos.php?cod_grupo="+cod_grupo,true);				
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
			div_subgrupo.innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null)		
}



function registrar(f){
	f.submit();
}



</script>
</head>
<body bgcolor="#FFFFFF">
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">CAMBIO DE PRECIOS VENTA MATERIALES </h3>
<h3 align="center" style="background:#FFF;font-size: 11px;color: #663300;font-weight:bold;">Seleccione el Grupo y Subgrupo para el cambio de precio de venta </h3>
<form name="form1" method="post" action="cambioPrecioMaterial.php">
<?php
	require("conexion.inc");
	include("funciones.php");
?>
<table border="0" align="center">
<tr>
<td><strong>Grupo:</strong></td>
<td colspan="3">
<select name="cod_grupo" id="cod_grupo" class="textoform" onChange="listaSubGrupos(this.form)">
				<option value="0">Seleccione una opcion</option>	
              <?php
					$sql2="select cod_grupo, nombre_grupo from grupos where cod_estado_registro=1 order by  nombre_grupo asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_grupo=$dat2[0];	
			  		 		$nombre_grupo=$dat2[1];	
				 ?>
				 <option value="<?php echo $cod_grupo;?>"><?php echo $nombre_grupo;?>
				 </option>					 

              <?php		
					}
				?>
        </select>
</td>
</tr>
<tr>
<td><strong>Subgrupo:</strong></td>
<td colspan="3">
				<div id="div_subgrupo">
			<select name="cod_subgrupo" id="cod_subgrupo" class="textoform">	
			<option value="0">Seleccione una opcion</option>				
			</select>	
				</div>	
	  </td>

</tr>
</table>
		
<?php require("cerrar_conexion.inc");
?>
<br>
<div align="center">
	<INPUT type="button" class="boton" name="btn_editar"  value="Aceptar" onClick="registrar(this.form);">
</div>

</form>
</body>
</html>
