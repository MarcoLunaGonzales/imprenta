<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Proveedores</title>
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
		param+='proveedorContactoB='+document.form1.proveedorContactoB.value;
		param+='&nro_filas_show=0';	
		
		divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchProveedores.php'+param);
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
		param+='proveedorContactoB='+document.form1.proveedorContactoB.value;
		param+='&nro_filas_show='+document.form1.nro_filas_show.value;
		param+='&pagina='+document.form1.pagina1.value;
	
		divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchProveedores.php'+param);
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
		param+='proveedorContactoB='+document.form1.proveedorContactoB.value;
		param+='&nro_filas_show='+document.form1.nro_filas_show.value;
		param+='&pagina='+document.form1.pagina1.value;
	
		divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchProveedores.php'+param);
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
		param+='proveedorContactoB='+document.form1.proveedorContactoB.value;
		param+='&nro_filas_show='+document.form1.nro_filas_show.value;
		param+='&pagina='+document.form1.pagina2.value;
	
			divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchProveedores.php'+param);
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
function editar(cliente){

		izquierda = (screen.width) ? (screen.width-600)/2 : 100;

	    arriba = (screen.height) ? (screen.height-400)/2 : 100;

		
		url="editarCliente.php?cod_cliente="+cliente;

		opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=400,left='+izquierda+',top=' + arriba + '';

	   	window.open(url, 'popUp', opciones);
}

</script>

</head>
<body  bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">LISTADO DE PROVEEDORES
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
	
		$sql=" select count(*) ";
		$sql.=" from proveedores";
		if($_GET['proveedorContactoB']<>""){
		$sql.=" where nombre_proveedor like'%".$_GET['proveedorContactoB']."%' ";
		$sql.=" or cod_proveedor in(select cod_proveedor from proveedores_contactos ";
		$sql.=" where CONCAT(nombre_contacto,ap_paterno_contacto,ap_materno_contacto)like '%".$_GET['proveedorContactoB']."%')";
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
		$sql=" select cod_proveedor, nombre_proveedor, nit_proveedor, mail_proveedor, telefono_proveedor, celular_proveedor, ";
		$sql.=" fax_proveedor, direccion_proveedor, cod_ciudad, contacto1_proveedor, cel_contacto1_proveedor,";
		$sql.=" contacto2_proveedor, cel_contacto2_proveedor, cod_estado_registro, cod_usuario_registro, fecha_registro, ";
		$sql.=" cod_usuario_registro, fecha_modifica, cod_usuario_modifica";
		$sql.=" from proveedores";
		if($_GET['proveedorContactoB']<>""){
		$sql.=" where nombre_proveedor like'%".$_GET['proveedorContactoB']."%' ";
		$sql.=" or cod_proveedor in(select cod_proveedor from proveedores_contactos ";
		$sql.=" where CONCAT(nombre_contacto,ap_paterno_contacto,ap_materno_contacto)like '%".$_GET['proveedorContactoB']."%')";
		}
		$sql.=" order by nombre_proveedor asc";
		$sql.=" limit 50";

		$resp = mysql_query($sql);

?>	
	<table width="89%" align="center" cellpadding="1" cellspacing="1" bgColor="#CCCCCC" class="tablaReporte" style="width:100% !important;">
    
	<thead>		
	    <tr height="20px" align="center"  class="bg-success text-white">
    		<th>ID</th>
            <th>Proveedor</th>
            <th>Nit</th>
            <th>Ciudad</th>            
            <th>Direccion</th>
            <th>Telf/Celular/Fax</th>
            <th>**Contactos**</th>
            <th colspan="3">Contactos</th>
            <th colspan="2">&nbsp;</th>           															
		</tr>
		</thead>
       <tbody>
<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){	
		
				$cod_proveedor=$dat['cod_proveedor'];
				$nombre_proveedor=$dat['nombre_proveedor'];
				$nit_proveedor=$dat['nit_proveedor'];
				$mail_proveedor=$dat['mail_proveedor'];
				$telefono_proveedor=$dat['telefono_proveedor'];
				$celular_proveedor=$dat['celular_proveedor'];
				$fax_proveedor=$dat['fax_proveedor'];
				$direccion_proveedor=$dat['direccion_proveedor'];
				$cod_ciudad=$dat['cod_ciudad'];
				$contacto1_proveedor=$dat['contacto1_proveedor']; 
				$cel_contacto1_proveedor=$dat['cel_contacto1_proveedor'];
				$contacto2_proveedor=$dat['contacto2_proveedor'];
				$cel_contacto2_proveedor=$dat['cel_contacto2_proveedor'];
				$cod_estado_registro=$dat['cod_estado_registro'];
				$cod_usuario_registro=$dat['cod_usuario_registro'];
				$fecha_registro=$dat['fecha_registro'];
				$cod_usuario_registro=$dat['cod_usuario_registro'];
				$fecha_modifica=$dat['fecha_modifica'];
				$cod_usuario_modifica=$dat['cod_usuario_modifica'];
		
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
				//**************************************************************
					$nroContactos=0;							
					$sql2="select count(*) from proveedores_contactos";
					$sql2.=" where cod_proveedor='".$cod_proveedor."'";	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nroContactos=$dat2[0];
					}	
				
