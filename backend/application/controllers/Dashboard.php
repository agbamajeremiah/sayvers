<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    public function __construct(){
        parent::__construct();
    }

	public function index()
	{
		$data['count_users'] = $this->crud_m->countUsers();
		$data['count_tranx'] = $this->crud_m->countTranx();
		$data['count_blocked'] = $this->crud_m->countBlockedUsers();
		$data['count_active'] = $this->crud_m->countActiveUsers();
		$data['wallet_balance'] = $this->wallet_balance();
		$data['users'] = $this->crud_m->fetchAll();
		$this->load->template('dashboard', $data);
	}

	public function users()
	{
		$this->index();
	}

	public function wallet_balance(){
		$postRequest = array(
			'currency' => $this->input->post('currency'),
			'SecretKey' => $this->config->item('wallet-secretKey')
		);

		$response = http_post($this->config->item('api-wallet-base-url') ."self/balance", $postRequest, array(
			'Content-Type: application/x-www-form-urlencoded',
			"Authorization: Bearer ". $this->config->item('wallet-publicKey')
		)); 
		$response = json_decode($response, true);
		// update db
		$this->crud_m->update(array('balance' => $response['Data']['WalletBalance']), array('id' => 1), 'account');
		return $response['Data']['WalletBalance'];
	}

	public function active_users()
	{
        $data['users'] = $this->crud_m->fetchAll(array('status' => 'active'));
		$this->load->template('active_users', $data);
	}

	public function blocked_users()
	{
        $data['users'] = $this->crud_m->fetchAll(array('status' => 'blocked'));
		$this->load->template('blocked_users', $data);
	}

	public function edit_user($id, $action = "edit"){
		if($action === 'edit'){
			$data['user'] = $this->crud_m->fetch(array('uuid' => $id));
			$this->load->template('edit_user', $data);
		}else if($action === 'activate'){
			$this->crud_m->update(array('status' => 'active'), array('uuid' => $id));
			redirect(site_url('dashboard'));
		}else if($action === 'block'){
			$this->crud_m->update(array('status' => 'blocked'), array('uuid' => $id));
			redirect(site_url('dashboard'));
		}
	}

	public function delete_user($id){
		$this->crud_m->delete(array('uuid' => $id));
		redirect(site_url('dashboard'));
	}

	public function edit($id){
		$user = $this->crud_m->fetch(array('uuid' => $id));

		$data = $this->input->post();
		$data['uuid'] = $id;

		if($data['password']){
			if($data['confirmpwd'] != $data['password']){
				$this->session->set_flashdata('invalid_reg', 'Passwords do not match');
				redirect(site_url("dashboard/edit_user/$id"));
			}

			$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
		}else{
			$data['password'] = $user->password;
		}

		if($this->crud_m->checkIfAnotherExist(array('email' => $data['email'], 'uuid' => $data['uuid']))){
			$this->session->set_flashdata('invalid_reg', 'Email already registered');
			redirect(site_url("dashboard/edit_user/$id"));
		}
		
		else{
			unset($data['confirmpwd']); // remove unwanted keys from array
			$data['token'] = $this->authorization->generateToken(['uuid' => $data['uuid'], 'password' => $data['password'], 'email' => $data['email']]);
			$this->crud_m->update($data, 'uuid');
			redirect(site_url('dashboard'));
		}
	}
}
