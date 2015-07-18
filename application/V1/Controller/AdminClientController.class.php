<?php
namespace V1\Controller;
use Common\Controller\AdminbaseController;
use Org\OAuth\ThinkOAuth2;
Class AdminClientController extends AdminbaseController {
	
	private $oauth;
	function _initialize() {
		parent::_initialize();
	}
	
	public function __construct(){
		parent::__construct();
		$this->oauth = new ThinkOAuth2();
	}
	
	public function index(){
		$this->assign('rows' , $this->oauth->listClient());
		$this->display();
	}
	
	public function add(){
		$this->display();
	}
	
	public function do_add(){
		$client_id = I('post.client_id');
		$client_secret = I('post.client_id');
		$redirect_uri = I('post.client_id');
		$status = I('post.status');
		if(empty($client_id) || empty($client_secret) || empty($redirect_uri)) $this->error('client_id,client_secret,redirct_uri均不能为空');
		$this->oauth->addClient($client_id , $client_secret , $redirect_uri , $status);
		$this->success('添加成功');
	}
	
	public function edit(){
		$id = I('get.id');
		if(empty($id)) $this->error('未传入id');
		$this->assign('detail' , $this->oauth->getClient($id));
		$this->display();
	}

	public function do_edit(){
		$id = I('post.id');
		$client_id = I('post.client_id');
		$client_secret = I('post.client_secret');
		$redirect_uri = I('post.redirect_uri');
		$status = I('post.status');
		if(empty($id) || empty($client_id) || empty($client_secret) || empty($redirect_uri)) $this->error('client_id,client_secret,redirct_uri均不能为空');
		$this->oauth->editClient($id , $client_id , $client_secret , $redirect_uri , $status);
		$this->success('修改成功');
		
	}
	
	public function delete(){
		$id = I('get.id');
		$this->oauth->deleteClient($id);
		$this->success('删除成功');
	}
	
	public function able(){
		$ids = implode(',' , I('post.ids'));
		$this->oauth->multipleHandleClient($ids , 'able');
		$this->success();
	}
	
	public function disable(){
		$ids = implode(',' , I('post.ids'));
		$this->oauth->multipleHandleClient($ids , 'disable');
		$this->success();
	}
	
	public function del(){
		$ids = implode(',' , I('post.ids'));
		$this->oauth->multipleHandleClient($ids , 'delete');
		$this->success();
	}
}