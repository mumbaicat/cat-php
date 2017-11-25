<?php 

class Cache {

	public static function set($name,$value){
		file_put_contents('lib/cache/'.$name.'.cache', serialize($value));
	}

	public static function get($name){
		$path = 'lib/cache/'.$name.'.cache';
		if(!file_exists($path)){
			return false;
		}
		$data = file_get_contents($path);
		return unserialize($data);
	}

	public static function rm($name){
		$path = 'lib/cache/'.$name.'.cache';
		if(!file_exists($path)){
			return false;
		}
		return unlink($path);
	}

	public static function clear(){
		$file=scandir('lib/cache');
		foreach ($file as $name) {
			if($name!='.' and  $name!='..'){
				unlink('lib/cache/'.$name);
			}
		}
	}
	
}