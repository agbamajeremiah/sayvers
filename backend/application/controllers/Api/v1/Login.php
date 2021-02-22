<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
     
class Login extends REST_Controller {
    
	/**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();

       $this->load->library('user_agent');
    }

    // All the get requests on /login is performed in this method
    public function index_get()
    {
        $args = func_get_args();
        if(empty($args)) return;

        // /api/vi/login/resetpassword -GET
        if($args[0] === 'resetpassword'){
            $code = $this->utility->getToken(6, true); // Get random code
            $email = $this->input->get('email');
            $result = $this->crud_m->fetch(['email' => $email], 'users');

            if(!$result){
                $this->response(['status' => TRUE, 'message' => 'Please check your email for a verification code'],  REST_Controller::HTTP_OK);
            }else{
                $data['code'] = $code;
                $this->crud_m->update(['resetcode' => $code], ['email' => $email]);
                $messageFromTemp = $this->load->view('emails/resetpwd', $data['code'], true);

                $config['mailType'] = 'html';

                $this->load->library('email');

                $this->email->initialize($config);
                $this->email->from('skycombabs@gmail.com', 'mySkycombabs App');
                $this->email->to($email);

                $this->email->subject('Reset Your Password');
                $this->email->message($messageFromTemp);

                $this->email->send();

                $this->response(['status' => TRUE, 'message' => 'Please check your email for a verification code'],  REST_Controller::HTTP_OK);
            }
            
        }

        // /api/v1/login/changepwd - GET
        if($args[0] === 'changepwd'){
            $password = $this->input->get('password');
            $newpassword = $this->input->get('newPassword');
            $confirmpwd = $this->input->get('confirmPwd');
    
            $uuid = $this->input->get('uuid');
            $sess_token = $this->input->post('sess_token');
            $auth = $this->authorization->authValidate($sess_token);
            
            if(!$uuid || empty($uuid)){
                $this->response(['status' => FALSE, 'message' => 'UUID is required to fetch user data'], REST_Controller::HTTP_BAD_REQUEST);
                return;
            }
            
            $data = $this->crud_m->fetch(['uuid' => $uuid]);

            if(!$data){
                $this->response(['status' => FALSE, 'message' => 'User not found. User has either been deleted or never existed'], REST_Controller::HTTP_NOT_FOUND);
                return;
            }

            if(!$auth || !$auth['status'] || $auth['data']->uuid != $uuid){
                $this->response(['status' => FALSE, 'message' => 'Unauthorized access'], REST_Controller::HTTP_OK);
                return;
            }else{
                $new_token = $this->authorization->generateToken(['uuid' => $uuid, 'email' => $data->email]);
                $this->crud_m->update(array('token' => $new_token), array('uuid' => $uuid));
                $data->token = $new_token;
            }


            if(!password_verify($password, $data->password)){
                $this->response(['status' => FALSE, 'message' => 'Current Password is incorrect'],  REST_Controller::HTTP_OK);
            }else if($newpassword != $confirmpwd){
                $this->response(['status' => FALSE, 'message' => 'Passwords does not match'],  REST_Controller::HTTP_OK);
            }else{
                $this->crud_m->update(['password' => password_hash($password, PASSWORD_DEFAULT)], ['uuid' => $data->uuid]);
                $this->response(['status' => TRUE, 'sess_token' => $data->token, 'message' => 'Passwords has been changed'],  REST_Controller::HTTP_OK);
            }

        }

        // /api/v1/login/changepassword -GET 
        if($args[0] === 'changepassword'){
            $code = $this->input->get('resetcode');
            $email = $this->input->get('email');
            $password = $this->input->get('password');
            $confirmpwd = $this->input->get('confirmPwd');

            $data = $this->crud_m->fetch(['email' => $email]);
            if(!$data){
                $this->response(['status' => FALSE, 'message' => 'Reset code does not match this email\'s reset code. Please request a new code to reset your password!'],  REST_Controller::HTTP_OK);
            }else if($data->resetcode != $code){
                $this->response(['status' => FALSE, 'message' => 'Reset code does not match this email\'s reset code. Please request a new code to reset your password!'],  REST_Controller::HTTP_OK);
            }else if($password != $confirmpwd){
                $this->response(['status' => FALSE, 'message' => 'Passwords does not match'],  REST_Controller::HTTP_OK);
            }else{
                $this->crud_m->update(['password' => password_hash($password, PASSWORD_DEFAULT)], ['uuid' => $data->uuid]);
                $this->response(['status' => TRUE, 'message' => 'Passwords has been changed'],  REST_Controller::HTTP_OK);
            }

        }

        // /api/v1/login/transactionpin -GET 
        if($args[0] === 'transactionpin'){
            $pin = $this->input->get('pin');

            $uuid = $this->input->get('uuid');
            // $uuid = "ddhhfufufu";
            $sess_token = $this->input->get('sess_token');
            $auth = $this->authorization->authValidate($sess_token);
            // $this->response(['status' => FALSE, 'uuid' => $uuid, 'token' => $sess_token], REST_Controller::HTTP_OK);
            
            if(!$uuid || empty($uuid)){
                $this->response(['status' => FALSE, 'message' => 'User not found!'], REST_Controller::HTTP_OK);
                return;
            }
            
            $data = $this->crud_m->fetch(['uuid' => $uuid]);

            if(!$data){
                $this->response(['status' => FALSE, 'message' => 'User not found.'], REST_Controller::HTTP_OK);
                return;
            }

            if(!$auth || !$auth['status'] || $auth['data']->uuid != $uuid){
                $this->response(['status' => FALSE, 'message' =>  'Unauthorized access', 'auth_data' => $auth],  REST_Controller::HTTP_OK);
                return;
            }else{
                $new_token = $this->authorization->generateToken(['uuid' => $uuid, 'email' => $data->email]);
                $this->crud_m->update(array('token' => $new_token), array('uuid' => $uuid));
                $data->token = $new_token;
            }

            $password = password_verify($this->input->get('password'), $data->password);

            if(! password_verify($this->input->get('password'), $data->password)){
                $this->response(['status' => FALSE, 'message' => 'Password is invalid', 'data' ], REST_Controller::HTTP_OK);
                return;
            }else{
                $hashed_pin = password_hash($pin, PASSWORD_BCRYPT);
                $this->crud_m->update(['pin' => $hashed_pin], ['uuid' => $uuid]);
                $this->response(['status' => TRUE, 'sess_token' => $data->token, 'message' => 'Your transaction pin was set successfully'], REST_Controller::HTTP_OK);
                return;
            }
        }
    }
      
    /**
     * Post requests are captured in this method
     * // /api/v1/login/ -POST 
     *
     * @return Response
    */
    public function index_post()
    {
        $email      = $this->input->post('email');
        $password   = $this->input->post('password');
        $login = $this->crud_m->fetch(array('email' => $email));

        if(!$login){
            $this->response(['status' => FALSE, 'message' => 'Email or password is invalid'], REST_Controller::HTTP_OK);
            return;
        }
        else{
            if(!password_verify($password, $login->password)){
                $this->response(['status' => FALSE, 'message' => 'Email or password is invalid'], REST_Controller::HTTP_OK);
                return;
            }
            else if($login->status === 'blocked'){
                $this->response(['status' => FALSE, 'message' => 'Account blocked'], REST_Controller::HTTP_OK);
                return;
            }
            else{
                // create sess_token for user
                $password           = password_hash($password, PASSWORD_DEFAULT);
         
                $data['last_login'] = date('Y-m-d H:i:s');
                $data['updated_at'] = date('Y-m-d H:i:s');
                $data['ip_address'] = $this->input->ip_address();
                $data['user_agent'] = $this->agent->agent_string();
                $data['uuid']       = $login->uuid;
                $data['token']      = $this->authorization->generateToken(['uuid' => $login->uuid, 'email' => $email]);

                $this->crud_m->update($data, 'uuid');
                // $this->crud_m->notify($data['uuid'], 'Logged in to your wallet', 'You just logged in to your wallet');
                // $wallet = $this->crud_m->fetch_array(['uuid' => $data['uuid']], 'wallets');
                // $data = array_unique(array_merge($data, $wallet));
                $this->response(['status' => TRUE, 'data' => $data], REST_Controller::HTTP_OK);
                return;
            }
        }

    } 	
}