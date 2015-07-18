<?php
/**
 * Created by PhpStorm.
 * User: yqbaa
 * Date: 15-7-18
 * Time: 下午3:06
 * 用户app接口
 */

namespace V1\Controller;
Class MemberController extends PublicRestController
{
    protected $allowMethod = array('get', 'post', 'put', 'delete'); // REST允许的请求类型列表
    protected $allowType = array('html', 'xml', 'json'); // REST允许请求的资源类型列表

    /*
     * app 获取用户信息
     * apple_id 苹果id
     * pid 邀请人id
     */
    function read_json(){
        $apple_id = I('post.apple_id');
        if($apple_id==''){
            $this->response( array('info' =>'apple_id非法' , 'code' => 3001), 'json' );
            exit();
        }
        //判断是否注册
        $member = M("Member");
        $user_info = $member->where("user_login='{$apple_id}'")->select();
        if(!$user_info){
            //注册
            $data['user_login'] = $apple_id;
            $data['user_pass'] = md5($apple_id);
            $data['last_login_ip'] = get_client_ip();
            $data['last_login_time'] = date("Y-m-d H:i:s",time());
            $data['create_time'] = date("Y-m-d H:i:s",time());
            $data['points'] = 0;
            $data['utype'] = 0;
            if(isset($_POST['pid'])){
                $data['pid'] = intval($_POST['pid']);
                //查找pre_pid
                $pre_data = $member->find($data['pid']);
                $data['pre_pid'] = $pre_data['pid'];
            }
            $res = $member->add($data);
            if($res){
                $data['id'] = $res;
                $this->response( array('info' =>$data , 'code' => 3000), 'json' );
                exit();
            }else{
                $this->response( array('info' =>'服务器忙请重试' , 'code' => 3002), 'json' );
                exit();
            }

        }else{
            $data['last_login_ip'] = get_client_ip();
            $data['last_login_time'] = date("Y-m-d H:i:s",time());
            $member->where("user_login='{$apple_id}'")->save($data);
            $this->response( array('info' =>$user_info[0] , 'code' => 3000), 'json' );
            exit();
        }
    }

    //用户签到
    function sign(){
        $uid = I('post.uid');
        if($uid==''){
            $this->response( array('info' =>'用户id非法' , 'code' => 3001), 'json' );
            exit();
        }
        $uid = intval($uid);
        $now = date("Y-m-d",time());
        $sign = M("Sign");
        $data = $sign->where("uid={$uid}")->order("signtime desc")->limit(1)->select();

        if($data){
            $last_signtime = $data[0]['signtime'];
            if($last_signtime==$now){
                //已经签到
                $this->response( array('info' =>'用户已经签到过了' , 'code' => 3002), 'json' );
                exit();
            }
        }
        //开始签到
        $signData['uid'] = $uid;
        $signData['signtime'] = $now;
        $res = M("Sign")->add($signData);
        if($res){
            //成功
            $config = $this->get_config('sign');
            $diamond = $config[0]['value'];
            $prefix = C("DB_PREFIX");
            $sql = "update {$prefix}member set points = points+{$diamond} WHERE id ={$uid}";
            $res = M()->execute($sql);
            $this->response( array('info' =>'用户签到成功' , 'code' => 3000), 'json' );
            exit();
        }else{
            $this->response( array('info' =>'用户签到失败' , 'code' => 3003), 'json' );
            exit();
        }
    }


}