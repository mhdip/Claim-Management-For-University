<!DOCTYPE html>
<html lang="en">

<?php include_once 'head.php';?>

<body style="background-image: url('../images/std_back.jpg');">
    <?php 
    require_once dirname(__DIR__).'/core/init.php';
        
           
      ?>



    <?php
        if(Session::exists(Config::get('session/session_name_1'))){
            Redirect::to('home.php');

            if(Session::exists(Config::get('session/session_name_2'))){
              Redirect::to('../staff/home.php');
            }

         }else {
            
          
    
    ?>
    <div style="float:right;color:white;margin-right: 5px;">
        <a style="color:white;text-decoration:none;" href="../staff/index.php"><button class="btn btn-xs btn-danger">Staff</button></a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title" id="dip">Please Sign In</h3>
                    </div>
                      <?php 
                          echo "<span style='color:green;'>".Session::flash('forgont_password')."</span>";
                          Session::delete('forgont_password');
                        ?>
                     
                    <div class="zartan_login">
                          
                          <?php

                              #for login studen  

                              if(Token::check(Input::get('token'))){
                                if(Input::exists()){
                                    $validate = new validate();
                                    $validation = $validate->check($_POST, array(
                                        'email'    => array('required' => true),
                                        'password' => array('required' => true), 

                                    ));

                                    if($validation->passed()){
                                        $user = new User();
                                        #login user by their email and passowrd
                                        $login = $user->login(Input::get('email'),Input::get('password'));
                                        
                                        
                                        #if login success then redirect user home page

                                        if($login){
                                           Redirect::to('home.php');
                                           
                                       }else {
                                           echo "<div id='zartan_login_error_message'>"; 
                                           echo "Enter correct email and password";
                                           echo "</div>"; 
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
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" value="<?php echo escape(Input::get('email'));?>" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <!--<label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>-->
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="hidden" name="token" value="<?php echo Token::generate()?>">
                                <input type = "submit" value="Let me in" class="btn btn-lg btn-info btn-block">
								<div class="checkbox">
                                    
                                       <a href="forgot_password.php">Forgot Password?</a>
                                    
                                </div>

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <?php include_once 'footer.php';?>

   <?php
        }
   ?>

</body>

</html>
