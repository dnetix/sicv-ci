<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * My custom made PHP Time helpers 
 */

 if(!function_exists('fecha_diff')){
 	function fecha_diff($fi, $ff = ''){
 			
 		$fechainicial = new DateTime($fi);
		if($ff != ''){
			$fechafinal = new DateTime($ff);
		}else{
			$fechafinal = new DateTime(date('Y-m-d'));
		}
		
		return $fechainicial->diff($fechafinal);
	
	}
 }

 if(!function_exists('month_diff')){
 	function month_diff($fi, $ff = ''){
 			
 		$dif = fecha_diff($fi, $ff);
		
		return ($dif->y * 12) + $dif->m;
	
	}
 }
 
 if(!function_exists('date_print_format')){
 	function date_print_format($fecha){
 		
		$dt_fecha = getdate(strtotime($fecha));
		
 		$dias = array('Domingo', 'Lunes', 'Martes', 'Mi&eacute;rcoles', 'Jueves', 'Viernes', 'Sabado');
		$meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

		return $dias[$dt_fecha['wday']].', '.$dt_fecha['mday'].' de '.$meses[$dt_fecha['mon'] - 1].' de '.$dt_fecha['year'];
	
	}
 }
 
 if(!function_exists('date_contract_format')){
 	function date_contract_format($fecha){
 		
		$dt_fecha = getdate(strtotime($fecha));
		
 		$dias = array('Domingo', 'Lunes', 'Martes', 'Mi&eacute;rcoles', 'Jueves', 'Viernes', 'Sabado');
		$meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

		return $dt_fecha['mday'].' d&iacute;as, del mes de '.$meses[$dt_fecha['mon'] - 1].' del a&ntilde;o '.$dt_fecha['year'];
	
	}
 }
 
 if(!function_exists('get_month_name')){
 	function get_month_name($mes, $minus = TRUE, $short = FALSE){
 		
		if($minus){
			$mes--;
		}
		if($short){
			$meses = array('Ene.', 'Feb.', 'Mar.', 'Abr.', 'May.', 'Jun.', 'Jul.', 'Ago.', 'Sep.', 'Oct.', 'Nov.', 'Dic.');
		}else{
			$meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
		}
		return $meses[$mes];
	
	}
 }
 
 if(!function_exists('dmy_date')){
 	function dmy_date($fecha){
		
		return date('d/m/Y', strtotime($fecha));
	
	}
 }