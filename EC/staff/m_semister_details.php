

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
                        <h1 class="page-header">Add Semister Details</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    
                    
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
                                               
                                            <thead>                                              
                                                <tr>
                                                    <th>Serial No</th>
                                                    <th>Semister Name</th>
                                                    <th>Closure Date</th>
                                                   
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
