<?php
class Validate {
	private $_passed = false,
			$_errors = array(), // for error message of input field, if data is given wrong or empty
			$_db = null; // for database connection

	public function __construct(){
		$this->_db = DB::getInstance();
	}

	#this function will check the every feild of input and their rules
	public function check($source, $items = [] ){
		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {
				//echo "{$item} {$rule} must be {$rule_value}".'<br>';

				
				@$value = trim($source[$item]);// this means->$_POST['username']
				$items = escape($item);//sanitize every input field;
				$item = str_replace('_', ' ', $items);



				if($rule === 'required' && empty($value)){
					$this->addError("Please Enter {$item} ");
				}else if($rule === 'select' && empty($value)){
					$this->addError("Please select {$item}");

				}else if($rule === 'describe' && empty($value)){
					$this->addError("Please describe your claim");

				}else if(!empty($value)){
					switch ($rule) {
						case 'min':
							if(strlen($value) < $rule_value){
								$this->addError("Your {$item} must be minimum of {$rule_value} characters");
							}
							break;
						case 'minimum':
							if(strlen($value) < $rule_value){
								$this->addError("{$item} must be minimum of {$rule_value} characters");
							}
							break;	
						case 'max':
							if(strlen($value) > $rule_value){
								$this->addError("Your {$item} must be maximum of {$rule_value} characters");
							}
							break;
						case 'maximum':
							if(strlen($value) > $rule_value){
								$this->addError("{$item} must be maximum of {$rule_value} characters");
							}
							break;	
						case 'matches':
							if($value != $source[$rule_value]){
								$this->addError("This {$rule_value} doesn't match with each other");
							}
							break;
						case 'unique':
							$data = $this->_db->get($rule_value, array($item,'=', $value));
							if($data->count()){
								$this->addError("<b>{$value}</b> is exists already");
							}
							break;


						case 'exists':
							$exists = $this->_db->query("SELECT * from {$rule_value} where {$item} = {$value}");
							if($exists->count()){
								$this->addError("<b>{$value}</b> already exists");
							}

						
						default:
							# code...
							break;
					}
				}

			}
		}

		//after validation it check error
		if(empty($this->_errors)){
			$this->_passed = true;
		}

		return $this;

	}


	//this function is for error message inside the class
	private function addError($error){
		$this->_errors[] = $error;
	}

	//this fucntion is for error outside the class, if data is validate then error message will show
	public function errors(){
		return $this->_errors;
	}

	//this funciton will use pass the data after validation
	public function passed(){
		return $this->_passed;
	}







}

?>