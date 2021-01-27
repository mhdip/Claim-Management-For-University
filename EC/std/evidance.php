

<?php include_once 'head.php'; ?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
         <?php
            //include_once 'base_url.php';
             
            require_once dirname(__DIR__).'/core/init.php';


            $user = new User();

            if($user->isLoggedIn()){
                $std_no = $user->data()->std_first_name;
            
             
            

            include_once 'navbar.php';
        ?>

        <!-- Page Content -->

        <div id="page-wrapper">
            <div class="container-fluid">
           
              
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Claim and Evidance Details</h1>
                </div>
            </div>



               
                <!-- /.row -->
                <div class="row">

                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Your claim and evidance details
                        </div><br>
                        <!-- /.panel-heading -->
                        <div class="row">
                        <div class="col-lg-6 col-lg-offset-3">
                            <div style="margin:0 0 2 0;color:green">
                                <?php 
                                    echo Session::flash('claim_success');
                                        
                                ?>
                                
                            </div>
                         <input type="text" name="search" id="search" class="form-control" placeholder="Search Data...">

                        </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive" >
                                <table class="table table-bordered" id="table_data">
                                   <?php
                                     $std_id = $user->data()->std_id;
                                     $data = DB::getInstance()->get('claim',array('std_id','=',$std_id));

                                     if(!$data->count()){
                                        echo "<span style='color:red;'>You have no claim to submitted Yet</span>";
                                     }else {
                                   ?>
                                    <thead>
                                        <tr style="background:black;color:white">
                                            <th>Serial no</th>
                                            <th>Claim Module</th>
                                            <th>Module Assessment Type</th>
                                            <th>EC Type</th>
                                            <th>Your Claim Details</th>
                                            <th>Your Evidance Status</th>
                                            <th>Your claim feedback</th>
                                            <th>Your claim date</th>
                                            <th>Upload Evidance</th>
                                           
                                        </tr>
                                    </thead>
                                    

                                    


                                    
                                    <tbody>

                                         <?php

                                        $i= 0;
                                        foreach($data->results() as $data){
                                            $i++;
                                        
                                       ?>
                                        <tr class="info" id="table_row">

                                            <td><?php echo $i;?></td>
                                            <td><?php echo $data->module_title;?></td>
                                            <td><?php echo $data->assessment;?></td>
                                            <td><?php echo $data->ec_type;?></td>


                                            <td><?php echo $data->claim_details;?></td>

                                            <?php
                                                if($data->evidance_details == 'available'){
                                                    ?>
                                                     <td><?php echo $data->evidance_details;?>
                                                        <b><br><a href="upload_evidance.php?cd=<?php echo $data->claim_no.'&'.'sn='.HasH::make($data->std_id)?>">See Evidence</a></b>

                                                     </td>
                                                    <?php
                                                }else {
                                                    ?>
                                                    <td><?php echo $data->evidance_details;?></td>
                                                    <?php
                                                }
                                            ?>
                                            

                                            <?php
                                                if($data->claim_feedback == 'accepted'){
                                                    ?>
                                                      <td style="background:green;color:white;"><?php echo $data->claim_feedback;?></td>   
                                                    <?php
                                                }else if($data->claim_feedback == 'rejected') {
                                                    ?>
                                                        <td style="background:red;color:white"><?php echo $data->claim_feedback;?></td> 
                                                    <?php
                                                }else if($data->claim_feedback == 'processing'){
                                                     ?>
                                                        <td style="background:orange;color:white"><?php echo $data->claim_feedback;?></td> 
                                                     <?php     
                                                }else {
                                                    ?>
                                                         <td><?php echo $data->claim_feedback;?></td> 
                                                    <?php
                                                }
                                            ?>

                                            


                                            <td><?php echo $data->claim_date;?></td>


                                            
                                              <?php
                                                 if($data->evidance_details == 'available'){
                                                   ?>
                                                    <td>Already Uploaded</a></td>
                                                   <?php 
                                                 }else {
                                                    ?>
                                                     <td><a href="upload_evidance.php?cd=<?php echo $data->claim_no.'&'.'sn='.HasH::make($data->std_id)?>">Upload Evidance</a></td>     
                                                   <?php
                                                 }   
                                              ?>
                                                                                               
                                           
                                           
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
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>

               
            </div>
            </div>
             </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <script type="text/javascript">
            function fac_name(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET","assessmentAjx.php?faculty_name="+document.getElementById('faculty_name').value,false);
            xmlhttp.send(null);
            //alert(xmlhttp.responseText);
            document.getElementById("department_name").innerHTML=xmlhttp.responseText;

            

        }
   
            function dep_name(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET","assessmentAjx.php?department_name="+document.getElementById('department_name').value, false);
            xmlhttp.send(null);
            //alert(xmlhttp.responseText);
            document.getElementById("module_name").innerHTML=xmlhttp.responseText;
        }

        


        $(document).ready(function(){
            $('#search').keyup(function(){
                search_table($(this).val());
            });

            function search_table(value){
                $('#table_data #table_row').each(function(){
                    var found = 'false';
                    $(this).each(function(){
                        if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0){
                            found = 'true';
                        }
                    });

                    if(found == 'true'){
                        $(this).show();
                    }else {
                       $(this).hide(); 
                    }
                });
            }


        });

    </script>


       <?php include_once 'footer.php';?> 

    
    <?php
        }else {
            Redirect::to('index.php');

        }
    ?> 

</body>

</html>
