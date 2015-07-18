<?php
/**
 * Created by PhpStorm.
 * User: yqbaa
 * Date: 15-6-27
 * Time: 上午11:14
 * 职位
 */
namespace User\Controller;
use Common\Controller\HomeBaseController;
use Common\Controller\UtilsController as Utils;
use User\Model\MemberModel;
use User\Model\JobsModel;
use Common\Model\CateModel;

class JobsController extends HomeBaseController
{
    private $user;
    private $jobs;
    public function _initialize()
    {
        parent::_initialize();
        if (!$_SESSION['user']['id']) $this->redirect(U('User/login/index'));
        $this->user = M('Member')->where(array("id" => $_SESSION['user']['id']))->find();
        $this->assign('user', $this->user);
        $this->jobs = new JobsModel();
    }
    //职位列表
    public function  index(){
//        $ca = new CateModel();
//        $data = $ca->getSelectList(0);
//        echo $data;
        if(isset($_GET['status'])){
            $status = intval($_GET['status']);
        }else{
            $status = -1;
        }
        $data = $this->jobs->getMyJobs($this->user['id'],$status);
        $this->assign("show",$data['show']);
        $this->assign("jobs",$data['list']);

        $this->display();
    }
    //新增或修改职位
    function aejobs(){
        //查看用户权限
        $ac = M("Account");
        $uid = $this->user['id'];
        $vdata = $ac->where("uid=$uid and audit=2")->select();
        if(!$vdata){
            $this->error("请先认证您的身份",U("User/my/user_verify"));
            exit();
        }
        if(IS_POST){
            $data['job_name'] = I('post.job_name');
            $data['catid'] = I('post.catid');
            $data['job_desc'] = I('post.job_desc');
            $data['job_content'] = I('post.job_content');
            $data['person_num'] = intval($_POST['person_num']);
            $data['work_start_time'] = I('post.work_start_time');
            $data['work_end_time'] = I('post.work_end_time');
            $data['work_start_date'] = I('post.work_start_date');
            $data['work_end_date'] = I('post.work_end_date');
            $data['work_total_date'] = I('post.work_total_date');
            $data['work_pay'] = I('post.work_pay');
            $data['pay_method'] = I('post.pay_method');
            $data['pay_date'] = I('post.pay_date');
            $data['work_nature'] = I('post.work_nature');
            $data['work_area'] = $_POST['work_province'].",".$_POST['work_city'].",".$_POST['work_area'];
            $data['work_province'] = I("post.province");
            $data['work_city'] = I("post.city");
            $data['work_area'] = I("post.area");
            $data['work_address'] = I('post.work_address');
            $data['work_map_x'] = I('post.work_map_x');
            $data['work_map_y'] = I('post.work_map_y');
            if($data['job_name'] =='' || strlen($data['job_name'])>60){
                Utils::resOut(-1,'招聘标题不能为空，或者超过60个字符');
                exit();
            }
            if(!Utils::isPositiveInt($data['catid'])){
                Utils::resOut(-1,'分类必须选择');
                exit();
            }
            if($data['job_desc'] == '' || strlen($data['job_desc'])>10){
                Utils::resOut(-1,'工作内容不能为空，或者超过10个字符');
                exit();
            }
            if(strlen($data['job_content'])<20 || strlen($data['job_content'])>300){
                Utils::resOut(-1,'工作内容小于20个字符，或者超过300个字符');
                exit();
            }
            if(!Utils::isInt($data['work_start_time']) || !Utils::isInt($data['work_end_time'])){
                Utils::resOut(-1,'工作时间必须是正整数');
                exit();
            }
            if($data['work_start_date']>$data['work_end_date']){
                Utils::resOut(-1,'开始工作日期不能大于结束日期');
                exit();
            }

            if(!is_numeric($data['work_total_date']) || $data['work_total_date']<=0){
                Utils::resOut(-1,'工作总时长必须是大于0的数字');
                exit();
            }
            if(!is_numeric($data['work_pay']) || $data['work_pay']<=0){
                Utils::resOut(-1,'价钱必须是大于0的数字');
                exit();
            }
            if(!Utils::isInt($data['pay_date'])){
                Utils::resOut(-1,'结算时间错误');
                exit();
            }elseif($data['pay_date']!=1 && $data['pay_date']!=0){
                Utils::resOut(-1,'结算时间错误');
                exit();
            }
            if(!Utils::isInt($data['pay_method'])){
                Utils::resOut(-1,'结算方式错误');
                exit();
            }elseif($data['pay_method']!=1 && $data['pay_method']!=0){
                Utils::resOut(-1,'结算方式错误1');
                exit();
            }
            if(!Utils::isPositiveInt($data['work_nature'])){
                Utils::resOut(-1,'工作性质选择有误');
                exit();
            }
            if(!Utils::isPositiveInt($data['work_province']) || !Utils::isPositiveInt($data['work_city']) || !Utils::isPositiveInt($data['work_area'])){
                Utils::resOut(-1,'请选择工作地区');
                exit();
            }
            if($data['work_address'] == '' || strlen($data['work_address'])>60){
                Utils::resOut(-1,'工作地址不能为空，或者超过60个字符');
                exit();
            }
            if(!is_numeric($data['work_map_x']) || !is_numeric($data['work_map_y'])){
                Utils::resOut(-1,'请在地图标记您的位置');
                exit();
            }
            if(isset($_POST['jid']) && Utils::isPositiveInt($_POST['jid'])){
                $jid = intval($_POST['jid']);
                $up = 1;
            }else{
                $jid = '';
                $data['uid'] = $this->user['id'];
                $up = 0;
            }
            if($_POST['catname']){
                $data['catname'] = I('post.catname');
                $data['catid'] = 0;
            }else{
                $cate = M("Cate")->find($data['catid']);
                $data['catname'] = $cate['name'];
            }
            $res = $this->jobs->aejobs($data,$up,$jid);
            if(!$res){
                Utils::resOut('-1','操作失败');
                exit();
            }else{
                if($up){
                    $cost = getCostConfig('publish');
                    if($cost>0) {
                        logCost($this->user['id'],$cost,1,'发布职位',$data['job_name'],$res,$data['catname']);
                    }
                }
                Utils::resOut(0,'操作成功');
                exit();
            }
        }
        //找出nature--工作性质表
        $nature = M("Nature");
        $nature_data = $nature->select();
        $this->assign("nature",$nature_data);
        //分类
        $cate = new CateModel();
        $cateData = $cate->getSelectList(0);
        $this->assign("cate",$cateData);
        if(isset($_GET['jid'])){
            $this->assign("edit",1);
            $jid = intval($_GET['jid']);
            $jobs_data = $this->jobs->getJobsInfo($jid,$this->user['id']);
            if(!$jobs_data){
                $this->error("您访问的页面不存在");
                exit();
            }
            $this->assign("jobs",$this->jobs->getJobsInfo($jid,$this->user['id']));
        }
//        $province =
        $this->display();
    }
    //下架工作
    function offline_job(){
        if(IS_AJAX){
            $id = intval($_POST['id']);
            $jobs = M("Jobs");
            $up['offline_time'] = time();
            $up['status'] = 4;
            $where['uid'] = $this->user['id'];
            $where['id'] = $id;
            $res = $jobs->where($where)->save($up);
            if($res){
                Utils::resOut(0,'下架成功');
                exit();
            }else{
                Utils::resOut(-1,'下架失败');
                exit();
            }
        }
    }
    //刷新工作
    function refresh_job(){
        if(IS_AJAX){
            //查询我的账户
            $ac = M("Account");
            $uid = $this->user['id'];
            $id = intval($_POST['id']);
            $res = $this->jobs->refreshJob($uid,$id);
            if($res == -1){
                Utils::resOut(-1,'余额不足');
                exit();
            }elseif($res==-2){
                Utils::resOut(-2,'刷新失败');
                exit();
            }elseif($res==1){
                $cost = getCostConfig('refresh');
                if($cost>0){
                    logCost($this->user['id'],$cost,0,'刷新职位');
                }
                Utils::resOut(0,'刷新成功');
                exit();
            }
        }
    }

