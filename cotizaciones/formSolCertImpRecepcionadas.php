<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Solicitudes de Importacion Recepcionadas</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
function paginar(f)
{	
	location.href="formSolCertImpRecepcionadas.php?pagina="+f.pagina.value;
		
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
	
		location.href='lista_eliminar_formSolCertImpRegistradas.php?datos='+datos+'';
	}
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
			alert('Debe seleccionar un registro para mofificar.');
		}
		else
		{
			izquierda = (screen.width) ? (screen.width-600)/2 : 100 
    		arriba = (screen.height) ? (screen.height-400)/2 : 100 
			location.href="editar_formSolCertImp.php?cod_sol_imp="+cod_registro;	
		}
	}
}




</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<form name="form1" method="post">
<h3 align="center" style="background:white;font-size: 16px;color:#d20000;font-weight:bold;">Solicitudes de Importaci&oacute;n Recepcionadas</h3>
<?php 
require("conexion.inc");
include("funciones.php");

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
	
	$sql_aux=" select count(*)";
	$sql_aux.=" from solicitudes_importacion ";			
	$sql_aux.=" where cod_estado_sol_imp=2";
	$resp_aux = mysql_query($sql_aux);
	$nro_filas_sql=0;
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}	


	if($nro_filas_sql==0){
?>
	<table width="95%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
				<td>Nro de Solicitud</td>
				<td>Representante Legal</td>
				<td>Contacto de Representante Legal</td>				
				<td>Documentos Adjuntos</td>				
				<td>Fecha Registro</td>		
				<td>Fecha de Ultima Edición</td>
				<td>Fecha de Envio</td>				
				<td>Estado</td>							
		</tr>
		<tr><th colspan="8" class="fila_par" align="center">&iexcl;No existen Formularios de Solicitud!</th></tr>
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
		$sql=" select cod_sol_imp, cod_contacto_rep_legal,persona_contacto_rep_legal, cod_contacto_registro, fecha_registro, ";
		$sql.=" cod_contacto_modifica, fecha_modifica, cod_usuario_asig_inspeccion,fecha_asig_inspeccion, cod_usuario_inspeccion,";
		$sql.=" obs_asig_inspeccion, cod_estado_sol_imp, cod_contacto_envio, fecha_envio ";
		$sql.=" from solicitudes_importacion";		
		$sql.=" where cod_estado_sol_imp=2";
		$sql.=" order by fecha_registro desc ";
		$sql.="  limit ".$fila_inicio." , ".$fila_final;
		$resp=mysql_query($sql);
?>	
		<div align="center">
			<table width="90%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
		    <tr height="20px"  class="titulo_tabla">
				<td width="20px" >&nbsp;</td>
				<td>Nro de Solicitud</td>
				<td>Representante Legal</td>
				<td>Contacto de Representante Legal</td>				
				<td>Documentos Adjuntos</td>				
				<td>Fecha Registro</td>		
				<td>Fecha de Ultima Edición</td>
				<td>Fecha de Envio</td>							
				<td>Estado</td>														
			</tr>
<?php   
		while($dat=mysql_fetch_array($resp)){		
							
			$cod_sol_imp=$dat[0];
			$cod_contacto_rep_legal=$dat[1];
			/*--------------------------------*/						
			$sql2=" select  nombre_contacto, ap_paterno_contacto, ap_materno_contacto from contactos  where cod_contacto='".$cod_contacto_rep_legal."'";
			$nombre_contacto_rep_legal="";
			$ap_paterno_contacto_rep_legal="";
			$ap_materno_contacto_rep_legal="";
			$resp2=mysql_query($sql2);
			while($dat2=mysql_fetch_array($resp2)){
					$nombre_contacto_rep_legal=$dat2[0];
					$ap_paterno_contacto_rep_legal=$dat2[1];
					$ap_materno_contacto_rep_legal=$dat2[2];
			}
			/*--------------------------------*/							
			$persona_contacto_rep_legal=$dat[2];
			
			$cod_contacto_registro=$dat[3];
			/*--------------------------------------------*/
			$sql2=" select  nombre_contacto, ap_paterno_contacto, ap_materno_contacto from contactos  where cod_contacto='".$cod_contacto_registro."'";
			$nombre_contacto_registro="";
			$ap_paterno_contacto_registro="";
			$ap_materno_contacto_registro="";
			$resp2=mysql_query($sql2);
			while($dat2=mysql_fetch_array($resp2)){
					$nombre_contacto_registro=$dat2[0];
					$ap_paterno_contacto_registro=$dat2[1];
					$ap_materno_contacto_registro=$dat2[2];
			}
			/*--------------------------------------------*/			
			$fecha_registro=$dat[4];
				if($fecha_registro<>""){
					$vector=explode(" ",$fecha_registro);
					$vector2=explode("-",$vector[0]);				
					$fecha_registro=$vector2[2]."/".$vector2[1]."/".$vector2[0]." ".$vector[1];
				}
			
			$cod_contacto_modifica=$dat[5]; 
			/*--------------------------------------------*/
			$sql2=" select  nombre_contacto, ap_paterno_contacto, ap_materno_contacto from contactos  where cod_contacto='".$cod_contacto_registro."'";
			$nombre_contacto_modifica="";
			$ap_paterno_contacto_modifica="";
			$ap_materno_contacto_modifica="";
			$resp2=mysql_query($sql2);
			while($dat2=mysql_fetch_array($resp2)){
					$nombre_contacto_modifica=$dat2[0];
					$ap_paterno_contacto_modifica=$dat2[1];
					$ap_materno_contacto_modifica=$dat2[2];
			}
			/*--------------------------------------------*/				
			$fecha_modifica=$dat[6];
			if($fecha_modifica<>""){
					$vector=explode(" ",$fecha_modifica);
					$vector2=explode("-",$vector[0]);				
					$fecha_modifica=$vector2[2]."/".$vector2[1]."/".$vector2[0]." ".$vector[1];
			}			
			
			$cod_usuario_asig_inspeccion=$dat[7];
			/*--------------------------------------------*/
			$sql2=" select  nombre_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios  where cod_usuario='".$cod_usuario_asig_inspeccion."'";
			$nombre_usuario_asig_inspeccion="";
			$ap_paterno_usuario_asig_inspeccion="";
			$ap_materno_usuario_asig_inspeccion="";
			$resp2=mysql_query($sql2);
			while($dat2=mysql_fetch_array($resp2)){
					$nombre_usuario_asig_inspeccion=$dat2[0];
					$ap_paterno_usuario_asig_inspeccion=$dat2[1];
					$ap_materno_usuario_asig_inspeccion=$dat2[2];
			}
			/*--------------------------------------------*/			
						
			$fecha_asig_inspeccion=$dat[8];
			if($fecha_asig_inspeccion<>""){
					$vector=explode(" ",$fecha_asig_inspeccion);
					$vector2=explode("-",$vector[0]);				
					$fecha_asig_inspeccion=$vector2[2]."/".$vector2[1]."/".$vector2[0]." ".$vector[1];
			}	
						
			$cod_usuario_inspeccion=$dat[9];
			/*--------------------------------------------*/
			$sql2=" select  nombre_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios  where cod_usuario='".$cod_usuario_inspeccion."'";
			$nombre_usuario_inspeccion="";
			$ap_paterno_usuario_inspeccion="";
			$ap_materno_usuario_inspeccion="";
			$resp2=mysql_query($sql2);
			while($dat2=mysql_fetch_array($resp2)){
					$nombre_usuario_inspeccion=$dat2[0];
					$ap_paterno_usuario_inspeccion=$dat2[1];
					$ap_materno_usuario_inspeccion=$dat2[2];
			}
			/*--------------------------------------------*/						
			$obs_asig_inspeccion=$dat[10];
			$cod_estado_sol_imp=$dat[11];
			$sql2=" select  nombre_estado_sol_imp from estados_solucitudes_importacion  where cod_estado_sol_imp='".$cod_estado_sol_imp."'";
			$nombre_estado_sol_imp="";
			$resp2=mysql_query($sql2);
			while($dat2=mysql_fetch_array($resp2)){
					$nombre_estado_sol_imp=$dat2[0];
			}
			$cod_contacto_envio=$dat[12];
				$sql2=" select  nombre_contacto, ap_paterno_contacto, ap_materno_contacto from contactos  where cod_contacto='".$cod_contacto_envio."'";
				$nombre_contacto_envio="";
				$ap_paterno_contacto_envio="";
				$ap_materno_contacto_envio="";
				$resp2=mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_contacto_envio=$dat2[0];
					$ap_paterno_contacto_envio=$dat2[1];
					$ap_materno_contacto_envio=$dat2[2];
				}			
			
			$fecha_envio=$dat[13];
			if($fecha_envio<>""){
					$vector=explode(" ",$fecha_envio);
					$vector2=explode("-",$vector[0]);				
					$fecha_envio=$vector2[2]."/".$vector2[1]."/".$vector2[0]." ".$vector[1];
			}				
						
?> 
		<tr bgcolor="#FFFFFF">
			<td align="left"><input type="checkbox"name="cod_sol_imp"value="<?php echo $cod_sol_imp; ?>"></td>
			<td><?php echo $cod_sol_imp;?></td>
			<td><?php echo $nombre_contacto_rep_legal." ".$ap_paterno_contacto_rep_legal." ".$ap_materno_contacto_rep_legal; ?></td>
			<td><?php echo $persona_contacto_rep_legal;?></td>				
			<td>
				<ul>
			<?php
				$sql2="select cod_doc_sol_imp, nombre_doc_sol_imp from documentos_sol_imp";
				$resp2 = mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){			
				 	$cod_doc_sol_imp=$dat2[0];
					$nombre_doc_sol_imp=$dat2[1];	
			?>
				<li><?php echo $nombre_doc_sol_imp;?>
			<?php					
					$sql3="select url_archivo from sol_imp_doc where cod_sol_imp='".$cod_sol_imp."' and cod_doc_sol_imp='".$cod_doc_sol_imp."'";
					$resp3 = mysql_query($sql3);
					while($dat3=mysql_fetch_array($resp3)){		
						$url_archivo=$dat3[0];
					}
					if($url_archivo<>""){
			?>
					<a href="..//anexos_solCertImp/<?php echo $url_archivo;?>" target="_blank">Ver Archivo</a>
			<?php		}else{
			?>
					<a href="#">(No Adjunto Archivo)</a>
			<?php	}
			?>
				</li>
			<?php				
				}			
			?>
				</ul>
			</td>				
			<td><?php echo $fecha_registro;?><br><?php echo $nombre_contacto_registro." ".$ap_paterno_contacto_registro." ".$ap_materno_contacto_registro;?></td>		
			<td><?php echo $fecha_modifica;?><br><?php echo $nombre_contacto_modifica." ".$ap_paterno_contacto_modifica." ".$ap_materno_contacto_modifica;?></td>
			<td><?php echo $fecha_envio;?><br><?php echo $nombre_contacto_envio." ".$ap_paterno_contacto_envio." ".$ap_materno_contacto_envio;?></td>
			<td><?php echo $nombre_estado_sol_imp;?></td>					
		  </tr>
<?php
		} 
?>			
		<tfoot>
  			<tr bgcolor="#FFFFFF">
    			<td colSpan="9" align="center">
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
		</tfoot>
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
