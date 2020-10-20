<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>Materiales</title>
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
		var div_subgrupo,codgrupoB;
		div_subgrupo=document.getElementById("div_subgrupo");			
		//codgrupoB=f.codgrupoB.value;	
		codgrupoB=document.getElementById("codgrupoB").value;	
		ajax=nuevoAjax();
		ajax.open("GET","ajax_listaSubGrupos_nav.php?codgrupoB="+codgrupoB,true);				
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
			div_subgrupo.innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null)		
}

function paginar(f)
{	
	var param="?desccompletamaterialB="+document.getElementById("desccompletamaterialB").value;
	param+="&pagina="+document.getElementById("pagina").value;
	param+="&codgrupoB="+document.getElementById("codgrupoB").value;
	param+="&codsubgrupoB="+document.getElementById("codsubgrupoB").value;
	
		location.href='navegadorMateriales.php'+param;		
}
function paginar1(f,pagina)
{		

	f.pagina.value=pagina*1;
	var param="?desccompletamaterialB="+document.getElementById("desccompletamaterialB").value;
	param+="&pagina="+document.getElementById("pagina").value;
	param+="&codgrupoB="+document.getElementById("codgrupoB").value;
	param+="&codsubgrupoB="+document.getElementById("codsubgrupoB").value;
			
		location.href='navegadorMateriales.php'+param;	
}

function buscar(f){
	
	var param="?desccompletamaterialB="+document.getElementById("desccompletamaterialB").value;
	param+="&codgrupoB="+document.getElementById("codgrupoB").value;
	param+="&codsubgrupoB="+document.getElementById("codsubgrupoB").value;	
	location.href="navegadorMateriales.php"+param;
}

function registrar(f){
	f.submit();
}
function editar(f)
{	
	var i;
	var j=0;
	var cod_registro;
	for(i=0;i<=f.length-1;i++)
	{
		if(f.elements[i].type=='checkbox')
		{	if(f.elements[i].checked==true)
			{	cod_registro=f.elements[i].value;
				j=j+1;
			}
		}
	}
	if(j>1)
	{	alert('Debe seleccionar solamente un registro para modificar.');
	}
	else
	{
		if(j==0)
		{
			alert('Debe seleccionar un registro para modificar.');
		}
		else
		{
			window.location="editarMaterial.php?cod_material="+cod_registro;
		}
	}
}


function eliminar(f)
{
	var i;
	var j=0;
	datos=new Array();
	for(i=0;i<=f.length-1;i++)
	{
		if(f.elements[i].type=='checkbox')
		{	if(f.elements[i].checked==true)
			{	datos[j]=f.elements[i].value;
				j=j+1;
			}
		}
	}
	if(j==0)
	{	alert('Debe seleccionar al menos un registro para eliminarlo.');
		return(false);
	}
	else
	{
			window.location ="listaEliminarMateriales.php?datos="+datos;			
	}
}
</script></head>
<body bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<h3 align="center" style="background:#FFFFFF;font-size: 14px;color: #E78611;font-weight:bold;">MATERIALES
  <a class="btn btn-warning btn-lg float-right text-white boton-filtro-iframe" href="#" data-toggle="modal" data-target="#filtroModal">
       <i class="fa fa-search"></i> BUSCAR REGISTROS
    </a>
</h3>
<form name="form1" method="post" action="registrarMaterial.php">
<?php 
	require("conexion.inc");
	include("funciones.php");
	$desccompletamaterialB=$_GET['desccompletamaterialB'];
	$codgrupoB=$_GET['codgrupoB'];
	$codsubgrupoB=$_GET['codsubgrupoB'];

?>

