<?php header("Cache-Control: no-store, no-cache, must-revalidate");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Busqueda de Material</title>
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
function cancelar(f)
{	
			window.close();
}
function listaSubGrupos(f)
{	

		var div_subgrupo,cod_grupo;

		div_subgrupo=document.getElementById("div_subgrupo");
			
		cod_grupo=document.getElementById("cod_grupo").value;	

		ajax5=nuevoAjax();

	//alert("ajax_listSubGrupos.php?cod_grupo="+cod_grupo);
		ajax5.open("GET","ajax_listSubGrupos.php?cod_grupo="+cod_grupo,true);				
		ajax5.onreadystatechange=function(){
			if (ajax5.readyState==4) {
			div_subgrupo.innerHTML=ajax5.responseText;
		    }
	    }		
		ajax5.send(null);
		//alert("entrooooooooo");
		buscar(f);
		
}
function buscar(f){
		var div_resultado;
		div_resultado=document.getElementById("div_resultado");			

		ajax=nuevoAjax();

	
		ajax.open("GET","ajax_buscarMaterial_Auxiliar.php?cod_grupo="+document.getElementById("cod_grupo").value+"&cod_subgrupo="+document.getElementById("cod_subgrupo").value+"&nombreMaterialB="+document.getElementById("nombreMaterialB").value,true);		

		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
			div_resultado.innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null)
}	
function enviarDatos(cod_material,desc_completa_material){			
			window.close();
			//alert("datos="+numMaterial+" "+cod_material+" "+desc_completa_material);
			window.opener.setMateriales(cod_material,desc_completa_material);
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<!---Autor:Gabriela Quelali Si�ani
	02 de Julio de 2008
-->
<form   method="post" name="form1" id="form1" >

        <h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">BUSQUEDA DE MATERIALES</h3>
   <h3 align="center" style="background:#FFF;font-size: 11px;color: #000;font-weight:bold;">Seleccione o llene los campos de busqueda.</h3>
<table align='center'>
<?php
require("conexion.inc");
?>
			<tr><th>Grupo</th><th>SubGrupo</th><th>Material</th></tr>
			<tr>
			<td><select name="cod_grupo" id="cod_grupo" class="textoform" onChange="listaSubGrupos(this.form)">
				<option value="0">Seleccione una opcion</option>	
              <?php
					$sql2="select cod_grupo, nombre_grupo from grupos where cod_estado_registro=1 order by  nombre_grupo asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_grupo=$dat2[0];	
			  		 		$nombre_grupo=$dat2[1];	
				 ?>
      		  <option value="<?php echo $cod_grupo;?>" ><?php echo $nombre_grupo;?></option>
              <?php		
					}
				?>
            </select>
			</td>
      		<td>
				<div id="div_subgrupo">
					<select name="cod_subgrupo" id="cod_subgrupo" class="textoform" disabled="disabled"> 
						<option value="0">Seleccione una opción</option>
					</select>
				</div>			
			</td>            
			<td>
				<input type='text' name='nombreMaterialB' id="nombreMaterialB" onKeyUp="buscar(this.form);">
			</td>

			</tr>
			
		</table>

   <br/>
<div id="div_resultado">

	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>Grupo</td>
			<td>SubGrupo</td>
			<td>Id Material ACTUAL</td>  
    		<td>Material</td>
			<td>Unidad</td>			
			<td>Cant Actual</td>									
		</tr>
		<tr><th colspan="6" class="fila_par" align="center">No existen resultados</th></tr>
	</table>

</div>

</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>
