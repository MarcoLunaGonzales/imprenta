<?php 
	require("conexion.inc");
	include("funciones.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>INVENTA</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script type="text/javascript">

function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function resultados_ajax(datos){
	divResultado = document.getElementById('resultados');
	ajax=objetoAjax();
	ajax.open("GET",datos);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			divResultado.innerHTML = ajax.responseText;
			cargarClasesFrame();	
			agregarTablaReporteClase();
		}
	}
	ajax.send(null)
}
function buscar()
{	
	for (i=0;i<document.form1.cod_estado_registro.length;i++){ 
       if (document.form1.cod_estado_registro[i].checked) 
          break; 
    } 
//alert('searchGastos.php?descGastoB='+document.form1.descGastoB.value+'&cod_estado_registro='+document.form1.cod_estado_registro[i].value);
resultados_ajax('searchGastos.php?descGastoB='+document.form1.descGastoB.value+'&cod_estado_registro='+document.form1.cod_estado_registro[i].value);

}
function paginar(f)
{	
	for (i=0;i<document.form1.cod_estado_registro.length;i++){ 
       if (document.form1.cod_estado_registro[i].checked) 
          break; 
    } 

	location.href='listGastos.php?descGastoB='+document.form1.descGastoB.value+'&cod_estado_registro='+document.form1.cod_estado_registro[i].value+'&pagina='+document.form1.pagina.value;
}
function paginar1(f,pagina)
{		

	f.pagina.value=pagina*1;		
	for (i=0;i<document.form1.cod_estado_registro.length;i++){ 
       if (document.form1.cod_estado_registro[i].checked) 
          break; 
    } 

	location.href='listGastos.php?descGastoB='+document.form1.descGastoB.value+'&cod_estado_registro='+document.form1.cod_estado_registro[i].value+'&pagina='+document.form1.pagina.value;	
}



</script></head>
<body bgcolor="#FFFFFF" onload="document.form1.descGastoB.focus()" >
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->

<h3 align="center" style="background:#FFFFFF;font-size: 14px;color: #E78611;font-weight:bold;">LISTADO DE GASTOS
   <a class="btn btn-warning btn-lg float-right text-white boton-filtro-iframe" href="#" data-toggle="modal" data-target="#filtroModal">
       <i class="fa fa-search"></i> BUSCAR REGISTROS
    </a>
</h3>
<form name="form1" id="form1" method="post" >
<?php

?>


<br/>
 <div id="resultados" align="center">   
<?php
	$nro_filas_show=50;	
	$pagina=$_GET['pagina'];
	//echo $pagina;
	if ($pagina==""){
		$pagina = 1;
		$fila_inicio=0;
		$fila_final=$nro_filas_show;
	}else{
		$fila_inicio=(($pagina*$nro_filas_show)-$nro_filas_show);
		$fila_final=($fila_inicio+$nro_filas_show);
	}	
	
	$sql=" select count(*)  ";
	$sql.=" from gastos g, estados_referenciales er ";
	$sql.=" where g.cod_estado_registro=er.cod_estado_registro ";	
	if($_GET['cod_estado_registro']<>0){
			$sql.=" and g.cod_estado_registro=".$_GET['cod_estado_registro'];
	}
	if($_GET['descGastoB']<>""){
			$sql.=" and g.desc_gasto like '%".$_GET['descGastoB']."%'";
	}	
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$nro_filas_sql=$dat[0];
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
		$sql=" select g.cod_gasto, g.desc_gasto, g.obs_gasto, g.cod_estado_registro, ";
		$sql.=" er.nombre_estado_registro, g.cod_usuario_registro, g.fecha_registro, ";
		$sql.=" g.cod_usuario_modifica, g.fecha_modifica ";
		$sql.=" from gastos g, estados_referenciales er ";
		$sql.=" where g.cod_estado_registro=er.cod_estado_registro ";
	if($_GET['cod_estado_registro']<>0){
			$sql.=" and g.cod_estado_registro=".$_GET['cod_estado_registro'];
	}
		if($_GET['descGastoB']<>""){
			$sql.=" and g.desc_gasto like '%".$_GET['descGastoB']."%'";
		}			
		$sql.=" order by g.desc_gasto";
		$sql.=" limit 50";
		$resp = mysql_query($sql);

?>	

	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc" class="tablaReporte" style="width:100% !important;">

	<thead>		    
	    <tr height="20px" align="center"  class="bg-success text-white">
            <th>Gasto</th>
			<th>Observaciones</th>				
    		<th>Estado</th>
			<th>Fecha de Registro</th>	
			<th>Ultima Edici&oacute;n</th>	
            <th>&nbsp;</th>	
            <th>&nbsp;</th>																		
		</tr>
		</thead>
    <tbody>
