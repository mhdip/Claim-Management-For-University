<?php
	require_once dirname(__DIR__).'/core/init.php';
    
	echo $claim_no = Input::get('cd');
	$filterid = filter_var($claim_no, FILTER_SANITIZE_NUMBER_INT);

	echo @$claim_accept = Input::get('decision');
    echo $claim_reject = Input::get('rdecision');
    echo $claim_default = Input::get('default');
    echo $std_id = Input::get('std_id');

	$user = new Staff();

	if($user->isLoggedIn()){

		if($user->hasPermission('coordinator')){
				
				if($claim_accept){
				
					$data = DB::getinstance()->query("
						UPDATE 
							claim 
						set 
							claim_feedback = 'accepted' 
						where 
							claim_no = ?",array("$filterid"));

					if($data){
						//echo "claim accepted";
						Session::flash('claim_acception','This claim has been accepted successfully');
						Redirect::to("claim_feedback.php?cd=$filterid");
					}else {
						echo "claim can't accept";
					}

				}else if($claim_reject) {
					
					$data = DB::getinstance()->query("
						UPDATE 
							claim 
						set 
							claim_feedback = 'rejected' 
						where 
							claim_no = ?",array("$filterid"));

					if($data){
						Session::flash('claim_rejection','This claim has been rejected successfully');
						Redirect::to("claim_feedback.php?cd=$filterid");
					}else {
						echo "claim can't reject";
					}
				}else if($claim_default){
					$data = DB::getinstance()->query("
						UPDATE 
							claim 
						set 
							claim_feedback = 'processing' 
						where 
							claim_no = ?",array("$filterid"));

					if($data){
						Session::flash('claim_default','This claim is under process');
						Redirect::to("claim_feedback.php?cd=$filterid");
					}else {
						echo "claim can't defult";
					}
				}	

					

				

		}else {
			Redirect::to('home.php');
		}

	}else {
		Redirect::to('index.php');
	}

?>