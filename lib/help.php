<?php 
// 系统补助函数

/**
 * 仿TP5 Cookie操作
 * @param  string $name  cookie名称
 * @param  string $value 若有值,则设置;若为空,则读取;若为null,则为删除.
 * @param  integer $time  有效时间,单位秒. 默认关闭浏览器删除
 * @return void        
 */
function cookie($name,$value='',$time=null){
	if($value===''){
		if(empty($_COOKIE[$name])){
			return false;
		}else{
			return $_COOKIE[$name];
		}
	}elseif($value===null){
		setcookie($name,'',time()-3600,"/");
	}else{
		if($time!=null){
			setcookie($name,$value,time()+$time,"/");
		}else{
			setcookie($name,$value, 0 ,"/"); // ?
		}
	}
}


/**
 * 数组分页
 * @param  array  $array 字典数组
 * @param  integer  $page  页数
 * @param  integer  $count 一页个数
 * @param  integer $order 排序 0升序 1降序
 * @return array
 */
function page($array, $page, $count, $order = 0) {
	$countpage = 0;
	$page = (empty($page)) ? '1' : $page;
	$start = ($page - 1) * $count;
	if ($order == 1) {
		$array = array_reverse($array);
	}
	$totals = count($array);
	$countpage = ceil($totals / $count); #计算总页面数
	$pagedata = array();
	$pagedata = array_slice($array, $start, $count);
	return $pagedata;
}


/**
 * 生成JSON信息
 * @param  integer $code 状态码
 * @param  string $msg  提示信息
 * @param  array  $data 附加数据
 * @return string       
 */
function makeReturnJson($code,$msg,$data=''){
	$return = array(
		'code'=>$code,
		'msg'=>$msg,
		'data'=>$data
	);
	header("Content-type: text/json; charset=utf-8");
	// return json_encode($return,JSON_UNESCAPED_UNICODE);
	exit(json_encode($return,JSON_UNESCAPED_UNICODE));
}

/**
 * 生成Layui的智能表格的Json
 * 先获取$_GET['page'] 和 $_GET['limit'] ,然后进行page分页
 * @param  array $data  分页后的数组
 * @param  integer $count 总个数
 * @return void        
 */
function makeLayuiTable($data,$count){
	$return =[
		'code'=>0,
		'msg'=>'获取成功',
		'count'=>$count,
		'data'=>$data,
	];
	header("Content-type: text/json; charset=utf-8");
	exit(json_encode($return,JSON_UNESCAPED_UNICODE));
}

/**
 * 简单的过滤输入信息
 * @param  string $text 信息
 * @return string       
 */
function filter($text){
	$text = addslashes($text);
	$text = strip_tags($text);
	return $text;
}

/**
 * 取出字符串之间
 * @param  string $str      总文本
 * @param  string $leftStr  左边文本
 * @param  string $rightStr 右边文本
 * @return string           
 */
function strCenter($str, $leftStr, $rightStr) {
	$left = strpos($str, $leftStr);
	$right = strpos($str, $rightStr, $left);
	if ($left < 0 or $right < $left) {
		return '';
	}
	return substr($str, $left + strlen($leftStr), $right - $left - strlen($leftStr));
}

/**
 * 获取字符串的右边
 * @param  string $string 全部字符串
 * @param  string $left   根据字符串左边
 * @return string         得到右边的字符串
 */
function stringRight($string,$left){
	$leftLength = strlen($left);
	$index = strpos($string,$left);
	if($index == -1){
		return false;
	}
	$result = substr($string, $index+$leftLength); 
	return $result;
}

/**
 * 获取字符串的左边
 * @param  string $string 全部字符串
 * @param  string $right  根据字符的右边
 * @return string         得到左边的字符串
 */
function stringLeft($string,$right){
	$reg = '/(.*)'.$right.'.*/';
	preg_match($reg,$string,$data);
	if(empty($data[1])){
		return false;
	}
	return $data[1];
}