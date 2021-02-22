<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
     
class Register extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();

       $this->load->library('user_agent');
    }
       
    /**
     * Post requests is captured here
     * /api/v1/register -POST
     *
     * @return Response
    */
    public function index_post()
    {
        $required_index = array('email', 'password', 'confirmpwd');
        $data = $this->input->post(); // Get all posted data
        foreach($required_index as $dt){
            if(!array_key_exists($dt, $data)){
                $this->response(['status' => FALSE, 'message' => 'field "'.$dt.'" is required'], REST_Controller::HTTP_BAD_REQUEST);
                return;
            }
        }

        if($data['confirmpwd'] != $data['password']){
            $this->response(['status' => FALSE, 'message' => 'Passwords do not match'], REST_Controller::HTTP_OK);
            return;

        }else if($this->crud_m->checkIfExist(array('email' => $data['email']))){
            $this->response(['status' => FALSE, 'message' => 'Email already registered. Please login instead'], REST_Controller::HTTP_OK);
            return;
        }
        
        else{
             // remove unwanted keys from array
            unset($data['confirmpwd']);

            $data['uuid'] = $this->utility->uniqueID(); // Generate UUID
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['last_login'] = date('Y-m-d H:i:s');
            $data['ip_address'] = $this->input->ip_address();
            $data['user_agent'] = $this->agent->agent_string();
            $data['token'] = $this->authorization->generateToken(['uuid' => $data['uuid'], 'password' => $data['password'], 'email' => $data['email']]);

            $auth = $this->crud_m->insert($data);

            if(!$auth){
                $this->response(['status' => FALSE, 'message' => 'Could not create an account for you. Try again with correct details'], REST_Controller::HTTP_OK);
                return;
            }
            else{
                $this->response(['status' => TRUE, 'data' => ['uuid' => $data['uuid'], 'sess_token' => $data['token']]], REST_Controller::HTTP_OK);
                return;
            }
        }
    } 
    	
}