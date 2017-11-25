<?php 
/**
 * 仿TP5 Db Query
 */
class Db {
	protected $sql;
	private $tb_name;

	public static function table($name){
		$this->tb_name = $name;
		return $this;
	}

	public static function select(){
		global $Db;
		$res = $Db->select('select * from '.$this->tb_name);
		return $res;
	}
}