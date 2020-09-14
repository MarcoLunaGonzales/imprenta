<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Fichas Tecnicas por Producto</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>

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
	window.location ="listaProductosEmpresas.php?cod_marca_b="+f.cod_marca_b.value;
}
function paginar(f)
{	
	location.href="fichasTecnicasAprobadas.php?pagina="+f.pagina.value;
		
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
	$cod_empresa=$_GET['cod_empresa'];
	$cod_marca_b=$_GET['cod_marca_b'];
	if($cod_marca_b==""){
		$cod_marca_b=0;
	}
	$sql=" select  rotulo_comercial from empresas  where cod_empresa='".$cod_empresa."'";
	$resp=mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$rotulo_comercial=$dat[0];
	}	
?>
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">FICHAS TECNICAS DE <?PHP echo $rotulo_comercial; ?></h3>

<div align="center" ><a href="productos_empresas.php">Volver Atras</a></div>
<br>

<table border="0" align="center">
	<tr>
		<td><strong>Marca:</strong></td>
		<td>
			<select name="cod_marca_b" class="textoform">
				<option value="0" selected="selected">Todas</option>			
			<?php
				$sql="select cod_marca, nombre_marca from marcas order by nombre_marca asc ";
				$resp = mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){
					$cod_marca=$dat[0];
					$nombre_marca=$dat[1];
					if($cod_marca==$cod_marca_b){
			?>
						<option value="<?php echo $cod_marca;?>" selected="selected"><?php echo $nombre_marca; ?></option>
			<?php 	}else{?>
						<option value="<?php echo $cod_marca;?>"><?php echo $nombre_marca; ?></option>
			<?php 	}?>
			
			<?php
				}			
			?>			
			</select>
		</td>
		<td><input type="button" class="boton" name="buscar" value="Buscar" onClick="buscar(this.form)"></td>
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
	
		$sql_aux=" select count(*) from productos ";
		$sql_aux.=" where cod_producto in(select cod_producto from presentaciones where cod_pres in(select sku from fichas_producto where cod_estado_ficha=3 and cod_contacto_registro in(select cod_contacto from contactos where cod_empresa='".$cod_empresa."')))";
	if($cod_marca_b<>0){
		$sql_aux.=" and cod_marca='".$cod_marca_b."' ";
	}

	$resp_aux = mysql_query($sql_aux);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}
	if($nro_filas_sql==0){
?>
	<table width="95%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>Producto </td>
			<td>Marca</td>		
			<td>Compañia Productora</td>		
			<td>Compañia Productora o Comercializadora(Bolvia)</td>									
			<td>Fichas Tecnicas</td>		
		</tr>
		<tr><th colspan="5" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
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
		$sql=" select cod_producto, nombre_producto, cod_marca, cia_productora, cia_productora_bolivia ";
		$sql.=" from productos ";
		$sql.=" where cod_producto in(select cod_producto from presentaciones where cod_pres in(select sku from fichas_producto where cod_estado_ficha=3 and cod_contacto_registro in(select cod_contacto from contactos where cod_empresa=1)))";
		if($cod_marca_b<>0){
				$sql.=" and cod_marca='".$cod_marca_b."' ";
		}		
			$sql.=" order by nombre_producto  asc";
			$sql.="  limit ".$fila_inicio." , ".$fila_final;
			$resp = mysql_query($sql);

?>	
	<table width="90%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>&nbsp;</td>
			<td>Producto </td>
			<td>Marca</td>	
			<td>Compañia Productora</td>		
			<td>Compañia Productora o Comercializadora(Bolvia)</td>														
			<td>Fichas Tecnicas</td>																			
		</tr>

<?php   
		while($dat=mysql_fetch_array($resp)){	
		
			$cod_producto=$dat[0];
			$nombre_producto=$dat[1];
			$cod_marca=$dat[2];
			$sql2="select nombre_marca from marcas where cod_marca='".$cod_marca."'";
			$resp2 = mysql_query($sql2);
			$nombre_marca="";
			while($dat2=mysql_fetch_array($resp2)){
				$nombre_marca=$dat2[0];
			}
			$cia_productora=$dat[3];
			$cia_productora_bolivia=$dat[4];
				
?> 
		<tr bgcolor="#FFFFFF">	
			<td><input type="checkbox"name="cod_producto"value="<?php echo $cod_producto;?>"></td>
    		<td><?php echo $nombre_producto;?>&nbsp;</td>
			<td><?php echo $nombre_marca;?></td>			
			<td><?php echo $cia_productora;?></td>			
			<td><?php echo $cia_productora_bolivia;?></td>									
			<td><ul>
			<?php
				$sql2=" select cod_ficha, sku, presentacion ";
				$sql2.=" from fichas_producto ";
				$sql2.=" where cod_estado_ficha=3 ";
				$sql2.=" and sku in(select cod_pres from presentaciones where cod_producto='".$cod_producto."') ";
				$sql2.=" and cod_contacto_registro in (select cod_contacto from contactos where cod_empresa='".$cod_empresa."')";
				$resp2 = mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$cod_ficha=$dat2[0];
					$sku=$dat2[1];
					$presentacion=$dat2[2];
			?>
				<li><a href="../reportes/fichaProducto.php?cod_ficha=<?php echo $cod_ficha;?>"  target="_blank">Nro:<?php echo $cod_ficha." ".$presentacion." (".$sku.")"; ?></a></li>
			<?php
				}			
			?>
			</ul></td>	
   	  </tr>
<?php
		  } 
?>			
  			<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="7">
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


</form>
</body>
</html>
