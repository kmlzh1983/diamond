<?php
/**
 * 会员注册
 */
namespace User\Controller;
use Common\Controller\HomeBaseController;
class LoginController extends HomeBaseController {
    function test(){
        $res = M("Member")->select();
        dump($res);
    }
	
	function index(){
		$_SESSION['login_http_referer'] = $_SERVER["HTTP_REFERER"];
		$this->display(":login");
	}
	
	function active(){
		$this->check_login();
		$this->display(":active");
	}
	
	function doactive(){
		$this->check_login();
		$this->_send_to_active();
		$this->success('激活邮件发送成功，激活请重新登录！',U("user/index/logout"));
	}
	
	function forgot_password(){
		$this->display(":forgot_password");
	}
	
	
	function doforgot_password(){
		if(IS_POST){
			if(!sp_check_verify_code()){
				$this->error("验证码错误！");
			}else{
				$users_model=M("Member");
				$rules = array(
						//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
						array('email', 'require', '邮箱不能为空！', 1 ),
						array('email','email','邮箱格式不正确！',1), // 验证email字段格式是否正确
						
				);
				if($users_model->validate($rules)->create()===false){
					$this->error($users_model->getError());
				}else{
					$email=I("post.email");
					$find_user=$users_model->where(array("user_email"=>$email))->find();
					if($find_user){
						$this->_send_to_resetpass($find_user);
						$this->success("密码重置邮件发送成功！",__ROOT__."/");
					}else {
						$this->error("账号不存在！");
					}
					
				}
				
			}
			
		}
	}
	
	protected  function _send_to_resetpass($user){
		$options=get_site_options();
		//邮件标题
		$title = $options['site_name']."密码重置";
		$uid=$user['id'];
		$username=$user['user_login'];
	
		$activekey=md5($uid.time().uniqid());
		$users_model=M("Member");
	
		$result=$users_model->where(array("id"=>$uid))->save(array("user_activation_key"=>$activekey));
		if(!$result){
			$this->error('密码重置激活码生成失败！');
		}
		//生成激活链接
		$url = U('user/login/password_reset',array("hash"=>$activekey), "", true);
		//邮件内容
		$template =<<<hello
		#username#，你好！<br>
		请点击或复制下面链接进行密码重置：<br>
		<a href="http://#link#">http://#link#</a>
hello;
		$content = str_replace(array('http://#link#','#username#'), array($url,$username),$template);
	
		$send_result=sp_send_email($user['user_email'], $title, $content);
	
		if($send_result['error']){
			$this->error('密码重置邮件发送失败！');
		}else{
			$this->success("发送成功");
		}
	}
	
	
	function password_reset(){
		$hash = I('request.hash');
		$result=M( "Member" )->where(array("user_activation_key"=>$hash,'user_login'=>$_SESSION['find_password_user']['user_login']))->find();
		if( empty($result) ) $this->error("请勿尝试");
		$_SESSION['reset'] = true;
		M("Member")->where( array('user_login'=>$_SESSION['find_password_user']['user_login']) )->save( array("user_activation_key"=>'') );
		$this->password_set_password_show();
	}
	