<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){
		
				$cod_gasto=$dat['cod_gasto'];
				$desc_gasto=$dat['desc_gasto'];
				$obs_gasto=$dat['obs_gasto'];
				$cod_estado_registro=$dat['cod_estado_registro'];
				$nombre_estado_registro=$dat['nombre_estado_registro'];
				$cod_usuario_registro=$dat['cod_usuario_registro'];				
				$fecha_registro=$dat['fecha_registro'];
				$cod_usuario_modifica=$dat['cod_usuario_modifica'];
				$fecha_modifica=$dat['fecha_modifica'];	
				///Usuario de Registro//////////
				if($cod_usuario_registro<>""){
					$sqlAux=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
					$sqlAux.=" from usuarios ";
					$sqlAux.=" where cod_usuario=".$cod_usuario_registro;
					$respAux = mysql_query($sqlAux);
					$nombres_usuario_registro="";
					$ap_paterno_usuario_registro="";
					$ap_materno_usuario_registro="";						
					while($datAux=mysql_fetch_array($respAux)){
						
						$nombres_usuario_registro=$datAux['nombres_usuario'];
						$ap_paterno_usuario_registro=$datAux['ap_paterno_usuario'];
						$ap_materno_usuario_registro=$datAux['ap_materno_usuario'];						
					}
				}
				////////////////////////////////	
				///Usuario de Modifica//////////
				if($cod_usuario_modifica<>""){
					$sqlAux=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
					$sqlAux.=" from usuarios ";
					$sqlAux.=" where cod_usuario=".$cod_usuario_modifica;
					$respAux = mysql_query($sqlAux);
					$nombres_usuario_modifica="";
					$ap_paterno_usuario_modifica="";
					$ap_materno_usuario_modifica="";						
					while($datAux=mysql_fetch_array($respAux)){
						
						$nombres_usuario_modifica=$datAux['nombres_usuario'];
						$ap_paterno_usuario_modifica=$datAux['ap_paterno_usuario'];
						$ap_materno_usuario_modifica=$datAux['ap_materno_usuario'];						
					}
				}
				////////////////////////////////				
				
?> 
		<tr bgcolor="#FFFFFF">	
    		<td align="left"><?php echo $desc_gasto;?></td>
    		<td><?php echo $obs_gasto;?></td>
    		<td><?php echo $nombre_estado_registro; ?></td>
			<td>
			<?php
				if($fecha_registro<>""){ 
					echo strftime("%d/%m/%Y",strtotime($fecha_registro))." ". $nombres_usuario_registro[0].$ap_paterno_usuario_registro[0].$ap_materno_usuario_registro[0]; 
				}
			?>
            </td>
   			<td><?php 
				if($fecha_modifica<>""){
				echo strftime("%d/%m/%Y",strtotime($fecha_modifica))." ". $nombres_usuario_modifica[0].$ap_paterno_usuario_modifica[0].$ap_materno_usuario_modifica[0];
				}
				 ?></td>
            <td><a href="editGasto.php?cod_gasto=<?php echo $cod_gasto;?>" class="btn btn-success text-white"><i class="fa fa-edit"></i></a></td>
            <td><a href="deleteGasto.php?cod_gasto=<?php echo $cod_gasto;?>" class="btn btn-danger text-white"><i class="fa fa-trash"></i></a></td>

					
   	  </tr>
<?php
		 } 
?>		
  	</tbody>
  </table>
		</div>			

</div>	

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
 <table width="323" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr >
          <td width="122" align="right" >TODOS</td>
          <td width="20"><label>
            <input name="cod_estado_registro" type="radio" id="cod_estado_registro" value="0"  <?php if($_GET['cod_estado_registro']==0){?> checked="checked" <?php }?> onclick="buscar()"/>
          </label></td>
          <?php 
		  	$queryEstado=" select cod_estado_registro, nombre_estado_registro  from estados_referenciales ";
			$queryEstado.=" order by  cod_estado_registro ";
			$resp= mysql_query($queryEstado);
			while($dat=mysql_fetch_array($resp)){
				$cod_estado_registro=$dat['cod_estado_registro'];
				$nombre_estado_registro=$dat['nombre_estado_registro'];
		 ?>
         	    <td width="126" align="right" ><?php echo $nombre_estado_registro;?></td>
        		<td width="20">
		    	 <label>
	               <input name="cod_estado_registro" type="radio" id="cod_estado_registro" value="<?php echo $cod_estado_registro;?>"  onclick="buscar()" <?php if($cod_estado_registro==$_GET['cod_estado_registro']){?> checked="checked" <?php }?> />
        		  </label>
          		</td>
		 <?php
			}
		  
		  ?>
        </tr>
      </table>
      <br/>

    <table width="323" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr class="texto">
          <td width="67" align="right" class="al_derecha">Buscar</td>
          <td width="256" align="left"><span id="sprytextfield1">
            <label for="elemento"></label>
            <input name="descGastoB" type="text" class="textoform" id="descGastoB" value="<?php echo $_GET['descGastoB']; ?>" onkeyup="buscar()" size="50" />
</span></td>
          </tr>
    </table>
    <div align="right"><a href="newGasto.php" class="btn btn-warning"><i class="fa fa-plus"></i> NUEVO GASTO</a></div>

        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
