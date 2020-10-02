<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Usuarios</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}
function buscar()
{	
		var param="?";
		param+='usuarioB='+document.form1.usuarioB.value;
		param+='&nro_filas_show=1';	
		
		divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchUsuarios.php'+param);
			ajax.onreadystatechange=function() {
				if (ajax.readyState==4) {
					divResultado.innerHTML = ajax.responseText;
					cargarClasesFrame();	
			        agregarTablaReporteClase();
				}
			}
				ajax.send(null)	

}


function paginar(f)
{	

		var param="?";
		param+='usuarioB='+document.form1.usuarioB.value;
		param+='&nro_filas_show='+document.form1.nro_filas_show.value;
		param+='&pagina='+document.form1.pagina1.value;
	
		divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchUsuarios.php'+param);
			ajax.onreadystatechange=function() {
				if (ajax.readyState==4) {
					divResultado.innerHTML = ajax.responseText
				}
			}
		ajax.send(null)	
}
function paginar1(f,pagina)
{	
		document.form1.pagina1.value=pagina*1;
		var param="?";
		param+='usuarioB='+document.form1.usuarioB.value;
		param+='&nro_filas_show='+document.form1.nro_filas_show.value;
		param+='&pagina='+document.form1.pagina1.value;
	
		divResultado = document.getElementById('resultados');
		//alert('searchUsuarios.php'+param);
		ajax=objetoAjax();
			ajax.open("GET",'searchUsuarios.php'+param);
			ajax.onreadystatechange=function() {
				if (ajax.readyState==4) {
					divResultado.innerHTML = ajax.responseText
				}
			}
		ajax.send(null)	
}
function paginar2(f)
{	
		var param="?";
		param+='usuarioB='+document.form1.usuarioB.value;
		param+='&nro_filas_show='+document.form1.nro_filas_show.value;
		param+='&pagina='+document.form1.pagina2.value;
	
			divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchUsuarios.php'+param);
			ajax.onreadystatechange=function() {
				if (ajax.readyState==4) {
					divResultado.innerHTML = ajax.responseText
				}
			}
		ajax.send(null)
}



</script>

</head>
<body  bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">LISTADO DE USUARIOS
  <a class="btn btn-warning btn-lg float-right text-white boton-filtro-iframe" href="#" data-toggle="modal" data-target="#filtroModal">
       <i class="fa fa-search"></i> BUSCAR REGISTROS
    </a>
</h3>
<form name="form1" id="form1" method="post" >
<?php 
	require("conexion.inc");
	include("funciones.php");

?>

<div id="resultados">


<?php	
	//Paginador
	if($_GET['nro_filas_show']==""){
		$nro_filas_show=20;
	}
	$pagina = $_GET['pagina'];

	if ($pagina == ""){
		$pagina = 1;
		$fila_inicio=0;
		$fila_final=$nro_filas_show;
	}else{
		$fila_inicio=(($pagina*$nro_filas_show)-$nro_filas_show);
		$fila_final=($fila_inicio+$nro_filas_show);
	}	
	
		$sql=" select count(*) ";
		$sql.=" from usuarios ";
		if($_GET['usuarioB']<>""){
		$sql.="where CONCAT(ap_paterno_usuario,' ',ap_materno_usuario,' ',nombres_pila,' ',nombres_usuario,' ',nombres_usuario2) like '%".$_GET['usuarioB']."%'";
		}
		$resp_aux = mysql_query($sql);
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
		$sql=" select cod_usuario, cod_area, cod_cargo, cod_grado, usuario, contrasenia,  ";
		$sql.=" nombres_usuario,nombres_usuario2, nombres_pila,  ap_paterno_usuario, ap_materno_usuario, ";
		$sql.=" ci_usuario,cod_ciudad, telf_usuario, email_usuario, cod_estado_registro, usuario_interno, cod_perfil ";
		$sql.=" from usuarios  ";
		if($_GET['usuarioB']<>""){
		$sql.="where CONCAT(ap_paterno_usuario,' ',ap_materno_usuario,' ',nombres_pila,' ',nombres_usuario,' ',nombres_usuario2) like '%".$_GET['usuarioB']."%'";
		}		
		$sql.=" order by ap_paterno_usuario asc, ap_materno_usuario asc, nombres_pila asc,nombres_usuario asc ";
		$sql.=" limit 50";
		$resp = mysql_query($sql);

?>	

	<table width="89%" align="center" cellpadding="1" cellspacing="1" bgColor="#CCCCCC" class="tablaReporte" style="width:100% !important;">  
	<thead>
	    <tr height="20px" align="center"  class="bg-success text-white">
    		<th>Usuario</th>
    		<th>CI</th>
    		<th>Ciudad</th>
    		<th>Telf</th>
    		<th>Area</th>
    		<th>Cargo</th>
    		<th>Grado</th>
            <th>User</th>			
    		<th>Password</th>					
    		<th>Estado</th>			
    		<th>Modulos</th>
            <th>Perfil</th>
            <th>Usuario</th>
           <th>Firma Cotizacion</th>	
           <th>Editar</th>		        															
		</tr>
		</thead>
    <tbody>
