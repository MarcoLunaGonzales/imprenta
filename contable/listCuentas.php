<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cuentas</title>
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
		param+='numero_cuentaB='+document.form1.numero_cuentaB.value;
		param+='&nro_filas_show='+document.form1.nro_filas_show.value;	
		
		divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchCuentas.php'+param);
			ajax.onreadystatechange=function() {
				if (ajax.readyState==4) {
					divResultado.innerHTML = ajax.responseText
				}
			}
				ajax.send(null)	

}


function paginar(f)
{	

		var param="?";
		param+='numero_cuentaB='+document.form1.numero_cuentaB.value;
		param+='&nro_filas_show='+document.form1.nro_filas_show.value;	
		param+='&pagina='+document.form1.pagina1.value;
	
		divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchCuentas.php'+param);
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
		param+='numero_cuentaB='+document.form1.numero_cuentaB.value;
		param+='&nro_filas_show='+document.form1.nro_filas_show.value;	
		param+='&pagina='+document.form1.pagina1.value;
	
		divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchCuentas.php'+param);
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
		param+='numero_cuentaB='+document.form1.numero_cuentaB.value;
		param+='&nro_filas_show='+document.form1.nro_filas_show.value;	
		param+='&pagina='+document.form1.pagina2.value;
	
			divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchCuentas.php'+param);
			ajax.onreadystatechange=function() {
				if (ajax.readyState==4) {
					divResultado.innerHTML = ajax.responseText
				}
			}
		ajax.send(null)
}

function registrar(f){
	f.submit();
}


</script>

</head>
<body  bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">LISTADO DE PLAN DE CUENTAS</h3>
<form name="form1" id="form1" method="post" >
<?php 
	require("conexion.inc");
	include("funciones.php");

?>

<table border="0" align="center">
<tr>
<td><strong>Buscar por Cuenta</strong></td>
<td colspan="3"><input type="text" name="numero_cuentaB" id="numero_cuentaB" size="60" class="textoform" value="<?php echo $numero_cuentaB;?>" onkeyup="buscar()" ></td>
</tr>
</table>
<table border="0" align="center" width="89%">
<tr><td align="right">
<div align="right"><a href="newCuenta.php"><img src="img/adicionar.jpg" border="0">[Adicionar Cuenta]</a></div>
</td>
</tr>
<tr><td align="right">
<div align="right"><a href="../reportes/pdfListCuentas.php" target="_blank">[Reporte de Cuentas]</a></div>
</td>
</tr>
</table>
<div align="center" class="text">Nro de Registros Mostrados por Pagina
  <select name="nro_filas_show" id="nro_filas_show" class="text" onchange="paginar1(this.form,1)" >
		<option value="20" <?php if($_GET['nro_filas_show']==20){ ?> selected="true"<?php }?> >20</option>
	    <option value="50" <?php if($_GET['nro_filas_show']==50){ ?> selected="true"<?php }?> >50</option>
    	<option value="100" <?php if($_GET['nro_filas_show']==100){ ?> selected="true"<?php }?> >100</option>
	    <option value="200" <?php if($_GET['nro_filas_show']==200){ ?> selected="true"<?php }?> >200</option>
    	<option value="300"<?php if($_GET['nro_filas_show']==300){ ?> selected="true"<?php }?> >300</option>
        <option value="400"<?php if($_GET['nro_filas_show']==400){ ?> selected="true"<?php }?> >400</option>
    </select>
</div>

