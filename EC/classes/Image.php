<?php
	/**
	* 
	*/
	class Image
	{
		
		function __construct()
		{
			
		}


	public static function upload_file($filename, $destination){
	 //require_once dirname(__DIR__).'/core/init.php';


	  if(isset($_FILES[$filename])){
		$file = $_FILES[$filename];


		$file_name = $file['name'];
		$file_tmp = $file['tmp_name'];
		$file_size = $file['size'];
		$file_error = $file['error'];


		if(empty($file_name)){
			echo "Please choose an Image or PDF";
		}else {
			$allowed = array('jpg','jpeg','png','pdf');
			
			$file_ext = explode('.', $file_name);
			$file_exts = strtolower(end($file_ext));

			if(in_array($file_exts, $allowed)){
				 if($file_error === 0){
				 	if($file_size <= 2097152){

				   $file_name_new = uniqid('', true).'.'.$file_exts;
				    $file_destination = $destination.'/'.$file_name_new;

				    if(move_uploaded_file($file_tmp, $file_destination)){
				    	

				   		$image = DB::getinstance()->query(
				   			"UPDATE claim
							SET file_name= '$file_name_new', file_path='$file_destination', 
							WHERE claim_no=15" 
				   		);
				   		echo "Your fle has been uploaded successfully";
				   		//echo $file_destination;

				   }
				  }  
				 }else {
				 	echo "Upload Correct file With minimum of 2 MB size ";
				 }  
				
			}else {
				echo "Only jpg, jpeg, png and pdf are allowed";
			}

		}

	}

}

}
?>