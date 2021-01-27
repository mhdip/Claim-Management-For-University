<?php
	require_once dirname(__DIR__).'/core/init.php'; 
	$fac_name = Input::get('faculty_name');


	if($fac_name){

	$data = DB::getInstance()->get('department',array('fac_name','=',$fac_name));

	?>
	  <select>
	  	  <option></option>	
	  	  <?php
	  	  	foreach ($data->results() as $data) {
	  	  			  	  	
	  	  ?>
	  		<option value="<?php echo $data->dep_name?>"><?php echo $data->dep_name;?></option>
	  	   <?php 
	  	   	}
	  	   ?>
	  </select>	

<?php
	}
?>
<?php
	//require_once dirname(__DIR__).'/core/init.php';
	$dep_name = Input::get('department_name');

	$department_name = Input::get('department_name');

	if($dep_name){

	$data = DB::getInstance()->get('module',array('dep_name','=',$dep_name));

	?>
	  <select>
	  	  <option></option>	
	  	  <?php
	  	  	foreach ($data->results() as $data) {
	  	  			  	  	
	  	  ?>
	  		<option value="<?php echo $data->mod_title?>"><?php echo $data->mod_title;?></option>
	  	   <?php 
	  	   	}
	  	   ?>
	  </select>	

<?php
	}
?>



