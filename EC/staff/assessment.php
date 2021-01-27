
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
               // echo " you are administrator";
            

            include_once 'adminnav.php';
        ?>

        <!-- Page Content -->

        <div id="page-wrapper">
            <div class="container-fluid">
           
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Add Assessment Details</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    
                    <div class="col-lg-5">
                        

                   <div class="login-panel panel panel-default" style="margin-top:0px; margin-bottom:20px;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Enter Assessment Details</h3>
                        </div>
                          <div class="zartan_semister">
                             <?php
                                if(Token::check(Input::get('token'))){
                                    if(Input::exists()){


                                        $validate = new Validate();
                                        $validation = $validate->check($_POST, array(
                                            'semister_name' => array('select' => true),
                                            'faculty_name' => array('select' => true),
                                            'department_name' => array('select' => true),
                                            'module_name' => array('select' => true),
                                            'assessment_type' => array('select' => true),
                                            'due_date' => array('required' => true),
                                            'final_date' => array('required' => true)

                                        ));
                                        

                                        if($validation->passed()){

                                            //echo "ok";
                                             
                                            $user = DB::getInstance()->insert('assessment',array(
                                                'dep_name'   => Input::get('department_name'),
                                                'assess_type' => Input::get('assessment_type'),
                                                'assess_due_date'  => Input::get('due_date'),
                                                'assess_final_date' => Input::get('final_date'),
                                                'mod_title' => Input::get('module_name'),
                                                'semister_id' => Input::get('semister_name'),


                                           ));

                                        if($user){
                                                
                                                echo "<div class='row'>";
                                                echo "<div class='col-lg-8 col-lg-offset-2'>";
                                                echo "<div id='zartan_success_message'>";
                                                echo "Data insert successfully";
                                                echo "</div>";
                                                echo "</div>"; 
                                                echo "</div>"; 
                                                

                                            }else {
                                                echo "<div class='row'>";
                                                echo "<div class='col-lg-8 col-lg-offset-2'>";
                                                echo "<div id='zartan_error_message'>"; 
                                                echo "There is problem to insert data";
                                                echo "</div>"; 
                                                echo "</div>"; 
                                                echo "</div>"; 
                                            }

                                        }else {
                                                echo "<div class='row'>";
                                                echo "<div class='col-lg-9 col-lg-offset-1'>"; 
                                                echo "<div id='zartan_assessment_error_messages'>";
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
                            <button type="reset" class="btn btn-default">Reset Data</button>
                            <fieldset>
                                <div class="form-group">

                                    <label>Select Semister</label> 
                                    <select class="form-control" name="semister_name" required>
                                        <option></option>
                                        <?php
                                            $data = DB::getInstance()->query("SELECT * FROM semister");

                                            foreach ($data->results() as $data) {                                           
                                        
                                        ?>
                                            <option value="<?php echo $data->id?>"><?php echo $data->semister_name?></option>
                                        <?php
                                            }
                                        ?>
                                           
                                    </select>
                                </div>

                                <div class="form-group">

                                    <label>Select faculty</label> 
                                    <select class="form-control" name="faculty_name" id="faculty_name" onchange="fac_name()" required>
                                      
                                       <option></option>
                                        <?php
                                            $data = DB::getInstance()->query("SELECT * FROM faculty");

                                            foreach ($data->results() as $data) {                                           
                                        
                                        ?>
                                            <option value="<?php echo $data->fac_name?>"><?php echo $data->fac_name?></option>
                                        <?php
                                            }
                                        ?>
                                        
                                           
                                    </select>
                                </div>
                                 <div class="form-group">

                                    <label>Select Department</label> 
                                    <select class="form-control" name="department_name" id="department_name" onchange="dep_name()" required>
                                    <option></option>                                       
                                                                                  
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Select Module</label> 
                                    <select class="form-control" name="module_name" id="module_name">
                                     <option></option>
                                        
                                           
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Select Assessment</label> 
                                    <select class="form-control" name="assessment_type" required>
                                        <option></option>
                                        <option value="assignment">assignment</option>
                                        <option value="exam">exam</option>
                                        <option value="presentation">presentation</option>
                                        
                                           
                                    </select>
                                </div>

           
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Add Due Date</label>
                                        <input class="form-control" id="datepicker" type="text" name="due_date">
                                            
                                    </div>

                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Add Final Evidance Date</label>
                                        <input class="form-control" id="datepicker2" type="text" name="final_date">
                                            
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
                  
                </div>
                



                </div>
                <!-- /.row -->
              

               
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
