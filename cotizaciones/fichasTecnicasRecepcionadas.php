<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Fichas Tecnicas Recepcionadas</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
function aprobar(f)
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
			alert('Debe seleccionar un registro para mofificar.');
		}
		else
		{
			izquierda = (screen.width) ? (screen.width-600)/2 : 100 
    		arriba = (screen.height) ? (screen.height-400)/2 : 100 
			url='aprobarFichaProducto.php?cod_ficha='+cod_registro;
			opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=550,height=280,left='+izquierda+ ',top=' + arriba + '' 
		   	window.open(url, 'popUp', opciones)					
		}
	}
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
			window.location="editarFichaProductoAdm.php?cod_ficha="+cod_registro;
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
		 if(confirm('¿Esta seguro de continuar con la Eliminacion?')){	
			window.location ="listaEliminarFichaProductoAdm.php?datos="+datos;			
		 }	
	}
}

function imprimir(f)
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
			url='../reportes/fichaProducto.php?cod_ficha='+cod_registro;
			opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,width=700,height=580,left='+izquierda+ ',top=' + arriba + '' 
		   	window.open(url, 'popUp', opciones)					
		}
	}
}

function buscar(f){
	window.location ="fichasTecnicasRecepcionadas.php?cod_ficha_b="+f.cod_ficha_b.value+"&cod_empresa_b="+f.cod_empresa_b.value;
}
function paginar(f)
{	
	location.href="fichasTecnicasRecepcionadas.php?pagina="+f.pagina.value;
		
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<form name="form1" method="post" >
<?php 
	require("conexion.inc");
	include("funciones.php");
	
	$cod_ficha_b=$_GET['cod_ficha_b'];
	$cod_empresa_b=$_GET['cod_empresa_b'];
	if($cod_empresa_b==""){
		$cod_empresa_b=0;
	}
?>
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">FICHAS TECNICAS RECEPCIONADAS</h3>
<table border="0" align="center">
<tr>
	<td><strong>Nro Ficha:</strong></td>
	<td><input type="text" name="cod_ficha_b" value="<?php echo $cod_ficha_b;?>" size="10" class="textoform"></td>
	<td><strong>Solicitante:</strong></td>
	<td>
		<select name="cod_empresa_b" class="textoform">
		 		<option value="0" selected="selected">Todos</option>	
		<?php 
			$sql="select cod_empresa, rotulo_comercial from empresas order by rotulo_comercial asc";
			$resp= mysql_query($sql);
			while($dat=mysql_fetch_array($resp)){
				$cod_empresa=$dat[0];
				$rotulo_comercial=$dat[1];
				if($cod_empresa_b==$cod_empresa){
		?>
		 		<option value="<?php echo $cod_empresa;?>" selected="selected"><?php echo $rotulo_comercial;?></option>	
		<?php }else{?>
				<option value="<?php echo $cod_empresa;?>"><?php echo $rotulo_comercial;?></option>	
		<?php }?>
		<?php				
			}
		?>
		</select>
	</td>
	<td><input type="button" class="boton" name="Buscar" value="Buscar" onClick="buscar(this.form)"></td>
</tr>
</table>
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
	
	$sql_aux=" select count(*) from fichas_producto ";
	$sql_aux.=" where cod_estado_ficha=2 ";
	if($cod_ficha_b<>""){
		$sql_aux.=" and cod_ficha like '%".$cod_ficha_b."%' ";	
	}
	if($cod_empresa_b<>0){
		$sql_aux.=" and cod_contacto_registro in (select cod_contacto from contactos where cod_empresa='".$cod_empresa_b."')";	
	}

	$resp_aux = mysql_query($sql_aux);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}
	if($nro_filas_sql==0){
?>
	<table width="95%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>Nro de ficha</td>
			<td>Solicitante</td>			
			<td>Fecha Registro</td>		
			<td>Fecha de Envio</td>		
			<td>Fecha de Ultima Edición (Interna)</td>																								
			<td>Marca</td>
			<td>Producto</td>
			<td>Presentaci&oacute;n</td>
			<td>SKU Origen</td>			
		</tr>
		<tr><th colspan="9" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
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
		$sql=" select cod_ficha, fecha_contacto_registro, cod_estado_ficha, cod_tipo_cigarrillo, ";
		$sql.=" cod_emp_prim_cant, cod_emp_secc_cant, cod_embalaje_cant, cod_marca, sku, sku_local, ";
		$sql.=" marca, producto, presentacion, cod_pais, cia_productora, cia_productora_en_bolivia,";
		$sql.=" filtro_si_no, presen_hard_soft_pack, impresion_cajetilla, nicotina_humo, alquitran_humo,";
		$sql.=" carbono_humo, fecha_contacto_envio,cod_contacto_envio, fecha_usuario_modifica, cod_usuario_modifica,";
		$sql.=" fecha_aprobacion, cod_usuario_aprobacion, obs_aprobacion, cod_contacto_registro, cod_contacto_modifica, fecha_contacto_modifica ";
		$sql.=" from fichas_producto ";
		$sql.=" where  cod_estado_ficha=2";
		if($cod_ficha_b<>""){
			$sql.=" and cod_ficha like '%".$cod_ficha_b."%' ";	
		}	
		if($cod_empresa_b<>0){
			$sql.=" and cod_contacto_registro in (select cod_contacto from contactos where cod_empresa='".$cod_empresa_b."')";	
		}
		
		$sql.=" order by fecha_contacto_envio asc ";
		$sql.="  limit ".$fila_inicio." , ".$fila_final;
		$resp = mysql_query($sql);
?>	
	<table width="90%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>&nbsp;</td>
			<td>Nro de ficha</td>
			<td>Solicitante</td>			
			<td>Fecha Registro</td>		
			<td>Fecha de Envio</td>		
			<td>Fecha de Ultima Edición (Interna)</td>													
			<td>Marca</td>
			<td>Producto</td>
			<td>Presentaci&oacute;n</td>
			<td>SKU Origen</td>		
		</tr>

<?php   
		$sw=1;
		while($dat=mysql_fetch_array($resp)){	
			
			$cod_ficha=$dat[0]; 
			$fecha_contacto_registro=$dat[1]; 
			if($fecha_contacto_registro<>""){
				$vector=explode(" ",$fecha_contacto_registro);
				$vector2=explode("-",$vector[0]);				
				$fecha_contacto_registro=$vector2[2]."/".$vector2[1]."/".$vector2[0]." ".$vector[1];
			}
			$cod_estado_ficha=$dat[2]; 
			$cod_tipo_cigarrillo=$dat[3]; 
			$cod_emp_prim_cant=$dat[4]; 
			$cod_emp_secc_cant=$dat[5]; 
			$cod_embalaje_cant=$dat[6]; 
			$cod_marca=$dat[7]; 
			$sku=$dat[8]; 
			$sku_local=$dat[9]; 
			$marca=$dat[10];  
			$producto=$dat[11]; 
			$presentacion=$dat[12]; 
			$cod_pais=$dat[13]; 
			$cia_productora=$dat[14]; 
			$cia_productora_en_bolivia=$dat[15]; 
			$filtro_si_no=$dat[16]; 
			$presen_hard_soft_pack=$dat[17]; 
			$impresion_cajetilla=$dat[18]; 
			$nicotina_humo=$dat[19]; 
			$alquitran_humo=$dat[20]; 
			$carbono_humo=$dat[21]; 
			$fecha_contacto_envio=$dat[22]; 
			if($fecha_contacto_envio<>""){
				$vector=explode(" ",$fecha_contacto_envio);
				$vector2=explode("-",$vector[0]);				
				$fecha_contacto_envio=$vector2[2]."/".$vector2[1]."/".$vector2[0]." ".$vector[1];
			}				
			$cod_contacto_envio=$dat[23];
			$nombre_contacto_envio="";
			$ap_paterno_contacto_envio="";
			$ap_materno_contacto_envio="";	
								
				$sql4=" select nombre_contacto, ap_paterno_contacto, ap_materno_contacto from contactos where cod_contacto='".$cod_contacto_envio."'";
				$resp4= mysql_query($sql4);
				while($dat4=mysql_fetch_array($resp4)){					
					$nombre_contacto_envio=$dat4[0];
					$ap_paterno_contacto_envio=$dat4[1];
					$ap_materno_contacto_envio=$dat4[2];					
				}
							 
			$fecha_usuario_modifica=$dat[24]; 
			if($fecha_usuario_modifica<>""){
				$vector=explode(" ",$fecha_usuario_modifica);
				$vector2=explode("-",$vector[0]);				
				$fecha_usuario_modifica=$vector2[2]."/".$vector2[1]."/".$vector2[0]." ".$vector[1];
			}									
			$cod_usuario_modifica=$dat[25]; 
				$nombre_usuario_modifica="";
				$ap_paterno_usuario_modifica="";
				$ap_materno_usuario_modifica="";
				$sql4=" select nombre_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios where cod_usuario='".$cod_usuario_modifica."'";
				$resp4= mysql_query($sql4);
				$dat4=mysql_fetch_array($resp4);				
					$nombre_usuario_modifica=$dat4[0];
					$ap_paterno_usuario_modifica=$dat4[1];
					$ap_materno_usuario_modifica=$dat4[2];
								
			
			$fecha_aprobacion=$dat[26]; 
			if($fecha_aprobacion<>""){
				$vector=explode(" ",$fecha_aprobacion);
				$vector2=explode("-",$vector[0]);				
				$fecha_aprobacion=$vector2[2]."/".$vector2[1]."/".$vector2[0]." ".$vector[1];
			}				
			$cod_usuario_aprobacion=$dat[27]; 
				$nombre_usuario_aprobacion="";
				$ap_paterno_usuario_aprobacion="";
				$ap_materno_usuario_aprobacion="";
				$sql4=" select nombre_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios where cod_usuario='".$cod_usuario_aprobacion."'";
				$resp4= mysql_query($sql4);
				$dat4=mysql_fetch_array($resp4);				
					$nombre_usuario_aprobacion=$dat4[0];
					$ap_paterno_usuario_aprobacion=$dat4[1];
					$ap_materno_usuario_aprobacion=$dat4[2];	
		
			
			$obs_aprobacion=$dat[28]; 
			$cod_contacto_registro=$dat[29]; 
			$nombre_contacto_registro="";
			$ap_paterno_contacto_registro="";
			$ap_materno_contacto_registro="";
			$cod_empresa=0;
				$sql4=" select nombre_contacto, ap_paterno_contacto, ap_materno_contacto,cod_empresa from contactos where cod_contacto='".$cod_contacto_registro."'";
				$resp4= mysql_query($sql4);
				$dat4=mysql_fetch_array($resp4);					
					$nombre_contacto_registro=$dat4[0];
					$ap_paterno_contacto_registro=$dat4[1];
					$ap_materno_contacto_registro=$dat4[2];	
					$cod_empresa=$dat4[3];	
					$sql5=" select  rotulo_comercial from empresas  where cod_empresa='".$cod_empresa."'";
					$resp5= mysql_query($sql5);
					while($dat5=mysql_fetch_array($resp5)){
						$rotulo_comercial=$dat5[0];
					}			

			
			$cod_contacto_modifica=$dat[30]; 
			$nombre_contacto_modifica="";
			$ap_paterno_contacto_modifica="";
			$ap_materno_contacto_modifica="";
			$sql4=" select nombre_contacto, ap_paterno_contacto, ap_materno_contacto from contactos where cod_contacto='".$cod_contacto_modifica."'";
			$resp4= mysql_query($sql4);
			while($dat4=mysql_fetch_array($resp4)){					
				$nombre_contacto_modifica=$dat4[0];
				$ap_paterno_contacto_modifica=$dat4[1];
				$ap_materno_contacto_modifica=$dat4[2];					
			}
			$fecha_contacto_modifica=$dat[31]; 
			if($fecha_contacto_modifica<>""){
				$vector=explode(" ",$fecha_contacto_modifica);
				$vector2=explode("-",$vector[0]);				
				$fecha_contacto_modifica=$vector2[2]."/".$vector2[1]."/".$vector2[0]." ".$vector[1];
			}					
?> 
		<tr bgcolor="#FFFFFF">	
			<td><input type="checkbox"name="codigo"value="<?php echo $cod_ficha;?>"></td>
    		<td><?php echo $cod_ficha;?>&nbsp;</td>
			<td><?php echo $rotulo_comercial;?></td>			
			<td>
				<?php echo $fecha_contacto_registro; ?><br>
				<?php echo $nombre_contacto_registro." ".$ap_paterno_contacto_registro." ".$ap_materno_contacto_registro; ?>				
			</td>
			<td>
				<?php echo $fecha_contacto_envio; ?><br>
				<?php echo $nombre_contacto_envio." ".$ap_paterno_contacto_envio." ".$ap_materno_contacto_envio; ?>	
			</td>	
			<td>
				<?php echo $fecha_usuario_modifica; ?><br>
				<?php echo $nombre_usuario_modifica." ".$ap_paterno_usuario_modifica." ".$ap_materno_usuario_modifica; ?>	
			</td>
								
    		<td><?php echo $marca;?>&nbsp;</td>
    		<td><?php echo $producto;?>&nbsp;</td>
			<td><?php echo $presentacion;?></td>
    		<td><?php echo $sku;?></td>
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
<br>
<div align="center">
	<INPUT type="button" class="boton" name="btn_editar"  value="Editar" onClick="editar(this.form);">
	<INPUT type="button" class="boton" name="btn_eliminar"  value="Eliminar" onClick="eliminar(this.form);">
	<INPUT type="button" class="boton" name="btn_imprimir"  value="Imprimir Ficha" onClick="imprimir(this.form);">
	<INPUT type="button" class="boton" name="btn_aprobar"  value="Aprobar Ficha" onClick="aprobar(this.form);">
</div>
		
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
