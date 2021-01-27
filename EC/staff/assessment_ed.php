

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

                
                 $id = Input::get('id');

                if($id){

                
                
            

            include_once 'adminnav.php';
        ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Update Module Details</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    
                    <div class="col-lg-4">
                        

                   <div class="login-panel panel panel-default" style="margin-top:0px; margin-bottom:20px;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Update Module Details</h3>
                        </div>
                          <div class="zartan_semister">
                             <?php
                                if(Token::check(Input::get('token'))){
                                    if(Input::exists()){


                                        $validate = new Validate();
                                        $validation = $validate->check($_POST, array(
                                            

                                            'closure_date' => array(
                                                    'required' => true,
                                                    
                                                ),
                                             'final_date' => array(
                                                    'required' => true,
                                                    
                                                )


                                        ));
                                        
                                        // $id = Input::get('id');
                                           $due_date = Input::get('closure_date');
                                           $final_date = Input::get('final_date');

                                        if($validation->passed()){
                                            //insert data
                                            $user = DB::getInstance()->query("
                                                UPDATE assessment SET 
                                                assess_due_date = '$due_date', 
                                                assess_final_date = '$final_date' 
                                                WHERE assess_code = $id"
                                            );

                                        if($user){

                                        	   Session::flash('assessment_update','Your data has been updated successfully');

                                                Redirect::to("assessment_ed.php?id=$id");

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
                                    <?php
                                        $assessment = DB::getInstance()->get('assessment',array('assess_code','=',$id));

                                        foreach ($assessment->results() as $assessment) {
                                            # code...
                                        
                                    ?>
                                    <div class="form-group">
                                        <label>Module Name</label>
                                       <input class="form-control" id="" type="text" name="module_name" value="<?php echo $assessment->mod_title?>" readonly>
                                    </div>

	                                <div class="form-group">
	                                    <div class="form-group">
	                                        <label>assessment Type</label>
	                                        <input class="form-control" id="" type="text" name="assessment_type" value="<?php echo $assessment->assess_type?>"  readonly="">
	                                            
	                                    </div>

	                                </div>
           
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>New Assessment Due Date</label>
                                            <input class="form-control" id="datepicker" type="text" name="closure_date">
                                            
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>New Assessment Final Evidence Date</label>
                                            <input class="form-control" id="datepicker2" type="text" name="final_date">
                                            
                                        </div>

                                    </div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <input type="hidden" name="token" value="<?php echo Token::generate()?>">
                                    <input type="hidden" name="semister_id" value="<?php echo $assessment->semister_id?>">
                                    <input type = "submit" value="Update Data" class="btn btn-lg btn-success btn-block">
                                    <?php
                                        }
                                    ?>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                           This Module date Details
                        </div>
                        <div class="panel-body">
                            <div style="color:green">
                                <?php echo Session::flash('assessment_update')?>
                            </div>
                            <?php
                                $date = DB::getInstance('assessment',array('assess_code','=',$id));
                                foreach ($date->results() as $date) {
                                    # code...
                                
                            ?>
                           <div class="form-group">
                                <div class="form-group">
                                    <label>Assessment Due Date</label>
                                    <input class="form-control" id="" type="text" name="final_date" readonly="" value="<?php echo $date->assess_due_date;?>">
                                            
                                </div>
                                <div class="form-group">
                                    <label>Assessment Final Evidence Date</label>
                                    <input class="form-control" id="" type="text" name="final_date" readonly="" value="<?php echo $date->assess_final_date;?>">                                          
                                </div>
                           </div>
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
                Redirect::to('assessment.php');
            }
        ?>
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
