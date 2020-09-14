<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>Unidades de Medida</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>

function paginar(f)
{	
var param="?nombreUnidadMedidaB="+f.nombreUnidadMedidaB.value;
	param+="&pagina="+f.pagina.value;
		location.href='navegadorUnidadesMedida.php'+param;		
}
function paginar1(f,pagina)
{		

		f.pagina.value=pagina*1;
var param="?nombreUnidadMedidaB="+f.nombreUnidadMedidaB.value;
	param+="&pagina="+f.pagina.value;
			
		location.href='navegadorUnidadesMedida.php'+param;	
}

function buscar(f){

var param="?nombreUnidadMedidaB="+f.nombreUnidadMedidaB.value;
	//param+="&pagina="+f.pagina.value;

	location.href="navegadorUnidadesMedida.php"+param;

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
			window.location="editarUnidadMedida.php?cod_unidad_medida="+cod_registro;
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
			window.location ="listaEliminarUnidadesMedida.php?datos="+datos;			
	}
}
</script></head>
<body >
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">UNIDADES DE MEDIDA </h3>
<form name="form1" method="post" action="registrarUnidadMedida.php">
<?php 
	require("conexion.inc");
	include("funciones.php");
	$nombreUnidadMedidaB=$_GET['nombreUnidadMedidaB'];

?>

<table border="0" align="center">
<tr>
<td><strong>Unidad de Medida :</strong></td>
<td colspan="3"><input type="text" name="nombreUnidadMedidaB" id="nombreUnidadMedidaB" size="30" class="textoform" value="<?php echo $nombreUnidadMedidaB;?>" ></td>
<td rowspan="2"><a  onClick="buscar(form1)"><img src="images/buscar_header.jpg" border="0" alt="Buscar"></a></td>
</tr>
</table>



<?php	
	//Paginador
	$nro_filas_show=50;	
	$pagina = $_GET['pagina'];

	if ($pagina == ""){
		$pagina = 1;
		$fila_inicio=0;
		$fila_final=$nro_filas_show;
	}else{
		$fila_inicio=(($pagina*$nro_filas_show)-$nro_filas_show);
		$fila_final=($fila_inicio+$nro_filas_show);
	}	
	
	$sql_aux=" select count(*) from unidades_medidas ";
	if($nombreUnidadMedidaB<>""){
		$sql_aux.=" where nombre_unidad_medida like '%".$nombreUnidadMedidaB."%'";
	}
	$resp_aux = mysql_query($sql_aux);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}
	if($nro_filas_sql==0){
?>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>Unidad Medida</td>
    		<td>Abreviatura</td>	
    		<td>Estado</td>											
		</tr>
		<tr><th colspan="4" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
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
		$sql="select cod_unidad_medida, nombre_unidad_medida, abrev_unidad_medida, cod_estado_registro, ";
		$sql.=" cod_usuario_registro, fecha_registro, cod_usuario_modifica, fecha_modifica ";
		$sql.=" from unidades_medidas ";
		if($nombreUnidadMedidaB<>""){
			$sql.=" where nombre_unidad_medida like '%".$nombreUnidadMedidaB."%'";
		}		
		$sql.=" order by nombre_unidad_medida asc	";	
		$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		$resp = mysql_query($sql);

?>	
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>&nbsp;</td>
			<td>Unidad Medida</td>
    		<td>Abreviatura</td>	
    		<td>Estado</td>																
		</tr>

<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){	
		
				$cod_unidad_medida=$dat[0];
				$nombre_unidad_medida=$dat[1];
				$abrev_unidad_medida=$dat[2];
				$cod_estado_registro=$dat[3];
				$cod_usuario_registro=$dat[4];
				$fecha_registro=$dat[5];
				$cod_usuario_modifica=$dat[6];
				$fecha_modifica=$dat[7];			

				//**************************************************************
					$nombre_estado_registro="";				
					$sql2="select nombre_estado_registro from estados_referenciales";
					$sql2.=" where cod_estado_registro='".$cod_estado_registro."'";	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_estado_registro=$dat2[0];
					}	
				//**************************************************************	
		
							

				
?> 
		<tr bgcolor="#FFFFFF">	
			<td><input type="checkbox"name="cod_unidad_medida"value="<?php echo $cod_unidad_medida;?>"></td>	
							
    		<td><?php echo $nombre_unidad_medida;?></td>
    		<td><?php echo $abrev_unidad_medida;?></td>
    		<td><?php echo $nombre_estado_registro;?></td>
				
    	 </tr>
<?php
		 } 
?>			
  			<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="4">
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
						Ir a Pagina<input type="text" name="pagina"  id="pagina" size="5"><input  type="button" size="8"  value="Go" onClick="paginar(this.form)">												
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
