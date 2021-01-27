

<?php include_once 'head.php'; ?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
         <?php
            //include_once 'base_url.php';
            require_once dirname(__DIR__).'/core/init.php'; 


            $user = new User();

            if($user->isLoggedIn()){
               //echo $user->data()->coo_name;

                         
            

            include_once 'navbar.php';
        ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Upload Evidance</h1>
                    </div>

                    <!-- /.col-lg-12 -->


                    
                    <div class="col-lg-4">
                        

                   <div class="login-panel panel panel-default" style="margin-top:0px; margin-bottom:20px;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Your claim Details</h3>
                        </div>
                          <div class="zartan_semister">
                             
                            

                          </div>
                        <div class="panel-body">
                            <form role="form" method="post" action="">
                            <fieldset>
                            		<?php
                            			$id = Input::get('cd');
                            			$filterid = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
                            			$user_data = $user->data()->std_id;
                            			
                                        
                            			
                            			$data = DB::getInstance()->query("SELECT * from claim where claim_no = ? and std_id = ?", array("$filterid","$user_data"));
                            			

                            			foreach ($data->results()as $data) {
                            				
                            			

                            			
                            		?>
	                                <div class="form-group">
	                                    <label>Claim Module</label>
	                                   <input class="form-control" id="" type="text" name="claim_module" value="<?php echo $data->module_title?>" readonly="">
	                                </div>

	                                <div class="form-group">
	                                    <label>Assessment type</label>
	                                   <input class="form-control" id="" type="text" name="assessment_type" value="<?php echo $data->assessment?>" readonly="">
	                                </div>

	                                <div class="form-group">
	                                    <label>EC Type</label>
	                                   <input class="form-control" id="" type="text" name="EC_type" value="<?php echo $data->ec_type?>" readonly="">
	                                </div>
	                                <div class="form-group"> 
                                    
                                        <label>Your claim description</label> 
                                        <span id="textarea_feedback"></span>
                                        <textarea id="textarea" class="form-control" rows="4" maxlength="200" name="claim" readonly=""><?php echo $data->claim_details?></textarea>
                                   </div>
                                    

                                  
                                   

	                                
 
                                    <!-- Change this to a button or input when using this as a form -->
                                    
                                    
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
                   if($data->claim_feedback == 'accepted' or $data->evidance_details == 'available'){

                   }else {
                ?>
                <div class="col-lg-4">
                    <div style="background:#bc2525;color:white;margin-bottom: 8px; padding: 5px; border-radius:5px">
                    <img src="../images/warning_y.png" width="25" height="25">
                     <span>You can Upload evidance only Once</span>
                    </div>
                    <div class="panel panel-green">
                        <div class="panel-heading">
                           Upload Evidance in Image or PDF
                        </div>
                        <div class="panel-body">
                            <?php
                                  if(Input::exists()){

                                  
                                    if(isset($_FILES['file'])){
                                    $file = $_FILES['file'];


                                    $file_name = $file['name'];
                                    $file_tmp = $file['tmp_name'];
                                    $file_size = $file['size'];
                                    $file_error = $file['error'];


                                    if(empty($file_name)){
                                        echo "<b>Please choose an Image or PDF</b>";
                                    }else {
                                        $allowed = array('jpg','jpeg','png','pdf');
                                        
                                        $file_ext = explode('.', $file_name);
                                        $file_exts = strtolower(end($file_ext));

                                        if(in_array($file_exts, $allowed)){
                                             if($file_error == 0){
                                                if($file_size <= 2097152){

                                               $file_name_new = uniqid('', true).'.'.$file_exts;
                                                $file_destination = 'draco/'.$file_name_new;

                                                if(move_uploaded_file($file_tmp, $file_destination)){
                                                    

                                                    $claim_no = Input::get('cd');

                                                     $data = DB::getInstance()->query("
                                                        UPDATE 
                                                            claim 
                                                        set 
                                                            evidance_details = 'available' , 
                                                            file_name = '$file_name_new', 
                                                            file_path= '$file_destination' 
                                                        where 
                                                            claim_no = $claim_no
                                                        and
                                                            std_id = $user_data"

                                                        );

                                                         echo "<span style:color:green;>"."Your file has been uploaded successfully"."</span>";
                                                    //echo $file_destination;

                                                     

                                               }
                                              }  
                                             }else {
                                                echo "<b>Upload Correct file With minimum of 2 MB size</b>";
                                             }  
                                            
                                        }else {
                                            echo "<b>Only jpg, jpeg, png and pdf are allowed</b>";
                                        }

                                    }

                                }
                            }    
                                                      

                            ?>
                        
                            <form method="post" action="" enctype="multipart/form-data">
                                <fieldset>
                                    <input type="file" name="file"><br>
                                    <input type="submit" name="submit" class="btn btn-success" value="Upload">
                                </fieldset>
                            </form>
                        </div>
                        
                    </div>
                    <!-- /.col-lg-4 -->
                </div>
                <?php
                    }
                ?>
                
                <div class= col-lg-4>

                    <div class="panel panel-red">
                        <div class="panel-heading">
                            Your Uploaded Evidence
                        </div>
                        <div class="panel-body">
                           <?php
                                $claim_no = Input::get('cd'); 
                                $data = DB::getInstance()->query("SELECT  * from claim where claim_no = $claim_no");

                                foreach ($data->results() as $data) {

                                    $a= $data->file_path;

                                    $b = explode('.', $a);
            //print_r($b);

                                    if(in_array('pdf', $b)){
                                        echo "<img src='../images/Graphicloads-Filetype-Pdf.ico' width=25 height=25>".' '.$data->file_name;
                                    ?>
                                        <br><br>
                                        <a href="download.php?cd=<?php echo $data->claim_no?>"><button class="btn btn-warning">Download</button></a> 
                                    <?php
                                }else {
                                    ?>
                                      <div class="thumbnail">
                                    <?php
                                    echo "<img src='$data->file_path' height= 300 width= 280 class='img-rounded' alt='No Evidence'>";
                                    ?>
                                      </div>  
                                    <?php
                                }

            

                                    ?>
                
                                <?php
                                    }
                                ?>

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
            Redirect::to('index.php');
        }
    ?> 

</body>

</html>
