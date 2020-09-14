<?
header("Cache-Control: no-store, no-cache, must-revalidate");

//coneccion a la Base de Datos
require("conexion.inc");
	$clienteContactoB=$_GET['clienteContactoB'];

//para sacar los datos de la busqueda
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Clientes</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
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
		$sql.=" from clientes ";
		if($_GET['clienteContactoB']<>""){
			$sql.=" where nombre_cliente like '%".$_GET['clienteContactoB']."%'";
			$sql.=" or cod_cliente in( select cod_cliente from clientes_contactos where CONCAT(nombre_contacto,ap_paterno_contacto,ap_materno_contacto)like '%".$_GET['clienteContactoB']."%')";
		}
		$sql.=" order by nombre_cliente asc  ";
		$resp_aux = mysql_query($sql);
		while($dat_aux=mysql_fetch_array($resp_aux)){
			$nro_filas_sql=$dat_aux[0];
		}
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
            <td>Celular</td>			
    		<td>Email</td>					
    		<td>Observaciones</td>			
    		<td>Estado</td>											
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
		$sql=" select cod_cliente, nombre_cliente, nit_cliente,cod_categoria, cod_ciudad, ";
		$sql.=" direccion_cliente, telefono_cliente, celular_cliente,fax_cliente, ";
		$sql.=" email_cliente, obs_cliente, cod_usuario_registro, ";
		$sql.=" fecha_registro, cod_usuario_modifica, fecha_modifica, cod_estado_registro ";
		$sql.=" from clientes ";
		if($_GET['clienteContactoB']<>""){
			$sql.=" where nombre_cliente like '%".$_GET['clienteContactoB']."%'";
			$sql.=" or cod_cliente in( select cod_cliente from clientes_contactos where CONCAT(nombre_contacto,ap_paterno_contacto,ap_materno_contacto)like '%".$_GET['clienteContactoB']."%')";
		}
		$sql.=" order by nombre_cliente asc  ";
		$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;

		$resp = mysql_query($sql);

?>	
<h3 align="center" style="background:#FFF;font-size: 10px;color: #000;font-weight:bold;">Total Registro:<?php echo $nro_filas_sql;?></h3>
	<table width="89%" align="center" cellpadding="1" cellspacing="1" bgColor="#CCCCCC">
    <tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="11">
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
    		<td>ID</td>
            <td>Cliente</td>
            <td>Nit</td>
            <td>Direccion</td>
            <td>Telf/Celular/fax</td>
            <td colspan="3">Contactos</td>
            <td colspan="3">&nbsp;</td>            															
		</tr>

<?php   
	$cont=0;
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
					$nroContactos=0;							
					$sql2="select count(*) from clientes_contactos";
					$sql2.=" where cod_cliente='".$cod_cliente."'";	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nroContactos=$dat2[0];
					}	
					$nroUnidades=0;							
					$sql2="select count(*) from clientes_unidades";
					$sql2.=" where cod_cliente='".$cod_cliente."'";	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nroUnidades=$dat2[0];
					}													

				
?> 

		<tr bgcolor="#FFFFFF" class="text">	
				<td><?php echo $cod_cliente;?></td>		
    		<td><?php echo $nombre_cliente;?></td>
    		<td><?php echo $nit_cliente;?></td>
    		<td><?php echo $direccion_cliente;?></td>
    		<td><?php echo $telefono_cliente." ".$celular_cliente." ".$fax_cliente;?></td>
<td  align="center" colspan="3"><a href="listContactosClientes.php?cod_cliente=<?php echo $cod_cliente;?>"><img src="img/msnLogo.gif"  border="0"width="16" height="16"><br/>
[Administrar Contactos (<?php echo $nroContactos;?>)]</a></td>            
<td align="center"><a href="listUnidadesClientes.php?cod_cliente=<?php echo $cod_cliente;?>"><img src="img/organigrama.jpg" border="0" ><br/>
[Administar Unidades (<?php echo $nroUnidades;?>)]</a></td>
            <td><a href="editarCliente.php?cod_cliente=<?php echo $cod_cliente;?>" class="link_color1" title="EDICION DE CLIENTE"><img src="img/edit.png"  border="0"></a></td>
            <td><a href="listaEliminarClientes.php?cod_cliente=<?php echo $cod_cliente;?>" class="link_color1">
            <img src="img/delete.gif" border="0" width="16" height="16"></a></td> 

         </tr>



				<?php
				$swUnidades=1;
	          	$sqlAux=" select cod_contacto, nombre_contacto, ap_paterno_contacto, ap_materno_contacto, cargo_contacto,";
				$sqlAux.=" telefono_contacto, celular_contacto";
				$sqlAux.=" from clientes_contactos ";
				$sqlAux.=" where cod_cliente=".$cod_cliente;
				$sqlAux.=" order by ap_paterno_contacto, ap_materno_contacto, nombre_contacto asc ";
				$respAux= mysql_query($sqlAux);
				while($datAux=mysql_fetch_array($respAux)){
					$cod_contacto=$datAux['cod_contacto'];
					$nombre_contacto=$datAux['nombre_contacto'];
					$ap_paterno_contacto=$datAux['ap_paterno_contacto'];
					$ap_materno_contacto=$datAux['ap_materno_contacto'];
					$cargo_contacto=$datAux['cargo_contacto'];
					$telefono_contacto=$datAux['telefono_contacto'];
					$celular_contacto=$datAux['celular_contacto'];
				?>
                <tr class="text" bgcolor="#FFFFFF">
                <td colspan="5">&nbsp;</td>
                <td><?php echo $ap_paterno_contacto." ".$nombre_contacto;?></td>
                <td><?php echo $cargo_contacto;?></td>
                <td><?php echo $telefono_contacto." ".$celular_contacto;?></td>
                
                
				<td><?php
                if($nroUnidades>0 and $swUnidades==1){
					$swUnidades=0;
					$sqlAux2="select nombre_unidad, telf_unidad from clientes_unidades";
					$sqlAux2.=" where cod_cliente='".$cod_cliente."'";	
					$sqlAux2.=" order by nombre_unidad asc";
					$respAux2= mysql_query($sqlAux2);
					while($datAux2=mysql_fetch_array($respAux2)){
						$nombre_unidad=$datAux2['nombre_unidad'];
						$telf_unidad=$datAux2['telf_unidad'];
						echo "<br/>".$nombre_unidad;
					}	
				}
				
				?></td>
                <td colspan="2">&nbsp;</td>                                                                     
                </tr>
                <?php
				}					
			?>
            <?php  if($nroUnidades>0 and $swUnidades==1){?>
            <tr bgcolor="#FFFFFF">
            <td colspan="8">&nbsp;</td>
            <td>
            <?php
                 
					$swUnidades=0;
					$sqlAux2="select nombre_unidad, telf_unidad from clientes_unidades";
					$sqlAux2.=" where cod_cliente='".$cod_cliente."'";	
					$sqlAux2.=" order by nombre_unidad asc";
					$respAux2= mysql_query($sqlAux2);
					while($datAux2=mysql_fetch_array($respAux2)){
						$nombre_unidad=$datAux2['nombre_unidad'];
						$telf_unidad=$datAux2['telf_unidad'];
						echo "<br/>".$nombre_unidad."(".$telf_unidad.")";
					}	
				
			?>
            </td>
            <td colspan="2">&nbsp;</td>  
            <tr>
			<?php }?>
<?php
		 } 
?>			
	<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="11">
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