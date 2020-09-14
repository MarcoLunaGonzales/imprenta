<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Registro de Cargo</title>
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
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form  name="form1" method="post" action="guardaRegistrarComponente.php" accept-charset="UTF-8">
<?php 
	require("conexion.inc");
	$codItemF=$_POST['codItemF'];
	$cod_estado_registro=1;
	$sql2=" select nombre_estado_registro from estados_referenciales where cod_estado_registro='".$cod_estado_registro."'";
    $resp2 = mysql_query($sql2);	
	$nombre_estado_registro="";
	$dat2=mysql_fetch_array($resp2);
	$nombre_estado_registro=$dat2[0];

?>
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">REGISTRAR COMPONENTE</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">

		 <tr class="titulo_tabla">
		   <td  colSpan="3" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td width="19%">Componente</td>
      		<td colspan="2"><input type="text"  class="textoform" size="50" name="nombre_componenteitem" ></td>
    	</tr>
		<tr bgcolor="#FFFFFF">
     		<td>Estado de Registro</td>
      		<td colspan="2"><?php echo $nombre_estado_registro;?></td>
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
				
?> 
		<tr bgcolor="#FFFFFF" valign="middle">	
			<td><input type="checkbox"name="cod_carac"value="<?php echo $codCarac;?>"></td>	
		  <td width="4%"><input type="text" class="textoform" name="orden" size="3"></td>				
    		<td width="77%"><?php echo $nombreCarac;?>&nbsp;</td>
			
   	  </tr>
<?php
		 } 
?>	
	</table>
	<br>
<div align="center">
	<INPUT type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
	<INPUT type="button"  class="boton"  name="btn_limpiar" value="Cancelar" onClick="cancelar('<?php echo $codItemF;?>');"  >
</div>
<input type="hidden" name="codItemF"  value="<?php echo $codItemF;?>" >
<input type="hidden" name="datos"  value="0" >
</form>
<?php require("cerrar_conexion.inc");?>

</body>
</html>

