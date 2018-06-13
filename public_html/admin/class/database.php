<?php
class Database {
	
	private $connection;
	private $reg;
	private $type;
	private $bStatus = false;
	private $arrQueries = array();
	
	public function __construct($type, $hostname, $username, $password, $database, $reg) {
		//$mysqli = new mysqli("localhost", "user", "password", "database");
		$this->reg = $reg;
		$this->type = $type;
		if($this->type == 'mysql'){
			if (!$this->connection = mysql_connect($hostname, $username, $password)) {
				return false;
			}else{
				if (!mysql_select_db($database, $this->connection)) {
					return false;
				}else{
					mysql_query("SET NAMES 'utf8'", $this->connection);
					mysql_query("SET CHARACTER SET utf8", $this->connection);
					mysql_query("SET CHARACTER_SET_CONNECTION=utf8", $this->connection);
					mysql_query("SET SQL_MODE = ''", $this->connection);
					}
				}
		}else if($this->type == 'mssql'){
			if (!$this->connection = mssql_connect($hostname, $username, $password)) {
				exit('Error: Could not make a database connection using ' . $username . '@' . $hostname);
			}else{
				if (!mssql_select_db($database, $this->connection)) {
					return false;
				}else{
					mssql_query("SET NAMES 'utf8'", $this->connection);
					mssql_query("SET CHARACTER SET utf8", $this->connection);
					mssql_query("SET CHARACTER_SET_CONNECTION=utf8", $this->connection);
					}
				}
			}
		$this->bStatus = true;	
		}
		
  	public function query($sql) {
		//debug
		//$this->reg->get('log')->log('queries', $sql);
		//debug
		array_push($this->arrQueries, $sql);
		//
		if(!$this->connection){
			return false;	
			}
			
		if($this->type == 'mysql'){
			$resource = mysql_query($sql, $this->connection);	
		}else if($this->type == 'mssql'){	
			$resource = mssql_query($sql, $this->connection);
			}
		if($resource){
			if(is_resource($resource)) {
				$i = 0;
				$data = array();
				if($this->type == 'mysql'){
					while($result = mysql_fetch_assoc($resource)){
						$data[$i] = $this->addSlashes($result);
						$i++;
						}
					mysql_free_result($resource);
				}else if($this->type == 'mssql'){	
					while ($result = mssql_fetch_assoc($resource)) {
						$data[$i] = $this->addSlashes($result);
						$i++;
						}
					mssql_free_result($resource);
					}		
			
			$query = new stdClass();
			$query->row = isset($data[0]) ? $data[0] : array();
			$query->rows = $data;
			$query->num_rows = $i;
			unset($data);
			return $query;	
						
		}else {
			return 1;
			}
		}else{
			if($this->type == 'mysql'){
				exit('Error: ' . mysql_error($this->connection) . '<br />Error No: ' . mysql_errno($this->connection) . '<br />' . $sql);
			}else if($this->type == 'mssql'){		
				exit('Error: ' . mssql_get_last_message($this->connection) . '<br />' . $sql);
				}
			}
		}
		
	public function getRessource($sql) {
		$resource = mysql_query($sql, $this->connection);
		if($resource){
			if(is_resource($resource)) {
				return $resource;
			}else {
				return false;
				}
		}else{
			exit('Error: ' . mysql_error($this->connection) . '<br />Error No: ' . mysql_errno($this->connection) . '<br />' . $sql);
			}
		return false;
		}	
		
	private function addSlashes($result){
		if(is_array($result)){
			foreach($result as $k=>$v){
				$result[$k] = $this->addSlashes($result[$k]);
				}
		}else{
			$result = stripslashes($result);
			$result = htmlspecialchars($result, ENT_COMPAT, 'UTF-8');
			}
		return $result;
		}
	
	public function escape($value){
		if($this->type == 'mysql'){
			return mssql_real_escape_string($value, $this->connection);
		}else if($this->type == 'mssql'){		
			return mysql_real_escape_string($value, $this->connection);
			}
		}
	
  	public function countAffected() {
    	if($this->type == 'mysql'){
			return mysql_affected_rows($this->connection);
		}else if($this->type == 'mssql'){		
			return mssql_rows_affected($this->connection);
			}
		}

  	public function getLastId() {
    	if($this->type == 'mysql'){
			return mysql_insert_id($this->connection);
		}else if($this->type == 'mssql'){		
			$last_id = FALSE;
			$resource = mssql_query("SELECT @@identity AS id", $this->connection);
			if ($row = mssql_fetch_row($resource)) {
				$last_id = trim($row[0]);
				}
			mssql_free_result($resource);
			return $last_id;
			}
		}	
	
	public function __destruct() {
		if($this->type == 'mysql'){
			if($this->connection){
				mysql_close($this->connection);
				}	
		}else if($this->type == 'mssql'){	
			mssql_close($this->connection);
			}
		}
	
	public function showRows($rs){
		$bTitle = 0;
		$table = '<table border="1" cellpadding="2" cellspacing="2">';
		foreach($rs->rows as $k=>$v){
			if(!$bTitle){
				$table .= $this->showTitle($v);
				$bTitle = 1;
				}
			$table .= $this->showRow($v);
			}
		$table .= '</table>';
		echo $table;
		}

	public function showTitle($row){
		$data = '<tr>';
		foreach($row as $k=>$v){
			$data .='<td><font size="-1"><b>'.$k.'</b></font></td>';
			}
		$data .= '</tr>';
		return $data;
		}

	public function showRow($row){
		$data = '<tr>';
		foreach($row as $k=>$v){
			$data .='<td><font size="-1">'.$v.'</font></td>';
			}
		$data .= '</tr>';
		return $data;
		}	
		
	public function getStatus(){
		return $this->bStatus;
		}	
		
	public function getQueries(){
		return $this->arrQueries;
		}	
		
	
		
		
	}
?>