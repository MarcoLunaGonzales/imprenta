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
<script language='Javascript'>
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
	ajax.open("GET", datos);
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
<body bgcolor="#F7F5F3" onload="document.form1.descGastoB.focus()" >
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->

<h3 align="center" style="background:#F7F5F3;font-size: 14px;color: #E78611;font-weight:bold;">LISTADO DE CLIENTES
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
	$nro_filas_show=100;	
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
	$sql.=" from clientes cli, ciudades ciu, clientes_categorias cat, estados_referenciales er ";
	$sql.=" where cli.cod_categoria=cat.cod_categoria";
	$sql.=" and  cli.cod_ciudad=ciu.cod_ciudad";
	$sql.=" and cli.cod_estado_registro=er.cod_estado_registro ";
	$sql.=" order by cli.nombre_cliente asc ";

	/*$sql.=" from gastos g, estados_referenciales er ";
	$sql.=" where g.cod_estado_registro=er.cod_estado_registro ";	
	if($_GET['cod_estado_registro']<>0){
			$sql.=" and g.cod_estado_registro=".$_GET['cod_estado_registro'];
	}
	if($_GET['descGastoB']<>""){
			$sql.=" and g.desc_gasto like '%".$_GET['descGastoB']."%'";
	}	*/
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
		$sql=" select cli.cod_cliente, cli.nombre_cliente, cli.cod_categoria, cat.desc_categoria, cli.cod_ciudad, ";
		$sql.=" ciu.desc_ciudad, cli.direccion_cliente, cli.telefono_cliente,";
		$sql.=" cli.celular_cliente, cli.fax_cliente, cli.email_cliente, cli.obs_cliente, cli.cod_usuario_registro,";
		$sql.=" cli.fecha_registro, cli.cod_usuario_modifica, cli.fecha_modifica, cli.cod_estado_registro, er.nombre_estado_registro";
		$sql.=" from clientes cli, ciudades ciu, clientes_categorias cat, estados_referenciales er";
		$sql.=" where cli.cod_categoria=cat.cod_categoria";
		$sql.=" and  cli.cod_ciudad=ciu.cod_ciudad";
		$sql.=" and cli.cod_estado_registro=er.cod_estado_registro ";
		
	/*if($_GET['cod_estado_registro']<>0){
			$sql.=" and g.cod_estado_registro=".$_GET['cod_estado_registro'];
	}
		if($_GET['descGastoB']<>""){
			$sql.=" and g.desc_gasto like '%".$_GET['descGastoB']."%'";
		}		*/	
		$sql.=" order by cli.nombre_cliente asc";
		$sql.=" limit 50";
		$resp = mysql_query($sql);

?>	

	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc" class="tablaReporte" style="width:100% !important;">   
	<thead>		
	    <tr height="20px" align="center"  class="bg-success text-white">
            <th>&nbsp;</th>
            <th>Cliente</th>
            <th>Categoria</th>	
			<th>Ciudad</th>				
    		<th>Direcci&oacute;n</th>
            <th>Celular</th>
			<th>Telefono</th>	
            <th>Fax</th>
            <th>Email</th>
            <th>Observaciones</th>	
            <th>Estado</th>																		
		</tr>
	</thead>
    <tbody>
