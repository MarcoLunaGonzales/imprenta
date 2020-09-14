<?php
/**
 * @version $Id$
 * @copyright 2008 
 **/

    require("conexion_inicio.inc");

	 $usuario=$_POST['usuario'];
 	 $contrasena=$_POST['contrasena'];
	 
	 if($usuario<>"" and $contrasena<>""){
	 
			 $sql_aux="select count(*) from usuarios where usuario='".$usuario."' and contrasenia='".$contrasena."'";	
		 
			 $resp_aux = mysql_query($sql_aux);
			 while($dat_aux=mysql_fetch_array($resp_aux)){
				 $nro_filas_sql=$dat_aux[0];
			 }		
			
			if($nro_filas_sql>0){
		 		
				$sql="select cod_usuario, usuario_interno  from usuarios where usuario='".$usuario."' ";
				$sql.=" and contrasenia='".$contrasena."'";	
				$resp = mysql_query($sql);
				 while($dat=mysql_fetch_array($resp)){	
			 		$cod_usuario=$dat[0];
					$usuario_interno=$dat[1];
				 }
				
			 	$numModulos=0;
				$sql="select count(*) from usuarios_modulos where cod_usuario=".$cod_usuario;
				$resp = mysql_query($sql);
				while($dat=mysql_fetch_array($resp)){	
			 			$numModulos=$dat[0];					
				}	
					
						
		 		if($numModulos>0){	
						////////////VALIDACION TIPO CAMBIO/////////////////////
						$sql="select cod_moneda from monedas where cod_moneda<>1";
						//echo $sql;
						$resp = mysql_query($sql);
						while($dat=mysql_fetch_array($resp)){
							$cod_moneda=$dat['cod_moneda'];		
												
							$sql2=" select count(*) from tipo_cambio";
							$sql2.=" where cod_moneda=".$cod_moneda;
							$sql2.=" and fecha_tipo_cambio='".date('Y-m-d', time())."'";
							$resp2 = mysql_query($sql2);
							$numReg=0;
							while($dat2=mysql_fetch_array($resp2)){
								$numReg=$dat2[0];
							}
							if($numReg==0){
								$sql3="select count(*) ";
								$sql3.=" from tipo_cambio where cod_moneda=".$cod_moneda;
								$resp3=mysql_query($sql3);
								$numRegMon=0;
								while($dat3=mysql_fetch_array($resp3)){
									$numRegMon=$dat3[0];
								}
								if($numRegMon>0){
									//////////////////////////////////////
										$sql3="select cambio_bs ";
										$sql3.=" from tipo_cambio ";
										$sql3.=" where cod_moneda=".$cod_moneda;
										$sql3.=" order by fecha_tipo_cambio desc";
										$sql3.=" limit 1";
										$resp3=mysql_query($sql3);
										while($dat3=mysql_fetch_array($resp3)){
											$cambio_bs=$dat3[0];
										}
										
										$sql3=" insert into tipo_cambio set ";
										$sql3.=" fecha_tipo_cambio='".date('Y-m-d', time())."',";
										$sql3.=" cod_moneda=".$cod_moneda.",";
										$sql3.=" cambio_bs=".$cambio_bs."";
										//echo $sql3;
										mysql_query($sql3);

									//////////////////////////////////////////////								
								}else{
									    $sql3=" insert into tipo_cambio set ";
										$sql3.=" fecha_tipo_cambio='".date('Y-m-d', time())."',";
										$sql3.=" cod_moneda=".$cod_moneda.",";
										$sql3.=" cambio_bs=1";
									//	echo $sql3;
										mysql_query($sql3);
								
								}
							
							}
						}
						////////////FIN VALIDACION TIPO CAMBIO/////////////////////
				 	 			
						$sql=" select cod_modulo, nombre_modulo, ubicacion_fisica  from modulos ";
						$sql.=" where cod_modulo in(select cod_modulo from usuarios_modulos where cod_usuario=".$cod_usuario.")";
						$resp = mysql_query($sql);
						while($dat=mysql_fetch_array($resp)){													
				 		
								$cod_modulo=$dat[0];
								$nombre_modulo=$dat[1];
								$ubicacion_fisica=$dat[2];					
						}
						

								
						if($numModulos==1){
								setcookie("usuario_global", $cod_usuario, time()+28800,"/","");

									header("location:".$ubicacion_fisica."?cod_modulo=".$cod_modulo); 	
		     
				
						}else{

								setcookie("usuario_global", $cod_usuario, time()+28800,"/","");	
//
									header("location:modules.php"); 

								

						}
																					

			
				}else{
		 
				 		header("location:indexErrorModules.html"); 
			
				 }		
		}else{
			header("location:indexIncorrectoAdmin.html"); 		
		}
		
	}else{
		header("location:indexIncorrectoAdmin.html"); 
	}
?>
