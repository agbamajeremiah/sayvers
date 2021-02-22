<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------
| Session tmeout for inactivity in seconds
| default: 30 minutes
|--------------------------------------------------------------------------
*/
$config['sesson_timeout'] = 1800; 
/*
|-----------------------
| JWT Algorithm Type
|--------------------------------------------------------------------------
*/
$config['access_type'] = 'strict';

$config['max_attempts'] = 5;

/*
|-----------------------
| Token Request Header Name
|--------------------------------------------------------------------------
*/
$config['allow_multiple_login'] = false;
/*
|-----------------------
| Token Expire Time
| https://www.tools4noobs.com/online_tools/hh_mm_ss_to_seconds/
|--------------------------------------------------------------------------
*/
$config['auto_change_pwd_with_ip'] = false;

$config['password_expires'] = false;


$config['otp_enabled'] = false;


$config['otp_agent'] = 'email';


$config['users_table'] = 'users';

$config['cookie_name']      = 'autologin';

$config['cookie_encrypt']   = TRUE;

$config['autologin_table']  = 'autologin';

$config['autologin_expire'] = 86400; // 5184000 60 days

$config['hash_algorithm']   = 'sha256';