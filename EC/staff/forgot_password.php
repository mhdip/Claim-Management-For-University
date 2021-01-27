<?php
	
	include_once "head.php";
	require_once dirname(__DIR__).'/core/init.php';
	
?>

<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title" id="dip">Please Enter Your Email</h3>
                    </div>
                    <div class="zartan_login">
                    	<?php
                    		$email = Input::get('email');
                    		if(Token::check(Input::get('token'))){
                    			if(Input::exists()){
                    				$validate = new validate();
                                    $validation = $validate->check($_POST, array(
                                        'email'    => array('required' => true),

                                        
                                    ));

                                    if($validation->passed()){
                                    	$db = DB::getInstance()->query("SELECT * from ec_coo where coo_email = ?",array("$email"));

                                    	if(!$db->count()){
                                    		echo "<div id='zartan_login_error_message'>";
                                    		echo "The Email you have entered, does not exists in our database";
                                    		echo "</div>";
                                    	}else {


                                            $code = rand(1000,100000);

                                            $data = DB::getInstance()->query("UPDATE ec_coo set code='$code' where coo_email='$email'");

                                    		 $message = "

                                            <p style='background:#897468;color:white;padding:10px;'>
                                            Hello, ". $email .'<br>' .'<br>'.
                                            nl2br("We've got request to reset your password, click the link to reset your password. <br> 
                                                
                                                <a href='http://localhost/ec/staff/r_pass.php'><b>Click This Link to Reset Your Password</b></a> 
                                            </p>"

                                             ); 
                                    		


                                    		
                                    		$subject = "Password Recovery";

                                            Session::put('password_code',$code);

                                    		Mail::Send_mail($email,$subject,$message);

                                           
                                            
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
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" required  value="<?php echo escape(Input::get('email'));?>" autofocus>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="hidden" name="token" value="<?php echo Token::generate()?>">
                                <input type = "submit" value="Send" class="btn btn-lg btn-primary btn-block">
                                <hr/>
								



                            </fieldset>
                        </form>
                        <div class="checkbox" style="margin-top: 0px;">
                                    
                            <a href="index.php" onclick="return confirm('Are you sure to leave this page')"><button class="btn btn-xs-3 btn-primary">Back to Login</button></a>
                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>