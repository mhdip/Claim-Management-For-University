<?php
	require_once dirname(__DIR__).'/core/init.php';
	$user = new User();
		if($user->isLoggedIn()){

		
		//echo $user->data()->std_first_name;
	



	$module_name = Input::get('module_name');


	if($module_name){

	 Session::put('module_name',$module_name);	

	$data = DB::getInstance()->get('assessment',array('mod_title','=',$module_name));

	?>
	  <select>
	  	  <option></option>
	  	  <?php
	  	  	foreach ($data->results() as $data) {
	  	  			  	  	
	  	  ?>
	  		<option value="<?php echo $data->assess_type?>"><?php echo $data->assess_type;?></option>
	  	   <?php 
	  	   	}
	  	   ?>
	  </select>	

<?php
	}

?>

<?php
	$semister_name = Input::get('semister_name');

	$data = DB::getInstance()->query("
		SELECT id from semister where semister_name = '$semister_name';	
	");

	foreach ($data->results() as $data) {
		echo $data->id;
	}
?>

<?php
	$assessment_type = Input::get('assessment_type');
	//$module_name = Input::get('module_name');
	$module_name = Session::get('module_name');
	//echo $module_name;

	 $id = $user->data()->std_id;
	 $semister_id = $user->data()->semister_id;
	

	$data = DB::getInstance()->query("
			SELECT
			  student.std_id,
			  assessment.mod_title,
			  assessment.assess_type,
			  assessment.assess_due_date as assess_due_date,
			  CURDATE() as present_date,
			  assessment.assess_final_date,
			  assessment.mod_title
			FROM
			  student
			INNER JOIN
			  assessment ON student.semister_id = assessment.semister_id
			where 
  			  student.std_id = $id and student.semister_id = $semister_id and assessment.mod_title = '$module_name' and assessment.assess_type = '$assessment_type'

		")

	?>
	  
	  	  
	  	  <?php
	  	  	foreach ($data->results() as $data) {
	  	  		
	  	  	 if($data->assess_due_date < $data->present_date){
	  	  	 	?>
	  	  	 	<div class="form-group">
			  		<div class="alert alert-success">
			  		    <span>This assessment due date has finished</span><br>
			  		    <span>Last date was: <?php echo $data->assess_due_date?></span>		
			  		</div>
	  			</div>
	  		<div class="form-group">
		  		<label>Assessment Final Evidence Date</label>
		  		<input class="form-control" type="text" name="" value="<?php echo $data->assess_final_date?>" readonly="readonly">
		  	</div>
	  			
	  	  	 	<?php
	  	  	 }else {



	  	  ?>
	  	  	<div class="form-group">
		  		<label>Assessment Due Date</label>
		  		<input class="form-control" type="text" name="" value="<?php echo $data->assess_due_date?>" readonly="readonly">
	  		</div>
	  		<div class="form-group">
		  		<label>Assessment Final Evidence Date</label>
		  		<input class="form-control" type="text" name="" value="<?php echo $data->assess_final_date?>" readonly="readonly">
		  	</div>
	  		
	  	   <?php
	  	   		}
	  	   		//Session::delete('module_name');


	  	   		
	  	   	}
	  	   ?>
	

<?php
	

}	



?>

