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
			divResultado.innerHTML = ajax.responseText
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
resultados_ajax('searchAreas.php?elemento='+document.form1.elemento.value+'&cod_estado_registro='+document.form1.cod_estado_registro[i].value);

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
			window.location="editArea.php?cod_area="+cod_registro;
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
			window.location ="listaEliminarAreas.php?datos="+datos;			
	}
}
</script></head>
<body bgcolor="#FFFFFF" onload="document.form1.elemento.focus()" >
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->

<h3 align="center" style="background:#FFFFFF;font-size: 14px;color: #E78611;font-weight:bold;">LISTADO DE AREAS</h3>
<form name="form1" method="post" action="newArea.php">

 <table width="323" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr >
          <td width="122" align="right" >TODOS</td>
          <td width="20"><label>
            <input name="cod_estado_registro" type="radio" id="cod_estado_registro" value="0" checked="checked" onclick="buscar()"/>
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
	               <input name="cod_estado_registro" type="radio" id="cod_estado_registro" value="<?php echo $cod_estado_registro;?>"  onclick="buscar()"/>
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
            <input name="elemento" type="text" class="textoform" id="elemento" onkeyup="buscar()" size="50" />
</span></td>
          </tr>
    </table>

<br/>
 <div id="resultados" align="center">   
<?php	
	
	$sql_aux=" select count(*) from areas a , estados_referenciales e ";
	$sql_aux.=" where a.cod_estado_registro=e.cod_estado_registro";		
	$resp_aux = mysql_query($sql_aux);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}
?>
	<div id="nroRows" align="center" class="textoform"><?php echo "Nro. de Registros: ".$nro_filas_sql; ?></div>
    <br/>
<?php
	if($nro_filas_sql==0){
?>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>&nbsp;</td>
            <td>Area</td>
			<td>Observaciones</td>				
    		<td>Estado</td>
			<td>Fecha de Registro</td>	
			<td>Ultima Edicion</td>																
		</tr>
		<tr><th colspan="6" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
	</table>
	
<?php	
	}else{
		//Calculo de Nro de Paginas
				
		//Fin de calculo de paginas
		$sql=" select a.cod_area, a.nombre_area, a.obs_area, a.cod_estado_registro, e.nombre_estado_registro, a.fecha_registro, ";
		$sql.=" a.cod_usuario_registro, a.fecha_modifica, a.cod_usuario_modifica ";
		$sql.=" from areas a , estados_referenciales e ";
		$sql.=" where a.cod_estado_registro=e.cod_estado_registro ";
		$sql.=" order by a.nombre_area asc ";
		$resp = mysql_query($sql);

?>	
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>&nbsp;</td>
            <td>Area</td>
			<td>Observaciones</td>				
    		<td>Estado</td>
			<td>Fecha de Registro</td>	
			<td>Ultima Edicion</td>																		
		</tr>

<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){
		
				$cod_area=$dat['cod_area'];
				$nombre_area=$dat['nombre_area'];
				$obs_area=$dat['obs_area'];
				$cod_estado_registro=$dat['cod_estado_registro'];
				$nombre_estado_registro=$dat['nombre_estado_registro'];
				$fecha_registro=$dat['fecha_registro'];
				$cod_usuario_registro=$dat['cod_usuario_registro'];
				$fecha_modifica=$dat['fecha_modifica'];
				$cod_usuario_modifica=$dat['cod_usuario_modifica'];
		


				
?> 
		<tr bgcolor="#FFFFFF">	
			<td><input type="checkbox"name="cod_area"value="<?php echo $cod_area;?>"></td>	
    		<td><?php echo $nombre_area;?></td>
    		<td><?php echo $obs_area;?></td>
    		<td><?php echo $nombre_estado_registro; ?></td>
			<td>&nbsp;</td>
   			<td>&nbsp;</td>

					
   	  </tr>
<?php
		 } 
?>			
  </TABLE>
		</div>			
<?php
	}
?>
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
