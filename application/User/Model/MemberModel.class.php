<?php
namespace User\Model;
use Common\Model\CommonModel;
class MemberModel extends CommonModel{
    //修改密码
    function change_pwd($oldpwd,$newpwd){
        //验证旧密码
        $prefix = C("DB_PREFIX");
        $uid = $_SESSION['user']['id'];
        $sql = "select user_pass from {$prefix}member where uid = $uid";
        $res = $this->find($uid);
        $oldpwd = sp_password($oldpwd);
        if($res['user_pass']!=$oldpwd){
            return -1;//旧密码错误
        }
        $data['user_pass'] = sp_password($newpwd);
        $where['id'] = $uid;
        $result = $this->where($where)->save($data);
        return $result;
    }
    //身份验证
    function identify($img_path,$act,$utype){
        $ac = M("Account");
        if($act=='z'){
            $data['identify_z'] = $img_path;
            $data['audit'] = 1;//验证中
        }elseif($act == 'f'){
            $data['identify_f'] = $img_path;
            $data['audit'] = 1;//验证中
        }else{
            $data['licence'] = $img_path;
            $data['audit'] = 1;//验证中
        }
        $_SESSION['user']['utype']  = $utype;

        $uid = $_SESSION['user']['id'];
        $res1 = $ac->where("uid = $uid")->save($data);
        //更新member表的utype
        $up['utype'] = $utype;
        $res2 = $this->where("id = $uid")->save($up);
        return $res1;
    }
    //用户认证状态
    function audit_status($uid){
        $ac = M("Account");
        $res = $ac->where("uid=$uid")->select();
        if(!$res){
            return false;
        }else{
            return $res[0];
        }

    }
}