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
use Think\Page;

class JobsModel extends CommonModel{
    function aejobs($data,$up=0,$jid=''){
        if($up==0){
            //新增
            $data['addtime'] = $data['refreshtime'] = time();
            return $this->add($data);
        }else{
            //更新
            $data['refreshtime'] = time();
            $data['status'] = 0;
            $uid = $_SESSION['user']['id'];
            return $this->where("id={$jid} and uid ={$uid}")->save($data);
        }
    }
    //获取jobs 一条信息 通过uid
    function getJobsInfo($id,$uid){
        return $this->where("uid=$uid")->find($id);
    }
    function getMyJobs($uid,$status,$pagesize=10,$page=1){
        $prefix = C("DB_PREFIX");
        $firstRow = ($page-1)*$pagesize;
        if($status==-1){
            //查全部
            $count =  $this->where("uid={$uid}")->count();
            $sql = "select j.*,count(a.id) rcount from {$prefix}jobs j LEFT JOIN {$prefix}apply a on j.id =a.job_id where j.uid = {$uid}  GROUP by j.id ORDER by addtime desc limit ".$firstRow . ',' . $pagesize;

        }else{
            $count =  $this->where("uid={$uid} and status={$status}")->count();
            $sql = "select j.*,count(a.id) rcount from {$prefix}jobs j LEFT JOIN {$prefix}apply a on j.id =a.job_id where j.status={$status} and j.uid = {$uid}  GROUP by j.id ORDER by addtime desc limit ".$firstRow . ',' . $pagesize;
        }
        //$page = new \Page($count,$pagesize);
        $page = page($count,$pagesize);
        $list = $this->query($sql);
        $show = $page->show('home');
        $data['show'] = $show;
        $data['list'] = $list;
        return $data;
    }
    //刷新职位
    function refreshJob($uid,$id){
        $ac = M("Account");
        $acData = $ac->where("uid=$uid")->select();
        $myMoney = $acData[0]['money'];
        //刷新职位需要多少钱
        $cost = M("CostConfig");
        $refreshData = $cost->where("name='refresh'")->select();
        $costMoney = $refreshData[0]['value'];
        if($myMoney<$costMoney){
            return -1;//余额不足
        }
        $this->startTrans();
        $my['money'] = $myMoney - $costMoney;
        $acRes = $ac->where("uid=$uid")->save($my);
        $up['refreshtime'] = time();
        $jobRes = $this->where("id=$id")->save($up);
        if($jobRes && $acRes){
            $this->commit();
            return 1;
        }else{
            return -2;
        }
    }
    //申请职位 uid :用户id ,jid:职位id，rid:简历id
    function applyJob($uid,$jid,$rid){
        $jobData = $this->where("status=2")->find($jid);
        if(!$jobData){
            return -2;//该职位不存在
        }
        if($uid == $jobData['uid']){
            return -3;//不能申请自己的职位
        }
        $resume = M("Resume");
        $resumeData = $resume->where("uid=$uid and status =1")->find($rid);
        if(!$resumeData){
            return -4;//简历不存在
        }
        $data['uid'] = $uid;
        $data['compid'] = $jobData['uid'];
        $data['resume_id'] = $rid;
        $data['job_id'] = $jid;
        $data['apply_time'] = time();
        $data['status'] = 0;
        $res = M("Apply")->add($data);
        if($res){
            return $res;
        }else{
            return -5;//插入数据库失败
        }

    }
}