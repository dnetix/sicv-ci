<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * My custom made HTML helpers 
 */

 if(!function_exists('transfer_message')){
 	function transfer_message($type, $message){
 		$CI =& get_instance();
 		$CI->session->set_flashdata('msg', array($type, $message));
 	}
 }
 
 if(!function_exists('read_message')){
 	function read_message(){
 		$CI =& get_instance();
 		if($msg = $CI->session->flashdata('msg')){
 			echo '<div id="msg" class="msg_'.$msg[0].'" onclick="closeMsg(this)">'.$msg[1].'</div>';
		}
 	}
 }

 if(!function_exists('html_option')){
 	function html_option($results, $key, $value, $selected = ''){
 		foreach($results->result_array() as $result){
 			if($selected != ''){
 				if($result[$key] == $selected){
 					echo '<option value="'.$result[$key].'" selected="selected">'.$result[$value].'</option>';
 				}else{
 					echo '<option value="'.$result[$key].'">'.$result[$value].'</option>';
 				}
 			}else{
 				echo '<option value="'.$result[$key].'">'.$result[$value].'</option>';
 			}
 		}
 	}
 }