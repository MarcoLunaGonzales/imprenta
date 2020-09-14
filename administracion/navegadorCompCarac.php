<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Items</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>


function paginar(f)
{	
	location.href="navegadorItems.php?pagina="+f.pagina.value;
		
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
			window.location="modificarItem?cod_item="+cod_registro;
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
	var codItem=document.getElementById('codItemF').value;
	var codCompItem=document.getElementById('codCompItemF').value;
	if(j==0)
	{	alert('Debe seleccionar al menos un registro para eliminarlo.');
		return(false);
	}
	else
	{	
			window.location ="listaEliminarCompCarac.php?datos="+datos+"&codItem="+codItem+"&codCompItem="+codCompItem;			
	}
}
	function cancelar(obj){
		window.location="navegadorComponente.php?codigo="+obj;
	}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">CARACTERISTICAS</h3>
<form name="form1" method="post" action="registrarCompCarac.php" >
<?php 
	require("conexion.inc");
	include("funciones.php");

?>
<?php	
	$codItem=$_GET['codItem'];
	$codComp=$_GET['codComp'];
	$sql_00="select desc_item from items where cod_item=".$codItem;
	$resp_00 = mysql_query($sql_00);
	$nombreItem="";
	if($dat_00=mysql_fetch_array($resp_00)){
		$nombreItem=$dat_00[0];
	}
	$sql_00="select nombre_componenteitem from componente_items where cod_item=".$codItem." and cod_compitem=".$codComp;
	$resp_00 = mysql_query($sql_00);
	$nombreCompItem="";
	if($dat_00=mysql_fetch_array($resp_00)){
		$nombreCompItem=$dat_00[0];
	}	
	$sql_aux=" select count(*) from componente_items where cod_item=".$codItem." and cod_compitem=".$codComp;
	$resp_aux = mysql_query($sql_aux);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}
?>
	<div align="center">
	<b>Nombre Item&nbsp;::&nbsp;</b><?php echo $nombreItem;?><br>
	<b>Nombre Componente&nbsp;::&nbsp;</b><?php echo $nombreCompItem;?>
	</div><br>
<?php
	if($nro_filas_sql==0){
?>
	<div aling="center" >Nombre Item&nbsp;::&nbsp;<?php echo $nombreItem;?></div>
	<table width="50%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>&nbsp;</td>
			<td>Caracteristica</td>
		</tr>
		<tr><th colspan="11" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
	</table>
	
<?php	
	}else{


?>	
	<table width="50%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>&nbsp;</td>
			<td>Caracteristica</td>
		</tr>

<?php   
		$sql="select cc.cod_carac,c.desc_carac from  componentes_caracteristica cc, caracteristicas c";
		$sql.=" where cc.cod_carac=c.cod_carac and cc.cod_compitem=".$codComp." order by c.desc_carac asc";
		$resp = mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){	
		
				$codCarac=$dat[0];
				$nombreCarac=$dat[1]; 
				
?> 
		<tr bgcolor="#FFFFFF" valign="middle">	
			<td><input type="checkbox"name="cod_item"value="<?php echo $codCarac;?>"></td>					
    		<td>&nbsp;<?php echo $nombreCarac;?>&nbsp;</td>
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
<br>
<div align="center">
	<INPUT type="button" class="boton" name="btn_editar"  value="Registrar" onClick="registrar(this.form);">
	<INPUT type="button" class="boton" name="btn_eliminar"  value="Eliminar" onClick="eliminar(this.form);">
	<INPUT type="button"  class="boton"  name="btn_limpiar" value="Cancelar" onClick="cancelar('<?php echo $codItem;?>');"  >
</div>
<input type="hidden" name="codItemF" id="codItemF"  value="<?php echo $codItem;?>" >
<input type="hidden" name="codCompItemF" id="codCompItemF"  value="<?php echo $codComp;?>" >
</form>
</body>
</html>
