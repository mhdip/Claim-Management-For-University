

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

                if($user->hasPermission('coordinator')){
                         
            

            include_once 'adminnav.php';
        ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Student Claim Details and Evidance


                        </h1>

                        
                    </div>

                    <!-- /.col-lg-12 -->


                    
                    <div class="col-lg-6">
                        

                   <div class="login-panel panel panel-success" style="margin-top:0px; margin-bottom:20px;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Student Claim Details</h3>
                        </div>
                          <div class="zartan_semister">
                             
                            

                          </div>
                        <div class="panel-body">
                            <form role="form" method="post" action="">
                            <fieldset>
                            		<?php
                            			$id = Input::get('cd');
                            			$filterid = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
                            			$fac_name = $user->data()->fac_name;
                            			

                            			
                            			$data = DB::getInstance()->query("
                                                                 SELECT
                                                                  c.coo_name,
                                                                  c.fac_name,
                                                                  d.dep_name,
                                                                  m.mod_title,
                                                                  cl.claim_no,
                                                                  cl.claim_details,
                                                                  cl.ec_type,
                                                                  cl.module_title,
                                                                  cl.assessment,
                                                                  cl.claim_date,
                                                                  cl.claim_feedback,
                                                                  DATEDIFF(cl.last_date,CURDATE()) as remaining_day,
                                                                  cl.evidance_details,
                                                                  cl.std_id
                                                                FROM
                                                                  ec_coo AS c
                                                                INNER JOIN
                                                                  department AS d ON c.fac_name = d.fac_name
                                                                INNER JOIN
                                                                  module AS m ON m.dep_name = d.dep_name
                                                                INNER JOIN
                                                                  claim AS cl ON cl.module_title = m.mod_title
                                                                WHERE
                                                                  cl.claim_no = ? and c.fac_name = ?",array("$filterid","$fac_name"));

                                      
                            			
                                       
                                           
                                        

                            			foreach ($data->results()as $data) {
                            				
                            			
                            			
                            		?>
                                  <div class="form-group">
                                        <label>Remaining Days to reply</label>
                                       
                                       <div class="alert alert-success">
                                           <?php 
                                                if($data->remaining_day == 1){
                                                   echo $data->remaining_day. " day";
                                                }else if($data->remaining_day <= 0){
                                                   echo "<span style='color:red'>"."No day left"."<span>";

                                                   

                                                }else {
                                                   echo $data->remaining_day. " days";
                                                }

                                           ?>
                                       </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Claim Status</label>
                                       
                                       <div class="alert alert-success">
                                           <?php echo $data->claim_feedback ?>
                                       </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Student ID</label>
                                       
                                       <div class="alert alert-success">
                                           <?php echo $data->std_id ?>
                                       </div>
                                    </div>

	                                <div class="form-group">
	                                    <label>Claim Module</label>
	                                   
                                       <div class="alert alert-success">
                                           <?php echo $data->module_title ?>
                                       </div>
	                                </div>

	                                <div class="form-group">
	                                    <label>Assessment type</label>
                                       <div class="alert alert-success">
                                           <?php echo $data->assessment ?>
                                       </div>
	                                </div>

                                    <div class="form-group">
                                        <label>Claim Date</label>
                                       <div class="alert alert-success">
                                           <?php echo $data->claim_date ?>
                                       </div>
                                    </div>

	                                <div class="form-group">
	                                    <label>EC Type</label>
                                       <div class="alert alert-success">
                                           <?php echo $data->ec_type ?>
                                       </div>
	                                </div>
	                                <div class="form-group"> 
                                    
                                        <label>claim description</label> 
                                        
                                        <div class="alert alert-success">
                                           <?php echo $data->claim_details ?>
                                       </div>
                                   </div>
                                    

                                  


	                                
 
                                    <!-- Change this to a button or input when using this as a form -->
                                    
                                    
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class= col-lg-4>

                    <div class="panel panel-red">
                        <div class="panel-heading">
                           Evidence box
                        </div>
                        <div class="panel-body">
                           <?php
                                //$claim_no = Input::get('cd');


                                $data = DB::getInstance()->query("SELECT
                                                                      c.coo_name,
                                                                      c.fac_name,
                                                                      d.dep_name,
                                                                      m.mod_title,
                                                                      cl.claim_no,
                                                                      cl.file_name,
                                                                      cl.file_path,
                                                                      cl.std_id
                                                                    FROM
                                                                      ec_coo AS c
                                                                    INNER JOIN
                                                                      department AS d ON c.fac_name = d.fac_name
                                                                    INNER JOIN
                                                                      module AS m ON m.dep_name = d.dep_name
                                                                    INNER JOIN
                                                                      claim AS cl ON cl.module_title = m.mod_title
                                                                    where 
                                                                        cl.claim_no = ? and c.fac_name = ?",array("$filterid","$fac_name"));

                                foreach ($data->results() as $data) {

                                    $a= $data->file_path;

                                    $b = explode('.', $a);
            //print_r($b);

                                    if(in_array('pdf', $b)){
                                        echo "<div class='alert alert-danger'>";

                                        echo "<img src='../images/Graphicloads-Filetype-Pdf.ico' width=25 height=25>".' '.$data->file_name;
                                        echo "</div>";
                                    ?>
                                        
                                        <a href="download.php?cd=<?php echo $data->claim_no?>"><button class="btn btn-warning">Download</button></a> 
                                    <?php
                                }else {
                                    ?>
                                      <div class="thumbnail">
                                    <?php
                                    echo "<img src='../std/$data->file_path' height= 300 width= 280 class='img-rounded' alt='No Evidence'>";
                                    ?>
                                      </div>  
                                    <?php
                                }

                                    

                                    ?>
                
                                <?php
                                    }
                                ?>

                                
                                   
                        </div>
                        
                    </div> 
                    <div class="row">   
                        <div class="col-lg-12">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                   Make Decision
                                </div>
                                <div class="panel-body" id="make_decision">
                                 


                                    <p><?php echo "<span style='color:red'>".Session::flash('claim_rejection')."</span>"?></p>
                                    <p><?php Session::delete('claim_rejection')."</span>"?></p>


                                    <p><?php echo "<span style='color:blue'>".Session::flash('claim_default')."</span>"?></p>
                                    <p><?php Session::delete('claim_default')."</span>"?></p>


                                    <p><?php echo "<span style='color:green'>".Session::flash('claim_acception')."</span>"?></p>
                                    <p><?php Session::delete('claim_acception')."</span>"?></p>



                                    <p><a href="decision.php?cd=<?php echo $data->claim_no.'&'.'decision='.'accept'.'&'.'std_id='.$data->std_id?>"><button class="btn btn-success btn-md btn-block">Accept</button></a></p>

                                    <p><a href="decision.php?cd=<?php echo $data->claim_no.'&'.'rdecision='.'reject'.'&'.'std_id='.$data->std_id?>"><button class="btn btn-danger btn-md btn-block"  onclick="return confirm('Are you sure to reject this claim?')">Reject</button></a></p>

                                    <p><a href="decision.php?cd=<?php echo $data->claim_no.'&'.'default='.'default'.'&'.'std_id='.$data->std_id?>"><button class="btn btn-warning btn-md btn-block">Under Process</button></a></p>

                                    
                                </div>
                                
                            </div>
                        <!-- /.col-lg-4 -->
                        </div>
                    </div>
                     <?php
                                      
                        }

                      
                                 
                    ?>
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
