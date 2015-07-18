<?php
/**
 * Created by PhpStorm.
 * User: yqbaa
 * Date: 15-7-4
 * Time: 下午2:37
 */
namespace Portal\Controller;
use Common\Controller\HomeBaseController;
use Common\Controller\UtilsController as Utils;

/**
 * 首页
 */
class JobsController extends HomeBaseController
{
    function index(){
        $this->display();
    }
    //工作详情
    function detail(){
        if(!isset($_GET['id'])){
            $this->error('页面不存在');
            exit();
        }
        $id = intval($_GET['id']);
        $job = M("Jobs");
        $data = $job->where('status=2')->find($id);
        if(!$data){
            $this->error('该职位不存在或者已经下架');
            exit();
        }
        $publish_uid = $data['uid'];
        $userInfo = M("Member")->find($publish_uid);
        //当前申请人数
        $applyNum = M("Apply")->where("job_id=$id")->count();
        //所属分类
        if($data['catid']>0){
            $catdata = M("Cate")->field('name')->find($data['catid']);
            $this->assign("catname",$catdata['name']);
        }
        //岗位性质
        $natureData = M("Nature")->find($data['work_nature']);
        //浏览量+1
        $up['click'] = $data['click']+1;
        $job->where("id={$id}")->save($up);
//        dump($userInfo);
        $this->assign('user',$userInfo);
//        dump($userInfo);
        //简历
        if(sp_is_user_login()){
            $uid = $_SESSION['user']['id'];
            $resumeCount = M("Resume")->where("uid=$uid")->count();
            $this->assign("resumeCount",$resumeCount);
        }

        $this->assign('job',$data);
        $this->assign("applyNum",$applyNum);
        $this->assign("nature_name",$natureData['nature_name']);
        $this->display();
    }
    function lists(){
        $prefix = C("DB_PREFIX");
        //分类
        $cate = M("Cate")->where("parent=0")->select();
        $this->assign("cate",$cate);
        if(!isset( $_SESSION['wiki']['cityId'])){
            $city = getCurrentCity();
            $cityId = $city['cityId'];
        }else {
            $cityId = $_SESSION['wiki']['cityId'];
        }
        if(IS_POST){
           // $cityId = $_SESSION['wiki']['cityId'];
            $where = "j.work_city={$cityId} and j.status=2 ";
            $area_id = intval($_POST['area_id']);
            if($area_id!=0) {
                $where .= " and j.work_area={$area_id} ";
                //$cityWhere = " j.work_area_id={$area_id} ";
            }

            $start_date = I("post.start_date");
            $end_date = I("post.end_date");
            if($start_date && $end_date){
                $start_date = strtotime($start_date);
                $end_date = strtotime($end_date);
                $where.=" and j.refreshtime between {$start_date} and {$end_date} ";
            }else{
                $date_id = I("post.date_id");
                $today = date("Y-m-d",time());
                if($date_id>0){
                    if($date_id==1){
                        //今天
                        $today = date("Y-m-d",time());
                        $where.= " and j.work_start_date='{$today}' ";
                    }elseif($date_id==2){
                        //明天
                        $next_day = strtotime($today) + (24*3600);
                        $next_day = date("Y-m-d",$next_day);
                        $where.= " and j.work_start_date='{$next_day}' ";
                    }
                }
            }
            $catid= intval($_POST['catid']);
            if($catid>0){
                $where.=" and j.catid = {$catid}";
            }
            $pay_id = intval($_POST['pay_id']);
            if($pay_id==1){
                $where.=" and j.work_pay<15 ";
            }elseif($pay_id==2){
                $where.=" and j.work_pay>=15 and j.work_pay<=20";
            }elseif($pay_id==3){
                $where.=" and j.work_pay>20 ";
            }
            $time_id = $_POST['time_id'];
            if($time_id==1){
                $where.=" and j.work_total_day <1 ";
            }elseif($time_id==2){
                $where.=" and j.work_total_day >=1 and j.work_total_day<2 ";
            }elseif($time_id==3){
                $where.=" and j.work_total_day >=2 and j.work_total_day<3 ";
            }elseif($time_id==4){
                $where.=" and j.work_total_day >=3 and j.work_total_day<4 ";
            }elseif($time_id==5){
                $where.=" and j.work_total_day >=4 ";
            }

            //搜索工作
            $count = $data = M("Jobs")->alias('j')->where($where)->count();
            $page = page($count,10);
//            $data = M("Jobs")->alias('j')->where($where)->select();
//            $count =  M("Jobs")->alias('j')->where($where)->count();
            $sql = "select j.*,c.name,n.nature_name,r.name as cityName from {$prefix}jobs j LEFT JOIN {$prefix}cate c on j.catid=c.id LEFT JOIN ";
            $sql.=" {$prefix}nature n on n.id=j.work_nature left join {$prefix}region r on r.id = j.work_city where {$where} order by j.refreshtime desc limit ".$page->firstRow.','.$page->listRows;
//           echo $sql;die();
            $data = M()->query($sql);
            $this->assign('jobs',$data);
        }else{
            $count = M("Jobs")->count();
            $page = page($count,10);
//            $data = M("Jobs")->select();
            if(isset($_GET['keyword']) && $_GET['keyword']!=''){
                $keyword = I("get.keyword");
                $where =" j.job_name like '%{$keyword}%' and j.work_city={$cityId} and j.status=2 ";
            }else{
                $where = "j.work_city={$cityId} and j.status=2";
            }
            $sql = "select j.*,c.name,n.nature_name,r.name as cityName from {$prefix}jobs j LEFT JOIN {$prefix}cate c on j.catid=c.id LEFT JOIN ";
            $sql.=" {$prefix}nature n on n.id=j.work_nature left join {$prefix}region r on r.id = j.work_city where {$where} order by j.refreshtime desc limit ".$page->firstRow.','.$page->listRows;
//            echo $sql;die();
            $data = M()->query($sql);
            $this->assign('jobs',$data);
        }

        $show = $page->show('home');
       // $data['show'] = $show;
        //获取地区
        $cityId = $_SESSION['wiki']['cityId'];
        $region = M("Region")->where("pid={$cityId}")->select();
        $this->assign("region",$region);
        $this->assign("show",$show);
//        dump($data);
        $this->display();
    }
    //申请职位视图
    function apply(){
//        $this->redirect("User/Login/index");
        if(!sp_is_user_login()){
            $this->redirect("User/Login/index");
            exit();
        }
        if(!isset($_GET['id'])){
            $this->error('职位不存在');
            exit();
        }
        $id = intval($_GET['id']);
        $data = M("Jobs")->find($id);
        if(!$data){
            $this->error('职位不存在');
            exit();
        }
        //我的简历
        $uid = $this->user['id'];
        $resume = M("Resume")->where("uid=$uid")->order('refreshtime desc')->select();
        $this->assign('resume',$resume);
        $this->assign('job',$data);
        $this->display();

    }


