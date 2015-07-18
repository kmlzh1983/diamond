<?php
/*
@author liufee
@email job@feehi.com
@description api of orders
@date 2015-05-20
**/
namespace V1\Controller;
use Think\Controller\RestController;
use Org\OAuth\ThinkOAuth2;
Class Oauth2Controller extends RestController {
	private $oauth = null;
	public function __construct(){
		$this->oauth = new ThinkOAuth2();
	}
	public function authorize(){
		$client_id = I('request.client_id');
		$redirect_uri = I('request.redirect_uri');
		if(!$client_id || !redirect_uri) $this->response(array('info'=>C('errorcode.1001') , 'code'=>1001) , 'json');
		if($this->oauth->getRedirectUri($client_id) != $redirect_uri) $this->response(array('info'=>C('errorcode.1002') , 'code'=>1002) , 'json');
		$code = '';
		$str = '1234567890qwertyuiopasdfghjklzxcvbnm';
		for($i=0;$i<30;$i++){
			$code .= $str{rand(0,35)};
		}
		$this->oauth->setAuthCode($code , I('request.client_id') , I('request.redirect_uri') , C('OATUTH2_EXPIRES'));
		$this->response(array('data'=>$code , 'code'=>1000) , 'json');
	}
	
	public function access_token(){
		if ($_POST) {
			$client_id = I('post.client_id');
			$client_secret = I('post.client_secret');
			$code = I('post.code');
			$redirect_uri = I('post.redirect_uri');
			if(!$client_id || !$client_secret || !$code) $this->response(array('info'=> C('errorcode.1003'), 'code'=>1003) , 'json');
			$info = $this->oauth->getAuthCode($code);
			if($info == null) $this->response(array('info'=>C('errorcode.1004') , 'code'=>1004) , 'json');
			if($info['redirect_uri'] != $redirect_uri) $this->response(array('info'=>'传入的redirect_uri与绑定的redirect_uri不一致' , 'code'=>1002) , 'json');
			switch($result = $this->oauth->checkSecret($client_id , $client_secret)){
				case '1' :
						 $this->response(array('info'=>C('errorcode.1005') , 'code'=>1005) , 'json');
						 break;
				case '2' :
						 $this->response(array('info'=>C('errorcode.1006') , 'code'=>1006) , 'json');
						 break;
			}
            $access_token = '2.00';
			$str = '1234567890qwertyuiopasdfghjklzxcvbnm';
			for($i=0;$i<30;$i++){
				$access_token .= $str{rand(0,35)};
			}
			$expires_in = time() + C('OATUTH2_EXPIRES');
			$this->oauth->setAccessToken($access_token, $client_id, $expires_in, $scope = NULL);
			$this->response(array('access_token'=>$access_token , 'expires_in'=> $expires_in, 'code'=>1000) , 'json');
        } 
		$this->response(array('info'=>C('errorcode.1007') , 'code'=>1007) , 'json');
	}
}