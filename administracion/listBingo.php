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
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
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
	for (i=0;i<document.form1.codestotB.length;i++){ 
       if (document.form1.codestotB[i].checked) 
          break; 
    }	
	if(document.form1.codActivoFecha.checked){
		valorchecked="on";
	}else{
		valorchecked="off";
	}

resultados_ajax('searchOrdenTrabajo.php?codestotB='+document.form1.codestotB[i].value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&nroOrdenTrabajoB='+document.form1.nroOrdenTrabajoB.value+'&numeroOrdenTrabajoB='+document.form1.numeroOrdenTrabajoB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&cod_estado_pago_docB='+document.form1.cod_estado_pago_docB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value);

}
function paginar(f)
{	
	for (i=0;i<document.form1.codestotB.length;i++){ 
       if (document.form1.codestotB[i].checked) 
          break; 
    }	
	if(document.form1.codActivoFecha.checked){
		valorchecked="on";
	}else{
		valorchecked="off";
	}
		location.href='listOrdenTrabajo.php?codestotB='+document.form1.codestotB[i].value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&nroOrdenTrabajoB='+document.form1.nroOrdenTrabajoB.value+'&numeroOrdenTrabajoB='+document.form1.numeroOrdenTrabajoB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&cod_estado_pago_docB='+document.form1.cod_estado_pago_docB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&pagina='+document.form1.pagina.value;
}
function paginar1(f,pagina)
{		

		f.pagina.value=pagina*1;		
		for (i=0;i<document.form1.codestotB.length;i++){ 
       if (document.form1.codestotB[i].checked) 
          break; 
    }	
	if(document.form1.codActivoFecha.checked){
		valorchecked="on";
	}else{
		valorchecked="off";
	}
		location.href='listOrdenTrabajo.php?codestotB='+document.form1.codestotB[i].value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&nroOrdenTrabajoB='+document.form1.nroOrdenTrabajoB.value+'&numeroOrdenTrabajoB='+document.form1.numeroOrdenTrabajoB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&cod_estado_pago_docB='+document.form1.cod_estado_pago_docB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&pagina='+document.form1.pagina.value;
}
function openPopup(url){
	window.open(url,'','top=50,left=200,width=600,height=400,scrollbars=1,resizable=1');
}
</script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#FFFFFF" onload="document.form1.nombreClienteB.focus()" >
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->

<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">LISTADO DE BINGOS </h3>
<form name="form1" id="form1"  method="post" >

<br/>
      <br/>
<div id="resultados">
<?php 

	//Paginador
	
	

	
	$sql=" select count(*) ";
	$sql.=" from bingo ";

	$resp = mysql_query($sql);
	while($dat_aux=mysql_fetch_array($resp)){
		$nro_filas_sql=$dat_aux[0];
	}
?>
	<div id="nroRows" align="center" class="textoform"><?php echo "Nro. de Registros: ".$nro_filas_sql; ?></div>
    <br/>
<?php
	if($nro_filas_sql==0){
?>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#FFFFFF">
	    <tr height="20px" align="center"  class="titulo_tabla">
            <td>BINGO</td>
  																													            
		</tr>
		<tr>
		  <th  class="fila_par" align="center">&iexcl;No existen !</th>
		</tr>
	</table>
	
<?php	
	}else{

	$sql=" select distinct(numero_bingo), cod_bingo, desc_bingo ";
	$sql.=" from bingo ";
	$sql.=" order by  cod_bingo ";
	$resp = mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
	
		$cod_bingo=$dat['cod_bingo'];
		$desc_bingo=$dat['desc_bingo'];
		$numero_bingo=$dat['numero_bingo'];
	
?>	
<br/>
	<table width="10%" align="center" cellpadding="1" cellspacing="0" bgColor="#cccccc">


	    <tr height="20px" align="center"  class="titulo_tabla" >
            <td colspan="25">BINGO <?php echo $desc_bingo;?></td>          
                             	            																	
		</tr>
                       <tr>
	    
<?php   

							

				$sql2="select cod_bingo_detalle from bingo_detalle where cod_bingo=".$cod_bingo;
				$resp2= mysql_query($sql2);	
				$cont=0;
					while($dat2=mysql_fetch_array($resp2)){
				
						$cod_bingo_detalle=$dat2['cod_bingo_detalle'];
						$cont=$cont+1;
						
						if($cont==1 or $cont==6 or $cont==11 or $cont==15 or $cont==20){
				?>
 
        <td>
                	<table border="0" >
                    
                <?php
							
						}
						if($cont==13)		{
				?>
                		<tr height="20px" align="center"   bgcolor="#FFFFFF"><th>LOGO</th></tr>
                <?php }?>
					<tr height="20px" align="center"   bgcolor="#FFFFFF"><td><?php echo $cod_bingo_detalle; ?></td></tr>
                <?php
					if($cont==5 or $cont==10 or $cont==14 or $cont==19 or $cont==24){
				?>    
                		
                        </table>
                        	</td>

				<?php	
					}
					}			
				?>
	    </tr>
	</table>
<?php
		 } 
?>			

		
<?php
	}
?>
</div>	
<?php require("cerrar_conexion.inc");
?>


</form>

</body>
</html>


