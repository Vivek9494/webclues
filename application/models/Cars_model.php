<?php
class Cars_model extends CI_Model{

    function getAllCars($limit,$offset){
        $this->db->limit($limit, $offset);
        return $this->db->get('cars')->result_array();
    }

    function checkCarExist($id=''){
        if(!empty($id)){
            $this->db->where('id !=',$id);
        }
        $result = $this->db->get_where('cars',array('car_name' => $this->input->post('car_name'),
                                                    'car_color' => $this->input->post('car_color'),
                                                    'car_fuel' => $this->input->post('car_fuel')))->result_array();

        if(!empty($result)){
            return true;
        }else{
            return false;
        }
    }

    function saveCar($car_id=''){

        $file_name = time().'_'.rand(111,999);

        $config['upload_path'] = 'uploads/';
        $config['overwrite'] = TRUE;							
        $config['file_name'] = $file_name;
        $config['allowed_types'] = 'jpg|png';
        $config['max_size'] = 1024;

        $this->load->library('upload',$config);	
        $this->upload->initialize($config);	
        if (!$this->upload->do_upload('userfile')) {
            $response['status'] = 'error';
            $response['message'] = strip_tags($this->upload->display_errors());
        } else {
            $u_data = $this->upload->data();
            $imagelink  = $u_data['file_name'];
            $response['status'] = 'success';
        }		
        
        if($response['status'] == 'success'){
            $date = $this->input->post('car_date');
            $month = $this->input->post('car_month');
            $year = $this->input->post('car_year');

            $data = array(
                'car_name' => $this->input->post('car_name'),
                'car_color' => $this->input->post('car_color'),
                'car_fuel' => $this->input->post('car_fuel'),
                'car_description' => $this->input->post('car_description'),
                'car_photo' => $imagelink,
                'car_date' => $year.'-'.$month.'-'.$date,
                'status' => $this->input->post('car_status')
            );

            if(empty($car_id)){
                $this->db->insert('cars',$data);
            }else{
                $this->db->where('id',$car_id);
                $this->db->update('cars',$data);
            }
        }
        
        return $response;
    }
}
