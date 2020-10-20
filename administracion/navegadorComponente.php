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
			//alert("modificarComponente.php?codCompItem="+cod_registro+"&codItem="+codItemF);
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
	window.location="navegadorItems.php";
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">COMPONENTES ITEMS</h3>
<form name="form1" method="post" action="registrarComponente.php" >
<?php 
	require("conexion.inc");
	include("funciones.php");

?>
<?php	
	$codItem=$_GET['codigo'];
	$sql_00="select desc_item from items where cod_item=".$codItem;
	$resp_00 = mysql_query($sql_00);
	$nombreItem="";
	if($dat_00=mysql_fetch_array($resp_00)){
		$nombreItem=$dat_00[0];
	}
	$sql_aux=" select count(*) from componente_items where cod_item=".$codItem;
	$resp_aux = mysql_query($sql_aux);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}

		$sql="select cod_compitem,nombre_componenteitem from componente_items  where cod_item=".$codItem;
		$sql.=" order by nombre_componenteitem asc";
		$resp = mysql_query($sql);

?>	
	<table width="50%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc" class="tablaReporte" style="width:100% !important;">
		<thead>
	    <tr height="20px" align="center"  class="bg-success text-white">
			<th>&nbsp;</th>
			<th>Componente Item</th>
			<th>Detalle Cacteristica</th>
		</tr>
	  </thead>
	  <tbody>

<?php   
		while($dat=mysql_fetch_array($resp)){	
		
				$codCompItem=$dat[0];
				$nombreCompItem=$dat[1]; 
				
?> 
		<tr bgcolor="#FFFFFF" valign="middle">	
			<td><input type="checkbox"name="codCompItem"value="<?php echo $codCompItem;?>"></td>					
    		<td>&nbsp;<?php echo $nombreCompItem;?>&nbsp;</td>
			<td>
			<ul>
			<?php
			$sql_01="select c.desc_carac,cc.orden from componentes_caracteristica cc,caracteristicas c";
			$sql_01.=" where cc.cod_carac=c.cod_carac and  cc.cod_compitem=".$codCompItem." order by cc.orden  asc";
			$resp_01 = mysql_query($sql_01);
			while($dat_01=mysql_fetch_array($resp_01)){	
				$nombreCaracteristica=$dat_01[0];
				$orden=$dat_01[1];
			?>
				<li><?php echo $orden.". ".$nombreCaracteristica;?></li>
			<?php
			}
			?>
			</ul>
			</td>
    	 </tr>
<?php
		 } 
?>			
          </tbody>	
		</table>
		</div>			
		
<?php require("cerrar_conexion.inc");
?>
<br>
<div align="center">
	<INPUT type="button" class="boton" name="btn_editar"  value="Registrar" onClick="registrar(this.form);">
	<INPUT type="button" class="boton" name="btn_eliminar"  value="Editar" onClick="editar(this.form);">	
	<INPUT type="button" class="boton" name="btn_eliminar"  value="Eliminar" onClick="eliminar(this.form);">
	<INPUT type="button"  class="boton"  name="btn_limpiar" value="Cancelar" onClick="cancelar();"  >
</div>
<input type="hidden" name="codItemF" id="codItemF"  value="<?php echo $codItem;?>" >
</form>
</body>
</html>
