<?php
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
<title>CUENTAS</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>


<?php	
	//Paginador
	if($_GET['$nro_filas_show']==""){
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
		$sql.=" FROM(select cod_cliente,SUM(nroHR) as nroHR,SUM(nroOT) as nroOT,SUM(nroVTA) as nroVTA ";
		$sql.=" from (select c.cod_cliente,count(*) as nroHR, 0 as nroOT, 0 as nroVTA ";
		$sql.=" from  hojas_rutas hr inner join cotizaciones c ";
		$sql.=" ON( hr.cod_cotizacion=c.cod_cotizacion and  hr.cod_estado_hoja_ruta<>2)";
		$sql.=" group by c.cod_cliente ";
		$sql.=" UNION ";
		$sql.=" select cod_cliente, 0 as nroHR, COUNT(*) as nroOT, 0 as nroVTA";
		$sql.=" from ordentrabajo where cod_est_ot<>2 ";
		$sql.=" group by cod_cliente ";
		$sql.=" UNION ";
		$sql.=" select cod_cliente_venta as cod_cliente, 0 as nroHR, 0 as nroOT, COUNT(*) as nroVTA";
		$sql.=" from  salidas where cod_tipo_salida=1  and cod_estado_salida<>2 ";
		$sql.=" group by cod_cliente) as clientesValidos ";
		$sql.=" GROUP BY cod_cliente) as clientesVal  INNER join clientes cli ON(clientesVal.cod_cliente=cli.cod_cliente) ";
		$sql.=" LEFT JOIN cuentas  on (cli.cod_cuenta=cuentas.cod_cuenta) ";
		$sql.=" where cli.cod_cliente<>0 ";
		if($_GET['clienteContactoB']<>""){
			$sql.=" and ( cli.nombre_cliente like '%".$_GET['clienteContactoB']."%' ";
			$sql.="  or cli.cod_cliente in( select cod_cliente from clientes_contactos  ";
			$sql.=" where CONCAT(nombre_contacto,ap_paterno_contacto,ap_materno_contacto)like '%".$_GET['clienteContactoB']."%')) ";	
		}
		if($_GET['codcuentaB']=="true"){
			$sql.=" and  (cli.cod_cuenta IS NULL or cli.cod_cuenta='') ";
		}
		if($_GET['numero_cuentaB']=="true"){
			$sql.=" and (cuentas.nro_cuenta like '%".$_GET['numero_cuentaB']."%' OR cuentas.desc_cuenta like '%".$_GET['numero_cuentaB']."%') ";
		}
		if($_GET['operador']<>0 and $_GET['nroDocB']<>'' ){
			if($_GET['operador']==1){
				$sql.=" and ((clientesVal.nroVTA+clientesVal.nroHR+clientesVal.nroOT)=".$_GET['nroDocB'].") ";
			}
			if($_GET['operador']==2){
				$sql.=" and ((clientesVal.nroVTA+clientesVal.nroHR+clientesVal.nroOT)>".$_GET['nroDocB'].") ";
			}
			if($_GET['operador']==3){
				$sql.=" and ((clientesVal.nroVTA+clientesVal.nroHR+clientesVal.nroOT)".$_GET['nroDocB'].") ";
			}
		}
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
		/*select *
FROM(select cod_cliente,SUM(nroHR) as nroHR,SUM(nroOT) as nroOT,SUM(nroVTA) as nroVTA 
from (select c.cod_cliente,count(*) as nroHR, 0 as nroOT, 0 as nroVTA
from  hojas_rutas hr inner join cotizaciones c 
ON( hr.cod_cotizacion=c.cod_cotizacion and  hr.cod_estado_hoja_ruta<>2)
group by c.cod_cliente
UNION
select cod_cliente, 0 as nroHR, COUNT(*) as nroOT, 0 as nroVTA
from ordentrabajo where cod_est_ot<>2
group by cod_cliente
UNION
select cod_cliente_venta as cod_cliente, 0 as nroHR, 0 as nroOT, COUNT(*) as nroVTA
from  salidas where cod_tipo_salida=1  and cod_estado_salida<>2
group by cod_cliente) as clientesValidos
GROUP BY cod_cliente) as clientesVal  INNER join clientes cli ON(clientesVal.cod_cliente=cli.cod_cliente)
LEFT JOIN cuentas  on (cli.cod_cuenta=cuentas.cod_cuenta)
where cli.cod_cliente<>0
and( cli.nombre_cliente like '%%'
 or cli.cod_cliente in( select cod_cliente from clientes_contactos where CONCAT(nombre_contacto,ap_paterno_contacto,ap_materno_contacto)like '%%'))
and (cuentas.nro_cuenta like '%%' OR cuentas.desc_cuenta like '%%')
and ((clientesVal.nroVTA+clientesVal.nroHR+clientesVal.nroOT)>0)
and  (cli.cod_cuenta IS NULL or cli.cod_cuenta='')
and( cli.nombre_cliente like '%%'
 or cli.cod_cliente in( select cod_cliente from clientes_contactos where CONCAT(nombre_contacto,ap_paterno_contacto,ap_materno_contacto)like '%%'))
and (cuentas.nro_cuenta like '%%' OR cuentas.desc_cuenta like '%%')
and ((clientesVal.nroVTA+clientesVal.nroHR+clientesVal.nroOT)>0)
and  (cli.cod_cuenta IS NULL or cli.cod_cuenta='')*/
		
		$sql=" select cli.cod_cliente, cli.nombre_cliente, ";
		$sql.=" cli.nit_cliente, cli.cod_categoria, cli.cod_ciudad,  ";
		$sql.=" cli.direccion_cliente, cli.telefono_cliente, cli.celular_cliente, cli.fax_cliente, ";
		$sql.=" cli.email_cliente, cli.obs_cliente, cli.cod_usuario_registro, ";
		$sql.=" cli.fecha_registro, cli.cod_usuario_modifica, cli.fecha_modifica, ";
		$sql.=" cli.cod_estado_registro, cli.cod_usuario_comision, cli.cod_cuenta,cuentas.nro_cuenta,cuentas.desc_cuenta,";
		$sql.=" clientesVal.nroVTA, clientesVal.nroHR, clientesVal.nroOT, ";
		$sql.=" (clientesVal.nroVTA+clientesVal.nroHR+clientesVal.nroOT) as nroDoc";
		$sql.=" FROM(select cod_cliente,SUM(nroHR) as nroHR,SUM(nroOT) as nroOT,SUM(nroVTA) as nroVTA ";
		$sql.=" from (select c.cod_cliente,count(*) as nroHR, 0 as nroOT, 0 as nroVTA ";
		$sql.=" from  hojas_rutas hr inner join cotizaciones c ";
		$sql.=" ON( hr.cod_cotizacion=c.cod_cotizacion and  hr.cod_estado_hoja_ruta<>2)";
		$sql.=" group by c.cod_cliente ";
		$sql.=" UNION ";
		$sql.=" select cod_cliente, 0 as nroHR, COUNT(*) as nroOT, 0 as nroVTA";
		$sql.=" from ordentrabajo where cod_est_ot<>2 ";
		$sql.=" group by cod_cliente ";
		$sql.=" UNION ";
		$sql.=" select cod_cliente_venta as cod_cliente, 0 as nroHR, 0 as nroOT, COUNT(*) as nroVTA";
		$sql.=" from  salidas where cod_tipo_salida=1  and cod_estado_salida<>2 ";
		$sql.=" group by cod_cliente) as clientesValidos ";
		$sql.=" GROUP BY cod_cliente) as clientesVal  INNER join clientes cli ON(clientesVal.cod_cliente=cli.cod_cliente) ";
		$sql.=" LEFT JOIN cuentas  on (cli.cod_cuenta=cuentas.cod_cuenta) ";
		$sql.=" where cli.cod_cliente<>0 ";
		if($_GET['clienteContactoB']<>""){
			$sql.=" and ( cli.nombre_cliente like '%".$_GET['clienteContactoB']."%' ";
			$sql.="  or cli.cod_cliente in( select cod_cliente from clientes_contactos  ";
			$sql.=" where CONCAT(nombre_contacto,ap_paterno_contacto,ap_materno_contacto)like '%".$_GET['clienteContactoB']."%')) ";	
		}
		if($_GET['codcuentaB']=="true"){
			$sql.=" and  (cli.cod_cuenta IS NULL or cli.cod_cuenta='') ";
		}
		if($_GET['numero_cuentaB']=="true"){
			$sql.=" and (cuentas.nro_cuenta like '%".$_GET['numero_cuentaB']."%' OR cuentas.desc_cuenta like '%".$_GET['numero_cuentaB']."%') ";
		}
		if($_GET['operador']<>0 and $_GET['nroDocB']<>'' ){
			$sql.=" and ((clientesVal.nroVTA+clientesVal.nroHR+clientesVal.nroOT)".$_GET['operador']."".$_GET['nroDocB'].") ";
		}
		$sql.=" order by cli.nombre_cliente asc";
		$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;				
		$resp = mysql_query($sql);

?>	
<h3 align="center" style="background:#FFF;font-size: 10px;color: #000;font-weight:bold;">Nro de Registros:<?php echo $nro_filas_sql;?></h3>
<table border="0" align="center" >
<tr>

<td bgcolor="#FFFF66">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td ><strong>Alerta: Clientes no Vinculados con una Cuenta</strong></td>
</tr>
</table>
	<table width="89%" align="center" cellpadding="1" cellspacing="1" bgColor="#CCCCCC">
    <tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="14">
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
			<td>Nro Cuenta</td>
			<td>Nombre Cuenta</td>
            <td>Cliente</td>
            <td>Nit</td>
            <td>Direccion</td>
            <td>Telf/Celular/fax</td>
            <td >Contactos</td>
            <td>Unidades</td> 
			<td>HR</td> 
			<td>OT</td> 
			<td>VTA</td>
			<td>TOTAL DOC.</td> 
			<td>&nbsp;</td>            															
		</tr>

<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){	
			$cod_cliente=$dat['cod_cliente'];
			$nombre_cliente=$dat['nombre_cliente'];
			$nit_cliente=$dat['nit_cliente'];
			$cod_categoria=$dat['cod_categoria'];
			$cod_ciudad=$dat['cod_ciudad'];
			$direccion_cliente=$dat['direccion_cliente'];
			$telefono_cliente=$dat['telefono_cliente'];
			$celular_cliente=$dat['celular_cliente'];
			$fax_cliente=$dat['fax_cliente'];
			$email_cliente=$dat['email_cliente'];
			$obs_cliente=$dat['obs_cliente'];
			$cod_usuario_registro=$dat['cod_usuario_registro'];
			$fecha_registro=$dat['fecha_registro'];
			$cod_usuario_modifica=$dat['cod_usuario_modifica'];
			$fecha_modifica=$dat['fecha_modifica'];
			$cod_estado_registro=$dat['cod_estado_registro'];
			$cod_usuario_comision=$dat['cod_usuario_comision'];
			$cod_cuenta=$dat['cod_cuenta'];
			$nro_cuenta=$dat['nro_cuenta'];
			$desc_cuenta=$dat['desc_cuenta'];
			$nroVTA=$dat['nroVTA'];
			$nroHR=$dat['nroHR'];
			$nroOT=$dat['nroOT'];
			$nroDoc=$dat['nroDoc'];

			
					$desc_categoria="";				
					$sql2="select desc_categoria from clientes_categorias where cod_categoria='".$cod_categoria."'";	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$desc_categoria=$dat2[0];
					}	

				$desc_ciudad="";
				$sql2="select desc_ciudad from ciudades where cod_ciudad='".$cod_ciudad."'";
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$desc_ciudad=$dat2[0];
				}					

					$nombre_estado_registro="";				
					$sql2="select nombre_estado_registro from estados_referenciales";
					$sql2.=" where cod_estado_registro='".$cod_estado_registro."'";	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_estado_registro=$dat2[0];
					}	

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

		<tr bgcolor="<?php if($cod_cuenta==null or $cod_cuenta=="" ){ echo '#FFFF66';}else{echo '#FFFFFF';}?>" class="text" >	
			<td><?php echo $cod_cliente;?></td>		
			<td><?php echo $nro_cuenta;?></td>	
			<td><?php echo $desc_cuenta;?></td>				
    		<td><?php echo $nombre_cliente;?></td>
    		<td><?php echo $nit_cliente;?></td>
    		<td><?php echo $direccion_cliente;?></td>
    		<td><?php echo $telefono_cliente." ".$celular_cliente." ".$fax_cliente;?></td>
