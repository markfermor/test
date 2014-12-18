<?php

require_once(dirname(__FILE__)."/Exceptions.php");

class MySQL extends MySQLi{
	
	var $m_server;
	var $m_dbname;

	function __construct($server,$dbname,$user,$pass = ""){
		if(trim($server) && trim($dbname) && trim($user)){
			parent::__construct($server, $user, $pass, $dbname);
			$this->m_server = $server;
			$this->m_dbname = $dbname;
		}else{
			throw new InvalidArgumentException("Parameters missing");
		}
		if($this->connect_errno){
			throw new MySQLConnectionException($this->error);
		}
	}

	function execute($query){
		return $this->query($query);
	}

	function insertFromArray($table,$data,$replace =false){
		if (trim($table) && is_array($data)){
			$insertPair = Array();
			while(list($key,$value)=each($data)){
				$insertPair[] = $this->real_escape_string($key)."='".$this->real_escape_string($value)."'";
			}
			if(count($insertPair) > 0){
				if($replace == true){
					$query = ("REPLACE INTO ".$this->real_escape_string($table)." SET ".implode(",",$insertPair));
				}else{
					$query = ("INSERT INTO ".$this->real_escape_string($table)." SET ".implode(",",$insertPair));
				}
				#echo "$query\n";
				$this->execute($query);
				if($this->errno){
					throw new MySQLInsertException($this->errno." - ".$this->error."\n\t$query");
				}
				return $this->insert_id;
			}
		}
		return false;
	}

	function insert($table,$fields,$values){
		if (trim($table) && is_array($fields) && is_array($values)){
			$insertPair = Array();
			if(is_array($fields)){
				while(list($key,$value)=each($fields)){
					if(array_key_exists($key,$values)){
						$insertPair[] = $this->real_escape_string($value)."='".$this->real_escape_string($values[$key])."'";
					}
				}
			}
			if(count($insertPair) > 0){
				$query = ("INSERT INTO ".$this->real_escape_string($table)." SET ".implode(",",$insertPair));
				#echo "$query\n";
				$this->execute($query);
				if($this->errno){
					throw new MySQLInsertException($this->errno." - ".$this->error."\n\t$query");
				}
				return $this->insert_id;
			}
		}
	}

	/* Returns first field of first row in resultset */
	function getValue($query){
		$result = $this->execute($query);
		if($result != null){
			if($result->num_rows > 0){
				$field = $result->fetch_array(MYSQLI_NUM);
				if(is_array($field)){
					$result->close();
					return $field[0];
				}
			}
			$result->close();
		}
		return false;
	}

	/* Returns first row in resultset */
	function getValues($query){
		$result = $this->execute($query);
		if($result->num_rows > 0){
			$field = $result->fetch_array(MYSQLI_ASSOC);
			if(is_array($field)){
				$result->close();
				return $field;
			}
		}
		$result->close();
		return false;
	}

	/* Returns first row in resultset */
	function getRows($query){
		$result = $this->execute($query);
		$rows = array();
		if($result != null && $result->num_rows > 0){
			while($tmp = $result->fetch_array(MYSQLI_ASSOC)){
				if(is_array($tmp)){
					$rows[] = $tmp;
				}
			}
			$result->close();
			return $rows;
		}
		return false;
	}

	function delete($table,$condition){
		if(is_array($condition)){
			while(list($key,$value)=each($condition)){
				$insertPair[] = $this->real_escape_string($key)."='".$this->real_escape_string($value)."'";
			}
		}else{
			throw new MySQLDeleteException("No conditions were supplied to the delete method for table $table");
		}
		$query = "DELETE FROM ".$this->real_escape_string($table)." WHERE ".implode(" AND ",$insertPair);
		$this->execute($query);
		if($this->errno){
			throw new MySQLDeleteException($this->errno." - ".$this->error."\n\t$query");
		}
	}



}

?>