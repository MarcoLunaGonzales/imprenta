<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Fichas Tecnicas Aprobadas</title>
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
	window.location ="fichasTecnicasAprobadas.php?cod_empresa_b="+f.cod_empresa_b.value;
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

?>
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">FICHAS TECNICAS POR EMPRESA</h3>

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
	
	$sql_aux=" select count(*) from empresas ";


	$resp_aux = mysql_query($sql_aux);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}
	if($nro_filas_sql==0){
?>
	<table width="95%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>Rotulo Comercial</td>
			<td>Razon Social</td>			
			<td>Nit</td>		
			<td>Direccion</td>		
			<td>Email</td>	
			<td>Pagina Web</td>	
			<td>Fichas Tecnicas </td>																		
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
		$sql=" select cod_empresa, cod_estado_empresa,cod_ciudad, razon_social, rotulo_comercial,";
		$sql.=" nit, direccion, telf, fax, celular, email1, email2, pagina_web, obs_empresa";
		$sql.=" from empresas";
		$sql.=" order by rotulo_comercial  asc";
		$sql.="  limit ".$fila_inicio." , ".$fila_final;
		$resp = mysql_query($sql);

?>	
	<table width="90%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>&nbsp;</td>
			<td>Rotulo Comercial</td>
			<td>Razon Social</td>			
			<td>Nit</td>		
			<td>Direccion</td>		
			<td>Email</td>	
			<td>Pagina Web</td>	
			<td>Fichas Tecnicas </td>																		
		</tr>

<?php   
		while($dat=mysql_fetch_array($resp)){	
		
			$cod_empresa=$dat[0];
			$cod_estado_empresa=$dat[1];
			$cod_ciudad=$dat[2];
			$razon_social=$dat[3];
			$rotulo_comercial=$dat[4];
			$nit=$dat[5];
			$direccion=$dat[6];
			$telf=$dat[7];
			$fax=$dat[8];
			$celular=$dat[9];
			$email1=$dat[10];
			$email2=$dat[11];
			$pagina_web=$dat[12];
			$obs_empresa=$dat[13];
				
?> 
		<tr bgcolor="#FFFFFF">	
			<td><input type="checkbox"name="cod_empresa"value="<?php echo $cod_empresa;?>"></td>
    		<td><?php echo $rotulo_comercial;?>&nbsp;</td>
			<td><?php echo $razon_social;?></td>			
			<td><?php echo $nit; ?></td>
			<td>Dirección:<?php echo $direccion;?><br>Telf:<?php echo $telf;?><br>Fax:<?php echo $fax;?><br>Celular:<?php echo $celular;?></td>
			<td>
				<?php echo $email1; ?><br>
				<?php echo $email2; ?>	
			</td>	
			<td><a href="http://<?php echo $pagina_web; ?>" target="_blank"><?php echo $pagina_web; ?></a></td>	
			<th><a href="listaProductosEmpresas.php?cod_empresa=<?php echo $cod_empresa;?>">Ver Fichas Tecnicas </a></th>	
   	  </tr>
<?php
		  } 
?>			
  			<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="13">
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
