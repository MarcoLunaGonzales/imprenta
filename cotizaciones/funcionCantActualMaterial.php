<?php

//require("conexion.inc");
/**
 * Funciones 
 * Autor: Gabriela Quelali Siñani
 * @version $Id$
 * @copyright 2008 
 **/
function cantActualMaterial($cod_material,$cod_almacen)
{	
	require("conexion.inc");
		
		$cantActualMaterial_1=0;
		
		$cantActualMaterial_2=0;
		
		$swError=0;
		

		
		$sql=" select count(*)  from ingresos_detalle where cod_material=".$cod_material."";
		$sql.=" and cod_ingreso in(select cod_ingreso from ingresos where cod_almacen=".$cod_almacen." and cod_estado_ingreso=1)";
		$resp= mysql_query($sql);
		$num_reg_ing_material=0;
		while($dat=mysql_fetch_array($resp)){
				$num_reg_ing_material=$dat[0]; 									
		}		
		
		$sql=" select count(*) from salidas_detalle where cod_material=".$cod_material."";
		$sql.=" and cod_salida in(select cod_salida from salidas where cod_almacen=".$cod_almacen." and cod_estado_salida=1)";
		$resp= mysql_query($sql);
		$num_reg_sal_material=0;
		while($dat=mysql_fetch_array($resp)){
				$num_reg_sal_material=$dat[0]; 									
		}	
		
		if($num_reg_ing_material==0){			
				if($num_reg_sal_material==0){
					$cantActualMaterial_1=0;
					$cantActualMaterial_2=0;
					
				}else{
					$cantActualMaterial_1=0;
					$cantActualMaterial_2=0;
					$swError=1; // No existe Ingreso pero si salidas
				}		
		}else{

				
				$sql="  select sum(cant_actual) from ingresos_detalle where cod_material=".$cod_material."";
				$sql.=" and cod_ingreso in(select cod_ingreso from ingresos where cod_almacen=".$cod_almacen." and cod_estado_ingreso=1)";
				$resp= mysql_query($sql);
				$cantActualMaterial_1=0;
				while($dat=mysql_fetch_array($resp)){
						$cantActualMaterial_1=$dat[0]; 									
				}

				$sql="  select sum(cantidad) from ingresos_detalle where cod_material=".$cod_material."";
				$sql.=" and cod_ingreso in(select cod_ingreso from ingresos where cod_almacen=".$cod_almacen." and cod_estado_ingreso=1)";
				$resp= mysql_query($sql);
				$sum_cant_ing_mat=0;
				while($dat=mysql_fetch_array($resp)){
						$sum_cant_ing_mat=$dat[0]; 									
				}
				
				
				if($num_reg_sal_material>0){
					////////////////
						$sql=" select sum(cant_salida) from salidas_detalle where cod_material=".$cod_material."";
						$sql.=" and cod_salida in(select cod_salida from salidas where cod_almacen=".$cod_almacen." and cod_estado_salida=1)";
						$resp= mysql_query($sql);
						$sum_reg_sal_material=0;
						while($dat=mysql_fetch_array($resp)){
							$sum_reg_sal_material=$dat[0]; 									
						}
					///////////////
					
						$cantActualMaterial_2=$sum_cant_ing_mat-$sum_reg_sal_material;
					
				}else{
					$cantActualMaterial_2=$sum_cant_ing_mat;
				}					
		}
		
		if($cantActualMaterial_1==$cantActualMaterial_2){
			$swError=0;//no existe error

		}else{
			$swError=2;//no existe error
		}

	return($cantActualMaterial_2);
}




?>