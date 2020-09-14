<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Certificados de Productos por Empresa</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>

function imprimirCertificado(f)
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
	{	alert('Debe seleccionar solamente un registro.');
	}
	else
	{
		if(j==0)
		{
			alert('Debe seleccionar un registro.');
		}
		else
		{
			izquierda = (screen.width) ? (screen.width-600)/2 : 100 
    		arriba = (screen.height) ? (screen.height-400)/2 : 100 
			url='../reportes/certificadoProducto.php?cod_cert_prod='+cod_registro;
			opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,width=700,height=580,left='+izquierda+ ',top=' + arriba + '' 
		   	window.open(url, 'popUp', opciones)					
		}
	}
}

function paginar(f)
{	
	location.href="listaCertificadosEmpresas.php?pagina="+f.pagina.value;
		
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
			window.location="editar_certificado.php?cod_cert_prod="+cod_registro;
		}
	}
}

function cerrarCertificado(f)
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
	{	alert('Debe seleccionar  un Certificado.');
	}
	else
	{
		if(j==0)
		{
			alert('Debe seleccionar un Cetificado.');
		}
		else
		{
			if(window.confirm("Esta seguro de Cerrar el Certificado?")){
				if(window.confirm("Desea continuar? Usted no podra realizar mas modificaciones sobre el mismo.")){
								window.location="cerrar_certificado.php?cod_cert_prod="+cod_registro+"&cod_empresa="+f.cod_empresa.value;
				}
			
			}

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
			window.location ="lista_eliminar_certificados.php?cod_empresa="+f.cod_empresa.value+"&datos="+datos;			
	}
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<form name="form1" method="post" action="registrar_certificado.php" >
<?php 
	require("conexion.inc");
	include("funciones.php");
	$cod_empresa=$_GET['cod_empresa'];
	$sql=" select  rotulo_comercial from empresas  where cod_empresa='".$cod_empresa."'";
	$resp=mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$rotulo_comercial=$dat[0];
	}	
?>
<input type="hidden" name="cod_empresa" value="<?php echo $cod_empresa;?>">
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">CERTIFICADOS DE PRODUCTOS DE <?PHP echo $rotulo_comercial; ?></h3>

