<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>MODULO DE ALMACENES</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
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
		//codgrupoB=f.codgrupoB.value;	
		cod_grupo=document.getElementById("cod_grupo").value;	
		ajax=nuevoAjax();
		ajax.open("GET","ajaxSubGrupos.php?cod_grupo="+cod_grupo,true);				
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
			div_subgrupo.innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null)	
		document.form1.seleccionar[0].checked=true;	
}
function seleccionarDatos(){
		for (i=0;i<document.form1.seleccionar.length;i++){ 
       	if (document.form1.seleccionar[i].checked) 
          break; 
	    } 
		if(document.form1.seleccionar[i].value==1){
		for (i=0;i<document.form1.elements.length;i++){
	      if(document.form1.elements[i].type == "checkbox") {
    	     document.form1.elements[i].checked=1;
		  }	
		}
		}else{
		for (i=0;i<document.form1.elements.length;i++){
	      if(document.form1.elements[i].type == "checkbox") {
    	     document.form1.elements[i].checked=0;
		  }	
		}			
		}

}
	
</script>
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF">
<h3 align="center" style="background:#FFFFFF;font-size: 14px;color: #E78611;font-weight:bold;">REPORTE DE EXISTENCIAS CON STOCK</h3>
<h3 align="center" style="background:#FFFFFF;font-size: 11px;color: #663300;font-weight:bold;">Seleccione los Parametros del Reporte</h3>
<form name="form1" method="post" action="rptExistenciasAlmacen.php">
<?php
	require("conexion.inc");
	include("funciones.php");
?>
<table width="40%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>A FECHA</td>									
		</tr>
       <tr bgcolor="#FFFFFF">
<td  align="center"><input type="text" name="fecha" id="fecha" class="textoform" value="<?php echo date("d/m/Y");?>"></td>

</tr>

	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>GRUPO</td>									
		</tr>
        
<tr>
<td class="fila_par" align="center">
	<select name="cod_grupo" id="cod_grupo" class="textoform" onChange="listaSubGrupos(this.form)">
				<option value="0">Todos los Grupos</option>	
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
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>SUBGRUPOS&nbsp;&nbsp;Checkear&nbsp;<input type="radio" name="seleccionar" id="seleccionar" value="1" onClick="seleccionarDatos()" checked>&nbsp;DesCheckear&nbsp;<input type="radio" name="seleccionar" id="seleccionar" value="0" onClick="seleccionarDatos()"></td>									
		</tr>
<tr>
<td  class="fila_par" align="center" >
				<div id="div_subgrupo">
					<h3 align="center" style="background:#F7F5F3;font-size: 11px;color: #663300;font-weight:bold;">
                    Todos los Subgrupos</h3>
				</div>	
	  </td>

</tr>
</table>
		
<?php require("cerrar_conexion.inc");
?>
<br>
<div align="center">
	<INPUT type="submit" class="boton" name="btn_editar"  value="Aceptar" onClick="registrar(this.form);">
</div>

</form>

</body>
</html>
