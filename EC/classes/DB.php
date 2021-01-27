<?php
class DB {
	private static $_instance = null;
	private $_pdo, 
			$_query, 
			$_error = false, 
			$_results, 
			$_count = 0,
			$_fetchColumn;
	
	private function __construct(){
			try{
				$this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.
													Config::get('mysql/db'),
													Config::get('mysql/username'),
													Config::get('mysql/password'));	
						
						//echo 'connected';							
													
			}catch(PDOexception $e){
				die($e->getMessage());	
			}	
		}

	//Use this function for connection to database separately which establish connection just once
	public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new DB();	
			}
			return self::$_instance;	
		}

	//query with sql injection protection 
	public function query($sql, $params = array()){
			$this->_error = false;
			if($this->_query = $this->_pdo->prepare($sql)){
				$x=1;
				if(count($params)){
					foreach($params as $param){
						$this->_query->bindValue($x, $param);
						$x++;
					}
				}
				
				if($this->_query->execute()){
					$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
					$this->_count = $this->_query->rowCount();
					$this->_fetchColumn = $this->_query->columnCount();
					
				}else {
					$this->_error = true;
				}
			}
			return $this;		
		}
	
	//this funciton allow more flexility to use select element and delete element form database
	private function action($action, $table, $where = array()){
		if(count($where) === 3 ){
			$operators = array('=', '>', '<', '>=', '<=','and','between','in','like');
			
			$field  	 = $where[0];
			$operator    = $where[1];
			$value		 = $where[2];
			
			if(in_array($operator, $operators)){
				$sql = "{$action} from {$table} where {$field} {$operator} ?";
				if(!$this->query($sql, array($value))->error()){
					return $this;
				}
			}	
		}
		return false;	
	}

	//this funciton will work fol select element form the databse
	public function get($table, $where){
			return $this->action('select *', $table, $where);
	}
	
	//this funciton will work for delete element form the databse
	public function delete($table, $where){
		return $this->action('delete', $table, $where);	
	}
	
	//this function allow insertion with lot's of flexbility 
	public function insert($table, $fields = array()){
		if(count($fields)){
			$keys 	= array_keys($fields);
			$values = '';
			$x = 1;
			
			foreach($fields as $field){
				$values .= '?';
				if($x < count($fields)){
					$values .= ', ';
				}
				$x++;
				
			}
			
			$sql = "Insert into {$table} (`". implode('`, `',$keys)."`) values ({$values})";  
			
			if(!$this->query($sql, $fields)->error()){
				return true;


			}
		}
		
		return false;

	}
	
	// this function allow update with flexibility 
	public function update($table, $id, $fields){
		$set = '';
		$x = 1;
		
		foreach($fields as $name => $value){
			$set .= "{$name} = ?";
			if($x < count($fields)){
				$set .= ', ';
			}
			$x++;
		}
		
		$sql = "update {$table} set {$set} where id ={$id}";
		
		if(!$this->query($sql, $fields)->error()){
			return true;
		}
		return false;	
	}
	//update by string
	public function update_by_field($table, $field_name, $field_value, $fields){
		$set = '';
		$x = 1;
		
		foreach($fields as $name => $value){
			$set .= "{$name} = ?";
			if($x < count($fields)){
				$set .= ', ';
			}
			$x++;
		}

		// update "table" set "set" where field_name = '1st semister';
		//UPDATE `semister` SET `closure_date` = '2017-03-30' WHERE `semister`.`semister_name` = '2nd semister';
		
		$sql = "update {$table} set {$set} where {$field_name} ={$field_value}";
		
		if(!$this->query($sql, $fields)->error()){
			return true;
		}
		return false;	
	}
	
	//fetch the all the result  form the daabse
	public function results(){
		return $this->_results;	
	}

	// fethcn the first result form the databse
	public function first(){
		return $this->_results[0];
		  //return $this->results()[0];		
	}
	
	//fetch the error form the databse if any erro happening in databse
	public function error(){
		return $this->_error;	
	}
	
	//fethe row form the databse
	public function count(){
		return $this->_count;	
	}

	//fetch the column form the databse
	public function fetchColumn() {
		return $this->_fetchColumn;
	}	
}
