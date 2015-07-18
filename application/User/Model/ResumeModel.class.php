<?php
/**
 * Created by PhpStorm.
 * User: yqbaa
 * Date: 15-6-27
 * Time: 下午3:19
 * 简历模型
 */
namespace User\Model;
use Common\Model\CommonModel;
class ResumeModel extends CommonModel{
    //更新或新增
    function aeresume($data,$up = false,$id = ''){
        $uid = $_SESSION['user']['id'];
        if($up){
            //更新
            $data['refreshtime'] = time();
            $res = $this->where("uid = $uid and id = $id")->save($data);
            return $res;
        }
        //新增
        $data['uid'] = $uid;
        $data['addtime'] = time();
        $data['refreshtime'] =  $data['addtime'];
        $res = $this->add($data);
        return $res;
    }
    //查询简历 by id
    function getResumeById($id,$uid){
        $res = $this->where("uid=$uid")->find($id);
        return $res;
    }
    //获取简历
    function getResume($uid){
        return $this->where("uid=$uid")->order("id desc")->select();
    }
    //删除简历
    function delResume($rid,$uid){
        return $this->where("uid={$uid} and id={$rid}")->delete();
    }
}