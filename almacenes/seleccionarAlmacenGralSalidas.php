<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Seleccion de Almacen </title>
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
function listaAlmacenes(f)
{	
		var div_almacenes,cod_sucursal;
		div_almacenes=document.getElementById("div_almacenes");			
		cod_sucursal=f.cod_sucursal.value;	
		ajax=nuevoAjax();
		
	
		ajax.open("GET","ajax_listaAlmacenes.php?cod_sucursal="+cod_sucursal,true);				
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
			div_almacenes.innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null)
		

}	
	
function aceptar(f)
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
	{	alert('Debe seleccionar un Almacen para el Ingreso de Materiales.');
	}
	else
	{
		if(j==0)
		{
			alert('Debe seleccionar un Almacen para el Ingreso de Materiales.');
		}
		else
		{
			window.location="navegadorSalidas.php?cod_almacen="+cod_registro;
		}
	}
}		
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" >
<?php 	require("conexion.inc");?>
<h3 align="center" style="background:white;font-size: 14px;color:#E78611;font-weight:bold;">Seleccionar Almacen </h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="40%" bgColor="#cccccc" border="0">
	<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">SELECCION DE ALMACEN </td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Sucursal</td>
      		<td>
			<select name="cod_sucursal" class="textoform" onChange="listaAlmacenes(this.form)">
			<option value="0">Seleccione un Registro</option>
              <?php
					$sql2=" select cod_sucursal, nombre_sucursal from sucursales ";
					$sql2.=" where cod_estado_registro=1 order by  cod_sucursal asc ";
					$resp2=mysql_query($sql2);
						$sw=0;
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_sucursal=$dat2[0];	
							if($sw==0){
								$cod_sucursal_seleccionado=$cod_sucursal;
								$sw=1;
							}
			  		 		$nombre_sucursal=$dat2[1];	
				 ?>
      		  		<option value="<?php echo $cod_sucursal;?>"><?php echo $nombre_sucursal;?></option>
              <?php		
					}
				?>
            </select>
			</td>
    	</tr>	
		<tr class="titulo_tabla">
		<td  colSpan="2" align="center">ALMACENES</td>
	  </tr>	

		<tr bgcolor="#FFFFFF">
		
		<td colspan="2"  align="center">
		<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#ffffff" border="0">
		<tr bgcolor="#FFFFFF">
		<td colspan="2">
		<div id="div_almacenes">
				
		</div>
		</td>
		</tr>
		</table>
		</td>
		</tr>					
	  </tbody>
	</table>	

<br>
<div align="center">
	<input type="button" class="boton" name="btn_guardar" value="Aceptar" onClick="aceptar(this.form);"  >
</div>
</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>