<?php	
	//Paginador
	$nro_filas_show=50;	
	$pagina = $_GET['pagina'];

	if ($pagina == ""){
		$pagina = 1;
		$fila_inicio=0;
		$fila_final=$nro_filas_show;
	}else{
		$fila_inicio=(($pagina*$nro_filas_show)-$nro_filas_show);
		$fila_final=($fila_inicio+$nro_filas_show);
	}	
		$sql_aux=" select count(*)";
		$sql_aux.=" from materiales m, subgrupos sbg, grupos g ";
		$sql_aux.=" where m.cod_material<>0 ";
		$sql_aux.=" and m.cod_subgrupo=sbg.cod_subgrupo";
		$sql_aux.=" and sbg.cod_grupo=g.cod_grupo ";
		if($codgrupoB<>0){
			$sql_aux.=" and sbg.cod_grupo='".$codgrupoB."'";
				if($codsubgrupoB<>0){
					$sql_aux.=" and m.cod_subgrupo=".$codsubgrupoB."";
				}	
		}			
		if($desccompletamaterialB<>""){
			$sql_aux.=" and m.desc_completa_material like '%".$desccompletamaterialB."%'";
		}			
	
	$resp_aux = mysql_query($sql_aux);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}

		//Calculo de Nro de Paginas
			$nropaginas=1;
			if($nro_filas_sql<$nro_filas_show){
				$nropaginas=1;
			}else{
				$nropag_aux=round($nro_filas_sql/$nro_filas_show);

				if($nro_filas_sql>($nropag_aux*$nro_filas_show)){
					$nropaginas=$nropag_aux+1;
				}else{
					$nropaginas=$nropag_aux;
				}
			}					
		//Fin de calculo de paginas
		
		$sql=" select sbg.cod_grupo, g.nombre_grupo,g.abrev_grupo, m.cod_subgrupo, sbg.nombre_subgrupo, sbg.abrev_subgrupo,";
		$sql.="  m.cod_material, m.nombre_material, m.desc_completa_material, "; 
		$sql.=" m.cod_unidad_medida, m.stock_minimo, m.stock_maximo, m.cod_estado_registro, ";
		$sql.=" m.cod_usuario_registro, m.fecha_registro, m.cod_usuario_modifica, m.fecha_modifica, ";
		$sql.=" m.idMaterial, m.idMaterialDesc";
		$sql.=" from materiales m, subgrupos sbg, grupos g ";
		$sql.=" where m.cod_material<>0 ";
		$sql.=" and m.cod_subgrupo=sbg.cod_subgrupo";
		$sql.=" and sbg.cod_grupo=g.cod_grupo ";
		if($codgrupoB<>0){
			$sql.=" and sbg.cod_grupo='".$codgrupoB."'";
				if($codsubgrupoB<>0){
					$sql.=" and m.cod_subgrupo=".$codsubgrupoB."";
				}	
		}			
		if($desccompletamaterialB<>""){
			$sql.=" and m.desc_completa_material like '%".$desccompletamaterialB."%'";
		}			

		$sql.=" order by g.nombre_grupo, sbg.nombre_subgrupo, m.desc_completa_material asc ";
		//$sql.=" limit 50";
		
		$resp = mysql_query($sql);

?>	
	<table width="98%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc" class="tablaReporte" style="width:100% !important;">
		<thead>
	    <tr height="20px" align="center"  class="bg-success text-white">
			<th>&nbsp;</th>
			<th>Grupo</th>
			<th>SubGrupo</th>
			<!--th>Id Material ANTIGUO</th-->
			<th>Id Material ACTUAL</th>            
			<th>Material</th>			
			<th>Unidad</th>		
			<th>Stock Minimo</th>
			<th>Stock Maximo</th>	
			<th>Estado</th>	    																		
		</tr>
		</thead>
		<tbody>

<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){	
		
				$cod_grupo=$dat['cod_grupo']; 
				$nombre_grupo=$dat['nombre_grupo'];
				$abrev_grupo=$dat['abrev_grupo'];
				$cod_subgrupo=$dat['cod_subgrupo'];
				$nombre_subgrupo=$dat['nombre_subgrupo'];
				$abrev_subgrupo=$dat['abrev_subgrupo'];
				$cod_material=$dat['cod_material'];
				$nombre_material=$dat['nombre_material'];
				$desc_completa_material=$dat['desc_completa_material'];
				$cod_unidad_medida=$dat['cod_unidad_medida'];
				$stock_minimo=$dat['stock_minimo'];
				$stock_maximo=$dat['stock_maximo'];
				$cod_estado_registro=$dat['cod_estado_registro'];
			    $cod_usuario_registro=$dat['cod_usuario_registro'];
				$fecha_registro=$dat['fecha_registro'];
				$cod_usuario_modifica=$dat['cod_usuario_modifica'];
				$fecha_modifica=$dat['fecha_modifica'];
				$idMaterial=$dat['idMaterial'];
				$idMaterialDesc=$dat['idMaterialDesc'];

						
					$sql3=" SELECT mgc.desc_material_grupo_caracteristica,gc.nombre_grupo_carac, gc.orden ";
					$sql3.=" FROM grupos_caracteristicas gc, materiales_grupos_caracteristicas mgc ";
					$sql3.=" where mgc.cod_material='".$cod_material."'";
					$sql3.=" and gc.cod_grupo_carac=mgc.cod_grupo_carac ";
					$sql3.=" order by gc.orden asc ";
	
					$resp3= mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){
						$desc_material_grupo_caracteristica=$dat3[0];
						$nombre_grupo_carac=$dat3[1];
						$orden=$dat3[2];
						
						$nombre_material=$nombre_material." ".$desc_material_grupo_caracteristica;
					}						
			
				//**************************************************************
				$nombre_unidad_medida="";
				$sql2="select nombre_unidad_medida from unidades_medidas where cod_unidad_medida='".$cod_unidad_medida."'";
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_unidad_medida=$dat2[0];
				}					
				//**************************************************************								
				//**************************************************************
					$nombre_estado_registro="";				
					$sql2="select nombre_estado_registro from estados_referenciales";
					$sql2.=" where cod_estado_registro='".$cod_estado_registro."'";	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_estado_registro=$dat2[0];
					}	
				//**************************************************************	
		
							

				
