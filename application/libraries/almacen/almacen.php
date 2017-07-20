<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Almacen {
	
	public function getArticulosParaVenta($tipoarticulo = '', $ordenarpor = '', $orden = ''){
		$CI =& get_instance();
		
		if($orden != ''){
			$_orden = array('idarticulo', 'contrato', 'articulo', 'fechaingreso');
			$query = 'SELECT idarticulo, contrato, articulo, tipoarticulo, fechaingreso, valorcompra, valorventa, disponible 
				FROM articulosventa WHERE contrato IS NULL
				UNION ALL
				SELECT idarticulo, contrato, articulosventa.articulo, articulosventa.tipoarticulo, articulosventa.fechaingreso, contrato.valor AS valorcompra, valorventa, disponible 
				FROM articulosventa JOIN contrato ON articulosventa.contrato = contrato.idcontrato 
				WHERE articulosventa.contrato IS NOT NULL';
			if($tipoarticulo != ''){
				$query .= ' AND idtipoarticulo = '.$CI->db->escape($tipoarticulo);
			}
			if($orden != 'ASC' && $orden != 'DESC'){
				return FALSE;
			}
			if(!in_array($ordenarpor, $_orden)){
				return FALSE;
			}
			$query .= ' ORDER BY '.$ordenarpor.' '.$orden;
		}else{
			$query = 'SELECT idarticulo, contrato, articulo, tipoarticulo, fechaingreso, valorcompra, valorventa, disponible 
				FROM articulosventa WHERE contrato IS NULL
				UNION ALL
				SELECT idarticulo, contrato, articulosventa.articulo, articulosventa.tipoarticulo, articulosventa.fechaingreso, contrato.valor AS valorcompra, valorventa, disponible 
				FROM articulosventa JOIN contrato ON articulosventa.contrato = contrato.idcontrato 
				WHERE articulosventa.contrato IS NOT NULL';
		}
		
		return $CI->db->query($query);
	}
	
	public function getArticulosVendidos($tipoarticulo = '', $ordenarpor = '', $orden = '', $inicial = '', $final = ''){
		$CI =& get_instance();
		
		if($orden != ''){
			$_orden = array('idnotacobro', 'fecha', 'valor', 'contrato');
			$query = 'SELECT * FROM articulosvendidos';
			
			$where = array();
			
			if($tipoarticulo != ''){
				$where[] = 'tipoarticulo = '.$CI->db->escape($tipoarticulo);
			}

			if($inicial != '' && $final != ''){
				$where[] = 'fecha BETWEEN '.$CI->db->escape($inicial).' AND '.$CI->db->escape($final);
			}
			
			if(sizeof($where) != 0){
				$where = implode(' AND ', $where);
				$query .= ' WHERE '.$where;
			}

			if($orden != 'ASC' && $orden != 'DESC'){
				return FALSE;
			}
			if(!in_array($ordenarpor, $_orden)){
				return FALSE;
			}
			$query .= ' ORDER BY '.$ordenarpor.' '.$orden;
		}else{
			$query = 'SELECT * FROM articulosvendidos WHERE fecha BETWEEN '.date('Y-m-d').' AND '.date('Y-m-d').' ORDER BY idnotacobro DESC';
		}
		
		return $CI->db->query($query);
	}
	
	public function buscarArticulo($q){
		$CI =& get_instance();
		
		if(strstr($q, 'AR') && strpos($q, 'AR') === 0 && is_numeric(substr($q, 2))){
			
		}else{
			$qs = explode(' ', $q);
			$search = array();
			foreach ($qs as $qt){
				if(is_numeric($qt)){
					$search[] = '(articulo LIKE '.$CI->db->escape('%'.$qt.'%').' OR contrato LIKE '.$CI->db->escape($qt.'%').' OR idarticulo LIKE '.$CI->db->escape($qt.'%').')';
				}else{
					$search[] = 'articulo LIKE '.$CI->db->escape('%'.$qt.'%');
				}
			}
			$query = 'SELECT * FROM 
				(SELECT idarticulo, contrato, articulo, tipoarticulo, fechaingreso, valorcompra, valorventa, disponible 
				FROM articulosventa WHERE contrato IS NULL 
				UNION ALL 
				SELECT idarticulo, contrato, articulosventa.articulo, articulosventa.tipoarticulo, articulosventa.fechaingreso, contrato.valor AS valorcompra, valorventa, disponible 
				FROM articulosventa JOIN contrato ON articulosventa.contrato = contrato.idcontrato 
				WHERE articulosventa.contrato IS NOT NULL) AS articulos 
				WHERE  disponible > 0 AND '.implode(' AND ', $search).' LIMIT 30';
	
			return $CI->db->query($query);
		}

	}
	
	public function getTotalGastos($inicial, $final){
		$CI =& get_instance();
		$query = 'SELECT SUM(valor) AS gastos FROM gasto WHERE fecha BETWEEN '.$CI->db->escape($inicial).' AND '.$CI->db->escape($final);
		$sql = $CI->db->query($query);
		$res = $sql->result_array();
		return $res[0]['gastos'];
	}
	
	public function getTotalCompras($inicial, $final){
		$CI =& get_instance();
		$query = 'SELECT SUM(valorcompra) AS compras FROM articulo WHERE fechaingreso BETWEEN '.$CI->db->escape($inicial).' AND '.$CI->db->escape($final);
		$sql = $CI->db->query($query);
		$res = $sql->result_array();
		return $res[0]['compras'];
	}
	
	public function getTotalVentas($inicial, $final){
		$CI =& get_instance();
		$query = 'SELECT SUM(total) AS ventas FROM notacobro WHERE fecha BETWEEN '.$CI->db->escape($inicial).' AND '.$CI->db->escape($final);
		$sql = $CI->db->query($query);
		$res = $sql->result_array();
		return $res[0]['ventas'];
	}
	
	public function getNotasPorCliente($idcliente){
		$CI =& get_instance();
		$query = 'SELECT idnotacobro, fecha, total FROM notacobro WHERE cliente = '.$CI->db->escape($idcliente);
		return $CI->db->query($query);
	}
	
}