<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){	
		
			$cod_usuario=$dat['cod_usuario'];
			$cod_area=$dat['cod_area'];
			$cod_cargo=$dat['cod_cargo'];
			$cod_grado=$dat['cod_grado'];
			$usuario=$dat['usuario'];
			$contrasenia=$dat['contrasenia'];
			$nombres_usuario=$dat['nombres_usuario'];
			$nombres_usuario2=$dat['nombres_usuario2'];
			$nombres_pila=$dat['nombres_pila'];
			$ap_paterno_usuario=$dat['ap_paterno_usuario'];
			$ap_materno_usuario=$dat['ap_materno_usuario'];
			$ci_usuario=$dat['ci_usuario'];
			$cod_ciudad=$dat['cod_ciudad'];
			$telf_usuario=$dat['telf_usuario'];
			$email_usuario=$dat['email_usuario'];
			$cod_estado_registro=$dat['cod_estado_registro'];
			$usuario_interno=$dat['usuario_interno'];
			$cod_perfil=$dat['cod_perfil'];
			$descUsuario="";
			 if($usuario_interno==1){
					$descUsuario="Interno";
				}else{
					$descUsuario="Externo";
				}

			//**************************************************************
				$desc_ciudad="";				
				$sql2="select desc_ciudad from ciudades where cod_ciudad='".$cod_ciudad."'";	
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$desc_ciudad=$dat2['desc_ciudad'];
				}	
				$nombre_area="";				
				$sql2="select nombre_area from areas where cod_area='".$cod_area."'";	
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_area=$dat2['nombre_area'];
				}	
				$desc_cargo="";				
				$sql2="select desc_cargo from cargos where cod_cargo='".$cod_cargo."'";	
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$desc_cargo=$dat2['desc_cargo'];
				}	
				$desc_grado="";				
				$sql2="select desc_grado from grado_academico where cod_grado='".$cod_grado."'";	
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$desc_grado=$dat2['desc_grado'];
				}	
				
			$nombre_estado_registro="";				
			$sql2="select nombre_estado_registro from estados_referenciales where cod_estado_registro='".$cod_estado_registro."'";	
			$resp2= mysql_query($sql2);
			while($dat2=mysql_fetch_array($resp2)){
				$nombre_estado_registro=$dat2['nombre_estado_registro'];
			}	
			//******************************Perfil*******************************
					$nombre_perfil="";				
					$sql2=" select nombre_perfil from perfiles";
					$sql2.=" where cod_perfil='".$cod_perfil."'";	
					$resp2= mysql_query($sql2);
					$nombre_perfil="";
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_perfil=$dat2['nombre_perfil'];
					}
			//*******************************Fin Perfil*******************************																	
			//**************************************************************
			$autorizadoFirmaCotizacion="";				
			$sql2="select count(*) from autorizados_firma_cotizacion";
			$sql2.=" where cod_usuario='".$cod_usuario."'";	
			$resp2= mysql_query($sql2);
			while($dat2=mysql_fetch_array($resp2)){
					$var=$dat2[0];
			}	
			if($var>0){
					$autorizadoFirmaCotizacion="OK";
			}								
													

				
?> 

		<tr bgcolor="#FFFFFF" class="text">	
			<td><?php echo $ap_paterno_usuario." ".$ap_materno_usuario." ".$nombres_usuario." ".$nombres_usuario2;?></td>		
    		<td><?php echo $ci_usuario;?></td>
            <td><?php echo $desc_ciudad;?></td>
             <td><?php echo $telf_usuario;?></td>
            <td><?php echo $nombre_area;?></td>
            <td><?php echo $desc_cargo;?></td>
            <td><?php echo $desc_grado;?></td>
            <td><?php echo $usuario;?></td>
            <td><?php echo $contrasenia;?></td>
            <td><?php echo $nombre_estado_registro;?></td>
            <td>
	            <table border="0" cellspacing="1" cellpadding="1">
			<?php 
				$sql2=" select  um.cod_modulo, m.nombre_modulo ";
				$sql2.=" from usuarios_modulos um, modulos m ";
				$sql2.=" where um.cod_usuario=".$cod_usuario;
				$sql2.=" and um.cod_modulo=m.cod_modulo";
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$cod_modulo=$dat2['cod_modulo'];
					$nombre_modulo=$dat2['nombre_modulo'];
			?>
            	<tr><td><?php echo "- ".$nombre_modulo;?></td></tr>
            <?php
				}
 
			
			?>
            </table>
            </td>
			<td><?php echo $nombre_perfil;?></td>
            <td><?php echo $descUsuario;?></td>
          <td><?php echo $autorizadoFirmaCotizacion;?></td>
<td><a href="editarUsuario.php?cod_usuario=<?php echo $cod_usuario;?>" class="link_color1" title="Editar"><img src="img/edit.png"  border="0"></a></td>


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
<td><strong>Buscar por Usuario</strong></td>
<td colspan="3"><input type="text" name="usuarioB" id="usuarioB" size="60" class="textoform" value="<?php echo $usuarioB;?>" onkeyup="buscar()" ></td>
</tr>
</table>
<table border="0" align="center" width="89%">
<tr><td align="right">
<div align="right"><a href="registrarUsuario.php" class="btn btn-warning text-white"><i class="fa fa-plus"></i> Nuevo Usuario</a></div>
</td>
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


</form>
</body>
</html>
