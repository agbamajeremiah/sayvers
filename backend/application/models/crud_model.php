<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_model extends CI_Model {

    protected $users_table = "users";
    protected $tranx_table = "transaction";
    protected $wallet_table = "wallet";
    protected $system_table = "system";

    


    function __construct(){
        parent::__construct();
        //$this->user_id = @$this->session->userdata('user_id') ?? null;
    }

    public function fetch( array $data, $table = 'users'){
        if(!empty($data)){
            return $this->db->get_where($table, $data)->row() ?? false;
        }else{
            return $this->db->get($table)->row() ?? false;
        }
        
    }

    public function fetch_array( array $data, $table = 'users'){
        if(!empty($data)){
            $this->db->where($data);
        }
        return $this->db->get($table)
            ->row_array() ?? false;
    }

    public function fetchAll(array $data = NULL, array $columns = NULL, $table = 'users'){
        if($table == 'users'){
            $this->db->where('user_role !=', 1);
        }
        if(is_array($columns)){
            $this->db->select($columns);  
        }
        if ($table == 'wallet') {
            $this->db->order_by('created_at', 'DESC');
        }
        $query = $data == NULL ? $this->db->get($table) : $this->db->get_where($table, $data);
        return $query->result_array() ?? [];

    }

    public function update(array $data, $cond, $table = 'users'){
        if(is_array($cond)){
            $this->db->where($cond);
        }else{
            $this->db->where($cond, $data[$cond]);
        }
        return $this->db->update($table, $data);
    }

    public function insert(array $data, $table = 'users'){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function delete(array $data, $table = 'users'){
        $this->db->delete($table, $data);
    }

    public function checkIfExist(array $data, string $table = 'users'){
        $query = $this->db->get_where($table, $data);
        return $query->num_rows() ?? false;
    }

    public function checkIfAnotherExist(array $data, $table = 'users'){
        $this->db->where('uuid !=', $data['uuid']);
        unset($data['uuid']);
        $this->db->where($data);
        $query = $this->db->get($table);
        return $query->num_rows() ?? false;
    }

    // Currently not being used as it makes no point $this->fetch() does the job.
    public function login( array $data ){
        $check_user = $this->db->get_where($this->users_table, $data);
        return $check_user->row() ?? false;
    }

    public function countUsers(){
        $this->db->where('user_role !=', 1);
        return $this->db->get($this->users_table)
            ->num_rows();
    }

    public function countActiveWallets(){
        $this->db->where('status', 'active');
        return $this->db->get($this->wallet_table)
            ->num_rows();
    }

    public function countTranx(){
        return $this->db->get($this->tranx_table)
            ->num_rows();
    }

    public function countBlockedUsers(){
        $this->db->where('user_role !=', 1);
        $this->db->where('status', 'blocked');
        return $this->db->get($this->users_table)
            ->num_rows();
    }

    public function countActiveUsers(){
        $this->db->where('user_role !=', 1);
        $this->db->where('status', 'active');
        return $this->db->get($this->users_table)
            ->num_rows();
    }
    
    public function getSystemData($singleData){
        $systemData = $this->db->get($this->system_table)->row_array();
        if(isset($singleData)){
            // print_r($systemData);
            return $systemData[$singleData];
        }
        else{
            return $systemData;
        }
    }
    //////////////////////////////// API MODELS ///////////////////////////////////////

    public function getTranx($num){
        // first check if there is a transaction for today

        $this->db->select('(SELECT SUM(tranx.amount) FROM tranx WHERE tranx.receiver='.$num.' AND DATE(created_at) = CURDATE()) AS amount_sent', FALSE);
        $query = $this->db->get('tranx');
        // print_r($query->result());
        $result = $query->row();

        return !empty($result->amount_sent) ? $result : false;

    }
    public function getWallet($uuid){
        return $this->fetch([], 'wallets');
    }

    public function notify($uuid = '', $title, $message){
        $data = array(
            'uuid' => $uuid,
            'title' => $title,
            'message' => $message,
            'status' => 'unread'
        );

        $this->crud_m->insert($data, 'notifications');
    }

    public function sendmail($data){
        
    }
}
