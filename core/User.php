<?php 
class User  extends Controller{

	private $userData;
	private $uid;

	public function __construct(){
		parent::__construct();
		$passAction = array('login','register');
		if(!in_array($this->request->action(),$passAction)){
			// 检测用户登陆
			$this->userData = checkUserLogin();
			if(!$this->userData){
				return makeReturnJson(500,'用户尚未登录');
			}
			$this->uid = $this->userData['uid'];
		}
	}

	// 登陆
	public function  login(){
		// 用户登陆啦
	}

	// 注册
	public function insert(){
		// 用户注册啦
	}

	// 注销
	public function logout(){
		cookie('usertoken',null);
		return makeReturnJson(200,'注销成功');
	}

	public function lists(){
		// Layui的智能表格
 
		$page = filter($_GET['page']);
		$limit = filter($_GET['limit']);

		$sql = 'select * from f_user';

		$lists = $this->Db->select($sql);

		$count = count($lists);
		$data = page($lists,$page,$limit);

		for ($i=0; $i < count($data); $i++) { 
			// $data[$i]['create_time'] = date('Y-m-d H:i:s',$data[$i]['create_time']);
		}

		$return =[
			'code'=>0,
			'msg'=>'获取成功',
			'count'=>$count,
			'data'=>$data,
		];
		header("Content-type: text/json; charset=utf-8");
		return json_encode($return,JSON_UNESCAPED_UNICODE);
	}

}