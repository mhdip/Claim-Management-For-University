<?php
   require_once dirname(__DIR__).'/core/init.php';

    $user = new Staff();

    if($user->isLoggedIn()){
    	//session data
    	if($user->hasPermission('admin')){

    		echo $id = Input::get('id');
    		
    		$user = DB::getinstance()->query("DELETE from assessment where assess_code = $id");
    		if($user){
    			Session::flash('assessment_delete','This data has been deleted successfully');
    			Redirect::to('assessment.php');
    		}


    	}else {
    		Redirect::to('home.php');
    	}
    }else {
    	Redirect::to('index.php');
    }
?>