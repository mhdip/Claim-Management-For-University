

<?php 
include_once 'head.php';
require_once dirname(__DIR__).'/core/init.php'; 

?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
         <?php
            //include_once 'base_url.php';
           

            $user = new staff();

            if($user->isLoggedIn()){

                

                    
              
            $coo_id = $user->data()->coo_id;
            $coo_email = $user->data()->coo_email;

            include_once 'adminnav.php';
        ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Profile and Settings</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                 
                 </div>   
                <div class="row">   
                    <div class="col-lg-6">
                      <div class="panel panel-success">
                        <div class="panel-heading">
                           Your profile Details
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    
                                    <?php
                                        $data = DB::getInstance()->query("SELECT * From ec_coo where coo_id = ?",array("$coo_id"));

                                        if(!$data->count()){
                                            echo "<span style='color:red;'>No record found</span>";
                                        }else {
                                        ?>
                                               
                                            <thead>                                              
                                                <tr>
                                                    
                                                    <th>Info</th>
                                                    <th>Details</th>
                                                   
                                                </tr>
                                             </thead>
                                        <?php
                                        
                                       foreach ($data->results() as $data) {
                                           
                                       
                                            
                                              
                                         
                                    ?>

                                    <tbody>
                                        <tr class="success">
                                            
                                            <td>First Name</td>
                                            <td><?php echo $data->coo_name?></td>
                                            
                                             
                                        </tr>
                                        <tr class="success">
                                            
                                            <td>Email</td>
                                            <td><?php echo $data->coo_email?></td>
                                            
                                             
                                        </tr>
                                     
                                    </tbody>
                                    <?php
                                          } 
                                        }
                                    ?>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>

                   <div class="col-lg-6">
                      <div class="panel panel-danger">
                        <div class="panel-heading">
                           Chanage Your Email
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="zartan_login">
                        <?php
                           
                            if(Token::check(Input::get('token'))){
                               
                                if(isset($_POST['submit_1'])){
                                    $validate = new validate();
                                    $validation = $validate->check($_POST, array(
                                        'email'    => array('required' => true),

                                        
                                    ));

                                    if($validation->passed()){
                                        $email = Input::get('email');
                                        $coo_id = $user->data()->coo_id;
                                        $data = DB::getInstance()->query("SELECT * from ec_coo where coo_email = ?",array("$email"));

                                        if($data->count()){
                                            echo "<div id='zartan_error_message'>";
                                            echo "This email is not available, Choose another";
                                            echo "</div>";
                                        }else {
                                           $data = DB::getInstance()->query("UPDATE ec_coo set coo_email = '$email' where coo_id =?",array("$coo_id"));

                                           if($data){
                                                echo "<div id='zartan_success_message'>";
                                                echo "The email has updated successfully";
                                                echo "</div>";
                                           }else {
                                            echo "not updated";
                                           }
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

                           <form role="form" action="" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" required  value="<?php echo $coo_email?>" autofocus>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="hidden" name="token" value="<?php echo Token::generate()?>">
                                <input type = "submit" value="Update" class="btn btn-lg btn-danger btn-block" name="submit_1">
                               
                                



                            </fieldset>
                        </form>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div> 
                  
                </div>

                <div class="row">
                    
                    <!-- /.col-lg-12 -->
                    

                    <div class="col-lg-6" id="h">
                      <div class="panel panel-primary">
                        <div class="panel-heading">
                           Chanage Your password
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="zartan_login">
                        <?php
                           
                           
                               
                                if(isset($_POST['submit'])){
                                    $validate = new validate();
                                    $validation = $validate->check($_POST, array(
                                        'current-password' => array(
                                                'required' => true,
                                                'minimum' => 6
                                            ),

                                        'new-password' => array(
                                                'required' => true,
                                                'minimum' => 6
                                            ),
                                        'confirm-password' => array(
                                                'required' => true,
                                                'matches' => 'new-password',
                                                'minimum' => 6
                                            ),

                                        
                                    ));

                                    if($validation->passed()){
                                        //echo "ok"; 
                                        $coo_id = $user->data()->coo_id;
                                        if(Hash::make(Input::get('current-password'), $user->data()->salt) !== $user->data()->coo_password){
                                            echo "<div id='zartan_error_message'>";
                                            echo "Your current password is wrong";
                                            echo "</div>";
                                        }else if(Hash::make(Input::get('new-password'), $user->data()->salt) === $user->data()->coo_password){
                                            echo "<div id='zartan_error_message'>";
                                            echo "You can't choose your current password as new password";
                                            echo "</div>";
                                        }else {
                                            $salt = Hash::salt(32);
                                            $new_password = Hash::make(Input::get('new-password'), $salt);

                                           $data = DB::getInstance()->query("UPDATE ec_coo set coo_password = '$new_password' , salt= '$salt' where coo_id = ?",array("$coo_id"));

                                           if($data){
                                                echo "<div id='zartan_success_message'>";
                                                echo "Password has been updated successfully";
                                                echo "</div>";
                                           }else {
                                              echo "not updated";
                                           }

                                        }
                                        
                                    }else {
                                        echo "<div id='zartan_error_message'>";
                                        foreach ($validation->errors() as $error) {
                                          echo $error. '<br>';  
                                        }
                                        echo "</div>";
                                    }
                                }
                            
                        ?>
                    </div>

                           <form role="form" action="" data-target='h' method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Current Password" name="current-password" type="password" required value="" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="New Password" name="new-password" type="password" required  value="" autofocus>
                                </div>
                                 <div class="form-group">
                                    <input class="form-control" placeholder="Confirm Password" name="confirm-password" type="password" required  value="" autofocus>
                                </div>

                                <!-- Change this to a button or input when using this as a form -->
                                
                                <input type = "submit" value="Change" class="btn btn-lg btn-primary btn-block" name="submit">
                               
                                



                            </fieldset>
                        </form>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>

                    
                  
                </div>

                
                    <!-- /.col-lg-12 -->
                    
                    
                

                    
                  
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
            Redirect::to('index.php');
        }
    ?> 

</body>

</html>