	function dopassword_reset(){
		if(IS_POST){
			if(!sp_check_verify_code()){
				$this->error("验证码错误！");
			}else{
				$users_model=M("Member");
				$rules = array(
						//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
						array('password', 'require', '密码不能为空！', 1 ),
						array('repassword', 'require', '重复密码不能为空！', 1 ),
						array('repassword','password','确认密码不正确',0,'confirm'),
						array('hash', 'require', '重复密码激活码不能空！', 1 ),
				);
				if($users_model->validate($rules)->create()===false){
					$this->error($users_model->getError());
				}else{
					$password=sp_password(I("post.password"));
					$hash=I("post.hash");
					$result=$users_model->where(array("user_activation_key"=>$hash))->save(array("user_pass"=>$password,"user_activation_key"=>""));
					if($result){
						$this->success("密码重置成功，请登录！",U("user/login/index"));
					}else {
						$this->error("密码重置失败，重置码无效！");
					}
					
				}
				
			}
		}
	}
	
	
    //登录验证
    function dologin(){

    	/*if(!sp_check_verify_code()){
    		$this->error("验证码错误！");
    	}*/
    	
    	$users_model=M("Member");
    	$rules = array(
    			//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
    			//array('terms', 'require', '您未同意服务条款！', 1 ),
    			array('username', 'require', '用户名或者邮箱不能为空！', 1 ),
    			array('password','require','密码不能为空！',1),
    	
    	);
    	if($users_model->validate($rules)->create()===false){
    		$this->error($users_model->getError());
    	}
    	
    	extract($_POST);
    	
    	if(strpos($username,"@")>0){//邮箱登陆
    		$where['user_email']=$username;
    	}else{
    		$where['user_realname']=$username;
    	}
    	$users_model=M('Member');
    	$result = $users_model->where($where)->find();
    	$ucenter_syn=C("UCENTER_ENABLED");
    		
    	$ucenter_old_user_login=false;
    	
    	$ucenter_login_ok=false;
    	if($ucenter_syn){
    		setcookie("thinkcmf_auth","");
    		include UC_CLIENT_ROOT."client.php";
    		list($uc_uid, $username, $password, $email)=uc_user_login($username, $password);
    	
    		if($uc_uid>0){
    			if(!$result){
    				$data=array(
    						'user_login' => $username,
    						'user_email' => $email,
    						'user_pass' => sp_password($password),
    						'last_login_ip' => get_client_ip(),
    						'create_time' => time(),
    						'last_login_time' => time(),
    						'user_status' => '1',
    				);
    				$id= $users_model->add($data);
    				$data['id']=$id;
    				$result=$data;
    			}
    				
    		}else{
    	
    			switch ($uc_uid){
    				case "-1"://用户不存在，或者被删除
    					if($result){//本应用已经有这个用户
    						if($result['user_pass'] == sp_password($password)){//本应用已经有这个用户,且密码正确，同步用户
    							$uc_uid2=uc_user_register($username, $password, $result['user_email']);
    							if($uc_uid2<0){
    								$uc_register_errors=array(
    										"-1"=>"用户名不合法",
    										"-2"=>"包含不允许注册的词语",
    										"-3"=>"用户名已经存在",
    										"-4"=>"Email格式有误",
    										"-5"=>"Email不允许注册",
    										"-6"=>"该Email已经被注册",
    								);
    								$this->error("同步用户失败--".$uc_register_errors[$uc_uid2]);
    	
    	
    							}
    							$uc_uid=$uc_uid2;
    						}else{
    							$this->error("密码错误！");
    						}
    					}
    						
    					break;
    				case -2://密码错
    					if($result){//本应用已经有这个用户
    						if($result['user_pass'] == sp_password($password)){//本应用已经有这个用户,且密码正确，同步用户
    							$uc_user_edit_status=uc_user_edit($username,"",$password,"",1);
    							if($uc_user_edit_status<=0){
    								$this->error("登陆错误！");
    							}
    							list($uc_uid2)=uc_get_user($username);
    							$uc_uid=$uc_uid2;
    							$ucenter_old_user_login=true;
    						}else{
    							$this->error("密码错误！");
    						}
    					}else{
    						$this->error("密码错误！");
    					}
    	
    					break;
    	
    			}
    		}
    		$ucenter_login_ok=true;
    	}
    	//exit();
    	if($result != null)
    	{
    		if($result['user_pass'] == sp_password($password)|| $ucenter_login_ok)
    		{
    			$_SESSION["user"]=$result;
				if( $_POST['auto_login']==1 ){
					setcookie('user_login',$result['user_login'],time()+3600,'/');
					setcookie('user_auth',md5($result['user_pass'].'iloveyouhmvpoint'),time()+3600,'/');
				}
    			//写入此次登录信息
    			$data = array(
    					'last_login_time' => date("Y-m-d H:i:s"),
    					'last_login_ip' => get_client_ip(),
    			);
    			$users_model->where("id=".$result["id"])->save($data);
    			$redirect=empty($_SESSION['login_http_referer'])?__ROOT__."/":$_SESSION['login_http_referer'];
    			$_SESSION['login_http_referer']="";
    			$ucenter_old_user_login_msg="";
    				
    			if($ucenter_old_user_login){
    				//$ucenter_old_user_login_msg="老用户请在跳转后，再次登陆";
    			}
				if( $_COOKIE['cart'] ) $this->sync_cart();	
    			$this->success("登录验证成功！", $redirect);
    		}else{
    			$this->error("密码错误！");
    		}
    	}else{
    		$this->error("用户名不存在！");
    	}
    	 
    }
	
