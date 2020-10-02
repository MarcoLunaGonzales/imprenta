<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Clientes - Proveedores</title>
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
		param+='clienteProveedorB='+document.form1.clienteProveedorB.value;
		param+='&nro_filas_show=1';
		
		divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchClientesProveedores.php'+param);
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
		param+='clienteProveedorB='+document.form1.clienteProveedorB.value;
		param+='&nro_filas_show='+document.form1.nro_filas_show.value;
		param+='&pagina='+document.form1.pagina1.value;
	
		divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchClientesProveedores.php'+param);
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
		param+='clienteProveedorB='+document.form1.clienteProveedorB.value;
		param+='&nro_filas_show='+document.form1.nro_filas_show.value;
		param+='&pagina='+document.form1.pagina1.value;
	
		divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchClientesProveedores.php'+param);
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
		param+='clienteProveedorB='+document.form1.clienteProveedorB.value;
		param+='&nro_filas_show='+document.form1.nro_filas_show.value;
		param+='&pagina='+document.form1.pagina2.value;
	
			divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchClientesProveedores.php'+param);
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
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">LISTADO DE CLIENTES Y PROVEEDORES
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
		$sql.=" from clientes ";
		if($_GET['clienteProveedorB']<>""){
			$sql.=" where nombre_cliente like'%".$_GET['clienteProveedorB']."%' ";
			$sql.=" or cod_cliente in (select cod_cliente from clientes_contactos ";
			$sql.=" where CONCAT(nombre_contacto,ap_paterno_contacto,ap_materno_contacto)like'%".$_GET['clienteProveedorB']."%')";
		}
		$resp_aux = mysql_query($sql);
		while($dat_aux=mysql_fetch_array($resp_aux)){
			$nro_filas_sql_clientes=$dat_aux[0];
		}		
		$sql=" select count(*) ";
		$sql.=" from proveedores ";
		if($_GET['clienteProveedorB']<>""){
		$sql.=" where nombre_proveedor like'%".$_GET['clienteProveedorB']."%' ";
		$sql.=" or cod_proveedor in (select cod_proveedor from proveedores_contactos  ";
		$sql.=" where CONCAT(nombre_contacto,ap_paterno_contacto,ap_materno_contacto)like'%".$_GET['clienteProveedorB']."%') ";
		}
		$resp_aux = mysql_query($sql);
		while($dat_aux=mysql_fetch_array($resp_aux)){
			$nro_filas_sql_proveedores=$dat_aux[0];
		}
		$nro_filas_sql=$nro_filas_sql_clientes+$nro_filas_sql_proveedores;

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
		/*
		(select 1,cod_cliente as cod, nombre_cliente as nom,cod_ciudad as ciudad, direccion_cliente as direccion, 
telefono_cliente as telf, celular_cliente as cel, fax_cliente as fax, email_cliente as email  
from clientes where nombre_cliente like'%%' 
or cod_cliente in (select cod_cliente from clientes_contactos 
where CONCAT(nombre_contacto,ap_paterno_contacto,ap_materno_contacto)like'%%')
)
UNION 
(select 2, cod_proveedor as cod ,nombre_proveedor as nom, cod_ciudad as ciudad, direccion_proveedor as direccion, 
telefono_proveedor as telf,null as cel, null as fax, mail_proveedor as email 
from proveedores where nombre_proveedor like'%%'
or cod_proveedor in (select cod_proveedor from proveedores_contactos 
where CONCAT(nombre_contacto,ap_paterno_contacto,ap_materno_contacto)like'%%')
)
order BY  asc
		*/
		$sql=" (select 1,cod_cliente as cod, nombre_cliente as nom,cod_ciudad as ciudad, direccion_cliente as direccion, ";
		$sql.=" telefono_cliente as telf, celular_cliente as cel, fax_cliente as fax, email_cliente as email, cod_estado_registro,";
		$sql.=" fecha_registro, cod_usuario_registro, fecha_modifica, cod_usuario_modifica  ";
		$sql.=" from clientes ";
		if($_GET['clienteProveedorB']<>""){
		$sql.=" where nombre_cliente like'%".$_GET['clienteProveedorB']."%' ";
		$sql.=" or cod_cliente in (select cod_cliente from clientes_contactos ";
		$sql.=" where CONCAT(nombre_contacto,ap_paterno_contacto,ap_materno_contacto)like'%".$_GET['clienteProveedorB']."%')";
		}
		$sql.=" )";
		$sql.=" UNION ";
		$sql.=" (select 2,cod_proveedor as cod,nombre_proveedor as nom,cod_ciudad as ciudad,direccion_proveedor as direccion, ";
		$sql.=" telefono_proveedor as telf,null as cel, null as fax, mail_proveedor as email, cod_estado_registro,";
		$sql.=" fecha_registro, cod_usuario_registro, fecha_modifica, cod_usuario_modifica  ";
		$sql.=" from proveedores";
		if($_GET['clienteProveedorB']<>""){		
		$sql.=" where nombre_proveedor like'%".$_GET['clienteProveedorB']."%'";
		$sql.=" or cod_proveedor in (select cod_proveedor from proveedores_contactos ";
		$sql.=" where CONCAT(nombre_contacto,ap_paterno_contacto,ap_materno_contacto)like'%".$_GET['clienteProveedorB']."%')";
		}
		$sql.=" )";
		$sql.=" order BY nom  asc";
		$sql.=" limit 50";
		
		$resp = mysql_query($sql);

