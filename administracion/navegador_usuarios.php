<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Listado de Usuarios</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>


function paginar(f)
{	
	location.href="navegador_usuarios.php?pagina="+f.pagina.value;
		
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
			window.location="editar_usuario.php?cod_usuario="+cod_registro;
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
			window.location ="lista_eliminar_usuarios.php?datos="+datos;			
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<form name="form1" method="post" action="registrar_usuario.php" >
<?php 
	require("conexion.inc");
	include("funciones.php");

?>
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">Listado de Usuarios Internos </h3>

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
	
	$sql_aux=" select count(*) from usuarios ";
	$resp_aux = mysql_query($sql_aux);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}
	if($nro_filas_sql==0){
?>
	<table width="85%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>Nombre</td>
			<td>Cargo</td>							
			<td>Grado</td>		
			<td>Usuario/Contraseña</td>																		
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
		$sql=" select cod_usuario, nombre_usuario, ap_paterno_usuario, ap_materno_usuario, usuario, password, cod_cargo, cod_grado,cod_estado_registro ";
		$sql.=" from usuarios ";
		$sql.=" order by ap_paterno_usuario asc, ap_materno_usuario asc, nombre_usuario asc ";
		$sql.=" limit ".$fila_inicio." , ".$fila_final;
		$resp = mysql_query($sql);

?>	
	<table width="85%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>&nbsp;</td>
			<td>Nombre</td>
			<td>Cargo</td>							
			<td>Grado</td>		
			<td>Usuario/Contraseña</td>																		
			<td>Estado de Registro</td>																					
		</tr>

<?php   
		while($dat=mysql_fetch_array($resp)){	
				$cod_usuario=$dat[0];
				$nombre_usuario=$dat[1];
				$ap_paterno_usuario=$dat[2];
				$ap_materno_usuario=$dat[3];
				$usuario=$dat[4];
				$password=$dat[5];
				$cod_cargo=$dat[6];
				/**************************************************************************/
					$sql2=" select nombre_cargo from cargos where cod_cargo='".$cod_cargo."'";
	    			$resp2 = mysql_query($sql2);	
					$nombre_cargo="";
					$dat2=mysql_fetch_array($resp2);
					$nombre_cargo=$dat2[0];					
				/**************************************************************************/				
				$cod_grado=$dat[7];
				/**************************************************************************/
					$sql2=" select nombre_grado from grados where cod_grado='".$cod_grado."'";
	    			$resp2 = mysql_query($sql2);	
					$nombre_grado="";
					$dat2=mysql_fetch_array($resp2);
					$nombre_grado=$dat2[0];					
				/**************************************************************************/						
				$cod_estado_registro=$dat[8];
				/**************************************************************************/
					$sql2=" select nombre_estado_registro from estados_referenciales where cod_estado_registro='".$cod_estado_registro."'";
	    			$resp2 = mysql_query($sql2);	
					$nombre_estado_registro="";
					$dat2=mysql_fetch_array($resp2);
					$nombre_estado_registro=$dat2[0];					
				/**************************************************************************/
							
?> 
		<tr bgcolor="#FFFFFF">	
			<td><input type="checkbox"name="cod_usuario"value="<?php echo $cod_usuario;?>"></td>
			<td><?php echo $ap_paterno_usuario." ".$ap_materno_usuario." ".$nombre_usuario;?></td>
			<td><?php echo $nombre_cargo;?></td>							
			<td><?php echo $nombre_grado; ?></td>		
			<td>Usuario:<?php echo $usuario;?><br>Contraseña:<?php echo $password;?></td>																		
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
