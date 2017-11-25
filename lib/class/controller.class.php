<?php 
class Controller{
	public $Db;
	public $request;
	public function __construct(){
		global $Db;
		$this->Db = $Db;
		$this->request = new Request();
	}
}