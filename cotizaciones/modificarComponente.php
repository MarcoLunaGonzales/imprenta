<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>Edici&oacute;n Componente</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
		if(f.nombre_componenteitem.value==""){
			alert("El campo Componente se encuentra vacio.")
			f.nombre_componenteitem.focus();
		 	return(false);
			
		}
		
		var i;
		var j=0;
		datos=new Array();
		for(i=0;i<=f.length-1;i++)
		{
			if(f.elements[i].type=='checkbox')
			{	if(f.elements[i].checked==true)
				{	
					if(f.elements[i+1].value==""){
						alert("Debe llenar el orden en el que debe ser llenado las caracteristicas");
						return(false);
					}					
					datos[j]=f.elements[i].value+"|"+f.elements[i+1].value;
					j=j+1;
				}
			}
		}
		if(j==0)
		{	alert('Debe seleccionar las caracteristicas del Componente.');
			return(false);
		}
		//alert("datos="+datos);
		f.datos.value=datos;
		
		if(confirm("Esta seguro de grabar.")){
			f.submit();
		}else{
			return(false);
		}		
	}	
	
	function cancelar(obj){
		window.location="navegadorComponente.php?codigo="+obj;
	}

</script>

</head>
<body>

<form method="post" action="guardaModificarComponente.php" accept-charset="UTF-8">

<?php 
	require("conexion.inc");
	$codItem=$_GET['codItem'];
	$codCompItem=$_GET['codCompItem'];
	
	$sql=" select nombre_componenteitem from componente_items where  cod_compitem=".$codCompItem;
    $resp= mysql_query($sql);	
	while($dat=mysql_fetch_array($resp)){
		$nombre_componenteitem=$dat[0];
	}

?>


<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">MODIFICAR COMPONENTE</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">

		 <tr class="titulo_tabla">
		   <td  colSpan="3" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Componente</td>
      		<td colspan="2"><input type="text"  class="textoform" size="50" name="nombre_componenteitem" value="<?php echo $nombre_componenteitem;?>"></td>
    	</tr>
		<tr height="20px" align="center"  class="titulo_tabla">
			 <td  colSpan="3" align="center">Caracteristicas</td>
		</tr>

	<?php   
		$sql="select cod_carac, desc_carac from  caracteristicas  order by desc_carac asc";
		$resp = mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){	
				$codCarac=$dat[0];
				$nombreCarac=$dat[1]; 
					$sw=0;
					$orden="";
					$sql2="select orden from componentes_caracteristica ";
					$sql2.=" where cod_carac=".$codCarac." and cod_compitem=".$codCompItem;
					$resp2 = mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$orden=$dat2[0];
						$sw=1;
					}
			
?> 
		<tr bgcolor="#FFFFFF" valign="middle">	
		<td><input type="checkbox"name="cod_carac"value="<?php echo $codCarac;?>" <?php if($sw==1){?> checked="checked"<?php } ?>></td>	
		  <td width="4%"><input type="text" class="textoform" name="orden" value="<?php echo $orden;?>" size="3"></td>				
    		<td width="77%"><?php echo $nombreCarac;?>&nbsp;</td>
			
   	  </tr>
<?php
		 } 
?>

	</table>	
	<br>
<div align="center">
<INPUT type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
<INPUT type="button"  class="boton"  name="btn_limpiar" value="Cancelar" onClick="cancelar('<?php echo $codItem;?>');"  >
</div>
<input type="hidden" name="datos" >
<input type="hidden" name="codItem"  value="<?php echo $codItem;?>" >
<input type="hidden" name="codCompItem"  value="<?php echo $codCompItem;?>" >

<?php require("cerrar_conexion.inc");?>

</body>
</html>