<div id="resultados">


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

		$sql=" select count(*)  ";
		$sql.=" from cuentas ";
		if($_GET['numero_cuentaB']<>""){
			$sql.=" where (nro_cuenta like'%".$_GET['numero_cuentaB']."%' ";
			$sql.=" or desc_cuenta like'%".$_GET['numero_cuentaB']."%')";			
		}
		$resp_aux = mysql_query($sql);
		while($dat_aux=mysql_fetch_array($resp_aux)){
			$nro_filas_sql=$dat_aux[0];
		}		

		
		if($nro_filas_sql==0){
?>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>Nro Cuenta</td>
            <td>Descripcion</td>
    		<td>Moneda</td>
    		<td>Estado</td>
    		<td>Registro</td>
    		<td>Ultima Edici&oacute;n</td>									
		</tr>
		<tr><th colspan="9" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
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

		$sql=" select cod_cuenta, nro_cuenta, desc_cuenta, detalle_cuenta, cod_moneda, cod_cuenta_padre, ";
		$sql.=" cod_estado_registro, cod_usuario_registro, fecha_registro, cod_usuario_modifica, fecha_modifica ";
		$sql.=" from cuentas ";
		if($_GET['numero_cuentaB']<>""){
			$sql.=" where (nro_cuenta like'%".$_GET['numero_cuentaB']."%' ";
			$sql.=" or desc_cuenta like'%".$_GET['numero_cuentaB']."%')";			
		}
		$sql.=" order by nro_cuenta asc";
		$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;

		
		$resp = mysql_query($sql);

?>	
<h3 align="center" style="background:#FFF;font-size: 10px;color: #000;font-weight:bold;">Total Registro:<?php echo $nro_filas_sql;?></h3>
	<table width="95%" align="center" cellpadding="1" cellspacing="1" bgColor="#CCCCCC">
    <tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="12">
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
    		<td>Nro Cuenta</td>
            <td>Cuenta</td> 
			<td>Cliente</td> 
			<td>Proveedor</td>            
            <td>Detalle</td>
            <td>Vinculacion</td>
    		<td>Moneda</td>
    		<td>Estado</td>
    		<td>Registro</td>
    		<td>Ultima Edici&oacute;n</td>	
            <td>Editar</td>	
			<td>Eliminar</td>		                   																                   															
		</tr>

<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){	
				$cod_cuenta=$dat['cod_cuenta'];
				///
				
				$sql2=" select nombre_proveedor";
				$sql2.=" from proveedores";
				$sql2.=" where cod_cuenta=".$cod_cuenta;
				$nombre_proveedor="";
				$resp2 = mysql_query($sql2);	
				while($dat2=mysql_fetch_array($resp2)){			
						$nombre_proveedor=$dat2['nombre_proveedor'];			
				}
				$sql2=" select nombre_cliente";
				$sql2.=" from clientes";
				$sql2.=" where cod_cuenta=".$cod_cuenta;
				$nombre_cliente="";
				$resp2 = mysql_query($sql2);	
				while($dat2=mysql_fetch_array($resp2)){			
						$nombre_cliente=$dat2['nombre_cliente'];			
				}				

				$nro_cuenta=$dat['nro_cuenta'];
				$desc_cuenta=$dat['desc_cuenta'];
				$detalle_cuenta=$dat['detalle_cuenta'];
				$cod_moneda=$dat['cod_moneda'];
				$cod_cuenta_padre=$dat['cod_cuenta_padre'];
				$cod_estado_registro=$dat['cod_estado_registro'];
				$cod_usuario_registro=$dat['cod_usuario_registro'];
				$fecha_registro=$dat['fecha_registro'];
				$cod_usuario_modifica=$dat['cod_usuario_modifica'];
				$fecha_modifica=$dat['fecha_modifica'];
				$nro_cuenta_padre="";
				$desc_cuenta_padre="";
				if($cod_cuenta_padre!= NULL){
					$sql2=" select  nro_cuenta, desc_cuenta ";
					$sql2.=" from cuentas ";
					$sql2.=" where cod_cuenta=".$cod_cuenta_padre." ";
					$resp2 = mysql_query($sql2);	
					while($dat2=mysql_fetch_array($resp2)){
			
						$nro_cuenta_padre=$dat2['nro_cuenta'];
						$desc_cuenta_padre=$dat2['desc_cuenta'];			
					}
				}				
				//Obteniendo la descripcion de la Moneda
					$sql2="select desc_moneda from monedas where cod_moneda=".$cod_moneda;
					$resp2 = mysql_query($sql2);
					$desc_moneda="";
					while($dat2=mysql_fetch_array($resp2)){
						$desc_moneda=$dat2['desc_moneda'];
					}
				// Fin Obteniendo la descripcion de la Moneda
				//Obteniendo la descripcion del Estado de Registro
					$sql2="select nombre_estado_registro from estados_referenciales where cod_estado_registro=".$cod_estado_registro;
					$resp2 = mysql_query($sql2);
					$nombre_estado_registro="";
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_estado_registro=$dat2['nombre_estado_registro'];
					}
				// Fin Obteniendo la descripcion del Estado de Registro				
				
				//Obteniendo la descripcion del Estado de Registro
					$sql2="select nombre_estado_registro from estados_referenciales where cod_estado_registro=".$cod_estado_registro;
					$resp2 = mysql_query($sql2);
					$nombre_estado_registro="";
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_estado_registro=$dat2['nombre_estado_registro'];
					}
				// Fin Obteniendo la descripcion del Estado de Registro	
				//Obteniendo Fecha de Registro
					$usuario_registro="";
				if($cod_usuario_registro!=NULL){
					$sql2=" select nombres_usuario, nombres_usuario2, nombres_pila, ap_paterno_usuario, ap_materno_usuario ";
					$sql2.=" from usuarios where cod_usuario=".$cod_usuario_registro;
					$resp2 = mysql_query($sql2);
				
					while($dat2=mysql_fetch_array($resp2)){
						$nombres_usuario=$dat2['nombres_usuario'];
						$nombres_usuario2=$dat2['nombres_usuario2'];
						$nombres_pila=$dat2['nombres_pila'];
						$ap_paterno_usuario=$dat2['ap_paterno_usuario'];
						$ap_materno_usuario=$dat2['ap_materno_usuario'];
						$usuario_registro=$nombres_usuario[0].$ap_paterno_usuario[0].$ap_materno_usuario[0];
					}
					
						$usuario_registro=strftime("%d/%m/%Y %H:%M:%S",strtotime($fecha_registro))." ".$usuario_registro;
				}
				// Fin Obteniendo Fecha de Registro	
				//Obteniendo Fecha de Registro
					$usuario_modifica="";
				if($cod_usuario_modifica!=NULL){
					$sql2=" select nombres_usuario, nombres_usuario2, nombres_pila, ap_paterno_usuario, ap_materno_usuario ";
					$sql2.=" from usuarios where cod_usuario=".$cod_usuario_modifica;
					$resp2 = mysql_query($sql2);
				
					while($dat2=mysql_fetch_array($resp2)){
						$nombres_usuario=$dat2['nombres_usuario'];
						$nombres_usuario2=$dat2['nombres_usuario2'];
						$nombres_pila=$dat2['nombres_pila'];
						$ap_paterno_usuario=$dat2['ap_paterno_usuario'];
						$ap_materno_usuario=$dat2['ap_materno_usuario'];
						$usuario_modifica=$nombres_usuario[0].$ap_paterno_usuario[0].$ap_materno_usuario[0];
					}
					
						$usuario_modifica=strftime("%d/%m/%Y %H:%M:%S",strtotime($fecha_modifica))." ".$usuario_modifica;
					}
				// Fin Obteniendo Fecha de Registro					
