<?php
class User_model extends CI_Model{

    function check_login(){
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        return $this->db->get_where('users',array('email' => $email,'password' => $password))->row_array();
    }
}
?>