<?php 
	require("conexion.inc");
	include("funciones.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>INVENTA</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function cancelar(f){
			window.location="listGastoHojaRuta.php?cod_hoja_ruta="+f.cod_hoja_ruta.value;
	}
	function guardar(f){
			if(f.monto_gasto.value==""){
			alert("El campo Monto se encuentra vacio.")
			f.monto_gasto.focus();
		 	return(false);
			
		}
		f.submit();
	}
	
	function cancelar(){
			window.location="listHojasRutas.php";
	}
function nuevoAjax()
{	var xmlhttp=false;
 		try {
 			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	 	} catch (e) {
 			try {
 				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
 			} catch (E) {
 				xmlhttp = false;
 			}
	  	}
		if (!xmlhttp && typeof XMLHttpRequest!="undefined") {
 			xmlhttp = new XMLHttpRequest();
		}
		return xmlhttp;
}
function cargar_proveedor_ajax(url)
{	var div_proveedor;
		div_proveedor=document.getElementById("div_proveedor");
		ajax=nuevoAjax();
		ajax.open("GET", url,true);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4) {
			div_proveedor.innerHTML=ajax.responseText;
			}
		}
		ajax.send(null)
}	
function cargar_proveedor()
{			
		izquierda = (screen.width) ? (screen.width-600)/2 : 100 
	    arriba = (screen.height) ? (screen.height-400)/2 : 100 
		url="registrarProveedorAjax.php";
		opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=650,left='+izquierda+',top=' + arriba + '' 
	   	window.open(url, 'popUp', opciones);
}	
function datosProveedor(f)
{	 

		var cod_proveedor=document.getElementById("cod_proveedor").value;
		cod_proveedor=cod_proveedor*1;
		if(cod_proveedor!=0){
		
			izquierda = (screen.width) ? (screen.width-600)/2 : 100 
		    arriba = (screen.height) ? (screen.height-400)/2 : 100 
			url="datosProveedorAjax.php?cod_proveedor="+cod_proveedor;
			opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=650,left='+izquierda+',top=' + arriba + '' 
		   	window.open(url, 'popUp', opciones)
			
		}else{
			alert("Seleccione un Proveedor");
			
		}
}	


</script></head>
<body bgcolor="#F7F5F3" onload="document.form1.recibo_gasto.focus()">
<!---Autor:Gabriela Quelali Si�ani
02 de Julio de 2008
-->


<form name="form1" id="form1" method="post" action="saveGastoHojaRuta.php">
<?php
 $cod_hoja_ruta=$_POST['cod_hoja_ruta'];
 ?>
 <input type="hidden" name="cod_hoja_ruta" id="cod_hoja_ruta" value="<?php echo $cod_hoja_ruta;?>">
 <?php
 $sql=" select hr.nro_hoja_ruta, hr.cod_gestion, g.gestion, hr.cod_cotizacion, ";
 $sql.=" c.cod_cliente, cli.nombre_cliente ";
 $sql.=" from hojas_rutas hr, gestiones g, cotizaciones c, clientes cli ";
 $sql.=" where hr.cod_gestion=g.cod_gestion ";
 $sql.=" and  hr.cod_cotizacion=c.cod_cotizacion ";
 $sql.=" and c.cod_cliente=cli.cod_cliente ";
 $sql.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
 $resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$nro_hoja_ruta=$dat['nro_hoja_ruta'];
		$cod_gestion=$dat['cod_gestion'];
		$gestion=$dat['gestion'];
		$cod_cotizacion=$dat[''];
		$cod_cotizacion=$dat['cod_cotizacion'];
		$cod_cliente=$dat['cod_cliente'];
		$nombre_cliente=$dat['nombre_cliente'];
	} 
?>
<h3 align="center" style="background:#F7F5F3;font-size: 14px;color: #E78611;font-weight:bold;">GASTOS DE HOJA DE RUTA <?php echo "Nro. ".$nro_hoja_ruta."/".$gestion; ?></br> CLIENTE: <?php echo $nombre_cliente;?></h3>
<div align="center"><a href="../reportes/impresionHojaRuta.php?cod_hoja_ruta=<?php echo $_POST['cod_hoja_ruta']; ?>" target="_blank">VER HOJA RUTA</a></div>

 <div id="resultados" align="center">   

    <table align="center"class="text" cellSpacing="1" cellPadding="4" width="70%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Introduzca Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td align="left">Nro Recibo</td>
      		<td align="left"><input type="text"  class="textoform" size="50" name="recibo_gasto" id="recibo_gasto"  ></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha de Gasto</td>
      		<td align="left"><input type="text"  class="textoform" size="50" name="fecha_gasto" id="fecha_gasto" value="<?php echo date('d/m/Y', time());?>" /></td>
    	</tr>        
		 <tr bgcolor="#FFFFFF">
     		<td>Proveedor</td>
      		<td align="left">
            <div id="div_proveedor">
            <select class="textoform" name="cod_proveedor" id="cod_proveedor">
            <?php
            	$sql2="select cod_proveedor, nombre_proveedor";
            	$sql2.=" from proveedores ";
            	$sql2.=" order by nombre_proveedor asc ";
				$resp2 = mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$cod_proveedor=$dat2['cod_proveedor'];
					$nombre_proveedor=$dat2['nombre_proveedor'];
			?>
            	<option value="<?php echo $cod_proveedor;?>"><?php echo $nombre_proveedor; ?></option>
            <?php
				}				

			?>
            </select> <a  href="javascript:cargar_proveedor();">[ Nuevo Proveedor]</a>
			&nbsp;<a  href="javascript:datosProveedor(this.form);">[Editar Datos de Proveedor]</a></div>
            </td>
    	</tr>     
		<tr bgcolor="#FFFFFF">
     		<td>Gasto</td>
      		<td align="left"><select class="textoform" name="cod_gasto" id="cod_gasto">
            <?php
            	$sql2="select cod_gasto, desc_gasto";
            	$sql2.=" from gastos ";
            	$sql2.=" order by desc_gasto asc ";
				$resp2 = mysql_query($sql2);
				while($dat2=mysql_fetch_array($resp2)){
					$cod_gasto=$dat2['cod_gasto'];
					$desc_gasto=$dat2['desc_gasto'];
			?>
            	<option value="<?php echo $cod_gasto;?>"><?php echo $desc_gasto; ?></option>
            <?php
				}				

			?>
            </select></td>
    	</tr>		
		 <tr bgcolor="#FFFFFF">
     		<td>Descripcion</td>
      		<td align="left"><input type="text"  class="textoform" size="50" name="descripcion_gasto"  id="descripcion_gasto"/></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Cantidad</td>
      		<td align="left"><input type="text"  class="textoform" size="50" name="cant_gasto"  id="cant_gasto"/></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Monto</td>
      		<td align="left"><input type="text"  class="textoform" size="50" name="monto_gasto" id="monto_gasto" /></td>
    	</tr>                 										
		</tbody>
	</table>
 </div>			

</div>	
	<br>
<div align="center">
<INPUT type="button"  class="boton"  name="btn_atras" value="IR  ATRAS" onClick="cancelar(this.form);"  >
<INPUT type="button" class="boton" name="btn_guardar" onclick="guardar(this.form)" value="GUARDAR"  >

</div>
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
