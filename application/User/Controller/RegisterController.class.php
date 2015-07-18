<?php
/**
 * 会员注册
 */
namespace User\Controller;
use Common\Controller\HomeBaseController;
class RegisterController extends HomeBaseController {
	
	function index(){
		if( $_SESSION['user'] ) $this->redirect("portal/index/index");
		$this->display();
	}
	
	function doregister(){
        $rules = array(
            //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
            //array('terms', 'require', '您未同意服务条款！', 1 ),
            array('password','require','密码不能为空！',1),
            array('user_realname','require','用户名不能为空！',1),
            array('repassword', 'require', '重复密码不能为空！', 1 ),
            array('repassword','password','确认密码不正确',0,'confirm'),
        );
		if(I('post.reg_type') == 1){
			if(!sp_check_verify_code()){
				$this->error("验证码错误！");
			}
            $_POST['email'] = I('post.username');
            array_unshift($rules ,  array('username', 'require', '邮箱不能为空！', 1 ) , array('email','email','邮箱格式不正确！',1));
		}else{
			array_unshift($rules ,  array('username', 'require', '手机号码不能为空！', 1 ));
            $user_phone  = I('post.username');
            if(!preg_match('/^[1][3458]{1}[0-9]{9}$/' , $user_phone)) $this->error('手机号码格式有误');//手机号码格式检测
            $check = M('Sms')->field('code,add_time')->where( array('phone'=>$user_phone) )->order('id desc')->find();
            if( empty($_POST['code']) ) $this->error('验证码不能为空');
            if( strtolower($check['code']) != strtolower(I('post.code')) ) $this->error("手机验证码错误");
            if( time() > ($check['add_time']+3600) ) $this->error('验证码已过期,请重新获取');
		}
		$users_model=M("Member");
    	if($users_model->validate($rules)->create()===false){
    		$this->error($users_model->getError());
    	}
    	
    	extract($_POST);
    	//用户名需过滤的字符的正则
    	/**$stripChar = '?<*.>\'"';
    	if(preg_match('/['.$stripChar.']/is', $username)==1){
    		$this->error('用户名中包含'.$stripChar.'等非法字符！');
    	}
    	**/
    	$banned_usernames=explode(",", sp_get_cmf_settings("banned_usernames"));
    	
    	if(in_array($username, $banned_usernames)){
    		$this->error("此用户名禁止使用！");
    	}
    	
    	if(strlen($password) < 6 || strlen($password) > 20){
    		$this->error("密码长度至少6位，最多20位！");
    	}
    	

    	$where['user_login']=$username;
    	$where['user_email']=$email;
//    	$where['user_realname']=$user_realname;
    	$where['_logic'] = 'OR';
    	$ucenter_syn=C("UCENTER_ENABLED");
    	$uc_checkemail=1;
    	$uc_checkusername=1;
    	if($ucenter_syn){
    		include UC_CLIENT_ROOT."client.php";
    		$uc_checkemail=uc_user_checkemail($email);
    		$uc_checkusername=uc_user_checkname($username);
    	}
    	$users_model=M("Member");
    	$result = $users_model->where($where)->count();
    	if($result || $uc_checkemail<0 || $uc_checkusername<0){
    		$this->error("用户名或者该邮箱已经存在！");
    	}else{
    		$uc_register=true;
    		if($ucenter_syn){
    	
    			$uc_uid=uc_user_register($username,$password,$email);
    			//exit($uc_uid);
    			if($uc_uid<0){
    				$uc_register=false;
    			}
    		}
    		if($uc_register){
    			$need_email_active=C("SP_MEMBER_EMAIL_ACTIVE");
                if($need_email_active){//配置为需要邮件激活时
                    if(I('post.reg_type') == 1){//邮箱注册
                        $need_email_active = true;
                    }else if(I('post.reg_type') == 2){//手机号码注册
                        $need_email_active = false;
                    }
                }
    			$data=array(
    					'user_login' => $username,
    					'user_email' => $email,
    					'user_nicename' =>$username,
                        'user_realname' => $user_realname,
    					'user_pass' => sp_password($password),
    					'last_login_ip' => get_client_ip(),
    					'create_time' => date("Y-m-d H:i:s"),
    					'last_login_time' => date("Y-m-d H:i:s"),
    					'user_status' => $need_email_active?2:1,
    					"utype"=>0,
                        'user_phone' => $user_phone,
    			);
    			$rst = $users_model->add($data);
    			if($rst){
    				//登入成功页面跳转
    				$data['id']=$rst;
                    //插入我的账户
                    $account = M("Account");
                    $ac['uid'] = $rst;
                    $ac['money'] = get_point_rule('register');
                    $account->add($ac);
    				$_SESSION['user']=$data;
    					
    				//发送激活邮件
    				if($need_email_active){
    					$this->_send_to_active();
    					unset($_SESSION['user']);
    					$this->success("注册成功，激活后才能使用！",U("user/login/index"));
    				}else {
    					$this->success("注册成功！",__ROOT__."/");
    				}
    					
    			}else{
    				$this->error("注册失败！",U("user/register/index"));
    			}
    	
    		}else{
    			$this->error("注册失败！",U("user/register/index"));
    		}
    	
    	}
    	 
    
	}
	
	
	function active(){
		$hash=I("get.hash","");
		if(empty($hash)){
			$this->error("激活码不存在");
		}
		
		$users_model=M("Member");
		$find_user=$users_model->where(array("user_activation_key"=>$hash))->find();
		
		if($find_user){
			$result=$users_model->where(array("user_activation_key"=>$hash))->save(array("user_activation_key"=>"","user_status"=>1));
			
			if($result){
				$find_user['user_status']=1;
				$_SESSION['user']=$find_user;
				$this->success("用户激活成功，正在登录中...",__ROOT__."/");
			}else{
				$this->error("用户激活失败!",U("user/login/index"));
			}
		}else{
			$this->error("用户激活失败，激活码无效！",U("user/login/index"));
		}
		
		
	}

    public function sendCheckcode(){
        $phone = I('get.phone');
        if(!preg_match('/^[1][3458]{1}[0-9]{9}$/' , $phone)) $this->error('手机号码格式有误');//手机号码格式检测
        $res = M('Member')->where(array('user_phone'=>$phone))->field('user_phone')->find();
        if( $res['user_phone'] ) $this->error("手机号码已经被注册了");
        $code =  generateCode();
        if(sendSMS($phone,$code)){
            $this->success('发送成功,请注意查收短信');
        }else{
            $this->error('未知错误,短信发送失败,请联系hmv客服');
        }
    }
	
	
}