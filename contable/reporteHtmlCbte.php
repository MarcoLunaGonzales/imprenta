<?php
	require("conexion.inc");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>INVENTA</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script language='Javascript'>
 
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>
<body >
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post"  name="form1">

<?php 

		$sql=" select cod_cbte, cod_empresa, cod_gestion, cod_tipo_cbte, nro_cbte, cod_moneda, cod_estado_cbte, ";
		$sql.=" fecha_cbte, nro_cheque, nro_factura, glosa, cod_usuario_registro, fecha_registro,";
		$sql.=" cod_usuario_modifica, fecha_modifica";
		$sql.=" from comprobante";
		$sql.=" where cod_cbte=".$_GET['cod_cbte'];
		$resp = mysql_query($sql);
		while($dat=mysql_fetch_array($resp)){	
				$cod_cbte=$dat['cod_cbte'];
				$cod_empresa=$dat['cod_empresa'];
				$cod_gestion=$dat['cod_gestion'];
				$cod_tipo_cbte=$dat['cod_tipo_cbte'];
				$nro_cbte=$dat['nro_cbte'];
				$cod_moneda=$dat['cod_moneda'];
				$cod_estado_cbte=$dat['cod_estado_cbte'];
				$fecha_cbte=$dat['fecha_cbte'];
				$nro_cheque=$dat['nro_cheque'];
				$nro_factura=$dat['nro_factura'];
				$glosa=$dat['glosa'];
				$cod_usuario_registro=$dat['cod_usuario_registro'];
				$fecha_registro=$dat['fecha_registro'];
				$cod_usuario_modifica=$dat['cod_usuario_modifica'];
				$fecha_modifica=$dat['fecha_modifica'];
				$gestion="";
				$nombre_tipo_cbte="";
				$nombre_estado_cbte="";
				$desc_moneda="";
				if($cod_gestion!= NULL){
					$sql2=" select  gestion from gestiones  where cod_gestion=".$cod_gestion." ";
					$resp2 = mysql_query($sql2);	
					while($dat2=mysql_fetch_array($resp2)){			
						$gestion=$dat2['gestion'];		
					}
				}				
				//Tipo de Comprobante
				//if($cod_tipo_cbte!= NULL or $cod_tipo_cbte!=""){	
				//echo "holaaaaa".$cod_tipo_cbte;			
					$sql2=" select nombre_tipo_cbte from tipo_comprobante where cod_tipo_cbte=".$cod_tipo_cbte;
					//echo $sql2;
					$resp2 = mysql_query($sql2);
					$nombre_tipo_cbte="";
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_tipo_cbte=$dat2['nombre_tipo_cbte'];
					}
				//}
				// Fin Tipo de Comprobante
				//Obteniendo la descripcion del Estado de Cbte
				if($cod_estado_cbte!= NULL){	
					$sql2="select nombre_estado_cbte from estado_comprobante where cod_estado_cbte=".$cod_estado_cbte;
					$resp2 = mysql_query($sql2);
					$nombre_estado_cbte="";
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_estado_cbte=$dat2['nombre_estado_cbte'];
					}
				}
				// Fin Obteniendo la descripcion del Estado de Cbte	
				//Obteniendo la descripcion del Estado de Cbte
				if($cod_moneda!= NULL){	
					$sql2="select desc_moneda from monedas where cod_moneda=".$cod_moneda;
					$resp2 = mysql_query($sql2);
					$desc_moneda="";
					while($dat2=mysql_fetch_array($resp2)){
						$desc_moneda=$dat2['desc_moneda'];
					}
				}
				// Fin Obteniendo la descripcion del Estado de Cbte					
							
				

				//Obteniendo Fecha de Registro
					$usuario_registro="";
				if($cod_usuario_registro!=NULL){
					$sql2=" select nombres_usuario, nombres_usuario2, nombres_pila, ap_paterno_usuario, ap_materno_usuario ";
					$sql2.=" from usuarios where cod_usuario=".$cod_usuario_registro;
					$resp2 = mysql_query($sql2);
				
					while($dat2=mysql_fetch_array($resp2)){
						$nombres_usuario=$dat2['nombres_usuario'];
						$nombres_usuario2=$dat2['nombres_usuario2'];
						$nombres_pila=$dat2['nombres_pila'];
						$ap_paterno_usuario=$dat2['ap_paterno_usuario'];
						$ap_materno_usuario=$dat2['ap_materno_usuario'];
						$usuario_registro=$nombres_usuario[0].$ap_paterno_usuario[0].$ap_materno_usuario[0];
					}
					
						$usuario_registro=strftime("%d/%m/%Y %H:%M:%S",strtotime($fecha_registro))." ".$usuario_registro;
				}
				// Fin Obteniendo Fecha de Registro	
				//Obteniendo Fecha de Registro
					$usuario_modifica="";
				if($cod_usuario_modifica!=NULL){
					$sql2=" select nombres_usuario, nombres_usuario2, nombres_pila, ap_paterno_usuario, ap_materno_usuario ";
					$sql2.=" from usuarios where cod_usuario=".$cod_usuario_modifica;
					$resp2 = mysql_query($sql2);
				
					while($dat2=mysql_fetch_array($resp2)){
						$nombres_usuario=$dat2['nombres_usuario'];
						$nombres_usuario2=$dat2['nombres_usuario2'];
						$nombres_pila=$dat2['nombres_pila'];
						$ap_paterno_usuario=$dat2['ap_paterno_usuario'];
						$ap_materno_usuario=$dat2['ap_materno_usuario'];
						$usuario_modifica=$nombres_usuario[0].$ap_paterno_usuario[0].$ap_materno_usuario[0];
					}
					
						$usuario_modifica=strftime("%d/%m/%Y %H:%M:%S",strtotime($fecha_modifica))." ".$usuario_modifica;
					}
			}

