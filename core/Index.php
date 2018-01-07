<?php
class Index  extends Controller{
	public function __construct(){
		parent::__construct();
	}

	public function demo(){
		return make_return_json(200,'hello');
	}
}
