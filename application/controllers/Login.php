<?php
class Login extends CI_Controller
{
	function __construct(){
        parent ::__construct();
        $this->load->model('user_model','user');
    }
    
	function index(){
        $this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','password','trim|required');
        
        if($this->form_validation->run() == FALSE){
            $this->load->view('login/index');
        }else{
            $user = $this->user->check_login();
            if(!empty($user)){
                $user_data['name'] = $user['name'];
                $user_data['email'] = $user['email'];
                $this->session->set_userdata('webclues_user',$user_data);
                redirect(site_url('cars/index'));
            }else{
                $this->session->set_flashdata('error','Email/Password is not correct');
                $this->load->view('login/index');
            }
        }       
    }

    function logout(){
        $this->session->sess_destroy();
        redirect('Login');
    }
}
?>