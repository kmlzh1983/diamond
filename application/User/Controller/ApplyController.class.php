<?php
/**
 * Created by PhpStorm.
 * User: yqbaa
 * Date: 15-7-2
 * Time: 下午10:21
 */
namespace User\Controller;
use Common\Controller\HomeBaseController;
use Common\Controller\UtilsController as Utils;
use User\Model\MemberModel;

class ApplyController extends HomeBaseController
{
    private $user;
    private $apply_obj;

    public function _initialize()
    {
        parent::_initialize();
        if (!$_SESSION['user']['id']) $this->redirect(U('User/login/index'));
        $this->user = M('Member')->where(array("id" => $_SESSION['user']['id']))->find();
        $this->assign('user', $this->user);
        $this->apply_obj = M("Apply");
    }
    /*
     * 应聘历史
     */
    public function apply_list(){
        $uid = $this->user['id'];
        $prefix = C("DB_PREFIX");
        $count = $this->apply_obj->where("uid={$uid}")->count();
        $Page = page($count , 10);
        $limit = "limit ".$Page->firstRow.','.$Page->listRows;
        $sql = "select a.*,j.addtime,j.job_name,m.user_login from {$prefix}apply a left join {$prefix}jobs j on j.id = a.job_id  left join {$prefix}member m on  m.id=a.compid where a.uid={$uid} order by a.apply_time desc {$limit}";
        $data = $this->apply_obj->query($sql);
        $this->assign("list",$data);
        $this->assign("show",$Page->show());


        $this->display();
    }
}