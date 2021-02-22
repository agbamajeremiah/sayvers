<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct(){
        parent::__construct();
        
        $token = $this->authorization->authValidate($this->session->userdata('sess_token'));
        if(!$token || !$token['status']){
            redirect(site_url('auth/login'), 'refresh');
        }
    }

}