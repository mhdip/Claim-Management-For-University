<?php
	class Staff {
		private $_db,
				$_data, // for storing data				 
				$_session_name_1,
				$_isLoggedIn; //for checking that user logged In or Not

		public function __construct($user= null){
			$this->_db = DB::getInstance();

			$this->_session_name_2 = Config::get('session/session_name_2');

			if(!$user){
				if(Session::exists($this->_session_name_2)){
					$user = Session::get($this->_session_name_2);

					if($this->staff_find($user)){
						$this->_isLoggedIn = true;
					}else {
						//process logout
					}
				}	
			}else {
				$this->staff_find($user);
			}
		}

		private function staff_find($user = null){
			if($user){
				$field = (is_numeric($user)) ? 'coo_id' : 'coo_email';
				$data = $this->_db->get('ec_coo',array($field,'=', $user));

				if($data->count()){
					$this->_data = $data->first();
					return true;
				}
			}
		}

		public function staff_login($email= null, $password = null){

			$user = $this->staff_find($email);

			if($user){
				if($this->data()->coo_password === Hash::make($password, $this->data()->salt)){
					Session::put($this->_session_name_2, $this->data()->coo_id);
					return true;
				}
			}

			return false;

		}


		//this function is for that user permission
		public function hasPermission($key){
			//this->data()-group means user table group row;
			$group = $this->_db->get('groups',array('id','=',$this->data()->group));

			//check if the user is in a group or not
			if($group->count()){
				//decode in json format	
			    $permissions = json_decode($group->first()->permissions,true);

			   //check the permission role
			    if(@$permissions[$key] == true){
			    	return true;
			    }			    
			}
			return false;

		}


		//this function is for getting user data who are logged in
		public function isLoggedIn(){
			return $this->_isLoggedIn;
		}

		//this function is for logout
		public function logout($string){
			Session::delete($string);
		}

		//this function return the data of the database for particual user
		public function data(){
			return $this->_data;
		}

	}
?>