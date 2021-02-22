<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Utility {
    private $ci;

    protected $users_table = 'users';

    protected $tranx_table = 'tranx';

    public function __construct(){
        $this->ci =& get_instance();
    }

    public function getToken($length = 10, $type = 'string')
    {
        $token = "";
        if($type === 'string'){
            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        }else{
            $codeAlphabet = "0123456789";
        }

        $max = strlen($codeAlphabet) - 1;
        for ($i = 0; $i < $length; $i ++) {
            $token .= $codeAlphabet[$this->cryptoRandSecure(0, $max)];
        }
        return $token;
    }
    
    public function cryptoRandSecure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) {
            return $min; // not so random...
        }
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    public function uniqueID(){
        $exist = false;
        $uuid = '';
        do {
            $uuid = $this->getToken(20);
            $query = $this->ci->db->get_where($this->users_table, array('uuid' => $uuid));
            $exist = $query->num_rows() > 0 ? true : false;
        } while($exist);
        return $uuid;
    }

    public function uniqueTranxRef(){
        $exist = false;
        $ref = '';
        do {
            $ref = $this->getToken(15, true);
            $query = $this->ci->db->get_where($this->tranx_table, array('tranx_ref' => $ref));
            $exist = $query->num_rows() > 0 ? true : false;
        } while($exist);

        return $ref;
    }
    
    public function clearAuthCookie() {
        if (isset($_COOKIE["member_login"])) {
            setcookie("member_login", "");
        }
        if (isset($_COOKIE["random_password"])) {
            setcookie("random_password", "");
        }
        if (isset($_COOKIE["random_selector"])) {
            setcookie("random_selector", "");
        }
    }
}
?>