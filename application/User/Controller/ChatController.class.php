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

class ChatController extends HomeBaseController
{
    private $user;
    private $apply_obj;

    public function _initialize()
    {
        parent::_initialize();
        if (!$_SESSION['user']['id']) $this->redirect(U('User/login/index'));
        $this->user = M('Member')->where(array("id" => $_SESSION['user']['id']))->find();
        $this->assign('user', $this->user);
//        $this->apply_obj = M("Apply");
    }
   function chat(){
       $this->display();
   }
}