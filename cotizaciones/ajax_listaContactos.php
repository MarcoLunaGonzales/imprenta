<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<link rel="STYLESHEET" type="text/css" href="pagina.css" />

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Siñani
	02 de Octubre de 2008
-->

<?php require("conexion.inc");
$codcliente=$_GET['cod_cliente'];
$codcontacto=$_GET['cod_contacto'];
?>

			
			<select name="cod_contacto" id="cod_contacto" class="textoform" >
				<option value="0">Seleccione un Contacto</option>
				<?php
					$sql2=" select cod_contacto,nombre_contacto, ap_paterno_contacto, ap_materno_contacto  ";
					$sql2.=" from clientes_contactos";
					$sql2.=" where cod_cliente=".$codcliente;
					$sql2.=" order by  ap_paterno_contacto asc, ap_materno_contacto asc , nombre_contacto asc ";
					$resp2=mysql_query($sql2);
						while($dat2=mysql_fetch_array($resp2))
						{
							$cod_contacto=$dat2['cod_contacto'];
							$nombre_contacto=$dat2['nombre_contacto'];
							$ap_paterno_contacto=$dat2['ap_paterno_contacto'];
							$ap_materno_contacto=$dat2['ap_materno_contacto'];

				 ?>
				 <?php if($cod_contacto==$codcontacto){?>
					 <option value="<?php echo $cod_contacto;?>" selected="selected"><?php echo $ap_paterno_contacto." ".$nombre_contacto;?></option>		
				 <?php }else{?>
 					 <option value="<?php echo $cod_contacto;?>"><?php echo $ap_paterno_contacto." ".$nombre_contacto;?></option>		
				 <?php }?>		
				<?php		
					}
				?>						
			</select>
			<a  href="javascript:cargar_contacto();">[ Nuevo Contacto]</a>
			&nbsp;<a  href="javascript:datosContacto(this.form)"> [Datos Contacto]</a>
</body>
</html>
