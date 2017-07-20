<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Code128 {
	private $string;
	private $checksum;
	private $code128;
	
	const DIFF = 32;
	const BIGDIFF = 100;
	const STARTB = 204;
	const STOP = 206;
	const CHECKMOD = 103;
	
	public function getBarCode($string){
		
		$this->checksum = 104;
		$this->string = $string;
		$string = str_split($string);
		$len = sizeof($string);
		$i = 0;
		$this->code128 = chr(Code128::STARTB);
		while($i < $len){
			$this->checksum += (ord($string[$i]) - Code128::DIFF) * ($i + 1);
			$this->code128 .= $string[$i];
			$i++;
		}
		$this->checksum = $this->checksum % Code128::CHECKMOD;
		if($this->checksum > 94){
			$this->code128 .= chr($this->checksum + Code128::BIGDIFF);
		}else{
			$this->code128 .= chr($this->checksum + Code128::DIFF);
		}
		$this->code128 .= chr(Code128::STOP);
		return $this->code128;
	}
	
	public function getString(){
		return $this->string;
	}
	
	public function getChecksum(){
		return $this->checksum;
	}
	
}