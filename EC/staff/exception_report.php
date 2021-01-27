

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
            
            if($user->hasPermission('ecmanager')){
                //echo " you are administrator";
            

            include_once 'adminnav.php';
        ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Exception Report</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                   
                <div class="col-lg-12">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                           <?php
                              $data = DB::getInstance()->query("SELECT count(claim_no) as total_claim from claim where evidance_details = 'no exists'");

                              foreach ($data->results() as $data) {
                                ?>
                                  <p class="pull-right"><?php echo "Total Claim: "."<b>".$data->total_claim."</b>"?></p>
                                <?php
                              }
                           ?> 
                           Claim without uploaded Evidence 
                        </div>
                        <!-- /.panel-heading -->
                         <div class="row">
                            <div class="col-lg-6 col-lg-offset-3" style="margin-top: 10px;">
                                <div style="margin-bottom:3px;">
                                  
                                </div>
                                <input type="text" name="search" id="search" class="form-control" placeholder="Search Data...">

                            </div>
                        </div>
                   
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="table_data">
                                    
                                    <?php
                                        $data = DB::getInstance()->query("SELECT * from claim where evidance_details = ? order by claim_no desc",array("not available"));

                                        if(!$data->count()){
                                            echo "<span style='color:red;'>No record found</span>";
                                        }else {
                                        ?>
                                              
                                            <thead>                                              
                                                <tr>
                                                    <th>Serial No</th>
                                                    <th>Student ID</th>
                                                    <th>Module Name</th>
                                                    <th>Assessment Type</th>
                                                    <th>Evidance details</th>
                                                    <th>Claim Date</th>
                                                    
                                                   
                                                    
                                                </tr>
                                             </thead>
                                        <?php
                                        $i=0;
                                        foreach ($data->results() as $data) {
                                            $i++; 
                                              
                                         
                                    ?>

                                    <tbody>
                                        <tr class="success" id="table_row">
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $data->std_id; ?></td>
                                            <td><?php echo $data->module_title;?></td>
                                            <td><?php echo $data->assessment;?></td>
                                            <td><?php echo $data->evidance_details;?></td>
                                            <td><?php echo $data->claim_date;?></td>
                                            

                                           
                                            
                                            
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

                <div class="col-lg-12">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                           <?php
                              $data = DB::getInstance()->query("SELECT count(claim_no) as total_claim from claim where last_date < CURDATE()");

                              foreach ($data->results() as $data) {
                                ?>
                                  <p class="pull-right"><?php echo "Total Claim: "."<b>".$data->total_claim."</b>"?></p>
                                <?php
                              }
                           ?> 
                           Claim without decision after 14 days
                        </div>
                        <!-- /.panel-heading -->
                         <div class="row">
                            <div class="col-lg-6 col-lg-offset-3" style="margin-top: 10px;">
                                <div style="margin-bottom:3px;">
                                  
                                </div>
                                <input type="text" name="search" id="search" class="form-control" placeholder="Search Data...">

                            </div>
                        </div>
                   
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="table_data">
                                    
                                    <?php
                                        $data = DB::getInstance()->query("SELECT
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
                                                                where cl.last_date < CURDATE()
                                                                order by 
                                                                    cl.claim_no
                                                                desc      ");

                                        if(!$data->count()){
                                            echo "<span style='color:red;'>No record found</span>";
                                        }else {
                                        ?>
                                              
                                            <thead>                                              
                                                <tr id="without_evidance">
                                                    <th>Serial No</th>
                                                    <th>Student ID</th>
                                                    <th>Module Name</th>
                                                    <th>Assessment Type</th>
                                                    <th>Evidance details</th>
                                                    <th>Days to Left</th>
                                                    
                                                   
                                                    
                                                </tr>
                                             </thead>
                                        <?php
                                        $i=0;
                                        foreach ($data->results() as $data) {
                                            $i++; 
                                              
                                         
                                    ?>

                                    <tbody>
                                        <tr class="success" id="table_row">
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $data->std_id; ?></td>
                                            <td><?php echo $data->module_title;?></td>
                                            <td><?php echo $data->assessment;?></td>
                                            <td><?php echo $data->evidance_details;?></td>
                                            <td><?php echo "End of 14 day"?></td>
                                            

                                           
                                            
                                            
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

    <script type="text/javascript">
        
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

</body>

</html>
