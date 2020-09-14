<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Registro de Material</title>
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
		cod_grupo=f.cod_grupo.value;	
		ajax=nuevoAjax();
		
		var div_gruposcaracteristicas;
		div_gruposcaracteristicas=document.getElementById("div_gruposcaracteristicas");	
		ajax2=nuevoAjax();
		
	
		ajax.open("GET","ajax_listaSubGrupos.php?cod_grupo="+cod_grupo,true);				
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
			div_subgrupo.innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null)
		
		ajax2.open("GET","ajax_listaGruposCaracteristicas.php?cod_grupo="+cod_grupo,true);				
		ajax2.onreadystatechange=function(){
			if (ajax2.readyState==4) {
			div_gruposcaracteristicas.innerHTML=ajax2.responseText;
		    }
	    }		
		ajax2.send(null)
		
}	
function mostrar_idMaterial(f)
{	
		var div_idMaterial,cod_grupo,cod_subgrupo;
		div_idMaterial=document.getElementById("div_idMaterial");			
		cod_grupo=f.cod_grupo.value;
		cod_subgrupo=f.cod_subgrupo.value;	
		ajax=nuevoAjax();
	//	alert("ajax_mostraridMaterial.php?cod_grupo="+cod_grupo+"&cod_subgrupo="+cod_subgrupo);
		ajax.open("GET","ajax_mostraridMaterial.php?cod_grupo="+cod_grupo+"&cod_subgrupo="+cod_subgrupo,true);				
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
			div_idMaterial.innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null)

}	

	function guardar(f)
	{	
			/*if(f.nombre_material.value==""){
			 	alert('El campo Material se encuentra vacio.'); 
			 	f.nombre_material.focus();
		 	 	return(false);
			}*/
			
			if(f.cod_grupo.value==0){
			 	alert('Seleccione un Grupo.'); 
			 	f.cod_grupo.focus();
		 	 	return(false);
			}
			if(f.cod_subgrupo.value==0){
			 	alert('Seleccione una SubGrupo.'); 
			 	f.cod_subgrupo.focus();
		 	 	return(false);
			}			

			if(f.cod_unidad_medida.value==0){
			 	alert('Seleccione la Unidad de Medida.'); 
			 	f.cod_unidad_medida.focus();
		 	 	return(false);
			}
			if(f.stock_minimo.value==""){
			 	alert('El campo Stock Minimo se encuentra vacio.'); 
			 	f.stock_minimo.focus();
		 	 	return(false);
			}
			if(f.stock_maximo.value==""){
			 	alert('El campo Stock Maximo se encuentra vacio.'); 
			 	f.stock_maximo.focus();
		 	 	return(false);
			}						

			f.submit();
		}	
	function cancelar(f)
	{	
		window.location="navegadorMateriales.php";
	}			
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="guardaRegistrarMaterial.php">
<?php 	require("conexion.inc");

	$sql2="select nombre_estado_registro from estados_referenciales where cod_estado_registro=1";
	$resp2= mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2)){
		$nombre_estado_registro=$dat2[0];
	}	
?>
<h3 align="center" style="background:white;font-size: 14px;color:#E78611;font-weight:bold;">Registro de Material </h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="50%" bgColor="#cccccc" border="0">
	<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Grupo</td>
      		<td><select name="cod_grupo" class="textoform" onChange="listaSubGrupos(this.form)"
			>
				<option value="0">Seleccione una opcion</option>	
              <?php
					$sql2="select cod_grupo, nombre_grupo from grupos where cod_estado_registro=1 order by  nombre_grupo asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_grupo=$dat2[0];	
			  		 		$nombre_grupo=$dat2[1];	
				 ?>
      		  <option value="<?php echo $cod_grupo;?>"><?php echo $nombre_grupo;?></option>
              <?php		
					}
				?>
            </select></td>
    	</tr>	
		 <tr bgcolor="#FFFFFF">
     		<td>SubGrupo</td>
      		<td>
				<div id="div_subgrupo">
					<select name="cod_subgrupo" class="textoform" disabled="disabled"> 
						<option value="0">Seleccione una opción</option>
					</select>
				</div>			
			</td>
    	</tr>	
		 <tr bgcolor="#FFFFFF">
     		<td>Id. Material</td>
      		<td>
				<div id="div_idMaterial">

				</div>			
			</td>
    	</tr>			
		 <tr bgcolor="#FFFFFF">
     		<td>Material</td>
      		<td><input type="text"  class="textoform" size="55" name="nombre_material" ></td>
    	</tr>	
		<tr class="titulo_tabla">
		<td  colSpan="2" align="center">DATOS ESPECIFICOS DEL MATERIAL </td>
		 </tr>	

		<tr bgcolor="#FFFFFF">
		
		<td colspan="2"  align="center">
		
		<div id="div_gruposcaracteristicas" align="right">
		</div>

		</td>
		</tr>	
		 <tr bgcolor="#FFFFFF">
     		<td>Unidad de Medida </td>
      		<td>
			<select name="cod_unidad_medida" class="textoform">				
				<?php
					$sql2=" select cod_unidad_medida, nombre_unidad_medida from unidades_medidas ";
					$sql2.=" where cod_estado_registro=1 order by  nombre_unidad_medida asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_unidad_medida=$dat2[0];	
			  		 		$nombre_unidad_medida=$dat2[1];	
				 ?><option value="<?php echo $cod_unidad_medida;?>"><?php echo $nombre_unidad_medida;?></option>				
				<?php		
					}
				?>						
			</select>			</td>
			</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Stock Minimo</td>
      		<td><input type="text"  class="textoform" size="55" name="stock_minimo" ></td>
    	</tr>			
		 <tr bgcolor="#FFFFFF">
     		<td>Stock Maximo</td>
      		<td><input type="text"  class="textoform" size="55" name="stock_maximo" ></td>
    	</tr>	
		 				
		 <tr bgcolor="#FFFFFF">
   			<td>Estado</td>
      		<td><?php echo $nombre_estado_registro;?></td>
    	</tr>				
		</tbody>
	</table>	

<br>
<div align="center">
	<input type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
	<input type="reset"  class="boton"  name="btn_limpiar" value="Limpiar" >
	<input type="reset"  class="boton"  name="btn_cancelar" value="Cancelar" onClick="cancelar(this.form);"  >
</div>
</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>