?>	
	<table width="100%" align="center" cellpadding="1" cellspacing="1" bgColor="#CCCCCC" class="tablaReporte" style="width:100% !important;">
 
	<thead>		  
	    <tr height="20px" align="center"  class="bg-success text-white">
    		<th>Tipo</th>
            <th>Nombre</th>
    		<th>Ciudad</th>
    		<th>Direccion</th>
    		<th>Telefono</th>
    		<th>Celular</th>
            <th>Fax</th>
            <th>Email</th>							
    		<th>Contactos</th>			
    		<th>Estado</th>	
    		<th>Registro</th>			
    		<th>Edicion</th>	                   															
		</tr>
	</thead>
   <tbody>
<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){	
				$tipo_desc="";
				$tipo=$dat[0];
				if($tipo==1){
					$tipo_desc="C";
				}
				if($tipo==2){
					$tipo_desc="P";
				}
				$codigo=$dat[1];
				$nombre=$dat[2];
				$ciudad=$dat[3];
				$desc_ciudad="";
				$sql2="select desc_ciudad from ciudades where cod_ciudad='".$ciudad."'";
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$desc_ciudad=$dat2[0];
				}	
				$direccion=$dat[4];
				$telf=$dat[5];
				$cel=$dat[6];
				$fax=$dat[7];
				$email=$dat[8];	
				$cod_estado_registro=$dat[9];
				$fecha_registro=$dat[10];	
				$cod_usuario_registro=$dat[11];	
				$fecha_modifica=$dat[12];	
				$cod_usuario_modifica=$dat[13];						
				$nombre_estado_registro="";
				$sql2="select nombre_estado_registro from estados_referenciales where cod_estado_registro='".$cod_estado_registro."'";
				$resp2= mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$nombre_estado_registro=$dat2[0];
				}		
///////////////////////Usuario Registro//////////////////////////
			  $usuario_registro="";
			  if($cod_usuario_registro<>"" && $cod_usuario_registro<>0){
				 $sqlAux="select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios where cod_usuario=".$cod_usuario_registro;
				 $respAux = mysql_query($sqlAux);
				 while($datAux=mysql_fetch_array($respAux)){
					 $usuario_registro=$datAux['nombres_usuario'][0].$datAux['ap_paterno_usuario'][0].$datAux['ap_materno_usuario'][0];
				 }
			 }			 
			///////////////////////Fin Usuario Registro/////////////////////
			///////////////////////Usuario Modifica//////////////////////////
			  $usuario_modifica="";
			  if($cod_usuario_modifica<>"" && $cod_usuario_modifica<>0){
				 $sqlAux="select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios where cod_usuario=".$cod_usuario_modifica;
				 $respAux = mysql_query($sqlAux);
				 while($datAux=mysql_fetch_array($respAux)){
					 $usuario_modifica=$datAux['nombres_usuario'][0].$datAux['ap_paterno_usuario'][0].$datAux['ap_materno_usuario'][0];
				 }
			 }			 
			///////////////////////Fin Usuario Modifica/////////////////////																				

				
