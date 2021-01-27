<?php
	/**
	* 
	*/
	#this class is for CSRF protection
	#first it generate the token
	#it check the token whether it valid or exist 
	#delete that token


	class Token 
	{
		//for generating Token 
		public static function generate(){
			return Session::put(Config::get('session/token_name'), md5(uniqid()));
		}

		//check if the token is exist or not
		public static function check($token){
			$tokenName = Config::get('session/token_name');

			if(Session::exists($tokenName) && $token === Session::get($tokenName)){
				Session::delete($tokenName);
				return true;
			}

			return false;
		}
	}
	
?>