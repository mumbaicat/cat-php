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
function make_return_json($code,$msg,$data=''){
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
 * @param  integer $count 全部数组
 * @return void
 */
function make_layui_table($data,$count){
	$return =[
		'code'=>0,
		'msg'=>'获取成功',
		'count'=>count($count),
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
function get_string_center($str, $leftStr, $rightStr) {
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
function get_string_right($string,$left){
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
function get_string_left($string,$right){
	$reg = '/(.*)'.$right.'.*/';
	preg_match($reg,$string,$data);
	if(empty($data[1])){
		return false;
	}
	return $data[1];
}

/**
 * 秒转人性化时间处理
 * @param  integer  $time    秒数
 * @param  integer $seconds 单位
 * @return string
 */
function time_span($time = '', $seconds = 1) {
	if (!is_numeric($seconds)) {
		$seconds = 1;
	}
	if (!is_numeric($time)) {
		$time = time();
	}
	if ($time <= $seconds) {
		$seconds = 1;
	} else {
		$seconds = $time - $seconds;
	}
	$str = '';
	$years = floor($seconds / 31536000);
	if ($years > 0) {
		$str .= $years . ' 年';
	}
	$seconds -= $years * 31536000;
	$months = floor($seconds / 2628000);
	if ($years > 0 OR $months > 0) {
		if ($months > 0) {
			$str .= $months . ' 月';
		}

		$seconds -= $months * 2628000;
	}
	$weeks = floor($seconds / 604800);
	if ($years > 0 OR $months > 0 OR $weeks > 0) {
		if ($weeks > 0) {
			$str .= $weeks . ' 周';
		}

		$seconds -= $weeks * 604800;
	}
	$days = floor($seconds / 86400);
	if ($months > 0 OR $weeks > 0 OR $days > 0) {
		if ($days > 0) {
			$str .= $days . ' 天';
		}

		$seconds -= $days * 86400;
	}
	$hours = floor($seconds / 3600);
	if ($days > 0 OR $hours > 0) {
		if ($hours > 0) {
			$str .= $hours . ' 小时';
		}

		$seconds -= $hours * 3600;
	}
	$minutes = floor($seconds / 60);
	if ($days > 0 OR $hours > 0 OR $minutes > 0) {
		if ($minutes > 0) {
			$str .= $minutes . ' 分钟';
		}

		$seconds -= $minutes * 60;
	}
	if ($str == '') {
		$str .= $seconds . ' 秒';
	}
	return $str;
}

/**
 * 人性化时间显示(xx秒钱)
 * @param  integer $timeInt UNIX时间戳
 * @param  string $format  返回格式
 * @return string
 */
function time_format($timeInt, $format = 'Y-m-d H:i:s') {
	if (empty($timeInt) || !is_numeric($timeInt) || !$timeInt) {
		return '';
	}
	$d = time() - $timeInt;
	if ($d < 0) {
		return '';
	} else {
		if ($d < 60) {
			return $d . '秒前';
		} else {
			if ($d < 3600) {
				return floor($d / 60) . '分钟前';
			} else {
				if ($d < 86400) {
					return floor($d / 3600) . '小时前';
				} else {
					if ($d < 259200) {			//3天内
						return floor($d / 86400) . '天前';
					} else {
						return date($format, $timeInt);
					}
				}
			}
		}
	}
}
