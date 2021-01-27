<?php
   require_once dirname(__DIR__).'/core/init.php';

     /*$user = new User();
     //$user->logout(Config::get('session/session_name_3'));

     if($user->logout(config::get('session/session_name_1'))){
    	Redirect::to('index.php');
    }else if($user->logout(config::get('session/session_name_2'))){
    	Redirect::to('index.php');
    }else if($user->logout(config::get('session/session_name_4'))){
    	Redirect::to('index.php');
    }else if($user->logout(config::get('session/session_name_3'))){
    	Redirect::to('index.php');
    }*/

    Session_destroy();


    Redirect::to('index.php');
?>