?> 

		<tr bgcolor="#FFFFFF" class="text">	
				<td align="center"><strong><?php echo $tipo_desc;?></strong></td>
                <td align="left"><?php echo $nombre;?></td>
                <td align="left"><?php echo $desc_ciudad;?></td>
                <td align="left"><?php echo $direccion;?></td>
                <td align="left"><?php echo $telf;?></td>
                <td align="left"><?php echo $cel;?></td>
                <td align="left"><?php echo $fax;?></td>
                <td align="left"><?php echo $email;?></td>
                <td align="left">
                <?php 
				 if($tipo==1){
					$sqlAux=" select cod_contacto, nombre_contacto, ap_paterno_contacto, ap_materno_contacto, cargo_contacto,";
					$sqlAux.=" telefono_contacto, celular_contacto";
					$sqlAux.=" from clientes_contactos ";
					$sqlAux.=" where cod_cliente=".$codigo;
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
						if($cargo_contacto<>""){
							echo $nombre_contacto." ".$ap_paterno_contacto."(".$cargo_contacto.") ".$telefono_contacto." ".$celular_contacto."<br/>";			
						}else{
						echo $nombre_contacto." ".$ap_paterno_contacto." ".$telefono_contacto." ".$celular_contacto."<br/>";	
						}
					}
				}
				
				if($tipo==2){
				
					$sqlAux=" select contacto1_proveedor, cel_contacto1_proveedor, contacto2_proveedor, cel_contacto2_proveedor";
					$sqlAux.=" from proveedores ";
					$sqlAux.=" where cod_proveedor=".$codigo;
					$respAux= mysql_query($sqlAux);
					$contacto1_proveedor="";
					$cel_contacto1_proveedor="";
					$contacto2_proveedor=""; 
					$cel_contacto2_proveedor="";
					while($datAux=mysql_fetch_array($respAux)){
							$contacto1_proveedor=$datAux['contacto1_proveedor'];
							$cel_contacto1_proveedor=$datAux['cel_contacto1_proveedor'];
							$contacto2_proveedor=$datAux['contacto2_proveedor']; 
							$cel_contacto2_proveedor=$datAux['cel_contacto2_proveedor'];
					}					
					
					if($contacto1_proveedor<>"" or $cel_contacto1_proveedor<>"" ){
					?>
						<p style="background:#FFCCFF"><?php echo $contacto1_proveedor." ".$cel_contacto1_proveedor."<br/>";?></p>
					<?php
					}
					if($contacto2_proveedor<>"" or $cel_contacto2_proveedor<>""){
										?>
						<p style="background:#FFCCFF"><?php echo $contacto2_proveedor." ".$cel_contacto2_proveedor."<br/>";;?></p>
					<?php
						
					}
					$sqlAux=" select cod_contacto_proveedor, nombre_contacto, ap_paterno_contacto, ";
					$sqlAux.=" ap_materno_contacto, cargo_contacto,";
					$sqlAux.=" telefono_contacto, celular_contacto";
					$sqlAux.=" from proveedores_contactos ";
					$sqlAux.=" where cod_proveedor=".$codigo;
					$sqlAux.=" order by ap_paterno_contacto, ap_materno_contacto, nombre_contacto asc ";
					$respAux= mysql_query($sqlAux);
					while($datAux=mysql_fetch_array($respAux)){
						$cod_contacto_proveedor=$datAux['cod_contacto_proveedor'];
						$nombre_contacto=$datAux['nombre_contacto'];
						$ap_paterno_contacto=$datAux['ap_paterno_contacto'];
						$ap_materno_contacto=$datAux['ap_materno_contacto'];
						$cargo_contacto=$datAux['cargo_contacto'];
						$telefono_contacto=$datAux['telefono_contacto'];
						$celular_contacto=$datAux['celular_contacto'];
						if($cargo_contacto<>""){
							echo $nombre_contacto." ".$ap_paterno_contacto."(".$cargo_contacto.") ".$telefono_contacto." ".$celular_contacto."<br/>";			
						}else{
						echo $nombre_contacto." ".$ap_paterno_contacto." ".$telefono_contacto." ".$celular_contacto."<br/>";	
						}
					}
				}				
				?>
                
                </td>
                <td align="left"><?php echo $nombre_estado_registro;?></td>		
            <td align="left">
			<?php 
			if($fecha_registro<>""){
				echo strftime("%d/%m/%Y",strtotime($fecha_registro))." ".$usuario_registro;
			}

			?></td>
             <td align="right">
			 <?php 
			if($fecha_modifica<>""){
				echo strftime("%d/%m/%Y",strtotime($fecha_modifica))." ".$usuario_modifica;
			}

			?></td>
                
    		

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
<td><strong>Buscar por Cliente o Proveedor</strong></td>
<td colspan="3"><input type="text" name="clienteProveedorB" id="clienteProveedorB" size="60" class="textoform" value="<?php echo $clienteContactoB;?>" onkeyup="buscar()" ></td>
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
