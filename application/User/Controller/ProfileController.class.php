<?php

/**
 * 会员中心
 */
namespace User\Controller;
use Common\Controller\MemberbaseController;
class ProfileController extends MemberbaseController {
	
	protected $users_model;
	function _initialize(){
		parent::_initialize();
		$this->users_model=D("Common/Member");
	}
	
    //编辑用户资料
	public function edit() {
		$userid=sp_get_current_userid();
		$user=$this->users_model->where(array("id"=>$userid))->find();
		$this->assign($user);
    	$this->display();
    }
    
    public function edit_post() {
    	if(IS_POST){
    		$userid=sp_get_current_userid();
    		$_POST['id']=$userid;
    		if ($this->users_model->create()) {
				if ($this->users_model->save()!==false) {
					$user=$this->users_model->find($userid);
					sp_update_current_user($user);
					$this->success("保存成功！",U("user/profile/edit"));
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->users_model->getError());
			}
    	}
    	
    }
    
    public function password() {
    	$userid=sp_get_current_userid();
    	$user=$this->users_model->where(array("id"=>$userid))->find();
    	$this->assign($user);
    	$this->display();
    }
    
    public function password_post() {
    	if (IS_POST) {
    		if(empty($_POST['old_password'])){
    			$this->error("原始密码不能为空！");
    		}
    		if(empty($_POST['password'])){
    			$this->error("新密码不能为空！");
    		}
    		$uid=sp_get_current_userid();
    		$admin=$this->users_model->where("id=$uid")->find();
    		$old_password=$_POST['old_password'];
    		$password=$_POST['password'];
    		if(sp_password($old_password)==$admin['user_pass']){
    			if($_POST['password']==$_POST['repassword']){
    				if($admin['user_pass']==sp_password($password)){
    					$this->error("新密码不能和原始密码相同！");
    				}else{
    					$data['user_pass']=sp_password($password);
    					$data['id']=$uid;
    					$r=$this->users_model->save($data);
    					if ($r!==false) {
    						$this->success("修改成功！");
    					} else {
    						$this->error("修改失败！");
    					}
    				}
    			}else{
    				$this->error("密码输入不一致！");
    			}
    	
    		}else{
    			$this->error("原始密码不正确！");
    		}
    	}
    	 
    }
    
    
    function bang(){
    	$oauth_user_model=M("OauthUser");
    	$uid=sp_get_current_userid();
    	$oauths=$oauth_user_model->where(array("uid"=>$uid))->select();
    	$new_oauths=array();
    	foreach ($oauths as $oa){
    		$new_oauths[strtolower($oa['from'])]=$oa;
    	}
    	$this->assign("oauths",$new_oauths);
    	$this->display();
    }
    
    function avatar(){
    	$userid=sp_get_current_userid();
		$user=$this->users_model->where(array("id"=>$userid))->find();
		$this->assign($user);
    	$this->display();
    }
    
    function avatar_upload(){
    	$config=array(
    			'FILE_UPLOAD_TYPE' => sp_is_sae()?"Sae":'Local',//TODO 其它存储类型暂不考虑
    			'rootPath' => './'.C("UPLOADPATH"),
    			'savePath' => './avatar/',
    			'maxSize' => 512000,//500K
    			'saveName'   =>    array('uniqid',''),
    			'exts'       =>    array('jpg', 'png', 'jpeg'),
    			'autoSub'    =>    false,
    	);
    	$upload = new \Think\Upload($config);//
    	$info=$upload->upload();
    	//开始上传
    	if ($info) {
    	//上传成功
    	//写入附件数据库信息
    		$first=array_shift($info);
    		$file=$first['savename'];
    		$_SESSION['avatar']=$file;
    		$this->ajaxReturn(sp_ajax_return(array("file"=>$file),"上传成功！",1),"AJAX_UPLOAD");
    	} else {
    		//上传失败，返回错误
    		$this->ajaxReturn(sp_ajax_return(array(),$upload->getError(),0),"AJAX_UPLOAD");
    	}
    }
    
    function avatar_update(){
    	if(!empty($_SESSION['avatar'])){
    		$targ_w = intval($_POST['w']);
    		$targ_h = intval($_POST['h']);
    		$x = $_POST['x'];
    		$y = $_POST['y'];
    		$jpeg_quality = 90;
    		
    		$avatar=$_SESSION['avatar'];
    		$avatar_dir=C("UPLOADPATH")."avatar/";
    		if(sp_is_sae()){//TODO 其它存储类型暂不考虑
    			$src=C("TMPL_PARSE_STRING.__UPLOAD__")."avatar/$avatar";
    		}else{
    			$src = $avatar_dir.$avatar;
    		}
    		
    		$avatar_path=$avatar_dir.$avatar;
    		
    		
    		if(sp_is_sae()){//TODO 其它存储类型暂不考虑
    			$img_data = sp_file_read($avatar_path);
    			$img = new \SaeImage();
    			$size=$img->getImageAttr();
    			$lx=$x/$size[0];
            	$rx=$x/$size[0]+$targ_w/$size[0];
            	$ty=$y/$size[1];
            	$by=$y/$size[1]+$targ_h/$size[1];
    			
    			$img->crop($lx, $rx,$ty,$by);
    			$img_content=$img->exec('png');
    			sp_file_write($avatar_dir.$avatar, $img_content);
    		}else{
    			$image = new \Think\Image();
    			$image->open($src);
    			$image->crop($targ_w, $targ_h,$x,$y);
    			$image->save($src);
    		}
    		
    		$userid=sp_get_current_userid();
    		$result=$this->users_model->where(array("id"=>$userid))->save(array("avatar"=>$avatar));
    		$_SESSION['user']['avatar']=$avatar;
    		if($result){
    			$this->success("头像更新成功！");
    		}else{
    			$this->error("头像更新失败！");
    		}
    		
    	}
    }
	
