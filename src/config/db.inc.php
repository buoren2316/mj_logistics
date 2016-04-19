<?php

/*
 * func: connect Business DB2 
 * auth: buoren
 * date: 2011-05-06
 */



class DBSQL {
	private $CONN = "";
	
	/**
	* Function: Initialization MySQL DB
	*/

	public function __construct(){
		try {
			$CONN = mysql_connect(ServerName,UserName,PassWord);
		} catch (Exception $e) {
			$msg = $e;
			 die("<br><br><center><b>There seems to be a problem with the $dbtype server, sorry for the inconvenience.<br><br>We should be back shortly.</center></b>");
		}
		try {
			mysql_select_db(DBName,$CONN);
			mysql_query("SET NAMES UTF8");
		} catch (Exception $e) {
			$msg = $e;
			 die("<br><br><center><b>There seems to be a problem with the $dbtype server, sorry for the inconvenience.<br><br>We should be back shortly.</center></b>");
		}
		$this->CONN = $CONN;
		
	}

	public function select ($sql="") {
		//echo $sql;
		if(empty($sql)) return false;	//SQL 语句为空返回FALSE
		if(empty($this->CONN)) return false;	//连接为空返回FALSE
 
		// Start memcache
		//$mem = new Memcache;
		//$mem->connect('127.0.0.1', 11211) or die ("Could not connect");

		//$key = md5($sql);
		//if ( !($datas = $mem->get($key)) ) {

			$results = mysql_query($sql,$this->CONN);
			if(!$results || empty($results)) {	//如果查询结果为空则释放结果并返回FALSE
				@mysql_free_result($results);
				return false;
			}		
			$count = 0;
			$data = array();

			while ($row=mysql_fetch_array($results)) {	//查询结果重组成二维数组
				$data[$count] = $row;
				//$mem->add($count,$row,300);
				$count++;

			}
			@mysql_free_result($results);
		//}else{
		//	$data = $mem->get($key);
		//}
		return $data;
	}

	public function getid ($sql="") {
		if(empty($sql)) return false;	//SQL 语句为空返回FALSE
		if(empty($this->CONN)) return false;	//连接为空返回FALSE
		
		$results = mysql_query($sql,$this->CONN);
		if(!$results || empty($results)) {	//如果查询结果为空则释放结果并返回FALSE
			@mysql_free_result($results);
			return false;
		}
		
		$count = 0;
		$data = array();
		$data=mysql_fetch_row($results);
		@mysql_free_result($results);
		return $data;
	}


	public function insert ($sql = ""){
		if(empty($sql)) return false;	//SQL 语句为空返回FALSE
		if(empty($this->CONN)) return false;	//连接为空返回FALSE
		
		$results = mysql_query($sql,$this->CONN);
		if (!$results) return 0;	//如果插入失败返回0，否则返回当前插入记录ID
		else return @mysql_insert_id($this->CONN);
	}

	public function update($sql="") {
		if(empty($sql)) return false;	//SQL 语句为空返回FALSE
		if(empty($this->CONN)) return false;	//连接为空返回FALSE

		$result = mysql_query($sql,$this->CONN);
		return $result;
	}

	public function deldata($sql="") {
		if(empty($sql)) return false;	//SQL 语句为空返回FALSE
		if(empty($this->CONN)) return false;	//连接为空返回FALSE
		
		$result = mysql_query($sql,$this->CONN);
		return $result;
	}

	public function begintransaction () {
		mysql_query("SET AUTOCOMMIT=0");	//设置不自动提交
		mysql_query("BEGIN");
		
	}

	public function rollback() {
		mysql_query("ROOLBACK");
	}

	public function commit() {
		mysql_query("COMMIT");
	}


	public function close() {
		@mysql_close();
	}

}
