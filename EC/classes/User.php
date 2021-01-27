<?php
	#this class is for User
	class User {
		private $_db,
				$_data, // for storing data				 
				$_session_name_1,
				$_isLoggedIn; //for checking that user logged In or Not

		public function __construct($user = null){
			$this->_db = DB::getInstance();

			//get session form init class
			
			$this->_session_name_1 = Config::get('session/session_name_1');
			
			

			//for student
			if(!$user){
				if(Session::exists($this->_session_name_1)){
					$user = Session::get($this->_session_name_1);

					if($this->find($user)){
						$this->_isLoggedIn = true;
					}else {
						//process logout
					}
				}	
			}else {
				$this->find($user);
			}

		}



		//function for create data in database table user
		public function create($fields = []){
			if(!$this->_db->insert('student', $fields)){
				throw new Exception('there was a problem to insert data');
				
			}
		}

		//for student find and login
		private function find($user = null){
			if($user){
				$field = (is_numeric($user)) ? 'std_id' : 'std_email';
				$data = $this->_db->get('student',array($field,'=', $user));

				if($data->count()){
					$this->_data = $data->first();
					return true;
				}
			}
		}

		public function login($email= null, $password = null){

			$user = $this->find($email);

			if($user){
				if($this->data()->std_password === Hash::make($password, $this->data()->salt)){
					Session::put($this->_session_name_1, $this->data()->std_id);
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