	public function sync_cart(){//session中的购物车写入数据库
		$origin = M('Cart')->field('id,gid,num')->where( array('uid'=>$_SESSION['user']['id']) )->select();
		if( $origin[0]['id'] ){
			$gidArr = array();
			foreach($origin as $k => $v){
				$gidArr[$v['id']] = $v['gid'];
			}
		}
		$cart = unserialize($_COOKIE['cart']);
		$datas = array();
		foreach($cart as $k => $v){
			
			if( in_array($v['id'] , $gidArr) ){//数据库中已有此商品
				$data = array(
					'id' => array_search($v['id'] , $gidArr),
					'num' => $v['num'],
					'attr' => json_encode( $v['attr'] ),
				);
				M('Cart')->save($data);
			}else{//数据中无此商品
				$datas[]=array(
					'uid' => $_SESSION['user']['id'],
					'gid' => $v['id'],
					'num' => $v['num'],
					'attr' => json_encode( $v['attr'] ),
					'add_time' => time(),
				);
			}
		}
		M('Cart')->addAll($datas);
		setcookie('cart','',time()-360,'/');
	}
	
	public function password_find(){
		$this->display();
	}
	public function password_find_by_mobile(){
		$type = '';
		if(!sp_check_verify_code()){
				$this->error("验证码错误！");
		}
		$result = M('Member')->where( array('user_login'=>I('post.username')) )->find();
		if( !is_array($result) ) $this->error("不存在的用户");
		$_SESSION['find_password_user'] = $result;
		if( !$result['user_phone'] ){
			$type = 1;
		}else{
			$type = 2;
		}
		$this->success($type);
	}
	public function password_find_by_mobile_show(){
		if( isset($_SESSION['find_password_user']) ){
			$this->assign('phone' , substr_replace($_SESSION['find_password_user']['user_phone'],'****',3,4));
			$this->display();
		}else{
			$this->redirect('password_find');
		}
		
	}
	public function password_find_by_email_show(){
		if( isset($_SESSION['find_password_user']) ){
			$this->assign('email' , $_SESSION['find_password_user']['user_email']);
			$arr = explode('@',$_SESSION['find_password_user']['user_email']);
			$url = 'http://mail.'.$arr[1];
			$this->assign('url' , $url);
			$this->display();
		}else{
			$this->redirect('password_find');
		}
	}
	public function password_find_send_sms(){
		if( $_SESSION['find_password_user'] ){
			$phone = $_SESSION['find_password_user']['user_phone'];
		}else{
			$this->error("错误");
		}
        $code =  generateCode();
        if(sendSMS($phone,$code)){
            $this->success('发送成功,请注意查收短信');
        }else{
            $this->error('未知错误,短信发送失败,请联系hmv客服');
        }		
	}
	public function password_find_send_email(){
		$this->_send_to_resetpass($_SESSION['find_password_user']);
	}
	public function password_set_password(){
		if( empty($_POST['code']) ) $this->error('验证码不能为空');
		$check = M('Sms')->field('code,add_time')->where( array('phone'=>$_SESSION['phone']) )->order('id desc')->find();
        if( strtolower($check['code']) != strtolower(I('post.code')) ) $this->error("手机验证码错误");
        if( time() > ($check['add_time']+3600) ) $this->error('验证码已过期,请重新获取');
		$_SESSION['reset'] = true;
		$this->success("验证成功");
	}
	public function password_set_password_show(){
		if( $_SESSION['reset'] ){
			$this->display('password_set_password_show');
		}else{
			$this->redirect('password_find');
		}
		
	}
	public function do_password_set_password(){
		$users_model=M("Member");
		$rules = array(
			//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
			array('password', 'require', '密码不能为空！', 1 ),
			array('repassword', 'require', '重复密码不能为空！', 1 ),
			array('repassword','password','确认密码不正确',0,'confirm'),
		);
		if(strlen(I('post.password')) < 6 || strlen(I('post.password')) > 20){
    		$this->error("密码长度至少6位，最多20位！");
    	};
		if($users_model->validate($rules)->create()===false){
			$this->error($users_model->getError());
		}else{
			$password=sp_password(I("post.password"));
			$result=$users_model->where(array("user_login"=>$_SESSION['find_password_user']['user_login']))->save(array("user_pass"=>$password));
			if($result){
				$_SESSION['find_password_user'];
				$this->success("设置成功，请登录！",U("user/login/index"));
			}else {
				$this->error("设置失败！");
			}
					
		}
	}
	
	public function password_set_success(){
		$this->display();
	}
	
}