?> 
		<tr bgcolor="#FFFFFF">	
			<td><input type="checkbox"name="cod_material"value="<?php echo $cod_material;?>"></td>	
			<td><?php echo $nombre_grupo;?></td>
			<td><?php echo $nombre_subgrupo;?></td>
			<!--td><?php echo $idMaterialDesc;?></td-->
            <td align="left"><?php 
			if($cod_material<10){
				$varAux="0000";
			}
			if($cod_material>=10 and $cod_material<100 ){
				$varAux="000";
			}	
			if($cod_material>=100 and $cod_material<1000 ){
				$varAux="00";
			}
			if($cod_material>=1000 and $cod_material<10000 ){
				$varAux="0";
			}						
			echo $abrev_grupo." ".$abrev_subgrupo." ".$varAux.$cod_material;?></td>							
    		<td><?php echo $desc_completa_material;?></td>
			<td><?php echo $nombre_unidad_medida;?></td>
			<td><?php echo $stock_minimo;?></td>			
			<td><?php echo $stock_maximo;?></td>			
			<td><?php echo $nombre_estado_registro;?></td>									
				
    	 </tr>
<?php
		 } 
?>			
			</tbody>
		</table>
					
	<!-- MODAL FILTRO-->
  <div class="modal fade modal-arriba" id="filtroModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Buscar</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </div>
        <div class="modal-body">
<table border="0" align="center">
<tr>
<td><strong>Grupo:</strong></td>
<td colspan="3">
<select name="codgrupoB" id="codgrupoB" class="textoform" onChange="listaSubGrupos(form1)"
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
				 <option value="<?php echo $cod_grupo;?>" <?php if($cod_grupo==$codgrupoB){echo "selected='selected'";}?>><?php echo $nombre_grupo;?>
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
			<select name="codsubgrupoB" id="codsubgrupoB" class="textoform">	
			<option value="0">Seleccione una opcion</option>
				<?php if($codgrupoB<>""){?>			
				<?php
					$sql2=" select cod_subgrupo, nombre_subgrupo from subgrupos ";
					$sql2.=" where cod_estado_registro=1  and cod_grupo=".$codgrupoB;
					$sql2.= "  order by  nombre_subgrupo asc";

					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_subgrupo=$dat2[0];	
			  		 		$nombre_subgrupo=$dat2[1];	
				 ?>
				 <option value="<?php echo $cod_subgrupo;?>" <?php if($cod_subgrupo==$codsubgrupoB){echo "selected='selected'";}?>><?php echo $nombre_subgrupo;?>
				 </option>					 				
				<?php		
					}
				?>		
				<?php }?>					
			</select>	
				</div>	
				</td>

</tr>
<tr>
<td><strong>Material:</strong></td>
<td colspan="3"><input type="text" name="desccompletamaterialB" id="desccompletamaterialB" size="30" class="textoform" value="<?php echo $desccompletamaterialB;?>" ></td>
<td rowspan="2"><a  onClick="buscar(form1)" class="btn btn-warning"><i class="fa fa-search"></i></a></td>
</tr>
</table>

        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>		
<?php require("cerrar_conexion.inc");
?>
<br>
<div align="center">
	<INPUT type="button" class="boton" name="btn_editar"  value="Registrar" onClick="registrar(this.form);">
	<INPUT type="button" class="boton" name="btn_eliminar"  value="Editar" onClick="editar(this.form);">	
	<INPUT type="button" class="boton" name="btn_eliminar"  value="Eliminar" onClick="eliminar(this.form);">
</div>

</form>
</body>
</html>
