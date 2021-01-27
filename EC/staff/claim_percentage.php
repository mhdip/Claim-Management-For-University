

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
                        <h1 class="page-header">Claim Percentage</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row">    
                <div class="col-lg-8">
                     
                        
                        <!-- /.panel-heading -->
                        <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Percentage of Claim By Each Facutly
                           
                        </div>
                        <!-- /.panel-heading -->
                        <div>
                             <?php
                                $faculty = Input::get('faculty');
                                $year = Input::get('year');
                                if(isset($_POST['submit_btn1'])){


                                        $validate = new Validate();
                                        $validation = $validate->check($_POST, array(
                                            'faculty' => array(
                                                    'select' => true,
                                                    
                                                ),

                                            'year' => array(
                                                    'select' => true,
                                                    

                                                )


                                        ));
                                        

                                        if($validation->passed()){
                                            
                                                /*echo "<div class='row'>";
                                                echo "<div class='col-lg-7 col-lg-offset-1'>";
                                                echo "<div id='zartan_success_message'>";
                                                echo "ok";
                                                echo "</div>";
                                                echo "</div>"; 
                                                echo "</div>";*/
                                             


                                            //insert data
                                            //DB::getInstance()->query("ALTER TABLE semister AUTO_INCREMENT = 1");

                                           

                                            $data = DB::getInstance()->query("SELECT 
                                                          COUNT(cl.claim_no) AS total_claim, count(distinct cl.std_id) as total_student,
                                                          (
                                                          SELECT 
                                                         COUNT(a.assess_type)
                                                          FROM
                                                            assessment AS a
                                                          LEFT JOIN
                                                            department AS dp ON dp.dep_name = a.dep_name
                                                          LEFT JOIN
                                                            claim AS clm ON a.mod_title = clm.module_title
                                                          WHERE
                                                            dp.fac_name = '$faculty'
                                                        ) AS total_assessment
                                                        FROM
                                                          claim AS cl
                                                        INNER JOIN
                                                          module AS m ON cl.module_title = m.mod_title
                                                        INNER JOIN
                                                          department AS d ON d.dep_name = m.dep_name
                                                        WHERE
                                                          d.fac_name = '$faculty' AND YEAR(cl.claim_date) = '$year'");

                                            foreach ($data->results() as $data) {
                                                
                                            
                                            
                                            
                                       
                                                //Session::delete('semister_delete');
                                                ?>
                                                <div class="panel panel-warning">
                                                <div class="panel-heading">
                                                    <div class="row">
                                                      
                                                        <div class="col-xs-12 text-left">
                                                            <?php 
                                                            echo "Total assessment- ".$data->total_assessment."<br>";
                                                            echo "Total claim- ".$data->total_claim."<br>";
                                                            echo "Total student- ".$data->total_student;

                                                            ?>
                                                            <div class="huge"><span style="font-size: 18px;">In <?php echo "<h4 style='display:inline-block;'>".$year."</h4>"?> total Percentage of Claim in <?php echo $faculty;?> Faculty</span> - 
                                                            <?php 

                                                               $total_assessment = $data->total_assessment;
                                                               $total_claim = $data->total_claim;
                                                               //echo "<br>";

                                                               if($total_assessment == 0){
                                                                  echo "0 %";
                                                               }else {

                                                                $claim_percentage = $total_claim/$total_assessment*100;

                                                               echo  $total = number_format($claim_percentage,2)."%";
                                                               } 

                                                            ?>

                                                        </div>
                                        
                                                        </div>
                                                    </div>
                                                </div>
                                                 <!--<a href="#">
                                                        <div class="panel-footer">
                                                            <span class="pull-left">Total rejected claim</span>
                                                            <span class="pull-right"><i class=""></i></span>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </a>-->
                                            </div>
                                                <?php
                                                    }
                                                ?>
                                                <?php

                                            

                                        }else {
                                                echo "<div class='row'>";
                                                echo "<div class='col-lg-4 col-lg-offset-3'>"; 
                                                echo "<div id='zartan_error_message'>";
                                            foreach ($validation->errors() as $error) {
                                                echo $error.'<br>';
                                            }
                                                echo "</div>";
                                                echo "</div>"; 
                                                echo "</div>";  
                                        }
                                    }

                             ?>
                        </div>
                        <div class="panel-body">

                           <form class="form-inline" action="" method="post" id="claim_by_faculty_form">
                                <div class="form-group" >
                                    <label>Faculty</label>
                                    <select class="form-control" name="faculty" required>
                                        <option></option>
                                        <?php
                                            $data = DB::getInstance()->query("SELECT * from faculty");
                                            foreach ($data->results() as $data) {
                                                
                                            
                                        ?>

                                        <option value="<?php echo $data->fac_name?>"><?php echo $data->fac_name;?></option>
                                        
                                        <?php
                                            }
                                        ?>
                                           
                                    </select>
                                </div>
                                <div class="form-group">

                                    <div class="form-group">
                                    <label>Year</label>
                                    <select class="form-control" name="year" required>
                                        <option></option>
                                        <?php
                                            $data = DB::getInstance()->query("SELECT DISTINCT Year(claim_date) as year from claim order by claim_date");
                                            foreach ($data->results() as $data) {
                                                
                                            
                                        ?>

                                        <option value="<?php echo $data->year?>"><?php echo $data->year;?></option>
                                        
                                        <?php
                                            }
                                        ?>
                                           
                                    </select>
                                </div>

                                    </div>
                               
                                <input type="submit" class="btn btn-info" value="Search" name="submit_btn1">
                            </form>                             

                        </div>


                        <!-- /.panel-body -->
                    </div>
                        <!-- /.panel-body -->
                   
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
