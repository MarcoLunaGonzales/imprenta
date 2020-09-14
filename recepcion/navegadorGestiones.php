<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Gestiones</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>


function paginar(f)
{	
	location.href="navegadorGestiones.php?pagina="+f.pagina.value;
		
}
function registrar(f){
	f.submit();
}
function activarGestion(f)
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
			window.location="activarGestion.php?cod_gestion="+cod_registro;
		}
	}
}


function eliminar(f)
{
	alert("En construccion");
	/*var i;
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
			window.location ="lista_eliminar_empresas.php?datos="+datos;			
	}*/
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->

<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">GESTIONES</h3>
<form name="form1" method="post" action="registrarGestion.php" >
<?php 
	require("conexion.inc");
	include("funciones.php");

?>


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
	
	$sql_aux=" select count(*) from gestiones ";
	$resp_aux = mysql_query($sql_aux);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}
	if($nro_filas_sql==0){
?>
	<table width="40%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>Gesti&oacute;n</td>
    		<td>Estado</td>
							
		</tr>
		<tr><th colspan="2" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
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
		$sql=" select cod_gestion, gestion, gestion_activa ";
		$sql.=" from gestiones ";
		$sql.=" order by gestion desc  ";
		$sql.=" limit ".$fila_inicio." , ".$fila_final;
		$resp = mysql_query($sql);

?>	
	<table width="40%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>&nbsp;</td>
    		<td>Gesti&oacute;n</td>
    		<td>Estado</td>																			
		</tr>

<?php   
		while($dat=mysql_fetch_array($resp)){	
		
				$cod_gestion=$dat[0];
				$gestion=$dat[1]; 
				$gestion_activa=$dat[2];
				if($gestion_activa==1){
					$desc_gestion_activa="Activa";
				}else{
					$desc_gestion_activa="No Activa";
				}
										
							

				
?> 
		<tr bgcolor="#FFFFFF">	
			<td><input type="checkbox"name="cod_gestion"value="<?php echo $cod_gestion;?>"></td>					
    		<td><?php echo $gestion;?></td>
    		<td><?php echo $desc_gestion_activa;?></td>
					
    	 </tr>
<?php
		 } 
?>			
  			<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="3">
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
	<INPUT type="button" class="boton" name="btn_eliminar"  value="Eliminar" onClick="eliminar(this.form);">
	<INPUT type="button" class="boton" name="btn_eliminar"  value="Activar Gesti&oacute;n" onClick="activarGestion(this.form);">	
</div>

</form>
</body>
</html>
