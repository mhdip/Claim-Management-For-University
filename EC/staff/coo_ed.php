

<?php include_once 'head.php'; ?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
         <?php
            //include_once 'base_url.php';
            require_once dirname(__DIR__).'/core/init.php';


            $user = new Staff();

            if($user->isLoggedIn()){
                //echo $user->data()->coo_name;
            
            if($user->hasPermission('admin')){
                //echo " you are administrator".'<br>';               
            
            include_once 'adminnav.php';
        ?>

        <!-- Page Content -->
        
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Update Coordinator Details</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    
                    <div class="col-lg-4">
                        

                   <div class="login-panel panel panel-default" style="margin-top:0px; margin-bottom:20px;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Update Coordinatr Details</h3>
                        </div>
                          <div class="zartan_semister">
                             <?php
                             	$id = Input::get('cod_id');
                                if(Token::check(Input::get('token'))){
                                    if(Input::exists()){


                                        $validate = new Validate();
                                        $validation = $validate->check($_POST, array(
                                            
                                        	'name' => array(
                                                    'required' => true,
                                                    
                                                    
                                                ),

                                            'email' => array(
                                                    'required' => true,
                                                    

                                                ),

                                           

                                            

                                            'faculty' => array(
                                                    'select' => true,
                                                    

                                                ),

                                            


                                        ));
                                        
                                        

                                        if($validation->passed()){
                                            //insert data
                                        	$c_id = Input::get('cod_id');
                                            //$salt = Hash::salt(32);
                                            /*$user = DB::getInstance()->update('ec_coo',$id,array(
                                              
                                                'coo_name'  => Input::get('name'),
                                                'coo_email' => Input::get('email'),
                                                'coo_password' => Hash::make(Input::get('password'), $salt),
                                                'salt'  => $salt,
                                                'fac_name' => Input::get('faculty'),
                                               	

                                           ));*/
                                           $name = Input::get('name');
                                           $email = Input::get('email');
                                           //$password = Hash::make(Input::get('password'),$salt);
                                           $faculty = Input::get('faculty');

                                           $user = DB::getInstance()->query("
                                           		UPDATE ec_coo
                                           		SET 
                                           	    coo_name = '$name',
                                           	    coo_email = '$email',
                                           	    
                                           	    
                                           	    fac_name = '$faculty'
                                           	    WHERE coo_id = ?	
                                           	",array("$c_id"));
                                           	
                                           
                                        if($user){
                                        	

                                        	   Session::flash('coordinator_update','This data has been updated successfully');	
                                               Redirect::to('home.php');
                                        	   
                                                
                                               
                                            }else {
                                                echo "<div class='row'>";
                                                echo "<div class='col-lg-8 col-lg-offset-2'>";
                                                echo "<div id='zartan_error_message'>"; 
                                                echo "data doesn't update";
                                                
                                                echo "</div>"; 
                                                echo "</div>"; 
                                                echo "</div>"; 
                                            }

                                        }else {
                                                echo "<div class='row'>";
                                                echo "<div class='col-lg-8 col-lg-offset-2'>"; 
                                                echo "<div id='zartan_error_message'>";
                                            foreach ($validation->errors() as $error) {
                                                echo $error.'<br>';
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
                        		<?php

                        			$data = DB::getInstance()->query("SELECT * from ec_coo Where coo_id = '$id'");

                        			foreach ($data->results() as $data) {
                        					
                        					
                        		?>

                            <script type="text/javascript">
                                function clean(e){
                                        var textfield = document.getElementById(e);

                                        var regex = /[^a-z 0-9]/gi;

                                        textfield.value = textfield.value.replace(regex, "");

                                    }

                                     function email_clean(e){
                                        var textfield = document.getElementById(e);

                                        var regex = /[^a-z 0-9@._-]/gi;

                                        textfield.value = textfield.value.replace(regex, "");

                                    }
                            </script>
                            <form role="form" method="post" action="">
                            <fieldset>


                                
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control" id="name" onkeydown="clean('name')" onkeyup="clean('name')" type="text" name="name" required value="<?php echo $data->coo_name;?>">
                                            
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" id="email" onkeydown="email_clean('email')" onkeyup="email_clean('email')" type="email" name="email" required value="<?php echo $data->coo_email;?>">
                                            
                                </div>
                                <div class="form-group">
                                    <label>Select faculty</label>
                                    <select class="form-control" name="faculty" required >

                                        <option><?php echo $data->fac_name?></option>
                                            <?php
                                                $data = DB::getInstance()->query("SELECT * from faculty");

                                                foreach ($data->results() as $data) {
                                                   ?>
                                                    <option value="<?php echo $data->fac_name;?>"><?php echo $data->fac_name;?></option>

                                                   <?php
                                                }
                                            ?>
                                       
                                       
                                        
                                           
                                    </select>
                                </div>
                                <!--<div class="form-group">
                                    <label>password</label>
                                    <input class="form-control" id="password" type="password" name="password" required autocomplete="off">
                                            
                                </div>
                                 <div class="form-group">
                                    <label>Confirm password</label>
                                    <input class="form-control" id="password" type="password" name="confirm-password" required autocomplete="off">
                                            
                                </div>-->
                                

                                
           
                                   
                                    <!-- Change this to a button or input when using this as a form -->
                                    <input type="hidden" name="token" value="<?php echo Token::generate()?>">
                                    <input type = "submit" value="Update" class="btn btn-lg btn-success btn-block">
                                    
                                </fieldset>
                            </form>
                            <?php
                            	}
                            ?>
                        </div>
                    </div>
                </div>
                
                    
                  
                </div>

                </div>
                <!-- /.row -->
            </div>
           
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

       <?php include_once 'footer.php';?> 

      <?php
         }else {
            Redirect::to('home.php');
         }   
      ?> 
    <?php
        }else {
            Redirect::to('index.php');
        }
    ?> 

</body>

</html>
