<!DOCTYPE html>
<html lang="en">

<?php include_once 'head.php';?>
 <?php require_once dirname(__DIR__).'/core/init.php'; ?>

<body style="background:#FAE5D3 ">
  <div style="float:right; margin-right:5px;">
    <a style="color:white;text-decoration:none;" href="../std/index.php"><button class="btn btn-xs btn-danger">Student</button></a>

  </div>
   

    <?php
        if(Session::exists(Config::get('session/session_name_2'))){
            Redirect::to('home.php');

            if(Session::exists(Config::get('session/session_name_1'))){
              Redirect::to('../std/home.php');
            }

         }else {
            
    
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Staff Area </h3>
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
                                        $user = new Staff();
                                        #login user by their email and passowrd
                                        $login = $user->staff_login(Input::get('email'),Input::get('password'));
                                        
                                        
                                        #if login success then redirect user home page

                                        if($login){
                                           Redirect::to('home.php');

                                       }else {
                                           echo "<div class='row'>";
                                           echo "<div class='col-lg-8 col-lg-offset-2'>";
                                           echo "<div id='zartan_login_error_message'>"; 
                                           echo "Enter correct email and password";
                                           echo "</div>";
                                           echo "</div>";
                                           echo "</div>"; 
                                        }

                                    }else {
                                        echo "<div class='row'>";
                                        echo "<div class='col-lg-8 col-lg-offset-2'>"; 
                                        echo "<div id='zartan_login_error_message'>";
                                        foreach ($validation->errors() as $error) {
                                          echo $error. '<br>';  
                                        }
                                        echo "</div>";
                                        echo "</div>";
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
                                    
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="hidden" name="token" value="<?php echo Token::generate()?>">
                                <input type = "submit" value="Let me in" class="btn btn-lg btn-success btn-block">
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

    <!-- jQuery -->
    <script src="../../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../../vendor/raphael/raphael.min.js"></script>
    <script src="../../vendor/morrisjs/morris.min.js"></script>
    <script src="../../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>

   <?php
        }
   ?>

</body>

</html>
