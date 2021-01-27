<?php
	
            require_once dirname(__DIR__).'/core/init.php';

	$id = Input::get('cd');

	$data = DB::getInstance()->query("SELECT * from claim where claim_no= $id ");

	foreach ($data->results() as $data) {
		$path = $data->file_path;
		header('content-Disposition: attachment; filename ='.$path.' ');
		header('content-type:application/octent-strem');
		header('content-lenght='.filesize($path));
		readfile($path);



	}
?>