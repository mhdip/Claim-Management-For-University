<?php
  /*
	Configaration class for database element, cookie, and session
	we configure this class form core/init.php page 
  */
	class Config {
		//form this mechanism of method we will get value form array of init.php class
		public static function get($path = null){
			if($path){
				$config = $GLOBALS['config'];
				$path = explode('/', $path);

				foreach ($path as $bit) {
					if(isset($config[$bit])){
						$config = $config[$bit];
					}
				}


				return $config;
				
			}
		}
	}

?>