	public function savePortrait(){
		if( !$userid=sp_get_current_userid() ) $this->error("非法操作,封你IP");
		header('Content-Type: text/html; charset=utf-8');
		$result = array();
		$result['success'] = false;
		$success_num = 0;
		$msg = '';
		//上传目录
		$dir = $_SERVER['DOCUMENT_ROOT']."/data/upload/avatar";
		//删除之前上传的图片
		$member = M('Member')->where( array( 'id'=>$userid ) )->find();
		if( $member['avatar_origin'] ){
			$old_avatar_origin = explode( '?' , $member['avatar_origin']);
			unlink($_SERVER['DOCUMENT_ROOT'].$old_avatar_origin[0]);
			unlink($_SERVER['DOCUMENT_ROOT'].$member['avatar']);
			unlink($_SERVER['DOCUMENT_ROOT'].$member['avatar_small']);
			unlink($_SERVER['DOCUMENT_ROOT'].$member['avatar_large']);
		}
		// 取服务器时间+8位随机码作为部分文件名，确保文件名无重复。
		$filename = date("YmdHis").'_'.floor(microtime() * 1000).'_'.$this->createRandomCode(8);
		// 处理原始图片开始------------------------------------------------------------------------>
		//默认的 file 域名称是__source，可在插件配置参数中自定义。参数名：src_field_name
		$source_pic = $_FILES["__source"];
		//如果在插件中定义可以上传原始图片的话，可在此处理，否则可以忽略。
		if ($source_pic)
		{
			if ( $source_pic['error'] > 0 )
			{
				$msg .= $source_pic['error'];
			}
			else
			{
				//原始图片的文件名，如果是本地或网络图片为原始文件名、如果是摄像头拍照则为 *FromWebcam.jpg
				$sourceFileName = $source_pic["name"];
				//原始文件的扩展名(不包含“.”)
				$sourceExtendName = substr($sourceFileName, strripos($sourceFileName, "."));
				//保存路径
				$savePath = "$dir"."/".$userid."_origin".$sourceExtendName;
				//当前头像基于原图的初始化参数（只有上传原图时才会发送该数据，且发送的方式为POST），用于修改头像时保证界面的视图跟保存头像时一致，提升用户体验度。
				//修改头像时设置默认加载的原图url为当前原图url+该参数即可，可直接附加到原图url中储存，不影响图片呈现。
				$init_params = $_POST["__initParams"];
				 move_uploaded_file($source_pic["tmp_name"], $savePath);
				$result['sourceUrl'] = $this->toVirtualPath($savePath).$init_params;
				$success_num++;
			}
		}
		//<------------------------------------------------------------------------处理原始图片结束
		// 处理头像图片开始------------------------------------------------------------------------>
		//头像图片(file 域的名称：__avatar1,2,3...)。
		$avatars = array("__avatar1", "__avatar2", "__avatar3");
		$avatars_length = count($avatars);
		for ( $i = 0; $i < $avatars_length; $i++ )
		{ 
			$avatar = $_FILES[$avatars[$i]];
			$avatar_number = $i + 1;
			if ( $avatar['error'] > 0 )
			{
				$msg .= $avatar['error'];
			}
			else
			{
				$savePath = "$dir"."/".$userid.'_'. $avatar_number . "_$filename.jpg";
				$result['avatarUrls'][$i] = $this->toVirtualPath($savePath);
				move_uploaded_file($avatar["tmp_name"], $savePath);
				$success_num++;
			}
		} 
		$result['msg'] = $msg;
		if ($success_num > 0)
		{
			$result['success'] = true;
		}
		$data = array(
			'id' => $userid,
			'avatar' => $result['avatarUrls'][1],
			'avatar_small' => $result['avatarUrls'][0],
			'avatar_large' => $result['avatarUrls'][2],
			'avatar_origin' => $result['sourceUrl'],
		);
		M('Member')->save($data);
		//返回图片的保存结果（返回内容为json字符串）
		print json_encode($result);
	}
	
	/**************************************************************
	*  将物理路径转为虚拟路径。
	*  @param string $physicalPpath 物理路径。
	*  @access public
	**************************************************************/
	function toVirtualPath($physicalPpath)
	{
		$virtualPath = str_replace($_SERVER['DOCUMENT_ROOT'], "", $physicalPpath);
		$virtualPath = str_replace("\\", "/", $virtualPath);
		return $virtualPath;
	}
	
	/**************************************************************
	*  生成指定长度的随机码。
	*  @param int $length 随机码的长度。
	*  @access public
	**************************************************************/
	function createRandomCode($length)
	{
		$randomCode = "";
		$randomChars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		for ($i = 0; $i < $length; $i++)
		{
			$randomCode .= $randomChars { mt_rand(0, 35) };
		}
		return $randomCode;
	}
    
    
}
    
