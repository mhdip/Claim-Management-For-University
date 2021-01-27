<?php
	
	include_once "head.php";
	require_once dirname(__DIR__).'/core/init.php';
	
	

   if(Session::exists('password_code')){

   



?>

<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title" id="dip">Please Enter New password</h3>
                    </div>
                    <div class="zartan_login">
                    	<?php
                    		//$password = Input::get('password');
                    		
                    		if(Token::check(Input::get('token'))){
                    			if(Input::exists()){
                    				$validate = new validate();
                                    $validation = $validate->check($_POST, array(
                                        'code'    => array('required' => true),
                                        'new-password'    => array(
                                        	'required' => true,
                                        	'minimum' => 6l
                                        	),
                                        'confirm-password'    => array(
                                        		'required' => true,
                                        		'matches' => 'new-password'
                                        	),

                                        
                                    ));

                                    if($validation->passed()){

                                    	$code = Input::get('code');
                                    	$salt = Hash::salt(32);
                                    	//$password = Hash::make(Input::get('new-password'),$salt);
                                    	$password = Hash::make(Input::get('new-password'),$salt);

                                    	$data = DB::getInstance()->query("UPDATE ec_coo set coo_password = '$password', salt= '$salt' where code = ?",array("$code"));

                                    	if($data){
                                    		Session::delete('password_code');
                                    		Session::flash('forgont_password','Password has been updated successfully, login now');
                                    		Redirect::to('index.php');
                                    	}else {
                                    		echo "not updated";
                                    	}

                                    }else {
                                        echo "<div id='zartan_login_error_message'>";
                                        foreach ($validation->errors() as $error) {
                                          echo $error. '<br>';  
                                        }
                                        echo "</div>";
                                    }
                    			}
                    		}
                    	?>
                    </div>

                    <div class="panel-body">
                        <form role="form" action="" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="code" name="code" type="hidden"  value="<?php echo Session::get('password_code')?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="new password" name="new-password" type="password" >
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="confirm password" name="confirm-password" type="password" >
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="hidden" name="token" value="<?php echo Token::generate()?>">
                                <input type = "submit" value="Change" class="btn btn-lg btn-danger btn-block">
                               
								



                            </fieldset>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php 
    	}else {
    		Redirect::to('index.php');
    	}
    ?>