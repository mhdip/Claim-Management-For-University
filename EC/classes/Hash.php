<?php
	class Hash {

		//this funciton is for making hash
		#it will hash the string we provide 
		#the string will also converted into salt
		#salt randomely generated form string and make it secure data
		public static function make($string, $salt= ''){
			return hash('sha256', $string.$salt);
		}

		//this funciton is for making salt associated with password hashing
		public static function salt($length){
			//this gonna provide us some rubbish such as *^..{}sse&^*^(3409)
			return mcrypt_create_iv($length);

		}

		//this function is for making totaly uniq hash 
		public static function uniqe(){
			return self::make(uniqid());
		}
	}

?>