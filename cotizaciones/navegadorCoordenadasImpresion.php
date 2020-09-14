<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>Clientes</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>



function paginar(f)
{	
		location.href="navegadorCoordenadasImpresion.php?pagina="+f.pagina.value;		
}
function paginar1(f,pagina)
{		
		f.pagina.value=pagina*1;
		location.href="navegadorCoordenadasImpresion.php?pagina="+f.pagina.value;		
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
			window.location="editarCoordenadaImpresion.php?cod_coordenada="+cod_registro;
		}
	}
}

</script>

</head>
<body>
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">VALORES DE IMPRESION </h3>
<form name="form1" method="post" action="registrarCliente.php" accept-charset="UTF-8" >
<?php 
	require("conexion.inc");
	include("funciones.php");

?>


<?php	
	//Paginador
	$nro_filas_show=15;	
	$pagina = $_GET['pagina'];

	if ($pagina == ""){
		$pagina = 1;
		$fila_inicio=0;
		$fila_final=$nro_filas_show;
	}else{
		$fila_inicio=(($pagina*$nro_filas_show)-$nro_filas_show);
		$fila_final=($fila_inicio+$nro_filas_show);
	}	
	
	$sql_aux=" select count(*) from coordenadas_impresion ";
	$resp_aux = mysql_query($sql_aux);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}
	if($nro_filas_sql==0){
?>
	<table width="50%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>Reporte</td>
    		<td>Valor X</td>
    		<td>Valor Y</td>											
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
		$sql=" select cod_coordenada, desc_coordenada, valor_x, valor_y  ";
		$sql.=" from coordenadas_impresion  ";
		$sql.=" order by desc_coordenada asc  ";
		$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		$resp = mysql_query($sql);

?>	
	<table width="50%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>&nbsp;</td>
    		<td>Reporte</td>
    		<td>Valor X</td>
    		<td>Valor Y</td>																		
		</tr>

<?php   
		while($dat=mysql_fetch_array($resp)){	
				$cod_coordenada=$dat[0];
				$desc_coordenada=$dat[1];
				$valor_x=$dat[2];
				$valor_y=$dat[3];
			
?> 
		<tr bgcolor="#FFFFFF">	
			<td><input type="checkbox"name="cod_coordenada"value="<?php echo $cod_coordenada;?>"></td>					
    		<td><?php echo $desc_coordenada;?></td>
    		<td><?php echo $valor_x;?></td>
    		<td><?php echo $valor_y; ?></td>
				
    	 </tr>
<?php
		 } 
?>			
  			<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="13">
						<p align="center">						
						<b><?php if($pagina>1){ ?>
							<a href="#" onclick="paginar1(form1,<?php echo $pagina-1; ?>)"><--Anterior</a>
							<?php }?>
						</b>
						<b> Pagina <?php echo $pagina; ?> de <?php echo $nropaginas; ?> </b>
						<b><?php if($nropaginas>$pagina){ ?> 
							<a href="#" onclick="paginar1(form1,<?php echo $pagina+1; ?>)">Siguiente--></a>
						<?php }?></b>
						</p>
						<p align="center">				
						Ir a Pagina<input type="text" name="pagina" size="5"><input  type="button" size="8"  value="Go" onClick="paginar(this.form)">												
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
	<INPUT type="button" class="boton" name="btn_editar"  value="Editar" onClick="editar(this.form);">

</div>

</form>
</body>
</html>
