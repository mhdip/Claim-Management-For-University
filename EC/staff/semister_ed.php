

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
                        <h1 class="page-header">Update Semister Details</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    
                    <div class="col-lg-4">
                        

                   <div class="login-panel panel panel-default" style="margin-top:0px; margin-bottom:20px;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Update Semister Details</h3>
                        </div>
                          <div class="zartan_semister">
                             <?php
                                if(Token::check(Input::get('token'))){
                                    if(Input::exists()){


                                        $validate = new Validate();
                                        $validation = $validate->check($_POST, array(
                                            

                                            'closure_date' => array(
                                                    'required' => true,
                                                     'unique' => 'semister' 
                                                )


                                        ));
                                        
                                        $id = Input::get('id');

                                        if($validation->passed()){
                                            //insert data
                                            $user = DB::getInstance()->update('semister',$id,array(
                                              
                                                'closure_date'  => Input::get('closure_date')

                                           ));

                                        if($user){

                                        	   Session::flash('semister_update','This data has been updated successfully');	
                                               Redirect::to('semister.php');
                                                

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
                            <form role="form" method="post" action="">
                            <fieldset>
                                <div class="form-group">
                                    <label>Semister Name</label>
                                   <input class="form-control" id="" type="text" name="semister_name" value="<?php echo Input::get('sn')?>" readonly="">
                                </div>
	                                <div class="form-group">
	                                    <div class="form-group">
	                                        <label>Exist Closure Date</label>
	                                        <input class="form-control" id="" type="text" name="closure_date" value="<?php echo Input::get('closure_date')?>"  readonly="">
	                                            
	                                    </div>

	                                </div>
           
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>New Closure Date</label>
                                            <input class="form-control" id="datepicker" type="text" name="closure_date">
                                            
                                        </div>

                                    </div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <input type="hidden" name="token" value="<?php echo Token::generate()?>">
                                    <input type = "submit" value="Update Data" class="btn btn-lg btn-success btn-block">
                                    
                                </fieldset>
                            </form>
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
