<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Listado de Cargos</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>


function paginar(f)
{	
	location.href="navegador_cargos.php?pagina="+f.pagina.value;
		
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
			window.location="editar_cargos.php?cod_cargo="+cod_registro;
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
			window.location ="lista_eliminar_cargos.php?datos="+datos;			
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<form name="form1" method="post" action="registrar_cargos.php" >
<?php 
	require("conexion.inc");
	include("funciones.php");

?>
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">Listado de Cargos</h3>

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
	
	$sql_aux=" select count(*) from paises ";
	$resp_aux = mysql_query($sql_aux);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}
	if($nro_filas_sql==0){
?>
	<table width="60%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>Cargo</td>
			<td>Observaciones</td>							
			<td>Estado de Registro</td>										
		</tr>
		<tr><th colspan="3" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
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
		$sql=" select cod_cargo, nombre_cargo, obs_cargo, cod_estado_registro ";
		$sql.=" from cargos order by nombre_cargo asc  ";
		$sql.=" limit ".$fila_inicio." , ".$fila_final;
		$resp = mysql_query($sql);

?>	
	<table width="60%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>&nbsp;</td>
			<td>Cargo</td>
			<td>Observaciones</td>							
			<td>Estado de Registro</td>																				
		</tr>

<?php   
		while($dat=mysql_fetch_array($resp)){	
				$cod_cargo=$dat[0];
				$nombre_cargo=$dat[1];
				$obs_cargo=$dat[2];
				$cod_estado_registro=$dat[3];
				$sql2=" select nombre_estado_registro from estados_referenciales where cod_estado_registro='".$cod_estado_registro."'";
    			$resp2 = mysql_query($sql2);	
				$nombre_estado_registro="";
				$dat2=mysql_fetch_array($resp2);
				$nombre_estado_registro=$dat2[0];				
				
?> 
		<tr bgcolor="#FFFFFF">	
			<td><input type="checkbox"name="cod_cargo"value="<?php echo $cod_cargo;?>"></td>
			<td><?php echo $nombre_cargo;?></td>							
			<td><?php echo $obs_cargo;?></td>							
			<td><?php echo $nombre_estado_registro;?></td>																				
    	 </tr>
<?php
		  } 
?>			
  			<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="8">
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
</div>

</form>
</body>
</html>
