<?php
/**
 * 会员注册
 */
namespace User\Controller;
use Common\Controller\HomeBaseController;
class UserController extends HomeBaseController {
	private $user;
	public function _initialize(){
		if( !$_SESSION['user']['user_login'] ) $this->error('未登陆,请先去登陆' , U('User/login/index'));
		$this->user = $_SESSION['user'];
	}
	
	function index(){

	}
	

}