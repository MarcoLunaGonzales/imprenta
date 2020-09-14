<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Registro de Cargo</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
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
		{	alert('Debe seleccionar las caracteristicas del Item.');
			return(false);
		}
		f.datos.value=datos;		
		f.submit();
		
	}
	function cancelar(codItem,codCompItem){
		window.location="navegadorCompCarac.php?codItem="+codItem+"&codComp="+codCompItem;
	}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="guardaRegistrarCompCarac.php">
<?php 
	require("conexion.inc");
	$codItem=$_POST['codItemF'];
	$codComp=$_POST['codCompItemF'];
	
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
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">REGISTRAR COMPONENTE</h3>

	<div align="center">
	<b>Nombre Item&nbsp;::&nbsp;</b><?php echo $nombreItem;?><br>
	<b>Nombre Componente&nbsp;::&nbsp;</b><?php echo $nombreCompItem;?>
	</div><br>
	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
		 <tr bgcolor="#FFFFFF">
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">CARACTERISTICAS DE ITEM </td>
		 </tr>	
		<?php 
		$sql2="select cod_carac,desc_carac from caracteristicas ";
		$sql2.=" where cod_carac not in (select cod_carac from componentes_caracteristica where cod_compitem=".$codComp.")";
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$cod_carac=$dat2[0];
						$desc_carac=$dat2[1];
			?>	
		 <tr bgcolor="#FFFFFF">
    	 		<td align="right"><input type="checkbox"name="cod_carac"value="<?php echo $cod_carac;?>"></td>
				<td><?php echo $desc_carac;?></td>
	     </tr>					
			<?php		}
			?>
    	</tr>
	</table>
	<br>
<div align="center">
<INPUT type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
<INPUT type="button"  class="boton"  name="btn_limpiar" value="Cancelar" onClick="cancelar('<?php echo $codItem;?>','<?php echo $codComp;?>');"  >
</div>
<input type="hidden" name="codItemF"  value="<?php echo $codItem;?>" >
<input type="hidden" name="codCompItemF"  value="<?php echo $codComp;?>" >
<input type="hidden" name="datos"  value="0" >
</form>
<?php require("cerrar_conexion.inc");?>

</body>
</html>