?>
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">COMPROBANTE</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="70%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="8" align="center">Datos Generales</td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<th align="left">Fecha:</th>
      		<td><?php echo strftime("%d/%m/%Y %H:%M:%S",strtotime($fecha_cbte));?></td>            
            <th align="left">Tipo Cbte.:</th>
      		<td><?php echo $nombre_tipo_cbte;?></td>             
            <th align="left">Nro. Cbte.:</th>
      		<td><?php echo $nro_cbte."/".$gestion;?></td>               
            <th align="left">Moneda:</th>  
      		<td>Bs.</td>                                   
         </tr>	
		
		 <tr bgcolor="#FFFFFF">
     		<th align="left">Glosa:</th>
      		<td  colspan="7" align="justify"><?php echo $glosa;?></td>
    	</tr>        
	        					
		</tbody>
	</table>
	<?php
		$sql2="";
	
	?>
		
	<center>
		<fieldset id="fiel" style="width:98%;border:0;" >
			<table align="center"class="text" cellSpacing="1" cellPadding="2" width="98%" border="0" id="data0">
				<tr>
					<td align="center" colspan="10">
						<input class="boton" type="button" value="Nuevo Item (+)" onclick="mas(this)" />
						<!--input class="boton" type="button" value="Memos Item (-)" onclick="menos(this)" /-->						
					</td>
				</tr>
			
				<tr class="titulo_tabla" align="center">
					<td width="4%">&nbsp;</td>
                    <td width="7%">Nro</td>
					<td width="20%">Cuenta</td>
					<td width="10%">Nro Factura</td>
                    <td width="10%">Fecha Factura</td>
					<td width="10%">Debe</td>
					<td width="10%">Haber</td>
					<td width="20%">Glosa</td>
                    <td width="3%">Dias Venc.</td>
                    <td width="4%">&nbsp;</td>

				</tr>
			</table>
		</fieldset>
           

		
		<table align="center"class="text" cellSpacing="1" cellPadding="2" width="98%" border="0" id="dataTotal">
				<tr class="titulo_tabla">
					<td  width="51%" colspan="5">&nbsp;<b>Total</b></td>
                    <td  width="10%" ><SPAN id="debeTotal">0</SPAN></td>
                    <td  width="10%"><SPAN id="haberTotal">0</SPAN></td>
					<td width="20%">&nbsp;</td>
					<td colspan="2" width="7%">&nbsp;</td>
					
				</tr>		
		</table>
	</center>	    
	<br>
<div align="center">
<INPUT type="button" class="boton" name="btn_guardar" value="Guardar Registro" onClick="guardar(this.form);">
<INPUT type="button" class="boton" name="atras" value="Cancelar Registro" onClick="javascript:history.back(1)">
</div>
</form>

</body>
</html>
