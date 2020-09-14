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
var param="?nombreClienteB="+f.nombreclienteB.value;
	param+="&pagina="+f.pagina.value;
		location.href='navegadorClientes.php'+param;		
}
function paginar1(f,pagina)
{		

		f.pagina.value=pagina*1;
var param="?nombreClienteB="+f.nombreclienteB.value;
	param+="&pagina="+f.pagina.value;
			
		location.href='navegadorClientes.php'+param;	
}

function buscar(f){

var param="?nombreClienteB="+f.nombreclienteB.value;
	param+="&pagina="+f.pagina.value;

	location.href="navegadorClientes.php"+param;

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
			window.location="editarCliente.php?cod_cliente="+cod_registro;
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
			window.location ="listaEliminarClientes.php?datos="+datos;			
	}
}
</script>

</head>
<body bgcolor="#F7F5F3">
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<h3 align="center" style="background:#F7F5F3;font-size: 14px;color: #E78611;font-weight:bold;">CLIENTES</h3>
<form name="form1" method="post" action="registrarCliente.php">
<?php 
	require("conexion.inc");
	include("funciones.php");
	$nombreclienteB=$_GET['nombreclienteB'];

?>



<?php	

	$sql_aux=" select count(*) from clientes ";

	$resp_aux = mysql_query($sql_aux);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}
?>

<h3 align="center" style="background:#F7F5F3;font-size: 12px;color: #E78611;font-weight:bold;">Nro. de Registros:&nbsp
<?php echo $nro_filas_sql;?></h3>

<?php
	if($nro_filas_sql==0){
?>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>Cliente</td>
    		<td>Nit</td>
    		<td>Categoria</td>
    		<td>Ciudad</td>
    		<td>Direcci&oacute;n</td>
    		<td>Telefonos</td>
    		<td>Fax</td>			
    		<td>Email</td>					
    		<td>Observaciones</td>			
    		<td>Estado</td>											
		</tr>
		<tr><th colspan="11" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
	</table>
	
<?php	
	}else{
				
		//Fin de calculo de paginas
		$sql=" select cod_cliente, nombre_cliente, nit_cliente,cod_categoria, cod_ciudad, ";
		$sql.=" direccion_cliente, telefono_cliente, celular_cliente,fax_cliente, ";
		$sql.=" email_cliente, obs_cliente, cod_usuario_registro, ";
		$sql.=" fecha_registro, cod_usuario_modifica, fecha_modifica, cod_estado_registro ";
		$sql.=" from clientes ";
		$sql.=" order by nombre_cliente asc  ";

		$resp = mysql_query($sql);

?>	
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
        	<td>&nbsp;</td>
    		<td>Cliente</td>
    		<td>Nit</td>
    		<td>Ciudad</td>
    		<td>Direcci&oacute;n</td>
    		<td>Telefonos</td>		
						
																	
		</tr>

<?php   
	$cont=1;
		while($dat=mysql_fetch_array($resp)){	

				$cod_cliente=$dat[0];
				$nombre_cliente=$dat[1]; 
				$nit_cliente=$dat[2];
				$cod_categoria=$dat[3];
				//**************************************************************
					$desc_categoria="";				
					$sql2="select desc_categoria from clientes_categorias where cod_categoria='".$cod_categoria."'";	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$desc_categoria=$dat2[0];
					}	
				//**************************************************************					
				$cod_ciudad=$dat[4];
				//**************************************************************
				$desc_ciudad="";
				$sql2="select desc_ciudad from ciudades where cod_ciudad='".$cod_ciudad."'";
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$desc_ciudad=$dat2[0];
				}					
				//**************************************************************
				$direccion_cliente=$dat[5];
				$telefono_cliente=$dat[6];
				$celular_cliente=$dat[7];
				$fax_cliente=$dat[8];
				$email_cliente=$dat[9];
				$obs_cliente=$dat[10];
				$cod_usuario_registro=$dat[11]; 
				$fecha_registro=$dat[12];
				$cod_usuario_modifica=$dat[13];
				$fecha_modifica=$dat[14];
				$cod_estado_registro=$dat[15];
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
			<td align="right"><?php echo $cont++;?>&nbsp;&nbsp;</td>			
    		<td><?php echo $nombre_cliente;?></td>
    		<td><?php echo $nit_cliente;?></td>
    		<td><?php echo $desc_ciudad; ?></td>
    		<td><?php echo $direccion_cliente;?></td>
    		<td><?php echo $telefono_cliente; if($celular_cliente!=""){echo "- ".$celular_cliente;}?></td>
					
				
    	 </tr>
<?php
		 } 
?>			
  		
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
