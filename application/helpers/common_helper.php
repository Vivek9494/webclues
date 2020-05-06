<?php
	function UserSessionCheck(){
		$CI =& get_instance();
		$SessionUser = $CI->session->userdata('webclues_user');

		if(!empty($SessionUser)){
			return true;
		}else{
			redirect(site_url('login'));
		}
	}

