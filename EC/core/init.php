<?php
//this page must include all over the page
ob_start();
session_start();
$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => '127.0.0.1',
		'username' => 'root',
		'password' => '',
		'db' => 'ec'
		),
    
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 60800
		),

	'session' => array(
			'session_name_1' => 'user',
			'session_name_2' => 'staff',
			'token_name'    => 'token'
		)

	);

spl_autoload_register(function($class){
	require_once dirname(__DIR__).'/classes/'.$class.'.php';
});

require_once dirname(__DIR__).'/function/sanitize.php'
?>