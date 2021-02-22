<?php
    class Admin_model extends CI_Model{

        private $admin_table = 'admin';
        private $system_table = 'system';
        
        function verifyLogin($loginData){   
            $this->db->where($loginData);
            $result = $this->db->get($this->admin_table);
            //echo $result->num_rows();
            if($result->num_rows() == 1){
                $admin_data = $result->row_array();
                $sess_token = $this->generateToken();
                $value = array('sess_token' => $sess_token);
                $this->db->where('id', $admin_data['id']);
                $this->db->update($this->admin_table, $value);
                return $sess_token;
            }
            else{
                return false;
            }
        }
        public function updateUserData($data, $condition = NULL){
            if($condition != NULL){
                $this->db->where($condition);
            }
            return $this->db->update('users', $data);
        }
        public function updateSettingsData($newData){
            return $this->db->update('system', $newData);
        }
        
        public function fetchAllData(array $data = NULL, array $columns = NULL, $table = 'wallet', $order = false){
            if(is_array($columns)){
                $this->db->select($columns);  
            }
            if ($order == true) {
                $this->db->order_by('created_at', 'DESC');
            }
            $this->db->join('users', 'users.uuid = '.$table.'.uuid');
            $query = $data == NULL ? $this->db->get($table) : $this->db->get_where($table, $data);
            return $query->result_array() ?? [];
    
        }
        public function getSystemData(){
            $this->db->where('id', 1);
            $result =  $this->db->get($this->system_table);
            return $result->row_array();
        }
        public function generateToken()
        {   
            $hashString = "";
            $all_chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            for($i = 0; $i < 2; $i++){
                $hashString .= str_shuffle($all_chars);
            }
            return $hashString; 
        }
    }