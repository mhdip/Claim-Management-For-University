<?php
class Input {

	//this function echek if input has been provided or not, default type is post
	public static function exists($type = 'post'){
		switch ($type) {
			case 'post':
				 return (!empty($_POST)) ? true : false;
				break;

			case 'get':
				 return (!empty($_GET)) ? true : false;
				break;
			
			default:
				return false;
				break;
		}
	}

	//this function is for get the item form input.. it's like $_POST['username'];
	public static function get($item){
		if(isset($_POST[$item])){
			return $_POST[$item];
		}elseif(isset($_GET[$item])){
			return $_GET[$item];
		}
		return '';
	}

}

?>