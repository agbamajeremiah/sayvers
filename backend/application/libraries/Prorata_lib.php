<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Prorata_lib{
    var $BASE_URL = 'https://api.prorata.xyz';
    var $payment_url,$verify_url;
    var $PBFPubKey, $SECKEY, $txn_prefix;
    protected $currency;
    var $post_data = array();
    var $CI;
    
    function __construct(){
        $this->CI = & get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->helper('form');

        // $this->CI->load->config('flutterwave');
        // $this->payment_url = $this->CI->config->item('payment_endpoint');
        // $this->verify_url = $this->CI->config->item('verify_endpoint');
        // $this->PBFPubKey = $this->CI->config->item('PBFPubKey');
        // $this->SECKEY = $this->CI->config->item('SECKEY');
        // //$this->currency = $this->CI->config->item('currency');
        // $this->txn_prefix = $this->CI->config->item('txn_prefix');
    }
    function get_request($url){
        $response = $this->curl_get($url);
        return $response;
    }
    function post_request($url, $data){
        $response = $this->curl_post($url, $data,TRUE);
        return $response;
    }
    function curl_get($url){
        $curl = curl_init();
        curl_setopt_array($curl, array(
    		CURLOPT_URL => $url,
    		CURLOPT_RETURNTRANSFER => true,
    		CURLOPT_CUSTOMREQUEST => "GET",
    		CURLOPT_HTTPHEADER => [
    			"content-type: application/json",
    			"cache-control: no-cache"
    		],
    	));
    	$response = curl_exec($curl);
    	
    	if($err = curl_error($curl)){
    	    curl_close($curl);
    	    return "CURL Error : ".$err;
    	}else{
        	curl_close($curl);
        	return $response;
        }
    }
    
    function curl_post($url, $data, $json_encode_data = FALSE){
        // print_r($url);
        // print_r($data);
        $data = ($json_encode_data)?json_encode($data):$data;
        $curl = curl_init();
        curl_setopt_array($curl, array(
    		CURLOPT_URL => $url,
    		CURLOPT_RETURNTRANSFER => true,
    		CURLOPT_CUSTOMREQUEST => "POST",
    		CURLOPT_POSTFIELDS => $data,
    		CURLOPT_HTTPHEADER => [
    			"content-type: application/json",
    			"cache-control: no-cache"
    		],
    	));
    	$response = curl_exec($curl);
    	print_r($response);
    	if($err = curl_error($curl)){
    	    curl_close($curl);
    	    return "CURL Error : ".$err;
    	}else{
        	curl_close($curl);
        	return $response;
        }
    }
}
