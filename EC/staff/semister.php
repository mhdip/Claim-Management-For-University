

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
                //echo " you are administrator";
            

            include_once 'adminnav.php';
        ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Add Semister Details</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    
                    <div class="col-lg-4">
                        

                   <div class="login-panel panel panel-default" style="margin-top:0px; margin-bottom:20px;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Enter Semister Details</h3>
                        </div>
                          <div class="zartan_semister">
                             <?php
                                if(Token::check(Input::get('token'))){
                                    if(Input::exists()){


                                        $validate = new Validate();
                                        $validation = $validate->check($_POST, array(
                                            'semister_name' => array(
                                                    'required' => true,
                                                     'exists' => 'semister'
                                                    
                                                ),

                                            'closure_date' => array(
                                                    'required' => true,
                                                     'exists'  => 'semister'

                                                )


                                        ));
                                        

                                        if($validation->passed()){
                                            //insert data
                                            DB::getInstance()->query("ALTER TABLE semister AUTO_INCREMENT = 1");

                                            $user = DB::getInstance()->insert('semister',array(
                                                'semister_name' => Input::get('semister_name'),
                                                'closure_date'  => Input::get('closure_date')

                                           ));
                                            
                                            
                                        if($user){
                                                //Session::delete('semister_delete');
                                                Session::delete('semister_update');
                                                echo "<div class='row'>";
                                                echo "<div class='col-lg-8 col-lg-offset-2'>";
                                                echo "<div id='zartan_success_message'>";
                                                echo "Data insert successfully";
                                                echo "</div>";
                                                echo "</div>"; 
                                                echo "</div>"; 
                                                

                                            }else {
                                                echo "<div class='row'>";
                                                echo "<div class='col-lg-7 col-lg-offset-3'>";
                                                echo "<div id='zartan_error_message'>"; 
                                                echo "This data already exists, Please Update this data";
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
                                    <select class="form-control" name="semister_name" required>
                                        <option></option>
                                        <option value="1st semister">1st semister</option>
                                        <option value="2nd semister">2nd semister</option>
                                        <option value="3rd semister">3rd semister</option>
                                        <option value="4th semister">4th semister</option>
                                        <option value="5th semister">5th semister</option>
                                        <option value="6th semister">6th semister</option>
                                        
                                           
                                    </select>
                                </div>
           
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Closure Date</label>
                                            <input class="form-control" id="datepicker" type="text" name="closure_date">
                                            
                                        </div>

                                    </div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <input type="hidden" name="token" value="<?php echo Token::generate()?>">
                                    <input type = "submit" value="Insert Data" class="btn btn-lg btn-success btn-block">
                                    
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                           All Semister Closure Date Details
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    
                                    <?php
                                        $data = DB::getInstance()->query("SELECT * From semister");

                                        if(!$data->count()){
                                            echo "<span style='color:red;'>No record found</span>";
                                        }else {
                                        ?>
                                             <?php echo Session::flash('semister_update');?>
                                             <?php Session::delete('semister_update');?>
                                             <?php echo Session::flash('semister_delete');?>
                                              <?php Session::delete('semister_delete');?>     
                                            <thead>                                              
                                                <tr>
                                                    <th>Serial No</th>
                                                    <th>Semister Name</th>
                                                    <th>Closure Date</th>
                                                    <th>Action</th>
                                                </tr>
                                             </thead>
                                        <?php
                                        $i=0;
                                        foreach ($data->results() as $data) {
                                            $i++; 
                                              
                                         
                                    ?>

                                    <tbody>
                                        <tr class="success">
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $data->semister_name; ?></td>
                                            <td><?php  echo $data->closure_date;?></td>
                                            <td>
                                             <a href="semister_ed.php?id=<?php echo $data->id.'&'.'sn='.$data->semister_name.'&'.'closure_date='.$data->closure_date?>">Update</a> 
                                             <!--<a onclick="return confirm('Are you sure to delete')" href="<?php //echo base_url;?>/staff/semister_dl.php?id=<?php //echo $data->id;?>">Delete</a>-->

                                            </td>
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
