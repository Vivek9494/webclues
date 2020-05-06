<?php
class Cars extends CI_Controller
{
	function __construct(){
        parent ::__construct();
        UserSessionCheck();
        $this->load->model('cars_model','cars');
    }

    function index(){
        $config = array();
        $config['total_rows'] = $this->db->get('cars')->num_rows();
        $config["per_page"] = $limit = 5;
        $config["uri_segment"] = 3;
        $config["base_url"] = site_url('cars/index');
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["links"] = $this->pagination->create_links();
        $data['cars'] = $this->cars->getAllCars($limit,$page);
        $this->load->view('cars/index',$data);
    }


    function add_car(){
        $this->load->view('cars/add_car');
    }

    function save_car(){
        $this->form_validation->set_rules('car_name','Car Name','trim|required');
        $this->form_validation->set_rules('car_color','Car Color','trim|required');
        $this->form_validation->set_rules('car_fuel','Car Fuel','trim|required');
        $this->form_validation->set_rules('car_description','Car Description','trim|required');
        $this->form_validation->set_rules('car_date','Car Date','trim|required|callback_check_valid_date');
        $this->form_validation->set_rules('car_status','Car Status','trim|required');
        if($this->form_validation->run() == FALSE){
            $response['status'] = 'error';
            $response['message'] = strip_tags(validation_errors());
        } else{
            $CarExist = $this->cars->checkCarExist();
            if($CarExist){
                $response['status'] = 'error';
                $response['message'] = 'Car with Same Details is already Exist';
            }else{
                $result = $this->cars->saveCar(); 
                $response['status'] = 'success';
                $response['message'] = 'Car Details added successfull';            
            }
        }
        echo json_encode($response);die;
    }

    function edit_car($id){
        $data['car_details'] = $this->db->get_where('cars',array('id' => $id))->row_array();
        if(!empty($data['car_details'])){
            $this->load->view('cars/edit_car',$data);
        }else{
            echo 'Invalid Url';
        }        
    }

    function update_car(){
        $this->form_validation->set_rules('car_name','Car Name','trim|required');
        $this->form_validation->set_rules('car_color','Car Color','trim|required');
        $this->form_validation->set_rules('car_fuel','Car Fuel','trim|required');
        $this->form_validation->set_rules('car_description','Car Description','trim|required');
        $this->form_validation->set_rules('car_date','Car Date','trim|required|callback_check_valid_date');
        $this->form_validation->set_rules('car_status','Car Status','trim|required');
        if($this->form_validation->run() == FALSE){
            $response['status'] = 'error';
            $response['message'] = strip_tags(validation_errors());
        } else{
            $id = $this->input->post('car_id');
            $CarExist = $this->cars->checkCarExist($id);
            if($CarExist){
                $response['status'] = 'error';
                $response['message'] = 'Car with Same Details is already Exist';
            }else{
                $result = $this->cars->saveCar($id); 
                $response['status'] = 'success';
                $response['message'] = 'Car Details added successfull';            
            }
        }
        echo json_encode($response);die;
    }

    function check_valid_date($date){
        $month = $this->input->post('car_month');
        $year = $this->input->post('car_year');
        if(checkdate($month,$date,$year)){
            return true;
        }else{
            $this->form_validation->set_message('check_valid_date', 'Invalid Date selected');
            return false;
        }
    }
}