<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){
			
				$cod_cliente=$dat['cod_cliente'];
				$nombre_cliente=$dat['nombre_cliente'];
				$cod_categoria=$dat['cod_categoria'];
				$desc_categoria=$dat['desc_categoria'];
				$cod_ciudad=$dat['cod_ciudad'];
				$desc_ciudad=$dat['desc_ciudad'];
				$direccion_cliente=$dat['direccion_cliente'];
				$telefono_cliente=$dat['telefono_cliente'];
				$celular_cliente=$dat['celular_cliente'];
				$fax_cliente=$dat['fax_cliente'];
				$email_cliente=$dat['email_cliente'];
				$obs_cliente=$dat['obs_cliente'];
				$cod_usuario_registro=$dat['cod_usuario_registro'];
				$fecha_registro=$dat['fecha_registro'];
				$cod_usuario_modifica=$dat['cod_usuario_modifica'];
				$fecha_modifica=$dat['fecha_modifica'];
				$cod_estado_registro=$dat['cod_estado_registro'];
				$nombre_estado_registro=$dat['nombre_estado_registro'];
		
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
				$cont=$cont+1;
				
?> 
		<tr bgcolor="#FFFFFF">	
    		<td align="left"><?php echo $cont;?></td>
            <td align="left"><?php echo $nombre_cliente;?></td>
    		<td><?php echo $desc_categoria;?></td>
    		<td><?php echo $desc_ciudad; ?></td>
            <td><?php echo $direccion_cliente; ?></td>
            <td><?php echo $celular_cliente; ?></td>
            <td><?php echo $telefono_cliente; ?></td>
            <td><?php echo $fax_cliente; ?></td>
            <td><?php echo $email_cliente; ?></td>
            <td><?php echo $obs_cliente; ?></td>
            <td><?php echo $nombre_estado_registro; ?></td>
			<!--td>
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


					
   	  </tr-->
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
          <td width="67" align="right" class="al_derecha">Cliente</td>
          <td width="256" align="left"><span id="sprytextfield1">
            <label for="elemento"></label>
            <input name="nombreClienteB" type="text" class="textoform" id="nombreClienteB" value="<?php echo $_GET['nombreClienteB']; ?>" onkeyup="buscar()" size="50" />
</span></td>
          </tr>
                <tr class="texto">
          <td width="67" align="right" class="al_derecha">Ciudad</td>
          <td width="256" align="left">
          <select name="cod_ciudad" id="cod_ciudad" class="textoform">
         <option value="0" >TODAS</option>
		<?php
        
			$sql2=" select cod_ciudad, desc_ciudad from ciudades ";
		    $resp2 = mysql_query($sql2);	
			while($dat2=mysql_fetch_array($resp2)){
				$cod_ciudad=$dat2['cod_ciudad'];
				$desc_ciudad=$dat2['desc_ciudad'];
		?>
        	<option value="<?php echo $cod_ciudad;?>" <?php if($cod_ciudad==$_GET['cod_ciudad']){?> selected <?php }?> ><?php echo $desc_ciudad;?></option>
        <?php
			}
		?>              
   		    </select>
            </td>
          </tr>   
      <tr class="texto">
          <td width="67" align="right" class="al_derecha">Categoria</td>
          <td width="256" align="left">
          <select name="cod_categoria" id="cod_categoria" class="textoform">
         <option value="0" >TODAS</option>
		<?php
        
			$sql2=" select cod_categoria, desc_categoria from clientes_categorias ";
		    $resp2 = mysql_query($sql2);	
			while($dat2=mysql_fetch_array($resp2)){
				$cod_categoria=$dat2['cod_categoria'];
				$desc_categoria=$dat2['desc_categoria'];
		?>
        	<option value="<?php echo $cod_categoria;?>" <?php if($cod_categoria==$_GET['cod_categoria']){?> selected <?php }?> ><?php echo $desc_categoria;?></option>
        <?php
			}
		?>              
   		    </select>
            </td>
          </tr>     
      <tr class="texto">
          <td width="67" align="right" class="al_derecha">Estado</td>
          <td width="256" align="left">
          <select name="cod_estado_registro" id="cod_estado_registro" class="textoform">
         <option value="0" >TODOS LOS ESTADOS</option>
		<?php
        
			$sql2=" select cod_estado_registro, nombre_estado_registro from estados_referenciales ";
		    $resp2 = mysql_query($sql2);	
			while($dat2=mysql_fetch_array($resp2)){
				$cod_estado_registro=$dat2['cod_estado_registro'];
				$nombre_estado_registro=$dat2['nombre_estado_registro'];
		?>
        	<option value="<?php echo $cod_estado_registro;?>" <?php if($cod_estado_registro==$_GET['cod_estado_registro']){?> selected <?php }?> ><?php echo $nombre_estado_registro;?></option>
        <?php
			}
		?>              
   		    </select>
            </td>
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


</form>
</body>
</html>