?> 

		<tr bgcolor="#FFFFFF" class="text">	
				<td><?php echo $cod_proveedor;?></td>		
    		<td><?php echo $nombre_proveedor;?></td>    		
            <td><?php echo $nit_proveedor;?></td>
            <td><?php echo $desc_ciudad;?></td>
    		<td><?php echo $direccion_proveedor;?></td>
    		<td><?php echo $telefono_proveedor." ".$celular_proveedor." ".$fax_proveedor;?></td>
            <td><?php 
				if($contacto1_proveedor<>"" or $cel_contacto1_proveedor){
					echo $contacto1_proveedor." ".$cel_contacto1_proveedor."<br/>";
				}
				if($contacto2_proveedor<>"" or $cel_contacto2_proveedor){
					echo $contacto2_proveedor." ".$cel_contacto2_proveedor;
				
				}				
			?>
               </td>
<td  align="center" colspan="3"><a href="listContactosProveedor.php?cod_proveedor=<?php echo $cod_proveedor;?>"><br/>
[Administrar Contactos (<?php echo $nroContactos;?>)]</a></td>          

            <td><a href="editarProveedor.php?cod_proveedor=<?php echo $cod_proveedor;?>" class="link_color1" title="EDICION DE PROVEEDOR">
            	<i class="fa fa-edit text-success"></i></a></td>
            <td><a href="listaEliminarProveedores.php?cod_proveedor=<?php echo $cod_proveedor;?>" class="link_color1">
                <i class="fa fa-trash text-danger"></i></a></td> 

         </tr>



				<?php
	          	$sqlAux=" select cod_contacto_proveedor,nombre_contacto, ap_paterno_contacto, ap_materno_contacto, cargo_contacto,";
				$sqlAux.=" telefono_contacto, celular_contacto";
				$sqlAux.=" from proveedores_contactos ";
				$sqlAux.=" where cod_proveedor=".$cod_proveedor;
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
				?>
                <tr class="text" bgcolor="#FFFFFF">
                <td colspan="6">&nbsp;</td>
                <td><?php echo $ap_paterno_contacto." ".$nombre_contacto;?></td>
                <td><?php echo $cargo_contacto;?></td>
                <td><?php echo $telefono_contacto." ".$celular_contacto;?></td>
                <td colspan="5">&nbsp;</td>                                                                    
                </tr>
                <?php
				}					
			?>
           
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
<td><strong>Buscar por Proveedor o Contacto</strong></td>
<td><input type="text" name="proveedorContactoB" id="proveedorContactoB" size="60" class="textoform"  onkeyup="buscar()" ></td>
</tr>
</table>
<table border="0" align="center" width="89%">
<tr><td align="right">
<div align="right"><a href="registrarProveedor.php">[Click Nuevo Proveedor]</a></div>
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
