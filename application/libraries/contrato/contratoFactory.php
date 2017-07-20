<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ContratoFactory {
	
	public static $_ordenVencidos = array('mesesactuales', 'mesesvencidos', 'ultimaprorroga', 'valor', 'idcontrato', 'nombre');
	
	public function getContratosVencidos($tipoarticulo = '', $ordenarpor = '', $orden = ''){
		$CI =& get_instance();
		
		if($orden != ''){
			$query = 'SELECT * FROM contratosvencidos WHERE idcontrato NOT IN (SELECT contrato FROM presaca)';
			if($tipoarticulo != ''){
				$query .= ' AND tipoarticulo = '.$CI->db->escape($tipoarticulo);
			}
			if($orden != 'ASC' && $orden != 'DESC'){
				return FALSE;
			}
			if(!in_array($ordenarpor, ContratoFactory::$_ordenVencidos)){
				return FALSE;
			}
			if($ordenarpor == 'mesesvencidos'){
				$query .= ' ORDER BY (mesesactuales - mesesprorrogados) '.$orden;
			}else{
				$query .= ' ORDER BY '.$ordenarpor.' '.$orden;
			}
			
		}else{
			$query = 'SELECT * FROM contratosvencidos WHERE idcontrato NOT IN (SELECT contrato FROM presaca) ORDER BY mesesactuales DESC';
		}
		
		return $CI->db->query($query);
	}
	
	public function getContratosActivos($tipoarticulo = '', $ordenarpor = '', $orden = '', $inicial = '', $final = ''){
		$CI =& get_instance();
		
		if($orden != ''){
			$_orden = array('mesesactuales', 'ultimaprorroga', 'valor', 'fechaingreso', 'idcontrato', 'nombre');
			$query = 'SELECT * FROM contratosactivos';
			
			$where = array();
			
			if($tipoarticulo != ''){
				$where[] = 'tipoarticulo = '.$CI->db->escape($tipoarticulo);
			}

			if($inicial != '' && $final != ''){
				$where[] = 'fechaingreso BETWEEN '.$CI->db->escape($inicial).' AND '.$CI->db->escape($final);
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
			$query = 'SELECT * FROM contratosactivos';
		}
		
		return $CI->db->query($query);
	}
	
	public function getTotalesContratosActivos(){
		$CI =& get_instance();
		$query = 'SELECT COUNT(valor) AS nrocontratos, SUM(valor) AS totalprestado FROM contratosactivos ORDER BY mesesactuales DESC';
		$res = $CI->db->query($query);
		$res = $res->result_array();
		return $res[0];
	}
	
	public function getPresacas(){
		$CI =& get_instance();
		
		$query = 'SELECT * FROM contratosvencidos WHERE idcontrato IN (SELECT contrato FROM presaca) ORDER BY mesesactuales DESC';
				
		return $CI->db->query($query);
	}
	
	public function getTotalContratos($inicial, $final){
		$CI =& get_instance();
		$query = 'SELECT SUM(valor) AS prestado FROM contrato WHERE fechaingreso BETWEEN '.$CI->db->escape($inicial).' AND '.$CI->db->escape($final);
		$sql = $CI->db->query($query);
		$res = $sql->result_array();
		return $res[0]['prestado'];
	}
	
	public function getTotalCancelaciones($inicial, $final){
		$CI =& get_instance();
		
		$CI->load->library('contrato/contrato');
		
		$query = 'SELECT SUM(valor) AS capital, SUM(valorcancelado) AS cancelado FROM contrato WHERE estado = '.Contrato::CANCELADO.' AND fechasalida BETWEEN '.$CI->db->escape($inicial).' AND '.$CI->db->escape($final);
		$sql = $CI->db->query($query);
		$res = $sql->result_array();
		return $res[0];
	}
	
	public function getTotalProrrogas($inicial, $final){
		$CI =& get_instance();
		$query = 'SELECT SUM(valor) AS prorrogas FROM prorroga WHERE fecha BETWEEN '.$CI->db->escape($inicial).' AND '.$CI->db->escape($final);
		$sql = $CI->db->query($query);
		$res = $sql->result_array();
		return $res[0]['prorrogas'];
	}
	
	public function getInfoSellos($inicial, $final){
		$CI =& get_instance();
		$query = 'SELECT idcontrato, fechaingreso, articulo, valor FROM contrato WHERE fechaingreso BETWEEN '.$CI->db->escape($inicial).' AND '.$CI->db->escape($final);
		return $CI->db->query($query);
	}
	
	public function getContratosPorCliente($idcliente){
		$CI =& get_instance();
		$query = 'SELECT idcontrato, fechaingreso, valor FROM contrato WHERE cliente = '.$CI->db->escape($idcliente);
		return $CI->db->query($query);
	}
	
	public function getHistorialContratos($idcliente){
		$CI =& get_instance();
		$query = 'SELECT idcontrato, fechaingreso, articulo, valor, estado, descripcion, valorcancelado, (SELECT SUM(valor) FROM prorroga WHERE contrato = idcontrato) AS prorrogas FROM contrato JOIN estado ON contrato.estado = estado.idestado WHERE cliente = '.$CI->db->escape($idcliente);
		return $CI->db->query($query);
	}
	
	public function getEstadisticasXAno($ano){
		$CI =& get_instance();
		$query = 'SELECT MONTH(fechaingreso) AS mes, COUNT(idcontrato) as nrocontratos, SUM(valor) AS totalmes FROM contrato WHERE fechaingreso BETWEEN '.$CI->db->escape($ano.'-01-01').' AND '.$CI->db->escape($ano.'-12-31').' GROUP BY mes';
		return $CI->db->query($query);
	}
	
	public function contratosSacados($inicial, $final, $tipoarticulo = '', $ordenarpor = '', $orden = ''){
		$CI =& get_instance();
		
		require_once(APPPATH.'libraries/contrato/contrato.php');
		
		$_orden = array('nromeses', 'ultimaprorroga', 'valor', 'fechasalida', 'idcontrato', 'nombre');
		$query = 'SELECT idcontrato, contrato.cliente AS idcliente, nombre, articulo, contrato.tipoarticulo AS idtipoarticulo, valor, valorcancelado, fechaingreso, fechasalida, porcentaje, (TIMESTAMPDIFF(MONTH, fechaingreso, fechasalida) + 1) AS nromeses, tipoarticulo.tipoarticulo,
			(SELECT SUM(valor) FROM prorroga WHERE contrato = contrato.idcontrato) AS prorrogas
			FROM contrato JOIN tipoarticulo ON contrato.tipoarticulo = tipoarticulo.idtipoarticulo 
			JOIN cliente ON contrato.cliente = cliente.idcliente';
		
		$where = array();
		$where[] = 'contrato.fechasalida IS NOT NULL';
		$where[] = '(contrato.estado = '.Contrato::CHATARRIZADO.' OR contrato.estado = '.Contrato::ALMACEN.' OR contrato.estado = '.Contrato::VENDIDO.')';
		
		if($tipoarticulo != ''){
			$where[] = 'contrato.tipoarticulo = '.$CI->db->escape($tipoarticulo);
		}

		if($inicial != '' && $final != ''){
			$where[] = 'fechasalida BETWEEN '.$CI->db->escape($inicial.' 00:00:00').' AND '.$CI->db->escape($final.' 23:59:59');
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
		return $CI->db->query($query);
	}

	public function contratosCancelados($inicial, $final, $tipoarticulo = '', $ordenarpor = '', $orden = ''){
		$CI =& get_instance();
		
		require_once(APPPATH.'libraries/contrato/contrato.php');
		
		$_orden = array('nromeses', 'ultimaprorroga', 'valor', 'fechasalida', 'idcontrato', 'nombre');
		$query = 'SELECT idcontrato, contrato.cliente AS idcliente, nombre, articulo, contrato.tipoarticulo AS idtipoarticulo, valor, valorcancelado, fechaingreso, fechasalida, porcentaje, (TIMESTAMPDIFF(MONTH, fechaingreso, fechasalida) + 1) AS nromeses, tipoarticulo.tipoarticulo,
			(SELECT SUM(valor) FROM prorroga WHERE contrato = contrato.idcontrato) AS prorrogas
			FROM contrato JOIN tipoarticulo ON contrato.tipoarticulo = tipoarticulo.idtipoarticulo 
			JOIN cliente ON contrato.cliente = cliente.idcliente';
		
		$where = array();
		$where[] = 'contrato.fechasalida IS NOT NULL';
		$where[] = 'contrato.estado = '.Contrato::CANCELADO;
		
		if($tipoarticulo != ''){
			$where[] = 'contrato.tipoarticulo = '.$CI->db->escape($tipoarticulo);
		}

		if($inicial != '' && $final != ''){
			$where[] = 'fechasalida BETWEEN '.$CI->db->escape($inicial.' 00:00:00').' AND '.$CI->db->escape($final.' 23:59:59');
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
		return $CI->db->query($query);
	}
	
}
