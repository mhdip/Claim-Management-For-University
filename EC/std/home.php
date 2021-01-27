<!DOCTYPE html>
<html lang="en">
<?php include_once 'head.php';?>

<body>
    <?php
        require_once dirname(__DIR__).'/core/init.php';
    
     #check sesion flash data
    

    #how to get logged in user data



    $user = new User();
    if($user->isLoggedIn()){
       //echo escape($user->data()->std_first_name);

      //echo Session::get(Config::get('session/session_name_1'));
          
        
       ?>  

    <div id="wrapper">

        <!-- Navigation -->
        <?php
			include_once 'navbar.php';
		?>

        <div id="page-wrapper">
          <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Student- <?php echo "<span style='font-size:20px'>".$user->data()->dep_name." Department"."</span>";?></h1>
                </div>
            </div>
           
        <div class="row">
            <div class="col-md-4">
                <div class="login-panel panel panel-default" style="margin:0 0 0 0;">
                    <div class="panel-heading">
                        <h3 class="panel-title" id="dip">Enter claim Description</h3>
                    </div>

                        <div class="zartan_semister">
                        <?php @$module_name = Session::get('module_name');

                            

                        ?>
                             <?php
                                if(Token::check(Input::get('token'))){
                                    if(Input::exists()){


                                        $validate = new Validate();
                                        $validation = $validate->check($_POST, array(
                                            'module_name' => array(
                                                    'select' => true,
                                                    
                                                ),

                                            'assessment_type' => array(
                                                    'select' => true,
                                                    

                                                ),
                                            'EC_type' => array(
                                                    'select' => true,
                                                     

                                                ),
                                            'claim' => array(
                                                    'describe' => true,
                                                    
                                                     

                                                )


                                        ));

                                       

                                        

                                        if($validation->passed()){
                                            //echo "ok";

                                                
                                            //insert data
                                        $data = DB::getInstance()->query("SELECT assess_code, assess_due_date, assess_type, CURDATE() as present_date from assessment where mod_title = '$module_name'");

                                            foreach ($data->results() as $data) {
                                                if($data->assess_due_date < $data->present_date ){
                                                    echo "<div class='row'>";
                                                    echo "<div class='col-lg-8 col-lg-offset-2'>";
                                                    echo "<div id='zartan_error_message'>"; 
                                                    echo "Sorry your claim date has been finished";
                                                    echo "</div>";   
                                                    echo "</div>"; 
                                                    echo "</div>";

                                                }else {
                                                    $user = DB::getInstance()->insert('claim',array(
                                                'module_title'  => Input::get('module_name'),
                                                'assessment'    => Input::get('assessment_type'),
                                                'ec_type'       => Input::get('EC_type'),
                                                'claim_details' => Input::get('claim'),
                                                'claim_date'    => date('Y-m-d'),
                                                'last_date'     => date('Y-m-d', strtotime("+14 days")), 
                                                'std_id'        => $user->data()->std_id,


                                           ));



                                        if($user){
                                                
                                               Session::put('claim_success','Claim submitted successfully , please upload evidance!');
                                               Redirect::to('evidance.php');
                                                

                                            }else {
                                                echo "<div class='row'>";
                                                echo "<div class='col-lg-8 col-lg-offset-2'>";
                                                echo "<div id='zartan_error_message'>"; 
                                                echo "sorry,problem to claiming";
                                                echo "</div>"; 
                                                echo "</div>"; 
                                                echo "</div>"; 
                                            }
                                                }
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
                        <form role="form" action="" method="post">
                            <fieldset>
                                <label>Select Module Name</label>
                                <div class="form-group">
                                    <select class="form-control" name="module_name" id="module_name" onchange="module()"  required="required">
                                         <option></option>
                                           
                                            <?php


                                               $std_id   = $user->data()->std_id;
                                               $semister_id   = $user->data()->semister_id;

                                               $data = DB::getInstance()->query(
                                                "SELECT student.std_id, student.dep_name, module.mod_title, module.semister_id 
                                                from student 
                                                INNER JOIN department 
                                                on student.dep_name = department.dep_name 
                                                INNER join module 
                                                on module.dep_name = department.dep_name
                                                INNER JOIN semister 
                                                on semister.id = module.semister_id 
                                                where student.std_id = $std_id
                                                and module.semister_id = $semister_id 
                                                


                                                ");

                                            
                                               foreach ($data->results() as $data) {
                                                ?>
                                                    <option value="<?php echo $data->mod_title;?>"><?php echo $data->mod_title?></option>
                                                <?php
                                               }
                                                

                                            ?>
                                                           
                                    </select>
                                </div> 

                                <div class="form-group">
                                 <label>Select Assesment Type</label>
                                   
                                    <select class="form-control" name="assessment_type" id="assessment_type" onchange="assessment()" required="required">
                                        <option></option>
                                         
                                            
                                                           
                                    </select>
                                </div>
                                
                                <div class="form-group" id="">
                                    

                                </div>
                                
                                
                                
                                <div class="form-group">
                                 <label>Select EC Type</label>
                                    <select class="form-control" name="EC_type" required="required">
                                             <option></option>
                                            <option value="family">Family</option>
                                            <option value="accident">Accident</option>
                                            <option value="finance">Finance</option>
                                            <option value="other">Other</option>
                                                           
                                    </select>
                                </div>
                                <div class="form-group"> 
                                    
                                        <label>Describe Your Claim</label> 
                                        <span id="textarea_feedback" style="float: right; color: grey;"></span>
                                        <textarea id="textarea" class="form-control" rows="4" placeholder="Not more than 200 character..." maxlength="200" name="claim" required="required"  onkeydown="clean('textarea')" onkeyup="clean('textarea')"><?php echo Input::get('claim')?></textarea>
                                </div>

                                
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="hidden" name="token" value="<?php echo Token::generate()?>">
                                <input type = "submit" value="Claim" class="btn btn-lg btn-primary btn-block">
                                
                                
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Please select your module name and assessment type to see their date details    
                    </div>
                   
                    <div class="panel-body" id="assessment_due_date">
                           
                    </div>
                        
                </div>
            </div>
        </div>

   
        </div>    
        </div>
        <!-- /#page-wrapper -->
        <div>
          


        </div>

    </div>
    <!-- /#wrapper -->
    <script type="text/javascript">
        $(document).ready(function() {
            var text_max = 200;
            $('#textarea_feedback').html(text_max+ ' character remaining');
            
            $('#textarea').keyup(function(){
                var text_lenght = $('#textarea').val().length;
                var text_remaining = text_max - text_lenght;
                    
                var h=$('#textarea_feedback').html(text_remaining+ ' character remaining');
            
            
        });
    });

        function module(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET","stdAgx.php?module_name="+document.getElementById('module_name').value,false);
            xmlhttp.send(null);
            //alert(xmlhttp.responseText);
            document.getElementById("assessment_type").innerHTML=xmlhttp.responseText;
            
            if(document.getElementById('module_name').value == ' ' ){
                alert("hello");
            }      

        }

         function assessment(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET","stdAgx.php?assessment_type="+document.getElementById('assessment_type').value,false);
            xmlhttp.send(null);
            //alert(xmlhttp.responseText);
            document.getElementById("assessment_due_date").innerHTML=xmlhttp.responseText;
                

        }


       function clean(e){
        var textfield = document.getElementById(e);

        var regex = /[^a-z 0-9?!.,]/gi;

        textfield.value = textfield.value.replace(regex, "");

    }
       

    </script>

   <?php include_once 'footer.php';?>


    <?php
    }else {
        Redirect::to('index.php');
    }
    ?>

</body>

</html>
