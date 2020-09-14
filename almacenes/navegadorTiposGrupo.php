<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Items</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>

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
	var codItemF=document.getElementById("codItemF").value;
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
			location.href="modificarComponente.php?codCompItem="+cod_registro+"&codItem="+codItemF;
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
	var codItemF=document.getElementById("codItemF").value;	
	if(j==0)
	{	alert('Debe seleccionar al menos un registro para eliminarlo.');
		return(false);
	}
	else
	{	
			window.location ="listaElimarComponente.php?datos="+datos+"&codItemF="+codItemF
	}
}
function cancelar(){
	window.location="navegadorGrupos.php";
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<h3 align="center" style="background:white;font-size: 14px;color:#E78611;font-weight:bold;">Tipos de Grupo </h3>
<form name="form1" method="post" action="registrarTiposGrupo.php" >
<?php 
	require("conexion.inc");
	include("funciones.php");

?>
<?php	
	$cod_grupo=$_GET['cod_grupo'];

	$sql="select nombre_grupo from grupos where cod_grupo=".$cod_grupo;
	$resp = mysql_query($sql);
	$nombre_grupo="";
	if($dat=mysql_fetch_array($resp)){
		$nombre_grupo=$dat[0];
	}
	$sql_aux=" select count(*) from tipos_grupo where cod_grupo=".$cod_grupo;
	$resp_aux = mysql_query($sql_aux);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}

?>
<input type="hidden" name="cod_grupo" id="cod_grupo"  value="<?php echo $cod_grupo;?>" >
	<div align="center"><b>Grupo&nbsp;::&nbsp;</b><?php echo $nombre_grupo;?></div><br>
<?php	
	if($nro_filas_sql==0){
?>	
	<table width="50%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>&nbsp;</td>
			<td>Tipo</td>
			<td>Estado</td>
		</tr>
		<tr><th colspan="11" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
	</table>
	
<?php	
	}else{
		$sql=" select cod_tipo_grupo,nombre_tipo_grupo,cod_estado_registro, ";
		$sql.=" cod_usuario_registro, fecha_registro, cod_usuario_modifica, fecha_modifica";
		$sql.="	from tipos_grupo  where cod_grupo=".$cod_grupo;
		$sql.=" order by nombre_tipo_grupo asc";
		$resp = mysql_query($sql);

?>	
	<table width="50%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>&nbsp;</td>
			<td>Tipo</td>
			<td>Estado</td>
		</tr>

<?php   
		while($dat=mysql_fetch_array($resp)){	
		
				$cod_tipo_grupo=$dat[0];
				$nombre_tipo_grupo=$dat[1]; 
				$cod_estado_registro=$dat[2];
				$cod_usuario_registro=$dat[3];
				$fecha_registro=$dat[4];
				$cod_usuario_modifica=$dat[5];
				$fecha_modifica=$dat[6];				 
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
		<tr bgcolor="#FFFFFF" valign="middle">	
			<td><input type="checkbox"name="cod_tipo_grupo"value="<?php echo $cod_tipo_grupo;?>"></td>					
    		<td><?php echo $nombre_tipo_grupo;?></td>
			<td><?php echo $nombre_estado_registro;?></td>
    	 </tr>
<?php
		 } 
?>			

		</TABLE>
		</div>			
<?php
	}
?>
		
<?php require("cerrar_conexion.inc");
?>
<input type="hidden" name="cod_grupo" value="<?php echo $cod_grupo;?>">
<br>
<div align="center">
	<INPUT type="button" class="boton" name="btn_editar"  value="Registrar" onClick="registrar(this.form);">
	<INPUT type="button" class="boton" name="btn_editar"  value="Editar" onClick="editar(this.form);">	
	<INPUT type="button" class="boton" name="btn_eliminar"  value="Eliminar" onClick="eliminar(this.form);">
	<INPUT type="button"  class="boton"  name="btn_limpiar" value="Cancelar" onClick="cancelar();"  >
</div>

</form>
</body>
</html>
