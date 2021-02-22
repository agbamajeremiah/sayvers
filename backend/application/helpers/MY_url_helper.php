<?php

function http_post($url, $data = array(), $options){
    $curl = curl_init($url);

    if(!empty($data)){
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    }
    curl_setopt($curl, CURLOPT_ENCODING, "");
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_TIMEOUT, 0);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);

    if(!empty($options)){
        curl_setopt($curl, CURLOPT_HTTPHEADER, $options);
    }
    

    $response = curl_exec($curl);
    curl_close($curl);
    
    return $response;
}

function http_get($url, $data = array(), $options){
    $getParams = '';
    if(!empty($data)){
        foreach($data as $k => $v) 
        { 
           $getParams .= $k . '='.$v.'&'; 
        }
        $getParams = rtrim($getParams, '&');
    }

    $url = $getParams === '' ? $url : $url .'?' .$getParams;
    

    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_ENCODING, "");
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_TIMEOUT, 0);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);

    if(!empty($options)){
        curl_setopt($curl, CURLOPT_HTTPHEADER, $options);
    }

    $response = curl_exec($curl);
    curl_close($curl);
    
    return $response;
   
}

function deduce_transfer_charge($amount){
    $ci =& get_instance();
    $chargesArray = $ci->config->item('wallet-transfer-charges');
    foreach($chargesArray as $k => $v){
        if($k != '^150000'){
            if($amount < (int)$k){
                return $v;
            }
        }else{
            return $v;
        }
        
    }
}