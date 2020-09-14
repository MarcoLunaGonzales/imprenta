


<?php


require("conexion.inc");





		$sql=" select count(*) ";
		$sql.=" from cuentas ";
		if($_GET['numero_cuentaB']<>""){
			$sql.=" where (nro_cuenta like'%".$_GET['numero_cuentaB']."%' ";
			$sql.=" or desc_cuenta like'%".$_GET['numero_cuentaB']."%')";			
		}

		$resp = mysql_query($sql);
		$numRows=0;
		while($dat=mysql_fetch_array($resp)){
			$numRows=$dat[0];			
		}
		if($numRows==0){
?>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			  <td>Nro de Cuenta</td>
              <td>Cuenta</td>
              <td>Detalle</td>
              <td>Moneda</td> 
        	  <td>Estado</td>
     		  <td>Registro</td>
    		  <td>Ultima Edici&oacute;n</td>	 									
		</tr>
		<tr><th colspan="7" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
	</table>
	
<?php	
	}else{
	
?>
<h3 align="center" style="background:#F7F5F3;font-size: 10px;color: #E78611;font-weight:bold;"><?php echo "Nro de Registros :".$nro_filas_sql;?></h3>
<?php

		
		$sql=" select cod_cuenta, nro_cuenta, desc_cuenta, detalle_cuenta, cod_moneda, cod_cuenta_padre, ";
		$sql.=" cod_estado_registro, cod_usuario_registro, fecha_registro, cod_usuario_modifica, fecha_modifica ";
		$sql.=" from cuentas ";	
		if($_GET['numero_cuentaB']<>""){
			$sql.=" where (nro_cuenta like'%".$_GET['numero_cuentaB']."%' ";
			$sql.=" or desc_cuenta like'%".$_GET['numero_cuentaB']."%')";			
		}
		$sql.=" order by nro_cuenta asc";
	//	echo $sql."<br/>";
			$resp = mysql_query($sql);


?>	
	<table width="98%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
    	    <tr height="20px" align="center"  class="titulo_tabla">
			  <td>Nro de Cuenta</td>
              <td>Cuenta</td>
              <td>Detalle</td>
              <td>Moneda</td> 
        	  <td>Estado</td>
     		  <td>Registro</td>
    		  <td>Ultima Edici&oacute;n</td>	 																		
		</tr>

<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){	
		
					$cod_cuenta=$dat['cod_cuenta'];
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
		<tr bgcolor="#FFFFFF">	
        		<tr bgcolor="#FFFFFF">	
			<td align="left"><?php echo $nro_cuenta;?></td>
				<td align="center"><strong><a href="javascript:enviarDatos('<?php echo $_GET['numDetalleCbte'];?>','<?php echo $cod_cuenta;?>','<?php echo $nro_cuenta;?>','<?php echo $desc_cuenta;?>')"><?php echo $desc_cuenta;?></a></strong></td>
                <td align="left"><?php echo $detalle_cuenta;?></td>
                <td align="left"><?php echo $desc_moneda;?></td>
                <td align="left"><?php echo $nombre_estado_registro;?></td>
                <td align="left"><?php echo $usuario_registro;?></td>
                <td align="left"><?php echo $usuario_modifica;?></td>          		

    	 </tr>
<?php
		 } 
?>			

		</TABLE>
					
<?php
	}
?>

<?php require("cerrar_conexion.inc");

