<?php
/**
 * Created by PhpStorm.
 * User: yqbaa
 * Date: 15-6-27
 * Time: 上午11:14
 */
namespace User\Controller;
use Common\Controller\HomeBaseController;
use Common\Controller\UtilsController as Utils;
use User\Model\MemberModel;
use User\Model\ResumeModel;

class ResumeController extends HomeBaseController
{
    private $user;
    private $resume;
    public function _initialize()
    {
        parent::_initialize();
        if (!$_SESSION['user']['id']) $this->redirect(U('User/login/index'));
        $this->user = M('Member')->where(array("id" => $_SESSION['user']['id']))->find();
        $this->assign('user', $this->user);
        $this->resume = new ResumeModel();
    }
    //个人简历中心
    public function  index(){
        $res = $this->resume->getResume($this->user['id']);
        $this->assign("resume",$res);
        //dump($res);
        $this->display();
    }
    //新增或修改简历
    function aeresume(){
        if(IS_POST){
            $data['title'] = I('post.title');
            $data['name'] = I('post.name');
            $data['age'] = I('post.age');
            $data['gender'] = I('post.gender');
            $data['live_place'] = I('post.live_place');
            $data['email'] = I('post.email');
            $data['tel'] = I('post.tel');
            $data['height'] = I('post.height');
            $data['degree'] = I('post.degree');
            $data['resume_content'] = I('post.resume_content');
            if($data['title'] =='' || strlen($data['title'])>60){
                Utils::resOut(-1,'简历名称不能为空，或者超过60个字符');
                exit();
            }
            if($data['name'] == '' || strlen($data['name'])>20){
                Utils::resOut(-1,'姓名不能为空，或者超过20个字符');
                exit();
            }
            if($data['gender'] != 1 && $data['gender']!=0){
                Utils::resOut(-1,'请选择性别');
                exit();
            }
            if(!Utils::isPositiveInt($data['age'])){
                Utils::resOut(-1,'年龄必须是整数');
                exit();
            }
            if($data['live_place'] == '' || strlen($data['live_place'])>60){
                Utils::resOut(-1,'居住地不能为空，或者超过60个字符');
                exit();
            }
            if(!Utils::isPhoneNum($data['tel'])){
                Utils::resOut(-1,'手机号码格式有误');
                exit();
            }
            if($data['email']!='' && !Utils::isPositiveInt($data['email'])){
                Utils::resOut(-1,'邮箱格式有误');
                exit();
            }
            $degree = array("小学",'初中','高中/专科','大专','本科','硕士','博士','其他');
            if(!in_array($data['degree'],$degree)){
                Utils::resOut(-1,'学历有误');
                exit();
            }
            if(!Utils::isPositiveInt($data['height']) && $data['height']!=''){
                Utils::resOut(-1,'身高只能是整数');
                exit();
            }
            if(strlen($data['resume_content']) < 10 && strlen($data['resume_content'])>300){
                Utils::resOut(-1,'工作经历字数必须在10到300之间');
                exit();
            }
            if(isset($_POST['rid']) && $_POST['rid']>0){
                $rid = intval($_POST['rid']);
                $up = 1;
            }else{
                $rid = '';
                $up = 0;
            }
//            print_r($_POST);die();
            $res = $this->resume->aeresume($data,$up,$rid);
            if($up){
                $msg = '修改';
            }else{
                $msg = '新增';
            }
            if(!$res){
                Utils::resOut('-1',$msg.'简历失败');
                exit();
            }else{
                Utils::resOut(0,$msg.'简历成功');
                exit();
            }

        }
        if(isset($_GET['rid'])){
            $rid = intval($_GET['rid']);
            $res = $this->resume->getResumeById($rid,$this->user['id']);
            if(!$res){
                $this->error("访问出错");
                exit();
            }
            $this->assign("resume",$res);
            $this->assign("edit",1);

        }
        $this->assign("country",M("Region")->where("type=0")->select());
        $this->display();
    }
    //删除简历
    function delResume(){
        if(IS_AJAX){
            if(!isset($_POST['rid'])){
                Utils::resOut(-1,'简历参数有误');
                exit();
            }
            $rid = intval($_POST['rid']);
            $res = $this->resume->delResume($rid,$this->user['id']);
            if($res){
                Utils::resOut(0,'删除成功');
                exit();
            }else{
                Utils::resOut(-1,'删除失败');
                exit();
            }

        }
    }
    //刷新简历
    function refreshResume(){
        if(IS_AJAX){
            if(!isset($_POST['rid'])){
                Utils::resOut(-1,'简历参数有误');
                exit();
            }
            $rid = intval($_POST['rid']);
            $data['refreshtime'] = time();
            $res = $this->resume->aeresume($data,1,$rid);
            if($res){
                Utils::resOut(0,'刷新成功');
                exit();
            }else{
                Utils::resOut(-1,'刷新失败');
                exit();
            }

        }
    }

    //收到的简历
    function receive(){
        $uid = $this->user['id'];
        $prefix = C("DB_PREFIX");
        $resume = M("Resume");
        $count = M("Apply")->where("compid={$uid}")->count();
        $Page = page($count , 10);
        $limit = "limit ".$Page->firstRow.','.$Page->listRows;
        $sql = "select a.*,j.job_name,j.addtime,m.user_login from {$prefix}apply a left join {$prefix}jobs j on j.id = a.job_id  left join {$prefix}member m on  m.id=a.uid where a.compid={$uid} ORDER BY a.apply_time desc {$limit}";
        $data = $resume->query($sql);
//        dump($data);die();
        $this->assign("list",$data);
        $this->assign("show",$Page->show());
        $this->display();
    }
    //收到的简历按工作分组
    function receive_group(){
        $uid = $this->user['id'];
        if(!isset($_GET['job_id'])){
            $this->error("页面不存在");
            exit();
        }
        $job_id = intval($_GET['job_id']);
        $prefix = C("DB_PREFIX");
        $resume = M("Resume");
        $count = M("Apply")->where("compid={$uid}")->count();
        $Page = page($count , 10);
        $limit = "limit ".$Page->firstRow.','.$Page->listRows;
        $sql = "select a.*,j.job_name,j.addtime,m.user_login from {$prefix}apply a left join {$prefix}jobs j on j.id = a.job_id  left join {$prefix}member m on  m.id=a.uid where a.compid={$uid} and a.job_id={$job_id} ORDER BY a.apply_time desc {$limit}";
//        echo $sql;
        $data = $resume->query($sql);
//        dump($data);die();
        $this->assign("list",$data);
        $this->assign("show",$Page->show());
        $this->display("receive");
    }
    //查看简历
    function view_resume(){
        if(!isset($_GET['id'])){
            $this->error("页面不存在");
            exit();
        }
        if(!isset($_GET['job_id'])){
            $this->error("页面不存在");
            exit();
        }
        $id = intval($_GET['id']);
        $job_id = intval($_GET['job_id']);

        //先判断是否在申请表里
        $apply = M("Apply");
        $uid = $this->user['id'];
        $res = $apply->where("compid={$uid} and job_id={$job_id} and resume_id={$id}")->select();
        if(!$res){
            $this->error("您无权查看该简历");
            exit();
        }
        $resume = M("Resume");
        $data = $resume->find($id);
        if(!$data){
            $this->error("对不起，该简历已经被用户删除");
            exit();
        }
        //更新申请状态为简历被查看
        $up['status'] = 1;
        $apply->where("compid={$uid} and job_id={$job_id} and resume_id={$id}")->save($up);
        $this->assign("resume",$data);
        $this->display();
    }
}