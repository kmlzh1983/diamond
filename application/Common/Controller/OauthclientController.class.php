<?php
namespace Common\Controller;
use Common\Controller\HomeBaseController;
class OauthclientController extends HomeBaseController {
	
	private $url;
	private $client_id;
	private $client_secret;
	
	
	public function _initialize() {
		$this->url = 'http://'.$_SERVER['HTTP_HOST'].'/v1';
		$this->client_id = 'hmv_web';
		$this->client_secret = 'vsgame';
	}
	
	private function getCode(){
		$url = $this->url.'/oauth2/authorize?client_id='.$this->client_id.'&client_secret='.$this->client_secret;
		$res = json_decode(getMethod($url));
		if($res->code != 1000) $this->error("获取authorize code时出错:{$res->info}");
		return $res->data;
	}
	
	public function getAccessToken($code){
		$url = $this->url.'/oauth2/access_token';
		$data = array(
			'client_id'=>$this->client_id,
			'client_secret'=>$this->client_secret,
			'code' => $code,
		);
		$res = json_decode(postMethod($url,$data));
		if($res->code!=1000) $this->error("获取access_token出错{$res->info}");
		$data = array(
			'access_token'=>$res->access_token,
			'expires_in'=>$res->expires_in,
			'time'=>time(),
			'ip'=>$_SERVER['REMOTE_ADDR'],
		);
		M('Oauth_client')->add($data);
		return $res;
	}
	
	public function createOrder($data){//var_dump($data);die;
		$access_token = M('Oauth_client')->order('id desc')->find();
		//var_dump($access_token);die;\
		if( empty($access_token) || $access_token['expires_in']-time()<0 ){//如果没有授权,或授权已过期,重新授权
			$code = $this->getCode();
			$ac = $this->getAccessToken($code);
			$access_token['access_token'] = $ac->access_token;
		}
		$info['value'] = json_encode($data);
		$url = $this->url.'/order/read_post.json'.'?access_token='.$access_token['access_token'];
		//var_dump( postMethod($url , $info) );die;
		$res =json_decode( postMethod($url , $info) );
		if($res->code != 3000){
			$this->error($res->code.$res->info);
		}else{//var_dump($res->info);die;
			M('Cart')->where( array('uid'=>$_SESSION['user']['id']) )->delete();
			return $res->info;
		}
		
	}
}