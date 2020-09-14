<?
header('Content-Type: text/html; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';

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
		if($nro_filas_sql==0){
?>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>Usuario</td>
    		<td>CI</td>
    		<td>Ciudad</td>
    		<td>Telf</td>
    		<td>Area</td>
    		<td>Cargo</td>
    		<td>Grado</td>
            <td>User</td>			
    		<td>Password</td>					
    		<td>Estado</td>			
    		<td>Modulos</td>	
            <td>Usuario Interno</td>
            <td>Autorizado Firma Cotizacion</td>	             										
		</tr>
		<tr><th colspan="13" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
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
		$sql=" select cod_usuario, cod_area, cod_cargo, cod_grado, usuario, contrasenia,  ";
		$sql.=" nombres_usuario,nombres_usuario2, nombres_pila,  ap_paterno_usuario, ap_materno_usuario, ";
		$sql.=" ci_usuario,cod_ciudad, telf_usuario, email_usuario, cod_estado_registro, usuario_interno, cod_perfil ";
		$sql.=" from usuarios  ";
		if($_GET['usuarioB']<>""){
		$sql.="where CONCAT(ap_paterno_usuario,' ',ap_materno_usuario,' ',nombres_pila,' ',nombres_usuario,' ',nombres_usuario2) like '%".$_GET['usuarioB']."%'";
		}		
		$sql.=" order by ap_paterno_usuario asc, ap_materno_usuario asc, nombres_pila asc,nombres_usuario asc ";
		$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		$resp = mysql_query($sql);

?>	
<h3 align="center" style="background:#FFF;font-size: 10px;color: #000;font-weight:bold;">Total Registro:<?php echo $nro_filas_sql;?></h3>
	<table width="89%" align="center" cellpadding="1" cellspacing="1" bgColor="#CCCCCC">
    <tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="15">
						<p align="center">						
						<b><?php if($pagina>1){ ?>
							<a href="#" onclick="paginar1(form1,<?php echo $pagina-1; ?>)" ><--Anterior</a>
							<?php }?>
						</b>
						<b> Pagina <?php echo $pagina; ?> de <?php echo $nropaginas; ?> </b>
						<b><?php if($nropaginas>$pagina){ ?> 
							<a href="#" onclick="paginar1(form1,<?php echo $pagina+1; ?>)" >Siguiente--></a>
						<?php }?></b>
						</p>
                        <?php if($nropaginas>1){ ?>
                      <p align="center">				
						Ir a Pagina<input type="text" name="pagina1" class="texto" id="pagina1" size="5" value="<?php echo $pagina;?>" onkeypress="return validar(event)"><input  type="button" size="8"  value="Ir" onClick="paginar(this.form)"  >	
				  </p>
						<?php }?>
</td>
			</tr>    
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>Usuario</td>
    		<td>CI</td>
    		<td>Ciudad</td>
    		<td>Telf</td>
    		<td>Area</td>
    		<td>Cargo</td>
    		<td>Grado</td>
            <td>User</td>			
    		<td>Password</td>					
    		<td>Estado</td>			
    		<td>Modulos</td>
            <td>Perfil</td>
            <td>Usuario</td>
           <td>Firma Cotizacion</td>	
           <td>Editar</td>		        															
		</tr>

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
				
	<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="15">
						<p align="center">						
						<b><?php if($pagina>1){ ?>
							<a href="#" onclick="paginar(form1,<?php echo $pagina-1; ?>)" ><--Anterior</a>
							<?php }?>
						</b>
						<b> Pagina <?php echo $pagina; ?> de <?php echo $nropaginas; ?> </b>
						<b><?php if($nropaginas>$pagina){ ?> 
							<a href="#" onclick="paginar1(form1,<?php echo $pagina+1; ?>)">Siguiente--></a>
						<?php }?></b>
						</p>
                        <?php if($nropaginas>1){ ?>
						<p align="center">				
						Ir a Pagina<input type="text" name="pagina2" size="5"  class="texto" id="pagina2" value="<?php echo $pagina;?>" onkeypress="return validar(event)"><input  type="button" size="8"  value="Ir" onClick="paginar2(this.form)">	</p>
                         <?php } ?>		
</td>
			</tr>
		</table>

<?php
	}
?>
	
</body>
</html>