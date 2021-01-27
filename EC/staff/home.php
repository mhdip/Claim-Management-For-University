<!DOCTYPE html>
<html lang="en">

<?php 
require_once dirname(__DIR__).'/core/init.php';
include_once 'head.php';

?>

<body>
    <?php
        
    
     #check sesion flash data
    

    #how to get logged in user data



    $user = new Staff();
    if($user->isLoggedIn()){
       //echo escape($user->data()->coo_name);

      //echo Session::get(Config::get('session/session_name_1'));

      if($user->hasPermission('admin')){
        //start admin
            //echo "you are administrator";

       ?>
            
    <div id="wrapper">

    <?php include_once 'adminnav.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Admin</h1>
                </div>
                <div class="col-lg-4">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                          Add Coordinator
                        </div>
                        <!-- /.panel-heading -->
                        
                          <div class="zartan_semister">
                             <?php
                                if(Token::check(Input::get('token'))){
                                    if(Input::exists()){


                                        $validate = new Validate();
                                        $validation = $validate->check($_POST, array(
                                            'name' => array(
                                                    'required' => true,
                                                    
                                                    
                                                ),

                                            'email' => array(
                                                    'required' => true,
                                                    

                                                ),

                                           

                                            'password' => array(
                                                    'required' => true,
                                                    'minimum' => 6

                                                ),

                                            'confirm-password' => array(
                                                    'required' => true,
                                                    'matches'  => 'password'

                                                ),

                                            'faculty' => array(
                                                    'select' => true,
                                                    

                                                ),


                                        ));
                                        

                                        if($validation->passed()){


                                            //echo "ok";
                                            //insert data
                                            //DB::getInstance()->query("ALTER TABLE semister AUTO_INCREMENT = 1");

                                            $salt = Hash::salt(32);

                                            $user = DB::getInstance()->insert('ec_coo',array(
                                                'coo_name' => Input::get('name'),
                                                'coo_email'  => Input::get('email'),
                                                'coo_password' => Hash::make(Input::get('password'), $salt),
                                                'salt'  => $salt,
                                                'fac_name' => Input::get('faculty'),
                                                'group' => '4'

                                           ));
                                            
                                            
                                        if($user){
                                                
                                                echo "<div class='row'>";
                                                echo "<div class='col-lg-8 col-lg-offset-2'>";
                                                echo "<div id='zartan_success_message'>";
                                                echo "Coordinator added successfully";
                                                echo "</div>";
                                                echo "</div>"; 
                                                echo "</div>"; 
                                                

                                            }else {
                                                echo "<div class='row'>";
                                                echo "<div class='col-lg-7 col-lg-offset-2'>";
                                                echo "<div id='zartan_error_message'>"; 
                                                echo "This data already exists, Please Update this data";
                                                echo "</div>"; 
                                                echo "</div>"; 
                                                echo "</div>"; 
                                            }

                                        }else {
                                                echo "<div class='row'>";
                                                echo "<div class='col-lg-9 col-lg-offset-1'>"; 
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
                            <script type="text/javascript">
                                   function clean(e){
                                        var textfield = document.getElementById(e);

                                        var regex = /[^a-z 0-9]/gi;

                                        textfield.value = textfield.value.replace(regex, "");

                                    }

                                    function email_clean(e){
                                        var textfield = document.getElementById(e);

                                        var regex = /[^a-z 0-9@._-]/gi;

                                        textfield.value = textfield.value.replace(regex, "");

                                    }


                            </script>

                            <form role="form" method="post" action="">
                            <fieldset>

                                
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control" id="name" onkeydown="clean('name')" onkeyup="clean('name')" type="text" name="name" required value="<?php echo Input::get('name')?>">
                                            
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" id="email" onkeydown="email_clean('email')" onkeyup="email_clean('email')" type="email" name="email" required value="<?php echo Input::get('email')?>">
                                            
                                </div>
                                <div class="form-group">
                                    <label>password</label>
                                    <input class="form-control" id="password" type="password" name="password" required autocomplete="off">
                                            
                                </div>
                                 <div class="form-group">
                                    <label>Confirm password</label>
                                    <input class="form-control" id="password" type="password" name="confirm-password" required autocomplete="off">
                                            
                                </div>
                                

                                <div class="form-group">
                                    <label>Select faculty</label>
                                    <select class="form-control" name="faculty" required >

                                        <option><?php echo Input::get('faculty')?></option>
                                            <?php
                                                $data = DB::getInstance()->query("SELECT * from faculty");

                                                foreach ($data->results() as $data) {
                                                   ?>
                                                    <option value="<?php echo $data->fac_name;?>"><?php echo $data->fac_name;?></option>

                                                   <?php
                                                }
                                            ?>
                                       
                                       
                                        
                                           
                                    </select>
                                </div>
           
                                   
                                    <!-- Change this to a button or input when using this as a form -->
                                    <input type="hidden" name="token" value="<?php echo Token::generate()?>">
                                    <input type = "submit" value="Add" class="btn btn-lg btn-success btn-block">
                                    
                                </fieldset>
                            </form>
                        </div>
             
                        <!-- /.panel-body -->
                    </div>

                </div>
                <div class="col-lg-8">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                           Staff Details
                        </div>
                        <!-- /.panel-heading -->
                        <div style="margin-top: 10px;">
                            
                            <?php
                                 if(Session::exists('coordinator_update')){

                                 
                                echo "<span id='success_update'>".Session::flash('coordinator_update')."<span>";
                                Session::delete('coordinator_update');

                            } else if(Session::exists('coo_delete')){
                                 echo "<span id='success_update'>".Session::flash('coo_delete')."<span>";
                                Session::delete('coo_delete');
                            }  
                            ?>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    
                                    <?php
                                        $data = DB::getInstance()->query("SELECT * From ec_coo where `group` = ? order by coo_id desc" ,array("4"));

                                        if(!$data->count()){
                                            echo "<span style='color:red;'>No record found</span>";
                                        }else {
                                        ?>
                                           
                                            <thead>                                              
                                                <tr>
                                                    <th>Serial No</th>
                                                    <th>Staff Email</th>
                                                    <th>Faculty </th>
                                                    <th>Action </th>
                                                
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
                                            <td><?php echo $data->coo_email; ?></td>
                                            <td><?php  echo $data->fac_name;?></td>
                                            <td>
                                                <a href="coo_ed.php?cod_id=<?php echo $data->coo_id?>">Edit</a> ||
                                                <a href="coo_dl.php?coo_id=<?php echo $data->coo_id?>" onclick="return confirm('Are you sure to delete')">Delete</a>
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
                <!-- /.col-lg-12 -->
            </div>
            
            <div class="row">
                <div class="col-lg-8">
                          

                   
                    <!-- /.panel -->

                    <!-- /.panel -->
                    
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

        </div>
   </div> 
    <!-- /#wrapper -->


    <?php include_once 'footer.php';?>
       <?php     
        //end admin

        //start ecmanager
      }else if($user->hasPermission('ecmanager')){
      ?>
      
    <div id="wrapper">

        <!-- Navigation -->
        <?php
            include_once 'adminnav.php';
        ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">EC-manager </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                    <?php
                        $data = DB::getInstance()->query("SELECT count(cl.claim_no) as total_claim,
                                (SELECT Count(*) FROM claim where evidance_details = 'exists') as total_evidance,
                                (SELECT Count(*) FROM claim where claim_feedback = 'accepted') as accepted_claim,
                                (SELECT Count(*) FROM claim where claim_feedback = 'rejected') as rejected_claim
                                from claim cl");

                        foreach ($data->results() as $data) {
                            
                        
                    ?>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i><img src="../images/total_claim.png" width="100" height="70"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $data->total_claim;?></div>
                                    
                                </div>
                            </div>
                        </div>
                         <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Total Claim of all Faculty</span>
                                <span class="pull-right"><i class=""></i></span>
                                <div class="clearfix"></div>
                            </div>
                         </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i><img src="../images/evidance.png" width="100" height="70"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $data->total_evidance;?></div>
                                   
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Total claim with Evidance</span>
                                <span class="pull-right"><i class=""></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                     <i><img src="../images/accepted.png" width="100" height="70"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $data->accepted_claim;?></div>
                                    
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Total Accepted claim</span>
                                <span class="pull-right"><i class=""></i></span>
                                <div class="clearfix"></div>
                            </div>
                         </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i><img src="../images/rejected.png" width="100" height="70"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $data->rejected_claim;?></div>
                                    
                                </div>
                            </div>
                        </div>
                       <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Total rejected claim</span>
                                <span class="pull-right"><i class=""></i></span>
                                <div class="clearfix"></div>
                            </div>
                         </a>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>

            <!-- /.row -->
            <div class="row">
                <div class="col-lg-7">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Number of claim by faculty
                           
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
                                                      c.coo_name,
                                                      c.fac_name,
                                                      d.dep_name,
                                                      m.mod_title,
                                                      count(cl.claim_no) as total_claim,
                                                      cl.claim_date
                                                    FROM
                                                      ec_coo AS c
                                                    INNER JOIN
                                                      department AS d ON c.fac_name = d.fac_name
                                                    INNER JOIN
                                                      module AS m ON m.dep_name = d.dep_name
                                                    INNER JOIN
                                                      claim AS cl ON cl.module_title = m.mod_title
                                                    where   c.fac_name = ? and Year(cl.claim_date) = ?",array("$faculty","$year"));

                                            foreach ($data->results() as $data) {
                                                
                                            
                                            
                                            
                                       
                                                //Session::delete('semister_delete');
                                                ?>
                                                <div class="panel panel-warning">
                                                <div class="panel-heading">
                                                    <div class="row">
                                                      
                                                        <div class="col-xs-12 text-left">
                                                            <div class="huge"><span style="font-size: 20px;">In <?php echo "<h4 style='display:inline-block;'>".$year."</h4>"?> total Claim in <?php echo $faculty;?> Faculty</span> - <?php echo $data->total_claim?></div>
                                        
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
                               
                                <input type="submit" class="btn btn-success" value="Search" name="submit_btn1">
                            </form>                             

                        </div>


                        <!-- /.panel-body -->
                    </div>
                    
                    
                </div>
                <!-- /.col-lg-8 -->
                
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->

            <!---->

            <div class="row">
                <div class="col-lg-7">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Number of student's claim by facutly
                           
                        </div>
                        <!-- /.panel-heading -->
                        <div>
                             <?php
                                $faculty = Input::get('faculty');
                                $year = Input::get('year');
                                if(isset($_POST['submit_btn2'])){


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
                                                      c.coo_name,
                                                      c.fac_name,
                                                      d.dep_name,
                                                      m.mod_title,
                                                      count(cl.claim_no) as total_claim,
                                                      cl.claim_date,
                                                      count(DISTINCT cl.std_id) as total_student
                                                    FROM
                                                      ec_coo AS c
                                                    INNER JOIN
                                                      department AS d ON c.fac_name = d.fac_name
                                                    INNER JOIN
                                                      module AS m ON m.dep_name = d.dep_name
                                                    INNER JOIN
                                                      claim AS cl ON cl.module_title = m.mod_title
                                                    where   c.fac_name = ? and Year(cl.claim_date) = ?",array("$faculty","$year"));

                                            foreach ($data->results() as $data) {
                                                
                                            
                                            
                                            
                                       
                                                //Session::delete('semister_delete');
                                                ?>
                                                <div class="panel panel-success">
                                                <div class="panel-heading">
                                                    <div class="row">
                                                      
                                                        <div class="col-xs-12 text-left">
                                                            
                                                            <div class="huge"><span style="font-size: 15px;">In <?php echo "<h4 style='display:inline-block;'>".$year."</h4>"?> total students who already claim in <?php echo $faculty;?> Faculty</span> - <?php echo $data->total_student?></div>
                                        
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

                           <form class="form-inline" action="home.php" method="post" id="claim_by_faculty_form">
                                <div class="form-group" >
                                    <label>Faculty</label>
                                    <select class="form-control" name="faculty"  required>
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
                               
                                <input type="submit" class="btn btn-success" value="Search" name="submit_btn2">
                            </form>                             

                        </div>


                        <!-- /.panel-body -->
                    </div>
                    
                    
                </div>
                <!-- /.col-lg-8 -->
                
                <!-- /.col-lg-4 -->
            </div>



        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
   <?php require_once 'footer.php';?>
      <?php
      //end ec manager
      }else  {


     
    ?>    

    

    <div id="wrapper">

        <!-- Navigation -->
        <?php
			include_once 'adminnav.php';
		?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Co-ordinator- <spans style="font-size: 20px;"><?php echo "Faculty of ".$user->data()->fac_name?></span></h1>
                    

                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
            <div class="row">

                <div class="col-lg-12">

                    <div class="panel panel-default">

                    <div class="row" style="margin-top:35px">
                        <div class="col-lg-6 col-lg-offset-3">

                            <input type="text" name="search" id="search" class="form-control" placeholder="Search Data...">

                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                            $fac_name = $user->data()->fac_name;
                            $page_Id = Input::get('page') ? Input::get('page'): 1;
                            $page = filter_var($page_Id, FILTER_SANITIZE_NUMBER_INT);

                           
                            $perPage = Input::get('per-page') && Input::get('per-page') <=50 ? (int)Input::get('per-page'): 25;

                                            
                            $start = ($page > 1) ? ($page * $perPage) - $perPage : 0;
                            $total = DB::getInstance()->query("SELECT c.coo_name, c.fac_name, d.dep_name, m.mod_title, 
                                                    cl.claim_no, cl.claim_details, cl.ec_type,cl.module_title,
                                                    cl.assessment, cl.claim_date, cl.evidance_details, cl.claim_feedback,cl.std_id
                                                    from ec_coo as c
                                                    INNER join department as d
                                                    on c.fac_name = d.fac_name
                                                    INNER join module as m
                                                    on m.dep_name = d.dep_name
                                                    inner join claim as cl 
                                                    on cl.module_title = m.mod_title
                                                    where c.fac_name ='$fac_name'")->count();
                                           
                            @$pages = ceil($total/$perPage);



                        ?>
                        <?php for($x=1; $x<= $pages; $x++):?>
                                    <ul class="pagination">
                                        <li><a href="?page=<?php echo $x; ?>"><?php echo $x;?></a></li>
                                    </ul>    
                        <?php endfor;?>

                            <div class="table-responsive" >
                                <table class="table table-bordered" id="table_data">
                                   <?php
                                     //$pageId = filter_var( $claim_no, FILTER_SANITIZE_NUMBER_INT);
                                     
                                        $data = DB::getInstance()->query("SELECT c.coo_name, c.fac_name, d.dep_name, m.mod_title, 
                                                cl.claim_no, cl.claim_details, cl.ec_type,cl.module_title,
                                                cl.assessment, cl.claim_date, cl.evidance_details, cl.claim_feedback,cl.std_id
                                                from ec_coo as c
                                                INNER join department as d
                                                on c.fac_name = d.fac_name
                                                INNER join module as m
                                                on m.dep_name = d.dep_name
                                                inner join claim as cl 
                                                on cl.module_title = m.mod_title
                                                where c.fac_name = ? order by cl.claim_no desc limit $start,  $perPage",array("$fac_name"));


                                       
                                       



                                        if(!$data->count()){
                                            echo "<span style='color:red;'>There is no claim in this Faculty</span>";
                                        }else {
                                   ?>
                                    <thead>
                                        <tr style="background:black;color:white">
                                            <th>Serial no</th>
                                            
                                            <th>Claim Module</th>
                                            <th>Student ID</th>
                                            <th>Module Assessment Type</th>
                                            <th>EC Type</th>
                                            <th>Claim Details</th>
                                            <th>Evidance Status</th>
                                            <th>Claim feedback</th>
                                            <th>Claim date</th>
                                            <th>View claim</th>
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
                                            <td><?php echo $data->std_id;?></td>
                                            <td><?php echo $data->assessment;?></td>
                                            <td><?php echo $data->ec_type;?></td>
                                            <td><?php echo $data->claim_details;?></td>
                                            <td><?php echo $data->evidance_details;?></td>
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
                                                }else  {
                                                    ?>
                                                         <td><?php echo $data->claim_feedback;?></td> 
                                                    <?php
                                                }
                                            ?>
                                            


                                            <td><?php echo $data->claim_date;?></td>
                                            <td>
                                                <?php 
                                                    $claim_no = $data->claim_no;
                                                    $filterid = filter_var( $claim_no, FILTER_SANITIZE_NUMBER_INT);
                                                    //$filterid = filter_var($filter,FILTER_SANITIZE_URL);

                                                ?>
                                             <a href="claim_feedback.php?cd=<?php echo $filterid?>">View</a>
                                                

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
                    <div class="row">
                        <div class="col-lg-12">
                            <div style="margin-left:27px">
                                 

                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
            <!-- /.row -->
            
                <!-- /.col-lg-4 -->
        </div>
            <!-- /.row -->
    </div>
        <!-- /#page-wrapper -->

   
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

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

    <?php
        }
    ?>

    <?php
    }else {
        Redirect::to('index.php');
    }
    ?>

</body>

</html>
