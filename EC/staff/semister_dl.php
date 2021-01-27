<?php
    require_once dirname(__DIR__).'/core/init.php';

    $user = new Staff();

    if($user->isLoggedIn()){
    	//session data
    	if($user->hasPermission('admin')){

    		echo $id = Input::get('id');
    		
    		$user = DB::getinstance()->query("DELETE FROM semister WHERE id='$id'");
    		if($user){
    			Session::flash('semister_delete','This data has been deleted successfully');
    			Redirect::to('semister.php');
    		}else {
    			Session::delete('semister_delete');
    			Redirect::to('semister.php');
    		}


    	}else {
    		Redirect::to('home.php');
    	}
    }else {
    	Redirect::to('index.php');
    }
?>