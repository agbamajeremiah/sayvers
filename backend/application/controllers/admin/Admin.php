<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {
		parent:: __construct();
		$this->load->library('session');
		$this->load->model('admin_model');
		$this->load->model('crud_model');
	}

	public function index()
	{
		$token = $this->session->token;
		$logged_in_status= $this->session->logged_in;
		if(isset($this->session->token) && isset($this->session->logged_in)){
			echo "user_logged_id";
			redirect(base_url()."admin\dashboard");
		}
		else{
			redirect(base_url()."admin\login");
		}
		
	}
	public function login()
	{
		$this->load->view('admin/admin_login');
	}
	public function process_login()
	{
		$this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'username', 'required', 
         array('required' => '*%s required.'));
        $this->form_validation->set_rules('password', 'password', 'required',
                array('required' => '*%s required.')
        );
        if ($this->form_validation->run() == FALSE)
        {
                $this->load->view('admin/admin_login');
        }
        else
        {
                $username = $this->input->post('username');
				$password = $this->input->post('password');
				$loginData = array(
					'username'  => $username,
					'password'     => $password
				);
				$res = $this->admin_model->verifyLogin($loginData);
                if($res){
					$userData = array(
						'username'  => $username,
						'token'     => $res,
						'logged_in' => TRUE
					);
					$this->session->set_userdata($userData);
					redirect(base_url()."admin\dashboard");
                }
                else{
					$this->session->set_flashdata('message', 'Invalid username or password!');
					redirect(base_url()."admin\login");
                }
                
        }
	}
	public function fund_user(){
		if(!isset($this->session->token) || !isset($this->session->logged_in)){
			$this->send_response(401);
		}
		else{
			$userId = $this->input->post('userId');
			$amount = $this->input->post('amount');
			if(!isset($userId) || empty($userId)){
				$this->send_response(400);
			}
			$data = $this->crud_m->fetch(['id' => $userId]);

			//  transaction data
			 $transaction_ref = 'TRX-'.time().''.mt_rand();
			 $transaction_data = array(
				 'uuid' => $data->uuid,
				 'amount' => $amount,
				 'type' => 'funding',
				 'status' => 'successful', 
				 'currency' => 'USD',
				 'transaction_ref' => $transaction_ref,
				 'created_at' => date('Y-m-d H:i:s')        
			 );
			 $transaction_id = $this->crud_m->insert( $transaction_data, 'transaction');
			 if($transaction_id){
				  //wallet data
				 $asset_data = array(
					 'uuid'  =>  $data->uuid,
					 'asset' => $amount,
					 'deposit_transaction_id' => $transaction_id,
					 'status' => 'active',
					 'created_at' => date('Y-m-d H:i:s'),
				 );
				 $this->crud_m->insert( $asset_data, 'wallet');
				 $return_data = array('status' => TRUE, 'message' => 'Fund added successfully');
				 $this->send_response(200, $return_data);
			 }
			 else{
				$this->send_response(500, array('status' => FALSE));

			 }
		}
	}
	public function block_user(){
		if(!isset($this->session->token) || !isset($this->session->logged_in)){
			$this->send_response(401);
		}
		else{
			$userId = $this->input->post('userId');
			if(!isset($userId) || empty($userId)){
				$this->send_response(400);
			}
			$this->admin_model->updateUserData(array('status' => 'blocked'), array('id' => $userId));
			$data = array('status' => true, 'message' => 'User blocked successfully');
			$this->send_response(200, $data);
		}
	}
	public function process_withdrawal($withdrawal_id){
		echo $withdrawal_id;
		$this->load->library(['prorata_lib']);
		$this->prorata_lib->get_banks('NG');

		
	}
	public function unblock_user(){
		if(!isset($this->session->token) || !isset($this->session->logged_in)){
			$this->send_response(401);
		}
		else{
			$userId = $this->input->post('userId');
			if(!isset($userId) || empty($userId)){
				$this->send_response(400);
			}
			$this->admin_model->updateUserData(array('status' => 'active'), array('id' => $userId));
			$data = array('status' => true, 'message' => 'User unblocked successfully');
			$this->send_response(200, $data );
		}
	}
	public function update_settings(){
		if(!isset($this->session->token) || !isset($this->session->logged_in)){
			$this->send_response(401);
		}
		else{
			$profit = $this->input->post('profit');
			$tranx_fee = $this->input->post('tranx_fee');
			$app_version = $this->input->post('app_version');
			if(!isset($profit) || empty($profit) || empty($tranx_fee) || empty($app_version) ){
				$this->send_response(400, array('message' => "Invalid data"));
			}
			$newData = array('current_profit' => (float)$profit, 'transaction_percent' => (float)$tranx_fee, 'app_version' => $app_version, 'last_updated' =>  date('Y-m-d H:i:s'));
			$this->admin_model->updateSettingsData($newData);
			$data = array('status' => true, 'message' => 'Settings Updated successfully');
			$this->send_response(200, $data );
		}
	}
	public function dashboard()
	{
		if(!isset($this->session->token) || !isset($this->session->logged_in)){
			redirect(base_url()."admin\login");
		}
		
		$data['active_users'] = $this->crud_model->countActiveUsers();
		$data['active_wallets'] = $this->crud_model->countActiveWallets();
		$data['total_tranx'] = $this->crud_model->countTranx();
		$data['current_profit'] = $this->crud_model->getSystemData('current_profit');


		$this->load->view('admin/dashboard', $data); 
	}
	public function users()
	{
		if(!isset($this->session->token) || !isset($this->session->logged_in)){
			redirect(base_url()."admin\login");
		}
		$required_columns = array('id', 'firstname', 'lastname', 'status', 'created_at');
		$data['active_users'] = $this->crud_model->fetchAll(null, $required_columns);
		// print_r(($data['all_wallet']));
		$this->load->view('admin/manage_users', $data );
	}
	public function wallets()
	{
		if(!isset($this->session->token) || !isset($this->session->logged_in)){
			redirect(base_url()."admin\login");
		}
		$required_columns = array('wallet.id', 'firstname', 'lastname', 'asset', 'earnings', 'wallet.status', 'wallet.created_at');
		$data['all_wallet'] = $this->admin_model->fetchAllData(null, $required_columns, 'wallet');
		// print_r(($data['all_wallet']));
		$this->load->view('admin/wallet_view', $data);
	}
	public function withdrawals()
	{
		if(!isset($this->session->token) || !isset($this->session->logged_in)){
			redirect(base_url()."admin\login");
		}
		$required_columns = array('withdrawals.id', 'firstname', 'lastname', 'amount', 'withdrawals.status', 'withdrawals.created_at');
		$data['all_withdrawals'] = $this->admin_model->fetchAllData(null, $required_columns, 'withdrawals');
		// print_r(($data['all_wallet']));
		$this->load->view('admin/withdrawal_view', $data);
	}
	public function settings(){
		if(!isset($this->session->token) || !isset($this->session->logged_in)){
			redirect(base_url()."admin\login");
		}
		$data['system_data'] = $this->admin_model->getSystemData();
		$this->load->view('admin/settings_view', $data);
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url()."admin\login");
	}
	public function send_response($status_code = 200, $data = null){
		header('Content-Type: application/json');
		http_response_code($status_code);
		$response = json_encode($data);
		echo $response;
	}

}
