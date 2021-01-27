

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
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header"> Assessment and Their Date Details</h1>

                        </div>
                    </div>

                    <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            All Module date details
                        </div><br>
                        <!-- /.panel-heading -->
                        <div class="row">
                        <div class="col-lg-6 col-lg-offset-3">
                            <div style="margin-bottom:3px;">
                                <?php echo Session::flash("assessment_delete")?>
                            </div>
                            <input type="text" name="search" id="search" class="form-control" placeholder="Search Data...">

                        </div>

                        </div>

                        <div class="panel-body">
                            <?php
										
										
                                        $page_Id = Input::get('page') ? Input::get('page'): 1;
                                        $page = filter_var($page_Id, FILTER_SANITIZE_NUMBER_INT);

                                        $perPage = Input::get('per-page') && Input::get('per-page') <=50 ? (int)Input::get('per-page'): 15;
                                            
                                        $start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

                                        $total = DB::getInstance()->query("SELECT * from assessment")->count();

                                        $pages = ceil($total/$perPage);

                            ?>
							

							
							 
                            <?php for($x=1; $x<= $pages; $x++):?>
                                    <ul class="pagination">
                                        <li><a href="?page=<?php echo $x; ?>"><?php echo $x;?></a></li>
                                    </ul>    
                            <?php endfor;?>
							
							<!--<div class='row'>
								<div class='col-lg-12' style=''>
								 
									<div class='pull-right'>
									<span style='margin-right:5px'><b>Select number of records</b></span>
									 <select name='select_record'>
										<option value=5>5</option>
										<option value=10>10</option>
										<option value=15>15</option>
										<option value=20>20</option>
										
									</select>
									</div>
								</div>
							</div>-->
                            <div class="table-responsive" >
                                <table class="table table-bordered" id="table_data">
                                   <?php
                                     $data = DB::getInstance()->query("SELECT * FROM assessment order by assess_code desc limit $start, $perPage");

                                     if(!$data->count()){
                                        echo "<span style='color:red;'>No record found</span>";
                                     }else {
                                   ?>
                                    <thead>
                                        <tr style="background:black;color:white">
                                            <th>Serial no</th>
                                            <th>Department Name</th>
                                            <th>Module Name</th>
                                            <th>Assessment Type</th>
                                            <th>Due Date</th>
                                            <th>Final Date</th>
                                            <th>Action</th>
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
                                            <td><?php echo $data->dep_name;?></td>
                                            <td><?php echo $data->mod_title;?></td>
                                            <td><?php echo $data->assess_type;?></td>
                                            <td><?php echo $data->assess_due_date;?></td>
                                            <td><?php echo $data->assess_final_date;?></td>
                                            <td>
                                             <a href="assessment_ed.php?id=<?php echo $data->assess_code?>">Edit</a> || 
                                            <a onclick="return confirm('Are you sure to delete')" href="assessment_dl.php?id=<?php echo $data->assess_code?>">Delete</a>
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
                    <!-- /.panel -->
                </div>    
                </div>    
            </div>        
        </div>            <!-- /.col-lg-12 -->
                    
    </div>               






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
