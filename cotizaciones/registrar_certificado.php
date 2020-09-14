<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Registro de Certificado</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />

<script language='Javascript'>
	function nuevoAjax()
	{		var xmlhttp=false;
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

	function datosProducto(f)
	{	
		var div_marca,cod_producto,cod_empresa;
		div_marca=document.getElementById("div_marca");			
		div_cia_productora=document.getElementById("div_cia_productora");		
		div_cia_productora_bolivia=document.getElementById("div_cia_productora_bolivia");	
		div_fichas=document.getElementById("div_fichas");			
		cod_producto=f.cod_producto.value;	
		cod_empresa=f.cod_empresa.value;	
		ajax=nuevoAjax();
		ajax2=nuevoAjax();
		ajax3=nuevoAjax();	
		ajax4=nuevoAjax();		
		

		ajax.open("GET","ajax_mostrarMarca.php?cod_producto="+cod_producto,true);				
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
				div_marca.innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null)
		
		ajax2.open("GET","ajax_mostrarCiaProductora.php?cod_producto="+cod_producto,true);				
		ajax2.onreadystatechange=function(){
			if (ajax2.readyState==4) {
				div_cia_productora.innerHTML=ajax2.responseText;
		    }
	    }		
		ajax2.send(null)
		
		ajax3.open("GET","ajax_mostrarCiaProductoraBolivia.php?cod_producto="+cod_producto,true);				
		ajax3.onreadystatechange=function(){
			if (ajax3.readyState==4) {
				div_cia_productora_bolivia.innerHTML=ajax3.responseText;
		    }
	    }		
		ajax3.send(null)
		
		ajax4.open("GET","ajax_mostrarFichas.php?cod_producto="+cod_producto+"&cod_empresa="+cod_empresa,true);				
		ajax4.onreadystatechange=function(){
			if (ajax4.readyState==4) {
				div_fichas.innerHTML=ajax4.responseText;
		    }
	    }		
		ajax4.send(null)
		
	}

	function guardar(f)
	{	
		if(f.cod_producto.value==0){
			alert("Seleccione un Producto");
			f.cod_producto.focus();
		 	return(false);			
		}
		
		var i;
		var fichasTecnicas=new Array();
		var indice1=0;

		for(i=0;i<=f.length-1;i++)
		{	
			if(f.elements[i].name=='cod_ficha')
			{	if(f.elements[i].checked==true)			
				{	
					//alert("f.elements[i].value="+f.elements[i].value);
					fichasTecnicas[indice1]=f.elements[i].value;
					indice1++;
				}

			}
		}
	//	alert(indice1);				
		if(indice1==0)
		{	
			alert('Debe seleccionar Fichas Tecnicas.');
			return(false);
		}

		f.fichasTecnicas.value=fichasTecnicas;	
		//alert("f.fichasTecnicas.value"+f.fichasTecnicas.value);	
		
		alert("f.cod_producto.value="+f.cod_producto.value);
		f.submit();		
	}	
	
	function cancelar(f){
			window.location="listaCertificadosEmpresas.php?cod_empresa="+f.cod_empresa.value;
	}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="guarda_registrar_certificado.php">

<?php 
	require("conexion.inc");

	$cod_empresa=$_POST['cod_empresa'];		
	$sql=" select  rotulo_comercial from empresas  where cod_empresa='".$cod_empresa."'";
	$resp=mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$rotulo_comercial=$dat[0];
	}		
	$usuario_global=$_COOKIE['usuario_global'];
	$sql=" select nombre_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios  where cod_usuario='".$cod_empresa."'";
	$resp=mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$nombre_usuario_registro=$dat[0];
		$ap_paterno_usuario_registro=$dat[1];
		$ap_materno_usuario_registro=$dat[2];				
	}		
	
	$sql=" select  nombre_estado_certificado from estados_certificados  where cod_estado_certificado=1";
	$resp=mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$nombre_estado_certificado=$dat[0];
	}		
?>