    //获取子类
    function get_son_cate(){
        if(IS_AJAX && IS_POST){
            if(!isset($_POST['id'])){
                Utils::resOut(-1,'id未传');
                exit();
            }
            $id = intval($_POST['id']);
            $cate = M("Cate");
            $data = $cate->where("parent=$id")->select();
            Utils::resOut(0,$data);

        }
    }
    /*
     * 分类页
     */
    function category()
    {
        $prefix = C("DB_PREFIX");

        if (!isset($_SESSION['wiki']['cityId'])) {
            $city = getCurrentCity();
            $cityId = $city['cityId'];
        } else {
            $cityId = $_SESSION['wiki']['cityId'];
        }
        if(!isset($_GET['catid'])){
            $this->error("您查看的页面不存在");
            exit();
        }
        $catid = intval($_GET['catid']);
        $cate = sp_sql_cate($catid);
        if($cate){
            foreach($cate as $v){
                $catid.=','.$v['id'];
            }
        }
        $count = M("Jobs")->where("catid in ({$catid}) and status=2")->count();
        $page = page($count, 10);

        $where = "j.work_city={$cityId} and j.catid in ({$catid}) and j.status=2 ";

        $sql = "select j.*,c.name,n.nature_name,r.name as cityName from {$prefix}jobs j LEFT JOIN {$prefix}cate c on j.catid=c.id LEFT JOIN ";
        $sql .= " {$prefix}nature n on n.id=j.work_nature left join {$prefix}region r on r.id = j.work_city where {$where} order by j.refreshtime desc limit " . $page->firstRow . ',' . $page->listRows;
//        echo $sql;die();
        $data = M()->query($sql);
        $this->assign('jobs', $data);
        $this->display();
    }
}