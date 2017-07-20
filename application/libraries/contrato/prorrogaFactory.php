<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProrrogaFactory {
	
	public static function informeProrrogas($filtros = ''){
		$CI =& get_instance();
		// CONSULTA SQL
		$query = 'SELECT prorroga.contrato, prorroga.fecha, prorroga.valor AS valorprorrogado, contrato.articulo, contrato.cliente, cliente.nombre AS nombrecliente, contrato.valor AS valorcontrato, prorroga.valor AS valorprorroga
				FROM prorroga JOIN contrato ON prorroga.contrato = contrato.idcontrato
				JOIN cliente ON contrato.cliente = cliente.idcliente';
		$qs = array();
		if(isset($filtros['cliente']) && $filtros['cliente'] != ''){
			$qs[] = 'contrato.cliente = '.$CI->db->escape($filtros['cliente']);
		}
		if(isset($filtros['inicial']) && $filtros['inicial'] != '' && isset($filtros['final']) && $filtros['final'] != ''){
			$qs[] = '(prorroga.fecha BETWEEN '.$CI->db->escape($filtros['inicial']).' AND '.$CI->db->escape($filtros['final']).')';
		}
		if(sizeof($qs) >= 1){
			$query .= ' WHERE '.implode(' AND ', $qs);
		}
		$query .= ' ORDER BY prorroga.fecha DESC';
		return $CI->db->query($query);
	}
	
}
