<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
     
class Wallet extends REST_Controller {
    
    protected $users_table = "users";
    protected $wallet_table = "wallet";
    protected $PAYMENT_BASE_URL = 'https://api.prorata.xyz';
    protected $currency = "USD";

    public function __construct() {
       parent::__construct();

    }
       
    /**
     * All POST request handled here
     *
     * @return Response
    */
    
    public function index_post(){
        $uuid = $this->input->post('uuid'); //Every endpoint here must pass the UUID and Sess_token
        $sess_token = $this->input->post('sess_token'); 
        $auth = $this->authorization->authValidate($sess_token); // Validate token
        
        //If UUID was not passed, reject the request and return 400 error
        if(!$uuid || empty($uuid)){
            $this->response(['status' => FALSE, 'message' => 'UUID is required to fetch user data'], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }
        
        // Fetch User from User's table in DB. Check this function in Crud_model.php
        // This data is available throughout this method. (Obviously ^-^ !)
        //If the User is not found in DB, return a 404 error.
        $data = $this->crud_m->fetch(['uuid' => $uuid]);
        if(!$data){
            $this->response(['status' => FALSE, 'message' => 'User not found. User has either been deleted or never existed'], REST_Controller::HTTP_NOT_FOUND);
            return;
        }

        // Confirm that the session token is valid if it's valid, update the token else return Unauthorized access.
        // User should be made to login again
        // Every request should return the new token 
        if(!$auth || !$auth['status'] || $auth['data']->uuid != $uuid){
            $this->response(['status' => FALSE, 'message' => 'Unauthorized access'], REST_Controller::HTTP_OK);
            return;
        }else{
            $new_token = $this->authorization->generateToken(['uuid' => $uuid, 'email' => $data->email]); // New token
            $this->crud_m->update(array('token' => $new_token), array('uuid' => $uuid));
            $data->token = $new_token; // Update the token stored in $data
        }

        //Get all the params passed to this method. Each parameter is an api endpoint. Pretty easy and straight forward right? I thought so too :-)
        // List of endpoints are
        // /api/v1/wallet/fund -POST
        // /api/v1/wallet/withdraw -POST
            ///api/v1/wallet/change_bankaccount
        // /api/v1/wallet/notifications -POST
        // /api/v1/wallet/countnotifications -POST
        // Remember any route in this method is a post request. selah!
        $args = func_get_args();
        if(empty($args)){
            $this->response(['status' => FALSE, 'message' => 'Operation not allowed'], REST_Controller::HTTP_NOT_FOUND);
            return;
        }else{
            // /api/v1/wallet/fund
            if($args[0] === "fund"){
                $amount = $this->input->post('amount');
                // $pin  = $this->input->post('tranx_pin');
                // Process the funding here
                if(true) { //strlen($pin) == 4  &&  password_verify($pin, $data->pin
                    //transaction data
                    $transaction_ref = 'TRX-'.time().''.mt_rand();
                    $this->load->library('Prorata_lib');
                    
                    $transaction_data = array(
                        'uuid' => $uuid,
                        'amount' => $amount,
                        'type' => 'funding',
                        'status' => 'pending', 
                        'currency' => $this->currency,
                        'transaction_ref' => $transaction_ref,
                        'created_at' => date('Y-m-d H:i:s')        
                    );
                    $transaction_id = $this->crud_m->insert( $transaction_data, 'transaction');
                    if($transaction_id){
                        // $payment_data = array(
                        //     'amount'=> $amount,
                        //     'currency' => 'USD',
                        //     'email' => $data->email,
                        //     'ref'=> $transaction_ref,
                        //     'redirect_url'=> '',
                        // );
                        //initiate payment
                        // $paymentRes = $this->prorata_lib->post_request( $this->PAYMENT_BASE_URL.'/pay/simplecollect', $payment_data);
                        // $responseObj = json_decode($paymentRes, true);
                        // print($responseObj);
                        // if($responseObj['status' == true] && isset($responseObj['data']['payment_url'])){
                        //     $this->response(['status' => TRUE, 'message' =>
                        //     'Fund added successfully', 
                        //     'data' => $responseObj['ddata']],
                        //      REST_Controller::HTTP_OK);
                        // }
                        // else{
                        //     $this->response(['status' => False, 'message' => 'Error occured. Try again!' ], REST_Controller::HTTP_NOT_IMPLEMENTED);
                        // }
                        // $this->response([$response], REST_Controller::HTTP_OK);
                         //wallet data
                        // $asset_data = array(
                        //     'uuid'  =>  $uuid,
                        //     'asset' => $amount,
                        //     'deposit_transaction_id' => $transaction_id,
                        //     'status' => 'pending',
                        //     'created_at' => date('Y-m-d H:i:s'),
                        // );
                        // $this->crud_m->insert( $asset_data, 'wallet');
                        $this->response(['status' => TRUE, 'message' =>
                         'Fund added successfully', 
                         'data' => ['amount' => $amount, 'ref' => $transaction_ref, 'payment_link' => "https://www.google.com".$transaction_ref]],
                          REST_Controller::HTTP_OK);
                    }
                    else{
                        $this->response(['status' => FALSE,  'message' => 'Error occured. Try again'], REST_Controller::HTTP_INTERNAL_SERVER_ERROR );
                    }
                   
                }
                else{
                    $this->response(['status' => FALSE,  'message' => 'Incorrect pin'], REST_Controller::HTTP_OK);
                }

            }
             // /api/v1/wallet/getaccount
             if($args[0] === "getaccount"){
                $wallet_data = $this->crud_m->fetchAll(array('uuid' => $uuid, 'status'=> 'active'), ['id', 'asset', 'earnings', 'status', 'created_at'], $this->wallet_table);
                if($wallet_data && !empty($wallet_data)){
                    $total_funds = 0;
                    foreach ($wallet_data as $wallet) {
                        $total_funds +=  ($wallet['asset'] + $wallet['earnings']);
                    }
                    //Do calculation for gain & loss here
                    $this->response(['status' => TRUE, 'message' => 'Account Received', 'data' => ['total_funds' => $total_funds,'gain' => 50, 'loss' => 5,
                    'wallet' => $wallet_data]], REST_Controller::HTTP_OK);
                }
                else{
                    $this->response(['status' => FALSE,  'message' => 'No active wallet'], REST_Controller::HTTP_OK );
                }   
            }
            // /api/v1/wallet/getbankdetails
            if($args[0] === "getbankdetails"){
               if(empty($data->bank_account_number) || empty($data->bank_name)){
                    $this->response(['status' => FALSE,  'message' => 'No bank account saved'], REST_Controller::HTTP_OK );
               }
               else{
                    $bank_details = array(
                        'account_number' => $data->bank_account_number,
                        'bank_name' => $data->bank_name,
                    );
                    $this->response(['status' => TRUE,  'message' => 'Bank Details Recived', 'data' => $bank_details], REST_Controller::HTTP_OK );
               }
            }

            // /api/v1/wallet/withdraw
            if($args[0] === "withdraw"){
                $amount         = $this->input->post('amount');
                $withdrawType   = $this->input->post('withdrawalType'); // Can be any of ['asset', 'earnings', 'asset + earnings'];
                $pin            = $this->input->post('tranx_pin');
                $walletId       = $this->input->post('walletId');
                // Process the withdrawal here
                if(empty($walletId) || empty($amount) || empty($withdrawType) || empty($pin)){
                    $this->response(['status' => FALSE, 'message' => 'Invalid parameters'], REST_Controller::HTTP_BAD_REQUEST);
                }
                else{
                    if(strlen($pin) == 4  &&  password_verify($pin, $data->pin)) {
                        $wallet_data = $this->crud_m->fetch_array(array('id' => $walletId), 'wallet');
                        // print_r(($wallet_data));
                        // Check if wallet is active and is the user withdrawing
                        if($wallet_data['status'] !== 'active' || $wallet_data['uuid'] !== $uuid){
                            $this->response(['status' => FALSE, 'message' => 'Operation not allowed!'], REST_Controller::HTTP_METHOD_NOT_ALLOWED);
                            return;
                        }
                         //transaction data
                         $transaction_ref = 'TRX-'.time().''.mt_rand();
                         $transaction_data = array(
                             'uuid' => $uuid,
                             'amount' => $amount,
                             'type' => 'withdraw',
                             'status' => 'pending', 
                             'currency' => 'USD',
                             'transaction_ref' => $transaction_ref,
                             'created_at' => date('Y-m-d H:i:s')        
                         );
                         //Withdrawal data
                         $withdrawalData = array(
                            'uuid' => $uuid,
                            'wallet_id' => $wallet_data['id'],
                            'amount' => $amount,
                            'status' => 'pending',
                            'created_at' => date('Y-m-d H:i:s'),
                            'account_number'  => $data->bank_account_number,
                            'bank_name' => $data->bank_name,
                         );

                        $response  = '';
                        $status = false;
                        switch ($withdrawType) {
                            // Withraw asset only
                            case 'asset':
                                // Check wallet asset ballance
                                if($wallet_data['asset'] < $amount ){
                                    $response = "Insufficient Balance!";
                                }
                                else{
                                    $newWalletData = [];
                                    $newWalletData =  array('asset' =>  0, 'status' => 'closed' );
                                    // Insert transaction data
                                    $transaction_id = $this->crud_m->insert( $transaction_data, 'transaction');
                                    if($transaction_id){
                                        $this->crud_m->insert($withdrawalData, 'withdrawals');
                                        $this->crud_m->update($newWalletData, array('id' => $wallet_data['id']), 'wallet');
                                        $status = true;
                                    } 
                                }  
                                break;
                             // Withdraw Earnings
                             case 'earnings':
                                // Check wallet asset ballance
                                if($wallet_data['earnings'] < $amount ){
                                    $response = "Insufficient Balance!";
                                }
                                else{
                                    $newWalletData = [];
                                    if($wallet_data['asset'] == 0){
                                        $newWalletData =  array('earnings' =>  0, 'status' => 'closed' );
                                    }
                                    else{
                                        $newWalletData =  array('earnings' =>  0 );
                                    }
                                    // Insert transaction data
                                    $transaction_id = $this->crud_m->insert( $transaction_data, 'transaction');
                                    if($transaction_id){
                                        $this->crud_m->insert($withdrawalData, 'withdrawals');
                                        $this->crud_m->update($newWalletData, array('id' => $wallet_data['id']), 'wallet');
                                        $status = true;
                                    } 
                                }  
                                break;
                                // Withdraw from asset and earnings
                                case 'earnings_asset':
                                    // Check booth wallet asset & earnings ballance
                                    if( ($wallet_data['asset'] + $wallet_data['earnings'])  < $amount ){
                                        $response = "Insufficient Balance!";
                                    }
                                    else{
                                        $newWalletData =  array('asset' => 0, 'earnings' =>  0, 'status' => 'closed');
                                        // Insert transaction data
                                        $transaction_id = $this->crud_m->insert( $transaction_data, 'transaction');
                                        if($transaction_id){
                                            $this->crud_m->insert($withdrawalData, 'withdrawals');
                                            $this->crud_m->update($newWalletData, array('id' => $wallet_data['id']), 'wallet');
                                            $status = true;
                                        }     
                                    }  
                                    break;
                            
                            default:
                                $response = "Unknown Withdrawal Type";
                                break;
                        }
                        if($status){
                            $wallet_data = $this->crud_m->fetchAll(['uuid' => $uuid, 'status'=> 'active'], ['id', 'asset', 'earnings', 'status' , 'created_at'], $this->wallet_table);
                            // print_r($wallet_data);
                            if($wallet_data && !empty($wallet_data)){
                                $total_funds = 0;
                                foreach ($wallet_data as $wallet) {
                                    $total_funds +=  ($wallet['asset'] + $wallet['earnings']);
                                }
                                //Do calculation for gain & loss here
                                $this->response([
                                    'status' => TRUE,
                                'message' => 'Withdrawal Sent',  'data' => ['total_funds' => $total_funds,'gain' => 50, 'loss' => 5,
                                'wallet' => $wallet_data]], REST_Controller::HTTP_OK);
                            }
                            else{
                                $this->response([
                                    'status' => TRUE,
                                'message' => 'Withdrawal Sent',  'data' => "No active wallet"], REST_Controller::HTTP_OK);
                            }
                            
                        }
                        else{
                            $this->response([
                                'status' => FALSE,
                            'message' => $response], REST_Controller::HTTP_OK);

                        }
                }
                else{
                    $this->response(['status' => FALSE,  'message' => 'Incorrect pin'], REST_Controller::HTTP_OK);
                }
                   
               }
                
            }

            ///api/v1/wallet/change_bankaccount
            if($args[0] == "change_bankaccount"){
                $account_no     = $this->input->post('account_no');
                $bank_name     = $this->input->post('bank_name');
                $pin            = $this->input->post('tranx_pin');
                // Process the withdrawal here
                if(empty($account_no) || empty($bank_name) || empty($pin)){
                    $this->response(['status' => FALSE, 'message' => 'Invalid parameters'], REST_Controller::HTTP_BAD_REQUEST);
                }
                else{
                    if(strlen($pin) == 4  &&  password_verify($pin, $data->pin)) {
                        $updateData = array(
                            'bank_account_number' =>  $account_no,
                            'bank_name' => $bank_name,
                            'updated_at' => date('Y-m-d H:i:s')
                        );
                        $this->crud_m->update($updateData,  ['uuid' => $uuid]);
                        $accout_data = array('account_number' => $account_no, 'bank_name' => $bank_name);
                        $this->response(['status' => TRUE,  'message' => 'Bank account updated', 'data' => $accout_data], REST_Controller::HTTP_OK);
                    }
                    else{
                        $this->response(['status' => FALSE,  'message' => 'Incorrect pin'], REST_Controller::HTTP_OK);
                    }  
               }
            }


            // /api/v1/wallet/notifications
            if($args[0] === "notifications"){
                $this->db->where('uuid', $uuid);
                // $this->db->or_where(array('uuid' => ''));
                $notify = $this->db->get('notifications')->result_array() ?? false;
                if(!$notify){
                    $this->response(['status' => FALSE, 'message' => 'no new notification'], REST_Controller::HTTP_OK);
                }else{
                    $this->response(['status' => TRUE, 'sess_token' => $data->token, 'data' => $notify], REST_Controller::HTTP_OK);
                }
            }



            // /api/v1/wallet/deleteaccount
            if($args[0] === 'deleteaccount'){
                $this->crud_m->delete(array('uuid' => $uuid));
                $this->response(['status' => TRUE], REST_Controller::HTTP_OK);
            }




            // /api/v1/wallet/countnotifications
            if($args[0] === 'countnotifications'){
                $this->db->where('uuid', $uuid);
                // $this->db->or_where(array('uuid' => ''));
                $countNotification = $this->db->get('notifications')->num_rows();
                if(!$countNotification){
                    $this->response(['status' => FALSE, 'message' => 'no new notification'], REST_Controller::HTTP_OK);
                }else{
                    $this->response(['status' => TRUE, 'sess_token' => $data->token, 'data' => $countNotification], REST_Controller::HTTP_OK);
                }
            }
        }
    }
  
}