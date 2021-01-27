

<?php include_once 'head.php'; ?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
         <?php
            //include_once 'base_url.php';
            require_once dirname(__DIR__).'/core/init.php'; 


            $user = new User();

            if($user->isLoggedIn()){
               echo $std_id = $user->data()->std_id;
               echo $module_title = Session::get('module_name');

                         
            

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
                    <?php
                        $data = DB::getInstance()->query("SELECT * from claim where claim_details = ? and std_id = ?", array("late upload evidance","$std_id"));

                       
                   
                         

                         foreach ($data->results() as $data) {
                            
                         
                           
                    ?>

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


                                                    $std_id = $user->data()->std_id;   
                                                     $data = DB::getInstance()->insert("claim",array(
                                                            'claim_details' => 'late_upload',
                                                            'ec_type' => 'none',
                                                            'module_title' => $module_title,
                                                            'assessment' => 'none',
                                                            'claim_date' => 'none',
                                                            'last_date' => 'none',
                                                            'evidance_details' => 'available',
                                                            'file_name' => $file_name_new,
                                                            'file_path' => $file_destination,
                                                            'std_id' => $std_id,
                                                            'claim_feedback' => 'pending'
                                                        ));

                                                     if($data){
                                                        $move_file = move_uploaded_file($file_tmp, $file_destination);

                                                        if($move_file){
                                                             echo "<span style=color:green;>"."Your file has been uploaded successfully"."</span>";
                                                        }else {
                                                            echo "doesn't upload";
                                                        }

                                                     }else {
                                                        echo "problem";
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
                                //$claim_no = Input::get('cd'); 
                                $data = DB::getInstance()->query("SELECT  * from claim where std_id = $std_id and module_title = '$module_title' and claim_details = 'late upload evidance'");

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
