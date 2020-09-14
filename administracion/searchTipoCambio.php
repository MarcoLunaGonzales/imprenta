<?php
header('Content-Type: text/html; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';

//coneccion a la Base de Datos
require("conexion.inc");
include("funciones.php");

$cod_monedaB=$_GET['cod_monedaB'];

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
</body>
</html>