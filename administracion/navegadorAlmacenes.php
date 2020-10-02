<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>Almacenes</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>

function paginar(f)
{	
var param="?nombreAlmacenB="+f.nombreAlmacenB.value;
	param+="&pagina="+f.pagina.value;
		location.href='navegadorAlmacenes.php'+param;		
}
function paginar1(f,pagina)
{		

		f.pagina.value=pagina*1;
var param="?nombreAlmacenB="+f.nombreAlmacenB.value;
	param+="&pagina=1";
			
		location.href='navegadorAlmacenes.php'+param;	
}

function buscar(f){

var param="?nombreAlmacenB="+f.nombreAlmacenB.value;
	//param+="&pagina="+f.pagina.value;

	location.href="navegadorAlmacenes.php"+param;

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
			window.location="editarAlmacen.php?cod_almacen="+cod_registro;
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
			window.location ="listaEliminarAlmacenes.php?datos="+datos;			
	}
}
</script></head>
<body bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">Almacenes
  <a class="btn btn-warning btn-lg float-right text-white boton-filtro-iframe" href="#" data-toggle="modal" data-target="#filtroModal">
       <i class="fa fa-search"></i> BUSCAR REGISTROS
    </a>
</h3>
<form name="form1" method="post" action="registrarAlmacen.php">
<?php 
	require("conexion.inc");
	include("funciones.php");
	$nombreAlmacenB=$_GET['nombreAlmacenB'];

?>





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
	
	$sql_aux=" select count(*) from almacenes ";
	if($nombreAlmacenB<>""){
		$sql_aux.=" where nombre_almacen like '%".$nombreAlmacenB."%'";
	}
	$resp_aux = mysql_query($sql_aux);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}

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
		$sql="select cod_almacen, cod_sucursal, nombre_almacen, cod_estado_registro,";
		$sql.=" cod_usuario_registro, fecha_registro, cod_usuario_modifica, fecha_modifica";
		$sql.=" from almacenes ";
		if($nombreAlmacenB<>""){
			$sql.=" where nombre_almacen like '%".$nombreAlmacenB."%'";
		}		
		$sql.=" order by nombre_almacen asc	";	
		//$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		$resp = mysql_query($sql);

?>	
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc" class="tablaReporte" style="width:100% !important;">
		<thead>
	    <tr height="20px" align="center"  class="bg-success text-white">
			<th>&nbsp;</th>
    		<th>Almacen</th>
    		<th>Sucursal</th>	
    		<th>Estado</th>																	
		</tr>
		</thead>
    <tbody>
<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){	
		
				$cod_almacen=$dat[0];
				$cod_sucursal=$dat[1];
				$nombre_almacen=$dat[2];
				$cod_estado_registro=$dat[3];
				$cod_usuario_registro=$dat[4];
				$fecha_registro=$dat[5];
				$cod_usuario_modifica=$dat[6];
				$fecha_modifica=$dat[7];			
				//**************************************************************
				$nombre_sucursal="";
				$sql2="select nombre_sucursal from sucursales where cod_sucursal='".$cod_sucursal."'";
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_sucursal=$dat2[0];
				}					
				//**************************************************************
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
			<td><input type="checkbox"name="cod_almacen"value="<?php echo $cod_almacen;?>"></td>	
							
    		<td><?php echo $nombre_almacen;?></td>
    		<td><?php echo $nombre_sucursal;?></td>
    		<td><?php echo $nombre_estado_registro;?></td>
				
    	 </tr>
<?php
		 } 
?>			
  			</tbody>
		</table>
		</div>			

<!-- MODAL FILTRO-->
  <div class="modal fade modal-arriba" id="filtroModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Buscar</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </div>
        <div class="modal-body">
<table border="0" align="center">
<tr>
<td><strong>Almacen:</strong></td>
<td colspan="3"><input type="text" name="nombreAlmacenB" id="nombreAlmacenB" size="30" class="textoform" value="<?php echo $nombreAlmacenB;?>" ></td>
<td rowspan="2"><a  onClick="buscar(form1)" class="btn btn-warning"><i class="fa fa-search"></i></a></td>
</tr>
</table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>			
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
