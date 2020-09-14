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

function resultados_ajax(datos){
	divResultado = document.getElementById('resultados');
	ajax=objetoAjax();
	ajax.open("GET", datos);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			divResultado.innerHTML = ajax.responseText
		}
	}
	ajax.send(null)
}

function buscar()
{	

	resultados_ajax('searchTipoCambio.php?cod_monedaB='+document.form1.cod_monedaB.value);

}
function paginar(f)
{	

	location.href='listTipoCambio.php?cod_monedaB='+document.form1.cod_monedaB.value+'&pagina='+document.form1.pagina.value;
}
function paginar1(f,pagina)
{		

	location.href='listTipoCambio.php?cod_monedaB='+document.form1.cod_monedaB.value+'&pagina='+document.form1.pagina.value;	
}



</script></head>
<body bgcolor="#FFFFFF" onload="document.form1.cod_monedaB.focus()" >
<!---Autor:Gabriela Quelali Si�ani
02 de Julio de 2008
-->

<h3 align="center" style="background:#FFFFFF;font-size: 14px;color: #E78611;font-weight:bold;">TIPO DE CAMBIO</h3>
<form name="form1" id="form1" method="post" >
<?php
	$cod_monedaB=$_GET['cod_monedaB'];
?>
<br/>

    <table width="323" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr class="texto">
          <td width="120" align="right" class="al_derecha">Buscar por Moneda</td>
          <td width="256" align="left">
          <select name="cod_monedaB" id="cod_monedaB" class="textoform">
          <option value="0">Seleccione una opci&oacute;n</option>	
	   <?php
					$sql2=" select cod_moneda, desc_moneda, abrev_moneda";
					$sql2.=" from   monedas ";
					$sql2.=" where  cod_moneda<>1";
					$sql2.=" order by desc_moneda asc ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_moneda=$dat2['cod_moneda'];	
			  		 		$desc_moneda=$dat2['desc_moneda'];
							$abrev_moneda=$dat2['abrev_moneda'];	
				 ?>
                 <option value="<?php echo $cod_moneda;?>" <?php if($cod_moneda==$cod_monedaB){?> selected="true" <?php }?>><?php echo $desc_moneda; ?></option>				
				<?php		
					}
				?>						
			</select></td>
          </tr>
    </table>

<br/>
 <div id="resultados" align="center">   
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
	$sql.=" from tipo_cambio tc, monedas m ";
	$sql.=" where tc.cod_moneda=m.cod_moneda ";
	if($cod_monedaB<>0){
	$sql.=" and tc.cod_moneda=".$cod_monedaB;
	}
	$sql.=" order by tc.fecha_tipo_cambio ";
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
		$nro_filas_sql=$dat[0];
	}
?>
	<div id="nroRows" align="center" class="textoform"><?php echo "Nro. de Registros: ".$nro_filas_sql; ?></div>
    <br/>
<?php
	if($nro_filas_sql==0){
?>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
            <td>Fecha</td>
			<td>Moneda</td>				
    		<td>Cambio Bs</td>															
		</tr>
		<tr><th colspan="3" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
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
		$sql=" select tc.fecha_tipo_cambio, tc.cod_moneda, m.desc_moneda, tc.cambio_bs ";
		$sql.=" from tipo_cambio tc, monedas m ";
		$sql.=" where tc.cod_moneda=m.cod_moneda ";
		if($cod_monedaB<>0){
			$sql.=" and tc.cod_moneda=".$cod_monedaB;
		}		
		$sql.=" order by tc.fecha_tipo_cambio desc ";
		$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		$resp = mysql_query($sql);

?>	

	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="4">
						<p align="center">						
						<b><?php if($pagina>1){ ?>
							<a href="#" onclick="paginar1(form1,<?php echo $pagina-1; ?>)"><--Anterior</a>
							<?php }?>
						</b>
						<b> Pagina <?php echo $pagina; ?> de <?php echo $nropaginas; ?> </b>
						<b><?php if($nropaginas>$pagina){ ?> 
							<a href="#" onclick="paginar1(form1,<?php echo $pagina+1; ?>)">Siguiente--></a>
						<?php }?></b>
						</p>
						
</td>
			</tr>     
	    <tr height="20px" align="center"  class="titulo_tabla">
            <td>Fecha</td>
			<td>Moneda</td>				
    		<td>Cambio Bs</td>		
          <td>&nbsp;</td>																		
		</tr>

<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){
		
				$cod_gasto=$dat['cod_gasto'];
				$fecha_tipo_cambio=$dat['fecha_tipo_cambio'];
				$cod_moneda=$dat['cod_moneda'];
				$desc_moneda=$dat['desc_moneda'];
				$cambio_bs=$dat['cambio_bs']; 

?> 
		<tr bgcolor="#FFFFFF">	
    		<td align="left"><?php echo strftime("%d/%m/%Y",strtotime($fecha_tipo_cambio));?></td>
    		<td><?php echo $desc_moneda;?></td>
    		<td><?php echo $cambio_bs; ?></td>
            <td><a href="editTipoCambio.php?fecha_tipo_cambio=<?php echo $fecha_tipo_cambio;?>&cod_moneda=<?php echo $cod_moneda;?>">Editar</a></td>
		
   	  </tr>
<?php
		 } 
?>		
  			<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="4">
						<p align="center">						
						<b><?php if($pagina>1){ ?>
							<a href="#" onclick="paginar1(form1,<?php echo $pagina-1; ?>)"><--Anterior</a>
							<?php }?>
						</b>
						<b> Pagina <?php echo $pagina; ?> de <?php echo $nropaginas; ?> </b>
						<b><?php if($nropaginas>$pagina){ ?> 
							<a href="#" onclick="paginar1(form1,<?php echo $pagina+1; ?>)">Siguiente--></a>
						<?php }?></b>
						</p>
						<p align="center">				
						Ir a Pagina<input type="text" name="pagina" size="5"><input  type="button" size="8"  value="Go" onClick="paginar(this.form)">	
</td>
			</tr>	
  </table>
		</div>			
<?php
	}
?>
</div>	
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>