?> 								
 

		<tr bgcolor="#FFFFFF" class="text">	
				<td align="left"><strong><?php echo $nro_cuenta;?></strong></td>
                <td align="left"><?php echo $desc_cuenta;?></td>
				 <td align="left"><?php echo $nombre_cliente;?></td>
				  <td align="left"><?php echo $nombre_proveedor;?></td>
                <td align="left"><?php echo $detalle_cuenta;?></td>
                <td align="left"><?php echo $nro_cuenta_padre." ".$desc_cuenta_padre;?></td>
                <td align="left"><?php echo $desc_moneda;?></td>
                <td align="left"><?php echo $nombre_estado_registro;?></td>
                <td align="left"><?php echo $usuario_registro;?></td>
                <td align="left"><?php echo $usuario_modifica;?></td>
                <td align="left"><a href="editCuenta.php?cod_cuenta=<?php echo $cod_cuenta;?>">Editar</a></td>    
				<td align="left">
				<?php 
					$sql3="select count(*) from cuentas where cod_cuenta_padre=".$cod_cuenta;
					$resp3 = mysql_query($sql3);
					$cont1=0;
					while($dat3=mysql_fetch_array($resp3)){
						$cont1=$dat3[0];
					}
					$sql3="select count(*) from clientes where cod_cuenta=".$cod_cuenta;
					$resp3 = mysql_query($sql3);
					$cont2=0;
					while($dat3=mysql_fetch_array($resp3)){
						$cont2=$dat3[0];
					}	
					$sql3="select count(*) from proveedores where cod_cuenta=".$cod_cuenta;
					$resp3 = mysql_query($sql3);
					$cont3=0;
					while($dat3=mysql_fetch_array($resp3)){
						$cont3=$dat3[0];
					}
					$sql3="select count(*) from comprobante_detalle where cod_cuenta=".$cod_cuenta;
					$resp3 = mysql_query($sql3);
					$cont4=0;
					while($dat3=mysql_fetch_array($resp3)){
						$cont4=$dat3[0];
					}															
					if($cont1==0 and $cont2==0 and $cont3==0 and $cont4==0){
				?>
					<a href="listaEliminarCuentas.php?cod_cuenta=<?php echo $cod_cuenta;?>">Eliminar</a>    
				<?php
					}else{
				?>
					<a href="listaEliminarCuentas.php?cod_cuenta=<?php echo $cod_cuenta;?>" style="color:#FF0000">Eliminar</a>   
				<?php
					}
				?>  
				</td>         
         </tr>

<?php
		 } 
?>			
	<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="12">
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
	
</div> 	
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