<td  align="center"><?php
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
			<div align="justify"><?php  echo "*".$nombre_contacto." ".$ap_paterno_contacto." ".$cargo_contacto." ".$telefono_contacto." ".$celular_contacto; ?></div>
			<?php

			}
?></td>            
<td align="center"><?php

				$sqlAux2="select nombre_unidad, telf_unidad from clientes_unidades";
					$sqlAux2.=" where cod_cliente='".$cod_cliente."'";	
					$sqlAux2.=" order by nombre_unidad asc";
					$respAux2= mysql_query($sqlAux2);
					while($datAux2=mysql_fetch_array($respAux2)){
						$nombre_unidad=$datAux2['nombre_unidad'];
						$telf_unidad=$datAux2['telf_unidad'];
						echo "<br/>".$nombre_unidad;
					}
				
				?>
				
		  </td>
				<td><?php echo $nroHR;?></td> 
				<td><?php echo $nroOT;?></td> 
				<td><?php echo $nroVTA;?></td> 
				<td bgcolor="#FFCCFF"><?php echo $nroDoc;?></td> 
            <td><a href="vincularClienteCuenta.php?cod_cliente=<?php echo $cod_cliente;?>" class="link_color1" title="EDITAR">Editar </a></td>

        </tr>
<?php
		 } 
?>			
	<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="14">
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