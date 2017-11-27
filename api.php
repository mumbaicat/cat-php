<?php
/**
 * cat框架
 * PHP,API框架
 * 2017年11月25日17:48:23
 * 填坑项目:
 * 	Db (db.class.php)
 * 	Validate
 */

session_start();

$CONFIG = require 'lib/config.php';
if($CONFIG['DEBUG']==true){
	$stratTime   = microtime(true);
	$startMemory = memory_get_usage();
	// ini_set("display_errors", "On");
	// error_reporting(E_ALL | E_STRICT);
	// 开启错误提示什么的
}else{
	// 关闭错误提示什么的
}


// 解析PATH_INFO
if (!empty($_SERVER['PATH_INFO'])) {
	global $PATH_PARAM;
	$PATH_INFO = $_SERVER['PATH_INFO'];
	$PATH_PARAM = explode('/', $PATH_INFO);
}

// 载入文件
require 'lib/common.php';
require 'lib/help.php';
require 'plugin/require.php';
require 'lib/class/db.class.php';
require 'lib/class/controller.class.php';
require 'lib/class/mysql.class.php';
require 'lib/class/cache.class.php';
require 'lib/class/request.class.php';
$file=scandir('core');
foreach ($file as $name) {
	if(substr($name,-4)=='.php'){
		require 'core/'.$name;
	}
}

// 连接数据库
global $Db;
$Db = new Mysql($CONFIG['DB_SERVER'],$CONFIG['DB_NAME'],$CONFIG['DB_USER'],$CONFIG['DB_PASSWORD']);

// 兼容路由
if (empty($PATH_PARAM[1])) {
	$PATH_PARAM[1] = 'index';
}
if (empty($PATH_PARAM[2])) {
	$PATH_PARAM[2] = 'demo';
}
$PATH_PARAM[1] = strtolower($PATH_PARAM[1]);
$PATH_PARAM[2] = strtolower($PATH_PARAM[2]);
$PATH_PARAM[1] = ucfirst($PATH_PARAM[1]);

// 判断路由正确性及运行
if(class_exists($PATH_PARAM[1])==false){
	exit('No class:'.$PATH_PARAM[1]);

}
$object = new $PATH_PARAM[1]();
if(method_exists($object,$PATH_PARAM[2])==false){
	exit('No method:'.$PATH_PARAM[2]);
}
echo $object->$PATH_PARAM[2]();

if($CONFIG['DEBUG'] == true){
	echo '<hr>';
	$endTime    = microtime(true);
	$startMemory = memory_get_usage();
	$runtime    = ($endTime - $stratTime) * 1000; //将时间转换为毫秒
	$endMemory  = memory_get_usage();
	$usedMemory = ($endMemory - $startMemory) / 1024;
	echo "运行时间: {$runtime} 毫秒<br />";
	echo "耗费内存: {$usedMemory} K";
}