<?php
namespace Portal\Controller;
use Common\Controller\HomeBaseController; 
/**
 * 首页
 */
class IndexController extends HomeBaseController {
	
    //首页
	public function index() {
        if(!isset($_SESSION['wiki']['city'])){
            $res = getCurrentCity();
            if(!$res){
                $_SESSION['wiki']['city']='深圳';
                $_SESSION['wiki']['cityId']=77;
            }else{
                $_SESSION['wiki']['city'] = $res['city'];
                $_SESSION['wiki']['cityId'] = $res['cityId'];
            }
        }
        $cityId= $_SESSION['wiki']['cityId'];
        $prefix = C("DB_PREFIX");
        $now = time();
        $sql = "select * from {$prefix}jobs j left join {$prefix}job_pos p on p.job_id=j.id where p.type='emergency' and p.start_time<='$now' and p.end_time>='$now' and j.status=2 and j.work_city={$cityId} limit 0,12";
        $edata = M()->query($sql);
        $this->assign('ejob',$edata);

        $sql = "select * from {$prefix}jobs j left join {$prefix}job_pos p on p.job_id=j.id where p.type='highlight' and p.start_time<='$now' and p.end_time>='$now' and j.status=2 and j.work_city={$cityId} limit 0,12";
        $hdata = M()->query($sql);
        $this->assign('hjob',$hdata);

        $sql = "select * from {$prefix}jobs WHERE status=2 and work_city={$cityId} order by refreshtime desc";
        $newJob = M()->query($sql);
        $this->assign('newJob',$newJob);
    	$this->display();
    }   
	
	public function top(){
		if( $_SESSION['user']['id'] ){
			$this->success($this->fetch('../../Public:top'));
		}else{
			$this->error();
		}
	}


    //更换城市
    public function change_city(){
        if(isset($_GET['id'])){
            $id = intval($_GET['id']);
            $res = setCurrentCity($id);
            if($res){
                $this->redirect("Portal/Index/index");
                exit();
            }
        }
        $this->display();
    }
	public function address(){
		$this->display();
	}
    //获取当前城市和天气
    function getWiki(){
        if(!isset($_SESSION['wiki']['city'])){
            //获取城市--通过ip
            $city= getCurrentCity();
            if(!$city){
                $_SESSION['wiki']['city'] = $city = '深圳';
                $_SESSION['wiki']['cityId'] = 77;
            }
            $data['city'] = $city;
            $weather = getWeather($city);
            $data['weather'] = $_SESSION['wiki']['weather'];
            echo json_encode($data);
            exit();
        }else{
             $data['city'] = $_SESSION['wiki']['city'];
             if(!isset($_SESSION['wiki']['weather'])){
                getWeather($data['city']);
             }
             $data['weather'] =  $_SESSION['wiki']['weather'];
             echo json_encode($data);
             exit();
        }
    }


    function test(){
        $this->display();
    }
}


