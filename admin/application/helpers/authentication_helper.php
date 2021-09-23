<?php

	function authenticate() {
		$CI =& get_instance();
		if(!$CI->session->userdata('adminId')) {
			redirect($CI->config->item('base_url'));
		}
	}

	function clear_cache() {
		$CI =& get_instance();
		$CI->output->set_header("HTTP/1.0 200 OK");
		$CI->output->set_header("HTTP/1.1 200 OK");
		$CI->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
		$CI->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$CI->output->set_header("Cache-Control: post-check=0, pre-check=0");
		$CI->output->set_header("Pragma: no-cache"); 
	}

	function isPageRefresh() {
		$CI =& get_instance();
		if($CI->session->userdata('S_PgRefRan') != $CI->input->get_post('hidPgRefRan',TRUE)) {
			$CI->session->set_userdata('S_PgRefRan',$CI->input->get_post('hidPgRefRan'));
			return false;
		}
		return true;
	}
?>