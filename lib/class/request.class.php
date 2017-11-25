<?php 
class Request{

	public static function path(){
		global $PATH_PARAM;
		return $PATH_PARAM;
	}

	public static function action(){
		global $PATH_PARAM;
		return $PATH_PARAM[2];
	}

	public static function controller(){
		global $PATH_PARAM;
		return $PATH_PARAM[1];
	}

	public static function param($name=null){
		global $PATH_PARAM;
		$paramRaw = $PATH_PARAM;
		unset($paramRaw[0]);
		unset($paramRaw[1]);
		unset($paramRaw[2]);

		if(count($paramRaw)==0){
			return false;
		}
		$param = array();
		foreach ($paramRaw as $key) {
			array_push($param,$key);
		}
		$array = array();
		for ($i=0; $i < count($param); $i=$i+2) { 
			if(!empty($param[$i+1])){
				$array[$param[$i]]=filter($param[$i+1]);	// 这里过滤输入了
			}else{
				$array[$param[$i]]=null;
			}
		}

		if($name==null){
			return $array;
		}

		if(!empty($array[$name])){
			return $array[$name];
		}else{
			return false;
		}
	}

}