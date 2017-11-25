<?php
class Mysql extends PDO {
	public $server;
	public $database;
	public $user;
	public $password;

	public function __construct($server, $database, $user, $password, $port = 3306) {
		$this->server = $server;
		$this->database = $database;
		$this->user = $user;
		$this->password = $password;
		parent::__construct("mysql:host=$server;port=$port;dbname=$database", $user, $password);
		$this->query('SET NAMES utf8');
	}


	public function find($sql){
		$re = $this->query($sql);
		$row = $re->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function select($sql) {
		$return = array();
		$re = $this->query($sql);  //exec  返回影响行数
		while ($row = $re->fetch(PDO::FETCH_ASSOC)) {
			array_push($return, $row);
		}
		return $return;
	}
}