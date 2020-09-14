<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Edici&oacute;n de Material</title>
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
	function guardar(f)
	{			

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
<form   method="post" action="guardaEditarMaterial.php">
<?php 	require("conexion.inc");

	$cod_material=$_GET['cod_material'];
	$sql="select nombre_material,cod_subgrupo, cod_unidad_medida,";
	$sql.=" stock_minimo, stock_maximo,cod_estado_registro, idMaterialDesc ";
	$sql.=" from materiales ";
	$sql.=" where cod_material='".$cod_material."'";
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){	
							
				$nombre_material=$dat[0];				
				$cod_subgrupo=$dat[1];
				$codunidadmedida=$dat[2];
				$stock_minimo=$dat[3];
				$stock_maximo=$dat[4];
				$codestadoregistro=$dat[5];	
				$idMaterialDesc=$dat[6];	
				$nombre_grupo="";
				$sql2=" select cod_grupo,nombre_grupo from grupos ";
				$sql2.=" where cod_grupo in(select cod_grupo from subgrupos where cod_subgrupo='".$cod_subgrupo."')";
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$cod_grupo=$dat2[0];
					$nombre_grupo=$dat2[1];
				}	
				
				$sql2="select nombre_subgrupo from subgrupos  where cod_subgrupo=".$cod_subgrupo;
				$resp2=mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2))
				{
						$nombre_subgrupo=$dat2[0];					
				}
	}
?>
<h3 align="center" style="background:white;font-size: 14px;color:#E78611;font-weight:bold;">Edici&oacute;n de Material </h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
	<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Grupo</td>
      		<td><?php echo $nombre_grupo;?></td>
    	</tr>	
		 <tr bgcolor="#FFFFFF">
     		<td>SubGrupo</td>
      		<td><?php echo $nombre_subgrupo;?></td>
    	</tr>	
		 <tr bgcolor="#FFFFFF">
     		<td>ID Material</td>
      		<td><?php echo $idMaterialDesc;?></td>
    	</tr>			
		 <tr bgcolor="#FFFFFF">
     		<td>Material</td>
      		<td><input type="text"  class="textoform" size="55" name="nombre_material" value="<?php echo $nombre_material;?>" ></td>
    	</tr>	
		<tr class="titulo_tabla">
		<td  colSpan="2" align="center">DATOS ESPECIFICOS DEL MATERIAL </td>
		 </tr>	
				<?php
					$sql2=" select cod_grupo_carac, nombre_grupo_carac from grupos_caracteristicas ";
					$sql2.=" where cod_estado_registro=1  and cod_grupo=".$cod_grupo." order by orden asc";
					$resp2=mysql_query($sql2);
					$sw=0;
					while($dat2=mysql_fetch_array($resp2))
					{				
							$cod_grupo_carac=$dat2[0];	
			  		 		$nombre_grupo_carac=$dat2[1];	
							
							$sql3=" select desc_material_grupo_caracteristica ";
							$sql3.=" from materiales_grupos_caracteristicas";
							$sql3.=" where 	cod_material='".$cod_material."'";
							$sql3.=" and  cod_grupo_carac='".$cod_grupo_carac."'";
							$resp3=mysql_query($sql3);
							$desc_material_grupo_caracteristica="";
							while($dat3=mysql_fetch_array($resp3))
							{				
								$desc_material_grupo_caracteristica=$dat3[0];	
							}			
							
				?>
					
					<tr bgcolor="#FFFFFF">
			     		<td><?php echo $nombre_grupo_carac;?></td>
      					<td>
						<input type="text"  class="textoform" id="<?php echo $cod_grupo_carac;?>" size="20" 
						name="<?php echo $cod_grupo_carac;?>" value="<?php echo $desc_material_grupo_caracteristica;?>">
						</td>
			    	</tr>
				<?php
		
					  }
				?>			 
		</tr>	
		 <tr bgcolor="#FFFFFF">
     		<td>Unidad de Medida </td>
      		<td>
			<select name="cod_unidad_medida" class="textoform">				
				<?php
					$sql2=" select cod_unidad_medida, nombre_unidad_medida from unidades_medidas ";
					$sql2.="  order by  nombre_unidad_medida asc";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_unidad_medida=$dat2[0];	
			  		 		$nombre_unidad_medida=$dat2[1];	
				 ?>
				 				 <option value="<?php echo $cod_unidad_medida;?>" <?php if($cod_unidad_medida==$codunidadmedida){echo "selected='selected'";}?>><?php echo $nombre_unidad_medida;?>
				 </option>				
				<?php		
					}
				?>						
			</select>			</td>
			</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Stock Minimo</td>
      		<td><input type="text"  class="textoform" size="55" name="stock_minimo" value="<?php echo $stock_minimo;?>" ></td>
    	</tr>			
		 <tr bgcolor="#FFFFFF">
     		<td>Stock Maximo</td>
      		<td><input type="text"  class="textoform" size="55" name="stock_maximo" value="<?php echo $stock_maximo;?>" ></td>
    	</tr>	
		 				
		 <tr bgcolor="#FFFFFF">
   			<td>Estado</td>
      		<td>
			<select name="cod_estado_registro" class="textoform">				
				<?php
					$sql2="select cod_estado_registro, nombre_estado_registro from estados_referenciales ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_estado_registro=$dat2[0];	
			  		 		$nombre_estado_registro=$dat2[1];	
				 ?>
				 <option value="<?php echo $cod_estado_registro;?>" <?php if($cod_estado_registro==$codestadoregistro){echo "selected='selected'";}?>><?php echo $nombre_estado_registro;?>
				 </option>				
				<?php		
					}
				?>						
			</select>	
			</td>
    	</tr>				
		</tbody>
	</table>	

<br>
<input type="hidden" name="cod_material" value="<?php echo $cod_material;?>">
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
