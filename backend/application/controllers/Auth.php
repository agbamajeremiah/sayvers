<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->library('user_agent');
    }

	#region Pages loader methods
	// The methods below are used for loading pages/views
	public function index()
	{
		$this->login();
	}

	public function login(){
		if($this->authorization->isLoggedIn($this->session->userdata('sess_token')))
            redirect(site_url('dashboard'));

        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required',
            array('required' => 'You must provide a %s.')
        );

        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('login');
        }
        else
        {
            $data['email']      = $this->input->post('email');
            $data['password']   = $this->input->post('password');
            $remember           = $this->input->post('remember');

            $login = $this->crud_m->fetch(array('email' => $data['email'], 'user_role' => 1));

  
            if(!$login){
                $this->session->set_flashdata('invalid_login', 'Email or password is invalid');
                redirect(site_url('auth/login'));
            }
            else{
                if(!password_verify($data['password'], $login->password)){
                    $this->session->set_flashdata('invalid_login', 'Email or password is invalid');
                    redirect(site_url('auth/login'));
                }
                else if($login->status === 'blocked'){
                    redirect(site_url('auth/blocked'));
                }
                else{
                    // create sess_token for user
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    $data['last_login'] = date('Y-m-d H:i:s');
                    $data['updated_at'] = date('Y-m-d H:i:s');
                    $data['ip_address'] = $this->input->ip_address();
                    $data['user_agent'] = $this->agent->agent_string();
                    $data['uuid'] = $login->uuid;
                    $data['token'] = $this->authorization->generateToken(['uuid' => $login->uuid, 'password' => $data['password'], 'email' => $data['email']]);

                    unset($data['password']);

                    $this->crud_m->update($data, 'uuid');
                    
                    $this->session->set_userdata('user_id', $login->uuid);
                    $this->session->set_userdata('sess_token', $data['token']);

                    redirect(site_url('dashboard'));
                }
            }
        }
    }

    public function register(){
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required',
            array('required' => 'You must provide a %s.')
        );
        $this->form_validation->set_rules('confirmpwd', 'Password', 'required',
            array('required' => 'You must confirm your %s.')
        );

        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('register');
        }
        else
        {
            $data = $this->input->post();

            if($data['confirmpwd'] != $data['password']){
                $this->session->set_flashdata('invalid_reg', 'Passwords do not match');
                redirect(site_url('auth/register'));

            }else if($this->crud_m->checkIfExist(array('email' => $data['email']))){
                $this->session->set_flashdata('invalid_reg', 'Email already registered');
                redirect(site_url('auth/register'));
            }
            
            else{
                unset($data['confirmpwd']); // remove unwanted keys from array

                $data['uuid'] = $this->utility->uniqueID();
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                $data['last_login'] = date('Y-m-d H:i:s');
                $data['ip_address'] = $this->input->ip_address();
                $data['user_agent'] = $this->agent->agent_string();
                $data['token'] = $this->authorization->generateToken(['uuid' => $data['uuid'], 'password' => $data['password'], 'email' => $data['email']]);

                $auth = $this->crud_m->insert($data);

                if(!$auth){
                    $this->session->set_flashdata('invalid_reg', 'Could not create an account for you. Try again with correct details');
                    redirect(site_url('auth/register'));
                }
                else{
                    $this->session->set_userdata('user_id', $data['uuid']);
                    $this->session->set_userdata('sess_token', $data['token']);
                    redirect(site_url('dashboard'));
                }
            }
        }
    }

    public function logout(){
        session_unset();
        session_destroy();

        redirect(site_url('auth/login'));
    }

}