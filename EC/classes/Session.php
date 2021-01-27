<?php
	class Session {
		//this function is for set session with session_name and Session_value
		public static function put($name, $value){
			return $_SESSION[$name] = $value;
		}

		//this funciton is for check that, setting session is exist or not
		public static function exists($name){
			return (isset($_SESSION[$name])) ? true : false;
		}

		//this function is for get the session value 
		public static function get($name){
			return $_SESSION[$name];
		}

		//this function is for delete the session 
		public static function delete($name){
			#it will check if session exist then we will unset
			if(self::exists($name)){
				unset($_SESSION[$name]);
			}
		}

		

		//this funciton is for flashing messaage- means ist message appear, after refreshing the page it deleted
		//it takes two parameter "name" for the flash data and "content" of the flash data
		public static function flash($name, $string='') {
			#first check sessiong exist or not, if it is then we return the value that we store in session
			if(self::exists($name)){
				$session = self::get($name);
				self::delete($name);
				return $session;
			}else {
				self::put($name, $string);
			}
			
		}


	}

?>