    //申请职位
    function apply_job(){
        if(IS_AJAX){
            $uid = $this->user['id'];
            $jid = intval($_POST['jid']);
            $rid = intval($_POST['rid']);
            if(!Utils::isPositiveInt($jid)){
                Utils::resOut(-1,'职位参数有误');
                exit();
            }
            $res = $this->jobs->applyJob($uid,$jid,$rid);
            if($res==-2){
                Utils::resOut(-2,'该职位不存在');
                exit();
            }elseif($res==-3){
                Utils::resOut(-3,'不能申请自己的职位');
                exit();
            }elseif($res==-4){
                Utils::resOut(-4,'简历不存在');
                exit();
            }elseif($res==-5){
                Utils::resOut(-5,'申请失败，请重试');
                exit();
            }else{
                Utils::resOut(0,'申请成功');
                exit();
            }
        }
    }


    //推荐职位
    function job_pos(){
        $uid = $this->user['id'];
        if(IS_POST){

            $job_id = intval($_POST['job_id']);
            $type = I("post.type");
            if($job_id==0){
                Utils::resOut(-1,'参数错误');
                exit();
            }
            if($type!='emergency' && $type!='recommend' && $type!='highlight'){
                Utils::resOut(-1,'推广类型错误');
                exit();
            }

            $start_time = I("post.start_time");
            $end_time = I("post.end_time");
            $now = date("Y-m-d",time());
            if($start_time<$now){
                Utils::resOut(-1,'开始时间不能在今天之前');
                exit();
            }
            $start_time = strtotime($start_time);
            $end_time = strtotime($end_time);
            $days = ($end_time - $start_time)/(24*3600) + 1;
            if($start_time>$end_time){
                Utils::resOut(-1,'开始时间不能大于结束时间');
                exit();
            }
            $end_time = $end_time+(24*3600);
            //查询需花费金额
            $cost = M("CostConfig");
            $res = $cost->field("name,value")->where("name='{$type}'")->select();
            if(!$res){
                Utils::resOut(-1,'推广类型错误');
            }
            //查询是否重复推广
            $job_posM = M("JobPos");
            $jobPosData = $job_posM->where("type='{$type}' and job_id={$job_id}")->select();
            if($jobPosData){
                foreach($jobPosData as $k=>$v){
                    if($start_time>=$v['start_time'] && $start_time<=$v['end_time']){
                        Utils::resOut(-1,'此时间段已经有推广了，无需重复添加');
                        exit();
                    }
                    if($end_time>$v['end_time'] && $start_time<=$v['end_time']){
                        Utils::resOut(-1,'此时间段已经有推广了，无需重复添加');
                        exit();
                    }
                }
            }
            //查询用户余额
            $ac = M("Account");
            $resUser = $ac->where("uid=$uid")->select();
            $costMoney = $res[0]['value']*$days;
            $yue = $resUser[0]['money'];
            if($costMoney>$yue){
                Utils::resOut(-1,'对不起您的余额不足');
                exit();
            }
            $data['job_id'] = $job_id;
            $data['type'] = $type;
            $data['start_time'] = $start_time;
            $data['end_time'] = $end_time;
            $data['status'] = 1;
            $res = M("JobPos")->add($data);
            if($res){
                //扣除钱
                $up['money'] = $yue-$costMoney;
                $ac->where("uid=$uid")->save($up);
                logCost($this->user['id'],$costMoney,1,$type);
                Utils::resOut(0,'操作成功');
                exit();
            }else{
                Utils::resOut(-1,'操作失败');
                exit();
            }
        }
        if(!isset($_GET['id']) || !isset($_GET['type'])){
            $this->error('访问出错');
            exit();
        }
        $id = intval($_GET['id']);
        $resJob = $this->jobs->where("uid=$uid")->find($id);
        if(!$resJob){
            $this->error('您访问的页面不存在');
            exit();
        }
        $type = I('get.type');

        //查询此操作需要多少钱
        $cres = M("CostConfig")->where("name='{$type}'")->select();
        if(!$cres){
            $this->error('此操作不存在');
            exit();
        }
        $costMoney = $cres[0]['value'];
        $this->assign("job",$resJob);
        $this->assign("costMoney",$costMoney);
        if($type=='recommend'){
            $typeV = '置顶';
        }elseif($type=='highlight'){
            $typeV = '高亮';
        }else{
            $typeV = '加急';
        }
        $this->assign("type",$typeV);
        //我的余额
        $acM = M("Account")->field('money')->where("uid=$uid")->select();
        $this->assign('yue',$acM[0]['money']);

        $this->display();
    }
    function test(){
        $ip = get_client_ip();
        echo $ip;

    }
    //查看用户是否有权限
    function publish_auth(){
        //查看用户权限
        if(!IS_AJAX){die();}
        $ac = M("Account");
        $uid = $this->user['id'];
        $vdata = $ac->where("uid=$uid and audit=2")->select();
//        if(!$vdata){
//            $this->error("请先认证您的身份",U("User/my/user_verify"));
//            exit();
//        }
        if($vdata){
            echo 1;
        }else{
            echo 0;
        }
    }

}