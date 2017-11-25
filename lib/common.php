<?php 

/**
 * 加密密码
 * @param  string $password 明文密码
 * @return string           
 */
function passwordEncrypt($password){
	$password = md5($password);
	return $password;
}

/**
 * 保存密码
 * @param  string $uid            用户UID
 * @param  string $passwordEncrypt 加密后的密码
 * @return void                  
 */
function remeberUser($uid,$passwordEncrypt){
	$json = array('uid'=>$uid,'password'=>$passwordEncrypt);
	$enJson = json_encode($json);
	$token = base64_encode($enJson);
	cookie('usertoken',$token,3600*24*31);
}

/**
 * 获取当前登录用户的UID
 * @return integer
 */
function getUserUid() {
	$userToken = cookie('usertoken');
	$token = base64_decode($userToken);
	$json = json_decode($token,true);
	return $json['uid'];
}

/**
 * 检查用户是否登录
 * @return Boolean 成功返回用户信息,否则返回false
 */
function checkUserLogin() {
	$userToken = cookie('usertoken');
	$token = base64_decode($userToken);
	if (empty($token)) {
		return false;
	}
	$json = json_decode($token,true);
	if (empty($json)) {
		cookie('usertoken',null);
		return false;
	}
	$uid = $json['uid'];
	global $Db;
	$userData =$Db->find('select * from f_user where uid="'.$uid.'" limit 1;');
	if (!$userData) {
		return false;
	} else {
		if ($userData['password'] != $json['password']) {
			cookie('usertoken',null);
			return false;
		} else {
			return $userData;
		}
	}

}


/**
 * 写入日志
 * @param  string $info 日志内容
 * @return integer       日志ID
 */
function logWrite($info){
	global $Db;
	$timestamp = time();
	$uid = getUserUid() ;
	$sql = "insert into f_log(uid,contents,create_time) values('$uid','$info','$timestamp');";
	$row = $Db->exec($sql);
	$id = $Db->lastInsertId();
	return $id;
}