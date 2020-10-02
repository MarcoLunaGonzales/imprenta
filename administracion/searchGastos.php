<?php
header("Cache-Control: no-store, no-cache, must-revalidate");

//coneccion a la Base de Datos
require("conexion.inc");
include("funciones.php");

//para sacar los datos de la busqueda
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgcolor="#FFFFFF">
<?php
	$nro_filas_show=50;	
	$pagina=$_GET['pagina'];
	//echo $pagina;
	if ($pagina==""){
		$pagina = 1;
		$fila_inicio=0;
		$fila_final=$nro_filas_show;
	}else{
		$fila_inicio=(($pagina*$nro_filas_show)-$nro_filas_show);
		$fila_final=($fila_inicio+$nro_filas_show);
	}	
	
	$sql=" select count(*)  ";
	$sql.=" from gastos g, estados_referenciales er ";
	$sql.=" where g.cod_estado_registro=er.cod_estado_registro ";	
	if($_GET['cod_estado_registro']<>0){
			$sql.=" and g.cod_estado_registro=".$_GET['cod_estado_registro'];
	}
	if($_GET['descGastoB']<>""){
			$sql.=" and g.desc_gasto like '%".$_GET['descGastoB']."%'";
	}	
//echo $sql;
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$nro_filas_sql=$dat[0];
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
		$sql=" select g.cod_gasto, g.desc_gasto, g.obs_gasto, g.cod_estado_registro, ";
		$sql.=" er.nombre_estado_registro, g.cod_usuario_registro, g.fecha_registro, ";
		$sql.=" g.cod_usuario_modifica, g.fecha_modifica ";
		$sql.=" from gastos g, estados_referenciales er ";
		$sql.=" where g.cod_estado_registro=er.cod_estado_registro ";
	if($_GET['cod_estado_registro']<>0){
			$sql.=" and g.cod_estado_registro=".$_GET['cod_estado_registro'];
	}
		if($_GET['descGastoB']<>""){
			$sql.=" and g.desc_gasto like '%".$_GET['descGastoB']."%'";
		}			
		$sql.=" order by g.desc_gasto";
		//echo $sql;
		//$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		$resp = mysql_query($sql);
		

?>	

	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc" class="tablaReporte" bgColor="#cccccc" style="width:100% !important;">
<thead>
	    <tr height="20px" align="center"  class="bg-success text-white">
            <th>Gasto</th>
			<th>Observaciones</th>				
    		<th>Estado</th>
			<th>Fecha de Registro</th>	
			<th>Ultima Edici&oacute;n</th>	
            <th>&nbsp;</th>	
            <th>&nbsp;</th>																		
		</tr>
  </thead>    
  <tbody>
<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){
		
				$cod_gasto=$dat['cod_gasto'];
				$desc_gasto=$dat['desc_gasto'];
				$obs_gasto=$dat['obs_gasto'];
				$cod_estado_registro=$dat['cod_estado_registro'];
				$nombre_estado_registro=$dat['nombre_estado_registro'];
				$cod_usuario_registro=$dat['cod_usuario_registro'];				
				$fecha_registro=$dat['fecha_registro'];
				$cod_usuario_modifica=$dat['cod_usuario_modifica'];
				$fecha_modifica=$dat['fecha_modifica'];	
				///Usuario de Registro//////////
				if($cod_usuario_registro<>""){
					$sqlAux=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
					$sqlAux.=" from usuarios ";
					$sqlAux.=" where cod_usuario=".$cod_usuario_registro;
					$respAux = mysql_query($sqlAux);
					$nombres_usuario_registro="";
					$ap_paterno_usuario_registro="";
					$ap_materno_usuario_registro="";						
					while($datAux=mysql_fetch_array($respAux)){
						
						$nombres_usuario_registro=$datAux['nombres_usuario'];
						$ap_paterno_usuario_registro=$datAux['ap_paterno_usuario'];
						$ap_materno_usuario_registro=$datAux['ap_materno_usuario'];						
					}
				}
				////////////////////////////////	
				///Usuario de Modifica//////////
				if($cod_usuario_modifica<>""){
					$sqlAux=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario ";
					$sqlAux.=" from usuarios ";
					$sqlAux.=" where cod_usuario=".$cod_usuario_modifica;
					$respAux = mysql_query($sqlAux);
					$nombres_usuario_modifica="";
					$ap_paterno_usuario_modifica="";
					$ap_materno_usuario_modifica="";						
					while($datAux=mysql_fetch_array($respAux)){
						
						$nombres_usuario_modifica=$datAux['nombres_usuario'];
						$ap_paterno_usuario_modifica=$datAux['ap_paterno_usuario'];
						$ap_materno_usuario_modifica=$datAux['ap_materno_usuario'];						
					}
				}
				////////////////////////////////				
				
?> 
		<tr bgcolor="#FFFFFF">	
    		<td align="left"><?php echo $desc_gasto;?></td>
    		<td><?php echo $obs_gasto;?></td>
    		<td><?php echo $nombre_estado_registro; ?></td>
			<td>
			<?php
				if($fecha_registro<>""){ 
					echo strftime("%d/%m/%Y",strtotime($fecha_registro))." ". $nombres_usuario_registro[0].$ap_paterno_usuario_registro[0].$ap_materno_usuario_registro[0]; 
				}
			?>
            </td>
   			<td><?php 
				if($fecha_modifica<>""){
				echo strftime("%d/%m/%Y",strtotime($fecha_modifica))." ". $nombres_usuario_modifica[0].$ap_paterno_usuario_modifica[0].$ap_materno_usuario_modifica[0];
				}
				 ?></td>
            <td><a href="editGasto.php?cod_gasto=<?php echo $cod_gasto;?>" class="btn btn-success text-white"><i class="fa fa-edit"></i></a></td>
            <td><a href="deleteGasto.php?cod_gasto=<?php echo $cod_gasto;?>" class="btn btn-danger text-white"><i class="fa fa-trash"></i></a></td>

					
   	  </tr>
<?php
		 } 
?>		
  			</tbody>	
  </table>
		</div>			

   
</body>
</html>