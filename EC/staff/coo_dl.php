<?php
    require_once dirname(__DIR__).'/core/init.php';

    $user = new Staff();

    if($user->isLoggedIn()){
    	//session data
    	if($user->hasPermission('admin')){

    		echo $id = Input::get('coo_id');
    		
    		$user = DB::getinstance()->query("DELETE FROM ec_coo WHERE coo_id='$id'");
    		if($user){
    			Session::flash('coo_delete','This data has been deleted successfully');
    			Redirect::to('home.php');
    		}
            

    	}else {
    		Redirect::to('home.php');
    	}
    }else {
    	Redirect::to('index.php');
    }
?>