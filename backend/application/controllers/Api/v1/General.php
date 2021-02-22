<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
     
class General extends REST_Controller {
    
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
     * Post request are handled in this method
     *
     * @return Response
    */
    public function index_post()
    {
        //Get all the params passed to this method. Each parameter is an api endpoint. Pretty easy and straight forward right? I thought so too :-)
        // List of endpoints are
        // /api/v1/general/checkupdates -POST
        $args = func_get_args();
        if(empty($args)){
            $this->response(['status' => FALSE, 'message' => 'Invalid endpoint'], REST_Controller::HTTP_NOT_FOUND);
            return;
        }else{
            // fetch admin account table
            $data = $this->crud_m->fetch(['id' => 1], 'account');


            // /api/v1/general/checkupdates   - POST
            if($args[0] === "checkupdates"){
                if($data->app_version != $this->input->post('version')){
                    $this->response(['status' => true, 'message' => 'New version available, please update your app'], REST_Controller::HTTP_OK);
                }else{
                    $this->response(['status' => false, 'message' => 'No updates available'], REST_Controller::HTTP_OK);
                }
            }

            
        }
    }
}