<input type="hidden" name="cod_empresa" value="<?php echo $cod_empresa;?>">
<input type="hidden" name="fichasTecnicas">
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">Registro de Certificado de <?php echo $rotulo_comercial;?> </h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="80%" bgColor="#cccccc" border="0">
	<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" >I.-  DATOS GENERALES</td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td >1.0 Solicitante</td>
      		<td><?php echo $rotulo_comercial;?></td>
    	</tr>		
		 <tr bgcolor="#FFFFFF">
     		<td>1.1 Marca</td>
      		<td><div id="div_marca"></div></td>
    	</tr>
		
		 <tr bgcolor="#FFFFFF">
     		<td>1.2 Producto</td>
      		<td>	
				<select name="cod_producto" class="textoform" onChange="datosProducto(this.form)" >
					<option value="0">Seleccione un Producto</option>
				<?php
					$sql=" select cod_producto, nombre_producto from productos ";
					$sql.=" where cod_producto in(select cod_producto from presentaciones where cod_pres in(select sku from fichas_producto where cod_estado_ficha=3 and cod_contacto_registro in(select cod_contacto from contactos where cod_empresa='".$cod_empresa."')))";
					$sql.=" order by nombre_producto asc ";
					$resp=mysql_query($sql);
					while($dat=mysql_fetch_array($resp)){
						$cod_producto=$dat[0];
						$nombre_producto=$dat[1];						
				?>
						<option value="<?php echo $cod_producto;?>"><?php echo $nombre_producto;?></option>
				<?php
					}	
				?>		
				</select>
			
			</td>
    	</tr>	
			
		 <tr bgcolor="#FFFFFF">
     		<td>1.3 Compañía productora</td>
      		<td><div id="div_cia_productora"><input type="text" name="cia_productora" class="textoform" size="40"></div></td>
    	</tr>			
		 <tr bgcolor="#FFFFFF">
     		<td>1.4 Compañía importadora o Comercializadora:</td>
      		<td><div id="div_cia_productora_bolivia"><input type="text" name="cia_productora_bolivia" class="textoform" size="40"></div></td>
    	</tr>	
		 <tr bgcolor="#FFFFFF">
     		<td>1.5 Modelo de Certificación</td>
      		<td><input type="text" class="textoform" name="modelo_certificacion"></td>
    	</tr>			
		 <tr bgcolor="#FFFFFF">
     		<td>1.6 Numero de Fichas Tecnicas</td>
      		<td><div id="div_fichas"></div></td>
    	</tr>	
										
		<tr class="titulo_tabla">
		   <td  colSpan="2">II.- MARCO LEGAL</td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
		 	<td>Emitido en la Ciudad</td>
			<td>
			<select name="cod_ciudad" class="textoform">
				<?php
					$sql=" select cod_ciudad, nombre_ciudad from ciudades o ";
					$resp=mysql_query($sql);
					while($dat=mysql_fetch_array($resp)){
						$cod_ciudad=$dat[0];
						$nombre_ciudad=$dat[1];						
				?>
						<option value="<?php echo $cod_ciudad;?>"><?php echo $nombre_ciudad;?></option>
				<?php
					}	
				?>		
				</select>
	 	    </td>
		 </tr>
		 
		 <tr bgcolor="#FFFFFF">
		 	<td>Fecha de Emisión</td>
			<td>
			<INPUT type="text" id="fecha_emision" value="<?php echo date('d/m/Y');?>" size="10" name="fecha_emision" class="textoform" >
	 	    </td>
		 </tr>		 
		 
		 <tr bgcolor="#FFFFFF">
		 	<td>Firma</td>
			<td>
				<select name="cod_usuario_firma" class="textoform">
				<?php
					$sql=" select cod_usuario, nombre_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios ";
					$resp=mysql_query($sql);
					while($dat=mysql_fetch_array($resp)){
						$cod_usuario=$dat[0];
						$nombre_usuario=$dat[1];
						$ap_paterno_usuario=$dat[2];											
						$ap_materno_usuario=$dat[3];					
				?>
						<option value="<?php echo $cod_usuario;?>"><?php echo $ap_paterno_usuario." ".$ap_materno_usuario." ".$nombre_usuario;?></option>
				<?php
					}	
				?>		
				</select>
			</td>
		 </tr>
										
		<tr class="titulo_tabla">
		   <td  colSpan="2">DATOS DE SISTEMA</td>
		 </tr>	
		 <tr bgcolor="#FFFFFF">	
		 	<td>Fecha de Registro</td><td><?php echo date("d/m/Y H:i:s");?></td>			
		 </tr>									
		 <tr bgcolor="#FFFFFF">	
		 	<td>Registrado por:</td><td><?php echo $nombre_usuario_registro." ".$ap_paterno_usuario_registro." ".$ap_materno_usuario_registro;?></td>			
		 </tr>									
		 <tr bgcolor="#FFFFFF">	
		 	<td>Estado de Certificado:</td><td><?php echo $nombre_estado_certificado;?></td>			
		 </tr>			 
		</tbody>
	</table>	
	<br>
<div align="center">
<INPUT type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
<INPUT type="button"  class="boton"  name="btn_limpiar" value="Cancelar" onClick="cancelar(this.form);"  >
</div>
</form>

<?php require("cerrar_conexion.inc");?>
</body>
</html>