<div align="center" ><a href="certificados_empresas">Volver Atras</a></div>
<br>
<?php	
	//Paginador
	$nro_filas_show=10;	
	$pagina = $_GET['pagina'];

	if ($pagina == ""){
		$pagina = 1;
		$fila_inicio=0;
		$fila_final=$nro_filas_show;
	}else{
		$fila_inicio=(($pagina*$nro_filas_show)-$nro_filas_show);
		$fila_final=($fila_inicio+$nro_filas_show);
	}	
	
		$sql_aux=" select count(*) ";
		$sql_aux.=" from certificados_producto ";
		$sql_aux.=" where cod_empresa='".$cod_empresa."'";


	$resp_aux = mysql_query($sql_aux);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}
	if($nro_filas_sql==0){
?>
	<table width="95%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>Nro de Cert.</td>							
			<td>Producto </td>
			<td>Marca</td>	
			<td>Fichas Tecnicas</td>				
			<td>Ciudad de Emisión</td>					
			<td>Fecha Emisión</td>		
			<td>Fecha de Registro</td>					
			<td>Fecha de Ultima Edición</td>	
			<td>Fecha de Cierre</td>								
			<td>Estado</td>											

		</tr>
		<tr><th colspan="11" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
	</table>
	
<?php	
	}else{
		//Calculo de Nro de Paginas
			$nropaginas=1;
			if($nro_filas_sql<$nro_filas_show){
				$nropaginas=1;
			}else{
				$nropag_aux=round($nro_filas_sql/$nro_filas_show);

				if($nro_filas_sql>($nropag_aux*$nro_filas_show)){
					$nropaginas=$nropag_aux+1;
				}else{
					$nropaginas=$nropag_aux;
				}
			}					
		//Fin de calculo de paginas
		$sql=" select cod_cert_prod, cod_producto, modelo_certificacion, cia_productora, cia_productora_bolivia, fecha_emision, ";
		$sql.=" cod_usuario_firma, cod_usuario_registro, fecha_usuario_registro, cod_usuario_modifica, fecha_usuario_modifica, ";
		$sql.=" cod_estado_certificado, cod_ciudad, cod_usuario_cierra, fecha_cierra";
		$sql.=" from certificados_producto ";
		$sql.=" where cod_empresa='".$cod_empresa."'";
		$sql.=" order by fecha_emision desc ";
		$sql.="  limit ".$fila_inicio." , ".$fila_final;
		$resp = mysql_query($sql);

?>	
	<table width="90%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>&nbsp;</td>
			<td>Nro de Cert.</td>							
			<td>Producto </td>
			<td>Marca</td>	
			<td>Fichas Tecnicas</td>				
			<td>Ciudad de Emisión</td>												
			<td>Fecha Emisión</td>		
			<td>Fecha de Registro</td>					
			<td>Fecha de Ultima Edición</td>	
			<td>Fecha de Cierre</td>																		
			<td>Estado</td>																					
		</tr>

<?php   
		while($dat=mysql_fetch_array($resp)){	
		
			$cod_cert_prod=$dat[0]; 
			$cod_producto=$dat[1];
			$sql2="select nombre_producto, cod_marca from productos where cod_producto='".$cod_producto."'";
			$resp2 = mysql_query($sql2);
			$nombre_marca="";
			$dat2=mysql_fetch_array($resp2);
				$nombre_producto=$dat2[0];
				$cod_marca=$dat2[1];
			/*------------------------------*/
				$sql5=" select nombre_marca from marcas where cod_marca='".$cod_marca."'";
				$resp5= mysql_query($sql5);
				$dat5=mysql_fetch_array($resp5);				
				$nombre_marca=$dat5[0];					
			/*------------------------------*/										
			
			$modelo_certificacion=$dat[2]; 
			$cia_productora=$dat[3];
			$cia_productora_bolivia=$dat[4]; 			
			$fecha_emision=$dat[5];
			if($fecha_emision<>""){
				$vector2=explode("-",$fecha_emision);				
				$fecha_emision=$vector2[2]."/".$vector2[1]."/".$vector2[0];
			}
						
			$cod_usuario_firma=$dat[6];
			/******************************/
				$nombre_usuario_firma="";
				$ap_paterno_usuario_firma="";
				$ap_materno_usuario_firma="";
			 	$cod_grado=0;
				$cod_cargo=0; 
				$sql4=" select nombre_usuario, ap_paterno_usuario, ap_materno_usuario, cod_grado, cod_cargo from usuarios where cod_usuario='".$cod_usuario_firma."'";
				$resp4= mysql_query($sql4);
				$dat4=mysql_fetch_array($resp4);				
					$nombre_usuario_firma=$dat4[0];
					$ap_paterno_usuario_firma=$dat4[1];
					$ap_materno_usuario_firma=$dat4[2];	
				 	$cod_grado=$dat4[3];
					/*------------------------------*/
						$sql5=" select abrev_grado from grados where cod_grado='".$cod_grado."'";
						$resp5= mysql_query($sql5);
						$dat5=mysql_fetch_array($resp5);				
						$abrev_grado=$dat5[0];					
					/*------------------------------*/
					$cod_cargo=$dat4[4];
					/*------------------------------*/
						$sql5=" select nombre_cargo from cargos where cod_cargo='".$cod_cargo."'";
						$resp5= mysql_query($sql5);
						$dat5=mysql_fetch_array($resp5);				
						$nombre_cargo=$dat5[0];					
					/*------------------------------*/					
											
			/*********************************/
			
			$cod_usuario_registro=$dat[7];
			/******************************/
			$nombre_usuario_registro="";
			$ap_paterno_usuario_registro="";
			$ap_materno_usuario_registro="";
			$sql4=" select nombre_usuario, ap_paterno_usuario, ap_materno_usuario, cod_grado, cod_cargo from usuarios where cod_usuario='".$cod_usuario_registro."'";
			$resp4= mysql_query($sql4);
			$dat4=mysql_fetch_array($resp4);				
					$nombre_usuario_registro=$dat4[0];
					$ap_paterno_usuario_registro=$dat4[1];
					$ap_materno_usuario_registro=$dat4[2];							
			/*********************************/
						
			$fecha_usuario_registro=$dat[8];
			if($fecha_usuario_registro<>""){
				$vector=explode(" ",$fecha_usuario_registro);
				$vector2=explode("-",$vector[0]);				
				$fecha_usuario_registro=$vector2[2]."/".$vector2[1]."/".$vector2[0]." ".$vector[1];
			}
						
			$cod_usuario_modifica=$dat[9];
			/******************************/
			$nombre_usuario_modifica="";
			$ap_paterno_usuario_modifica="";
			$ap_materno_usuario_modifica="";
			$sql4=" select nombre_usuario, ap_paterno_usuario, ap_materno_usuario, cod_grado, cod_cargo";
			$sql4.=" from usuarios where cod_usuario='".$cod_usuario_modifica."'";
			$resp4= mysql_query($sql4);
			$dat4=mysql_fetch_array($resp4);				
					$nombre_usuario_modifica=$dat4[0];
					$ap_paterno_usuario_modifica=$dat4[1];
					$ap_materno_usuario_modifica=$dat4[2];							
			/*********************************/
						
			$fecha_usuario_modifica=$dat[10];
			if($fecha_usuario_modifica<>""){
				$vector=explode(" ",$fecha_usuario_modifica);
				$vector2=explode("-",$vector[0]);				
				$fecha_usuario_modifica=$vector2[2]."/".$vector2[1]."/".$vector2[0]." ".$vector[1];
			}
						
			$cod_estado_certificado=$dat[11];
			$sql4=" select nombre_estado_certificado  from estados_certificados where cod_estado_certificado='".$cod_estado_certificado."'";
			$resp4= mysql_query($sql4);
			$dat4=mysql_fetch_array($resp4);				
			$nombre_estado_certificado=$dat4[0];
			
			$cod_ciudad=$dat[12];
			$sql4=" select nombre_ciudad  from ciudades where cod_ciudad='".$cod_ciudad."'";
			$resp4= mysql_query($sql4);
			$dat4=mysql_fetch_array($resp4);				
			$nombre_ciudad=$dat4[0];
			
			$cod_usuario_cierre=$dat[13];
			/******************************/
			$nombre_usuario_cierre="";
			$ap_paterno_usuario_cierre="";
			$ap_materno_usuario_cierre="";
			$sql4=" select nombre_usuario, ap_paterno_usuario, ap_materno_usuario, cod_grado, cod_cargo ";
			$sql4.=" from usuarios where cod_usuario='".$cod_usuario_cierre."'";
			$resp4= mysql_query($sql4);
			$dat4=mysql_fetch_array($resp4);				
			$nombre_usuario_cierra=$dat4[0];
			$ap_paterno_usuario_cierra=$dat4[1];
			$ap_materno_usuario_cierra=$dat4[2];							
			/*********************************/			
			$fecha_cierra=$dat[14];
			if($fecha_cierra<>""){
				$vector=explode(" ",$fecha_cierra);
				$vector2=explode("-",$vector[0]);				
				$fecha_cierra=$vector2[2]."/".$vector2[1]."/".$vector2[0]." ".$vector[1];
			}			
			
		
						
			
				
?> 
		<tr bgcolor="#FFFFFF">	
			<td><input type="checkbox"name="cod_cert_prod"value="<?php echo $cod_cert_prod;?>"></td>
			<td><?php echo $cod_cert_prod;?></td>							
			<td><?php echo $nombre_producto; ?></td>
			<td><?php echo $nombre_marca;?></td>				
			<td>
			<ul>
<?php
			/****************Fichas Tecnicas***********************/
				$sql4=" select cod_ficha, sku, presentacion ";
				$sql4.=" from fichas_producto ";
				$sql4.=" where cod_ficha in(select cod_ficha from certificados_producto where cod_cert_prod='".$cod_cert_prod."')";
				$resp4= mysql_query($sql4);
				while($dat4=mysql_fetch_array($resp4)){				
					$cod_ficha=$dat4[0];
					$sku=$dat4[1];
					$presentacion=$dat4[2];
?>
<li><a href="../reportes/fichaProducto.php?cod_ficha=<?php echo $cod_ficha;?>"  target="_blank">Nro:<?php echo $cod_ficha." ".$presentacion." (".$sku.")"; ?></a></li>
<?php					
				}			
?>
			</ul>
			</td>				
			<td><?php echo $nombre_ciudad;?></td>					
			<td>
				<?php echo $fecha_emision;?><br>
				<?php echo $abrev_grado." ".$nombre_usuario_firma." ".$ap_paterno_usuario_firma." ".$ap_materno_usuario_firma;?><br>
				<?php echo $nombre_cargo;?>
			</td>		
			<td>
				<?php echo $fecha_usuario_registro;?><br>
				<?php echo $nombre_usuario_registro." ".$ap_paterno_usuario_registro." ".$ap_materno_usuario_registro;?><br>
			</td>					
			<td>
				<?php echo $fecha_usuario_modifica;?><br>
				<?php echo $nombre_usuario_modifica." ".$ap_paterno_usuario_modifica." ".$ap_materno_usuario_modifica;?><br>
			</td>				
			<td>
				<?php echo $fecha_cierra;?><br>
				<?php echo $nombre_usuario_cierra." ".$ap_paterno_usuario_cierra." ".$ap_materno_usuario_cierra;?><br>
			</td>							
			<td><?php echo $nombre_estado_certificado; ?></td>									

    	 </tr>
<?php
		  } 
?>			
  			<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="11">
					Pagina <?php echo $pagina; ?> de <?php echo $nropaginas; ?>&nbsp;&nbsp;&nbsp;	
					<select onchange="paginar(this.form);" name="pagina" >
				    <?php for($i=1;$i<=$nropaginas;$i++){	
							if($pagina==$i){
					?>
							<option value="<?php echo $i; ?>"  selected><?php echo $i; ?></option>";
				    	<?php }else{?>	
							<option value="<?php echo $i; ?>"  ><?php echo $i; ?></option>";
						<?php }?>						
					<?php }?>
					</select>													
				</td>
			</tr>
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
	<INPUT type="button" class="boton" name="btn_eliminar"  value="Editar" onClick="editar(this.form);">	
	<INPUT type="button" class="boton" name="btn_eliminar"  value="Eliminar" onClick="eliminar(this.form);">
	<INPUT type="button" class="boton" name="btn_imprimir"  value="Imprimir" onClick="imprimirCertificado(this.form);">
	<INPUT type="button" class="boton" name="btn_aprobar"  value="Cerrar Certificado" onClick="cerrarCertificado(this.form);">
</div>

</form>
</body>
</html>
