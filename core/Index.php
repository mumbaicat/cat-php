<?php 
class Index  extends Controller{
	public function __construct(){
		parent::__construct();
	}

	public function demo(){
		return makeReturnJson(200,'hello');
	}
}